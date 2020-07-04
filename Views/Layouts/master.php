<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Xpeedstudio | Interview</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../Views/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../Views/assets/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- testing tag input -->
  <link href="../Views/assets/test/tagsinput.css" rel="stylesheet" type="text/css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="../Views/assets/plugins/daterangepicker/daterangepicker.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>

    </ul>

    <!-- SEARCH FORM -->


    <!-- Right navbar links -->

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="http://localhost/xpeedstudio/purchases/create" class="brand-link">
      <img src="../Views/assets/dist/img/AdminLTELogo.png"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Xpeedstudio</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->









          <li class="nav-item">
            <a href="http://localhost/xpeedstudio/purchases/create" class="nav-link <?php echo $page == 'purchase_create' ? 'active' : '' ?> ">
              <i class="nav-icon fa fa-plus-square"></i>
              <p>
                form
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="http://localhost/xpeedstudio/purchases/index" class="nav-link <?php echo $page != 'purchase_create' ? 'active' : '' ?>">
              <i class="nav-icon fa fa-book"></i>
              <p>
                Report
              </p>
            </a>
          </li>













        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

    </section>

    <!-- Main content -->
    <?php
    echo $content_for_layout;
    ?>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">

  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../Views/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../Views/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="../Views/assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="../Views/assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../Views/assets/dist/js/demo.js"></script>
<!-- testing tag input -->
<script src="../Views/assets/test/tagsinput.js"></script>
<!-- InputMask -->
<script src="../Views/assets/plugins/moment/moment.min.js"></script>
<!-- date-range-picker -->
<script src="../Views/assets/plugins/daterangepicker/daterangepicker.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>

<script type="text/javascript">
//Date range picker
$(function() {

  $('#reservation').daterangepicker({
      autoUpdateInput: false,
      locale: {
          cancelLabel: 'Clear'
      }
  });

  $('#reservation').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
  });

  // $('#reservation').on('cancel.daterangepicker', function(ev, picker) {
  //     $(this).val('');
  // });

});
</script>

<!-- Page specific javascript -->
<?php $page = $page ?? Null; ?>
<?php if ($page == 'purchase_create') : ?>

  <script type="text/javascript">
  $(function () {

      $('form').on('submit', function (e) {

        //Remove last validation errors
        $('.form-control').removeClass('is-invalid'); // remove the error class
        $('.text-danger').remove(); // remove the error text


        e.preventDefault();

        $.ajax({
          type: 'post',
          url: 'create',
          data: $('form').serialize(),
          dataType    : 'json',
          success: function (data) {
            // console.log(data.errors);
            if(!data.success){
              //Form validation fails

              if (data.errors.amount) {
                  $('#amount').addClass('is-invalid'); // add the error class to show red input
                  $('#amount').after('<p class="text-danger">'+ data.errors.amount +'</p>');

              }
              if (data.errors.buyer) {
                  $('#buyer').addClass('is-invalid');
                  $('#buyer').after('<p class="text-danger">'+ data.errors.buyer +'</p>');

              }
              if (data.errors.receipt_id) {
                  $('#receipt_id').addClass('is-invalid');
                  $('#receipt_id').after('<p class="text-danger">'+ data.errors.receipt_id +'</p>');

              }
              if (data.errors.items) {
                  $('#items').addClass('is-invalid');
                  $('#items').after('<p class="text-danger">'+ data.errors.items +'</p>');

              }
              if (data.errors.buyer_email) {
                  $('#buyer_email').addClass('is-invalid');
                  $('#buyer_email').after('<p class="text-danger">'+ data.errors.buyer_email +'</p>');

              }
              if (data.errors.note) {
                  $('#note').addClass('is-invalid');
                  $('#note').after('<p class="text-danger">'+ data.errors.note +'</p>');

              }
              if (data.errors.city) {
                  $('#city').addClass('is-invalid');
                  $('#city').after('<p class="text-danger">'+ data.errors.city +'</p>');

              }
              if (data.errors.phone) {
                  $('#phone').addClass('is-invalid');
                  $('#phone').after('<p class="text-danger">'+ data.errors.phone +'</p>');

              }
              if (data.errors.entry_by) {
                  $('#entry_by').addClass('is-invalid');
                  $('#entry_by').after('<p class="text-danger">'+ data.errors.entry_by +'</p>');

              }

            }else{
              //Validation successfull
              // alert("Form submitted successfully");
              window.location = 'index';
            }


          }


        });

      });

    });
  </script>
<?php endif; ?>
</body>
</html>
