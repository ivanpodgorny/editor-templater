<?php

declare(strict_types=1);

namespace EditorTemplater;

use EditorTemplater\Contract\ParserInterface;
use EditorTemplater\Contract\TokenInterface;
use EditorTemplater\Exception\ParseException;
use EditorTemplater\Node\ExpressionNode;
use EditorTemplater\Node\TextNode;
use function trim;

final class Parser implements ParserInterface
{
    private const EXPECTED_TEXT_OR_START_EXPRESSION = 1;
    private const EXPECTED_START_EXPRESSION = 2;
    private const EXPECTED_EXPRESSION_BODY = 3;
    private const EXPECTED_END_EXPRESSION = 4;

    public function parse(iterable $tokens): iterable
    {
        $expected = self::EXPECTED_TEXT_OR_START_EXPRESSION;
        foreach ($tokens as $token) {
            switch ($expected) {
                case self::EXPECTED_TEXT_OR_START_EXPRESSION:
                    if (TokenInterface::START_EXPRESSION === $token) {
                        $expected = self::EXPECTED_EXPRESSION_BODY;
                    } elseif (TokenInterface::END_EXPRESSION === $token) {
                        throw new ParseException("Unexpected token $token.");
                    } else {
                        $expected = self::EXPECTED_START_EXPRESSION;

                        yield new TextNode($token);
                    }

                    break;
                case self::EXPECTED_START_EXPRESSION:
                    if (TokenInterface::START_EXPRESSION !== $token) {
                        throw new ParseException("Unexpected token $token.");
                    }

                    $expected = self::EXPECTED_EXPRESSION_BODY;

                    break;
                case self::EXPECTED_EXPRESSION_BODY:
                    if (TokenInterface::START_EXPRESSION === $token || TokenInterface::END_EXPRESSION === $token) {
                        throw new ParseException("Unexpected token $token.");
                    }

                    $expected = self::EXPECTED_END_EXPRESSION;

                    yield new ExpressionNode(trim($token));

                    break;
                case self::EXPECTED_END_EXPRESSION:
                    if (TokenInterface::END_EXPRESSION !== $token) {
                        throw new ParseException("Unexpected token $token.");
                    }

                    $expected = self::EXPECTED_TEXT_OR_START_EXPRESSION;

                    break;
            }
        }

        if (self::EXPECTED_EXPRESSION_BODY === $expected || self::EXPECTED_END_EXPRESSION === $expected) {
            throw new ParseException("Unexpected end of template.");
        }
    }
}
