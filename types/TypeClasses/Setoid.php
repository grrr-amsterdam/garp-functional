<?php
declare(strict_types=1);

namespace Garp\Functional\Types\TypeClasses;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 * @see      https://github.com/fantasyland/fantasy-land#setoid
 */
interface Setoid {

    /**
     * Whether this equals that.
     *
     * @param  Setoid $that
     * @return bool
     */
    public function equals(Setoid $that): bool;

}
