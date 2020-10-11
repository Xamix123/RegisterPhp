<?php

namespace testTask1\app\controllers;

use testTask1\app\models\User;
use testTask1\app\validators\UserDataValidator;
use testTask1\app\view\View;

class UserController
{
    /**
     * @return bool
     */
    public function actionLogin()
    {
        if (! User::isGuest()) {
            header("Location: /home");
        }

        $data['login'] = "";
        $data['password'] = "";
        $errors = [];
        $lockSecondsLeft = 0;

        if (isset($_POST['submit'])) {
            if (! isset($_SESSION['blockTime']) || (!User::getLockSecondsLeft($lockSecondsLeft))) {
                $data['login'] = $_POST['login'];
                $data['password'] = $_POST['password'];
                $userId = User::checkUserData($data['login'], $data['password']);

                if ($userId) {
                    User::auth($userId);
                    header("Location: /home");
                } else {
                    User::failedAuth();
                    $errors = ["Authorization failed"];
                    ;
                }
            } else {
                $errors = ["The limit of authorization attempts has been exceeded,
                 you can try again in $lockSecondsLeft seconds"];
            }
        }

        $view = new View('login');
        $view->assign('errors', $errors);
        echo $view->render();
        return true;
    }

    /**
     * @return bool
     */
    public function actionRegister()
    {
        if (! User::isGuest()) {
            header("Location: /home");
        }

        $data['login'] = '';
        $data['password'] = '';
        $errors = [];

        if (isset($_POST['submit'])) {
            $data['login'] = $_POST['login'];
            $data['password'] = $_POST['password'];

            (new UserDataValidator())->validateData($data, $errors);

            if (empty($errors)) {
                User::register($data['login'], $data['password']);
                $_SESSION['success'] = true;
                header("Location: /");
            }
        }

        $view = new View('register');
        $view->assign('errors', $errors);
        echo $view->render();
        return true;
    }


    public function actionLogout()
    {
        unset($_SESSION["user"]);
        header("Location: /");
    }
}
