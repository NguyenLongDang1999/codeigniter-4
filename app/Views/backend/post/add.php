<!-- Kế thừa layout backend -->
<?= $this->extend('layout/backend/layout'); ?>

<!-- Tiêu đề trang -->
<?= $this->section('title') ?>
Thêm mới tin tức
<?= $this->endSection() ?>

<!-- Link CSS trang -->
<?= $this->section('isLink') ?>
<link href="<?= base_url() ?>\assets\libs\summernote\summernote-bs4.css" rel="stylesheet" type="text/css">
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
                    <li class="breadcrumb-item"><a class="text-capitalize" href="javascript: void(0);">tin tức</a></li>
                    <li class="breadcrumb-item active text-capitalize">Thêm mới</li>
                </ol>
            </div>
            <h4 class="page-title text-capitalize">Thêm mới tin tức</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<a href="<?= base_url(route_to('postIndex')) ?>" class="btn btn-danger waves-effect waves-light mb-3 text-capitalize">Quay Lại <i class="mdi mdi-backspace-outline"></i></a>

<?= form_open_multipart(base_url(route_to('postPostAdd'))) ?>
<?= csrf_field() ?>
<div class="card">
    <div class="card-body">
        <div id="progressbarwizard">

            <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                <li class="nav-item">
                    <a href="#account-2" data-toggle="tab" class="nav-link">
                        <span class="number">1.</span>
                        <span class="d-none d-sm-inline text-capitalize">Thông tin cơ bản tin tức</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#profile-tab-2" data-toggle="tab" class="nav-link">
                        <span class="number">2.</span>
                        <span class="d-none d-sm-inline text-capitalize">Thông tin chi tiết tin tức </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#finish-2" data-toggle="tab" class="nav-link">
                        <span class="number">3.</span>
                        <span class="d-none d-sm-inline">SEO</span>
                    </a>
                </li>
            </ul>

            <div class="tab-content b-0 mb-0">

                <div id="bar" class="progress mb-3" style="height: 7px;">
                    <div class="bar progress-bar progress-bar-striped progress-bar-animated bg-success"></div>
                </div>

                <div class="tab-pane" id="account-2">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="field-1" class="control-label text-capitalize">Tên tin tức</label>
                                <input type="text" class="form-control <?= ($validation->getError('name')) ? 'parsley-error' : '' ?>" value="<?= set_value('name') ?>" name="name" placeholder="">
                                <ul class="list-unstyled mt-1">
                                    <li class="text-danger"> <?= $validation->getError('name');  ?></li>
                                </ul>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->


                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="field-2" class="control-label text-capitalize">Ảnh đại diện tin tức</label>
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
                </div>

                <div class="tab-pane" id="profile-tab-2">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="field-1" class="control-label text-capitalize">Danh mục</label>
                                <select class="form-control select2" name="catpostid">
                                    <option selected value="">[--- Chọn danh mục ---]</option>

                                    <?php foreach ($catalog_subcat as $item) { ?>
                                        <option value="<?= $item['id'] ?>" <?= set_select('catpostid', $item['id']) ?>><?= $item['name'] ?></option>
                                        <?php $catalog_subcat2 = $mcatpost->where(['parentid' => $item['id'], 'status' => 1])->orderBy('created_at', 'desc')->findAll() ?>
                                        <?php if (count($catalog_subcat2)) { ?>
                                            <?php foreach ($catalog_subcat2 as $item2) { ?>
                                                <option value="<?= $item2['id'] ?>" <?= set_select('catpostid', $item2['id']) ?>> - - - <?= $item2['name'] ?></option>
                                                <?php $catalog_subcat3 = $mcatpost->where(['parentid' => $item2['id'], 'status' => 1])->orderBy('created_at', 'desc')->findAll() ?>
                                                <?php if (count($catalog_subcat3)) { ?>
                                                    <?php foreach ($catalog_subcat3 as $item3) { ?>
                                                        <option value="<?= $item3['id'] ?>" <?= set_select('catpostid', $item3['id']) ?>> - - - - - - <?= $item3['name'] ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                                <ul class="list-unstyled mt-1">
                                    <li class="text-danger"> <?= $validation->getError('catpostid');  ?></li>
                                </ul>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="field-2" class="control-label text-capitalize">Mô tả ngắn</label>
                                <textarea name="intro_desc" class="form-control <?= ($validation->getError('intro_desc')) ? 'parsley-error' : '' ?>"><?= set_value('intro_desc') ?></textarea>
                                <ul class="list-unstyled mt-1">
                                    <li class="parsley-required text-danger"> <?= $validation->getError('intro_desc');  ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="field-2" class="control-label text-capitalize">Mô tả chi tiết tin tức</label>
                                <textarea id="summernote-editor" name="detail_desc" class="form-control <?= ($validation->getError('detail_desc')) ? 'parsley-error' : '' ?>"><?= set_value('detail_desc') ?></textarea>
                                <ul class="list-unstyled mt-1">
                                    <li class="parsley-required text-danger"> <?= $validation->getError('detail_desc');  ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="finish-2">
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
                </div>

                <ul class="list-inline mb-0 wizard">
                    <li class="previous list-inline-item">
                        <a href="javascript: void(0);" class="btn btn-secondary">Previous</a>
                    </li>
                    <li class="next list-inline-item float-right">
                        <a href="javascript: void(0);" class="btn btn-secondary">Next</a>
                    </li>
                </ul>

                <div class="mt-3">
                    <button type="reset" class="btn btn-secondary waves-effect" data-dismiss="modal">Nhập Lại</button>
                    <button type="submit" class="btn btn-info waves-effect waves-light btn-spinner">Lưu</button>
                </div>

            </div> <!-- tab-content -->
        </div> <!-- end #progressbarwizard-->
    </div>
</div>

<?= form_close() ?>
<?= $this->endSection() ?>

<!-- Link JS trang -->
<?= $this->section('isScript') ?>
<script src="<?= base_url() ?>\assets\libs\multiselect\jquery.multi-select.js"></script>
<script src="<?= base_url() ?>\assets\libs\select2\select2.min.js"></script>
<script src="<?= base_url() ?>\assets\libs\twitter-bootstrap-wizard\jquery.bootstrap.wizard.min.js"></script>
<script src="<?= base_url() ?>\assets\libs\summernote\summernote-bs4.min.js"></script>
<!-- Plugins js -->
<script src="<?= base_url() ?>\assets\libs\dropify\dropify.min.js"></script>
<!-- Datatables init -->
<script src="<?= base_url() ?>\assets\js\pages\form-advanced.init.js"></script>
<script src="<?= base_url() ?>\assets\js\pages\form-wizard.init.js"></script>
<script src="<?= base_url() ?>\assets\js\pages\dropify.init.js"></script>
<script src="<?= base_url() ?>\assets\js\pages\form-summernote.init.js"></script>
<?= $this->endSection() ?>