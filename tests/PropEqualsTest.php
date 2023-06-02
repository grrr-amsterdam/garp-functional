<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class PropEqualsTest extends TestCase {

    public function test_should_determine_equality(): void {
        $miles = array(
            'first_name' => 'Miles',
            'last_name' => 'Davis',
            'instrument' => 'trumpet'
        );
        $this->assertTrue(
            f\prop_equals('first_name', 'Miles', $miles)
        );
        $this->assertTrue(
            f\prop_equals('last_name', 'Davis', $miles)
        );
        $this->assertTrue(
            f\prop_equals('instrument', 'trumpet', $miles)
        );
    }

    public function test_should_work_with_objects(): void {
        $obj = new stdClass();
        $obj->first_name = 'Miles';
        $obj->last_name = 'Davis';
        $this->assertTrue(
            f\prop_equals('first_name', 'Miles', $obj)
        );
        $this->assertFalse(
            f\prop_equals('last_name', 'Coltrane', $obj)
        );
    }

    public function test_should_not_blow_up_on_missing_prop(): void {
        $this->assertFalse(
            f\prop_equals('fruit', 'banana', array())
        );
    }

    public function test_should_be_curried(): void {
        $playsTrumpet = f\prop_equals('instrument', 'trumpet');
        $musicians = array(
            array('first_name' => 'Miles', 'last_name' => 'Davis', 'instrument' => 'trumpet'),
            array('first_name' => 'John', 'last_name' => 'Coltrane', 'instrument' => 'saxophone'),
            array('first_name' => 'Louis', 'last_name' => 'Armstrong', 'instrument' => 'trumpet')
        );
        $this->assertTrue(is_callable($playsTrumpet));
        $this->assertEquals(
            array('Miles', 'Louis'),
            f\reindex(f\map(f\prop('first_name'), f\filter($playsTrumpet, $musicians)))
        );
    }

    public function test_should_be_thrice_curried(): void {
        $musicians = array(
            array('first_name' => 'Miles', 'last_name' => 'Davis', 'instrument' => 'trumpet'),
            array('first_name' => 'John', 'last_name' => 'Coltrane', 'instrument' => 'saxophone'),
            array('first_name' => 'Louis', 'last_name' => 'Armstrong', 'instrument' => 'trumpet'),
            array('first_name' => 'Thelonious', 'last_name' => 'Monk', 'instrument' => 'piano'),
            array('first_name' => 'Charlie', 'last_name' => 'Parker', 'instrument' => 'saxophone')
        );
        $plays = f\prop_equals('instrument');
        $this->assertTrue(is_callable($plays));
        $this->assertTrue(is_callable($plays('saxophone')));

        $saxOrPianoPlayers = f\filter(
            f\either($plays('saxophone'), $plays('piano')),
            $musicians
        );
        $this->assertEquals(
            array(
                array(
                    'first_name' => 'John', 'last_name' => 'Coltrane', 'instrument' => 'saxophone'
                ),
                array('first_name' => 'Thelonious', 'last_name' => 'Monk', 'instrument' => 'piano'),
                array(
                    'first_name' => 'Charlie', 'last_name' => 'Parker', 'instrument' => 'saxophone'
                )
            ),
            $saxOrPianoPlayers
        );
    }

}

