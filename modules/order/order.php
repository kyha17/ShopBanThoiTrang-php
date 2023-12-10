<?php
if (!defined('_INCODE')) die('Access Deined...');
$data = [
    'dataTitle' => 'Chi tiết sản phẩm '
];

layout('header', 'client', $data);

if (!empty($_SESSION['cart'])) {
    $cartSession = $_SESSION['cart'];
} else {
    $cartSession = [];
}
if (!empty(getSession('cart'))) {
    $tongtien = getSession('tongtien');
} else {
    unset($_SESSION['tongtien']);
}

// echo '<pre>';
// print_r($_SESSION['cart']);
// echo '</pre>';


?>

<body class="animsition">
    <!-- Header -->
    <?php require_once 'templates/client/layouts/Desktop/header.php' ?>
    <?php require_once 'templates/client/layouts/Desktop/cart.php' ?>
    <!-- Shoping Cart -->
    <form class="bg0  p-b-85" method="post">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                    <div class="m-l-25 m-r--38 m-lr-0-xl">

                        <div class="wrap-table-shopping-cart">
                            <table class="table-shopping-cart">
                                <tr class="table_head">
                                    <th class="column-1">Image</th>
                                    <th class="column-2">Tên sản phẩm</th>
                                    <th class="column-3">Gía</th>
                                    <th class="column-3">Size</th>
                                    <th class="column-4">Số lượng</th>
                                    <th class="column-5">Tổng tiền</th>
                                    <th class="column-5">Xóa</th>
                                </tr>

                                <?php
                                if (!empty($_SESSION['cart'])) {
                                    $allCart = $_SESSION['cart'];
                                } else {
                                    $allCart = [];
                                }

                                $i = 0;
                                $tongtien = 0;

                                foreach ($allCart as $value) {
                                    if ($value['sale'] == '') {
                                        $thanhtien = $value['quantity'] * $value['price'];
                                    } else {
                                        $thanhtien = $value['quantity'] * $value['sale'];
                                    }

                                    $tongtien += $thanhtien;
                                    setSession('tongtien', $tongtien);
                                    $i++;

                                ?>
                                    <tr class="table_row">
                                        <td class="column-1">
                                            <div class="how-itemcart1">
                                                <img src="<?php echo $value['image'] ?>" alt="IMG">
                                            </div>
                                        </td>
                                        <td class="column-2">
                                            <a href="<?php echo getLink('detai', 'lists', ['id' => $value['productID']]) ?>"><?php echo $value['name'] ?></a>
                                        </td>
                                        <?php
                                        if ($value['sale'] == '') {
                                        ?>
                                            <td class="column-3"><?php echo formatPrice($value, 'price')  ?></td>
                                        <?php
                                        } else {
                                        ?>
                                            <td class="column-3"><?php echo formatPrice($value, 'sale') ?></td>
                                        <?php
                                        }

                                        ?>
                                        <td class="column-3">
                                            <?php
                                            $getAllSize = firstRaw("SELECT * FROM properties WHERE id=" . $value['propertieID']);

                                            ?>
                                            <?php echo  $getAllSize['size'] ?>
                                        </td>
                                        <td class="column-3">
                                            <?php echo $value['quantity'] ?>
                                        </td>
                                        <td class="column-4">
                                            <?php echo formatPrices($thanhtien); ?>
                                        </td>

                                        <td class="column-5">
                                            <a href="<?php echo getLink('order', 'deleteOrder', ['id' => $value['productID']]) ?>" style="color: red;">
                                                <i class="fa-solid fa-delete-left fa-xl"></i>
                                            </a>
                                        </td>
                                    </tr>

                                <?php
                                }
                                ?>



                            </table>
                        </div>
                        <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                            <div class="flex-w flex-m m-r-20 m-tb-5">
                                <input class="stext-104 cl2 plh4 size-117 bor13 p-lr-20 m-r-10 m-tb-5" type="text" name="coupon" placeholder="Coupon Code">

                                <div class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5">
                                    Apply coupon
                                </div>
                            </div>

                            <a class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10" href="<?php echo getLink('order', 'deleteAllOrder') ?>">Xóa tất cả</a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                    <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                        <h4 class="mtext-109 cl2 p-b-30">
                            TỔNG GIỎ HÀNG
                        </h4>

                        <div class="flex-w flex-t bor12 p-b-13">
                            <div class="size-208">
                                <span class="stext-110 cl2">
                                    Tổng tiền:
                                </span>
                            </div>

                            <div class="size-209">
                                <span class="mtext-110 cl2">
                                    <?php
                                    if (!empty($tongtien)) {
                                        echo formatPrices($tongtien);
                                    } else {
                                        echo '0đ';
                                    }

                                    ?>
                                </span>
                            </div>
                        </div>

                        <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                            <div class="size-208 w-full-ssm">
                                <span class="stext-110 cl2">
                                    Vận chuyển:
                                </span>
                            </div>

                            <div class=" p-r-18 p-r-0-sm w-full-ssm">
                                <p class="stext-111 cl6 p-t-2">
                                    Không có phương pháp vận chuyển có sẵn.
                                    Vui lòng kiểm tra kỹ địa chỉ của bạn hoặc liên
                                    hệ với chúng tôi nếu bạn cần bất kỳ sự trợ giúp nào.
                                </p>

                                <div class="p-t-15">
                                    <span class="stext-112 cl8">
                                        Địa chỉ
                                    </span>

                                    <div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                        <select id="city" class="js-select2" name="time">
                                            <option value="" selected>Chọn tỉnh thành</option>



                                        </select>
                                        <div class="dropDownSelect2"></div>
                                    </div>


                                    <div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                        <select id="district" class="js-select2" name="time">
                                            <option value="" selected>Chọn quận huyện</option>



                                        </select>
                                        <div class="dropDownSelect2"></div>
                                    </div>


                                    <div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                        <select id="ward" class="js-select2" name="time">
                                            <option value="" selected>Chọn phường xã</option>



                                        </select>
                                        <div class="dropDownSelect2"></div>
                                    </div>

                                    <div class="bor8 bg0 m-b-22">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" id="address" name="address" placeholder="Địa chỉ">
                                    </div>

                                    <div class="flex-w">
                                        <div class="flex-c-m stext-101 cl2 size-115 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer">
                                            Update Totals
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="flex-w flex-t p-t-27 p-b-33">
                            <div class="size-208">
                                <span class="mtext-101 cl2">
                                    Thành tiền:
                                </span>
                            </div>

                            <div class="size-209 p-t-1">
                                <span class="mtext-110 cl2">
                                    <?php
                                    if (!empty($tongtien)) {
                                        echo formatPrices($tongtien);
                                    } else {
                                        echo '0đ';
                                    }

                                    ?>
                                </span>
                            </div>
                        </div>

                        <button id="order" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer" type="button">
                            Xác nhận mua hàng
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            const host = "https://provinces.open-api.vn/api/";
            var callAPI = (api) => {
                return axios.get(api)
                    .then((response) => {
                        renderData(response.data, "city");
                    });
            }
            callAPI('https://provinces.open-api.vn/api/?depth=1');
            var callApiDistrict = (api) => {
                return axios.get(api)
                    .then((response) => {
                        renderData(response.data.districts, "district");
                    });
            }
            var callApiWard = (api) => {
                return axios.get(api)
                    .then((response) => {
                        renderData(response.data.wards, "ward");
                    });
            }

            var renderData = (array, select) => {
                let row = ' <option disable value="">Chọn</option>';
                array.forEach(element => {
                    row += `<option data-id="${element.code}" value="${element.name}">${element.name}</option>`
                });
                document.querySelector("#" + select).innerHTML = row
            }

            $("#city").change(() => {
                callApiDistrict(host + "p/" + $("#city").find(':selected').data('id') + "?depth=2");
                printResult();
            });
            $("#district").change(() => {
                callApiWard(host + "d/" + $("#district").find(':selected').data('id') + "?depth=2");
                printResult();
            });
            $("#ward").change(() => {
                printResult();
            })

            var printResult = () => {
                if ($("#district").find(':selected').data('id') != "" && $("#city").find(':selected').data('id') != "" &&
                    $("#ward").find(':selected').data('id') != "") {
                    let result = $("#city option:selected").text() +
                        " | " + $("#district option:selected").text() + " | " +
                        $("#ward option:selected").text();
                    $("#result").text(result)
                }

            }
        });
    </script>

    <script>
        $('#order').on("click", function() {
            var city = $('#city').val();
            var district = $('#district').val();
            var ward = $('#ward').val();
            var address = $('#address').val();

            $.ajax({
                type: "post",
                url: "?module=order&action=addOrder",
                data: {
                    city: city,
                    district: district,
                    ward: ward,
                    address: address
                },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: response.success,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        setTimeout(function() {
                location.reload();
            }, 1000);
                    }else{
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title:  response.errors,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                 
                }
            });

        })
    </script>
    <?php
    layout('footer', 'client');
    ?>