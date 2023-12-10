<?php
$body = getBody('get');
$id = $body['id'];
$getSession = getSession('cart') ;
foreach($getSession as $item){
   if($item['productID'] == $id){
       unset($_SESSION['cart'][$id]);
   }
  

}

redirect('?module=order&action=order');

