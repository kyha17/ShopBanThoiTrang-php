<?php
if (!defined('_INCODE')) die('Access Deined...');
$data = [
    'dataTitle' => 'Kích hoạt tài khoản'
];


layout('header_login','admin',$data);

$tokenSesion = getSession('activeToken');

$token = getBody()['token'];

$email = $tokenSesion['email'];

$tokenActive = $tokenSesion['token'];

if(!empty($token)){
    if($token == $tokenActive){
        $tokenQuery = firstRaw("SELECT id FROM users WHERE email='$email'");

        if(!empty($tokenQuery)){
            $userID = $tokenQuery['id'];

            $dataUpdate = [
                'activeToken' => $tokenActive,
            ];

            $updateStatus = update('users',$dataUpdate,"id='$userID'");
            if($updateStatus){
                removeSession('activeToken');
                setFlashData('msg','Tài khoản của bạn đã kích hoạt thành công!');
                setFlashData('msgType','success');
                redirect('admin/?module=users&action=list');
            }else{
                setFlashData('msg','Kích hoạt tài khoản thất bại! Vui lòng liên hệ quản tị viên.');
                setFlashData('msgType','danger');
            }
        }
    }else{
        getMsg('Liên kết không tồn tại hoặc đã hết hạn','danger');

    }
}else{
    getMsg('Liên kết không tồn tại hoặc đã hết hạn','danger');

}

?>










