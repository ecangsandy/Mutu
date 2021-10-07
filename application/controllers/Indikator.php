<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Indikator extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Model_app', 'Models');
    if (empty($this->session->userdata('logged_mutu'))) {
      redirect(base_url('Login'), 'refresh');
    }
  }

  public function index()
  {
    $area      = $this->Models->get_data('MASTER_AREA')->result();
    $kategori = $this->Models->get_data('MASTER_JENIS_INDIKATOR')->result();
    $tipe      = $this->Models->get_data('MASTER_TIPE_INDIKATOR')->result();
    $data = array(
      'content'       => 'Page/Indikator',
      'script'        => 'Script/Indikator',
      'tipeindikator' => $tipe,
      'kategori'      => $kategori,
      'area'          => $area,
    );
    $this->load->view('Theme', $data);
  }

  public function get_tables($ID_JENIS_INDIKATOR = '')
  {
    $KD_UNIT = $this->session->userdata('USERDATA')->KD_UNIT;
    $no = 1;
    if ($this->session->userdata('STATUS') == 'Super Admin') {
      if ($ID_JENIS_INDIKATOR == '') {
        $query = "SELECT ID_INDIKATOR, JUDUL_INDIKATOR, DEFINISI_INDIKATOR, SUMBER, KT_INKLUSI, KT_EKLUSI, NM_TIPE_INDIKATOR,NM_JENIS_INDIKATOR, AREA, FREKUENSI, STANDAR, NILAI_TARGET
  		FROM MASTER_INDIKATOR INNER JOIN MASTER_TIPE_INDIKATOR
  		ON MASTER_INDIKATOR.TP_INDIKATOR=MASTER_TIPE_INDIKATOR.ID_TIPE_INDIKATOR INNER JOIN MASTER_JENIS_INDIKATOR
  		ON MASTER_INDIKATOR.ID_JENIS_INDIKATOR=MASTER_JENIS_INDIKATOR.ID_JENIS_INDIKATOR ORDER BY ID_INDIKATOR ASC";
      } else {
        $query = "SELECT ID_INDIKATOR, JUDUL_INDIKATOR, DEFINISI_INDIKATOR, SUMBER, KT_INKLUSI, KT_EKLUSI, NM_TIPE_INDIKATOR,NM_JENIS_INDIKATOR, AREA, FREKUENSI, STANDAR, NILAI_TARGET
      FROM MASTER_INDIKATOR INNER JOIN MASTER_TIPE_INDIKATOR
      ON MASTER_INDIKATOR.TP_INDIKATOR=MASTER_TIPE_INDIKATOR.ID_TIPE_INDIKATOR INNER JOIN MASTER_JENIS_INDIKATOR
      ON MASTER_INDIKATOR.ID_JENIS_INDIKATOR=MASTER_JENIS_INDIKATOR.ID_JENIS_INDIKATOR WHERE MASTER_JENIS_INDIKATOR.ID_JENIS_INDIKATOR=$ID_JENIS_INDIKATOR ORDER BY ID_INDIKATOR ASC";
      }
    } else {
      if ($ID_JENIS_INDIKATOR == '') {
        $query = "SELECT MASTER_INDIKATOR.ID_INDIKATOR, JUDUL_INDIKATOR, DEFINISI_INDIKATOR, SUMBER, KT_INKLUSI, KT_EKLUSI, NM_TIPE_INDIKATOR,NM_JENIS_INDIKATOR, AREA, FREKUENSI, STANDAR, NILAI_TARGET
      FROM MASTER_INDIKATOR INNER JOIN MASTER_TIPE_INDIKATOR
      ON MASTER_INDIKATOR.TP_INDIKATOR=MASTER_TIPE_INDIKATOR.ID_TIPE_INDIKATOR INNER JOIN MASTER_JENIS_INDIKATOR
      ON MASTER_INDIKATOR.ID_JENIS_INDIKATOR=MASTER_JENIS_INDIKATOR.ID_JENIS_INDIKATOR INNER JOIN INDIKATOR_UNIT
      ON MASTER_INDIKATOR.ID_INDIKATOR=INDIKATOR_UNIT.ID_INDIKATOR WHERE INDIKATOR_UNIT.KD_UNIT=$KD_UNIT ORDER BY MASTER_INDIKATOR.ID_INDIKATOR ASC";
      } else {
        $query = "SELECT MASTER_INDIKATOR.ID_INDIKATOR, JUDUL_INDIKATOR, DEFINISI_INDIKATOR, SUMBER, KT_INKLUSI, KT_EKLUSI, NM_TIPE_INDIKATOR,NM_JENIS_INDIKATOR, AREA, FREKUENSI, STANDAR, NILAI_TARGET
      FROM MASTER_INDIKATOR INNER JOIN MASTER_TIPE_INDIKATOR
      ON MASTER_INDIKATOR.TP_INDIKATOR=MASTER_TIPE_INDIKATOR.ID_TIPE_INDIKATOR INNER JOIN MASTER_JENIS_INDIKATOR
      ON MASTER_INDIKATOR.ID_JENIS_INDIKATOR=MASTER_JENIS_INDIKATOR.ID_JENIS_INDIKATOR INNER JOIN INDIKATOR_UNIT
      ON MASTER_INDIKATOR.ID_INDIKATOR=INDIKATOR_UNIT.ID_INDIKATOR WHERE MASTER_JENIS_INDIKATOR.ID_JENIS_INDIKATOR=$ID_JENIS_INDIKATOR AND INDIKATOR_UNIT.KD_UNIT=$KD_UNIT ORDER BY MASTER_INDIKATOR.ID_INDIKATOR ASC";
      }
    }



    $output = array();

    $get = $this->Models->query($query);
    foreach ($get->result() as $key => $value) {
      $data = array();
      $data[] = $no++;
      $data[] = $value->JUDUL_INDIKATOR;
      $data[] = $this->limit_words(($value->DEFINISI_INDIKATOR), 10);
      $data[] = $this->limit_words(($value->KT_INKLUSI), 10);
      $data[] = $this->limit_words(($value->KT_EKLUSI), 10);
      $data[] = $value->SUMBER;
      $data[] = $value->NM_TIPE_INDIKATOR;
      $data[] = $value->NM_JENIS_INDIKATOR;
      $data[] = $value->AREA;
      $data[] = $value->FREKUENSI;
      $data[] = $value->STANDAR;
      $data[] = $value->NILAI_TARGET;
      if ($this->session->userdata('STATUS') == 'Super Admin') {
        $data[] = '<a href="javascript:void(0)" class="btn btn-primary btn-xs" id="edit" data-url="' . base_url('Indikator/getData/' . $value->ID_INDIKATOR) . '" ><i class="fa fa-pencil"></i> Edit</a>
           <a href="javascript:void(0)" class="btn btn-danger btn-xs" id="delBtn" data-url="' . base_url('Indikator/delData/' . $value->ID_INDIKATOR) . '" ><i class="fa fa-trash"></i> Hapus</a>
            <a href="javascript:void(0)" class="btn btn-success btn-xs" id="viewDef" data-url="' . base_url('Indikator/getDef/' . $value->ID_INDIKATOR) . '" ><i class="fa fa-eye"></i> Detail</a>
            <a href="javascript:void(0)" class="btn btn-warning btn-xs" id="isi_variable" data-url="' . base_url('Indikator/getVariable/' . $value->ID_INDIKATOR) . '" onclick="variable(' . $value->ID_INDIKATOR . ')"><i class="fa fa-eye"></i> Isi Variable</a>';
      } else {
        $data[] = '<a href="javascript:void(0)" class="btn btn-success btn-xs" id="viewDef" data-url="' . base_url('Indikator/getDef/' . $value->ID_INDIKATOR) . '" ><i class="fa fa-eye"></i> Detail</a>';
      }

      $output[] = $data;
    }
    echo json_encode(array('data' => $output));
  }



  public function getData($id)
  {
    $data = $this->Models->get_dataJoinIndkatorJnsTp('MASTER_INDIKATOR', 'ID_INDIKATOR', $id)->row();

    $getData = array(
      "id_indikator"   => $data->ID_INDIKATOR,
      "judul"   => $data->JUDUL_INDIKATOR,
      'deskripsi' => $data->DEFINISI_INDIKATOR,
      'inklusi'  => $data->KT_INKLUSI,
      "eklusi"   => $data->KT_EKLUSI,
      "sumber"   => $data->SUMBER,
      'kategoriindikator' => $data->ID_JENIS_INDIKATOR,
      'tipeindikator'  => $data->ID_TIPE_INDIKATOR,
      "area"   => $data->AREA,
      'standar' => $data->STANDAR,
      'nilai_target' => $data->NILAI_TARGET,

    );

    echo json_encode($getData);
  }
  public function getVariable($id)
  {
    $nemulator = $this->Models->query("SELECT * FROM MASTER_VARIABLE_INDIKATOR WHERE ID_INDIKATOR = $id AND type='N'");
    $demulator = $this->Models->query("SELECT * FROM MASTER_VARIABLE_INDIKATOR WHERE ID_INDIKATOR = $id AND type='D'");
    if ($nemulator->num_rows() > 0) {
      $nemu = $nemulator->row();
      $VARIABLE_NAME_nemu = $nemu->VARIABLE_NAME;
      $ID_INDIKATOR_nemu = $nemu->ID_INDIKATOR;
      $ID_VARIABLE_INDIKATOR_nemu = $nemu->ID_VARIABLE_INDIKATOR;
      $SATUAN_nemu = $nemu->SATUAN;
    } else {
      $nemu = $nemulator->row();
      $VARIABLE_NAME_nemu = '';
      $ID_VARIABLE_INDIKATOR_nemu = '';
      $ID_INDIKATOR_nemu = '';
      $SATUAN_nemu = '';
    }
    if ($demulator->num_rows() > 0) {
      $demu = $demulator->row();
      $VARIABLE_NAME_demu = $demu->VARIABLE_NAME;
      $ID_INDIKATOR_demu = $demu->ID_INDIKATOR;
      $ID_VARIABLE_INDIKATOR_demu = $demu->ID_VARIABLE_INDIKATOR;
      $SATUAN_demu = $demu->SATUAN;
    } else {
      $demu = $demulator->row();
      $VARIABLE_NAME_demu = '';
      $ID_INDIKATOR_demu = '';
      $ID_VARIABLE_INDIKATOR_demu = '';
      $SATUAN_demu = '';
    }

    $getData = array(
      "variable_name_nemulator" => $VARIABLE_NAME_nemu,
      "id_indikator_n" => $id,
      "satuan_nemulator"   => $SATUAN_nemu,
      "id_variable_indikator_nemu"   => $ID_VARIABLE_INDIKATOR_nemu,
      "variable_name_demulator" => $VARIABLE_NAME_demu,
      "id_indikator_d" => $id,
      "id_variable_indikator_demu"   => $ID_VARIABLE_INDIKATOR_demu,
      "satuan_demulator"   => $SATUAN_demu,
    );

    echo json_encode($getData);
  }

  public function getDef($id)
  {
    $data = $this->Models->get_dataId('MASTER_INDIKATOR', 'ID_INDIKATOR', $id)->row();

    $getData = array(
      "id_indikator"   => $data->ID_INDIKATOR,
      'deskripsi' => $data->DEFINISI_INDIKATOR,
      'inklusi'  => $data->KT_INKLUSI,
      "eklusi"   => $data->KT_EKLUSI,
    );

    echo json_encode($getData);
  }


  function limit_words($string, $word_limit)
  {
    $words = explode(" ", $string);
    return implode(" ", array_splice($words, 0, $word_limit));
  }

  public function getArea()
  {
    $output = array();
    $cari = $this->input->post('searchTerm');
    // $notin = "SELECT MASTER_AREA FROM INDIKATOR_UNIT WHERE KD_UNIT = '$unit' ";
    // $getNotin = $this->Models->query($notin)->result();
    if ($cari != '') {
      $sql = "SELECT NM_AREA FROM MASTER_AREA WHERE NM_AREA LIKE '%$cari%' ORDER BY NM_AREA ";
      $get = $this->Models->query($sql);
    } else {
      $sql = "SELECT NM_AREA FROM MASTER_AREA ORDER BY NM_AREA";
      $get = $this->Models->query($sql);
    }
    foreach ($get->result() as $key => $value) {
      $data = array();
      $data['id'] = $value->NM_AREA;
      $data['text'] = $value->NM_AREA;
      $output[] = $data;
    }
    echo json_encode($output);
  }


  public function save()
  {

    $metode = $this->input->post('metode');
    $valid = $this->validation_check();
    if ($metode == 'update') {
      if ($valid == true) {
        $id = $this->input->post('id_indikator');
        $input = array(
          'JUDUL_INDIKATOR'    => $this->input->post('judul'),
          'DEFINISI_INDIKATOR' => $this->input->post('deskripsi'),
          'KT_INKLUSI'         => $this->input->post('inklusi'),
          'KT_EKLUSI'          => $this->input->post('eklusi'),
          'SUMBER'             => $this->input->post('sumber'),
          'TP_INDIKATOR'       => $this->input->post('tipeindikator'),
          'AREA'             => $this->input->post('areas'),
          'ID_JENIS_INDIKATOR' => $this->input->post('kategoriindikator'),
          'STANDAR'             => $this->input->post('standar'),
          'NILAI_TARGET'       => $this->input->post('nilai_target'),
        );
        $save = $this->Models->update('MASTER_INDIKATOR', 'ID_INDIKATOR', $id, $input);
        if ($save == true) {
          echo json_encode(array('success' => true, 'notif' => "Data Berhasil Di Ubah"));
        } else {
          echo json_encode(array('error_db' => $this->db->error()));
        }
      }
    } else {

      if ($valid == true) {


        $input = array(
          'JUDUL_INDIKATOR'    => $this->input->post('judul'),
          'DEFINISI_INDIKATOR' => $this->input->post('deskripsi'),
          'KT_INKLUSI'         => $this->input->post('inklusi'),
          'KT_EKLUSI'          => $this->input->post('eklusi'),
          'SUMBER'             => $this->input->post('sumber'),
          'TP_INDIKATOR'       => $this->input->post('tipeindikator'),
          'AREA'             => $this->input->post('areas'),
          'ID_JENIS_INDIKATOR' => $this->input->post('kategoriindikator'),
          'STANDAR'             => $this->input->post('standar'),
          'NILAI_TARGET'             => $this->input->post('nilai_target'),
        );
        $save = $this->Models->insert('MASTER_INDIKATOR', $input);
        if ($save == true) {
          echo json_encode(array('success' => true, 'notif' => "Data Berhasil Di Tambahkan"));
        } else {
          echo json_encode(array('error_db' => $this->db->error()));
        }
      }
    }
  }

  public function save_variable()
  {
    $id_n = $this->input->post('id_indikator_n');
    $id_d = $this->input->post('id_indikator_d');
    $id_var_nemu = $this->input->post('id_variable_indikator_nemu');
    $id_var_demu = $this->input->post('id_variable_indikator_demu');
    // $metode = $this->input->post('metode');
    $valid = $this->validation_viriable_check();
    if ($id_var_nemu != '') {
      if ($valid == true) {

        $input = array(
          'ID_INDIKATOR'    => $id_n,
          'VARIABLE_NAME' => $this->input->post('variable_name_nemulator'),
          'SATUAN'         => $this->input->post('satuan_nemulator'),
          'TYPE'          => 'N',
        );
        $save = $this->Models->update('MASTER_VARIABLE_INDIKATOR', 'ID_VARIABLE_INDIKATOR', $id_var_nemu, $input);
        if ($save == true) {
          $inputDemu = array(
            'ID_INDIKATOR'    => $id_d,
            'VARIABLE_NAME' => $this->input->post('variable_name_demulator'),
            'SATUAN'         => $this->input->post('satuan_demulator'),
            'TYPE'          => 'D',
          );
          $saveDemu = $this->Models->update('MASTER_VARIABLE_INDIKATOR', 'ID_VARIABLE_INDIKATOR', $id_var_demu, $inputDemu);
        }
        if (($saveDemu == true) && ($save == true)) {
          echo json_encode(array('success' => true, 'notif' => "Data Berhasil Di Ubah"));
        } else {
          echo json_encode(array('error_db' => $this->db->error()));
        }
      }
    } else {
      if ($valid == true) {
        $input = array(
          'ID_INDIKATOR'    => $id_n,
          'VARIABLE_NAME' => $this->input->post('variable_name_nemulator'),
          'SATUAN'         => $this->input->post('satuan_nemulator'),
          'TYPE'          => 'N',
        );
        $save = $this->Models->insert('MASTER_VARIABLE_INDIKATOR', $input);
        if ($save == true) {
          $inputDemu = array(
            'ID_INDIKATOR'    => $id_d,
            'VARIABLE_NAME' => $this->input->post('variable_name_demulator'),
            'SATUAN'         => $this->input->post('satuan_demulator'),
            'TYPE'          => 'D',
          );
          $saveDemu = $this->Models->insert('MASTER_VARIABLE_INDIKATOR', $inputDemu);
        }
        if ($saveDemu == true) {
          echo json_encode(array('success' => true, 'notif' => "Data Berhasil Di Tambahkan"));
        } else {
          echo json_encode(array('error_db' => $this->db->error()));
        }
      }
    }
  }



  function validation_check()
  {
    $data = array('messages' => array());
    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
    $this->form_validation->set_rules('judul', 'JUDUL', 'required');
    $this->form_validation->set_rules('deskripsi', 'DESKRIPSI', 'required');
    // $this->form_validation->set_rules('inklusi','INKLUSI', 'required');
    // $this->form_validation->set_rules('eklusi','EKLUSI', 'required');
    $this->form_validation->set_rules('sumber', 'SUMBER', 'required');
    $this->form_validation->set_rules('tipeindikator', 'JENIS INDIKATOR', 'required');
    $this->form_validation->set_rules('area', 'AREA', 'required');
    if ($this->form_validation->run() == FALSE) {
      foreach ($_POST as $key => $value) {
        $data['messages'][$key] = form_error($key);
      }
    } else {
      return true;
    }
    echo json_encode($data);
  }

  function validation_viriable_check()
  {
    $data = array('messages' => array());
    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
    $this->form_validation->set_rules('variable_name_nemulator', 'Nama Variable', 'required');
    $this->form_validation->set_rules('satuan_nemulator', 'SATUAN', 'required');
    //  $this->form_validation->set_rules('type_nemulator','INKLUSI', 'required');
    $this->form_validation->set_rules('variable_name_demulator', 'Nama Variable', 'required');
    $this->form_validation->set_rules('satuan_demulator', 'Satuan', 'required');
    //  $this->form_validation->set_rules('type_demulator','INKLUSI', 'required');

    if ($this->form_validation->run() == FALSE) {
      foreach ($_POST as $key => $value) {
        $data['messages'][$key] = form_error($key);
      }
    } else {
      return true;
    }
    echo json_encode($data);
  }


  public function delData($id)
  {
    $delete = $this->Models->deletData('MASTER_INDIKATOR', 'ID_INDIKATOR', $id);
    if ($delete) {
      echo json_encode(array('success' => true, 'notif' => "Data Berhasil Dihapus"));
    }
  }
}

/* End of file Indikator.php */
