<?php
if (!defined('_INCODE')) die('Access Deined...');

/*File này dùng để xoá người dùng*/
$body = getBody();

$errors = [];

if(!empty($body['id'])){
    $categorysID = $body['id'];
    $categorysDetaiID = getRows("SELECT id FROM categorys WHERE id=$categorysID");
    $productID =  getRaw("SELECT id FROM products WHERE categoryID=$categorysID");
   
    
    foreach($productID as $item){
        delete('imagecontents','productID ='.$item['id']);
        delete('properties','productID ='.$item['id']);
    }
    delete('products','categoryID ='.$categorysID);

    delete('banner','categorysID='.$categorysID);


    if($categorysDetaiID > 0){
       
     

      
        $deleteCategorys = delete('categorys',"id =$categorysID");
       
        if($deleteCategorys){
            echo json_encode(array(['msg' => "Xóa danh mục thành công!",'msgType' => "success"]));
        }else{
            echo json_encode(array(['msg' => "Lỗi hệ thống! Vui lòng thử lại sau",'msgType' => "errors"]));
        }
    }else{
        setFlashData('msg', 'Danh mục không tồn tại');
        setFlashData('msgType', 'danger');
        redirect('admin?module=categorys&action=list');
    }
}else{
    setFlashData('msg', 'Liên kết không tồn tại');
    setFlashData('msgType', 'danger');
    redirect('admin?module=categorys&action=list');
}