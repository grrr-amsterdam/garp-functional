<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Return a set of tuples for every key/value in the collection.
 *
 * @param  iterable<mixed, mixed> $collection
 * @return array
 */
function entries(iterable $collection): array {
    $collection = is_array($collection) ? $collection : iterator_to_array($collection);
    return map(
        function ($key) use ($collection): array {
            return [$key, $collection[$key]];
        },
        array_keys($collection)
    );
}

const entries = '\Garp\Functional\entries';
