<?php
if (!defined('_INCODE')) die('Access Deined...');
//Lấy userId đăng nhập
$userId = isLogin()['userID'];

$body = getBody('get');
if(!empty($body['id'])){
    $categorysID = $body['id'];
    $categorysDetai = firstRaw("SELECT * FROM categorys WHERE id = $categorysID");

    if(empty($categorysDetai)){
        /* ID không tồn tại */
        setFlashData('msg','Danh mục không tồn tại!');
        setFlashData('msgType','danger');
        redirect('admin/?module=categorys&action=list');
    }
}else{
    setFlashData('msg','Danh mục không tồn tại!');
    setFlashData('msgType','danger');
    redirect('admin/?module=categorys&action=list');
}

if(isPost()){
    $body = getBody();


    $names = $body['name'];

    $errors = [];

    //Validate name
    if(empty(trim($body['name']))){
        $errors['name']['required'] = "Tên danh mục bắt buộc phải nhập";
    }elseif (strlen(trim($body['name'])) < 4){
        $errors['name']['min'] = "Tên danh mục không được nhỏ hơn 4 ký tự";
    }else{
        //Kiểm tra groups có tồn tại trong DB
        $names = $body['name'];
        $sql = "SELECT id FROM categorys WHERE name='$names'";
        if(getRows($sql) > 0){
            $errors['name']['unique'] = 'Tên danh mục đã tồn tại';
        }
    }

    //Validate slug
    if(empty(trim($body['slug']))){
        $errors['slug']['required'] = "Slug bắt buộc phải nhập";
    }

    //Kiểm tra mảng $errors
    if(empty($errors)){
        $dataUpdate = [
            'name' => $body['name'],
            'slug' => $body['slug'],
            'userID' => isLogin()['userID'],
            'updateAt' => date('Y-m-d H:i:s')
        ];

//        echo '<pre>';
//        var_dump($dataUpdate);
//        echo '</pre>';

        $updateStatus = update('categorys',$dataUpdate,"id = $categorysID");
        if($updateStatus){
            setFlashData('msg', 'Cập nhật danh mục thành công!');
            setFlashData('msgType', 'success');
            redirect('admin?module=categorys&action=list'); //Load lại trang thêm người dùng
        }else{
            setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
            setFlashData('msgType', 'danger');
            redirect('admin?module=categorys&action=list'); //Load lại trang thêm người dùng
        }

    }else{
        //Có lỗi xảy ra
        setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
        setFlashData('msgType', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old', $body);
        redirect('admin?module=categorys&action=list'); //Load lại trang thêm người dùng
    }

    redirect('admin?module=categorys&action=list&view=edit&id='.$categorysID);

}
$msg = getFlashData('msg');
$msgType = getFlashData('msgType');
$errors = getFlashData('errors');
$old = getFlashData('old');


if(!empty($categorysDetai) && empty($old)){
    $old = $categorysDetai;
}
?>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Cập nhật nhóm danh mục</h5>
    </div>
    <div class="card-body">
        <form action="" method="post">

            <div class="mb-3">
                <label class="form-label" for="basic-default-fullname">Tên danh mục</label>
                <input type="text"
                       class="form-control slug"
                       id="basic-default-username"
                       name="name"
                       value="<?php echo old('name',$old) ?>"
                       placeholder="Tên nhóm" />
                <?php echo form_error('name', $errors, '<span class="text-danger">', '</span>'); ?>
            </div>

            <div class="mb-3">
                <label class="form-label" for="basic-default-fullname">Đường dẫn</label>
                <input type="text"
                       class="form-control render-slug"
                       id="basic-default-username"
                       name="slug"
                       value="<?php echo old('slug',$old) ?>"
                       placeholder="Đường dẫn" />
                <?php echo form_error('slug', $errors, '<span class="text-danger">', '</span>'); ?>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary" id="showToastPlacement">Xác nhận</button>

            </div>
        </form>
    </div>
</div>