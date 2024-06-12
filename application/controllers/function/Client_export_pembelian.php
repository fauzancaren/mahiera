<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
class Client_export_pembelian extends CI_Controller
{
   function __construct()
   {
      parent::__construct();

      $this->load->library('pdf');
      $this->load->model('model_app');
      date_default_timezone_set('Asia/Jakarta');
   }


   public function grpo_a5($id)
   {
      $result = $this->db
         ->select("*,TblGRPO.MsWorkplaceId")
         ->join("TblPO", "TblPO.POCode=TblGRPO.GRPORef", "left")
         ->join("TblSales", "TblSales.SalesCode=TblPO.SalesRef", "left")
         ->join("TblMsCustomer", "TblSales.MsCustomerId=TblMsCustomer.MsCustomerId", "left")
         ->join("TblMsEmployee", "TblSales.MsEmpId=TblMsEmployee.MsEmpId", "left")
         ->join("TblMsVendor", "TblMsVendor.MsVendorId=TblGRPO.MsVendorId", "left")
         ->where("GRPOId", $id)
         ->get("TblGRPO")->row();
      $data["_header"] = ' <header>
										<img src="' . base_url("asset/image/kop/Header") . $result->MsWorkplaceId . '.jpg" style="width: 90%;">
										<div class="judul"><span>Good Received Purchase Order</span></div>
										<div class="cetak"><span>' . date("Y/m/d H:i:s") . '</span></div>
									</header>';
      $data["_data"] = $result;
      $data["_item"] = $this->db
         ->join("TblGRPO", "TblGRPO.GRPOCode=TblGRPODetail.GRPODetailRef")
         ->join("TblMsVendor", "TblMsVendor.MsVendorId=TblGRPO.MsVendorId")
         ->join("TblMsItem", "TblGRPODetail.MsItemId=TblMsItem.MsItemId")
         ->join("TblMsItemCategory", "TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId")
         ->where("GRPODetailRef", $result->GRPOCode)
         ->get("TblGRPODetail")->result();
      $this->pdf->setPaper(array(0, 0, 595.28, 420.94), 'potrait');
      $this->pdf->set_option('isRemoteEnabled', true);
      $this->pdf->filename = "Export GRPO A5.pdf";
      $this->pdf->load_view('report/pembelian/grpo_a5', $data);
   }
   public function grpo_a6($id)
   {
      $result = $this->db
         ->join("TblSales", "TblSales.SalesCode=TblPO.SalesRef")
         ->join("TblMsCustomer", "TblSales.MsCustomerId=TblMsCustomer.MsCustomerId")
         ->join("TblMsEmployee", "TblSales.MsEmpId=TblMsEmployee.MsEmpId")
         ->join("TblMsVendor", "TblMsVendor.MsVendorId=TblPO.MsVendorId")
         ->where("POId", $id)
         ->get("TblPO")->row();
      if ($result->SalesHeader == 1) {
         $data["_header"] = ' <header>
											<img class="logo" src="' . base_url("asset/image/logo/logo-1-200.png") . '" width="140px">
											<div class="title">
												<span class="title-head">OMAHBATA INDONESIA</span><br>
												<span class="title-desc">Jl. Ciputat Raya No.59, RT.5/RW.2, Pondok Pinang, Kebayoran Lama, South Jakarta City, Jakarta 12310</span><br>
												<span class="title-desc">CS  : 0812-500-500-53</span><br>
												<span class="title-desc">Tlp : (021)-2912-5223</span><br>
												<span class="title-desc">WA  : 0812-820-1414/0812-810-1313</span>
											</div>
											<div class="judul"><span>Purchase Order</span></div>
										</header>';
         $data["_direct"] = "CS (+62 812-500-500-53) / Admin 1 (+62 812-820-1414) / Admin 2 (+62 812-810-1313)";
      } else if ($result->SalesHeader == 3) {
         $data["_header"] = ' <header>
											<img class="logo" src="' . base_url("asset/image/logo/logo-3-200.png") . '" width="140px">
											<div class="title">
												<span class="title-head">TOKO ROSTER BSD</span><br>
												<span class="title-desc">Jl. Ciater Raya No. 185 E Kampung Maruga RT 004/09 Kel. Ciater Kec. Serpong Tangerang Selatan 15310</span><br>
												<span class="title-desc">WA  : 0812-1348-1313</span><br>
												<span class="title-desc">CS  : 0812-500-500-53</span><br>
												<span class="title-desc">Tlp : (021)-7568-5590</span>
											</div>
											<div class="judul"><span>Purchase Order</span></div>
										</header>';
         $data["_direct"] = "Admin (+62 812-1348-1313)";
      } else if ($result->SalesHeader == 4) {
         $data["_header"] = ' <header>
											<img class="logo" src="' . base_url("asset/image/logo/logo-4-200.png") . '" width="140px">
											<div class="title">
												<span class="title-head">PABRIK ROSTER BOGOR</span><br>
												<span class="title-desc">Jl. Raya Bogor KM.41 RT001/RW05 Kel Pabuaran kec Cibinong Bogor Jawa Barat 16916</span><br>
												<span class="title-desc">WA  : 0813-1234-8313</span>
											</div>
											<div class="judul"><span>Purchase Order</span></div>
										</header>';
         $data["_direct"] = "Admin (+62 813-1234-8313)";
      } else if ($result->SalesHeader == 5) {
         $data["_header"] = ' <header>
											<img class="logo" src="' . base_url("asset/image/logo/logo-5-200.png") . '" width="140px">
											<div class="title">
												<span class="title-head">GLOCANA INDUSTRIAL FURNITURE</span><br>
												<span class="title-desc">Jl. Ciputat Raya No.59, RT.5/RW.2, Pondok Pinang, Kebayoran Lama, South Jakarta City, Jakarta 12310</span><br>
												<span class="title-desc">WA  : 0817-1773-1313</span>
											</div>
											<div class="judul"><span>Purchase Order</span></div>
										</header>';
         $data["_direct"] = "Admin (+62 817-1773-8313)";
      } else if ($result->SalesHeader == 6) {
         $data["_header"] = ' <header>
											<img class="logo" src="' . base_url("asset/image/logo/logo-6-200.png") . '" width="140px">
											<div class="title">
												<span class="title-head">OMAHBATA STUDIO</span><br>
												<span class="title-desc">Jl. Ciputat Raya No.59, RT.5/RW.2, Pondok Pinang, Kebayoran Lama, South Jakarta City, Jakarta 12310</span><br>
												<span class="title-desc">WA  : 0812-5685-1313</span>
											</div>
											<div class="judul"><span>Purchase Order</span></div>
										</header>';
         $data["_direct"] = "Admin (+62 812-5685-1313)";
      }
      $data["_data"] = $result;
      $data["_item"] = $this->db
         ->join("TblPO", "TblPO.POCode=TblPODetail.PODetailRef")
         ->join("TblMsVendor", "TblMsVendor.MsVendorId=TblPO.MsVendorId")
         ->join("TblMsItem", "TblPODetail.MsItemId=TblMsItem.MsItemId")
         ->join("TblMsItemCategory", "TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId")
         ->where("PODetailRef", $result->POCode)
         ->get("TblPODetail")->result();
      //$this->pdf->setPaper('A4', 'potrait');
      $this->pdf->setPaper(array(0, 0, 297.64, 420.94), 'potrait');
      //$this->pdf->setPaper(array(0, 0, 595.28, 420.94), 'potrait');
      //$this->pdf->setPaper('A4', 'landscape');
      $this->pdf->set_option('isRemoteEnabled', true);
      $this->pdf->filename = "Export PO A5.pdf";
      $this->pdf->load_view('report/pembelian/po_a6', $data);
   }
   public function po(){
      if($this->input->get("store")!=""){
         $this->db->where("TblPO.MsWorkplaceId",$this->input->get("store"));
      };
      $result = $this->db
      ->join("TblMsWorkplace", "TblPO.MsWorkplaceId=TblMsWorkplace.MsWorkplaceId") 
      ->join("TblMsVendor", "TblMsVendor.MsVendorId=TblPO.MsVendorId") 
      ->join("TblPODetail", "TblPODetail.PODetailRef=TblPO.POCode") 
      ->join("TblMsItem", "TblPODetail.MsItemId=TblMsItem.MsItemId") 
      ->where("PODate >=",$this->input->get("datestart"))
      ->where("PODate <=",$this->input->get("dateend")) 
      ->get("TblPO")->result(); 

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
      $sheet->mergeCells("C1:L1");
      $sheet->getStyle("C1:L1")->getFont()->setSize(36);
      $sheet->getStyle("C1:L1")->getFont()->setBold(true);
      $sheet->getStyle("C1")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle("C1")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);

