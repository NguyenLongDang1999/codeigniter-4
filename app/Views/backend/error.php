<!-- Kế thừa layout backend -->
<?= $this->extend('layout/backend/error'); ?>

<!-- Tiêu đề trang -->
<?= $this->section('title') ?>
Không tìm thấy trang
<?= $this->endSection() ?>

<!-- Nội dung trang -->
<?= $this->section('showError') ?>
<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card">

                    <div class="card-body p-4">

                        <div class="error-ghost text-center">
                            <img src="<?= base_url() ?>\assets\images\error.svg" width="200" alt="error-image">
                        </div>

                        <div class="text-center">
                            <h3 class="mt-4 text-uppercase font-weight-bold"> không tìm thấy trang này </h3>

                            <a class="btn btn-primary mt-3" href="<?= base_url() ?>"><i class="mdi mdi-reply mr-1"></i> Return Home</a>
                        </div>

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
<?= $this->endSection() ?>