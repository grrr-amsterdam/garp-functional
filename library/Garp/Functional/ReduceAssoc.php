<?php
declare(strict_types=1);

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
 * @param  callable $fn         Reducation function
 * @param  mixed    $default
 * @param  array    $collection
 * @return mixed
 */
function reduce_assoc(callable $fn, $default, iterable $collection = null) {
    return autocurry(
        function ($fn, $default, $collection) {
            return reduce(
                function ($acc, $key) use ($fn, $collection) {
                    return $fn($acc, prop($key, $collection), $key);
                },
                $default,
                keys($collection)
            );
        },
        3
    )(...func_get_args());
}
