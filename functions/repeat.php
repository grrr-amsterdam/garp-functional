<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Create a function that will repeat a function {$times} times and return an array
 * containing all results.
 *
 * @param  int      $times
 * @param  callable $fn
 * @return callable
 */
function repeat(int $times, callable $fn): callable {
    $accumulate = Y(
        function ($recur) use ($fn, $times) {
            return function (array $args, array $result = []) use ($fn, $times, $recur): array {
                return count($result) === $times
                    ? $result
                    : $recur(
                        $args,
                        concat(
                            [$fn(...$args)],
                            $result
                        )
                    );
            };
        }
    );

    return function (...$args) use ($accumulate): array {
        return $accumulate($args);
    };
}

const repeat = '\Garp\Functional\repeat';