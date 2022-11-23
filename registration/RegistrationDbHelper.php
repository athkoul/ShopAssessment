<?php

require_once "../defines.php";

class RegistrationDbHelper
{
    private static $instance = null;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function insertData($ownerName, $ownerEmail, $ownerPassword)
    {
        $conn  = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        if ($conn->connect_error)
        {
            die("Connection failed: " . $conn->connect_error);
        }

        //call checkIfEmailExists so that if entry with the same email exists to not continue with the registration
        $this->checkIfEmailExists($conn, $ownerEmail);

        //hash the password to save it to database
        $hashed_password = password_hash($ownerPassword, PASSWORD_DEFAULT);

        $sql = "INSERT INTO owners (name, email, password)
        VALUES ('$ownerName', '$ownerEmail', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            return "success";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }


    private function checkIfEmailExists($conn,$email)
    {

        $sql = "SELECT id
        FROM owners
        WHERE email = '$email'";

        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        if(isset($row))
        {
            http_response_code(203);
            echo "User with email ".$email." exists already";
            die;
        }
    }

}