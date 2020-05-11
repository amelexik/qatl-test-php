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


    /**
     *
     * @param array $ids
     * @return bool
     */
    public function isValidAuthors(array $ids)
    {
        if (!$ids) return false;
        $ids = array_unique(array_values($ids));


        // PDO problem - IN() statement
        // use instruction from https://www.php.net/manual/ru/pdostatement.execute.php
        // "Создаем строку из знаков вопроса (?) в количестве, равном количеству параметров"
        $place_holders = implode(',', array_fill(0, count($ids), '?'));

        $count = (int)$this->db->queryScalar("SELECT COUNT(*) FROM {$this->table} WHERE id IN ({$place_holders})", $ids);

        if (count($ids) === $count)
            return true;

        return false;

    }

}