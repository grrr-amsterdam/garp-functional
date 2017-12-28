<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Ternary operator in function form.
 * Allows functions for the first 3 arguments in which case $subject will be passed into them to get
 * to the result, as well as determine which branch to take.
 *
 * Usage:
 * $isAllowedEditing = when(propertyEquals('role', 'admin'), true, false, $user);
 *
 * array_map(
 *   when(
 *     propertyEquals('role', 'admin'),
 *     array_set('can_edit', true),
 *     array_set('can_edit', false)
 *   ),
 *   $users
 * )
 *
 * @param mixed $condition
 * @param mixed $ifTrue
 * @param mixed $ifFalse
 * @param mixed $subject
 * @return mixed
 */
function when($condition, $ifTrue, $ifFalse, $subject = null) {
    $someCallable = is_callable_function($condition)
        || is_callable_function($ifTrue) || is_callable_function($ifFalse);
    if (func_num_args() === 3 && $someCallable) {
        return partial('Garp\Functional\when', $condition, $ifTrue, $ifFalse);
    }
    $passed = is_callable_function($condition) ? call_user_func($condition, $subject) : $condition;
    if ($passed) {
        return is_callable_function($ifTrue) ? call_user_func($ifTrue, $subject) : $ifTrue;
    }
    return is_callable_function($ifFalse) ? call_user_func($ifFalse, $subject) : $ifFalse;
}
