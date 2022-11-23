<?php
require_once "RegistrationDbHelper.php";
class RegistrationClass
{
    private $data;
    private $db;

    public function __construct($data)
    {
        $this->db = RegistrationDbHelper::getInstance();
        $this->data = $data;
    }

    public function main()
    {

        $name = $this->data['name'];
        $email = $this->data['email'];
        $password = $this->data['password'];
        $insert = $this->db->insertData($name, $email, $password);

        return $insert;
    }

}