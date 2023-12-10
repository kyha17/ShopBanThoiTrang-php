<?php
if (!defined('_INCODE')) die('Access Deined...');

/*File này dùng để xoá người dùng*/
$body = getBody();

$errors = [];

if(!empty($body['id'])){
    $ID = $body['id'];
    $DetaiRow = getRows("SELECT id FROM banner WHERE id=$ID");


     if($DetaiRow > 0){
         /* Thực hiện xóa*/

         $deleteGroups = delete('banner',"id=$ID");

         if($deleteGroups){
             echo json_encode(array(['msg' => "Xóa banner thành công!",'msgType' => "success"]));

         }else{
             setFlashData('msg', 'Lỗi hệ thống! Vui lòng thử lại sau');
             setFlashData('msgType', 'danger');
             redirect('admin?module=banner&action=list');
         }
     }else{
         setFlashData('msg', 'Nhóm không tồn tại trên hệ thống');
         setFlashData('msgType', 'danger');
         redirect('admin?module=banner&action=list');
     }
}else{
    setFlashData('msg', 'Liên kết không tồn tại');
    setFlashData('msgType', 'danger');
    redirect('admin?module=banner&action=list');
}



