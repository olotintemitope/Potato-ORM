<?php

/**
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */
namespace Laztopaz\PotatoORM;

use Exception;

class TableFieldUndefinedException extends Exception
{
    public static function create($unExpectedFields, $message)
    {
        $fields = implode(', ', $unExpectedFields);

        return new static($fields.' '.$message);
    }
}
