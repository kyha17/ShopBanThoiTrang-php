<?php
if (!defined('_INCODE')) die('Access Deined...');
$data = [
    'dataTitle' => 'Thông tin lịch sử'
];

layout('header', 'admin', $data);

$IDGroup = getGroupId(); 
$permissionsData = getPermissionsData($IDGroup);

$checkView = checkPermission($permissionsData,'order','view');
$checkActive = checkPermission($permissionsData,'order','active');
$checkDelete = checkPermission($permissionsData,'order','delete');

if(!$checkView){
    redirectPermission("admin/?module=dashboard&action=list");
}

$module = 'order';
$filter = '';



if (isGet()) {
    $body = getBody();


    $magiaodich = $body['magiaodich'];

    $idArray = explode(',', $magiaodich);

    $id = "'" . $idArray[0] . "'    ";
}

//Truy vấn dữ liệu
$getAllID = getRaw("SELECT orderID,id FROM order_detail WHERE maGiaoDich=" . $id);

foreach ($getAllID as $item) {
    $idOrder = $item['orderID'];
    $listAllUser = getRaw("SELECT `order`.id as order_id,`order`.productID  as order_productID ,`order`.clientID as order_clientID,
`order`.propertieID as order_propertieID,`order`.quantity as order_quantity,maDonHang,total,`order`.status,
images,products.name as product_name,usersclient.name as usersclient_name  FROM `order` 
INNER JOIN products ON `order`.productID =products.id
INNER JOIN properties ON `order`.propertieID =properties.id
INNER JOIN usersclient ON `order`.clientID =usersclient.id  AND `order`.id='$idOrder' ORDER BY `order`.createdAt ASC  ");
    $arr[] = $listAllUser;
}


/* Lấy dữ Jone 2 bảng users với groups  */

$firstData = firstRaw("SELECT * FROM order_detail WHERE orderID =" . $getAllID[0]['orderID']);




$msg = getFlashData('msg');
$msgType = getFlashData('msgType');

?>


<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">


        <div class="card">
            <?php
            getMsg($msg, $msgType);
            ?>
            <div class="card-header">
                <h5 class="card-title">Chi tiết mã giao dịch :<?php echo $firstData['maGiaoDich'] ?></h5>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>

                            <th width="10%">Mã đơn hàng</th>
                            <th width="15%">Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th width="10%">Người mua</th>
                            <th width="10%">Số lượng</th>
                            <th width="10%">Tổng giá</th>
                            <?php if($checkActive): ?>
                            <th width="10%">Trạng thái</th>
                            <?php endif; ?>
                            <th width="5%">Xóa</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php
                        if (!empty($arr)) :

                            foreach ($arr as $key => $item) :



                        ?>
                                <tr>


                                    <td>
                                        <?php echo $item[0]['maDonHang']; ?>
                                    </td>
                                    <td>
                                        <img width="80px" height="100px" src="<?php echo _WEB_HOST_ROOT . $item[0]['images']; ?>">
                                    </td>

                                    <td><?php echo $item[0]['product_name'] ?></td>

                                    <td><?php echo $item[0]['usersclient_name'] ?></td>

                                    <td><?php echo $item[0]['order_quantity'] ?></td>

                                    <td><?php echo formatPrice($item[0], 'total') ?></td>

                                    <?php if($checkActive): ?>
                                    <td><?php echo toglesStatus($item[0]) ?></td>
                                    <?php endif; ?>

                                    <?php if($checkDelete): ?>
                                    <td>
                                        <a href="javascript:void(0);" class="deletes" data-id="<?php echo $item[0]['order_id'] ?>">
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
                                    <div class="alert alert-danger text-center">Không có dữ liệu</div>
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
                            url: "?module=order&action=delete",
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
                                        window.location.replace("http://localhost/admin/?&module=order_detail");
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

            $('.btnCheck').on('click', function() {
                let id = $(this).data("id");
                $.ajax({
                    type: "post",
                    url: "?module=order&action=checkOrder",
                    data: {
                        id: id
                    },
                    // dataType: "json",
                    success: function(response) {
                       
                        if (response.success) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'bottom-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'success',
                                title: response.success
                            })
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'bottom-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'error',
                                title: response.errors
                            })
                        }

                    }
                });
            })
        })
    </script>