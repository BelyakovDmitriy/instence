<?php


namespace components;


use components\traits\SingletonTrait;

class Config
{
    use SingletonTrait;

    private $dbConfig = [
        'host'      =>  'localhost',
        'user'      =>  'dmitriy',
        'pass'      =>  'dmitriy',
        'dbName'    =>  'php2lesson6',
        'charset'   =>  'utf8',
        'options'   =>  [
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC, // по умолчанию ассоциативный массив
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION // ошибки бросают исключения
        ]
    ];

    public function getConfig() {
        return $this->dbConfig;
    }
}