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
 * @param  mixed $collection
 * @return array
 */
function keys_where(callable $predicate, iterable $collection = null) {
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
