<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Garp\Functional as f;
use Garp\Functional\Types\StringM;
use Garp\Functional\Types\Traits\{TestsSemigroupLaws, TestsMonoidLaws};

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class StringMTest extends TestCase {

    use TestsSemigroupLaws;
    use TestsMonoidLaws;

    public function test_semigroup_laws() {
        $this->assertObeysSemigroupLaws(
            new StringM('foo'),
            new StringM('bar'),
            new StringM('baz')
        );
    }

    public function test_monoid_laws() {
        $this->assertObeysMonoidLaws(new StringM('foo'));
    }

    public function test_folds_to_string() {
        $this->assertEquals(
            new StringM('foobarbaz'),
            f\fold(StringM::class, ['foo', 'bar', 'baz'])
        );

        $this->assertEquals(
            '',
            f\fold(StringM::class, [])->value
        );
    }

}
