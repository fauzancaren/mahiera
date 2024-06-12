<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Client_export_financial extends CI_Controller
{
   function __construct()
   {
      parent::__construct();
      $this->load->model('model_app');
      $this->load->library('pdf');
      date_default_timezone_set('Asia/Jakarta');
   }

   public function data_group_petty_cash()
   {
      $result = $this->db->get("TblFinanceCategory")->result();
      foreach ($result as $row) {
         $sub_data["id"] = $row->FinanceCatId;
         $sub_data["name"] = $row->FinanceCatName;
         $sub_data["type"] =  $row->FinanceCatType;
         $sub_data["parent_id"] =  $row->FinanceCatParent;
         $data[] = $sub_data;
      }
      foreach ($data as $key => &$value) {
         $output[$value["id"]] = &$value;
      }
      foreach ($data as $key => &$value) {
         if ($value["parent_id"] && isset($output[$value["parent_id"]])) {
            $output[$value["parent_id"]]["nodes"][] = &$value;
         }
      }
      foreach ($data as $key => &$value) {
         if ($value["parent_id"] && isset($output[$value["parent_id"]])) {
            unset($data[$key]);
         }
      }
      return $data;
   }

   function pettycash()
   {
      $datestart = $this->input->get("datestart");
      $dateend = $this->input->get("dateend");
      $store = $this->input->get("store");
      if ($store == "") {
         $toko = "semua Toko";
      } else {
         $toko = $this->model_app->get_single_data("MsWorkplaceCode", "TblMsWorkplace", array("MsWorkplaceId" => $store));
      }


      $spreadsheet = new Spreadsheet;
      $sheet = $spreadsheet->setActiveSheetIndex(0);

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
      $sheet->mergeCells("C1:E1");
      $sheet->getStyle("C1:E1")->getFont()->setSize(26);
      $sheet->getStyle("C1:E1")->getFont()->setBold(true);
      $sheet->getStyle("C1")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle("C1")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);

      $sheet->setCellValue('C2', 'DATA KAS KECIL');
      $sheet->getRowDimension(2)->setRowHeight(40);
      $sheet->mergeCells("C2:E2");
      $sheet->getStyle("C2:E2")->getFont()->setSize(20);
      $sheet->getStyle("C2:E2")->getFont()->setBold(true);
      $sheet->getStyle("C2")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle("C2")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

      $sheet->setCellValue('B3', 'PERIODE : ' . date_format(date_create($datestart), "d M Y") . ' - ' . date_format(date_create($dateend), "d M Y"));
      $sheet->getRowDimension(3)->setRowHeight(20);
      $sheet->mergeCells("B3:E3");
      $sheet->getStyle("B3:E3")->getFont()->setSize(12);
      $sheet->getStyle("B3")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

      $sheet->setCellValue('B4', 'TOKO    : ' . $toko);
      $sheet->getRowDimension(3)->setRowHeight(20);
      $sheet->mergeCells("B4:E4");
      $sheet->getStyle("B4:E4")->getFont()->setSize(12);
      $sheet->getStyle("B4")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);


      $sheet->getColumnDimension('A')->setWidth(4);
      $sheet->getColumnDimension('B')->setWidth(15);
      $sheet->getColumnDimension('C')->setWidth(50);
      $sheet->getColumnDimension('D')->setWidth(20);
      $sheet->getColumnDimension('E')->setWidth(20);





      //---------------------------  Header TABLE
      $sheet->setCellValue('A6', 'KATEGORI');
      $sheet->setCellValue('D6', 'MASUK');
      $sheet->setCellValue('E6', 'KELUAR');
      $sheet->mergeCells("A6:C6");
      $sheet->getStyle("A6:E6")->getFont()->setBold(true);
      $sheet->getStyle('A6:E6')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
      $sheet->getStyle('A6:E6')->getFill()->getStartColor()->setRGB('b3b3b3');


      $data = $this->data_group_petty_cash();

      $total_out = 0;
      $total_in = 0;
      $row_num = 7;
      foreach ($data as $key) {
         $totalout = $this->db->join("TblFinanceCategory as b", "a.FinanceCatId = b.FinanceCatParent")
            ->join("TblFinancial as c", "b.FinanceCatId = c.FinancialCategory")
            ->where("a.FinanceCatId", $key["id"])
            ->where("c.isDelete", 0)
            ->where("FinancialType", 0)
            ->where("FinancialDate >=", $datestart)
            ->where("FinancialDate <=", $dateend)
            ->like("MsWorkplaceId", $store)
            ->select_sum("c.FinancialTotal")
            ->get("TblFinanceCategory AS a")->row();

         $totalin = $this->db->join("TblFinanceCategory as b", "a.FinanceCatId = b.FinanceCatParent")
            ->join("TblFinancial as c", "b.FinanceCatId = c.FinancialCategory")
            ->where("a.FinanceCatId", $key["id"])
            ->where("c.isDelete", 0)
            ->where("FinancialType", 1)
            ->where("FinancialDate >=", $datestart)
            ->where("FinancialDate <=", $dateend)
            ->like("MsWorkplaceId", $store)
            ->select_sum("c.FinancialTotal")
            ->get("TblFinanceCategory AS a")->row();

         $_in = number_format(is_null($totalout->FinancialTotal) ? 0 : $totalout->FinancialTotal, 0);
         $_out = number_format(is_null($totalin->FinancialTotal) ? 0 : $totalin->FinancialTotal, 0);

         $sheet->setCellValue('A' . $row_num, $key["name"]);
         $sheet->setCellValue('D' . $row_num, ($_in == 0 ? "-" : $_in));
         $sheet->setCellValue('E' . $row_num, ($_out == 0 ? "-" : $_out));
         $sheet->getStyle('A' . $row_num . ':E' . $row_num)->getFont()->setBold(true);
         $sheet->getStyle('A' . $row_num . ':E' . $row_num)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
         $sheet->getStyle('A' . $row_num . ':E' . $row_num)->getFill()->getStartColor()->setRGB('ebebeb');
         $row_num++;

         $total_out += $totalout->FinancialTotal;
         $total_in += $totalin->FinancialTotal;

         foreach ($key["nodes"] as $row) {
            $totalout = $this->db->join("TblFinanceCategory as b", "a.FinanceCatId = b.FinanceCatParent")
               ->join("TblFinancial as c", "b.FinanceCatId = c.FinancialCategory")
               ->where("c.FinancialCategory", $row["id"])
               ->where("c.isDelete", 0)
               ->where("FinancialType", 0)
               ->where("FinancialDate >=", $datestart)
               ->where("FinancialDate <=", $dateend)
               ->like("MsWorkplaceId", $store)
               ->select_sum("c.FinancialTotal")
               ->get("TblFinanceCategory AS a")->row();

            $totalin = $this->db->join("TblFinanceCategory as b", "a.FinanceCatId = b.FinanceCatParent")
               ->join("TblFinancial as c", "b.FinanceCatId = c.FinancialCategory")
               ->where("c.FinancialCategory", $row["id"])
               ->where("c.isDelete", 0)
               ->where("FinancialType", 1)
               ->where("FinancialDate >=", $datestart)
               ->where("FinancialDate <=", $dateend)
               ->like("MsWorkplaceId", $store)
               ->select_sum("c.FinancialTotal")
               ->get("TblFinanceCategory AS a")->row();


            $_in = number_format(is_null($totalout->FinancialTotal) ? 0 : $totalout->FinancialTotal, 0);
            $_out = number_format(is_null($totalin->FinancialTotal) ? 0 : $totalin->FinancialTotal, 0);
            $sheet->setCellValue('B' . $row_num, $row["name"]);
            $sheet->setCellValue('D' . $row_num, ($_in == 0 ? "-" : $_in));
            $sheet->setCellValue('E' . $row_num, ($_out == 0 ? "-" : $_out));
            $row_num++;
         }
      }

      $tataloldin = $this->db->join("TblFinanceCategory as b", "a.FinanceCatId = b.FinanceCatParent")
         ->join("TblFinancial as c", "b.FinanceCatId = c.FinancialCategory")
         ->where("c.isDelete", 0)
         ->where("FinancialType", 1)
         ->where("FinancialDate <", $datestart)
         ->like("MsWorkplaceId", $store)
         ->select_sum("c.FinancialTotal")
         ->get("TblFinanceCategory AS a")->row();
      $tataloldout = $this->db->join("TblFinanceCategory as b", "a.FinanceCatId = b.FinanceCatParent")
         ->join("TblFinancial as c", "b.FinanceCatId = c.FinancialCategory")
         ->where("c.isDelete", 0)
         ->where("FinancialType", 0)
         ->where("FinancialDate <", $datestart)
         ->like("MsWorkplaceId", $store)
         ->select_sum("c.FinancialTotal")
         ->get("TblFinanceCategory AS a")->row();

      $_in = number_format(is_null($tataloldin->FinancialTotal) ? 0 : $totalout->FinancialTotal, 0);
      $_out = number_format(is_null($tataloldout->FinancialTotal) ? 0 : $totalin->FinancialTotal, 0);

      $sheet->getStyle('A' . $row_num . ':E' . $row_num)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
      $sheet->getStyle('A' . $row_num . ':E' . $row_num)->getFill()->getStartColor()->setRGB('b3b3b3');
      $row_num++;

      $sheet->setCellValue('A' . $row_num, "TOTAL");
      $sheet->setCellValue('D' . $row_num, (number_format($total_in) == 0 ? "-" : number_format($total_in)));
      $sheet->setCellValue('E' . $row_num, (number_format($total_out) == 0 ? "-" : number_format($total_out)));
      $row_num++;
      $sheet->setCellValue('A' . $row_num, "Saldo Awal pada " . $datestart);
      $sheet->setCellValue('E' . $row_num, number_format($tataloldin->FinancialTotal - $tataloldout->FinancialTotal));
      $row_num++;
      $sheet->setCellValue('A' . $row_num, "Perubahan Saldo");
      $sheet->setCellValue('E' . $row_num, number_format($total_in - $total_out));
      $row_num++;
      $sheet->setCellValue('A' . $row_num, "Saldo Akhir pada " . $dateend);
      $sheet->setCellValue('E' . $row_num, number_format(($tataloldin->FinancialTotal - $tataloldout->FinancialTotal) + ($total_in - $total_out)));
      $row_num++;
      $sheet->getStyle('A' . $row_num . ':E' . $row_num)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
      $sheet->getStyle('A' . $row_num . ':E' . $row_num)->getFill()->getStartColor()->setRGB('b3b3b3');
      $sheet->setTitle('DATA GLOBAL');

      $id_index = 1;
      foreach ($data as $key) {
         $spreadsheet->createSheet();
         // Zero based, so set the second tab as active sheet
         $sheet = $spreadsheet->setActiveSheetIndex($id_index);
         $sheet->setTitle($key["name"]);

         $sheet->setCellValue('A1', $key["name"]);
         $sheet->getRowDimension(1)->setRowHeight(25);
         $sheet->mergeCells("A1:D1");
         $sheet->getStyle("A1:D1")->getFont()->setSize(16);
         $sheet->getStyle("A1:D1")->getFont()->setBold(true);
         $sheet->getStyle("A1")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);

         $row_num = 2;
         foreach ($key["nodes"] as $row) {
            $sheet->setCellValue('A' . $row_num, $row["name"]);
            $sheet->getRowDimension($row_num)->setRowHeight(15);
            $sheet->mergeCells('A' . $row_num . ':D' . $row_num);
            $sheet->getStyle('A' . $row_num . ':D' . $row_num)->getFont()->setSize(12);
            $sheet->getStyle('A' . $row_num . ':D' . $row_num)->getFont()->setBold(true);
            $sheet->getStyle('A' . $row_num)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);
            $row_num++;

            $sheet->setCellValue('A' . $row_num, "No.");
            $sheet->setCellValue('B' . $row_num, "Keterangan");
            $sheet->setCellValue('C' . $row_num, "Tanggal");
            $sheet->setCellValue('D' . $row_num, "Total");
            $sheet->getStyle('A' . $row_num . ':D' . $row_num)->getFont()->setSize(11);
            $sheet->getStyle('A' . $row_num . ':D' . $row_num)->getFont()->setBold(true);
            $sheet->getStyle('A' . $row_num)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);
            $sheet->getStyle('A' . $row_num . ':D' . $row_num)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle('A' . $row_num . ':D' . $row_num)->getFill()->getStartColor()->setRGB('b3b3b3');
            $sheet->setCellValue('A' . $row_num, "No.");
            $sheet->setCellValue('B' . $row_num, "Keterangan");
            $sheet->setCellValue('C' . $row_num, "Tanggal");
            $sheet->setCellValue('D' . $row_num, "Total");
            $row_num++;

            $data = $this->db
               ->join("TblFinanceCategory", "TblFinancial.FinancialCategory=TblFinanceCategory.FinanceCatId")
               ->where("TblFinanceCategory.FinanceCatName", $row["name"])
               ->where("TblFinanceCategory.FinanceCatParent", $key["id"])
               ->where("isDelete", 0)
               ->where("FinancialDate >=", $datestart)
               ->where("FinancialDate <=", $dateend)
               ->like("MsWorkplaceId", $store)
               ->order_by("")
               ->get("TblFinancial")->result();
            $total = 0;
            $no = 0;
            foreach ($data as $rows) {
               $no++;
               $sheet->setCellValue('A' . $row_num, $no);
               $sheet->setCellValue('B' . $row_num, $rows->FinancialDescription);
               $sheet->setCellValue('C' . $row_num, $rows->FinancialDate);
               $sheet->setCellValue('D' . $row_num, number_format($rows->FinancialTotal));
               $sheet->getStyle('A' . $row_num . ':D' . $row_num)->getFont()->setSize(11);
               $row_num++;
               $total +=  $rows->FinancialTotal;
            }

            $sheet->setCellValue('C' . $row_num, "Grand Total");
            $sheet->setCellValue('D' . $row_num, number_format($total));
            $sheet->getStyle('A' . $row_num . ':D' . $row_num)->getFont()->setSize(11);
            $sheet->getStyle('A' . $row_num . ':D' . $row_num)->getFont()->setBold(true);
            $sheet->getStyle('A' . $row_num)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);
            $sheet->getStyle('A' . $row_num . ':D' . $row_num)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle('A' . $row_num . ':D' . $row_num)->getFill()->getStartColor()->setRGB('ebebeb');
            $row_num += 2;
         }
         $id_index++;

         $sheet->getColumnDimension('A')->setWidth(4);
         $sheet->getColumnDimension('B')->setWidth(120);
         $sheet->getColumnDimension('C')->setWidth(20);
         $sheet->getColumnDimension('D')->setWidth(20);
      }
      $writer = new Xlsx($spreadsheet);

      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="Data-pettycash.xlsx"');
      header('Cache-Control: max-age=0');

      $writer->save('php://output');
   }
}
