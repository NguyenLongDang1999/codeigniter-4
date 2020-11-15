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
    <div class="col-md-4">
        <!-- .billig-detail -->
        <div class="bill-detail mb-4">
            <h4 class="text-uppercase">Thông tin khách hàng</h4>
            <div class="info mt-4" style="font-size: 15px;">
                <p class="mb-2"><strong>Họ và tên:</strong> <span class="text-capitalize"><?= $row['fullname'] ?></span></p>
                <p class="mb-2"><strong>Email:</strong> <?= $row['email'] ?></p>
                <p class="mb-2"><strong>Số điện thoại:</strong> <?= $row['phone'] ?></p>
                <p class="mb-2"><strong>Địa chỉ:</strong> <?= !empty($row['address']) ? $row['address'] : '...' ?>
                </p>

                <a href="<?= base_url(route_to('infoEdit', $row['id'])) ?>" class="btn btn-primary border-radius-0 btn-sm text-uppercase mt-4">CậP nhật thông tin</a>

                <a href="<?= base_url(route_to('infoResetPassword', $row['id'])) ?>" class="btn btn-dark border-radius-0 btn-sm text-uppercase mt-4">Đổi mật khẩu</a>
            </div>
        </div>
        <!-- end bill etail -->
    </div>

    <div class="col-md-8">
    <?php if (count($listOrderNotSuccess)) { ?>
        <!-- .billig-detail -->
        <div class="bill-detail">
            <h4 class="text-uppercase">Danh sách đơn hàng chưa duyệt</h4>

            <div class="table-responsive mt-2">
                <table class="table table-bordered mt-3 text-center">
                    <thead>
                        <tr>
                            <th scope="col">Mã đơn hàng</th>
                            <th scope="col">Ngày đặt</th>
                            <th scope="col">Số tiền</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col" colspan="2">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listOrderNotSuccess as $item) { ?>
                            <tr>
                                <td>#<?= $item['ordercode'] ?></td>
                                <td><?= $item['orderdate'] ?></td>
                                <td><?= number_format($item['money'], 0, ",", ".") ?> VNĐ</td>
                                <td>
                                    <?= ($item['status'] == 0) ? 'Chưa duyệt' : 'Đã duyệt' ?>
                                </td>
                                <td>
                                    <a href="<?= base_url(route_to('infoDetail', $item['id'])) ?>" class="btn btn-success btn-sm border-radius-0">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                </td>
                                <td>
                                    <a onclick="return confirm('Are You Sure ?')" href="<?= base_url(route_to('infoDelete', $item['id'])) ?>" class="btn btn-danger btn-sm border-radius-0">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- end bill etail -->
    <?php } ?>

    <?php if (count($listOrderSuccess)) { ?>
        <!-- .billig-detail -->
        <div class="bill-detail">
            <h4 class="text-uppercase">Danh sách đơn hàng đã duyệt</h4>

            <div class="table-responsive mt-2">
                <table class="table table-bordered mt-3 text-center">
                    <thead>
                        <tr>
                            <th scope="col">Mã đơn hàng</th>
                            <th scope="col">Ngày đặt</th>
                            <th scope="col">Số tiền</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listOrderSuccess as $item) { ?>
                            <tr>
                                <td>#<?= $item['ordercode'] ?></td>
                                <td><?= $item['orderdate'] ?></td>
                                <td><?= number_format($item['money'], 0, ",", ".") ?> VNĐ</td>
                                <td>
                                    <?php if ($item['status'] == 0) {
                                        echo 'Chưa duyệt.';
                                    } else if ($item['status'] == 1) {
                                        echo 'Đã duyệt và đang giao hàng.';
                                    } else if ($item['status'] == 2) {
                                        echo 'Đã giao hàng và thanh toán thành công.';
                                    } else if ($item['status'] == 3) {
                                        echo 'Khách hàng đã huỳ.';
                                    } else if ($item['status'] == 4) {
                                        echo 'ADMIN đẫ huỷ.';
                                    } ?>
                                </td>
                                <td>
                                    <a href="<?= base_url(route_to('infoDetail', $item['id'])) ?>" class="btn btn-success btn-sm border-radius-0">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- end bill etail -->
    <?php } ?>
</div>
</div>
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