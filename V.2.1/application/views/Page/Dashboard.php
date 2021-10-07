  <link rel="stylesheet" href="<?php echo base_url('assets/') ?>bower_components/morris.js/morris.css">
  <section class="content-header">
  	<h1>
  		Dashboard
  		<small>Control panel</small>
  	</h1>
  	<ol class="breadcrumb">
  		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
  		<li class="active">Dashboard</li>
  	</ol>
  </section>

  <!-- Main content -->
  <section class="content">
  	<!-- Small boxes (Stat box) -->
  	<?php if ($this->session->userdata('STATUS') == 'Super Admin') : ?>
  		<div class="row">
  			<div class="col-lg-3 col-xs-6">
  				<!-- small box -->
  				<div class="small-box bg-aqua">
  					<div class="inner">
  						<h3><?php echo $unit ?></h3>

  						<p>UNIT</p>
  					</div>
  					<div class="icon">
  						<i class="ion ion-bag"></i>
  					</div>
  					<a href="<?php echo base_url('Unit') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
  				</div>
  			</div>
  			<!-- ./col -->
  			<div class="col-lg-3 col-xs-6">
  				<!-- small box -->
  				<div class="small-box bg-green">
  					<div class="inner">
  						<h3><?php echo $indikator ?></h3>

  						<p>INDIKATOR</p>
  					</div>
  					<div class="icon">
  						<i class="ion ion-stats-bars"></i>
  					</div>
  					<a href="<?php echo base_url('Indikator') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
  				</div>
  			</div>
  			<!-- ./col -->
  			<div class="col-lg-3 col-xs-6">
  				<!-- small box -->
  				<div class="small-box bg-yellow">
  					<div class="inner">
  						<h3><?php echo $area ?></h3>
  						<p>AREA</p>
  					</div>
  					<div class="icon">
  						<i class="ion ion-person-add"></i>
  					</div>
  					<a href="<?php echo base_url('Area') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
  				</div>
  			</div>
  		</div>
  		<div class="">
  			<div class="box box-danger">
  				<div class="box-header with-border">
  					<h3 class="box-title">Filter Chart</h3>
  				</div>
  				<div class="box-body">
  					<div class="form-row">
  						<div class="col-md-3">
  							<?php if (empty($bln)) {
									$bln = date("n");
								} ?>
  							<select name="bulan" id="bulan" class="form-control select2">
  								<option value="" disabled selected>Pilih Bulan</option>
  								<option value="1" <?php if ($bln == 1) echo "selected"; ?>>Januari</option>
  								<option value="2" <?php if ($bln == 2) echo "selected"; ?>>Februari</option>
  								<option value="3" <?php if ($bln == 3) echo "selected"; ?>>Maret</option>
  								<option value="4" <?php if ($bln == 4) echo "selected"; ?>>April</option>
  								<option value="5" <?php if ($bln == 5) echo "selected"; ?>>Mei</option>
  								<option value="6" <?php if ($bln == 6) echo "selected"; ?>>Juni</option>
  								<option value="7" <?php if ($bln == 7) echo "selected"; ?>>Juli</option>
  								<option value="8" <?php if ($bln == 8) echo "selected"; ?>>Agustus</option>
  								<option value="9" <?php if ($bln == 9) echo "selected"; ?>>September</option>
  								<option value="10" <?php if ($bln == 10) echo "selected"; ?>>Oktober</option>
  								<option value="11" <?php if ($bln == 11) echo "selected"; ?>>Nopember</option>
  								<option value="12" <?php if ($bln == 12) echo "selected"; ?>>Desember</option>
  							</select>
  						</div>
  						<div class="col-md-2">
  							<select name="tahun" id="tahun" class="form-control select2">
  								<option value="" disabled selected>Pilih Tahun</option>
  								<?php $start = 2018;
									$now = (int)date('Y');
									for ($start; $start <= $now; $start) {
										$selected = ($start == $now) ? 'selected' : '';
										echo '	<option value="' . $start . '" ' . $selected . '>' . $start++ . '</option>';
									}
									?>
  							</select>
  						</div>
  						<div class="col-md-1">
  							<button type="button" id="cari" class="btn btn-block btn-info">Go!</button>
  						</div>
  					</div>

  				</div>
  				<!-- /.box-body -->
  			</div>
  		</div>
  		<div class="row">
  			<section class="col-lg-12 connectedSortable">
  				<!-- Custom tabs (Charts with tabs)-->
  				<div class="nav-tabs-custom">
  					<!-- Tabs within a box -->
  					<ul class="nav nav-tabs pull-right">
  						<li class="pull-left header"><i class="fa fa-inbox"></i> Capaian Indikator Nasional</li>
  					</ul>
  					<div class="tab-content no-padding">
  						<!-- Morris chart - Sales -->
  						<div class="chart" id="area-chart" style="height: 300px; width: 100%"></div>
  					</div>
  				</div>
  			</section>
  		</div>
  		<div class="row">
  			<!-- Left col -->
  			<section class="col-lg-12 connectedSortable">
  				<!-- Custom tabs (Charts with tabs)-->
  				<div class="nav-tabs-custom">
  					<!-- Tabs within a box -->
  					<ul class="nav nav-tabs pull-right">
  						<li class="pull-left header"><i class="fa fa-inbox"></i> Capaian Indikator Area Management (IAM)</li>
  					</ul>
  					<div class="tab-content no-padding">
  						<!-- Morris chart - Sales -->
  						<div class="chart" id="area-chart-area" style="height: 300px; width: 100%"></div>
  					</div>
  				</div>
  			</section>
  		</div>
  		<div class="row">
  			<!-- Left col -->
  			<section class="col-lg-12 connectedSortable">
  				<!-- Custom tabs (Charts with tabs)-->
  				<div class="nav-tabs-custom">
  					<!-- Tabs within a box -->
  					<ul class="nav nav-tabs pull-right">
  						<li class="pull-left header"><i class="fa fa-inbox"></i> Capaian Indikator Klinis (IAK)</li>
  					</ul>
  					<div class="tab-content no-padding">
  						<!-- Morris chart - Sales -->
  						<div class="chart" id="area-chart-klinik" style="height: 300px; width: 100%"></div>
  					</div>
  				</div>
  			</section>
  		</div>
  		<div class="row">
  			<!-- Left col -->
  			<section class="col-lg-12 connectedSortable">
  				<!-- Custom tabs (Charts with tabs)-->
  				<div class="nav-tabs-custom">
  					<!-- Tabs within a box -->
  					<ul class="nav nav-tabs pull-right">
  						<li class="pull-left header"><i class="fa fa-inbox"></i> Capaian Indikator Sasaran Keselamatan
  							Pasien (ISKP)</li>
  					</ul>
  					<div class="tab-content no-padding">
  						<!-- Morris chart - Sales -->
  						<div class="chart" id="area-chart-pasien" style="height: 300px; width: 100%"></div>
  					</div>
  				</div>
  			</section>
  		</div>
  		<div class="row">
  			<!-- Left col -->
  			<section class="col-lg-12 connectedSortable">
  				<!-- Custom tabs (Charts with tabs)-->
  				<div class="nav-tabs-custom">
  					<!-- Tabs within a box -->
  					<ul class="nav nav-tabs pull-right">
  						<li class="pull-left header"><i class="fa fa-inbox"></i> Capaian Indikator Unit</li>
  					</ul>
  					<div class="tab-content no-padding">
  						<!-- Morris chart - Sales -->
  						<div class="chart" id="area-chart-unit" style="height: 300px; width: 100%"></div>
  					</div>
  				</div>
  			</section>
  		</div>
  	<?php else : ?>
  		<div class="">
  			<div class="box box-danger">
  				<div class="box-header with-border">
  					<h3 class="box-title">Filter Chart</h3>
  				</div>
  				<div class="box-body">
  					<div class="input-group input-group-sm col-md-4">
  						<?php if (empty($bln)) {
								$bln = date("n");
							} ?>
  						<select name="bulan" id="bulan" class="form-control select2">
  							<option value=""></option>
  							<option value="1" <?php if ($bln == 1) echo "selected"; ?>>Januari</option>
  							<option value="2" <?php if ($bln == 2) echo "selected"; ?>>Februari</option>
  							<option value="3" <?php if ($bln == 3) echo "selected"; ?>>Maret</option>
  							<option value="4" <?php if ($bln == 4) echo "selected"; ?>>April</option>
  							<option value="5" <?php if ($bln == 5) echo "selected"; ?>>Mei</option>
  							<option value="6" <?php if ($bln == 6) echo "selected"; ?>>Juni</option>
  							<option value="7" <?php if ($bln == 7) echo "selected"; ?>>Juli</option>
  							<option value="8" <?php if ($bln == 8) echo "selected"; ?>>Agustus</option>
  							<option value="9" <?php if ($bln == 9) echo "selected"; ?>>September</option>
  							<option value="10" <?php if ($bln == 10) echo "selected"; ?>>Oktober</option>
  							<option value="11" <?php if ($bln == 11) echo "selected"; ?>>Nopember</option>
  							<option value="12" <?php if ($bln == 12) echo "selected"; ?>>Desember</option>
  						</select>

  						<span class="input-group-btn">
  							<button type="button" id="cari" class="btn btn-info btn-flat">Go!</button>
  						</span>
  					</div>
  				</div>
  				<!-- /.box-body -->
  			</div>
  		</div>
  		<div class="row">
  			<!-- Left col -->
  			<section class="col-lg-12 connectedSortable">
  				<!-- Custom tabs (Charts with tabs)-->
  				<div class="nav-tabs-custom">
  					<!-- Tabs within a box -->
  					<ul class="nav nav-tabs pull-right">
  						<li class="pull-left header"><i class="fa fa-inbox"></i> Capaian Indikator</li>
  					</ul>
  					<div class="tab-content no-padding">
  						<!-- Morris chart - Sales -->
  						<div class="chart" id="chart_unit" style="height: 300px; width: 100%"></div>
  					</div>
  				</div>
  			</section>
  		</div>
  	<?php endif ?>

  </section>