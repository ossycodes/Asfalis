<?php

namespace App;

class Example
{
    protected $foo;

    public function __construct(Foo $foo)
    {
        return $this->foo = $foo;
    }
}
