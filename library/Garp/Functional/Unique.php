<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Returns an array containing unique entries in the given collection.
 * Works with multi-dimensional arrays, as opposed to native `array_unique`.
 *
 * @param array $collection
 * @return int
 */
function unique($collection) {
    $collection = is_string($collection) ? str_split($collection) : $collection;
    if (!is_array($collection) && !$collection instanceof \Traversable) {
        throw new \InvalidArgumentException('unique expects argument 1 to be a collection');
    }
    return reduce(
        function ($out, $item) {
            if (!in_array($item, $out, true)) {
                $out[] = $item;
            }
            return $out;
        },
        array(),
        $collection
    );
}
