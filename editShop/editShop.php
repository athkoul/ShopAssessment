<?php

/*Example of the json inside the body for the call
 {
    "token":"0f5db394e9bfaaaeb0b6fefece40926f2193b73c",
    "name":"shop name to be edit",
    "editFields":{
        "name": "newName2",
        "city":"newCity3",
        "address":"newAddress3"
    }
  }

 */

require_once "EditShopClass.php";


if ($_SERVER["REQUEST_METHOD"] === "PUT")
{

    $inputData = file_get_contents("php://input");
    $inputData = json_decode($inputData,true);

    $validation = validation($inputData);

    if ($validation['status']==='success')
    {
        validation2($inputData['editFields']);

        $createProcess = new EditShopClass($inputData);
        $result = $createProcess->main();

        if($result === "success")
        {
            http_response_code(200);
            echo " Success Edit" ;
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
    echo json_encode( array( "message" => 'Wrong Request method' ) );
    return;
}

function validation($field_name)
{

    if ( !isset($field_name['token']) || $field_name['token']===''   )
    {
        $validationResults['error'] = 'token attribute is required' ;
    }
    if ( !isset($field_name['name']) || $field_name['name']===''   )
    {
        $validationResults['error1'] = 'name attribute is required' ;
    }
    if ( !isset($field_name['editFields']) || $field_name['editFields']==='' || count($field_name['editFields']) ===0 )
    {
        $validationResults['error2'] = 'edit fields are required' ;
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

function validation2($extraFieldsArray)
{

    $columnsArray = array ('name', 'category', 'description', 'open_hours', 'city', 'address');

    foreach($extraFieldsArray as $item=>$value)
    {
        if(!in_array($item, $columnsArray))
        {
            echo $item." invalid";
            die;
        }
    }

}