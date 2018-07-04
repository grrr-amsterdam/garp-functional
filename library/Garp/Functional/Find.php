<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Filter a collection and get the first element.
 *
 * @param  callable $predicate
 * @param  mixed $collection
 * @return mixed
 */
function find(callable $predicate, iterable $collection = null) {
    return autocurry(
        function ($predicate, $collection) {
            $filtered = filter($predicate, $collection);
            return current($filtered) ?: null;
        },
        2
    )(...func_get_args());
}
