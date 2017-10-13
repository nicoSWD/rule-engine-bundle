Install
=======

```shell
$ composer require nicoswd/symfony-rule-engine-bundle
```

Configure
=========

```php
<?php

// in AppKernel::registerBundles()
$bundles = [
    // ...
    new nicoSWD\RuleBundle\RuleBundle(),
    // ...
];
```

Custom functions
================

_services.yml_

```yaml
AppBundle\Functions\:
    resource: '../../src/AppBundle/Functions'
    tags: ['nico_swd.rule.function']
```

Function example
```php
<?php

namespace AppBundle\Functions;

use nicoSWD\Rules\Core\CallableUserFunction;
use nicoSWD\Rules\Tokens\BaseToken;
use nicoSWD\Rules\Tokens\TokenInteger;

class Multiply implements CallableUserFunction
{
    /**
     * @param BaseToken $param
     * @param BaseToken $param ...
     * @return mixed
     */
    public function call($param = null)
    {
        return new TokenInteger($param->getValue() * 2);
    }

    public function getName(): string
    {
        return 'multiply';
    }
}
```