<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class InstanceTest extends TestCase {

    public function test_should_return_instance(): void {
        $instance = new stdClass();
        $this->assertEquals(
            $instance,
            f\instance($instance)
        );
    }

    public function test_should_create_instance_from_string(): void {
        $this->assertInstanceOf('stdClass', f\instance('stdClass'));
    }

    public function test_named_constant(): void {
        $this->assertTrue(is_callable(f\instance));
    }
}
