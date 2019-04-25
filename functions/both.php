<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Return true if both arguments are truthy.
 *
 * @param  mixed $left
 * @param  mixed $right
 * @return bool|callable
 */
function both($left, $right) {
    if (is_callable_function($left) || is_callable_function($right)) {
        return function () use ($left, $right): bool {
            $leftVal = is_callable_function($left)
                ? call_user_func_array($left, func_get_args())
                : $left;
            if (!$leftVal) {
                return false;
            }
            $rightVal = is_callable_function($right)
                ? call_user_func_array($right, func_get_args())
                : $right;
            return !!$rightVal;
        };
    }
    return $left && $right;
}

const both = '\Garp\Functional\both';