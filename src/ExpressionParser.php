<?php

declare(strict_types=1);

namespace EditorTemplater;

use EditorTemplater\Contract\ExpressionParserInterface;
use EditorTemplater\Contract\NodeTypeInterface;
use function explode;
use function mb_strpos;
use function preg_match;

final class ExpressionParser implements ExpressionParserInterface
{
    public function parse(string $expression): array
    {
        if ($this->isFunction($expression)) {
            return $this->parseFunction($expression);
        }

        return [NodeTypeInterface::CONSTANT, [$expression]];
    }

    private function isFunction(string $expression): bool
    {
        return mb_strpos($expression, '(') !== false;
    }

    private function parseFunction(string $expression): array
    {
        preg_match('/([a-z0-9_]+)\((.*)\)/', $expression, $matches);
        [1 => $functionName, 2 => $parametersString] = $matches;

        return [NodeTypeInterface::FUNCTION, [$functionName, explode(',', $parametersString)]];
    }
}
