<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Returns an array from the given collection, keyed by the given index.
 * If index is callable, the collection is keyed by the result of
 * calling the function with the given item in the collection.
 *
 * Inspired by Clojure's group-by function.
 *
 * @param callable|string $indexFn
 * @param array $collection
 * @return int
 */
function group_by($indexFn, $collection = null) {
    $indexFn = !is_callable($indexFn) ? prop($indexFn) : $indexFn;
    $grouper = function ($collection) use ($indexFn) {
        return reduce(
            function ($acc, $cur) use ($indexFn) {
                $key = $indexFn($cur);
                if (!is_int($key) && !is_string($key)) {
                    throw new \InvalidArgumentException(
                        'group_by expects result of first argument to be of type integer or string'
                    );
                }
                $acc[$key][] = $cur;
                return $acc;
            },
            array(),
            $collection
        );
    };
    return func_num_args() < 2 ? $grouper : $grouper($collection);
}
