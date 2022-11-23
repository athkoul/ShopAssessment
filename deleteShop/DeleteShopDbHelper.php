<?php

require_once "../defines.php";

class DeleteShopDbHelper
{
    private static $instance = null;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function deleteShop($shopName,$ownerId)
    {
        $conn  = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        if ($conn->connect_error)
        {
            die("Connection failed: " . $conn->connect_error);
        }

        //Delete from shops table the relevant entry using the shop name and verify that the user that uses the call and the token is the owner.
        $sql = "DELETE FROM shops 
        WHERE name='$shopName'
        AND owner ='$ownerId'";
        $conn->query($sql);

        echo "affected shops: ".$conn->affected_rows;

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