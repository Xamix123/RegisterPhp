<?php

namespace testTask1\app\models;

use Carbon\Carbon;
use PDO;
use testTask1\app\components\Db;

class User
{
    /**
     * @param int $id
     *
     * @return mixed
     */
    public static function getUserById($id)
    {
        if ($id) {
            $db = Db::getConnection();
            $sql = "SELECT * FROM users WHERE id = :id";

            $result = $db->prepare($sql);
            $result->bindParam(':id', $id, PDO::PARAM_INT);

            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result->execute();

            return $result->fetch();
        }
    }

    /**
     * @param string $login
     * @param string $password
     *
     * @return false|int
     */
    public static function checkUserData($login, $password)
    {
        $result  = false;
        $db = DB::getConnection();

        $sql = "SELECT * FROM users where login = :login";

        $request = $db->prepare($sql);
        $request->bindParam(":login", $login, PDO::PARAM_STR);
        $request->execute();

        $user = $request->fetch();
        if ($user) {
            $result = password_verify($password, $user['password'])
                ? $user['id']
                : false;
        }

        return $result;
    }


    /**
     * check if login contains in user table
     *
     * @param string $login
     *
     * @return bool
     */
    public static function checkLoginExists($login)
    {
        $db = Db::getConnection();
        $sql = 'SELECT COUNT(*) FROM users WHERE login = :login';

        $result = $db->prepare($sql);
        $result->bindParam(':login', $login, PDO::PARAM_STR);
        $result->execute();

        return $result->fetchColumn()
            ? true
            : false;
    }

    /**
     * @param string $login
     * @param string $password
     *
     * @return bool
     */
    public static function register($login, $password)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $db = DB::getConnection();

        $sql = "INSERT INTO users(login, password) "
            . "VALUES (:login, :password)";

        $result = $db->prepare($sql);
        $result->bindParam(':login', $login, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);

        return $result->execute();
    }

    /**
     * put user into the session
     *
     * @param int $userId
     */
    public static function auth($userId)
    {
        $_SESSION['user'] = $userId;

        if (isset($_SESSION['countFail'])) {
            unset($_SESSION['countFail']);
        }
    }

    public static function failedAuth()
    {
        if (! isset($_SESSION['blockTime'])) {
            User::countFail();
        }
    }

    /**
     * counting the number of authorization attempts
     */
    private static function countFail()
    {
        $_SESSION['countFail'] = ! isset($_SESSION['countFail'])
            ? 1
            : $_SESSION['countFail'] + 1;

        //if count == 3 add time blocking in session. And removes the number of unsuccessful login attempts
        if ($_SESSION['countFail'] == 3) {
            $blockTime = new Carbon();
            $blockTime->addMinutes(5);

            //Time blocking = current time + 5 minutes
            $_SESSION['blockTime'] = $blockTime->toDateTimeString();

            unset($_SESSION["countFail"]);
        }
    }

    /**
     * get diff in seconds between current and block time
     * @param int $locSecondsLeft
     * @return int
     */
    public static function getLockSecondsLeft(int &$locSecondsLeft)
    {
        $current = new Carbon();
        $locSecondsLeft = $current->diffInSeconds($_SESSION['blockTime']);

        if ($current->gt($_SESSION['blockTime'])) {
            $locSecondsLeft = 0;
            unset($_SESSION['blockTime']);
        }

        return $locSecondsLeft;
    }

    /**
     * checks if the user is in the session
     *
     * @return mixed
     */
    public static function checkLogged()
    {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        header("Location: /");
    }

    /**
     * @return bool
     */
    public static function isGuest()
    {
        $result = true;
        if (isset($_SESSION['user'])) {
            $result = false;
        }

        return $result;
    }
}
