<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('URI', $_SERVER['REQUEST_URI']);

require_once(ROOT.DS.'lib'.DS.'init.php');

Router::getInstance()->parseURL(URI);

echo "<pre>";
print_r('Route: '.Router::getInstance()->getRoute().PHP_EOL);
print_r('Language: '.Router::getInstance()->getLanguage().PHP_EOL);
print_r('Controller: '.Router::getInstance()->getController().PHP_EOL);
print_r('Action to be called: '.Router::getInstance()->getMethodPrefix().Router::getInstance()->getAction().PHP_EOL);
echo "Params: ";
print_r(Router::getInstance()->getParams());