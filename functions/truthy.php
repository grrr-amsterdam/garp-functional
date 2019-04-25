<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Returns true if the value coerces to true.
 *
 * @param  mixed $value
 * @return bool|callable
 */
function truthy($value) {
    if (is_callable_function($value)) {
        return function () use ($value): bool {
            return !!call_user_func_array($value, func_get_args());
        };
    }
    return !!$value;
}

const truthy = '\Garp\Functional\truthy';