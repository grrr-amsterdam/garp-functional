<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * A functional programming classic.
 * Compose functions $g and $f into a new function $gf
 *
 * Note that evaluation is from right to left, as is traditional.
 * Usage:
 * $reverseAndToUpper = compose('ucfirst', 'strrev');
 *
 * Takes n function arguments.
 *
 * @param  callable[] ...$args
 * @return callable
 */
function compose(...$args): callable {
    $functions = array_reverse($args);
    return function ($arg) use ($functions) {
        return reduce(
            function ($acc, $cur) {
                return call_user_func($cur, $acc);
            },
            $arg,
            $functions
        );
    };
}


