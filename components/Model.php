<?php


namespace components;


abstract class Model
{
    public $pdo = null;
    public $table = '';
    public $fields = [];

    public function __construct() {
        $this->pdo = \components\Db::getInstance()->getPDO();
    }

    public function select($closure = []) {
        $query = 'SELECT * FROM ' . $this->table;

        if (!empty($closure['where']))
            $query .= ' WHERE ' . $closure['where'];
        if (!empty($closure['orderBy']))
            $query .= ' ORDER BY ' . $closure['orderBy'];
        if (!empty($closure['limit']))
            $query .= ' LIMIT ' . $closure['limit'];

        $statement = $this->pdo->prepare($query);
        $statement->execute($closure);
        return $statement->fetchAll();
    }

    public function insert($values = []) {
        if (!$this->validate($values, $this->fields)) {
            return false;
        }

        $query = 'INSERT INTO ' . $this->table . ' (' . implode(', ', array_keys($this->fields)) . ') VALUES (:' . implode(', :', array_keys($this->fields)) . ');';

        $statement = $this->pdo->prepare($query);
        return $statement->execute($values);
    }

    public function countAll() {
        return $this->pdo->query('SELECT COUNT(*) as count FROM ' . $this->table)->fetch()['count'];
    }

    public function validate($value, $rules) {
        foreach ($rules as $key => $rule) {
            if (!isset($value[$key])) {
                continue;
            }

            switch ($rule) {
                case 'text':
                    if (!is_string($value[$key])) {
                        return false;
                    }
                    break;

                case 'int':
                    if (is_numeric($value[$key])) {
                        return false;
                    }
                    break;

                default:
                    throw new \Exception('Неизвестное правило валидации');
            }
        }
        return true;
    }
}