<?php
declare(strict_types=1);

namespace Garp\Functional\Types\Traits;

use Garp\Functional\Types\TypeClasses\Semigroup;
use PHPUnit\Framework\TestCase;

/**
 * Use this trait in a PHPUnit testcase to ensure your Semigroup implementation obeys the
 * Semigroup laws.
 *
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
trait TestsSemigroupLaws {

    public function assertObeysSemigroupLaws(Semigroup $a, Semigroup $b, Semigroup $c): void {
        if (!$this instanceof TestCase) {
            throw new \RunTimeException(
                __TRAIT__ . ' should be used in the context of a PHPUnit TestCase'
            );
        }

        $test = function ($a, $b, $c) {
            $this->assertEquals(
                $a->concat($b)->concat($c),
                $a->concat($b->concat($c)),
                'Does not satisfy law of associativity'
            );
        };

        // Make sure all permutations are tested.
        $test($a, $b, $c);
        $test($a, $c, $b);
        $test($b, $a, $c);
        $test($b, $c, $a);
        $test($c, $a, $b);
        $test($c, $b, $a);
    }

}
