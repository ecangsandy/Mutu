<section class="content-header">
    <h1>
        Data Tables
        <small>data Imut</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Indikator Mutu</li>
    </ol>
</section>
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <!-- <h3 class="box-title">Different Width</h3> -->

        </div>
        <div class="box-body">
            <div class="container">
                <form action="<?= base_url('Survei/Survei_Progres/') ?>/" method="POST" role="form">
                    <!-- <input type="hidden" name="idKat" id="idKat" class="form-control" value=""> -->
                    <div class="form-row">
                        <div class="col-md-2 form-group">
                            <?php if (empty($bln)) {
                                $bln = date("n");
                            }
                            switch ($bln) {
                                case ($bln == 1 || $bln == 2 || $bln == 3):
                                    $select = 1;
                                    break;
                                case ($bln == 4 || $bln == 5 || $bln == 6):
                                    $select = 2;
                                    break;
                                case ($bln == 7 || $bln == 8 || $bln == 9):
                                    $select = 3;
                                    break;
                                case ($bln == 10 || $bln == 11 || $bln == 12):
                                    $select = 4;
                                    break;

                                default:
                                    $select = 0;
                                    break;
                            }
                            ?>
                            <select name="bulan" id="bulan" class="form-control selectwo">
                                <option value="" Selectes disabled>Pilih Bulan</option>
                                <option value="1" <?php if ($select == 1) echo "selected"; ?>>Triwulan I</option>
                                <option value="2" <?php if ($select == 2) echo "selected"; ?>>Triwulan II</option>
                                <option value="3" <?php if ($select == 3) echo "selected"; ?>>Triwulan III</option>
                                <option value="4" <?php if ($select == 4) echo "selected"; ?>>Triwulan IV</option>
                            </select>

                        </div>
                        <div class="col-md-2 form-group">

                            <select name="tahun" id="tahun" class="form-control selectwo">
                                <option value="" selected disabled>Pilih Tahun</option>
                                <?php
                                $start = 2018;
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
                        <div class="col-md-2 form-group">
                            <select name="layanan" id="layanan" class="form-control selectwo">
                                <option value="" selected disabled>Pilih Layanan</option>
                                <?php foreach ($layanan_group as $key => $value) {
                                    echo '<option value="' . $value->GROUP . '" ' . (($value->GROUP == 'IRI') ? 'selected="selected"' : "") . '>' . $value->GROUP . '</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <select name="jenis_indikator" id="jenis_indikator" class="form-control selectwo">
                                <option value="" selected disabled>Pilih Jenis</option>
                                <option value="_all"> Semua </option>
                                <?php foreach ($jenis as $key => $vals) {
                                    echo '<option value="' . $vals->ID_JENIS_INDIKATOR . '" >' . $vals->NM_JENIS_INDIKATOR . '</option>';
                                } ?>
                            </select>
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <select name="indikator" id="indikator_filter" class="form-control">
                                <option value="" selected disabled>Pilih Indikator</option>
                                <?php foreach ($indikator as $key => $value) {
                                    echo '<option value="' . $value->ID_INDIKATOR . '">' . $value->JUDUL_INDIKATOR . '</option>';
                                } ?>
                            </select>
                        </div>

                        <div class="col-md-1">

                            <button type="button" id="filter" class="btn btn-primary">Cari</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Data Indikator </h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

            <div class="table-responsive">
                <table title="Reports using TreeGrid" class="easyui-tree" id="triwulan_table" style="width:100%;height:450px">
                    <thead frozen="true">
                        <tr>
                            <th field="region" width="200">Nama</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <?php $max =  31 ?>
                            <th field="f0" width="80" align="right"> Bulan</th>
                            <th field="f1" width="80" align="right"> Bulan</th>
                            <th field="f2" width="80" align="right"> Bulan</th>
                            <!-- <?php for ($i = 1; $i <= $max; $i++) {
                                        echo '<th field="f' . $i . '" width="60" align="right">' . $i . '</th>';
                                    } ?> -->

                        </tr>
                    </thead>
                </table>

            </div>
            <!-- /.box-body -->
        </div>
</section>
<div id="dd" class="easyui-dialog" title="My Dialog" style="width:400px;height:200px;padding:10px" closed="true" buttons="#dlg-buttons">
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