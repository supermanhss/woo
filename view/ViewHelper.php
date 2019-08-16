<?php

namespace woo\view;

use woo\base\register\RequestRegister;

class ViewHelper
{
    public static function getRequest()
    {
        return RequestRegister::getRequest();
    }
}
