<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('/{locale}', 'Language::index', ['as' => 'language']);

// Trang chủ
$routes->get('/', 'HomeController::index', ['as' => 'homeIndex']);
$routes->post('/modal', 'HomeController::modal', ['as' => 'modalQuickView']);
// Chi tiết sản phẩm
$routes->get('/{locale}/danh-muc-san-pham', 'ProductController::index', ['as' => 'productIndexFE']);
$routes->post('showProductFilter', 'ProductController::showProductFilter', ['as' => 'showProductFilter']);
$routes->post('danh-muc-san-pham', 'ProductController::index', ['as' => 'productIndexFEPost']);
$routes->get('san-pham/(:any)', 'ProductController::detail/$1', ['as' => 'productDetail']);
$routes->get('danh-muc/(:any)', 'ProductController::catalog/$1', ['as' => 'productCatalog']);
$routes->post('danh-muc/(:any)', 'ProductController::catalog/$1', ['as' => 'productCatalogFilter']);
$routes->post('comment', 'ProductController::comment', ['as' => 'productComment']);
$routes->post('showComment/(:num)', 'ProductController::showComment/$1', ['as' => 'productShowComment']);
// Tìm kiếm sản phẩm
$routes->get('search?(:any)', 'SearchController::index/$1', ['as' => 'productSearch']);
$routes->get('autocomplete/?', 'SearchController::autocomplete', ['as' => 'searchAutocomplete']);
$routes->post('search?(:any)', 'SearchController::index/$1', ['as' => 'productSearchPost']);
// Tin tức
$routes->get('tin-tuc/(:any)', 'PostController::detail/$1', ['as' => 'postDetail']);
$routes->get('danh-muc-tin-tuc/(:any)', 'PostController::catpost/$1', ['as' => 'postCatpost']);
$routes->get('/{locale}/tat-ca-tin-tuc', 'PostController::index', ['as' => 'postAllIndex']);
// Giỏ hàng
$routes->get('/{locale}/gio-hang', 'CartController::index', ['as' => 'cartIndex']);
$routes->post('addToCart', 'CartController::add', ['as' => 'cartAdd']);
$routes->post('editCart', 'CartController::edit', ['as' => 'cartEdit']);
$routes->post('delCart', 'CartController::delete', ['as' => 'cartDel']);
$routes->post('showCart', 'CartController::showCart', ['as' => 'showCart']);
$routes->post('showCartData', 'CartController::showCartData', ['as' => 'showCartData']);
$routes->post('showCartQuantity', 'CartController::showCartQuantity', ['as' => 'showCartQuantity']);
$routes->post('showTotal', 'CartController::showTotal', ['as' => 'showTotal']);
$routes->post('coupon', 'CartController::coupon', ['as' => 'applyCoupon']);
// Login
$routes->post('postLogin', 'LoginController::postLogin', ['as' => 'postLogin']);
$routes->post('postRegister', 'LoginController::postRegister', ['as' => 'postRegister']);
$routes->post('postLogout', 'LoginController::postLogout', ['as' => 'postLogout']);
$routes->post('showLogin', 'LoginController::showLogin', ['as' => 'showLogin']);
// Liên hệ
$routes->get('/{locale}/lien-he', 'ContactController::index', ['as' => 'contactIndex']);
$routes->post('postContact', 'ContactController::postContact', ['as' => 'postContact']);
// Thông tin
$routes->get('/{locale}/thong-tin-thanh-toan', 'InfoController::checkout', ['as' => 'checkoutIndex']);
$routes->get('/{locale}/thong-tin-ca-nhan', 'InfoController::index', ['as' => 'infoIndex']);
$routes->get('don-hang/(:num)', 'InfoController::detail/$1', ['as' => 'infoDetail']);
$routes->get('delete/(:num)', 'InfoController::delete/$1', ['as' => 'infoDelete']);
$routes->get('cap-nhat-thong-tin/(:num)', 'InfoController::edit/$1', ['as' => 'infoEdit']);
$routes->post('postEdit/(:num)', 'InfoController::postEdit/$1', ['as' => 'infoPostEdit']);
$routes->get('doi-mat-khau/(:num)', 'InfoController::resetPassword/$1', ['as' => 'infoResetPassword']);
$routes->post('resetPassword/(:num)', 'InfoController::postResetPassword/$1', ['as' => 'infoPostResetPassword']);
$routes->get('/{locale}/lay-lai-mat-khau', 'InfoController::forgotPassword', ['as' => 'infoForgotPassword']);
$routes->get('lay-lai-mat-khau/(:num)', 'InfoController::getForgotPassword/$1', ['as' => 'infoGetForgotPassword']);
$routes->post('getPostForgotPassword/(:num)', 'InfoController::getPostForgotPassword/$1', ['as' => 'infoGetPostForgotPassword']);
$routes->post('postForgotPassword', 'InfoController::postForgotPassword', ['as' => 'infoPostForgotPassword']);
$routes->post('showOrder', 'InfoController::showOrder', ['as' => 'showOrder']);
$routes->post('district', 'InfoController::district', ['as' => 'showDistrict']);
$routes->post('postCheckout', 'InfoController::postCheckout', ['as' => 'postCheckout']);
$routes->get('/{locale}/tri-an-khach-hang', 'InfoController::thanks', ['as' => 'checkoutThanks']);

