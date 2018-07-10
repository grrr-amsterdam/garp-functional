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
 * @param callable $predicate
 * @param mixed    $collection
 * @return mixed
 */
function filter(callable $predicate, $collection = null) {
    $filterer = function ($collection) use ($predicate) {
        if (is_array($collection)) {
            $filtered = array_filter($collection, $predicate);
            return !is_assoc($collection) ? array_values($filtered) : $filtered;
        }
        $out = [];
        foreach ($collection as $index => $item) {
            if (call_user_func($predicate, $item)) {
                $out[$index] = $item;
            }
        }
        return !is_assoc($collection) ? array_values($out) : $out;
    };
    return func_num_args() < 2 ? $filterer : $filterer($collection);
}
