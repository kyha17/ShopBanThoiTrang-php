<?php
if (!defined('_INCODE')) die('Access Deined...');
$data = [
    'dataTitle' => 'Lịch sử mua hàng'
];

layout('header', 'admin', $data);

$IDGroup = getGroupId();
$permissionsData = getPermissionsData($IDGroup);

$checkView= checkPermission($permissionsData,'contact','view');
$checkEdit = checkPermission($permissionsData,'contact','edit');
$checkDelete = checkPermission($permissionsData,'contact','delete');

if(!$checkView){
    redirectPermission("admin/?module=dashboard&action=list");
}

$module = 'contact';
$filter = '';



if (isGet()) {
    $body = getBody();


    //Xử lý lọc theo từ khoá
    if (!empty($body['keyword'])) {
        $keyword = $body['keyword'];

        if (!empty($filter) && strpos($filter, 'WHERE') >= 0) {

            $operator = 'AND';
        } else {
            $operator = 'WHERE';
        }

        $filter .= " $operator $module.email LIKE '%$keyword%'";
    }


}


/* Lấy dữ Jone 2 bảng users với groups  */
$listAllUser = getRaw("SELECT * FROM contact $filter ORDER BY contact.createdAt ASC ");

//echo '<pre>';
//print_r($listAllUser);
//echo '</pre>';
//die();

//Xử lý query string tìm kiếm với phân trang
$queryString = null;
if (!empty($_SERVER['QUERY_STRING'])) {
    $queryString = $_SERVER['QUERY_STRING'];
    $queryString = str_replace('module=' . $module, '', $queryString);

    $queryString = trim($queryString, '&');

    $queryString = '&' . $queryString;
}

$msg = getFlashData('msg');
$msgType = getFlashData('msgType');

?>


<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Content -->
        <div class="row">
            <form action="" class="d-flex mb-3" method="get">




                <div class="col-lg-12 d-flex">
                    <input class="form-control me-2" name="keyword" type="search" placeholder="Search" value="<?php echo (!empty($keyword) ? $keyword : false); ?>" aria-label="Search" />
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </div>
                <input type="hidden" name="module" value="contact">

            </form>
        </div>

        <div class="card">
            <?php
            getMsg($msg, $msgType);
            ?>
            <div class="card-header">
                <h5 class="card-title">Danh sách hỗ trợ</h5>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                    <tr>
                        <th width="5%">STT</th>
                        <th width="20%">Email</th>

                        <th >Nội dung</th>

                        <th width="10%">Trạng thái</th>
                        <th width="20%">Thời gian</th>
                        <?php if($checkEdit): ?>
                        <th width="5%">Trả lời</th>
                        <?php endif; ?>
                        <?php if($checkDelete): ?>
                            <th width="5%">Xóa</th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <?php
                    if (!empty($listAllUser)) :
                        $count = 0;
                        foreach ($listAllUser as $item) :

                            $count++;

                            ?>
                            <tr>
                                <td>
                                    <?php echo $count; ?>
                                </td>

                                <td>
                                    <?php echo $item['email']; ?>
                                </td>
                                <td>
                                    <?php echo $item['content']; ?>
                                </td>

                                <td>
                                    <?php echo toglesStatusContact($item); ?>
                                </td>

                                <td>
                                    <?php echo getDateFormat($item['createdAt'],"d/m/Y"); ?>
                                </td>

                                <?php if($checkEdit): ?>
                                <td>
                                    <a href="<?php echo getLinkAdmin('contact', 'edit', ['id' => $item['id']]) ?>">
                                        <button class="btn btn-warning btn-sm">
                                            <i class='bx bx-edit-alt'></i>
                                        </button>
                                    </a>
                                </td>
                                <?php endif; ?>

                                <?php if($checkDelete): ?>
                                    <td>
                                        <a href="javascript:void(0);" class="deletes" data-id="<?php echo $item['id'] ?>">
                                            <button class="btn btn-danger btn-sm">
                                                <i class='bx bx-message-square-x'></i>
                                            </button>
                                        </a>
                                    </td>
                                <?php endif; ?>
                            </tr>

                        <?php endforeach;
                    else : ?>
                        <tr>
                            <td colspan="9">
                                <div class="alert alert-danger text-center">Không có dữ liệu người dùng</div>
                            </td>
                        </tr>

                    <?php endif;  ?>
                    </tbody>
                </table>
            </div>
        </div>


        <!-- / Content -->
    </div>


    <?php

    layout('footer', 'admin');

    ?>

    <script>
        var url = '?module=contact&action=delete';
        deleteAjax('.deletes',url);

    </script>
