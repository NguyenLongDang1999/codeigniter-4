<?php

// override core en language system validation or define your own en language validation message
return [
    'dashboard' => 'Page DashBoard Admin',

    // Frontend
    // ----- Home
    'frontend' => [
        // Nav
        'nav' => [
            'home' => 'Home',
            'product' => 'Product',
            'news' => 'News',
            'contact' => 'Contact',
            'faq' => 'Faq',
            'cart' => 'Shopping Cart',
            'showCart' => 'Show Cart',
            'checkout' => 'Check Out',
            'item' => 'items'
        ],
        // Categories Home
        'catHome' => [
            'allCat' => 'All categories'
        ],
        // Product
        'products' => [
            'news' => 'Latest Products',
            'featured' => 'Featured Products',
            'views' => 'Most View Products',
            'addToCart' => 'Add to cart',
            'quickView' => 'Quick View',
            'heart' => 'Heart',
        ],
        // SerVices
        'services' => [
            'paymentTitle' => 'Payment on delivery',
            'paymentText' => 'Cash on delivery option',
            'shippingTitle' => 'Free shipping',
            'shippingText' => 'Free shipping on order over 1tr',
            'securityTitle' => 'Secure payment',
            'securityText' => 'We value your securiry',
            'supportTitle' => 'Online support',
            'supportText' => 'We have support 24/7',
        ],
        // News
        'newsTitle' => 'Latest News',
        // ----- Product
        'pageProduct' => [
            'breadcrumbsTitle' => 'All products',
            'childCat' => 'Child Categories',
            'selectDefault' => 'Default',
            'selectOld' => 'Oldest product',
            'selectName1' => 'Name (A - Z)',
            'selectName2' => 'Name (Z - A)',
            'selectPrice1' => 'Price (Low -> High)',
            'selectPrice2' => 'Price (High -> Low)',
            'selectView1' => 'View (High -> Low)',
            'selectView2' => 'View (Low -> High)',
        ],
        // ----- Detail Product
        'detail' => [
            'related' => 'Related Products',
            'detailProduct' => 'Description',
            'review' => 'Review'
        ],
        // ----- Login
        'login' => [
            'infoCustomer' => 'Information Customer',
            'fullname' => 'Fullname',
            'phone' => 'Phone',
            'logout' => 'Logout',
            'login' => 'Login',
            'register' => 'Register',
            'info' => 'infomation',
            'validate' => [
                'fullname' => [
                    'required' => 'Fullname is required',
                    'max' => 'Fullname is too long. It should have 255 characters or fewer.',
                    'min' => 'Fullname is too short. It should have 3 characters or more.'
                ],
                'email' => [
                    'required' => 'Email is required',
                    'max' => 'Email is too long. It should have 255 characters or fewer.',
                    'valid' => 'Email should be a valid email.',
                    'unique' => 'Email already exists.'
                ],
                'phone' => [
                    'required' => 'Phone is required',
                    'max' => 'Phone is too long. It should have 10 characters or fewer.',
                    'numeric' => 'Phone is is_numeric.',
                    'natural' => 'Phone is is_natural.'
                ],
                'username' => [
                    'required' => 'Username is required',
                    'regex' => 'Username is incorrect. Username only contains the characters A-Z, a-z, 0-9 and underlined oil. Does not contain spaces. Username is 3 -> 32 characters long.',
                    'unique' => 'Username already exists.'
                ],
                'password' => [
                    'required' => 'Password is required',
                    'regex' => 'Password is incorrect. The first letter is not a numeric character. Has a length of 3 -> 32 characters. Does not contain spaces.'
                ]
            ],
        ],
        // ----- Cart 
        'cart' => [
            'cartTitle' => 'Shopping Cart',
            'cartName' => 'Name',
            'cartPrice' => 'Price',
            'cartQty' => 'Quantity',
            'cartTotal' => 'Total',
            'cartCheckout' => 'Checkout',
            'continue' => 'Continue Shopping',
            'order' => 'Order Summary',
            'shipping' => 'Shipping',
            'coupon' => 'Coupon',
            'tax' => 'Tax',
            'subTotal' => 'Subtotal'
        ]
    ]
];
