<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Concat two things, but in reverse order.
 *
 * @param mixed $right
 * @param mixed $left
 * @return mixed
 */
function concat_right($right, $left = null) {
    if (func_num_args() < 2) {
        return partial_right('Garp\Functional\concat', $right);
    }
    return concat($left, $right);
}
