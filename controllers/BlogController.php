<?php


namespace controllers;
use components\Controller;
use models\Blog;


class BlogController extends Controller
{
    public function actionIndex() {
        $blogModel = new Blog();
        $articles = $blogModel->getBlogs();
        $this->render('blog.tmpl', $articles);
    }
    public function actionView() {
        echo 'Смотрим блог';
    }
    public function actionAdd() {
        if (!empty($_POST)) {
            $blogModel = new Blog();
            $blogModel->insert($_POST);
        }
        echo '
        <form method="post" action="/php2/lesson6/public/blog/add">
            <input type="text" name="title">
            <input type="text" name="content">
            <input type="submit">
        </form>';
    }
}