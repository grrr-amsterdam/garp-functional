<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

use Garp\Functional\Types\TypeClasses\Monoid;

/**
 * Fold a collection of items into a Monoid.
 *
 * @param  string $monoidClassName
 * @param  array  $collection
 * @return Monoid
 */
function fold(string $monoidClassName, $collection = null): Monoid {
    if (!is_a($monoidClassName, Monoid::class, true)) {
        throw new \InvalidArgumentException(
            sprintf('Class %s does not implement Monoid', $monoidClassName)
        );
    }
    return reduce(
        function (Monoid $acc, $curr) use ($monoidClassName) {
            return concat($acc, new $monoidClassName($curr));
        },
        call_user_func("{$monoidClassName}::empty"),
        $collection
    );
}

const fold = '\Garp\Functional\fold';
