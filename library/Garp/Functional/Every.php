<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Returns true if $callback returns true for every item in the collection.
 *
 * @param callable $fn
 * @param array    $collection
 * @return bool
 */
function every(callable $fn, iterable $collection = null) {
    return reduce(
        function ($acc, $cur) use ($fn): bool {
            return $acc && !!call_user_func($fn, $cur);
        },
        true,
        $collection
    );
}
