<?php

namespace woo\base;

use woo\base\register\RequestRegister;
use woo\command\Command;

class Request
{
    private $data = [];
    private $feedback = [];

    public function __construct()
    {
        $this->init();
        RequestRegister::setRequest($this);
    }

    public function init()
    {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            $this->data = $_REQUEST;
        }

        if (isset($_SERVER['argv'])) {
            foreach ($_SERVER['argv'] as $argv) {
                if (strrpos($argv, '=') !== false) {
                    $argv_array = explode('=', $argv);

                    $this->addData($argv_array[0], $argv_array[1]);
                }
            }
        }
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function getData($key)
    {
        return array_key_exists($key, $this->data) ? $this->data[$key] : null;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addData($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * @param $msg
     */
    public function addFeedback($msg)
    {
        $this->feedback[] = $msg;
    }

    /**
     * @return array
     */
    public function getFeedback()
    {
        return $this->feedback;
    }

    /**
     * @param string $separator
     * @return string
     */
    public function getFeedbackString($separator = "\n")
    {
        return implode($separator, $this->feedback);
    }

    /**
     * @return Command
     */
    public function getLastCommand()
    {
        return $this->getData('lastCommand');
    }

    /**
     * @param Command $lastCommand
     */
    public function setLastCommand(Command $lastCommand)
    {
        $this->addData('lastCommand', $lastCommand);
    }
}
