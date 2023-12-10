<?php
    $body = getBody();

    $id = $body['id'];

    $getproperties = firstRaw("SELECT * FROM properties WHERE id=".$id);

    $quanity = $getproperties['quantity'];
    if($quanity <= 0){
        $response = array(
       
            'errors' => true
        );
    }else{
        $response = array(
            'success' => true,
         
        );
    }
   
    $jsonResponse = json_encode($response);
    header('Content-Type: application/json');
    echo $jsonResponse;
?>