<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class NotTest extends TestCase {

    public function test_should_negate_function() {
        $noArray = f\not('is_array');
        $this->assertTrue($noArray(123));
        $this->assertFalse($noArray(array(1,2,3)));
    }

}
