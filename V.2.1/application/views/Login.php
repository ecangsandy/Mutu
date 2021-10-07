<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url('assets/')?>dist/img/favicon-32x32.png">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/')?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/')?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/')?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/')?>dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url('assets/')?>plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>
<body class="hold-transition login-page" style="background-image: url('<?=base_url('assets/dist/img/bg.jpg')?>'); background-repeat:no-repeat;background-size: cover;">
<div class="login-box">
  <div class="login-logo">
    <!-- <a href="#"><b>Admin</b> MUTU</a> -->
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <h3 class="login-box-msg">INDIKATOR MUTU</h3>

    <form id="basicform" method="POST" action="<?php echo base_url();?>Login/aksi_login" >
      <div class="form-group has-feedback">
        <input type="username" id="username" name="username" class="form-control" placeholder="Username">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" id="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <?php if($this->session->flashdata('error')== TRUE): ?>
      <center>
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="glyphicon glyphicon-check"></i> Gagal!</h4>
        <?php echo $this->session->flashdata('error') ?>
      </div>
      </center>
    <?php endif; ?>
      <div class="row">

        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->

      </div>
    </form>
<!-- <a href="<?php echo base_url('Registrasi')?>" class="text-center">Register a new account</a> -->
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo base_url('assets/')?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets/')?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url('assets/')?>plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
<script type="text/javascript">

  jQuery().ready(function() {

    // validate form on keyup and submit
    var v = jQuery("#basicform").validate({
      rules: {
        username: {
          required: true,

        },
        password: {
          required: true,

        }
      },
      messages: {
                username: {
                    required: "<p class='errors'>Masukkan Username</p>", //pesan ini muncul apabila username tidak dimasukkan
                    //pesan ini muncul apabila username sudah ada sesuai yang diinput di database
                },
                password: {
                    required: "<p class='errors'>Masukkan Password</p>", //pesan ini muncul apabila email tidak dimasukkan

                },
                username: {
                    required: "<p class='errors'>Masukkan Username</p>",


                }
            },
            errorElement: "em",
                errorPlacement: function ( error, element ) {
                    // Add the `help-block` class to the error element
                    error.addClass( "help-block" );

                    // Add `has-feedback` class to the parent div.form-group
                    // in order to add icons to inputs
                    element.parents( ".form-group" ).addClass( "has-feedback" );

                        error.insertAfter( element );

                },
                success: function ( label, element ) {
                    // Add the span element, if doesn't exists, and apply the icon classes to it.
                    // if ( !$( element ).next( "span" )[ 0 ] ) {
                    //     $( "<span class='glyphicon glyphicon-ok form-control-feedback'></span>" ).insertAfter( $('.form-group') );
                    // }
                },
                highlight: function ( element, errorClass, validClass ) {
                    $( element ).parents( ".form-group" ).addClass( "has-error" ).removeClass( "has-success" );

                },
                unhighlight: function ( element, errorClass, validClass ) {
                    $( element ).parents( ".form-group" ).addClass( "has-success" ).removeClass( "has-error" );

                }

    });
  });
</script>

</body>
</html>
