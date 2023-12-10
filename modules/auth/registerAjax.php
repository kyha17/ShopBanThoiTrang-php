<?php
if(isPost()){
    $body = getBody();

    $errors = [];

    if(empty(trim($body['name']))){
        $errors['name'] = "Họ tên bắt buộc phải nhập" ;
    }elseif (strlen(trim($body['name'])) < 4){
        $errors['name'] = "Họ tên không được nhỏ hơn 4 ký tự";
    }

    //Validate email: Bắt buộc phải nhập, định dạng email, email phải duy nhất
    if(empty(trim($body['email']))){
        $errors['email'] = "Email bắt buộc phải nhập";
    }elseif (!isEmail($body['email'])){
        //Kiểm tra email hợp lệ
        $errors['email'] = "Email không hợp lệ";
    }else{
        //Kiểm tra email có tồn tại trong DB
        $email = $body['email'];
        $sql = "SELECT id FROM usersclient WHERE email='$email'";
        if(getRows($sql) > 0){
            $errors['email'] = 'Địa chỉ email đã tồn tại';
        }
    }


    if(empty(trim($body['password']))){
        $errors['password'] = "Mật khẩu bắt buộc phải nhập" ;
    }

    if(empty($errors)){
        $data = [
            'name' => $body['name'],
            'email' => $body['email'],
            'password' =>  password_hash($body['password'],PASSWORD_DEFAULT),
            'status' => 0,
            'createdAt' => date('Y-m-d H:i:s')
        ];

        $dataInsert = insert('usersclient',$data);

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
}
