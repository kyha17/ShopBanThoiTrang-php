<?php
$getCategory = getRaw("SELECT * FROM categorys");

?>
<!-- Modal -->

<?php include_once 'modules/auth/list.php' ?>
<footer class="bg3 p-t-75 p-b-32">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-lg-3 p-b-50">
				<h4 class="stext-301 cl0 p-b-30">
					Danh mục
				</h4>

				<ul>
					<?php
					foreach ($getCategory as $item) {
					?>
						<li class="p-b-10">
							<a href="<?php echo getLink('category', 'lists', ['id' => $item['id']]) ?>" class="stext-107 cl7 hov-cl1 trans-04">
								<?php echo $item['name'] ?>
							</a>
						</li>

					<?php
					}

					?>


				</ul>
			</div>

			<div class="col-sm-6 col-lg-3 p-b-50">
				<h4 class="stext-301 cl0 p-b-30">
					Hỗ trợ
				</h4>

				<ul>
					<li class="p-b-10">
						<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
							Chính sách bảo mật
						</a>
					</li>

					<li class="p-b-10">
						<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
							Chính sách trả hàng
						</a>
					</li>

					<li class="p-b-10">
						<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
							Chính sách trả góp
						</a>
					</li>

					<li class="p-b-10">
						<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
							FAQs
						</a>
					</li>
				</ul>
			</div>

			<div class="col-sm-6 col-lg-3 p-b-50">
				<h4 class="stext-301 cl0 p-b-30">
					Liên lạc
				</h4>

				<p class="stext-107 cl7 size-201">
					
Bất kỳ câu hỏi? Hãy cho chúng tôi biết tại cửa hàng ở tầng 8, 379 Hudson St, New York, NY 10018 hoặc gọi cho chúng tôi theo số (+1) 96 716 6879
				</p>

				<div class="p-t-27">
					<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
						<i class="fa fa-facebook"></i>
					</a>

					<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
						<i class="fa fa-instagram"></i>
					</a>

					<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
						<i class="fa fa-pinterest-p"></i>
					</a>
				</div>
			</div>

			<div class="col-sm-6 col-lg-3 p-b-50">
				<h4 class="stext-301 cl0 p-b-30">
					đăng ký nhận khuyến mại
				</h4>

				<form>
					<div class="wrap-input1 w-full p-b-4">
						<input id="email" class="input1 bg-none plh1 stext-107 cl7" type="text" name="email" placeholder="email@example.com">
						<div class="focus-input1 trans-04"></div>
					</div>

					<div class="p-t-18">
						<button id="subscribe" type="button" class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
							Đăng ký
						</button>
					</div>
				</form>
			</div>
		</div>

		<div class="p-t-40">
			<div class="flex-c-m flex-w p-b-18">
				<a href="#" class="m-all-1">
					<img src="<?php echo _WEB_HOST_TEMPLATE.'/assest/images/icons/icon-pay-01.png' ?>" alt="ICON-PAY">
				</a>

				<a href="#" class="m-all-1">
					<img src="<?php echo _WEB_HOST_TEMPLATE.'/assest/images/icons/icon-pay-02.png' ?>" alt="ICON-PAY">
				</a>

				<a href="#" class="m-all-1">
					<img src="<?php echo _WEB_HOST_TEMPLATE.'/assest/images/icons/icon-pay-03.png' ?>" alt="ICON-PAY">
				</a>

				<a href="#" class="m-all-1">
					<img src="<?php echo _WEB_HOST_TEMPLATE.'/assest/images/icons/icon-pay-04.png' ?>" alt="ICON-PAY">
				</a>

				<a href="#" class="m-all-1">
					<img src="<?php echo _WEB_HOST_TEMPLATE.'/assest/images/icons/icon-pay-05.png' ?>" alt="ICON-PAY">
				</a>
			</div>

			<p class="stext-107 cl6 txt-center">
				<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
				Bản quyền &copy;<script>
					document.write(new Date().getFullYear());
				</script> Bảo lưu mọi quyền | Làm với <i class="fa fa-heart-o" aria-hidden="true"></i> qua 
				<a href="https://www.facebook.com/profile.php?id=100026452673905" target="_blank">Mạnh Lê</a> &amp; phân phối bởi <a href="https://themewagon.com" target="_blank">ViboTeam</a>
				<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->

			</p>
		</div>
	</div>
</footer>

