<?php
if (!defined('_INCODE')) die('Access Deined...');
$data = [
    'dataTitle' => 'Trang chủ Admin'
];

layout('header','client',$data);


?>


<body class="animsition">
<!-- Header -->
<?php require_once 'header.php' ?>

<!-- Cart -->
<?php require_once 'templates/client/layouts/Desktop/cart.php' ?>

<!-- Slider -->
<?php require_once 'slider.php' ?>

<!-- Banner -->
<?php require_once 'banner.php' ?>

<!-- Product -->
<?php require_once 'product.php' ?>


<?php
layout('footer', 'client'); 

?>