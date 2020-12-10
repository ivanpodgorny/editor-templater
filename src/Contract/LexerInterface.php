<?php

declare(strict_types=1);

namespace EditorTemplater\Contract;

interface LexerInterface
{
    /**
     * @param string $template
     *
     * @return string[]
     */
    public function tokenize(string $template): iterable;
}
