<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class Client_export_absen extends CI_Controller
{
   function __construct()
   {
      parent::__construct();
      $this->load->model('model_app');
      $this->load->library('pdf');
      date_default_timezone_set('Asia/Jakarta');
   }

   function data_absen_export_excel()
   {
      $store = $this->input->post("store");
      $datestart = $this->input->post("datestart");
      $dateend = $this->input->post("dateend");
      $search = $this->input->post("search");

      if ($store == "-") {
         $toko = "semua Toko";
      } else {
         $toko = ($this->db->where("MsWorkplaceId", $store)->get("TblMsWorkplace")->row())->MsWorkplaceCode;
      }
      $this->db->join("TblMsWorkplace", "TblMsWorkplace.MsWorkplaceId=TblAbsen.MsWorkplaceId")->where("AbsenDate >=", $datestart)->where("AbsenDate <=", $dateend)
         ->group_start()
         ->like("MsWorkplaceCode", $search)
         ->or_like("AbsenDesc", $search)
         ->or_like("MsEmpCode", $search)
         ->or_like("MsEmpName", $search)->group_end();
      if ($store != "-") $this->db->where("TblAbsen.MsWorkplaceId", $store);
      $data = $this->db->get("TblAbsen")->result();

      $spreadsheet = new Spreadsheet;
      $sheet = $spreadsheet->setActiveSheetIndex(0);

      $sheet->setTitle("Laporan Log Absensi");

      //---------------------------  ICON
      $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
      $drawing->setName('Logo');
      $drawing->setDescription('Logo');
      $drawing->setPath('asset/image/mgs-erp/logo.png'); // put your path and image here
      $drawing->setCoordinates('A1');
      $drawing->setResizeProportional(false);
      $drawing->setWidth(100);
      $drawing->setHeight(100);
      $drawing->getShadow()->setVisible(true);
      $drawing->getShadow()->setDirection(45);
      $drawing->setOffsetX(50);
      $drawing->setOffsetY(20);
      $drawing->setWorksheet($spreadsheet->getActiveSheet());

      //---------------------------  HEADER
      $sheet->setCellValue('C1', 'OBI - Enterprice Resource Planning');
      $sheet->getRowDimension(1)->setRowHeight(60);
      $sheet->mergeCells("C1:H1");
      $sheet->getStyle("C1:H1")->getFont()->setSize(20);
      $sheet->getStyle("C1:H1")->getFont()->setBold(true);
      $sheet->getStyle("C1")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle("C1")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);

      $sheet->setCellValue('C2', 'Report Log Absensi');
      $sheet->mergeCells("C2:H2");
      $sheet->getStyle("C2:H2")->getFont()->setSize(12);
      $sheet->getStyle("C2:H2")->getFont()->setBold(true);
      $sheet->getStyle("C2")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle("C2")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

      $sheet->setCellValue('C3', 'Store : ' . $toko);
      $sheet->mergeCells("C3:H3");
      $sheet->getStyle("C3:H3")->getFont()->setSize(12);
      $sheet->getStyle("C3:H3")->getFont()->setBold(true);
      $sheet->getStyle("C3")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle("C3")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

      $sheet->setCellValue('C4', 'periode : ' . $datestart . "/" . $dateend);
      $sheet->mergeCells("C4:H4");
      $sheet->getStyle("C4:H4")->getFont()->setSize(12);
      $sheet->getStyle("C4:H4")->getFont()->setBold(true);
      $sheet->getStyle("C4")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle("C4")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

      //---------------------------  Header Table
      $sheet->setCellValue('A6', 'No');
      $sheet->setCellValue('B6', 'Kode');
      $sheet->setCellValue('C6', 'Nama');
      $sheet->setCellValue('D6', 'Tanggal');
      $sheet->setCellValue('E6', 'Waktu');
      $sheet->setCellValue('F6', 'Toko');
      $sheet->setCellValue('G6', 'Status');
      $sheet->setCellValue('H6', 'Keterangan');
      $sheet->getStyle("A6:H6")->getFont()->setBold(true);
      $sheet->getStyle("A6:H6")->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
      $sheet->getStyle("A6:H6")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
      $sheet->getStyle("A6:H6")->getFill()->getStartColor()->setARGB('FF25221d');
      $sheet->getStyle("A6:H6")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle("A6:H6")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

      $sheet->getStyle("A6:H6")->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $sheet->getStyle("A6:H6")->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $sheet->getStyle("A6:H6")->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $sheet->getStyle("A6:H6")->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      //---------------------------  Isi Table
      $kolom = 7;
      $nomor = 1;
      foreach ($data as $row) {

         $sheet->getRowDimension($kolom)->setRowHeight(25);
         $sheet->getStyle("A" . $kolom . ":H" . $kolom)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
         $sheet->getStyle("A" . $kolom . ":H" . $kolom)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

         $sheet->getStyle("A" . $kolom . ":H" . $kolom)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
         $sheet->getStyle("A" . $kolom . ":H" . $kolom)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
         $sheet->getStyle("A" . $kolom . ":H" . $kolom)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
         $sheet->getStyle("A" . $kolom . ":H" . $kolom)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

         $sheet->setCellValue('A' . $kolom, $nomor);
         $sheet->setCellValue('B' . $kolom, $row->MsEmpCode);
         $sheet->setCellValue('C' . $kolom, $row->MsEmpName);
         $sheet->setCellValue('D' . $kolom, $row->AbsenDate);
         $sheet->setCellValue('E' . $kolom, $row->AbsenTime);
         $sheet->setCellValue('F' . $kolom, $row->MsWorkplaceCode);
         $sheet->setCellValue('G' . $kolom, ($row->System == 0 ? "System" : "Manual"));
         $sheet->setCellValue('H' . $kolom, $row->AbsenDesc);

         $kolom++;
         $nomor++;
      }

      $sheet->getColumnDimension('A')->setAutoSize(true);
      $sheet->getColumnDimension('B')->setAutoSize(true);
      $sheet->getColumnDimension('C')->setAutoSize(true);
      $sheet->getColumnDimension('D')->setAutoSize(true);
      $sheet->getColumnDimension('E')->setAutoSize(true);
      $sheet->getColumnDimension('F')->setAutoSize(true);
      $sheet->getColumnDimension('G')->setAutoSize(true);
      $sheet->getColumnDimension('H')->setAutoSize(true);
      $sheet->setShowGridlines(false);

      $writer = new Xlsx($spreadsheet);

      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="Data-log-absensi.xlsx"');
      header('Cache-Control: max-age=0');

      $writer->save('php://output');
      //$writer->save("upload/data-master-datatoko.xlsx");
      //header("Content-Type: application/vnd.ms-excel");
      //redirect(base_url()."upload/test.xlsx");        
   }
   function data_lembur_export_excel()
   {
      $store = "-";//$this->input->post("store");
      $datestart = $this->input->post("datestart");
      $dateend = $this->input->post("dateend");
      $search = $this->input->post("search");
      $type = $this->input->post("type");

      if ($store == "-") {
         $toko = "semua Toko";
      } else {
         $toko = ($this->db->where("MsWorkplaceId", $store)->get("TblMsWorkplace")->row())->MsWorkplaceCode;
      }

      $this->db
      ->join("TblMsEmployee","TblAbsenLembur.MsEmpId = TblMsEmployee.MsEmpId")
      ->join("TblMsWorkplace", "TblMsWorkplace.MsWorkplaceId=TblMsEmployee.MsWorkplaceId")
      ->join("TblAbsenLemburType", "TblAbsenLemburType.AbsenLemburTypeId=TblAbsenLembur.AbsenLemburType")
      ->where("AbsenLemburDate >=", $datestart)->where("AbsenLemburDate <=", $dateend)
         ->group_start()
         ->like("MsWorkplaceCode", $search)
         ->or_like("AbsenLemburDesc", $search)
         ->or_like("MsEmpCode", $search)
         ->or_like("MsEmpName", $search)->group_end();
      if ($store != "-") $this->db->where("TblMsWorkplace.MsWorkplaceId", $store);
      if ($type != "-") $this->db->where("TblAbsenLemburType.AbsenLemburTypeId", $type);
      $data = $this->db->get("TblAbsenLembur")->result();

      $spreadsheet = new Spreadsheet;
      $sheet = $spreadsheet->setActiveSheetIndex(0);

      $sheet->setTitle("Laporan Lembur Absensi");

      //---------------------------  ICON
      $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
      $drawing->setName('Logo');
      $drawing->setDescription('Logo');
      $drawing->setPath('asset/image/mgs-erp/logo.png'); // put your path and image here
      $drawing->setCoordinates('A1');
      $drawing->setResizeProportional(false);
      $drawing->setWidth(100);
      $drawing->setHeight(100);
      $drawing->getShadow()->setVisible(true);
      $drawing->getShadow()->setDirection(45);
      $drawing->setOffsetX(50);
      $drawing->setOffsetY(20);
      $drawing->setWorksheet($spreadsheet->getActiveSheet());

      //---------------------------  HEADER
      $sheet->setCellValue('C1', 'OBI - Enterprice Resource Planning');
      $sheet->getRowDimension(1)->setRowHeight(60);
      $sheet->mergeCells("C1:H1");
      $sheet->getStyle("C1:H1")->getFont()->setSize(20);
      $sheet->getStyle("C1:H1")->getFont()->setBold(true);
      $sheet->getStyle("C1")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle("C1")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);

      $sheet->setCellValue('C2', 'Report Lemburan');
      $sheet->mergeCells("C2:H2");
      $sheet->getStyle("C2:H2")->getFont()->setSize(12);
      $sheet->getStyle("C2:H2")->getFont()->setBold(true);
      $sheet->getStyle("C2")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle("C2")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

      $sheet->setCellValue('C3', 'Store : ' . $toko);
      $sheet->mergeCells("C3:H3");
      $sheet->getStyle("C3:H3")->getFont()->setSize(12);
      $sheet->getStyle("C3:H3")->getFont()->setBold(true);
      $sheet->getStyle("C3")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle("C3")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

      $sheet->setCellValue('C4', 'periode : ' . $datestart . "/" . $dateend);
      $sheet->mergeCells("C4:H4");
      $sheet->getStyle("C4:H4")->getFont()->setSize(12);
      $sheet->getStyle("C4:H4")->getFont()->setBold(true);
      $sheet->getStyle("C4")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle("C4")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

      //---------------------------  Header Table
      $sheet->setCellValue('A6', 'No');
      $sheet->setCellValue('B6', 'Kode');
      $sheet->setCellValue('C6', 'Nama');
      $sheet->setCellValue('D6', 'Tanggal');
      $sheet->setCellValue('E6', 'Toko'); 
      $sheet->setCellValue('F6', 'Type Lemburan');
      $sheet->setCellValue('G6', 'Keterangan');
      $sheet->getStyle("A6:G6")->getFont()->setBold(true);
      $sheet->getStyle("A6:G6")->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
      $sheet->getStyle("A6:G6")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
      $sheet->getStyle("A6:G6")->getFill()->getStartColor()->setARGB('FF25221d');
      $sheet->getStyle("A6:G6")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle("A6:G6")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

      $sheet->getStyle("A6:G6")->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $sheet->getStyle("A6:G6")->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $sheet->getStyle("A6:G6")->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $sheet->getStyle("A6:G6")->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      //---------------------------  Isi Table
      $kolom = 7;
      $nomor = 1;
      foreach ($data as $row) {

         $sheet->getRowDimension($kolom)->setRowHeight(25);
         $sheet->getStyle("A" . $kolom . ":G" . $kolom)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
         $sheet->getStyle("A" . $kolom . ":G" . $kolom)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

         $sheet->getStyle("A" . $kolom . ":G" . $kolom)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
         $sheet->getStyle("A" . $kolom . ":G" . $kolom)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
         $sheet->getStyle("A" . $kolom . ":G" . $kolom)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
         $sheet->getStyle("A" . $kolom . ":G" . $kolom)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

         $sheet->setCellValue('A' . $kolom, $nomor);
         $sheet->setCellValue('B' . $kolom, $row->MsEmpCode);
         $sheet->setCellValue('C' . $kolom, $row->MsEmpName);
         $sheet->setCellValue('D' . $kolom, $row->AbsenLemburDate);
         $sheet->setCellValue('E' . $kolom, $row->MsWorkplaceCode);
         $sheet->setCellValue('F' . $kolom, $row->AbsenLemburTypeName); 
         $sheet->setCellValue('G' . $kolom, $row->AbsenLemburDesc);

         $kolom++;
         $nomor++;
      }

      $sheet->getColumnDimension('A')->setAutoSize(true);
      $sheet->getColumnDimension('B')->setAutoSize(true);
      $sheet->getColumnDimension('C')->setAutoSize(true);
      $sheet->getColumnDimension('D')->setAutoSize(true);
      $sheet->getColumnDimension('E')->setAutoSize(true);
      $sheet->getColumnDimension('F')->setAutoSize(true);
      $sheet->getColumnDimension('G')->setAutoSize(true); 
      $sheet->setShowGridlines(false);

      $writer = new Xlsx($spreadsheet);

      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="Data-Lemburan.xlsx"');
      header('Cache-Control: max-age=0');

      $writer->save('php://output');
      //$writer->save("upload/data-master-datatoko.xlsx");
      //header("Content-Type: application/vnd.ms-excel");
      //redirect(base_url()."upload/test.xlsx");        
   }

   function data_kehadiran_export_excel()
   {
      $store = "-";//$this->input->post("store");
      $datestart = $this->input->post("datestart");
      $dateend = $this->input->post("dateend");
      $search = $this->input->post("search");
      $type = $this->input->post("type");

      if ($store == "-") {
         $toko = "semua Toko";
      } else {
         $toko = ($this->db->where("MsWorkplaceId", $store)->get("TblMsWorkplace")->row())->MsWorkplaceCode;
      }

      $this->db
      ->join("TblMsEmployee","TblAbsenKelola.MsEmpId = TblMsEmployee.MsEmpId")
      ->join("TblMsWorkplace", "TblMsWorkplace.MsWorkplaceId=TblMsEmployee.MsWorkplaceId")
      ->where("AbsenKelolaDate >=", $datestart)->where("AbsenKelolaDate <=", $dateend)
         ->group_start()
         ->like("MsWorkplaceCode", $search)
         ->or_like("AbsenKelolaDesc", $search)
         ->or_like("AbsenKelolaNote", $search)
         ->or_like("MsEmpCode", $search)
         ->or_like("MsEmpName", $search)->group_end();
      if ($store != "-") $this->db->where("TblMsWorkplace.MsWorkplaceId", $store);
      if ($type != "-") $this->db->where("AbsenKelolaType", $type);
      $data = $this->db->get("TblAbsenKelola")->result();

      $spreadsheet = new Spreadsheet;
      $sheet = $spreadsheet->setActiveSheetIndex(0);

      $sheet->setTitle("Laporan Kehadiran Absensi");

      //---------------------------  ICON
      $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
      $drawing->setName('Logo');
      $drawing->setDescription('Logo');
      $drawing->setPath('asset/image/mgs-erp/logo.png'); // put your path and image here
      $drawing->setCoordinates('A1');
      $drawing->setResizeProportional(false);
      $drawing->setWidth(100);
      $drawing->setHeight(100);
      $drawing->getShadow()->setVisible(true);
      $drawing->getShadow()->setDirection(45);
      $drawing->setOffsetX(50);
      $drawing->setOffsetY(20);
      $drawing->setWorksheet($spreadsheet->getActiveSheet());

      //---------------------------  HEADER
      $sheet->setCellValue('C1', 'OBI - Enterprice Resource Planning');
      $sheet->getRowDimension(1)->setRowHeight(60);
      $sheet->mergeCells("C1:H1");
      $sheet->getStyle("C1:H1")->getFont()->setSize(20);
      $sheet->getStyle("C1:H1")->getFont()->setBold(true);
      $sheet->getStyle("C1")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle("C1")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);

      $sheet->setCellValue('C2', 'Report Kehadiran');
      $sheet->mergeCells("C2:H2");
      $sheet->getStyle("C2:H2")->getFont()->setSize(12);
      $sheet->getStyle("C2:H2")->getFont()->setBold(true);
      $sheet->getStyle("C2")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle("C2")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

      $sheet->setCellValue('C3', 'Store : ' . $toko);
      $sheet->mergeCells("C3:H3");
      $sheet->getStyle("C3:H3")->getFont()->setSize(12);
      $sheet->getStyle("C3:H3")->getFont()->setBold(true);
      $sheet->getStyle("C3")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle("C3")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

      $sheet->setCellValue('C4', 'periode : ' . $datestart . "/" . $dateend);
      $sheet->mergeCells("C4:H4");
      $sheet->getStyle("C4:H4")->getFont()->setSize(12);
      $sheet->getStyle("C4:H4")->getFont()->setBold(true);
      $sheet->getStyle("C4")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle("C4")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

      //---------------------------  Header Table
      $sheet->setCellValue('A6', 'No');
      $sheet->setCellValue('B6', 'Kode');
      $sheet->setCellValue('C6', 'Nama');
      $sheet->setCellValue('D6', 'Tanggal');
      $sheet->setCellValue('E6', 'Toko'); 
      $sheet->setCellValue('F6', 'Type');
      $sheet->setCellValue('G6', 'Keterangan');
      $sheet->getStyle("A6:G6")->getFont()->setBold(true);
      $sheet->getStyle("A6:G6")->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
      $sheet->getStyle("A6:G6")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
      $sheet->getStyle("A6:G6")->getFill()->getStartColor()->setARGB('FF25221d');
      $sheet->getStyle("A6:G6")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle("A6:G6")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

      $sheet->getStyle("A6:G6")->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $sheet->getStyle("A6:G6")->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $sheet->getStyle("A6:G6")->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $sheet->getStyle("A6:G6")->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      //---------------------------  Isi Table
      $kolom = 7;
      $nomor = 1;
      foreach ($data as $row) {

         $sheet->getRowDimension($kolom)->setRowHeight(25);
         $sheet->getStyle("A" . $kolom . ":G" . $kolom)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
         $sheet->getStyle("A" . $kolom . ":G" . $kolom)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

         $sheet->getStyle("A" . $kolom . ":G" . $kolom)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
         $sheet->getStyle("A" . $kolom . ":G" . $kolom)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
         $sheet->getStyle("A" . $kolom . ":G" . $kolom)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
         $sheet->getStyle("A" . $kolom . ":G" . $kolom)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

         $sheet->setCellValue('A' . $kolom, $nomor);
         $sheet->setCellValue('B' . $kolom, $row->MsEmpCode);
         $sheet->setCellValue('C' . $kolom, $row->MsEmpName);
         $sheet->setCellValue('D' . $kolom, $row->AbsenKelolaDate);
         $sheet->setCellValue('E' . $kolom, $row->MsWorkplaceCode);
         $sheet->setCellValue('F' . $kolom, $row->AbsenKelolaDesc); 
         $sheet->setCellValue('G' . $kolom, $row->AbsenKelolaNote);

         $kolom++;
         $nomor++;
      }

      $sheet->getColumnDimension('A')->setAutoSize(true);
      $sheet->getColumnDimension('B')->setAutoSize(true);
      $sheet->getColumnDimension('C')->setAutoSize(true);
      $sheet->getColumnDimension('D')->setAutoSize(true);
      $sheet->getColumnDimension('E')->setAutoSize(true);
      $sheet->getColumnDimension('F')->setAutoSize(true);
      $sheet->getColumnDimension('G')->setAutoSize(true); 
      $sheet->setShowGridlines(false);

      $writer = new Xlsx($spreadsheet);

      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="Data-Kehadiran.xlsx"');
      header('Cache-Control: max-age=0');

      $writer->save('php://output');
      //$writer->save("upload/data-master-datatoko.xlsx");
      //header("Content-Type: application/vnd.ms-excel");
      //redirect(base_url()."upload/test.xlsx");        
   }
   function schedule_load()
   {
      $store = $this->input->post("store");
      $month = $this->input->post("month");
      $year = $this->input->post("year");
      $search = $this->input->post("search");

      // ================================= SETUP HEADER TABLE ===================================

      $jsonlibur = json_decode(file_get_contents("https://raw.githubusercontent.com/guangrei/Json-Indonesia-holidays/master/calendar.json"), true);
      $maxdate = cal_days_in_month(CAL_GREGORIAN, $month, $year);
      $coldate = "";
      for ($i = 1; $i <= $maxdate; $i++) {
         $arr = $this->model_app->tanggalMerah($year . $month . (strlen($i) == 1 ? "0" . $i : $i), $jsonlibur);
         $coldate .= '<th scope="col" class="col-head " style="color:' . $arr[0] . ';background:' . $arr[3] . '" data-bs-toggle="tooltip"  title="' . $arr[1] . '">' . $i . '</th>';
      }


      // ================================= SETUP DETAIL TABLE ===================================
      if ($store != "-")   $this->db->where("MsWorkplaceId", $store);
      $employee = $this->db->where("MsEmpIsActive", 1)->group_start()->like("MsEmpCode", $search)->or_like("MsEmpName", $search)->group_end()->get("TblMsEmployee")->result();
      $coldetail = "";
      foreach ($employee as $row) {
         $coldetail .= '<tr><td scope="col" class="col-fix">' . $row->MsEmpCode . '-' . $row->MsEmpName . '</td>';
         for ($i = 1; $i <= $maxdate; $i++) {
            $roster = $this->db->join("TblRosterList", "TblRoster.RosterTipe=TblRosterList.RosterListCode", "left")->where("MsEmpId", $row->MsEmpId)->where("RosterDate", "$year-$month-$i")->get("TblRoster")->row();
            if (isset($roster->RosterTipe)) {
               $id =  $roster->RosterId;
               $data = $roster->RosterTipe;
               $title = $roster->RosterListDesc . " (" . $roster->RosterListTimeIn . "-" . $roster->RosterListTimeOut . ")";
               $color = ($roster->RosterTipe == "L" ? "RED" : "BLACK");
            } else {
               $id = "-";
               $data = "-";
               $title = "Belum dijadwalkan";
               $color = "GRAY";
            }
            $arr = $this->model_app->tanggalMerah($year . $month . (strlen($i) == 1 ? "0" . $i : $i), $jsonlibur);
            $coldetail .= '<td onclick="tdclick(event,\'' . $row->MsEmpId . '\',\'' . $year . "-" . $month . "-" . (strlen($i) == 1 ? "0" . $i : $i) . '\',\'' . $id . '\')" class="col-head text-center pointer" style="color:' . $color . ';background:' . $arr[3] . '" data-bs-toggle="tooltip"  title="' .  $title . '" >' .   $data . '</td>';
         }
         $coldetail .= "</tr>";
      }



      $content = '<div class="table-responsive">
                     <table class="table table-hover">
                        <thead class="align-middle text-center">
                           <tr>
                              <th scope="col" class="col-fix">Karyawan</th> 
                              ' . $coldate . ' 
                           <tr> 
                        </thead>
                        <tbody style="font-size:0.65rem;font-weight:bold">
                           ' . $coldetail . '
                        </tbody>
                     </table>
                  </div>
      <script>
         $("[data-bs-toggle=\'tooltip\']").tooltip()          
      </script>';
      echo $content;
   }

   function getDatesFromRange($start, $end, $format = 'Y-m-d')
   {
      $array = array();
      $interval = new DateInterval('P1D');

      $realEnd = new DateTime($end);
      $realEnd->add($interval);

      $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

      foreach ($period as $date) {
         $array[] = $date->format($format);
      }

      return $array;
   }

   function absensi_proses()
   {
      $MsEmpId = $this->input->post("MsEmpId");
      $datestart = $this->input->post("datestart");
      $dateend = $this->input->post("dateend");

      $jsonlibur = json_decode(file_get_contents("https://raw.githubusercontent.com/guangrei/Json-Indonesia-holidays/master/calendar.json"), true);
      $Employee = $this->db->join("TblMsWorkplace", "TblMsWorkplace.MsWorkplaceId=TblMsEmployee.MsWorkplaceId", "left")
         ->join("TblMsEmployeePosition", "TblMsEmployeePosition.MsEmpPositionId=TblMsEmployee.MsEmpPositionId", "left")
         ->where_in("TblMsEmployee.MsEmpId", $MsEmpId)->order_by("TblMsEmployee.MsWorkplaceId ASC,TblMsEmployee.MsEmpId ASC")->get("TblMsEmployee")->result();
      $periode = $this->getDatesFromRange($datestart, $dateend);
      $tabledetail = "";
      $tablehead = "";
      $no = 0;
      foreach ($Employee as $row) {
         $tabledetail .= '
                     <h4 class="fw-bold text-center">Detail Absensi</h4><h6 class="fw-bold text-center">' . $row->MsEmpName . '<h6>
                     <table class="table table-hover">
                        <thead class="align-middle text-center">
                           <tr> 
                              <th scope="col">Toko</th>  
                              <th scope="col">Karyawan</th> 
                              <th scope="col">Tanggal</th>  
                              <th scope="col">Roster</th>  
                              <th scope="col">Jam Masuk</th>  
                              <th scope="col">Jam Keluar</th> 
                              <th scope="col">Terlambat</th> 
                              <th scope="col">Izin/sakit/Alpa</th> 
                              <th scope="col">Keterangan</th> 
                           </tr>
                        </thead>
                        <tbody style="font-size:0.7rem;font-weight:bold">';
         $header_telat_jam = 0;
         $header_telat_hari = 0;
         $header_kelola = 0;
         $header_time_kelola = 0;
         foreach ($periode as $date) {
            // -----------------------------------
            // ----------------------------------- Mengambil Roster / Schedule
            // -----------------------------------
            $employee_roster = $this->db
               ->join("TblRosterList", "TblRosterList.RosterListCode=TblRoster.RosterTipe", "left")
               ->where("MsEmpId", $row->MsEmpId)
               ->where("RosterDate", $date)
               ->get("TblRoster")->row();
            $arr = $this->model_app->tanggalMerah(date_format(date_create($date), "Ymd"), $jsonlibur);

            // -----------------------------------
            // ----------------------------------- JIKA SCHEDULE SUDAH DISET
            // -----------------------------------
            if (isset($employee_roster->RosterListTimeIn)) {
               // -----------------------------------
               // ----------------------------------- Check Izin/sakit/alpa
               // -----------------------------------
               $desc = "";
               $kelola = $this->db->join("TblAbsenKelolaType", "TblAbsenKelolaType.AbsenKelolaTypeId=TblAbsenKelola.AbsenKelolaType", "left")->where("AbsenKelolaDate", $date)->where("MsEmpId", $row->MsEmpId)->get("TblAbsenKelola")->row();
               if (isset($kelola->AbsenKelolaDesc)) {
                  $jammasuk = "-";
                  $jamkeluar = "-";
                  $desc .= $kelola->AbsenKelolaDesc;
                  $telat = "-";
                  if ($employee_roster->RosterListTimeIn < $employee_roster->RosterListTimeOut) {
                     $to_time = strtotime("2008-12-13 " . $employee_roster->RosterListTimeIn);
                     $from_time = strtotime("2008-12-13 " . $employee_roster->RosterListTimeOut);
                     $sakitizin = (ceil(abs(($to_time - $from_time) / 100 * $kelola->AbsenKelolaTypePersen) / 3600) == 0 ? "-" : ceil(abs(($to_time - $from_time) / 100 * $kelola->AbsenKelolaTypePersen) / 3600) . " Jam ") . "<br>";
                     $sakitizin .= (ceil(abs(($to_time - $from_time) / 100 * $kelola->AbsenKelolaTypePersen) / 60) == 0 ? "" : "(" . ceil(abs(($to_time - $from_time) / 100 * $kelola->AbsenKelolaTypePersen) / 60) . " Menit )");
                     $header_time_kelola += ceil(abs($to_time - $from_time) / 100 * $kelola->AbsenKelolaTypePersen / 3600);
                  } else {
                     $to_time = strtotime("2008-12-13 " . $employee_roster->RosterListTimeIn);
                     $from_time = strtotime("2008-12-14 " . $employee_roster->RosterListTimeOut);
                     $sakitizin = (ceil(abs(($to_time - $from_time) / 100 * $kelola->AbsenKelolaTypePersen) / 3600) == 0 ? "-" : ceil(abs(($to_time - $from_time) / 100 * $kelola->AbsenKelolaTypePersen) / 3600) . " Jam ") . "<br>";
                     $header_time_kelola += ceil(abs($to_time - $from_time) / 100 * $kelola->AbsenKelolaTypePersen / 3600);
                  }
                  $header_kelola++;
               } else if ($employee_roster->RosterListCode == "L") { // ----------------------------------- Check Jika Libur
                  $jammasuk = "-";
                  $jamkeluar = "-";
                  $desc .= "-";
                  $telat = "-";
                  $sakitizin = "-";
               } else if ($employee_roster->RosterListTimeIn < $employee_roster->RosterListTimeOut) { // ----------------------------------- Check Jam Kerja Normal 
                  $desc_absen = $this->db->select("AbsenDesc")->where("AbsenDesc !=", "-")->where("AbsenDate", $date)->where("MsEmpCode", $row->MsEmpCode)->get("TblAbsen")->row();
                  $jammasuk = ($this->db->select("ifnull(min(AbsenTime),'-') as min")->where("AbsenDate", $date)->where("AbsenTime <", "12:00:00")->where("MsEmpCode", $row->MsEmpCode)->get("TblAbsen")->row())->min;
                  $jamkeluar = ($this->db->select("ifnull(max(AbsenTime),'-') as min")->where("AbsenDate", $date)->where("AbsenTime >", "12:00:00")->where("MsEmpCode", $row->MsEmpCode)->get("TblAbsen")->row())->min;

                  $sakitizin = "-";
                  $desc .= (isset($desc_absen->AbsenDesc) ? $desc_absen->AbsenDesc : "-");
                  if ($jammasuk != "-") {
                     $to_time = strtotime("2008-12-13 " . $employee_roster->RosterListTimeIn);
                     $from_time = strtotime("2008-12-13 " . substr($jammasuk, 0, 6) . "00");
                     if ($to_time < $from_time) {
                        $telat =  ceil(abs($to_time - $from_time) / 3600) . " Jam<br>";
                        $telat .=  "(" . ceil(abs($to_time - $from_time) / 60) . " Menit)";

                        $header_telat_jam += ceil(abs($to_time - $from_time) / 3600);
                        $header_telat_hari++;
                     } else {
                        $telat = "-";
                     }
                  } else {
                     $telat = "-";
                  }
               } else { // ----------------------------------- Jam Kerja Security
                  $nextDate = date('Y-m-d H:i:s', strtotime($date . ' +1 day'));
                  $desc_absen = $this->db->select("AbsenDesc")->where("AbsenDesc !=", "-")->where("AbsenDate", $date)->where("MsEmpCode", $row->MsEmpCode)->get("TblAbsen")->row();
                  $jammasuk = ($this->db->select("ifnull(min(AbsenTime),'-') as min")->where("AbsenDate", $date)->where("AbsenTime >", "12:00:00")->where("MsEmpCode", $row->MsEmpCode)->get("TblAbsen")->row())->min;
                  $jamkeluar = ($this->db->select("ifnull(max(AbsenTime),'-') as min")->where("AbsenDate", date_format(date_create($nextDate), "Y-m-d"))->where("AbsenTime <", "12:00:00")->where("MsEmpCode", $row->MsEmpCode)->get("TblAbsen")->row())->min;

                  $sakitizin = "-";
                  $desc .= (isset($desc_absen->AbsenDesc) ? $desc_absen->AbsenDesc : "-");

                  $to_time = strtotime("2008-12-13 " . $employee_roster->RosterListTimeIn);
                  $from_time = strtotime("2008-12-13 " . substr($jammasuk, 0, 6) . "00");
                  if ($to_time < $from_time) {
                     $telat =  ceil(abs($to_time - $from_time) / 3600) . " Jam<br>";
                     $telat .=  "(" . ceil(abs($to_time - $from_time) / 60) . " Menit)";

                     $header_telat_jam += ceil(abs($to_time - $from_time) / 3600);
                     $header_telat_hari++;
                  } else {
                     $telat = "-";
                  }
               }

               $tabledetail .= "<tr class='" . (date_format(date_create($date), "D") == "Sun" ? "table-secondary" : "") . "'>
                              <td>" . $row->MsWorkplaceCode . "</td>
                              <td>" . $row->MsEmpCode . " - " . $row->MsEmpName . "</td>
                              <td style='color:" . $arr[0] . "'>" . $arr[1] . "<br>" .  date_format(date_create($date), "d M Y")  . "</td>
                              <td style='color:" . ($employee_roster->RosterListCode == "L" ? "blue" : "") . "'>" . $employee_roster->RosterListCode . " - " . $employee_roster->RosterListDesc . "<br>(" . $employee_roster->RosterListTimeIn . " - " . $employee_roster->RosterListTimeOut . ")</td>
                              <td style='color:" . ($telat != "-" ? "RED" : "") . "'>" . $jammasuk . " </td>
                              <td>" . $jamkeluar . "</td>
                              <td style='color:" . ($telat != "-" ? "RED" : "") . "'>" . $telat . "</td>
                              <td style='color:" . ($sakitizin != "-" ? "RED" : "") . "'>" . $sakitizin . "</td>
                              <td>" . $desc . "</td>
                           </tr>";


               // -----------------------------------
               // ----------------------------------- JIKA SCHEDULE BELUM DISET
               // -----------------------------------
            } else {
               $tabledetail .= "<tr class='" . (date_format(date_create($date), "D") == "Sun" ? "table-secondary" : "") . "'>
                              <td>" . $row->MsWorkplaceCode . "</td>
                              <td>" . $row->MsEmpCode . " - " . $row->MsEmpName . "</td>
                              <td style='color:" . $arr[0] . "'>" . $arr[1] . "<br>" .  date_format(date_create($date), "d M Y")  . "</td>
                              <td style='color:RED'>Schedule Belum dimasukan</td>
                              <td style='color:RED'>-</td>
                              <td style='color:RED'>-</td>
                              <td style='color:RED'>-</td>
                              <td style='color:RED'>-</td>
                           </tr>";
            }
         }
         $tabledetail .= '
                        </tbody>
                     </table>';
         $no++;
         $tablehead .= "<tr>
                           <td>" . $no . "</td>
                           <td>" . $row->MsWorkplaceCode . "</td>
                           <td>" . $row->MsEmpCode . " - " . $row->MsEmpName . "</td>
                           <td>" . $row->MsEmpPositionName . "</td>
                           <td>" . $header_telat_jam . "</td>
                           <td>" . $header_telat_hari . "</td> 
                           <td " . ($header_kelola > 0 ? "style='color:red'" : "") . ">" .  $header_time_kelola . "</td> 
                           <td " . ($header_kelola > 0 ? "style='color:red'" : "") . ">" .  $header_kelola . "</td> 
                           <td></td> 
                           <td></td> 
                        </tr>";
      }
      $content = '<h2 class="fw-bold text-center">Report Proses Absensi</h2>
                  <h6 class="text-center"><b>' . date_format(date_create($datestart), "d M Y") . '</b> sampai <b>' . date_format(date_create($dateend), "d M Y") . '</b></h6>';
      $content .= '<div class="table-responsive">
                     <table class="table table-hover">
                        <thead class="align-middle text-center border-dark">
                           <tr>
                              <th scope="col" rowspan="2">No</th>  
                              <th scope="col" rowspan="2">Toko</th>  
                              <th scope="col" rowspan="2">Karyawan</th>  
                              <th scope="col" rowspan="2">Jabatan</th>  
                              <th scope="col" colspan="2">Terlambat</th>  
                              <th scope="col" colspan="2">Izin/sakit/alpa</th>  
                              <th scope="col" colspan="2">Lembur</th>  
                           </tr>  
                           <tr>
                              <th scope="col">jam</th>  
                              <th scope="col">hari</th>  
                              <th scope="col">jam</th>  
                              <th scope="col">hari</th>  
                              <th scope="col">jam</th>  
                              <th scope="col">Harga</th>
                           </tr>
                        </thead>
                        <tbody class="align-middle text-center" style="font-size:0.7rem;font-weight:bold"> 
                        ' . $tablehead . '
                        </tbody>
                     </table> 
                     <br>
                        ' . $tabledetail . '
                  </div>
      <script>
         $("[data-bs-toggle=\'tooltip\']").tooltip()          
      </script>';
      echo $content;
   }

   function absensi_proses_export()
   {
      $MsEmpId = $this->input->post("MsEmpId");
      $datestart = $this->input->post("datestart");
      $dateend = $this->input->post("dateend");

      $spreadsheet = new Spreadsheet();
      $spreadsheet->getProperties()->setCreator('Syahrul Fauzan')
         ->setLastModifiedBy('Syahrul Fauzan')
         ->setTitle('Office 2007 XLSX Test Document')
         ->setSubject('Office 2007 XLSX Test Document')
         ->setDescription('EXPORT BY OBI-WEB')
         ->setKeywords('office 2007 openxml php')
         ->setCategory('Application');

      $worksheet = $spreadsheet->getActiveSheet();
      $worksheet->setTitle("Laporan Ringkasan Absensi");
      $worksheet->setCellValue('A1', 'REPORT ABSENSI');
      $worksheet->setCellValue('A2', "Periode : " . $datestart . " " . $dateend);
      $worksheet->mergeCells('A1:I1');
      $worksheet->mergeCells('A2:I2');
      $worksheet->getStyle('A1:I1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $worksheet->getStyle('A1:I1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
      $worksheet->getStyle('A1:I1')->getFont()->setSize(25);
      $worksheet->getStyle('A1:I1')->getFont()->setBold(true);

      $worksheet->getStyle('A2:I2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $worksheet->getStyle('A2:I2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
      $worksheet->getStyle('A2:I2')->getFont()->setSize(12);
      $worksheet->getStyle('A2:I2')->getFont()->setBold(true);


      //==============================   HEADER pertama
      $worksheet->setCellValue('A4', 'No.');
      $worksheet->mergeCells('A4:A5');
      $worksheet->setCellValue('B4', 'Toko');
      $worksheet->mergeCells('B4:B5');
      $worksheet->setCellValue('C4', 'Karyawan');
      $worksheet->mergeCells('C4:C5');
      $worksheet->setCellValue('D4', 'Jabatan');
      $worksheet->mergeCells('D4:D5');
      $worksheet->setCellValue('E4', 'Terlambat');
      $worksheet->mergeCells('E4:F4');
      $worksheet->setCellValue('E5', 'Jam');
      $worksheet->setCellValue('F5', 'Hari');
      $worksheet->setCellValue('G4', 'Izin/Sakit/Alpa');
      $worksheet->mergeCells('G4:G5');
      $worksheet->mergeCells('H4:I4');
      $worksheet->setCellValue('H5', 'Jam');
      $worksheet->setCellValue('I5', 'Harga');
      $worksheet->getStyle('A4:I5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB(838383);
      $worksheet->getStyle('A4:I5')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
      $worksheet->getStyle('A4:I5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $worksheet->getStyle('A4:I5')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
      $worksheet->getStyle('A4:I5')->getFont()->setSize(12);
      $worksheet->getStyle('A4:I5')->getFont()->setBold(true);


      $jsonlibur = json_decode(file_get_contents("https://raw.githubusercontent.com/guangrei/Json-Indonesia-holidays/master/calendar.json"), true);
      $Employee = $this->db->join("TblMsWorkplace", "TblMsWorkplace.MsWorkplaceId=TblMsEmployee.MsWorkplaceId", "left")
         ->join("TblMsEmployeePosition", "TblMsEmployeePosition.MsEmpPositionId=TblMsEmployee.MsEmpPositionId", "left")
         ->where_in("TblMsEmployee.MsEmpId", $MsEmpId)->order_by("TblMsEmployee.MsWorkplaceId ASC,TblMsEmployee.MsEmpId ASC")->get("TblMsEmployee")->result();
      $periode = $this->getDatesFromRange($datestart, $dateend);
      $no_sheet = 1;
      $no = 1;
      $row_number = 6;
      foreach ($Employee as $row) {
         $header_telat_jam = 0;
         $header_telat_hari = 0;
         $header_kelola = 0;
         $header_time_kelola = 0;
         $spreadsheet->createSheet();
         $worksheetdetail =  $spreadsheet->getSheet($no_sheet);
         $worksheetdetail->setTitle(substr($row->MsEmpCode. "-" .$row->MsEmpName, 0 ,31));
         $worksheetdetail->setCellValue('A1', 'DETAIL ABSENSI');
         $worksheetdetail->setCellValue('A2', $row->MsEmpCode . "-" . $row->MsEmpName);
         $worksheetdetail->mergeCells('A1:H1');
         $worksheetdetail->mergeCells('A2:H2');
         $worksheetdetail->getStyle('A1:H1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
         $worksheetdetail->getStyle('A1:H1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
         $worksheetdetail->getStyle('A1:H1')->getFont()->setSize(25);
         $worksheetdetail->getStyle('A1:H1')->getFont()->setBold(true);

         $worksheetdetail->getStyle('A2:H2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
         $worksheetdetail->getStyle('A2:H2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
         $worksheetdetail->getStyle('A2:H2')->getFont()->setSize(12);
         $worksheetdetail->getStyle('A2:H2')->getFont()->setBold(true);

         //==============================   HEADER
         $worksheetdetail->setCellValue('A4', 'Toko');
         $worksheetdetail->setCellValue('B4', 'Karyawan');
         $worksheetdetail->setCellValue('C4', 'Tanggal');
         $worksheetdetail->setCellValue('D4', 'Roster');
         $worksheetdetail->setCellValue('E4', 'Jam Masuk');
         $worksheetdetail->setCellValue('F4', 'Jam Keluar');
         $worksheetdetail->setCellValue('G4', 'Terlambat');
         $worksheetdetail->setCellValue('H4', 'Izin/Sakit/Alpa');
         $worksheetdetail->setCellValue('I4', 'Keterangan');
         $worksheetdetail->getStyle('A4:I4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB(838383);
         $worksheetdetail->getStyle('A4:I4')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
         $worksheetdetail->getStyle('A4:I4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
         $worksheetdetail->getStyle('A4:I4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
         $worksheetdetail->getStyle('A4:I4')->getFont()->setSize(12);
         $worksheetdetail->getStyle('A4:I4')->getFont()->setBold(true);
         $worksheetdetail->getColumnDimension('A')->setWidth(8);
         $worksheetdetail->getColumnDimension('B')->setWidth(35);
         $worksheetdetail->getColumnDimension('C')->setWidth(12);
         $worksheetdetail->getColumnDimension('D')->setWidth(20);
         $worksheetdetail->getColumnDimension('E')->setWidth(13);
         $worksheetdetail->getColumnDimension('F')->setWidth(13);
         $worksheetdetail->getColumnDimension('G')->setWidth(13);
         $worksheetdetail->getColumnDimension('H')->setWidth(13);
         $worksheetdetail->getColumnDimension('I')->setWidth(50);

         $row_data = 5;
         foreach ($periode as $date) {
            $employee_roster = $this->db
               ->join("TblRosterList", "TblRosterList.RosterListCode=TblRoster.RosterTipe", "left")
               ->where("MsEmpId", $row->MsEmpId)
               ->where("RosterDate", $date)
               ->get("TblRoster")->row();
            $arr = $this->model_app->tanggalMerah(date_format(date_create($date), "Ymd"), $jsonlibur);
            // -----------------------------------
            // ----------------------------------- JIKA SCHEDULE SUDAH DISET
            // -----------------------------------
            if (isset($employee_roster->RosterListTimeIn)) {
               // -----------------------------------
               // ----------------------------------- Check Izin/sakit/alpa
               // -----------------------------------
               $desc = "";
               $telat = "-";
               $kelola = $this->db->join("TblAbsenKelolaType", "TblAbsenKelolaType.AbsenKelolaTypeId=TblAbsenKelola.AbsenKelolaType", "left")->where("AbsenKelolaDate", $date)->where("MsEmpId", $row->MsEmpId)->get("TblAbsenKelola")->row();
               if (isset($kelola->AbsenKelolaDesc)) {
                  $jammasuk = "-";
                  $jamkeluar = "-";
                  $desc .= $kelola->AbsenKelolaDesc;
                  $telat = "-";
                  $header_kelola++;
                  if ($employee_roster->RosterListTimeIn < $employee_roster->RosterListTimeOut) {
                     $to_time = strtotime("2008-12-13 " . $employee_roster->RosterListTimeIn);
                     $from_time = strtotime("2008-12-13 " . $employee_roster->RosterListTimeOut);
                     $sakitizin = (ceil(abs(($to_time - $from_time) / 100 * $kelola->AbsenKelolaTypePersen) / 3600) == 0 ? "-" : ceil(abs(($to_time - $from_time) / 100 * $kelola->AbsenKelolaTypePersen) / 3600) . " Jam ") . "\n";
                     $sakitizin .= (ceil(abs(($to_time - $from_time) / 100 * $kelola->AbsenKelolaTypePersen) / 60) == 0 ? "" : "(" . ceil(abs(($to_time - $from_time) / 100 * $kelola->AbsenKelolaTypePersen) / 60) . " Menit )");
                     $header_time_kelola += ceil(abs($to_time - $from_time) / 100 * $kelola->AbsenKelolaTypePersen / 3600);
                  } else {
                     $to_time = strtotime("2008-12-13 " . $employee_roster->RosterListTimeIn);
                     $from_time = strtotime("2008-12-14 " . $employee_roster->RosterListTimeOut);
                     $sakitizin = (ceil(abs(($to_time - $from_time) / 100 * $kelola->AbsenKelolaTypePersen) / 3600) == 0 ? "-" : ceil(abs(($to_time - $from_time) / 100 * $kelola->AbsenKelolaTypePersen) / 3600) . " Jam ") . "\n";
                     $header_time_kelola += ceil(abs($to_time - $from_time) / 100 * $kelola->AbsenKelolaTypePersen / 3600);
                  }
               } else if ($employee_roster->RosterListCode == "L") { // ----------------------------------- Check Jika Libur
                  $jammasuk = "-";
                  $jamkeluar = "-";
                  $desc .= "-";
                  $telat = "-";
                  $sakitizin = "-";
               } else if ($employee_roster->RosterListTimeIn < $employee_roster->RosterListTimeOut) { // ----------------------------------- Check Jam Kerja Normal 
                  $desc_absen = $this->db->select("AbsenDesc")->where("AbsenDesc !=", "-")->where("AbsenDate", $date)->where("MsEmpCode", $row->MsEmpCode)->get("TblAbsen")->row();
                  $jammasuk = ($this->db->select("ifnull(min(AbsenTime),'-') as min")->where("AbsenDate", $date)->where("AbsenTime <", "12:00:00")->where("MsEmpCode", $row->MsEmpCode)->get("TblAbsen")->row())->min;
                  $jamkeluar = ($this->db->select("ifnull(max(AbsenTime),'-') as min")->where("AbsenDate", $date)->where("AbsenTime >", "12:00:00")->where("MsEmpCode", $row->MsEmpCode)->get("TblAbsen")->row())->min;

                  $sakitizin = "-";
                  $desc .= (isset($desc_absen->AbsenDesc) ? $desc_absen->AbsenDesc : "-");
                  if ($jammasuk != "-") {
                     $to_time = strtotime("2008-12-13 " . $employee_roster->RosterListTimeIn);
                     $from_time = strtotime("2008-12-13 " . substr($jammasuk, 0, 6) . "00");
                     if ($to_time < $from_time) {
                        $telat =  ceil(abs($to_time - $from_time) / 3600) . " Jam\n";
                        $telat .=  "(" . ceil(abs($to_time - $from_time) / 60) . " Menit)";

                        $header_telat_jam += ceil(abs($to_time - $from_time) / 3600);
                        $header_telat_hari++;
                     } else {
                        $telat = "-";
                     }
                  }
               } else { // ----------------------------------- Jam Kerja Security
                  $nextDate = date('Y-m-d H:i:s', strtotime($date . ' +1 day'));
                  $desc_absen = $this->db->select("AbsenDesc")->where("AbsenDesc !=", "-")->where("AbsenDate", $date)->where("MsEmpCode", $row->MsEmpCode)->get("TblAbsen")->row();
                  $jammasuk = ($this->db->select("ifnull(min(AbsenTime),'-') as min")->where("AbsenDate", $date)->where("AbsenTime >", "12:00:00")->where("MsEmpCode", $row->MsEmpCode)->get("TblAbsen")->row())->min;
                  $jamkeluar = ($this->db->select("ifnull(max(AbsenTime),'-') as min")->where("AbsenDate", date_format(date_create($nextDate), "Y-m-d"))->where("AbsenTime <", "12:00:00")->where("MsEmpCode", $row->MsEmpCode)->get("TblAbsen")->row())->min;

                  $desc .= (isset($desc_absen->AbsenDesc) ? $desc_absen->AbsenDesc : "-");
                  $sakitizin = "-";

                  $to_time = strtotime("2008-12-13 " . $employee_roster->RosterListTimeIn);
                  $from_time = strtotime("2008-12-13 " . substr($jammasuk, 0, 6) . "00");
                  if ($to_time < $from_time) {
                     $telat =  ceil(abs($to_time - $from_time) / 3600) . " Jam\n";
                     $telat .=  "(" . ceil(abs($to_time - $from_time) / 60) . " Menit)";

                     $header_telat_jam += ceil(abs($to_time - $from_time) / 3600);
                     $header_telat_hari++;
                  } else {
                     $telat = "-";
                  }
               }

               $worksheetdetail->setCellValue('A' . $row_data, $row->MsWorkplaceCode);
               $worksheetdetail->setCellValue('B' . $row_data, $row->MsEmpCode . " - " . $row->MsEmpName);
               $worksheetdetail->setCellValue('C' . $row_data,  $arr[1] . "\n" .  date_format(date_create($date), "d M Y"));
               $worksheetdetail->setCellValue('D' . $row_data, $employee_roster->RosterListCode . " - " . $employee_roster->RosterListDesc . "\n(" . $employee_roster->RosterListTimeIn . " - " . $employee_roster->RosterListTimeOut . ")");
               $worksheetdetail->setCellValue('E' . $row_data, $jammasuk);
               $worksheetdetail->setCellValue('F' . $row_data, $jamkeluar);
               $worksheetdetail->setCellValue('G' . $row_data, $telat);
               $worksheetdetail->setCellValue('H' . $row_data, $sakitizin);
               $worksheetdetail->setCellValue('I' . $row_data, $desc);
               // -----------------------------------
               // ----------------------------------- JIKA SCHEDULE BELUM DISET
               // -----------------------------------
            } else {
               $worksheetdetail->setCellValue('A' . $row_data, $row->MsWorkplaceCode);
               $worksheetdetail->setCellValue('B' . $row_data, $row->MsEmpCode . " - " . $row->MsEmpName);
               $worksheetdetail->setCellValue('C' . $row_data,  $arr[1] . "\n" .  date_format(date_create($date), "d M Y"));
               $worksheetdetail->setCellValue('D' . $row_data, 'Belum Diset');
               $worksheetdetail->setCellValue('E' . $row_data, '-');
               $worksheetdetail->setCellValue('F' . $row_data, '-');
               $worksheetdetail->setCellValue('G' . $row_data, '-');
               $worksheetdetail->setCellValue('H' . $row_data, '-');
               $worksheetdetail->setCellValue('I' . $row_data, '-');
            }
            $worksheetdetail->getStyle('A' . $row_data . ':I' . $row_data)->getAlignment()->setWrapText(true);
            $row_data++;
         }
         $worksheet->setCellValue('A' . $row_number, $no);
         $worksheet->setCellValue('B' . $row_number, $row->MsWorkplaceCode);
         $worksheet->setCellValue('C' . $row_number, $row->MsEmpCode . " - " . $row->MsEmpName);
         $worksheet->setCellValue('D' . $row_number, $row->MsEmpPositionName);
         $worksheet->setCellValue('E' . $row_number, $header_telat_jam);
         $worksheet->setCellValue('F' . $row_number, $header_telat_hari);
         //$worksheet->setCellValue('G' . $row_number, $header_time_kelola);
         $worksheet->setCellValue('G' . $row_number, $header_kelola);
         $worksheet->setCellValue('H' . $row_number, "");
         $worksheet->setCellValue('I' . $row_number, "");
         $no_sheet++;
         $no++;
         $row_number++;
      }

      $worksheet->getColumnDimension('A')->setWidth(5);
      $worksheet->getColumnDimension('B')->setWidth(10);
      $worksheet->getColumnDimension('C')->setWidth(35);
      $worksheet->getColumnDimension('D')->setWidth(25);
      $worksheet->getColumnDimension('E')->setWidth(7);
      $worksheet->getColumnDimension('F')->setWidth(7);
      $worksheet->getColumnDimension('G')->setWidth(15);
      $worksheet->getColumnDimension('H')->setWidth(7);
      $worksheet->getColumnDimension('I')->setWidth(7);

      // Save Excel 2007 file 
      $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
      $writer->setIncludeCharts(true);

      $filename = "REPORT ABSENSI PERIODE " . $this->input->post("datestart") . " " . $this->input->post("dateend"); // set filename for excel file to be exported
      header('Content-Type: application/vnd.ms-excel'); // generate excel file
      header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
      header('Cache-Control: max-age=0');
      $writer->save('php://output');   // download file
   }
}
