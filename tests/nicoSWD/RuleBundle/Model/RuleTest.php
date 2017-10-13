<?php

namespace tests\nicoSWD\RuleBundle\Model;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\Mock;
use nicoSWD\RuleBundle\Model\Rule;
use nicoSWD\Rules\Evaluator;
use nicoSWD\Rules\Parser;
use PHPUnit\Framework\TestCase;

class RuleTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /** @var Parser|Mock */
    private $parser;

    /** @var Evaluator|Mock */
    private $evaluator;

    /** @var Rule */
    private $rule;

    protected function setUp()
    {
        $this->parser = \Mockery::mock(Parser::class)->shouldIgnoreMissing();
        $this->evaluator = \Mockery::mock(Evaluator::class);

        $this->rule = new Rule($this->parser, $this->evaluator);
    }

    public function testGivenARuleWhenTheEvaluatorReturnsTrueItShouldReturnTrue()
    {
        $this->parser->shouldReceive('parse')->once()->andReturn('1');
        $this->evaluator->shouldReceive('evaluate')->once()->andReturn(true);

        $this->assertTrue($this->rule->isTrue('1 === 1'));
    }

    public function testGivenARuleWhenTheEvaluatorReturnsFalseItShouldReturnFalse()
    {
        $this->parser->shouldReceive('parse')->once()->andReturn('1');
        $this->evaluator->shouldReceive('evaluate')->once()->andReturn(false);

        $this->assertFalse($this->rule->isTrue('1 === 2'));
    }
}