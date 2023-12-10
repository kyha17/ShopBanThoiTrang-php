<?php
if (!defined('_INCODE')) die('Access Deined...');
$data = [
    'dataTitle' => 'Thêm người dùng'
];

layout('header','admin',$data);






if(isPost()){
    $body = getBody();

  
    $email = $body['email'];

    $errors = [];

    //Validate họ tên: Bắt buộc nhập, >=4 ký tự
    if(empty(trim($body['name']))){
        $errors['name']['required'] = "Họ tên bắt buộc phải nhập";
    }elseif (strlen(trim($body['name'])) < 4){
        $errors['name']['min'] = "Họ tên không được nhỏ hơn 4 ký tự";
    }

    //Validate email: Bắt buộc phải nhập, định dạng email, email phải duy nhất
    if(empty(trim($body['email']))){
        $errors['email']['required'] = "Email bắt buộc phải nhập";
    }elseif (!isEmail($body['email'])){
        //Kiểm tra email hợp lệ
        $errors['email']['required'] = "Email không hợp lệ";
    }else{
        //Kiểm tra email có tồn tại trong DB
        $email = $body['email'];
        $sql = "SELECT id FROM usersclient WHERE email='$email'";
        if(getRows($sql) > 0){
            $errors['email']['unique'] = 'Địa chỉ email đã tồn tại';
        }
    }

   //Validate confirm-password
   if(!empty(trim($body['password']))){
    if (empty(trim($body['confirm-password']))) {
        $errors['confirm-password']['required'] = "Mật khẩu bắt buộc phải nhập";
    } else {
        if (trim($body['password']) != trim($body['confirm-password'])) {
            $errors['confirm-password']['math'] = "2 Mật khẩu không trùng nhau";
        }
    }
}

    //Kiểm tra mảng $errors
    if(empty($errors)){

        //Không có lỗi xảy ra
        $dataInsert = [
            'name' => $body['name'],
            'email' => $body['email'],
            'password' => password_hash($password,PASSWORD_DEFAULT),
            'status' => 0,
            'createdAt' => date('Y-m-d H:i:s')
        ];


        $InserStatus = insert('usersclient',$dataInsert);

        if($InserStatus){
            
            setFlashData('msg', 'Thêm người dùng thành công');
            setFlashData('msgType', 'success');
            /* Chuyển hướng qua đanh sách */
            redirect('admin?module=usersclient&action=list');
        }else{
            setFlashData('msg', 'Hệ thống đang gặp sự cố! Vui lòng thử lại sau.');
            setFlashData('msgType', 'danger');
            redirect('admin?module=usersclient&action=add');
        }
    }else{
        //Có lỗi xảy ra
        setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
        setFlashData('msgType', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old', $body);
        redirect('admin?module=usersclient&action=add'); //Load lại trang thêm người dùng
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
                        <h5 class="card-title mb-0">Thêm người dùng</h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">

                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">Họ tên</label>
                                <input type="text"
                                       class="form-control"
                                       id="basic-default-username"
                                       name="name"
                                       value="<?php echo old('name', $old); ?>"
                                       placeholder="FullName" />
                                <?php echo form_error('name', $errors, '<span class="text-danger">', '</span>'); ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-default-email">Email</label>
                                <div class="input-group input-group-merge">
                                    <input
                                        type="text"
                                        id="basic-default-email"
                                        class="form-control"
                                        placeholder="Email address"
                                        aria-label="john.doe"
                                        name="email"
                                        value="<?php echo old('email', $old); ?>"
                                        aria-describedby="basic-default-email2"
                                    />
                                    <span class="input-group-text" id="basic-default-email2">@example.com</span>
                                </div>

                                <?php echo form_error('email', $errors, '<span class="text-danger">', '</span>'); ?>
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">Mật khẩu</label>
                                <input type="password"
                                       class="form-control"
                                       id="basic-default-username"
                                       name="password"
                                       value="<?php echo old('password', $old); ?>"
                                       placeholder="Mật khẩu" />
                                <?php echo form_error('password', $errors, '<span class="text-danger">', '</span>'); ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">Nhập lại mật khẩu</label>
                                <input type="password" class="form-control" id="basic-default-username" name="confirm-password" value="" placeholder="Nhập lại mật khẩu" />
                                <?php echo form_error('confirm-password', $errors, '<span class="text-danger">', '</span>'); ?>
                            </div>
                            
                            <div class="mb-3">
                                <label for="exampleFormControlSelect1" class="form-label">Trạng thái</label>
                                <select class="form-select" id="exampleFormControlSelect1" name="status" aria-label="Default select example">
                                    <option value="0" <?php echo (old('status', $old)==0)?'selected':false;  ?>>Mở tài khoản</option>
                                    <option value="1" <?php echo (old('status', $old)==1)?'selected':false;   ?>>Khóa tài khoản</option>

                                </select>

                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary" id="showToastPlacement">Xác nhận</button>
                                <a href="<?php echo getLinkAdmin('usersclient', 'list'); ?>" class="btn btn-warning">Quay lại</a>
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
