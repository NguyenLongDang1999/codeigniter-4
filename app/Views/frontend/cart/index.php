<!-- Kế thừa layout frontend -->
<?= $this->extend('layout/frontend/layout'); ?>

<!-- Tiêu đề trang -->
<?= $this->section('title') ?>
Tất cả sản phẩm
<?= $this->endSection() ?>

<!-- Seo Website -->
<?= $this->section('metaSeo') ?>
<meta name="description" content="Giỏ hàng của Website">
<meta name="keywords" content="Giỏ hàng của Website">
<meta name="title" content="Giỏ hàng của Website">
<?= $this->endSection() ?>

<!-- Link CSS trang -->
<?= $this->section('isLink') ?>
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>
<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="<?= base_url() ?>/css/magnific-popup.css" />
<?= $this->endSection() ?>

<!-- Thanh breadcrumb -->
<?= $this->section('breadcrumbs') ?>
<div class="container-fluid mb-3 p-0">
    <div class="breadcrumbs">
        <div class="breadcrumbs__title"><?= lang('App.frontend.cart.cartTitle') ?></div>

        <div class="breadcrumbs__url mt-4">
            <ul class="m-0 list-unstyled d-flex flex-wrap justify-content-center">
                <li class="breadcrumbs__url-item">
                    <a class="breadcrumbs__url-link" href="<?= base_url() ?>"><?= lang('App.frontend.nav.home') ?></a>
                </li>
                <li class="breadcrumbs__url-item">
                    <a class="breadcrumbs__url-link breadcrumbs__url-active" href="javascript:void(0)"><?= lang('App.frontend.cart.cartTitle') ?></a>
                </li>
            </ul>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<!-- Nội dung trang -->
<?= $this->section('content') ?>

<div class="cart">
    <div class="row">
        <div class="col-lg-8 p-0">
            <div class="table-responsive">
                <table class="table table-centered mb-0 table-nowrap">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 120px" class="text-truncate">Image</th>
                            <th style="width: 20%" class="text-truncate"><?= lang('App.frontend.cart.cartName') ?></th>
                            <th><?= lang('App.frontend.cart.cartPrice') ?></th>
                            <th class="text-truncate"><?= lang('App.frontend.cart.cartQty') ?></th>
                            <th colspan="2" class="text-truncate"><?= lang('App.frontend.cart.cartTotal') ?></th>
                        </tr>
                    </thead>
                    <tbody class="showCartData">

                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="border p-3 mt-4 mt-lg-0 rounded">
                <h4 class="header-title mb-3 text-capitalize"><?= lang('App.frontend.cart.order') ?></h4>

                <div class="table-responsive">
                    <table class="table mb-0">
                        <tbody class="text-capitalize showTotal">

                        </tbody>
                    </table>
                </div>
                <!-- end table-responsive -->
            </div>

            <?php if(session()->get('cart')) { ?>
            <div class="alert alert-warning mt-3" role="alert">
                Nhập mã coupon <strong>GIAMGIA250K</strong> để giảm giá 250.000 VNĐ trong lần đầu mua hàng !
            </div>

            <div class="input-group mt-3">
                <input type="text" class="form-control form-control-light" name="coupon" placeholder="Coupon code" aria-label="Recipient's username">
                <div class="input-group-append">
                    <button class="btn btn-light border btn-coupon" type="button">Apply</button>
                </div>
            </div>
            <div class="text-danger mt-2 result"></div>
            <?php } ?>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <a href="<?= base_url(route_to('productIndexFE')) ?>" class="btn btn-danger btn-sm text-capitalize">
                    <?= lang('App.frontend.cart.continue') ?>
                </a>
                <a href="<?= base_url(route_to('checkoutIndex')) ?>" class="btn btn-secondary btn-sm text-uppercase">
                <?= lang('App.frontend.cart.cartCheckout') ?>
                </a>
            </div>
        </div>
    </div>
</div>
</div>
<?= $this->endSection() ?>

<?= $this->section('isScript') ?>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<!-- Jquery Cookie JS -->
<script src="<?= base_url() ?>/js/jquery-cookie.js"></script>
<!-- Magnific JS -->
<script src="<?= base_url() ?>/js/jquery.magnific-popup.min.js"></script>
<?= $this->endSection() ?>

<?= $this->section('isAjax') ?>
<script>
    function showCartData() {
        $.post("<?= base_url(route_to('showCartData')) ?>", function(data) {
            $(".showCartData").html(data);
        });
    }

    function showTotal() {
        $.post("<?= base_url(route_to('showTotal')) ?>", function(data) {
            $(".showTotal").html(data);
        });
    }
    showCartData();
    showTotal();

    $(function() {
        $(document).on("click", ".btn-coupon", function() {
            var coupon = $(this).parent().prev().val();

            $.ajax({
                url: "<?= base_url(route_to('applyCoupon')) ?>",
                type: "post",
                data: {
                    coupon: coupon
                },
                dataType: 'json',
                success: function(data) {
                    $('.result').html(data);
                    showTotal();
                }
            })
        });

        // DelCart
        $(".showCartData").on("click", ".delCart", function() {
            var id = $(this).attr('id'); // Lây thuộc tính 
            $.ajax({
                url: "<?= base_url(route_to('cartDel')) ?>",
                type: "post",
                data: {
                    id: id
                },
                success: function(data) {
                    toastr.options = {
                        "closeButton": true,
                        "debug": true,
                        "newestOnTop": false,
                        "progressBar": true,
                        "positionClass": "toast-bottom-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "3000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }

                    toastr["success"]('Xoá thành công sản phẩm')

                    showCartData();
                    showData();
                    showCartQuantity();
                    showTotal();
                }
            });
        })
        // end del cart

        // edit cart
        $(document).on("click", ".qtyBtn.plus", function() {

            var id = $(this).prev().attr('id'); // Lây thuộc tính 
            var sl = $(this).prev().val(); // Lấy giá trị value trong input
            $.ajax({
                url: "<?= base_url(route_to('cartEdit')) ?>",
                type: "post",
                data: {
                    id: id,
                    sl: sl
                },
                success: function(data) {
                    toastr.options = {
                        "closeButton": true,
                        "debug": true,
                        "newestOnTop": false,
                        "progressBar": true,
                        "positionClass": "toast-bottom-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "3000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }

                    toastr["success"]('Cập nhật số lượng thành công');

                    showCartData();
                    showData();
                    showCartQuantity();
                    showTotal();
                }
            });
        })

        $(document).on("click", ".qtyBtn.minus", function() {

            var id = $(this).next().attr('id'); // Lây thuộc tính 
            var sl = $(this).next().val(); // Lấy giá trị value trong input
            $.ajax({
                url: "<?= base_url(route_to('cartEdit')) ?>",
                type: "post",
                data: {
                    id: id,
                    sl: sl
                },
                success: function(data) {
                    if (sl > 2) {
                        toastr.options = {
                            "closeButton": true,
                            "debug": true,
                            "newestOnTop": false,
                            "progressBar": true,
                            "positionClass": "toast-bottom-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "3000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }

                        toastr["success"]('Cập nhật số lượng thành công');
                    }
                    showCartData();
                    showData();
                    showCartQuantity();
                    showTotal();
                }
            });
        })
    })
</script>
<?= $this->endSection() ?>