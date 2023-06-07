<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Curried filter function, but returns results that WON'T match the predicate function.
 * Accepts more than arrays.
 *
 * @param  callable $predicate
 * @param  mixed    $collection
 * @return ($collection is null ? callable : mixed)
 */
function reject(callable $predicate, iterable $collection = null) {
    return autocurry(
        function ($predicate, $collection) {
            return filter(not($predicate), $collection);
        },
        2
    )(...func_get_args());
}

const reject = '\Garp\Functional\reject';
