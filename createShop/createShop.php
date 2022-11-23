<?php

/*Example of the json inside the body for the call
 {
    "token": "0f5db394e9bfaaaeb0b6fefece40926f2193b73c",
    "name":"test ShopFinal",
    "category": "TestCategoryNameFinal",
    "description": "This is a test shop",
    "openHours": "10-17:00",
    "city": "Thessal",
    "address": "dodekaorofes"
   }
 */
require_once "CreateShopClass.php";


if ($_SERVER["REQUEST_METHOD"] === "POST")
{

    $inputData = file_get_contents("php://input");
    $inputData = json_decode($inputData,true);

    //call validation function to validate if the required data are inside the call.
    $validation = validation($inputData);

    if ($validation['status']==='success')
    {
        $createProcess = new CreateShopClass($inputData);
        $result = $createProcess->main();

        if($result === "success")
        {
            http_response_code(200);
            echo "Success Creation of shop" ;
            return;
        }
        else
        {
            http_response_code(203);
            echo $result;
            return;
        }
    }
    else
    {
        http_response_code(203);
        echo json_encode( $validation );
        return;
    }
}

else
{
    http_response_code(405);
    echo json_encode( array( "message" => 'Wrong Request. method' ) );
    return;
}

function validation($field_name)
{
    //$validationResults = array();
    if ( !isset($field_name['token']) || $field_name['token'] ===''  )
    {
        $validationResults['error']= "token attribute is required";
    }
    if ( !isset($field_name['name']) || $field_name['name'] ===''   )
    {
        $validationResults['error1'] = 'email attribute is required' ;
    }
    if ( !isset($field_name['category']) || $field_name['category'] ===''  )
    {
        $validationResults['error3']= "category attribute is required";
    }
    if ( !isset($field_name['description']) || $field_name['description'] ===''  )
    {
        $validationResults['error4']= "description attribute is required";
    }
    if ( !isset($field_name['openHours']) || $field_name['openHours'] ===''  )
    {
        $validationResults['error5']= "Open Hours attribute is required";
    }
    if ( !isset($field_name['city']) || $field_name['city'] ===''  )
    {
        $validationResults['error6']= "city attribute is required";
    }

    if(isset($validationResults))
    {
        $validationResults['status'] = 'fail';
    }
    else
    {
        $validationResults['status'] = 'success';
    }

    return $validationResults;


}