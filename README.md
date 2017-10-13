Symfony Rule Engine Bundle
==========================

![build](https://travis-ci.org/nicoSWD/rule-engine-bundle.svg?branch=master)
![coverage](https://scrutinizer-ci.com/g/nicoSWD/rule-engine-bundle/badges/coverage.png?b=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nicoSWD/rule-engine-bundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nicoSWD/rule-engine-bundle/?branch=master)
[![Latest Stable Version](https://img.shields.io/packagist/v/nicoswd/symfony-rule-engine-bundle.svg)](https://packagist.org/packages/nicoswd/symfony-rule-engine-bundle)


This package bundles [nicoSWD/php-rule-parser](https://github.com/nicoSWD/php-rule-parser)

Requires PHP >= 7.0

Install
=======

```shell
$ composer require nicoswd/symfony-rule-engine-bundle
```

```php
<?php

// in AppKernel::registerBundles()
$bundles = [
    // ...
    new nicoSWD\RuleBundle\RuleBundle(),
    // ...
];
```

Usage Example
=====
```php
<?php

$rule = '[1, 4, 3].join(glue) === "1-4-3"';
$variables = ['glue' => '-'];

$result = $this->get('rule_parser')->isTrue($rule, $variables);
```

Custom functions
================

_services.yml_

```yaml
AppBundle\Functions\:
    resource: '../../src/AppBundle/Functions'
    tags: ['nico_swd.rule.function']
```

Custom Function Example
```php
<?php

namespace AppBundle\Functions;

use nicoSWD\Rules\Core\CallableUserFunction;
use nicoSWD\Rules\Tokens\BaseToken;
use nicoSWD\Rules\Tokens\TokenArray;

class ArrayFilter implements CallableUserFunction
{
    /**
     * @param BaseToken $param
     * @param BaseToken $param ...
     * @return mixed
     */
    public function call($param = null)
    {
        if (!$param instanceof TokenArray) {
            throw new \InvalidArgumentException();
        }

        return new TokenArray(
            array_values(
                array_filter(
                    $param->toArray()
                )
            )
        );
    }

    public function getName(): string
    {
        return 'array_filter';
    }
}
```

```php
$result = $this->get('rule_parser')->isTrue('array_filter([0, false, 1]) === [1]');

var_dump($result); // bool(true)
```