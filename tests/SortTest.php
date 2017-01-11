<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class SortTest extends TestCase {

    public function test_should_sort_array() {
        $spices = array('nutmeg', 'allspice', 'clove', 'cumin');
        $this->assertEquals(
            array('allspice', 'clove', 'cumin', 'nutmeg'),
            f\sort($spices)
        );
        $this->assertEquals(
            array('nutmeg', 'allspice', 'clove', 'cumin'),
            $spices,
            'The original array is not modified'
        );
    }

}

