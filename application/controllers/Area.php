<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Area extends CI_Controller
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
		$data = array('content' => 'Page/Area', 'script' => 'Script/Script');
		$this->load->view('Theme', $data);
	}
	public function get_tables()
	{
		$no = 1;
		$query = "SELECT * from MASTER_AREA ORDER BY nm_area ASC";
		$output = array();
		$get = $this->Models->query($query);
		foreach ($get->result() as $key => $value) {
			$data = array();
			$data[] = $no++;
			$data[] = $value->NM_AREA;
			$data[] = '<a href="javascript:void(0)" class="btn btn-primary btn-xs" id="edit" data-url="' . base_url('Area/getData/' . $value->ID_AREA) . '" ><i class="fa fa-pencil"></i> Edit</a>
					<a href="javascript:void(0)" class="btn btn-danger btn-xs" id="delBtn" data-url="' . base_url('Area/delData/' . $value->ID_AREA) . '" ><i class="fa fa-trash"></i> Hapus</a>';
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
				$id = $this->input->post('id_area');
				$input = array(
					'NM_AREA' => $this->input->post('nm_area'),
				);
				$save = $this->Models->update('MASTER_AREA', 'ID_AREA', $id, $input);
				if ($save == true) {
					echo json_encode(array('success' => true, 'notif' => "Data Berhasil Di Ubah"));
				} else {
					echo json_encode(array('error_db' => $this->db->error()));
				}
			}
		} else {

			if ($valid == true) {
				$input = array(
					'NM_AREA' => $this->input->post('nm_area'),
				);
				$save = $this->Models->insert('MASTER_AREA', $input);
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
		$data = $this->Models->get_dataId('MASTER_AREA', 'ID_AREA', $id)->row();

		$getData = array(
			"id_area"   => $data->ID_AREA,
			"nm_area" => $data->NM_AREA,
		);

		echo json_encode($getData);
	}
	public function delData($id)
	{
		$delete = $this->Models->deletData('MASTER_AREA', 'ID_AREA', $id);
		if ($delete) {
			echo json_encode(array('success' => true, 'notif' => "Data Berhasil Dihapus"));
		}
	}
	function validation_check()
	{
		$data = array('messages' => array());
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
		$this->form_validation->set_rules('nm_area', 'NAMA AREA', 'required');
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

/* End of file Tipeindikator.php */
