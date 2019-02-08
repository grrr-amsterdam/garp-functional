<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional\Tests\Helpers\MockMusician;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class IdTest extends TestCase {

    public function test_should_return_its_argument() {
        $this->assertEquals('Miles Davis', f\id('Miles Davis'));
        $this->assertEquals(123, f\id(123));
        $this->assertEquals(true, f\id(true));

        $data = array(1, 'abc', true, array());
        $this->assertEquals($data, f\id($data));

        $miles = new MockMusician('Miles', 'Davis');
        $this->assertEquals($miles, f\id($miles));
    }

    public function test_it_should_be_curried() {
        $this->assertTrue(is_callable(f\id()));
        $this->assertEquals(
            'Banana!',
            call_user_func(f\id(), 'Banana!')
        );
    }

}
