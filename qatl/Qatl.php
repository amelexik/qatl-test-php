<?php

define('DS', DIRECTORY_SEPARATOR);

define('ROOT', dirname(dirname(__FILE__)));
define('QATL_PATH', ROOT . DS . 'qatl');
define('QATL_BASE_PATH', ROOT . DS . 'qatl' . DS . 'base');
define('QATL_COMPONENTS_PATH', ROOT . DS . 'qatl' . DS . 'components');
define('APP_PATH', ROOT . DS . 'app');
define('CONFIG_PATH', ROOT . DS . 'app' . DS . 'config');
define('CONTROLLERS_PATH', ROOT . DS . 'app' . DS . 'controllers');
define('MODEL_PATH', ROOT . DS . 'app' . DS . 'model');
define('VIEWS_PATH', ROOT . DS . 'app' . DS . 'views');
define('LAYOUT_PATH', ROOT . DS . 'app' . DS . 'views' . DS . 'layouts');

Class Qatl
{
    private static $_app;

    /**
     * @param null $config
     * @return WebApp
     */
    public static function createWebApp($config = null)
    {

        return new WebApp($config);
    }

    /**
     * @return mixed
     */
    public static function app()
    {
        return self::$_app;
    }

    /**
     * @param $app
     * @throws Exception
     */
    public static function setApp($app)
    {
        if (!self::$_app)
            self::$_app = $app;
        else
            throw new Exception('App can bee run once!');
    }

    /**
     * @param $class_name
     */
    public static function autoload($class_name)
    {
        $directories = [
            QATL_PATH,
            QATL_BASE_PATH,
            QATL_COMPONENTS_PATH,
            CONTROLLERS_PATH,
            MODEL_PATH
        ];

        foreach ($directories as $directory) {
            if (file_exists($file = $directory . DS . $class_name . '.php')) {
                require_once($file);
                return;
            }
        }
    }
}

spl_autoload_register(['Qatl', 'autoload']);