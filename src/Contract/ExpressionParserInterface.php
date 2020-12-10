<?php

declare(strict_types=1);

namespace EditorTemplater\Contract;

interface ExpressionParserInterface
{
    /**
     * @param string $expression
     *
     * @return array [$type, $data]
     */
    public function parse(string $expression): array;
}
