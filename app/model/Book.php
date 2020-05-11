<?php

/**
 * Model Of Books
 * Class Book
 */
Class Book extends Model
{
    var $table = 'book';

    /**
     * Get Books With Author And Publisher
     * @param int $limit
     * @return mixed
     */
    public function getAllWithRelations($limit = 10)
    {
        $sql = "SELECT b.id,
        b.name,
        p.name               as publisher,
        GROUP_CONCAT(a.name) as authors
            from book b
        LEFT JOIN publisher p on b.publisher_id = p.id
        LEFT JOIN link_book_author lba on b.id = lba.book_id
        LEFT JOIN author a on lba.author_id = a.id
        GROUP BY b.id";
        return $this->db->queryAll($sql);

    }

    /**
     * Get One Book With Author And Publisher
     * @param $id
     * @return mixed
     */
    public function getOneWithRelations($id)
    {
        $sql = "SELECT b.id,
        b.name,
        p.name               as publisher,
        GROUP_CONCAT(a.name) as authors
            from book b
        LEFT JOIN publisher p on b.publisher_id = p.id
        LEFT JOIN link_book_author lba on b.id = lba.book_id
        LEFT JOIN author a on lba.author_id = a.id
        WHERE b.id=:id
        GROUP BY b.id";
        return $this->db->queryRow($sql, [':id' => $id]);

    }

    /**
     * Add new book
     * @param $name
     * @param array $author
     * @param $publisher
     * @return mixed
     */
    public function add($name, array $author, $publisher)
    {
        // todo USE TRANSACTION
        $query = "INSERT INTO {$this->table} (name,publisher_id) VALUES (:name,:publisher)";
        if ($this->db->execute($query, [':name' => $name, ':publisher' => $publisher])) {
            if ($bookId = $this->db->getLastInsertId()) {
                // link authors to book
                foreach ($author as $authorId) {
                    $query = "INSERT INTO link_book_author (book_id,author_id) VALUES (:book_id,:author_id)";
                    $this->db->execute($query, [':book_id' => $bookId, ':author_id' => $authorId]);
                }
            }
            return true;
        }
        return false;
    }


    /**
     * Update Book
     * @param $id
     * @param $name
     * @param array $author
     * @param $publisher
     * @return bool
     */
    public function update($id, $name, $publisher, array $author)
    {
        if (!$name && !$author && !$publisher)
            return false;

        $needUpdateBase = $name || $publisher;
        $needUpdateAuthor = !empty($author);



        if ($needUpdateBase) {
            $params = [
                ':id' => $id
            ];

            $query = "UPDATE {$this->table}";
            if ($name) {
                $query .= " set name=:name ";
                $params[':name'] = $name;
            }else{
                $query .= " set name=name ";
            }

            if ($publisher) {
                $query .= ", publisher_id=:publisher";
                $params[':publisher'] = $publisher;
            }else{
                $query .= ", publisher_id=publisher_id";
            }

            $query .= " WHERE id=:id";

            $this->db->execute($query, $params);

        }

        if ($needUpdateAuthor) {
            //unlink authors
            $this->db->execute("DELETE FROM link_book_author WHERE book_id=:book_id",[':book_id'=>$id]);
            foreach ($author as $authorId) {
                $query = "INSERT INTO link_book_author (book_id,author_id) VALUES (:book_id,:author_id)";
                $this->db->execute($query, [':book_id' => $id, ':author_id' => $authorId]);
            }
        }
    }

}