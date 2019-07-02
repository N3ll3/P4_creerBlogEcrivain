<?php

namespace Model;

use Model\Manager;

class AdminManager extends Manager
{
    protected $db;

    public function  __construct()
    {
        $this->db = $this->dbConnect();
    }

    public function registerUser($userName, $password, $email)
    { }

    public function getPassword($userName)
    {
        $reqUser = $this->db->prepare(
            'SELECT psw, username 
            FROM users 
            WHERE username = :username'
        );
        $reqUser->execute(['username' => $userName]);
        $password = $reqUser->fetch();
        return $password;
    }


    public function updatePasswordUser($newPassword, $userName)
    {
        $userData = $this->db->prepare(
            'UPDATE users
            SET psw = :new_password
            WHERE username=:username'
        );

        $userData->execute(
            [
                'userName' => $userName,
                'new_password' => $passwordHashed,
            ]
        );
        $userData->closeCursor();
    }
}
