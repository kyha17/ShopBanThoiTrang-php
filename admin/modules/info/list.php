<?php
if (!defined('_INCODE')) die('Access Deined...');
$data = [
    'dataTitle' => 'Danh sách sản phẩm'
];

layout('header', 'admin', $data);

$id = isLogin()['userID'];

$userInfo = getUserInfo($id);


$module = 'info';

if (isPost()) {
    $body = getBody();

    echo '<pre>';
    print_r($body);
    echo '</pre>';

    $dataUpdate = [
        'name' => $body['name'],
        'phone' => $body['phone'],
        'address' => $body['address'],
        'facebook' => $body['facebook'],
        'youtube' => $body['youtube'],
        'instagram' => $body['instagram'],
        'twitch' => $body['twitch'],
        'updateAt' => date('Y-m-d H:i:s'),
    ];

    $dataUpdate = update('users', $dataUpdate, 'id='.$id);
    if ($dataUpdate) {
        setFlashData('msg', 'Cập nhật thông tin thành công!');
        setFlashData('msgType', 'success');

        redirect('admin?module=info&action=list');
    }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msgType');
?>

<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">

        <?php
        getMsg($msg, $msgType);
        ?>

        <div class="row">
            <div class="col-md-12">

                <div class="card mb-4">

                    <!-- Account -->
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="<?php echo _WEB_HOST_ADMIN_TEMPLATE.'/assets/img/avatars/'. $userInfo['image']  ?>" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar">
                            <div class="button-wrapper">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Tải ảnh mới lên</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>

                                        <input type="file" data-id="<?php echo $id ?>" name="image" id="upload" class="account-file-input" hidden="" accept="image/png, image/jpeg">
                                    </label>

                                </form>
                                <script>
                                  
                                </script>

                                <p class="text-muted mb-0">Cho phép JPG, GIF hoặc PNG. Kích thước tối đa 800K</p>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0">
                    <div class="card-body">
                        <form id="formAccountSettings" method="POST">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input type="text" name="email" readonly="" class="form-control" id="" value="<?php echo $userInfo['email'] ?>">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Họ tên</label>
                                    <input type="text" name="name" class="form-control" id="" value="<?php echo $userInfo['name'] ?>">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="organization" class="form-label">Điện thoại</label>
                                    <input type="text" name="phone" class="form-control" id="" value="<?php echo $userInfo['phone'] ?>">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="organization" class="form-label">Địa chỉ</label>
                                    <input type="text" name="address" class="form-control" id="" value="<?php echo $userInfo['address'] ?>">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="phoneNumber">Facebook</label>
                                    <input type="text" name="facebook" class="form-control" id="" value="<?php echo $userInfo['facebook'] ?>">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="address" class="form-label">Youtube</label>
                                    <input type="text" name="youtube" class="form-control" id="" value="<?php echo $userInfo['youtube'] ?>">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="state" class="form-label">Instagram</label>
                                    <input type="text" name="instagram" class="form-control" id="" value="<?php echo $userInfo['instagram'] ?>">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="zipCode" class="form-label">Twitch</label>
                                    <input type="text" name="twitch" class="form-control" id="" value="<?php echo $userInfo['twitch'] ?>">
                                </div>

                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Xác nhận</button>
                                <a href="<?php echo getLinkAdmin('users', 'list'); ?>" class="btn btn-outline-secondary">Quay lại</a>
                            </div>
                        </form>
                    </div>
                    <!-- /Account -->
                </div>
                <div class="card">
                    <h5 class="card-header">Xóa tài khoản</h5>
                    <div class="card-body">
                        <div class="mb-3 col-12 mb-0">
                            <div class="alert alert-warning">
                                <h6 class="alert-heading fw-bold mb-1">Bạn có chắc rằng bạn muốn xóa tài khoản của bạn?</h6>
                                <p class="mb-0">Sau khi bạn xóa tài khoản của mình, bạn sẽ không thể quay lại. Hãy chắc chắn.</p>
                            </div>
                        </div>
                        <form id="formAccountDeactivation" onsubmit="return false">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="accountActivation" id="accountActivation">
                                <label class="form-check-label" for="accountActivation">Tôi xác nhận hủy kích hoạt tài khoản của mình</label>
                            </div>
                            <button type="submit" data-id="<?php echo $id ?>" class="btn btn-danger deactivate-account">Xác nhận xóa tài khoản</button>
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