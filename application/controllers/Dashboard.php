<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    if (empty($this->session->userdata('logged_mutu'))) {
      redirect(base_url('Login'), 'refresh');
    }
    $this->load->model('Model_app', 'Models');
    $this->load->model('Model_survei', 'Msurvei');
  }
  public function index()
  {
    $data['unit']      = count($this->db->get('MASTER_UNIT')->result());
    $data['indikator'] = count($this->db->get('MASTER_INDIKATOR')->result());
    $data['area']      = count($this->db->get('MASTER_AREA')->result());
    $data['content']   = 'Page/Dashboard';
    if ($this->session->userdata('STATUS') === 'Super Admin') {
      $data['script']    = 'Script/Dashboard';
    } else {
      $data['script']    = 'Script/Dashboard_unit';
    }
    $this->load->view('Theme', $data);
  }
  function get_cart_survei1($id_kategori = '')
  {
    $post_bln = $this->input->post('bulan');
    $out = array();
    $day = date('n');
    if ($post_bln != '') {
      $Month = $post_bln;
    } else {
      $Month = date('m');
    }
    $Year = date('Y');
    $indikator =  $this->db->query(
      "getIndikatorChart '" . $id_kategori . "'"
    )->result();
    $no = 1;
    foreach ($indikator as $key => $val) {
      $ind = $this->Models->get_dataId('master_indikator', 'id_indikator', $val->ind)->row();
      // $ind = $this->db->join('indikator_unit', 'indikator_unit.id_indikator=master_indikator.id_indikator', 'right')->where('master_indikator.id_indikator', $val->ind)->get('master_indikator')->row();
      $data = $this->db->select_sum('V_DEMULATOR', 'DEMU')->select_sum('V_NEMULATOR', 'NEMU')->where('ID_INDIKATOR', $val->ind)->group_by('INPUT_DATE')->get('RESULT_INDIKATOR')->row();
      $max =  cal_days_in_month(CAL_GREGORIAN, $Month, $Year);
      $NEMU = 0;
      $DEMU = 0;
      $out1 = array();
      $out1['y'] = $no++;
      $out1['n'] = $ind->JUDUL_INDIKATOR;
      $out1['a'] = $val->target;
      if (isset($val->SATUAN)) {
        $satuan = $val->SATUAN;
      } else {
        $satuan = '%';
      }
      // $get_Satuan = $this->Msurvei->getSatuanN($val->ind);
      // if ($get_Satuan->num_rows() > 0) {
      //   if ($get_Satuan->num_rows() > 0) {
      //     $satuanGet = $get_Satuan->row();
      //     $satuan = $satuanGet->SATUAN;
      //   } else {
      //     $satuan = '%';
      //   }
      // }
      for ($i = 1; $i <= $max; $i++) {
        $q = "SELECT SUM(V_NEMULATOR) AS V, SUM(V_DEMULATOR) AS D FROM RESULT_INDIKATOR WHERE
              ID_INDIKATOR = '$val->ind'
              AND DAY(INPUT_DATE) = '$i'
              AND MONTH(INPUT_DATE) = '$Month'
              AND YEAR(INPUT_DATE) = '$Year' ";
        $check = $this->db->query($q);
        if ($check->num_rows() > 0) {
          $dt =  $check->row();
          $NEMU += $dt->V;
          $DEMU += $dt->D;
        } else {
          $NEMU = 0;
          $DEMU = 0;
        }
      }
      // echo $val->JUDUL_INDIKATOR.$val->ID_INDIKATOR.'<br>';
      if ($DEMU > 0) {
        if ($satuan === 'menit') {
          $out1['b'] =  round(($NEMU / $DEMU), 2);
        } else {
          $out1['b'] =  round(($NEMU / $DEMU) * 100, 2);
        }
      } else {
        $out1['b'] = 0;
      }

      // $data[] = 1;

      $out[] = $out1;
    }
    // return $out;
    echo json_encode(array('data' => $out));
  }
  public function get_cart_survei($id_kategori = '')
  {
    $out = array();
    $tahun = (int)date('Y');
    $post_bln = $this->input->post('bulan');
    $post_tahun = $this->input->post('tahun');
    if (isset($post_tahun)) {
      $tahun = $post_tahun;
    }
    if ($post_bln != '') {
      $Month = $post_bln;
    } else {
      $Month = date('m');
    }
    $indikator =  $this->db
      ->select('SUM( V_DEMULATOR ) demu,SUM( V_NEMULATOR ) nemu, RESULT_INDIKATOR.ID_INDIKATOR, NILAI_TARGET')
      ->join('MASTER_INDIKATOR', 'RESULT_INDIKATOR.ID_INDIKATOR = MASTER_INDIKATOR.ID_INDIKATOR', 'LEFT')
      ->join('MASTER_VARIABLE_INDIKATOR', 'MASTER_VARIABLE_INDIKATOR.ID_INDIKATOR = MASTER_INDIKATOR.ID_INDIKATOR', 'LEFT')
      ->where(array(
        'MASTER_INDIKATOR.ID_JENIS_INDIKATOR' => $id_kategori,
        'MONTH(INPUT_DATE)' => $Month,
        'YEAR(INPUT_DATE)' => $tahun,
        'TYPE' => 'D',
        'SATUAN' => '%'
      ))
      ->group_by('RESULT_INDIKATOR.ID_INDIKATOR, NILAI_TARGET')
      ->get('RESULT_INDIKATOR');
    $no = 1;
    foreach ($indikator->result() as $key => $val) {
      $out1 = array();
      $ind = $this->Models->get_dataId('MASTER_INDIKATOR', 'ID_INDIKATOR', $val->ID_INDIKATOR)->row();
      $out1['y'] = $no++;
      $out1['n'] = $ind->JUDUL_INDIKATOR;
      $out1['a'] = $val->NILAI_TARGET;
      if ($val->demu > 0) {
        $out1['b'] =  round(($val->nemu / $val->demu) * 100, 2);
      } else {
        $out1['b'] = 0;
      }

      $out[] = $out1;
    }
    echo json_encode(array('data' => $out));
  }
  // Unit Capaian
  public function Chart_unit1()
  {
    $post_bln = $this->input->post('bulan');
    $kd_unit = $this->input->post('kd_unit');
    if ($post_bln != '') {
      $Month = $post_bln;
    } else {
      $Month = date('m');
    }
    $Year = date('Y');
    $output = array();
    if ($kd_unit == '') {
      $id_unit = $this->session->userdata('USERDATA')->KD_UNIT;
    } else {
      $id_unit = $kd_unit;
    }

    $indikator = $this->Models->get_dataId('INDIKATOR_UNIT', 'KD_UNIT', $id_unit)->result();
    $no = 1;
    foreach ($indikator as $key => $val) {
      $data = array();
      $get = $this->Models->get_dataId('MASTER_INDIKATOR', 'ID_INDIKATOR', $val->ID_INDIKATOR);
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
      $data['y'] = $id_unit;
      $data['n'] = $dt_indikator->JUDUL_INDIKATOR;
      $data['a'] = $target;
      $max =  cal_days_in_month(CAL_GREGORIAN, $Month, $Year);
      for ($i = 1; $i <= $max; $i++) {
        $q = "SELECT SUM(V_NEMULATOR) AS V, SUM(V_DEMULATOR) AS D FROM RESULT_INDIKATOR WHERE
              ID_INDIKATOR = '$val->ID_INDIKATOR'
              AND ID_UNIT = '$id_unit'
              AND DAY(INPUT_DATE) = '$i'
              AND MONTH(INPUT_DATE) = '$Month'
              AND YEAR(INPUT_DATE) = '$Year' ";
        $check = $this->db->query($q);
        if ($check->num_rows() > 0) {
          $dt =  $check->row();
          $NEMU += $dt->V;
          $DEMU += $dt->D;
        } else {
          $NEMU = 0;
          $DEMU = 0;
        }
        if ($DEMU > 0) {
          $get_Satuan = $this->Msurvei->getSatuanN($val->ID_INDIKATOR);
          if ($get_Satuan->num_rows() > 0) {
            $data['b'] =  round(($NEMU / $DEMU), 2);
          } else {
            $data['b'] =  round(($NEMU / $DEMU) * 100, 2);
          }
          // $data['b'] =  round(($NEMU/$DEMU)*100,2);
        } else {
          $data['b'] = 0;
        }
      }

      $output[] = $data;
    }
    echo json_encode(array('data' => $output));
  }
  public function Chart_unit()
  {
    $post_bln = $this->input->post('bulan');
    $kd_unit = $this->input->post('kd_unit');
    if ($post_bln != '') {
      $Month = $post_bln;
    } else {
      $Month = date('m');
    }
    $Year = date('Y');
    $output = array();
    if ($kd_unit == '') {
      $id_unit = $this->session->userdata('USERDATA')->KD_UNIT;
    } else {
      $id_unit = $kd_unit;
    }
    $indikator = $this->db
      ->select('SUM( V_DEMULATOR ) demu,SUM( V_NEMULATOR ) nemu, RESULT_INDIKATOR.ID_INDIKATOR')
      ->join('INDIKATOR_UNIT', 'RESULT_INDIKATOR.ID_INDIKATOR = INDIKATOR_UNIT.ID_INDIKATOR', 'LEFT')
      ->join('MASTER_VARIABLE_INDIKATOR', 'MASTER_VARIABLE_INDIKATOR.ID_INDIKATOR = INDIKATOR_UNIT.ID_INDIKATOR', 'LEFT')
      ->where(array(
        'INDIKATOR_UNIT.KD_UNIT' => $id_unit,
        'MONTH(INPUT_DATE)' => $Month,
        'YEAR(INPUT_DATE)' => $Year,
        'TYPE' => 'D',
        'SATUAN' => '%'
      ))
      ->group_by('RESULT_INDIKATOR.ID_INDIKATOR')
      ->get('RESULT_INDIKATOR');
    // $indikator = $this->Models->get_dataId('INDIKATOR_UNIT', 'KD_UNIT', $id_unit)->result();
    $no = 1;
    foreach ($indikator->result() as $key => $val) {
      $data = array();
      $get = $this->Models->get_dataId('MASTER_INDIKATOR', 'ID_INDIKATOR', $val->ID_INDIKATOR);
      if ($get->num_rows() > 0) {
        $dt_indikator = $get->row();
      }
      // $NEMU = 0;
      // $DEMU = 0;
      // if ($dt_indikator->NILAI_TARGET == null) {
      //   $target = 0;
      // } else {
      //   $target = $dt_indikator->NILAI_TARGET;
      // }
      $data['y'] = $val->ID_INDIKATOR;
      $data['n'] = $dt_indikator->JUDUL_INDIKATOR;
      $data['a'] = $dt_indikator->NILAI_TARGET;
      if ($val->demu > 0) {
        $data['b'] =  round(($val->nemu / $val->demu) * 100, 2);
      } else {
        $data['b'] = 0;
      }
      // $max =  cal_days_in_month(CAL_GREGORIAN, $Month, $Year);
      // for ($i = 1; $i <= $max; $i++) {
      // $q = "SELECT SUM(V_NEMULATOR) AS V, SUM(V_DEMULATOR) AS D FROM RESULT_INDIKATOR WHERE
      //       ID_INDIKATOR = '$val->ID_INDIKATOR'
      //       AND ID_UNIT = '$id_unit'
      //       AND DAY(INPUT_DATE) = '$i'
      //       AND MONTH(INPUT_DATE) = '$Month'
      //       AND YEAR(INPUT_DATE) = '$Year' ";
      // $check = $this->db->query($q);
      // if ($check->num_rows() > 0) {
      //   $dt =  $check->row();
      //   $NEMU += $dt->V;
      //   $DEMU += $dt->D;
      // } else {
      //   $NEMU = 0;
      //   $DEMU = 0;
      // }
      // if ($DEMU > 0) {
      //   $get_Satuan = $this->Msurvei->getSatuanN($val->ID_INDIKATOR);
      //   if ($get_Satuan->num_rows() > 0) {
      //     $data['b'] =  round(($NEMU / $DEMU), 2);
      //   } else {
      //     $data['b'] =  round(($NEMU / $DEMU) * 100, 2);
      //   }
      //   // $data['b'] =  round(($NEMU/$DEMU)*100,2);
      // } else {
      // $data['b'] = 0;
      // }
      // }

      $output[] = $data;
    }
    echo json_encode(array('data' => $output));
  }
}

/* End of file Dashboard.php */
