<?php

declare(strict_types=1);

namespace EditorTemplater\Node;

use EditorTemplater\Contract\NodeInterface;
use EditorTemplater\Contract\NodeTypeInterface;

final class TextNode implements NodeInterface
{
    private int $type;
    private array $data;

    public function __construct(string $text)
    {
        $this->type = NodeTypeInterface::TEXT;
        $this->data = [$text];
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