      $sheet->setCellValue('C2', 'DATA PO VENDOR');
      $sheet->getRowDimension(2)->setRowHeight(40);
      $sheet->mergeCells("C2:L2");
      $sheet->getStyle("C2:L2")->getFont()->setSize(26);
      $sheet->getStyle("C2:L2")->getFont()->setBold(true);
      $sheet->getStyle("C2")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle("C2")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

      $sheet->setCellValue('C3', 'Periode : ' . date_format(date_create($this->input->get("datestart")), "d F Y")  . ' - ' . date_format(date_create($this->input->get("dateend")), "d F Y"));
      $sheet->getRowDimension(3)->setRowHeight(20);
      $sheet->mergeCells("C3:L3");
      $sheet->getStyle("C3:L3")->getFont()->setSize(14);
      $sheet->getStyle("C3:L3")->getFont()->setBold(true);
      $sheet->getStyle("C3")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle("C3")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

      $store = $this->model_app->get_single_data("MsWorkplaceCode", "TblMsWorkplace", array("MsWorkplaceId" => $this->input->get("store")));
      if ($store == "") {
         $store = "Semua Toko";
      }

      $sheet->setCellValue('C4', 'Toko : ' . $store);
      $sheet->getRowDimension(3)->setRowHeight(20);
      $sheet->mergeCells("C4:L4");
      $sheet->getStyle("C4:L4")->getFont()->setSize(14);
      $sheet->getStyle("C4:L4")->getFont()->setBold(true);
      $sheet->getStyle("C4")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle("C4")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

