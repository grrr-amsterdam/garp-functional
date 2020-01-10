<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class TakeTest extends TestCase {

    public function test_should_take_from_array() {
        $spices = array('Nutmeg', 'Cumin', 'Clove', 'Cinnamon');
        $this->assertEquals(
            array('Nutmeg', 'Cumin'),
            f\take(2, $spices)
        );
        $this->assertEquals(
            array(),
            f\take(4, array())
        );
    }

    public function test_no_problem_if_n_is_more_than_length_of_array() {
        $spices = array('Nutmeg', 'Cumin', 'Clove', 'Cinnamon');
        $this->assertEquals(
            array('Nutmeg', 'Cumin', 'Clove', 'Cinnamon'),
            f\take(10, $spices)
        );
    }

    public function test_should_take_from_string() {
        $spice = 'Nutmeg';
        $this->assertEquals(
            'Nut',
            f\take(3, $spice)
        );
    }

    public function test_should_work_with_iterable_objects() {
        $spices = new ArrayIterator(array('Nutmeg', 'Cumin', 'Clove', 'Cinnamon'));
        $this->assertEquals(
            array('Nutmeg', 'Cumin'),
            f\take(2, $spices)
        );
    }

    public function test_should_throw_on_invalid_arguments() {
        $this->expectException(InvalidArgumentException::class);
        f\take(4, new stdClass());
    }

    public function test_should_be_curried() {
        $take5 = f\take(5);
        $this->assertTrue(is_callable($take5));
        $takeFive = array(
            'Take Five', 'Blue Rhondo à la Turk', 'Unsquare Dance',
            'Out of nowhere', 'Somewhere', 'There\'ll Be Some Changes Made',
            'You Go To My Head', 'Besame Mucho', 'Win A Few, Lose A Few', 'Forty Days'
        );
        $this->assertEquals(
            array('Take Five', 'Blue Rhondo à la Turk', 'Unsquare Dance',
                'Out of nowhere', 'Somewhere'),
            $take5($takeFive)
        );
    }

    public function test_named_constant() {
        $this->assertTrue(is_callable(f\take));
    }
}
