<?php
if (!defined('_INCODE')) die('Access Deined...');


if (!isLogin()){
    redirect('admin/?module=auth&action=login');
}
saveActivity();
autoRemoveTokenLogin();

?>
<!DOCTYPE html>


<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/"
    data-template="vertical-menu-template-free"
>
<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title><?php echo $data['dataTitle']; ?> - Quản trị website</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php assets('assets/img/favicon/favicon.ico'); ?>" />
    <?php includeLink('admin/layouts/LinkAdmin/adminCss') ?>

</head>

<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->

      <?php includeLink('admin/layouts/LayoutSub/sidebar'); ?>

        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->

            <?php includeLink('admin/layouts/LayoutSub/nav'); ?>

            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