// Gọi trang login admin (nằm ngoài filder => login)
$routes->group('admin', function ($routes) {
    $routes->get('login', 'Admin\LoginController::index', ['as' => 'loginIndex']);
    $routes->get('login/logout', 'Admin\LoginController::logout', ['as' => 'logout']);
    $routes->post('login/login', 'Admin\LoginController::login', ['as' => 'loginLogin']);
});
// Note: routes->get (Gọi giao diện) routes->post (Gọi khi submit form)
// Cấu hình router admin
$routes->group('/admin', ['filter' => 'login'], function ($routes) {
    // Load trang dashboard khi vào admin
    $routes->get('/', 'Admin\DashboardController::index', ['as' => 'dashboardIndex']);
    // Cấu hình router Danh mục
    $routes->group('catalog', function ($routes) {
        $routes->get('/', 'Admin\CatalogController::index', ['as' => 'catalogIndex']);
        $routes->get('add', 'Admin\CatalogController::add', ['as' => 'catalogAdd']);
        $routes->post('postAdd', 'Admin\CatalogController::postAdd', ['as' => 'catalogPostAdd']);
        $routes->get('edit/(:num)', 'Admin\CatalogController::edit/$1', ['as' => 'catalogEdit']);
        $routes->post('postEdit/(:num)', 'Admin\CatalogController::postEdit/$1', ['as' => 'catalogPostEdit']);
        $routes->get('status/(:num)', 'Admin\CatalogController::status/$1', ['as' => 'catalogStatus']);
        $routes->get('restore/(:num)', 'Admin\CatalogController::restore/$1', ['as' => 'catalogRestore']);
        $routes->get('delete/(:num)', 'Admin\CatalogController::delete/$1', ['as' => 'catalogDelete']);
        $routes->get('recycle', 'Admin\CatalogController::recycle', ['as' => 'catalogRecycle']);
        $routes->get('trash/(:num)', 'Admin\CatalogController::trash/$1', ['as' => 'catalogTrash']);
    });
    // Cấu hình router Thương hiệu
    $routes->group('brand', function ($routes) {
        $routes->get('/', 'Admin\BrandController::index', ['as' => 'brandIndex']);
        $routes->get('add', 'Admin\BrandController::add', ['as' => 'brandAdd']);
        $routes->post('postAdd', 'Admin\BrandController::postAdd', ['as' => 'brandPostAdd']);
        $routes->get('edit/(:num)', 'Admin\BrandController::edit/$1', ['as' => 'brandEdit']);
        $routes->post('postEdit/(:num)', 'Admin\BrandController::postEdit/$1', ['as' => 'brandPostEdit']);
        $routes->get('status/(:num)', 'Admin\BrandController::status/$1', ['as' => 'brandStatus']);
        $routes->get('delete/(:num)', 'Admin\BrandController::delete/$1', ['as' => 'brandDelete']);
    });
    // Cấu hình router Sản phẩm
    $routes->group('product', function ($routes) {
        $routes->get('/', 'Admin\ProductController::index', ['as' => 'productIndex']);
        $routes->get('add', 'Admin\ProductController::add', ['as' => 'productAdd']);
        $routes->post('postAdd', 'Admin\ProductController::postAdd', ['as' => 'productPostAdd']);
        $routes->get('edit/(:num)', 'Admin\ProductController::edit/$1', ['as' => 'productEdit']);
        $routes->post('postEdit/(:num)', 'Admin\ProductController::postEdit/$1', ['as' => 'productPostEdit']);
        $routes->get('status/(:num)', 'Admin\ProductController::status/$1', ['as' => 'productStatus']);
        $routes->get('restore/(:num)', 'Admin\ProductController::restore/$1', ['as' => 'productRestore']);
        $routes->get('delete/(:num)', 'Admin\ProductController::delete/$1', ['as' => 'productDelete']);
        $routes->get('recycle', 'Admin\ProductController::recycle', ['as' => 'productRecycle']);
        $routes->get('trash/(:num)', 'Admin\ProductController::trash/$1', ['as' => 'productTrash']);
        $routes->get('featured/(:num)', 'Admin\ProductController::featured/$1', ['as' => 'productFeatured']);
    });
    // Cấu hình router Slider
    $routes->group('slider', function ($routes) {
        $routes->get('/', 'Admin\SliderController::index', ['as' => 'sliderIndex']);
        $routes->get('add', 'Admin\SliderController::add', ['as' => 'sliderAdd']);
        $routes->post('postAdd', 'Admin\SliderController::postAdd', ['as' => 'sliderPostAdd']);
        $routes->get('edit/(:num)', 'Admin\SliderController::edit/$1', ['as' => 'sliderEdit']);
        $routes->post('postEdit/(:num)', 'Admin\SliderController::postEdit/$1', ['as' => 'sliderPostEdit']);
        $routes->get('status/(:num)', 'Admin\SliderController::status/$1', ['as' => 'sliderStatus']);
        $routes->get('delete/(:num)', 'Admin\SliderController::delete/$1', ['as' => 'sliderDelete']);
    });
    // Cấu hình router Dah mục tin
    $routes->group('catpost', function ($routes) {
        $routes->get('/', 'Admin\CatpostController::index', ['as' => 'catpostIndex']);
        $routes->get('add', 'Admin\CatpostController::add', ['as' => 'catpostAdd']);
        $routes->post('postAdd', 'Admin\CatpostController::postAdd', ['as' => 'catpostPostAdd']);
        $routes->get('edit/(:num)', 'Admin\CatpostController::edit/$1', ['as' => 'catpostEdit']);
        $routes->post('postEdit/(:num)', 'Admin\CatpostController::postEdit/$1', ['as' => 'catpostPostEdit']);
        $routes->get('status/(:num)', 'Admin\CatpostController::status/$1', ['as' => 'catpostStatus']);
        $routes->get('delete/(:num)', 'Admin\CatpostController::delete/$1', ['as' => 'catpostDelete']);
    });
    // Cấu hình router TIn tức
    $routes->group('post', function ($routes) {
        $routes->get('/', 'Admin\PostController::index', ['as' => 'postIndex']);
        $routes->get('add', 'Admin\PostController::add', ['as' => 'postAdd']);
        $routes->post('postAdd', 'Admin\PostController::postAdd', ['as' => 'postPostAdd']);
        $routes->get('edit/(:num)', 'Admin\PostController::edit/$1', ['as' => 'postEdit']);
        $routes->post('postEdit/(:num)', 'Admin\PostController::postEdit/$1', ['as' => 'postPostEdit']);
        $routes->get('status/(:num)', 'Admin\PostController::status/$1', ['as' => 'postStatus']);
        $routes->get('restore/(:num)', 'Admin\PostController::restore/$1', ['as' => 'postRestore']);
        $routes->get('delete/(:num)', 'Admin\PostController::delete/$1', ['as' => 'postDelete']);
        $routes->get('recycle', 'Admin\PostController::recycle', ['as' => 'postRecycle']);
        $routes->get('trash/(:num)', 'Admin\PostController::trash/$1', ['as' => 'postTrash']);
    });
    // Cấu hình router COupon
    $routes->group('coupon', function ($routes) {
        $routes->get('/', 'Admin\CouponController::index', ['as' => 'couponIndex']);
        $routes->get('add', 'Admin\CouponController::add', ['as' => 'couponAdd']);
        $routes->post('postAdd', 'Admin\CouponController::postAdd', ['as' => 'couponPostAdd']);
        $routes->get('edit/(:num)', 'Admin\CouponController::edit/$1', ['as' => 'couponEdit']);
        $routes->post('postEdit/(:num)', 'Admin\CouponController::postEdit/$1', ['as' => 'couponPostEdit']);
        $routes->get('status/(:num)', 'Admin\CouponController::status/$1', ['as' => 'couponStatus']);
        $routes->get('delete/(:num)', 'Admin\CouponController::delete/$1', ['as' => 'couponDelete']);
    });
    // Cấu hình router Đơn hàng
    $routes->group('order', function ($routes) {
        $routes->get('/', 'Admin\OrderController::index', ['as' => 'orderIndex']);
        $routes->get('status/(:num)', 'Admin\OrderController::status/$1', ['as' => 'orderStatus']);
        $routes->get('restore/(:num)', 'Admin\OrderController::restore/$1', ['as' => 'orderRestore']);
        $routes->get('delete/(:num)', 'Admin\OrderController::delete/$1', ['as' => 'orderDelete']);
        $routes->get('saves/(:num)', 'Admin\OrderController::saves/$1', ['as' => 'orderSaves']);
        $routes->get('saved', 'Admin\OrderController::saved', ['as' => 'orderSaved']);
        $routes->get('cancel/(:num)', 'Admin\OrderController::cancel/$1', ['as' => 'orderCancel']);
        $routes->get('detail/(:num)', 'Admin\OrderController::detail/$1', ['as' => 'orderDetail']);
    });
    // Cấu hình router Liên hệ
    $routes->group('contact', function ($routes) {
        $routes->get('/', 'Admin\ContactController::index', ['as' => 'contactIndexBE']);
        $routes->get('detail/(:num)', 'Admin\ContactController::detail/$1', ['as' => 'contactDetail']);
        $routes->post('postDetail/(:num)', 'Admin\ContactController::postDetail/$1', ['as' => 'contactPostDetail']);
        $routes->get('delete/(:num)', 'Admin\ContactController::delete/$1', ['as' => 'contactDelete']);
    });
    // Cấu hình router Khách hàng
    $routes->group('user', function ($routes) {
        $routes->get('/', 'Admin\UserController::index', ['as' => 'userIndex']);
        $routes->get('detail/(:num)', 'Admin\UserController::detail/$1', ['as' => 'userDetail']);
        $routes->get('status/(:num)', 'Admin\UserController::status/$1', ['as' => 'userStatus']);
        $routes->get('delete/(:num)', 'Admin\UserController::delete/$1', ['as' => 'userDelete']);
    });
});
/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
