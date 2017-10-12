<?php

namespace nicoSWD\RuleBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class RuleFunctionPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('nico_swd.rules.parser')) {
            return;
        }

        /** @var \nicoSWD\Rules\Parser $parser */
        $parser = $container->findDefinition('nico_swd.rules.parser');
        $functions = $container->findTaggedServiceIds('nico_swd.rule.function');

        foreach ($functions as $id => $function) {
            /** \nicoSWD\Rules\Core\CallableFunction $function */
            $parser->registerFunction($function->getName(), function () use ($function) {
                return $function->call(...func_get_args());
            });
        }
    }
}