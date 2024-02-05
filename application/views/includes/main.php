<?php
$paths = explode('/', trim($_SERVER['PATH_INFO'], '/'));
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php echo $pageTitle; ?></title>

  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.png" />

  <!-- core:css -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendors/core/core.css">
  <!-- endinject -->

  <!-- plugin css for this page -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendors/jquery-steps/jquery.steps.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendors/select2/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendors/sweetalert2/sweetalert2.min.css">
  <!-- end plugin css for this page -->

  <!-- inject:css -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/feather-font/css/iconfont.css">
  <!-- endinject -->

  <!-- Layout styles -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/demo_1/style.css">
  <!-- End layout styles -->

  <link rel="stylesheet" href="<?= base_url() ?>assets/css/custom.css">

  <script src="<?php echo base_url(); ?>assets/vendors/core/core.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/template.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/formatter.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/jquery.table2excel.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/repeater.js"></script>

  <?php if (in_array('uploader', $paths) || in_array('survei', $paths) || in_array('commando', $paths) || in_array('best_witel', $paths) || in_array('management_review', $paths) || in_array('document_tracking', $paths) || in_array('khs', $paths)) : ?>
    <link href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendors/dropify/dist/dropify.min.css" />
  <?php endif; ?>

  <?php if (in_array('rewards', $paths)) : ?>
    <link rel="stylesheet" href="https://unpkg.com/ag-grid-community/dist/styles/ag-grid.css">
    <link rel="stylesheet" href="https://unpkg.com/ag-grid-community/dist/styles/ag-theme-balham.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ag-theme-custom.css">
  <?php endif; ?>

  <?php if (in_array('frontend', $paths)) : ?>
    <link rel="stylesheet" href="<?= base_url() ?>assets/frontend/css/index.css">
    <script type="module" crossorigin src="<?= base_url(); ?>assets/frontend/js/index08987431.js"></script>

    <script type="module">
      try {
        import.meta.url;
        import("_").catch(() => 1);
      } catch (e) {}
      window.__vite_is_modern_browser = true;
    </script>
    <script type="module">
      ! function() {
        if (window.__vite_is_modern_browser) return;
        console.warn("vite: loading legacy build because dynamic import or import.meta.url is unsupported, syntax error above should be ignored");
        var e = document.getElementById("vite-legacy-polyfill"),
          n = document.createElement("script");
        n.src = e.src, n.onload = function() {
          System.import(document.getElementById('vite-legacy-entry').getAttribute('data-src'))
        }, document.body.appendChild(n)
      }();
    </script>
  <?php endif; ?>
</head>

<body>
  <div id="app" class="main-wrapper">
    <!-- partial:sidebar -->
    <?php $this->load->view('includes/partials/sidebar.php'); ?>
    <!-- partial -->

    <div class="page-wrapper">
      <!-- partial:navbar -->
      <?php $this->load->view('includes/partials/navbar.php'); ?>
      <!-- partial -->

      <div class="page-content">
        <?php $this->load->view($pageView); ?>
      </div>
      <!-- page content -->

      <!-- partial:footer -->
      <?php $this->load->view('includes/partials/footer.php'); ?>
      <!-- partial -->
    </div>
    <!-- page wrapper -->
  </div>
  <!-- main wrapper -->

  <!-- core:js -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <!-- endinject -->

  <!-- inject:js -->
  <script src="<?php echo base_url(); ?>assets/vendors/feather-icons/feather.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <!-- endinject -->

  <!-- plugin js for this page -->
  <script src="<?php echo base_url(); ?>assets/vendors/sweetalert2/sweetalert2.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendors/select2/select2.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendors/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
  <!-- end plugin js for this page -->

  <!-- custom js for this page -->
  <script src="<?php echo base_url(); ?>assets/js/dashboard.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendors/jquery-steps/jquery.steps.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/wizard.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/select2.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/sweet-alert.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/bootstrap-maxlength.js"></script>
  <!-- end custom js for this page -->

  <?php if (in_array('uploader', $paths) || in_array('survei', $paths) || in_array('commando', $paths) || in_array('best_witel', $paths) || in_array('management_review', $paths) || in_array('document_tracking', $paths) || in_array('khs', $paths)) : ?>
    <script src="<?php echo base_url(); ?>assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/data-table.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendors/dropify/dist/dropify.min.js"></script>
  <?php endif; ?>

  <?php if (in_array('rewards', $paths)) : ?>
    <script src="https://unpkg.com/@ag-grid-community/all-modules@26.2.0/dist/ag-grid-community.min.js"></script>
  <?php endif; ?>

  <?php if (in_array('frontend', $paths)) : ?>
    <script nomodule>
      ! function() {
        var e = document,
          t = e.createElement("script");
        if (!("noModule" in t) && "onbeforeload" in t) {
          var n = !1;
          e.addEventListener("beforeload", (function(e) {
            if (e.target === t) n = !0;
            else if (!e.target.hasAttribute("nomodule") || !n) return;
            e.preventDefault()
          }), !0), t.type = "module", t.src = ".", e.head.appendChild(t), t.remove()
        }
      }();
    </script>
    <script nomodule crossorigin id="vite-legacy-polyfill" src="<?= base_url() ?>assets/frontend/js/polyfills-legacy.js"></script>
    <script nomodule crossorigin id="vite-legacy-entry" data-src="<?= base_url() ?>assets/frontend/js/index-legacy.js">
      System.import(document.getElementById('vite-legacy-entry').getAttribute('data-src'))
    </script>
  <?php endif; ?>

  <script>
    function doLogout() {
      document.getElementById("loggedOut").submit();
    }
  </script>
</body>

</html>