<?php
declare(strict_types=1);

namespace Garp\Functional\Types\TypeClasses;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 * @see      https://github.com/fantasyland/fantasy-land#monoid
 */
interface Monoid extends Semigroup {

    /**
     * Return the identity value for this group.
     *
     * @return Monoid
     */
    public static function empty(): Monoid;

}
