<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Model_survei extends CI_Model
{

    var $table = 'MASTER_INDIKATOR';
    var $column_order = array(null, 'JUDUL_INDIKATOR'); //set column field database for datatable orderable
    var $column_search = array('JUDUL_INDIKATOR'); //set column field database for datatable searchable 
    var $order = array('ID_INDIKATOR' => 'asc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($kat, $unit = null)
    {

        $this->db->select('JUDUL_INDIKATOR, MASTER_INDIKATOR.ID_INDIKATOR');
        $this->db->from('MASTER_INDIKATOR');
        if ($unit !== null) {
            $this->db->join('INDIKATOR_UNIT B', 'MASTER_INDIKATOR.ID_INDIKATOR=B.ID_INDIKATOR', 'LEFT');
            $this->db->where('B.KD_UNIT', $unit);
        }
        $this->db->where('MASTER_INDIKATOR.ID_JENIS_INDIKATOR', $kat);

        $i = 0;

        foreach ($this->column_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($kat, $kd_unit = NULL)
    {
        $this->_get_datatables_query($kat, $kd_unit);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    public function getSatuanN($id)
    {
        $this->db->where('TYPE', 'N');
        // $this->db->where('SATUAN', 'menit');
        $this->db->where('ID_INDIKATOR', $id);
        return $this->db->get('MASTER_VARIABLE_INDIKATOR');
    }

    function count_filtered($kat, $kd_unit = NULL)
    {
        $this->_get_datatables_query($kat, $kd_unit);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
}

/* End of file Model_survei.php */
