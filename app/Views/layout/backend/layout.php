<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Minton - <?= $this->renderSection('title'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?= $this->renderSection('isLink'); ?>

    <?= view('layout/backend/head') ?>

</head>

<body>

    <!-- Pre-loader -->
    <div id="preloader">
        <div id="status">
            <div class="bouncingLoader">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <!-- End Preloader-->

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <div class="navbar-custom">
            <?= view('layout/backend/navbar') ?>
        </div>
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        <div class="left-side-menu">

            <?= view('layout/backend/leftside') ?>

        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <?= $this->renderSection('content'); ?>

                </div> <!-- container -->

            </div> <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <?= view('layout/backend/footer') ?>
            </footer>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    <?= view('layout/backend/script') ?>

    <?= $this->renderSection('isScript'); ?>

    <?= $this->renderSection('isAjax'); ?>

</body>

</html>