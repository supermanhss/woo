<?php

namespace woo\command;

use woo\base\Request;

abstract class Command
{
    const COM_DEFAULT = 0;
    const CMD_OK = 1;
    const CMD_ERROR = 2;
    const CMD_INSUFFICIENT_DATA = 3;

    private $status = 0;

    private static $STATUS_STRINGS = [
        'CMD_DEFAULT' => 0,
        'CMD_OK' => 1,
        'CMD_ERROR' => 2,
        'CMD_INSUFFICIENT_DATA' => 3,
    ];

    final public function __construct() {}

    /**
     * 执行命令
     *
     * @param Request $request
     */
    public function execute(Request $request)
    {
        $this->status = $this->doExecute($request);
        $request->setLastCommand($this);
    }

    /**
     * 执行命令的具体实现
     *
     * @param Request $request
     * @return int
     */
    abstract public function doExecute(Request $request);

    /**
     * 状态列表
     *
     * @param null $status_str
     * @return array|mixed
     */
    public static function statuses($status_str = null)
    {
        if ($status_str && array_key_exists($status_str, self::$STATUS_STRINGS)) {
            return self::$STATUS_STRINGS[$status_str];
        }

        return self::$STATUS_STRINGS;
    }

    public function getStatus()
    {
        return $this->status;
    }
}