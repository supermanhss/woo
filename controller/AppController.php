<?php

namespace woo\controller;

use woo\base\Request;
use woo\command\Command;
use woo\command\DefaultCommand;

class AppController
{
    private static $base_command;
    private static $default_command;
    private $controllerMap;
    private $invoked = [];

    public function __construct(ControllerMap $controllerMap)
    {
        $this->controllerMap = $controllerMap;
        if (! self::$base_command) {
            self::$base_command = new \ReflectionClass("woo\\command\\Command");
            self::$default_command = new DefaultCommand();
        }
    }

    /**
     * @param Request $request
     * @return string
     */
    public function getView(Request $request)
    {
        $view = $this->getResource($request, 'View');

        return $view;
    }

    /**
     * @param Request $request
     * @return string
     */
    public function getFroward(Request $request)
    {
        $forward = $this->getResource($request, 'Forward');
        if ($forward) {
            $request->addData('cmd', $forward);
        }

        return $forward;
    }

    private function getResource(Request $request, $res)
    {
        $cmd = $request->getData('cmd');

        $lastCommand = $request->getLastCommand();

        $status = 0;
        if ($lastCommand) {
            $status = $lastCommand->getStatus();
        }

        $action = "get$res";

        $resource = $this->controllerMap->$action($cmd, $status);
        if ($resource) {
            return $resource;
        }

        $resource = $this->controllerMap->$action($cmd, 0);
        if ($resource) {
            return $resource;
        }

        $resource = $this->controllerMap->$action('default', $status);
        if ($resource) {
            return $resource;
        }

        $resource = $this->controllerMap->$action('default', 0);
        if ($resource) {
            return $resource;
        }

        return null;
    }

    /**
     * @param Request $request
     * @return Command
     */
    public function getCommand(Request $request)
    {
        $previous = $request->getLastCommand();
        if (! $previous) {
            $cmd = $request->getData('cmd');
            if (! $cmd) {
                $request->addData('cmd', 'Default');
                return self::$default_command;
            }
        } else {
            $cmd = $this->getFroward($request);
            if (! $cmd) {
                return null;
            }
        }

        $cmd_obj = $this->resolveCommand($cmd);

        $cmd_class_name = get_class($cmd_obj);
        if (isset($this->invoked[$cmd_class_name])) {
            exit("circular forwarding");
        }

        $this->invoked[$cmd_class_name] = 1;

        return $cmd_obj;
    }

    /**
     * @param $cmd
     * @return Command|Object
     * @throws
     */
    public function resolveCommand($cmd)
    {
        $classRoot = $this->controllerMap->getClassRoot($cmd);

        $className = "woo\\command\\" . $classRoot . "Command";
        if (class_exists($className)) {
            $cmd_class = new \ReflectionClass($className);
            if ($cmd_class->isSubclassOf(self::$base_command)) {
                return $cmd_class->newInstance();
            }
        }

        return null;
    }
}