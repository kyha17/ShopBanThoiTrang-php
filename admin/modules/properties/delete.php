<?php
if (!defined('_INCODE')) die('Access Deined...');

/*File này dùng để xoá người dùng*/
$body = getBody();

$errors = [];

if(!empty($body['id'])){
    $ID = $body['id'];
    $DetaiRow = getRows("SELECT id FROM properties WHERE id=$ID");



     if($DetaiRow > 0){
           /* Thực hiện xóa*/

           $delete = delete('properties',"id=$ID");

           if($delete){


               echo json_encode(array(['msg' => "Xóa thuộc tính thành công!",'msgType' => "success"]));

           }else{
               setFlashData('msg', 'Lỗi hệ thống! Vui lòng thử lại sau');
               setFlashData('msgType', 'danger');
               redirect('admin?module=groups&action=list');
           }
     }else{
         setFlashData('msg', 'Thuộc tính không tồn tại trên hệ thống');
         setFlashData('msgType', 'danger');
         redirect('admin?module=groups&action=list');
     }
}else{
    setFlashData('msg', 'Liên kết không tồn tại');
    setFlashData('msgType', 'danger');
    redirect('admin?module=groups&action=list');
}



