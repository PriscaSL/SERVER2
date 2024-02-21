<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Method: GET');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization,  x-Request-With');

    include ('function.php');


    $requestMethod = $_SERVER["REQUEST_METHOD"];

    if ($requestMethod == "GET"){

        if(isset($_GET['id'])){
            $medecin = getMedecin($_GET);
            echo $medecin; 

        }else{
            $medecinList = getMedecinList();
            echo $medecinList;
    
        }

      
    }else{
        $data= [
            'status' => 405,
            'message' => $requestMethod. ' Method not Allowed',
        ];
        header ("HTTP/1.0 405  Method Not Allowed");
        echo json_encode($data);
    }

?>