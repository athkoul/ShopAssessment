<?php

require_once "../defines.php";

class TokenValidationDbHelper
{
    private static $instance = null;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function validateToken($token, $dateCreated)
    {
        $conn  = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        if ($conn->connect_error)
        {
            die("Connection failed: " . $conn->connect_error);
        }

        //query to check if the token is inside the table and it has not expired.
        $sql = "SELECT owner_id
        FROM tokens
        WHERE token = '$token'
        AND date_expire  > '$dateCreated'
        ";

        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        return isset($row)  ?  $row['owner_id'] : "fail";
    }

}