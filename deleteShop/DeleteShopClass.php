<?php

require_once "DeleteShopDbHelper.php";
require_once "../tokenDefines.php";

class DeleteShopClass
{
    private $data;
    private $db;

    public function __construct($data)
    {
        $this->db = DeleteShopDbHelper::getInstance();
        $this->data = $data;
    }


    public function main()
    {
        $token = $this->data['token'];
        $name = $this->data['name'];
        $tokenInfo =json_encode( array("token"=>$token));

        //use curl function to call the tokenValidation api to check if the token is valid
        //if the validation is success get as return from validation the userId
        $validityToken = $this->curl($tokenInfo);

        if($validityToken !== 'fail')
        {
            $insert = $this->db->deleteShop($name, $validityToken);
            return $insert;
        }
        else
        {
            return "Invalid Token";
        }

    }

    public function curl($data)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => TOKEN_VALIDATION_API_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 11,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err)
        {
            return "cURL Error #:" . $err;
        }
        else
        {
            return $response;
        }
    }

}