<!--===============================================================================================-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<!--===============================================================================================-->
<script src="<?php linkClient('assest/vendor/animsition/js/animsition.min.js') ?>"></script>
<!--===============================================================================================-->
<script src="<?php linkClient('assest/vendor/bootstrap/js/popper.js') ?>"></script>
<script src="<?php linkClient('assest/vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
<!--===============================================================================================-->
<script src="<?php linkClient('assest/vendor/select2/select2.min.js') ?>"></script>
<script>
	$(".js-select2").each(function() {
		$(this).select2({
			minimumResultsForSearch: 20,
			dropdownParent: $(this).next('.dropDownSelect2')
		});
	})
</script>
<!--===============================================================================================-->
<script src="<?php linkClient('assest/vendor/daterangepicker/moment.min.js') ?>"></script>
<script src="<?php linkClient('assest/vendor/daterangepicker/daterangepicker.js') ?>"></script>
<!--===============================================================================================-->
<script src="<?php linkClient('assest/vendor/slick/slick.min.js') ?>"></script>
<script src="<?php linkClient('assest/js/slick-custom.js') ?>"></script>

<!--===============================================================================================-->
<script src="<?php linkClient('assest/vendor/parallax100/parallax100.js') ?>"></script>
<script>
	$('.parallax100').parallax100();
</script>
<!--===============================================================================================-->
<script src="<?php linkClient('assest/vendor/MagnificPopup/jquery.magnific-popup.min.js') ?>"></script>
<script>
	$('.gallery-lb').each(function() { // the containers for all your galleries
		$(this).magnificPopup({
			delegate: 'a', // the selector for gallery item
			type: 'image',
			gallery: {
				enabled: true
			},
			mainClass: 'mfp-fade'
		});
	});
</script>
<!--===============================================================================================-->
<script src="<?php linkClient('assest/vendor/isotope/isotope.pkgd.min.js') ?>"></script>
<!--===============================================================================================-->
<script src="<?php linkClient('assest/vendor/sweetalert/sweetalert.min.js') ?>"></script>
<script>
	$('.js-addwish-b2').on('click', function(e) {
		e.preventDefault();
	});

	$('.js-addwish-b2').each(function() {
		var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
		$(this).on('click', function() {
			swal(nameProduct, "is added to wishlist !", "success");

			$(this).addClass('js-addedwish-b2');
			$(this).off('click');
		});
	});

	$('.js-addwish-detail').each(function() {
		var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

		$(this).on('click', function() {
			swal(nameProduct, "is added to wishlist !", "success");

			$(this).addClass('js-addedwish-detail');
			$(this).off('click');
		});
	});

	/*---------------------------------------------*/

	$('.js-addcart-detail').each(function() {
		var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
		$(this).on('click', function() {
			swal(nameProduct, "is added to cart !", "success");
		});
	});
</script>
<!--===============================================================================================-->
<script src="<?php linkClient('assest/vendor/perfect-scrollbar/perfect-scrollbar.min.js') ?>"></script>
<script>
	$('.js-pscroll').each(function() {
		$(this).css('position', 'relative');
		$(this).css('overflow', 'hidden');
		var ps = new PerfectScrollbar(this, {
			wheelSpeed: 1,
			scrollingThreshold: 1000,
			wheelPropagation: false,
		});

		$(window).on('resize', function() {
			ps.update();
		})
	});
</script>
<!--===============================================================================================-->
<script src="<?php linkClient('assest/js/main.js') ?>"></script>
<script src="<?php linkClient('assest/js/custom.js?ver=1231') ?>"></script>
<script src="<?php linkClient('assest/js/ajax.js?ver=1231') ?>"></script>
<script>
	$(document).ready(function() {
		$('.slick3-dots .slick-active').remove('.slick-active')
	})
</script>
<script>
	$(document).ready(function() {



		$('#subscribe').on('click', function() {
			var email = $('#email').val();

			$.ajax({
				type: "post",
				url: "?module=subscribe&action=subscribeAjax",
				data: {
					email: email
				},
				dataType: 'json',
				success: function(response) {

					if (response.success) {
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Bạn đã đăng ký thành công.',
							showConfirmButton: true,
							timer: 1500
						})

					} else {
						var error = response.errors;
						
						Swal.fire({
							position: 'center',
							icon: 'error',
							title: error,
							showConfirmButton: true,
							timer: 1500
						})
					}

				}
			});
		})


	})

	
</script>

</body>

</html>