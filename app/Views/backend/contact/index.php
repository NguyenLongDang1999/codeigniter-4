<!-- Kế thừa layout backend -->
<?= $this->extend('layout/backend/layout'); ?>

<!-- Tiêu đề trang -->
<?= $this->section('title') ?>
Xem danh sách liên hệ
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
                    <li class="breadcrumb-item"><a class="text-capitalize" href="javascript: void(0);">Liên hệ</a></li>
                    <li class="breadcrumb-item active text-capitalize">Xem danh sách</li>
                </ol>
            </div>
            <h4 class="page-title text-capitalize">Xem danh sách liên hệ</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">

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
                            <th>Họ và Tên</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($list as $item) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $item['fullname'] ?></td>
                                <td><?= $item['created_at'] ?></td>
                                <td>
                                    <a href="<?= base_url(route_to('contactDetail', $item['id'])) ?>" class="btn btn-xs btn-secondary"><i class="mdi mdi-eye"></i></a>
                                    <a href="<?= base_url(route_to('contactDelete', $item['id'])) ?>" onclick="return confirm('Bạn có chắn chắn muốn xóa thương hiệu này không ?')" class="btn btn-xs btn-danger"><i class="mdi mdi-trash-can-outline"></i></a>
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