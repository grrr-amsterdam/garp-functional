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
 * @return ($collection is null ? callable : mixed)
 */
function find_index(callable $predicate, iterable $collection = null) {
    return autocurry(
        function ($predicate, $collection) {
            return reduce_assoc(
                function ($acc, $item, $key) use ($predicate) {
                    return $predicate($item) ? reduced($key) : $acc;
                },
                null,
                $collection
            );
        },
        2
    )(...func_get_args());
}

const find_index = '\Garp\Functional\find_index';
