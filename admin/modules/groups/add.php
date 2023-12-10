<?php
if (!defined('_INCODE')) die('Access Deined...');
$data = [
    'dataTitle' => 'Thêm nhóm tài khoản'
];

layout('header','admin',$data);

$getAllGroup = getRaw("SELECT id, name FROM `groups` ORDER BY name");

if(isPost()){
    $body = getBody();


    $names = $body['name'];

    $errors = [];

    //Validate name
    if(empty(trim($body['name']))){
        $errors['name']['required'] = "Tên nhóm bắt buộc phải nhập";
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

    //Kiểm tra mảng $errors
    if(empty($errors)){

        //Không có lỗi xảy ra
        $dataInsert = [
            'name' => $body['name'],
            'createAt' => date("Y-m-d H:i:s")
        ];


        $InserStatus = insert('groups',$dataInsert);

        if($InserStatus){
            setFlashData('msg', 'Thêm nhóm mới thành công!.');
            setFlashData('msgType', 'success');
            /* Chuyển hướng qua đanh sách */
            redirect('admin?module=groups&action=list');
        }else{
            setFlashData('msg', 'Hệ thống đang gặp sự cố! Vui lòng thử lại sau.');
            setFlashData('msgType', 'danger');
            redirect('admin?module=groups&action=add');
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
//echo '<pre>';
//var_dump($errors);
//echo '</pre>';

?>
<!-- Content wrapper -->
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Content -->

        <?php
        getMsg($msg,$msgType);
        ?>
        <div class="row justify-content-center">
            <div class="col-xl-6 ">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Thêm nhóm tài khoản</h5>
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
                                       placeholder="Tên nhóm" />
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
