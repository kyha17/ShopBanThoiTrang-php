<?php
$getAllCategory = getRaw("SELECT * FROM categorys");


?>
<header class="header-v3">
    <!-- Header desktop -->
    <div class="container-menu-desktop trans-03">
        <div class="wrap-menu-desktop">
            <nav class="limiter-menu-desktop p-l-45">

                <!-- Logo desktop -->
                <a href="#" class="logo">
                    <img src="<?php linkClient('assest/images/icons/logo-02.png"') ?> alt=" IMG-LOGO">
                </a>

                <!-- Menu desktop -->
                <div class="menu-desktop">
                    <li>
                        <a href="<?php echo getLink('home', 'lists') ?>">Trang chủ</a>
                    </li>
                    <ul class="main-menu">
                        <li class="label1" data-label1="hot">
                        <a href="javascript:void(0)">Sản phẩm</a>
                            <ul class="sub-menu">
                                <?php
                                foreach ($getAllCategory as $item) {
                                ?>
                                    <li><a href="<?php echo getLink('category', 'lists', ['id' => $item['id']]) ?>"><?php echo $item['name'] ?></a></li>
                                <?php
                                }

                                ?>

                            </ul>
                        </li>

                        <li>
                            <a href="<?php echo getLink('about','list') ?>">About</a>
                        </li>

                        <li>
                            <a href="<?php echo getLink('contact','list') ?>">Contact</a>
                        </li>
                    </ul>
                </div>

                <!-- Icon header -->
                <div class="wrap-icon-header flex-w flex-r-m h-full">
                    <div class="flex-c-m h-full p-r-25 bor6">
                        <div class="icon-header-item cl0 hov-cl1 trans-04 p-lr-11 icon-header-noti js-show-cart" data-notify="<?php echo (!empty($_SESSION['cart'])?count($_SESSION['cart']):'0')  ?>">
                            <i class="zmdi zmdi-shopping-cart"></i>
                        </div>
                    </div>


                    <?php
                    if (isLoginClient()) {
                    ?>
                        <div class="flex-c-m h-full p-lr-19">
                            <a href="<?php echo getLink('auth', 'logout')  ?>" class="icon-header-item cl0 hov-cl1 trans-04 p-lr-11">
                                <i class="fa-solid fa-right-from-bracket fa-sm" style="color: #f7f7f7;"></i>
                            </a>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="flex-c-m h-full p-lr-19 main-nav">
                            <div class="icon-header-item cl0 hov-cl1 trans-04 p-lr-11 cd-switche cd-signin">
                                <i class="fa-solid fa-user fa-sm" style="color: #ffffff;"></i>
                            </div>
                        </div>
                    <?php
                    }
                    ?>


                </div>
            </nav>
        </div>
    </div>

    <!-- Header Mobile -->
    <div class="wrap-header-mobile">
        <!-- Logo moblie -->
        <div class="logo-mobile">
            <a href="index.html"><img src="images/icons/logo-01.png" alt="IMG-LOGO"></a>
        </div>

        <!-- Icon header -->
        <div class="wrap-icon-header flex-w flex-r-m h-full m-r-15">
            <div class="flex-c-m h-full p-r-5">
                <div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 icon-header-noti js-show-cart" data-notify="2">
                    <i class="zmdi zmdi-shopping-cart"></i>
                </div>
            </div>
        </div>

        <!-- Button show menu -->
        <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </div>
    </div>


    <!-- Menu Mobile -->
    <div class="menu-mobile">
        <ul class="main-menu-m">
            <li>
                <a href="index.html">Home</a>
                <ul class="sub-menu-m">
                    <li><a href="index.html">Homepage 1</a></li>
                    <li><a href="home-02.html">Homepage 2</a></li>
                    <li><a href="home-03.html">Homepage 3</a></li>
                </ul>
                <span class="arrow-main-menu-m">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </span>
            </li>

            <li>
                <a href="product.html">Shop</a>
            </li>

            <li>
                <a href="shoping-cart.html" class="label1 rs1" data-label1="hot">Features</a>
            </li>

            <li>
                <a href="blog.html">Blog</a>
            </li>

            <li>
                <a href="about.html">About</a>
            </li>

            <li>
                <a href="contact.html">Contact</a>
            </li>
        </ul>
    </div>

    <!-- Modal Search -->
    <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
        <button class="flex-c-m btn-hide-modal-search trans-04">
            <i class="zmdi zmdi-close"></i>
        </button>

        <form class="container-search-header">
            <div class="wrap-search-header">
                <input class="plh0" type="text" name="search" placeholder="Search...">

                <button class="flex-c-m trans-04">
                    <i class="zmdi zmdi-search"></i>
                </button>
            </div>
        </form>
    </div>
</header>