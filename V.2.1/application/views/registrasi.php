
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/')?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/')?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/')?>bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/')?>bower_components/select2/dist/css/select2.min.css">
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
<body class="hold-transition login-page" style="background-image: url('<?=base_url('assets/dist/img/bg.jpg')?>'); background-repeat:no-repeat;background-size: cover;height: 100%;">
<div class="register-box">
  <div class="register-logo">
    <a><b>Admin</b> MUTU</a>
  </div>
    <div class="register-box-body">
    <p class="login-box-msg">Register</p>
    <?php if(!empty($this->session->flashdata('error'))){ ?>
                                <div class="form-group">
                                    <div class="alert alert-danger">
                                    <?php echo $this->session->flashdata('error'); ?>
                                    </div>
                                </div>
                                <?php } ?>
    <?php if(!empty($this->session->flashdata('success'))){ ?>
                                <div class="form-group">
                                    <div class="alert alert-success">
                                    <?php echo $this->session->flashdata('success'); ?>
                                    </div>
                                </div>
                                <?php } ?>

          <div class="panel panel-default">

          <div class="panel-body">
          <form name="basicform" id="basicform" method="post" action="<?php echo base_url('Registrasi/register') ?>" enctype="multipart/form-data">

            <div class="form-group has-feedback">
               <input type="hidden" class="form-control" id="metode" name="metode">
               <input type="hidden" name="id_user" id="id_user" value="">
              <select name="kd_unit" id="kd_unit" class="form-control select2" style="width: 100%;">
                  <option value="">PILIH UNIT </option>
                        <?php foreach ($unit as $key => $value) {
                        echo '<option value="'.$value->KD_UNIT.'">'.$value->NM_UNIT.'</option>';
                      } ?>

                        </select>
            </div>
            <div class="form-group has-feedback">
              <input type="text"  id="full_name" name="full_name" class="form-control" placeholder="Full name">
              <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
              <input type="username" id="username" name="username" class="form-control" placeholder="Username">
              <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
              <input type="password" id="password" name="password" class="form-control" placeholder="Password">
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>


            <div class="row">
              <div class="col-xs-8">
                <div class="checkbox icheck">
                <a href="<?php echo base_url('Login')?>"class="text-center">I already have a account</a>
                </div>
              </div>

              <!-- /.col -->
              <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
              </div>
              <!-- /.col -->
            </div>

        <!-- </div> -->
      </form>
      </div>

    </div>
      </div>
</div>

<!-- jQuery 3 -->
<script src="<?php echo base_url('assets/')?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets/')?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url('assets/')?>bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url('assets/')?>plugins/iCheck/icheck.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
$('.select2').select2({placeholder: "PILIH UNIT",})
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
        full_name: {
          required: true,
          minlength: 2,
          maxlength: 20
        },
        username: {
          required: true,
          minlength: 5,
          remote: {
						url: "<?php echo base_url('Registrasi/getmail/');?>",
					 }
        },
        kd_unit: {
          required: true,
        },

        password: {
          required: true,
          minlength: 6,
          maxlength: 50
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
                    remote: "<p class='errors'>Username Sudah Terdaftar</p>", //pesan ini muncul apabila email tidak dimasukkan

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
