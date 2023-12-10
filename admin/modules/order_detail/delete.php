<?php
if (!defined('_INCODE')) die('Access Deined...');

/*File này dùng để xoá người dùng*/
$body = getBody();

$errors = [];

if (!empty($body['id'])) {
    $userID = $body['id'];

    
    $orderDetaiRow = firstRaw("SELECT maGiaoDich, COUNT(*) AS count FROM order_detail GROUP BY maGiaoDich HAVING count > 1");
    if($orderDetaiRow != ''){
        $magiaodich = "'".$orderDetaiRow['maGiaoDich']."'";
   
        $getAll = getRaw("SELECT orderID,id FROM order_detail WHERE maGiaoDich=".$magiaodich);
    
        foreach ($getAll as $id){
            $idOrderDetai= $id['id'];
            $idOrder = $id['orderID'];
            delete('order_detail',"id='$idOrderDetai'");
            delete('order',"id='$idOrder'");
    
           
        }
        $response = array(
            'success' => "Xóa giao dịch thành công!",
         
        );
    }else{
        $getAlls = getRaw("SELECT orderID,id FROM order_detail WHERE id=".$userID);
        foreach ($getAlls as $ids){
            $idOrderDetais= $ids['id'];
            $idOrders = $ids['orderID'];
            delete('order_detail',"id='$idOrderDetais'");
            delete('order',"id='$idOrders'");
    
            
            $response = array(
                'success' => "Xóa giao dịch thành công!",
             
            );
        }
       
    }
  
    
} else {
    $response = array(
        'errors' => "Giao dịch không tồn tại!",
     
    );
}
$jsonResponse = json_encode($response);
header('Content-Type: application/json');
echo $jsonResponse;

