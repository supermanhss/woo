<?php

namespace woo\domain;

interface EventCollection extends \Iterator
{
    public function add(DomainObject $event);
}