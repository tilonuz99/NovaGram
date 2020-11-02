<?php

require __DIR__ . '/../vendor/autoload.php';

use Amp\Promise;
use function Amp\ParallelFunctions\{parallel, parallelMap};

parallelMap([1,2,3], function ($time) {
    $time = 1;
    \sleep($time); // a blocking function call, might also do blocking I/O here
    print($time."\n");

    return $time * $time;
});



for ($i=0; $i < 1000; $i++) {
    // code...
}
