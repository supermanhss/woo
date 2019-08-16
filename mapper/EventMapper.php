<?php

namespace woo\mapper;

use woo\domain\DomainObject;

class EventMapper extends Mapper
{
    /**
     * @inheritdoc
     */
    protected function doInsert(DomainObject $obj)
    {
        // TODO: Implement doInsert() method.
    }

    /**
     * @inheritdoc
     */
    protected function doCreateObject(array $array)
    {
        // TODO: Implement doCreateObject() method.
    }

    /**
     * @inheritdoc
     */
    protected function selectStmt()
    {
        // TODO: Implement selectStmt() method.
    }

    /**
     * @inheritdoc
     */
    public function update(DomainObject $obj)
    {
        // TODO: Implement update() method.
    }

    function targetClass()
    {
        return "woo\\domain\\Event";
    }

    function getCollection(array $raw)
    {
        // TODO: Implement getCollection() method.
    }

    protected function selectAllStmt()
    {
        // TODO: Implement selectAllStmt() method.
    }
}