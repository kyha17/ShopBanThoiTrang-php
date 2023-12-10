<?php
if (!defined('_INCODE')) die('Access Deined...');
$data = [
    'dataTitle' => 'Thêm Slide'
];

layout('header', 'admin', $data);


$getAllGroup = getRaw("SELECT id, name FROM categorys ORDER BY name");

$countSlide = getRaw("SELECT id FROM slides");

$count = count($countSlide);
if (isPost()) {
    $body = getBody();




    $errors = [];

    //Validate họ tên: Bắt buộc nhập, >=4 ký tự
    if (empty(trim($body['name']))) {
        $errors['name']['required'] = "Tên slide bắt buộc phải nhập";
    } elseif (strlen(trim($body['name'])) < 4) {
        $errors['name']['min'] = "Tên slide không được nhỏ hơn 4 ký tự";
    }

    //Validate email: Bắt buộc phải nhập, định dạng email, email phải duy nhất
    if (empty(trim($body['title']))) {
        $errors['title']['required'] = "Title bắt buộc phải nhập";
    } 


    if (empty($body['image'])) {
        $errors['image']['required'] = "Vui lòng chọn ảnh";
    }

    //Kiểm tra mảng $errors
    if (empty($errors)) {
       
        //Không có lỗi xảy ra
        $dataInsert = [
            'name' => $body['name'],
            'name' => $body['name'],
            'title' => $body['title'],
            'image' => $body['image'],
            'createAt' => date('Y-m-d H:i:s')
        ];

        if($count <= 6){
            $InserStatus = insert('slides', $dataInsert);
        }else{
            setFlashData('msg', 'Bạn không được thêm qua 7 slide!');
            setFlashData('msgType', 'danger');
            redirect('admin?module=slides&action=add');
        }

      

        if ($InserStatus) {
          


          
            setFlashData('msg', 'Thêm slide thành công');
            setFlashData('msgType', 'success');
            /* Chuyển hướng qua đanh sách */
            redirect('admin?module=slides&action=list');
        } else {
            setFlashData('msg', 'Hệ thống đang gặp sự cố! Vui lòng thử lại sau.');
            setFlashData('msgType', 'danger');
            redirect('admin?module=slides&action=add');
        }
    } else {
        //Có lỗi xảy ra
        setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
        setFlashData('msgType', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old', $body);
        redirect('admin?module=slides&action=add'); //Load lại trang thêm người dùng
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
        getMsg($msg, $msgType);
        ?>
        <div class="row justify-content-center">
            <div class="col-xl-6 ">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Thêm Slide</h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">

                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">Tên Slide</label>
                                <input type="text" class="form-control" id="basic-default-username" name="name" value="<?php echo old('name', $old); ?>" placeholder="FullName" />
                                <?php echo form_error('name', $errors, '<span class="text-danger">', '</span>'); ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-default-email">Title</label>
                                <div class="input-group input-group-merge">
                                    <input type="text" id="basic-default-email" class="form-control" placeholder="Email address" aria-label="john.doe" name="title" value="<?php echo old('title', $old); ?>" aria-describedby="basic-default-email2" />
                                </div>

                                <?php echo form_error('title', $errors, '<span class="text-danger">', '</span>'); ?>
                            </div>

                            <div class="mb-3">
                                <div class="row ckfinder-group">
                                    <label for="forfilemFile" class="form-label">Image Đại diện</label>
                                    <div class="col-9 ">
                                        <input class="form-control image-render" name="image" type="text" value="<?php echo old('image', $old); ?>">
                                    </div>
                                    <div class="col-3">
                                        <button type="button" class="btn btn-primary w-100 choose-images">Chọn ảnh</button>
                                    </div>
                                </div>
                                <?php echo form_error('image', $errors, '<span class="text-danger">', '</span>'); ?>
                            </div>

                           

                            <!--
                            <div class="mb-3">
                                <label for="exampleFormControlSelect1" class="form-label">Trạng thái</label>
                                <select class="form-select" id="exampleFormControlSelect1" name="status" aria-label="Default select example">
                                    <option value="1" <?php /*echo (old('status', $old)==1)?'selected':false;  */ ?>>Mở tài khoản</option>
                                    <option value="0" <?php /*echo (old('status', $old)==0)?'selected':false;  */ ?>>Khóa tài khoản</option>

                                </select>

                            </div>-->

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary" id="showToastPlacement">Xác nhận</button>
                                <a href="<?php echo getLinkAdmin('slides', 'list'); ?>" class="btn btn-warning">Quay lại</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
        <!-- / Content -->
    </div>


    <?php
    layout('footer', 'admin');

    ?>