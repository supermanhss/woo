<?php

namespace woo\mapper;

use woo\domain\DomainObject;
use woo\domain\Space;

class SpaceMapper extends Mapper
{
    private $selectStmt;
    private $insertStmt;
    private $updateStmt;
    private $selectAllStmt;
    private $findByVenueStmt;

    public function __construct()
    {
        parent::__construct();

        $this->selectStmt = static::$DB->prepare("SELECT * FROM space WHERE id = ?");
        $this->insertStmt = static::$DB->prepare("INSERT space(venue,name) VALUES(?,?)");
        $this->updateStmt = static::$DB->prepare("UPDATE space SET venue=?,name=? WHERE id=?");
        $this->selectAllStmt = static::$DB->prepare("SELECT * FROM space LIMIT 10");
        $this->findByVenueStmt = static::$DB->prepare("SELECT * FROM space WHERE venue = ?");
    }

    /**
     * @inheritdoc
     */
    function getCollection(array $raw)
    {
        return new SpaceCollection($raw, $this);
    }

    /**
     * @inheritdoc
     */
    protected function doInsert(DomainObject $obj)
    {
        if ($obj instanceof Space) {
            echo "inserting " . $obj->getName() . "\n";
            $this->insertStmt->execute([$obj->getVenue(), $obj->getName()]);
            $obj->setId(static::$DB->lastInsertId());
        }
    }

    /**
     * @inheritdoc
     */
    protected function doCreateObject(array $array)
    {
        return new Space($array['id'], $array['venue'], $array['name']);
    }

    /**
     * @inheritdoc
     */
    public function update(DomainObject $obj)
    {
        if ($obj instanceof Space) {
            $this->updateStmt->execute([$obj->getVenue(), $obj->getName(), $obj->getId()]);
        }
    }

    /**
     * @inheritdoc
     */
    protected function selectStmt()
    {
        return $this->selectStmt;
    }

    /**
     * @inheritdoc
     */
    protected function selectAllStmt()
    {
        return $this->selectAllStmt;
    }

    /**
     * @param $venue_id
     * @return SpaceCollection
     */
    public function findByVenue($venue_id)
    {
        $this->findByVenueStmt->execute([$venue_id]);
        return new SpaceCollection($this->findByVenueStmt->fetchAll(\PDO::FETCH_ASSOC), $this);
    }

    /**
     * @inheritDoc
     */
    function targetClass()
    {
        return "woo\\domain\\Space";
    }
}
