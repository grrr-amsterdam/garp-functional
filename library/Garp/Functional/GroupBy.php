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
 * @param callable|string $index
 * @param array $collection
 * @return int
 */
function group_by($index, $collection = null) {
    if (!is_string($index) && !is_callable($index)) {
        throw new \InvalidArgumentException(
            'Given index is invalid. Must be of type string or callable'
        );
    }
    $grouper = function ($collection) use ($index) {
        return reduce(
            function ($acc, $cur) use ($index) {
                $key = is_callable($index) ? $index($cur) : prop($index, $cur);
                if (!is_int($key) && !is_string($key)) {
                    throw new \InvalidArgumentException(
                        'Key is not usable as index. Must be of type integer or string'
                    );
                }
                if (!array_key_exists($key, $acc)) {
                    $acc[$key] = array();
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
