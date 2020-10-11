<?php

namespace testTask1\app\controllers;

use testTask1\app\models\User;
use testTask1\app\view\View;

class SiteController
{
    public function actionHome()
    {
        $userId = User::checkLogged();
        $user = User::getUserById($userId);

        $view = new View('home');
        $view->assign('login', $user['login']);

        echo $view->render();
        return true;
    }
}
