<?php
if (!defined('_INCODE')) die('Access Deined...');
$data = [
    'dataTitle' => 'Thêm sản phẩm'
];

layout('header','admin',$data);

//Lấy dánh sách danh mục
$getAllGroup = getRaw("SELECT id,name FROM categorys ORDER BY name");




if(isPost()){
    $body = getBody();

    $errors = [];

    $name = $body['name'];

    /* Valide tên sản phẩm */
    if(empty($body['name'])){
        $errors['name']['required'] = "Tên sản phẩm bắt buộc nhập";
    }

    /* Valiedate ảnh đại diện */
    if(empty($body['images'])){
        $errors['images']['required'] = "Ảnh đại diện bắt buộc nhập";
    }

    /* Validate mô tả */
    if(empty($body['content'])){
        $errors['content']['required'] = "Mô tả bắt buộc nhập";
    }



    /* Validate giá */
    if(empty($body['price'])){
        $errors['price']['required'] = "Gía bắt buộc nhập";
    }

    /* Validate danh mục */
    if(!empty($body['categoryID']) == 0){
        $errors['categoryID']['required'] = "Vui lòng chọn danh mục";
    }

    //Validate ảnh dự án: Bắt buộc phải nhập

    if (!empty($body['gallery'])){

        $galleryArr = $body['gallery'];

        foreach ($galleryArr as $key => $item){
            if (empty(trim($item))){
                $errors['gallery']['required'][$key] = 'Vui lòng chọn ảnh';
            }
        }
    }





    if(empty($errors)){

        $dataInsert = [
            'name' => trim($body['name']),
            'slug' => slug(trim($body['name'])),
            'content' => trim($body['content']),
            'userID' => isLogin()['userID'],
            'images' => trim($body['images']),
            'categoryID' => trim($body['categoryID']),
            'price' => trim($body['price']),
            'sale' => trim($body['sale']),
            'status' => trim($body['status']),
            'createAt' => date('Y-m-d H:i:s')

        ];

        $InsertStatus = insert('products',$dataInsert);

       if($InsertStatus){
            $IDInsert = insertId();
           setFlashData('IDInsert', $IDInsert);
            //Xử lý thêm ảnh dự án

           if (!empty($galleryArr)){
               foreach ($galleryArr as $item){

                   $dataImages = [
                       'productID' =>   $IDInsert,
                       'links' => trim($item),
                       'createAt' => date('Y-m-d H:i:s')
                   ];

                   insert('imagecontents',$dataImages);
                  
               }
           }

            //Xử lý thêm ảnh dự án
            setFlashData('msg', 'Thêmd sản phẩm thành công');
            setFlashData('msgType', 'success');

            redirect('admin?module=properties&action=add'); //Chuyển hướng qua dự án danh sách
        }else{
            setFlashData('msg', 'Hệ thống đang gặp sự cố! Vui lòng thử lại sau.');
            setFlashData('msgType', 'danger');

             //Load lại trang thêm người dùng
        }
    }else{
        //Có lỗi xảy ra
        setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
        setFlashData('msgType', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old', $body);
     
         //Load lại trang thêm người dùng
    }
    redirect('admin?module=products&action=add'); //Chuyển hướng qua dự án danh sách






}

$msg = getFlashData('msg');
$msgType = getFlashData('msgType');
$errors = getFlashData('errors');
$old = getFlashData('old');
$IDInsert = getFlashData('IDInsert');


?>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Content -->

        <?php
        getMsg($msg,$msgType);
        ?>
        <div class="row justify-content-center">
            <div class="col-xl-10 ">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Thêm sản phẩm</h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">

                            <!-- Tên sản phẩm -->
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">Tên sản phẩm</label>
                                <input type="text"
                                       class="form-control"
                                       name="name"
                                       value="<?php echo old('name', $old); ?>"
                                       placeholder="Tên sản phẩm" />
                                <?php echo form_error('name', $errors, '<span class="text-danger">', '</span>'); ?>
                            </div>
                            <!-- End Tên sản phẩm -->

                            <!-- Ảnh đại diện -->
                            <div class="mb-3">
                                <div class="row ckfinder-group">
                                <label for="forfilemFile" class="form-label">Image Đại diện</label>
                                    <div class="col-10 ">
                                        <input class="form-control image-render"
                                               name="images"
                                               type="text"
                                               value="<?php echo old('images', $old); ?>" >
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-primary w-100  choose-images">Chọn ảnh</button>
                                    </div>
                                </div>
                                <?php echo form_error('images', $errors, '<span class="text-danger">', '</span>'); ?>
                            </div>
                            <!-- End Ảnhr đại diện -->


                            <!-- Mô tả -->
                            <div class="mb-3">
                            <div id="toolbar-container"></div>
                                <label for="exampleFormControlTextarea1" class="form-label">Mô tả</label>
                                <textarea  class="form-control"
                                           name="content"
                                           id="editor">
                                    <?php echo old('content', $old); ?>
                                </textarea>
                                <?php echo form_error('content', $errors, '<span class="text-danger">', '</span>'); ?>
                            </div>
                            <!--End Mô tả-->


                            <!-- Gía và sále -->
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col">
                                        <label class="form-label" for="basic-default-fullname">Gía</label>
                                        <input type="text"
                                               class="form-control"
                                               name="price"
                                               value="<?php echo old('price', $old); ?>"
                                               placeholder="Gía sản phẩm" />
                                        <?php echo form_error('price', $errors, '<span class="text-danger">', '</span>'); ?>
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="basic-default-fullname">Sale (%)</label>
                                        <input type="text"
                                               class="form-control"
                                               name="sale"
                                               value="<?php echo old('sale', $old); ?>"
                                               placeholder="Sale sản phẩm" />

                                    </div>
                                </div>
                            </div>
                            <!-- End giá và sale -->

                            <!-- Danh mục -->
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col">
                                        <label for="defaultSelect" class="form-label">Danh mục</label>
                                            <select id="defaultSelect"
                                                    class="form-select" name="categoryID">
                                                <option value="0">Chọn danh mục</option>
                                                <?php
                                                    if(!empty($getAllGroup)){
                                                        foreach ($getAllGroup as $item){
                                                            ?>
                                                            <option value="<?php echo $item['id'] ?>"<?php echo (old('categoryID',$old)==$item['id']?'selected':false); ?>><?php echo $item['name'] ?></option>
                                                            <?php
                                                        }
                                                    }

                                                ?>
                                            </select>
                                        <?php echo form_error('categoryID', $errors, '<span class="text-danger">', '</span>'); ?>
                                    </div>
                                    <div class="col">
                                        <label for="defaultSelect" class="form-label">Trạng thái</label>
                                        <select id="defaultSelect" class="form-select" name="status">
                                            <option value="0" <?php echo (old('status',$old)==0?'selected':false) ;?>>Kích hoạt</option>
                                            <option value="1"<?php echo (old('status',$old)==1?'selected':false) ;?>>Bỏ kích hoạt</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End Danh mục -->

                            <!-- Ảnh sản phẩm -->
                            <div class="mb-3">
                                <label for="defaultSelect" class="form-label">Ảnh sản phẩm</label>

                                <div class="gallery-image">
                                    <?php
                                        $oldGallery = old('gallery', $old);
                                        if(!empty($oldGallery)){
                                            $galleryErrors = $errors['gallery'];
                                            if(!empty($galleryErrors)){
                                                foreach ($oldGallery as $key=> $item){
                                                    ?>
                                                    <div class="gallery-item mt-4">
                                                        <div class="row ckfinder-group">
                                                            <div class="col-9 ">
                                                                <input class="form-control form-control-sm image-render"
                                                                       name="gallery[]"
                                                                       type="text"
                                                                       value="<?php echo (!empty($item))?$item:false; ?>" >
                                                            </div>
                                                            <div class="col-2">
                                                                <button type="button" class="btn btn-sm btn-info w-100  choose-images">Chọn ảnh</button>
                                                            </div>
                                                            <div class="col-1">
                                                                <a href="javascript:void(0);" class="btn btn-sm btn-danger remove">Xóa</a>
                                                            </div>
                                                            <?php
                                                            echo (!empty($galleryErrors['required'][$key]))?'<span class="error">'.$galleryErrors['required'][$key].'</span>':false;
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                        }

                                    ?>
                                </div>
                                <p></p>
                                <a href="javascript:void(0);" class="btn btn-warning btn-sm add-gellery">Thêm ảnh</a>
                            </div>



                            <div class="text-end">
                                <button type="submit" class="btn btn-primary" id="showToastPlacement">Xác nhận</button>
                                <a href="<?php echo getLinkAdmin('products', 'list'); ?>" class="btn btn-warning">Quay lại</a>
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
