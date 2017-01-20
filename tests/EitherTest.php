<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class EitherTest extends TestCase {

    public function test_should_return_first_thruty_value() {
        $this->assertEquals(
            'nutmeg',
            f\either('nutmeg', 'cinnamon')
        );
        $this->assertEquals(
            'nutmeg',
            f\either('', 'nutmeg')
        );
        $this->assertEquals(
            true,
            f\either(true, false)
        );
    }

    public function test_works_elegantly_with_prop() {
        $miles = array(
            'first_name' => 'Miles',
            'last_name' => 'Davis'
        );
        $this->assertEquals(
            'Trumpet',
            f\either(f\prop('instrument', $miles), 'Trumpet')
        );
    }

}
