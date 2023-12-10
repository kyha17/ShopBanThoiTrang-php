<?php
$body = getBody('get');
    unset($_SESSION['cart']);
    redirect('?module=order&action=order');
?>