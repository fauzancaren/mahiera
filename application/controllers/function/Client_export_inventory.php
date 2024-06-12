<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Protection;

class Client_export_inventory extends CI_Controller
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
         ->join("TblMsVendor", "TblMsVendor.MsVendorId=TblGRPO.MsVendorId", "left")
         ->where("GRPOId", $id)
         ->get("TblGRPO")->row();
      $data["_header"] = ' <header>
										<img src="' . base_url("asset/image/kop/Header") . $result->MsWorkplaceId . 'jpg" style="width: 90%;">
										<div class="judul"><span>Good Received Purchase Order</span></div>
										<div class="cetak"><span>' . date("Y/m/d H:i:s") . '</span></div>
									</header>';
      $data["_data"] = $result;
      if ($result->MsCustomerTypeId == null) {
         $data["_customer"] = "-";
      } else {
         $data["_customer"] =  ($result->MsCustomerTypeId == 1 ? $result->MsCustomerName : $result->MsCustomerName . ' (' . $result->MsCustomerCompany . ')');
      }
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
      $this->pdf->load_view('report/inventory/grpo_a5', $data);
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
      $this->pdf->load_view('report/sales/po_a6', $data);
   }


   public function ti($id)
   {
      $code = $this->input->post("code");
      if (isset($code)) {
         $code = $this->db->select("InvTIId")->where("InvTICode", $code)->get("TblInvTI")->row();
         $id = $code->InvTIId;
      }
      $result = $this->db
         ->select("*,a.MsWorkplaceCode as src,b.MsWorkplaceId as dstid, b.MsWorkplaceCode as dst")
         ->join("TblMsEmployee", "TblInvTI.MsEmpId=TblMsEmployee.MsEmpId", "left")
         ->join("TblMsWorkplace as a", "a.MsWorkplaceId=TblInvTI.InvTISrc", "left")
         ->join("TblMsWorkplace as b", "b.MsWorkplaceId=TblInvTI.InvTIDst", "left")
         ->where("InvTIId", $id)
         ->get("TblInvTI")->row();
      $data["_header"] = ' <header>
										<img src="' . base_url("asset/image/kop/Header") . $result->dstid . '.jpg" style="width: 90%;">
										<div class="judul"><span>Transfer IN</span></div>
										<div class="cetak"><span>' . date("Y/m/d H:i:s") . '</span></div>
									</header>';
      $data["_data"] = $result;
      $data["_item"] = $this->db
         ->join("TblMsItem", "TblInvTIDetail.MsItemId=TblMsItem.MsItemId")
         ->join("TblMsItemCategory", "TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId")
         ->where("InvTIDetailRef", $result->InvTICode)
         ->get("TblInvTIDetail")->result();
      //$this->pdf->setPaper('A4', 'potrait');
      $this->pdf->setPaper(array(0, 0, 595.28, 420.94), 'potrait');
      //$this->pdf->setPaper('A4', 'landscape');
      $this->pdf->set_option('isRemoteEnabled', true);
      $this->pdf->filename = "Export TI.pdf";
      $this->pdf->load_view('report/inventory/ti', $data);
      //$this->load->view('report/inventory/ti', $data);
   }
   public function to($id)
   {
      $code = $this->input->post("code");
      if (isset($code)) {
         $code = $this->db->select("InvTOId")->where("InvTOCode", $code)->get("TblInvTO")->row();
         $id = $code->InvTOId;
      }
      $result = $this->db
         ->select("*,a.MsWorkplaceCode as src,a.MsWorkplaceId as srcid, b.MsWorkplaceCode as dst")
         ->join("TblMsEmployee", "TblInvTO.MsEmpId=TblMsEmployee.MsEmpId", "left")
         ->join("TblMsWorkplace as a", "a.MsWorkplaceId=TblInvTO.InvTOSrc", "left")
         ->join("TblMsWorkplace as b", "b.MsWorkplaceId=TblInvTO.InvTODst", "left")
         ->where("InvTOId", $id)
         ->get("TblInvTO")->row();
      $data["_header"] = ' <header>
										<img src="' . base_url("asset/image/kop/Header") . $result->srcid . '.jpg" style="width: 90%;">
										<div class="judul"><span>Transfer OUT</span></div>
										<div class="cetak"><span>' . date("Y/m/d H:i:s") . '</span></div>
									</header>';
      $data["_data"] = $result;
      $data["_item"] = $this->db
         ->join("TblMsItem", "TblInvTODetail.MsItemId=TblMsItem.MsItemId")
         ->join("TblMsItemCategory", "TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId")
         ->where("InvTODetailRef", $result->InvTOCode)
         ->get("TblInvTODetail")->result();
      //$this->pdf->setPaper('A4', 'potrait');
      $this->pdf->setPaper(array(0, 0, 595.28, 420.94), 'potrait');
      //$this->pdf->setPaper('A4', 'landscape');
      $this->pdf->set_option('isRemoteEnabled', true);
      $this->pdf->filename = "Export TO.pdf";
      $this->pdf->load_view('report/inventory/to', $data);
      //$this->load->view('report/inventory/ti', $data);
   }
   public function iw($id)
   {
      $code = $this->input->post("code");
      if (isset($code)) {
         $code = $this->db->select("InvWasteId")->where("InvWasteCode", $code)->get("TblInvWaste")->row();
         $id = $code->InvWasteId;
      }
      $result = $this->db
         ->join("TblMsEmployee", "TblInvWaste.MsEmpId=TblMsEmployee.MsEmpId", "left")
         ->join("TblMsWorkplace", "TblMsWorkplace.MsWorkplaceId=TblInvWaste.MsWorkplaceId", "left")
         ->where("InvWasteId", $id)
         ->get("TblInvWaste")->row();
      $data["_header"] = ' <header>
										<img src="' . base_url("asset/image/kop/Header") . $result->MsWorkplaceId . '.jpg" style="width: 90%;">
										<div class="judul"><span>Barang Rusak</span></div>
										<div class="cetak"><span>' . date("Y/m/d H:i:s") . '</span></div>
									</header>';
      $data["_data"] = $result;
      $data["_item"] = $this->db
         ->join("TblMsItem", "TblInvWasteDetail.MsItemId=TblMsItem.MsItemId")
         ->join("TblMsItemCategory", "TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId")
         ->where("InvWasteDetailRef", $result->InvWasteCode)
         ->get("TblInvWasteDetail")->result();
      //$this->pdf->setPaper('A4', 'potrait');
      $this->pdf->setPaper(array(0, 0, 595.28, 420.94), 'potrait');
      //$this->pdf->setPaper('A4', 'landscape');
      $this->pdf->set_option('isRemoteEnabled', true);
      $this->pdf->filename = "Export Waste.pdf";
      $this->pdf->load_view('report/inventory/waste', $data);
      //$this->load->view('report/inventory/waste', $data);
   }
   public function is($id)
   {
      $code = $this->input->post("code");
      if (isset($code)) {
         $code = $this->db->select("InvSampleId")->where("InvSampleCode", $code)->get("TblInvSample")->row();
         $id = $code->InvSampleId;
      }
      $result = $this->db
         ->join("TblMsEmployee", "TblInvSample.MsEmpId=TblMsEmployee.MsEmpId", "left")
         ->join("TblMsWorkplace", "TblMsWorkplace.MsWorkplaceId=TblInvSample.MsWorkplaceId", "left")
         ->join("TblMsCustomer", "TblMsCustomer.MsCustomerId=TblInvSample.MsCustomerId", "left")
         ->where("InvSampleId", $id)
         ->get("TblInvSample")->row();
      $data["_header"] = ' <header>
										<img src="' . base_url("asset/image/kop/Header") . $result->MsWorkplaceId . '.jpg" style="width: 90%;">
										<div class="judul"><span>Barang Sampel</span></div>
										<div class="cetak"><span>' . date("Y/m/d H:i:s") . '</span></div>
									</header>';
      $data["_data"] = $result;
      $data["_customer"] = $this->model_app->get_customer_name($result->MsCustomerId);
      $data["_item"] = $this->db
         ->join("TblMsItem", "TblInvSampleDetail.MsItemId=TblMsItem.MsItemId")
         ->join("TblMsItemCategory", "TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId")
         ->where("InvSampleDetailRef", $result->InvSampleCode)
         ->get("TblInvSampleDetail")->result();
      //$this->pdf->setPaper('A4', 'potrait');
      $this->pdf->setPaper(array(0, 0, 595.28, 420.94), 'potrait');
      //$this->pdf->setPaper('A4', 'landscape');
      $this->pdf->set_option('isRemoteEnabled', true);
      $this->pdf->filename = "Export Sample.pdf";
      $this->pdf->load_view('report/inventory/sample', $data);
      //$this->load->view('report/inventory/waste', $data);
   }


   public function data_so_excel($id)
   {
      $spreadsheet = new Spreadsheet();
      $spreadsheet->getProperties()->setCreator('Syahrul Fauzan')
         ->setLastModifiedBy('Syahrul Fauzan')
         ->setTitle('Office 2007 XLSX Test Document')
         ->setSubject('Office 2007 XLSX Test Document')
         ->setDescription('EXPORT BY OBI-WEB')
         ->setKeywords('office 2007 openxml php')
         ->setCategory('Application');



      $worksheet = $spreadsheet->getActiveSheet();
      $worksheet->setTitle("master stock opname ");

      $worksheet->setCellValue('A1', 'InvStockId');
      $worksheet->setCellValue('B1', 'No');
      $worksheet->setCellValue('C1', 'Kode');
      $worksheet->setCellValue('D1', 'Nama');
      $worksheet->setCellValue('E1', 'Vendor');
      $worksheet->setCellValue('F1', 'Toko');
      $worksheet->setCellValue('G1', 'Ukuran');
      $worksheet->setCellValue('H1', 'UoM');
      $worksheet->setCellValue('I1', 'Stock');
      $worksheet->getStyle('A1:I1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $worksheet->getStyle('A1:I1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
      $worksheet->getStyle('A1:I1')->getFont()->setBold(true);
      $worksheet->getStyle('A1:I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFD5D5D5');

      $data = $this->db->join("TblMsItem", "TblMsItem.MsItemId=TblInvStock.MsItemId", "left")
         ->join("TblMsVendor", "TblMsVendor.MsVendorId=TblInvStock.MsVendorId", "left")
         ->join("TblMsWorkplace", "TblMsWorkplace.MsWorkplaceId=TblInvStock.MsWorkplaceId", "left")
         ->where("TblInvStock.MsWorkplaceId", $id)->get("TblInvStock")->result();
      $no = 2;
      foreach ($data as $row) {
         $worksheet->setCellValue('A' . $no, $row->InvStockId);
         $worksheet->setCellValue('B' . $no, $no - 1);
         $worksheet->setCellValue('C' . $no, $row->MsItemCode);
         $worksheet->setCellValue('D' . $no, $row->MsItemName);
         $worksheet->setCellValue('E' . $no, $row->MsVendorCode);
         $worksheet->setCellValue('F' . $no, $row->MsWorkplaceCode);
         $worksheet->setCellValue('G' . $no, $row->MsItemSize);
         $worksheet->setCellValue('H' . $no, $row->MsItemUoM);
         $worksheet->setCellValue('I' . $no, 0);
         $worksheet->getStyle('I' . $no)->getNumberFormat()->setFormatCode('#,##0.00');

         $worksheet->getStyle('A' . $no . ':H' . $no)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFF2F2F2');
         $no++;
      }
      $spreadsheet->getActiveSheet()->setAutoFilter('B1:H1');

      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(0);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(35);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(10);
      $spreadsheet->getActiveSheet()->protectCells('A2:H' . $no, 'OBI');
      $worksheet->getStyle('I2:I' . $no)->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
      $spreadsheet->getActiveSheet()->getProtection()->setSheet(true);

      // Save Excel 2007 file 
      $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
      $writer->setIncludeCharts(true);

      header('Content-Type: application/vnd.ms-excel'); // generate excel file
      header('Content-Disposition: attachment;filename="data-stock-opname.xlsx"');
      header('Cache-Control: max-age=0');
      $writer->save('php://output');   // download file
   }

   public function upload_so_excel()
   {

      if (isset($_FILES["file"]["name"])) {
         $path =  $_FILES["file"]["tmp_name"];

         $object = PhpOffice\PhpSpreadsheet\IOFactory::load($path);
         foreach ($object->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            for ($row = 2; $row <= $highestRow; $row++) {
               //InvStockId	No	Kode	Nama	Vendor	Toko	Ukuran	UoM	Stock

               $InvStockId = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
               $MsItemCode = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
               $MsItemName = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
               $MsVendorCode = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
               $MsWorkplaceCode = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
               $MsItemSize = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
               $MsItemUoM = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
               $MsItemStock = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
               $data[] = array(
                  'InvStockId'  => $InvStockId,
                  'MsItemCode'   => $MsItemCode,
                  'MsItemName'    => $MsItemName,
                  'MsVendorCode'  => $MsVendorCode,
                  'MsWorkplaceCode'   => $MsWorkplaceCode,
                  'MsItemSize'   => $MsItemSize,
                  'MsItemUoM'   => $MsItemUoM,
                  'MsItemStock'   => $MsItemStock
               );
            }
         }
         echo JSON_ENCODE($data);
      }
   }
}
