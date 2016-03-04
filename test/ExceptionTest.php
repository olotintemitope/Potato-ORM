<?php

/**
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */
namespace Laztopaz\PotatoORM\Test;

error_reporting(0);

use Laztopaz\PotatoORM\DatabaseHandler;
use Laztopaz\PotatoORM\DatabaseHelper;
use Laztopaz\PotatoORM\User;
use Mockery;
use PHPUnit_Framework_TestCase;

class ExceptionTest extends PHPUnit_Framework_TestCase
{
    private $dbConnMocked;
    private $dbHelper;
    private $dbHandler;

    public function setUp()
    {
        $this->dbConnMocked = Mockery::mock('\Laztopaz\PotatoORM\DatabaseConnection');

        $this->dbHelper = new DatabaseHelper($this->dbConnMocked);

        $this->dbHandler = new DatabaseHandler('gingers', $this->dbConnMocked);

        $this->statement = Mockery::mock('\PDOStatement');
    }

    /**
     * @expectedException Laztopaz\PotatoORM\EmptyArrayException
     */
    public function testFindAndWhere()
    {
        $id = 3;

        $sql = "SELECT * FROM gingers WHERE `id` = '$id'";

        $this->dbConnMocked->shouldReceive('prepare')->with($sql)->andReturn($this->statement);

        $this->statement->shouldReceive('execute');
        $this->statement->shouldReceive('rowCount')->andReturn(true);

        $this->dbHandler->findAndWhere([], 'gingers', $this->dbConnMocked);
    }

    /**
     * @expectedException Laztopaz\PotatoORM\TableFieldUndefinedException
     */
    public function testUpdateRecord()
    {
        $this->getTableColumnFields();

        $id = 1;

        $data = [
            'kiss'   => 'Kola',
            'gender' => 'Male',
        ];

        $updateQuery = "UPDATE `gingers` SET `name` = 'Kola',`gender` = 'Male' WHERE id = ".$id;

        $this->dbConnMocked->shouldReceive('prepare')->with($updateQuery)->andReturn($this->statement);

        $this->statement->shouldReceive('execute')->andReturn(true);

        $this->dbHandler = new DatabaseHandler('gingers', $this->dbConnMocked);
        $this->dbHandler->update(['id' => $id], 'gingers', $data, $this->dbConnMocked);
    }

    /**
     * @expectedException Laztopaz\PotatoORM\TableFieldUndefinedException
     */
    public function testCreate()
    {
        $this->getTableColumnFields();

        $this->dbHandler = new DatabaseHandler('gingers', $this->dbConnMocked);

        $insertQuery = "INSERT INTO gingers (id,name,gender) VALUES ('1','Kola','Male')";

        $this->dbConnMocked->shouldReceive('exec')->with($insertQuery)->andReturn(true);

        $this->dbHandler->create([
            'id'     => '1',
            'kiss'   => 'Kola',
            'gender' => 'Male', ],
            'gingers',
            $this->dbConnMocked
        );
    }

    /**
     * @expectedException Laztopaz\PotatoORM\NoRecordDeletionException
     */
    public function testDelete()
    {
        $id = "sade";

        $sql = 'DELETE FROM gingers WHERE id = '.$id;

        $this->dbConnMocked->shouldReceive('exec')->with($sql)->andReturn(false);

        $bool = $this->dbHandler->delete($id, 'gingers',  $this->dbConnMocked);
    }

    /**
     * @expectedException Laztopaz\PotatoORM\NoArgumentPassedToFunctionException
     */
    public function testIfFindMethodHasAnArgument()
    {
        User::find();
    }

    /**
     * @expectedException Laztopaz\PotatoORM\NullArgumentPassedToFunctionException
     */
    public function testIfEmptyStringIsPassedToDestroyMethodAsArgument()
    {
        User::find('');
    }

    /**
     * @expectedException Laztopaz\PotatoORM\NoArgumentPassedToFunctionException
     */
    public function testIfDestroyMethodHasAnArgument()
    {
        User::destroy();
    }

    public function getTableColumnFields()
    {
        $fieldName1 = [
            'Field' => 'id',
            'Type'  => 'int',
            'NULL'  => 'NO',
        ];

        $fieldName2 = [
            'Field' => 'name',
            'Type'  => 'varchar',
            'NULL'  => 'NO',
        ];

        $fieldName3 = [
            'Field' => 'gender',
            'Type'  => 'varchar',
            'NULL'  => 'YES',
        ];

        $fieldName = [$fieldName1, $fieldName2, $fieldName3];

        $this->dbConnMocked->shouldReceive('prepare')->with('SHOW COLUMNS FROM gingers')->andReturn($this->statement);

        $this->statement->shouldReceive('bindValue')->with(':table', 'gingers', 2);
        $this->statement->shouldReceive('execute');
        $this->statement->shouldReceive('fetchAll')->with(2)->andReturn($fieldName);

        return $fieldName;
    }
}
