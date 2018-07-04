<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Alias for array_values.
 * Provides a more semantic alias for this type of work.
 *
 * @param  array $collection
 * @return array
 */
function reindex(array $collection): array {
    return array_values($collection);
}
