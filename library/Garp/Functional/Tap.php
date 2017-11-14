<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Return a function that calls the original function with the given argument, and returns the
 * argument.
 *
 * @param callable $fn
 * @return callable
 */
function tap($fn) {
    return function ($x) use ($fn) {
        $fn($x);
        return $x;
    };
}
