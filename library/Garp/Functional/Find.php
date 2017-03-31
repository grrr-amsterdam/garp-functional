<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Filter a collection and get the first element.
 *
 * @param callable $fn
 * @param mixed $collection
 * @return mixed
 */
function find($fn, $collection = null) {
    $finder = function ($collection) use ($fn) {
        $filtered = filter($fn, $collection);
        return current($filtered) ?: null;
    };
    return func_num_args() < 2 ? $finder : $finder($collection);
}
