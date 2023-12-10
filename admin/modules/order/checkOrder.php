<?php
$body = getBody();

$id = $body['id'];


$getOrder = firstRaw("SELECT * FROM `order` WHERE id=".$id);

$getPropertie = firstRaw("SELECT * FROM properties WHERE id=".$getOrder['propertieID']);


$data = [
    'status' => 0,
    'updatedAt' => date('Y-m-d H:i:s')
];
$dataUpdaate = update('order',$data,"id=".$id);
if($dataUpdaate){
    $quantity = [
        'quantity' => $getPropertie['quantity'] - $getOrder['quantity'],
    ];
    update('properties',$quantity,"id=".$getPropertie['id']);
    $response = array(
        'success' => "Xác nhận đơn hàng thành công!", 
    );
}else{
    $response = array(
        'errors' => "Lỗi hệ thống vui lòng thử lại sau!", 
    );
}

$jsonResponse = json_encode($response);
header('Content-Type: application/json');
echo $jsonResponse;

?>