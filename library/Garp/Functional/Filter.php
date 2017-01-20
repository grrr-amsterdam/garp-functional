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
    $filterer = function ($collection) use ($fn) {
        if (is_array($collection)) {
            return array_filter($collection, $fn);
        }
        $out = array();
        foreach ($collection as $index => $item) {
            if (call_user_func($fn, $item)) {
                $out[$index] = $item;
            }
        }
        return $out;
    };
    return is_null($collection) ? $filterer : $filterer($collection);
}
