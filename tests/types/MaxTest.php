<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Garp\Functional\Types\Max;
use Garp\Functional\Types\Traits\{TestsSemigroupLaws, TestsMonoidLaws};

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class MaxTest extends TestCase {

    use TestsSemigroupLaws;
    use TestsMonoidLaws;

    public function test_semigroup_laws(): void {
        $large = new Max(100);
        $medium = new Max(50);
        $small = new Max(25);
        $this->assertObeysSemigroupLaws($large, $medium, $small);
    }

    public function test_monoid_laws(): void {
        $this->assertObeysMonoidLaws(new Max(100));
    }

    public function test_keeps_the_max_value(): void {
        $large = new Max(100);
        $medium = new Max(50);
        $small = new Max(25);
        $this->assertSame(
            $large,
            $large->concat($small)
        );
        $this->assertSame(
            $medium,
            $medium->concat($small)
        );
        $this->assertSame(
            $large,
            $medium->concat($large)
        );
    }

}
