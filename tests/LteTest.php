<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;
use Garp\Functional\Tests\Helpers\MockOrd;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class LteTest extends TestCase {

    public function test_should_check_if_n_is_less_or_equal() {
        $this->assertTrue(
            f\lte(20, 10)
        );
        $this->assertTrue(
            f\lte(0.52, 0.51)
        );
        $this->assertTrue(
            f\lte(10, 10)
        );
        $this->assertFalse(f\lte(50, 100));
    }

    public function test_should_be_curried() {
        $lessThan5 = f\lte(5);
        $this->assertTrue(is_callable($lessThan5));
        $this->assertTrue($lessThan5(3));
        $this->assertFalse($lessThan5(5.5));
    }

    public function test_should_allow_ord_instances() {
        $small = new MockOrd('small');
        $big = new MockOrd('big');
        $huge = new MockOrd('huge');
        $tiny = new MockOrd('tiny');

        $this->assertTrue(f\lte($huge, $small));
        $this->assertFalse(f\lte($big, $huge));
        $this->assertTrue(f\lte($big, $big));
        $this->assertTrue(f\lte($small, $tiny));
    }

}
