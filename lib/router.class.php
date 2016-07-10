<?php
class Router{
    protected static $_instance = null;
    protected $uri;
    protected $controller;
    protected $action;
    protected $params;
    protected $route;
    protected $method_prefix;
    protected $language;

    private function __clone() {}
    private function __construct() {}

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param mixed $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param mixed $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param mixed $route
     */
    public function setRoute($route)
    {
        $this->route = $route;
    }

    /**
     * @return mixed
     */
    public function getMethodPrefix()
    {
        return $this->method_prefix;
    }

    /**
     * @param mixed $method_prefix
     */
    public function setMethodPrefix($method_prefix)
    {
        $this->method_prefix = $method_prefix;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param mixed $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
            return self::$_instance;
        } else {
            return self::$_instance;
        }
    }
    
    public function parseURL($uri)
    {
        self::$_instance->setUri(urldecode(trim($uri, '/')));
        // Get defaults
        $routes = Config::get('routes');
        self::$_instance->setRoute(Config::get('default_route'));
        self::$_instance->setMethodPrefix(isset($routes[self::$_instance->getRoute()]) ? $routes[self::$_instance->getRoute()] : '');
        self::$_instance->setLanguage(Config::get('default_language'));
        self::$_instance->setController(Config::get('default_controller'));
        self::$_instance->setAction(Config::get('default_action'));
        $uri_parts = explode('?', self::$_instance->getUri());
        // Get path like /lng/controller/action/param1/param2/.../...
        $path = $uri_parts[0];
        $path_parts = explode('/', $path);
        if ( count($path_parts) ){
            // Get route or language at first element
            if ( in_array(strtolower(current($path_parts)), array_keys($routes)) ){
                self::$_instance->setRout(strtolower(current($path_parts)));
                self::$_instance->setMethodPrefix(isset($routes[self::$_instance->getRoute()]) ? $routes[self::$_instance->getRoute()] : '');
                array_shift($path_parts);
            } elseif ( in_array(strtolower(current($path_parts)), Config::get('languages')) ){
                self::$_instance->setLanguage(strtolower(current($path_parts)));
                array_shift($path_parts);
            }
            // Get controller - next element of array
            if ( current($path_parts) ){
                self::$_instance->setController(strtolower(current($path_parts)));
                array_shift($path_parts);
            }
            // Get action
            if ( current($path_parts) ){
                self::$_instance->setAction(strtolower(current($path_parts)));
                array_shift($path_parts);
            }
            // Get params - all the rest
            self::$_instance->setParams($path_parts);
        }
    }
}