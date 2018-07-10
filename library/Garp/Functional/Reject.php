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
 * @param callable $predicate
 * @param mixed    $collection
 * @return mixed
 */
function reject(callable $predicate, $collection = null) {
    $filterer = function ($collection) use ($predicate) {
        return filter(not($predicate), $collection);
    };
    return func_num_args() < 2 ? $filterer : $filterer($collection);
}
