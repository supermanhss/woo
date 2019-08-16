<?php

namespace woo\mapper;

use woo\base\register\ApplicationRegister;
use woo\domain\DomainObject;
use woo\domain\ObjectWatcher;

abstract class Mapper
{
    protected static $DB;

    public function __construct()
    {
        if (! self::$DB) {
            $dsn = ApplicationRegister::getDsn();
            $dbUsername = ApplicationRegister::getDbUsername();
            $dbPassword = ApplicationRegister::getDbPassword();

            if (! $dsn || ! $dbUsername || ! $dbPassword) {
                exit('no dsn');
            }

            self::$DB = new \PDO($dsn, $dbUsername, $dbPassword);
            self::$DB->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
    }

    /**
     * @param $id
     * @return DomainObject
     */
    private function getFromMap($id)
    {
        return ObjectWatcher::exists($this->targetClass(), $id);
    }

    /**
     * @param DomainObject $object
     */
    private function addToMap(DomainObject $object)
    {
        ObjectWatcher::add($object);
    }

    /**
     * @param $id
     * @return DomainObject|null
     */
    public function find($id)
    {
        if ($obj = $this->getFromMap($id)) {
            return $obj;
        }

        $this->selectStmt()->execute([$id]);
        $array = $this->selectStmt()->fetch();
        if (! $array || ! is_array($array) || ! isset($array['id'])) {
            return null;
        }

        return $this->createObject($array);
    }

    /**
     * @return Collection
     */
    public function findAll()
    {
        $this->selectAllStmt()->execute([]);
        return $this->getCollection($this->selectAllStmt()->fetchAll(\PDO::FETCH_ASSOC));
    }

    /**
     * @param array $array
     * @return DomainObject
     */
    public function createObject(array $array)
    {
        if ($obj = $this->getFromMap($array['id'])) {
            return $obj;
        }

        $object = $this->doCreateObject($array);

        $this->addToMap($object);

        $obj->markClean();

        return $object;
    }

    /**
     * @param DomainObject $obj
     */
    public function insert(DomainObject $obj)
    {
        $this->doInsert($obj);
        $this->addToMap($obj);
    }

    /**
     * @param DomainObject $obj
     * @return mixed
     */
    abstract public function update(DomainObject $obj);

    /**
     * @param array $array
     * @return DomainObject
     */
    abstract protected function doCreateObject(array $array);

    /**
     * @param DomainObject $obj
     * @return mixed
     */
    abstract protected function doInsert(DomainObject $obj);

    /**
     * @return \PDOStatement
     */
    abstract protected function selectStmt();

    /**
     * @return \PDOStatement
     */
    abstract protected function selectAllStmt();

    /**
     * @param array $raw
     * @return Collection
     */
    abstract function getCollection(array $raw);

    /**
     * @return string
     */
    abstract function targetClass();
}
