<?php
if(isPost()){
    $id = isLogin()['userID'];

    $userAll = getUserInfo($id);

    $getAllGroup = firstRaw("SELECT id,name FROM `groups` WHERE id=".$userAll['groupID']);
    
    if($getAllGroup['name'] == "SuperAdmin"){
        echo json_encode(array(['msg' => "Không thể xóa người dùng có nhóm SuperAdmin",'msgType' => "error"]));
    }else{
        delete('users','id='.$id);
        redirect('admin?module=auth&action=login');
    }
}