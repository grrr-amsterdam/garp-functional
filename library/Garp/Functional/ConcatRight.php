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
 * Accepts 0 or more arguments. When 1 or less is given, a curried function will be
 * returned.
 *
 * @return mixed
 */
function concat_right() {
    if (func_num_args() <= 1) {
        return call_user_func_array(
            'Garp\Functional\partial_right',
            array_merge(array('Garp\Functional\concat'), func_get_args())
        );
    }
    return call_user_func_array(
        'Garp\Functional\concat',
        array_reverse(func_get_args())
    );
}
