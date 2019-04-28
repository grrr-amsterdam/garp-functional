<?php
declare(strict_types=1);

namespace Garp\Functional\Types\TypeClasses;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 * @see      https://github.com/fantasyland/fantasy-land#functor
 */
interface Functor {

    /**
     * Map a function over the contained value.
     *
     * @param  callable $fn
     * @return Functor
     */
    public function map(callable $fn): Functor;

}
