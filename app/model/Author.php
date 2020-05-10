<?php

/**
 * Class Services
 */
Class Author extends Model
{
    var $table = 'author';

    /**
     * Add author
     * @param $name
     * @return mixed
     */
    public function add($name)
    {
        $query = "INSERT INTO {$this->table} (name) VALUES (:name)";
        $params = [
            ':name' => $name,
        ];
        return $this->db->execute($query, $params);
    }

    /**
     * Update Author
     * @param $id
     * @param $name
     * @return mixed
     */
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