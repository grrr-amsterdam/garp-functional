<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Whether a value is reduced.
 *
 * @param  mixed $value
 * @return bool
 */
function is_reduced($value): bool {
    return $value instanceof Internal\ReducedValue;
}

const is_reduced = '\Garp\Functional\is_reduced';