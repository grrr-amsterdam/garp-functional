<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Split a string.
 *
 * @param  string $separator
 * @param  string|null $subject
 * @return ($subject is null ? callable : array)
 */
function split(string $separator, ?string $subject = null) {
    return autocurry(
        function ($separator, $subject): array {
            return explode($separator, $subject);
        },
        2
    )(...func_get_args());
}

const split = '\Garp\Functional\split';
