<?php 

require '../connexion/dbconn.php';

//ERROR
function error($message){
    $data= [
        'status' => 404,
        'message' => $message,
        
    ];
    header ("HTTP/1.0 404  Error");
    echo  json_encode($data);
    exit();
}

//CREATE
function medecinInsertion($medecinInput){
    global  $conn;

    $nom = mysqli_real_escape_string($conn, $medecinInput[ 'nom' ]);
    $nbjrs = mysqli_real_escape_string($conn, $medecinInput[ 'nbjrs' ]);
    $tauxjournalier = mysqli_real_escape_string($conn, $medecinInput[ 'tauxjournalier' ]);

    if(empty(trim($nom))){
        return error('enter your name');

    }elseif(empty(trim($nbjrs))){
        return error('enter  nb jrs');

    }elseif(empty(trim($tauxjournalier))){
        return error('enter  taux journalier ');

    }else{
        $query = "INSERT INTO medecin (nom, nbjrs, tauxjournalier) VALUES ( '$nom', '$nbjrs', '$tauxjournalier' )";
        $result = mysqli_query($conn, $query);

        if($result){

            $data= [
                'status' => 201,
                'message' => 'Inserted successfully',
            ];
            header ("HTTP/1.0 201 success");
            return json_encode($data);
        


        }else{

            $data= [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header ("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        
        }
    }
}

//READ
function getMedecinList(){
            global  $conn;
            
            $query = "SELECT * FROM medecin";
            $query_run  =  mysqli_query($conn, $query);
 
        if ($query_run){
                 if(mysqli_num_rows($query_run)>0){

                    $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
                    $data= [
                        'status' => 200,
                        'message' => 'Customer read successfully',
                        'data' => $res
                    ];
                    header ("HTTP/1.0 200 success");
                    return json_encode($data);


                 }else{
                    $data= [
                        'status' => 404,
                        'message' => 'No Medecin Found',
                    ];
                    header ("HTTP/1.0 404 No Medecin Found");
                    return json_encode($data);
                }
        }
                
        else{
                $data= [
                    'status' => 500,
                    'message' => 'Internal Server Error',
                ];
                header ("HTTP/1.0 500 Internal Server Error");
                return json_encode($data);
            }
}

//SELECT A SPECIFIC ID
function getMedecin($medecinParam){
    global $conn;

    if($medecinParam['id'] == null ){
        return error('enter a specific Id');

    }
    $medecinId  =  mysqli_real_escape_string($conn, $medecinParam['id']);
    
    $query = "SELECT * FROM medecin WHERE id= '$medecinId' LIMIT 1";
    $result = mysqli_query($conn,  $query);

    if($result){
        if(mysqli_num_rows($result) == 1){

            $res = mysqli_fetch_assoc($result); 
            $data= [
                'status' => 200,
                'message' => 'Trouver avec succes',
                'data' => $res
            ];
            header ("HTTP/1.0 200 succes ");
            return json_encode($data);


        }else{
            $data= [
                'status' => 404,
                'message' => 'Id qui ne se trouve pas dans la liste',
            ];
            header ("HTTP/1.0 404 donnée qui n'existe pas");
            return json_encode($data);
            
        }



    }else{
        $data= [
            'status' => 500,
            'message' => ' Erreur lié au Serveur',
        ];
        header ("HTTP/1.0 500 Erreur lié au Serveur");
        return json_encode($data);
        
    }

    
}

//UPDATE
function medecinUpdate($medecinInput, $medecinParam){
    global  $conn;

    if(!isset($medecinParam['id'])){
        return error('aucun Id n  est spécifié ');

    }elseif($medecinParam['id'] == null ){
        return error('entrer l Id');
    }

    $medecinId = mysqli_real_escape_string($conn, $medecinParam['id']);

    $nom = mysqli_real_escape_string($conn, $medecinInput[ 'nom' ]);
    $nbjrs = mysqli_real_escape_string($conn, $medecinInput[ 'nbjrs' ]);
    $tauxjournalier = mysqli_real_escape_string($conn, $medecinInput[ 'tauxjournalier' ]);

    if(empty(trim($nom))){
        return error('enter your name');

    }elseif(empty(trim($nbjrs))){
        return error('enter  nb jrs');

    }elseif(empty(trim($tauxjournalier))){
        return error('enter  taux journalier ');

    }else{

        $query = "UPDATE medecin SET  nom= '$nom', nbjrs= '$nbjrs', tauxjournalier= '$tauxjournalier' WHERE id= '$medecinId' ";
        $result = mysqli_query($conn, $query);

        if($result){

            $data= [
                'status' => 201,
                'message' => 'Updated successfully',
            ];
            header ("HTTP/1.0 201 success");
            return json_encode($data);
        


        }else{

            $data= [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header ("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        
        }
    }
}

//DELETE
function medecinDelete($medecinParam){
    global $conn;

    if(!isset($medecinParam['id'])){
        return error('aucun Id n  est spécifié ');

    }elseif($medecinParam['id'] == null ){
        return error('entrer un Id different de 0 ');
    }

    $medecinId = mysqli_real_escape_string($conn, $medecinParam['id']);

    $query = "DELETE FROM medecin WHERE  id='$medecinId' ";
    $result = mysqli_query($conn, $query);

    if($result){
        $data= [
            'status' => 200,
            'message' => 'Supprimer avec succes',
        ];
        header ("HTTP/1.0 200 success");
        return json_encode($data);

    }else{
        $data= [
            'status' => 404,
            'message' => 'aucun élément trouvé',
        ];
        header ("HTTP/1.0 404 erreur");
        return json_encode($data);
    }
}
?>