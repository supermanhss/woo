<?php

use woo\view\ViewHelper;

$request = ViewHelper::getRequest();

$venue_data = $request->getData('venue_data');

echo '<pre>';
print_r($venue_data);