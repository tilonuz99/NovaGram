<?php

require __DIR__ . '/../vendor/autoload.php';

use skrtdev\NovaGram\Bot;
use skrtdev\Telegram\Update;
use skrtdev\NovaGram\Exception as NovaGramException;
use skrtdev\Telegram\Exception as TelegramException;

$Bot = new Bot(readline("Insert Bot token: "));

$Bot->onUpdate(function (Update $update) use ($Bot) {

    if(isset($update->message)){ // update is a message
        $message = $update->message;
        $chat = $message->chat;

        if(isset($message->from)){ // message has a sender
            $user = $message->from;
            $text = $message->text;

            if($text === "/novagram"){
                throw new NovaGramException("Sample Exception");
            }
            if($text === "/telegram"){
                $Bot->sendMessage(0, "uh");
            }
            if($text === "/exception"){
                throw new \Exception("Sample Exception");
            }
            if($text === "/error"){
                throw new \Error("Sample Error");
            }
        }
    }
});

$Bot->setErrorHandler(function (NovaGramException $e) {
    print("Caught ".get_class($e)." exception from speficic handler".PHP_EOL);
});

$Bot->setErrorHandler(function (TelegramException $e) {
    print("Caught ".get_class($e)." exception from speficic handler".PHP_EOL);
});

$Bot->setErrorHandler(function (Throwable $e) {
    print("Caught ".get_class($e)." exception from general handler".PHP_EOL);
});

// the same exception can be handled by more than one handler

?>