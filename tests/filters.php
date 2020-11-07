<?php

require __DIR__ . '/../vendor/autoload.php';

use skrtdev\NovaGram\Bot;
use skrtdev\NovaGram\BaseHandler;
use skrtdev\Telegram\{Update, Message};
use skrtdev\NovaGram\Exception as NovaGramException;
use skrtdev\Telegram\Exception as TelegramException;
use function Amp\delay;

class Filters{

    protected array $args;

    function __construct(...$args)
    {
        $this->args = $args;
    }

    public function getArgs()
    {
        return $this->args;
    }

    public static function TextMessage()
    {
        return function ($message) {
            return isset($message->text);
        };
    }

    public static function TextRegex(string $pattern)
    {
        return function ($message) use ($pattern) {
            return (self::TextMessage())($message) && preg_match($pattern, $message->text);
        };
    }

    public static function commands($commands = [])
    {
        if(is_string($commands)){
            $commands = [$commands];
        }

        return function ($message) use ($commands) {
            return (self::TextMessage())($message) && (self::TextRegex('/\/(?:'.implode('|', $commands).')/'))($message);
        };
    }
}

function filters(...$args)
{
    return new Filters($args);
}

Bot::addMethod("onMessage", function (Filters $filters, Closure $handler) {
    $this->onUpdate(function (Update $update) use ($filters, $handler) {
        if(!isset($update->message)) return;
        foreach ($filters->getArgs() as $filter) {
            if(!$filter($update->message)) return;
        }
        $handler($update->message);
    });
});

$Bot = new Bot("722952667:AAFoPOkdyWXTT3j-Efm5PrwDGW20AhB_9T8", [
    "restart_on_changes" => true,
    #"async" => false
]);

class Handler extends BaseHandler{
    public function onUpdate(Bot $Bot, Update $update)
    {
        #print("afammoc");

        if(isset($update->message)){ // update is a message
            $message = $update->message;
            $chat = $message->chat;

            #yield delay(1000);
            #print("there");
            #sleep(1);
            $message->reply("afammoc from class");
            print("afammoc\n");
            #yield delay(1000);
        }

        return yield new Amp\Success(true);
    }
}

#var_dump(Filters::TextMessage() | Filters::TextMessage());

$Bot->onMessage(new Filters(Filters::TextMessage()), function (Message $message) {
    $message->reply("text message");
});

$Bot->onMessage(new Filters(Filters::TextRegex('/ciao/')), function (Message $message) {
    $message->reply("ciao");
});


$Bot->onMessage(new Filters(Filters::commands("start")), function (Message $message) {
    $message->reply("start!");
});

$Bot->onUpdate(function (Update $update) use ($Bot) {

    if(isset($update->message)){ // update is a message
        $message = $update->message;
        $chat = $message->chat;

        #$message->reply("from Update handler");
    }
});

/*
$Bot->addErrorHandler(function (Throwable $e) {
    print("Caught ".get_class($e)." exception from general handler".PHP_EOL);
    print($e.PHP_EOL);
});
*/
$Bot->handleClass(new Handler);

#$Bot->idle();

?>
