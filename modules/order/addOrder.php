<?php
$body = getBody();

$sessionCart = getSession('cart');

$tongtien = getSession('tongtien');

   


$maGiaoDich = 'MGd'.rand(000,99999).'jG'.rand(0000,99999);

$idClient = isLoginClient()['clientID'];
foreach($sessionCart as $item){
    $productID = $item['productID'];
    $propertieID = $item['propertieID'];
    $clientID  = $item['clientID'];
    $tong = 0;
    if($item['sale'] == ''){
        $tong = $item['price'] * $item['quantity'];
    }else{
        $tong = $item['sale'] * $item['quantity'];
    }

    $maSanPham = 'MsG'.rand(000,99999).'sD'.rand(0000,99999);

    $dataOrder = [
        'productID' => $productID,
        'clientID' => $clientID,
        'propertieID' => $propertieID   ,
        'total' => $tong,
        'quantity' => $item['quantity'],
        'maDonHang' => $maSanPham,
        'createdAt' => date('Y-m-d H:i:s')
    ];
    
    $getAlProperties = firstRaw("SELECT * FROM properties WHERE id=".$propertieID);

    $countQuantity =  $getAlProperties['quantity'] ;

   


    if($countQuantity <0){
        $dataQuantity[ 'quantity']= 0;
    
    }else{
        $dataQuantity[ 'quantity']= $countQuantity;
    }
    
   
 
    $dataInsert = insert('order',$dataOrder);

    $idInsert = insertId();

    $dataAddress = [
        'city' => $body['city'],
        'district' => $body['district'],
        'ward' => $body['ward'],
        'address' => $body['address'],
        'orderID' => $idInsert,
        'clientID' => $idClient,
        'createdAt' => date('Y-m-d H:i:s'),
        'maGiaoDich' => $maGiaoDich,
    ];

  

    // echo '<pre>';
    // print_r($dataAddress);
    // echo '</pre>';
   
    insert('order_detail',$dataAddress);
    $updateQuantity = update('properties',$dataQuantity,'id='.$propertieID);
   
    unset($_SESSION['cart']);
    unset($_SESSION['thanhtoan']);
   
   
}

if($dataInsert){
   

    $response = array(
        'success' => true,
        'success' =>  "Đặt hàng thành công!"
    );
}else{
    $response = array(
        'success' => false,
        'errors' => "Lỗi hệ thống! Vui lòng thử lại sau!"
    );
}

$jsonResponse = json_encode($response);
header('Content-Type: application/json');
echo $jsonResponse;

