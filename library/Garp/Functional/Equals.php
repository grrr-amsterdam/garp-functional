<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Functional equality check.
 *
 * @param mixed $comparison
 * @param mixed $subject
 * @return bool
 */
function equals($comparison, $subject = null) {
    $checker = function ($subject) use ($comparison) {
        return $comparison === $subject;
    };
    return func_num_args() < 2 ? $checker : $checker($subject);
}
