<?php

class connectDB
{

    private static $instance = null ;

    public static function dbConnect()

    {
        if (self::$instance === null)
        {
            try {
               $filename = require APP_DIRECTORY . 'config/config_db.php';
               self::$instance = new PDO(
                   "mysql:host=$filename[0];
                   dbname=$filename[1];
                   port=$filename[2]",
                   $filename[3],
                   $filename[4]);
            } catch (PDOException $e) {
                $display = "Erreur : " . $e->getmessage() . "<br/>";
                print_r($display);
                die;
            }
        }
        return self::$instance;

    }
}
