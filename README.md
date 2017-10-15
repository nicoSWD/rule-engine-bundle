Symfony Rule Engine Bundle
==========================

![build](https://travis-ci.org/nicoSWD/rule-engine-bundle.svg?branch=master)
![coverage](https://scrutinizer-ci.com/g/nicoSWD/rule-engine-bundle/badges/coverage.png?b=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nicoSWD/rule-engine-bundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nicoSWD/rule-engine-bundle/?branch=master)
[![Latest Stable Version](https://img.shields.io/packagist/v/nicoswd/symfony-rule-engine-bundle.svg)](https://packagist.org/packages/nicoswd/symfony-rule-engine-bundle)


[![SensioLabsInsight](https://insight.sensiolabs.com/projects/67203389-970c-419c-9430-a7f9a005bd94/big.png)](https://insight.sensiolabs.com/projects/67203389-970c-419c-9430-a7f9a005bd94)

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
var_dump($result); // bool(true)
```

Custom Functions
================

Custom functions are automatically discovered. They just need to be configured
as service with the tag `nico_swd.rule.function`.

If you have multiple functions inside the same directory, the easiest way to make
them visible to the bundle is this:

_services.yml_

```yaml
AppBundle\Functions\:
    resource: '../../src/AppBundle/Functions'
    tags: ['nico_swd.rule.function']
```

Furthermore, custom functions must implement `nicoSWD\Rules\Core\CallableUserFunction`
like in the example below

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
     * @return BaseToken
     */
    public function call($param = null)
    {
        // Make sure this functions only works on arrays
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

The functions optionally retrieve instances of `nicoSWD\Rules\Tokens\BaseToken` as arguments,
and always must return one as well.

```php
<?php

$rule = 'array_filter([0, false, 1]) === [1]';

$result = $this->get('rule_parser')->isTrue($rule);
var_dump($result); // bool(true)
```
