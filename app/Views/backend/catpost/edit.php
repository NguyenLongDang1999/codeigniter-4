<!-- Kế thừa layout backend -->
<?= $this->extend('layout/backend/layout'); ?>

<!-- Tiêu đề trang -->
<?= $this->section('title') ?>
Cập nhật danh mục
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
                    <li class="breadcrumb-item"><a class="text-capitalize" href="javascript: void(0);">Danh mục tin tức</a></li>
                    <li class="breadcrumb-item active text-capitalize">Cập nhật</li>
                </ol>
            </div>
            <h4 class="page-title text-capitalize">Cập nhật danh mục</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<a href="<?= base_url(route_to('catpostIndex')) ?>" class="btn btn-danger waves-effect waves-light mb-3 text-capitalize">Quay Lại <i class="mdi mdi-backspace-outline"></i></a>

<?= form_open_multipart(base_url(route_to('catpostPostEdit', $row['id']))) ?>
<?= csrf_field() ?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="field-1" class="control-label text-capitalize">Tên danh mục</label>
                    <input type="text" class="form-control <?= ($validation->getError('name')) ? 'parsley-error' : '' ?>" value="<?= set_value('name') ? set_value('name') : $row['name'] ?>" name="name" placeholder="">
                    <ul class="list-unstyled mt-1">
                        <li class="text-danger"> <?= $validation->getError('name');  ?></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="field-2" class="control-label text-capitalize">Danh mục cha</label>
                    <select class="form-control select2" name="parentid">
                        <option value="0" <?= set_select('parentid', 0) ?>>Là danh mục cha</option>
                        <?php
                        $showListCat = $mcatpost->catpostSubcatpost();
                        foreach ($showListCat as $item) { ?>
                            <?php $showListCat1 = $mcatpost->catpostSubcatpost($item['id']); ?>
                            <?php if($row['parentid'] == $item['id']) { ?>
                                <option value="<?= $item['id'] ?>" selected <?= set_select('parentid', $item['id']) ?>><?= $item['name'] ?></option>
                            <?php } else { ?>
                                <option value="<?= $item['id'] ?>" <?= set_select('parentid', $item['id']) ?>><?= $item['name'] ?></option>
                            <?php } ?>
                            
                            <?php foreach ($showListCat1 as $item1) { ?>
                                <?php $showListCat2 = $mcatpost->catpostSubcatpost($item1['id']); ?>
                                
                                <?php if($row['parentid'] == $item1['id']) { ?>
                                    <option value="<?= $item1['id'] ?>" selected <?= set_select('parentid', $item1['id']) ?>> - - - <?= $item1['name'] ?></option>
                                <?php } else { ?>
                                    <option value="<?= $item1['id'] ?>" <?= set_select('parentid', $item1['id']) ?>> - - - <?= $item1['name'] ?></option>
                                <?php } ?>


                                <?php foreach ($showListCat2 as $item2) { ?>
                                    
                                    <?php if($row['parentid'] == $item2['id']) { ?>
                                        <option value="<?= $item2['id'] ?>" selected <?= set_select('parentid', $item2['id']) ?>> - - - - - - <?= $item2['name'] ?></option>
                                    <?php } else { ?>
                                        <option value="<?= $item2['id'] ?>" <?= set_select('parentid', $item2['id']) ?>> - - - - - - <?= $item2['name'] ?></option>
                                    <?php } ?>

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
                    <label for="field-1" class="control-label text-capitalize">Meta title (SEO)</label>
                    <input type="text" class="form-control <?= ($validation->getError('meta_title')) ? 'parsley-error' : '' ?>" value="<?= set_value('meta_title') ? set_value('meta_title') : $row['meta_title'] ?>" name="meta_title" placeholder="">
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
                    <input type="text" class="form-control <?= ($validation->getError('meta_keyword')) ? 'parsley-error' : '' ?>" value="<?= set_value('meta_keyword') ? set_value('meta_keyword') : $row['meta_keyword'] ?>" name="meta_keyword" placeholder="">
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
                    <textarea name="meta_desc" class="form-control <?= ($validation->getError('meta_desc')) ? 'parsley-error' : '' ?>"><?= set_value('meta_desc') ? set_value('meta_desc') : $row['meta_desc'] ?></textarea>
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
<!-- Datatables init -->
<script src="<?= base_url() ?>\assets\js\pages\form-advanced.init.js"></script>
<?= $this->endSection() ?>