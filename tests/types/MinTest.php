<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Garp\Functional\Types\Min;
use Garp\Functional\Types\Traits\{TestsSemigroupLaws, TestsMonoidLaws};

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class MinTest extends TestCase {

    use TestsSemigroupLaws;
    use TestsMonoidLaws;

    public function test_semigroup_laws(): void {
        $large = new Min(100);
        $medium = new Min(50);
        $small = new Min(25);
        $this->assertObeysSemigroupLaws($large, $medium, $small);
    }

    public function test_monoid_laws(): void {
        $this->assertObeysMonoidLaws(new Min(100));
    }

    public function test_keeps_the_min_value(): void {
        $large = new Min(100);
        $medium = new Min(50);
        $small = new Min(25);
        $this->assertSame(
            $small,
            $large->concat($small)
        );
        $this->assertSame(
            $small,
            $medium->concat($small)
        );
        $this->assertSame(
            $medium,
            $medium->concat($large)
        );
    }

}

