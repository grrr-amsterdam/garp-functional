<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Create a new array containing only the keys from the original that you want.
 *
 * @param array $allowed
 * @param array $collection
 * @return array
 */
function pick(array $allowed, $collection = null) {
    $picker = function ($collection) use ($allowed) {
        if (is_array($collection)) {
            return array_intersect_key($collection, array_flip($allowed));
        }
        $out = array();
        foreach ($collection as $key => $value) {
            if (in_array($key, $allowed)) {
                $out[$key] = $value;
            }
        }
        return $out;
    };
    return is_null($collection) ? $picker : $picker($collection);
}
