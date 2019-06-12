<?php
namespace Model;

use Model\Manager;

class AdminManager extends Manager
{

    public function registerUser($userName, $psw, $email)
    {
        $pswHashed = password_hash($psw, PASSWORD_DEFAULT);
        $db = $this->dbConnect();
        $userData = $db->prepare('INSERT INTO users(username, psw, email) VALUES(:userName, :psw, :email)');
        $userData->execute(array('userName' => $userName, 'psw' => $pswHashed, 'email' => $email));

        // $db->closeCursor();
    }

    public function getAllUsers()
    {
        $db = $this->dbConnect();
        $reqUsers = $db->query('SELECT * FROM users');

        return $reqUsers;
    }

    public function getUser($userName)
    {
        $db = $this->dbConnect();
        $userData = $db->prepare('SELECT * FROM users WHERE username = :userName');
        $userData->execute(array('name' => $userName));
        $user = $userData->fetch();

        return $user;
    }

    public function getPsw($userName)
    {
        $db = $this->dbConnect();
        $reqUser = $db->prepare('SELECT psw, username FROM users WHERE username = :username');
        $reqUser->execute(array('username' => $userName));
        $psw = $reqUser->fetch();
        return $psw;
    }

    public function updateEmailUser($emailChanged, $userName)
    { }

    public function updatePswUser($newPsw, $userName)
    { }
}
