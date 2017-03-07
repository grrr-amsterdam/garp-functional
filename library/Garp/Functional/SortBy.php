<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Sort a collection by comparing the results of the given function applied to the arguments in the
 * collection.
 *
 * Inspired by Clojure's `sort-by`
 *
 * @param callable $fn
 * @param array $collection
 * @return int
 */
function sort_by($fn, array $collection = null) {
    if (!is_callable($fn)) {
        throw new \InvalidArgumentException('sort_by expects parameter 1 to be callable');
    }
    $sorter = function (array $collection) use ($fn) {
        return usort(
            function ($a, $b) use ($fn) {
                $resultA = $fn($a);
                $resultB = $fn($b);
                if ($resultA === $resultB) {
                    return 0;
                }
                return ($resultA < $resultB) ? -1 : 1;
            },
            $collection
        );
    };
    return func_num_args() < 2 ? $sorter : $sorter($collection);
}
