<?php

declare(strict_types=1);

namespace EditorTemplater\Contract;

interface TokenInterface
{
    public const START_EXPRESSION = '{{';
    public const END_EXPRESSION = '}}';
}
