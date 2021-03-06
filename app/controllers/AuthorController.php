<?php

/**
 * Class AuthorController
 * API author
 */
Class AuthorController extends ApiController
{
    /**
     * List authors
     * GET /author
     */
    public function actionIndex()
    {
        if (!$data = Author::model()->getAll())
            return $this->response("Authors not found", 404);
        return $this->response($data, 200);
    }

    /**
     * View Author
     * GET /author?id=100500
     */
    public function actionView()
    {
        if (!$data = Author::model()->getOne($this->id))
            return $this->response("Author with id={$this->id} not found", 404);
        return $this->response($data, 200);
    }

    /**
     * Create Author
     * POST /author?name=ololosh
     */
    public function actionCreate()
    {
        $name = $this->requestParams['name'] ?? '';

        if (empty($name))
            return $this->response('Error, name is required', 500);

        if (!Author::model()->add($name))
            $this->response('Database server error', 400);

        return $this->response($name, 200);

    }

    /**
     * Update Author
     * PUT /author?id=100500&name=ololosh
     */
    public function actionUpdate()
    {
        $name = $this->requestParams['name'] ?? '';

        if (!$this->id || empty($name))
            return $this->response('Check params', 400);

        if (!$item = Author::model()->getOne($this->id))
            return $this->response('Author not found', 404);

        if (!Author::model()->update($this->id, $name))
            return $this->response('Database server error', 500);


        return $this->response('Updated', 200);


    }

    /**
     * Delete Author
     * DELETE /author?id=10
     */
    public function actionDelete()
    {
        if (!$this->id)
            return $this->response('Id is required', 400);

        if (!$item = Author::model()->getOne($this->id)) {
            return $this->response('Author not found', 404);
        }
        if (!Author::model()->deleteByPk($this->id))
            return $this->response('Database server error', 500);

        return $this->response('Delete successful', 200);

    }


}
