<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Flatten an array of arrays.
 *
 * @param  iterable $collection
 * @return array
 */
function flatten(iterable $collection): array {
    $results = [];
    foreach ($collection as $item) {
        // Merge arrays...
        if (is_iterable($item) && !is_assoc($item)) {
            $results = array_merge($results, flatten($item));
            continue;
        }
        // ...push anything else.
        $results[] = $item;
    }
    return $results;
}
