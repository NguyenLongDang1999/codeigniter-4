<!-- Kế thừa layout frontend -->
<?= $this->extend('layout/frontend/layout'); ?>

<!-- Tiêu đề trang -->
<?= $this->section('title') ?>
Thông tin thanh toán đơn hàng
<?= $this->endSection() ?>

<!-- Link CSS trang -->
<?= $this->section('isLink') ?>
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="<?= base_url() ?>/public/css/magnific-popup.css" />
<?= $this->endSection() ?>

<!-- Thanh breadcrumb -->
<?= $this->section('breadcrumbs') ?>
<div class="container-fluid mb-3 p-0">
    <div class="breadcrumbs">
        <div class="breadcrumbs__title">Lấy lại mật khẩu</div>
    </div>
</div>
<?= $this->endSection() ?>

<!-- Nội dung trang -->
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="bill-detail">
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
            <h4 class="text-uppercase text-center">Lấy lại mật khẩu</h4>
            <?= form_open(base_url(route_to('infoGetPostForgotPassword', $row['id'])), ['class' => 'mt-3 mb-3']) ?>
            <?= csrf_field() ?>
            <div class="form-row d-flex justify-content-center">
                <div class="form-group col-md-4">
                    <label for="inputEmail4">Mật khẩu mới <span class="text-danger">(*)</span></label>
                    <input type="password" name="passwordNew" class="form-control border-radius-0 <?= ($validation->getError('passwordNew')) ? 'is-invalid' : '' ?>" id="inputEmail4">
                    <p class="text-danger mb-0 text-capitalize"><?= $validation->getError('passwordNew');  ?></p>
                </div>
            </div>

            <div class="form-row d-flex justify-content-center">
                <div class="form-group col-md-4">
                    <label for="inputEmail4">Nhập lại mật khẩu <span class="text-danger">(*)</span></label>
                    <input type="password" name="rePasswordNew" class="form-control border-radius-0 <?= ($validation->getError('rePasswordNew')) ? 'is-invalid' : '' ?>" id="inputEmail4">
                    <p class="text-danger mb-0 text-capitalize"><?= $validation->getError('rePasswordNew');  ?></p>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-dark btn-sm border-radius-0 text-uppercase">Cập nhật</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('isScript') ?>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<!-- Jquery Cookie JS -->
<script src="<?= base_url() ?>/public/js/jquery-cookie.js"></script>
<!-- Magnific JS -->
<script src="<?= base_url() ?>/public/js/jquery.magnific-popup.min.js"></script>
<?= $this->endSection() ?>

<?= $this->section('isAjax') ?>
<script>
    $(function() {

        // DelCart
        $(".showCart").on("click", ".delCart", function() {
            toastr.options = {
                "closeButton": true,
                "debug": true,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-bottom-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "timeOut": "3000",
                "hideDuration": "1000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            toastr["error"]('Trạng thái hiện tại không cho phép thao tác xóa sản phẩm.')
        })
        // end del cart
    })
</script>
<?= $this->endSection() ?>