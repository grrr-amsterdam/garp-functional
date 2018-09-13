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
 * @param  mixed $collection
 * @return array
 */
function entries($collection): array {
    return map(
        function ($key) use ($collection) {
            return [$key, $collection[$key]];
        },
        keys($collection)
    );
}
