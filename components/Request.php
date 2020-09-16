<?php


namespace components;


class Request
{
    protected $controller = 'index';
    protected $action = 'index';
    protected $controllerNamespace = 'controllers';

    public function init() {
        $url = $_SERVER['REQUEST_URI'];
        $path = explode('/', $url);
        $count = 4;

        /*echo '<pre>';
        var_dump($path);
        echo '</pre>';*/

        switch (count($path)) {
            case $count + 2:
                $this->controller = $path[$count];
                if (!empty($path[$count + 1]))
                    $this->action = $path[$count + 1];
                break;
            case $count+1:
                if (!empty($path[$count]))
                    $this->controller = $path[$count];
                break;
        }

        $classController = $this->controllerNamespace . '\\' . ucfirst($this->controller) . 'Controller';
        //var_dump($classController);

        $action = 'action' . ucfirst($this->action);
        //var_dump($action);

        if (class_exists($classController)) {
            $instanceController = new $classController;
            if (method_exists($instanceController, $action)) {
                call_user_func_array([$instanceController, $action], []);
            }
        }
    }
}