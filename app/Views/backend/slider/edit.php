<!-- Kế thừa layout backend -->
<?= $this->extend('layout/backend/layout'); ?>

<!-- Tiêu đề trang -->
<?= $this->section('title') ?>
Cập nhật slider
<?= $this->endSection() ?>

<!-- Link CSS trang -->
<?= $this->section('isLink') ?>
<!-- Plugins css -->
<link href="<?= base_url() ?>\assets\libs\dropify\dropify.min.css" rel="stylesheet" type="text/css">
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
                    <li class="breadcrumb-item"><a class="text-capitalize" href="javascript: void(0);">slider</a></li>
                    <li class="breadcrumb-item active text-capitalize">Cập nhật</li>
                </ol>
            </div>
            <h4 class="page-title text-capitalize">Cập nhật slider</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<a href="<?= base_url(route_to('sliderIndex')) ?>" class="btn btn-danger waves-effect waves-light mb-3 text-capitalize">Quay Lại <i class="mdi mdi-backspace-outline"></i></a>

<?= form_open_multipart(base_url(route_to('sliderPostEdit', $row['id']))) ?>
<?= csrf_field() ?>
<input type="hidden" value="<?= $row['thumb'] ?>" name="checkImg">
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="field-1" class="control-label text-capitalize">Tên slider</label>
                    <input type="text" class="form-control <?= ($validation->getError('name')) ? 'parsley-error' : '' ?>" value="<?= set_value('name') ? set_value('name') : $row['name'] ?>" name="name" placeholder="">
                    <ul class="list-unstyled mt-1">
                        <li class="text-danger"> <?= $validation->getError('name');  ?></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="field-2" class="control-label text-capitalize">Ảnh đại diện slider</label>
                    <input type="file" class="dropify" name="thumb" data-default-file="<?= ($row['thumb'] == 'default-image.jpg') ? base_url('uploads/' . $row['thumb']) : base_url('uploads/slider/' . $row['thumb']) ?>">
                    <ul class="list-unstyled mt-1">
                        <li class="parsley-required text-danger"> <?= $validation->getError('thumb');  ?></li>
                    </ul>
                </div>

                <!-- end card-->
            </div>
            <!-- end col-->
        </div>
        <!-- end row -->
        
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