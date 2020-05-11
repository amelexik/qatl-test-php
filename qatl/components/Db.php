<?php

/**
 * Component DB
 */
Class Db extends Component
{
    public $host;
    public $user;
    public $password;
    public $db;

    private $_handler;

    public function __construct($config)
    {
        parent::__construct($config);

        try {
            $this->_handler =
                new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db, $this->user, $this->password, array(PDO::ATTR_PERSISTENT => true));
            $this->_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->_handler->exec("set names utf8");
        } catch (PDOException $e) {
            $this->close();
            throw new Exception($e->getMessage(), E_USER_ERROR);
        }
    }

    // Удаление екземпляра соеденения
    public function close()
    {
        $this->_handler = null;
    }

    /**
     * @param $sqlQuery
     * @param null $params
     * @return bool
     * @throws Exception
     */
    public function execute($sqlQuery, $params = null)
    {
        try {
            $handler = $this->getHandler();
            $result = $handler->prepare($sqlQuery)->execute($params);
            return $result;
        } catch (PDOException $e) {
            $this->close();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @return PDO
     */
    public function getHandler()
    {
        return $this->_handler;
    }

    /**
     * @param $sqlQuery
     * @param null $params
     * @param int $fetchStyle
     * @return array|null
     * @throws Exception
     */
    public function queryAll($sqlQuery, $params = null, $fetchStyle = PDO::FETCH_ASSOC)
    {
        $result = null;
        try {
            $handler = $this->getHandler();
            $source = $handler->prepare($sqlQuery);
            $source->execute($params);
            $result = $source->fetchAll($fetchStyle);
            return $result;
        } catch (PDOException $e) {
            $this->close();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param $sqlQuery
     * @param null $params
     * @param int $fetchStyle
     * @return mixed|null
     * @throws Exception
     */
    public function queryRow($sqlQuery, $params = null, $fetchStyle = PDO::FETCH_ASSOC)
    {
        $result = null;
        try {
            $handler = $this->getHandler();
            $source = $handler->prepare($sqlQuery);
            $source->execute($params);
            $result = $source->fetch($fetchStyle);
            return $result;
        } catch (PDOException $e) {
            $this->close();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param $sqlQuery
     * @param null $params
     * @return null
     * @throws Exception
     */
    public function queryScalar($sqlQuery, $params = null)
    {
        $result = null;
        try {
            $handler = $this->getHandler();
            $source = $handler->prepare($sqlQuery);
            $source->execute($params);
            $result = $source->fetch();
            return isset($result[0]) ? $result[0] : null;
        } catch (PDOException $e) {
            $this->close();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Last Insert Id
     * @return string
     * @throws Exception
     */
    public function getLastInsertId(){
        try {
            $handler = $this->getHandler();
            return $handler->lastInsertId();
        } catch (PDOException $e) {
            $this->close();
            throw new Exception($e->getMessage());
        }
    }

}