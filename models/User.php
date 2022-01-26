<?php

/**
 *
 *
 */
class User

{
    private $connect;

    function __construct(PDO $connect)
    {
        $this->connect = $connect;
    }

    function connexion($email, $password)
    {
        $check = $this->connect->prepare('SELECT username, email FROM users WHERE email = :email AND password = :password ');
        $check->execute(array(":email" => $email, ":password" => $password));
        return $check->fetch();
    }

    function inscription($email, $password, $username)
    {
        $statement = $this->connect->prepare('SELECT username, email FROM users WHERE username = :username OR email = :email');
        $statement->execute(array("username" => $username, ":email" => $email));
        $result = $statement->rowCount();

        if ($result == 0) {
            $check = $this->connect->prepare('INSERT INTO users(username, password, email) VALUES (:username, :password, :email)');
            $check->execute(array("username" => $username, ":email" => $email, "password" => $password));
            return $check->rowCount();
        } else {
            header("Location: http://project5/users/inscription");
        }
    }
}
