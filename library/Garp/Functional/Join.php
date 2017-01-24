<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Join two things.
 * Works with arrays and strings.
 *
 * @param mixed $left
 * @param mixed $right
 * @return mixed
 */
function join($left = null, $right = null) {
    $joiner = function ($right) use ($left) {
        if (is_array($left) || is_array($right)) {
            return array_merge((array)$left, (array)$right);
        }
        if (is_string($left) && is_string($right)) {
            return $left . $right;
        }
        throw new \InvalidArgumentException(
            __FUNCTION__ . ' can only join arrays or strings'
        );
    };
    if (is_null($left)) {
        return partial('Garp\Functional\join');
    }
    return is_null($right) ? $joiner : $joiner($right);
}
