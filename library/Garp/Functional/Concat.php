<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Concat two things.
 * Works with arrays and strings.
 *
 * @param mixed $left
 * @param mixed $right
 * @return mixed
 */
function concat($left = null, $right = null) {
    $concatter = function ($right) use ($left) {
        if (is_array($left) || is_array($right)) {
            return array_merge((array)$left, (array)$right);
        }
        if (is_string($left) && is_string($right)) {
            return $left . $right;
        }
        throw new \InvalidArgumentException(
            __FUNCTION__ . ' can only concat arrays or strings'
        );
    };
    if (!func_num_args()) {
        return partial('Garp\Functional\concat');
    }
    return func_num_args() === 1 ? $concatter : $concatter($right);
}
