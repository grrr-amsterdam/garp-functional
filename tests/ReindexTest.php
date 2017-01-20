<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class ReindexTest extends TestCase {

    public function test_should_reindex_array() {
        $spices = array('clove', 'nutmeg', 'allspice', 'cumin');
        $this->assertEquals(
            $spices,
            f\reindex($spices)
        );

        $spices = array(5 => 'clove', 7 => 'nutmeg', 10 => 'chile', 'abc' => 'cinnamon');
        $this->assertEquals(
            array('clove', 'nutmeg', 'chile', 'cinnamon'),
            f\reindex($spices)
        );
    }

}
