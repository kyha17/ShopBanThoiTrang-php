<?php
if (!defined('_INCODE')) die('Access Deined...');

/*File này dùng để xoá người dùng*/
$body = getBody();

$errors = [];

if(!empty($body['id'])){
    $ID = $body['id'];
    $DetaiID = getRows("SELECT id FROM products WHERE id=$ID");

    if($DetaiID > 0){

        delete('imagecontents',"productID=".$ID);
        $deleteStatus = delete('products',"id =$ID");
        if($deleteStatus){

            echo json_encode(array(['msg' => "Xóa sản phẩm thành công!",'msgType' => "success"]));
        }else{
            echo json_encode(array(['msg' => "Lỗi hệ thống! Vui lòng thử lại sau",'msgType' => "errors"]));
        }
    }else{
        setFlashData('msg', 'Danh mục không tồn tại');
        setFlashData('msgType', 'danger');
        redirect('admin?module=products&action=list');
    }
}else{
    setFlashData('msg', 'Liên kết không tồn tại');
    setFlashData('msgType', 'danger');
    redirect('admin?module=products&action=list');
}