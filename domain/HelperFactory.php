<?php

namespace woo\domain;

use woo\mapper\Collection;
use woo\mapper\VenueCollection;
use woo\mapper\SpaceCollection;
use woo\mapper\EventCollection;
use woo\mapper\Mapper;
use woo\mapper\EventMapper;
use woo\mapper\SpaceMapper;
use woo\mapper\VenueMapper;

class HelperFactory
{
    /**
     * @param string $type
     * @return Collection
     */
    public static function getCollection($type)
    {
        if ($type == "woo\\domain\\Venue") {
            return new VenueCollection();
        }

        if ($type == "woo\\domain\\Space") {
            return new SpaceCollection();
        }

        if ($type == "woo\\domain\\Event") {
            return new EventCollection();
        }

        return null;
    }

    /**
     * @param string $type
     * @return Mapper
     */
    public static function getFinder($type)
    {
        if ($type == "woo\\domain\\Venue") {
            return new VenueMapper();
        }

        if ($type == "woo\\domain\\Space") {
            return new SpaceMapper();
        }

        if ($type == "woo\\domain\\Event") {
            return new EventMapper();
        }

        return null;
    }
}
