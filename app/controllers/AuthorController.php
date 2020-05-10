<?php

Class AuthorController extends ApiController
{
    public function actionIndex()
    {
        if ($data = Author::model()->getData()) {
            return $this->response($data, 200);
        }
        return $this->response("Authors not found", 404);
    }

    public function actionView()
    {
        if ($data = Author::model()->getByPk($this->id)) {
            return $this->response($data, 200);
        }
        return $this->response("Author with id={$this->id} not found", 404);
    }

    public function actionCreate()
    {
        if ($name = $this->requestParams['name'] ?? '') {
            if (Author::model()->add($name)) {
                return $this->response($name, 201);
            } else {
                return $this->response('Error add', 500);
            }
        }
        return $this->response('Error, name is required', 500);
    }

    public function actionUpdate()
    {
        $name = $this->requestParams['name'] ?? '';

        if (!$this->id || empty($name))
            return $this->response('Check params', 400);

        if (!$item = Author::model()->getByPk($this->id))
            return $this->response('Author not found', 404);

        if (!Author::model()->update($this->id, $name))
            return $this->response('Server error', 500);


        return $this->response('Updated', 204);


    }

    public function actionDelete()
    {
        if ($this->id) {
            if ($item = Author::model()->getByPk($this->id)) {
                if (Author::model()->deleteByPk($this->id)) {
                    return $this->response('Delete successful', 204);
                } else {
                    return $this->response('Error', 500);
                }
            }
            return $this->response('Author not found', 404);
        }
        return $this->response('Id is required', 400);
    }
}
