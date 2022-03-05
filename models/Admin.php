<?php

/**
 *
 *
 */
class Admin

{
    private $connect;

    function __construct(PDO $connect)
    {
        $this->connect = $connect;
    }

    function getAdmins()
    {
        $stmt = $this->connect->prepare("SELECT id, username ,ft_image, created_at, role  FROM users");
        $stmt->execute();
        $displayAdmin=$stmt->fetchall();
        return $displayAdmin;

    }
    function valAdmin($id)
    {
        $stmt=$this->connect->prepare("UPDATE users SET role = 2 WHERE id='$id'");
        $stmt->execute();

    }

    function denAdmin($id)
    {
        $stmt=$this->connect->prepare("UPDATE users SET role = 3 WHERE id='$id'");
        $stmt->execute();
    }

    function suprAdmin($id)
    {
        $stmt = $this->connect->prepare("DELETE FROM users WHERE id='$id'");
        $stmt->execute();
        $delAdmin=$stmt->fetch();
        return $delAdmin;
    }

}
