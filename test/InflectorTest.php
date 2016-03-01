<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

use Laztopaz\potatoORM\Inflector;
use PHPUnit_Framework_TestCase;

class InflectorClassTest extends PHPUnit_Framework_TestCase {


	public function testPluralize()
	{
		$user = "user";
		$userPlural = Inflector::pluralize($user);
		$this->assertEquals('users',$userPlural);
	}

}