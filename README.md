# __NovaGram__ - _Beta_
[![GitHub license](https://img.shields.io/github/license/skrtdev/NovaGram)](https://github.com/skrtdev/NovaGram/blob/master/LICENSE) [![GitHub stars](https://img.shields.io/github/stars/skrtdev/NovaGram)](https://github.com/skrtdev/NovaGram/stargazers) [![Version](https://poser.pugx.org/skrtdev/novagram/version)](https://github.com/skrtdev/NovaGram/releases) [![Latest Unstable Version](https://poser.pugx.org/skrtdev/novagram/v/unstable)](https://github.com/skrtdev/NovaGram/tree/beta) [![Total Downloads](https://poser.pugx.org/skrtdev/novagram/downloads)](https://packagist.org/packages/skrtdev/novagram)

An elegant, Object-Oriented, reliable PHP Telegram Bot Interface

## TODO

- [x] Long Polling (multi-processing)
- [x] Error handler
- [x] Auto recognition of mode to use: WebHook/getUpdates/none
- [x] Error handler based on type hinting for setting more handlers with only a Closure as parameter  
- [x] Use something else than fork for making multi-processing update handling ([skrtdev/async](https://github.com/skrtdev/php-async))  
- [x] Catch exceptions in exceptions handlers
- [x] New, more speficic exceptions
- [x] Changed behaviour of debug setting: now it create an error handler
- [ ] auto handling of FloodwaitException with a treshold?
- [ ] ? more filters (onMessage, onCallbackQuery)

### Installation via [Composer](https://getcomposer.org)

```
composer require skrtdev/novagram dev-beta
```

### Example
An example code of a simple bot that just forwards back what you send.

```php
require __DIR__ . '/vendor/autoload.php';

use skrtdev\NovaGram\Bot;
$Bot = new Bot("YOUR_TOKEN", [
    "debug" => CHAT_ID,
    "parse_mode" => "HTML",
]);

$Bot->onUpdate(function (Update $update) use ($Bot) {

    if(isset($update->message)){ // update is a message
        $message = $update->message;
        $chat = $message->chat;

        if(isset($message->from)){ // message has a sender
            $user = $message->from;

            $message->forward(); // forward() with no parameters will forward the Message back to the sender
        }
    }
});
```

More info in the [Documentation](https://docs.novagram.ga)  
Public support group at [https://t.me/joinchat/JdBNOEqGheC33G476FiB2g](https://t.me/joinchat/JdBNOEqGheC33G476FiB2g)
