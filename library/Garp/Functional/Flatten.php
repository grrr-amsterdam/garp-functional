<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Flatten an array of arrays.
 *
 * @param array $collection
 * @return array
 */
function flatten($collection) {
    $results = array();
    foreach ($collection as $item) {
        // Merge arrays...
        if (is_array($item) || $item instanceof \Traversable) {
            $results = array_merge($results, flatten($item));
            continue;
        }
        // ...push anything else.
        $results[] = $item;
    }
    return $results;
}
