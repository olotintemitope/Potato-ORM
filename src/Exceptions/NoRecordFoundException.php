<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

namespace Laztopaz\potatoORM;

use Exception;

class NoRecordFoundException extends Exception {

    public static function checkNoRecordFoundException($message)
    {
        return new static($message);
        
    }

}
