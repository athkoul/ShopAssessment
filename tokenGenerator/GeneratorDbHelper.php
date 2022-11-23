<?php

require_once "../defines.php";

class GeneratorDbHelper
{
    private static $instance = null;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function insertToken($userId, $token, $dateCreated, $dateExpire)
    {
        $conn  = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        if ($conn->connect_error)
        {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "INSERT INTO tokens (owner_id, token, date_created, date_expire)
        VALUES ('$userId','$token','$dateCreated', '$dateExpire')";

        if ($conn->query($sql) === TRUE)
        {
            return "success";
        }
        else
        {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }


    }
}