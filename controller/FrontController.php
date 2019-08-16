<?php

namespace woo\controller;

use woo\base\register\ApplicationRegister;
use woo\base\Request;

class FrontController
{
    private $applicationHelper;

    private function __construct() {}

    public static function run()
    {
        $instance = new self();
        $instance->init();
        $instance->handleRequest();
    }

    public function init()
    {
        $this->applicationHelper = ApplicationHelper::instance();
        $this->applicationHelper->init();
    }

    public function handleRequest()
    {
        $request = new Request();
        $app_controller = new AppController(ApplicationRegister::getControllerMap());

        while ($cmd_object = $app_controller->getCommand($request)) {
            $cmd_object->execute($request);
        }

        $this->invokeView($app_controller->getView($request));
    }

    public function invokeView($target)
    {
        include (DIR_VIEW . "/$target.php");
    }
}
