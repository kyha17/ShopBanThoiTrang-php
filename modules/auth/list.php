<?php

?>

<div class="cd-user-modal"> <!-- this is the entire modal form, including the background -->
		<div class="cd-user-modal-container"> <!-- this is the container wrapper -->
			<ul class="cd-switcher">
				<li><a href="#0">Đăng nhập</a></li>
				<li><a href="#0">Đăng ký</a></li>
			</ul>

			<?php include_once'modules/auth/login.php'  ?>

			<?php include_once'modules/auth/register.php'  ?>

			<?php include_once'modules/auth/forgot.php'  ?>
			<a href="#0" class="cd-close-form">Close</a>
		</div> <!-- cd-user-modal-container -->
	</div> <!-- cd-user-modal -->