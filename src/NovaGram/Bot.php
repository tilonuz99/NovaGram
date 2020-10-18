<?php

declare(strict_types=1);

namespace skrtdev\NovaGram;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use skrtdev\Telegram\Exception as TelegramException;
use skrtdev\Telegram\Update;
use skrtdev\Prototypes\proto;
use Closure;
use Throwable;
use stdClass;

class Bot {

    use Methods;
    use proto;

    const LICENSE = "NovaGram - An Object-Oriented PHP library for Telegram Bots".PHP_EOL."Copyright (c) 2020 Gaetano Sutera <https://github.com/skrtdev>";
    const NONE    = 0;
    const WEBHOOK = 1;
    const CLI     = 2;

    private string $token;
    private stdClass $settings;
    private array $json;
    private bool $payloaded = false;

    public ?Update $update = null; // read-only
    public ?array $raw_update = null; // read-only
    public int $id; // read-only
    public ?Database $database = null; // read-only

    private bool $started = false;
    private static bool $shown_license = false;

    private ?Closure $handler = null;
    private ?Closure $error_handler = null;


    public function __construct(string $token, array $settings = [], ?Logger $logger = null) {
        if(!Utils::isTokenValid($token)){
            throw new Exception("Not a valid Telegram Bot Token provided ($token)");
        }
        $this->token = $token;
        $this->id = Utils::getIDByToken($token);
        $this->settings = (object) $settings;

        if(!isset($logger)){
            $logger = new Logger("NovaGram");
            $logger->pushHandler(new StreamHandler(STDERR, Logger::INFO));
            #$logger->info('Logger automatically replaced by a default one');
        }
        $this->logger = $logger;

        $settings_array = [
            "json_payload" => true,
            "log_updates" => false,
            "debug" => false,
            "disable_webhook" => false,
            "disable_ip_check" => false,
            "exceptions" => true,
            #"mode" => "webhook",
            "async" => true
        ];

        foreach ($settings_array as $name => $default){
            $this->settings->{$name} ??= $default;
        }

        if(!isset($this->settings->mode)){
            if($this->settings->disable_webhook){
                Utils::trigger_error("Using deprecated disable_webhook, check updated docs at https://docs.novagram.ga/construct.html", E_USER_DEPRECATED);
                $this->settings->mode = self::NONE;
            }
            else{
                $this->settings->mode = Utils::isCLI() ? self::CLI : self::WEBHOOK;
            }
        }
        if($this->settings->mode === "getUpdates"){
            Utils::trigger_error("Using deprecated \"getUpdates\" mode in settings, check updated docs at https://docs.novagram.ga/construct.html", E_USER_DEPRECATED);
            $this->settings->mode = self::CLI;
        }
        if($this->settings->mode === "webhook"){
            Utils::trigger_error("Using deprecated \"webhook\" mode in settings, check updated docs at https://docs.novagram.ga/construct.html", E_USER_DEPRECATED);
            $this->settings->mode = self::WEBHOOK;
        }

        $this->json = json_decode(implode(file(__DIR__."/json.json")), true);

        if(isset($this->settings->database)){
            $this->database = $this->db = new Database($this->settings->database);
        }

        if(!$this->settings->mode === self::WEBHOOK){
            if(!$this->settings->disable_ip_check){
                if(!isset($_SERVER['REMOTE_ADDR'])) exit;
                if(isset($_SERVER["HTTP_CF_CONNECTING_IP"]) and Utils::isCloudFlare()) $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
                if(!Utils::ip_in_range($_SERVER['REMOTE_ADDR'], "149.154.160.0/20") and !Utils::ip_in_range($_SERVER['REMOTE_ADDR'], "91.108.4.0/22")) exit("Access Denied");
            }
            if(file_get_contents("php://input") === "") exit("Access Denied");

            $this->raw_update = json_decode(file_get_contents("php://input"), true);

            if($this->settings->log_updates) $this->APICall("sendMessage", ["chat_id" => $this->settings->log_updates, "text" => "<pre>".json_encode($this->raw_update, JSON_PRETTY_PRINT)."</pre>", "parse_mode" => "HTML"]);

            $this->update = $this->JSONToTelegramObject($this->raw_update, "Update");
        }
        else{
            $this->settings->json_payload = false;
        }


    }

    public function setErrorHandler(Closure $handler){
        $this->error_handler = $handler;
    }

