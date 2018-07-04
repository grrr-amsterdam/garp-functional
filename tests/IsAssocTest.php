<?php
use PHPUnit\Framework\TestCase;
use Garp\Functional as f;

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class IsAssocTest extends TestCase {

    /**
     * @dataProvider arrayProvider
     * @param  iterable $input
     * @param  bool     $result
     * @return void
     */
    public function test_should_recognize_associative_arrays(iterable $input, bool $result) {
        $this->assertSame($result, f\is_assoc($input));
    }

    public function arrayProvider(): array {
        return [
            [
                [1, 2, 3],
                false
            ],
            [
                [],
                false
            ],
            [
                ['foo' => 'bar', 1, 2, 3],
                true
            ],
            [
                ['foo' => 'boar', 'bar' => 'boaz'],
                true
            ],
            [
                new ArrayIterator([1, 2, 3]),
                false
            ],
            [
                new ArrayIterator(['foo' => 'bar', 'baz' => 'boaz']),
                true
            ]
        ];
    }

}
