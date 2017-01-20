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
Function find($fn, $collection = null) {
    $finder = Function ($collection) use ($fn) {
        $filtered = filter($fn, $collection);
        return current($filtered) ?: null;
    };
    return is_null($collection) ? $finder : $finder($collection);
}
