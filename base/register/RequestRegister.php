<?php

namespace woo\base\register;

use woo\base\Request;

class RequestRegister extends Register
{
    private static $instance;

    private $values = array();

    // 私有构造方法
    private function __construct() {}

    /**
     * 单例模式
     * 取得RequestRegister类的实例
     *
     * @return RequestRegister
     */
    public static function getInstance()
    {
        if (! self::$instance instanceof self) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @inheritdoc
     */
    protected function get($key)
    {
        return array_key_exists($key, $this->values) ? $this->values[$key] : null;
    }

    /**
     * @inheritdoc
     */
    protected function set($key, $value)
    {
        $this->values[$key] = $value;
    }

    /**
     * Get request
     *
     * @return Request
     */
    public static function getRequest()
    {
        return self::getInstance()->get('request');
    }

    /**
     * Set request
     *
     * @param Request $request
     */
    public static function setRequest(Request $request)
    {
        self::getInstance()->set('request', $request);
    }
}
