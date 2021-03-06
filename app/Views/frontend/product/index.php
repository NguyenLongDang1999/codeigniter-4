<!-- Kế thừa layout frontend -->
<?= $this->extend('layout/frontend/layout'); ?>

<!-- Tiêu đề trang -->
<?= $this->section('title') ?>
<?= lang('App.frontend.catHome.allCat'); ?>
<?= $this->endSection() ?>

<!-- Seo Website -->
<?= $this->section('metaSeo') ?>
<meta name="description" content="Tất cả sản phẩm Website">
<meta name="keywords" content="Tất cả sản phẩm Website">
<meta name="title" content="Tất cả sản phẩm Website">
<?= $this->endSection() ?>

<!-- Link CSS trang -->
<?= $this->section('isLink') ?>
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="<?= base_url() ?>/css/magnific-popup.css" />
<?= $this->endSection() ?>

<!-- Thanh breadcrumb -->
<?= $this->section('breadcrumbs') ?>
<div class="container-fluid mb-3 p-0">
    <div class="breadcrumbs">
        <div class="breadcrumbs__title"><?= lang('App.frontend.pageProduct.breadcrumbsTitle'); ?></div>

        <div class="breadcrumbs__url mt-4">
            <ul class="m-0 list-unstyled d-flex flex-wrap justify-content-center">
                <li class="breadcrumbs__url-item">
                    <a class="breadcrumbs__url-link" href="<?= base_url() ?>"><?= lang('App.frontend.nav.home'); ?></a>
                </li>
                <li class="breadcrumbs__url-item">
                    <a class="breadcrumbs__url-link breadcrumbs__url-active" href="javascript:void(0)"><?= lang('App.frontend.pageProduct.breadcrumbsTitle'); ?></a>
                </li>
            </ul>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<!-- Nội dung trang -->
