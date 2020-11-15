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
                <li class="breadcrumbs__url-item">
                    <a class="breadcrumbs__url-link" href="<?= base_url('danh-muc/' . $parent['slug']) ?>"><?= $parent['name'] ?></a>
                </li>
                <?php if (isset($parentChild)) { ?>
                    <li class="breadcrumbs__url-item">
                        <a class="breadcrumbs__url-link" href="<?= base_url('danh-muc/' . $parentChild['slug']) ?>"><?= $parentChild['name'] ?></a>
                    </li>
                <?php } ?>
                <?php if (isset($catalogName)) { ?>
                    <li class="breadcrumbs__url-item">
                        <a class="breadcrumbs__url-link" href="<?= base_url('danh-muc/' . $catalogName['slug']) ?>"><?= $catalogName['name'] ?></a>
                    </li>
                <?php } ?>
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
        <div class="detail">
            <div class="row details">
                <div class="col-md-6">
                    <div class="slick-for-carousel">
                        <a href="<?= base_url('uploads/product/' . $row['thumb']) ?>"><img src="<?= base_url('uploads/product/' . $row['thumb']) ?>" class="img-fluid" alt="<?= $row['name'] ?>" /></a>
                        <?php $thumbList = explode(',', $row['thumb_list']); ?>
                        <?php foreach ($thumbList as $img) { ?>
                            <a href="<?= base_url('uploads/product/' . $img) ?>"><img src="<?= base_url('uploads/product/' . $img) ?>" class="img-fluid" alt="<?= $row['name'] ?>" /></a>
                        <?php } ?>
                    </div>

                    <div class="slick-nav-carousel mt-3">
                        <div>
                            <img src="<?= base_url('uploads/product/' . $row['thumb']) ?>" class="img-fluid" alt="<?= $row['name'] ?>" />
                        </div>
                        <?php foreach ($thumbList as $img) { ?>
                            <div>
                                <img src="<?= base_url('uploads/product/' . $img) ?>" class="img-fluid" alt="<?= $row['name'] ?>" />
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <h2 class="detail__product-name mt-3 mt-md-0">
                        <?= $row['name'] ?> - <?= $row['sku'] ?>
                    </h2>

                    <div class="detail-product-star d-flex flex-wrap my-2">
                        <div class="text-warning mr-4">
                            <?php
                            $sum = 0;
                            foreach ($list_review as $item) {
                                $sum += $item['total'];
                            }
                            $count = count($list_review);
                            for ($i = 1; $i <= 5; $i++) {
                                if (!empty($sum) && !empty($count)) {
                                    if ($i <= floor($sum / $count)) {
                                        echo '<i class="fa fa-star"></i>';
                                    } else if (($i) == floor($sum / $count)) {
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
                        <p class="text-muted">
                            <?= (count($list_review) > 0) ? '(Có ' . count($list_review) . ' đánh giá cho sản phẩm này.)' : '(Chưa có đánh giá nào cho sản phẩm này.)' ?>
                        </p>
                    </div>

                    <div class="detail__product-price">
                        <?php if ($row['sale'] > 0) { ?>
                            <span class="price-buy" style="<?= ($row['sale'] > 0) ? '' : 'opacity: 0' ?>"><?= ($row['sale'] > 0) ? number_format(ceil($row['price'] - ($row['price'] * ($row['sale'] / 100))), 0, ",", ".") : '' ?> VNĐ</span>
                            <span class="price-root"><?= number_format($row['price'], 0, ",", ".") ?> VNĐ</span>
                        <?php } else { ?>
                            <span class="price-buy"><?= number_format($row['price'], 0, ",", ".") ?> VNĐ</span>
                            <span class="price-root" style="<?= ($row['sale'] > 0) ? '' : 'opacity: 0' ?>"><?= ($row['sale'] > 0) ? number_format($row['price'] / ($row['sale'] / 100), 0, ",", ".") : '' ?> VNĐ</span>
                        <?php } ?>
                    </div>

                    <div class="detail__product-info mt-3">
                        <p class="text-capitalize m-0">
                            Mã sản phẩm: <span class="text-muted ml-2"><?= $row['sku'] ?></span>
                        </p>
                        <?php if (isset($brandName['name'])) { ?>
                            <p class="text-capitalize m-0">
                                Thương hiệu: <span class="text-muted ml-2"><?= isset($brandName['name']) ? $brandName['name'] : '' ?></span>
                            </p>
                        <?php } ?>
                        <p class="text-capitalize m-0">
                            Danh mục: <span class="text-muted ml-2"><?= $catalogName['name'] ?></span>
                        </p>
                        <p class="text-capitalize m-0">
                            Tình trạng: <span class="text-muted ml-2">Còn hàng</span>
                        </p>
                        <p class="text-capitalize m-0">
                            Lượt xem: <span class="text-muted ml-2"><?= $row['view'] ?></span>
                        </p>
                    </div>

                    <div class="detail__product-btn">
                        <a href="javascript:void(0)" class="product__detail-link addToCart" data-id="<?= $row['id'] ?>"><i class="fa fa-shopping-basket pr-2" aria-hidden="true"></i><?= lang('App.frontend.products.addToCart'); ?></a>
                        <a href="javascript:void(0)" class="product__detail-link"><i class="fa fa-heart-o pr-2" aria-hidden="true"></i><?= lang('App.frontend.products.heart'); ?>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row mt-5 details">
                <div class="col-12">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">
                                <?= lang('App.frontend.detail.detailProduct') ?>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false"><?= lang('App.frontend.detail.review') ?></a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="detail__product-desc">
                                <?= $row['detail_desc'] ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <div class="detail__product-write">
                                <div class="review">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-4">
                                            <?php if (session()->has('userAll')) { ?>
                                                <div class="spr-form clearfix">
                                                    <form method="post" action="<?= base_url(route_to('productComment')) ?>" id="new-review-form" class="new-review-form">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="productid" value="<?= $row['id'] ?>" id="productid-cmt">
                                                        <h3 class="spr-form-title">Viết bài đánh giá cho riêng bạn</h3>
                                                        <fieldset class="spr-form-contact">
                                                            <div class="spr-form-review-rating">
                                                                <label class="spr-form-label text-capitalize">Chọn số sao bạn muốn đánh
                                                                    giá?<span class="required">*</span></label>
                                                                <div class="spr-form-input spr-starrating">
                                                                    <select id="rate" class="select-rate">
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                    </select>
                                                                    <p class="m-0 text-danger" id="error-cmt"></p>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <fieldset class="spr-form-review">
                                                            <div class="spr-form-review-body">
                                                                <label class="spr-form-label" for="message">Viết đánh giá</label>
                                                                <div class="spr-form-input">
                                                                    <textarea class="spr-form-input spr-form-input-textarea body-cmt form-control border-radius-0" id="message" name="message" rows="5"></textarea>
                                                                    <p class="m-0 text-danger" id="error-cmt"></p>

                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="spr-form-actions">
                                                            <input type="submit" class="spr-button btn-cmt spr-button-primary button button-primary btn btn-dark btn-sm border-radius-0" value="Gửi đánh giá">
                                                        </div>
                                                    </form>
                                                </div>
                                            <?php } else { ?>
                                                <h4 class="spr-form-title text-danger text-center">Bạn vui lòng đăng nhập để viết đánh giá
                                                    của mình về sản phẩm này.</h4>
                                            <?php } ?>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="spr-reviews">
                                                <h3 class="spr-form-title">Khánh hàng đánh giá</h3>
                                                <div class="review-inner" id="review-inner">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 p-0">
                    <!-- product -->
                    <div class="product mt-4">
                        <h2 class="product__title">
                            <span> <?= lang('App.frontend.detail.related') ?> </span>
                        </h2>

                        <div class="slick-product">
                            <?php if (count($listProductRelated)) { ?>
                                <?php foreach ($listProductRelated as $item) { ?>
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
                            <?php } else { ?>
                                <div class="text-center">
                                    <h2 class="text-capitalize text-danger d-inline-block mt-5 ">Sản phẩm này hiện không có các sản phẩm liên quan khác. Vui lòng quay lại sau.</h2>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
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
    $('#rate').barrating({
        theme: 'fontawesome-stars'
    });
    $(function() {
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

        // coment
        function showComment() {
            $.post("<?= base_url(route_to('productShowComment', $row['id'])) ?>", function(data) {
                $("#review-inner").html(data);
            });
        }

        showComment();

        // comment  AJAX
        $('.btn-cmt').on('click', function(e) {
            e.preventDefault();
            var rate = $('.body-cmt').val(); // lấy giá trị textarea
            var select = $('.select-rate').val();
            var productid = $('#productid-cmt').val();

            $.ajax({
                url: "<?= base_url(route_to('productComment')) ?>",
                type: "post",
                data: {
                    rate: rate,
                    select: select,
                    productid: productid
                },
                dataType: 'html', // json encode chueyehnr
                success: function(data) {
                    if (rate != '' && select != '') {
                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": true,
                            "positionClass": "toast-bottom-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }

                        toastr["success"]("Bạn vừa gửi đánh giá thành công.");
                        showComment(); // gọi hàm hiển thị aja
                    } else {
                        toastr["error"]("Thông tin nhập chưa đầy đủ")

                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-bottom-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                    }
                }
            })
        })
    })
</script>
<?= $this->endSection() ?>