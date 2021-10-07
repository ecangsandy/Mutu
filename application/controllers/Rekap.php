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
        // $data1['id'] = 1;
        // $data1['region'] = "Total Perhari";
        $get = $query;
        $indikator_row = $query->row();
        $sum_percent = 0;
        $sum_count = 0;
        $sum_day_arr = [];
        $max =  cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
        // for ($i = 1; $i <= $max; $i++) {
        //     $sum_day_arr[$i] = 0;
        //     $check = $this->db->select('SUM(V_DEMULATOR) demu , SUM(V_NEMULATOR) nemu ')
        //         ->join('MASTER_UNIT', ' MASTER_UNIT.kd_unit=RESULT_INDIKATOR.ID_UNIT')
        //         ->where('GROUP', $layanan)
        //         ->where('ID_INDIKATOR', $indikator)
        //         ->where('DAY(INPUT_DATE) =', $i)
        //         ->where('MONTH(INPUT_DATE) =', $bln)
        //         ->where('YEAR(INPUT_DATE) =', $thn)
        //         ->get('RESULT_INDIKATOR');

        //     $percent = '';
        //     $d = '';
        //     $rows = $check->row();
        //     // if ($check->num_rows() > 0) {
        //     $d = $rows->demu;
        //     $n = $rows->nemu;
        //     $percent = 0;

        //     if ($d > 0) {
        //         if ($indikator_row->SATUAN === 'menit') {
        //             $percent = round(($n / $d), 2);
        //         } else {
        //             $percent = round(($n / $d) * 100, 2);
        //             $sum_percent += $percent;
        //             $sum_count += 1;
        //         }
        //     }
        //     // $data1['f' . $i . ''] =  (isset($indikator_row->SATUAN)) ?  $percent . $indikator_row->SATUAN :  $percent . '';
        // }


        $count_unit = 0;
        $sum_unit = 0;
        $total_sum = 0;

        foreach ($get->result() as $key => $value) {
            $tes = '';
            $data = array();
            $data['id'] = $no++;
            $data['_parentId'] = 1;
            $data['region'] = "<a href='javascript:void(0)'>$value->NM_UNIT</a>";
            $sum_hari = 0;
            $count_hari = 0;
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
                    $count_hari += 1;
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
                    $percent = 0;
                    $data['f' . $i . ''] = "<a href='javascript:void(0)' onclick='survei($value->ID_INDIKATOR,$i)' data-toggle='tooltip' data-placement='right' title='tanggal $i'>0$satuan</a>";
                }
                // $tes .= '+' . $percent;
                // $datas[] = $percent;
                $sum_hari += $percent;
                if ($sum_hari > 0) {
                    $total_sum += $sum_hari / $count_hari;
                }
            }
            $total = 0;
            if ($sum_hari > 0) {
                $sum_count += 1;
                $total = $sum_hari / $count_hari;
            }
            $data['total'] = $total;
            $count_unit += $total;
            $arr_1[] = $tes;


            $output[] = $data;
        }
        $average_percent = ($total_sum != 0) ? $total_sum /  $sum_count : 0;
        $data2['id'] = 1;
        $data2['region'] = 'Total Bulanan';
        // $data2['f1'] = round($average_percent, 2) . '%';
        $data2['f1'] = ($count_unit > 0) ? round($count_unit / $sum_count, 2) . ' %' : 0 . ' %';


        echo json_encode(array(
            'rows' => $output,
            'footer' => array($data2),
            'data' => $get->result(),
            $arr_1
        ));
    }
    public function getIndikator()
    {
        $q = $this->input->post('searchTerm');
        $jenis = $this->input->post('jenis');
        $this->db->select('ID_INDIKATOR, JUDUL_INDIKATOR')
            ->where('ID_JENIS_INDIKATOR !=', '0');
        if ($jenis != '_all') {
            $this->db->where('ID_JENIS_INDIKATOR', $jenis);
        }
        $get = $this->db->like('JUDUL_INDIKATOR', $q)
            ->get('MASTER_INDIKATOR');
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
    public function triwulan()
    {
        $data = array(
            'content'   => 'Page/rekaptriwulan_v',
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
    public function get_tables_triwulan()
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
        switch ($bln) {
            case '1':
                $arr_bln = array('01', '02', '03');
                break;

            case '2':
                $arr_bln = array('04', '05', '06');
                break;

            case '3':
                $arr_bln = array('07', '08', '09');
                break;

            case '4':
                $arr_bln = array('10', '11', '12');
                break;

            default:
                $arr_bln = array('00');
                break;
        }
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
        // $data1['id'] = 1;
        // $data1['region'] = "Total Per-Bulan";
        $get = $query;
        $indikator_row = $query->row();
        $sum_percent = 0;
        $sum_count = 0;
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
                $sum_percent += $percent;
                $sum_count += 1;
            }
            // }
            $dataa['fa' . $i . ''] =  (isset($indikator_row->SATUAN)) ?  $percent . $indikator_row->SATUAN :  $percent . '';
        }
        $total_bln1 = 0;
        $count_bln1 = 0;
        $total_bln2 = 0;
        $count_bln2 = 0;
        $total_bln3 = 0;
        $count_bln3 = 0;
        $sum_total = 0;
        $average_percent = ($sum_percent != 0) ? $sum_percent / $sum_count : 0;
        $data2['id'] = 2;
        $data2['region'] = 'Total Triwulan';
        // $data2['f1'] = round($average_percent, 2) . '%';
        foreach ($get->result() as $keys => $value) {
            $data = array();
            $data['id'] = $no++;
            $data['_parentId'] = 1;
            $data['region'] = "<a href='javascript:void(0)'>$value->NM_UNIT</a>";
            foreach ($arr_bln as $key => $val) {

                $sum_hr = 0;
                $sum_list = 0;
                $max_bln =  cal_days_in_month(CAL_GREGORIAN, $val, $thn);
                for ($i = 1; $i <= $max_bln; $i++) {
                    $q = "SELECT ID_HASIL_INDIKATOR, V_DEMULATOR, V_NEMULATOR  FROM RESULT_INDIKATOR WHERE
                    ID_UNIT = '$value->KD_UNIT' AND ID_INDIKATOR = '$value->ID_INDIKATOR'
                    AND DAY(INPUT_DATE) = '$i'
                    AND MONTH(INPUT_DATE) = '$val'
                    AND YEAR(INPUT_DATE) = '$thn' ";
                    $check = $this->db->query($q);
                    $get_Satuan = $value->SATUAN;
                    $satuan = ($get_Satuan != '') ? $satuan = $value->SATUAN : '%';

                    if ($check->num_rows() > 0) {
                        $sum_list += 1;
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
                    } else {
                        $percent = 0;
                    }
                    $sum_hr += $percent;

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
                        $sum_percent += $percent;
                        $sum_count += 1;
                    }
                }
                if ($sum_hr > 0) {
                    $pecent_ = $sum_hr / $sum_list;
                } else {
                    $pecent_ = 0;
                }
                $data['f' . $key . ''] = "<a href='javascript:void(0)'  data-toggle='tooltip' data-placement='right' title='tanggal $i'> " . round($pecent_, 2) . $satuan . "</a>";
                if ($key == 0) {
                    $total_bln1 += $pecent_;
                    if ($pecent_ > 0) {
                        $count_bln1 += 1;
                    }
                }
                if ($key == 1) {
                    $total_bln2 += $pecent_;
                    if ($pecent_ > 0) {
                        $count_bln2 += 1;
                    }
                }
                if ($key == 2) {
                    $total_bln3 += $pecent_;
                    if ($pecent_ > 0) {
                        $count_bln3 += 1;
                    }
                }
            }

            $output[] = $data;
        }
        $data1['id'] = 1;
        $data1['region'] = "Total Per-Bulan";
        $data1['f0'] = ($total_bln1 > 0) ? round($total_bln1 / $count_bln1, 2) : 0;
        $data1['f1'] = ($total_bln2 > 0) ? round($total_bln2 / $count_bln2, 2) : 0;
        $data1['f2'] =  ($total_bln2 > 0) ? round($total_bln3 / $count_bln3, 2) : 0;
        $sum_total = $data1['f0'] + $data1['f1'] + $data1['f2'];
        $data2['f1'] =  ($sum_total > 0) ? round($sum_total, 2) / 3 . '%' : 0 . '%';

        echo json_encode(array(
            'rows' => $output,
            'footer' => array($data1, $data2),
            'data' => $get->result(),
            // 'tes' => $t_arr
        ));
    }
}

/* End of file Rekap.php */
