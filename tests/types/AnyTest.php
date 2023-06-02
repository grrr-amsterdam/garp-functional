<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Garp\Functional as f;
use Garp\Functional\Types\Any;
use Garp\Functional\Types\Traits\{TestsSemigroupLaws, TestsMonoidLaws};

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class AnyTest extends TestCase {

    use TestsSemigroupLaws;
    use TestsMonoidLaws;

    public function test_semigroup_laws(): void {
        $this->assertObeysSemigroupLaws(
            new Any(true),
            new Any(true),
            new Any(false)
        );
    }

    public function test_monoid_laws(): void {
        $this->assertObeysMonoidLaws(new Any(true));
    }

    public function test_encapsulates_boolean_or(): void {
        $this->assertEquals(
            new Any(true),
            f\fold(Any::class, [false, false, false, true])
        );

        $this->assertEquals(
            new Any(false),
            f\fold(Any::class, [false, false, false, false])
        );
    }

}
