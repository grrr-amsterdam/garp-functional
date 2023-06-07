<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Curried filter function.
 * Accepts more than arrays.
 *
 * @param  callable $predicate
 * @param  iterable    $collection
 * @return ($collection is null ? callable : iterable)
 */
function filter(callable $predicate, iterable $collection = null) {
    return autocurry(
        function ($predicate, $collection): iterable {
            $collection = is_array($collection) ? $collection : iterator_to_array($collection);
            $filtered = array_filter($collection, $predicate);
            return is_assoc($collection) ? $filtered : array_values($filtered);
        },
        2
    )(...func_get_args());
}

const filter = '\Garp\Functional\filter';
