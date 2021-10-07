<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Survei extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_app', 'Models');
        $this->load->model('Model_survei', 'Msurvei');
        if (empty($this->session->userdata('logged_mutu'))) {
            redirect(base_url('Login'), 'refresh');
        }
    }

    public function index()
    {
    }
    public function Survei_Progres($kat = '')
    {
        $bln = $this->input->post('bulan');
        $thn = $this->input->post('tahun');

        if (empty($bln)) {
            $bln = date("n");
            $thn = date("Y");
        }
        if (empty($kat)) {
            $kat = $this->input->post('idKat');
        }
        $area       = $this->Models->get_data('MASTER_AREA')->result();
        $kategori   = $this->Models->get_data('MASTER_JENIS_INDIKATOR')->row();
        $kategori   = $this->Models->get_dataId('MASTER_JENIS_INDIKATOR', 'ID_JENIS_INDIKATOR', $kat)->row();
        $tipe       = $this->Models->get_data('MASTER_TIPE_INDIKATOR')->result();
        $data = array(
            'content'       => 'Page/Survei',
            'script'        => 'Script/Survei',
            'tipeindikator' => $tipe,
            'kategori'      => $kategori,
            'area'          => $area,
            'bln'           => $bln,
            'tahun'         => $thn,
            'idKat'         => $kat,
        );
        $this->load->view('Theme', $data);
    }
    public function cek($bln = '')
    {
        if (empty($bln)) {
            $bln = date("n");
            $nthn = date("Y");
        } else {
            $nbln = date("Y", strtotime($bln));
            $nthn = date("n", strtotime($bln));
        }
        echo json_encode(array('b' => $nbln, 't' => $nthn));
    }
    public function get_tables()
    {
        $sum = $ntot = $stot = 0;
        if (empty($bln)) {
            $bln = date("n");
            $thn = date("Y");
        }
        $kat = $this->input->post('kategori');
        $bln = $this->input->post('bln');
        $thn = $this->input->post('thn');
        $no = 1;
        $id_unit = $this->session->userdata('USERDATA')->KD_UNIT;
        if ($this->session->userdata('STATUS') == 'Super Admin') {
            $query = "SELECT JUDUL_INDIKATOR, A.ID_INDIKATOR FROM MASTER_INDIKATOR A, INDIKATOR_UNIT B
          WHERE A.ID_INDIKATOR=B.ID_INDIKATOR
          AND A.ID_JENIS_INDIKATOR = '$kat' ";
        } else {
            $query = "SELECT JUDUL_INDIKATOR, A.ID_INDIKATOR FROM MASTER_INDIKATOR A, INDIKATOR_UNIT B
          WHERE A.ID_INDIKATOR=B.ID_INDIKATOR
          AND B.KD_UNIT='$id_unit'
          AND A.ID_JENIS_INDIKATOR = '$kat' ";
        }

        $output = array();

        $get = $this->Models->query($query);
        foreach ($get->result() as $key => $value) {
            $sn = $sd = 0;
            $data = array();
            $data[] = $no++;
            $data[] = "<a href='#' onclick='detail($value->ID_INDIKATOR)'>$value->JUDUL_INDIKATOR</a>";
            $max =  cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
            for ($i = 1; $i <= $max; $i++) {
                $q = "SELECT * FROM RESULT_INDIKATOR WHERE
                ID_UNIT = '$id_unit' AND ID_INDIKATOR = '$value->ID_INDIKATOR'
                AND DAY(INPUT_DATE) = '$i'
                AND MONTH(INPUT_DATE) = '$bln'
                AND YEAR(INPUT_DATE) = '$thn' ";
                $check = $this->db->query($q);
                $get_Satuan = $this->Msurvei->getSatuanN($value->ID_INDIKATOR);
                if ($get_Satuan->num_rows() > 0) {
                    $satuanGet = $get_Satuan->row();
                    $satuan = $satuanGet->SATUAN;
                } else {
                    $satuan = '%';
                }

                if ($check->num_rows() > 0) {
                    $dt =  $check->row();
                    $n = $dt->V_NEMULATOR;
                    $d = $dt->V_DEMULATOR;
                    if ($d <= 0) {
                        $percent = 0;
                    } else {
                        if ($d <= 0) {
                            $percent = 0;
                            $sn += 0;
                            $sd += 0;
                        } else {
                            if ($satuan === 'menit') {
                                $percent = round(($n / $d), 2);
                            } else {
                                $percent = round(($n / $d) * 100, 2);
                            }
                            // $percent = round(($n/$d)*100,2);
                            $sn += $n;
                            $stot += $n;
                            $sd += $d;
                            $ntot += $d;
                        }
                    }
                    $data[] = "<a href='#' onclick='edit_survei($dt->ID_HASIL_INDIKATOR)' data-toggle='tooltip' data-placement='right' title='tanggal $i'>$percent$satuan</a>";
                } else {
                    $data[] = "<a href='#' onclick='survei($value->ID_INDIKATOR,$i)' data-toggle='tooltip' data-placement='right' title='tanggal $i'>0$satuan</a>";
                }
            }
            if ($sd > 0) {
                if ($satuan === 'menit') {
                    $data[] = "<a href='#' onclick='total_survei($value->ID_INDIKATOR,$sn,$sd)' data-toggle='tooltip' data-placement='right'>" . round(($sn / $sd), 2) . "</a>";
                } else {
                    $data[] = "<a href='#' onclick='total_survei($value->ID_INDIKATOR,$sn,$sd)' data-toggle='tooltip' data-placement='right'>" . round(($sn / $sd) * 100, 2) . "</a>";
                }
            } else {
                $data[] = 0;
            }
            $output[] = $data;
        }
        echo json_encode(array('data' => $output,));
    }
    public function getDay($month, $year)
    {
        $countDay = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        echo json_encode(array('countday' => $countDay));
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
    function getVariable($id)
    {
        $nemulator = $this->Models->query("SELECT * FROM MASTER_VARIABLE_INDIKATOR WHERE ID_INDIKATOR = $id AND type='N'");
        $demulator = $this->Models->query("SELECT * FROM MASTER_VARIABLE_INDIKATOR WHERE ID_INDIKATOR = $id AND type='D'");
        if ($nemulator->num_rows() > 0) {
            $nemu = $nemulator->row();
            $VARIABLE_NAME_nemu = $nemu->VARIABLE_NAME;
            $SATUAN_nemu = $nemu->SATUAN;
        } else {
            $VARIABLE_NAME_nemu = '<i>undifened</i>';
            $SATUAN_nemu = '<i>undifened</i>';
        }
        if ($demulator->num_rows() > 0) {
            $demu = $demulator->row();
            $VARIABLE_NAME_demu = $demu->VARIABLE_NAME;
            $SATUAN_demu = $demu->SATUAN;
        } else {
            $VARIABLE_NAME_demu = '<i>undifened</i>';
            $SATUAN_demu = '<i>undifened</i>';
        }

        $getData = array(
            "nemulator_variable" => $VARIABLE_NAME_nemu,
            "nemulator_satuan"   => $SATUAN_nemu,
            "demulator_variable" => $VARIABLE_NAME_demu,
            "demulator_satuan"   => $SATUAN_demu,
        );

        echo json_encode($getData);
    }
    function getData($id)
    {
        $data = $this->Models->query("SELECT * FROM RESULT_INDIKATOR WHERE ID_HASIL_INDIKATOR = $id ")->row();
        $nemulator = $this->Models->query("SELECT * FROM MASTER_VARIABLE_INDIKATOR WHERE ID_INDIKATOR = $data->ID_INDIKATOR AND type='N'");
        $demulator = $this->Models->query("SELECT * FROM MASTER_VARIABLE_INDIKATOR WHERE ID_INDIKATOR = $data->ID_INDIKATOR AND type='D'");
        if ($nemulator->num_rows() > 0) {
            $nemu = $nemulator->row();
            $VARIABLE_NAME_nemu = $nemu->VARIABLE_NAME;
            $SATUAN_nemu = $nemu->SATUAN;
        } else {
            $VARIABLE_NAME_nemu = '<i>undifened</i>';
            $SATUAN_nemu = '<i>undifened</i>';
        }
        if ($demulator->num_rows() > 0) {
            $demu = $demulator->row();
            $VARIABLE_NAME_demu = $demu->VARIABLE_NAME;
            $SATUAN_demu = $demu->SATUAN;
        } else {
            $VARIABLE_NAME_demu = '<i>undifened</i>';
            $SATUAN_demu = '<i>undifened</i>';
        }

        $getData = array(
            "nemulator_variable" => $VARIABLE_NAME_nemu,
            "nemulator_satuan"   => $SATUAN_nemu,
            "demulator_variable" => $VARIABLE_NAME_demu,
            "demulator_satuan"   => $SATUAN_demu,
            "value_nemulator"   => $data->V_NEMULATOR,
            "value_demulator"   => $data->V_DEMULATOR,
        );

        echo json_encode($getData);
    }
    function getDataAll($id, $i)
    {
        $q = $this->Models->query("SELECT sum(V_NEMULATOR) V_NEMULATOR, sum(V_DEMULATOR) V_DEMULATOR, ID_INDIKATOR FROM RESULT_INDIKATOR WHERE ID_INDIKATOR = $id AND DAY(INPUT_DATE) = '$i' group by ID_INDIKATOR");
        if ($q->num_rows() > 0) {
            $data = $q->row();
        } else {
            $data = (object)  array('V_NEMULATOR' => 0, 'V_DEMULATOR' => 0);
        }
        $nemulator = $this->Models->query("SELECT * FROM MASTER_VARIABLE_INDIKATOR WHERE ID_INDIKATOR = $id AND type='N'");
        $demulator = $this->Models->query("SELECT * FROM MASTER_VARIABLE_INDIKATOR WHERE ID_INDIKATOR = $id AND type='D'");
        if ($nemulator->num_rows() > 0) {
            $nemu = $nemulator->row();
            $VARIABLE_NAME_nemu = $nemu->VARIABLE_NAME;
            $SATUAN_nemu = $nemu->SATUAN;
        } else {
            $VARIABLE_NAME_nemu = '<i>undifened</i>';
            $SATUAN_nemu = '<i>undifened</i>';
        }
        if ($demulator->num_rows() > 0) {
            $demu = $demulator->row();
            $VARIABLE_NAME_demu = $demu->VARIABLE_NAME;
            $SATUAN_demu = $demu->SATUAN;
        } else {
            $VARIABLE_NAME_demu = '<i>undifened</i>';
            $SATUAN_demu = '<i>undifened</i>';
        }

        $getData = array(
            "nemulator_variable" => $VARIABLE_NAME_nemu,
            "nemulator_satuan"   => $SATUAN_nemu,
            "demulator_variable" => $VARIABLE_NAME_demu,
            "demulator_satuan"   => $SATUAN_demu,
            "value_nemulator"   => $data->V_NEMULATOR,
            "value_demulator"   => $data->V_DEMULATOR,
        );

        echo json_encode($getData);
    }
    public function rekapImut($kat)
    {
        $bln = $this->input->post('bulan');
        $thn = $this->input->post('tahun');
        $kd_unit = $this->input->post('kd_unit');

        if (empty($bln)) {
            $bln = date("n");
            $thn = date("Y");
        }
        if (empty($kat)) {
            $kat = $this->input->post('idKat');
        }
        $area       = $this->Models->get_data('MASTER_AREA')->result();
        $kategori   = $this->Models->get_data('MASTER_JENIS_INDIKATOR')->row();
        $kategori   = $this->Models->get_dataId('MASTER_JENIS_INDIKATOR', 'ID_JENIS_INDIKATOR', $kat)->row();
        $tipe       = $this->Models->get_data('MASTER_TIPE_INDIKATOR')->result();
        $unit = $this->Models->get_data('MASTER_UNIT')->result();

        $data = array(
            'content'       => 'Page/Rekap_Survei',
            'script'        => 'Script/Survei',
            'tipeindikator' => $tipe,
            'unit'          => $unit,
            'kategori'      => $kategori,
            'area'          => $area,
            'bln'           => $bln,
            'tahun'         => $thn,
            'idKat'         => $kat,
            'kd_unit'       => $kd_unit,
        );
        $this->load->view('Theme', $data);
    }
    public function get_tables_rekap()
    {
        $bln = $this->input->post('bln');
        $thn = $this->input->post('thn');
        if (empty($bln)) {
            $bln = date("n");
        }
        if (empty($thn)) {
            $thn = date("Y");
        }
        $kat = $this->input->post('kategori');

        $kd_unit = $this->input->post('kd_unit');
        if ($kd_unit != '') {
            $unit = $kd_unit;
        } else {
            $unit = null;
        }
        $no  = $_POST['start'];
        $output = array();
        $get = $this->Msurvei->get_datatables($kat, $unit);
        $filterd = $this->Msurvei->count_filtered($kat, $unit);
        if ($filterd > 0) {
            foreach ($get as $key => $value) {
                $sum = $sn = $sd = 0;
                $no++;
                $data = array();
                $data[] = $no;
                $data[] = "<a href='#' onclick='detail($value->ID_INDIKATOR)'>$value->JUDUL_INDIKATOR</a>";
                $max =  cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
                for ($i = 1; $i <= $max; $i++) {
                    if ($unit == null) {
                        $nquery = "SELECT SUM(V_DEMULATOR) AS DEMU, SUM(V_NEMULATOR) NEMU,ID_INDIKATOR FROM RESULT_INDIKATOR WHERE ID_INDIKATOR = $value->ID_INDIKATOR
                    AND DAY(INPUT_DATE) = '$i'
                    AND MONTH(INPUT_DATE) = '$bln'
                    AND YEAR(INPUT_DATE) = '$thn'
                    GROUP BY ID_INDIKATOR";
                    } else {
                        $nquery = "SELECT SUM(V_DEMULATOR) AS DEMU, SUM(V_NEMULATOR) NEMU,ID_INDIKATOR FROM RESULT_INDIKATOR WHERE ID_INDIKATOR = $value->ID_INDIKATOR
                    AND DAY(INPUT_DATE) = '$i'
                    AND MONTH(INPUT_DATE) = '$bln'
                    AND YEAR(INPUT_DATE) = '$thn'
                    and id_unit = '$unit'
                    GROUP BY ID_INDIKATOR";
                    }
                    $get_Satuan = $this->Msurvei->getSatuanN($value->ID_INDIKATOR);
                    if ($get_Satuan->num_rows() > 0) {
                        $satuanGet = $get_Satuan->row();
                        $satuan = $satuanGet->SATUAN;
                    } else {
                        $satuan = '%';
                    }
                    $check = $this->db->query($nquery);

                    if ($check->num_rows() > 0) {
                        $dt =  $check->row();

                        $n = $dt->NEMU;
                        $d = $dt->DEMU;

                        if ($d <= 0) {
                            $percent = 0;
                            $sn += 0;
                            $sd += 0;
                        } else {
                            if ($satuan === 'menit') {
                                $percent = round(($n / $d), 2);
                            } else {
                                $percent = round(($n / $d) * 100, 2);
                            }
                            // $percent = round(($n/$d)*100,2);
                            $sn += $n;
                            $sd += $d;
                        }
                        // $sum += ($n/$d)*100;
                        $data[] = "<a href='#' onclick='All_data($value->ID_INDIKATOR,$i)' data-toggle='tooltip' data-placement='right' title='Tanggal $i'>$percent$satuan</a>";
                    } else {
                        $data[] = "<a href='#' onclick='All_data($value->ID_INDIKATOR,$i)' data-toggle='tooltip' data-placement='right' title='tanggal $i'>0$satuan</a>";
                        // $sum += 0;
                    }
                }
                if ($sd > 0) {
                    if ($satuan === 'menit') {
                        $data[] = "<a href='#' onclick='avg($value->ID_INDIKATOR,$bln)' data-toggle='tooltip' data-placement='right' title='tanggal $i'>" . round(($sn / $sd), 2) . "</a>";
                    } else {
                        $data[] = "<a href='#' onclick='avg($value->ID_INDIKATOR,$bln)' data-toggle='tooltip' data-placement='right' title='tanggal $i'>" . round(($sn / $sd) * 100, 2) . "</a>";
                    }
                } else {
                    $data[] = 0;
                }

                $output[] = $data;
            }
        }
        $table = array(
            'data' => $output,
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Msurvei->count_all($kat, $unit),
            "recordsFiltered" => $this->Msurvei->count_filtered($kat, $unit)
        );
        echo json_encode($table);
    }
    function save()
    {
        $Idunit = $this->session->userdata('USERDATA')->KD_UNIT;

        $metode = $this->input->post('metode');
        if ($metode == 'update') {
            $id = $this->input->post('id_hasil');
            $input = array(
                'V_DEMULATOR'  => (int) $this->input->post('demulator'),
                'V_NEMULATOR'  => (int) $this->input->post('nemulator'),
            );
            $save = $this->Models->update('RESULT_INDIKATOR', 'ID_HASIL_INDIKATOR', $id, $input);
            if ($save == true) {
                echo json_encode(array('success' => true, 'notif' => "Data Berhasil Di Ubah"));
            } else {
                echo json_encode(array('error_db' => $this->db->error()));
            }
        } else {
            $input = array(
                'ID_INDIKATOR' => $this->input->post('id_indikator'),
                'ID_UNIT'      => $Idunit,
                'V_DEMULATOR'  => (int) $this->input->post('demulator'),
                'V_NEMULATOR'  => (int) $this->input->post('nemulator'),
                'INPUT_DATE'   => $this->input->post('tgl_input'),
            );
            $save = $this->Models->insert('RESULT_INDIKATOR', $input);
            if ($save == true) {
                echo json_encode(array('success' => true, 'notif' => "Data Berhasil Di Tambahkan"));
            } else {
                echo json_encode(array('error_db' => $this->db->error()));
            }
        }
    }
    public function getIndikator($id)
    {
        $get_indikator = $this->Models->get_dataId('master_indikator', 'id_indikator', $id)->row();
        $nemulator = $this->Models->query("SELECT * FROM MASTER_VARIABLE_INDIKATOR WHERE ID_INDIKATOR = $id AND type='N'");
        $demulator = $this->Models->query("SELECT * FROM MASTER_VARIABLE_INDIKATOR WHERE ID_INDIKATOR = $id AND type='D'");
        if ($nemulator->num_rows() > 0) {
            $nemu = $nemulator->row();
            $VARIABLE_NAME_nemu = $nemu->VARIABLE_NAME;
            $SATUAN_nemu = $nemu->SATUAN;
        } else {
            $VARIABLE_NAME_nemu = '<i>undifened</i>';
            $SATUAN_nemu = '<i>undifened</i>';
        }
        if ($demulator->num_rows() > 0) {
            $demu = $demulator->row();
            $VARIABLE_NAME_demu = $demu->VARIABLE_NAME;
            $SATUAN_demu = $demu->SATUAN;
        } else {
            $VARIABLE_NAME_demu = '<i>undifened</i>';
            $SATUAN_demu = '<i>undifened</i>';
        }

        $getData = array(
            "nemulator_variable" => $VARIABLE_NAME_nemu,
            "nemulator_satuan"   => $SATUAN_nemu,
            "demulator_variable" => $VARIABLE_NAME_demu,
            "demulator_satuan"   => $SATUAN_demu,
            'judul_indikator' => $get_indikator->JUDUL_INDIKATOR,
        );
        echo json_encode($getData);
    }
    public function getByMonth($id, $month)
    {
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $kd_unit = $this->input->post('kd_unit');
        $get_indikator = $this->Models->get_dataId('master_indikator', 'id_indikator', $id)->row();
        if ($kd_unit != '') {
            $q = $this->Models->query("SELECT sum(V_NEMULATOR) V_NEMULATOR, sum(V_DEMULATOR) V_DEMULATOR, ID_INDIKATOR 
          FROM RESULT_INDIKATOR WHERE ID_INDIKATOR = $id 
          AND ID_UNIT = '$kd_unit' 
          AND MONTH(INPUT_DATE) = '$bulan' 
          AND YEAR(INPUT_DATE) = '$tahun'
          group by ID_INDIKATOR");
        } else {
            $q = $this->Models->query("SELECT sum(V_NEMULATOR) V_NEMULATOR, sum(V_DEMULATOR) V_DEMULATOR, ID_INDIKATOR 
          FROM RESULT_INDIKATOR WHERE ID_INDIKATOR = $id 
          AND MONTH(INPUT_DATE) = '$bulan' 
          AND YEAR(INPUT_DATE) = '$tahun'
          group by ID_INDIKATOR");
        }

        if ($q->num_rows() > 0) {
            $data = $q->row();
        } else {
            $data = (object)  array('V_NEMULATOR' => 0, 'V_DEMULATOR' => 0);
        }
        $nemulator = $this->Models->query("SELECT * FROM MASTER_VARIABLE_INDIKATOR WHERE ID_INDIKATOR = $id AND type='N'");
        $demulator = $this->Models->query("SELECT * FROM MASTER_VARIABLE_INDIKATOR WHERE ID_INDIKATOR = $id AND type='D'");
        if ($nemulator->num_rows() > 0) {
            $nemu = $nemulator->row();
            $VARIABLE_NAME_nemu = $nemu->VARIABLE_NAME;
            $SATUAN_nemu = $nemu->SATUAN;
        } else {
            $VARIABLE_NAME_nemu = '<i>undifened</i>';
            $SATUAN_nemu = '<i>undifened</i>';
        }
        if ($demulator->num_rows() > 0) {
            $demu = $demulator->row();
            $VARIABLE_NAME_demu = $demu->VARIABLE_NAME;
            $SATUAN_demu = $demu->SATUAN;
        } else {
            $VARIABLE_NAME_demu = '<i>undifened</i>';
            $SATUAN_demu = '<i>undifened</i>';
        }

        $getData = array(
            "nemulator_variable" => $VARIABLE_NAME_nemu,
            "nemulator_satuan"   => $SATUAN_nemu,
            "demulator_variable" => $VARIABLE_NAME_demu,
            "demulator_satuan"   => $SATUAN_demu,
            "value_nemulator"   => $data->V_NEMULATOR,
            "value_demulator"   => $data->V_DEMULATOR,
            'judul_indikator' => $get_indikator->JUDUL_INDIKATOR,
        );

        echo json_encode($getData);
    }
}

/* End of file Survei.php */
