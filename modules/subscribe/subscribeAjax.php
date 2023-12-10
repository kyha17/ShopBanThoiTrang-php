<?php
$body = getBody();

$email = $body['email'];

$errors = [];

//Validate email: Bắt buộc phải nhập, định dạng email, email phải duy nhất
if (empty(trim($body['email']))) {
    $errors[] = 'Email bắt buộc phải nhập' ;
} elseif (!isEmail($body['email'])) {
    //Kiểm tra email hợp lệ
    $errors[] = 'Email không hợp lệ';
} else {
    //Kiểm tra email có tồn tại trong DB
    $email = $body['email'];
    $sql = "SELECT id FROM subscribes WHERE email='$email'";
    if (getRows($sql) > 0) {
        $errors[] = 'Địa chỉ email đã tồn tại';
    }
}


// echo '<pre>';
// print_r($errors[0]);
// echo '</pre>';

if(empty($errors)){
    $data = [
        'email' => $email,
    ];
    $dataInsert = insert('subscribes', $data);
    if ($dataInsert) {
        $response = array(
            'success' => json_encode($dataInsert),
        );
    }
}else{
    $response = array(
        'success' => false,
        'errors' => $errors
    );
}

$jsonResponse = json_encode($response);
header('Content-Type: application/json');
echo $jsonResponse;