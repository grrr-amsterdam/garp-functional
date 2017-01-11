<?php
/**
 * Little mock thing to test f\map() and f\filter()
 *
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class MockSpiceTraverser implements Iterator {
    private $_position = 0;
    private $_spices = array(
        'nutmeg', 'cinnamon', 'clove'
    );

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
}
