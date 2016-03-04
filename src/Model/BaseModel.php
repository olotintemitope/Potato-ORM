<?php

/**
 * @author   Temitope Olotin <temitope.olotin@andela.com>
 * @license  <https://opensource.org/license/MIT> MIT
 */
namespace Laztopaz\PotatoORM;

class BaseModel implements BaseModelInterface
{
    // Inject the inflector trait
    use Inflector;

    // Private variable that contains instance of database
    protected $databaseModel;

    // Class variable holding class name pluralized
    protected $tableName;

    // Properties will later contain key, value pairs from the magic setter, getter methods
    protected $properties = [];

    public function __construct()
    {
        $this->tableName = $this->getClassName();

        $this->databaseModel = new DatabaseHandler($this->tableName);

        $this->properties['id'] = 0;
    }

    /**
     * The magic getter method.
     *
     * @params key
     *
     * @return array key
     */
    public function __get($key)
    {
        $this->properties[$key];
    }

    /**
     * The magic setter method.
     *
     * @params property, key
     *
     * @return array associative array properties
     */
    public function __set($property, $value)
    {
        $this->properties[$property] = $value;
    }

    /**
     * This method gets all the record from a particular table.
     *
     * @params void
     *
     * @throws NoRecordFoundException
     *
     * @return associative array
     */
    public static function getAll()
    {
        $allData = DatabaseHandler::read($id = false, self::getClassName());

        if (count($allData) > 0) {
            return $allData;
        }

        throw NoRecordFoundException::create('There is no record to display');
    }

    /**
     * This method create or update record in a database table.
     *
     * @params void
     *
     * @throws EmptyArrayException
     * @throws NoRecordInsertionException
     * @throws NoRecordUpdateException
     *
     * @return bool true or false;
     */
    public function save()
    {
        $boolCommit = false;

        if ($this->properties['id']) {
            $allData = DatabaseHandler::read($id = $this->properties['id'], self::getClassName());

            if ($this->checkIfRecordIsEmpty($allData)) {
                $boolCommit = $this->databaseModel->update(['id' => $this->properties['id']], $this->tableName, $this->properties);

                if ($boolCommit) {
                    return true;
                }

                throw NoRecordUpdateException::create('Record not updated successfully');
            }

            throw EmptyArrayException::create("Value passed didn't match any record");
        }

        $boolCommit = $this->databaseModel->create($this->properties, $this->tableName);

        if ($boolCommit) {
            return true;
        }

        throw NoRecordInsertionException::create('Record not created successfully');
    }

    /**
     * This method find a record by id.
     *
     * @params int id
     *
     * @throws NoArgumentPassedToFunctionException
     *
     * @return object
     */
    public static function find($id)
    {
        $num_args = (int) func_num_args(); // get number of arguments passed to this function
        if ($num_args == 0 || $num_args > 1) {
            throw NoArgumentPassedToFunctionException::create('Argument missing: only one argument is allowed');
        }

        if ($id == '') {
            throw NullArgumentPassedToFunctionException::create('This function expect a value');
        }

        $staticFindInstance = new static();
        $staticFindInstance->id = $id == '' ? false : $id;

        return $staticFindInstance;
    }

    /**
     * This method delete a row from the table by the row id.
     *
     * @params int id
     *
     * @throws NoRecordDeletionException;
     *
     * @return bool true or false
     */
    public static function destroy($id)
    {
        $boolDeleted = false;

        $num_args = (int) func_num_args(); // get number of arguments passed to this function

        if ($num_args == 0 || $num_args > 1) {
            throw NoArgumentPassedToFunctionException::create('Argument missing: only one argument is allowed');
        }

        $boolDeleted = DatabaseHandler::delete($id, self::getClassName());

        if ($boolDeleted) {
            return true;
        }

        throw NoRecordDeletionException::create('Record deletion unsuccessful because id does not match any record');
    }

   /**
    * This method return the current class name
    * $params void.
    *
    * @return classname
    */
   public static function getClassName()
   {
       $tableName = preg_split('/(?=[A-Z])/', get_called_class());

       $className = end($tableName);

       return self::pluralize(strtolower($className));
   }

    /**
     * This method check if the argument passed to this function is an array.
     *
     * @param $arrayOfRecord
     *
     * @return bool
     */
    public function checkIfRecordIsEmpty($arrayOfRecord)
    {
        if (count($arrayOfRecord) > 0) {
            return true;
        }

        return false;
    }
}
