<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Returns TRUE if $callback returns true for every item in the collection.
 *
 * @param callable $callback
 * @param array    $collection
 * @return bool
 */
function every($callback, $collection = null) {
    return reduce(
        function ($acc, $cur) {
            return $acc && !!call_user_func($cur);
        },
        true,
        $collection
    );
}