    public function addHandler(...$args){
        return $this->onUpdate(...$args);
    }

    public function onUpdate(Closure $handler){
        $this->handler = $handler;
        #return $this->idle();
    }

    public function handleError(Throwable $e): void {
        if(isset($this->error_handler)){
            $handler = $this->error_handler;
            $handler($e);
        }
        else{
            print(PHP_EOL.$e.PHP_EOL.PHP_EOL);
        }
    }

    public function handleUpdate(Update $update){
        $handler = $this->handler;
        echo "INSIDE handleUpdate", "\n";
        #var_dump($this->loop);
        $handler($update);
        return;
    }

    public function processUpdates($offset = 0){
        $async = $this->settings->async;
        $params = ['offset' => $offset, 'timeout' => 300];
        $this->logger->debug('Processing Updates (async: '.(int) $async.')', $params);
        $updates = $this->getUpdates($params);
        $handler = $this->handler;
        foreach ($updates as $update) {
            if(!$async){
                $this->logger->info("Update handling started.", ['update_id' => $update->update_id]);
                $started = hrtime(true)/10**9;
                $handler($update);
                $this->logger->info("Update handling finished.", ['update_id' => $update->update_id, 'took' => (((hrtime(true)/10**9)-$started)*1000).'ms']);
            }
            else{
                $pid = pcntl_fork();
                if ($pid == -1) {
                    die('could not fork');
                }
                elseif($pid){
                    // we are the parent
                    pcntl_wait($status, WNOHANG | WUNTRACED);
                }
                else{
                    // we are the child
                    $this->logger->info("Update handling started.", ['update_id' => $update->update_id]);
                    $started = hrtime(true)/10**9;
                    try{
                        $handler($update);
                    }
                    catch(Throwable $e){
                        $this->handleError($e);
                    }
                    $this->logger->info("Update handling finished.", ['update_id' => $update->update_id, 'took' => (((hrtime(true)/10**9)-$started)*1000).'ms']);
                    exit;
                }


            }
            $offset = $update->update_id+1;

        }
        return $offset;
    }

    public function showLicense(): void {
        if(!self::$shown_license){
            print(self::LICENSE.PHP_EOL);
            self::$shown_license = true;
        }
    }

    public function idle(){
        if(!$this->started){
            if(isset($this->handler)){
                $this->deleteWebhook();
                $this->started = true;
                $this->showLicense();
                if(!isset($this->error_handler)){
                    $this->logger->error("Error handler is not set.");
                }
                while (true) {
                    $offset = $this->processUpdates($offset ?? 0);
                }
            }
            else $this->logger->debug("\n\nNO handler\n\n");
        }
    }

    public function __destruct(){
        $this->logger->debug("\n\nTriggered destructor\n\n");
        $this->logger->debug("\n\n{$this->settings->mode}\n\n");
        if($this->settings->mode === self::CLI and !$this->started){
            $this->logger->debug('Idling by destructor');
            return $this->idle();
        }
    }

    private function methodHasParamater(string $method, string $parameter){
        return in_array($method, $this->json["require_params"][$parameter]);
    }

    private function normalizeRequest(string $method, array $data){
        if($this->methodHasParamater($method, "parse_mode") and isset($this->settings->parse_mode)){
            $data['parse_mode'] ??= $this->settings->parse_mode;
        }
        if($this->methodHasParamater($method, "disable_web_page_preview") and isset($this->settings->disable_web_page_preview)){
            $data['disable_web_page_preview'] ??= $this->settings->disable_web_page_preview;
        }
        if($this->methodHasParamater($method, "disable_notification") and isset($this->settings->disable_notification)){
            $data['disable_notification'] ??= $this->settings->disable_notification;
        }
        foreach ($this->json['require_json_encode'] as $key){

            if(isset($data[$key]) and is_array($data[$key])){

                $data[$key] = json_encode($data[$key]);
            }
        }
        return $data;
    }

