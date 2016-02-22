<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

namespace Laztopaz\potatoORM;


use Exception;

class WrongArgumentException extends Exception {

	public function __construct()
	{

	}

	public function wrongArgumentException($message)
	{
		return new static ($message);
	}

}