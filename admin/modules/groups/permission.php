<?php
if (!defined('_INCODE')) die('Access Deined...');
$data = [
    'dataTitle' => 'Danh sách nhóm'
];

layout('header', 'admin', $data);

$module = 'groups';
$body = getBody('get'); //Yêu cầu lấy phương thức get


if (!empty($body['id'])){
    $groupId = $body['id'];
   
    $groupDetail = firstRaw("SELECT * FROM `groups` WHERE id=$groupId");
  
    if (empty($groupDetail)){
        //Không Tồn tại
        redirect('admin?module=groups');
    }

}else{
    redirect('admin?module=groups');
}



if(isPost()){
     
    $body = getBody();
  


    $errors = [];
   

    if(empty($errors)){
        if (!empty($body['permissions'])){
            $permissionJson = json_encode($body['permissions']);
        }else{
            $permissionJson = '';
        }
      

        $dataUpdate = [
            'describes' => trim($permissionJson),
            'updateAt' => date("Y-m-d H:i:s")
        ];

        $updateStatus = update('groups',$dataUpdate,"id=".$groupId);
        if($updateStatus){
            setFlashData('msg','Phân quyền thành công!');
            setFlashData('msgType', 'success');
        }else{
            setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
            setFlashData('msgType', 'danger');
        }
    }else{
          //Có lỗi xảy ra
          setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
          setFlashData('msgType', 'danger');
          setFlashData('errors', $errors);
          setFlashData('old', $body);
          redirect('admin?module=groups&action=list'); //Load lại trang thêm người dùng
    }
    redirect('admin?module=groups&action=permission&id='.$groupId);
}

$getAllModule = getRaw('SELECT * FROM modules');

$msg = getFlashData('msg');
$msgType = getFlashData('msgType');
$errors = getFlashData('errors');
$old = getFlashData('old');

if (empty($old) && !empty($groupDetail)){
    $old = $groupDetail;
}

if (!empty($old['describes'])){
    $permissionsJson = $old['describes'];

    $permissionsArr = json_decode($permissionsJson, true);
}

// echo '<pre>';
// print_r($permissionsArr);
// echo '</pre>';
?>


<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

    <form method="post" action="">
        <div class="card">
           
            <?php
            getMsg($msg, $msgType);
            ?>
            <div class="card-header">
                <h5 class="card-title">Phân quyền nhóm : <?php echo $groupDetail['name'] ?></h5>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table permission-lists">
                    <thead>
                        <tr>
                            <th width="20%">Modules</th>
                            <th>Chức nắng</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php
                        if (!empty($getAllModule)) :

                            foreach ($getAllModule as $item) :
                                $actions = $item['actions'];
                                $actionsArr = json_decode($actions);
                              
                        ?>
                                <tr>
                                    <td>
                                        <?php echo $item['title']; ?>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <?php
                                            if (!empty($actionsArr)) :
                                                foreach ($actionsArr as $roleKey => $roleValue) :
                                            ?>
                                                    <div class="col-2">
                                                        <input type="checkbox" 
                                                        name="<?php echo 'permissions['.$item['name'].'][]'; ?>" 
                                                        id="<?php echo $item['name'].'_'.$roleKey ?>"
                                                        value="<?php echo $roleKey ?>"<?php echo (!empty($permissionsArr[$item['name']] )&& in_array($roleKey,$permissionsArr[$item['name']]))?'checked':false ?>>
                                                        <label for="<?php echo $item['name'].'_'.$roleKey ?>">
                                                        <?php echo $roleValue; ?>
                                                        </label>
                                                    </div>
                                            <?php
                                                endforeach;
                                            endif;
                                            ?>
                                        </div>
                                    </td>

                                </tr>

                            <?php endforeach;
                        else : ?>
                            <tr>
                                <td colspan="7">
                                    <div class="alert alert-danger text-center">Không có dữ liệu người dùng</div>
                                </td>
                            </tr>

                        <?php endif;  ?>
                    </tbody>
                </table>
            </div>
                
            
        </div>
        <button type="submit" class="btn btn-success mt-2">Xác nhận</button>
        <a href="#" class="btn btn-warning mt-2">Quay lại</a>
        <input type="hidden" name="id" value="<?php echo (!empty($id)?$id:'') ?>">
    </form>
        <!-- / Content -->
    </div>


    <?php

    layout('footer', 'admin');

    ?>
    <script>
        var url = '?module=groups&action=delete';
        deleteAjax('.deletes', url);
    </script>