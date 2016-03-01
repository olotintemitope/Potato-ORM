<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

use Laztopaz\potatoORM\Inflector;
use PHPUnit_Framework_TestCase;

class InflectorClassTest extends PHPUnit_Framework_TestCase {


	public function testPluralizeThatEndsWithS()
	{
		$user = "user";
		$userPlural = Inflector::pluralize($user);
		$this->assertEquals('users',$userPlural);
	}

	public function testPluralizeThatEndsWithEn()
	{
		$child = "child";
		$childPlural = Inflector::pluralize($child);
		$this->assertEquals('children',$childPlural);
	}

	public function testPluralizeThatEndsWithEs()
	{
		$church = "church";
		$churchPlural = Inflector::pluralize($church);
		$this->assertEquals('churches',$churchPlural);
	}

	// public function testWordCannotBePluralize()
	// {
	// 	$noPlural = 'information';
	// 	$bool = Inflector::pluralize();
	// 	$this->assertFalse($bool);
	// }

}