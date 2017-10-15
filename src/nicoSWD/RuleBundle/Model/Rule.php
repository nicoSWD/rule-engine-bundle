<?php

namespace nicoSWD\RuleBundle\Model;

use nicoSWD\Rules\Evaluator;
use nicoSWD\Rules\Parser;

class Rule
{
    /** @var Parser */
    private $parser;

    /** @var Evaluator */
    private $evaluator;

    public function __construct(Parser $parser, Evaluator $evaluator)
    {
        $this->parser = $parser;
        $this->evaluator = $evaluator;
    }

    public function isTrue(string $rule, array $variables = []): bool
    {
        $this->parser->assignVariables($variables);

        return $this->evaluator->evaluate(
            $this->parser->parse($rule)
        );
    }

    public function isFalse(string $rule, array $variables = []): bool
    {
        return !$this->isTrue($rule, $variables);
    }
}
