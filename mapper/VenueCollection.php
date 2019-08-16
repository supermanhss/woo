<?php

namespace woo\mapper;

class VenueCollection extends Collection implements \woo\domain\VenueCollection
{
    public function targetClass()
    {
        return "\\woo\\domain\\Venue";
    }
}