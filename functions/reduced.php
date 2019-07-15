<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Declares a value as being "reduced".
 * This signals a short-circuit to the `reduce` function.
 *
 * @param  mixed $value
 * @return Internal\ReducedValue
 */
function reduced($value): Internal\ReducedValue {
    return is_reduced($value)
        ? $value
        : new Internal\ReducedValue($value);
}

const reduced = '\Garp\Functional\reduced';
