<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

require_once(ROOT.DS.'lib'.DS.'init.php');

Router::getInstance($_SERVER['REQUEST_URI']);

echo "<pre>";
print_r('Route: '.Router::getRoute().PHP_EOL);
print_r('Language: '.Router::getLanguage().PHP_EOL);
print_r('Controller: '.Router::getController().PHP_EOL);
print_r('Action to be called: '.Router::getMethodPrefix().Router::getAction().PHP_EOL);
echo "Params: ";
print_r(Router::getParams());