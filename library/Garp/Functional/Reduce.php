<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Curried version of array_reduce.
 * Also works on iterable objects.
 *
 * @param  callable $fn Reduction function
 * @param  mixed    $default
 * @param  iterable $collection
 * @return mixed
 */
function reduce(callable $fn, $default, iterable $collection = null) {
    return autocurry(
        function ($fn, $default, $collection) {
            if (is_array($collection)) {
                return array_reduce($collection, $fn, $default);
            }
            if (is_iterable($collection)) {
                return reduce($fn, $default, iterator_to_array($collection));
            }
            throw new \InvalidArgumentException('reduce expects argument 3 to be a collection');
        },
        3
    )(...func_get_args());
}
