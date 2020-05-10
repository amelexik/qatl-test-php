<?php

/**
 * Class ApiController
 */
abstract class ApiController extends Controller
{

    /**
     * @var array
     */
    public $requestUri = []; //GET|POST|PUT|DELETE
    /**
     * @var array
     */
    public $requestParams = [];
    /**
     * @var string
     */
    protected $method = '';
    /**
     * @var mixed
     */
    protected $id;

    /**
     * @var string
     */
    protected $action = '';


    /**
     * ApiController constructor.
     * @throws Exception
     */
    public function __construct()
    {
        header("Content-Type: application/json");

        $this->requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $this->requestParams = $_REQUEST;

        if (isset($_REQUEST['id'])) {
            $this->id = filter_var($_REQUEST['id'], FILTER_VALIDATE_INT);
        }

        $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            } else {
                throw new Exception("Unexpected Header");
            }
        }
    }

    /**
     * @return mixed
     */
    public function run()
    {
        $this->action = $this->getAction();

        if (method_exists($this, $this->action)) {
            return $this->{$this->action}();
        } else {
            throw new RuntimeException('Invalid Method', 405);
        }
    }

    /**
     * @return string|null
     */
    protected function getAction()
    {
        $method = $this->method;
        switch ($method) {
            case 'GET':
                if ($this->id) {
                    return 'actionView';
                } else {
                    return 'actionIndex';
                }
                break;
            case 'POST':
                return 'actionCreate';
                break;
            case 'PUT':
                return 'actionUpdate';
                break;
            case 'DELETE':
                return 'actionDelete';
                break;
            default:
                return null;
        }
    }

    /**
     * @param $data
     * @param int $status
     */
    protected function response($data, $status = 500)
    {
        header("HTTP/1.1 " . $status . " " . $this->requestStatus($status));
        echo json_encode($data);
    }

    /**
     * @param $code
     * @return mixed
     */
    private function requestStatus($code)
    {
        $status = array(
            200 => 'OK',
            400 => 'Bad request',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );
        return ($status[$code]) ? $status[$code] : $status[500];
    }

    /**
     * @return mixed
     */
    abstract protected function actionIndex();

    /**
     * @return mixed
     */
    abstract protected function actionView();

    /**
     * @return mixed
     */
    abstract protected function actionCreate();

    /**
     * @return mixed
     */
    abstract protected function actionUpdate();

    /**
     * @return mixed
     */
    abstract protected function actionDelete();

}