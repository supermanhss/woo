<?php

namespace woo\tests;

require_once __DIR__ . '/../vendor/autoload.php';

defined('ROOT_PATH') or define('ROOT_PATH', dirname(__DIR__) . '/');

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use PHPUnit\Framework\TestCase;

class StackTest extends TestCase
{
    public function testPushAndApp()
    {
        $stack = [];
        $this->assertEquals(0, count($stack));

        array_push($stack, 'foo');

        $this->log()->error('hello', $stack);

        $this->assertEquals('foo', $stack[count($stack) - 1]);
        $this->assertEquals(1, count($stack));

        $this->assertEquals('foo', array_pop($stack));
        $this->assertEquals(0, count($stack));
    }

    /**
     * @return Logger
     * @throws \Exception
     */
    public function log()
    {
        $log = new Logger('Tester');
        $log->pushHandler(new StreamHandler(ROOT_PATH . 'storage/logs/app.log', Logger::WARNING));

        $log->error('error');
        return $log;
    }
}
