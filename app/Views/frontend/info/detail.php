<!-- Kế thừa layout frontend -->
<?= $this->extend('layout/frontend/layout'); ?>

<!-- Tiêu đề trang -->
<?= $this->section('title') ?>
Thông tin thanh toán đơn hàng
<?= $this->endSection() ?>

<!-- Link CSS trang -->
<?= $this->section('isLink') ?>
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="<?= base_url() ?>/css/magnific-popup.css" />
<?= $this->endSection() ?>

<!-- Thanh breadcrumb -->
<?= $this->section('breadcrumbs') ?>
<div class="container-fluid mb-3 p-0">
    <div class="breadcrumbs">
        <div class="breadcrumbs__title">Thông tin cá nhân & lịch sử đặt hàng</div>
    </div>
</div>
<?= $this->endSection() ?>

<!-- Nội dung trang -->
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">

    <div class="mt-4">
            <a href="<?= base_url(route_to('infoIndex')) ?>" class="btn btn-danger border-radius-0 btn-sm">
                Quay lại
            </a>
        </div>

        <div class="float-sm-left mt-4">
            <address>
                <strong class="text-capitalize">Thông tin khách hàng</strong><br>
                Họ và tên: <span class="text-capitalize"><?= $user['fullname'] ?></span><br>
                Email: <?= $user['email'] ?><br>
                Địa chỉ giao hàng: <?= $row['address'] ?><br>
                <abbr title="Phone">Phone Number:</abbr> <?= $user['phone'] ?> <br>
                Tỉnh/Thành phố: <span class="text-capitalize"><?= $province['name'] ?> </span> <br>
                Quận/Huyện: <span class="text-capitalize"><?= $district['name'] ?></span>
            </address>
        </div>
        <div class="mt-4 text-sm-right">
            <p><strong class="text-capitalize">Ngày đặt hàng: </strong> <?= $row['orderdate'] ?></p>
            <p><strong class="text-capitalize">Trạng thái đơn hàng: </strong> <span class="badge badge-danger">
                    <?php if ($row['status'] == 0) {
                        echo 'Chưa duyệt.';
                    } else if ($row['status'] == 1) {
                        echo 'Đã duyệt và đang giao hàng.';
                    } else if ($row['status'] == 2) {
                        echo 'Đã giao hàng và thanh toán thành công.';
                    } else if ($row['status'] == 3) {
                        echo 'Khách hàng đã huỳ.';
                    } else if ($row['status'] == 4) {
                        echo 'ADMIN đẫ huỷ.';
                    } ?></span></p>
            <p><strong class="text-capitalize">Mã đơn hàng: </strong> #<?= $row['ordercode'] ?></p>
        </div>
    </div><!-- end col -->
</div>
<!-- end row -->

<div class="row mt-4">
    <div class="col-12">

        <div class="table-responsive">
            <table class="table table-nowrap">
                <thead>
                    <tr class="text-capitalize">
                        <th>#</th>
                        <th>Tên sản phẩm</th>
                        <th>SL</th>
                        <th>Giá</th>
                        <th>Tổng cộng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    $total = 0;
                    foreach ($listOrder as $item) { ?>
                        <?php $product = $mproduct->productGetid($item['productid']) ?>
                        <?php $total += $item['price'] * $item['qty'] ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $product['name'] ?></td>
                            <td><?= $item['qty'] ?></td>
                            <td><?= number_format($item['price']) ?> VNĐ</td>
                            <td><?= number_format($item['price'] * $item['qty']) ?> VNĐ</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">

    </div>
    <div class="col-sm-6">
        <div class="text-right mt-4">
            <p><b>Tổng Cộng:</b> <?= number_format($total, 0, ",", ".") ?> VNĐ</p>
            <p><b>Mã giảm giá:</b> <?= number_format($row['coupon'], 0, ",", ".") ?> VNĐ</p>
            <p><b>Phí Vận Chuyển:</b> 50.000 VNĐ</p>
            <p><b>Thuế: </b> 10%</p>
            <hr>
            <h3><?= number_format(($total + ($total * (10 / 100)) + 50000) - $row['coupon'], 0, ",", ".") ?> VNĐ</h3>
        </div>
    </div>
</div>
<hr>
<div class="d-print-none">
    <div class="float-right">
        <a href="javascript:window.print()" class="btn btn-dark waves-effect waves-light"><i class="fa fa-print"></i></a>
    </div>
    <div class="clearfix"></div>
</div>
</div>
</div>

</div>

</div>
<!-- end row -->

<?= $this->endSection() ?>

<?= $this->section('isScript') ?>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<!-- Jquery Cookie JS -->
<script src="<?= base_url() ?>/js/jquery-cookie.js"></script>
<!-- Magnific JS -->
<script src="<?= base_url() ?>/js/jquery.magnific-popup.min.js"></script>
<?= $this->endSection() ?>

<?= $this->section('isAjax') ?>
<script>
    $(function() {
        // DelCart
        $(".showCart").on("click", ".delCart", function() {
            toastr.options = {
                "closeButton": true,
                "debug": true,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-bottom-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "timeOut": "3000",
                "hideDuration": "1000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            toastr["error"]('Trạng thái hiện tại không cho phép thao tác xóa sản phẩm.')
        })
        // end del cart
    })
</script>
<?= $this->endSection() ?>