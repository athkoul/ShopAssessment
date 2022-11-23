<?php
require_once "ShowShopDbHelper.php";
require_once "../tokenDefines.php";

class ShowShopClass
{
    private $data;
    private $db;

    public function __construct($data)
    {
        $this->db = ShowShopDbHelper::getInstance();
        $this->data = $data;
    }

    public function main()
    {

        $token = (isset($this->data['token'])) ? $this->data['token'] : '';

        //if there are filter inside the call use the relevant function to create an array with the filters
        if(isset($this->data['filter']) && count($this->data['filter']) > 0)
        {
            $filterFields = $this->checkFilters($this->data['filter']);
        }
        else
        {
         $filterFields = 0;
        }

        //if the token is empty consider the call by guest
        //if the token exists consider the call by user.

        if($token === '')
        {
            $shops = $this->db->showShopUser($filterFields);
        }
        else
        {
            $tokenInfo =json_encode( array("token"=>$token));

            //use curl function to call the tokenValidation api to check if the token is valid
            //if the validation is success get as return from validation the userId
            $validityToken = $this->curl($tokenInfo);
            if($validityToken !== 'fail')
            {
                $shops = $this->db->showShopOwner($validityToken, $filterFields);
            }
            else
            {
                return "Invalid Token";
            }

        }
        return $shops;

    }

    public function checkFilters($filters)
    {
        foreach($filters as $filter=>$filter_value)
        {
            $filterArray[$filter]= $filter_value;
        }
        return $filterArray;
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