<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_model_login');
	}

	function index()
	{
		$this->load->view('Login');
	}

	function aksi_login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$where = array(
			'username' => $username,
			'password' => md5($password)
		);
		$query = $this->M_model_login->cek_login("MASTER_USER", $where);
		$cek = $query->num_rows();

		if ($cek > 0) {
			$get = $query->row();
			$dataUser = $this->db->query("SELECT * FROM MASTER_UNIT WHERE KD_UNIT = '$get->KD_UNIT'")->row();
			$status = $get->STATUS;
			if ($status == 'Super Admin') {
				$data_session = array(
					'ID_USER'  => $get->ID_USER,
					'USERNAME'  => $get->USERNAME,
					'FULL_NAME' => $get->FULL_NAME,
					'STATUS'    => $get->STATUS,
					'logged_mutu' 		=> true,
					'USERDATA'  => $dataUser,
				);
				$this->session->set_userdata($data_session);
				redirect(base_url("Dashboard"));
			} else {
				$data_session = array(
					'ID_USER'  => $get->ID_USER,
					'USERNAME'  => $get->USERNAME,
					'FULL_NAME' => $get->FULL_NAME,
					'STATUS'    => $get->STATUS,
					'logged_mutu' 		=> true,
					'USERDATA'  => $dataUser,
				);

				$this->session->set_userdata($data_session);
				redirect(base_url("Dashboard"));
			}
		} else {
			$this->session->set_flashdata('error', 'Maaf Username atau Password salah');
			redirect('Login');
		}
	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('login'));
	}
}
