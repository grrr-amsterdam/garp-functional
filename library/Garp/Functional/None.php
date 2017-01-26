<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Returns true if $callback returns false for every item in the collection.
 *
 * @param callable $fn
 * @param array    $collection
 * @return bool
 */
function none($fn, $collection = null) {
    return reduce(
        function ($acc, $cur) use ($fn) {
            return $acc && !call_user_func($fn, $cur);
        },
        true,
        $collection
    );
}
