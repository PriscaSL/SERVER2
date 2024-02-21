<?php
   error_reporting(0);


    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Method: POST');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization,  x-Request-With');

    include ('function.php');


    $requestMethod = $_SERVER["REQUEST_METHOD"] ;

    if ($requestMethod == 'POST'  ){
        $insertion = json_decode(file_get_contents("php://input"), true);
        if(empty($insertion)){
            $medecinInsertion = medecinInsertion($_POST);
        }
        else{
            $medecinInsertion = medecinInsertion($insertion);
        }
        echo $medecinInsertion;
    }
    else{
        $data= [
            'status' => 405,
            'message' => $requestMethod, 'Method not Allowed',
        ];
        header ("HTTP/1.0 405 Method Not Allowed");
        echo json_encode($data);
    }

    ?>  