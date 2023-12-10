<?php
if (!defined('_INCODE')) die('Access Deined...');

$data = [
    'dataTitle' => 'Câp nhật nhóm '
];

layout('header','admin',$data);

$module = 'groups';

$body = getBody('get');

if(!empty($body['id'])){
    $groupIDDetai = $body['id'];


    $groupsDetai = firstRaw("SELECT * FROM `groups` WHERE id='$groupIDDetai'");

    if(empty($groupsDetai)){
        /* ID không tồn tại */
        setFlashData('msg','Nhóm không tồn tại!');
        setFlashData('msgType','danger');
        redirect('admin/?module=groups&action=list');
    }
}else{
    setFlashData('msg','Nhóm không tồn tại!');
    setFlashData('msgType','danger');
    redirect('admin/?module=groups&action=list');
}


if(isPost()){
    $body = getBody();

    $errors = [];

    //Validate họ tên: Bắt buộc nhập, >=4 ký tự
    if(empty(trim($body['name']))){
        $errors['name']['required'] = 'Tên nhóm bắt buộc phải nhập';
    }elseif (strlen(trim($body['name'])) < 4){
        $errors['name']['min'] = "Tên nhóm không được nhỏ hơn 4 ký tự";
    }else{
        //Kiểm tra groups có tồn tại trong DB
        $names = $body['name'];
        $sql = "SELECT id FROM `groups` WHERE name='$names'";
        if(getRows($sql) > 0){
            $errors['name']['unique'] = 'Tên nhóm đã tồn tại';
        }
    }


    /* Kiểm tra mảng errors */
    if(empty($errors)){
        /* Không có lỗi */
        $dataUpdate = [
            'name' => $body['name'],
            'updateAt' => date('Y-m-d H:i:s')
        ];

//        $condition = "id="
        $updateStatus = update('groups',$dataUpdate,"id=$groupIDDetai");
        if($updateStatus){
            setFlashData('msg', 'Cập nhật nhóm thành công');
            setFlashData('msgType', 'success');
            redirect('admin?module=groups&action=list');
        }else{
            setFlashData('msg', 'Lỗi hệ thông vui lòng thử lại sau!');
            setFlashData('msgType', 'danger');
            redirect('admin?module=groups&action=list');
        }

    }else{
        //Có lỗi xảy ra
        setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
        setFlashData('msgType', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old', $body);
        redirect('admin?module=groups&action=add'); //Load lại trang thêm người dùng
    }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msgType');
$errors = getFlashData('errors');
$old = getFlashData('old');

if(!empty($groupsDetai) && empty($old)){
    $old = $groupsDetai;
}
?>
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Content -->

        <!--        --><?php
        //        getMsg($msg,$msgType);
        //        ?>
        <div class="row justify-content-center">
            <div class="col-xl-6 ">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Cập nhật nhóm </h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">

                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">Tên nhóm</label>
                                <input type="text"
                                       class="form-control"
                                       id="basic-default-username"
                                       name="name"
                                       value="<?php echo old('name', $old); ?>"
                                       placeholder="FullName" />
                                <?php echo form_error('name', $errors, '<span class="text-danger">', '</span>'); ?>
                            </div>


                            <div class="text-end">
                                <button type="submit" class="btn btn-primary" id="showToastPlacement">Xác nhận</button>
                                <a href="<?php echo getLinkAdmin('groups', 'list'); ?>" class="btn btn-warning">Quay lại</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
        <!-- / Content -->
    </div>






    <?php
    layout('footer','admin');

    ?>
