<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class JoinTest extends TestCase {

    public function test_should_join_arrays() {
        $spices = array('clove', 'nutmeg', 'allspice', 'cumin');
        $this->assertEquals(
            'clove,nutmeg,allspice,cumin',
            f\join(',', $spices)
        );

        $this->assertEquals(
            'foobar',
            f\join('', array('foo', 'bar'))
        );
    }

    public function test_should_join_strings() {
        $miles = 'MILES';
        $this->assertEquals(
            'M⭐️I⭐️L⭐️E⭐️S',
            f\join('⭐️', $miles)
        );
    }

    public function test_should_be_curried() {
        $joinWithSpace = f\join(' ');
        $this->assertTrue(is_callable($joinWithSpace));
        $this->assertEquals(
            'Miles Davis',
            $joinWithSpace(array('Miles', 'Davis'))
        );
    }

}
