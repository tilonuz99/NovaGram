<?php

require "../vendor/autoload.php";

use function Amp\delay;
use Amp\Http\Client\HttpClientBuilder;
use Amp\Http\Client\Request;
use Amp\Loop;

class Foo
{
    public function delegationWithCoroutine(): Amp\Promise
    {
        return new Amp\Coroutine($this->bar());
    }

    public function delegationWithYieldFrom(): Amp\Promise
    {
        return Amp\call(function () {
            return yield from $this->bar();
        });
    }

    public function delegationWithCallable()
    {
        return Amp\asyncCall([$this, 'bar']);
    }

    public function bar(): Generator
    {
        $client = HttpClientBuilder::buildDefault();

        $response = yield $client->request(new Request("https://httpbin.org/get"));

        var_dump($response->getStatus());
        #var_dump($response->getHeaders());
        #var_dump(yield $response->getBody()->buffer());
        yield new Amp\Success(1);
        yield new Amp\Success(2);
        return yield new Amp\Success(3);
    }
}

function f($value='')
{
    $foo = new Foo();
    for ($i=0; $i < 50; $i++) {
        $r1 = $foo->delegationWithCallable();
    }
    Loop::run();
}

#$f();

#sleep(1);

function processUpdates($value='')
{
    $f = function ()
    {
        $foo = new Foo();
        for ($i=0; $i < 50; $i++) {
            $r1 = $foo->delegationWithCallable();
        }
        Loop::run();
    };
    var_dump($f());
}

function idle($value='')
{
    Loop::run(function () {
        for ($i=0; $i < 50; $i++) {
            $offset = processUpdates($offset ?? 0);
        }
        while (true) {

        }
    });
}

idle();

echo "kek";
