<?php

/**
 * Class Request
 */
Class Request extends Component
{

    /**
     * Request constructor.
     * @param $config
     */
    public function __construct($config)
    {
        parent::__construct($config);

        // normalize request
        if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
            if (isset($_GET))
                $_GET = $this->stripSlashes($_GET);
            if (isset($_POST))
                $_POST = $this->stripSlashes($_POST);
            if (isset($_REQUEST))
                $_REQUEST = $this->stripSlashes($_REQUEST);
            if (isset($_COOKIE))
                $_COOKIE = $this->stripSlashes($_COOKIE);
        }
    }

    /**
     * @param $data
     * @return array|string
     */
    public function stripSlashes(&$data)
    {
        return is_array($data) ? array_map(array($this, 'stripSlashes'), $data) : stripslashes($data);
    }

    /**
     * @param $name
     * @param null $defaultValue
     * @return null
     */
    public function getParam($name, $defaultValue = null)
    {
        return isset($_GET[$name]) ? $_GET[$name] : (isset($_POST[$name]) ? $_POST[$name] : $defaultValue);
    }

    /**
     * @param $name
     * @param null $defaultValue
     * @return null
     */
    public function getPost($name, $defaultValue = null)
    {
        return isset($_POST[$name]) ? $_POST[$name] : $defaultValue;
    }
}