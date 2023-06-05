<?php
namespace Garp\Functional\Tests\Helpers;

/**
 * Little mock thing to test f\map() and f\filter()
 *
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 *
 * @implements \Iterator<int, string>
 */
class MockSpiceTraverser implements \Iterator, \ArrayAccess {

    /**
     * @var int
     */
    private $_position;

    /**
     * @var array<int, string>
     */
    private $_spices = array(
        'nutmeg', 'cinnamon', 'clove'
    );

    public static function instance(): self {
        return new static;
    }

    public function __construct() {
        $this->_position = 0;
    }

    function rewind(): void {
        $this->_position = 0;
    }

    function current(): string {
        return $this->_spices[$this->_position];
    }

    function key(): int
    {
        return $this->_position;
    }

    function next(): void {
        ++$this->_position;
    }

    function valid(): bool
    {
        return isset($this->_spices[$this->_position]);
    }

    function offsetExists($offset): bool
    {
        return isset($this->_spices[$offset]);
    }

    function offsetGet($offset): ?string {
        return isset($this->_spices[$offset]) ? $this->_spices[$offset] : null;
    }

    function offsetUnset($offset): void {
        unset($this->_spices[$offset]);
    }

    function offsetSet($offset, $value): void {
        if (is_null($offset)) {
            $this->_spices[] = $value;
        } else {
            $this->_spices[$offset] = $value;
        }
    }
}
