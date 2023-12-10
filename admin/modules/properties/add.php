<?php
if (!defined('_INCODE')) die('Access Deined...');
$data = [
    'dataTitle' => 'Thêm thuộc tính Admin'
];

layout('header','admin',$data);

$getAll = getRaw("SELECT * FROM products ORDER BY id");

$tong = 0;
if(isPost()){
    $body = getBody();

    $getRows = getRows("SELECT * FROM properties WHERE productID=".$body['productName']);
    $getFist = firstRaw("SELECT * FROM properties WHERE productID=".$body['productName']);
    
    $tong = $getFist['quantity'] + $body['quantity'];
   
    $errors = [];

  

  
     //Validate họ tên: Bắt buộc nhập, >=4 ký tự
     if(empty(trim($body['size']))){
        $errors['size']['required'] = "Tên thuộc tính bắt buộc phải nhập";
    }


     //Validate quatity
     if(empty(trim($body['quantity']))){
        $errors['quantity']['required'] = "Tên bắt buộc phải nhập";
    }else{
        if($body['quantity'] < 0){
            $errors['quantity']['numeric'] = "Định dạng phải là số";
        }
    }
   
    //Kiểm tra mảng $errors
    if(empty($errors)){
       
        if($getRows > 0){

           

            $data = [
                'productID' => $body['productName'],
                'size' => $body['size'],
                'quantity' => $tong,
                'createAt' => date('Y-m-d H:i:s')
            ];
            $InsertStatus = update('properties',$data,"productID=".$body['productName']);

            $dataImporst = [
                'propertieID' => $getFist['id'],
                'productID' => $body['productName'],
                'soLuong' =>  $body['quantity'],
                'createdAt' => date('Y-m-d H:i:s')
            ];


          
            insert('import_table',$dataImporst);
           
        }else{
            $dataInsert = [
                'productID' => $body['productName'],
                'size' => $body['size'],
                'quantity' => $body['quantity'],
                 'createAt' => date('Y-m-d H:i:s')
            ];
    
            $InsertStatus = insert('properties',$dataInsert);


            
           
        }

        if($InsertStatus){

            setFlashData('msg', 'Thêm thuộc tính thành công!');
            setFlashData('msgType', 'success');
            redirect('admin?module=properties&action=list');
        }else{
            setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
            setFlashData('msgType', 'danger');
            redirect('admin?module=properties&action=list');
        }

    }else{
        //Có lỗi xảy ra
        setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
        setFlashData('msgType', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old', $body);
        redirect('admin?module=properties&action=add'); //Load lại trang thêm người dùng
    }

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
            <div class="col-xl-6 ">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Thêm tài khoản</h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class=" mb-3">
                                <label for="nameWithTitle" class="form-label">Tên sản phẩm</label>
                                <select name="productName"  class="form-select">
                                    <?php
                                        foreach($getAll as $item){
                                            ?>
                                                  <option value="<?php echo $item['id'] ?>"
                                                      <?php echo (!empty($IDInsert) && $IDInsert==$item['id'])?"selected":'' ?>><?php echo $item['name']  ?></option>
                                            <?php
                                        }

                                    ?>
                               
                                </select>
                            </div>

                           

                            <div class="mb-3 value id2">
                                <label for="nameWithTitle" class="form-label">Kích thước</label>
                                <input
                                        type="text"
                                        name="size"
                                        id=""
                                        class="form-control x"
                                        value="<?php echo old('size',$old) ?>"
                                        placeholder="Nhập kích thước (XL , L ,S , ..)"
                                        
                                />
                                <?php echo form_error('size', $errors, '<span class="text-danger">', '</span>'); ?>
                            </div>

                            <div class="mb-3 ">
                                <label for="nameWithTitle" class="form-label">Số lượng</label>
                                <input
                                        type="number"
                                        name="quantity"
                                        id="quantity"
                                        class="form-control "
                                        value="<?php echo old('quantity',$old) ?>"
                                        placeholder="Nhập số lượng"
                                />
                                <?php echo form_error('quantity', $errors, '<span class="text-danger">', '</span>'); ?>
                            </div>



                            <div class="text-end">
                                <button type="submit" class="btn btn-primary" id="showToastPlacement">Xác nhận</button>
                                <a href="<?php echo getLinkAdmin('properties', 'list'); ?>" class="btn btn-warning">Quay lại</a>
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



