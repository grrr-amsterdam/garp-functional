<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Returns the given argument.
 *
 * @param  mixed $it
 * @return mixed
 */
function id($it = null) {
    return autocurry(
        function ($it) {
            return $it;
        },
        1
    )(...func_get_args());
}
