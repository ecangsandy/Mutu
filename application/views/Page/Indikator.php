<section class="content-header">
	<h1>
		Data
		<small>indikator</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Indikator Mutu</li>
	</ol>
</section>
<section class="content">
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Data Indikator</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<div class="form-group">
						<?php if ($this->session->userdata('STATUS')=='Super Admin'): ?>
						<a class="btn btn-primary" href='#' onclick="add()">Tambah</a>
						<?php  endif ?>
					</div>
					<div class="form-group">
						<label for="jenisselect">Jenis Indikator</label>
						<select name="jenisselect" id="jenisselect" class="form-control select2" required="required"
							data-placeholder="JENIS INDIKATOR" style="width: 100%;"
							data-url="<?=base_url('Indikator/get_tables/')?>">
							<option value=""></option>
							<?php foreach ($kategori as $key => $value) {
											echo "<option value='$value->ID_JENIS_INDIKATOR'>$value->NM_JENIS_INDIKATOR</option>";
										}?>
							<!-- <option value=""></option> -->
						</select>

					</div>
				</div>
			</div>
			<div class="table-responsive">
				<table id="tables" data-url="<?=base_url('Indikator/get_tables')?>"
					class="table table-bordered table-striped" width="100%">
					<thead>
						<tr>
							<th>No</th>
							<th>JUDUL</th>
							<th>DEFINISI</th>
							<th>KRETERIA INKLUSI</th>
							<th>KRETERIA EKLUSI</th>
							<th>SUMBER</th>
							<th>TIPE INDIKATOR</th>
							<th>JENIS INDIKATOR</th>
							<th>AREA</th>
							<th>FREKUENSI</th>
							<th>STANDAR</th>
							<th>NILAI</th>
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
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Modal title</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="form_input" action="<?=base_url('Indikator/save')?>">
					<div class="box-body">
						<input type="hidden" class="form-control" id="metode" name="metode">
						<input type="hidden" class="form-control" id="id_indikator" name="id_indikator">
						<div class="form-group">
							<label for="judul">JUDUL INDIKATOR</label>
							<input type="text" class="form-control" id="judul" name="judul" placeholder="JUDUL">
						</div>
						<div class="form-group">
							<label for="deskripsi">DESKRIPSI</label>
							<textarea class="textarea" name="deskripsi" id="deskripsi"
								placeholder="Place some text here"
								style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
							<!-- <input type="text" class="form-control" id="deskripsi" name="deskripsi"
									placeholder="DESKRIPSI"> -->
						</div>
						<div class="form-group">
							<label for="eklusi">INKLUSI</label>
							<textarea class="textarea" name="inklusi" id="inklusi" placeholder="Place some text here"
								style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
						</div>
						<div class="form-group">
							<label for="eklusi">EKLUSI</label>
							<textarea class="textarea" name="eklusi" id="eklusi" placeholder="Place some text here"
								style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
						</div>
						<div class="form-group">
							<label for="sumber">SUMBER DATA</label>
							<input type="text" class="form-control" id="sumber" name="sumber" placeholder="SUMBER">
						</div>
						<div class="form-group">
							<label for="tipeindikator">KATEGORI INDIKATOR</label>
							<!-- <input type="text" class="form-control select2" id="tipeindikator" name="tipeindikator"
									placeholder="TIPE INDIKATOR"> -->

							<select name="kategoriindikator" id="kategoriindikator" class="form-control select2"
								required="required" data-placeholder="KATEGORI INDIKATOR" style="width: 100%;">
								<option value=""></option>
								<?php foreach ($kategori as $key => $value) {
											echo "<option value='$value->ID_JENIS_INDIKATOR'>$value->NM_JENIS_INDIKATOR</option>";
										}?>
								<!-- <option value=""></option> -->
							</select>

						</div>
						<div class="form-group">
							<label for="tipeindikator">TIPE INDIKATOR</label>
							<!-- <input type="text" class="form-control select2" id="tipeindikator" name="tipeindikator"
									placeholder="TIPE INDIKATOR"> -->

							<select name="tipeindikator" id="tipeindikator" class="form-control select2"
								required="required" data-placeholder="TIPE INDIKATOR" style="width: 100%;">
								<option value=""></option>
								<?php foreach ($tipeindikator as $key => $value) {
											echo "<option value='$value->ID_TIPE_INDIKATOR'>$value->NM_TIPE_INDIKATOR</option>";
										}?>
								<!-- <option value=""></option> -->
							</select>

						</div>
						<div class="form-group">
							<label for="area">AREA</label>
							<select class="form-control select2" multiple="multiple" name="area" id="area"
								style="width: 100%">

								<?php foreach ($area as $key => $value) {
											echo "<option value='$value->NM_AREA'>$value->NM_AREA</option>";
										}?>
								<!-- <option value=""></option> -->
							</select>
						</div>
						<div class="form-group">
							<label for="standar">STANDAR</label>
							<input type="text" class="form-control" id="standar" name="standar"
								placeholder="STANDAR INDIKATOR">
						</div>
						<div class="form-group">
							<label for="standar">NILAI TARGET</label>
							<input type="number" class="form-control" id="nilai_target" name="nilai_target"
								placeholder="NILAI TARGET INDIKATOR">
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
					<input type="hidden" class="form-control" id="id_indikator" name="id_indikator">
				</form>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
				<a href="#" onclick="delet()" class="btn btn-danger">Hapus</a>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-definsi">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Modal title</h4>
			</div>
			<div class="modal-body">

				<form action="" id="form_def" role="form">
					<input type="hidden" class="form-control" id="id_indikator" name="id_indikator">
					<div class="form-group">
						<label for="eklusi">DEFINSI INDIKATOR</label>
						<p class="form-control-static" id="dettail_definisi"></p>
					</div>
					<div class="form-group">
						<label for="eklusi">INKLUSI</label>
						<p class="form-control-static" id="detail_Inklusi"></p>
					</div>
					<div class="form-group">
						<label for="eklusi">EKLUSI</label>
						<p class="form-control-static" id="detail_eklusi"></p>
					</div>
				</form>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-variable">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Modal title</h4>
			</div>
			<div class="modal-body">

				<form id="form_variable" action="<?=base_url('Indikator/save_variable/')?>" role="form">
					<input type="hidden" class="form-control" id="id_indikator_n" name="id_indikator_n">
					<input type="hidden" class="form-control" id="id_indikator_d" name="id_indikator_d">
					<input type="hidden" class="form-control" id="id_variable_indikator_nemu"
						name="id_variable_indikator_nemu">
					<input type="hidden" class="form-control" id="id_variable_indikator_demu"
						name="id_variable_indikator_demu">
					<div class="form-group">
						<label for="eklusi">NUMERATOR</label>
						<div class="form-group">
							<input type="text" class="form-control" id="variable_name_nemulator"
								name="variable_name_nemulator" placeholder="VARIABLE NAME NEMULATOR">
						</div>
						<div class="form-group">
							<input type="text" class="form-control" id="satuan_nemulator" name="satuan_nemulator"
								placeholder="SATUAN NUMERATOR">
						</div>
					</div>
					<div class="form-group">
						<label for="eklusi">DENUMERATOR</label>
						<div class="form-group">
							<input type="text" class="form-control" id="variable_name_demulator"
								name="variable_name_demulator" placeholder="VARIABLE NAME DEMULATOR">
						</div>
						<div class="form-group">
							<input type="text" class="form-control" id="satuan_demulator" name="satuan_demulator"
								placeholder="SATUAN NUMERATOR">
						</div>
					</div>
				</form>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-info pull-right" onclick="save_variable()">Save</button>
			</div>
		</div>
	</div>
</div>
<!-- <link rel="stylesheet" href="<?=base_url('assets')?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"> -->
