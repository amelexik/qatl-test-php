<?php

/**
 * Class BookController
 * API Book
 */
Class BookController extends ApiController
{
    /**
     * List books
     * GET /book
     */
    public function actionIndex()
    {
        if (!$data = Book::model()->getAllWithRelations())
            return $this->response("Books not found", 404);
        return $this->response($data, 200);
    }

    /**
     * View book info
     * GET /book?id=100500
     */
    public function actionView()
    {
        if (!$data = Book::model()->getOneWithRelations($this->id))
            return $this->response("Book with id={$this->id} not found", 404);
        return $this->response($data, 200);
    }

    /**
     * Create Book
     * POST /book?name=YourBookTitle&author=AUTHOR_ID&publisher=PUBLISHER_ID
     * POST /book?name=YourBookTitle&author[]=AUTHOR_ID&author[]=AUTHOR_ID_2&publisher=PUBLISHER_ID
     */
    public function actionCreate()
    {
        $name = $this->requestParams['name'] ?? '';
        $author = $this->requestParams['author'] ?? null;
        $publisher = $this->requestParams['publisher'] ?? null;

        if (empty($name) || !$author || !$publisher)
            return $this->response('Error: name,author,publisher is required', 400);

        if (!is_array($author)) {
            $author = (array)$author;
        }

        // check correct authors array
        if (!Author::model()->isValidAuthors($author)) {
            return $this->response('Authors array is not valid! Please use correct ids!', 400);
        }

        if (!Publisher::model()->getOne($publisher))
            return $this->response('Publisher ID does not exist', 404);

        if (!Book::model()->add($name, $author, $publisher))
            $this->response('Database server error', 400);

        return $this->response($name, 200);

    }


    /**
     * Update Book
     * PUT /book?id=1&name=YourBookTitle&author=AUTHOR_ID&publisher=PUBLISHER_ID
     */
    public function actionUpdate()
    {
        $name = $this->requestParams['name'] ?? '';
        $author = $this->requestParams['author'] ?? null;
        $publisher = $this->requestParams['publisher'] ?? null;

        if (!$this->id)
            return $this->response('Book id is required', 400);

        if (empty($name) && !$author && !$publisher)
            return $this->response('Updated field no passed', 400);

        // check book exist
        if (!$item = Book::model()->getOne($this->id))
            return $this->response('Book not found', 404);

        if (!is_array($author)) {
            $author = (array)$author;
        }

        // check author
        if ($author) {
            // check correct authors array
            if (!Author::model()->isValidAuthors($author)) {
                return $this->response('Authors array is not valid! Please use correct ids!', 400);
            }
        }

        // check publisher
        if ($publisher) {
            if (!Publisher::model()->getOne($publisher))
                return $this->response('Publisher not found', 404);
        }


        if (!Book::model()->update($this->id, $name, $publisher, $author))
            return $this->response('Database server error', 500);

        return $this->response('Updated', 200);

    }

    /**
     * Delete Book
     * DELETE /book?id=10
     */
    public function actionDelete()
    {
        if (!$this->id)
            return $this->response('Id is required', 400);

        if (!$item = Book::model()->getOne($this->id)) {
            return $this->response('Book not found', 404);
        }
        if (!Book::model()->deleteByPk($this->id))
            return $this->response('Database server error', 500);

        return $this->response('Delete successful', 200);

    }


}
