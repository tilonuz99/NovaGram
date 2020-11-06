<?php

require __DIR__ . '/../vendor/autoload.php';

use Amp\Promise;
use function Amp\ParallelFunctions\{parallel, parallelMap};
use skrtdev\NovaGram\BaseHandler;


/**
 * test
 */
class EventHandler extends BaseHandler{


    public static function onUpdate($update)
    {
        // code...
        sleep(10);
        print("kek");
    }
}



$values = parallel([EventHandler::class, "onUpdate"]);
/*
$h = new EventHandler;
$values = parallel(function ($handler = null) use ($h) {
    class EventHandler{
        public static function onUpdate($update)
        {
            // code...
            sleep(10);
            print("kek");
        }
    }

    $handler = $h;
    $handler->onUpdate("kek");
});
*/

var_dump(Promise\wait($values()));
var_dump(Promise\wait($values(new EventHandler)));
echo "here";

#Amp\wait($p);

for ($i=0; $i < 100000000; $i++) {
    // code...
}

#echo "there";
