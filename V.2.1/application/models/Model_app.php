<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_app extends CI_Model {

    public function get_data($table)
	{
		return $this->db->get($table);
    }
    public function query($query)
	{
		return $this->db->query($query);
	}
	public function insert($table, $value)
	{
		$this->db->insert($table, $value);
		return true;
	}
	public function get_dataId($table,$key,$val)
	{
		$this->db->where($key, $val);
		return $this->db->get($table);
	}
	public function get_UnitIndikator($id_indikator)
	{
		$this->db->select('master_indikator.*');
		$this->db->join('indikator_unit', 'indikator_unit.id_indikator = master_indikator.id_indikator');
		$this->db->where('master_indikator.ID_JENIS_INDIKATOR', $id_indikator);
		return $this->db->get('master_indikator');
		
		
	}
  public function get_dataJoinUserUnit($table,$key,$val)
  {
    	$this->db->join('MASTER_UNIT', 'MASTER_UNIT.KD_UNIT = MASTER_USER.KD_UNIT', 'left');
    $this->db->where($key, $val);
    return $this->db->get($table);
  }
  public function get_dataJoinIndkatorJnsTp($table,$key,$val)
  {
    $this->db->join('MASTER_JENIS_INDIKATOR', 'MASTER_JENIS_INDIKATOR.ID_JENIS_INDIKATOR = MASTER_INDIKATOR.ID_JENIS_INDIKATOR', 'left');
    $this->db->join('MASTER_TIPE_INDIKATOR', 'MASTER_TIPE_INDIKATOR.ID_TIPE_INDIKATOR = MASTER_INDIKATOR.TP_INDIKATOR', 'left');
    $this->db->where($key, $val);
    return $this->db->get($table);
  }
	public function update($table,$key,$val,$data)
	{
		$this->db->where($key, $val);
		$this->db->update($table, $data);
		return true;
	}
	public function deletData($table,$key,$val)
	{
		$this->db->where($key, $val);
		$this->db->delete($table);
		return true;

	}
	public function unitIndikator($kdIndikator)
	{
		$this->db->select('master_indikator.*');
		$this->db->join('indikator_unit', 'indikator_unit.id_indikator = master_indikator.id_indikator');
		$this->db->where('indikator_unit.kd_unit', $kdIndikator);
		return $this->db->get('master_indikator');
	}

}

/* End of file Model_app.php */
