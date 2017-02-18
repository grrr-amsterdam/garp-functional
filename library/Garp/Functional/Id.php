<?php
/**
 * @package  Garp\Functional
 * @author   Harmen Janssen <harmen@grrr.nl>
 * @license  https://github.com/grrr-amsterdam/garp-functional/blob/master/LICENSE.md BSD-3-Clause
 */
namespace Garp\Functional;

/**
 * Returns the given argument.
 *
 * @param mixed $it
 * @return mixed
 */
function id($it = null) {
    if (!func_num_args()) {
        return partial('Garp\Functional\id');
    }
    return $it;
}
