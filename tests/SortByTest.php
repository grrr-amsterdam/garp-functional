<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class SortByTest extends TestCase {

    public function test_should_sort_arrays() {
        $musicians = array(
            array('first_name' => 'Louis', 'last_name' => 'Armstrong', 'instrument' => 'trumpet'),
            array('first_name' => 'Miles', 'last_name' => 'Davis', 'instrument' => 'trumpet'),
            array('first_name' => 'John', 'last_name' => 'Coltrane', 'instrument' => 'saxophone'),
        );
        $this->assertSame(
            array(
                array(
                    'first_name' => 'John', 'last_name' => 'Coltrane', 'instrument' => 'saxophone'
                ),
                array(
                    'first_name' => 'Louis', 'last_name' => 'Armstrong', 'instrument' => 'trumpet'
                ),
                array(
                    'first_name' => 'Miles', 'last_name' => 'Davis', 'instrument' => 'trumpet'
                ),
            ),
            f\sort_by(f\prop('first_name'), $musicians)
        );

        $words = array('tree', 'axe', 'dwarf', 'fruit');
        $this->assertSame(
            array('axe', 'tree', 'dwarf', 'fruit'),
            f\sort_by('strlen', $words)
        );
    }

    public function test_should_be_curried() {
        $sortByName = f\sort_by(f\prop('first_name'));
        $this->assertTrue(is_callable($sortByName));
        $musicians = array(
            array('first_name' => 'Louis', 'last_name' => 'Armstrong', 'instrument' => 'trumpet'),
            array('first_name' => 'Miles', 'last_name' => 'Davis', 'instrument' => 'trumpet'),
            array('first_name' => 'John', 'last_name' => 'Coltrane', 'instrument' => 'saxophone'),
        );
        $this->assertSame(
            array(
                array(
                    'first_name' => 'John', 'last_name' => 'Coltrane', 'instrument' => 'saxophone'
                ),
                array(
                    'first_name' => 'Louis', 'last_name' => 'Armstrong', 'instrument' => 'trumpet'
                ),
                array(
                    'first_name' => 'Miles', 'last_name' => 'Davis', 'instrument' => 'trumpet'
                ),
            ),
            $sortByName($musicians)
        );
    }

    public function test_named_constant() {
        $this->assertTrue(is_callable(f\sort_by));
    }
}
