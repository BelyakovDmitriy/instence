<?php


namespace models;
use components\Model;

class Blog extends Model
{
    public $table = 'blogs';
    public $fields = [
        'title' => 'text',
        'content' => 'text'
    ];

    public function getBlogs() {
        return $this->select();
    }
}