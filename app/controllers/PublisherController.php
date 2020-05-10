<?php

/**
 * Class PublisherController
 * API Publisher
 */
Class PublisherController extends ApiController
{
    /**
     * List publisher
     * GET /publisher
     */
    public function actionIndex()
    {
        if (!$data = Publisher::model()->getAll())
            return $this->response("Publishers not found", 404);
        return $this->response($data, 200);
    }

    /**
     * View publisher
     * GET /publisher?id=100500
     */
    public function actionView()
    {
        if (!$data = Publisher::model()->getOne($this->id))
            return $this->response("Publisher with id={$this->id} not found", 404);
        return $this->response($data, 200);
    }

    /**
     * Create Publisher
     * POST /publisher?name=ololosh
     */
    public function actionCreate()
    {
        $name = $this->requestParams['name'] ?? '';

        if (empty($name))
            return $this->response('Error, name is required', 500);

        if (!Publisher::model()->add($name))
            $this->response('Database server error', 400);

        return $this->response($name, 200);

    }

    /**
     * Update Publisher
     * PUT /publisher?id=100500&name=ololosh
     */
    public function actionUpdate()
    {
        $name = $this->requestParams['name'] ?? '';

        if (!$this->id || empty($name))
            return $this->response('Check params', 400);

        if (!$item = Publisher::model()->getOne($this->id))
            return $this->response('Publisher not found', 404);

        if (!Publisher::model()->update($this->id, $name))
            return $this->response('Database server error', 500);


        return $this->response('Updated', 200);


    }

    /**
     * Delete Publisher
     * DELETE /publisher?id=10
     */
    public function actionDelete()
    {
        if (!$this->id)
            return $this->response('Id is required', 400);

        if (!$item = Publisher::model()->getOne($this->id)) {
            return $this->response('Publisher not found', 404);
        }
        if (!Publisher::model()->deleteByPk($this->id))
            return $this->response('Database server error', 500);

        return $this->response('Delete successful', 200);

    }


}
