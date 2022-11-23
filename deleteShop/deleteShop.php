<?php

/*Example of the json inside the body for the call

 {
    "token": "0f5db394e9bfaaaeb0b6fefece40926f2193b73c",
    "name": "Shop name value"
  }

 */

require_once "DeleteShopClass.php";


if ($_SERVER["REQUEST_METHOD"] === "DELETE")
{

    $inputData = file_get_contents("php://input");
    $inputData = json_decode($inputData,true);

    //call validation function to validate if the required data are inside the call.
    $validation = validation($inputData);

    if ($validation['status']==='success')
    {

        $createProcess = new DeleteShopClass($inputData);
        $result = $createProcess->main();
        if($result === "success")
        {
            http_response_code(200);
            echo " Success Request" ;
            return;
        }
        elseif($result === "invalid token")
        {
            http_response_code(203);
            echo "invalid token";
            return;
        }
        else
            {
                http_response_code(203);
                json_encode( $result );
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
    if ( !isset($field_name['token']) || $field_name['token']===''   )
    {
        $validationResults['error'] = 'token attribute is required' ;
    }
    if ( !isset($field_name['name']) || $field_name['name']===''   )
    {
        $validationResults['error'] = 'name attribute is required' ;
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