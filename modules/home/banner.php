<?php
$getAllBanner = getRaw("SELECT banner.id as banner_id ,categorysID ,title,categorys.id as categorys_id,image,categorys.slug as categorys_slug,
categorys.name as categorys_name  FROM banner 
INNER JOIN categorys ON banner.categorysID =categorys.id");


$getAllCategory = getRaw("SELECT * FROM categorys");


// echo '<pre>';
// print_r($getAllCategory);
// echo '</pre>';
// die();
?>
<section class="sec-product bg0 p-t-100 p-b-50">
    <div class="container">
        <div class="p-b-32">
            <h3 class="ltext-105 cl5 txt-center respon1">
                Danh mục hot
            </h3>
        </div>

        <!-- Slide2 -->
        <div class="wrap-slick2">
          
            <div class="slick2 slick-initialized slick-slider">
                <div class="slick-list draggable">
                    <div class="slick-track" style="opacity: 1; width: 2400px; transform: translate3d(0px, 0px, 0px);">
                        <?php
                        foreach ($getAllBanner as $key => $item) {
                        ?>
                            <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15 slick-slide slick-current slick-active" data-slick-index="<?php echo $key ?>" aria-hidden="false" tabindex="0" style="width: 300px;">
                                <!-- Block2 -->
                                <div class="block2">
                                    <div class="block2-pic hov-img0">
                                        <img src="<?php echo _WEB_HOST_ROOT . $item['image'] ?>" alt="IMG-PRODUCT">

                                        <a href="<?php echo getLink('category', 'lists', ['id' => $item['categorys_id']]) ?>" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 ">
                                            <?php echo $item['categorys_name'] ?>
                                        </a>
                                    </div>


                                </div>
                            </div>
                        <?php
                        }
                        ?>


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        $('.tabs').click(function() {
            var data = $(this).attr('href');
            var key = data.replace("#", '');
            var html = '';
            $.ajax({
                type: "GET",
                url: "?module=home&action=bannerAjax",
                data: {
                    key: key
                },
                dataType: "html",
                success: function(response) {
                    console.log(response);

                }
            });
        })

    })
</script>