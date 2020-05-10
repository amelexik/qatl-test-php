<?php

Class Model
{
    /**
     * Храним екземпляры моделей
     * @var array
     */
    private static $_models = [];
    protected $db;
    protected $table;

    public function __construct()
    {
        $this->db = Qatl::app()->Db;
    }

    public static function model()
    {

        $className = get_called_class();
        if (isset(self::$_models[$className]))
            return self::$_models[$className];
        else {
            $model = self::$_models[$className] = new $className(null);
            return $model;
        }
    }
}