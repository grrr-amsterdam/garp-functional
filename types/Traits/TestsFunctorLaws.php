<?php
declare(strict_types=1);

namespace Garp\Functional\Types\Traits;

use Garp\Functional\Types\TypeClasses\Functor;
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * Use this trait in a PHPUnit testcase to ensure your Functor implementation obeys the
 * Functor laws.
 *
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
trait TestsFunctorLaws {

    /**
     * @param  Functor $instance
     * @param  callable $f
     * @param  callable $g
     * @return void
     */
    public function assertObeysFunctorLaws(Functor $instance, callable $f, callable $g) {
        if (!$this instanceof TestCase) {
            throw new \RunTimeException(
                __TRAIT__ . ' should be used in the context of a PHPUnit TestCase'
            );
        }

        $this->assertEquals(
            $instance,
            $instance->map(f\id),
            'Does not satisfy law of identity'
        );
        $this->assertEquals(
            $instance->map(f\compose($g, $f)),
            $instance->map($f)->map($g),
            'Does not satisfy law of composition'
        );
    }

}
