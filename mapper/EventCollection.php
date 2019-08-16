<?php

namespace woo\mapper;

class EventCollection extends Collection implements \woo\domain\EventCollection
{
    public function targetClass()
    {
        return "\\woo\\domain\\Event";
    }
}