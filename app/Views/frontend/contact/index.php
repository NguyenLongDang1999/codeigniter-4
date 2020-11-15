<!-- Kế thừa layout frontend -->
<?= $this->extend('layout/frontend/layout'); ?>

<!-- Tiêu đề trang -->
<?= $this->section('title') ?>
Trang chủ
<?= $this->endSection() ?>

<!-- Seo Website -->
<?= $this->section('metaSeo') ?>
<meta name="description" content="CodeIgniter 4 Website thương mại điện tử thanh toán">
<meta name="keywords" content="CodeIgniter 4 WebSite">
<meta name="title" content="TopDeal, Website học tập thử nghiệm CodeIgniter 4">
<?= $this->endSection() ?>

<!-- Link CSS trang -->
<?= $this->section('isLink') ?>
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>
<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="<?= base_url() ?>/css/magnific-popup.css" />
<?= $this->endSection() ?>

<!-- Thanh breadcrumb -->
<?= $this->section('breadcrumbs') ?>
<div class="container-fluid mb-3 p-0">
    <div class="breadcrumbs">
        <div class="breadcrumbs__title">Liên hệ</div>

        <div class="breadcrumbs__url mt-4">
            <ul class="m-0 list-unstyled d-flex flex-wrap justify-content-center">
                <li class="breadcrumbs__url-item">
                    <a class="breadcrumbs__url-link" href="<?= base_url() ?>">Trang chủ</a>
                </li>
                <li class="breadcrumbs__url-item">
                    <a class="breadcrumbs__url-link breadcrumbs__url-active" href="javascript:void(0)">Liên hệ</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<!-- Nội dung trang -->
<?= $this->section('content') ?>
<div class="contact">
    <div class="row">
        <div class="col-md-6">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3898.7470707059647!2d109.19320581403832!3d12.265388091321935!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3170678c61b8f251%3A0x115f6f97f1af1d7c!2sTh%C3%A1p%20Po%20Nagar!5e0!3m2!1svi!2s!4v1599224312100!5m2!1svi!2s" width="100%" height="450" frameborder="0" style="border: 0" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
        <div class="col-md-6">
            <h2 class="contact__title text-uppercase">
                Liên hệ
            </h2>

            <?= form_open(base_url(route_to('postContact')), ['class' => 'mt-3 postSubmitForm']) ?>
            <?= csrf_field() ?>
            <div class="form-group">
                <input type="text" name="fullname" class="form-control" id="fullname" placeholder="Họ và tên của bạn">
                <div class="invalid-feedback fullname">

                </div>
            </div>
            <div class="form-group">
                <input type="text" name="email" class="form-control" id="email" placeholder="Địa chỉ Email của bạn">
                <div class="invalid-feedback email">

                </div>
            </div>
            <div class="form-group">
                <input type="text" name="phone" class="form-control" id="phone" placeholder="Số điện thoại của bạn">
                <div class="invalid-feedback phone">

                </div>
            </div>
            <div class="form-group">
                <textarea class="form-control" name="body" name="" id="body" rows="3" placeholder="Nội dung gửi liên hệ"></textarea>
                <div class="invalid-feedback body">

                </div>
            </div>
            <button type="submit" class="contact__submit-btn btn text-uppercase btn-sm">Gửi</button>
            <?= form_close() ?>
        </div>
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

        $('.postSubmitForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= base_url(route_to('postContact')) ?>",
                type: "post",
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.error) { // Validation form
                        if (response.error.fullname) {
                            $('#fullname').addClass('is-invalid');
                            $('.invalid-feedback.fullname').html(response.error.fullname);
                        } else {
                            $('#fullname').removeClass('is-invalid');
                            $('.invalid-feedback.fullname').html('');
                        }

                        if (response.error.email) {
                            $('#email').addClass('is-invalid');
                            $('.invalid-feedback.email').html(response.error.email);
                        } else {
                            $('#email').removeClass('is-invalid');
                            $('.invalid-feedback.email').html('');
                        }

                        if (response.error.phone) {
                            $('#phone').addClass('is-invalid');
                            $('.invalid-feedback.phone').html(response.error.phone);
                        } else {
                            $('#phone').removeClass('is-invalid');
                            $('.invalid-feedback.phone').html('');
                        }

                        if (response.error.body) {
                            $('#body').addClass('is-invalid');
                            $('.invalid-feedback.body').html(response.error.body);
                        } else {
                            $('#body').removeClass('is-invalid');
                            $('.invalid-feedback.body').html('');
                        }
                    } else {
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

                        toastr["success"](response.success)
                    }
                }
            })
        })

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
                        "hideDuration": "1000",
                        "timeOut": "3000",
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