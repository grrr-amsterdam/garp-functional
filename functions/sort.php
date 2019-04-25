<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Pure sort function. Returns a sorted copy.
 *
 * @param  array $collection
 * @return array
 */
function sort(array $collection): array {
    // make a copy of the array as to not disturb the original
    $copy = $collection;
    \sort($copy);
    return $copy;
}

const sort = '\Garp\Functional\sort';