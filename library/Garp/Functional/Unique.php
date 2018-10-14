<?php
declare(strict_types=1);

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
 * @param  iterable|string $collection
 * @return array
 */
function unique($collection) {
    $collection = is_string($collection) ? str_split($collection) : $collection;
    if (!is_iterable($collection)) {
        throw new \InvalidArgumentException('unique expects argument 1 to be a collection');
    }
    return reduce(
        function ($out, $item): array {
            if (!in_array($item, $out, true)) {
                $out[] = $item;
            }
            return $out;
        },
        [],
        $collection
    );
}
