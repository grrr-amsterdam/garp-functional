<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Curried map function.
 * Accepts more than arrays.
 *
 * @param callable $fn
 * @param mixed    $collection
 * @return mixed
 */
function map($fn, $collection = null) {
    $mapper = function ($collection) use ($fn) {
        if (is_array($collection)) {
            return array_map($fn, $collection);
        }
        $out = array();
        foreach ($collection as $index => $item) {
            $out[$index] = $fn($item);
        }
        return $out;
    };
    return func_num_args() < 2 ? $mapper : $mapper($collection);
}
