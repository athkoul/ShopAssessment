<?php

/*Example of the json inside the body for the call
 {
    "token":"0f5db394e9bfaaaeb0b6fefece40926f2193b73"
  }
 */

require_once "TokenValidationClass.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $inputData = file_get_contents("php://input");
    $inputData = json_decode($inputData, true);


    $token = $inputData['token'];
    $currentDateTime = date("Y-m-d H:i:s");

    $data = array("token"=>$token, "creationDate"=>$currentDateTime);

    $tokenValidator = new TokenValidationClass($data);
    $result = $tokenValidator->main();

    echo $result;
}

else
{
    http_response_code(405);
    echo json_encode( array( "message" => 'Wrong Request. method' ) );
    return;
}
