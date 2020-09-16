<?php


namespace components;


class App
{
    use \components\traits\SingletonTrait;

    public $request = null;
    public $auth = null;
    public $db = null;

    public function init() {
        $this->db = Db::getInstance();

        $this->auth = Auth::getInstance();
        //$this->auth = $auth->isAuth();

        $this->request =new Request();
        $this->request->init();
    }
}