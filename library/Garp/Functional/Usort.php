<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Pure sort function. Returns a sorted copy.
 *
 * @param callable $fn
 * @param array $collection
 * @return array
 */
function usort($fn, array $collection = null) {
    if (!is_callable($fn)) {
        throw new InvalidArgumentException('usort expects parameter 1 to be a valid callback');
    }
    $sorter = function (array $collection) use ($fn) {
        // make a copy of the array as to not disturb the original
        $copy = $collection;
        \usort($copy, $fn);
        return $copy;
    };
    return func_num_args() < 2 ? $sorter : $sorter($collection);
}
