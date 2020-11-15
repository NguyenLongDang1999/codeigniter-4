<!-- header top -->
<div class="header__top">
    <div class="container-fluid container-md">
        <div class="row">
            <div class="col-4">
                <div class="header__logo d-flex align-items-center">
                    <a href="<?= base_url() ?>">
                        <img src="<?= base_url() ?>/images/logo-2.png" class="img-fluid" alt="Logo" />
                    </a>
                </div>
            </div>

            <div class="col-8">
                <div class="header__cart d-flex justify-content-end align-items-center">
                    <span class="header__cart-icon">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    </span>
                    <div class="header__cart-info">
                        <span class="header__cart-text text-capitalize"> <?= lang('App.frontend.nav.cart'); ?> </span>
                        <span class="header__cart-items showCartQuantity">

                        </span>
                    </div>

                    <div class="header__cart-product" style="display: none">
                        <div class="container showCart">
                        </div>
                        <div class="row mt-2 pb-2 px-2">
                            <div class="col-6">
                                <a href="<?= base_url(route_to('cartIndex')) ?>" class="header__cart-view btn">
                                    <?= lang('App.frontend.nav.showCart'); ?>
                                </a>
                            </div>
                            <div class="col-6" style="text-align: right">
                                <a href="<?= base_url(route_to('checkoutIndex')) ?>" class="header__cart-checkout btn">
                                    <?= lang('App.frontend.nav.checkout'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end header top -->

<!-- header nav -->
<div class="header__navbar d-lg-block d-none">
    <div class="container-fluid container-md">
        <div class="row">
            <div class="col-md-8">
                <ul class="header__nav">
                    <li class="header__nav-item">
                        <a href="<?= base_url() ?>"" class=" header__nav-link"> <?= lang('App.frontend.nav.home'); ?> </a>
                    </li>
                    <li class="header__nav-item">
                        <a href="<?= base_url(route_to('productIndexFE')) ?>"" class=" header__nav-link"> <?= lang('App.frontend.nav.product'); ?> </a>
                    </li>
                    <li class="header__nav-item">
                        <a href="<?= base_url(route_to('postAllIndex')) ?>" class="header__nav-link"> <?= lang('App.frontend.nav.news'); ?> </a>
                    </li>
                    <li class="header__nav-item">
                        <a href="<?= base_url(route_to('contactIndex')) ?>" class="header__nav-link"> <?= lang('App.frontend.nav.contact'); ?> </a>
                    </li>
                    <li class="header__nav-item">
                        <a href="faq.html" class="header__nav-link"> <?= lang('App.frontend.nav.faq'); ?> </a>
                    </li>
                </ul>
            </div>

            <div class="col-md-4">
                <form action="<?= base_url(route_to('productSearch', '')) ?>" method="get" class="header__search d-flex align-items-center justify-content-end">
                    <input type="text" class="header__search-input text-search" name="search" placeholder="Search..." />
                    <button type="submit" class="header__search-btn">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end header nav -->

<div class="bg-fixed" style="display: none"></div>

<!-- header nav mobile -->
<div class="header__mobile d-lg-none d-block">
    <div class="container-fluid container-md">
        <div class="row">
            <div class="col-3">
                <a href="javascript:void(0)" class="header__mobile-nav">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </a>

                <ul class="header__mobile-menu header__mobile-hide">
                    <li>
                        <a href="javascript:void(0)" class="header__mobile-times"><i class="fa fa-times" aria-hidden="true"></i></a>
                    </li>
                    <li class="header__mobile-item">
                        <a href="<?= base_url() ?>" class="header__mobile-link">
                        <?= lang('App.frontend.nav.home'); ?>
                        </a>
                    </li>
                    <li class="header__mobile-item">
                        <a href="<?= base_url(route_to('productIndexFE')) ?>" class="header__mobile-link">
                        <?= lang('App.frontend.nav.product'); ?>
                        </a>
                    </li>
                    <li class="header__mobile-item">
                        <a href="<?= base_url(route_to('postAllIndex')) ?>" class="header__mobile-link"> <?= lang('App.frontend.nav.news'); ?> </a>
                    </li>
                    <li class="header__mobile-item">
                        <a href="<?= base_url(route_to('contactIndex')) ?>" class="header__mobile-link">
                        <?= lang('App.frontend.nav.contact'); ?>
                        </a>
                    </li>
                    <li class="header__mobile-item">
                        <a href="faq.html" class="header__mobile-link"> <?= lang('App.frontend.nav.faq'); ?> </a>
                    </li>
                </ul>
            </div>
            <div class="col-9">
                <form action="<?= base_url(route_to('productSearch', '')) ?>" class="header__search d-flex align-items-center justify-content-end" method="get">
                    <input type="text" class="header__search-input text-search" name="search" placeholder="Search..." id="text-search" />
                    <button type="submit" class="header__search-btn">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end header nav mobile -->