<?php

/**
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */
namespace Laztopaz\PotatoORM;

use Exception;

class NoRecordFoundException extends Exception
{
    public static function create($message)
    {
        return new static($message);
    }
}
