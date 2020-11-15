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
        <div class="breadcrumbs__title">Thông tin thanh toán đơn hàng</div>

        <div class="breadcrumbs__url mt-4">
            <ul class="m-0 list-unstyled d-flex flex-wrap justify-content-center">
                <li class="breadcrumbs__url-item">
                    <a class="breadcrumbs__url-link" href="<?= base_url() ?>">Trang chủ</a>
                </li>
                <li class="breadcrumbs__url-item">
                    <a class="breadcrumbs__url-link breadcrumbs__url-active" href="javascript:void(0)">Thông tin thanh toán đơn hàng</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<!-- Nội dung trang -->
<?= $this->section('content') ?>
<div class="checkout">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-7">
                            <?= form_open(base_url(route_to('postCheckout')), ['id' => 'msform']) ?>
                            <h2 class="fs-title">Thông tin cá nhân</h2>
                            <p class="text-muted">Vui lòng điền đầy đủ thông tin vào Form để gửi hóa đơn của đơn đật hàng.</p>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="billing-first-name" class="text-capitalize">Họ và tên</label>
                                        <input class="form-control" type="text" name="fullname" value="<?= $row['fullname'] ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="billing-first-name">Email</label>
                                        <input class="form-control" type="text" name="email"" value=" <?= $row['email'] ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="billing-last-name">Số điện thoại</label>
                                        <input class="form-control" type="text" name="phone" value="<?= $row['phone'] ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="billing-first-name">Tỉnh/Thành phố</label>
                                        <select class="custom-select" name="provinceid" id="provinceid">
                                            <option value="" selected="">[--- Chọn Tỉnh/Thành phố ---]</option>
                                            <?php foreach ($provinceAll as $item) { ?>
                                                <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                        <p class="m-0 text-danger"><?= $validation->getError('provinceid');  ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="billing-last-name">Quận/Huyện</label>
                                        <select class="custom-select" name="district" id="district">
                                            <option value="" selected="">[--- Chọn Quận/Huyện ---]</option>
                                        </select>
                                        <p class="m-0 text-danger"><?= $validation->getError('district');  ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="billing-first-name">Địa chỉ nhận hàng</label>
                                        <textarea class="form-control" name="address" id="" cols="30" rows="5"></textarea>
                                        <p class="m-0 text-danger"><?= $validation->getError('address');  ?></p>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-danger text-capitalize">Tiếp tục</button>
                            <?= form_close() ?>
                        </div>
                        <div class="col-lg-5 mt-4 mt-lg-0">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title mb-3">tóm tắt đơn hàng</h4>

                                    <div class="table-responsive">
                                        <table class="table table-centered table-nowrap mb-0">
                                            <tbody class="showOrder">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

        function showOrder() {
            $.post("<?= base_url(route_to('showOrder')) ?>", function(data) {
                $(".showOrder").html(data);
            });
        }

        showOrder();

        // show District
        $(document).on("change", "#provinceid", function() {
            var provinceid = $(this).val();

            $.ajax({
                url: "<?= base_url(route_to('showDistrict')) ?>",
                type: "post",
                data: {
                    provinceid: provinceid
                },
                success: function(data) {
                    $('#district').html(data);
                }
            })
        });

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