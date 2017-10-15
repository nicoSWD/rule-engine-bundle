<?php

namespace nicoSWD\RuleBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class RuleFunctionPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if ($container->has('nico_swd.rules.parser')) {
            $definition = $container->findDefinition('nico_swd.rules.parser');
            $serviceIds = array_keys($container->findTaggedServiceIds('nico_swd.rule.function'));

            foreach ($serviceIds as $serviceId) {
                $definition->addMethodCall('registerFunctionClass', [get_class($container->get($serviceId))]);
            }
        }
    }
}
