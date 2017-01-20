<?php
/**
 * Little mock object to test call().
 *
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
class MockMusician {
    private $_first;
    private $_last;

    public function __construct($first, $last) {
        $this->_first = $first;
        $this->_last = $last;
    }

    public function getName() {
        return $this->_first . ' ' . $this->_last;
    }

    public function setName($first, $last) {
        $this->_first = $first;
        $this->_last = $last;
    }
}
