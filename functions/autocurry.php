<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Currying utility, mostly used for Garp\Functional internals,
 * but help yourself if you can use it!
 * Keeps returning functions until the specified arity is reached,
 * after which it returns the evaluated result.
 *
 * @param  callable $fn    The function to call.
 * @param  int      $arity The required arity for the given function.
 *                         Alas, PHP cannot inspect this automatically without the Reflection API,
 *                         so it has to be a required argument.
 * @return callable
 */
function autocurry(callable $fn, int $arity): callable {
    return Y(
        function ($recur) use ($fn, $arity) {
            return function (...$restArgs) use ($recur, $fn, $arity) {
                return count($restArgs) < $arity
                    ? partial($recur, ...$restArgs)
                    : $fn(...$restArgs);
            };
        }
    );
}

const autocurry = '\Garp\Functional\autocurry';
