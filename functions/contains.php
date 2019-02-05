<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Check wether an item exists in an array or string.
 *
 * @param  mixed                    $item
 * @param  string|array|Traversable $collection
 * @return bool
 */
function contains($item, $collection = null) {
    return autocurry(
        function ($item, $collection):bool {
            if (is_string($collection)) {
                return strpos($collection, strval($item)) !== false;
            }
            if (is_array($collection)) {
                return in_array($item, $collection);
            }
            if ($collection instanceof \Traversable) {
                return contains($item, iterator_to_array($collection));
            }
            throw new \InvalidArgumentException('contains expects argument 2 to be a collection');
        },
        2
    )(...func_get_args());
}
