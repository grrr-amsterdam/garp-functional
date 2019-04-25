<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Returns a function like the supplied one, but with the first two arguments' order reversed.
 *
 * Note that a curried function will behave a little different than you might expect.
 * For instance:
 *
 * f\flip('Garp\Functional\Concat')('ba')('nana');
 *
 * Won't get you 'nanaba', but still 'banana', because the concat call receives just the one
 * argument, causing it to return a new function awaiting the second parameter,
 * but that one's not influenced by flip.
 *
 * @param  callable $fn
 * @return callable
 */
function flip(callable $fn): callable {
    return function () use ($fn) {
        $args = func_get_args();
        $rest = array_slice($args, 2);
        $arg0 = prop(0, $args);
        $arg1 = prop(1, $args);
        return call_user_func_array(
            $fn,
            concat($arg1, concat($arg0, $rest))
        );
    };
}

const flip = '\Garp\Functional\flip';