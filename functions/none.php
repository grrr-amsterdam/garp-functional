<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Returns true if $callback returns false for every item in the collection.
 *
 * @param  callable $fn
 * @param  iterable $collection
 * @return bool
 */
function none($fn, iterable $collection = null) {
    return autocurry(
        function ($fn, $collection) {
            return reduce(
                function (bool $acc, $cur) use ($fn): bool {
                    return $acc && !call_user_func($fn, $cur);
                },
                true,
                $collection
            );
        },
        2
    )(...func_get_args());
}
