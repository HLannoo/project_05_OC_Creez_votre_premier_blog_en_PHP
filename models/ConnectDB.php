<?php

class ConnectDB
{

    private static $instance = null ;

    public static function dbConnect()

    {
        if (self::$instance === null)
        {
               $filename = require APP_DIRECTORY . 'config/config_db.php';
               self::$instance = new PDO(
                   "mysql:host=$filename[0];
                   dbname=$filename[1];
                   port=$filename[2]",
                   $filename[3],
                   $filename[4]);

            }
        return self::$instance;
    }
}
