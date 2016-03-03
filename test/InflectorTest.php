<?php

/**
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */
namespace Laztopaz\PotatoORM\Test;

use Laztopaz\PotatoORM\Inflector;
use PHPUnit_Framework_TestCase;

class InflectorTest extends PHPUnit_Framework_TestCase
{
    /**
     * This test fot plural of words ending with s.
     *
     * @return bool true
     */
    public function testPluralizeThatEndsWithS()
    {
        $user = 'user';

        $userPlural = Inflector::pluralize($user);

        $this->assertEquals('users', $userPlural);
    }

    /**
     * This test fot plural of words ending with en.
     *
     * @return bool true
     */
    public function testPluralizeThatEndsWithEn()
    {
        $child = 'child';

        $childPlural = Inflector::pluralize($child);

        $this->assertEquals('children', $childPlural);
    }

    /**
     * This test for plural of words ending with es.
     *
     * @return bool true
     */
    public function testPluralizeThatEndsWithEs()
    {
        $church = 'church';

        $churchPlural = Inflector::pluralize($church);

        $this->assertEquals('churches', $churchPlural);
    }
}
