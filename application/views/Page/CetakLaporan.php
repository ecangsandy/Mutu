<section class="content-header">
	<h1>
		Cetak Laporan
		<small>nilai target indikator</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Target</li>
	</ol>
</section>
<section class="content">
	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title">Cetak Laporan</h3>
		</div>
		<!-- /.box-header -->
		<!-- form start -->
		<form action="<?= base_url('Laporan/cetakLaporan') ?>" method="post" class="form-horizontal" target="_blank">
			<div class="box-body">
				<div class="form-group">
					<label for="kd_unit" class="col-sm-2 control-label">Unit</label>

					<div class="col-sm-5">
						<select name="kd_unit" id="kd_unit" class="form-control select2" style="width: 100%;" data-url="<?= base_url('Laporan/getIndikatorById') ?>">
							<option value="">PILIH UNIT </option>
							<?php foreach ($unit as $key => $value) {
								echo '<option value="' . $value->KD_UNIT . '" ' . (($value->KD_UNIT == $kd_unit) ? 'selected="selected"' : "") . '>' . $value->NM_UNIT . '</option>';
							} ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="bulan" class="col-sm-2 control-label">Bulan</label>
					<div class="col-sm-5">
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

					</div>
				</div>
				<div class="form-group">
					<label for="tahun" class="col-sm-2 control-label">Tahun</label>
					<div class="col-sm-5">
						<select name="tahun" id="tahun" class="form-control select2">
							<option value=""></option>
							<?php
							$start = 2015;
							if (empty($tahun)) {
								$active = date("Y");
							} else {
								$active = $tahun;
							}
							$now = date("Y");
							for ($start; $start <= $active; $start++) {
								echo '<option value="' . $start . '" ' . (($start == $active) ? 'selected="selected"' : "") . '>' . $start . ' </option>';
							}
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<label>
							<button type="submit" class="btn btn-info pull-right">Cetak</button>
						</label>
					</div>
				</div>
			</div>
			<!-- /.box-body -->
			<!-- <div class="box-footer">
				<button type="submit" class="btn btn-default">Cancel</button>
				<button type="submit" class="btn btn-info pull-right">Sign in</button>
			</div> -->
			<!-- /.box-footer -->
		</form>
	</div>
</section>