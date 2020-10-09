# __NovaGram__ - _Beta_
[![GitHub license](https://img.shields.io/github/license/skrtdev/NovaGram)](https://github.com/skrtdev/NovaGram/blob/master/LICENSE) [![GitHub stars](https://img.shields.io/github/stars/skrtdev/NovaGram)](https://github.com/skrtdev/NovaGram/stargazers) [![Version](https://poser.pugx.org/skrtdev/novagram/version)](https://github.com/skrtdev/NovaGram/releases) [![Latest Unstable Version](https://poser.pugx.org/skrtdev/novagram/v/unstable)](https://github.com/skrtdev/NovaGram/tree/beta) [![Total Downloads](https://poser.pugx.org/skrtdev/novagram/downloads)](https://packagist.org/packages/skrtdev/novagram)

An elegant, Object-Oriented, reliable PHP Telegram Bot Interface

## Being implemented in this branch

- Long Polling (async)
- Error handler

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
    "mode" => "getUpdates",
    "exceptions" => false,
    "async" => true,
]);

$Bot->onUpdate(function (Update $update) use ($Bot) {
    $message = $update->message;
    $chat = $message->chat;
    $user = $message->from;

    $message->forward(); // forward() with no parameters will forward the Message back to the sender
});
```

More info in the [Documentation](https://docs.novagram.ga)  
Public support group at [https://t.me/joinchat/JdBNOEqGheC33G476FiB2g](https://t.me/joinchat/JdBNOEqGheC33G476FiB2g)
