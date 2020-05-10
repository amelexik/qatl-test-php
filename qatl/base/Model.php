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
    protected $pkField = 'id';

    public function __construct()
    {
        $this->db = Qatl::app()->Db;
    }

    /**
     * Get Model instance
     * @return mixed
     */
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

    /**
     * Fetch records
     * @param int $limit
     * @return mixed
     */
    public function getAll($limit = 10)
    {
        $query = "SELECT * FROM {$this->table} LIMIT 0,{$limit}";
        return $this->db->queryAll($query);
    }


    /**
     * Get One Row
     * @param $id
     * @return mixed
     */
    public function getOne($id)
    {
        $query = "SELECT * FROM {$this->table} where {$this->pkField}=:id";
        return $this->db->queryRow($query, [':id' => $id]);
    }


    /**
     * Delete One Row
     * @param $id
     * @return mixed
     */
    public function deleteByPk($id)
    {
        return $this->db->execute("DELETE FROM {$this->table} WHERE {$this->pkField} = :id", [':id' => $id]);
    }

}