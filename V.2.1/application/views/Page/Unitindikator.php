<section class="content-header">
	<h1>
		Data
		<small>unit indikator</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Unit Indikator</li>
	</ol>
</section>
<section class="content">
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Data Unit Indikator</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<div class="form-group">
						<a class="btn btn-primary" href='#' onclick="add()">Tambah</a>
					</div>
					<div class="form-group">
						<label for="unitselect">UNIT</label>
						<select name="unitselect" id="unitselect" class="form-control select2" required="required" data-placeholder="UNIT INDIKATOR" style="width: 100%;" data-url="<?= base_url('Unitindikator/get_tables/') ?>">
							<option value="">Semua Unit</option>
							<?php foreach ($unit as $key => $value) {
								echo "<option value='$value->KD_UNIT'>$value->NM_UNIT</option>";
							} ?>
							<!-- <option value=""></option> -->
						</select>

					</div>
				</div>
			</div>
			<div class="table-responsive">
				<!-- <b>UNIT</b> -->
				<table id="tables" data-url="<?= base_url('Unitindikator/get_tables') ?>" class="table table-bordered table-striped" width="100%">
					<thead>
						<tr>
							<th>NO</th>
							<th>JUDUL INDIKATOR</th>
							<th>DESKRIPSI</th>
							<th>KRETERIA INKLUSI</th>
							<th>STANDAR</th>
							<th></th>
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


<div class="modal fade" id="modal-id">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Modal title</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="form_input" action="<?= base_url('Unitindikator/save') ?>">
					<div class="box-body">
						<input type="hidden" class="form-control" id="metode" name="metode">
						<input type="hidden" class="form-control" id="idunitindikator" name="idunitindikator">
						<div class="form-group">
							<label for="unitkat">UNIT</label>
							<select name="unitkat" id="unitkat" class="form-control select2" required="required" data-placeholder="UNIT" style="width: 100%;">
								<option value=""></option>
								<?php foreach ($unit as $key => $value) {
									echo "<option value='$value->KD_UNIT'>$value->NM_UNIT</option>";
								} ?>
								<!-- <option value=""></option> -->
							</select>

						</div>

						<!-- <input type="hidden" name="unit" id="inputunit" class="form-control" value=""> -->

						<div class="form-group">
							<label for="indikatorunit">INDIKATOR</label>
							<select name="indikatorunit" id="indikatorunit" class="form-control select2" required="required" data-placeholder="INDIKATOR" style="width: 100%;">
								<option value=""></option>
								<?php foreach ($indikator as $key => $value) {
									echo "<option value='$value->ID_INDIKATOR'>$value->JUDUL_INDIKATOR</option>";
								} ?>
							</select>
						</div>

						<div class="form-group">
							<a class="btn btn-xs btn-primary" href="#" role="button" id="detail">Detail
								Indikator</a>
						</div>

					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-info pull-right" onclick="save()">Save</button>
					</div>
					<!-- /.box-footer -->
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-del">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Modal title</h4>
			</div>
			<div class="modal-body">
				<form action="" id="form_del" role="form">
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
				<a href="#" onclick="delet()" class="btn btn-danger">Hapus</a>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-detail">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title detail">Modal title</h4>
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