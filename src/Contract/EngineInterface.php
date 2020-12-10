<?php

declare(strict_types=1);

namespace EditorTemplater\Contract;

use EditorTemplater\Exception\CompileException;
use EditorTemplater\Exception\InvalidConfigException;
use EditorTemplater\Exception\ParseException;

interface EngineInterface
{
    /**
     * @param string $template
     *
     * @return string
     *
     * @throws CompileException
     * @throws ParseException
     */
    public function compile(string $template): string;

    /**
     * @param FunctionInterface $function
     *
     * @throws InvalidConfigException
     */
    public function addFunction(FunctionInterface $function): void;

    /**
     * @param ConstantInterface $constant
     *
     * @throws InvalidConfigException
     */
    public function addConstant(ConstantInterface $constant): void;
}
