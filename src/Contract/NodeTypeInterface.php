<?php

declare(strict_types=1);

namespace EditorTemplater\Contract;

interface NodeTypeInterface
{
    public const TEXT = 1;
    public const FUNCTION = 2;
    public const CONSTANT = 3;
}
