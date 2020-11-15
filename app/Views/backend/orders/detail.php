<!-- Kế thừa layout backend -->
<?= $this->extend('layout/backend/layout'); ?>

<!-- Tiêu đề trang -->
<?= $this->section('title') ?>
Xem chi tiết đơn hàng - <?= $row['ordercode'] ?>
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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Đơn hàng</a></li>
                    <li class="breadcrumb-item active"><?= $row['id'] ?></li>
                </ol>
            </div>
            <h4 class="page-title text-capitalize">Hóa đơn</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<a href="<?= base_url(route_to('orderIndex')) ?>" class="btn btn-danger waves-effect waves-light mb-3 text-capitalize">Quay Lại <i class="mdi mdi-backspace-outline"></i></a>

<div class="row">
    <div class="col-12">
        <div class="card-box">
            <!-- Logo & title -->
            <div class="clearfix">
                <div class="float-left">
                    <img src="<?= base_url()?>\assets\images\logo-dark.png" alt="" height="20">
                </div>
                <div class="float-right">
                    <h4 class="m-0 d-print-none">Invoice</h4>
                </div>
            </div>
            

            <div class="row">
                <div class="col-md-6">
                    <div class="mt-3">
                        <p class="m-b-10"><strong class="text-capitalize">Họ tên khách hàng : </strong> <span class="text-capitalize"><?= $muser->orderGetUserid($row['userid'])['fullname'] ?></span></p>
                        <p class="m-b-10"><strong class="text-capitalize">Email : </strong> <span><?= $muser->orderGetUserid($row['userid'])['email'] ?></span></p>
                        <p class="m-b-10"><strong class="text-capitalize">Số điện thoại : </strong> <span> <?= $muser->orderGetUserid($row['userid'])['phone'] ?> </span></p>
                        <p class="m-b-10"><strong class="text-capitalize">Địa chỉ nhận hàng : </strong> <span> <?= $row['address'] ?> </span></p>
                        <p class="m-b-10"><strong class="text-capitalize">Tỉnh/Thành phố : </strong> <span> <?= $province['name'] ?> </span></p>
                        <p class="m-b-10"><strong class="text-capitalize">Quận/Huyện : </strong> <span> <?= $district['name'] ?> </span></p>
                    </div>

                </div><!-- end col -->
                <div class="col-md-4 offset-md-2">
                    <div class="mt-3 float-right">
                        <p class="m-b-10"><strong class="text-capitalize">Ngày đặt hàng : </strong> <span class="float-right"> &nbsp;&nbsp;&nbsp;&nbsp; <?= $row['orderdate'] ?></span></p>
                        <p class="m-b-10"><strong class="text-capitalize">Trạng thái đơn hàng : </strong> <span class="float-right"><span class="badge badge-success"><?php if ($row['status'] == 0) {
                                        echo 'Chưa duyệt.';
                                    } else if ($row['status'] == 1) {
                                        echo 'Đang giao hàng.';
                                    } else if ($row['status'] == 2) {
                                        echo 'Đã hoàn thành.';
                                    } else if ($row['status'] == 3) {
                                        echo 'Khách hàng đã huỳ.';
                                    } else if ($row['status'] == 4) {
                                        echo 'ADMIN đẫ huỷ.';
                                    } ?></span></span></p>
                        <p class="m-b-10"><strong class="text-capitalize">Mã đơn hàng : </strong> <span class="float-right"> #<?= $row['ordercode'] ?> </span></p>
                    </div>
                </div><!-- end col -->
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table mt-4 table-centered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th></th>
                                    <th>Tên sản phẩm</th>
                                    <th style="width: 15%">Số lượng</th>
                                    <th style="width: 15%">Tổng cộng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; $total = 0; foreach($listProduct as $item) { ?>
                                    <?php $product = $mproduct->productGetid($item['productid']) ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <th>
                                    <?php if ($product['thumb'] == 'default-image.jpg') { ?>
                                        <img src="<?= base_url('uploads/' . $product['thumb']) ?>" width="50px" class="img-fluid" alt="<?= $product['name'] ?>">
                                    <?php } else { ?>
                                        <img src="<?= base_url('uploads/product/' . $product['thumb']) ?>" width="50px" class="img-fluid" alt="<?= $product['name'] ?>">
                                    <?php } ?>
                                    </th>
                                    <td>
                                        <b><?= $product['name'] ?></b> <br>
                                    </td>
                                    <td><?= $item['qty'] ?> x <?= number_format($item['price'], 0, ",", ".") ?></td>
                                    <td><?php $price = $item['qty'] * $item['price']; echo number_format($price, 0, ",", ".") ?> VNĐ</td>
                                </tr>
                                <?php $total += $price; ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div> <!-- end table-responsive -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-sm-6">
                    
                </div> <!-- end col -->
                <div class="col-sm-6">
                    <div class="float-right">
                        <p><b>Tông cộng:</b> <span class="float-right"><?= number_format($total, 0 ,",", ".") ?> VNĐ</span></p>
                        <p><b>Thuế:</b> <span class="float-right"> &nbsp;&nbsp;&nbsp; 10%</span></p>
                        <p><b>Phí vận chuyển:</b> <span class="float-right"> &nbsp;&nbsp;&nbsp; 50.000 VNĐ</span></p>
                        <p><b>Mã giảm giá:</b> <span class="float-right"> &nbsp;&nbsp;&nbsp; <?= number_format($row['coupon'], 0 ,",", ".") ?> VNĐ</span></p>
                        <h3><?php $subTotal = ($total + ($total * (10 / 100)) + 50000) - $row['coupon']; echo number_format($subTotal, 0 ,",", ".") ?> VNĐ</h3>
                    </div>
                    <div class="clearfix"></div>
                </div> <!-- end col -->
            </div>
            <!-- end row -->

            <div class="mt-4 mb-1">
                <div class="text-right d-print-none">
                    <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-printer mr-1"></i> Print</a>
                </div>
            </div>
        </div> <!-- end card-box -->
    </div> <!-- end col -->
</div>
<!-- end row -->
<?= $this->endSection() ?>