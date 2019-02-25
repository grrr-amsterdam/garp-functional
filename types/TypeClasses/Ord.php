<?php
declare(strict_types=1);

namespace Garp\Functional\Types\TypeClasses;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 * @see      https://github.com/fantasyland/fantasy-land#ord
 */
interface Ord extends Setoid {

    /**
     * Whether this is less than or equal to that.
     *
     * @param  Ord $that
     * @return bool
     */
    public function lte(Ord $that): bool;

}
