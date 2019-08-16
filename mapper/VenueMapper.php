<?php

namespace woo\mapper;

use woo\domain\DomainObject;
use woo\domain\Space;
use woo\domain\Venue;

class VenueMapper extends Mapper
{
    private $selectStmt;
    private $insertStmt;
    private $updateStmt;
    private $selectAllStmt;

    public function __construct()
    {
        parent::__construct();

        $this->selectStmt = static::$DB->prepare("SELECT * FROM venue WHERE id=?");
        $this->insertStmt = static::$DB->prepare("INSERT venue(name) VALUES(?)");
        $this->updateStmt = static::$DB->prepare("UPDATE venue SET name=?,id=? WHERE id=?");
        $this->selectAllStmt = static::$DB->prepare("SELECT * FROM venue LIMIT 10");
    }

    /**
     * @inheritDoc
     */
    function getCollection(array $raw)
    {
        return new VenueCollection($raw, $this);
    }

    /**
     * @inheritDoc
     */
    protected function doCreateObject(array $array)
    {
        $obj = new Venue($array['id'], $array['name']);

        $spaceMapper = new SpaceMapper();
        $spaceCollection = $spaceMapper->findByVenue($array['id']);
        $obj->setSpace($spaceCollection);

        return $obj;
    }

    /**
     * @inheritDoc
     */
    protected function doInsert(DomainObject $obj)
    {
        if (! $obj instanceof Venue) {
            exit();
        }

        echo "inserting " . $obj->getName() ."\n";
        $values = [$obj->getName()];
        $this->insertStmt->execute($values);
        $id = static::$DB->lastInsertId();
        $obj->setId($id);
    }

    /**
     * @inheritDoc
     */
    public function update(DomainObject $obj)
    {
        if (! $obj instanceof Venue) {
            exit();
        }
        echo "updating \n";
        $values = array($obj->getName(), $obj->getId(), $obj->getId());
        $this->updateStmt->execute($values);
    }

    /**
     * @inheritDoc
     */
    protected function selectStmt()
    {
        return $this->selectStmt;
    }

    /**
     * @inheritDoc
     */
    protected function selectAllStmt()
    {
        return $this->selectAllStmt;
    }

    /**
     * @inheritDoc
     */
    function targetClass()
    {
        return "woo\\domain\\Venue";
    }
}