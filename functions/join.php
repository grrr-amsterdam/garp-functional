<?php
declare(strict_types=1);

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
 * @param  string $separator
 * @param  mixed $list
 * @return string|callable
 */
function join(string $separator, $list = null) {
    return autocurry(
        function ($separator, $list) {
            if (is_string($list)) {
                $list = str_split($list);
            }
            return implode($separator, $list);
        },
        2
    )(...func_get_args());
}

const join = '\Garp\Functional\join';
