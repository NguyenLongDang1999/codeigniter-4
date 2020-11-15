<!DOCTYPE html>
<html lang="en">

<head>
  <title>TopDeal - <?= $this->renderSection('title') ?></title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="url" content="<?= base_url() ?>">
  <?= $this->renderSection('metaSeo'); ?>

  <?= view('layout/frontend/head') ?>
  <?= $this->renderSection('isLink') ?>
</head>

<body>

  <!-- Pre-loader -->
  <!-- <div id="preloader">
        <div id="status">
            <div class="bouncingLoader">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div> -->
    <!-- End Preloader-->

  <!-- header -->
  <div class="header">
    <?= view('layout/frontend/header') ?>
  </div>
  <!-- end header -->

  <!-- content -->
  <div class="content mt-3">
    <?= $this->renderSection('breadcrumbs') ?>

    <div class="container-fluid container-md">
      <?= $this->renderSection('content') ?>
    </div>
  </div>
  <!-- end content -->

  <div class="login">
    <?= view('layout/frontend/login') ?>
  </div>

  <div class="language">
    <?= view('layout/frontend/language') ?>
  </div>

  <footer class="footer mt-4">
    <?= view('layout/frontend/footer') ?>
  </footer>

  <div class="back-to-top" style="display: none;">
    <i class="fa fa-arrow-up" aria-hidden="true"></i>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="dataModal">
    <?= view('layout/frontend/modal') ?>
  </div>
  <!-- end Modal -->

  <?= view('layout/frontend/script') ?>

  <?= $this->renderSection('isScript') ?>
  <?= $this->renderSection('isAjax') ?>

  <script>
    // auto comple te tìm iém sản pham
    $(".text-search").autocomplete({
      source: "<?= base_url(route_to('searchAutocomplete'))?>",
    });

    function showData() {
      $.post("<?= base_url(route_to('showCart')) ?>", function(data) {
        $(".showCart").html(data);
      });
    }

    function showCartQuantity() {
      $.post("<?= base_url(route_to('showCartQuantity')) ?>", function(data) {
        $(".showCartQuantity").html(data);
      });
    }


    function showLogin() {
      $.post("<?= base_url(route_to('showLogin')) ?>", function(data) {
        $(".showLogin").html(data);
      });
    }

    showLogin();
    showCartQuantity();
    showData();
  </script>

</body>

</html>