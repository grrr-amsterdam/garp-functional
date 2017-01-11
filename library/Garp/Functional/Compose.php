<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * A functional programming classic.
 * Compose functions $g and $f into a new function $gf
 *
 * Note that evaluation is from right to left, as is traditional.
 * Usage:
 * $reverseAndToUpper = compose('ucfirst', 'strrev');
 *
 * @param callable $f
 * @param callable $g
 * @return callable
 */
function compose($f, $g) {
    return function () use ($f, $g) {
        $args = func_get_args();
        return call_user_func_array(
            $f,
            array(call_user_func_array($g, $args))
        );
    };
}


