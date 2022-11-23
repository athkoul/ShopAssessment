<?php

require_once "../defines.php";

class LoginDbHelper
{
    private static $instance = null;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function loginProcess($ownerEmail, $ownerPassword)
    {
        $conn  = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        if ($conn->connect_error)
        {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT id, password
        FROM owners
        WHERE email = '$ownerEmail' 
        ";

        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        if(isset($row))
        {
            //check the password as it is saved in database as hash
            if (password_verify($ownerPassword, $row['password']))
            {
                $ownerId = $row['id'];
                return $ownerId;
            }
        }

        return "fail";
    }

}