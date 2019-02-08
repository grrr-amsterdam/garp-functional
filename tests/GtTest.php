<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional\Tests\Helpers\MockOrd;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class GtTest extends TestCase {

    public function test_should_check_if_n_is_greater() {
        $this->assertTrue(
            f\gt(10, 20)
        );
        $this->assertTrue(
            f\gt(0.5, 0.51)
        );
        $this->assertFalse(f\gt(100, 50));
    }

    public function test_should_be_curried() {
        $moreThan5 = f\gt(5);
        $this->assertTrue(is_callable($moreThan5));
        $this->assertTrue($moreThan5(10));
    }

    public function test_should_allow_ord_instances() {
        $small = new MockOrd('small');
        $big = new MockOrd('big');
        $huge = new MockOrd('huge');
        $tiny = new MockOrd('tiny');

        $this->assertFalse(f\gt($huge, $small));
        $this->assertTrue(f\gt($big, $huge));
        $this->assertTrue(f\gt($tiny, $huge));
        $this->assertFalse(f\gt($big, $big));
        $this->assertFalse(f\gt($small, $tiny));
    }

}