<?= $this->section('content') ?>
<!-- categories -->
<div class="row">
    <div class="col-lg-3 d-lg-block d-none">
        <div class="categories">
            <h2 class="categories__title"><?= lang('App.frontend.catHome.allCat'); ?></h2>

            <ul class="categories__all m-0 list-unstyled">
                <?php $listSubCatalog = $mcatalog->catalogSubCatalog() ?>
                <?php foreach ($listSubCatalog as $item) { ?>
                    <?php $listSubCatalog1 = $mcatalog->catalogSubCatalog($item['id']) ?>
                    <li class="cat__accordion-item">
                        <div class="d-flex align-items-center justify-content-between">
                            <a class="cat__accordion-link" href="<?= base_url('danh-muc/' . $item['slug']) ?>"><?= $item['name'] ?></a>
                            <?php if ($listSubCatalog1) { ?>
                                <a href="javascript:void(0)" class="cat__accordion-toggle text-black-50"><i class="fa fa-plus" aria-hidden="true"></i></a>
                            <?php } ?>
                        </div>

                        <?php if ($listSubCatalog1) { ?>
                            <ul class="cat__accordion-inner m-0 list-unstyled">
                                <?php foreach ($listSubCatalog1 as $item1) { ?>
                                    <?php $listSubCatalog2 = $mcatalog->catalogSubCatalog($item1['id']) ?>
                                    <li class="cat__accordion-item">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a class="cat__accordion-link" href="<?= base_url('danh-muc/' . $item1['slug']) ?>"><?= $item1['name'] ?></a>
                                            <?php if ($listSubCatalog2) { ?>
                                                <a href="javascript:void(0)" class="cat__accordion-toggle text-black-50"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                            <?php } ?>
                                        </div>

                                        <?php if ($listSubCatalog2) { ?>
                                            <ul class="cat__accordion-inner m-0 list-unstyled">
                                                <?php foreach ($listSubCatalog2 as $item2) { ?>
                                                    <li>
                                                        <a href="<?= base_url('danh-muc/' . $item2['slug']) ?>" class="cat__accordion-link"><?= $item2['name'] ?></a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        <?php } ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>

            <div class="seller">
                <div class="categories__title mt-5">
                <?= lang('App.frontend.products.news'); ?>
                </div>

                <div class="slick-seller">
                    <?php foreach ($listProductNew as $item) { ?>
                        <div class="row p-2">
                            <div class="col-5">
                                <a href="<?= base_url('san-pham/' . $item['slug']) ?>">
                                    <img src="<?= base_url('uploads/product/' . $item['thumb']) ?>" class="img-fluid" alt="<?= $item['name'] ?>">
                                </a>
                            </div>

                            <div class="col-7">
                                <div class="seller__name">
                                    <a href="<?= base_url('san-pham/' . $item['slug']) ?>">
                                        <?= $item['name'] ?>
                                    </a>
                                </div>

                                <div class="seller__star">
                                    
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
                                </div>

                                <div class="seller__price">
                                    <?php if ($item['sale'] > 0) { ?>
                                        <div class="seller__price-buy">
                                            <?= ($item['sale'] > 0) ? number_format($item['price'] - ($item['price'] * ($item['sale'] / 100)), 0, ",", ".") : '' ?> VNĐ
                                        </div>
                                        <div class="seller__price-root" style="<?= ($item['sale'] > 0) ? '' : 'opacity: 0' ?>">
                                            <?= number_format($item['price'], 0, ",", ".") ?> VNĐ
                                        </div>
                                    <?php } else { ?>
                                        <div class="seller__price-buy">
                                            <?= number_format($item['price'], 0, ",", ".") ?> VNĐ
                                        </div>
                                        <div class="seller__price-root" style="<?= ($item['sale'] > 0) ? '' : 'opacity: 0' ?>">
                                            <?= ($item['sale'] > 0) ? number_format($item['price'] * ($item['sale'] / 100), 0, ",", ".") : '' ?> VNĐ
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- end categories -->

    <div class="col-12 d-lg-none d-block mobile__categories">
        <a href="javascript:void(0)" class="mobile__cat">
            <i class="fa fa-align-left" aria-hidden="true"></i>
            <?= lang('App.frontend.catHome.allCat'); ?>
        </a>

        <div class="categories categories-hide">
            <ul class="categories__all m-0 list-unstyled">
                <li>
                    <a href="javascript:void(0)" class="d-block text-right p-2 text-black-50 categories__mobile-times">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </a>
                </li>
                <?php $listSubCatalog = $mcatalog->catalogSubCatalog() ?>
                <?php foreach ($listSubCatalog as $item) { ?>
                    <?php $listSubCatalog1 = $mcatalog->catalogSubCatalog($item['id']) ?>
                    <li class="cat__accordion-item">
                        <div class="d-flex align-items-center justify-content-between">
                            <a class="cat__accordion-link" href="<?= base_url('danh-muc/' . $item['slug']) ?>"><?= $item['name'] ?></a>
                            <?php if ($listSubCatalog1) { ?>
                                <a href="javascript:void(0)" class="cat__accordion-toggle text-black-50"><i class="fa fa-plus" aria-hidden="true"></i></a>
                            <?php } ?>
                        </div>

                        <?php if ($listSubCatalog1) { ?>
                            <ul class="cat__accordion-inner m-0 list-unstyled">
                                <?php foreach ($listSubCatalog1 as $item1) { ?>
                                    <?php $listSubCatalog2 = $mcatalog->catalogSubCatalog($item1['id']) ?>
                                    <li class="cat__accordion-item">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a class="cat__accordion-link" href="<?= base_url('danh-muc/' . $item1['slug']) ?>"><?= $item1['name'] ?></a>
                                            <?php if ($listSubCatalog2) { ?>
                                                <a href="javascript:void(0)" class="cat__accordion-toggle text-black-50"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                            <?php } ?>
                                        </div>

                                        <?php if ($listSubCatalog2) { ?>
                                            <ul class="cat__accordion-inner m-0 list-unstyled">
                                                <?php foreach ($listSubCatalog2 as $item2) { ?>
                                                    <li>
                                                        <a href="<?= base_url('danh-muc/' . $item2['slug']) ?>" class="cat__accordion-link"><?= $item2['name'] ?></a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        <?php } ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <div class="col-lg-9 col-12">

        <div class="catalog">

            <?php if (count($listCatalogChild)) { ?>
                <div class="catalog__child mb-4">
                    <h2 class="catalog__title"><?= lang('App.frontend.pageProduct.childCat'); ?></h2>

                    <div class="row">
                        <?php foreach ($listCatalogChild as $item) { ?>
                            <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                <div class="catalog__child-thumb mt-4">
                                    <a href="<?= base_url('danh-muc/' . $item['slug']) ?>">
                                        <?php if (isset($item['thumb']) != 'default-image.jpg') { ?>
                                            <img src="<?= base_url('uploads/catalog/' . $item['thumb']) ?>" alt="<?= $item['name'] ?>" class="img-fluid">
                                        <?php } ?>
                                        <img src="<?= base_url('uploads/default-image.jpg') ?>" alt="<?= $item['name'] ?>" class="img-fluid">
                                    </a>
                                </div>

                                <div class="catalog__child-name text-center">
                                    <a class="text-capitalize d-inline-block mt-2" href="<?= base_url('danh-muc/' . $item['slug']) ?>">
                                        <h2><?= $item['name'] ?></h2>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

            <h2 class="catalog__title"><?= lang('App.frontend.catHome.allCat'); ?></h2>

            <?php if (count($listProductAll)) { ?>
                <div class="catalog__filter">
                    <div class="row">
                        <div class="col-4">
                            <span class="catalog__filter-th catalog__filter-main catalog__filter-active">
                                <i class="fa fa-th" aria-hidden="true"></i>
                            </span>
                            <span class="catalog__filter-list catalog__filter-main d-sm-inline-block d-none">
                                <i class="fa fa-list" aria-hidden="true"></i>
                            </span>
                        </div>

                        <div class="col-8">
                            <select class="custom-select" name="filter" id="select__ajax">
                                <?= $select ?>
                            </select>
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="col-3">
                            <input type="text" value="0" name="price1" class="form-control" readonly id="price1">
                        </div>

                        <div class="col-6">
                            <div id="mySlider" class="mySlider mt-3"></div>
                        </div>

                        <div class="col-3">
                            <input type="text" value="1000000" name="price2" class="form-control" readonly id="price2">
                        </div>
                    </div>
                </div>

                <div class="productFilter">
                    <div class="product product__th">
                        <div class="row">
                            <?php foreach ($listProductAll as $item) { ?>
                                <div class="col-md-4 col-6">
                                    <div class="product__container mt-4">
                                        <div class="product__container-thumb">
                                            <a href="<?= base_url('san-pham/' . $item['slug']) ?>">
                                                <img src="<?= base_url('uploads/product/' . $item['thumb']) ?>" class="img-fluid" alt="<?= $item['name'] ?>" />
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
                                                        <?= $item['name'] ?>
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
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="product__list" style="display: none">
                        <?php foreach ($listProductAll as $item) { ?>
                            <div class="row">
                                <div class="col-4">
                                    <a href="<?= base_url('san-pham/' . $item['slug']) ?>">
                                        <img src="<?= base_url('uploads/product/' . $item['thumb']) ?>" class="img-fluid" alt="<?= $item['name'] ?>" />
                                    </a>
                                </div>
                                <div class="col-8">
                                    <div class="product__list-name">
                                        <a href="<?= base_url('san-pham/' . $item['slug']) ?>">
                                            <h2>
                                                <?= $item['name'] ?>
                                            </h2>
                                        </a>
                                    </div>

                                    <div class="product__container-view mt-2 text-muted">
                                        Lượt xem: <?= $item['view'] ?>
                                    </div>

                                    <div class="product__container-view mt-2 text-muted">
                                        <?= $item['intro_desc'] ?>
                                    </div>

                                    <div class="product__list-price d-flex justify-content-between align-items-center">

                                        <?php if ($item['sale'] > 0) { ?>
                                            <div class="price">
                                                <div class="price-buy" style="<?= ($item['sale'] > 0) ? '' : 'opacity: 0' ?>"><?= ($item['sale'] > 0) ? number_format(ceil($item['price'] - ($item['price'] * ($item['sale'] / 100))), 0, ",", ".") : '' ?> VNĐ</div>
                                                <div class="price-root"><?= number_format($item['price'], 0, ",", ".") ?> VNĐ</div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="price">
                                                <div class="price-buy"><?= number_format($item['price'], 0, ",", ".") ?> VNĐ</div>
                                                <div class="price-root" style="<?= ($item['sale'] > 0) ? '' : 'opacity: 0' ?>"><?= ($item['sale'] > 0) ? number_format($item['price'] / ($item['sale'] / 100), 0, ",", ".") : '' ?> VNĐ</div>
                                            </div>
                                        <?php } ?>
                                        <div class="sale <?= ($item['sale'] > 0) ? '' : 'd-none' ?>">-<?= $item['sale'] ?>%</div>
                                    </div>

                                    <div class="product__list-btn mt-3">
                                        <a href="javascript:void(0)" class="product__list-link mb-1 addToCart" data-id="<?= $item['id'] ?>"><i class="fa fa-shopping-basket pr-2" aria-hidden="true"></i><?= lang('App.frontend.products.addToCart'); ?></a>
                                        <a href="javascript:void(0)" class="product__list-link mb-1"><i class="fa fa-heart-o pr-2" aria-hidden="true"></i><?= lang('App.frontend.products.heart'); ?>
                                            </a>
                                        <a href="javascript:void(0)" id="<?= $item['id'] ?>" class="product__list-link product__hover-quickview" data-toggle="modal" data-target="#dataModal"><i class="fa fa-search pr-2" aria-hidden="true"></i><?= lang('App.frontend.products.quickView'); ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>
                <?php if (count($listProductAll) >= 12) { ?>
                    <?= $pager->links() ?>
                <?php } ?>
            <?php } else { ?>
                <div class="text-center">
                    <h2 class="text-capitalize text-danger d-inline-block mt-5 ">Danh mục này tạm thời chưa có sản phẩm nào. Vui lòng quay lại sau.</h2>
                </div>
            <?php } ?>
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
    $(function() {
        function showFilterPrice() {
            var price1 = $('#price1').val();
            var price2 = $('#price2').val();

            $.ajax({
                url: "<?= base_url(route_to('showProductFilter')) ?>",
                type: "post",
                data: {
                    price1: price1,
                    price2: price2
                },
                success: function (data) {
                    $(".productFilter").html(data);
                }
            })
        }

        $("#mySlider").slider({
            range: true,
            min: 0,
            max: 1000000,
            values: [0, 1000000],
            step: 10000,
            slide: function(event, ui) {
                $('#price').html(ui.values[0] + ' - ' + ui.values[1]);
                $("#price1").val(ui.values[0]);
                $("#price2").val(ui.values[1]);
                showFilterPrice();
            }
        });

        $("#price").html("" + $("#mySlider").slider("values", 0) +
            " - " + $("#mySlider").slider("values", 1));


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

        $(document).on('change', '#select__ajax', function(e) {
            var filter = $(this).val(); // lấy giá trị select 

            $.ajax({
                url: "<?= base_url(route_to('productIndexFEPost')) ?>",
                type: "post",
                data: {
                    filter: filter,
                },
                dataType: 'json',
                success: function(data) {
                    $('.productFilter').html(data);
                }
            })
        });

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
                        "timeOut": "3000",
                        "hideDuration": "1000",
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