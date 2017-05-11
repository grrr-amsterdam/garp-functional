<?php
/**
 * @package  Garp\Functional
 * @author   Marco Worms <marcogworms@gmail.com>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Functional "if then else"
 *
 * @param function $predicate
 * @param function $then
 * @param function $else
 * @param mixed $subject
 * @return mixed
 */
function if_else($predicate, $then, $else, $subject = null) {
    $ifElser = function ($subject) use ($predicate, $then, $else) {
        if ($predicate($subject)) {
            return $then($subject);
        } else {
            return $else($subject);
        }
    };
    return func_num_args() < 4 ? $ifElser : $ifElser($subject);
}
