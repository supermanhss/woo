<?php

namespace woo\controller;

use woo\base\register\ApplicationRegister;
use woo\base\register\RequestRegister;
use woo\base\Request;

abstract class PageController
{
    private $request;

    protected $applicationHelper;

    public function __construct()
    {
        $request = RequestRegister::getRequest();
        if (! $request) {
            $request = new Request();
        }

        $this->request = $request;

        $this->applicationHelper = ApplicationHelper::instance();
        $this->applicationHelper->init();
    }

    /**
     * @return Request
     */
    function getRequest()
    {
        return $this->request;
    }

    abstract function process();

    /**
     * @param string $resource
     */
    public function forward($resource)
    {
        include DIR_VIEW . "/$resource";
        exit();
    }
}
