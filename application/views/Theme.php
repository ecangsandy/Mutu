<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>MUTU</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes" name="viewport">
	<link rel="stylesheet" href="<?php echo base_url('assets/') ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
	<!-- <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url('assets/') ?>dist/img/favicon-32x32.png"> -->
	<link rel="shortcut icon" href="<?php echo base_url('assets/') ?>dist/img/ico-rsud-soeselo.png" />
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo base_url('assets/') ?>bower_components/font-awesome/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="<?php echo base_url('assets/') ?>bower_components/Ionicons/css/ionicons.min.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/') ?>bower_components/select2/dist/css/select2.min.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/') ?>bower_components/morris.js/morris.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/') ?>summernote/dist/summernote.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/') ?>pnotify/dist/pnotify.css">
	<!-- Morris charts -->
	<link rel="stylesheet" href="<?php echo base_url('assets/') ?>bower_components/morris.js/morris.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="<?php echo base_url('assets/') ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
	<link rel="stylesheet" href="<?php echo base_url('assets/') ?>fixedColumns.bootstrap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist/css/AdminLTE.min.css">
	<!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
		apply the skin class to the body tag so the changes take effect. -->

	<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist/css/skins/skin-green.min.css">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

	<!-- Google Font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->

<body class="hold-transition skin-green sidebar-mini">
	<div class="wrapper">

		<!-- Main Header -->
		<header class="main-header">

			<!-- Logo -->
			<a href="index2.html" class="logo">

				<!-- mini logo for sidebar mini 50x50 pixels -->
				<span class="logo-mini"><b>M</b>TU</span>
				<!-- logo for regular state and mobile devices -->
				<span class="logo-lg"><b>MU</b>TU</span>
			</a>

			<!-- Header Navbar -->
			<nav class="navbar navbar-static-top" role="navigation">
				<!-- Sidebar toggle button-->
				<a href="#" class="sidebar-toggle" data-toggle="push-menu" data-enable-remember="true" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>
				<!-- Navbar Right Menu -->
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<!-- Messages: style can be found in dropdown.less-->

						<!-- User Account Menu -->
						<li class="dropdown user user-menu">
							<!-- Menu Toggle Button -->
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<!-- The user image in the navbar-->
								<img src="<?php echo base_url('assets/') ?>dist/img/user_icon.png" class="user-image" alt="User Image">
								<!-- hidden-xs hides the username on small devices so only the image appears. -->
								<span class="hidden-xs"><?php echo $this->session->userdata('FULL_NAME') ?></span>
							</a>
							<ul class="dropdown-menu">
								<!-- The user image in the menu -->

								<!-- Menu Body -->

								<!-- Menu Footer-->
								<li class="user-footer">
									<div class="pull-left">
										<a href='#' onclick="addPaasword()" class="btn btn-default btn-flat">Change Password</a>
									</div>
									<div class="pull-right">
										<a href="<?php echo base_url('Login/logout') ?>" class="btn btn-default btn-flat">Sign out</a>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</header>
		<!-- Left side column. contains the logo and sidebar -->
		<aside class="main-sidebar">

			<!-- sidebar: style can be found in sidebar.less -->
			<section class="sidebar">

				<!-- Sidebar user panel (optional) -->
				<div class="user-panel">
					<div class="pull-left image">
						<img src="<?php echo base_url('assets/') ?>dist/img/user_icon.png" class="img-circle" alt="User Image">
					</div>
					<div class="pull-left info">
						<p><?php echo $this->session->userdata('FULL_NAME') ?></p>
						<!-- Status -->
						<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
					</div>
				</div>

				<!-- search form (Optional) -->
				<form action="#" method="get" class="sidebar-form">

				</form>
				<!-- /.search form -->

				<!-- Sidebar Menu -->
				<?php $url = $this->uri->segment(1);
				$url1 = $this->uri->segment(2); ?>
				<ul class="sidebar-menu" data-widget="tree">
					<li class="header">HEADER</li>
					<!-- Optionally, you can add icons to the links -->
					<?php if ($this->session->userdata('STATUS') == 'User') : ?>
						<li class="<?= ($url == 'Dashboard') ? 'active' : '' ?>"><a href="<?= base_url('Dashboard') ?>"><i class="fa fa-link"></i> <span>Dashboard </span></a></li>
						<li class="<?= ($url == 'Indikator') ? 'active' : '' ?>"><a href="<?= base_url('Indikator') ?>"><i class="fa fa-link"></i> <span>INDIKATOR</span></a></li>
						<li class="treeview <?= ($url == 'Survei') ? 'active menu-open' : '' ?>">
							<a href="#"><i class="fa fa-link"></i> <span>INDIKATOR MUTU </span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<?php
								$q = "SELECT * FROM MASTER_GROUP";
								$fetch_data = $this->db->query($q);
								foreach ($fetch_data->result() as $key => $val) :
									$nq = "SELECT * FROM MASTER_JENIS_INDIKATOR WHERE GROUP_ID = '$val->ID_GROUP'";
									$fetch_imut = $this->db->query($nq);
									if ($fetch_imut->num_rows() > 1) :
										// $kategori =  $this->db->get('MASTER_JENIS_INDIKATOR')->result();
										// foreach ($kategori as $key => $value) {
										// 	echo '<li><a href="' . base_url('Survei/Survei_Progres/' . $value->ID_JENIS_INDIKATOR) . '">' . $value->NM_JENIS_INDIKATOR . '</a></li>';
										// } 
								?>
										<li class="treeview">
											<a href="#"><i class="fa fa-circle-o"></i> <?= $val->NM_GROUP ?>
												<span class="pull-right-container">
													<i class="fa fa-angle-left pull-right"></i>
												</span>
											</a>
											<ul class="treeview-menu">
												<?php foreach ($fetch_imut->result() as $key => $value) : ?>
													<li><a href="<?= base_url('Survei/Survei_Progres/' . $value->ID_JENIS_INDIKATOR) ?>"><i class="fa fa-circle-o"></i> <?= $value->NM_JENIS_INDIKATOR ?></a></li>
													<!-- <li><a href="<?= base_url('Survei/rekapImut/' . $value->ID_JENIS_INDIKATOR) ?>"><i class="fa fa-circle-o"></i> <?= $value->NM_JENIS_INDIKATOR ?></a></li> -->
												<?php endforeach ?>
											</ul>
										</li>
									<?php endif;
									if ($fetch_imut->num_rows() == 1) : ?>
										<?php foreach ($fetch_imut->result() as $key => $value) : ?>
											<li><a href="<?= base_url('Survei/Survei_Progres/' . $value->ID_JENIS_INDIKATOR) ?>"><i class="fa fa-circle-o"></i> <?= $value->NM_JENIS_INDIKATOR ?></a></li>
										<?php endforeach ?>
								<?php endif;
								endforeach ?>
								<!-- <li><a href="<?= base_url('Unitindikator') ?>"></a></li>
							<li><a href="#">Link in level 2</a></li> -->
							</ul>
						</li>
					<?php else : ?>
						<li class="<?= ($url == 'Dashboard') ? 'active' : '' ?>"><a href="<?= base_url('Dashboard') ?>"><i class="fa fa-link"></i> <span>Dashboard </span></a></li>
						<li class="<?= ($url == 'Unitindikator') ? 'active' : '' ?>"><a href="<?= base_url('Unitindikator') ?>"><i class="fa fa-link"></i> <span>Unit Indikator </span></a></li>
						<li class="treeview <?= ($url == 'Survei') ? 'active menu-open' : '' ?>">
							<a href="#"><i class="fa fa-link"></i> <span>Rekap Indikator</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<?php
								$q = "SELECT * FROM MASTER_GROUP";
								$fetch_data = $this->db->query($q);
								foreach ($fetch_data->result() as $key => $val) :
									$nq = "SELECT * FROM MASTER_JENIS_INDIKATOR WHERE GROUP_ID = '$val->ID_GROUP'";
									$fetch_imut = $this->db->query($nq);
									if ($fetch_imut->num_rows() > 1) :
								?>
										<li class="treeview">
											<a href="#"><i class="fa fa-circle-o"></i> <?= $val->NM_GROUP ?>
												<span class="pull-right-container">
													<i class="fa fa-angle-left pull-right"></i>
												</span>
											</a>
											<ul class="treeview-menu">
												<?php foreach ($fetch_imut->result() as $key => $value) : ?>
													<li><a href="<?= base_url('Survei/rekapImut/' . $value->ID_JENIS_INDIKATOR) ?>"><i class="fa fa-circle-o"></i> <?= $value->NM_JENIS_INDIKATOR ?></a></li>
												<?php endforeach ?>
											</ul>
										</li>
									<?php endif;
									if ($fetch_imut->num_rows() == 1) : ?>
										<?php foreach ($fetch_imut->result() as $key => $value) : ?>
											<li><a href="<?= base_url('Survei/rekapImut/' . $value->ID_JENIS_INDIKATOR) ?>"><i class="fa fa-circle-o"></i><?= $value->NM_JENIS_INDIKATOR ?></a></li>
										<?php endforeach ?>
								<?php endif;
								endforeach ?>
								<!-- <?php $kategori =  $this->db->get('MASTER_JENIS_INDIKATOR')->result();
										foreach ($kategori as $key => $value) {
											echo '<li><a href="' . base_url('Survei/rekapImut/' . $value->ID_JENIS_INDIKATOR) . '">' . $value->NM_JENIS_INDIKATOR . '</a></li>';
										} ?> -->
							</ul>
						</li>
						<li class="treeview <?= ($url == 'Laporan' || $url == 'Rekap') ? 'active menu-open' : '' ?>">
							<a href="#"><i class="fa fa-archive"></i> <span>Laporan</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<li class="<?= ($url == 'Laporan') ? 'active' : '' ?>"><a href="<?= base_url('Laporan') ?>">Capaian</a></li>
								<li class="<?= ($url . '/cetak' == 'Laporan/cetak') ? 'active' : '' ?>"><a href="<?= base_url('Laporan/Cetak') ?>">Cetak</a></li>
								<!-- <li class="<?= ($url  == 'Rekap') ? 'active' : '' ?>"><a href="<?= base_url('Rekap') ?>">Rekap</a></li> -->
								<li class="treeview <?= ($url  == 'Rekap') ? 'active menu-open' : '' ?>">
									<a href="#"><i class="fa fa-circle-o"></i>Rekap
										<span class="pull-right-container">
											<i class="fa fa-angle-left pull-right"></i>
										</span>
									</a>
									<ul class="treeview-menu">
										<li class="<?= ($url  == 'Rekap') ? 'active' : '' ?>"><a href="<?= base_url('Rekap') ?>"><i class="fa fa-circle-o"></i> Rekap Bulanan</a></li>
										<li class="<?= ($url1  == 'triwulan') ? 'active' : '' ?>"><a href="<?= base_url('Rekap/triwulan') ?>"><i class="fa fa-circle-o"></i> Rekap Triwulan</a></li>
									</ul>
								</li>
							</ul>
						</li>
						<!-- <li class="<?= ($url == 'Laporan') ? 'active' : '' ?>"><a href="<?= base_url('Laporan') ?>"><i class="fa fa-archive"></i> <span>Laporan </span></a></li> -->
						<li class="header">Data Master</li>
						<li class="<?= ($url == 'Unit') ? 'active' : '' ?>"><a href="<?= base_url('Unit') ?>"><i class="fa fa-link"></i> <span>Data Unit</span></a></li>
						<li class="<?= ($url == 'User') ? 'active' : '' ?>"><a href="<?= base_url('User') ?>"><i class="fa fa-link"></i> <span>Data Users</span></a></li>
						<li class="<?= ($url == 'Area') ? 'active' : '' ?>"><a href="<?= base_url('Area') ?>"><i class="fa fa-link"></i> <span>Data Area</span></a></li>
						<li class="treeview <?= ($url == 'Indikator' || $url == 'Jenisindikator' || $url == 'Tipeindikator') ? 'active menu-open' : '' ?>">
							<a href="#"><i class="fa fa-link"></i> <span>Indikator</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<li><a href="<?= base_url('Indikator') ?>">Indikator</a></li>
								<li><a href="<?= base_url('Jenisindikator') ?>">Jenis Indikator</a></li>
								<li><a href="<?= base_url('Tipeindikator') ?>">Tipe Indikator</a></li>
								<li><a href="#"></a></li>
							</ul>
						</li>
					<?php endif ?>
				</ul>
				<!-- /.sidebar-menu -->
			</section>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">

			<?php if (!empty($content)) $this->load->view($content) ?>

		</div>
		<!-- /.content-wrapper -->

		<!-- Main Footer -->
		<footer class="main-footer">
			<!-- To the right -->

			<!-- Default to the left -->
			<strong>Copyright &copy; 2019 <a href="#">RSUD Dr. SOESELO</a>.</strong> All rights reserved.
		</footer>
		<!-- /.control-sidebar -->
		<!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
		<div class="control-sidebar-bg"></div>
	</div>

	<div class="modal fade" id="modal-changePassword">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Modal title</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" id="form_changePassword" action="<?= base_url('User/change_password/') ?>">
						<div class="box-body">

							<input type="hidden" class="form-control" id="id_user" name="id_user" value="<?php echo $this->session->userdata('ID_USER') ?>">

							<div class="form-group">
								<label for="namaUnit" class="col-sm-3 control-label">PASSWORD LAMA</label>
								<div class="col-sm-9">
									<input type="password" class="form-control" id="passwordLama" name="passwordLama" placeholder="PASSWORD LAMA">
								</div>
							</div>
							<div class="form-group">
								<label for="passwordBaru" class="col-sm-3 control-label">PASSWORD BARU</label>

								<div class="col-sm-9">
									<input type="password" class="form-control" id="passwordBaru" name="passwordBaru" placeholder="PASSWORD BARU">
								</div>
							</div>

						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							<button type="button" class="btn btn-info pull-right" onclick="change_password()">Save</button>
						</div>
						<!-- /.box-footer -->
					</form>
				</div>
				<!-- <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div> -->
			</div>
		</div>
	</div>
	<!-- ./wrapper -->

	<!-- REQUIRED JS SCRIPTS -->

	<!-- jQuery 3 -->
	<script src="<?php echo base_url('assets/') ?>bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="<?php echo base_url('assets/') ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- DataTables -->
	<script src="<?php echo base_url('assets/') ?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url('assets/') ?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

	<script src="<?php echo base_url('assets/') ?>summernote/dist/summernote.min.js">
	</script>
	<!-- AdminLTE App -->
	<script src="<?php echo base_url('assets/') ?>dist/js/adminlte.min.js"></script>
	<script src="<?php echo base_url('assets/') ?>pnotify/dist/pnotify.js"></script>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/') ?>easy_ui/default/easyui.css">
	<script type="text/javascript" src="<?php echo base_url('assets/') ?>easy_ui/jquery.easyui.min.js"></script>

	<?php if (!empty($script)) $this->load->view($script) ?>
	<script>
		$(function() {
			$("li a").each(function() {
				//console.log($(this).attr('href'));
				if ((window.location.pathname.indexOf($(this).attr('href'))) > -1) {
					$(this).parent().addClass('active');
					console.log($(this).attr('href'));
				}
			});
		});

		function addPaasword() {
			//	remove_validation();
			$('#form_changePassword')[0].reset();
			$('.modal-title').text('Edit Password');
			$('#modal-changePassword').modal({
				backdrop: "static",
				show: true
			});
			$('#metode').val('addPaasword');
		}

		function change_password() {
			// remove_validation();

			var url = $('#form_changePassword').attr('action');

			var dataForm = new FormData($('#form_changePassword')[0]);
			// console.log(dataForm);
			$.ajax({
				url: url,
				type: "POST",
				data: dataForm,
				dataType: "JSON",
				cache: false,
				contentType: false,
				processData: false,
				success: function(data) {
					if (data.success) {
						new PNotify({
							title: 'Success!',
							text: data.notif,
							type: 'success',
							styling: 'bootstrap3'
						});
						$('#modal-changePassword').modal('hide');
						// $('#saveBtn').removeAttr('data-metode');
						reload_table();

					} else if (data.messages) {
						$('#msg').html(data.messages);
						$.each(data.messages, function(key, value) {
							var element = $('#' + key);
							element.closest('div.form-group')
								.removeClass('has-error')
								.addClass(value.length > 0 ? 'has-error' : 'has-success')
								.find('.text-danger')
								.remove();
							element.after(value);
						})
					}
				},
				error: function(ts) {
					alert(ts.responseText);
					console.log(ts.responseText);
				}
			})
		}
	</script>
	<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>

</html>