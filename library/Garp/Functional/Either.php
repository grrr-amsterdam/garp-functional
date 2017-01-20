<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Get either the left argument if true, otherwise the right argument.
 *
 * @param mixed $left
 * @param mixed $right
 * @return mixed
 */
function either($left, $right) {
    return $left ?: $right;
}
