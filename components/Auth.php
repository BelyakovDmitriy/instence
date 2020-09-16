<?php


namespace components;


use components\traits\SingletonTrait;

class Auth
{
    use SingletonTrait;

    public $pdo = null;
    private $auth = false;

    public function init()
    {
        $this->pdo = \components\Db::getInstance()->getPDO();
        return $this->isAuth();
    }

    private function isAuth() {
        if (!isset($_SESSION['id_user_session']))           //  если нет переменной сессии в сессии (открытие сайта)
        {
            $_SESSION['id_user_session'] = null;            //  создаем пустую переменную сессии
            if (isset($_COOKIE['id_user_session']))         //  смотрим есть ли кука с переменной сессии
            {
                if ($this->isAuthCookie($_COOKIE['id_user_session']))   //  если кука есть и подходящая
                {
                    setcookie('id_user_session', $_SESSION['id_user_session'], time() + 3600 * 24 * 2, '/php2/lesson5/'); //  обнвляем куку
                    $this->auth = true;
                }
            } elseif ($this->isAuthForm())                       //  смотрим есть ли попытка аутентификации через форму
                $this->auth = true;
        } elseif (isset($_POST['submit_authentication_exit']))  //  если не первый вход на сайт - смотрим нажата ли кнопка Выйти
            $this->userExit();
        elseif (empty($_SESSION['id_user_session']))         //  переменная сессии пуста (аутентификации нет)
        {
            if ($this->isAuthForm())                             //  смотрим есть ли попытка аутентификации через форму
                $this->auth = true;
        } elseif ($this->isAuthSession())    //  пробуем аутентифицироваться через сессию
            $this->auth = true;
        return $this->auth;
    }
    private function isAuthSession() {
        $this->auth = false;
        if ($_SESSION['user_agent'] == $_SERVER['HTTP_USER_AGENT'])
            $this->auth = true;
        return $this->auth;
    }
    private function isAuthCookie($id_user_session) {

        $query = "SELECT id_users, user_agent FROM users_auth WHERE id_users_session = ':id_user_session';";
        $statement = $this->pdo->prepare($query);
        $statement->execute($id_user_session);
        var_dump($statement);

        $user_agent_db = $user_data[0]['user_agent'];
        //$id_user_db = $user_data[0]['id_users'];

        $_SESSION['user_agent_security'] = security($_SERVER['HTTP_USER_AGENT']);

        if (password_verify($_SESSION['user_agent_security'], $user_agent_db))
        {
            //$_SESSION['id_user'] = $id_user_db;
            $_SESSION['id_user_session'] = $id_user_session_security;
            return true;
        } else
        {
            $this->userExit();
            return false;
        }
    }
    private function isAuthForm()
    {
        $auth = false;
        if ($_POST['submit_authentication'])                                //  Нажата кнопка "Войти"
        {
            if (authentication($_POST['login'], $_POST['password']))
                $auth = true;
        } elseif ($_POST['registration'])                               //  Нажата кнопка "Зарегистрироваться"
        {
            if (user_registration($_POST['login'], $_POST['password']))
                $auth = true;
        }
        return $auth;
    }
    private function userExit()
    {
        $id_user_session = $_SESSION['id_user_session'];
        $sql = "DELETE FROM users_auth WHERE id_users_session = '$id_user_session';";
        dbQuery($sql);

        unset($_SESSION['id_user']);
        $_SESSION['id_user_session'] = '';
        unset($_SESSION['user_agent_security']);
        unset($_SESSION['basket']);

        setcookie('id_user_session', 'false', time() - 3600 * 24 * 2, '/php1/lesson8/');
        unset($_COOKIE['id_user_session']);
    }
}