<?php

namespace woo\base\register;

use woo\controller\ControllerMap;

class ApplicationRegister extends Register
{
    private $freezeDir = 'data';
    private $values = [];
    private $m_times = [];

    private static $instance;

    /**
     * ApplicationRegister constructor.
     */
    private function __construct() {}

    /**
     * 取得类 SessionRegister 的实例
     * @return ApplicationRegister
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
        $file = __DIR__ . '/' . $this->freezeDir . '/' . $key;
        if (file_exists($file)) {
            clearstatcache();

            /* @var int $m_time 上次修改文件的时间戳 */
            $m_time = filemtime($file);

            /* @var int $last_m_time 保存在$this->m_tines里的文件修改时间戳 */
            $last_m_time = $this->getMTime($key);

            if ($m_time > $last_m_time) {
                $this->setMTime($key, $m_time);
                return ($this->values[$key] = unserialize(file_get_contents($file)));
            }
        }

        if (array_key_exists($key, $this->values)) {
            return $this->values[$key];
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    protected function set($key, $value)
    {
        $this->values[$key] = $value;
        $file = __DIR__ . '/' . $this->freezeDir . '/' . $key;
        file_put_contents($file, serialize($value));
        $this->setMTime($key);
    }

    /**
     * Get m time
     *
     * @param $key
     * @return int|mixed
     */
    private function getMTime($key)
    {
        if (array_key_exists($key, $this->m_times)) {
            return $this->m_times[$key];
        }

        return 0;
    }

    /**
     * Set m time
     *
     * @param $key
     * @param $m_time
     */
    private function setMTime($key, $m_time = null)
    {
        if (is_null($m_time)) {
            $m_time = time();
        }

        $this->m_times[$key] = $m_time;
    }

    /**
     * Get dsn
     *
     * @return mixed|null
     */
    public static function getDsn()
    {
        return self::getInstance()->get('dsn');
    }

    /**
     * Set dsn
     *
     * @param $dsn
     */
    public static function setDsn($dsn)
    {
        self::getInstance()->set('dsn', $dsn);
    }

    /**
     * Get dbUsername
     *
     * @return string
     */
    public static function getDbUsername()
    {
        return self::getInstance()->get('dbUsername');
    }

    /**
     * Set dbUsername
     *
     * @param $dbUsername
     */
    public static function setDbUsername($dbUsername)
    {
        self::getInstance()->set('dbUsername', $dbUsername);
    }

    /**
     * Get dbPassword
     *
     * @return string
     */
    public static function getDbPassword()
    {
        return self::getInstance()->get('dbPassword');
    }

    /**
     * Set dbPassword
     *
     * @param $dbPassword
     */
    public static function setDbPassword($dbPassword)
    {
        self::getInstance()->set('dbPassword', $dbPassword);
    }

    /**
     * Get controllerMap
     *
     * @return mixed|null
     */
    public static function getControllerMap()
    {
        return self::getInstance()->get('controllerMap');
    }

    /**
     * Set controllerMap
     *
     * @param ControllerMap $controllerMap
     */
    public static function setControllerMap(ControllerMap $controllerMap)
    {
        self::getInstance()->set('controllerMap', $controllerMap);
    }
}
