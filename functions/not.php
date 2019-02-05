<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Creates a negative version of an existing function.
 *
 * Example:
 * $a = ['a', 'b', 'c'];
 * in_array('a', $a); // true
 *
 * not('in_array')('a'); // false
 * not('in_array')('d'); // true
 *
 * @param  callable $fn Anything that call_user_func_array accepts
 * @return callable
 */
function not(callable $fn): callable {
    return function (...$args) use ($fn) {
        return !$fn(...$args);
    };
}
