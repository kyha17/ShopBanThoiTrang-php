<?php

if (isPost()) {
    $body = getBody();

    if (!empty(trim($body['email'])) && !empty(trim($body['password']))) {
        $email = $body['email'];
        $password = $body['password'];

        $userQuery = firstRaw("SElECT id,password FROM usersclient WHERE email='$email' AND status=0");

        if (!empty($userQuery)) {
            $passwordHash = $userQuery['password'];
            $userID = $userQuery['id'];

            if (password_verify($password, $passwordHash)) {
                /* Creaate Token Login */
                $tokenLogin = sha1(uniqid() . time());

                /* Insert du lieu vao bang login_token */
                $dataInsert = [
                    'clientID' => $userID,
                    'token' => $tokenLogin,
                    'createdAt' => date('Y-m-d H:i:s')
                ];


                $insertStatus = insert('login_token_client', $dataInsert);

                if ($insertStatus) {
                    //Insert token thành công
                    setSession('tokenLoginClient', $tokenLogin);

                    //Chuyển hướng qua trang quản lý users
                    $response = array(
                        'success' => 'Đăng nhập thành công',
                    );
                    
                }
            } else {
                $response = array(
                    'success' => false,
                    'errors' => "Tài khoản hoặc mật khẩu không chính xác"
                );
            }
        } else {
            $response = array(
                'success' => false,
                'errors' => "Tài khoản của bạn đã bị khóa! Vui lòng liên hệ Admin"
            );
        }
    } else {
        $response = array(
            'success' => false,
            'errors' => "Vui lòng nhập tài khoản hoặc mật khẩu"
        );
    }

    $jsonResponse = json_encode($response);
    header('Content-Type: application/json');
    echo $jsonResponse;
}
