<!-- Kế thừa layout backend -->
<?= $this->extend('layout/backend/layout'); ?>

<!-- Tiêu đề trang -->
<?= $this->section('title') ?>
Trang thống kê
<?= $this->endSection() ?>

<!-- Link CSS trang -->
<?= $this->section('isLink') ?>
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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Thống kê</a></li>
                    <li class="breadcrumb-item active">Thống kê</li>
                </ol>
            </div>
            <h4 class="page-title">Thống kê</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-md-6 col-xl-3">
        <div class="card-box">
            <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
            <h4 class="mt-0 font-16 text-capitalize">Khách hàng</h4>
            <h2 class="text-primary my-3 text-center"><span data-plugin="counterup"><?= count($userCount) ?></span></h2>
            <p class="text-muted mb-0">Total income: $22506 <span class="float-right"><i class="fa fa-caret-up text-success mr-1"></i>10.25%</span></p>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card-box">
            <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
            <h4 class="mt-0 font-16 text-capitalize">Liên hệ</h4>
            <h2 class="text-primary my-3 text-center"><span data-plugin="counterup"><?= count($contactCount) ?></span></h2>
            <p class="text-muted mb-0">Total sales: 2398 <span class="float-right"><i class="fa fa-caret-down text-danger mr-1"></i>7.85%</span></p>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card-box">
            <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
            <h4 class="mt-0 font-16 text-capitalize">Sản phẩm</h4>
            <h2 class="text-primary my-3 text-center"><span data-plugin="counterup"><?= count($productCount) ?></span></h2>
            <p class="text-muted mb-0">Total users: 121 M <span class="float-right"><i class="fa fa-caret-up text-success mr-1"></i>3.64%</span></p>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card-box">
            <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
            <h4 class="mt-0 font-16 text-capitalize">Đơn hàng</h4>
            <h2 class="text-primary my-3 text-center"><span data-plugin="counterup"><?= count($orderCount) ?></span></h2>
            <p class="text-muted mb-0">Total revenue: $1.2 M <span class="float-right"><i class="fa fa-caret-up text-success mr-1"></i>17.48%</span></p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-xl-3">
        <div class="card-box">
            <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
            <h4 class="mt-0 font-16 text-capitalize">Doanh thu ngày</h4>
            <h2 class="text-primary my-3 text-center"><span data-plugin="counterup"><?= number_format($total_day) ?></span> VNĐ</h2>
            <p class="text-muted mb-0">Total income: $22506 <span class="float-right"><i class="fa fa-caret-up text-success mr-1"></i>10.25%</span></p>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card-box">
            <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
            <h4 class="mt-0 font-16 text-capitalize">Doanh thu tuần</h4>
            <h2 class="text-primary my-3 text-center"><span data-plugin="counterup"><?= number_format($total_week) ?></span> VNĐ</h2>
            <p class="text-muted mb-0">Total sales: 2398 <span class="float-right"><i class="fa fa-caret-down text-danger mr-1"></i>7.85%</span></p>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card-box">
            <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
            <h4 class="mt-0 font-16 text-capitalize">Doanh thu tháng</h4>
            <h2 class="text-primary my-3 text-center"><span data-plugin="counterup"><?= number_format($total_month) ?></span> VNĐ</h2>
            <p class="text-muted mb-0">Total users: 121 M <span class="float-right"><i class="fa fa-caret-up text-success mr-1"></i>3.64%</span></p>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card-box">
            <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="More Info"></i>
            <h4 class="mt-0 font-16 text-capitalize">Doanh thu năm</h4>
            <h2 class="text-primary my-3 text-center"><span data-plugin="counterup"><?= number_format($total_year) ?></span> VNĐ</h2>
            <p class="text-muted mb-0">Total revenue: $1.2 M <span class="float-right"><i class="fa fa-caret-up text-success mr-1"></i>17.48%</span></p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-xl-8">
        <div class="card-box">
            <figure class="highcharts-figure">
                <div id="container1"></div>
            </figure>

        </div>
    </div><!-- end col-->

    <div class="col-lg-6 col-xl-4">
        <div class="card-box">
            <figure class="highcharts-figure">
                <div id="container"></div>
            </figure>

        </div>
    </div><!-- end col-->
</div>
<!-- end row -->


<?= $this->endSection() ?>

<!-- Link JS trang -->
<?= $this->section('isScript') ?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    // Build the chart
    Highcharts.chart('container', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Thống kê trạng thái đơn hàng'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        series: [{
            name: 'Tỷ lệ',
            colorByPoint: true,
            data: [{
                name: 'Chưa duyệt',
                y: <?= count($status_0) ?>,
                sliced: true,
                selected: true
            }, {
                name: 'Đã duyệt và đang giao hàng',
                y: <?= count($status_1) ?>,
            }, {
                name: 'Đã giao hàng và thanh toán thành công',
                y: <?= count($status_2) ?>,
            }, {
                name: 'Khách hàng đã huỷ',
                y: <?= count($status_3) ?>,
            }, {
                name: 'ADMIN đã huỷ',
                y: <?= count($status_4) ?>,
            }]
        }]
    });
</script>

<script>
    Highcharts.chart('container1', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Thống kê số lượng sản phẩm bán ra năm <?= $year?> '
        },
        xAxis: {
            type: 'category',
            labels: {
                rotation: -45,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Số lượng sản phẩm bán ra'
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: 'Số lượng sản phẩm bán ra: <b>{point.y} sản phẩm</b>'
        },
        series: [{
            name: 'Population',
            data: [
                <?php 
                    for ($i = 1; $i <= 12; $i++) {
                        // truy ấn lấy năm tháng
                        $list = $morder->where(['status' => 2, 'YEAR(orderdate)' => $year, 'MONTH(orderdate)' => $i])->findAll(); 
                        $sum = 0; // tính tổng sl 
                        foreach ($list as $item) {
                            $order_detail = $morderdetail->where(['status' => 1, 'trash' => 1, 'orderid' => $item['id']])->findAll();
                            foreach ($order_detail as $row) {
                                $sum += $row['qty']; // tổng sl bán ra tháng năm hiện tại
                            }
                        }

                        if ($i >= 1 && $i <= 9) {
                            echo "['0" . $i . '/' . $year . "'," . $sum . "],";
                        } else {
                            echo "['" . $i . '/' . $year . "'," . $sum . "],";
                        }
                    }
                    ?>,
            ],
            dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#FFFFFF',
                align: 'right',
                format: '{point.y}', // one decimal
                y: 10, // 10 pixels down from the top
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        }]
    });
</script>
<?= $this->endSection() ?>