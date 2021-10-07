<?php

defined('BASEPATH') or exit('No direct script access allowed');

class laporan extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Model_app', 'Models');
    $this->load->model('Model_survei', 'Msurvei');
    if (empty($this->session->userdata('logged_mutu'))) {
      redirect(base_url('Login'), 'refresh');
    }
  }


  public function index()
  {
    $bln = $this->input->post('bulan');
    $thn = $this->input->post('tahun');
    $kd_unit = $this->input->post('kd_unit');
    // $indikator = $this->input->post('kd_indikator');

    if (empty($bln)) {
      $bln = date("n");
      $thn = date("Y");
    }
    $unit = $this->Models->get_data('MASTER_UNIT')->result();
    $indikator = $this->Models->get_data('MASTER_INDIKATOR')->result();
    $data = array(
      // 'content'   => 'Page/Laporan',
      'bln'           => $bln,
      'tahun'         => $thn,
      // 'script'    => 'Script/Laporan',
      'kd_unit'      => $kd_unit,
      'unit' => $unit,
      'indikator' => $indikator,
    );
    // $this->load->view('Theme', $data);
    if (isset($_POST['cetak_btn'])) {
      $data['content'] = 'Page/Laporan';
      $data['script'] = 'Script/Laporan';
      // $this->load->view('Cetak/laporan_bulanan', $data);
      $this->cetakIndikator();
    } else {
      $data['content'] = 'Page/Laporan';
      $data['script'] = 'Script/Laporan';
      $this->load->view('Theme', $data);
    }
  }

  public function getIndikatorById($KD_UNIT = '')
  {
    $searchTerm = $this->input->post('searchTerm');
    if ($KD_UNIT != '') {
      $query = "SELECT MASTER_INDIKATOR.ID_INDIKATOR, JUDUL_INDIKATOR from INDIKATOR_UNIT INNER JOIN MASTER_INDIKATOR ON INDIKATOR_UNIT.ID_INDIKATOR=MASTER_INDIKATOR.ID_INDIKATOR WHERE INDIKATOR_UNIT.KD_UNIT='$KD_UNIT' AND MASTER_INDIKATOR.JUDUL_INDIKATOR LIKE '%$searchTerm%' ORDER BY STANDAR ASC";
    }
    $output = array();
    $unit_indikator = $this->db->query($query)->result();
    foreach ($unit_indikator as $key => $value) {
      $data = array();
      $data['id'] = $value->ID_INDIKATOR;
      $data['text'] = $value->JUDUL_INDIKATOR;

      $output[] = $data;
    }
    echo json_encode($output);
  }
  public function rekap()
  {
    # code...
  }
  public function get_tables()
  {
    $bln = $this->input->post('bln');
    $thn = $this->input->post('thn');
    if (empty($bln)) {
      $bln = date("n");
    }
    if (empty($thn)) {
      $thn = date("Y");
    }
    // $kat= $this->input->post('kategori');
    $indikator = $this->input->post('kd_indikator');
    $kd_unit = $this->input->post('kd_unit');
    $no = 1;
    // $id_unit = $this->session->userdata('USERDATA')->KD_UNIT;
    if ($kd_unit != '') {
      $query = "SELECT JUDUL_INDIKATOR, A.ID_INDIKATOR FROM MASTER_INDIKATOR A, INDIKATOR_UNIT B
          WHERE A.ID_INDIKATOR=B.ID_INDIKATOR AND A.ID_INDIKATOR = '$indikator' AND B.KD_UNIT = '$kd_unit' ";
    } else {
      $query = "SELECT JUDUL_INDIKATOR, A.ID_INDIKATOR FROM MASTER_INDIKATOR A
            WHERE  A.ID_INDIKATOR = null ";
    }
    $output = $output1 = array();
    $get = $this->Models->query($query);
    foreach ($get->result() as $key => $value) {
      $data = array();
      $title = array();
      $data[] = $no++;
      $title['title'] = "Nama";
      $data[] = "<a href='#' onclick='detail($value->ID_INDIKATOR)'>$value->JUDUL_INDIKATOR</a>";
      $max =  cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
      for ($i = 1; $i <= $max; $i++) {
        $nquery = "SELECT SUM(V_DEMULATOR) AS DEMU, SUM(V_NEMULATOR) NEMU FROM RESULT_INDIKATOR WHERE ID_INDIKATOR = $value->ID_INDIKATOR
            AND DAY(INPUT_DATE) = '$i'
            AND MONTH(INPUT_DATE) = '$bln'
            AND YEAR(INPUT_DATE) = '$thn'
            and id_unit = '$kd_unit'
            GROUP BY ID_INDIKATOR";
        $get_Satuan = $this->Msurvei->getSatuanN($value->ID_INDIKATOR);
        if ($get_Satuan->num_rows() > 0) {
          $satuanGet = $get_Satuan->row();
          $satuan = $satuanGet->SATUAN;
        } else {
          $satuan = '%';
        }
        $check = $this->db->query($nquery);
        if ($check->num_rows() > 0) {
          $dt =  $check->row();
          $n = $dt->NEMU;
          $d = $dt->DEMU;
          if ($d <= 0) {
            $percent = 0;
          } else {
            if ($satuan === 'menit') {
              $percent = round(($n / $d), 2);
            } else {
              $percent = round(($n / $d) * 100, 2);
            }
          }
          $data[] = "<a href='#' onclick='All_data($indikator,$i,$kd_unit)'>$percent$satuan</a>";
        } else {
          $data[] = "<a href='#' onclick='All_data($indikator,$i,$kd_unit)'>0$satuan</a>";
        }
      }
      $output[] = $data;
      $output1[] = $title;
    }
    $table = array('data' => $output, 'columns' => $output1);
    echo json_encode($table);
  }
  function cetak()
  {
    $unit = $this->Models->get_data('MASTER_UNIT')->result();
    $data = array(
      'content'   => 'Page/CetakLaporan',
      'script'    => 'Script/Laporan',
      'unit'      => $unit,
      'tahun' => date('Y'),
    );
    $this->load->view('Theme', $data);
  }
  function cetakIndikator()
  {
    $bulan = $this->input->post('bulan');
    $tahun = $this->input->post('tahun');
    $kd_unit = $this->input->post('kd_unit');
    $kd_indikator = $this->input->post('kd_indikator');
    // $indikator = $this->Models->unitIndikator($kd_unit);
    $dtIndikator = $this->Models->get_dataId('master_indikator', 'id_indikator', $kd_indikator);

    $dtUnit = $this->Models->get_dataId('master_unit', 'kd_unit', $kd_unit);
    if ($dtUnit->num_rows() > 0) {
      $unit = $dtUnit->row();
      $unit_name = $unit->NM_UNIT;
    } else {
      $unit_name = 'not_found';
    }
    $output = array();
    $get = $this->Models->get_dataId('MASTER_INDIKATOR', 'ID_INDIKATOR', $kd_indikator);
    if ($get->num_rows() > 0) {
      $dt_indikator = $get->row();
    }
    $NEMU = 0;
    $DEMU = 0;
    if ($dt_indikator->NILAI_TARGET == null) {
      $target = 0;
    } else {
      $target = $dt_indikator->NILAI_TARGET;
    }
    $max =  cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
    for ($i = 1; $i <= $max; $i++) {
      $q = "SELECT SUM(V_NEMULATOR) AS V, SUM(V_DEMULATOR) AS D FROM RESULT_INDIKATOR WHERE
              ID_INDIKATOR = '$kd_indikator'
              AND ID_UNIT = '$kd_unit'
              AND DAY(INPUT_DATE) = '$i'
              AND MONTH(INPUT_DATE) = '$bulan'
              AND YEAR(INPUT_DATE) = '$tahun' ";
      $check = $this->db->query($q);
      $data['n'] = 'Tanggal ' . $i;
      $data['y'] = $i;
      $data['a'] = $target;
      if ($check->num_rows() > 0) {
        $dt =  $check->row();
        $NEMU = $dt->V;
        $DEMU = $dt->D;
      } else {
        $NEMU = 0;
        $DEMU = 0;
      }
      if ($DEMU > 0) {
        $data['b'] =  round(($NEMU / $DEMU) * 100, 2);
      } else {
        $data['b'] = 0;
      }
      $output[] = $data;
    }
    $data = array(
      'unit' => $this->input->post('kd_unit'),
      'bulan' => $this->input->post('bulan'),
      'tahun' => $this->input->post('tahun'),
      'indikatorresult' => $dtIndikator,
      'unit_name' => $unit_name,
      'cart' => json_encode($output),
    );
    $this->load->view('Cetak/laporanIndikator', $data);
  }

  public function cetakLaporan()
  {
    $this->load->library('Pdf');
    $kd_unit = $this->input->post('kd_unit');
    $indikator = $this->Models->unitIndikator($kd_unit);
    $dtUnit = $this->Models->get_dataId('master_unit', 'kd_unit', $kd_unit);
    if ($dtUnit->num_rows() > 0) {
      $unit = $dtUnit->row();
      $unit_name = $unit->NM_UNIT;
    } else {
      $unit_name = 'not_found';
    }
    $data = array(
      'unit' => $this->input->post('kd_unit'),
      'bulan' => $this->input->post('bulan'),
      'tahun' => $this->input->post('tahun'),
      'indikator' => $indikator,
      'unit_name' => $unit_name,
    );
    $this->load->view('Cetak/laporan_bulanan', $data);
    $html = $this->output->get_output();
    $this->dompdf->set_paper('A4', 'landscape');
    // $this->dompdf->setIsPhpEnabled(true);
    $this->dompdf->load_html($html);
    $this->dompdf->render();
    $this->dompdf->stream("Capaian Indikator $unit_name.pdf", array('Attachment' => 0));
  }
  public function cek()
  {
    echo $this->input->post('tahun');
  }
  public function Chart_unit()
  {
    $bulan = $this->input->post('bulan');
    $tahun = $this->input->post('tahun');
    $kd_unit = $this->input->post('kd_unit');
    $kd_indikator = $this->input->post('kd_indikator');
    $output = array();
    $get = $this->Models->get_dataId('MASTER_INDIKATOR', 'ID_INDIKATOR', $kd_indikator);
    if ($get->num_rows() > 0) {
      $dt_indikator = $get->row();
    }
    $NEMU = 0;
    $DEMU = 0;
    if ($dt_indikator->NILAI_TARGET == null) {
      $target = 0;
    } else {
      $target = $dt_indikator->NILAI_TARGET;
    }
    $max =  cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
    for ($i = 1; $i <= $max; $i++) {
      $q = "SELECT SUM(V_NEMULATOR) AS V, SUM(V_DEMULATOR) AS D FROM RESULT_INDIKATOR WHERE
              ID_INDIKATOR = '$kd_indikator'
              AND ID_UNIT = '$kd_unit'
              AND DAY(INPUT_DATE) = '$i'
              AND MONTH(INPUT_DATE) = '$bulan'
              AND YEAR(INPUT_DATE) = '$tahun' ";
      $check = $this->db->query($q);
      $data['n'] = 'Tanggal ' . $i;
      $data['y'] = $i;
      $data['a'] = $target;
      if ($check->num_rows() > 0) {
        $dt =  $check->row();
        $NEMU = $dt->V;
        $DEMU = $dt->D;
      } else {
        $NEMU = 0;
        $DEMU = 0;
      }
      if ($DEMU > 0) {
        $get_Satuan = $this->Msurvei->getSatuanN($kd_indikator);
        if ($get_Satuan->num_rows() > 0) {
          $satuanGet = $get_Satuan->row();
          $satuan = $satuanGet->SATUAN;
          if ($satuan === 'menit') {
            $data['b'] =  round(($NEMU / $DEMU), 2);
          } else {
            $data['b'] =  round(($NEMU / $DEMU) * 100, 2);
          }
        }
      } else {
        $data['b'] = 0;
      }
      $output[] = $data;
    }
    echo json_encode(array('data' => $output));
  }
  function getDataAll($id, $i)
  {
    $bulan = $this->input->post('bulan');
    $tahun = $this->input->post('tahun');
    $kd_unit = $this->input->post('kd_unit');
    $get_indikator = $this->Models->get_dataId('master_indikator', 'id_indikator', $id)->row();
    if ($kd_unit != '') {
      $q = $this->Models->query("SELECT sum(V_NEMULATOR) V_NEMULATOR, sum(V_DEMULATOR) V_DEMULATOR, ID_INDIKATOR 
          FROM RESULT_INDIKATOR WHERE ID_INDIKATOR = $id 
          AND DAY(INPUT_DATE) = '$i' 
          AND ID_UNIT = '$kd_unit' 
          AND MONTH(INPUT_DATE) = '$bulan' 
          AND YEAR(INPUT_DATE) = '$tahun'
          group by ID_INDIKATOR");
    } else {
      $q = $this->Models->query("SELECT sum(V_NEMULATOR) V_NEMULATOR, sum(V_DEMULATOR) V_DEMULATOR, ID_INDIKATOR 
          FROM RESULT_INDIKATOR WHERE ID_INDIKATOR = $id 
          AND DAY(INPUT_DATE) = '$i' 
          AND MONTH(INPUT_DATE) = '$bulan' 
          AND YEAR(INPUT_DATE) = '$tahun'
          group by ID_INDIKATOR");
    }

    if ($q->num_rows() > 0) {
      $data = $q->row();
    } else {
      $data = (object)  array('V_NEMULATOR' => 0, 'V_DEMULATOR' => 0);
    }
    $nemulator = $this->Models->query("SELECT * FROM MASTER_VARIABLE_INDIKATOR WHERE ID_INDIKATOR = $id AND type='N'");
    $demulator = $this->Models->query("SELECT * FROM MASTER_VARIABLE_INDIKATOR WHERE ID_INDIKATOR = $id AND type='D'");
    if ($nemulator->num_rows() > 0) {
      $nemu = $nemulator->row();
      $VARIABLE_NAME_nemu = $nemu->VARIABLE_NAME;
      $SATUAN_nemu = $nemu->SATUAN;
    } else {
      $VARIABLE_NAME_nemu = '<i>undifened</i>';
      $SATUAN_nemu = '<i>undifened</i>';
    }
    if ($demulator->num_rows() > 0) {
      $demu = $demulator->row();
      $VARIABLE_NAME_demu = $demu->VARIABLE_NAME;
      $SATUAN_demu = $demu->SATUAN;
    } else {
      $VARIABLE_NAME_demu = '<i>undifened</i>';
      $SATUAN_demu = '<i>undifened</i>';
    }

    $getData = array(
      "nemulator_variable" => $VARIABLE_NAME_nemu,
      "nemulator_satuan"   => $SATUAN_nemu,
      "demulator_variable" => $VARIABLE_NAME_demu,
      "demulator_satuan"   => $SATUAN_demu,
      "value_nemulator"   => $data->V_NEMULATOR,
      "value_demulator"   => $data->V_DEMULATOR,
      'judul_indikator' => $get_indikator->JUDUL_INDIKATOR,
    );

    echo json_encode($getData);
  }
}

/* End of file laporan.php */
