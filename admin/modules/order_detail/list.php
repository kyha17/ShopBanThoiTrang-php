<?php
if (!defined('_INCODE')) die('Access Deined...');
$data = [
    'dataTitle' => 'Lịch sử mua hàng'
];

layout('header', 'admin', $data);

$IDGroup = getGroupId(); 
$permissionsData = getPermissionsData($IDGroup);

$checkView= checkPermission($permissionsData,'order_detail','view');
$checkDelete = checkPermission($permissionsData,'order_detail','delete');

if(!$checkView){
    redirectPermission("admin/?module=dashboard&action=list");
}

$module = 'order_detail';
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

        $filter .= " $operator $module.maGiaoDich LIKE '%$keyword%'";
    }


}


//Truy vấn dữ liệu
$orderDetaiRow = firstRaw("SELECT maGiaoDich, COUNT(*) AS count FROM order_detail GROUP BY maGiaoDich HAVING count > 1");


/* Lấy dữ Jone 2 bảng users với groups  */
$listAllUser = getRaw("SELECT order_detail.id as order_detail_id ,maGiaoDich,name,orderID,usersclient.id as usersclient_id  FROM order_detail 
INNER JOIN usersclient ON order_detail.clientID =usersclient.id $filter ORDER BY order_detail.maGiaoDich ASC ");

$mergedRecords = [];

foreach ($listAllUser as $item) {
    $found = false;

    foreach ($mergedRecords as $mergedRecord) {
        if ($mergedRecord['maGiaoDich'] === $item['maGiaoDich']) {
            $found = true;
            break;
        }
    }

    if ($found) {
        $mergedRecord['maGiaoDich'] .= ',' . $item['maGiaoDich'];
    } else {
        // Nếu không tìm thấy, thêm bản ghi mới vào mảng đã gộp
        $mergedRecords[] = $item;
    }
}




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
                <input type="hidden" name="module" value="order_detail">

            </form>
        </div>

        <div class="card">
            <?php
            getMsg($msg, $msgType);
            ?>
            <div class="card-header">
                <h5 class="card-title">Danh sách giao dịch</h5>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="5%">STT</th>
                            <th width="40%">Mã giao dịch</th>

                            <th width="20%">Họ tên</th>

                            <th width="5%">Xem</th>
                            <?php if($checkDelete): ?>
                            <th width="5%">Xóa</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php
                        if (!empty($mergedRecords)) :
                            $count = 0;
                            foreach ($mergedRecords as $item) :

                                $count++;

                        ?>
                                <tr>
                                    <td>
                                        <?php echo $count; ?>
                                    </td>

                                    <td>
                                        <?php echo explode(',', $item['maGiaoDich'])[0]; ?>
                                    </td>
                                    <td>
                                        <?php echo $item['name']; ?>
                                    </td>

                                    <td>
                                        <a href="<?php echo getLinkAdmin('order', 'list', ['magiaodich' => $item['maGiaoDich']]) ?>">
                                            <button class="btn btn-warning btn-sm">
                                                <i class='bx bx-edit-alt'></i>
                                            </button>
                                        </a>
                                    </td>

                                    <?php if($checkDelete): ?>
                                    <td>
                                        <a href="javascript:void(0);" class="deletes" data-id="<?php echo $item['order_detail_id'] ?>">
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
        $(document).ready(function() {
            $('.deletes').click(function() {
                let id = $(this).data("id");
                var el = this;

                Swal.fire({
                    title: 'Bạn có chắc không?',
                    text: "Bạn sẽ không thể khôi phục điều này!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Tôi, đồng ý!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: "?module=order_detail&action=delete",
                            data: {
                                id: id
                            },
                            success: function(data) {
                                console.log(data);
                                if (data.success) {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: data.success,
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    $(el).closest('tr').fadeOut(800, function() {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'error',
                                        title: data.errors,
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                }

                            },


                        })


                    }
                })
            });


        })
    </script>