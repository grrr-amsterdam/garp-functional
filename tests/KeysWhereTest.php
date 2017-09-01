<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class KeysWhereTest extends TestCase {

    public function test_should_find_keys_from_array() {
        $fruits = array(
            array('name' => 'apple', 'color' => 'red'),
            array('name' => 'banana', 'color' => 'yellow'),
            array('name' => 'kiwi', 'color' => 'green'),
            array('name' => 'lime', 'color' => 'green'),
            array('name' => 'lemon', 'color' => 'yellow')
        );

        $this->assertEquals(
            array(2, 3),
            f\keys_where(f\prop_equals('color', 'green'), $fruits)
        );

        $this->assertEquals(
            array(),
            f\keys_where(f\prop_equals('color', 'purple'), $fruits)
        );
    }

}
