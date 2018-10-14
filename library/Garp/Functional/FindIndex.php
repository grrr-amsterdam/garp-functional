<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Filter a collection and get the index of the first match.
 *
 * @param  callable $predicate
 * @param  iterable mixed $collection
 * @return mixed
 */
function find_index(callable $predicate, iterable $collection = null) {
    return autocurry(
        function ($predicate, $collection) {
            $collection = is_array($collection) ? $collection : iterator_to_array($collection);
            $keys = keys(array_filter($collection, $predicate));
            $first = current($keys);
            return $first !== false ? $first : null;
        },
        2
    )(...func_get_args());
}
