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
 * @param  iterable<mixed,mixed>|object|string  $collection The collection to search in
 * @param  int|string $key       The requested key
 * @return ($key is null ? callable : mixed)
 */
function prop_of($collection, $key = null) {
    return autocurry(
        function ($collection, $prop) {
            return prop($prop, $collection);
        },
        2
    )(...func_get_args());
}

const prop_of = '\Garp\Functional\prop_of';
