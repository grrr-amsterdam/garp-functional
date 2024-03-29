<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;
use Garp\Functional\Types\StringM;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class UniqueTest extends TestCase {

    public function test_should_work_with_simple_arrays(): void {
        $this->assertEquals(
            array('a', 'b', 'c'),
            f\unique(array('a', 'b', 'b', 'c', 'a'))
        );
        $this->assertEquals(
            array(true, 0, 1, false),
            f\unique(array(true, 0, 1, false, false, true, 1))
        );
    }

    public function test_should_work_with_multidimensional_arrays(): void {
        $musicians = array(
            array('first_name' => 'Miles', 'last_name' => 'Davis', 'instrument' => 'trumpet'),
            array('first_name' => 'Miles', 'last_name' => 'Davis', 'instrument' => 'trumpet'),
            array('first_name' => 'Louis', 'last_name' => 'Armstrong', 'instrument' => 'trumpet'),
            array('first_name' => 'John', 'last_name' => 'Coltrane', 'instrument' => 'saxophone'),
            array('first_name' => 'Miles', 'last_name' => 'Davis', 'instrument' => 'trumpet'),
            array('first_name' => 'John', 'last_name' => 'Coltrane', 'instrument' => 'saxophone'),
            array('first_name' => 'Louis', 'last_name' => 'Armstrong', 'instrument' => 'trumpet'),
        );

        $this->assertEquals(
            array(
                array(
                    'first_name' => 'Miles', 'last_name' => 'Davis', 'instrument' => 'trumpet'
                ),
                array(
                    'first_name' => 'Louis', 'last_name' => 'Armstrong', 'instrument' => 'trumpet'
                ),
                array(
                    'first_name' => 'John', 'last_name' => 'Coltrane', 'instrument' => 'saxophone'
                ),
            ),
            f\unique($musicians)
        );
    }

    public function test_should_work_with_strings(): void {
        $this->assertEquals(
            array('a', 'r', 'd', 'v', 'k'),
            f\unique('aardvark')
        );
    }

    public function test_should_work_with_setoids(): void {
        $john = new StringM('John');
        $miles = new StringM('Miles');
        $herbie = new StringM('Herbie');
        $john2 = new StringM('John');
        $miles2 = new StringM('Miles');

        $this->assertEquals(
            [$john, $miles, $herbie],
            f\unique([$john, $miles, $herbie, $john2, $miles2])
        );

        // Ensure it works with mixed-type arrays:
        $this->assertEquals(
            [$john, 55, 42, $miles],
            f\unique([$john, $john, 55, 42, $miles, 42])
        );
    }

    public function test_named_constant(): void {
        $this->assertTrue(is_callable(f\unique));
    }
}
