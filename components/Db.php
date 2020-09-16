<?php


namespace components;


class Db
{
    use \components\traits\SingletonTrait;

    private $pdo = null;
    private $dbConfig = null;

    public function init() {
        $this->dbConfig = Config::getInstance()->getConfig();
        $this->getPDO();
    }
    public function getPDO() {
        if (empty($this->pdo)) {
            $this->pdo = new \PDO(
                "mysql:host={$this->dbConfig['host']};dbname={$this->dbConfig['dbName']};charset={$this->dbConfig['charset']}",
                $this->dbConfig['user'],
                $this->dbConfig['pass'],
                $this->dbConfig['options']
            );
        }
        return $this->pdo;
    }
}