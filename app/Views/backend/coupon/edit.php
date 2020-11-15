<!-- Kế thừa layout backend -->
<?= $this->extend('layout/backend/layout'); ?>

<!-- Tiêu đề trang -->
<?= $this->section('title') ?>
Cập nhật coupon
<?= $this->endSection() ?>

<!-- Link CSS trang -->
<?= $this->section('isLink') ?>
<link href="<?= base_url() ?>\assets\libs\bootstrap-datepicker\bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
<?= $this->endSection() ?>

<!-- Nội dung trang -->
<?= $this->section('content') ?>
<!-- start page title -->

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Minton</a></li>
                    <li class="breadcrumb-item"><a class="text-capitalize" href="javascript: void(0);">coupon</a></li>
                    <li class="breadcrumb-item active text-capitalize">Cập nhật</li>
                </ol>
            </div>
            <h4 class="page-title text-capitalize">Cập nhật coupon</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<a href="<?= base_url(route_to('couponIndex')) ?>" class="btn btn-danger waves-effect waves-light mb-3 text-capitalize">Quay Lại <i class="mdi mdi-backspace-outline"></i></a>

<?= form_open(base_url(route_to('couponPostEdit', $row['id']))) ?>
<?= csrf_field() ?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="field-1" class="control-label text-capitalize">Mã code</label>
                    <input type="text" class="form-control <?= ($validation->getError('code')) ? 'parsley-error' : '' ?>" value="<?= set_value('code') ? set_value('code') : $row['code'] ?>" name="code" placeholder="">
                    <ul class="list-unstyled mt-1">
                        <li class="text-danger"> <?= $validation->getError('code');  ?></li>
                    </ul>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="field-1" class="control-label text-capitalize">Số tiền giảm giá</label>
                    <input type="text" class="form-control <?= ($validation->getError('price_discount')) ? 'parsley-error' : '' ?>" value="<?= set_value('price_discount') ? set_value('price_discount') : $row['price_discount'] ?>" name="price_discount" placeholder="">
                    <ul class="list-unstyled mt-1">
                        <li class="text-danger"> <?= $validation->getError('price_discount');  ?></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="field-1" class="control-label text-capitalize">giới hạn số lượng nhập</label>
                    <input type="text" class="form-control <?= ($validation->getError('code_limit')) ? 'parsley-error' : '' ?>" value="<?= set_value('code_limit') ? set_value('code_limit') : $row['code_limit'] ?>" name="code_limit" placeholder="">
                    <ul class="list-unstyled mt-1">
                        <li class="text-danger"> <?= $validation->getError('code_limit');  ?></li>
                    </ul>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="field-1" class="control-label text-capitalize">Ngày hết hạn</label>
                    <div class="input-group">
                        <input type="text" class="form-control datepicker <?= ($validation->getError('expiration_date')) ? 'parsley-error' : '' ?>" name="expiration_date" data-provide="datepicker" value="<?= set_value('expiration_date') ? set_value('expiration_date') : $row['expiration_date'] ?>" data-date-autoclose="true">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="ti-calendar"></i></span>
                        </div>
                    </div>
                    <ul class="list-unstyled mt-1">
                        <li class="text-danger"> <?= $validation->getError('expiration_date');  ?></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="field-1" class="control-label text-capitalize">Đơn hàng tối thiểu thể nhập code</label>
                    <input type="text" class="form-control <?= ($validation->getError('price_payment_limit')) ? 'parsley-error' : '' ?>" value="<?= set_value('price_payment_limit') ? set_value('price_payment_limit') : $row['price_payment_limit'] ?>" name="price_payment_limit" placeholder="">
                    <ul class="list-unstyled mt-1">
                        <li class="text-danger"> <?= $validation->getError('price_payment_limit');  ?></li>
                    </ul>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="field-1" class="control-label text-capitalize">Mô tả code</label>
                    <input type="text" class="form-control <?= ($validation->getError('code_description')) ? 'parsley-error' : '' ?>" value="<?= set_value('code_description') ? set_value('code_description') : $row['code_description'] ?>" name="code_description" placeholder="">
                    <ul class="list-unstyled mt-1">
                        <li class="text-danger"> <?= $validation->getError('code_description');  ?></li>
                    </ul>
                </div>
            </div>
        </div>

        <button type="reset" class="btn btn-secondary waves-effect" data-dismiss="modal">Nhập Lại</button>
        <button type="submit" class="btn btn-info waves-effect waves-light btn-spinner">Lưu</button>

    </div>
</div>
<?= form_close() ?>
<?= $this->endSection() ?>

<!-- Link JS trang -->
<?= $this->section('isScript') ?>
<script src="<?= base_url() ?>\assets\libs\bootstrap-datepicker\bootstrap-datepicker.min.js"></script>
<script>
    $(".datepicker").datepicker({ 
        format: 'yyyy-mm-dd'
    });
</script>
<script src="<?= base_url() ?>\assets\js\pages\form-pickers.init.js"></script>
<!-- Datatables init -->
<script src="<?= base_url() ?>\assets\js\pages\form-advanced.init.js"></script>
<?= $this->endSection() ?>