<?php

/**
 * @package  Laztopaz\potato-ORM
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */

namespace Laztopaz\potatoORM\test;

use \Mockery;
use Laztopaz\potatoORM\BaseClass;
use Laztopaz\potatoORM\User;
use PHPUnit_Framework_TestCase;
use Laztopaz\potatoORM\DatabaseConnection;
use Laztopaz\potatoORM\NullArgumentPassedToFunction;
use Laztopaz\potatoORM\DatabaseHandler;
use Laztopaz\potatoORM\DatabaseHelper;
use Laztopaz\potatoORM\EmptyArrayException;

class ExceptionTest extends PHPUnit_Framework_TestCase
{
    private $dbConnMocked;
    private $dbHelper;
    private $dbHandler;

    public function setUp()
    {
        $this->dbConnMocked = Mockery::mock('\Laztopaz\potatoORM\DatabaseConnection');

        $this->dbHelper = new DatabaseHelper($this->dbConnMocked);

        $this->dbHandler = new DatabaseHandler("gingers", $this->dbConnMocked);

        $this->statement = Mockery::mock('\PDOStatement');
    }

    /**
     * @expectedException Laztopaz\potatoORM\EmptyArrayException
     */
    public function testEmptyArrayOnFindAndWhere()
    {
        $dbHandler = new DatabaseHandler("gingers", $this->dbConnMocked);

        $dbHandler->findAndWhere([], "gingers", $this->dbConnMocked);
    }

    /**
     * @expectedException Laztopaz\potatoORM\
     */
}
