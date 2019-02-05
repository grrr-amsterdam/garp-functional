<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Create a copy of an object, setting or overriding the given property with the given value.
 * Thrice curried.
 *
 * @param  string|int $key
 * @param  mixed      $value
 * @param  mixed      $object
 * @return mixed
 */
function prop_set($key, $value = null, $object = null) {
    return autocurry(
        function ($key, $value, $object = null) {
            $copy = $object;
            $newVal = is_callable_function($value) ? $value($object) : $value;
            $copy[$key] = $newVal;
            return $copy;
        },
        3
    )(...func_get_args());
}
