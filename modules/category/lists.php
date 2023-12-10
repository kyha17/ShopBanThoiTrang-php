<?php
if (!defined('_INCODE')) die('Access Deined...');
$body = getBody('get');

$id = $body['id'];

$getAllProduct = getRaw("SELECT * FROM products WHERE categoryID = " . $id);

$getCategorys = firstRaw("SELECT id,name FROM categorys WHERE id=" . $id);
$categoryName = $getCategorys['name'];


$data = [
	'dataTitle' => 'Sản phẩm ' . $categoryName
];

layout('header', 'client', $data);


?>


<body class="animsition">
	<!-- Header -->
	<?php require_once 'templates/client/layouts/Desktop/header.php' ?>

	<?php require_once 'templates/client/layouts/Desktop/cart.php' ?>

	
	<div class="bg0 m-t-23 p-b-140">
		<div class="container">
			<div style="margin: 20px 0;">
				<h1><?php echo $categoryName ?></h1>
			</div>
			<div class="row isotope-grid rowSearch" style="position: relative; height: 1721.6px;">
				<?php
				if (count($getAllProduct) < 20) {
					foreach ($getAllProduct as $item) {
				?>
						<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women" style="position: absolute; left: 0%; top: 0px;">
							<!-- Block2 -->
							<div class="block2">
								<div class="block2-pic hov-img0">
									<img src="<?php echo _WEB_HOST_ROOT. $item['images'] ?>" alt="IMG-PRODUCT">

									<a href="<?php echo getLink('detai', 'lists', ['id' => $item['id']]) ?>" class="btnShow block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 ">
										Xem nhanh
									</a>
								</div>

								<div class="block2-txt flex-w flex-t p-t-14">
									<div class="block2-txt-child1 flex-col-l ">
										<a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
											<?php echo $item['name'] ?>
										</a>



										<?php

										if ($item['sale'] === '') {
										?>
											<div class="price">
												<span class="stext-105 cl3 ">
													<?php echo currency_format($item['price']) ?>
												</span>

											</div>
										<?php
										} else {
										?>
											<div class="price">
												<span class="stext-105 cl3">
													<?php echo currency_format($item['sale']) ?>
												</span>
												<span class="stext-105 cl3 sale">
													<?php echo currency_format($item['price']) ?>
												</span>
											</div>
										<?php
										} ?>


									</div>

								</div>
							</div>
						</div>

					<?php
					}
				} else {
					?>
					<!-- Load more -->
					<div class="flex-c-m flex-w w-full p-t-45">
						<a href="#"  class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
							Load More
						</a>
					</div>
				<?php
				}

				?>
			</div>

            <!-- Load more -->
            <div class="flex-c-m flex-w w-full p-t-45">
                <button id="loadProduct" data-id="<?php echo $id; ?>" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
                    Xem thêm
                </button>
            </div>
		</div>

	</div>

    <script>
        $(document).ready(function () {
            var page = 1; // Trang hiện tại
            var id = $('#loadProduct').attr('data-id');


            function loadData() {
                $.ajax({
                    url: "?module=category&action=pagingAjax",
                    method: "POST",
                    data: {
                        page: page,
                        id:id

                    }, // Dữ liệu gửi đi (trang hiện tại và số lượng bản ghi trên mỗi trang)
                    success: function(response){
                        console.log(response)
                        $('.rowSearch').removeAttr('style');
                        $('.rowSearch').html(response)
                    }
                });
            }
            loadData();
            $('#loadProduct').on('click',function () {
                page++;
                loadData();

            })
        })
    </script>

	<?php
	layout('footer', 'client');

	?>