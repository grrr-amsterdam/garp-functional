<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Safely read an array index. (or any object that supports array-like property reading)
 *
 * @param  string $key        The requested key
 * @param  mixed  $collection The collection to search in
 * @return mixed
 */
function prop($key, $collection = null) {
    $getter = function ($collection) use ($key) {
        if (is_object($collection)) {
            return $collection instanceof \ArrayAccess
                ? $collection[$key]
                : (isset($collection->{$key}) ? $collection->{$key} : null);
        }
        return isset($collection[$key]) ? $collection[$key] : null;
    };
    return func_num_args() < 2 ? $getter : $getter($collection);
}
