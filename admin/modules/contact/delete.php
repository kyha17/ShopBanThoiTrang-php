<?php
if (!defined('_INCODE')) die('Access Deined...');

/*File này dùng để xoá người dùng*/
$body = getBody();

$errors = [];

if(!empty($body['id'])){
    $userID = $body['id'];
    $userDetaiRow = getRows("SELECT id FROM contact WHERE id=$userID");

    if($userDetaiRow > 0){
        $deleteUser = delete('contact',"id=$userID");

        if($deleteUser){
            echo json_encode(array(['msg' => "Xóa người dùng thành công!",'msgType' => "success"]));

        }else{
            setFlashData('msg', 'Lỗi hệ thống! Vui lòng thử lại sau');
            setFlashData('msgType', 'danger');
            redirect('admin?module=users&action=list');
        }
    }else{
        setFlashData('msg', 'Người dùng không tồn tại trên hệ thống');
        setFlashData('msgType', 'danger');
        redirect('admin?module=users&action=list');
    }
}else{
    setFlashData('msg', 'Liên kết không tồn tại');
    setFlashData('msgType', 'danger');
    redirect('admin?module=users&action=list');
}



