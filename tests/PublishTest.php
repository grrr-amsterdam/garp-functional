<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class PublishTest extends TestCase {

    public function test_should_publish_private_methods(): void {
        $this->assertSame(
            [9, 25, 36],
            f\map(f\publish('_square', $this), [3, 5, 6])
        );
    }

    private function _square(int $n): int {
        return $n * $n;
    }

    public function test_named_constant(): void {
        $this->assertTrue(is_callable(f\publish));
    }
}
