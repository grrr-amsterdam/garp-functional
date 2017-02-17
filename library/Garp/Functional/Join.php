<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Join a list where every item is separated by a given separator.
 * Works with arrays and strings.
 *
 * @param string $separator
 * @param mixed $list
 * @return string
 */
function join($separator, $list = null) {
    $joiner = function ($list) use ($separator) {
        if (is_string($list)) {
            $list = str_split($list);
        }
        return implode($separator, $list);
    };
    return func_num_args() < 2 ? $joiner : $joiner($list);
}
