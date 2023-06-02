<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class RepeatTest extends TestCase {

    public function test_should_repeat_callable(): void {
        $toUpperZeroTimes = f\repeat(0, 'strtoupper');
        $this->assertTrue(is_callable($toUpperZeroTimes));
        $this->assertEmpty($toUpperZeroTimes(), 'Repeating zero times yields empty array');

        $toUpperFiveTimes = f\repeat(5, 'strtoupper');
        $this->assertSame(
            ['HENK', 'HENK', 'HENK', 'HENK', 'HENK'],
            $toUpperFiveTimes('henk')
        );

        $rand = function () {
            return mt_rand();
        };
        $this->assertCount(
            50,
            f\repeat(50, $rand)()
        );
    }

    public function test_named_constant(): void {
        $this->assertTrue(is_callable(f\repeat));
    }
}
