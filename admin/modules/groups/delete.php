<?php
if (!defined('_INCODE')) die('Access Deined...');

/*File này dùng để xoá người dùng*/
$body = getBody();

$errors = [];

if(!empty($body['id'])){
    $groupID = $body['id'];
    $groupDetaiRow = getRows("SELECT id FROM `groups` WHERE id=$groupID");


     if($groupDetaiRow > 0){
         //Kiểm tra xem trong nhóm còn người dùng không
         $userNum = getRows("SELECT id FROM users WHERE groupID=$groupID");

         if($userNum > 0){
             echo json_encode(array(['msg' => "Trong nhóm vẫn còn $userNum người dùng",'msgType' => "error"]));

         }else{
             /* Thực hiện xóa*/

             $deleteGroups = delete('groups',"id=$groupID");

             if($deleteGroups){
                 echo json_encode(array(['msg' => "Xóa nhóm thành công!",'msgType' => "success"]));

             }else{
                 setFlashData('msg', 'Lỗi hệ thống! Vui lòng thử lại sau');
                 setFlashData('msgType', 'danger');
                 redirect('admin?module=groups&action=list');
             }
         }
     }else{
         setFlashData('msg', 'Nhóm không tồn tại trên hệ thống');
         setFlashData('msgType', 'danger');
         redirect('admin?module=groups&action=list');
     }
}else{
    setFlashData('msg', 'Liên kết không tồn tại');
    setFlashData('msgType', 'danger');
    redirect('admin?module=groups&action=list');
}



