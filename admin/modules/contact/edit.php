<?php
if (!defined('_INCODE')) die('Access Deined...');

$data = [
    'dataTitle' => 'Sửa tài khoản Admin'
];

layout('header','admin',$data);

$body = getBody('get');

if(!empty($body['id'])){
    $userIDDetai = $body['id'];

    $userDetai = firstRaw("SELECT * FROM contact WHERE id='$userIDDetai'");

    if(empty($userDetai)){
        /* ID không tồn tại */
        setFlashData('msg','Tài khoản không tồn tại!');
        setFlashData('msgType','danger');
        redirect('admin/?module=users&action=list');
    }
}else{
    setFlashData('msg','Tài khoản không tồn tại!');
    setFlashData('msgType','danger');
    redirect('admin/?module=users&action=list');
}



if(isPost()){
    $body = getBody();

    $errors = [];



    //Validate nhóm người dùng: Bắt buộc phải chọn nhóm
    if(empty(trim($body['content']))){
        $errors['content']['required'] = "Vui lòng nhập dữ liệu";
    }

    /* Kiểm tra mảng errors */
    if(empty($errors)){
        $data = [
            'reply' => $body['content'],
            'status' => 0
        ];

        $updateStatus = update('contact',$data,"id=$userIDDetai");
        if($updateStatus){
            $email = $userDetai['email'];
            $subject = 'Yêu cầu hỗ trợ';
            $content = 'Chào bạn: '.$email.'<br/>';
            $content.='Chúng tôi nhận được yêu cầu hỗ trợ từ bạn. Đây là thông tin giải đáp của bạn: <br/>';
            $content.= $body['content'];


            //Tiến hành gửi email
            $sendStatus = sendMail($email, $subject, $content);

            setFlashData('msg', 'Cập nhật hỗ trợ thành công');
            setFlashData('msgType', 'success');
            redirect('admin?module=contact&action=list');
        }else{
            setFlashData('msg', 'Lỗi hệ thông vui lòng thử lại sau!');
            setFlashData('msgType', 'danger');
            redirect('admin?module=contact&action=list');
        }

    }else{
        //Có lỗi xảy ra
        setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
        setFlashData('msgType', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old', $body);
        redirect('admin?module=contact&action=edit&id='.$userIDDetai); //Load lại trang thêm người dùng
    }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msgType');
$errors = getFlashData('errors');
$old = getFlashData('old');
echo '<pre>';
print_r($errors);
echo '</pre>';
if(!empty($userDetai) && empty($old)){
    $old = $userDetai;
}
?>
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
                        <h5 class="card-title mb-0">Trả lời hỗ trợ email: <?php echo $userDetai['email']  ?></h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">

                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Content</label>
                                <textarea class="form-control" name="content" id="exampleFormControlTextarea1" rows="6">
                                    <?php echo old('reply', $old); ?>
                                </textarea>
                                <?php echo form_error('content', $errors, '<div id="defaultFormControlHelp " class="form-text text-danger">', '</div>'); ?>

                            </div>






                            <div class="text-end">
                                <button type="submit" class="btn btn-primary" id="showToastPlacement">Xác nhận</button>
                                <a href="<?php echo getLinkAdmin('contact', 'list'); ?>" class="btn btn-warning">Quay lại</a>
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
