<!-- Kế thừa layout backend -->
<?= $this->extend('layout/backend/layout'); ?>

<!-- Tiêu đề trang -->
<?= $this->section('title') ?>
Reply - <?= $row['fullname'] ?>
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
                    <li class="breadcrumb-item"><a class="text-capitalize" href="javascript: void(0);">Liên hệ</a></li>
                    <li class="breadcrumb-item active text-capitalize">Chi tiết</li>
                </ol>
            </div>
            <h4 class="page-title text-capitalize">Chi tiết</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<a href="<?= base_url(route_to('contactIndexBE')) ?>" class="btn btn-danger waves-effect waves-light mb-3 text-capitalize">Quay Lại <i class="mdi mdi-backspace-outline"></i></a>

<?= form_open(base_url(route_to('contactPostDetail', $row['id']))) ?>
<?= csrf_field() ?>

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
                    <label for="field-1" class="control-label text-capitalize">Nội dung liên hệ</label>
                    <textarea name="body" class="form-control" readonly><?= $row['body'] ?></textarea>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 100px;">
            <div class="col-12">
                <div class="form-group">
                    <label for="field-1" class="control-label text-capitalize">Trả lời liên hệ</label>
                    <textarea name="reply" class="form-control"></textarea>
                    <ul class="list-unstyled mt-1">
                        <li class="text-danger"> <?= $validation->getError('reply');  ?></li>
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
<!-- Plugins js -->
<script src="<?= base_url() ?>\assets\libs\dropify\dropify.min.js"></script>
<!-- Datatables init -->
<script src="<?= base_url() ?>\assets\js\pages\form-advanced.init.js"></script>
<script src="<?= base_url() ?>\assets\js\pages\dropify.init.js"></script>
<?= $this->endSection() ?>