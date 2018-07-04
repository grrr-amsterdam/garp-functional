<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Returns TRUE if $callback returns true for one of the items in the collection.
 *
 * @param  callable $callback
 * @param  array    $collection
 * @return bool
 */
function some(callable $callback, $collection = null) {
    return autocurry(
        function ($callback, $collection): bool {
            foreach ($collection as $index => $item) {
                if (call_user_func($callback, $item, $index)) {
                    return true;
                }
            }
            return false;
        },
        2
    )(...func_get_args());
}
