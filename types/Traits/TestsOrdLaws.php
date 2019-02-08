<?php
declare(strict_types=1);

namespace Garp\Functional\Types\Traits;

use Garp\Functional\Types\Ord;
use PHPUnit\Framework\TestCase;

/**
 * Use this trait in a PHPUnit testcase to ensure your Ord implementation obeys the Ord laws.
 *
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
trait TestsOrdLaws {

    public function assertObeysOrdLaws(Ord $a, Ord $b, Ord $c) {
        if (!$this instanceof TestCase) {
            throw new \RunTimeException(
                __TRAIT__ . ' should be used in the context of a PHPUnit TestCase'
            );
        }

        $test = function ($a, $b, $c) {
            $this->assertNotSame(
                $a->lte($b), $b->lte($a),
                'Does not satisfy law of totality'
            );

            $this->assertTrue(
                !($a->lte($b) && $b->lte($a)) || $a->equals($b),
                'Does not satisfy law of antisymmetry'
            );

            $this->assertTrue(
                !($a->lte($b) && $b->lte($c)) || $a->lte($c),
                'Does not satisfy law of transitivity'
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
