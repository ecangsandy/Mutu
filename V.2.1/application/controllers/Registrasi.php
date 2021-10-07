<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registrasi extends CI_Controller {
    function __construct()
	{
		parent::__construct();
		$this->load->model('Model_Register');
		$this->load->model('Model_app', 'Models');

	}
	public function index()
	{
		$data['title']     = 'Register';
		$data['sub_judul'] = '';
		$unit = $this->Models->get_data('MASTER_UNIT')->result();
		$data['unit']= $unit;

		$this->load->view('registrasi',$data);
	}
	public function register()
  {
          $input = $this->input->post();
          $account = array(

          'FULL_NAME' 	=> $input['full_name'],
          'USERNAME'			=> $input['username'],
          'PASSWORD'		=>md5($input['password']),
          'STATUS'		=> 'User',
          'KD_UNIT'		=>$input['kd_unit']

        );
  		$insert = $this->Models->insert('MASTER_USER',$account);
      if ($insert==true) {
        $this->session->set_userdata($toko);
        $this->session->set_flashdata('success', 'Registerasi Berhasil Silahkan Login Kembalil');
        redirect('Login');
      } else {
        $this->session->set_flashdata('error', 'Data gagal disimpan!');
        redirect(site_url('toko/registrasi'));
  		}



	}
	public function forget()
	{
		$data['title']     = 'Lupa Password';
		$data['sub_judul'] = '';

		$this->load->view('lupa_pass',$data);

	}

	public function getmail()
	{
		$username=$_GET['username'];
		$pass = $this->db->where('USERNAME' , $username)->get('MASTER_USER')->num_rows();
		if($pass > 0)
			$result = false;
		else
			$result = true;

		echo json_encode($result);
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('Login');
	}

}
