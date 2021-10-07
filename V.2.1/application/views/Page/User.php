<section class="content-header">
	<h1>
		Data
		<small>user</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Users</li>
	</ol>
</section>
<section class="content">
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Data User</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
		<a class="btn btn-primary" href='#' onclick="add()">Tambah</a>
			<div class="table-responsive">
				<table id="tables" data-url="<?=base_url('User/get_tables')?>" class="table table-bordered table-striped" width="100%">
					<thead>
						<tr>
							<th>No</th>
							<th>NAMA LENGKAP</th>
              <th>USERNAME</th>
              <th>UNIT</th>
              <th>HAK AKSES</th>
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
			<form class="form-horizontal" id="form_input" action="<?=base_url('User/save')?>">
              <div class="box-body">
			  <input type="hidden" class="form-control" id="metode" name="metode">
        <input type="hidden" name="id_user" id="id_user" value="">

                <div class="form-group">
                  <label for="jenis" class="col-sm-3 control-label">FULL NAME</label>

                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="full_name" name="full_name" placeholder="FULL NAME">
                  </div>
                </div>
                <div class="form-group">
                  <label for="jenis" class="col-sm-3 control-label">USERNAME</label>

                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="username" name="username" placeholder="USERNAME">
                  </div>
                </div>
                <div class="form-group">
                  <label for="jenis" class="col-sm-3 control-label">PASSWORD</label>

                  <div class="col-sm-9">
                    <input type="password" class="form-control" id="password" name="password" placeholder="PASSWORD">
                  </div>
                </div>
                <div class="form-group has-feedback">
                    <label for="jenis" class="col-sm-3 control-label">UNIT</label>

                  <div class="col-sm-9">
                  <select name="kd_unit" id="kd_unit" class="form-control select2" style="width: 100%;">
                      <option value="">PILIH UNIT </option>
                            <?php foreach ($unit as $key => $value) {
                            echo '<option value="'.$value->KD_UNIT.'">'.$value->NM_UNIT.'</option>';
                          } ?>

                  </select>
                  </div>
                </div>
                <div class="form-group has-feedback">
                    <label for="jenis" class="col-sm-3 control-label">AKSES</label>

                  <div class="col-sm-9">
                  <select name="status" id="status" class="form-control select2" style="width: 100%;">
                        <option value="">PILIH AKSES </option>
                        <option value="Super Admin">Super Admin</option>
                        <option value="User">User </option>

                  </select>
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
                <input type="hidden" class="form-control" id="idJenisIndikator" name="idJenisIndikator">
                </form>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
				<a href="#" onclick="delet()" class="btn btn-danger" >Hapus</a>
			</div>
		</div>
	</div>
</div>
