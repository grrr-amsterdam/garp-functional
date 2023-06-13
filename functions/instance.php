<?php
declare(strict_types=1);

/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Make the PHP language a little more expressive.
 * PHP 5.4 allows chaining of new instances like so;
 * (new Instance())->doSomething();
 * This method sort of brings this to earlier versions of PHP:
 * instance(new Instance())->doSomething();
 *
 * @template T of object
 * @param  T|class-string<T> $obj
 * @return T
 */
function instance($obj) {
    if (is_string($obj)) {
        $obj = new $obj;
    }
    return $obj;
}

const instance = '\Garp\Functional\instance';
