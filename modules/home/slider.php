<?php
$getAllSlide = getRaw("SELECT * FROM slides ");


?>

<section class="section-slide">
    <div class="wrap-slick1 rs2-slick1">
        <div class="slick1">
            <?php
            foreach ($getAllSlide as $item) {
            ?>
                <div class="item-slick1 bg-overlay1" style="background-image: url(<?php echo  _WEB_HOST_ROOT. $item['image'] ?>);" data-thumb="<?php echo $item['image'] ?>" data-caption="<?php echo $item['image'] ?>">
                    <div class="container h-full">
                        <div class="flex-col-c-m h-full p-t-100 p-b-60 respon5">
                            <div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
                                <span class="ltext-202 txt-center cl0 respon2">
                                    <?php echo $item['name'] ?>
                                </span>
                            </div>

                            <div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
                                <h2 class="ltext-104 txt-center cl0 p-t-22 p-b-40 respon1">
                                <?php echo $item['title'] ?>
                                </h2>
                            </div>


                        </div>
                    </div>
                </div>


            <?php
            }
            ?>

        </div>


    </div>
</section>
