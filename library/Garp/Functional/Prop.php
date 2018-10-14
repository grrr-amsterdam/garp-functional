<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Safely read an array index. (or any object that supports array-like property reading)
 *
 * @param  string|int $key        The requested key
 * @param  mixed      $collection The collection to search in
 * @return mixed
 */
function prop($key, $collection = null) {
    return autocurry(
        function ($key, $collection) {
            if (is_object($collection) && !$collection instanceof \ArrayAccess) {
                return isset($collection->{$key}) ? $collection->{$key} : null;
            }
            return isset($collection[$key]) ? $collection[$key] : null;
        },
        2
    )(...func_get_args());
}
