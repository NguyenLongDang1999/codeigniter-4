$(function () {
    // Nav mobile active
    $('.header__mobile-nav, .bg-fixed').on('click', function () {
        $('.header__mobile-menu').addClass('header__mobile-active');
        if ($('.header__mobile-menu').hasClass('header__mobile-hide')) {
            $('.header__mobile-menu').removeClass('header__mobile-hide');
        }
        $('.bg-fixed').fadeIn(300);
    })

    // Nav mobile hide
    $('.header__mobile-times, .bg-fixed').on('click', function () {
        $('.header__mobile-menu').addClass('header__mobile-hide');
        if ($('.header__mobile-menu').hasClass('header__mobile-active')) {
            $('.header__mobile-menu').removeClass('header__mobile-active');
        }
        $('.bg-fixed').fadeOut(300);
    })

    // mobile cat active
    $('.mobile__cat').on('click', function () {
        $('.categories').addClass('categories-active');
        if ($('.categories').hasClass('categories-hide')) {
            $('.categories').removeClass('categories-hide');
        }
        $('.bg-fixed').fadeIn(300);
    })

    // mobile cat  hide
    $('.categories__mobile-times, .bg-fixed').on('click', function () {
        $('.categories').addClass('categories-hide');
        if ($('.categories').hasClass('categories-active')) {
            $('.categories').removeClass('categories-active');
        }
        $('.bg-fixed').fadeOut(300);
    })

    // Cart product toggle
    $('.header__cart').on('click', function () {
        $(this).children().next().next().fadeToggle(300);
    })

    // Accordion sub categories
    $('.cat__accordion-toggle').click(function (e) {
        e.preventDefault();

        var $this = $(this);

        if ($this.parent().next().hasClass('show')) {
            $this.parent().next().removeClass('show');
            $this.parent().next().slideUp(300);
            $(this).children().removeClass('fa-minus').addClass('fa-plus');
        } else {
            $this.parent().parent().parent().find('li .cat__accordion-inner').removeClass('show');
            $this.parent().parent().parent().find('li .cat__accordion-inner').slideUp(300);
            $this.parent().next().toggleClass('show');
            $this.parent().next().slideToggle(300);
            $(this).children().removeClass('fa-plus').addClass('fa-minus');
        }
    });

    // Slick slider
    $('.slick-slider').slick({
        arrows: false,
        fade: true,
        autoplay: true,
        autoplaySpeed: 3000,
        fadeSpeed: 1000,
        dots: true
    })

    // Slick Product
    $('.slick-product').slick({
        arrows: false,
        autoplay: true,
        speed: 300,
        slidesToShow: 4,
        infinite: false,
        slidesToScroll: 4,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }
        ]
    })

    // Slick Post
    $('.slick-post').slick({
        arrows: false,
        autoplay: true,
        speed: 300,
        slidesToShow: 4,
        infinite: false,
        slidesToScroll: 4,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }
        ]
    })

    // slick servics
    $('.slick-services').slick({
        slidesToShow: 3,
        autoplay: true,
        arrows: false,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    })

    // slick product categories
    $('.slick-product-cat').slick({
        rows: 2,
        arrows: false,
        autoplay: true,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 4,
        infinite: false,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }
        ]

    })

    // slick modal
    $('#dataModal').on('shown.bs.modal', function () {
        $('.modal-body .slider-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.slider-nav'
        });
        $('.modal-body .slider-nav').slick({
            slidesToShow: 3,
            arrows: false,
            slidesToScroll: 1,
            asNavFor: '.slider-for',
            dots: false,
            centerMode: true,
            focusOnSelect: true,
        });
    });

    // back to top
    $(window).on('scroll load', function () {
        const body = $('html, body').scrollTop();
        if (body >= 100) {
            $('.header__top').addClass('header__top-sticky');
            $('.back-to-top').fadeIn(300);
        } else {
            $('.header__top').removeClass('header__top-sticky');
            $('.back-to-top').fadeOut(300);
        }

    })

    $('.back-to-top').on('click', function () {
        $('html, body').animate({ scrollTop: 0 }, 1500);
        return false;
    })

    // Gallery Popup Zoom Image
    var $carousel = $('.slick-for-carousel');

    $carousel
        .slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            adaptiveHeight: true,
            asNavFor: '.slick-nav-carousel'
        })
        .magnificPopup({
            type: 'image',
            delegate: 'a:not(.slick-cloned)',
            closeOnContentClick: false,
            tLoading: 'Загрузка...',
            mainClass: 'mfp-zoom-in mfp-img-mobile',
            image: {
                verticalFit: true,
                tError: '<a href="%url%">Фото #%curr%</a> не загрузилось.'
            },
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                tCounter: '<span class="mfp-counter">%curr% из %total%</span>', // markup of counte
                preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
            },
            zoom: {
                enabled: true,
                duration: 300
            },
            removalDelay: 300, //delay removal by X to allow out-animation
            callbacks: {
                open: function () {
                    //overwrite default prev + next function. Add timeout for css3 crossfade animation
                    $.magnificPopup.instance.next = function () {
                        var self = this;
                        self.wrap.removeClass('mfp-image-loaded');
                        setTimeout(function () { $.magnificPopup.proto.next.call(self); }, 120);
                    };
                    $.magnificPopup.instance.prev = function () {
                        var self = this;
                        self.wrap.removeClass('mfp-image-loaded');
                        setTimeout(function () { $.magnificPopup.proto.prev.call(self); }, 120);
                    };
                    var current = $carousel.slick('slickCurrentSlide');
                    $carousel.magnificPopup('goTo', current);
                },
                imageLoadComplete: function () {
                    var self = this;
                    setTimeout(function () { self.wrap.addClass('mfp-image-loaded'); }, 16);
                },
                beforeClose: function () {
                    $carousel.slick('slickGoTo', parseInt(this.index));
                }
            }
        });
    $('.slick-nav-carousel').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.slick-for-carousel',
        dots: false,
        focusOnSelect: true,
        prevArrow: '<button class="slide-arrow prev-arrow"></button>',
        nextArrow: '<button class="slide-arrow next-arrow"></button>'
    });

    // Slick Seller
    $('.slick-seller').slick({
        arrows: true,
        rows: 4,
        autoplay: true,
        prevArrow: "<div class='slick-prev pull-left'><i class='fa fa-angle-left' aria-hidden='true'></i></div>",
        nextArrow: "<div class='slick-next pull-right'><i class='fa fa-angle-right' aria-hidden='true'></i></div>"
    })

    // Product Catalog
    $('.catalog__filter-list').on('click', function () {
        $('.product__th').fadeOut(300);
        $(this).prev().removeClass('catalog__filter-active');
        $('.product__list').fadeIn(300);
        $(this).addClass('catalog__filter-active');
        $.cookie('list_grid', 'list');
    })

    $('.catalog__filter-th').on('click', function () {
        $('.product__th').fadeIn(300);
        $(this).next().removeClass('catalog__filter-active');
        $('.product__list').fadeOut(300);
        $(this).addClass('catalog__filter-active');
        $.cookie('list_grid', 'grid');
    })

    var cookie = $.cookie('list_grid');
    if (cookie == 'list') {
        $('.product__th').fadeOut(300);
        $('.catalog__filter-list').prev().removeClass('catalog__filter-active');
        $('.product__list').fadeIn(300);
        $('.catalog__filter-list').addClass('catalog__filter-active');
    } else {
        $('.product__th').fadeIn(300);
        $('.catalog__filter-th').next().removeClass('catalog__filter-active');
        $('.product__list').fadeOut(300);
        $('.catalog__filter-th').addClass('catalog__filter-active');
    }

    // +, - quanty
    $(document).on('click', '.qtyBtn', function () {
        var qtyField = $(this).parent();
        var qtyOld = $(qtyField).find('.qty').val();
        var value = 1;
        if ($(this).is(".plus")) {
            value = parseInt(qtyOld) + 1;
        } else if (qtyOld > 1) {
            value = parseInt(qtyOld) - 1;
        }
        $(qtyField).find(".qty").val(value);
    })

    // preloadcer
    $(window).on('load', function () {
        $('#status').fadeOut();
        $('#preloader').delay(350).fadeOut('slow');
    })

    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;

    $(".next").click(function () {
        // wizard
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

        //Add Class Active
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

        //show the next fieldset
        next_fs.show();
        //hide the current fieldset with style
        current_fs.animate({ opacity: 0 }, {
            step: function (now) {
                // for making fielset appear animation
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                next_fs.css({ 'opacity': opacity });
            },
            duration: 600
        });
    });

    $(".previous").click(function () {

        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();

        //Remove class active
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

        //show the previous fieldset
        previous_fs.show();

        //hide the current fieldset with style
        current_fs.animate({ opacity: 0 }, {
            step: function (now) {
                // for making fielset appear animation
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({ 'opacity': opacity });
            },
            duration: 600
        });
    });

    $('.radio-group .radio').click(function () {
        $(this).parent().find('.radio').removeClass('selected');
        $(this).addClass('selected');
    });

    $(".submit").click(function () {
        return false;
    })


})