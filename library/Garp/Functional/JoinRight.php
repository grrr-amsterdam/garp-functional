<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Join two things, but in reverse order.
 *
 * @param mixed $right
 * @param mixed $left
 * @return mixed
 */
function join_right($right, $left = null) {
    if (is_null($left)) {
        return partial_right('Garp\Functional\join', $right);
    }
    return join($left, $right);
}
