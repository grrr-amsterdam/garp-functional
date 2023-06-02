<?php
namespace Garp\Functional\Tests\Helpers;

/**
 * Little mock thing to test f\map() and f\filter()
 *
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
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

    function rewind() {
        $this->_position = 0;
    }

    function current() {
        return $this->_spices[$this->_position];
    }

    function key() {
        return $this->_position;
    }

    function next() {
        ++$this->_position;
    }

    function valid() {
        return isset($this->_spices[$this->_position]);
    }

    function offsetExists($offset) {
        return isset($this->_spices[$offset]);
    }

    function offsetGet($offset) {
        return isset($this->_spices[$offset]) ? $this->_spices[$offset] : null;
    }

    function offsetUnset($offset) {
        unset($this->_spices[$offset]);
    }

    function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->_spices[] = $value;
        } else {
            $this->_spices[$offset] = $value;
        }
    }
}
