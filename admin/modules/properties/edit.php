<?php
if (!defined('_INCODE')) die('Access Deined...');
$data = [
    'dataTitle' => 'Sửa thuộc tính Admin'
];

layout('header','admin',$data);


$body = getBody('get');

if(!empty($body['id'])){
    $propertiesIDDetai = $body['id'];

    $propertiesDetai = firstRaw("SELECT * FROM properties WHERE id='$propertiesIDDetai'");

    if(empty($propertiesDetai)){
        /* ID không tồn tại */
        setFlashData('msg','Thuộc tính không tồn tại!');
        setFlashData('msgType','danger');
        redirect('admin/?module=users&action=list');
    }
}else{
    setFlashData('msg','Thuộc tính không tồn tại!');
    setFlashData('msgType','danger');
    redirect('admin/?module=users&action=list');
}

$getAll = getRaw("SELECT id, name FROM products ORDER BY name");



if(isPost()){
    $body = getBody();


  
    $errors = [];

 
     //Validate họ tên: Bắt buộc nhập, >=4 ký tự
     if(empty(trim($body['size']))){
        $errors['size']['required'] = "Tên thuộc tính bắt buộc phải nhập";
    }

    
     //Validate quatity
     if(empty(trim($body['quantity']))){
        $errors['quantity']['required'] = "Tên bắt buộc phải nhập";
    }
   
    //Kiểm tra mảng $errors
    if(empty($errors)){

        $dataInsert = [
            'productID' => $body['productName'],
            'size' => $body['size'],
            'quantity' => $body['quantity'],
             'updateAt' => date('Y-m-d H:i:s')
        ];

        $InsertStatus = update('properties',$dataInsert,"id=$propertiesIDDetai");

        if($InsertStatus){
            if($propertiesDetai['quantity'] > $body['quantity']){
                $tong = $propertiesDetai['quantity'] - $body['quantity'];
                $dataImporst = [
                    'propertieID' => $propertiesDetai['id'],
                    'productID' => $body['productName'],
                    'soLuong' =>  '-'.$tong,
                    'createdAt' => date('Y-m-d H:i:s')
                ];
                insert('import_table',$dataImporst);
            }else{
                $dataImporst = [
                    'propertieID' => $propertiesDetai['id'],
                    'productID' => $body['productName'],
                    'soLuong' =>  $body['quantity'],
                    'createdAt' => date('Y-m-d H:i:s')
                ];



                insert('import_table',$dataImporst);
            }
            setFlashData('msg', 'Thêm thuộc tính thành công!');
            setFlashData('msgType', 'success');
            redirect('admin?module=properties&action=list');
        }else{
            setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
            setFlashData('msgType', 'danger');
            redirect('admin?module=properties&action=edit&id='.$propertiesIDDetai);
        }
    }else{
        //Có lỗi xảy ra
        setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
        setFlashData('msgType', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old', $body);
        redirect('admin?module=properties&action=edit&id='.$propertiesIDDetai);
    }

}
$msg = getFlashData('msg');
$msgType = getFlashData('msgType');
$errors = getFlashData('errors');
$old = getFlashData('old');

if(!empty($propertiesDetai) && empty($old)){
    $old = $propertiesDetai;
}

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
                        <h5 class="card-title mb-0">Sửa thuộc tính</h5>
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
                                                <?php echo (!empty($old['productID']) && $old['productID']==$item['id'])?"selected":'' ?>
                                                ><?php echo $item['name']  ?></option>
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
                                        class="form-control "
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
                                        class="form-control title"
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

    <script>

      
    </script>

    <?php
    layout('footer','admin');

    ?>



