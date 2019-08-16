<?php

namespace woo\domain;

interface VenueCollection extends \Iterator
{
    public function add(DomainObject $venue);
}