<!doctype html>

<html lang="en">

<head>

	<meta charset="UTF-8">

	<title>LAPORAN INDIKATOR MUTU</title>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script>
    window.print();
    </script>
	<style type="text/css">
		* {

			font-family: Verdana, Arial, sans-serif;

			font-size: 15px;

		}

		@page {

			margin-top: 75px;

			margin-left: 75px;

			margin-right: 75px;

			/*size: landscape*/

		}

		tr.noBorder td {

			border: 0px;

		}

		table {

			border-collapse: collapse;

			width: 100%;

		}
		table td{
			font-size: 14px;
		}

		/* table th {

			border: 1px solid #000;

			padding: 3px;

			font-weight: bold;

			text-align: left;

		}

		table td {

			border: 1px solid #000;

			padding: 3px;

			vertical-align: top;

		} */
		.img-logo {
			position: absolute;
			float: left;
		}

	</style>



</head>

<body>

	<div>

		<!-- <img width="60px" src="<?php echo $_SERVER['DOCUMENT_ROOT'].'/Mutu/assets/dist/img/logo-big.png'?>"
			class="img-logo"> -->

		<div align="center">
			<p>WORKSHEET</p>
			<p>INDIKATOR MUTU PRIORITAS AREA KLINIS </p>
			<p>RSUD DOKTER SOESELO SLAWI KABUPATEN TEGAL </p>
		</div>

		<table border="0" width="20%">
			<tr>
				<td width="80">UNIT</td>
				<td>: <strong><?=$unit_name?></strong> </td>
			</tr>
			<tr>
				<td width="80">Bulan</td>
				<td>: <?=bulan($bulan)?></td>
			</tr>
		</table>
		<br>
		<table border="1" width="100%">
			<?php 
        // $bln = date('m');
        // $tahun = date('Y');
        $max =  cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun) ?>
			<thead align="center" valign="middle">

				<tr>

					<td rowspan="2"> No</td>

					<td rowspan="2"> Judul Indikator</td>

					<!-- <td> Numerator</td> -->
					<td colspan="<?=$max?>"> Tanggal</td>
					<td rowspan="2"> Rata-Rata</td>
					<td rowspan="2"> Analisa</td>

				</tr>

				<tr>
					<?php for ($i=1; $i <= $max ; $i++) {
            echo "<td> $i </td>";
        }?>

				</tr>
				</thead>
			<tbody>
			<?php if ($indikatorresult->num_rows() > 0) : $no=1;?>
				<?php foreach($indikatorresult->result() as $key => $val): ?>
				<tr>
					<td align="center"><?=$no++?></td>
					<td><?=$val->JUDUL_INDIKATOR?></td>
					<?php 
					$sum = $sd = $sn = 0;
					for ($i=1; $i <= $max ; $i++) {
						$q = "SELECT SUM(V_NEMULATOR) AS V, SUM(V_DEMULATOR) AS D FROM RESULT_INDIKATOR WHERE
						ID_INDIKATOR = '$val->ID_INDIKATOR'
						AND ID_UNIT = '$unit'
						AND DAY(INPUT_DATE) = '$i'
						AND MONTH(INPUT_DATE) = '$bulan'
						AND YEAR(INPUT_DATE) = '$tahun' ";
						$check = $this->db->query($q);
						$get_Satuan = $this->Msurvei->getSatuanN($val->ID_INDIKATOR);
						if ($get_Satuan->num_rows() > 0) {
							$satuanGet = $get_Satuan->row();
							$satuan = $satuanGet->SATUAN;
						}
						else {
							$satuan = '%';
						}
						if($check->num_rows() > 0 ) {
							$dt =  $check->row();
							$sn += $NEMU = $dt->V;
							$sd += $DEMU = $dt->D;
						}
						else {
							$sn += $NEMU = 0;
							$sd += $DEMU =0;
						}
						if ($DEMU > 0) {
							if ($satuan ==='menit') {
								$hasil = round(($NEMU/$DEMU),2);
							}else{
								$hasil = round(($NEMU/$DEMU)*100,2);
							}
							// $hasil =  round(($NEMU/$DEMU)*100,2);
							$sum += $hasil;
						}else {
							$hasil = 0;
							$sum += $hasil;
						}
						echo "<td align='center'> $hasil$satuan </td>";
					}
					if ($satuan ==='menit') {
						$rata = round(($sn/$sd),2);
					}else{
						$rata = round(($sn/$sd)*100,2);
					}
					// $rata = $sum/$max;
					?>
					<td align='center'> <?=round($rata,2)?></td>
					<td> </td>
				</tr>
				<?php endforeach ?>
				<?php else:?><tr>
				<td colspan=""></td>
				</tr>
				<?php endif ?>
			</tbody>
		</table>
        <br>
		<div id="myfirstchart" style="height: 250px;"></div>
	</div>

</body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script>
$(document).ready(function () {
    var Unit_option = {
    element: 'myfirstchart',
    resize: true,
    data: <?=$cart?>,
    xkey: 'y',
    ykeys: ['a', 'b'],
    labels: ['Target', 'Hasil'],
    lineColors: ['#f9bc06', '#3c8dbc'],
    xlablels : 'day',
    hideHover: 'auto',
    parseTime:false,
    fillOpacity: 0.6,
    hideHover: 'auto',
    behaveLikeLine: true,
    pointFillColors:['#ffffff'],
    pointStrokeColors: ['black'],
    hoverCallback: function (index, options, content, row) {
      return  row.n+"<br> Target:" + row.a + "<br>Hasil: " + row.b;
    },
  }
  var Unit_chart = Morris.Area(Unit_option);
});

</script>

</html>
