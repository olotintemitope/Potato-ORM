<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

use Laztopaz\potatoORM\Inflector;
use PHPUnit_Framework_TestCase;

class InflectorClassTest extends PHPUnit_Framework_TestCase {

	/**
	 * This test fot plural of words ending with s
	 * @return boolean true
	 */
	public function testPluralizeThatEndsWithS()
	{
		$user = "user";

		$userPlural = Inflector::pluralize($user);

		$this->assertEquals('users',$userPlural);
	}

	/**
	 * This test fot plural of words ending with en
	 * @return boolean true
	 */
	public function testPluralizeThatEndsWithEn()
	{
		$child = "child";

		$childPlural = Inflector::pluralize($child);

		$this->assertEquals('children',$childPlural);
	}

	/**
	 * This test fot plural of words ending with es
	 * @return boolean true
	 */
	public function testPluralizeThatEndsWithEs()
	{
		$church = "church";

		$churchPlural = Inflector::pluralize($church);

		$this->assertEquals('churches',$churchPlural);
	}

}