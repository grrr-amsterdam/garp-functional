<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Returns a function that will always return the given argument.
 * Also known as `const`, or the `K` combinator.
 *
 * @param  mixed $it
 * @return mixed
 */
function always($it = null): callable {
    return function () use ($it) {
        return $it;
    };
}

const always = '\Garp\Functional\always';