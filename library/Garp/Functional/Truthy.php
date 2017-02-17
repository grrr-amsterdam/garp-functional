<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Returns true if the value coerces to true.
 *
 * @param mixed $value
 * @return bool
 */
function truthy($value) {
    if (is_callable($value)) {
        return function () use ($value) {
            return !!call_user_func_array($value, func_get_args());
        };
    }
    return !!$value;
}
