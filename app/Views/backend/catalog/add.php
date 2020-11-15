<!-- Kế thừa layout backend -->
<?= $this->extend('layout/backend/layout'); ?>

<!-- Tiêu đề trang -->
<?= $this->section('title') ?>
Thêm mới danh mục
<?= $this->endSection() ?>

<!-- Link CSS trang -->
<?= $this->section('isLink') ?>
<link href="<?= base_url() ?>\assets\libs\select2\select2.min.css" rel="stylesheet" type="text/css">
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
                    <li class="breadcrumb-item"><a class="text-capitalize" href="javascript: void(0);">Danh mục sản phẩm</a></li>
                    <li class="breadcrumb-item active text-capitalize">Thêm mới</li>
                </ol>
            </div>
            <h4 class="page-title text-capitalize">Thêm mới danh mục</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<a href="<?= base_url(route_to('catalogIndex')) ?>" class="btn btn-danger waves-effect waves-light mb-3 text-capitalize">Quay Lại <i class="mdi mdi-backspace-outline"></i></a>

<?= form_open_multipart(base_url(route_to('catalogPostAdd'))) ?>
<?= csrf_field() ?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="field-1" class="control-label text-capitalize">Tên danh mục</label>
                    <input type="text" class="form-control <?= ($validation->getError('name')) ? 'parsley-error' : '' ?>" value="<?= set_value('name') ?>" name="name" placeholder="">
                    <ul class="list-unstyled mt-1">
                        <li class="text-danger"> <?= $validation->getError('name');  ?></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="field-2" class="control-label text-capitalize">Danh mục cha</label>
                    <select class="form-control select2" name="parentid">
                        <option selected value="">[--- Chọn danh mục cha ---]</option>
                        <option value="0" <?= set_select('parentid', 0) ?>>Là danh mục cha</option>
                        <?php
                        $showListCat = $mcatalog->catalogSubCatalog();
                        foreach ($showListCat as $item) { ?>
                            <?php $showListCat1 = $mcatalog->catalogSubCatalog($item['id']); ?>
                            <option value="<?= $item['id'] ?>" <?= set_select('parentid', $item['id']) ?>><?= $item['name'] ?></option>
                            <?php foreach ($showListCat1 as $item1) { ?>
                                <?php $showListCat2 = $mcatalog->catalogSubCatalog($item1['id']); ?>
                                <option value="<?= $item1['id'] ?>" <?= set_select('parentid', $item1['id']) ?>>- - - <?= $item1['name'] ?></option>

                                <?php foreach ($showListCat2 as $item2) { ?>
                                    <option value="<?= $item2['id'] ?>" <?= set_select('parentid', $item2['id']) ?>>- - - - - - <?= $item2['name'] ?></option>

                                <?php } ?>

                            <?php } ?>
                        <?php } ?>
                    </select>
                    <ul class="list-unstyled mt-1">
                        <li class="parsley-required text-danger"> <?= $validation->getError('parentid');  ?></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="field-2" class="control-label text-capitalize">Ảnh đại diện danh mục</label>
                    <input type="file" class="dropify" name="thumb">
                    <ul class="list-unstyled mt-1">
                        <li class="parsley-required text-danger"> <?= $validation->getError('thumb');  ?></li>
                    </ul>
                </div>

                <!-- end card-->
            </div>
            <!-- end col-->
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="field-1" class="control-label text-capitalize">Meta title (SEO)</label>
                    <input type="text" class="form-control <?= ($validation->getError('meta_title')) ? 'parsley-error' : '' ?>" value="<?= set_value('meta_title') ?>" name="meta_title" placeholder="">
                    <ul class="list-unstyled mt-1">
                        <li class="text-danger"> <?= $validation->getError('meta_title');  ?></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="field-1" class="control-label text-capitalize">Meta keyword (SEO)</label>
                    <input type="text" class="form-control <?= ($validation->getError('meta_keyword')) ? 'parsley-error' : '' ?>" value="<?= set_value('meta_keyword') ?>" name="meta_keyword" placeholder="">
                    <ul class="list-unstyled mt-1">
                        <li class="text-danger"> <?= $validation->getError('meta_keyword');  ?></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="field-2" class="control-label text-capitalize">Meta Description (SEO)</label>
                    <textarea name="meta_desc" class="form-control <?= ($validation->getError('meta_desc')) ? 'parsley-error' : '' ?>"><?= set_value('meta_desc') ?></textarea>
                    <ul class="list-unstyled mt-1">
                        <li class="parsley-required text-danger"> <?= $validation->getError('meta_desc');  ?></li>
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
<script src="<?= base_url() ?>\assets\libs\multiselect\jquery.multi-select.js"></script>
<script src="<?= base_url() ?>\assets\libs\select2\select2.min.js"></script>
<!-- Plugins js -->
<script src="<?= base_url() ?>\assets\libs\dropify\dropify.min.js"></script>
<!-- Datatables init -->
<script src="<?= base_url() ?>\assets\js\pages\form-advanced.init.js"></script>
<script src="<?= base_url() ?>\assets\js\pages\dropify.init.js"></script>
<?= $this->endSection() ?>