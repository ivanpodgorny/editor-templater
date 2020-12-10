<?php

declare(strict_types=1);

namespace EditorTemplater\Contract;

interface FunctionInterface
{
    public function getName(): string;

    public function getCallable(): callable;
}