      //---------------------------  Header Table
      $sheet->setCellValue('A6', 'No');
      $sheet->setCellValue('B6', 'Tanggal');
      $sheet->setCellValue('C6', 'No. PO');
      $sheet->setCellValue('D6', 'No. Sales');
      $sheet->setCellValue('E6', 'Vendor');
      $sheet->setCellValue('F6', 'Toko');
      $sheet->setCellValue('G6', 'Keterangan');
      $sheet->setCellValue('H6', 'Kode Item');
      $sheet->setCellValue('I6', 'Nama Item');
      $sheet->setCellValue('J6', 'Ukuran');
      $sheet->setCellValue('K6', 'Qty');
      $sheet->setCellValue('L6', 'Satuan'); 

      $no_urut = 1;
      $col = 7;
      foreach($result as $row){
         $sheet->setCellValue("A" . $col, $no_urut);
			$sheet->setCellValue("B" . $col, date_format(date_create($row->PODate), "d F Y"));
			$sheet->setCellValue("C" . $col, $row->POCode);
			$sheet->setCellValue("D" . $col, $row->SalesRef);
			$sheet->setCellValue("E" . $col, $row->MsVendorCode . " - " . $row->MsVendorName);
			$sheet->setCellValue("F" . $col, $row->MsWorkplaceCode);
			$sheet->setCellValue("G" . $col, $row->PORemarks); 
			$sheet->setCellValue("H" . $col, $row->MsItemCode); 
			$sheet->setCellValue("I" . $col, $row->MsItemName); 
			$sheet->setCellValue("J" . $col, $row->MsItemSize); 
			$sheet->setCellValue("K" . $col, $row->PODetailQty); 
			$sheet->setCellValue("L" . $col, $row->MsItemUoM); 
         $no_urut++;
         $col++;
      }
      $sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getColumnDimension('D')->setAutoSize(true);
		$sheet->getColumnDimension('E')->setAutoSize(true);
		$sheet->getColumnDimension('F')->setAutoSize(true);
		$sheet->getColumnDimension('G')->setAutoSize(true);
		$sheet->getColumnDimension('H')->setAutoSize(true);
		$sheet->getColumnDimension('I')->setAutoSize(true);
		$sheet->getColumnDimension('J')->setAutoSize(true);
		$sheet->getColumnDimension('K')->setAutoSize(true);
		$sheet->getColumnDimension('L')->setAutoSize(true);

      // Save Excel 2007 file 
		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->setIncludeCharts(true);

		$filename = "REPORT PO VENDOR " . $this->input->post("datestart") . " " . $this->input->post("dateend"); // set filename for excel file to be exported
		header('Content-Type: application/vnd.ms-excel'); // generate excel file
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');	// download file
   }
}
