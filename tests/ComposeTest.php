<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class ComposeTest extends TestCase {

    public function test_should_compose_functions() {
        $revAndUpper = f\compose('strrev', 'strtoupper');
        $this->assertEquals('GEMTUN', $revAndUpper('nutmeg'));

        $initials = f\compose(f\map(f\prop(0)), f\call_left('explode', ' '));
        $this->assertEquals(
            ['M', 'D'],
            $initials('Miles Davis')
        );
    }

}
