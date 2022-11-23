<?php

/*Example of the json inside the body for the call
Filter is not mandatory
 {
    "token":"981ff43a1c9cde392f21f48e52eb5d7c1e607553",
    "filter":{
        "city": "Thessal",
        "name": "test Shop4"
    }
 }
 */

require_once "ShowShopClass.php";


if ($_SERVER["REQUEST_METHOD"] === "GET") {


    $inputData = file_get_contents("php://input");
    $inputData = json_decode($inputData, true);

    $showProcess = new showShopClass($inputData);
    $result = $showProcess->main();

    //print_r($result);
}

else
{
    http_response_code(405);
    echo json_encode( array( "message" => 'Wrong Request. method' ) );
    return;
}




