<?php

namespace woo\base\register;

class SessionRegister extends Register
{
    private static $instance;

    // 私有构造方法
    private function __construct() {}

    /**
     * 取得类 SessionRegister 的实例
     *
     * @return SessionRegister
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
        if (array_key_exists($key, $_SESSION[__CLASS__])) {
            return $_SESSION[__CLASS__][$key];
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    protected function set($key, $value)
    {
        $_SESSION[__CLASS__][$key] = $value;
    }

    /**
     * @return mixed
     */
    public static function getComplex()
    {
        return self::getInstance()->get('complex');
    }

    /**
     * @param $complex
     */
    public static function setComplex($complex)
    {
        self::getInstance()->set('complex', $complex);
    }
}
