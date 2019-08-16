<?php

namespace woo\domain;

class Space extends DomainObject
{
    private $venue;
    private $name;

    public function __construct($id = null, $name = null)
    {
        parent::__construct($id);

        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getVenue()
    {
        return $this->venue;
    }

    /**
     * @param DomainObject $venue
     */
    public function setVenue(DomainObject $venue)
    {
        $this->venue = $venue->getId();
        $this->markDirty();
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
        $this->markDirty();
    }
}
