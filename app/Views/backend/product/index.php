<!-- Kế thừa layout backend -->
<?= $this->extend('layout/backend/layout'); ?>

<!-- Tiêu đề trang -->
<?= $this->section('title') ?>
Xem danh sách sản phẩm
<?= $this->endSection() ?>

<!-- Link CSS trang -->
<?= $this->section('isLink') ?>
<!-- third party css -->
<link href="<?= base_url() ?>\assets\libs\datatables\dataTables.bootstrap4.css" rel="stylesheet" type="text/css">
<link href="<?= base_url() ?>\assets\libs\datatables\responsive.bootstrap4.css" rel="stylesheet" type="text/css">
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
                    <li class="breadcrumb-item"><a class="text-capitalize" href="javascript: void(0);">Sản phẩm</a></li>
                    <li class="breadcrumb-item active text-capitalize">Xem danh sách</li>
                </ol>
            </div>
            <h4 class="page-title text-capitalize">Xem danh sách sản phẩm</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">

        <a href="<?= base_url(route_to('productAdd')) ?>" class="btn btn-success waves-effect waves-light mb-2 text-capitalize">Thêm mới <i class="mdi mdi-plus-box"></i></a>
        <a href="<?= base_url(route_to('productRecycle')) ?>" class="btn btn-info waves-effect waves-light mb-2 text-capitalize">Thùng rác <i class="mdi mdi-trash-can"></i></a>

        <?php if (session()->getFlashdata('error')) { ?>
            <div class="alert alert-warning" role="alert">
                <i class="mdi mdi-alert-outline mr-2"></i> <?= session()->getFlashdata('error') ?>
            </div>
        <?php } ?>

        <?php if (session()->getFlashdata('success')) { ?>
            <div class="alert alert-success" role="alert">
                <i class="mdi mdi-check-all mr-2"></i> <?= session()->getFlashdata('success') ?>
            </div>
        <?php } ?>

        <div class="card">
            <div class="card-body">

                <table id="basic-datatable" class="table dt-responsive nowrap">
                    <thead class="text-capitalize">
                        <tr>
                            <th>#</th>
                            <th></th>
                            <th>Thông tin cơ bản</th>
                            <th>Thông tin chi tiết</th>
                            <th>trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Ngày sửa</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($list as $item) { ?>
                            <?php $status = ($item['status'] == 1) ? '<span class="badge badge-light-success">Hiển thị</span>' : '<span class="badge badge-light-danger">Không hiển thị</span>' ?>
                            <?php $featured = ($item['featured'] == 1) ? '<span class="badge badge-light-info">Nổi bật</span>' : '<span class="badge badge-light-warning">Không nổi bật</span>' ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <th>
                                    <?php if ($item['thumb'] == 'default-image.jpg') { ?>
                                        <img src="<?= base_url('uploads/' . $item['thumb']) ?>" class="img-fluid" alt="<?= $item['name'] ?>">
                                    <?php } else { ?>
                                        <img src="<?= base_url('uploads/product/' . $item['thumb']) ?>" class="img-fluid w-100" alt="<?= $item['name'] ?>">
                                    <?php } ?>
                                </th>
                                <td>
                                    <ul class="m-0 list-unstyled">
                                        <li class="text-truncate" style="width: 150px"><?= $item['name'] ?> - <?= $item['sku'] ?></li>
                                        <li>Số khuyến mãi: <?= $item['sale'] ?>%</li>
                                        <li>Giá bán: <?= number_format($item['price'], 0, ",", ".") ?> VNĐ</li>
                                        <li>Lượt xem: <?= $item['view'] ?></li>
                                        <li>Số lượng: <?= $item['quantity'] ?></li>
                                        <li>Đã bán: <?= $item['number_buy'] ?></li>
                                    </ul>
                                </td>
                                <td>
                                    <ul class="m-0 list-unstyled">
                                        <li class="text-truncate" style="width: 150px">Danh mục: <?= $mcatalog->catalogGetName($item['catid'])['name']?></li>
                                        <li class="text-truncate" style="width: 150px">Thương hiệu: <?= isset($mbrand->brandGetName($item['id'])['name']) ? $mbrand->brandGetName($item['id'])['name'] : 'Không' ?></li>
                                    </ul>
                                </td>
                                <td>
                                    <a href="<?= base_url(route_to('productStatus', $item['id'])) ?>"><?= $status ?></a>
                                    <a href="<?= base_url(route_to('productFeatured', $item['id'])) ?>"><?= $featured ?></a>
                                </td>
                                <td><?= $item['created_at'] ?></td>
                                <td><?= $item['updated_at'] ?></td>
                                <td>
                                    <a href="<?= base_url(route_to('productEdit', $item['id'])) ?>" class="btn btn-xs btn-secondary"><i class="mdi mdi-pencil"></i></a>
                                    <a href="<?= base_url(route_to('productTrash', $item['id'])) ?>" onclick="return confirm('Bạn có chắn chắn muốn đưa sản phẩm này vào thùng rác ?')" class="btn btn-xs btn-danger"><i class="mdi mdi-trash-can-outline"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<!-- end row-->
<?= $this->endSection() ?>

<!-- Link JS trang -->
<?= $this->section('isScript') ?>
<!-- third party js -->
<script src="<?= base_url() ?>\assets\libs\datatables\jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>\assets\libs\datatables\dataTables.bootstrap4.js"></script>
<script src="<?= base_url() ?>\assets\libs\datatables\dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>\assets\libs\datatables\responsive.bootstrap4.min.js"></script>

<!-- Datatables init -->
<script src="<?= base_url() ?>\assets\js\pages\datatables.init.js"></script>
<?= $this->endSection() ?>