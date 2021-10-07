<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Unitindikator extends CI_Controller
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
		$indikator = $this->Models->get_data('MASTER_INDIKATOR')->result();
		$data = array(
			'content'   => 'Page/Unitindikator',
			'script'    => 'Script/UnitIndikator',
			'unit'      => $unit,
			'indikator' => $indikator,
		);
		$this->load->view('Theme', $data);
	}
	function limit_words($string, $word_limit)
	{
		$words = explode(" ", $string);
		return implode(" ", array_splice($words, 0, $word_limit));
	}
	public function get_tables($KD_UNIT = '')
	{
		$no = 1;
		if ($KD_UNIT != '') {
			$query = "SELECT ID_INDIKATOR_UNIT, JUDUL_INDIKATOR, KT_INKLUSI,DEFINISI_INDIKATOR, KT_EKLUSI, STANDAR from INDIKATOR_UNIT INNER JOIN MASTER_INDIKATOR ON INDIKATOR_UNIT.ID_INDIKATOR=MASTER_INDIKATOR.ID_INDIKATOR WHERE INDIKATOR_UNIT.KD_UNIT='$KD_UNIT' ORDER BY STANDAR ASC";
		} else {
			$query = "SELECT ID_INDIKATOR_UNIT, JUDUL_INDIKATOR, KT_INKLUSI,DEFINISI_INDIKATOR, KT_EKLUSI, STANDAR from INDIKATOR_UNIT INNER JOIN MASTER_INDIKATOR ON INDIKATOR_UNIT.ID_INDIKATOR=MASTER_INDIKATOR.ID_INDIKATOR ORDER BY STANDAR ASC";
		}
		$output = array();
		$get = $this->Models->query($query);
		foreach ($get->result() as $key => $value) {
			$data = array();
			$data[] = $no++;
			$data[] = $value->JUDUL_INDIKATOR;
			$data[] = $this->limit_words(($value->DEFINISI_INDIKATOR), 10);
			$data[] = $this->limit_words(($value->KT_INKLUSI), 10);
			$data[] = $value->STANDAR;
			$data[] = '<a href="javascript:void(0)" class="btn btn-primary btn-xs" id="edit" data-url="' . base_url('Unitindikator/getData/' . $value->ID_INDIKATOR_UNIT) . '" ><i class="fa fa-pencil"></i> Edit</a>
					<a href="javascript:void(0)" class="btn btn-danger btn-xs" id="delBtn" data-url="' . base_url('Unitindikator/delData/' . $value->ID_INDIKATOR_UNIT) . '" ><i class="fa fa-trash"></i> Hapus</a>';
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
				$id = $this->input->post('idunitindikator');
				$input = array(
					'KD_UNIT'      => $this->input->post('unitkat'),
					'ID_INDIKATOR' => $this->input->post('indikatorunit'),
				);
				$save = $this->Models->update('INDIKATOR_UNIT', 'ID_INDIKATOR_UNIT', $id, $input);
				if ($save == true) {
					echo json_encode(array('success' => true, 'notif' => "Data Berhasil Di Ubah"));
				} else {
					echo json_encode(array('error_db' => $this->db->error()));
				}
			}
		} else {

			if ($valid == true) {
				$input = array(
					'KD_UNIT'      => $this->input->post('unitkat'),
					'ID_INDIKATOR' => $this->input->post('indikatorunit'),
				);
				$save = $this->Models->insert('INDIKATOR_UNIT', $input);
				if ($save == true) {
					echo json_encode(array('success' => true, 'notif' => "Data Berhasil Di Tambahkan"));
				} else {
					echo json_encode(array('error_db' => $this->db->error()));
				}
			}
		}
	}
	public function getIndikator($unit)
	{
		$output = array();
		$cari = $this->input->post('searchTerm');
		$notin = "SELECT ID_INDIKATOR FROM INDIKATOR_UNIT WHERE KD_UNIT = '$unit' ";
		$getNotin = $this->Models->query($notin)->result();
		if ($cari != '') {
			$sql = "SELECT ID_INDIKATOR, JUDUL_INDIKATOR FROM MASTER_INDIKATOR WHERE JUDUL_INDIKATOR LIKE '%$cari%' AND ID_INDIKATOR NOT IN (SELECT ID_INDIKATOR FROM INDIKATOR_UNIT WHERE KD_UNIT = '$unit') ";
			$get = $this->Models->query($sql);
		} else {
			$sql = "SELECT ID_INDIKATOR, JUDUL_INDIKATOR FROM MASTER_INDIKATOR WHERE ID_INDIKATOR NOT IN (SELECT ID_INDIKATOR FROM INDIKATOR_UNIT WHERE KD_UNIT = '$unit')";
			$get = $this->Models->query($sql);
		}
		foreach ($get->result() as $key => $value) {
			$data = array();
			$data['id']   = $value->ID_INDIKATOR;
			$data['text'] = $value->JUDUL_INDIKATOR;
			$output[]     = $data;
		}
		echo json_encode($output);
	}
	public function getData($id)
	{
		$data = $this->db->get_where('INDIKATOR_UNIT', array('ID_INDIKATOR_UNIT' => $id))->row();

		$getData = array(
			"unitkat"         => $data->KD_UNIT,
			"indikatorunit"   => $data->ID_INDIKATOR,
			"idunitindikator" => $data->ID_INDIKATOR_UNIT,
		);

		echo json_encode($getData);
	}
	public function Detailindikator($id)
	{
		$data = $this->db->get_where('MASTER_INDIKATOR', array('ID_INDIKATOR' => $id))->row();

		$getData = array(
			"judulindikator"    => $data->JUDUL_INDIKATOR,
			"definisiindikator" => $data->DEFINISI_INDIKATOR,
			"kt_inklusi"        => $data->KT_INKLUSI,
			"kt_eklusi"         => $data->KT_EKLUSI,
			"sumber"            => $data->SUMBER,
			"area"              => $data->AREA,
			"freakuensi"        => $data->FREKUENSI,
			"standar"           => $data->STANDAR,
		);

		echo json_encode($getData);
	}
	function validation_check()
	{
		$data = array('messages' => array());
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
		$this->form_validation->set_rules('unitkat', 'JENIS INDIKATOR', 'required');
		$this->form_validation->set_rules('indikatorunit', 'JENIS INDIKATOR', 'required');
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
		$delete = $this->Models->deletData('INDIKATOR_UNIT', 'ID_INDIKATOR_UNIT', $id);
		if ($delete) {
			echo json_encode(array('success' => true, 'notif' => "Data Berhasil Dihapus"));
		}
	}
}

/* End of file Unitindikator.php */
