<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
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
    $unit = $this->Models->get_data('MASTER_UNIT')->result();
    $data['unit'] = $unit;
    $data = array('content' => 'Page/User', 'script' => 'Script/Script', 'unit' => $unit);
    $this->load->view('Theme', $data);
  }
  public function get_tables()
  {
    $no = 1;
    $query = "SELECT * from MASTER_USER INNER JOIN MASTER_UNIT ON MASTER_USER.KD_UNIT = MASTER_UNIT.KD_UNIT  ORDER BY ID_USER ASC";
    $output = array();
    $get = $this->Models->query($query);
    foreach ($get->result() as $key => $value) {
      $data = array();
      $data[] = $no++;
      $data[] = $value->FULL_NAME;
      $data[] = $value->USERNAME;
      $data[] = $value->NM_UNIT;
      $data[] = $value->STATUS;
      $data[] = '<a href="javascript:void(0)" class="btn btn-primary btn-xs" id="edit" data-url="' . base_url('User/getData/' . $value->ID_USER) . '" ><i class="fa fa-pencil"></i> Edit</a>
            <a href="javascript:void(0)" class="btn btn-danger btn-xs" id="delBtn" data-url="' . base_url('User/delData/' . $value->ID_USER) . '" ><i class="fa fa-trash"></i> Hapus</a>';
      $output[] = $data;
    }
    echo json_encode(array('data' => $output));
  }
  public function save()
  {
    $metode = $this->input->post('metode');
    $valid = $this->validation_check();
    if ($metode == 'update') {
      if ($valid == true) {
        $id = $this->input->post('id_user');
        $pss = $this->input->post('password');
        if ($pss == '') {
          $input = array(
            'FULL_NAME' => $this->input->post('full_name'),
            'USERNAME' => $this->input->post('username'),
            'STATUS' => $this->input->post('status'),
            'KD_UNIT' => $this->input->post('kd_unit'),
          );
        } else {
          $input = array(
            'FULL_NAME' => $this->input->post('full_name'),
            'USERNAME' => $this->input->post('username'),
            'STATUS' => $this->input->post('status'),
            'PASSWORD' => md5($this->input->post('password')),
            'KD_UNIT' => $this->input->post('kd_unit'),
          );
        }

        $save = $this->Models->update('MASTER_USER', 'ID_USER', $id, $input);
        if ($save == true) {
          echo json_encode(array('success' => true, 'notif' => "Data Berhasil Di Ubah"));
        } else {
          echo json_encode(array('error_db' => $this->db->error()));
        }
      }
    } else {

      if ($valid == true) {
        $input = array(
          'FULL_NAME' => $this->input->post('full_name'),
          'USERNAME' => $this->input->post('username'),
          'STATUS' => $this->input->post('status'),
          'PASSWORD' => md5($this->input->post('full_name')),
          'KD_UNIT' => $this->input->post('kd_unit'),
        );
        $save = $this->Models->insert('MASTER_USER', $input);
        if ($save == true) {
          echo json_encode(array('success' => true, 'notif' => "Data Berhasil Di Tambahkan"));
        } else {
          echo json_encode(array('error_db' => $this->db->error()));
        }
      }
    }
  }
  public function getData($id)
  {
    $data = $this->Models->get_dataJoinUserUnit('MASTER_USER', ' ID_USER', $id)->row();

    $getData = array(
      "id_user" => $data->ID_USER,
      "full_name"            => $data->FULL_NAME,
      "username" => $data->USERNAME,
      //  "password" => $data->PASSWORD,
      "kd_unit"            => $data->KD_UNIT,
      "status"            => $data->STATUS,
    );

    echo json_encode($getData);
  }



  public function change_password()
  {
    $validPass = $this->validation_password();
    if ($validPass == true) {
      // code...
      $id = $this->input->post('id_user');
      $passLama = md5($this->input->post('passwordLama'));
      //  $passBaru = $this->input->post('passwordBaru');

      $data = $this->Models->get_dataId('MASTER_USER', ' ID_USER', $id)->row();
      $passLws = $data->PASSWORD;

      if ($passLama == $passLws) {
        $input = array(
          'PASSWORD' => md5($this->input->post('passwordBaru')),
        );
        $save = $this->Models->update('MASTER_USER', 'ID_USER', $id, $input);
        if ($save == true) {
          echo json_encode(array('success' => true, 'notif' => "Data Berhasil Di Ubah"));
        } else {
          echo json_encode(array('error_db' => $this->db->error()));
        }
      }
    }
  }


  public function delData($id)
  {
    $delete = $this->Models->deletData('MASTER_USER', 'ID_USER', $id);
    if ($delete) {
      echo json_encode(array('success' => true, 'notif' => "Data Berhasil Dihapus"));
    }
  }

  function validation_password()
  {
    $data = array('messages' => array());
    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
    $this->form_validation->set_rules('passwordLama', 'Password Lama', 'required');
    $this->form_validation->set_rules('passwordBaru', 'Password Baru', 'required');
    if ($this->form_validation->run() == FALSE) {
      foreach ($_POST as $key => $value) {
        $data['messages'][$key] = form_error($key);
      }
    } else {
      return true;
    }
    echo json_encode($data);
  }


  function validation_check()
  {
    $data = array('messages' => array());
    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
    if ($this->input->post('metode') == 'update') {
      // code...
      $this->form_validation->set_rules('full_name', 'FULL NAME', 'required');
      $this->form_validation->set_rules('username', 'USERNAME', 'callback_check_username');
      $this->form_validation->set_rules('status', 'HAK AKSES', 'required');
      $this->form_validation->set_rules('kd_unit', 'KODE UNIT', 'required');
    } else {
      // code...
      $this->form_validation->set_rules('full_name', 'FULL NAME', 'required');
      $this->form_validation->set_rules('username', 'USERNAME', 'callback_check_username');
      $this->form_validation->set_rules('status', 'HAK AKSES', 'required');
      $this->form_validation->set_rules('password', 'PASSWORD', 'required');
      $this->form_validation->set_rules('kd_unit', 'KODE UNIT', 'required');
    }

    if ($this->form_validation->run() == FALSE) {
      foreach ($_POST as $key => $value) {
        $data['messages'][$key] = form_error($key);
      }
    } else {
      return true;
    }
    echo json_encode($data);
  }

  public function check_username($str)
  {
    $us = $this->input->post('id_user');
    if ($str != '') {
      if ($us != '') {
        $q = "SELECT USERNAME FROM MASTER_USER WHERE ID_USER = '$us'";
        $cek = $this->db->query($q)->row();
        if ($cek->USERNAME == $str) {

          return TRUE;
        } else {
          $query = "SELECT USERNAME FROM MASTER_USER WHERE USERNAME = '$str'";
          $check = $this->Models->query($query)->num_rows();
          if ($check > 0) {
            $this->form_validation->set_message('check_username', "Username telah di gunakan");
            return FALSE;
          }
        }
      } else {
        $query = "SELECT USERNAME FROM MASTER_USER WHERE USERNAME = '$str'";
        $check = $this->Models->query($query)->num_rows();
        if ($check > 0) {
          $this->form_validation->set_message('check_username', "Username telah di gunakan");
          return FALSE;
        } else {
          // code...
          return TRUE;
        }
      }
    } else {
      $this->form_validation->set_message('check_username', "Masukan Username");
      return FALSE;
    }
  }
}

/* End of file Jenisindikator.php */
