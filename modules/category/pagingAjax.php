<?php
$body = getBody();


// Nhận dữ liệu từ yêu cầu AJAX
$page = $body['page'];
$id = $body['id'];



$itemsPerPage = 8;// Số lượng dữ liệu hiển thị trên mỗi tran

$Index = $page * $itemsPerPage; // Vị trí bắt đầu của dữ liệu trên trang

$getAllProduct = getRaw("SELECT * FROM products WHERE categoryID =$id  LIMIT 0, $Index");


$html = '';

foreach ($getAllProduct as $item){


    $html .= '<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item ">';
    $html .= '<div class="block2">';
    $html .= '<div class="block2-pic hov-img0 label-new" data-label="New">';
    $html .= '<img src="'._WEB_HOST_ROOT.$item['images'].'" alt="IMG-PRODUCT">';
    $getAll = getRows("SELECT * FROM properties WHERE productID=".$item['id']);
    if($getAll > 0){
        $html .= '<a href="'.getLink('detai', 'lists', ['id' => $item['id']]) .'" class="btnShow block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 ">';
        $html .= 'Xem nhanh';
        $html .= '</a>';
    }

    $html .= '</div>';
    $html .= ' <div class="block2-txt flex-w flex-t p-t-14">';
    $html .= '<div class="block2-txt-child1 flex-col-l ">';
    $html .= '<a href="'.getLink('detai', 'lists', ['id' => $item['id']]) .'" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">';
    $html .=  $item['name'];
    $html .= '</a>';
    $html .= '<div class="price">';
    if ($item['sale'] === '') {
        $html .= '<span class="stext-105 cl3 ">';
        $html .= currency_format($item['price']);
        $html .= '</span>';
    }else{
        $html .= '<span class="stext-105 cl3 ">';
        $html .= currency_format($item['sale']);
        $html .= ' </span>';
        $html .= '<span class="stext-105 cl3 sale">';
        $html .=  currency_format($item['price']);
        $html .= '</span>';
    }
    ;



    $html .= ' </div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
}
echo $html;