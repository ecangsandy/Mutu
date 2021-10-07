<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Unit extends CI_Controller
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
		$data = array('content' => 'Page/Unit', 'script' => 'Script/Unit');
		$this->load->view('Theme', $data);
	}
	public function get_tables()
	{
		$no = 1;
		$query = "SELECT * from MASTER_UNIT ORDER BY KD_UNIT ASC";
		$output = array();
		$get = $this->Models->query($query);
		foreach ($get->result() as $key => $value) {
			$data = array();
			$kode = $value->KD_UNIT;
			$data[] = $value->KD_UNIT;
			$data[] = $value->NM_UNIT;
			$data[] = $value->KEPALA;
			$data[] = $value->NIP;
			$data[] = '<a href="javascript:void(0)" class="btn btn-primary btn-xs" id="edit" data-url="' . base_url('Unit/getData/' . $value->KD_UNIT) . '" ><i class="fa fa-pencil"></i> Edit</a>
					<a href="javascript:void(0)" class="btn btn-danger btn-xs" id="delBtn" data-url="' . base_url('Unit/delData/' . $value->KD_UNIT) . '" ><i class="fa fa-trash"></i> Hapus</a>';
			$output[] = $data;
		}
		echo json_encode(array('data' => $output));
	}
	public function save()
	{
		$valid = $this->validation_check();
		$metode = $this->input->post('metode');
		if ($metode == 'update') {
			if ($valid == true) {
				$id = $this->input->post('kodeUnit');
				$input = array(
					'NM_UNIT' => $this->input->post('namaUnit'),
					'KEPALA'  => $this->input->post('kepalaUnit'),
					'NIP'     => $this->input->post('nipKepala'),
				);
				$save = $this->Models->update('MASTER_UNIT', 'KD_UNIT', $id, $input);
				if ($save == true) {
					echo json_encode(array('success' => true, 'notif' => "Data Berhasil Di Ubah"));
				} else {
					echo json_encode(array('error_db' => $this->db->error()));
				}
			}
		} else {
			if ($valid == true) {
				$input = array(
					'KD_UNIT' => $this->input->post('kodeUnit'),
					'NM_UNIT' => $this->input->post('namaUnit'),
					'KEPALA'  => $this->input->post('kepalaUnit'),
					'NIP'     => $this->input->post('nipKepala'),
				);
				$save = $this->Models->insert('MASTER_UNIT', $input);
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
		$data = $this->Models->get_dataId('MASTER_UNIT', 'KD_UNIT', $id)->row();

		$getData = array(
			"kodeUnit"   => $data->KD_UNIT,
			"namaUnit"   => $data->NM_UNIT,
			'kepalaUnit' => $data->KEPALA,
			'nipKepala'  => $data->NIP,
		);

		echo json_encode($getData);
	}
	function validation_check()
	{
		$data = array('messages' => array());
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
		if ($this->input->post('metode') == 'update') {
			$this->form_validation->set_rules('namaUnit', 'NAMA UNIT', 'required');
		} else {
			$this->form_validation->set_rules('kodeUnit', 'KODE UNIT', 'required|numeric|callback_kode_check|max_length[3]');
			$this->form_validation->set_rules('namaUnit', 'NAMA UNIT', 'required');
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
	public function kode_check($str)
	{
		$query = "SELECT KD_UNIT FROM MASTER_UNIT WHERE KD_UNIT = '$str'";
		$check = $this->Models->query($query)->num_rows();
		if ($check > 0) {
			$this->form_validation->set_message('kode_check', 'The Kode telah di gunakan');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	public function delData($id)
	{
		$delete = $this->Models->deletData('MASTER_UNIT', 'KD_UNIT', $id);

		redirect('Unit', 'refresh');
	}
}

/* End of file Unit.php */
