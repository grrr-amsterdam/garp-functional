<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Version of reduce tailored to associative arrays.
 * The callback function will receive the key as third argument.
 *
 * @param callable $fn         Reducation function
 * @param mixed    $default
 * @param array    $collection
 * @return mixed
 */
function reduce_assoc($fn, $default, $collection = null) {
    $reducer = function ($collection) use ($fn, $default) {
        return reduce(
            function ($acc, $key) use ($fn, $collection) {
                return $fn($acc, prop($key, $collection), $key);
            },
            $default,
            keys($collection)
        );
    };
    return func_num_args() < 3 ? $reducer : $reducer($collection);
}
