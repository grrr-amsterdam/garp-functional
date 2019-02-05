<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Return the last item in a collection.
 *
 * @param  mixed $collection
 * @return mixed
 */
function last($collection) {
    if (is_string($collection)) {
        $collection = str_split($collection);
    }
    if ($collection instanceof \Traversable) {
        $collection = iterator_to_array($collection);
    }
    $index = count($collection) - 1;
    return prop($index, array_values($collection));
}
