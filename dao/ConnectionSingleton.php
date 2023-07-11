<?php

class ConnectionSingleton {

    private static $instance;    

    public static function getInstance() {

        $dbname = "vuejs_notes";
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpassword = "";
        
        if(self::$instance === null) {
            try {
                self::$instance = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpassword);                
            }
            catch(PDOException $e) {
                die($e->getMessage());
            }            
        }
        return self::$instance;

    }

}