<?php

namespace testTask1\app\validators;

use testTask1\app\models\User;

class UserDataValidator
{
    /**
     * @param string $login
     * @return bool
     */
    private static function checkLogin($login)
    {
        return (strlen($login)>= 6) && preg_match("/^(|[0-9A-Za-z\s]+)$/iu", $login);
    }

    /**
     * Validate password
     *
     * @param string $password
     *
     * @return bool
     */
    private static function checkPassword($password)
    {
        return strlen($password) >= 8;
    }

    /**
     * @param array $data
     * @param array $errors
     * example data
     * data {
     *  'login' => exampleLogin,
     *  'password' => examplePass,
     * }
     */
    public static function validateData($data, &$errors)
    {
        if (!UserDataValidator::checkLogin($data['login'])) {
            $errors[] = 'Login is not valid. 
            It must contain more than 6 characters or numbers and not contain special characters';
        }

        if (!UserDataValidator::checkPassword($data['password'])) {
            $errors[] = 'Password is not valid. It must contain more than 8 characters';
        }

        if (User::checkLoginExists($data['login'])) {
            $errors[] = 'User with this login is already registered';
        }
    }
}
