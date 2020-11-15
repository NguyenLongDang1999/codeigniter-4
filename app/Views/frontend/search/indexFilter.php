<div class="product product__th">
    <div class="row">
        <?php foreach ($productSearch as $item) { ?>
            <div class="col-md-4 col-sm-6">
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
    <?php foreach ($productSearch as $item) { ?>
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
                    <a href="javascript:void(0)" class="product__list-link mb-1 addToCart" data-id="<?= $item['id'] ?>"><i class="fa fa-shopping-basket pr-2" aria-hidden="true"></i>Thêm vào giỏ hàng</a>
                    <a href="javascript:void(0)" class="product__list-link mb-1"><i class="fa fa-heart-o pr-2" aria-hidden="true"></i>Yêu
                        thích</a>
                    <a href="javascript:void(0)" id="<?= $item['id'] ?>" class="product__list-link product__hover-quickview" data-toggle="modal" data-target="#dataModal"><i class="fa fa-search pr-2" aria-hidden="true"></i>Xem nhanh</a>
                </div>
            </div>
        </div>
    <?php } ?>

</div>