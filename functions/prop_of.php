<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Read a property from the given array or object.
 * This is the same function as `prop` but with flipped arguments. The use-case is common enough to
 * move this into its own function.
 *
 * @param  mixed  $collection The collection to search in
 * @param  string $prop       The requested key
 * @return mixed
 */
function prop_of($collection, $prop = null) {
    return autocurry(
        function ($collection, $prop) {
            return prop($prop, $collection);
        },
        2
    )(...func_get_args());
}
