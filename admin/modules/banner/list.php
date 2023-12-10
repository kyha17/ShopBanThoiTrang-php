<?php
if (!defined('_INCODE')) die('Access Deined...');
$data = [
    'dataTitle' => 'Trang chủ danh mục hot'
];

layout('header','admin',$data);


$module = 'banner';
$filter ='';

$IDGroup = getGroupId(); 
$permissionsData = getPermissionsData($IDGroup);




$checkView= checkPermission($permissionsData,'banner','view');
$checkAdd = checkPermission($permissionsData,'banner','add');
$checkEdit = checkPermission($permissionsData,'banner','edit');
$checkDelete = checkPermission($permissionsData,'banner','delete');

if(!$checkView){
    redirectPermission("admin/?module=dashboard&action=list");
}

if(isGet()){
    $body = getBody();


    //Xử lý lọc theo từ khoá
    if (!empty($body['keyword'])){
        $keyword = $body['keyword'];

        if (!empty($filter) &&strpos($filter, 'WHERE')>=0){

            $operator = 'AND';

        }else{
            $operator = 'WHERE';
        }

        $filter.= " $operator $module.title LIKE '%$keyword%'";
    }

    //Xử lý lọc theo group
    if(!empty($body['categorysID'])){
        $groupID = $body['categorysID'];

        if(!empty($filter) && strpos($filter,'WHERE')>=0){
            $operator = 'AND';
        }else{
            $operator = 'WHERE';
        }

        $filter  .= "$operator categorysID=$groupID";
    }


}
/* Xử lý phân trang */

/* Tính tổng số lượng bản ghi */
$allUserNumber = getRows("SELECT id FROM banner $filter");

/* 1. Xác định số lượng bản ghi trên 1 trang */
$perPage = _PAGE; /* Mỗi trang có 3 bẳn ghi */

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
$listAllUser = getRaw("SELECT banner.id,title,image,categorys.name as categorys_name,categorys.id as categorys_id
 FROM banner INNER JOIN categorys ON banner.categorysID=categorys.id $filter ORDER BY banner.createdAt ASC LIMIT $offset,$perPage");

/* Lấy dữ liệu bẳng groups */
$listAllGroup = getRaw("SELECT id,name FROM categorys ORDER BY name");

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
        <!-- Content -->
        <div class="row">
            <form action="" class="d-flex mb-3" method="get">

            <?php
            if($checkAdd):
            ?>
            <div class="col-lg-2">
                <a href="<?php echo getLinkAdmin($module,'add')?>" class="btn btn-primary">Thêm danh mục hot</a>
            </div>
            <?php
            endif;
            ?>

            <div class="col-lg-2 ">
                <div class="me-2">
                    <select class="form-select " id="exampleFormControlSelect1" aria-label="Default select example" name="categorysID">
                        <option value="0">Tất cả nhóm</option>
                        <?php
                            if(!empty($listAllGroup)){
                                foreach ($listAllGroup as $item){
                                    ?>
                                    <option value="<?php echo $item['id']?>" <?php echo (!empty($categorysID) && $categorysID == $item['id']?'selected':false); ?>><?php echo $item['name']?></option>
                                    <?php
                                }
                            }
                        ?>


                    </select>
                </div>
            </div>

            <div class="<?php echo ($checkAdd)?'col-lg-8':'col-lg-10' ?> d-flex">
                    <input class="form-control me-2"
                           name="keyword"
                           type="search"
                           placeholder="Search"
                           value="<?php echo (!empty($keyword)?$keyword:false);?>"
                           aria-label="Search" />
                    <button class="btn btn-outline-primary" type="submit">Search</button>
            </div>
            <input type="hidden" name="module" value="banner">

            </form>
        </div>

        <div class="card">
            <?php
            getMsg($msg,$msgType);
            ?>
            <div class="card-header">
                <h5 class="card-title">Danh sách danh mục hot</h5>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                    <tr>
                        <th width="5%">STT</th>

                        <th width="20%">Image</th>
                        <th>Tiêu đề</th>
                        <th width="20%">Danh mục</th>
                        
                        <?php
                            if($checkEdit):
                        ?>
                        <th width="5%">Sửa</th>
                        <?php
                            endif;
                        ?>

                        <?php
                            if($checkDelete):
                        ?>
                        <th width="5%">Xóa</th>
                        <?php
                            endif;
                        ?>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    <?php
                    if(!empty($listAllUser)):
                        $count = 0;
                        foreach($listAllUser as $item):

                            $count++;

                            ?>
                            <tr>
                                <td>
                                    <?php echo $count;?>
                                </td>

                                
                                <td>
                                    <img width="80px" height="100px" src="<?php echo _WEB_HOST_ROOT.$item['image']; ?>">
                                </td>

                                <td>
                                    <?php echo $item['title'];?>
                                </td>



                                <td>
                                    <?php echo '<span class="badge bg-info">'.$item['categorys_name'].'</span>';?>
                                </td>
                               
                                <?php
                                    if($checkEdit):
                                ?>
                                <td>
                                    <a href="<?php echo getLinkAdmin($module,'edit',['id' => $item['id']])?>">
                                        <button class="btn btn-warning btn-sm">
                                            <i class='bx bx-edit-alt'></i>
                                        </button>
                                    </a>
                                </td>
                                <?php
                                    endif;
                                 ?>

                                <?php
                                    if($checkDelete):
                                ?>
                                <td>
                                    <a href="javascript:void(0);" class="deletes" data-id="<?php echo $item['id']?>">
                                        <button class="btn btn-danger btn-sm">
                                            <i class='bx bx-message-square-x'></i>
                                        </button>
                                    </a>
                                </td>
                                <?php
                                    endif;
                                 ?>
                            </tr>

                        <?php endforeach; else: ?>
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
        var url = '?module=banner&action=delete';
        deleteAjax('.deletes',url);

    </script>
