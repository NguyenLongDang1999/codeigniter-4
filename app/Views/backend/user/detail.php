<!-- Kế thừa layout backend -->
<?= $this->extend('layout/backend/layout'); ?>

<!-- Tiêu đề trang -->
<?= $this->section('title') ?>
Chi tiết - <?= $row['fullname'] ?>
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
                    <li class="breadcrumb-item"><a class="text-capitalize" href="javascript: void(0);">Khách hàng</a></li>
                    <li class="breadcrumb-item active text-capitalize">Chi tiết</li>
                </ol>
            </div>
            <h4 class="page-title text-capitalize">Chi tiết</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<a href="<?= base_url(route_to('userIndex')) ?>" class="btn btn-danger waves-effect waves-light mb-3 text-capitalize">Quay Lại <i class="mdi mdi-backspace-outline"></i></a>

<?php if (session()->getFlashdata('success')) { ?>
    <div class="alert alert-success" role="alert">
        <i class="mdi mdi-check-all mr-2"></i> <?= session()->getFlashdata('success') ?>
    </div>
<?php } ?>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="field-1" class="control-label text-capitalize">Họ và tên</label>
                    <input type="text" class="form-control" readonly value="<?= $row['fullname'] ?>" name="fullname" placeholder="">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="field-1" class="control-label text-capitalize">Email</label>
                    <input type="text" class="form-control" readonly value="<?= $row['email'] ?>" name="email" placeholder="">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="field-1" class="control-label text-capitalize">Số điện thoại</label>
                    <input type="text" class="form-control" readonly value="<?= $row['phone'] ?>" name="phone" placeholder="">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="field-1" class="control-label text-capitalize">Địa chỉ sinh sống</label>
                    <textarea class="form-control" readonly><?= $row['address'] ?></textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label for="inputEmail4">Ảnh đại diện </label>
            </div>
            <div class="form-group col-md-6 text-right">
                <?php if (!empty($row['thumb'])) { ?>
                    <img src="<?= base_url('uploads/user/' . $row['thumb']) ?>" class="img-fluid" alt="<?= $row['fullname'] ?>">
                <?php } else { ?>
                    <img src="<?= base_url('uploads/default-image.jpg') ?>" class="img-fluid" alt="<?= $row['fullname'] ?>">
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<!-- Link JS trang -->
<?= $this->section('isScript') ?>
<!-- Plugins js -->
<script src="<?= base_url() ?>\assets\libs\dropify\dropify.min.js"></script>
<!-- Datatables init -->
<script src="<?= base_url() ?>\assets\js\pages\form-advanced.init.js"></script>
<script src="<?= base_url() ?>\assets\js\pages\dropify.init.js"></script>
<?= $this->endSection() ?>