<div class="slimscroll-menu">

    <!--- Sidemenu -->
    <div id="sidebar-menu">

        <ul class="metismenu" id="side-menu">

            <li class="menu-title">Thống kê</li>

            <li>
                <a href="<?= base_url(route_to('dashboardIndex')) ?>" class="waves-effect text-capitalize">
                    <i class="remixicon-dashboard-line"></i>
                    <span> Thống kê </span>
                </a>
            </li>

            <li class="menu-title mt-2">Quản lý sản phẩm</li>

            <li>
                <a href="javascript: void(0);" class="waves-effect">
                    <i class="remixicon-stack-line"></i>
                    <span> Danh mục sản phẩm </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a class="text-capitalize" href="<?= base_url(route_to('catalogIndex')) ?>"> Xem danh sách</a>
                    </li>
                    <li>
                        <a class="text-capitalize" href="<?= base_url(route_to('catalogAdd')) ?>"> Thêm mới </a>
                    </li>
                    <li>
                        <a class="text-capitalize" href="<?= base_url(route_to('catalogRecycle')) ?>"> Xem thùng rác </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="waves-effect">
                    <i class="remixicon-stack-line"></i>
                    <span> Thương hiệu </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a class="text-capitalize" href="<?= base_url(route_to('brandIndex')) ?>"> Xem danh sách</a>
                    </li>
                    <li>
                        <a class="text-capitalize" href="<?= base_url(route_to('brandAdd')) ?>"> Thêm mới </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="waves-effect">
                    <i class="remixicon-stack-line"></i>
                    <span> Coupon </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a class="text-capitalize" href="<?= base_url(route_to('couponIndex')) ?>"> Xem danh sách</a>
                    </li>
                    <li>
                        <a class="text-capitalize" href="<?= base_url(route_to('couponAdd')) ?>"> Thêm mới </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="waves-effect">
                    <i class="remixicon-stack-line"></i>
                    <span> Sản phẩm </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a class="text-capitalize" href="<?= base_url(route_to('productIndex')) ?>"> Xem danh sách</a>
                    </li>
                    <li>
                        <a class="text-capitalize" href="<?= base_url(route_to('productAdd')) ?>"> Thêm mới </a>
                    </li>
                    <li>
                        <a class="text-capitalize" href="<?= base_url(route_to('productRecycle')) ?>"> Xem thùng rác </a>
                    </li>
                </ul>
            </li>

            <li class="menu-title mt-2">Quản lý đơn hàng</li>

            <li>
                <a href="javascript: void(0);" class="waves-effect">
                    <i class="remixicon-stack-line"></i>
                    <span> Đơn hàng </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a class="text-capitalize" href="<?= base_url(route_to('orderIndex')) ?>"> Xem danh sách</a>
                    </li>
                    <li>
                        <a class="text-capitalize" href="<?= base_url(route_to('orderSaved')) ?>"> Xem đơn hàng lưu </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="<?= base_url(route_to('userIndex')) ?>" class="waves-effect">
                    <i class="remixicon-stack-line"></i>
                    <span> Khách hàng </span>
                </a>
            </li>

            <li class="menu-title mt-2">Quản lý giao diện</li>

            <li>
                <a href="javascript: void(0);" class="waves-effect">
                    <i class="remixicon-stack-line"></i>
                    <span> Slider </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a class="text-capitalize" href="<?= base_url(route_to('sliderIndex')) ?>"> Xem danh sách</a>
                    </li>
                    <li>
                        <a class="text-capitalize" href="<?= base_url(route_to('sliderAdd')) ?>"> Thêm mới </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="<?= base_url(route_to('contactIndexBE')) ?>" class="waves-effect">
                    <i class="remixicon-stack-line"></i>
                    <span> Liên hệ </span>
                </a>
            </li>

            <li class="menu-title mt-2">Quản lý tin tức</li>

            <li>
                <a href="javascript: void(0);" class="waves-effect">
                    <i class="remixicon-stack-line"></i>
                    <span> Danh mục tin tức </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a class="text-capitalize" href="<?= base_url(route_to('catpostIndex')) ?>"> Xem danh sách</a>
                    </li>
                    <li>
                        <a class="text-capitalize" href="<?= base_url(route_to('catpostAdd')) ?>"> Thêm mới </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript: void(0);" class="waves-effect">
                    <i class="remixicon-stack-line"></i>
                    <span> Tin tức </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a class="text-capitalize" href="<?= base_url(route_to('postIndex')) ?>"> Xem danh sách</a>
                    </li>
                    <li>
                        <a class="text-capitalize" href="<?= base_url(route_to('postAdd')) ?>"> Thêm mới </a>
                    </li>
                    <li>
                        <a class="text-capitalize" href="<?= base_url(route_to('postRecycle')) ?>"> Xem thùng rác </a>
                    </li>
                </ul>
            </li>

        </ul>

    </div>
    <!-- End Sidebar -->

    <div class="clearfix"></div>

</div>
<!-- Sidebar -left -->