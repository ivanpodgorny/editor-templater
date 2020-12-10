<?php

declare(strict_types=1);

namespace EditorTemplater\Contract;

interface NodeInterface
{
    /**
     * @see NodeTypeInterface
     */
    public function getType(): int;

    public function getData(): array;
}
