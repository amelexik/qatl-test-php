<?php

class Router extends Component
{
    public $defaultController = 'site';
    public $defaultAction = 'index';

    protected $_uri;

    protected $_controller;

    protected $_action;

    protected $_params;

    protected $_methodPrefix = 'action';

    public function __construct($config)
    {
        parent::__construct($config);
        $this->_uri = urldecode(trim($_SERVER['REQUEST_URI'], '/'));

        // Get defaults
        $this->_controller = $this->defaultController;
        $this->_action = $this->defaultAction;

        $uri_parts = explode('?', $this->_uri);

        // controller/action/param1/param2/.../...
        $path = $uri_parts[0];

        $path_parts = explode('/', $path);

        if (count($path_parts)) {
            // Get controller - next element of array
            if (current($path_parts)) {
                $this->_controller = strtolower(current($path_parts));
                array_shift($path_parts);
            }
            // Get action
            if (current($path_parts)) {
                $this->_action = strtolower(current($path_parts));
                array_shift($path_parts);
            }

            // Get params - all the rest
            $this->_params = $path_parts;

        }

    }

    public static function redirect($location)
    {
        header("Location: $location");
        die();
    }

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->_uri;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->_controller;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->_action;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->_params;
    }

    /**
     * @return mixed
     */
    public function getMethodPrefix()
    {
        return $this->_methodPrefix;
    }

}