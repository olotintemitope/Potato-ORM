<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

namespace Laztopaz\potatoORM;

class BaseClass {

	public $name;

	public function __construct()
	{

	}

	/**
	 * This is a getter method that return value of name
	 * @params void
	 * @return string name
	 */
	public function getName()
	{
		return $this->name;
	}


}