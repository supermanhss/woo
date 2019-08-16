<?php

namespace woo\base\register;

abstract class Register
{
    /**
     * @param string $key
     * @return mixed
     */
    abstract protected function get($key);

    /**
     * @param string $key
     * @param mixed $value
     */
    abstract protected function set($key, $value);

    private function __clone()
    {

    }
}
