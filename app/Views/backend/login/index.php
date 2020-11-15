<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Minton - Đăng nhập trang quản trị</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta content="Coderthemes" name="author">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets\images\favicon.ico">

    <!-- App css -->
    <link href="<?= base_url() ?>\assets\css\bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>\assets\css\icons.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>\assets\css\app.min.css" rel="stylesheet" type="text/css">

</head>

<body>

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <a href="index.html">
                                    <span><img src="<?= base_url() ?>\assets\images\logo-dark.png" alt="" height="22"></span>
                                </a>
                                <p class="text-muted mb-4 mt-3">Nhập username và password để đăng nhập vào trang quản trị.</p>
                            </div>

                            <?php if (session()->getFlashdata('error')) { ?>
                                <div class="alert alert-warning" role="alert">
                                    <i class="mdi mdi-alert-outline mr-2"></i> <?= session()->getFlashdata('error') ?>
                                </div>
                            <?php } ?>

                            <?= form_open(base_url(route_to('loginLogin'))) ?>
                            <?= csrf_field() ?>
                            <div class="form-group mb-3">
                                <label for="emailaddress">Username</label>
                                <input class="form-control" type="text" id="emailaddress" name="username" placeholder="">
                            </div>

                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input class="form-control" type="password" name="password" id="password" placeholder="">
                            </div>

                            <div class="form-group mb-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="remember" class="custom-control-input" id="checkbox-signin" checked="">
                                    <label class="custom-control-label text-capitalize" for="checkbox-signin">Nhớ mật khẩu</label>
                                </div>
                            </div>

                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-primary btn-block text-capitalize" type="submit"> Đăng nhập </button>
                            </div>

                            </form>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->


    <footer class="footer footer-alt">
        2016 - 2019 &copy; Minton theme by <a href="" class="text-muted">Coderthemes</a>
    </footer>

    <!-- Vendor js -->
    <script src="<?= base_url() ?>\assets\js\vendor.min.js"></script>

    <!-- App js -->
    <script src="<?= base_url() ?>\assets\js\app.min.js"></script>

</body>

</html>