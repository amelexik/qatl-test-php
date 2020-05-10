<?php

Class BaseApp
{

    private $_components;
    private $_params;
    private $_controller;

    /**
     * BaseApp constructor.
     * @param $config
     */
    public function __construct($config)
    {
        if (is_string($config))
            $config = require $config;

        if (isset($config['components']) && is_array($config['components']) && !empty($config['components'])) {
            foreach ($config['components'] as $component => $componentConfig) {
                $this->_components[$component] = $this->createComponent($component, $componentConfig);
            }
        }
        if (isset($config['params']) && is_array($config['params']) && !empty($config['params'])) {
            foreach ($config['params'] as $key => $value) {
                $this->_params[$key] = $value;
            }
        }
    }

    /**
     * @param $component
     * @param $componentConfig
     * @return mixed
     */
    public function createComponent($component, $componentConfig)
    {
        return new $component($componentConfig);
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->_controller;
    }

    /**
     * @param $object
     */
    protected function setController($object)
    {
        if (!$this->_controller)
            $this->_controller = $object;
    }

    /**
     * @param $name
     * @param string $defaultValue
     * @return string
     */
    public function getParam($name, $defaultValue = '')
    {
        if (isset($this->_params[$name]))
            return !empty($this->_params[$name]) ? $this->_params[$name] : $defaultValue;
        return $defaultValue;
    }

    public function __get($name)
    {
        if (isset($this->_components[$name]))
            return $this->_components[$name];
        elseif (isset($this->{$name}))
            return $this->{$name};
        return null;
    }

    public function end()
    {
        die();
    }

    public function redirect($url)
    {
        header('location: ' . $url);
        die();
    }
}