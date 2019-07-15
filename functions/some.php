<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Returns TRUE if $predicate returns true for one of the items in the collection.
 *
 * @param  callable $predicate
 * @param  array    $collection
 * @return bool|callable
 */
function some(callable $predicate, $collection = null) {
    return autocurry(
        function ($predicate, $collection): bool {
            return reduce(
                function ($acc, $item) use ($predicate) {
                    return $predicate($item)
                        ? reduced(true)
                        : $acc;
                },
                false,
                $collection
            );
        },
        2
    )(...func_get_args());
}

const some = '\Garp\Functional\some';
