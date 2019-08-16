<?php

namespace woo\mapper;

class SpaceCollection extends Collection implements \woo\domain\SpaceCollection
{
    public function targetClass()
    {
        return "\\woo\\domain\\Space";
    }
}