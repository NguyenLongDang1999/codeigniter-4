<!-- Kế thừa layout frontend -->
<?= $this->extend('layout/frontend/layout'); ?>

<!-- Tiêu đề trang -->
<?= $this->section('title') ?>
<?= $row['name'] ?>
<?= $this->endSection() ?>

<!-- Seo Website -->
<?= $this->section('metaSeo') ?>
<meta name="description" content="<?= $row['meta_desc'] ?>">
<meta name="keywords" content="<?= $row['meta_keyword'] ?>">
<meta name="title" content="<?= $row['meta_title'] ?>">
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
        <div class="breadcrumbs__title"><?= $row['name'] ?></div>

        <div class="breadcrumbs__url mt-4">
            <ul class="m-0 list-unstyled d-flex flex-wrap justify-content-center">
                <li class="breadcrumbs__url-item">
                    <a class="breadcrumbs__url-link" href="<?= base_url() ?>">Trang chủ</a>
                </li>
                <?php if (isset($parentChild)) { ?>
                    <li class="breadcrumbs__url-item">
                        <a class="breadcrumbs__url-link" href="<?= base_url('danh-muc-tin-tuc/' . $parentChild['slug']) ?>"><?= $parentChild['name'] ?></a>
                    </li>
                <?php } ?>
                <li class="breadcrumbs__url-item">
                    <a class="breadcrumbs__url-link" href="<?= base_url('danh-muc-tin-tuc/' . $child['slug']) ?>"><?= $child['name'] ?></a>
                </li>
                <li class="breadcrumbs__url-item">
                    <a class="breadcrumbs__url-link breadcrumbs__url-active" href="javascript:void(0)"><?= $row['name'] ?></a>
                </li>
            </ul>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<!-- Nội dung trang -->
<?= $this->section('content') ?>
<div class="row">
    <!-- categories -->
    <div class="col-lg-3 d-lg-block d-none">
        <div class="categories">
            <h2 class="categories__title">Danh mục tin tức</h2>

            <ul class="categories__all m-0 list-unstyled mb-5">
                <?php $listPostSubCatalog = $mcatpost->catpostSubCatpost() ?>
                <?php foreach ($listPostSubCatalog as $item) { ?>
                    <?php $listPostSubCatalog1 = $mcatpost->catpostSubCatpost($item['id']) ?>
                    <li class="cat__accordion-item">
                        <div class="d-flex align-items-center justify-content-between">
                            <a class="cat__accordion-link" href="<?= base_url('danh-muc-tin-tuc/' . $item['slug']) ?>"><?= $item['name'] ?></a>
                            <?php if ($listPostSubCatalog1) { ?>
                                <a href="javascript:void(0)" class="cat__accordion-toggle text-black-50"><i class="fa fa-plus" aria-hidden="true"></i></a>
                            <?php } ?>
                        </div>

                        <?php if ($listPostSubCatalog1) { ?>
                            <ul class="cat__accordion-inner m-0 list-unstyled">
                                <?php foreach ($listPostSubCatalog1 as $item1) { ?>
                                    <?php $listPostSubCatalog2 = $mcatpost->catpostSubCatpost($item1['id']) ?>
                                    <li class="cat__accordion-item">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a class="cat__accordion-link" href="<?= base_url('danh-muc-tin-tuc/' . $item1['slug']) ?>"><?= $item1['name'] ?></a>
                                            <?php if ($listPostSubCatalog2) { ?>
                                                <a href="javascript:void(0)" class="cat__accordion-toggle text-black-50"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                            <?php } ?>
                                        </div>

                                        <?php if ($listPostSubCatalog2) { ?>
                                            <ul class="cat__accordion-inner m-0 list-unstyled">
                                                <?php foreach ($listPostSubCatalog2 as $item2) { ?>
                                                    <li>
                                                        <a href="<?= base_url('danh-muc-tin-tuc/' . $item2['slug']) ?>" class="cat__accordion-link"><?= $item2['name'] ?></a>
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


            <h2 class="categories__title">Tất cả danh mục</h2>

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
                    Hàng mới nhất
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
                                    <div class="text-warning">
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
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
            Tất cả danh mục
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
        <div class="detail__post">
            <h1 class="detail__post-title"><?= $row['name'] ?></h1>

            <div class="detail__post-time my-2 text-muted">
                <?= $item['created_at'] ?>
            </div>

            <div class="detail__post-intro">
                <p class="m-0"><?= $row['intro_desc'] ?></p>
            </div>

            <div class="detail__post-detail">
                <?= $row['detail_desc'] ?>
            </div>
        </div>
    </div>
</div>

<!-- end prodyct -->
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