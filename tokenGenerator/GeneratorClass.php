<?php
require_once "GeneratorDbHelper.php";



class GeneratorClass
{
    private $data;
    private $db;

    public function __construct($data)
    {
        $this->db = GeneratorDbHelper::getInstance();
        $this->data = $data;
    }

    public function main()
    {

        $token = $this->data['token'];
        $creationDate = $this->data['creationDate'];
        $expirationDate = $this->data['expirationDate'];
        $userId = $this->data['userId'];

        $login = $this->db->insertToken($userId, $token, $creationDate, $expirationDate);

        if ($login === 'success')
        {
            return $login;

        }
        else
        {
            echo "error in login.";
        }
    }

}