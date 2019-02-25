<?php
declare(strict_types=1);

namespace Garp\Functional\Types\Traits;

use Garp\Functional\Types\TypeClasses\Setoid;
use PHPUnit\Framework\TestCase;

/**
 * Use this trait in a PHPUnit testcase to ensure your Setoid implementation obeys the Setoid laws.
 *
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
trait TestsSetoidLaws {

    public function assertObeysSetoidLaws(Setoid $a, Setoid $b, Setoid $c) {
        if (!$this instanceof TestCase) {
            throw new \RunTimeException(
                __TRAIT__ . ' should be used in the context of a PHPUnit TestCase'
            );
        }

        if (get_class($a) !== get_class($b) || get_class($c) !== get_class($a)) {
            throw new \InvalidArgumentException('All Setoids should be of the same class');
        }

        $test = function ($a, $b, $c) {
            $this->assertTrue(
                $a->equals($a),
                'Does not satisfy the law of reflexivity'
            );

            $this->assertSame(
                $a->equals($b),
                $b->equals($a),
                'Does not satisfy the law of symmetry'
            );

            $aEqualsB = $a->equals($b);
            $bEqualsC = $b->equals($c);
            $aEqualsC = $a->equals($c);
            $this->assertTrue(
                !($aEqualsB && $bEqualsC) || $aEqualsC,
                'Does not satisfy the law of transitivity'
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
