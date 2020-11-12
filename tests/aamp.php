<?php

require "../vendor/autoload.php";

use function Amp\delay;
use Amp\Http\Client\HttpClientBuilder;
use Amp\Http\Client\Request;
use Amp\Loop;

class Foo
{
    public function delegationWithCoroutine()/*: Amp\Promise*/
    {
        #return new Amp\Coroutine($this->bar());
        Amp\call(function () {
            return yield from $this->bar();
        });
        return;
        Amp\call([$this, 'bar']);
        return;
        return Amp\asyncCall([$this, 'bar']);
        return Amp\asyncCoroutine([$this, 'bar'])();
    }

    public function delegationWithYieldFrom(): Amp\Promise
    {
        return Amp\call(function () {
            return yield from $this->bar();
        });
    }

    public function delegationWithCallable(): Amp\Promise
    {
        return Amp\call([$this, 'bar']);
    }

    public function bar(): Generator
    {
        throw new \Exception();
        yield new Amp\Success(1);
        yield new Amp\Success(2);
        print("ae1\n");
        yield delay(100);
        print("ae2\n");
        return yield new Amp\Success(3);
    }
}

$foo = new Foo();
var_dump(Amp\call([$foo, 'bar']));
Amp\call([$foo, 'bar']);
Amp\call([$foo, 'bar']);
Amp\call([$foo, 'bar']);
Amp\call([$foo, 'bar']);

#Amp\Loop::run();
echo "kek";

/*

Amp\Loop::run(function () {
    $foo = new Foo();
    $r1 = $foo->delegationWithCoroutine();
    $r2 = $foo->delegationWithCoroutine();
    $r3 = $foo->delegationWithCoroutine();
    #$r2 = yield $foo->delegationWithYieldFrom();
    #$r3 = yield $foo->delegationWithCallable();
    var_dump($r1);
    var_dump($r2);
    var_dump($r3);
    #while(true){}
});

echo "kek";
*/
?>
