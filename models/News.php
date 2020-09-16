<?php


namespace models;
use components\Model;

class News extends Model
{
        public $table = 'news';
        public $fields = [
            'title' => 'Заголовок новости 1',
            'content' => 'Текст новости 1',
            'views' => 2
        ];
    public function getNews() {
        return $this->select();
    }
}