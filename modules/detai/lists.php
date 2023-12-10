<?php
if (!defined('_INCODE')) die('Access Deined...');
$body = getBody('get');

$id = $body['id'];

$getAll = firstRaw("SELECT products.id , images,price,sale,name,content,quantity FROM products 
INNER JOIN properties ON properties.productID =products.id WHERE products.id=" . $id);



$getSize = getRaw("SELECT id,size FROM properties  WHERE productID=" . $id);

$getAllImagecontents = getRaw("SELECT * FROM imagecontents WHERE productID =" . $id);



$data = [
	'dataTitle' => 'Chi tiết sản phẩm '
];

layout('header', 'client', $data);
if (isset($_POST['addOrder'])) {
	$body = getBody('get');
	$bodys = getBody();

	$id = $body['id'];

	$getFirstProduct = firstRaw("SELECT * FROM products WHERE id=" . $id);


	$idClient = isLoginClient()['clientID'];
	if ($getFirstProduct) {
		if (!isset($_SESSION['cart'])) {
			$_SESSION['cart'] = array();
		}
		$data = array(
			'name' => $getFirstProduct['name'],
			'image' => $getFirstProduct['images'],
			'productID' => $id,
			'clientID' => $idClient,
			'propertieID' => $bodys['size'],
			'price' => $getFirstProduct['price'],
			'sale' => $getFirstProduct['sale'],
			'quantity' => $bodys['num-product'],
			'createdAt' =>  date('Y-m-d H:i:s')
		);
		if (array_key_exists($id, $_SESSION['cart'])) {
			// Sản phẩm đã tồn tại trong giỏ hàng, tăng số lượng
			$_SESSION['cart'][$id]['quantity'] = $bodys['num-product'];
			$_SESSION['cart'][$id]['size'] = $bodys['size'];
			if ($getFirstProduct['sale'] == '') {
				$_SESSION['cart'][$id]['total'] = $_SESSION['cart'][$id]['quantity'] * $getFirstProduct['price'];
			} else {
				$_SESSION['cart'][$id]['total'] = $_SESSION['cart'][$id]['quantity'] * $getFirstProduct['sale'];
			}
		} else {
			// Sản phẩm chưa tồn tại trong giỏ hàng, thêm vào giỏ hàng
			$_SESSION['cart'][$id] = $data;
		}
	}


	redirect('?module=order&action=order');
}

?>

<body class="animsition">
	<!-- Header -->
	<?php require_once 'templates/client/layouts/Desktop/header.php' ?>

	<?php require_once 'templates/client/layouts/Desktop/cart.php' ?>
	<div class="container">
		<div class="bg0  p-b-30 p-lr-15-lg how-pos3-parent">

			<div class="row">
				<div class="col-md-6 col-lg-7 p-b-30">
					<div class="p-l-25 p-r-30 p-lr-0-lg">
						<div class="wrap-slick3 flex-sb flex-w">
							<div class="wrap-slick3-dots ">
								<ul class="slick3-dots" role="tablist" style="">
									<li class="imgLists" role="presentation">
										<img class="img" src=" <?php echo _WEB_HOST_ROOT.$getAll['images'] ?>">
										<div class="slick3-dot-overlay"></div>
									</li>
									<?php
									foreach ($getAllImagecontents as $item) {
									?>
										<li class="imgLists" role="presentation">
											<img class="img" src=" <?php echo _WEB_HOST_ROOT.$item['links'] ?>">
											<div class="slick3-dot-overlay"></div>
										</li>
									<?php
									}
									?>

								</ul>
							</div>
							<div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

							<div class="slick3 gallery-lb">
								<div class="item-slick3">
									<div class="wrap-pic-w pos-relative imgBox">
										<img class="box" src="<?php echo _WEB_HOST_ROOT.$getAll['images'] ?>" alt="IMG-PRODUCT">

										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" data-toggle="modal" data-target="#exampleModal" href="images/product-detail-01.jpg">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>


							</div>
						</div>
					</div>
				</div>

				<div class="col-md-6 col-lg-5 p-b-30">
					<form method="post" action="">
						<div class="p-r-50 p-t-5 p-lr-0-lg">
							<h4 class="mtext-105 cl2 js-name-detail p-b-14">
								<?php echo $getAll['name'] ?>
							</h4>

							<div class="price" style="width: 200px;">
								<?php
								if ($getAll['sale'] === '') {
								?>
									<span class="mtext-106 cl2">
										<?php echo currency_format($getAll['price']) ?>
									</span>

								<?php
								} else {
								?>
									<span class="mtext-106 cl2">
										<?php echo currency_format($getAll['sale']) ?>
									</span>
									<span class="stext-105 cl3 sale">
										<?php echo currency_format($getAll['price']) ?>
									</span>
								<?php
								}

								?>


							</div>


							<p class="stext-102 cl3 p-t-23">
								<?php echo htmlspecialchars_decode($getAll['content']) ?>
							</p>

							<!--  -->
							<div class="p-t-33">
								<div class="flex-w flex-r-m p-b-10">
									<div class="size-203 flex-c-m respon6">
										Kích thước
									</div>

									<div class="size-204 respon6-next">
										<div class="rs1-select2 bor8 bg0">
											<select class="js-select2" name="size" id="size">
												<option value="null">Chọn kích thước</option>
												<?php
												foreach ($getSize as $item) {
												?>
													<option value="<?php echo $item['id'] ?>"><?php echo $item['size'] ?></option>
												<?php
												}
												?>
											</select>
											<div class="dropDownSelect2"></div>
										</div>
									</div>
								</div>


							</div>

							<div class="flex-w flex-c-m p-b-10 aler">
								<div class="alert alert-danger m-t" role="alert" style="display: none;">Hết hàng! Vui lòng liên hệ 0987111048</div>
								<div class="size-204 flex-c flex-w flex-m respon6-next addGioHang">
									<div class="wrap-num-product flex-w m-r-20 m-tb-10">
										<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
											<i class="fs-16 zmdi zmdi-minus"></i>
										</div>

										<input id="quantity" class="mtext-104 cl3 txt-center num-product" type="number" name="num-product" value="1">

										<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
											<i class="fs-16 zmdi zmdi-plus"></i>
										</div>
									</div>
									<?php
									if (isLoginClient()) {
									
									?>
											<input class="txt-center pointer flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 " 
											name="addOrder" 
											id="addOrder" 
											value="Thêm giỏ hàng" type="submit">

										<?php
										} else{
									    ?>
                                        <div class="alert alert-danger" role="alert">Vui lòng đăng nhâp để mua hàng!</div>

                                    <?php
                                    }


									?>

								</div>
							</div>
						</div>

						<!--  -->
						<div class="flex-w flex-m p-l-100 p-t-40 respon7">
							<div class="flex-m bor9 p-r-10 m-r-11">
								<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100" data-tooltip="Add to Wishlist">
									<i class="zmdi zmdi-favorite"></i>
								</a>
							</div>

							<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Facebook">
								<i class="fa fa-facebook"></i>
							</a>

							<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Twitter">
								<i class="fa fa-twitter"></i>
							</a>

							<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Google Plus">
								<i class="fa fa-google-plus"></i>
							</a>
						</div>
				</div>
				</form>
			</div>
		</div>
	</div>
	</div>



	<?php
	layout('footer', 'client');

	?>
	<script>
		$(document).ready(function() {
			$('.imgLists').click(function(e) {
				e.preventDefault();
				var srcImg = $(this).find('.img').attr('src');
				$('.imgBox').find('.box').attr('src', srcImg);
			});

			$('#size').on('change',function(){
				var id = $(this).val();

				$.ajax({
					type: "post",
					url: "?module=detai&action=changeSizeAjax",
					data: {
						id :id
					},
					dataType: "json",
					success: function (response) {
						var success = response.success;
						var error = response.errors;
						console.log(success);
						if(error == true){
						
							$('.addGioHang').css('display','none')
							$('.alert').removeAttr("style")
						}

						if (success == true) {
							$('.addGioHang').removeAttr("style")
							$('.alert').css('display','none')
						}
					}
				});
			})
		})
	</script>