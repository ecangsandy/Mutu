<section class="content-header">
	<h1>
		Data Tables
		<small>nilai target indikator</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Target</li>
	</ol>
</section>
<section class="content">
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Nilai Target Indikator</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
		<a class="btn btn-primary" href='#' onclick="add()">Tambah</a>
			<div class="table-responsive">
				<table id="tables" data-url="<?=base_url('Target/get_tables')?>" class="table table-bordered table-striped" width="100%">
					<thead>
						<tr>
							<th>No</th>
							<th>INDIKATOR</th>
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
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Modal title</h4>
			</div>
			<div class="modal-body">
			<form class="form-horizontal" id="form_input" action="<?=base_url('Target/save')?>">
              <div class="box-body">
			  <input type="hidden" class="form-control" id="metode" name="metode">
			  <input type="hidden" class="form-control" id="id_target" name="id_target">
        <div class="form-group has-feedback">
            <label for="indikator" class="col-sm-3 control-label">INDIKATOR</label>

          <div class="col-sm-9">
          <select name="id_indikator" id="id_indikator" class="form-control select2" style="width: 100%;">
              <option value="">PILIH INDIKATOR </option>
                    <?php foreach ($unit as $key => $value) {
                    echo '<option value="'.$value->ID_INDIKATOR.'">'.$value->NM_.'</option>';
                  } ?>

          </select>
          </div>
        </div>
                <div class="form-group">
                  <label for="jenis" class="col-sm-3 control-label">Nilai</label>

                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="nilai_target" name="nilai_target" placeholder="NILAI INDIKATOR">
                  </div>
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
			<!-- <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div> -->
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
				<a href="#" onclick="delet()" class="btn btn-danger" >Hapus</a>
			</div>
		</div>
	</div>
</div>
