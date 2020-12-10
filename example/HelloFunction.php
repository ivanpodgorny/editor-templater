<?php

use EditorTemplater\Contract\FunctionInterface;

final class HelloFunction implements FunctionInterface
{
    public function getName(): string
    {
        return 'hello';
    }

    public function getCallable(): callable
    {
        return static fn(string $name): string => "Hello, $name!";
    }
}
