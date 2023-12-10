<?php
if (!defined('_INCODE')) die('Access Deined...');
/*File này chứa chức năng đăng xuất*/

if (isLoginClient()){
    $token = getSession('tokenLoginClient');

    delete('login_token_client', "token='$token'");
    removeSession('login_token_client');
    if (!empty($_SERVER['HTTP_REFERER'])){
        redirect($_SERVER['HTTP_REFERER'], true);
    }else{
        redirect('?module=home&action=lists');
    }

}