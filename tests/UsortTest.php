<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class UsortTest extends TestCase {

    public function test_should_sort_array() {
        $spices = array('clove', 'nutmeg', 'allspice', 'cumin');
        $this->assertEquals(
            array('clove', 'cumin', 'nutmeg', 'allspice'),
            f\usort(
                function ($a, $b) {
                    return strlen($a) - strlen($b);
                },
                $spices
            )
        );
        $this->assertEquals(
            array('clove', 'nutmeg', 'allspice', 'cumin'),
            $spices,
            'The original array is not modified'
        );
    }

    public function test_should_be_curried() {
        $sortByStrlen = function ($a, $b) {
            return strlen($a) - strlen($b);
        };
        $sorter = f\usort($sortByStrlen);
        $this->assertTrue(is_callable($sorter));
        $this->assertEquals(
            array('clove', 'cumin', 'nutmeg', 'allspice'),
            $sorter(array('clove', 'nutmeg', 'allspice', 'cumin'))
        );
    }

}
