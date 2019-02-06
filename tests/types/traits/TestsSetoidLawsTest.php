<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional\Tests\Helpers\MockSetoid;
use Garp\Functional\Types\Traits\TestsSetoidLaws;

/**
 * This TestCase actually tests whether the test trait tests a reliable situation correctly.
 *
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class TestsSetoidLawsTest extends TestCase {

    use TestsSetoidLaws;

    public function test_setoid_laws() {
        $setoidA = new MockSetoid('A');
        $setoidB = new MockSetoid('B');
        $setoidC = new MockSetoid('C');
        $this->assertObeysSetoidLaws($setoidA, $setoidB, $setoidC);
    }

}
