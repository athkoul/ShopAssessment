<?php

require_once "../defines.php";

class CreateShopDbHelper
{
    private static $instance = null;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function insertShop($ownerId, $shopName, $shopCategory, $shopDescription, $shopOpenHours, $shopCity, $shopAddress)
    {
        $conn  = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        if ($conn->connect_error)
        {
            die("Connection failed: " . $conn->connect_error);
        }

        //firstly insert the category in shop_categories and acquire the id of the entry to use it for the insert to shops.
        $sql = "INSERT INTO shop_categories (name)
        VALUES ('$shopCategory')";
        $conn->query($sql);

        $sql2 = "SELECT id
        FROM shop_categories
        WHERE name = '$shopCategory'";

        $result = $conn->query($sql2);
        $row = $result->fetch_assoc();

        $categoryId = $row['id'];

        $sql3 = "INSERT INTO shops (name, owner, category, description, open_hours, city, address)
        VALUES ('$shopName','$ownerId', '$categoryId', '$shopDescription','$shopOpenHours', '$shopCity', '$shopAddress')";

        if ($conn->query($sql3) === TRUE) {
            return "success";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }


    }
}