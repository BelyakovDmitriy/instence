<?php


namespace controllers;
use components\Controller;
use models\Blog;
use models\News;


class IndexController extends Controller
{
    public function actionIndex() {
        $blogModel = new Blog();
        $newsModel = new News();
/*
        echo '<pre>';
        var_dump($newsModel->select([
            'column' => '*',
            'where' => '',
            'orderBy' => 'id ASC',
            'limit' => ''
        ]));
        echo '</pre>';
*/

        $blogContent = $blogModel->getBlogs();
        $newsContent = $newsModel->getNews();
        $this->render('index.tmpl', [
            'news' => $newsContent,
            'blog' => $blogContent
        ]);
    }
}