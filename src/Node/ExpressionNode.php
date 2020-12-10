<?php

declare(strict_types=1);

namespace EditorTemplater\Node;

use EditorTemplater\Contract\ExpressionParserInterface;
use EditorTemplater\Contract\NodeInterface;
use EditorTemplater\ExpressionParser;

final class ExpressionNode implements NodeInterface
{
    private int $type;
    private array $data;

    public function __construct(string $expression, ?ExpressionParserInterface $parser = null)
    {
        $parser = $parser ?? new ExpressionParser();
        [$this->type, $this->data] = $parser->parse($expression);
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
