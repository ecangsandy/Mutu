<style>
	[contenteditable=true]:empty:before {
		content: attr(placeholder);
		display: block;
		/* For Firefox */
	}

	/* */

	td[contenteditable=true] {
		/* border: 1px dashed #AAA; */
		width: 290px;
		padding: 5px;
	}

	pre {
		background: #EEE;
		padding: 5px;
		width: 290px;
	}
</style>
<section class="content-header">
	<h1>
		Data Tables
		<small>data Imut</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Tables</a></li>
		<li class="active">Data Rekap</li>
	</ol>
</section>
<section class="content">
	<div class="box box-success">
		<div class="box-header with-border">
			<!-- <h3 class="box-title">Different Width</h3> -->

		</div>
		<div class="box-body">
			<div class="row">
				<form action="<?= base_url('Survei/rekapImut/' . $idKat) ?>/" method="POST" role="form" id="filter-form">

					<input type="hidden" name="idKat" id="idKat" class="form-control" value="<?= $idKat ?>">

					<div class="col-xs-3 col-md-3">
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
					<div class="col-xs-3 col-md-3">

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
					<div class="col-xs-3 col-md-3">
						<select name="kd_unit" id="kd_unit" class="form-control select2" style="width: 100%;">
							<option value="">PILIH UNIT </option>
							<?php foreach ($unit as $key => $value) {
								echo '<option value="' . $value->KD_UNIT . '" ' . (($value->KD_UNIT == $kd_unit) ? 'selected="selected"' : "") . '>' . $value->NM_UNIT . '</option>';
							} ?>
						</select>
					</div>
					<div class="col-xs-1 col-md-1">
						<button type="button" onclick="caridata()" id="cari" class="btn btn-primary">Cari</button>
					</div>
					<div class="col-xs-2 col-md-2">
						<button type="button" onclick="saveExcel()" id="excel" class="btn btn-primary">Save to Excel</button>
					</div>
				</form>
			</div>
		</div>
		<!-- /.box-body -->
	</div>
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Data Indikator <?= $kategori->NM_JENIS_INDIKATOR ?></h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<!-- <a class="btn btn-primary" href='#' onclick="add()">Tambah</a> -->
			<div class="table-responsive">
				<table id="tables" data-url="<?= base_url('Survei/get_tables_rekap') ?>" class="table table-bordered table-striped" width="100%">
					<thead>
						<?php $max =  cal_days_in_month(CAL_GREGORIAN, $bln, $tahun) ?>
						<tr>
							<th>No</th>
							<th width="30%">INDIKATOR</th>
							<?php for ($i = 1; $i <= $max; $i++) {
								echo "<th> $i </th>";
							} ?>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
		<!-- /.box-body -->
	</div>
</section>
<div class="modal fade" id="modal-detail">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title detail">Detail Indikator</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal">
					<div class="form-group">
						<label class="control-label col-sm-2" for="judulindikator">Judul:</label>
						<div class="col-sm-10">
							<p class="form-control-static" id="judulindikator"></p>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="definisiindikator">DEFINISI:</label>
						<div class="col-sm-10">
							<p class="form-control-static" id="definisiindikator"></p>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="kt_inklusi">KAT INKLUSI:</label>
						<div class="col-sm-10">
							<p class="form-control-static" id="kt_inklusi"></p>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="kt_eklusi">KAT EKLUSI:</label>
						<div class="col-sm-10">
							<p class="form-control-static" id="kt_eklusi"></p>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="sumber">SUMBER:</label>
						<div class="col-sm-10">
							<p class="form-control-static" id="sumber"></p>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="area">AREA:</label>
						<div class="col-sm-10">
							<p class="form-control-static" id="area"></p>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-survei">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Modal title</h4>
			</div>
			<div class="modal-body">
				<form action="" id="form_survei" method="POST" role="form">
					<input type="hidden" name="id_hasil" id="id_hasil" class="form-control" value="">
					<input type="hidden" name="id_indikator" id="id_indikator" class="form-control" value="">
					<input type="hidden" name="tgl_input" id="tgl_input" class="form-control" value="">
					<input type="hidden" name="metode" id="metode" class="form-control" value="">

				</form>
				<div class="table-responsive">
					<table class="table table-hover" id="variable_survei">
						<thead>
							<tr>
								<th>Indikator</th>
								<th>Nilai</th>
								<th>Satuan</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<!-- <button type="button" class="btn btn-primary" onclick="save_variable()">Save changes</button> -->
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-input-survei">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header card-header-title text-center">
				<h4 class="modal-title card-element-title">pick your locker side</h4>
			</div>
			<div class="modal-body">
				<form action="" method="POST" role="form">
					<div class="form-group">
						<label for="">label</label>
						<input type="text" class="form-control" id="" placeholder="Input field">
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-input-survei1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header card-header-title text-center">
				<h4 class="modal-title card-element-title">pick your locker side</h4>
			</div>
			<div class="modal-body">
				<form action="" method="POST" role="form">
					<div class="form-group">
						<label for="">label</label>
						<input type="text" class="form-control" id="" placeholder="Input field">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>