<?php


namespace controllers;
use components\Controller;
use models\News;


class NewsController extends Controller
{
    public function actionIndex() {
        $newsModel = new News();
        $article = $newsModel->getNews();
        $this->render('news.tmpl', $article);
    }
    public function actionView() {
        echo 'Смотрим новости';
    }
}