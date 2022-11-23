<?php

/*Example of the json inside the body for the call
 {
     "email":"Test34email@mplampla.gr",
     "password":"12345"
 }
 */

require_once "LoginClass.php";


if ($_SERVER["REQUEST_METHOD"] === "POST")
{

    $inputData = file_get_contents("php://input");
    $inputData = json_decode($inputData,true);

    //call validation function to validate if the required data are inside the call.
    $validation = validation($inputData);

    if ($validation['status']==='success')
    {
        $loginProcess = new LoginClass($inputData);
        $result = $loginProcess->main();

        if($result["status"] === "success")
        {
            http_response_code(200);
            // echo json_encode( array( "message" => $result ) );
            echo json_encode($result) ;
            return;
        }
        else
        {
            http_response_code(203);
            echo json_encode( $result );
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

    if ( !isset($field_name['email']) || $field_name['email']===''   )
    {
        $validationResults['error'] = 'email attribute is required' ;
    }
    if ( !isset($field_name['password']) || $field_name['password'] ===''   )
    {
        $validationResults['error3']= "password attribute is required";
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