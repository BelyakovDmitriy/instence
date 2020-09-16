<?php


namespace components;


class Controller
{
    public function render($view, $params = []) {
        echo "Будет отрисован шаблон $view, с параметрами: ";
        echo '<pre>';
        var_dump($params);
        echo '</pre>';
    }
}