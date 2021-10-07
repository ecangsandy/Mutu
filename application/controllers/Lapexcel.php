<?php

defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Lapexcel extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_app', 'Models');
        $this->load->model('Model_survei', 'Msurvei');
    }


    public function excel()
    {
        $kat = $this->input->post('idKat');
        $bln = $this->input->post('bulan');
        $thn = $this->input->post('tahun');
        $no = 1;
        if (empty($bln)) {
            $bln = date("n");
            $thn = date("Y");
        }
        $bln_thn = date('F Y', strtotime('1/' . $bln . '/' . $thn . ''));
        $qjenis = $this->db->get_where('MASTER_JENIS_INDIKATOR', array('ID_JENIS_INDIKATOR' => $kat));
        $jnIndikator = $qjenis->row();
        $query = "SELECT JUDUL_INDIKATOR, A.ID_INDIKATOR FROM MASTER_INDIKATOR A 
            WHERE ID_INDIKATOR IN (SELECT ID_INDIKATOR FROM INDIKATOR_UNIT GROUP BY ID_INDIKATOR)
            AND
             A.ID_JENIS_INDIKATOR = '$kat' ";
        $get = $this->db->query($query);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $no = $tgl = 1;
        $row = 3;
        $col = 1;
        $scol = 3;
        $sheet->setCellValueByColumnAndRow(1, 1, $jnIndikator->NM_JENIS_INDIKATOR . ' ' . $bln_thn);
        $sheet->setCellValueByColumnAndRow($col, $row, 'No');
        $sheet->setCellValueByColumnAndRow($col + 1, $row, 'Indikator');
        $max =  cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
        for ($i = 1; $i <= $max; $i++) {
            $sheet->setCellValueByColumnAndRow($scol++, $row, $tgl++);
        }
        foreach ($get->result() as $key => $value) {
            $nrow = $row++ + 1;
            $icol = 3;
            $sheet->setCellValueByColumnAndRow($col, $nrow, $no++);
            $sheet->setCellValueByColumnAndRow($col + 1, $nrow, $value->JUDUL_INDIKATOR);
            $maxmonht =  cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
            for ($i = 1; $i <= $maxmonht; $i++) {
                $sum = $sn = $sd = 0;
                $nquery = "SELECT SUM(V_DEMULATOR) AS DEMU, SUM(V_NEMULATOR) NEMU,ID_INDIKATOR FROM RESULT_INDIKATOR WHERE ID_INDIKATOR = $value->ID_INDIKATOR
                AND DAY(INPUT_DATE) = '$i'
                AND MONTH(INPUT_DATE) = '$bln'
                AND YEAR(INPUT_DATE) = '$thn'
                GROUP BY ID_INDIKATOR";

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
                        $nilai = 0;
                        $sn += 0;
                        $sd += 0;
                    } else {
                        if ($satuan == 'menit') {
                            $nilai = round(($n / $d), 2);
                        } else {
                            $nilai = round(($n / $d) * 100, 2);
                        }
                        $sn += $n;
                        $sd += $d;
                    }
                } else {
                    $nilai = '0';
                }
                $sheet->setCellValueByColumnAndRow($icol++, $nrow, $nilai);
            }
        }
        $writer = new Xlsx($spreadsheet);

        $filename = 'Laporan-' . $jnIndikator->NM_JENIS_INDIKATOR . '-' . $bln_thn;
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}

/* End of file Lapexcel.php */
