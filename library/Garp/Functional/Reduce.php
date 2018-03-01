<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Curried version of array_reduce.
 * Also works on iterable objects.
 *
 * @param callable $fn Reducation function
 * @param mixed $default
 * @param array $collection
 * @return mixed
 */
function reduce($fn, $default, $collection = null) {
    $reducer = function ($collection) use ($fn, $default) {
        if (is_array($collection)) {
            return array_reduce($collection, $fn, $default);
        }
        if ($collection instanceof \Traversable) {
            return reduce($fn, $default, iterator_to_array($collection));
        }
        throw new \InvalidArgumentException('reduce expects argument 3 to be a collection');
    };
    return is_null($collection) ? $reducer : $reducer($collection);
}
