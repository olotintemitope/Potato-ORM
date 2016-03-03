<?php

/**
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */
namespace Laztopaz\PotatoORM;

use Exception;

class WrongArgumentException extends Exception
{
    public function create($message)
    {
        return new static ($message);
    }
}
