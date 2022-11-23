<?php
require_once "TokenValidationDbHelper.php";



class TokenValidationClass
{
    private $data;
    private $db;

    public function __construct($data)
    {
        $this->db = TokenValidationDbHelper::getInstance();
        $this->data = $data;
    }

    public function main()
    {

        $token = $this->data['token'];
        $creationDate = $this->data['creationDate'];

        //get the current date and time and check with the below call if the function is valid and if it has not expired.

        $login = $this->db->validateToken($token, $creationDate);

       return $login;
    }

}