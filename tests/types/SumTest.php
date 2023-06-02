<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Garp\Functional as f;
use Garp\Functional\Types\Sum;
use Garp\Functional\Types\Traits\{TestsSemigroupLaws, TestsMonoidLaws};

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class SumTest extends TestCase {

    use TestsSemigroupLaws;
    use TestsMonoidLaws;

    public function test_semigroup_laws(): void {
        $this->assertObeysSemigroupLaws(
            new Sum(540),
            new Sum(19),
            new Sum(-5)
        );
    }

    public function test_monoid_laws(): void {
        $this->assertObeysMonoidLaws(
            new Sum(4390)
        );
    }

    public function test_summation(): void {
        $sums = $this->_sumProvider();
        $this->assertTrue(
            f\every(
                function ($args) {
                    return (new Sum($args[2]))->equals(
                        (new Sum($args[0]))->concat(new Sum($args[1]))
                    );
                },
                $sums
            )
        );
    }

    /**
     * @return array<int, array<int, int>>
     */
    private function _sumProvider(): array {
        return f\reduce(
            function ($out, $n) {
                $a = rand(0, 1000);
                $b = rand(0, 1000);
                $sum = $a + $b;
                $out[] = [$a, $b, $sum];
                return $out;
            },
            [],
            range(0, 100)
        );
    }

}

