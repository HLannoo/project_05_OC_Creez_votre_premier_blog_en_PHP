<?php

class connectDB
{
    public static function dbConnect($host = 'localhost', $dbname = 'blog_php', $user = 'root', $pass = '')
    {
        try {
            return new PDO("mysql:host=$host;dbname=$dbname;port=3308", $user, $pass);
        } catch (PDOException $e) {
            print "Erreur : " . $e->getmessage() . "<br/>";
            die;
        }
    }
}