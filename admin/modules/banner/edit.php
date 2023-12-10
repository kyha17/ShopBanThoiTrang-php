<?php
if (!defined('_INCODE')) die('Access Deined...');

$data = [
    'dataTitle' => 'Sửa danh mục hot'
];

layout('header','admin',$data);

$body = getBody('get');

if(!empty($body['id'])){
    $userIDDetai = $body['id'];

    $userDetai = firstRaw("SELECT * FROM banner WHERE id='$userIDDetai'");

    if(empty($userDetai)){
        /* ID không tồn tại */
        setFlashData('msg','Danh mục này không tồn tại!');
        setFlashData('msgType','danger');
        redirect('admin/?module=banner&action=list');
    }
}else{
    setFlashData('msg','Danh mục này không tồn tại!');
    setFlashData('msgType','danger');
    redirect('admin/?module=banner&action=list');
}

// Lấy thông tin nhóm
$getAllGroup = getRaw("SELECT id, name FROM categorys ORDER BY name");

if(isPost()){
    $body = getBody();

    $errors = [];


    //Validate email: Bắt buộc phải nhập, định dạng email, email phải duy nhất
    if (empty(trim($body['title']))) {
        $errors['title']['required'] = "Title bắt buộc phải nhập";
    } 

    //Validate nhóm người dùng: Bắt buộc phải chọn nhóm
    if (!empty($body['categorysID']) == 0) {
        $errors['categorysID']['required'] = "Vui lòng chọn danh mục";
    }

    if (empty($body['image'])) {
        $errors['image']['required'] = "Vui lòng chọn ảnh";
    }


    /* Kiểm tra mảng errors */
    if(empty($errors)){
        /* Không có lỗi */
        $dataUpdate = [
            'title' => $body['title'],
            'image' => $body['image'],
            'categorysID' => $body['categorysID'],
            'updatedAt' => date('Y-m-d H:i:s')
        ];

//        $condition = "id="
        $updateStatus = update('banner',$dataUpdate,"id=$userIDDetai");
        if($updateStatus){
            setFlashData('msg', 'Cập nhật danh mục thành công');
            setFlashData('msgType', 'success');
            redirect('admin?module=banner&action=list');
        }else{
            setFlashData('msg', 'Lỗi hệ thông vui lòng thử lại sau!');
            setFlashData('msgType', 'danger');
            redirect('admin?module=banner&action=list');
        }

    }else{
        //Có lỗi xảy ra
        setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
        setFlashData('msgType', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old', $body);
        redirect('admin?module=banner&action=list'); //Load lại trang thêm người dùng
    }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msgType');
$errors = getFlashData('errors');
$old = getFlashData('old');

if(!empty($userDetai) && empty($old)){
    $old = $userDetai;

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
                        <h5 class="card-title mb-0">Sửa danh mục hot  </h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-email">Title</label>
                                <div class="input-group input-group-merge">
                                    <input type="text" id="basic-default-email" class="form-control" placeholder="Tên tiêu đề" aria-label="john.doe" name="title" value="<?php echo old('title', $old); ?>" aria-describedby="basic-default-email2" />
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

                           


                            <div class="mb-3">
                                <label for="exampleFormControlSelect1" class="form-label">Danh mục</label>
                                <select class="form-select" id="exampleFormControlSelect1" name="categorysID" aria-label="Default select example">
                                    <option value="0">Hãy danh mục</option>
                                    <?php
                                    if (!empty($getAllGroup)) {
                                        foreach ($getAllGroup as $item) {
                                          
                                    ?>
                                             <option value="<?php echo $item['id']; ?>" <?php echo (!empty($old['categorysID']) && $old['categorysID'] == $item['id']) ? 'selected' : false; ?>><?php echo $item['name']; ?></option>

                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <?php echo form_error('categorysID', $errors, '<span class="text-danger">', '</span>'); ?>
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
                                <a href="<?php echo getLinkAdmin('banner', 'list'); ?>" class="btn btn-warning">Quay lại</a>
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
