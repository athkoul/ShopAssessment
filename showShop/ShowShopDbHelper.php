<?php

require_once "../defines.php";

class ShowShopDbHelper
{
    private static $instance = null;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function showShopUser($filterArray)
    {
        $conn  = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        if ($conn->connect_error)
        {
            die("Connection failed: " . $conn->connect_error);
        }

        //the below block is used to create the sql query filter part dynamically as the number of filters is not the same each call
        //the call to filtersArray complete the process
        $helpString='';

        if($filterArray !== 0)
        {
            $helpString = ' WHERE ';
            $helpString = $this->filtersArray($filterArray, $helpString);
        }

        $sql = "SELECT *
        FROM shops
        $helpString";

        $connection = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($connection))
        {
            $theCategoryName = $this->getCategoryName($row['category'], $conn);
            echo "<tr>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $theCategoryName. "</td>";
            echo "<td>" . $row['description'] . "</td>";
            echo "<td>" . $row['open_hours'] . "</td>";
            echo "<td>" . $row['city'] . "</td>";
            echo "</tr>";
        }

        return $connection->num_rows > 0 ? "success" : array();
    }

    public function showShopOwner($ownerId, $filterArray)
    {
        $conn  = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        if ($conn->connect_error)
        {
            die("Connection failed: " . $conn->connect_error);
        }



        //the below block is used to create the sql query filter part dynamically as the number of filters is not the same each call
        //the call to filtersArray complete the process
        $helpString='';

        if($filterArray !== 0)
        {
            $helpString = ' AND ';
            $helpString = $this->filtersArray($filterArray, $helpString);
        }

        //show only the shops that is from the relevant owner, and if there are filter consider those as well.
        $sql = "SELECT *
        FROM shops
        WHERE owner = $ownerId
        $helpString";

        $connection = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($connection))
        {
            $theCategoryName = $this->getCategoryName($row['category'], $conn);
            echo "<tr>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $theCategoryName. "</td>";
            echo "<td>" . $row['description'] . "</td>";
            echo "<td>" . $row['open_hours'] . "</td>";
            echo "<td>" . $row['city'] . "</td>";
            echo "</tr>";
        }

        return $connection->num_rows > 0 ? "success" : array();
    }

    private function filtersArray($filters, $helpString)
    {

        $numItems = count($filters);

        $i = 0;
        foreach ($filters as $filter=>$value)
        {
            $i++;
            if ($i !== $numItems)
            {
                $helpString .= $filter."='".$value."' AND ";
            }
            else
            {
                $helpString .= $filter."='".$value."'";
            }
        }
        return $helpString;
    }

    private function getCategoryName($categoryId, $conn)
    {
        $sql = "SELECT name
        FROM shop_categories
        WHERE id = $categoryId
        LIMIT 1";

        $connection = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($connection);

        return $row['name'] ;

    }


}