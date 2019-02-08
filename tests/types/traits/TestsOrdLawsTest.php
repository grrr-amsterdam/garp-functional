<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional\Tests\Helpers\MockOrd;
use Garp\Functional\Types\Traits\TestsOrdLaws;

/**
 * This TestCase actually tests whether the test trait tests a reliable situation correctly.
 *
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class TestsOrdLawsTest extends TestCase {

    use TestsOrdLaws;

    public function test_ord_laws() {
        $tiny = new MockOrd('tiny');
        $big = new MockOrd('big');
        $large = new MockOrd('huge');
        $this->assertObeysOrdLaws($tiny, $big, $large);
    }

}
