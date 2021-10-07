<section class="content-header">
	<h1>
		Data 
		<small>unit</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Unit</li>
	</ol>
</section>
<section class="content">
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Data Unit</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
	
		<a class="btn btn-primary" href='#' onclick="add()">Tambah</a>

			<div class="table-responsive">
				<table id="unit_table" class="table table-bordered table-striped" width="100%">
					<thead>
						<tr>
							<th>KODE UNIT</th>
							<th>NAMA Unit</th>
							<th>KEPALA Unit</th>
							<th>NIP</th>
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
</div>


<div class="modal fade" id="modal-id">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Modal title</h4>
			</div>
			<div class="modal-body">
			<form class="form-horizontal" id="form_input">
              <div class="box-body">
			  <input type="hidden" class="form-control" id="metode" name="metode">
                <div class="form-group">
                  <label for="kodeUnit" class="col-sm-3 control-label">KODE UNIT</label>

                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="kodeUnit" name="kodeUnit" placeholder="KODE UNIT">
                  </div>
                </div>
                <div class="form-group">
                  <label for="namaUnit" class="col-sm-3 control-label">NAMA UNIT</label>

                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="namaUnit" name="namaUnit" placeholder="NAMA UNIT">
                  </div>
                </div>
				<div class="form-group">
                  <label for="kepalaUnit" class="col-sm-3 control-label">KEPALA UNIT</label>

                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="kepalaUnit" name="kepalaUnit" placeholder="KEPALA UNIT">
                  </div>
                </div>
				<div class="form-group">
                  <label for="nipKepala" class="col-sm-3 control-label">NIP KEPALA</label>

                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="nipKepala" name="nipKepala" placeholder="NIP KEPALA">
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

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
				<a href="#" id="hapus" class="btn btn-danger" >Hapus</a>
			</div>
		</div>
	</div>
</div>
