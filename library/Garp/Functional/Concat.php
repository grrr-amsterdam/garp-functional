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
 * Accepts 0 or more arguments. When 1 or less is given, a curried function will be
 * returned.
 *
 * @return mixed
 */
function concat() {
    $concatter = function () {
        $args = func_get_args();
        $toArray = function ($var) {
            return (array) $var;
        };
        if (some(unary('is_array'), $args)) {
            return call_user_func_array(
                'array_merge',
                map($toArray, $args)
            );
        }
        $isStringble = unary(
            either(
                'is_string',
                either(
                    both('is_object', partial_right('method_exists', '__toString')),
                    either('is_float', 'is_int')
                )
            )
        );
        if (every($isStringble, $args)) {
            return join(
                '',
                map('strval', $args)
            );
        }
        throw new \InvalidArgumentException(
            'concat can only concat arrays or strings'
        );
    };
    if (func_num_args() <= 1) {
        return call_user_func_array(
            'Garp\Functional\partial',
            array_merge(array('Garp\Functional\concat'), func_get_args())
        );
    }
    return call_user_func_array($concatter, func_get_args());
}
