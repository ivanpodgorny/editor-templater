<?php

declare(strict_types=1);

namespace EditorTemplater\Contract;

interface ConstantInterface
{
    public function getName(): string;

    public function getValue(): string;
}
