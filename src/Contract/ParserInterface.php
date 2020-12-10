<?php

declare(strict_types=1);

namespace EditorTemplater\Contract;

use EditorTemplater\Exception\ParseException;

interface ParserInterface
{
    /**
     * @param iterable $tokens
     *
     * @return NodeInterface[]
     *
     * @throws ParseException
     */
    public function parse(iterable $tokens): iterable;
}
