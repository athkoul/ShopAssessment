<?php

require_once "GeneratorClass.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $inputData = file_get_contents("php://input");
    $inputData = json_decode($inputData, true);
    $userId = $inputData['userId'];

    $token = sha1(uniqid(mt_rand(), true));
    $currentDateTime = date("Y-m-d H:i:s");
    $expirationDateTime =$my_date_time = date("Y-m-d H:i:s", strtotime("+1 hours"));

    $data = array("userId"=>$userId, "token"=>$token, "creationDate"=>$currentDateTime, "expirationDate"=>$expirationDateTime);

    $tokenProcess = new GeneratorClass($data);
    $result = $tokenProcess->main();

    if($result === "success")
    {
        print_r($token);
    }
}

else
{
    http_response_code(405);
    echo json_encode( array( "message" => 'Wrong Request. method' ) );
    return;
}


