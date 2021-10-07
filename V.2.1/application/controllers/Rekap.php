<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Rekap extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_app', 'Models');
        $this->load->model('Model_survei', 'Msurvei');
    }

    public function index()
    {
        $data = array(
            'content'   => 'Page/rekap_v',
            'script'    => 'Script/rekap',
        );
        $group = $this->db->select('GROUP')->group_by('GROUP')->get('MASTER_UNIT');
        $jenis = $this->db->get('MASTER_JENIS_INDIKATOR');
        $indikator = $this->db->select('ID_INDIKATOR, JUDUL_INDIKATOR')->where('ID_JENIS_INDIKATOR', '3')->get('MASTER_INDIKATOR');
        $data['layanan_group'] = $group->result();
        $data['indikator'] = $indikator->result();
        $data['jenis'] = $jenis->result();
        $this->load->view('Theme', $data);
    }
    public function get_tables()
    {
        $sum = $ntot = $stot = 0;
        if (empty($bln)) {
            $bln = date("n");
            $thn = date("Y");
        }
        $layanan = $this->input->post('layanan');
        $indikator = $this->input->post('indikator');
        $bln = $this->input->post('bln');
        $thn = $this->input->post('thn');
        $no = 2;
        // $id_unit = $this->session->userdata('USERDATA')->KD_UNIT;
        // if ($this->session->userdata('STATUS') == 'Super Admin') {
        $query = $this->db->select('NM_UNIT, b.KD_UNIT, a.ID_INDIKATOR, SATUAN')
            ->join('INDIKATOR_UNIT b', 'b.ID_INDIKATOR=a.ID_INDIKATOR')
            ->join('MASTER_UNIT c', 'b.KD_UNIT=c.KD_UNIT')
            ->join('MASTER_VARIABLE_INDIKATOR d', 'd.ID_INDIKATOR=a.ID_INDIKATOR')
            ->where('a.ID_INDIKATOR', $indikator)
            ->where('TYPE', 'D')
            ->where('GROUP', $layanan)
            ->get('MASTER_INDIKATOR a');

        $output = array();
        $data1['id'] = 1;
        $data1['region'] = "Total";
        $get = $query;
        $indikator_row = $query->row();
        $max =  cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
        for ($i = 1; $i <= $max; $i++) {

            $check = $this->db->select('SUM(V_DEMULATOR) demu , SUM(V_NEMULATOR) nemu ')
                ->join('MASTER_UNIT', ' MASTER_UNIT.kd_unit=RESULT_INDIKATOR.ID_UNIT')
                ->where('GROUP', $layanan)
                ->where('ID_INDIKATOR', $indikator)
                ->where('DAY(INPUT_DATE) =', $i)
                ->where('MONTH(INPUT_DATE) =', $bln)
                ->where('YEAR(INPUT_DATE) =', $thn)
                ->get('RESULT_INDIKATOR');

            $percent = '';
            $d = '';
            $rows = $check->row();
            // if ($check->num_rows() > 0) {
            $d = $rows->demu;
            $n = $rows->nemu;
            $percent = 0;
            if ($d != 0) {
                $percent = round(($n / $d) * 100, 2);
            }
            // }
            $data1['f' . $i . ''] =  (isset($indikator_row->SATUAN)) ?  $percent . $indikator_row->SATUAN :  $percent . '';
        }
        foreach ($get->result() as $key => $value) {

            $sn = $sd = 0;
            $data = array();
            $data['id'] = $no++;
            $data['_parentId'] = 1;
            $data['region'] = "<a href='javascript:void(0)'>$value->NM_UNIT</a>";

            for ($i = 1; $i <= $max; $i++) {
                $q = "SELECT ID_HASIL_INDIKATOR, V_DEMULATOR, V_NEMULATOR  FROM RESULT_INDIKATOR WHERE
                ID_UNIT = '$value->KD_UNIT' AND ID_INDIKATOR = '$value->ID_INDIKATOR'
                AND DAY(INPUT_DATE) = '$i'
                AND MONTH(INPUT_DATE) = '$bln'
                AND YEAR(INPUT_DATE) = '$thn' ";
                $check = $this->db->query($q);
                $get_Satuan = $value->SATUAN;
                $satuan = ($get_Satuan != '') ? $satuan = $value->SATUAN : '%';

                if ($check->num_rows() > 0) {
                    $dt =  $check->row();
                    $n = $dt->V_NEMULATOR;
                    $d = $dt->V_DEMULATOR;
                    if ($d <= 0) {
                        $percent = 0;
                    } else {
                        if ($satuan === 'menit') {
                            $percent = round(($n / $d), 2);
                        } else {
                            $percent = round(($n / $d) * 100, 2);
                        }
                    }
                    // $percent = $n . '/.' . $d;
                    $data['f' . $i . ''] = "<a href='javascript:void(0)' onclick='survei_view($dt->ID_HASIL_INDIKATOR)' data-toggle='tooltip' data-placement='right' title='tanggal $i'>$percent$satuan</a>";
                    // $data['f' . $i . ''] =  $percent;
                } else {
                    $data['f' . $i . ''] = "<a href='javascript:void(0)' onclick='survei($value->ID_INDIKATOR,$i)' data-toggle='tooltip' data-placement='right' title='tanggal $i'>0$satuan</a>";
                }
            }
            // if ($key == 4) {
            //     break;
            // }

            $output[] = $data;
        }


        echo json_encode(array(
            'rows' => $output,
            'footer' => array($data1),
            'data' => $get->result()
        ));
    }
    public function getIndikator()
    {
        $q = $this->input->post('searchTerm');
        $jenis = $this->input->post('jenis');
        $get = $this->db->select('ID_INDIKATOR, JUDUL_INDIKATOR')->where('ID_JENIS_INDIKATOR', $jenis)->where('ID_JENIS_INDIKATOR !=', '0')->get('MASTER_INDIKATOR');
        // $result = array();
        if ($get->num_rows() > 0) {
            foreach ($get->result() as $key => $vals) {
                $result[] = [
                    'id' => $vals->ID_INDIKATOR,
                    'text' => $vals->JUDUL_INDIKATOR
                ];
            }
        } else {
            $result[] = [
                'id' => '',
                'text' => 'Tidak Ada Indikator',
                "disabled" => true
            ];
        }
        echo json_encode($result);
    }
}

/* End of file Rekap.php */
