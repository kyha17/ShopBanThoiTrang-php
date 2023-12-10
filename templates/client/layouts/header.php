<?php
if (!defined('_INCODE')) die('Access Deined...');


// echo '<pre>';
// print_r(isLoginClient());
// echo '</pre>';
// die();
saveActivityClient();
autoRemoveTokenLoginClient();
?>
<!DOCTYPE html>
<html lang="en">

<head>


	<title><?php echo $data['dataTitle']; ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" 
	integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" 
	crossorigin="anonymous" referrerpolicy="no-referrer" />
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="<?php linkClient('assest/images/icons/favicon.png') ?>" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php linkClient('assest/vendor/bootstrap/css/bootstrap.min.css?ver=' . rand()) ?>">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php linkClient('assest/fonts/font-awesome-4.7.0/css/font-awesome.min.css?ver=' . rand()) ?>">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php linkClient('assest/fonts/iconic/css/material-design-iconic-font.min.css?ver=' . rand()) ?>">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php linkClient('assest/fonts/linearicons-v1.0.0/icon-font.min.css?ver=' . rand()) ?>">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php linkClient('assest/vendor/animate/animate.css?ver=' . rand()) ?>">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php linkClient('assest/vendor/css-hamburgers/hamburgers.min.css?ver=' . rand()) ?>">

	<link rel="stylesheet" type="text/css" href="<?php linkClient('assest/vendor/select2/select2.min.css?ver=' . rand()) ?>">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php linkClient('assest/vendor/daterangepicker/daterangepicker.css?ver=' . rand()) ?>">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php linkClient('assest/vendor/slick/slick.css?ver=' . rand()) ?>">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php linkClient('assest/vendor/MagnificPopup/magnific-popup.css?ver=' . rand()) ?>">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php linkClient('assest/vendor/perfect-scrollbar/perfect-scrollbar.css?ver=' . rand()) ?>">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php linkClient('assest/css/util.css?ver=' . rand()) ?>">
	<link rel="stylesheet" type="text/css" href="<?php linkClient('assest/css/main.css?ver=' . rand()) ?>">
	<link rel="stylesheet" type="text/css" href="<?php linkClient('assest/css/custom.css?ver=' . rand()) ?>">
	<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;0,1000;1,200;1,
	300;1,400;1,500;1,600;1,700;1,800;1,900;1,1000&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
	
	<style>
		.price {
			display: flex;
			justify-content: space-between;
			width: 100%;
			align-items: center;
		}

		.sale {
			text-decoration: line-through;
		}

		.text-danger {
			color: red;
		}
	</style>
	<!--===============================================================================================-->
	<script src="<?php linkClient('assest/vendor/jquery/jquery-3.2.1.min.js') ?>"></script>

</head>