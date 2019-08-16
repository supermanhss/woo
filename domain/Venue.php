<?php

namespace woo\domain;

class Venue extends DomainObject
{
    private $name;
    private $spaces;

    public function __construct($id = null, $name = null)
    {
        $this->name = $name;
        $this->spaces = $this->collection();

        parent::__construct($id);
    }

    /**
     * @param SpaceCollection $spaces
     */
    public function setSpace(SpaceCollection $spaces)
    {
        $this->spaces = $spaces;
        $this->markDirty();
    }

    /**
     * @return \woo\mapper\Collection
     */
    public function getSpace()
    {
        if (is_null($this->spaces)) {
            $this->spaces = $this->collection();
        }

        return $this->spaces;
    }

    public function addSpace(Space $space)
    {
        $this->getSpace()->add($space);
        $space->setVenue($this);
    }


    /**
     * @return |null
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