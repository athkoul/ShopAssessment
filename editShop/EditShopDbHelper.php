<?php

require_once "../defines.php";

class EditShopDbHelper
{
    private static $instance = null;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function editShop($shopName, $fieldsToChangeArray, $ownerId)
    {
        $conn  = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        if ($conn->connect_error)
        {
            die("Connection failed: " . $conn->connect_error);
        }

        //Check if shop to be edited exists by calling checkIfShopExists by using the shop name and the owner id to assure the shop is from this specific owner.
        //and avoid owners deleting others shops by mistake. Also get the category id for next step if category needs to be changed.
        $findIfShopExistsCategory = $this->checkIfShopExists($shopName, $ownerId, $conn);

        if(isset($fieldsToChangeArray['category']))
        {
            $newCategoryId = $this->changeCategoryName($fieldsToChangeArray['category'], $conn);
            $fieldsToChangeArray['category'] = $newCategoryId;
        }

        //the below block is used to create the sql query dynamically because the number of edits can be different in each call.
        $helpString='';
        $numItems = count($fieldsToChangeArray);

        $i = 0;
        foreach ($fieldsToChangeArray as $fieldName=>$value){
            $i++;
            if ($i !== $numItems)
            {
                $helpString .= $fieldName."='".$value."',";
            }
            else
            {
                $helpString .= $fieldName."='".$value."'";
            }
        }

        $sql = "UPDATE shops 
        SET $helpString
        WHERE name = '$shopName'";

        $conn->query($sql);

        echo "affected rows: ".$conn->affected_rows;


        if ($conn->query($sql) === TRUE) {
            return "success";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }


    private function checkIfShopExists($name, $id, $conn)
    {
        $sql = "SELECT id
        FROM shops
        WHERE name = '$name'
        AND owner = '$id'";

        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        if(isset($row))
        {
            return "success";
        }
        else
        {
         http_response_code(203);
         echo "Shop with name ".$name." does not exists";
         die;
        }
    }

    private function changeCategoryName($categoryName, $conn)
    {

        $sql = "SELECT id
        FROM shop_categories
        WHERE name = '$categoryName'";

        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        return $row['id'];

    }


}