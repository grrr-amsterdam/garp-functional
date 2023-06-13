<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * The Y Combinator.
 * Inspired by https://php100.wordpress.com/2009/04/13/php-y-combinator/.
 *
 * @param  callable $F
 * @return callable
 */
function Y(callable $F): callable {
    $y = function (callable $f) {
        return $f($f);
    };
    return $y(
        function (callable $f) use ($F) {
            return $F(
                function (...$args) use ($f) {
                    return ($f($f))(...$args);
                }
            );
        }
    );
}


const y = '\Garp\Functional\y';
