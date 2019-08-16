<?php

header('Content-Type: text/html;charset=utf-8');

defined('DIR_VIEW') or define('DIR_VIEW', __DIR__ . '/view');

require 'autoload.php';
spl_autoload_register(['Loader', 'autoload']);

$venue = new \woo\domain\Venue(null, 'Test venue');

$space = new \woo\domain\Space(null, 'Space one');
$venue->addSpace($space);

$space = new \woo\domain\Space(null, 'Space two');
$venue->addSpace($space);

\woo\domain\ObjectWatcher::instance()->performOperations();
