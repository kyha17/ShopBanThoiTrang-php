<?php
if (!defined('_INCODE')) die('Access Deined...');

/*File này dùng để xoá người dùng*/
$body = getBody();

$errors = [];

if(!empty($body['id'])){
    $ID = $body['id'];
    $DetaiRow = getRows("SELECT id FROM `order` WHERE id=$ID");

   
     if($DetaiRow > 0){
         /* Thực hiện xóa*/
        
         $deleteGroups = delete('order',"id=$ID");
      
         if($deleteGroups){
            $response = array(
                'success' => "Xóa đơn hàng thành công!",
               
            );

         }else{
            $response = array(
                'errors' => "Lỗi hệ thống!",
             
            );
         }
     }else{
        $response = array(
            'errors' => "Đơn hàng không tồn tại trong hệ thống!",
         
        );
     }
}else{
    $response = array(
        'errors' => "Đơn hàng không tồn tại trong hệ thống!",
     
    );
}


$jsonResponse = json_encode($response);
header('Content-Type: application/json');
echo $jsonResponse;

