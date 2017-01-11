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
 * Note that this function does *not* necessarily keep indexes intact.
 * When string keys are used, keys *will* be kept, but in the case of a numerically indexed array,
 * keys are discarded and a new numerically indexed array is returned.
 *
 * @param callable $fn
 * @param mixed    $collection
 * @return mixed
 */
function filter($fn, $collection = null) {
    $filterer = function ($collection) use ($fn) {
        if (is_array($collection)) {
            $strKeys = array_filter(array_keys($collection), 'is_string');
            $out = array_filter($collection, $fn);
            return count($strKeys) ? $out : array_values($out);
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
