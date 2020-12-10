<?php

declare(strict_types=1);

namespace EditorTemplater;

use EditorTemplater\Contract\ConstantInterface;
use EditorTemplater\Contract\EngineInterface;
use EditorTemplater\Contract\FunctionInterface;
use EditorTemplater\Contract\LexerInterface;
use EditorTemplater\Contract\NodeTypeInterface;
use EditorTemplater\Contract\ParserInterface;
use EditorTemplater\Exception\InvalidConfigException;
use EditorTemplater\Exception\CompileException;
use function array_key_exists;
use function call_user_func_array;

final class Engine implements EngineInterface
{
    /**
     * @var callable[]
     */
    private array $functions = [];

    /**
     * @var string[]
     */
    private array $constants = [];

    private LexerInterface $lexer;
    private ParserInterface $parser;

    public function __construct(?LexerInterface $lexer = null, ?ParserInterface $parser = null)
    {
        $this->lexer = $lexer ?? new Lexer();
        $this->parser = $parser ?? new Parser();
    }

    public function compile(string $template): string
    {
        $compiledTemplate = '';
        $tokens = $this->lexer->tokenize($template);
        foreach ($this->parser->parse($tokens) as $node) {
            switch ($node->getType()) {
                case NodeTypeInterface::TEXT:
                    $compiledTemplate .= $node->getData()[0];

                    break;
                case NodeTypeInterface::FUNCTION:
                    [$functionName, $parameters] = $node->getData();
                    $compiledTemplate .= call_user_func_array($this->getFunction($functionName), $parameters);

                    break;
                case NodeTypeInterface::CONSTANT:
                    $compiledTemplate .= $this->getConstant($node->getData()[0]);

                    break;
                default:
                    throw new CompileException('Unknown node type.');
            }
        }

        return $compiledTemplate;
    }

    public function addFunction(FunctionInterface $function): void
    {
        if (array_key_exists($function->getName(), $this->functions)) {
            throw new InvalidConfigException("Function {$function->getName()} already added.");
        }

        $this->functions[$function->getName()] = $function->getCallable();
    }

    public function addConstant(ConstantInterface $constant): void
    {
        if (array_key_exists($constant->getName(), $this->constants)) {
            throw new InvalidConfigException("Constant {$constant->getName()} already added.");
        }

        $this->constants[$constant->getName()] = $constant->getValue();
    }

    /**
     * @param string $name
     *
     * @return callable
     *
     * @throws CompileException
     */
    private function getFunction(string $name): callable
    {
        if (!array_key_exists($name, $this->functions)) {
            throw new CompileException("Function $name doesn't exist.");
        }

        return $this->functions[$name];
    }

    /**
     * @param string $name
     *
     * @return string
     *
     * @throws CompileException
     */
    private function getConstant(string $name): string
    {
        if (!array_key_exists($name, $this->constants)) {
            throw new CompileException("Constant $name doesn't exist.");
        }

        return $this->constants[$name];
    }
}
