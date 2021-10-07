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
                            } ?>
                            <select name="bulan" id="bulan" class="form-control selectwo">
                                <option value="" Selectes disabled>Pilih Bulan</option>
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
                <table title="Reports using TreeGrid" class="easyui-tree" id="dg" style="width:100%;height:450px">
                    <thead frozen="true">
                        <tr>
                            <th field="region" width="200">Nama</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <?php $max =  31 ?>

                            <?php for ($i = 1; $i <= $max; $i++) {
                                echo '<th field="f' . $i . '" width="60" align="right">' . $i . '</th>';
                            } ?>
                            <th field="total">Total</th>

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