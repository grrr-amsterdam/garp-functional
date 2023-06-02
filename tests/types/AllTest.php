<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Garp\Functional as f;
use Garp\Functional\Types\All;
use Garp\Functional\Types\Traits\{TestsSemigroupLaws, TestsMonoidLaws};

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class AllTest extends TestCase {

    use TestsSemigroupLaws;
    use TestsMonoidLaws;

    public function test_semigroup_laws(): void {
        $this->assertObeysSemigroupLaws(
            new All(true),
            new All(true),
            new All(false)
        );
    }

    public function test_monoid_laws(): void {
        $this->assertObeysMonoidLaws(new All(true));
    }

    public function test_encapsulates_boolean_or(): void {
        $this->assertEquals(
            new All(false),
            f\fold(All::class, [false, false, false, true])
        );

        $this->assertEquals(
            new All(true),
            f\fold(All::class, [true, true, true, true])
        );
    }

}
