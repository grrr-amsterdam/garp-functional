<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Filter a collection and get the index of the first match.
 *
 * @param callable $fn
 * @param mixed $collection
 * @return mixed
 */
function find_index($fn, $collection = null) {
    if (!is_callable($fn)) {
        throw new \InvalidArgumentException('find_index expects the first argument to be callable');
    }
    $finder = function ($collection) use ($fn) {
        if (is_array($collection)) {
            $keys = keys(array_filter($collection, $fn));
            $first = current($keys);
            return $first !== false ? $first : null;
        }
        if (!$collection instanceof \Traversable) {
            throw new \InvalidArgumentException('find_index expects argument 2 to be a collection');
        }
        foreach ($collection as $key => $value) {
            if ($fn($value)) {
                return $key;
            }
        }
        return null;
    };
    return func_num_args() < 2 ? $finder : $finder($collection);
}
