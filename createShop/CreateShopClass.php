<?php

require_once "CreateShopDbHelper.php";
require_once "../tokenDefines.php";

class CreateShopClass
{
    private $data;
    private $db;

    public function __construct($data)
    {
        $this->db = CreateShopDbHelper::getInstance();
        $this->data = $data;
    }


    public function main()
    {
        $token = $this->data['token'];
        $name = $this->data['name'];
        $category = $this->data['category'];
        $description = $this->data['description'];
        $openHours = $this->data['openHours'];
        $city = $this->data['city'];
        $address = (isset($this->data['address'])) ? $this->data['address'] : '';
        $tokenInfo =json_encode( array("token"=>$token));

        //use curl function to call the tokenValidation api to check if the token is valid
        //if the validation is success get as return from validation the userId
        $validityToken = $this->curl($tokenInfo);

        if($validityToken !== 'fail'){

        $insert = $this->db->insertShop($validityToken,$name, $category, $description, $openHours, $city, $address);

        return $insert;
        }
        else
        {

         return "Invalid Token";
        }




    }

    public function curl($data)
    {
        //echo "deutero";

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
        //echo "etoimo to curl";
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        //print_r($response);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            //print_r($response);
            //echo "the above is the response from curl";
            return $response;

        }
    }

}
