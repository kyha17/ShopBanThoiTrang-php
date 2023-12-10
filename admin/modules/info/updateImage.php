<?php
if (!defined('_INCODE')) die('Access Deined...');
if(isPost()){
    $body = getBody();

    $id = $body['id'];

    $file = $_FILES['image'];

    $fileName = $file['name'];
    $fileName = explode('.',$fileName);
    $ext = end($fileName);
    $newFile = md5(uniqid()).'.'.$ext;

    $upload = move_uploaded_file($file['tmp_name'],_WEB_PATH_TEMPLATE.'/admin/assets/img/avatars/'.$newFile);

    $data = ['image' => $newFile];
    $dataUpdate = update('users',$data,'id='.$id );
}







// $dataUpdate = update('users',$data,'id='.$id );
// $target_dir    = "uploads/";
// $target_file   = $target_dir . basename($body['image']);


?>