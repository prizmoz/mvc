<?php

class Router{

    protected static $_instance = null;

    private static $uri;

    private static $controller;

    private static $action;

    private static $params;

    private static $route;

    private static $method_prefix;

    private static $language;


    private function __clone() {}
    private function __construct() {}

    /**
     * @return mixed
     */
    public static function getUri()
    {
        return self::$uri;
    }

    /**
     * @return mixed
     */
    public static function getController()
    {
        return self::$controller;
    }

    /**
     * @return mixed
     */
    public static function getAction()
    {
        return self::$action;
    }

    /**
     * @return mixed
     */
    public static function getParams()
    {
        return self::$params;
    }

    /**
     * @return mixed
     */
    public static function getRoute()
    {
        return self::$route;
    }

    /**
     * @return mixed
     */
    public static function getMethodPrefix()
    {
        return self::$method_prefix;
    }

    /**
     * @return mixed
     */
    public static function getLanguage()
    {
        return self::$language;
    }


    public static function getInstance($uri){
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        
        self::$uri = urldecode(trim($uri, '/'));

        // Get defaults
        $routes = Config::get('routes');
        self::$route = Config::get('default_route');
        self::$method_prefix = isset($routes[self::$route]) ? $routes[self::$route] : '';
        self::$language = Config::get('default_language');
        self::$controller = Config::get('default_controller');
        self::$action = Config::get('default_action');

        $uri_parts = explode('?', self::$uri);

        // Get path like /lng/controller/action/param1/param2/.../...
        $path = $uri_parts[0];

        $path_parts = explode('/', $path);

        if ( count($path_parts) ){

            // Get route or language at first element
            if ( in_array(strtolower(current($path_parts)), array_keys($routes)) ){
                self::$route = strtolower(current($path_parts));
                self::$method_prefix = isset($routes[self::$route]) ? $routes[self::$route] : '';
                array_shift($path_parts);
            } elseif ( in_array(strtolower(current($path_parts)), Config::get('languages')) ){
                self::$language = strtolower(current($path_parts));
                array_shift($path_parts);
            }
            // Get controller - next element of array
            if ( current($path_parts) ){
                self::$controller = strtolower(current($path_parts));
                array_shift($path_parts);
            }
            // Get action
            if ( current($path_parts) ){
                self::$action = strtolower(current($path_parts));
                array_shift($path_parts);
            }

            // Get params - all the rest
            self::$params = $path_parts;

        }

    }

}