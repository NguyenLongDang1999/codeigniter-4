<!-- Kế thừa layout frontend -->
<?= $this->extend('layout/frontend/layout'); ?>

<!-- Tiêu đề trang -->
<?= $this->section('title') ?>
Trang chủ
<?= $this->endSection() ?>

<!-- Seo Website -->
<?= $this->section('metaSeo') ?>
<meta name="description" content="CodeIgniter 4 Website thương mại điện tử thanh toán">
<meta name="keywords" content="CodeIgniter 4 WebSite">
<meta name="title" content="TopDeal, Website học tập thử nghiệm CodeIgniter 4">
<?= $this->endSection() ?>

<!-- Link CSS trang -->
<?= $this->section('isLink') ?>
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>
<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="<?= base_url() ?>/css/magnific-popup.css" />
<?= $this->endSection() ?>

<!-- Nội dung trang -->
<?= $this->section('content') ?>
<div class="row">

    <?= view('layout/frontend/catalog') ?>

    <div class="col-lg-9 col-12">
        <div class="slick-slider">
            <?php foreach ($listSlider as $item) { ?>
                <div>
                    <img src="<?= base_url('uploads/slider/' . $item['thumb']) ?>" class="img-fluid" alt="<?= $item['name'] ?>" />
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <!-- product -->
        <div class="product mt-4">
            <h2 class="product__title">
                <span> <?= lang('App.frontend.products.news'); ?> </span>
            </h2>

            <div class="slick-product">
                <?php foreach ($listProductNew as $item) { ?>
                    <div class="product__container mt-4">
                        <div class="product__container-thumb">
                            <a href="<?= base_url('san-pham/' . $item['slug']) ?>">
                                <img src="<?= base_url('uploads/product/' . $item['thumb']) ?>" class="img-fluid" alt="Product" />
                            </a>

                            <ul class="product__container-hover">
                                <li class="product__hover-item">
                                    <a href="javascript:void(0)" id="<?= $item['id'] ?>" class="product__hover-link product__hover-quickview" data-toggle="modal" data-target="#dataModal">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li class="product__hover-item">
                                    <a href="" class="product__hover-link">
                                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li class="product__hover-item">
                                    <a href="javascript:void(0)" class="product__hover-link addToCart" data-id="<?= $item['id'] ?>">
                                        <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="product__container-info">
                            <div class="product__container-name">
                                <a href="<?= base_url('san-pham/' . $item['slug']) ?>" class="product__container-link">
                                    <h2>
                                        <?= $item['name'] ?> - <?= $item['sku'] ?>
                                    </h2>
                                </a>
                            </div>

                            <div class="product__container-view mt-2 text-muted">
                                Lượt xem: <?= $item['view'] ?>
                            </div>

                            <div class="product__contaier-start mt-2">
                                <div class="text-warning">
                                <?php 
                        $sum = 0;
                        $list_review1 = $mreview->where('productid', $item['id'])->orderBy('created_at', 'desc')->findAll();
                        foreach ($list_review1 as $rows) {
                            $sum+= $rows['total'];
                        }
                        $count = count($list_review1);
                        for ($i = 1; $i <= 5; $i++) { 
                            if(!empty($sum) && !empty($count)) {
                                if($i <= floor($sum/$count)) {
                                    echo '<i class="fa fa-star"></i>';
                                } else if(($i) == floor($sum/$count)) {
                                    echo '<i class="fa fa-star-o"></i>';    
                                } else {
                                    echo '<i class="fa fa-star-o"></i>';
                                }
                            } else {
                                echo '<i class="fa fa-star-o"></i>';
                            }
                        }
                        ?>
                                </div>
                            </div>

                            <div class="product__container-price d-flex justify-content-between align-items-center">
                                <?php if ($item['sale'] > 0) { ?>
                                    <div class="product-price">
                                        <div class="price-buy" style="<?= ($item['sale'] > 0) ? '' : 'opacity: 0' ?>"><?= ($item['sale'] > 0) ? number_format(ceil($item['price'] - ($item['price'] * ($item['sale'] / 100))), 0, ",", ".") : '' ?> VNĐ</div>
                                        <div class="price-root"><?= number_format($item['price'], 0, ",", ".") ?> VNĐ</div>
                                    </div>
                                <?php } else { ?>
                                    <div class="product-price">
                                        <div class="price-buy"><?= number_format($item['price'], 0, ",", ".") ?> VNĐ</div>
                                        <div class="price-root" style="<?= ($item['sale'] > 0) ? '' : 'opacity: 0' ?>"><?= ($item['sale'] > 0) ? number_format($item['price'] / ($item['sale'] / 100), 0, ",", ".") : '' ?> VNĐ</div>
                                    </div>
                                <?php } ?>
                                <div class="price-sale <?= ($item['sale'] > 0) ? '' : 'd-none' ?>">-<?= $item['sale'] ?>%</div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <!-- end prodyct -->
    </div>
</div>

<div class="row">
    <div class="col-12">
        <!-- product -->
        <div class="product mt-4">
            <h2 class="product__title">
                <span> <?= lang('App.frontend.products.featured'); ?> </span>
            </h2>

            <div class="slick-product">
                <?php foreach ($listProductFeatured as $item) { ?>
                    <div class="product__container mt-4">
                        <div class="product__container-thumb">
                            <a href="<?= base_url('san-pham/' . $item['slug']) ?>">
                                <img src="<?= base_url('uploads/product/' . $item['thumb']) ?>" class="img-fluid" alt="Product" />
                            </a>

                            <ul class="product__container-hover">
                                <li class="product__hover-item">
                                    <a href="javascript:void(0)" id="<?= $item['id'] ?>" class="product__hover-link product__hover-quickview" data-toggle="modal" data-target="#dataModal">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li class="product__hover-item">
                                    <a href="" class="product__hover-link">
                                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li class="product__hover-item">
                                    <a href="javascript:void(0)" class="product__hover-link addToCart" data-id="<?= $item['id'] ?>">
                                        <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="product__container-info">
                            <div class="product__container-name">
                                <a href="<?= base_url('san-pham/' . $item['slug']) ?>" class="product__container-link">
                                    <h2>
                                        <?= $item['name'] ?> - <?= $item['sku'] ?>
                                    </h2>
                                </a>
                            </div>

                            <div class="product__container-view mt-2 text-muted">
                                Lượt xem: <?= $item['view'] ?>
                            </div>


                            <div class="product__contaier-start mt-2">
                                <div class="text-warning">
                                <?php 
                        $sum = 0;
                        $list_review1 = $mreview->where('productid', $item['id'])->orderBy('created_at', 'desc')->findAll();
                        foreach ($list_review1 as $rows) {
                            $sum+= $rows['total'];
                        }
                        $count = count($list_review1);
                        for ($i = 1; $i <= 5; $i++) { 
                            if(!empty($sum) && !empty($count)) {
                                if($i <= floor($sum/$count)) {
                                    echo '<i class="fa fa-star"></i>';
                                } else if(($i) == floor($sum/$count)) {
                                    echo '<i class="fa fa-star-o"></i>';    
                                } else {
                                    echo '<i class="fa fa-star-o"></i>';
                                }
                            } else {
                                echo '<i class="fa fa-star-o"></i>';
                            }
                        }
                        ?>
                                </div>
                            </div>

                            <div class="product__container-price d-flex justify-content-between align-items-center">
                                <?php if ($item['sale'] > 0) { ?>
                                    <div class="product-price">
                                        <div class="price-buy" style="<?= ($item['sale'] > 0) ? '' : 'opacity: 0' ?>"><?= ($item['sale'] > 0) ? number_format(ceil($item['price'] - ($item['price'] * ($item['sale'] / 100))), 0, ",", ".") : '' ?> VNĐ</div>
                                        <div class="price-root"><?= number_format($item['price'], 0, ",", ".") ?> VNĐ</div>
                                    </div>
                                <?php } else { ?>
                                    <div class="product-price">
                                        <div class="price-buy"><?= number_format($item['price'], 0, ",", ".") ?> VNĐ</div>
                                        <div class="price-root" style="<?= ($item['sale'] > 0) ? '' : 'opacity: 0' ?>"><?= ($item['sale'] > 0) ? number_format($item['price'] / ($item['sale'] / 100), 0, ",", ".") : '' ?> VNĐ</div>
                                    </div>
                                <?php } ?>

                                <div class="price-sale <?= ($item['sale'] > 0) ? '' : 'd-none' ?>">-<?= $item['sale'] ?>%</div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <!-- end prodyct -->
    </div>
</div>

<div class="row">
    <div class="col-12">
        <!-- product -->
        <div class="product mt-4">
            <h2 class="product__title">
                <span> <?= lang('App.frontend.products.views'); ?> </span>
            </h2>

            <div class="slick-product">
                <?php foreach ($listProductMostView as $item) { ?>
                    <div class="product__container mt-4">
                        <div class="product__container-thumb">
                            <a href="<?= base_url('san-pham/' . $item['slug']) ?>">
                                <img src="<?= base_url('uploads/product/' . $item['thumb']) ?>" class="img-fluid" alt="Product" />
                            </a>

                            <ul class="product__container-hover">
                                <li class="product__hover-item">
                                    <a href="javascript:void(0)" id="<?= $item['id'] ?>" class="product__hover-link product__hover-quickview" data-toggle="modal" data-target="#dataModal">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li class="product__hover-item">
                                    <a href="" class="product__hover-link">
                                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li class="product__hover-item">
                                    <a href="javascript:void(0)" class="product__hover-link addToCart" data-id="<?= $item['id'] ?>">
                                        <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="product__container-info">
                            <div class="product__container-name">
                                <a href="<?= base_url('san-pham/' . $item['slug']) ?>" class="product__container-link">
                                    <h2>
                                        <?= $item['name'] ?> - <?= $item['sku'] ?>
                                    </h2>
                                </a>
                            </div>

                            <div class="product__container-view mt-2 text-muted">
                                Lượt xem: <?= $item['view'] ?>
                            </div>


                            <div class="product__contaier-start mt-2">
                                <div class="text-warning">
                                <?php 
                        $sum = 0;
                        $list_review1 = $mreview->where('productid', $item['id'])->orderBy('created_at', 'desc')->findAll();
                        foreach ($list_review1 as $rows) {
                            $sum+= $rows['total'];
                        }
                        $count = count($list_review1);
                        for ($i = 1; $i <= 5; $i++) { 
                            if(!empty($sum) && !empty($count)) {
                                if($i <= floor($sum/$count)) {
                                    echo '<i class="fa fa-star"></i>';
                                } else if(($i) == floor($sum/$count)) {
                                    echo '<i class="fa fa-star-o"></i>';    
                                } else {
                                    echo '<i class="fa fa-star-o"></i>';
                                }
                            } else {
                                echo '<i class="fa fa-star-o"></i>';
                            }
                        }
                        ?>
                                </div>
                            </div>

                            <div class="product__container-price d-flex justify-content-between align-items-center">
                                <?php if ($item['sale'] > 0) { ?>
                                    <div class="product-price">
                                        <div class="price-buy" style="<?= ($item['sale'] > 0) ? '' : 'opacity: 0' ?>"><?= ($item['sale'] > 0) ? number_format(ceil($item['price'] - ($item['price'] * ($item['sale'] / 100))), 0, ",", ".") : '' ?> VNĐ</div>
                                        <div class="price-root"><?= number_format($item['price'], 0, ",", ".") ?> VNĐ</div>
                                    </div>
                                <?php } else { ?>
                                    <div class="product-price">
                                        <div class="price-buy"><?= number_format($item['price'], 0, ",", ".") ?> VNĐ</div>
                                        <div class="price-root" style="<?= ($item['sale'] > 0) ? '' : 'opacity: 0' ?>"><?= ($item['sale'] > 0) ? number_format($item['price'] / ($item['sale'] / 100), 0, ",", ".") : '' ?> VNĐ</div>
                                    </div>
                                <?php } ?>

                                <div class="price-sale <?= ($item['sale'] > 0) ? '' : 'd-none' ?>">-<?= $item['sale'] ?>%</div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <!-- end prodyct -->
    </div>
</div>

<!-- Product By Cat -->
<?php foreach ($listProductByCat as $row) { ?>
    <?php $listCat = $mcatalog->catalogByCat($row['id']) ?>
    <?php $listProduct = $mproduct->productByCat($listCat); ?>
    <!-- Nếu có sản phẩm thì hiển thị danh mục theo sản phẩm -->
    <?php if (count($listProduct)) { ?>
        <div class="row">
            <div class="col-12">
                <!-- product -->
                <div class="product mt-4">
                    <h2 class="product__title">
                        <span> <?= $row['name'] ?> </span>
                    </h2>

                    <div class="slick-product-cat">
                        <?php foreach ($listProduct as $item) { ?>
                            <div class="product__container mt-4">
                                <div class="product__container-thumb">
                                    <a href="<?= base_url('san-pham/' . $item['slug']) ?>">
                                        <img src="<?= base_url('uploads/product/' . $item['thumb']) ?>" class="img-fluid" alt="Product" />
                                    </a>

                                    <ul class="product__container-hover">
                                        <li class="product__hover-item">
                                            <a href="javascript:void(0)" id="<?= $item['id'] ?>" class="product__hover-link product__hover-quickview" data-toggle="modal" data-target="#dataModal">
                                                <i class="fa fa-search" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li class="product__hover-item">
                                            <a href="" class="product__hover-link">
                                                <i class="fa fa-heart-o" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li class="product__hover-item">
                                            <a href="javascript:void(0)" class="product__hover-link addToCart" data-id="<?= $item['id'] ?>">
                                                <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="product__container-info">
                                    <div class="product__container-name">
                                        <a href="<?= base_url('san-pham/' . $item['slug']) ?>" class="product__container-link">
                                            <h2>
                                                <?= $item['name'] ?> - <?= $item['sku'] ?>
                                            </h2>
                                        </a>
                                    </div>

                                    <div class="product__container-view mt-2 text-muted">
                                        Lượt xem: <?= $item['view'] ?>
                                    </div>


                            <div class="product__contaier-start mt-2">
                                <div class="text-warning">
                                <?php 
                        $sum = 0;
                        $list_review1 = $mreview->where('productid', $item['id'])->orderBy('created_at', 'desc')->findAll();
                        foreach ($list_review1 as $rows) {
                            $sum+= $rows['total'];
                        }
                        $count = count($list_review1);
                        for ($i = 1; $i <= 5; $i++) { 
                            if(!empty($sum) && !empty($count)) {
                                if($i <= floor($sum/$count)) {
                                    echo '<i class="fa fa-star"></i>';
                                } else if(($i) == floor($sum/$count)) {
                                    echo '<i class="fa fa-star-o"></i>';    
                                } else {
                                    echo '<i class="fa fa-star-o"></i>';
                                }
                            } else {
                                echo '<i class="fa fa-star-o"></i>';
                            }
                        }
                        ?>
                                </div>
                            </div>

                                    <div class="product__container-price d-flex justify-content-between align-items-center">
                                        <?php if ($item['sale'] > 0) { ?>
                                            <div class="product-price">
                                                <div class="price-buy" style="<?= ($item['sale'] > 0) ? '' : 'opacity: 0' ?>"><?= ($item['sale'] > 0) ? number_format(ceil($item['price'] - ($item['price'] * ($item['sale'] / 100))), 0, ",", ".") : '' ?> VNĐ</div>
                                                <div class="price-root"><?= number_format($item['price'], 0, ",", ".") ?> VNĐ</div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="product-price">
                                                <div class="price-buy"><?= number_format($item['price'], 0, ",", ".") ?> VNĐ</div>
                                                <div class="price-root" style="<?= ($item['sale'] > 0) ? '' : 'opacity: 0' ?>"><?= ($item['sale'] > 0) ? number_format($item['price'] / ($item['sale'] / 100), 0, ",", ".") : '' ?> VNĐ</div>
                                            </div>
                                        <?php } ?>

                                        <div class="price-sale <?= ($item['sale'] > 0) ? '' : 'd-none' ?>">-<?= $item['sale'] ?>%</div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <!-- end prodyct -->
            </div>
        </div>
    <?php } ?>
<?php } ?>

<!-- services -->
<div class="row">
    <div class="col-12">
        <div class="slick-services mt-4">
            <div class="services__block d-flex align-items-center">
                <div class="services__block-icons">
                    <i class="fa fa-truck" aria-hidden="true"></i>
                </div>
                <div class="services__block-title">
                    <span class="d-block text-uppercase font-weight-bold text-white"><?= lang('App.frontend.services.shippingTitle'); ?></span>
                    <span class="text-capitalize text-white"><?= lang('App.frontend.services.shippingText'); ?></span>
                </div>
            </div>

            <div class="services__block d-flex align-items-center">
                <div class="services__block-icons">
                    <i class="fa fa-lock" aria-hidden="true"></i>
                </div>
                <div class="services__block-title">
                    <span class="d-block text-uppercase font-weight-bold text-white"><?= lang('App.frontend.services.securityTitle'); ?></span>
                    <span class="text-capitalize text-white"><?= lang('App.frontend.services.securityText'); ?></span>
                </div>
            </div>

            <div class="services__block d-flex align-items-center">
                <div class="services__block-icons">
                    <i class="fa fa-users" aria-hidden="true"></i>
                </div>
                <div class="services__block-title">
                    <span class="d-block text-uppercase font-weight-bold text-white"><?= lang('App.frontend.services.supportTitle'); ?></span>
                    <span class="text-capitalize text-white"><?= lang('App.frontend.services.supportText'); ?></span>
                </div>
            </div>

            <div class="services__block d-flex align-items-center">
                <div class="services__block-icons">
                    <i class="fa fa-paypal" aria-hidden="true"></i>
                </div>
                <div class="services__block-title">
                    <span class="d-block text-uppercase font-weight-bold text-white"><?= lang('App.frontend.services.paymentTitle'); ?></span>
                    <span class="text-capitalize text-white"><?= lang('App.frontend.services.paymentText'); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- lasted news -->
<div class="row">
    <div class="col-12">
        <!-- product -->
        <div class="product mt-4">
            <h2 class="product__title">
                <span> <?= lang('App.frontend.newsTitle'); ?> </span>
            </h2>

            <div class="slick-post post mt-4">
                <?php foreach ($listPost as $item) { ?>
                    <div class="post__container">
                        <div class="post__container-thumb">
                            <a href="<?= base_url('tin-tuc/' . $item['slug']) ?>">
                                <img src="<?= base_url('uploads/post/' . $item['thumb']) ?>" class="img-fluid" alt="<?= $item['name'] ?>" />
                            </a>
                        </div>

                        <div class="post-info">
                            <div class="post__container-date text-muted">
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                <?= $item['created_at'] ?>
                            </div>
                            <div class="post__container-name">
                                <a href="<?= base_url('tin-tuc/' . $item['slug']) ?>"> <?= $item['name'] ?> </a>
                            </div>

                            <div class="post__contanier-intro text-muted">
                                <?= $item['intro_desc'] ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <!-- end prodyct -->
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
    $(function() {
        // xem nhanh sản phẩm
        $('.product__hover-quickview').on('click', function() {
            var id = $(this).attr('id'); // Lây thuộc tính 
            $.ajax({
                url: "<?= base_url(route_to('modalQuickView')) ?>",
                type: "post",
                data: {
                    id: id,
                },
                success: function(data) {
                    $('#data').html(data);
                    $('#dataModal').modal('show');
                }
            })
        })

        // Thêm giỏ hàng sử dụng chung với modal
        $(document).on('click', '.addToCart', function(e) {
            var id = $(this).attr('data-id'); // Lây thuộc tính 

            $.ajax({
                url: "<?= base_url(route_to('cartAdd')) ?>",
                type: "post",
                data: {
                    id: id,
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

                    toastr["success"]('Thêm thành công sản phẩm vào giỏ hàng');

                    showData();
                    showCartQuantity();
                }
            });
        })
        // end add

        // DelCart
        $(".showCart").on("click", ".delCart", function() {
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

                    showData();
                    showCartQuantity();
                }
            });
        })
        // end del cart
    })
</script>
<?= $this->endSection() ?>