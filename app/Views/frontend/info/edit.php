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
<link rel="stylesheet" href="<?= base_url() ?>/css/magnific-popup.css" />
<?= $this->endSection() ?>

<!-- Thanh breadcrumb -->
<?= $this->section('breadcrumbs') ?>
<div class="container-fluid mb-3 p-0">
    <div class="breadcrumbs">
        <div class="breadcrumbs__title">Cập nhật thông tin cá nhân</div>
    </div>
</div>
<?= $this->endSection() ?>

<!-- Nội dung trang -->
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="bill-detail">

        <div class="my-4">
            <a href="<?= base_url(route_to('infoIndex')) ?>" class="btn btn-danger border-radius-0 btn-sm">
                Quay lại
            </a>
        </div>

            <?php if (!empty(session()->getFlashdata('success'))) { ?>
                <div class="alert alert-success my-2" role="alert">
                    <?php echo session()->getFlashdata('success') ?>
                </div>
            <?php } ?>
            <h4 class="text-uppercase">Thông tin cá nhân</h4>
            <?= form_open_multipart(base_url(route_to('infoPostEdit', $row['id'])), ['class' => 'mt-3 mb-3']) ?>
                <?= csrf_field() ?>
                <input type="hidden" value="<?= $row['thumb'] ?>" name="checkImg">

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="inputEmail4">Họ và tên <span class="text-danger">(*)</span></label>
                        <input type="text" value="<?= $row['fullname'] ?>" name="fullname" class="form-control border-radius-0 <?= ($validation->getError('fullname')) ? 'is-invalid' : '' ?>" id="inputEmail4">
                        <p class="text-danger mb-0 text-capitalize"><?= $validation->getError('fullname');  ?></p>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Email <span class="text-danger">(*)</span></label>
                        <input type="text" value="<?= $row['email'] ?>" name="email" class="form-control border-radius-0 <?= ($validation->getError('email')) ? 'is-invalid' : '' ?>" id="inputEmail4">
                        <p class="text-danger mb-0 text-capitalize"><?= $validation->getError('email');  ?></p>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Số điện thoại <span class="text-danger">(*)</span></label>
                        <input type="text" value="<?= $row['phone'] ?>" name="phone" class="form-control border-radius-0 <?= ($validation->getError('phone')) ? 'is-invalid' : '' ?>" id="inputEmail4">
                        <p class="text-danger mb-0 text-capitalize"><?= $validation->getError('phone');  ?></p>

                    </div>
                </div>
                <div class="form-group">
                    <label for="inputAddress">Địa chỉ sinh sống</label>
                    <textarea class="form-control border-radius-0" name="address" id="validationTextarea"><?= $row['address'] ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Ảnh đại diện </label>
                        <div class="custom-file">
                            <input type="file" name="thumb" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Chọn ảnh</label>
                        </div>
                        <p class="text-danger mb-0 text-capitalize"><?= $validation->getError('thumb');  ?></p>
                    </div>
                    <div class="form-group col-md-6 text-right">
                        <?php if (!empty($row['thumb'])) { ?>
                            <img src="<?= base_url('uploads/user/' . $row['thumb']) ?>" class="img-fluid" alt="<?= $row['fullname'] ?>">
                        <?php } else { ?>
                            <img src="<?= base_url('uploads/default-image.jpg') ?>" class="img-fluid" alt="<?= $row['fullname'] ?>">
                        <?php } ?>
                    </div>
                </div>

                <button type="submit" class="btn btn-dark btn-sm border-radius-0 text-uppercase">Cập nhật</button>
            <?= form_close()?>
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