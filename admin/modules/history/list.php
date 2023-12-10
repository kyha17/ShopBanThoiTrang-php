<?php
if (!defined('_INCODE')) die('Access Deined...');
$data = [
    'dataTitle' => 'Danh sách kích thước sản phẩm'
];

layout('header','admin',$data);

$IDGroup = getGroupId();
$permissionsData = getPermissionsData($IDGroup);

$checkView= checkPermission($permissionsData,'history','view');
$checkDelete = checkPermission($permissionsData,'history','delete');

if(!$checkView){
    redirectPermission("admin/?module=dashboard&action=list");
}


$module = 'import_table';
$filter ='';


if(isGet()){
    $body = getBody();




    //Xử lý lọc theo properties
    if(!empty($body['productId'])){
        $status = $body['productId'];

        if(!empty($filter) && strpos($filter,'WHERE')>=0){
            $operator = 'AND';
        }else{
            $operator = 'WHERE';
        }

        $filter.= " $operator productId LIKE '%$status%'";
    }




}
/* Xử lý phân trang */

/* Tính tổng số lượng bản ghi */
$allUserNumber = getRows("SELECT * FROM import_table $filter");

/* 1. Xác định số lượng bản ghi trên 1 trang */
$perPage = 7; /* Mỗi trang có 3 bẳn ghi */

/* 2. Tính số trang */
$maxPage = ceil($allUserNumber / $perPage);

/* 3. Xử lý số trang dựa vào phương thức Get */

if(!empty(getBody()['page'])){

    $page = getBody()['page'];
    if($page <1 || $page >$maxPage){
        $page = 1;
    }
}else{
    $page=1;
}

/* Tính toán offset trong limit dựa vào biến page */

/*
 * $page = 1 => offset = 0 = ($page-1)*$perPage = (1-1)*3 = 0
 * $page = 2 => offset = 3 = ($page-1)*$perPage = (2-1)*3 = 3
 * $page = 3 => offset = 6 = ($page-1)*$perPage = (3-1)*3 = 6
 * */

$offset = ($page - 1) * $perPage;
//Truy vấn dữ liệu

/* Lấy dữ Jone 2 bảng users với groups  */
$listAll = getRaw("SELECT import_table.id as import_table_ID,import_table.propertieID as import_table_propertieID,
import_table.productID  as import_table_productID, soLuong,name,size ,import_table.createdAt as import_table_createdAt
FROM import_table INNER JOIN products ON import_table.productID  =products.id
INNER JOIN properties ON import_table.propertieID  =properties.id
$filter ORDER BY import_table.createdAt DESC LIMIT $offset,$perPage");
//echo '<pre>';
//print_r($listAll);
//echo '</pre>';
//die();
// Lấy hết dữ liệu bẳng products
$getAllProduct = getRaw("SELECT id,name FROM products");
//Xử lý query string tìm kiếm với phân trang
$queryString = null;
if (!empty($_SERVER['QUERY_STRING'])){
    $queryString = $_SERVER['QUERY_STRING'];
    $queryString = str_replace('module='.$module, '', $queryString);
    $queryString = str_replace('&page='.$page, '', $queryString);
    $queryString = trim($queryString, '&');

    $queryString = '&'.$queryString;

}

$msg = getFlashData('msg');
$msgType = getFlashData('msgType');

?>
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">
            <?php
            getMsg($msg,$msgType);
            ?>
            <div class="card-header">
                <h5 class="card-title">Lịch sử cập nhật sản phẩm</h5>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                    <tr>
                        <th width="5%">STT</th>
                        <th >Tên sản phẩm</th>
                        <th width="10%">Kích thước</th>
                        <th width="10%">Số lượng</th>
                        <th width="10%">Thời gian</th>

                        <?php if($checkDelete):?>
                            <th width="5%">Xóa</th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    <?php
                    if(!empty($listAll)):
                        $count = 0;
                        foreach($listAll as $item):
                            $count++;

                            ?>
                            <tr>
                                <td>
                                    <?php echo $count;?>
                                </td>

                                <td><?php echo $item['name']?></td>

                                <td>
                                    <?php echo $item['size'] ?>
                                </td>

                                <td><?php echo $item['soLuong']?></td>

                                <td><?php echo $item['import_table_createdAt']?></td>
                                <?php if($checkDelete):?>
                                    <td>
                                        <a href="javascript:void(0);" class="deletes" data-id="<?php echo $item['import_table_ID']?>">
                                            <button class="btn btn-danger btn-sm">
                                                <i class='bx bx-message-square-x'></i>
                                            </button>
                                        </a>
                                    </td>
                                <?php endif; ?>
                            </tr>

                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="9">
                                <div class="alert alert-danger text-center">Không có dữ liệu </div>
                            </td>
                        </tr>

                    <?php endif;  ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Phân trang -->
        <div class="mt-3">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-end">
                    <?php
                    if($page > 1){
                        $prevPage = $page-1;
                        ?>
                        <li class="page-item prev">
                            <a class="page-link" href="<?php echo _WEB_HOST_ROOT_ADMIN.'?module='.$module.$queryString.'&page='.$prevPage; ?>"
                            ><i class="tf-icon bx bx-chevrons-left"></i
                                ></a>
                        </li>
                        <?php
                    }
                    ?>


                    <?php
                    $begin = $page-2;
                    if($begin < 1){
                        $begin = 1;
                    }

                    $end = $page+2;
                    if($end > $maxPage){
                        $end = $maxPage;
                    }
                    if($maxPage > 1){
                        for ($index = $begin ; $index <= $end ; $index++){
                            ?>
                            <li class="page-item <?php echo ($index == $page)?'active':false; ?>">
                                <a class="page-link" href="<?php echo _WEB_HOST_ROOT_ADMIN.'?module='.$module.$queryString.'&page='.$index; ?>"><?php echo $index ?></a>
                            </li>
                            <?php
                        }
                    }
                    ?>

                    <?php
                    if($page < $maxPage){
                        $nextPage = $page +1;
                        ?>
                        <li class="page-item next">
                            <a class="page-link" href="<?php echo _WEB_HOST_ROOT_ADMIN.'?module='.$module.$queryString.'&page='.$nextPage; ?>"
                            ><i class="tf-icon bx bx-chevrons-right"></i
                                ></a>
                        </li>
                        <?php
                    }
                    ?>

                </ul>
            </nav>
        </div>
        <!-- / Phân trang -->

        <!-- / Content -->
    </div>


    <?php

    layout('footer','admin');

    ?>
    <script>
        var url = '?module=history&action=delete';
        deleteAjax('.deletes',url);



    </script>

