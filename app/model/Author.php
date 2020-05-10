<?php

/**
 * Class Services
 */
Class Author extends Model
{
    var $table = 'author';

    /**
     * Get latest records
     * @param int $limit
     * @return mixed
     */
    public function getData($limit = 10)
    {
        $query = "SELECT * FROM {$this->table} LIMIT 0,{$limit}";
        return $this->db->queryAll($query);
    }

    public function getByPk($pk)
    {
        $query = "SELECT * FROM {$this->table} where id={$pk}";
        return $this->db->queryRow($query);
    }

    public function add($name)
    {
        $query = "INSERT INTO {$this->table} (name) VALUES (:name)";
        $params = [
            ':name' => $name,
        ];
        return $this->db->execute($query, $params);
    }

    public function deleteByPk($id)
    {
        return $this->db->execute("DELETE FROM {$this->table} WHERE id = :id", [':id' => $id]);
    }

    public function update($id, $name)
    {
        $query = "UPDATE {$this->table} SET name=:name WHERE id=:id";
        $params = [
            ':id'   => $id,
            ':name' => $name,
        ];
        return $this->db->execute($query, $params);
    }

}