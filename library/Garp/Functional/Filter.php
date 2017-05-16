<?php
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
 * @param callable $fn
 * @param mixed    $collection
 * @return mixed
 */
function filter($fn, $collection = null) {
    if (!is_callable($fn)) {
        throw new \InvalidArgumentException('filter expects the first argument to be callable');
    }
    $filterer = function ($collection) use ($fn) {
        if (is_array($collection)) {
            $numericKeys = array_filter(array_keys($collection), 'is_numeric');
            $isNumericArray = count($numericKeys) === count($collection);
            $filtered = array_filter($collection, $fn);
            return $isNumericArray ? array_values($filtered) : $filtered;
        }
        $out = array();
        $isNumericArray = true;
        foreach ($collection as $index => $item) {
            if (call_user_func($fn, $item)) {
                $out[$index] = $item;
                $isNumericArray = is_numeric($index) && $isNumericArray;
            }
        }
        return $isNumericArray ? array_values($out) : $out;
    };
    return func_num_args() < 2 ? $filterer : $filterer($collection);
}
