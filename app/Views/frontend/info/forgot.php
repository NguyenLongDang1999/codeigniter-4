<!-- Kế thừa layout backend -->
<?= $this->extend('layout/backend/error'); ?>

<!-- Tiêu đề trang -->
<?= $this->section('title') ?>
Quên mật khẩu
<?= $this->endSection() ?>

<!-- Nội dung trang -->
<?= $this->section('showError') ?>
<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card">

                    <div class="card-body p-4">

                        <div class="text-center w-75 m-auto">
                            <a href="javascript:void(0)">
                                <span><img src="<?= base_url() ?>\public\assets\images\logo-dark.png" alt="" height="22"></span>
                            </a>
                            <p class="text-muted mb-4 mt-3">Nhập Email của bạn và chúng tôi sẽ gửi hướng dẫn để lấy lại mật khẩu của bạn.</p>

                        </div>

                        <?php if (!empty(session()->getFlashdata('error'))) { ?>
                            <div class="alert alert-danger my-2" role="alert">
                                <?php echo session()->getFlashdata('error') ?>
                            </div>
                        <?php } ?>

                        <?php if (!empty(session()->getFlashdata('success'))) { ?>
                            <div class="alert alert-success my-2" role="alert">
                                <?php echo session()->getFlashdata('success') ?>
                            </div>
                        <?php } ?>

                        <?= form_open(base_url(route_to('infoPostForgotPassword'))) ?>

                        <div class="form-group mb-3">
                            <label for="emailaddress">Email address</label>
                            <input class="form-control <?= ($validation->getError('email')) ? 'is-invalid' : '' ?>" name="email" type="text" id="emailaddress" placeholder="Enter your email">
                            <p class="text-danger mb-0 text-capitalize"><?= $validation->getError('email');  ?></p>
                        </div>

                        <div class="form-group mb-0 text-center">
                            <button class="btn btn-primary btn-block text-capitalize" type="submit"> Tiếp tục </button>
                        </div>

                        <?= form_close() ?>

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
<!-- end page -->
<?= $this->endSection() ?>