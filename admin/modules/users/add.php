<?php
if (!defined('_INCODE')) die('Access Deined...');
$data = [
    'dataTitle' => 'Thêm tài khoản Admin'
];

layout('header','admin',$data);

//Random Images
$randomImages = randomImages();
shuffle($randomImages);

$getAllGroup = getRaw("SELECT id, name FROM `groups` ORDER BY name");

if(isPost()){
    $body = getBody();

    /* Random password */
    $password = generateRandomString();

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
        $sql = "SELECT id FROM users WHERE email='$email'";
        if(getRows($sql) > 0){
            $errors['email']['unique'] = 'Địa chỉ email đã tồn tại';
        }
    }

    //Validate nhóm người dùng: Bắt buộc phải chọn nhóm
    if(!empty($body['groupID']) == 0){
        $errors['groupID']['required'] = "Vui lòng chọn nhóm người dùng";
    }

    //Kiểm tra mảng $errors
    if(empty($errors)){

        //Không có lỗi xảy ra
        $dataInsert = [
            'name' => $body['name'],
            'email' => $body['email'],
            'image' => $randomImages[0],
            'groupID' => $body['groupID'],
            'password' => password_hash($password,PASSWORD_DEFAULT),
            'status' => 1,
            'createAt' => date('Y-m-d H:i:s')
        ];


        $InserStatus = insert('users',$dataInsert);

        if($InserStatus){
            //Tạo activeToken
            $data = [
                'token' =>  $activeToken = sha1(uniqid().time()),
                'email' => $email
            ];


            setSession('activeToken',$data);

            $linkLogin = _WEB_HOST_ROOT_ADMIN.'?module=auth&action=active&token='.$activeToken;
            //Thiết lập gửi email
            $subject = 'Yêu cầu tạo tài khoản mới';
            $content = 'Chào bạn: '.$email.'<br/>';
            $content.='Chúng tôi nhận được yêu cầu tạo tài khoản mới từ bạn. Đây là thông tin của bạn: <br/>';
            $content.='Tài khoản: '.$email .'<br/>';
            $content.='Mật khẩu: '.$password .'<br/>';
            $content.='Vui lòng click vào đây để đăng nhập: '.$linkLogin;

            //Tiến hành gửi email
            $sendStatus = sendMail($email, $subject, $content);
            setFlashData('msg', 'Thêm người dùng thành công');
            setFlashData('msgType', 'success');
            /* Chuyển hướng qua đanh sách */
            redirect('admin?module=users&action=list');
        }else{
            setFlashData('msg', 'Hệ thống đang gặp sự cố! Vui lòng thử lại sau.');
            setFlashData('msgType', 'danger');
            redirect('admin?module=users&action=add');
        }
    }else{
        //Có lỗi xảy ra
        setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
        setFlashData('msgType', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old', $body);
        redirect('admin?module=users&action=add'); //Load lại trang thêm người dùng
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
                        <h5 class="card-title mb-0">Thêm tài khoản</h5>
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
                                <label for="exampleFormControlSelect1" class="form-label">Quyền hạn</label>
                                <select class="form-select" id="exampleFormControlSelect1" name="groupID" aria-label="Default select example">
                                    <option value="0">Hãy chọn quyền</option>
                                    <?php
                                        if(!empty($getAllGroup)){
                                            foreach ($getAllGroup as $item){
                                                ?>
                                                <option value="<?php echo $item['id'];?>" <?php echo (!empty($old['groupID']) && $old['groupID']==$item['id'])?'selected':false; ?>><?php echo $item['name'] ;?></option>

                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                                <?php echo form_error('groupID', $errors, '<span class="text-danger">', '</span>'); ?>
                            </div>
<!--
                            <div class="mb-3">
                                <label for="exampleFormControlSelect1" class="form-label">Trạng thái</label>
                                <select class="form-select" id="exampleFormControlSelect1" name="status" aria-label="Default select example">
                                    <option value="1" <?php /*echo (old('status', $old)==1)?'selected':false;  */?>>Mở tài khoản</option>
                                    <option value="0" <?php /*echo (old('status', $old)==0)?'selected':false;  */?>>Khóa tài khoản</option>

                                </select>

                            </div>-->

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary" id="showToastPlacement">Xác nhận</button>
                                <a href="<?php echo getLinkAdmin('users', 'list'); ?>" class="btn btn-warning">Quay lại</a>
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
