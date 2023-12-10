<?php
$body = getBody();

$data = [
    'email' => $body['email'],
    'content' => $body['msg'],
    'status' => 1,
    'createdAt' => date('Y-m-d H:i:s')
];

$InserStatus = insert('contact',$data);

if($InserStatus){
    $email = $body['email'];
    $subject = 'Yêu cầu hỗ trợ';
    $content = 'Chào bạn: '.$email.'<br/>';
    $content.= $body['content'];

    //Tiến hành gửi email
    $sendStatus = sendMail($email, $subject, $content);
    $response = array(
        'success' => "Gửi hỗ trợ thành công!",

    );
}
$jsonResponse = json_encode($response);
header('Content-Type: application/json');
echo $jsonResponse;
