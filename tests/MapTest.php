<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class MapTest extends TestCase {

    public function test_should_map_function_over_array() {
        $spices = array('nutmeg', 'cinnamon', 'clove');

        // Native PHP function.
        $this->assertEquals(
            array('gemtun', 'nomannic', 'evolc'),
            f\map('strrev', $spices)
        );

        // Closure
        $this->assertEquals(
            array('NUTMEG', 'CINNAMON', 'CLOVE'),
            f\map(
                function ($spice) {
                    return strtoupper($spice);
                },
                $spices
            )
        );

        // Class method
        $this->assertEquals(
            array('nut', 'cin', 'clo'),
            f\map(array($this, 'getSubstr'), $spices)
        );
    }

    public function test_should_be_curried() {
        $mapToUpper = f\map('strtoupper');
        $spices = array('nutmeg', 'cinnamon', 'clove');
        $this->assertTrue(is_callable($mapToUpper));
        $this->assertEquals(
            array('NUTMEG', 'CINNAMON', 'CLOVE'),
            $mapToUpper($spices)
        );
    }

    public function test_should_work_with_iterable_objects() {
        $traversable = new MockSpiceTraverser();
        $this->assertEquals(
            array('NUTMEG', 'CINNAMON', 'CLOVE'),
            f\map('strtoupper', $traversable)
        );
    }

    public function getSubstr($str) {
        return substr($str, 0, 3);
    }

}
