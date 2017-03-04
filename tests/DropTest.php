<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class DropTest extends TestCase {

    public function test_should_take_from_array() {
        $spices = array('Nutmeg', 'Cumin', 'Clove', 'Cinnamon');
        $this->assertEquals(
            array('Clove', 'Cinnamon'),
            f\drop(2, $spices)
        );
    }

    public function test_no_problem_if_n_is_more_than_length_of_array() {
        $spices = array('Nutmeg', 'Cumin', 'Clove', 'Cinnamon');
        $this->assertEquals(
            array(),
            f\drop(10, $spices)
        );
    }

    public function test_should_take_from_string() {
        $spice = 'Nutmeg';
        $this->assertEquals(
            'meg',
            f\drop(3, $spice)
        );
    }

    public function test_should_work_with_iterable_objects() {
        $spices = new ArrayIterator(array('Nutmeg', 'Cumin', 'Clove', 'Cinnamon'));
        $this->assertEquals(
            array('Clove', 'Cinnamon'),
            f\drop(2, $spices)
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_should_throw_on_invalid_arguments() {
        f\drop(4, new stdClass());
    }

    public function test_should_be_curried() {
        $drop5 = f\drop(5);
        $this->assertTrue(is_callable($drop5));
        $takeFive = array(
            'Take Five', 'Blue Rhondo à la Turk', 'Unsquare Dance',
            'Out of nowhere', 'Somewhere', 'There\'ll Be Some Changes Made',
            'You Go To My Head', 'Besame Mucho', 'Win A Few, Lose A Few', 'Forty Days'
        );
        $this->assertEquals(
            array(
                'There\'ll Be Some Changes Made',
                'You Go To My Head', 'Besame Mucho', 'Win A Few, Lose A Few', 'Forty Days'
            ),
            $drop5($takeFive)
        );
    }

}
