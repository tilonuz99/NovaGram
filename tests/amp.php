<?php

require "../vendor/autoload.php";

$promise = Amp\asyncCall(function () {
    yield delay(1000);
    print("hello");
});

print("\nso");
sleep(2);
