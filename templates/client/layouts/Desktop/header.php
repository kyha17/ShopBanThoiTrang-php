<?php
$getAllCategory = getRaw("SELECT * FROM categorys");


?>
<header class="header-v4">
    <!-- Header desktop -->
    <div class="container-menu-desktop">
        

        <div class="wrap-menu-desktop how-shadow1">
            <nav class="limiter-menu-desktop container">

                <!-- Logo desktop -->
                <a href="<?php echo getLink('home','lists')  ?>" class="logo">
                    <img src="<?php linkClient('assest/images/icons/logo-01.png"') ?> alt="IMG-LOGO">
                </a>

                <!-- Menu desktop -->
                <div class="menu-desktop">
                    <li>
                        <a href="<?php echo getLink('home','lists')  ?>">Trang chủ</a>
                    </li>
                    <ul class="main-menu">
                        <li class="label1" data-label1="hot">
                            <a href="javascript:void(0)">Cửa hàng</a>
                            <ul class="sub-menu">
                                <?php
                                foreach ($getAllCategory as $item) {
                                ?>
                                    <li><a href="<?php echo getLink('category','lists',['id' => $item['id']]) ?>"><?php echo $item['name'] ?></a></li>
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
                <div class="wrap-icon-header flex-w flex-r-m">
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                        <i class="zmdi zmdi-search"></i>
                    </div>

                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" data-notify="<?php echo (!empty($_SESSION['cart'])?count($_SESSION['cart']):'0')  ?>">
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </div>

                    <?php
                    if (isLoginClient()) {
                    ?>
                        <div class="flex-c-m h-full p-lr-19">
                            <a href="<?php echo getLink('auth', 'logout')  ?>" class="icon-header-item cl0 hov-cl1 trans-04 p-lr-11">
                                <i class="fa-solid fa-right-from-bracket fa-sm" style="color: #000000;"></i>
                            </a>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="flex-c-m h-full p-lr-19 main-nav">
                            <div class="icon-header-item cl0 hov-cl1 trans-04 p-lr-11 cd-switche cd-signin">
                                <i class="fa-solid fa-user fa-sm" style="color: #000000;"></i>
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
        <div class="wrap-icon-header flex-w flex-r-m m-r-15">
            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
                <i class="zmdi zmdi-search"></i>
            </div>

            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart" data-notify="2">
                <i class="zmdi zmdi-shopping-cart"></i>
            </div>

            <a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti" data-notify="0">
                <i class="zmdi zmdi-favorite-outline"></i>
            </a>
        </div>

        <!-- Button show menu -->
        <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </div>
    </div>


    <!-- Menu Mobile -->
    <div class="menu-mobile" style="display: none;">
       
        <ul class="main-menu-m">
            <li>
                <a href="product.html">Trang chủ</a>
            </li>
            <ul class="main-menu">
                <li class="label1" data-label1="hot">
                    <a href="index.html">Cửa hàng</a>
                    <ul class="sub-menu">
                                                    <li><a href="index.html">Quần áo</a></li>
                                                    <li><a href="index.html">Quần áo nam</a></li>
                                                    <li><a href="index.html">Quần áo nữ</a></li>
                        
                    </ul>
                </li>

                <li>
                    <a href="about.html">About</a>
                </li>

                <li>
                    <a href="contact.html">Contact</a>
                </li>
            </ul>
        </ul>
    </div>

    <!-- Modal Search -->
    <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
        <div class="container-search-header">
            <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                <img src="images/icons/icon-close2.png" alt="CLOSE">
            </button>

            <form class="wrap-search-header flex-w p-l-15">
                <button class="flex-c-m trans-04">
                    <i class="zmdi zmdi-search"></i>
                </button>
                <input class="plh3" type="text" name="search" placeholder="Search...">
            </form>
        </div>
    </div>
</header>