<?php

namespace nicoSWD\RuleBundle;

use nicoSWD\RuleBundle\DependencyInjection\Compiler\RuleFunctionPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class RuleBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RuleFunctionPass());
    }
}
