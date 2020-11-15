<!-- Kế thừa layout backend -->
<?= $this->extend('layout/backend/layout'); ?>

<!-- Tiêu đề trang -->
<?= $this->section('title') ?>
Xem danh sách đơn hàng đã lưu
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
                    <li class="breadcrumb-item"><a class="text-capitalize" href="javascript: void(0);">đơn hàng</a></li>
                    <li class="breadcrumb-item active text-capitalize">Xem danh sách</li>
                </ol>
            </div>
            <h4 class="page-title text-capitalize">Xem danh sách đơn hàng đã lưu</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">

    <a href="<?= base_url(route_to('orderIndex')) ?>" class="btn btn-danger waves-effect waves-light mb-3 text-capitalize">Quay Lại <i class="mdi mdi-backspace-outline"></i></a>

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
                            <th>Thông tin người đặt</th>
                            <th>Thông tin đơn hàng</th>
                            <th>trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($list as $item) { ?>
                            <?php $status = ($item['status'] == 1) ? '<span class="badge badge-light-success">Hiển thị</span>' : '<span class="badge badge-light-danger">Không hiển thị</span>' ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <ul class="m-0 list-unstyled">
                                        <li class="text-truncate" style="width: 200px">Họ Tên: <?= $muser->orderGetUserid($item['userid'])['fullname'] ?></li>
                                        <li class="text-truncate" style="width: 200px">Email: <?= $muser->orderGetUserid($item['userid'])['email'] ?></li>
                                        <li class="text-truncate" style="width: 200px">Phone: <?= $muser->orderGetUserid($item['userid'])['phone'] ?></li>
                                    </ul>
                                </td>
                                <td>
                                    <ul class="m-0 list-unstyled">
                                        <li class="text-truncate" style="width: 200px">Mã đơn hàng: #<?= $item['ordercode'] ?></li>
                                        <li class="text-truncate" style="width: 200px">Coupon: <?= number_format($item['coupon'], 0, ",", ".") ?> VNĐ</li>
                                        <li class="text-truncate" style="width: 200px">Phí vận chuyển: <?= number_format($item['price_ship'], 0, ",", ".") ?> VNĐ</li>
                                        <li class="text-truncate" style="width: 200px">Ngày đặt: <?= $item['orderdate'] ?></li>
                                    </ul>
                                </td>
                                <td>
                                    <?php if ($item['status'] == 0) {
                                        echo 'Chưa duyệt.';
                                    } else if ($item['status'] == 1) {
                                        echo 'Đang giao hàng.';
                                    } else if ($item['status'] == 2) {
                                        echo 'Đã hoàn thành.';
                                    } else if ($item['status'] == 3) {
                                        echo 'Khách hàng đã huỳ.';
                                    } else if ($item['status'] == 4) {
                                        echo 'ADMIN đẫ huỷ.';
                                    } ?>
                                </td>
                                <td>
                                    <a href="<?= base_url(route_to('orderDetail', $item['id'])) ?>" class="btn btn-xs btn-secondary"><i class="mdi mdi-eye"></i></a>
                                    <a href="<?= base_url(route_to('orderRestore', $item['id'])) ?>" onclick="return confirm('Bạn có chắn chắn muốn bỏ lưu đơn hàng này ?')" class="btn btn-xs btn-danger"><i class="mdi mdi-content-save"></i></a>
                                    <a href="<?= base_url(route_to('orderDelete', $item['id'])) ?>" onclick="return confirm('Bạn có chắn chắn muốn xóa đơn hàng này ?')" class="btn btn-xs btn-danger"><i class="mdi mdi-trash-can-outline"></i></a>
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