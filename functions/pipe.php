<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Marco Worms <marcogworms@gmail.com>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * A functional programming classic.
 * Compose functions $g and $f into a new function $gf
 *
 * Note that evaluation is from left to right.
 * Usage:
 * $reverseAndToUpper = pipe('strrev', 'ucfirst');
 *
 * Takes n function arguments.
 *
 * @param  callable[] ...$functions
 * @return callable
 */
function pipe(...$functions): callable {
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



const pipe = '\Garp\Functional\pipe';