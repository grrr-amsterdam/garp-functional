<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Returns the keys of a list, matching the given predicate.
 *
 * @param  callable $predicate
 * @param  iterable<mixed,mixed>|null $collection
 * @return ($collection is null ? callable : array<int,mixed>)
 */
function keys_where(callable $predicate, ?iterable $collection = null) {
    return autocurry(
        function ($predicate, $collection) {
            return reduce_assoc(
                function ($matches, $val, $key) use ($predicate) {
                    return !$predicate($val)
                        ? $matches
                        : concat($matches, [$key]);
                },
                [],
                $collection
            );
        },
        2
    )(...func_get_args());
}

const keys_where = '\Garp\Functional\keys_where';
