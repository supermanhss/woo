<?php

namespace woo\domain;

interface SpaceCollection extends \Iterator
{
    public function add(DomainObject $space);
}