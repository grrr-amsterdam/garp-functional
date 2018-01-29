<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class PublishTest extends TestCase {

    public function test_should_publish_private_methods() {
        $this->assertSame(
            [9, 25, 36],
            f\map(f\publish('_square', $this), [3, 5, 6])
        );
    }

    private function _square($n) {
        return $n * $n;
    }

}
