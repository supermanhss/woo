<?php

namespace woo\controller;

use woo\base\register\ApplicationRegister;
use woo\command\Command;

class ApplicationHelper
{
    private static $instance;

    private function __construct() {}

    private function __clone() {}

    public static function instance()
    {
        if (! self::$instance instanceof self) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function init()
    {
        $dsn = ApplicationRegister::getDsn();
        if (is_null($dsn)) {
            $this->getOptions();
        }
    }

    public function getOptions()
    {
        $config = require __DIR__ . '/Config.php';

        if (array_key_exists('dsn', $config)) {
            ApplicationRegister::setDsn($config['dsn']);
        }

        if (array_key_exists('db_username', $config)) {
            ApplicationRegister::setDbUsername($config['db_username']);
        }

        if (array_key_exists('db_password', $config)) {
            ApplicationRegister::setDbPassword($config['db_password']);
        }

        $controllerMap = new ControllerMap();

        if (array_key_exists('controller', $config)) {
            foreach ($config['controller'] as $item) {
                $command = $item['command'];

                $status = 0;
                if (isset($item['status'])) {
                    $status = Command::statuses($item['status']);
                }

                $view = $item['view'];

                $controllerMap->addView($command, $status, $view);

                if (isset($item['forward'])) {

                    $status = 0;
                    if (isset($item['forward']['status'])) {
                        $status = Command::statuses($item['forward']['status']);
                    }

                    $newCommand = $item['forward']['newCommand'];

                    $controllerMap->addForward($command, $status, $newCommand);
                }

                if (isset($item['classRoot'])) {
                    $controllerMap->addClassRoot($command, $item['classRoot']);
                }
            }
        }

        ApplicationRegister::setControllerMap($controllerMap);
    }
}