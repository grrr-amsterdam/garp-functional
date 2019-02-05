<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Concat two things, using the given function as the smoosh function.
 * Works with arrays, but not string.
 *
 * @param  callable $mergeFunction
 * @param  array[]  ...$collections
 * @return array
 */
function concat_with(callable $mergeFunction, ...$collections) {
    $concatter = function (...$collections) use ($mergeFunction) {
        if (!every('is_iterable', $collections)) {
            throw new \InvalidArgumentException('concat_with expects arguments 2 and up to be arrays.');
        }
        return reduce(
            function ($acc, $cur) use ($mergeFunction) {
                return reduce_assoc(
                    function ($acc, $value, $key) use ($mergeFunction) {
                        return prop_set(
                            $key,
                            prop($key, $acc) ? $mergeFunction($acc[$key], $value) : $value,
                            $acc
                        );
                    },
                    $acc,
                    $cur
                );
            },
            [],
            $collections
        );
    };
    if (func_num_args() <= 2) {
        return call_user_func_array(
            'Garp\Functional\partial',
            array_merge(['Garp\Functional\concat_with'], array_slice(func_get_args(), 1))
        );
    }
    return call_user_func_array($concatter, $collections);
}
