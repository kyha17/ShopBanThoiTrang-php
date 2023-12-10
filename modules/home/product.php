<?php
$getCategory = getRaw("SELECT * FROM categorys ");





?>

<section class="bg0 p-t-23 p-b-130">
    <div class="container">

        <div class="flex-w flex-sb-m p-b-52 ">
            <div class="flex-w flex-l-m filter-tope-group m-tb-10">

                <h3 class="ltext-103 cl5">
                    Sản phẩm
                </h3>

            </div>
            <div class="flex-w flex-c-m m-tb-10">
                <div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
                    <i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
                    <i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                    Filter
                </div>

                <div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search btnSEARCH">
                    <i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
                    <i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                    Search
                </div>
            </div>


            <!-- Search product -->
            <div class="dis-none panel-search w-full p-t-10 p-b-15">
                <div class="bor8 dis-flex p-l-15">
                    <form>

                        <input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" id="search-product" name="search-product" placeholder="Search">
                    </form>
                </div>
            </div>

        </div>

        <div class="row isotope-grid rowSearch">




        </div>
        <div class="flex-c-m flex-w w-full p-t-45">
            <button id="loadProduct" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
                Xem thêm
            </button>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {
        $('#search-product').on('change',function () {
            var keyword = $(this).val();

            $.ajax({
                url: "?module=home&action=searchAjax",
                type: "POST",
                data: {keyword: keyword},
                success: function(response){
                    $('.rowSearch').removeAttr('style');

                    $('.All').css('display','none')

                    $('.rowSearch').html(response)
                }
            });
        })

        var page = 1; // Trang hiện tại


        function loadData() {
            $.ajax({
                url: "?module=home&action=pagingAjax",
                method: "POST",
                data: {
                    page: page,

                }, // Dữ liệu gửi đi (trang hiện tại và số lượng bản ghi trên mỗi trang)
                success: function(response){
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