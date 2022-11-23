<?php
require_once "LoginDbHelper.php";
require_once "../tokenDefines.php";



class LoginClass
{
    private $data;
    private $db;

    public function __construct($data)
    {
        $this->db = LoginDbHelper::getInstance();
        $this->data = $data;
    }

    public function main()
    {

        $email = $this->data['email'];
        $password = $this->data['password'];

        $login = $this->db->loginProcess($email, $password);

        if($login !== 'fail')
        {
            $userIdArray = array('userId'=>$login);
            $userIdJson = json_encode($userIdArray);

            //use curl function to call the tokenGeneraton api to create the token for this specific user
            $toke = $this->curl($userIdJson);
            $result = array ("status"=>"success","token"=>$toke);
            return($result);
        }

        else
        {
            $result = array ("status"=>"fail", "message"=>"wrong email or password");
            return($result);
        }
    }

    public function curl($userId)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => TOKEN_GENERATOR_API_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 11,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $userId
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