    public function APICall(string $method, array $data = [], bool $payload = false, bool $is_debug = false){

        $data = $this->normalizeRequest($method, $data);

        if($this->settings->json_payload){
            if($payload){
                if(!$this->payloaded){
                    $this->payloaded = true;
                    header('Content-Type: application/json');
                    $json = json_encode($data + ['method' => $method]);
                    echo $json;
                    return $json;
                }
                else{
                    Utils::trigger_error("Trying to use JSON Payload more than one time");
                }
            }
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot{$this->token}/$method");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        curl_close($ch);
        $decoded =  json_decode($response, true);

        if($decoded['ok'] !== true){
            $this->logger->debug("Response: ".$response);
            if($is_debug) throw new TelegramException("[DURING DEBUG] $method", $decoded, $data);
            $e = new TelegramException($method, $decoded, $data);
            if($this->settings->debug){
                #$this->sendMessage($this->settings->debug, "<pre>".$method.PHP_EOL.PHP_EOL.print_r($data, true).PHP_EOL.PHP_EOL.print_r($decoded, true)."</pre>", ["parse_mode" => "HTML"], false, true);
                $this->debug( (string) $e );
            }
            if($this->settings->exceptions) throw $e;
            else return (object) $decoded;
        }

        if(is_bool($decoded['result'])) return $decoded['result'];

        if($this->getMethodReturned($method)) return $this->JSONToTelegramObject($decoded['result'], $this->getMethodReturned($method));
        else return is_array($decoded['result']) ? (object) $decoded['result'] : $decoded['result'];
    }

    private function getMethodReturned(string $method){
        return $this->json['available_methods'][$method]['returns'] ?? false;
    }

    private function getObjectType(string $parameter_name, string $object_name = ""){
        if($object_name !== "") $object_name .= ".";
        return $this->json['available_types'][$object_name.$parameter_name] ?? false;
    }

    public function JSONToTelegramObject(array $json, string $parameter_name){
        if($this->getObjectType($parameter_name)) $parameter_name = $this->getObjectType($parameter_name);
        if(preg_match('/\[\w+\]/', $parameter_name) === 1) return $this->TelegramObjectArrayToStdClass($json, $parameter_name);
        foreach($json as $key => &$value){
            if(is_array($value)){
                $ObjectType = $this->getObjectType($key, $parameter_name);
                if($ObjectType){
                    if($this->getObjectType($ObjectType)) $value = $this->TelegramObjectArrayToStdClass($value, $ObjectType);
                    else $value = $this->JSONToTelegramObject($value, $ObjectType);
                }
                else $value = (object) $value;
            }
        }
        return $this->createObject($parameter_name, $json);
    }

    private function TelegramObjectArrayToStdClass(array $json, string $name){
        $parent_name = $name;
        $ObjectType = $this->getObjectType($name) !== false ? $this->getObjectType($name) : $name;

        if(preg_match('/\[\w+\]/', $ObjectType) === 1){
            preg_match('/\w+/', $ObjectType, $matches);// extract to matches[0] the type of elements
            $childs_name = $matches[0];
        }
        else $childs_name = $ObjectType;

        foreach($json as $key => &$value){
            if(is_array($value)){
                if(is_int($key)){
                    if($this->getObjectType($childs_name)) $value = $this->TelegramObjectArrayToStdClass($value, $childs_name);
                    //else $value = $this->createObject($childs_name, $value);
                    else $value = $this->JSONToTelegramObject($value, $childs_name);
                }
                else $value = $this->JSONToTelegramObject($value, $this->getObjectType($childs_name, $parent_name));

            }
        }
        return (object) $json;

    }

    public static function curl(string $url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }


    public static function getUsernameDC(string $username){
        preg_match('/cdn(\d)/', self::curl("https://t.me/$username"), $matches);
        return isset($matches[1]) ? (int) $matches[1] : false;
    }

    public function createObject(string $type, array $json){
        $obj = "\\skrtdev\\Telegram\\$type";
        return new $obj($type, $json, $this);
    }

    public function debug($value){
        if($this->settings->debug){
            return $this->APICall("sendMessage", [
                "chat_id" => $this->settings->debug,
                "text" => "<pre>".htmlspecialchars(print_r($value, true))."</pre>",
                "parse_mode" => "HTML"
            ], false, true);
        }
        else throw new Exception("debug chat id is not set");
    }

    public function getJSON(): array{
        return $this->json;
    }

    public function getDatabase(): Database{
        return $this->database;
    }

    public function __debugInfo() {
        $result = get_object_vars($this);
        foreach(['json', 'settings', 'payloaded', 'raw_update'] as $key) unset($result[$key]);
        return $result;
    }
}
?>
