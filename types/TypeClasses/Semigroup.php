<?php
declare(strict_types=1);

namespace Garp\Functional\Types\TypeClasses;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 * @see      https://github.com/fantasyland/fantasy-land#semigroup
 */
interface Semigroup {

    public function concat(Semigroup $that): Semigroup;

}
