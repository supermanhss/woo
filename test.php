<?php

class Foo
{
    public $a = 3;
}

class Bar
{
    public function foo(Foo $foo)
    {
        $foo->a = 5;
    }
}

$foo = new Foo();

$bar = new Bar();
$bar->foo($foo);

print_r($foo->a);