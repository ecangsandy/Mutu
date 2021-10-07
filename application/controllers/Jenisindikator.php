<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Jenisindikator extends CI_Controller
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
		$data = array('content' => 'Page/Jenisindikator', 'script' => 'Script/Script');
		$this->load->view('Theme', $data);
	}
	public function get_tables()
	{
		$no = 1;
		$query = "SELECT * from MASTER_JENIS_INDIKATOR ORDER BY ID_JENIS_INDIKATOR ASC";
		$output = array();
		$get = $this->Models->query($query);
		foreach ($get->result() as $key => $value) {
			$data = array();
			$data[] = $no++;
			$data[] = $value->NM_JENIS_INDIKATOR;
			$data[] = '<a href="javascript:void(0)" class="btn btn-primary btn-xs" id="edit" data-url="' . base_url('Jenisindikator/getData/' . $value->ID_JENIS_INDIKATOR) . '" ><i class="fa fa-pencil"></i> Edit</a>
					<a href="javascript:void(0)" class="btn btn-danger btn-xs" id="delBtn" data-url="' . base_url('Jenisindikator/delData/' . $value->ID_JENIS_INDIKATOR) . '" ><i class="fa fa-trash"></i> Hapus</a>';
			// '<a href="javascript:void(0)" class="btn btn-primary btn-xs" id="edit" onclick="edit('.$value->KD_UNIT.');" ><i class="fa fa-pencil"></i> Edit</a>
			// <a href="javascript:void(0)" class="btn btn-danger btn-xs" data-url="'.base_url('Opd/delData/').'" onclick="delet('.$value->KD_UNIT.');" id="delBtn"><i class="fa fa-trash"></i> Hapus</a>';
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
				$id = $this->input->post('idJenisIndikator');
				$input = array(
					'NM_JENIS_INDIKATOR' => $this->input->post('jenis'),
				);
				$save = $this->Models->update('MASTER_JENIS_INDIKATOR', 'ID_JENIS_INDIKATOR', $id, $input);
				if ($save == true) {
					echo json_encode(array('success' => true, 'notif' => "Data Berhasil Di Ubah"));
				} else {
					echo json_encode(array('error_db' => $this->db->error()));
				}
			}
		} else {

			if ($valid == true) {
				$input = array(
					'NM_JENIS_INDIKATOR' => $this->input->post('jenis'),
				);
				$save = $this->Models->insert('MASTER_JENIS_INDIKATOR', $input);
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
		$data = $this->Models->get_dataId('MASTER_JENIS_INDIKATOR', 'ID_JENIS_INDIKATOR', $id)->row();

		$getData = array(
			"idJenisIndikator" => $data->ID_JENIS_INDIKATOR,
			"jenis"            => $data->NM_JENIS_INDIKATOR,
		);

		echo json_encode($getData);
	}
	public function delData($id)
	{
		$delete = $this->Models->deletData('MASTER_JENIS_INDIKATOR', 'ID_JENIS_INDIKATOR', $id);
		if ($delete) {
			echo json_encode(array('success' => true, 'notif' => "Data Berhasil Dihapus"));
		}
	}
	function validation_check()
	{
		$data = array('messages' => array());
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
		$this->form_validation->set_rules('jenis', 'JENIS INDIKATOR', 'required');
		if ($this->form_validation->run() == FALSE) {
			foreach ($_POST as $key => $value) {
				$data['messages'][$key] = form_error($key);
			}
		} else {
			return true;
		}
		echo json_encode($data);
	}
}

/* End of file Jenisindikator.php */
