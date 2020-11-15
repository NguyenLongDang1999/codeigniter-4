<?php

// override core en language system validation or define your own en language validation message
return [
    'dashboard' => 'Trang thống kê',

    // Frontend
    // ----- Home
    'frontend' => [
        // Nav
        'nav' => [
            'home' => 'Trang chủ',
            'product' => 'Sản phẩm',
            'news' => 'Tin tức',
            'contact' => 'Liên hệ',
            'faq' => 'faq',
            'cart' => 'Giỏ hàng',
            'showCart' => 'Xem giỏ hàng',
            'checkout' => 'Thanh toán',
            'item' => 'Sản phẩm'
        ],
        // Categories Home
        'catHome' => [
            'allCat' => 'Tất cả danh mục'
        ],
        // Product
        'products' => [
            'news' => 'Sản phẩm mới nhất',
            'featured' => 'Sản phẩm nổi bật',
            'views' => 'Sản phẩm nhiều lượt xem',
            'addToCart' => 'Thêm vào giỏ hàng',
            'quickView' => 'Xem nhanh',
            'Heart' => 'Yêu thích',
        ],
        // SerVices
        'services' => [
            'paymentTitle' => 'Thanh toán tại nhà',
            'paymentText' => 'Thanh tóan bằng tiền mặt khi giao hàng',
            'shippingTitle' => 'Miễn phí vận chuyển',
            'shippingText' => 'Miễn phí vận chuyển đơn hàng trên 1tr',
            'securityTitle' => 'Thanh tóan an toàn',
            'securityText' => 'Bảo mật an toàn khi thanh toán',
            'supportTitle' => 'Hỗ trợ trực tuyến',
            'supportText' => 'Chúng tôi hỗ trợ quý khách 24/7',
        ],
        // News
        'newsTitle' => 'Tin tức công nghệ',
        // ----- Product
        'pageProduct' => [
            'breadcrumbsTitle' => 'Tất cả sản phẩm',
            'childCat' => 'Danh mục con',
            'selectDefault' => 'Mặc định',
            'selectOld' => 'Sản phẩm cũ nhất',
            'selectName1' => 'Tên (A - Z)',
            'selectName2' => 'Tên (Z - A)',
            'selectPrice1' => 'Giá (Thấp -> Cao)',
            'selectPrice2' => 'Giá (Cao -> Thấp)',
            'selectView1' => 'Lượt xem (Cao -> Thấp)',
            'selectView2' => 'Lượt xem (Thấp -> Cao)',
        ],
        // ----- Detail Product
        'detail' => [
            'related' => 'Sản phẩm cùng danh mục',
            'detailProduct' => 'Chi tiết sản phẩm',
            'review' => 'Đánh giá'
        ],
        // ----- Login
        'login' => [
            'infoCustomer' => 'Thông tin khách hàng',
            'fullname' => 'Họ và tên',
            'phone' => 'Số điện thoại',
            'logout' => 'Đăng xuất',
            'login' => 'Đăng nhập',
            'register' => 'Đăng ký',
            'info' => 'Thông tin cá nhân',
            'validate' => [
                'required' => 'Họ và tên không được bỏ trống.',
                'fullname' => [
                    'max' => 'Họ và tên quá dài. Không được vượt quá 255 ký tự.',
                    'min' => 'Họ và tên quá ngắn. Không được ít hơn 3 ký tự.'
                ],
                'email' => [
                    'required' => 'Email không được bỏ trống.',
                    'max' => 'Email quá dài. Không được vượt quá 255 ký tự.',
                    'valid' => 'Email không đúng định dạng.',
                    'unique' => 'Email đã tồn tại trong hệ thống.'
                ],
                'phone' => [
                    'required' => 'Số điện thoại không được bỏ trống.',
                    'max' => 'Số điện thoại quá dài. Không được vượt quá 10 ký tự.',
                    'numeric' => 'Số điện thoại phải là ký tự số.',
                    'natural' => 'Số điện thoại phải là số nguyên dương.'
                ],
                'username' => [
                    'required' => 'Username không được bỏ trống.',
                    'regex' => 'Username không đúng định dạng. Username chỉ chưa các ký tự A-Z, a-z, 0-9 và dầu gạch dưới. Không chứa dấu khoảng cách. Username có độ dài từ 3 -> 32 ký tự.',
                    'unique' => 'Username đã tồn tại.'
                ],
                'password' => [
                    'required' => 'Password không được bỏ trống.',
                    'regex' => 'Password không đúng định dạng. Chữ cái đầu tiên không phải là ký tự ký số. Có độ dài từ 3 -> 32 ký tự. Không chứa dấu khoảng cách.'
                ]
            ],
        ],
        // ----- Cart 
        'cart' => [
            'cartTitle' => 'Giỏ hàng',
            'cartName' => 'Tên sản phẩm',
            'cartPrice' => 'Giá',
            'cartQty' => 'Số lượng',
            'cartTotal' => 'Tổng cộng',
            'cartCheckout' => 'Thanh toán',
            'continue' => 'Tiếp tục mua hàng',
            'order' => 'Tóm tát đơn hàng',
            'shipping' => 'Phí vận chuyển',
            'coupon' => 'Mã giảm giá',
            'tax' => 'Thuế',
            'subTotal' => 'Thành tiền'
        ]
    ]
    
];
