<?php

declare(strict_types=1);

namespace EditorTemplater;

use EditorTemplater\Contract\LexerInterface;
use EditorTemplater\Contract\TokenInterface;
use function preg_match_all;
use function preg_quote;
use function strlen;
use function substr;

final class Lexer implements LexerInterface
{
    public function tokenize(string $template): iterable
    {
        $startExpressionToken = preg_quote(TokenInterface::START_EXPRESSION, '/');
        $endExpressionToken = preg_quote(TokenInterface::END_EXPRESSION, '/');
        preg_match_all(
            "/$startExpressionToken|$endExpressionToken/",
            $template,
            $matches,
            PREG_OFFSET_CAPTURE
        );

        $cursor = 0;
        foreach ($matches[0] as [$expressionToken, $position]) {
            $token = substr($template, $cursor, $position - $cursor);
            $cursor = $position + strlen($expressionToken);
            if ($token !== '') {
                yield $token;
            }

            yield $expressionToken;
        }

        $templateLength = strlen($template);
        if ($cursor < $templateLength) {
            yield substr($template, $cursor, $templateLength - $cursor);
        }
    }
}
