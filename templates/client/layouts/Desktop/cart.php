<div class="wrap-header-cart js-panel-cart">
    <div class="s-full js-hide-cart"></div>

    <div class="header-cart flex-col-l p-l-65 p-r-25">
        <div class="header-cart-title flex-w flex-sb-m p-b-8">
            <span class="mtext-103 cl2">
                Giỏ hàng của tôi
            </span>

            <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
                <i class="zmdi zmdi-close"></i>
            </div>
        </div>

        <div class="header-cart-content flex-w js-pscroll">
            <ul class="header-cart-wrapitem w-full">
                <?php
                if (!empty(getSession('cart'))) {
                   $cart = getSession('cart');
                    $coutn = count($cart);
                   
                    if ( $coutn > 0) {
                        $sessionCart = getSession('cart');
                        $tongtien = getSession('tongtien');
                       
                        foreach ($sessionCart as $item) {
                            ?>
                            <li class="header-cart-item flex-w flex-t m-b-12">
                                <div class="header-cart-item-img">
                                    <img src="<?php echo $item['image'] ?>" alt="IMG">
                                </div>

                                <div class="header-cart-item-txt p-t-8">
                                    <a href="<?php echo getLink('detai', 'lists', ['id' => $item['productID']]) ?>" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                        <?php echo $item['name'] ?>
                                    </a>

                                    <span class="header-cart-item-info">
                                        <strong>
                                            <?php echo $item['quantity'] ?>
                                        </strong>
                                        x
                                        <strong>
                                            <?php
                                            if ($item['sale'] == '') {
                                                echo formatPrice($item, 'price');
                                            } else {
                                                echo formatPrice($item, 'sale');
                                            }

                                            ?>
                                        </strong>
                                    </span>
                                </div>
                            </li>
                        <?php
                        }
                    } 
                }


                ?>


            </ul>

            <div class="w-full">
                <div class="header-cart-total w-full p-tb-40">
                    <?php
                    if (!empty($tongtien)) {
                    ?>
                        Tổng tiền: <?php echo formatPrices($tongtien);  ?>

                    <?php
                    }
                    ?>

                </div>

                <div class="header-cart-buttons flex-w w-full" style="justify-content: center;">
                    <a href="<?php echo getLink('order', 'order')  ?>" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
                        Xem giỏ hàng
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>