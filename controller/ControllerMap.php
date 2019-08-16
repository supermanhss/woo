<?php

namespace woo\controller;

class ControllerMap
{
    private $viewMap = [];
    private $forwardMap = [];
    private $classRootMap = [];

    public function addView($command, $status, $view)
    {
        $this->viewMap[$command][$status] = $view;
    }

    public function getView($command, $status)
    {
        if (isset($this->viewMap[$command][$status])) {
            return $this->viewMap[$command][$status];
        }

        return null;
    }

    public function addClassRoot($command, $classRoot)
    {
        $this->classRootMap[$command] = $classRoot;
    }

    public function getClassRoot($command)
    {
        if (isset($this->classRootMap[$command])) {
            return $this->classRootMap[$command];
        }

        return $command;
    }

    public function addForward($command, $status, $newCommand)
    {
        $this->forwardMap[$command][$status] = $newCommand;
    }

    public function getForward($command, $status)
    {
        if (isset($this->forwardMap[$command][$status])) {
            return $this->forwardMap[$command][$status];
        }

        return null;
    }
}
