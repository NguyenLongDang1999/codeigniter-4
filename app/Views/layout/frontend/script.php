<!-- Jquery JS -->
<script src="<?= base_url() ?>/js/jquery-3.5.1.min.js"></script>
<!-- Popper JS -->
<script src="<?= base_url() ?>/js/popper.min.js"></script>
<!-- Bootstrap JS -->
<script src="<?= base_url() ?>/js/bootstrap.min.js"></script>
<!-- Main JS -->
<script src="<?= base_url() ?>/js/main.js"></script>
<!-- Slick JS -->
<script src="<?= base_url() ?>/js/slick.min.js"></script>
<!-- Jquery UI JS -->
<script src="<?= base_url() ?>/js/jquery-ui.js"></script>
<!-- Rating JS -->
<script src="<?= base_url()?>/js/jquery.barrating.min.js"></script>

<script>
    $(function() {

        // Đăng ký
        $(document).on('submit', '.postRegisterForm', function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= base_url(route_to('postRegister')) ?>",
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
                            $('#fullname').addClass('is-valid');
                            $('.invalid-feedback.fullname').html('');
                        }

                        if (response.error.email) {
                            $('#email').addClass('is-invalid');
                            $('.invalid-feedback.email').html(response.error.email);
                        } else {
                            $('#email').removeClass('is-invalid');
                            $('#email').addClass('is-valid');
                            $('.invalid-feedback.email').html('');
                        }

                        if (response.error.phone) {
                            $('#phone').addClass('is-invalid');
                            $('.invalid-feedback.phone').html(response.error.phone);
                        } else {
                            $('#phone').removeClass('is-invalid');
                            $('#phone').addClass('is-valid');
                            $('.invalid-feedback.phone').html('');
                        }

                        if (response.error.username) {
                            $('#username').addClass('is-invalid');
                            $('.invalid-feedback.username').html(response.error.username);
                        } else {
                            $('#username').removeClass('is-invalid');
                            $('#username').addClass('is-valid');
                            $('.invalid-feedback.username').html('');
                        }

                        if (response.error.password) {
                            $('#password').addClass('is-invalid');
                            $('.invalid-feedback.password').html(response.error.password);
                        } else {
                            $('#password').removeClass('is-invalid');
                            $('#password').addClass('is-valid');
                            $('.invalid-feedback.password').html('');
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

                        toastr["success"](response.success);

                        $('#fullname').addClass('is-valid');
                        $('#fullname').removeClass('is-invalid');
                        $('.invalid-feedback.fullname').html('');

                        $('#email').addClass('is-valid');
                        $('#email').removeClass('is-invalid');
                        $('.invalid-feedback.email').html('');

                        $('#phone').addClass('is-valid');
                        $('#phone').removeClass('is-invalid');
                        $('.invalid-feedback.phone').html('');

                        $('#username').addClass('is-valid');
                        $('#username').removeClass('is-invalid');
                        $('.invalid-feedback.username').html('');

                        $('#password').addClass('is-valid');
                        $('#password').removeClass('is-invalid');
                        $('.invalid-feedback.password').html('');
                    }
                }
            })
        })

        // Đăng nhập
        $(document).on('submit', '.postLoginForm', function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= base_url(route_to('postLogin')) ?>",
                cache: false,
                type: "post",
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.error) { // Validation form
                        if (response.error.loginUsername) {
                            $('#loginUsername').addClass('is-invalid');
                            $('.invalid-feedback.loginUsername').html(response.error.loginUsername);
                        } else {
                            $('#loginUsername').removeClass('is-invalid');
                            $('#loginUsername').addClass('is-valid');
                            $('.invalid-feedback.loginUsername').html('');
                        }

                        if (response.error.loginPassword) {
                            $('#loginPassword').addClass('is-invalid');
                            $('.invalid-feedback.loginPassword').html(response.error.loginPassword);
                        } else {
                            $('#loginPassword').removeClass('is-invalid');
                            $('#loginPassword').addClass('is-valid');
                            $('.invalid-feedback.loginPassword').html('');
                        }
                    } else {
                        if (response.danger) {
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

                            toastr["error"](response.danger);
                        }

                        if (response.success) {

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

                            toastr["success"](response.success);

                            $('#userLogin').modal('hide');
                            showLogin();
                        }
                    }
                }
            })
        })

        $(document).on('click', '.postLogout', function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= base_url(route_to('postLogout')) ?>",
                type: "post",
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
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

                    toastr["success"](response.success);
                    $('[data-toggle="popover"]').popover('hide')
                    showLogin();
                }
            })
        })

        // js Poppover
        $(document).ajaxComplete(function() {
            $('.login [data-toggle="popover"]').popover({
                title: "<h1 class='text-uppercase text-center'><?= lang('App.frontend.login.infoCustomer')?></h1>",
                content: "<p class='mb-1'><?= lang('App.frontend.login.fullname')?>: <strong class='text-capitalize'><?= session()->has('userFullname') ? session()->get('userFullname') : '' ?></strong></p> <p class='mb-1'><?= lang('App.frontend.login.phone')?>: <strong><?= session()->has('userPhone') ? session()->get('userPhone') : '' ?></strong></p> <p class='mb-1'>Email: <strong><?= session()->has('userEmail') ? session()->get('userEmail') : '' ?></strong></p> <p <p class='mb-1 mt-3'><a class='text-capitalize btn btn-sm btn-primary btn-block' href='<?= base_url(route_to('infoIndex')) ?>'><?= lang('App.frontend.login.info')?></a><a class='text-capitalize btn btn-sm btn-dark btn-block postLogout' href='<?= base_url(route_to('postLogout')) ?>'><?= lang('App.frontend.login.logout')?></a></p>",
                html: true
            })
        });

        $('.language [data-toggle="popover"]').popover({
            title: "<h1 class='text-uppercase text-center'>Select Languague</h1>",
            content: "<a class='btn btn-danger btn-sm' href='<?= base_url('vi')?>'>Tiếng Việt</a> <a class='btn btn-dark btn-sm' href='<?= base_url('en') ?>'>English</a>",
            html: true
        })
    })
</script>