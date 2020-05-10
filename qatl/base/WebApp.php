<?php

/**
 * Class WebApp
 */
Class WebApp extends BaseApp
{
    public $layout = 'main';

    public function __construct($config = null)
    {
        parent::__construct($config);
        Qatl::setApp($this);
    }

    public function run()
    {

        $controllerClass = ucfirst($this->Router->getController()) . 'Controller';
        $controllerMethod = strtolower($this->Router->getMethodPrefix() . $this->Router->getAction());

        $controllerObject = new $controllerClass;
        $this->setController($controllerObject);

        if ($controllerObject instanceof ApiController) {
            return $controllerObject->run();
        }

        if (method_exists($controllerObject, $controllerMethod)) {
            $controllerObject->{$controllerMethod}();
            try {
                $viewObject = new View($controllerObject->getData());
                $viewObject->render();
            } catch (Exception $e) {

            }

        } else {
            throw new Exception('Method ' . $controllerMethod . ' of class ' . $controllerClass . ' does not exist.');
        }
    }

}