<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

namespace Laztopaz\potatoORM    ;

use Exception;

class NoRecordInsertionException extends Exception {

    public static function checkNoRecordAddedException($mesaage)
    {
        return new static($mesaage);
        
    }
}
