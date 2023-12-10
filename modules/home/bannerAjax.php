<?php

$body = getBody();
$keyword = '';
$keyword = "'" . $body['key'] . "'";


$html = '';


$getAll = getRaw("SELECT products.id as products_id ,images,products.name as products_name,price,sale,
categorys.id as categorys_id,categorys.slug as categorys_slug,
categorys.name as categorys_name  FROM products 
INNER JOIN categorys ON products.categoryID =categorys.id WHERE categorys.slug=" . $keyword);

foreach($getAll as $key =>  $item){
    $html .= '<div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15 slick-slide slick-current slick-active" data-slick-index="'.$key.'" aria-hidden="false" tabindex="0" style="width: 300px;">';
    $html .= '<div class="block2">';
    $html .= '<div class="block2-pic hov-img0">';
    $html .= '<img src="'.$item['images'].'" alt="IMG-PRODUCT">';
    $html .= '<a href="#" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1" tabindex="0"> Xem ngay</a>';
    $html .= '</div>';
    $html .= '<div class="block2-txt-child1 flex-col-l ">';
    $html .= '<a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6" tabindex="0">  Esprit Ruffle Shirt </a>';
    $html .= '<span class="stext-105 cl3">$16.64</span>';
    $html .= '</div>';
    $html .= '<div class="block2-txt-child2 flex-r p-t-3">';
    $html .= '<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2" tabindex="0">';
    $html .= '<img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png" alt="ICON">';
    $html .= '<img class="icon-heart2 dis-block trans-04 ab-t-l" src="images/icons/icon-heart-02.png" alt="ICON">';
    $html .= '</a>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    
}


echo $html;