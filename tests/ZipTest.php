<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class ZipTest extends TestCase {

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_should_throw_on_invalid_arguments() {
        f\zip([], [], 'abc');
    }

    public function test_it_should_zip_a_bunch_of_arrays_together() {
        $first = array('Miles', 'John', 'Herbie');
        $last = array('Davis', 'Coltrane', 'Hancock');
        $this->assertSame(
            array(array('Miles', 'Davis'), array('John', 'Coltrane'), array('Herbie', 'Hancock')),
            f\zip($first, $last)
        );
    }

    public function test_it_should_accept_variadic_arguments() {
        $first = array('Miles', 'John', 'Herbie');
        $second = array('Davis', 'Coltrane', 'Hancock');
        $last = array('Trumpet', 'Saxophone', 'Piano');
        $this->assertSame(
            array(
                array('Miles', 'Davis', 'Trumpet'),
                array('John', 'Coltrane', 'Saxophone'),
                array('Herbie', 'Hancock', 'Piano')
            ),
            f\zip($first, $second, $last)
        );
    }

    public function test_it_should_null_missing_values() {
        $first = array('Miles', 'John', 'Herbie');
        $last = array('Davis');
        $this->assertSame(
            array(array('Miles', 'Davis'), array('John', null), array('Herbie', null)),
            f\zip($first, $last)
        );
    }

    public function test_it_should_work_with_assoc_arrays() {
        $first = array('red' => '#FF0000', 'green' => '#00FF00');
        $last = array('red' => '#FF4136', 'green' => '#2ECC40');
        $this->assertSame(
            array(
                'red' => array('#FF0000', '#FF4136'),
                'green' => array('#00FF00', '#2ECC40')
            ),
            f\zip($first, $last)
        );
    }

    public function test_it_should_null_missing_assoc_values() {
        $first = array('red' => '#FF0000', 'green' => '#00FF00');
        $last = array('red' => '#FF4136', 'green' => '#2ECC40', 'blue' => '#0000FF');
        $this->assertSame(
            array(
                'red' => array('#FF0000', '#FF4136'),
                'green' => array('#00FF00', '#2ECC40'),
                'blue' => array(null, '#0000FF')
            ),
            f\zip($first, $last)
        );
    }

    public function test_it_should_work_with_iterable_objects() {
        $first = new ArrayIterator(array(1, 2, 3));
        $second = array(4, 5, 6);
        $this->assertSame(
            array(array(1, 4), array(2, 5), array(3, 6)),
            f\zip($first, $second)
        );
    }

}
