<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Returns the keys of a list, matching the given predicate.
 *
 * @param callable $predicate
 * @param mixed $collection
 * @return array
 */
function keys_where($predicate, $collection = null) {
    $filterer = function ($collection) use ($predicate) {
        return reduce_assoc(
            function ($matches, $val, $key) use ($predicate) {
                if (!$predicate($val)) {
                    return $matches;
                }
                return concat($matches, array($key));
            },
            array(),
            $collection
        );
    };
    return func_num_args() < 2 ? $filterer : $filterer($collection);
}
