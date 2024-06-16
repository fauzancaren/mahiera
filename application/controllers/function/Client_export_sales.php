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

class Client_export_sales extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('Pdf');
		$this->load->model('model_app'); 
		date_default_timezone_set('Asia/Jakarta');
	}
	public function quotation_export_excel()
	{
		$this->db->join("TblMsCustomerDelivery", "TblMsCustomerDelivery.MsCustomerDeliveryId=TblQuotation.MsCustomerDeliveryId", "LEFT");
		$this->db->join("TblMsCustomer", "TblMsCustomer.MsCustomerId=TblQuotation.MsCustomerId", "LEFT");
		$this->db->where("QuoDate >=", $this->input->get("datestart"))->where("QuoDate <=", $this->input->get("dateend"));
		if ($this->input->get("store") != "-") $this->db->where("MsWorkplaceId", $this->input->get("store"));
		$result = $this->db->get("TblQuotation")->result();

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
		$sheet->mergeCells("C1:P1");
		$sheet->getStyle("C1:P1")->getFont()->setSize(36);
		$sheet->getStyle("C1:P1")->getFont()->setBold(true);
		$sheet->getStyle("C1")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("C1")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);

		$sheet->setCellValue('C2', 'DATA QUOTATION');
		$sheet->getRowDimension(2)->setRowHeight(40);
		$sheet->mergeCells("C2:P2");
		$sheet->getStyle("C2:P2")->getFont()->setSize(26);
		$sheet->getStyle("C2:P2")->getFont()->setBold(true);
		$sheet->getStyle("C2")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("C2")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

		$sheet->setCellValue('C3', 'Periode : ' . date_format(date_create($this->input->get("datestart")), "d F Y")  . ' - ' . date_format(date_create($this->input->get("dateend")), "d F Y"));
		$sheet->getRowDimension(3)->setRowHeight(20);
		$sheet->mergeCells("C3:P3");
		$sheet->getStyle("C3:P3")->getFont()->setSize(14);
		$sheet->getStyle("C3:P3")->getFont()->setBold(true);
		$sheet->getStyle("C3")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("C3")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

		$store = $this->model_app->get_single_data("MsWorkplaceCode", "TblMsWorkplace", array("MsWorkplaceId" => $this->input->get("store")));
		if ($store == "") {
			$store = "Semua Toko";
		}
		$sheet->setCellValue('C4', 'Toko : ' . $store);
		$sheet->getRowDimension(3)->setRowHeight(20);
		$sheet->mergeCells("C4:P4");
		$sheet->getStyle("C4:P4")->getFont()->setSize(14);
		$sheet->getStyle("C4:P4")->getFont()->setBold(true);
		$sheet->getStyle("C4")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("C4")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);


		//---------------------------  Header Table
		$sheet->setCellValue('A6', 'No');
		$sheet->setCellValue('B6', 'Tanggal');
		$sheet->setCellValue('C6', 'No. Quotation');
		$sheet->setCellValue('D6', 'Customer');
		$sheet->setCellValue('E6', 'Telp');
		$sheet->setCellValue('F6', 'Alamat');
		$sheet->setCellValue('G6', 'Admin');
		$sheet->setCellValue('H6', 'Item');
		$sheet->setCellValue('I6', 'Qty');
		$sheet->setCellValue('J6', 'Total');
		$sheet->setCellValue('K6', 'Optional');
		$sheet->setCellValue('L6', 'Total');
		$sheet->setCellValue('M6', 'Sub Total');
		$sheet->setCellValue('N6', 'Pengiriman');
		$sheet->setCellValue('O6', 'Diskon');
		$sheet->setCellValue('P6', 'Grand Total');
		$sheet->setCellValue('Q6', 'Status');
		$sheet->getRowDimension(3)->setRowHeight(25);
		$sheet->getStyle("A6:Q6")->getFont()->setBold(true);
		$sheet->getStyle("A6:Q6")->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
		$sheet->getStyle('A6:Q6')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
		$sheet->getStyle('A6:Q6')->getFill()->getStartColor()->setARGB('FF25221d');
		$sheet->getStyle("A6:Q6")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("A6:Q6")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

		$sheet->getStyle('A6:Q6')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle('A6:Q6')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle('A6:Q6')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle('A6:Q6')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

		$col = 7;
		$no_urut = 1;
		foreach ($result as $row) {
			$name = $this->model_app->get_customer_name($row->MsCustomerId);
			$sheet->setCellValue("A" . $col, $no_urut);
			$sheet->setCellValue("B" . $col, date_format(date_create($row->QuoDate), "d F Y"));
			$sheet->setCellValue("C" . $col, $row->QuoCode);
			$sheet->setCellValue("D" . $col, $name);
			$sheet->setCellValue("E" . $col, $row->MsCustomerTelp1);
			$sheet->setCellValue("F" . $col, $row->MsCustomerAddress);
			$sheet->setCellValue("G" . $col, $this->model_app->get_single_data("MsEmpName", "TblMsEmployee", array("MsEmpId" => $row->MsEmpId)));
			$sheet->setCellValue("M" . $col, number_format($row->QuoSubTotal));
			$sheet->setCellValue("N" . $col, number_format($row->QuoDeliveryTotal));
			$sheet->setCellValue("O" . $col, number_format($row->QuoDiscTotal));
			$sheet->setCellValue("P" . $col, number_format($row->QuoGrandTotal));
			$sheet->setCellValue("Q" . $col, ($row->QuoStatus == 0 ? "PROGRESS" : ($row->QuoStatus == 1 ? "SELESAI" : "BATAL")));


			$dataitem = $this->db->join("TblMsItem", "TblMsItem.MsItemId=TblQuoDetail.MsItemId", "left")
				->where("QuoDetailRef", $row->QuoCode)
				->get("TblQuoDetail")->Result();
			$itemrow = $col;
			foreach ($dataitem as $rows) {
				$sheet->setCellValue("H" . $itemrow, $rows->MsItemName);
				$sheet->setCellValue("I" . $itemrow, $rows->QuoDetailQty);
				$sheet->setCellValue("J" . $itemrow, $rows->QuoDetailTotal);
				$itemrow++;
			}
			$dataoptional = $this->db->where("QuoOptionalRef", $row->QuoCode)->get("TblQuoOptional")->Result();
			$optionalrow = $col;
			foreach ($dataoptional as $rows) {
				$sheet->setCellValue("K" . $optionalrow, $rows->QuoOptionalDesc);
				$sheet->setCellValue("L" . $optionalrow, $rows->QuoOptionalPrice);
				$optionalrow++;
			}
			if ($optionalrow > $itemrow) {
				$col = $optionalrow;
			} else {
				$col = $itemrow;
			}
			$no_urut++;
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
		$sheet->getColumnDimension('M')->setAutoSize(true);
		$sheet->getColumnDimension('N')->setAutoSize(true);
		$sheet->getColumnDimension('O')->setAutoSize(true);
		$sheet->getColumnDimension('P')->setAutoSize(true);
		$sheet->setShowGridlines(false);

		$writer = new Xlsx($spreadsheet);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data-quotation-' . $this->input->get("datestart") . '-' . $this->input->get("dateend") . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}
	public function quotation($id)
	{
		$result = ($this->db->query("select * from TblQuotation left join TblMsCustomer ON TblQuotation.MsCustomerId=TblMsCustomer.MsCustomerId where QuoId='{$id}'")->result())[0];
		if ($result->QuoHeader == 1) {
			$data["_header"] = '<header>
				<img src="' . base_url("asset/image/kop/rrj_header.png") .'" style="width: 100%;"> 
			</header>';
			$data["_direct"] = "Admin (+62 812-1348-1313)";
		} else if ($result->QuoHeader == 2) {
			$data["_header"] = '<header>
				<img src="' . base_url("asset/image/kop/rrj_header.png") .'" style="width: 100%;"> 
			</header>';
			$data["_direct"] = "Admin (+62 812-1348-1313)";
		} else if ($result->QuoHeader == 3) {
			$data["_header"] = ' <header>
											<img src="' . base_url("asset/image/mgs-erp/Header.png") . '" style="width: 100%;">
											<img class="logo" src="' . base_url("asset/image/logo/logo-4-200.png") . '" width="140px">
											<div class="title">
												<span class="title-head">PABRIK ROSTER BOGOR</span><br>
												<span class="title-desc">Jl. Raya Bogor KM.28 RT01/RW05, Pekayon, Ps. Rebo, Jakarta Timur 13710</span><br>
												<span class="title-desc">WA  : 0813-1234-8313</span>
											</div>
										</header>';
			$data["_direct"] = "Admin (+62 813-1234-8313)";
		}  

		$data["_data"] = $result;
		$data["_item"] = $this->db->join("TblMsProduk","TblMsProduk.MsProdukId=TblQuoDetail.MsProdukId")->join("TblMsProdukSatuan","TblMsProdukSatuan.SatuanId=TblQuoDetail.SatuanId")->where("QuoDetailRef",$result->QuoCode)->get("TblQuoDetail")->result();
		$data["_optional"] = $this->db->query("select * from TblQuoOptional where QuoOptionalRef='" . $result->QuoCode . "'")->result();
		$data["_delivery"] = $this->db->query("select * from TblMsCustomerDelivery where MsCustomerDeliveryId='" . $result->MsCustomerDeliveryId . "'")->row();

		$this->pdf->setPaper('A4', 'potrait');
		//$this->pdf->setPaper('A4', 'landscape');
		$this->pdf->set_option('isRemoteEnabled', true);
		$this->pdf->filename = "Export Quotation.pdf";
		$this->pdf->load_view('report/sales/quotation', $data);
		//echo $this->load->view('report/sales/quotation', $data, true);
	}

	public function sales_export_excel()
	{
	}
	public function sales($id,$test = null)
	{
		$code = $this->input->post("code");
		if (isset($code)) {
			$code = $this->db->select("SalesId")->where("SalesCode", $code)->get("TblSales")->row();
			$id = $code->SalesId;
		}
		$result = ($this->db->query("select * from TblSales left join TblMsCustomer ON TblSales.MsCustomerId=TblMsCustomer.MsCustomerId left join TblMsEmployee on TblSales.MsEmpId=TblMsEmployee.MsEmpId where SalesId='{$id}' ")->result())[0];
		if ($result->SalesHeader == 1) {
			$data["_header"] = ' <header>
										<img class="logo" src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/logo-omahbata.png")) . '">
										<div class="store">INDONESIA</div>
										<div class="store-info">
											<div class="address">Jl. Ciputat Raya No.59, RT.5/RW.2, Pondok Pinang, Kebayoran Lama, <br>Jakarta Selatan, Jakarta 12310</div>
											<i class="icon-email"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-email.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="email">omahbataindonesia@gmail.com</div>
											<i class="icon-telp"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-phone.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="telp">Admin 0812-810-1313 - 0812-820-1414<br>CS (021) 2912-5223 - 0812-500-500-53</div>
											<i class="icon-instagram"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-instagram.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="instagram">omahbata</div>
											<i class="icon-website"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-website.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="website">www.omahbata.com</div>
										</div>
										<div class="judul">SALES ORDER</div>
										<div class="cetak">' . date("Y/m/d H:i:s") . '</div>
										<img class="barcode" src="' . $this->model_app->convert_image_url_to_base64(base_url("function/client_datatable_tools/get_barcode/omahbata")) . '">
										<div class="grid-1"></div>
										<div class="grid-2"></div>
									</header>';
			$urlold = site_url("function/client_export_sales/sales_load_qr/") . $result->SalesId . '/1';
		} else if ($result->SalesHeader == 3) {
			$data["_header"] = ' <header>
										<img class="logo" src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/logo-omahbata.png")) . '">
										<div class="store">BSD</div>
										<div class="store-info"> 
											<div class="address">Jl. Raya Ciater No.185 E Kampung Maruga Rt 004/09 Kelurahan<br>Ciater , Kecamatan Serpong ,Tangerang Selatan</div>
											<i class="icon-email"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-email.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="email">omahbata.bsd@gmail.com</div>
											<i class="icon-telp"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-phone.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="telp">Admin 0812-1348-1313 - (021)7568-5590 <br>CS 0812-500-500-53</div>
											<i class="icon-instagram"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-instagram.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="instagram">omahbata.bsd</div>
											<i class="icon-website"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-website.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="website">www.omahbata.com</div>
										</div>
										<div class="judul">SALES ORDER</div>
										<div class="cetak">' . date("Y/m/d H:i:s") . '</div>
										<img class="barcode" src="' . $this->model_app->convert_image_url_to_base64(base_url("function/client_datatable_tools/get_barcode/tokoroster")) . '">
										<div class="grid-1"></div>
										<div class="grid-2"></div>
									</header>';
			$urlold = site_url("function/client_export_sales/sales_load_qr/") . $result->SalesId . '/3';
		} else if ($result->SalesHeader == 4) {
			$data["_header"] = ' <header>
										<img class="logo" src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/logo-omahbata.png")) . '">
										<div class="store">BOGOR</div>
										<div class="store-info"> 
											<div class="address">Jl.Raya Bogor km.28 RT001 RW003 No.5, Kelurahan Pekayon, <br>Kec. Pasar Rebo Jaktim Kode Pos 13710</div>
											<i class="icon-email"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-email.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="email">pabrikrosterindonesia@gmail.com</div>
											<i class="icon-telp"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-phone.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="telp">Admin 0813-1234-8313<br>CS 0812-500-500-53</div>
											<i class="icon-instagram"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-instagram.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="instagram">pabrikroster.id</div>
											<i class="icon-website"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-website.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="website">www.pabrikroster.com</div>
										</div>
										<div class="judul">SALES ORDER</div>
										<div class="cetak">' . date("Y/m/d H:i:s") . '</div>
										<img class="barcode" src="' . $this->model_app->convert_image_url_to_base64(base_url("function/client_datatable_tools/get_barcode/pabrikroster")) . '">
										<div class="grid-1"></div>
										<div class="grid-2"></div>
									</header>';
			$urlold = site_url("function/client_export_sales/sales_load_qr/") . $result->SalesId . '/4';
		} else {
			$data["_header"] = '<header>
										<img class="logo-lama" src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/kop/Header". $result->SalesHeader . ".jpg")). '" style="width: 90%;">
										<div class="judul-lama">SALES ORDER</div>
										<div class="cetak-lama">' . date("Y/m/d H:i:s") . '</div> 
									</header>';
		}

		if ($result->SalesHeader == 5) {

			$data["_footer"] = ' 	<li>Pembayaran <b>DP 50% dan pelunasan</b> sebelum pengiriman<br></li>
										<li>Pembayaran melalui transfer pada No. Rekening<br><b>BCA 498 018 1508<br>GLOBAL CAKAR BUANA GROUP<br></b></li>
										<li>Harap konfirmasi ke kami apabila atas nama di rekening <b>berbeda</b> dengan nama yang tertera di invoice</li>
										<li>DP atau Pelunasan yang sudah masuk tidak bisa <b>dikembalikan</b></li>
										<li>Barang yang sudah dibeli tidak dapat <b>dikembalikam / ditukar</b></li>';
		} elseif ($result->SalesHeader == 7) {

			$data["_footer"] = ' 	<li>Pembayaran diharuskan <b>Lunas</b> agar PO bisa segera diproses</li>
									<li>Pembayaran melalui transfer pada No. Rekening<br>
										BCA <b>498 0375 990</b> OMAHBATA INDONESIA CV.<br>
										BNI <b>137 1428 786</b> OMAH BATA INDONESIA<br>
										MANDIRI <b>101 00 1177976 4</b> OMAHBATA INDONESIA<br> 
									</li> 
									<li>Harap konfirmasi ke kami apabila atas nama di rekening <b>berbeda</b> dengan nama yang tertera di invoice</li>
									<li>Pembayaran yang sudah masuk tidak bisa <b>dikembalikan / refund</b></li>
									<li>Barang yang sudah dibeli tidak dapat <b>dikembalikam / ditukar</b></li>';
		} else {
			$data["_footer"] = ' 	<li>Pembayaran diharuskan <b>Lunas</b> agar PO bisa segera diproses</li>
									<li>Pembayaran melalui transfer pada No. Rekening<br>
										BCA <b>498 0375 990</b> OMAHBATA INDONESIA CV.<br>
										BNI <b>137 1428 786</b> OMAH BATA INDONESIA<br>
										MANDIRI <b>101 00 1177976 4</b> OMAHBATA INDONESIA<br> 
									</li> 
									<li>Harap konfirmasi ke kami apabila atas nama di rekening <b>berbeda</b> dengan nama yang tertera di invoice</li>
									<li>DP atau Pelunasan yang sudah masuk tidak bisa <b>dikembalikan</b></li>
									<li>Barang yang sudah dibeli tidak dapat <b>dikembalikam / ditukar</b></li>';
		}
		$data["_data"] = $result;

		$data["_item"] = $this->db->join("TblMsProduk","TblMsProduk.MsProdukId=TblSalesDetail.MsProdukId")->join("TblMsSatuan","TblMsSatuan.SatuanId=TblSalesDetail.SatuanId")->where("SalesDetailRef",$result->SalesCode)->get("TblSalesDetail")->result();
		$data["_optional"] = $this->db->query("select * from TblSalesOptional where SalesOptionalRef='" . $result->SalesCode . "'")->result();

		//$this->pdf->setPaper('A4', 'potrait');
		$this->pdf->setPaper(array(0, 0, 595.28, 420.94), 'potrait');
		//$this->pdf->setPaper('A4', 'landscape');
		$this->pdf->set_option('isRemoteEnabled', true);
		$this->pdf->filename = "Export Sales.pdf";
		$test==null ? $this->pdf->load_view('report/sales/sales', $data): $this->load->view('report/sales/sales', $data); 
	}
	
	public function performa($id,$test = null)
	{
		$code = $this->input->post("code");
		if (isset($code)) {
			$code = $this->db->select("SalesId")->where("SalesCode", $code)->get("TblSales")->row();
			$id = $code->SalesId;
		}
		$result = ($this->db->query("select * from TblSales left join TblMsCustomer ON TblSales.MsCustomerId=TblMsCustomer.MsCustomerId left join TblMsEmployee on TblSales.MsEmpId=TblMsEmployee.MsEmpId where SalesId='{$id}' ")->result())[0];
		 
		if ($result->SalesHeader == 1) {
			$data["_header"] = ' <header>
										<img class="logo" src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/logo-omahbata.png")) . '">
										<div class="store">INDONESIA</div>
										<div class="store-info">
											<div class="address">Jl. Ciputat Raya No.59, RT.5/RW.2, Pondok Pinang, Kebayoran Lama, <br>Jakarta Selatan, Jakarta 12310</div>
											<i class="icon-email"><img src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-email.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="email">omahbataindonesia@gmail.com</div>
											<i class="icon-telp"><img src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-phone.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="telp">Admin 0812-810-1313 - 0812-820-1414<br>CS (021) 2912-5223 - 0812-500-500-53</div>
											<i class="icon-instagram"><img src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-instagram.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="instagram">omahbata</div>
											<i class="icon-website"><img src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-website.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="website">www.omahbata.com</div>
										</div>
										<div class="judul">PROFORMA INVOICE</div>
										<div class="cetak">' . date("Y/m/d H:i:s") . '</div>
										<img class="barcode" src="'.$this->model_app->convert_image_url_to_base64(site_url("function/client_datatable_tools/get_barcode/omahbata")) . '">
										<div class="grid-1"></div>
										<div class="grid-2"></div>
									</header>';
		} else if ($result->SalesHeader == 3) {
			$data["_header"] = ' <header>
										<img class="logo" src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/logo-omahbata.png")) . '">
										<div class="store">BSD</div>
										<div class="store-info"> 
											<div class="address">Jl. Raya Ciater No.185 E Kampung Maruga Rt 004/09 Kelurahan<br>Ciater , Kecamatan Serpong ,Tangerang Selatan</div>
											<i class="icon-email"><img src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-email.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="email">omahbata.bsd@gmail.com</div>
											<i class="icon-telp"><img src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-phone.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="telp">Admin 0812-1348-1313 - (021)7568-5590 <br>CS 0812-500-500-53</div>
											<i class="icon-instagram"><img src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-instagram.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="instagram">omahbata.bsd</div>
											<i class="icon-website"><img src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-website.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="website">www.omahbata.com</div>
										</div>
										<div class="judul">PROFORMA INVOICE</div>
										<div class="cetak">' . date("Y/m/d H:i:s") . '</div>
										<img class="barcode" src="'.$this->model_app->convert_image_url_to_base64(site_url("function/client_datatable_tools/get_barcode/tokoroster")) . '">
										<div class="grid-1"></div>
										<div class="grid-2"></div>
									</header>';
		} else if ($result->SalesHeader == 4) {
			$data["_header"] = ' <header>
										<img class="logo" src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/logo-omahbata.png")) . '">
										<div class="store">BOGOR</div>
										<div class="store-info"> 
											<div class="address">Jl.Raya Bogor km.28 RT001 RW003 No.5, Kelurahan Pekayon, <br>Kec. Pasar Rebo Jaktim Kode Pos 13710</div>
											<i class="icon-email"><img src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-email.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="email">pabrikrosterindonesia@gmail.com</div>
											<i class="icon-telp"><img src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-phone.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="telp">Admin 0813-1234-8313<br>CS 0812-500-500-53</div>
											<i class="icon-instagram"><img src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-instagram.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="instagram">pabrikroster.id</div>
											<i class="icon-website"><img src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-website.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="website">www.pabrikroster.com</div>
										</div>
										<div class="judul">PROFORMA INVOICE</div>
										<div class="cetak">' . date("Y/m/d H:i:s") . '</div>
										<img class="barcode" src="'.$this->model_app->convert_image_url_to_base64(site_url("function/client_datatable_tools/get_barcode/pabrikroster")) . '">
										<div class="grid-1"></div>
										<div class="grid-2"></div>
									</header>';
		} else {
			$data["_header"] = '<header>
										<img class="logo-lama" src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/kop/Header")) . $result->SalesHeader . '.jpg" style="width: 90%;">
										<div class="judul-lama">PROFORMA INVOICE</div>
										<div class="cetak-lama">' . date("Y/m/d H:i:s") . '</div> 
									</header>';
		}

		if ($result->SalesHeader == 5) {
			$data["_footer"] = '<li>Pembayaran melalui transfer pada No. Rekening<br>
									<b>BCA 498 018 1508<br>
									GLOBAL CAKAR BUANA GROUP</b><br>
								</li> 
								<li>DP atau Pelunasan yang sudah masuk tidak bisa <b>dikembalikan</b></li>
								<li>Barang yang sudah dibeli tidak dapat <b>dikembalikam / ditukar</b></li>';
		} else { 
			$data["_footer"] = '<li>Pembayaran melalui transfer pada No. Rekening<br>
									BCA <b>498 0375 990</b> OMAHBATA INDONESIA CV.<br>
									BNI <b>137 1428 786</b> OMAH BATA INDONESIA<br>
									MANDIRI <b>101 00 1177976 4</b> OMAHBATA INDONESIA<br> 
								</li> 
								<li>DP atau Pelunasan yang sudah masuk tidak bisa <b>dikembalikan</b></li>
								<li>Barang yang sudah dibeli tidak dapat <b>dikembalikam / ditukar</b></li>';
		}
		$data["_data"] = $result;

		$data["_item"] = $this->db->join("TblMsProduk","TblMsProduk.MsProdukId=TblSalesDetail.MsProdukId")->join("TblMsSatuan","TblMsSatuan.SatuanId=TblSalesDetail.SatuanId")->where("SalesDetailRef",$result->SalesCode)->get("TblSalesDetail")->result();
		$data["_optional"] = $this->db->query("select * from TblSalesOptional where SalesOptionalRef='" . $result->SalesCode . "'")->result();
		$data["_payment"] = ($this->db->query("select * from TblSalesPerforma left join TblMsMethod on TblSalesPerforma.MsMethodId=TblMsMethod.MsMethodId where PerformaRef='" . $result->SalesCode . "'")->result());
		//$this->pdf->setPaper('A4', 'potrait');
		$this->pdf->setPaper(array(0, 0, 595.28, 420.94), 'potrait');
		//$this->pdf->setPaper('A4', 'landscape');
		$this->pdf->set_option('isRemoteEnabled', true);
		$this->pdf->filename = "Export Payment.pdf";
		if($test==null){

			$this->pdf->load_view('report/sales/proforma', $data);
		}else{
			
			$this->load->view('report/sales/proforma', $data);
		} 
	}
	public function performa_old($id)
	{
		$code = $this->input->post("code");
		if (isset($code)) {
			$code = $this->db->select("SalesId")->where("SalesCode", $code)->get("TblSales")->row();
			$id = $code->SalesId;
		}
		$result = ($this->db->query("select * from TblSales left join TblMsCustomer ON TblSales.MsCustomerId=TblMsCustomer.MsCustomerId left join TblMsEmployee on TblSales.MsEmpId=TblMsEmployee.MsEmpId where SalesId='{$id}' ")->result())[0];
		$data["_header"] = ' <header>
										<img src="' . base_url("asset/image/kop/Header") . $result->SalesHeader . '.jpg" style="width: 90%;">
										<div class="judul"><span>PROFORMA INVOICE</span></div>
										<div class="cetak"><span>' . date("Y/m/d H:i:s") . '</span></div>
									</header>';
		$data["_data"] = $result;

		$data["_item"] = $this->db->query("select * from TblSalesDetail left join TblMsItem on TblSalesDetail.MsItemId=TblMsItem.MsItemId LEFT JOIN TblMsItemCategory on TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId  where SalesDetailRef='" . $result->SalesCode . "'")->result();
		$data["_optional"] = $this->db->query("select * from TblSalesOptional where SalesOptionalRef='" . $result->SalesCode . "'")->result();
		$data["_payment"] = ($this->db->query("select * from TblSalesPerforma left join TblMsMethod on TblSalesPerforma.MsMethodId=TblMsMethod.MsMethodId where PerformaRef='" . $result->SalesCode . "'")->result());
		//$this->pdf->setPaper('A4', 'potrait');
		$this->pdf->setPaper(array(0, 0, 595.28, 420.94), 'potrait');
		//$this->pdf->setPaper('A4', 'landscape');
		$this->pdf->set_option('isRemoteEnabled', true);
		$this->pdf->filename = "Export Performa.pdf";
		$this->pdf->load_view('report/sales/performa', $data);
		//$this->pdf->load_view('report/sales/performa2', $data);
		//$this->load->view('report/sales/performa2', $data);
	}
	public function payment($id,$test = null)
	{
		$code = $this->input->post("code");
		if (isset($code)) {
			$code = $this->db->select("SalesId")->where("SalesCode", $code)->get("TblSales")->row();
			$id = $code->SalesId;
		}
		$result = ($this->db->query("select * from TblSales left join TblMsCustomer ON TblSales.MsCustomerId=TblMsCustomer.MsCustomerId left join TblMsEmployee on TblSales.MsEmpId=TblMsEmployee.MsEmpId where SalesId='{$id}' ")->result())[0];
		 
		if ($result->SalesHeader == 1) {
			$data["_header"] = ' <header>
										<img class="logo" src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/logo-omahbata.png")) . '">
										<div class="store">INDONESIA</div>
										<div class="store-info">
											<div class="address">Jl. Ciputat Raya No.59, RT.5/RW.2, Pondok Pinang, Kebayoran Lama, <br>Jakarta Selatan, Jakarta 12310</div>
											<i class="icon-email"><img src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-email.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="email">omahbataindonesia@gmail.com</div>
											<i class="icon-telp"><img src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-phone.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="telp">Admin 0812-810-1313 - 0812-820-1414<br>CS (021) 2912-5223 - 0812-500-500-53</div>
											<i class="icon-instagram"><img src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-instagram.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="instagram">omahbata</div>
											<i class="icon-website"><img src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-website.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="website">www.omahbata.com</div>
										</div>
										<div class="judul">INVOICE</div>
										<div class="cetak">' . date("Y/m/d H:i:s") . '</div>
										<img class="barcode" src="'.$this->model_app->convert_image_url_to_base64(site_url("function/client_datatable_tools/get_barcode/omahbata")) . '">
										<div class="grid-1"></div>
										<div class="grid-2"></div>
									</header>';
		} else if ($result->SalesHeader == 3) {
			$data["_header"] = ' <header>
										<img class="logo" src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/logo-omahbata.png")) . '">
										<div class="store">BSD</div>
										<div class="store-info"> 
											<div class="address">Jl. Raya Ciater No.185 E Kampung Maruga Rt 004/09 Kelurahan<br>Ciater , Kecamatan Serpong ,Tangerang Selatan</div>
											<i class="icon-email"><img src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-email.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="email">omahbata.bsd@gmail.com</div>
											<i class="icon-telp"><img src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-phone.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="telp">Admin 0812-1348-1313 - (021)7568-5590 <br>CS 0812-500-500-53</div>
											<i class="icon-instagram"><img src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-instagram.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="instagram">omahbata.bsd</div>
											<i class="icon-website"><img src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-website.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="website">www.omahbata.com</div>
										</div>
										<div class="judul">INVOICE</div>
										<div class="cetak">' . date("Y/m/d H:i:s") . '</div>
										<img class="barcode" src="'.$this->model_app->convert_image_url_to_base64(site_url("function/client_datatable_tools/get_barcode/tokoroster")) . '">
										<div class="grid-1"></div>
										<div class="grid-2"></div>
									</header>';
		} else if ($result->SalesHeader == 4) {
			$data["_header"] = ' <header>
										<img class="logo" src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/logo-omahbata.png")) . '">
										<div class="store">BOGOR</div>
										<div class="store-info"> 
											<div class="address">Jl.Raya Bogor km.28 RT001 RW003 No.5, Kelurahan Pekayon, <br>Kec. Pasar Rebo Jaktim Kode Pos 13710</div>
											<i class="icon-email"><img src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-email.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="email">pabrikrosterindonesia@gmail.com</div>
											<i class="icon-telp"><img src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-phone.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="telp">Admin 0813-1234-8313<br>CS 0812-500-500-53</div>
											<i class="icon-instagram"><img src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-instagram.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="instagram">pabrikroster.id</div>
											<i class="icon-website"><img src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-website.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="website">www.pabrikroster.com</div>
										</div>
										<div class="judul">INVOICE</div>
										<div class="cetak">' . date("Y/m/d H:i:s") . '</div>
										<img class="barcode" src="'.$this->model_app->convert_image_url_to_base64(site_url("function/client_datatable_tools/get_barcode/pabrikroster")) . '">
										<div class="grid-1"></div>
										<div class="grid-2"></div>
									</header>';
		} else {
			$data["_header"] = '<header>
										<img class="logo-lama" src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/kop/Header")) . $result->SalesHeader . '.jpg" style="width: 90%;">
										<div class="judul-lama">INVOICE</div>
										<div class="cetak-lama">' . date("Y/m/d H:i:s") . '</div> 
									</header>';
		}

		if ($result->SalesHeader == 5) {
			$data["_footer"] = '<li>Pembayaran melalui transfer pada No. Rekening<br>
									<b>BCA 498 018 1508<br>
									GLOBAL CAKAR BUANA GROUP</b><br>
								</li> 
								<li>DP atau Pelunasan yang sudah masuk tidak bisa <b>dikembalikan</b></li>
								<li>Barang yang sudah dibeli tidak dapat <b>dikembalikam / ditukar</b></li>';
		} else { 
			$data["_footer"] = '<li>Pembayaran melalui transfer pada No. Rekening<br>
									BCA <b>498 0375 990</b> OMAHBATA INDONESIA CV.<br>
									BNI <b>137 1428 786</b> OMAH BATA INDONESIA<br>
									MANDIRI <b>101 00 1177976 4</b> OMAHBATA INDONESIA<br> 
								</li> 
								<li>DP atau Pelunasan yang sudah masuk tidak bisa <b>dikembalikan</b></li>
								<li>Barang yang sudah dibeli tidak dapat <b>dikembalikam / ditukar</b></li>';
		}
		$data["_data"] = $result;

		$data["_item"] = $this->db->join("TblMsProduk","TblMsProduk.MsProdukId=TblSalesDetail.MsProdukId")->join("TblMsSatuan","TblMsSatuan.SatuanId=TblSalesDetail.SatuanId")->where("SalesDetailRef",$result->SalesCode)->get("TblSalesDetail")->result();
		$data["_optional"] = $this->db->query("select * from TblSalesOptional where SalesOptionalRef='" . $result->SalesCode . "'")->result();
		$data["_payment"] = ($this->db->query("select * from TblSalesPayment left join TblMsMethod on TblSalesPayment.MsMethodId=TblMsMethod.MsMethodId where PaymentRef='" . $result->SalesCode . "'")->result());
		//$this->pdf->setPaper('A4', 'potrait');
		$this->pdf->setPaper(array(0, 0, 595.28, 420.94), 'potrait');
		//$this->pdf->setPaper('A4', 'landscape');
		$this->pdf->set_option('isRemoteEnabled', true);
		$this->pdf->filename = "Export Payment.pdf";
		if($test==null){

			$this->pdf->load_view('report/sales/payment', $data);
		}else{
			
			$this->load->view('report/sales/payment', $data);
		} 
	}
	public function delivery($id)
	{
		$code = $this->input->post("code");
		if (isset($code)) {
			$code = $this->db->select("DeliveryId")->where("DeliveryCode", $code)->get("TblDelivery")->row();
			$id = $code->DeliveryId;
		}
		$result = $this->db
			->join("TblSales", "TblSales.SalesCode=TblDelivery.DeliveryRef")
			->join("TblMsCustomer", "TblSales.MsCustomerId=TblMsCustomer.MsCustomerId")
			->join("TblMsCustomerDelivery", "TblMsCustomerDelivery.MsCustomerDeliveryId=TblDelivery.MsCustomerDeliveryId")
			->join("TblMsEmployee", "TblSales.MsEmpId=TblMsEmployee.MsEmpId")
			->join("TblMsDelivery", "TblMsDelivery.MsDeliveryId=TblDelivery.MsDeliveryId")
			->where("DeliveryId", $id)
			->get("TblDelivery")->row();

		if ($result->SalesHeader == 1) {
			$data["_header"] = ' <header>
										<img class="logo" src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/logo-omahbata.png")) . '">
										<div class="store">INDONESIA</div>
										<div class="store-info">
											<div class="address">Jl. Ciputat Raya No.59, RT.5/RW.2, Pondok Pinang, Kebayoran Lama, <br>Jakarta Selatan, Jakarta 12310</div>
											<i class="icon-email"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-email.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="email">omahbataindonesia@gmail.com</div>
											<i class="icon-telp"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-phone.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="telp">Admin 0812-810-1313 - 0812-820-1414<br>CS (021) 2912-5223 - 0812-500-500-53</div>
											<i class="icon-instagram"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-instagram.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="instagram">omahbata</div>
											<i class="icon-website"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-website.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="website">www.omahbata.com</div>
										</div>
										<div class="judul">SURAT JALAN</div>
										<div class="cetak">' . date("Y/m/d H:i:s") . '</div>
										<img class="barcode" src="' . $this->model_app->convert_image_url_to_base64(base_url("function/Client_export_sales/create_qr_code/" .  $result->MsCustomerDeliveryLat . '/' . $result->MsCustomerDeliveryLng)) . '">
										<div class="grid-1"></div>
										<div class="grid-2"></div>
									</header>';
		} else if ($result->SalesHeader == 3) {
			$data["_header"] = ' <header>
										<img class="logo" src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/logo-omahbata.png")) . '">
										<div class="store">BSD</div>
										<div class="store-info"> 
											<div class="address">Jl. Raya Ciater No.185 E Kampung Maruga Rt 004/09 Kelurahan<br>Ciater , Kecamatan Serpong ,Tangerang Selatan</div>
											<i class="icon-email"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-email.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="email">omahbata.bsd@gmail.com</div>
											<i class="icon-telp"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-phone.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="telp">Admin 0812-1348-1313 - (021)7568-5590 <br>CS 0812-500-500-53</div>
											<i class="icon-instagram"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-instagram.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="instagram">omahbata.bsd</div>
											<i class="icon-website"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-website.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="website">www.omahbata.com</div>
										</div>
										<div class="judul">SURAT JALAN</div>
										<div class="cetak">' . date("Y/m/d H:i:s") . '</div>
										<img class="barcode" src="' . $this->model_app->convert_image_url_to_base64(base_url("function/Client_export_sales/create_qr_code/" .  $result->MsCustomerDeliveryLat . '/' . $result->MsCustomerDeliveryLng)) . '">
										<div class="grid-1"></div>
										<div class="grid-2"></div>
									</header>';
		} else if ($result->SalesHeader == 4) {
			$data["_header"] = ' <header>
										<img class="logo" src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/logo-omahbata.png")) . '">
										<div class="store">BOGOR</div>
										<div class="store-info"> 
											<div class="address">Jl.Raya Bogor km.28 RT001 RW003 No.5, Kelurahan Pekayon, <br>Kec. Pasar Rebo Jaktim Kode Pos 13710</div>
											<i class="icon-email"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-email.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="email">pabrikrosterindonesia@gmail.com</div>
											<i class="icon-telp"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-phone.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="telp">Admin 0813-1234-8313<br>CS 0812-500-500-53</div>
											<i class="icon-instagram"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-instagram.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="instagram">pabrikroster.id</div>
											<i class="icon-website"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-website.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="website">www.pabrikroster.com</div>
										</div>
										<div class="judul">SURAT JALAN</div>
										<div class="cetak">' . date("Y/m/d H:i:s") . '</div>
										<img class="barcode" src="' . $this->model_app->convert_image_url_to_base64(base_url("function/Client_export_sales/create_qr_code/" .  $result->MsCustomerDeliveryLat . '/' . $result->MsCustomerDeliveryLng)) . '">
										<div class="grid-1"></div>
										<div class="grid-2"></div>
									</header>';
		} else {
			// <img class="logo" src="' . base_url("asset/image/mgs-erp/logo-omahbata.png") . '">
			$data["_header"] = ' <header class="theme-red">
										<img class="logo" src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/logo/logo-".$result->SalesHeader."-200.png")) . '">
										 
										<div class="store-info">
											<div class="address">Jl. Ciputat Raya No.59, RT.5/RW.2, Pondok Pinang, Kebayoran Lama, <br>Jakarta Selatan, Jakarta 12310</div>
											<i class="icon-email"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-email.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="email">omahbataindonesia@gmail.com</div>
											<i class="icon-telp"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-phone.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="telp">0812-500-500-53</div>
											<i class="icon-instagram"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-instagram.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="instagram">conblocindo</div>
											<i class="icon-website"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-website.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="website">www.conblocindo.com</div>
										</div>
										<div class="judul">SURAT JALAN</div>
										<div class="cetak">' . date("Y/m/d H:i:s") . '</div>
										<img class="barcode" src="' . $this->model_app->convert_image_url_to_base64(base_url("function/Client_export_sales/create_qr_code/" .  $result->MsCustomerDeliveryLat . '/' . $result->MsCustomerDeliveryLng)) . '">
										<div class="grid-1"></div>
										<div class="grid-2"></div>
									</header>';
			// '<header>
			// 							<img class="logo-lama" src="' . base_url("asset/image/kop/Header") . $result->SalesHeader . '.jpg" style="width: 90%;">
			// 							<div class="judul-lama">SURAT JALAN</div>
			// 							<div class="cetak-lama">' . date("Y/m/d H:i:s") . '</div> 
			// 						</header>';
		}

		$data["_data"] = $result;
		$data["_item"] = $this->db->join("TblMsProduk","TblMsProduk.MsProdukId=TblDeliveryDetail.MsProdukId")->join("TblMsSatuan","TblMsSatuan.SatuanId=TblDeliveryDetail.SatuanId")->where("DeliveryDetailRef",$result->DeliveryCode)->get("TblDeliveryDetail")->result();
		 
		//$this->pdf->setPaper('A4', 'potrait');
		$this->pdf->setPaper(array(0, 0, 595.28, 420.94), 'potrait');
		//$this->pdf->setPaper('A4', 'landscape');
		$this->pdf->set_option('isRemoteEnabled', true);
		$this->pdf->filename = "Export delivery.pdf";
		$this->pdf->load_view('report/sales/delivery', $data);
		//$this->load->view('report/sales/delivery', $data);
	}
	public function sales_invoice_export()
	{
		$this->db
			->join("TblMsWorkplace", "TblMsWorkplace.MsWorkplaceId=TblSales.MsWorkplaceId", "Left")
			->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblSales.MsEmpId", "Left")
			->join("TblMsCustomer", "TblMsCustomer.MsCustomerId=TblSales.MsCustomerId", "Left")
			->where("SalesDate >=", $this->input->post("datestart"))
			->where("SalesDate <=", $this->input->post("dateend"))
			->where_in("SalesStatusPayment", array(1, 2));
		if ($this->input->post("store") != "-") $this->db->where("TblSales.MsWorkplaceId", $this->input->post("store"));
		$sales = $this->db->order_by("MsWorkplaceCode ASC, MsEmpName ASC")->get("TblSales")->result();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()->setCreator('Syahrul Fauzan')
			->setLastModifiedBy('Syahrul Fauzan')
			->setTitle('Office 2007 XLSX Test Document')
			->setSubject('Office 2007 XLSX Test Document')
			->setDescription('EXPORT BY OBI-WEB')
			->setKeywords('office 2007 openxml php')
			->setCategory('Application');

		$worksheet = $spreadsheet->getActiveSheet();
		$worksheet->setTitle("Penjualan By Invoice");

		$worksheet->setCellValue('A1', 'REPORT SALES BY INVOICE');
		$worksheet->setCellValue('A2', "Periode : " . $this->input->post("datestart") . " " . $this->input->post("dateend"));
		$worksheet->mergeCells('A1:I1');
		$worksheet->mergeCells('A2:I2');
		$worksheet->getStyle('A1:I1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$worksheet->getStyle('A1:I1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$worksheet->getStyle('A1:I1')->getFont()->setSize(15);
		$worksheet->getStyle('A1:I1')->getFont()->setBold(true);

		$worksheet->getStyle('A2:I2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$worksheet->getStyle('A2:I2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$worksheet->getStyle('A2:I2')->getFont()->setSize(12);
		$worksheet->getStyle('A2:I2')->getFont()->setBold(true);

		$worksheet->setCellValue('A4', 'Store');
		$worksheet->setCellValue('B4', 'Admin');
		$worksheet->setCellValue('C4', 'Customer');
		$worksheet->setCellValue('D4', 'Tanggal');
		$worksheet->setCellValue('E4', 'No. Invoice');
		$worksheet->setCellValue('F4', 'Total Transaksi');
		$worksheet->setCellValue('G4', 'Nama Item');
		$worksheet->setCellValue('H4', 'Qty');
		$worksheet->setCellValue('I4', 'Satuan');

		$lastrow = 5;
		foreach ($sales as $row) {
			if ($row->MsCustomerCompany == "" || $row->MsCustomerCompany == "-") {
				$customer = $row->MsCustomerName;
			} elseif ($row->MsCustomerName == "" || $row->MsCustomerName == "-") {
				$customer = $row->MsCustomerCompany;
			} else {
				$customer = $row->MsCustomerName . "(" . $row->MsCustomerCompany . ")";
			}
			$detail = $this->db
				->join("TblMsItem", "TblMsItem.MsItemId=TblSalesDetail.MsItemId", "left")
				->where("SalesDetailRef", $row->SalesCode)
				->get("TblSalesDetail")->result();
			foreach ($detail as $row_detail) {
				$worksheet->setCellValue('A' . $lastrow, $row->MsWorkplaceCode);
				$worksheet->setCellValue('B' . $lastrow, $row->MsEmpName);
				$worksheet->setCellValue('C' . $lastrow, $customer);
				$worksheet->setCellValue('D' . $lastrow, $row->SalesDate);
				$worksheet->setCellValue('E' . $lastrow, $row->SalesCode);
				$worksheet->setCellValue('F' . $lastrow, $row->SalesGrandTotal);
				$worksheet->setCellValue('G' . $lastrow, $row_detail->MsItemName);
				$worksheet->setCellValue('H' . $lastrow, $row_detail->SalesDetailQty);
				$worksheet->setCellValue('I' . $lastrow, $row_detail->MsItemUoM);
				$lastrow++;
			}
		}
		$cellIterator = $worksheet->getRowIterator()->current()->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(true);
		foreach ($cellIterator as $cell) {
			$worksheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
		}

		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->setIncludeCharts(true);

		$filename = "REPORT SALES BY INVOICE " . $this->input->post("datestart") . " " . $this->input->post("dateend"); // set filename for excel file to be exported
		header('Content-Type: application/vnd.ms-excel'); // generate excel file
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');	// download file
	}
	public function po_a5($id)
	{
		$code = $this->input->post("code");
		if (isset($code)) {
			$code = $this->db->select("POId")->where("POCode", $code)->get("TblPO")->row();
			$id = $code->POId;
		}
		$result = $this->db
			->select("*,TblPO.MsWorkplaceId")
			->join("TblSales", "TblSales.SalesCode=TblPO.SalesRef", "left")
			->join("TblMsCustomer", "TblSales.MsCustomerId=TblMsCustomer.MsCustomerId", "left")
			->join("TblMsEmployee", "TblSales.MsEmpId=TblMsEmployee.MsEmpId", "left")
			->join("TblMsVendor", "TblMsVendor.MsVendorId=TblPO.MsVendorId or TblMsVendor.MsVendorCode=TblPO.MsVendorCode " , "left")
			->where("POId", $id)
			->get("TblPO")->row();


		if ($result->SalesHeader == null) {
			if ($result->MsWorkplaceId == 1) {
				$data["_header"] = ' <header>
										<img class="logo" src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/logo-omahbata.png"))  . '">
										<div class="store">INDONESIA</div>
										<div class="store-info">
											<div class="address">Jl. Ciputat Raya No.59, RT.5/RW.2, Pondok Pinang, Kebayoran Lama, <br>Jakarta Selatan, Jakarta 12310</div>
											<i class="icon-email"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-email.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="email">omahbataindonesia@gmail.com</div>
											<i class="icon-telp"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-phone.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="telp">Admin 0812-810-1313 - 0812-820-1414<br>CS (021) 2912-5223 - 0812-500-500-53</div>
											<i class="icon-instagram"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-instagram.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="instagram">omahbata</div>
											<i class="icon-website"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-website.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="website">www.omahbata.com</div>
										</div>
										<div class="judul">PURCHASE ORDER</div>
										<div class="cetak">' . date("Y/m/d H:i:s") . '</div>
										<img class="barcode" src="' . $this->model_app->convert_image_url_to_base64(site_url("function/client_export_sales/sales_load_qr_po/") . $id) . '">
										<div class="grid-1"></div>
										<div class="grid-2"></div>
									</header>';
			} else if ($result->MsWorkplaceId == 3) {
				$data["_header"] = ' <header>
										<img class="logo" src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/logo-omahbata.png"))   . '">
										<div class="store">BSD</div>
										<div class="store-info"> 
											<div class="address">Jl. Raya Ciater No.185 E Kampung Maruga Rt 004/09 Kelurahan<br>Ciater , Kecamatan Serpong ,Tangerang Selatan</div>
											<i class="icon-email"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-email.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="email">omahbata.bsd@gmail.com</div>
											<i class="icon-telp"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-phone.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="telp">Admin 0812-1348-1313 - (021)7568-5590 <br>CS 0812-500-500-53</div>
											<i class="icon-instagram"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-instagram.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="instagram">omahbata.bsd</div>
											<i class="icon-website"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-website.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="website">www.omahbata.com</div>
										</div>
										<div class="judul">PURCHASE ORDER</div>
										<div class="cetak">' . date("Y/m/d H:i:s") . '</div>
										<img class="barcode" src="' . $this->model_app->convert_image_url_to_base64(site_url("function/client_export_sales/sales_load_qr_po/")) . $id . '">
										<div class="grid-1"></div>
										<div class="grid-2"></div>
									</header>';
			} else if ($result->MsWorkplaceId == 4) {
				$data["_header"] = ' <header>
										<img class="logo" src="' .$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/logo-omahbata.png"))   . '">
										<div class="store">BOGOR</div>
										<div class="store-info"> 
											<div class="address">Jl. Raya Jakarta-Bogor No.KM.41, RT.001/RW05, Pabuaran, Cibinong,<br>Kota Bogor, Jawa Barat 16916</div>
											<i class="icon-email"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-email.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="email">omahbata.bogor@gmail.com</div>
											<i class="icon-telp"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-phone.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="telp">Admin 0813-1234-8313<br>CS 0812-500-500-53</div>
											<i class="icon-instagram"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-instagram.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="instagram">omahbata.bogor</div>
											<i class="icon-website"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-website.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="website">www.omahbata.com</div>
										</div>
										<div class="judul">PURCHASE ORDER</div>
										<div class="cetak">' . date("Y/m/d H:i:s") . '</div>
										<img class="barcode" src="' . $this->model_app->convert_image_url_to_base64(site_url("function/client_export_sales/sales_load_qr_po/") . $id) . '">
										<div class="grid-1"></div>
										<div class="grid-2"></div>
									</header>';
			} else {
				$data["_header"] = '<header>
										<img class="logo-lama" src="' .$this->model_app->convert_image_url_to_base64(base_url("asset/image/kop/Header" . $result->SalesHeader  . '.jpg')).'" style="width: 90%;">
										<div class="judul-lama">PURCHASE ORDER</div>
										<div class="cetak-lama">' . date("Y/m/d H:i:s") . '</div> 
									</header>';
			}
		} else {
			if ($result->SalesHeader == 1) {
				$data["_header"] = ' <header>
										<img class="logo" src="' .$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/logo-omahbata.png")) . '">
										<div class="store">INDONESIA</div>
										<div class="store-info">
											<div class="address">Jl. Ciputat Raya No.59, RT.5/RW.2, Pondok Pinang, Kebayoran Lama, <br>Jakarta Selatan, Jakarta 12310</div>
											<i class="icon-email"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-email.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="email">omahbataindonesia@gmail.com</div>
											<i class="icon-telp"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-phone.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="telp">Admin 0812-810-1313 - 0812-820-1414<br>CS (021) 2912-5223 - 0812-500-500-53</div>
											<i class="icon-instagram"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-instagram.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="instagram">omahbata</div>
											<i class="icon-website"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-website.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="website">www.omahbata.com</div>
										</div>
										<div class="judul">PURCHASE ORDER</div>
										<div class="cetak">' . date("Y/m/d H:i:s") . '</div>
										<img class="barcode" src="' . $this->model_app->convert_image_url_to_base64(site_url("function/client_export_sales/sales_load_qr_po/". $id ) ). '">
										<div class="grid-1"></div>
										<div class="grid-2"></div>
									</header>';
			} else if ($result->SalesHeader == 3) {
				$data["_header"] = ' <header>
										<img class="logo" src="' .$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/logo-omahbata.png"))  . '">
										<div class="store">BSD</div>
										<div class="store-info"> 
											<div class="address">Jl. Raya Ciater No.185 E Kampung Maruga Rt 004/09 Kelurahan<br>Ciater , Kecamatan Serpong ,Tangerang Selatan</div>
											<i class="icon-email"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-email.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="email">omahbata.bsd@gmail.com</div>
											<i class="icon-telp"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-phone.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="telp">Admin 0812-1348-1313 - (021)7568-5590 <br>CS 0812-500-500-53</div>
											<i class="icon-instagram"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-instagram.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="instagram">omahbata.bsd</div>
											<i class="icon-website"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-website.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="website">www.omahbata.com</div>
										</div>
										<div class="judul">PURCHASE ORDER</div>
										<div class="cetak">' . date("Y/m/d H:i:s") . '</div>
										<img class="barcode" src="' . $this->model_app->convert_image_url_to_base64(site_url("function/client_export_sales/sales_load_qr_po/". $id )). '">
										<div class="grid-1"></div>
										<div class="grid-2"></div>
									</header>';
			} else if ($result->SalesHeader == 4) {
				$data["_header"] = ' <header>
										<img class="logo" src="' .$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/logo-omahbata.png")) . '">
										<div class="store">BOGOR</div>
										<div class="store-info"> 
											<div class="address">Jl. Raya Jakarta-Bogor No.KM.41, RT.001/RW05, Pabuaran, Cibinong,<br>Kota Bogor, Jawa Barat 16916</div>
											<i class="icon-email"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-email.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="email">omahbata.bogor@gmail.com</div>
											<i class="icon-telp"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-phone.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="telp">Admin 0813-1234-8313<br>CS 0812-500-500-53</div>
											<i class="icon-instagram"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-instagram.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="instagram">omahbata.bogor</div>
											<i class="icon-website"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-website.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="website">www.omahbata.com</div>
										</div>
										<div class="judul">PURCHASE ORDER</div>
										<div class="cetak">' . date("Y/m/d H:i:s") . '</div>
										<img class="barcode" src="' . $this->model_app->convert_image_url_to_base64(site_url("function/client_export_sales/sales_load_qr_po/". $id )). '">
										<div class="grid-1"></div>
										<div class="grid-2"></div>
									</header>';
			} else {
				$data["_header"] = '<header>
										<img class="logo-lama" src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/kop/Header". $result->SalesHeader . '.jpg')).'" style="width: 90%;">
										<div class="judul-lama">PURCHASE ORDER</div>
										<div class="cetak-lama">' . date("Y/m/d H:i:s") . '</div> 
									</header>';
			}
		}

		$data["_data"] = $result;
		if ($result->MsCustomerTypeId == null) {
			$data["_customer"] = "-";
		} else {
			$data["_customer"] =  ($result->MsCustomerTypeId == 1 ? $result->MsCustomerName : $result->MsCustomerName . ' (' . $result->MsCustomerCompany . ')');
		}
		$data["_data"] = $result;
		if ($result->MsEmpName == null) {
			$data["_admin"] = $result->POName;
		} else {
			$data["_admin"] = $result->MsEmpName;
		}
		$data["_item"] = $this->db->join("TblMsProduk","TblMsProduk.MsProdukId=TblPODetail.MsProdukId")->join("TblMsSatuan","TblMsSatuan.SatuanId=TblPODetail.SatuanId")->where("PODetailRef",$result->POCode)->get("TblPODetail")->result();
		//$this->pdf->setPaper('A4', 'potrait');
		$this->pdf->setPaper(array(0, 0, 595.28, 420.94), 'potrait');
		//$this->pdf->setPaper('A4', 'landscape');
		$this->pdf->set_option('isRemoteEnabled', true);
		$this->pdf->filename = "Export PO A5.pdf";
		$this->pdf->load_view('report/sales/po_a5', $data);
	}
	public function po_a6($id)
	{
		$result = $this->db
			->join("TblSales", "TblSales.SalesCode=TblPO.SalesRef")
			->join("TblMsCustomer", "TblSales.MsCustomerId=TblMsCustomer.MsCustomerId")
			->join("TblMsEmployee", "TblSales.MsEmpId=TblMsEmployee.MsEmpId")
			->join("TblMsVendor", "TblMsVendor.MsVendorCode=TblPO.MsVendorCode")
			->where("POId", $id)
			->get("TblPO")->row();
		if ($result->SalesHeader == 1) {
			$data["_header"] = ' <header>
											<img class="logo" src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/logo/logo-1-200.png")) . '" width="140px">
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
											<img class="logo" src="' .  $this->model_app->convert_image_url_to_base64(base_url("asset/image/logo/logo-3-200.png")) . '" width="140px">
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
											<img class="logo" src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/logo/logo-4-200.png")) . '" width="140px">
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
											<img class="logo" src="' .  $this->model_app->convert_image_url_to_base64(base_url("asset/image/logo/logo-5-200.png")) . '" width="140px">
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
											<img class="logo" src="' .  $this->model_app->convert_image_url_to_base64(base_url("asset/image/logo/logo-6-200.png")) . '" width="140px">
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
		$data["_item"] = $this->db->join("TblMsProduk","TblMsProduk.MsProdukId=TblPODetail.MsProdukId")->join("TblMsSatuan","TblMsSatuan.SatuanId=TblPODetail.SatuanId")->where("PODetailRef",$result->POCode)->get("TblPODetail")->result();
	 
		$data["_footer"] = '<img src="'.$this->model_app->convert_image_url_to_base64(base_url("asset/image/kop/pofooter1.jpg")).'" style="width: 100%;">';
		//$this->pdf->setPaper('A4', 'potrait');
		$this->pdf->setPaper(array(0, 0, 297.64, 420.94), 'potrait');
		//$this->pdf->setPaper(array(0, 0, 595.28, 420.94), 'potrait');
		//$this->pdf->setPaper('A4', 'landscape');
		$this->pdf->set_option('isRemoteEnabled', true);
		$this->pdf->filename = "Export PO A6.pdf";
		$this->pdf->load_view('report/sales/po_a6', $data);
	}

	public function to($id)
	{
		$code = $this->input->post("code");
		if (isset($code)) {
			$code = $this->db->select("InvTOId")->where("TOCode", $code)->get("TblInvTO")->row();
			$id = $code->InvTOId;
		}
		$result = $this->db
			->select("*,TblSales.MsWorkplaceId")
			->join("TblSales", "TblSales.SalesCode=TblInvTO.SalesRef", "left")
			->join("TblMsCustomer", "TblSales.MsCustomerId=TblMsCustomer.MsCustomerId", "left")
			->join("TblMsEmployee", "TblSales.MsEmpId=TblMsEmployee.MsEmpId", "left") 
			->where("InvTOId", $id)
			->get("TblInvTO")->row();


		if ($result->SalesHeader == null) {
			if ($result->MsWorkplaceId == 1) {
				$data["_header"] = ' <header>
										<img class="logo" src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/logo-omahbata.png"))  . '">
										<div class="store">INDONESIA</div>
										<div class="store-info">
											<div class="address">Jl. Ciputat Raya No.59, RT.5/RW.2, Pondok Pinang, Kebayoran Lama, <br>Jakarta Selatan, Jakarta 12310</div>
											<i class="icon-email"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-email.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="email">omahbataindonesia@gmail.com</div>
											<i class="icon-telp"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-phone.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="telp">Admin 0812-810-1313 - 0812-820-1414<br>CS (021) 2912-5223 - 0812-500-500-53</div>
											<i class="icon-instagram"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-instagram.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="instagram">omahbata</div>
											<i class="icon-website"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-website.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="website">www.omahbata.com</div>
										</div>
										<div class="judul">TRANSFER OUT</div>
										<div class="cetak">' . date("Y/m/d H:i:s") . '</div>
										<img class="barcode" src="' . $this->model_app->convert_image_url_to_base64(site_url("function/client_export_sales/sales_load_qr_po/") . $id) . '">
										<div class="grid-1"></div>
										<div class="grid-2"></div>
									</header>';
			} else if ($result->MsWorkplaceId == 3) {
				$data["_header"] = ' <header>
										<img class="logo" src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/logo-omahbata.png"))   . '">
										<div class="store">BSD</div>
										<div class="store-info"> 
											<div class="address">Jl. Raya Ciater No.185 E Kampung Maruga Rt 004/09 Kelurahan<br>Ciater , Kecamatan Serpong ,Tangerang Selatan</div>
											<i class="icon-email"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-email.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="email">omahbata.bsd@gmail.com</div>
											<i class="icon-telp"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-phone.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="telp">Admin 0812-1348-1313 - (021)7568-5590 <br>CS 0812-500-500-53</div>
											<i class="icon-instagram"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-instagram.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="instagram">omahbata.bsd</div>
											<i class="icon-website"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-website.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="website">www.omahbata.com</div>
										</div>
										<div class="judul">TRANSFER OUT</div>
										<div class="cetak">' . date("Y/m/d H:i:s") . '</div>
										<img class="barcode" src="' . $this->model_app->convert_image_url_to_base64(site_url("function/client_export_sales/sales_load_qr_po/")) . $id . '">
										<div class="grid-1"></div>
										<div class="grid-2"></div>
									</header>';
			} else if ($result->MsWorkplaceId == 4) {
				$data["_header"] = ' <header>
										<img class="logo" src="' .$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/logo-omahbata.png"))   . '">
										<div class="store">BOGOR</div>
										<div class="store-info"> 
											<div class="address">Jl. Raya Jakarta-Bogor No.KM.41, RT.001/RW05, Pabuaran, Cibinong,<br>Kota Bogor, Jawa Barat 16916</div>
											<i class="icon-email"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-email.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="email">omahbata.bogor@gmail.com</div>
											<i class="icon-telp"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-phone.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="telp">Admin 0813-1234-8313<br>CS 0812-500-500-53</div>
											<i class="icon-instagram"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-instagram.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="instagram">omahbata.bogor</div>
											<i class="icon-website"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-website.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="website">www.omahbata.com</div>
										</div>
										<div class="judul">TRANSFER OUT</div>
										<div class="cetak">' . date("Y/m/d H:i:s") . '</div>
										<img class="barcode" src="' . $this->model_app->convert_image_url_to_base64(site_url("function/client_export_sales/sales_load_qr_po/") . $id) . '">
										<div class="grid-1"></div>
										<div class="grid-2"></div>
									</header>';
			} else {
				$data["_header"] = '<header>
										<img class="logo-lama" src="' .$this->model_app->convert_image_url_to_base64(base_url("asset/image/kop/Header" . $result->SalesHeader  . '.jpg')).'" style="width: 90%;">
										<div class="judul-lama">TRANSFER OUT</div>
										<div class="cetak-lama">' . date("Y/m/d H:i:s") . '</div> 
									</header>';
			}
		} else {
			if ($result->SalesHeader == 1) {
				$data["_header"] = ' <header>
										<img class="logo" src="' .$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/logo-omahbata.png")) . '">
										<div class="store">INDONESIA</div>
										<div class="store-info">
											<div class="address">Jl. Ciputat Raya No.59, RT.5/RW.2, Pondok Pinang, Kebayoran Lama, <br>Jakarta Selatan, Jakarta 12310</div>
											<i class="icon-email"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-email.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="email">omahbataindonesia@gmail.com</div>
											<i class="icon-telp"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-phone.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="telp">Admin 0812-810-1313 - 0812-820-1414<br>CS (021) 2912-5223 - 0812-500-500-53</div>
											<i class="icon-instagram"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-instagram.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="instagram">omahbata</div>
											<i class="icon-website"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-website.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="website">www.omahbata.com</div>
										</div>
										<div class="judul">TRANSFER OUT</div>
										<div class="cetak">' . date("Y/m/d H:i:s") . '</div>
										<img class="barcode" src="' . $this->model_app->convert_image_url_to_base64(site_url("function/client_export_sales/sales_load_qr_po/". $id ) ). '">
										<div class="grid-1"></div>
										<div class="grid-2"></div>
									</header>';
			} else if ($result->SalesHeader == 3) {
				$data["_header"] = ' <header>
										<img class="logo" src="' .$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/logo-omahbata.png"))  . '">
										<div class="store">BSD</div>
										<div class="store-info"> 
											<div class="address">Jl. Raya Ciater No.185 E Kampung Maruga Rt 004/09 Kelurahan<br>Ciater , Kecamatan Serpong ,Tangerang Selatan</div>
											<i class="icon-email"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-email.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="email">omahbata.bsd@gmail.com</div>
											<i class="icon-telp"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-phone.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="telp">Admin 0812-1348-1313 - (021)7568-5590 <br>CS 0812-500-500-53</div>
											<i class="icon-instagram"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-instagram.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="instagram">omahbata.bsd</div>
											<i class="icon-website"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-website.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="website">www.omahbata.com</div>
										</div>
										<div class="judul">TRANSFER OUT</div>
										<div class="cetak">' . date("Y/m/d H:i:s") . '</div>
										<img class="barcode" src="' . $this->model_app->convert_image_url_to_base64(site_url("function/client_export_sales/sales_load_qr_po/". $id )). '">
										<div class="grid-1"></div>
										<div class="grid-2"></div>
									</header>';
			} else if ($result->SalesHeader == 4) {
				$data["_header"] = ' <header>
										<img class="logo" src="' .$this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/logo-omahbata.png")) . '">
										<div class="store">BOGOR</div>
										<div class="store-info"> 
											<div class="address">Jl. Raya Jakarta-Bogor No.KM.41, RT.001/RW05, Pabuaran, Cibinong,<br>Kota Bogor, Jawa Barat 16916</div>
											<i class="icon-email"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-email.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="email">omahbata.bogor@gmail.com</div>
											<i class="icon-telp"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-phone.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="telp">Admin 0813-1234-8313<br>CS 0812-500-500-53</div>
											<i class="icon-instagram"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-instagram.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="instagram">omahbata.bogor</div>
											<i class="icon-website"><img src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/mgs-erp/icon-website.svg")) . '" alt="My Happy SVG" width="10" height="10" /></i>
											<div class="website">www.omahbata.com</div>
										</div>
										<div class="judul">TRANSFER OUT</div>
										<div class="cetak">' . date("Y/m/d H:i:s") . '</div>
										<img class="barcode" src="' . $this->model_app->convert_image_url_to_base64(site_url("function/client_export_sales/sales_load_qr_po/". $id )). '">
										<div class="grid-1"></div>
										<div class="grid-2"></div>
									</header>';
			} else {
				$data["_header"] = '<header>
										<img class="logo-lama" src="' . $this->model_app->convert_image_url_to_base64(base_url("asset/image/kop/Header". $result->SalesHeader . '.jpg')).'" style="width: 90%;">
										<div class="judul-lama">TRANSFER OUT</div>
										<div class="cetak-lama">' . date("Y/m/d H:i:s") . '</div> 
									</header>';
			}
		}

		$data["_data"] = $result;
		if ($result->MsCustomerTypeId == null) {
			$data["_customer"] = "-";
		} else {
			$data["_customer"] =  ($result->MsCustomerTypeId == 1 ? $result->MsCustomerName : $result->MsCustomerName . ' (' . $result->MsCustomerCompany . ')');
		}
		$data["_data"] = $result;
		if ($result->MsEmpName == null) {
			$data["_admin"] = $result->POName;
		} else {
			$data["_admin"] = $result->MsEmpName;
		}
		$data["_item"] = $this->db->join("TblMsProduk","TblMsProduk.MsProdukId=TblInvTODetail.MsProdukId")->join("TblMsSatuan","TblMsSatuan.SatuanId=TblInvTODetail.SatuanId")->where("InvTODetailRef",$result->InvTOCode)->get("TblInvTODetail")->result();
		//$this->pdf->setPaper('A4', 'potrait');
		$this->pdf->setPaper(array(0, 0, 595.28, 420.94), 'potrait');
		//$this->pdf->setPaper('A4', 'landscape');
		$this->pdf->set_option('isRemoteEnabled', true);
		$this->pdf->filename = "Export TO.pdf";
		$this->pdf->load_view('report/sales/to', $data);
		//$this->load->view('report/sales/to', $data);
	}

	public function pengunjung()
	{
		$data = $this->db->query("SELECT * FROM TblVisitor left join TblMsWorkplace on TblVisitor.MsWorkplaceId=TblMsWorkplace.MsWorkplaceId 
		where TblVisitor.MsWorkplaceId = '{$this->input->get("store")}' and VisitorDate between '{$this->input->get("datestart")}' and '{$this->input->get("dateend")}' ")->result();

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
		$sheet->mergeCells("C1:I1");
		$sheet->getStyle("C1:I1")->getFont()->setSize(36);
		$sheet->getStyle("C1:I1")->getFont()->setBold(true);
		$sheet->getStyle("C1")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("C1")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);

		$sheet->setCellValue('C2', 'DATA KUNJUNGAN');
		$sheet->getRowDimension(2)->setRowHeight(40);
		$sheet->mergeCells("C2:I2");
		$sheet->getStyle("C2:I2")->getFont()->setSize(26);
		$sheet->getStyle("C2:I2")->getFont()->setBold(true);
		$sheet->getStyle("C2")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("C2")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

		//---------------------------  Header Table
		$sheet->setCellValue('A3', 'No');
		$sheet->setCellValue('B3', 'Tanggal');
		$sheet->setCellValue('C3', 'Toko');
		$sheet->setCellValue('D3', 'Status');
		$sheet->setCellValue('E3', 'Via');
		$sheet->setCellValue('F3', 'Konsultasi');
		$sheet->setCellValue('G3', 'Sampel');
		$sheet->setCellValue('H3', 'Pembelian');
		$sheet->setCellValue('I3', 'Pengambilan');
		$sheet->setCellValue('J3', 'Nama');
		$sheet->setCellValue('K3', 'Keterangan');
		$sheet->getRowDimension(3)->setRowHeight(25);
		$sheet->getStyle("A3:K3")->getFont()->setBold(true);
		$sheet->getStyle("A3:K3")->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
		$sheet->getStyle('A3:K3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
		$sheet->getStyle('A3:K3')->getFill()->getStartColor()->setARGB('FF25221d');
		$sheet->getStyle("A3:K3")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("A3:K3")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

		$sheet->getStyle('A3:K3')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle('A3:K3')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle('A3:K3')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle('A3:K3')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		//---------------------------  Isi Table
		$kolom = 4;
		$nomor = 1;
		foreach ($data as $row) {

			$sheet->getRowDimension($kolom)->setRowHeight(25);
			$sheet->getStyle("A" . $kolom . ":K" . $kolom)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("A" . $kolom . ":K" . $kolom)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			$sheet->getStyle("A" . $kolom . ":K" . $kolom)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle("A" . $kolom . ":K" . $kolom)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle("A" . $kolom . ":K" . $kolom)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle("A" . $kolom . ":K" . $kolom)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

			$sheet->setCellValue('A' . $kolom, $nomor);
			$sheet->setCellValue('B' . $kolom, $row->VisitorDate);
			$sheet->setCellValue('C' . $kolom, $row->MsWorkplaceCode);
			$sheet->setCellValue('D' . $kolom, ($row->VisitorType == 0 ? "BARU" : "LAMA"));
			$sheet->setCellValue('E' . $kolom, $row->VisitorVia);
			$sheet->setCellValue('F' . $kolom, $row->VisitorKonsultasi);
			$sheet->setCellValue('G' . $kolom, $row->VisitorSampel);
			$sheet->setCellValue('H' . $kolom, $row->VisitorPembelian);
			$sheet->setCellValue('I' . $kolom, $row->VisitorPengambilan);
			$sheet->setCellValue('J' . $kolom, $row->VisitorName);
			$sheet->setCellValue('K' . $kolom, $row->VisitorDescription);

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
		$sheet->getColumnDimension('I')->setAutoSize(true);
		$sheet->setShowGridlines(false);

		$writer = new Xlsx($spreadsheet);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data-kunjungan-' . $this->input->get("datestart") . '-' . $this->input->get("dateend") . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function sales_item()
	{
		$datestart = $this->input->get("datestart");
		$dateend = $this->input->get("dateend");
		$store = $this->input->get("store");
		if ($store == "-") {
			$toko = "semua Toko";
		} else {
			$toko = $this->model_app->get_single_data("MsWorkplaceCode", "TblMsWorkplace", array("MsWorkplaceId" => $store));
		}
		$this->db->join("TblMsCustomer", "TblSales.MsCustomerId = TblMsCustomer.MsCustomerId", "left")
			->join("TblSalesDetail", "TblSales.SalesCode = TblSalesDetail.SalesDetailRef", "left")
			->join("TblMsItem", "TblMsItem.MsItemId = TblSalesDetail.MsItemId", "left")
			->join("TblMsItemCategory", "TblMsItem.MsItemCatId = TblMsItemCategory.MsItemCatId", "left")
			->join("TblMsEmployee", "TblMsEmployee.MsEmpId = TblSales.MsEmpId", "left")
			->where("SalesDate >=", $datestart)->where("SalesDate <=", $dateend)->where_in("SalesStatusPayment", array(1, 2));
		if ($store != "-") $this->db->where("TblSales.MsWorkplaceId", $store);

		$result = $this->db->group_by("salesCode, MsItemCode, MsVendorCode")->order_by("SalesDate ASC, SalesId ASC")->get("TblSales")->result();

		$spreadsheet = new Spreadsheet(); // instantiate Spreadsheet
		$spreadsheet->getProperties()->setCreator('Syahrul Fauzan')
			->setLastModifiedBy('Syahrul Fauzan')
			->setTitle('Office 2007 XLSX Test Document')
			->setSubject('Office 2007 XLSX Test Document')
			->setDescription('EXPORT BY OBI-WEB')
			->setKeywords('office 2007 openxml php')
			->setCategory('Application');

		$colorHeader1 = "909090";
		$colorHeader2 = "838383";
		$colorHeader3 = "9c9c9c";
		$colorHeader4 = "a9a9a9";
		$colorRow1  = "dadada";
		$colorRow2  = "f7f7f7";

		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setShowGridlines(false);
		$sheet->setTitle("Laporan Transaksi Sales Item");

		// ------------------------------------------------------------   HEADER
		// ------------------------------------------------------------
		$sheet->setCellValue('A1', 'REPORT TRANSAKSI');
		$sheet->setCellValue('A2', $toko);
		$sheet->setCellValue('A3', "Periode : " . $datestart . "/" . $dateend);

		$sheet->mergeCells('A1:F1');
		$sheet->getStyle('A1:F1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A1:F1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$sheet->getStyle('A1:F1')->getFont()->setSize(15);
		$sheet->getStyle('A1:F1')->getFont()->setBold(true);
		$sheet->mergeCells('A2:F2');
		$sheet->getStyle('A2:F2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A2:F2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$sheet->getStyle('A2:F2')->getFont()->setSize(15);
		$sheet->getStyle('A2:F2')->getFont()->setBold(true);
		$sheet->mergeCells('A3:F3');
		$sheet->getStyle('A3:F3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A3:F3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$sheet->getStyle('A3:F3')->getFont()->setSize(15);
		$sheet->getStyle('A3:F3')->getFont()->setBold(true);

		$sheet->setCellValue("A5", "Tanggal");
		$sheet->setCellValue("B5", "Customer");
		$sheet->setCellValue("C5", "Alamat");
		$sheet->setCellValue("D5", "Telp");
		$sheet->setCellValue("E5", "Admin");
		$sheet->setCellValue("F5", "Kategori");
		$sheet->setCellValue("G5", "Kode Barang");
		$sheet->setCellValue("H5", "Vendor");
		$sheet->setCellValue("I5", "Nama Barang");
		$sheet->setCellValue("J5", "Jumlah");
		$sheet->setCellValue("K5", "Satuan");

		$sheet->getStyle('A5:K5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($colorHeader2);
		$sheet->getStyle('A5:K5')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
		$sheet->getStyle('A5:K5')->getFont()->setBold(true);
		$sheet->getStyle('A5:K5')->getFont()->setSize(10);
		$sheet->getStyle('A5:K5')->getAlignment()->setWrapText(true);
		$sheet->getStyle('A5:K5')->getFont()->setBold(true);

		$indexstart = 6;
		$array_payment = array();
		$method = array();
		foreach ($result as $row) {

			$sheet->getStyle('A' . $indexstart . ':K' . $indexstart)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($colorRow2);
			$sheet->getStyle('A' . $indexstart . ':K' . $indexstart)->getFont()->setBold(true);
			$sheet->getStyle('A' . $indexstart . ':K' . $indexstart)->getFont()->setSize(10);

			//SalesDate,MsCustomerName,MsCustomerCompany,MsCustomerRemarks,MsCustomerTelp1,MsCustomerTelp2, MsItemCode,MsItemName,SalesDetailQty,MsItemUoM

			$customername = $row->MsCustomerTypeId == 1 ? $row->MsCustomerName : $row->MsCustomerCompany . ' (' . $row->MsCustomerName . ')';
			$customertelp = $row->MsCustomerTelp2 == "" ? $row->MsCustomerTelp1 : $row->MsCustomerTelp1 . '/' . $row->MsCustomerTelp2;
			$sheet->getStyle("A" . $indexstart)->getAlignment()->setWrapText(true);
			$sheet->setCellValue("A" . $indexstart, $row->SalesDate);
			$sheet->getStyle("A" . $indexstart, '-')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

			$sheet->setCellValue("B" . $indexstart, $customername);
			$sheet->getStyle("B" . $indexstart, '-')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("B" . $indexstart, '-')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			$sheet->setCellValue("C" . $indexstart, $row->MsCustomerAddress);
			$sheet->getStyle("C" . $indexstart)->getAlignment()->setWrapText(true);
			$sheet->getStyle("C" . $indexstart, '-')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

			$sheet->setCellValue("D" . $indexstart, $customertelp);
			$sheet->getStyle("D" . $indexstart, '-')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("D" . $indexstart, '-')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			$sheet->setCellValue("E" . $indexstart, $row->MsEmpName);
			$sheet->getStyle("E" . $indexstart, '-')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("E" . $indexstart, '-')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			$sheet->setCellValue("F" . $indexstart, $row->MsItemCatCode . "-" . $row->MsItemCatName);
			$sheet->getStyle("F" . $indexstart, '-')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("F" . $indexstart, '-')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			$sheet->setCellValue("G" . $indexstart, $row->MsItemCode);
			$sheet->getStyle("G" . $indexstart, '-')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("G" . $indexstart, '-')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			$sheet->setCellValue("H" . $indexstart, $row->MsVendorCode);
			$sheet->getStyle("H" . $indexstart, '-')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("H" . $indexstart, '-')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			$sheet->setCellValue("I" . $indexstart, $row->MsItemName);
			$sheet->getStyle("I" . $indexstart, '-')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("I" . $indexstart, '-')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);


			$sheet->getStyle("J" . $indexstart)->getNumberFormat()->setFormatCode('#,##0.00');
			$sheet->setCellValueExplicit("J" . $indexstart, $row->SalesDetailQty, DataType::TYPE_NUMERIC);
			//$sheet->setCellValue("J" . $indexstart, $row->SalesDetailQty, 2);
			$sheet->getStyle("J" . $indexstart, '-')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("J" . $indexstart, '-')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			$sheet->setCellValue("K" . $indexstart, $row->MsItemUoM);
			$sheet->getStyle("K" . $indexstart, '-')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("K" . $indexstart, '-')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			$indexstart++;
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

		$spreadsheet->setActiveSheetIndex(0);
		$writer = new Xlsx($spreadsheet); // instantiate Xlsx
		$filename = 'Report Transaksi ' . $datestart . " - " . $dateend;
		header('Content-Type: application/vnd.ms-excel'); // generate excel file
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');	// download file
	}

	public function sales_periode()
	{
		$store = $this->input->post("store");
		$datestart = $this->input->post("datestart");
		$dateend = $this->input->post("dateend");
		$spreadsheet = new Spreadsheet(); // instantiate Spreadsheet
		$spreadsheet->getProperties()->setCreator('Syahrul Fauzan')
			->setLastModifiedBy('Syahrul Fauzan')
			->setTitle('Office 2007 XLSX Test Document')
			->setSubject('Office 2007 XLSX Test Document')
			->setDescription('EXPORT BY OBI-WEB')
			->setKeywords('office 2007 openxml php')
			->setCategory('Application');

		$sheet = $spreadsheet->getActiveSheet();
		if ($store == "-") {
			$workplace = "Semua Toko";
		} else {
			$workplace = ($this->db->select("MsWorkplaceCode")->where("MsWorkplaceId", $store)->get("TblMsWorkplace")->row())->MsWorkplaceCode;
		}
		// manually set table data value
		$sheet->setTitle("Data Sales");
		$sheet->setCellValue('A1', 'REPORT SALES ITEM BY PERIODE');
		$sheet->setCellValue('A2', 'Store : ' . $workplace);
		$kolom = 4;
		$nomor = 1;
		$lastcol = "";
		$periode = $this->getDatesFromRange($datestart, $dateend);

		$sheet->setCellValue('A4', "Kode");
		$sheet->setCellValue('B4', "Tanggal");
		$sheet->setCellValue('B5', "Nama");
		$sheet->setCellValue('C4', "Vendor");
		$sheet->setCellValue('D4', "Ukuran");
		$sheet->setCellValue('E4', "Satuan");
		$sheet->setCellValue('F4', "Harga");
		$col = "G";
		foreach ($periode as $date) {
			$sheet->getColumnDimension($col)->setWidth(15);
			$sheet->setCellValue($col . '4', date_format(date_create($date), "d M"));
			$sheet->setCellValue($col . '5', date_format(date_create($date), "D"));
			if (date_format(date_create($date), "D") == "Sun") {
				$sheet->getStyle($col . '4:' . $col . '5:')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('e81212');
			}
			$col++;
		}
		$sheet->mergeCells($col . '4:' . $col . '5');
		$sheet->getColumnDimension($col)->setWidth(15);
		$sheet->setCellValue($col++ . '4', "Total Qty");
		$sheet->getColumnDimension($col)->setWidth(15);
		$sheet->mergeCells($col . '4:' . $col . '5');
		$sheet->setCellValue($col . '4', "Total Harga");
		$lastcol = $col;

		$sheet->mergeCells('A4:A5');
		$sheet->mergeCells('C4:C5');
		$sheet->mergeCells('D4:D5');
		$sheet->mergeCells('E4:E5');
		$sheet->mergeCells('F4:F5');
		$sheet->getStyle('A4:' . $col . "5")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A4:' . $col . "5")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

		$sheet->mergeCells('A1:E1');
		$sheet->getStyle('A1:E1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A1:E1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$sheet->getStyle('A1:E1')->getFont()->setSize(25);
		$sheet->getStyle('A1:E1')->getFont()->setBold(true);

		$sheet->mergeCells('A2:E2');
		$sheet->getStyle('A2:E2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A2:E2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$sheet->getStyle('A2:E2')->getFont()->setSize(12);
		$sheet->getStyle('A2:E2')->getFont()->setBold(true);

		$sheet->getColumnDimension('A')->setWidth(10);
		$sheet->getColumnDimension('B')->setWidth(25);
		$sheet->getColumnDimension('C')->setWidth(20);
		$sheet->getColumnDimension('D')->setWidth(20);
		$sheet->getColumnDimension('E')->setWidth(8);
		$sheet->getColumnDimension('F')->setWidth(10);

		$dataitem = $this->db->join("TblMsVendor", "TblMsItem.MsItemVendor LIKE CONCAT('%',TblMsVendor.MsVendorCode,'%')", "left")
			->join("TblMsItemCategory", "TblMsItem.MsItemCatId= TblMsItemCategory.MsItemCatId", "left")
			->where("MsItemSales", 1)
			->group_by("TblMsItem.MsItemCode,TblMsVendor.MsVendorCode")
			->order_by("TblMsItem.MsItemCatId asc,TblMsItem.MsItemCode asc")
			->get("TblMsItem")->result();

		//************************************************************    DATA DETAIL
		$colnum = 6;
		$cat = "";
		$arr_category = array();
		$key_cat = -1;
		$key_data = 0;
		foreach ($dataitem as $row) {
			if ($cat != $row->MsItemCatName) {
				$cat = $row->MsItemCatName;
				$sheet->setCellValue('A' . $colnum, $row->MsItemCatName);
				$sheet->mergeCells('A' . $colnum . ':' . $lastcol . $colnum);
				$sheet->getStyle('A' . $colnum . ':' . $lastcol . $colnum)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffda5f');
				$sheet->getStyle('A' . $colnum . ':' . $lastcol . $colnum)->getFont()->setBold(true);
				$colnum++;
				$key_cat++;
				$arr_category[] = array(
					"category" => $cat,
					"data" => array()
				);
			}
			$sheet->setCellValue('A' . $colnum, $row->MsItemCode);
			$sheet->setCellValue('B' . $colnum, $row->MsItemName);
			$sheet->setCellValue('C' . $colnum, $row->MsVendorCode . "-" . $row->MsVendorName);
			$sheet->setCellValue('D' . $colnum, $row->MsItemSize);
			$sheet->setCellValue('E' . $colnum, $row->MsItemUoM);
			$sheet->getStyle("F" . $colnum)->getNumberFormat()->setFormatCode('#,##0');
			$sheet->setCellValueExplicit("F" . $colnum, $row->MsItemPrice, DataType::TYPE_NUMERIC);
			$col = "G";
			$total = 0;
			foreach ($periode as $date) {
				$index_date = $this->get_index_date($arr_category, $key_cat, $date);
				if ($index_date < 0) {
					$arr_category[$key_cat]["data"][] = array("date" => $date, "Qty" => 0, "Price" => 0);
					$index_date = sizeof($arr_category[$key_cat]["data"]) - 1;
				};
				$this->db
					->select("ifnull(sum(SalesDetailQty),'') as qty")
					->join("TblSales", "TblSales.SalesCode = TblSalesDetail.SalesDetailRef", "left")
					->where("MsItemId", $row->MsItemId)
					->where("MsVendorCode", $row->MsVendorCode)
					->where("SalesDate", $date)
					->where_not_in("SalesStatusPayment", array(0, 3));
				if ($store != "-") $this->db->where("MsWorkplaceId", $store);
				$data = $this->db->get("TblSalesDetail")->row();



				if ($data->qty != "") {
					$total += $data->qty;
					$arr_category[$key_cat]["data"][$index_date]["Qty"] += $data->qty;
					$arr_category[$key_cat]["data"][$index_date]["Price"] += $data->qty * $row->MsItemPrice;
					$sheet->getStyle($col . $colnum)->getNumberFormat()->setFormatCode('#,##0.00');
					$sheet->setCellValueExplicit($col . $colnum, $data->qty, DataType::TYPE_NUMERIC);
				}
				$col++;
			}
			if ($total != 0) {
				$sheet->getStyle($col . $colnum)->getNumberFormat()->setFormatCode('#,##0.00');
				$sheet->setCellValueExplicit($col++ . $colnum, $total, DataType::TYPE_NUMERIC);
			} else {
				$sheet->setCellValue($col++ . $colnum, $total);
			}
			if (($total * $row->MsItemPrice) != 0) {
				$sheet->getStyle($col . $colnum)->getNumberFormat()->setFormatCode('#,##0');
				$sheet->setCellValueExplicit($col++ . $colnum, ($total * $row->MsItemPrice), DataType::TYPE_NUMERIC);
			} else {
				$sheet->setCellValue($col++ . $colnum, $total);
			}
			$colnum++;
		}

		//************************************************************    TOTAL QTY 
		foreach ($arr_category as $row) {
			$sheet->setCellValue('A' . $colnum, "Total Qty Kategori " . $row["category"]);
			$sheet->mergeCells('A' . $colnum . ':F' . $colnum);
			$sheet->getStyle('A' . $colnum . ':F' . $colnum)->getFont()->setBold(true);
			$sheet->getStyle('A' . $colnum . ':F' . $colnum)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('11caef');
			$col = "G";
			$total = 0;
			foreach ($periode as $date) {
				$sum = $this->get_qty($row["data"], $date);
				if ($sum != 0) {
					$sheet->getStyle($col . $colnum)->getNumberFormat()->setFormatCode('#,##0.00');
					$sheet->setCellValueExplicit($col++ . $colnum, $sum, DataType::TYPE_NUMERIC);
				} else {
					$sheet->setCellValue($col++ . $colnum, $sum);
				}
				$total += $sum;
			}
			if ($total != 0) {
				$sheet->getStyle($col . $colnum)->getNumberFormat()->setFormatCode('#,##0.00');
				$sheet->setCellValueExplicit($col++ . $colnum, $total, DataType::TYPE_NUMERIC);
			} else {
				$sheet->setCellValue($col++ . $colnum, $total);
			}
			$colnum++;
		}

		//************************************************************    TOTAL Price
		foreach ($arr_category as $row) {
			$sheet->setCellValue('A' . $colnum, "Total Rp Kategori " . $row["category"]);
			$sheet->mergeCells('A' . $colnum . ':F' . $colnum);
			$sheet->getStyle('A' . $colnum . ':F' . $colnum)->getFont()->setBold(true);
			$sheet->getStyle('A' . $colnum . ':F' . $colnum)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ec7706');
			$col = "G";
			$total = 0;
			foreach ($periode as $date) {
				$sum = $this->get_price($row["data"], $date);
				if ($sum != 0) {
					$sheet->getStyle($col . $colnum)->getNumberFormat()->setFormatCode('#,##0');
					$sheet->setCellValueExplicit($col++ . $colnum, $sum, DataType::TYPE_NUMERIC);
				} else {
					$sheet->setCellValue($col++ . $colnum, $sum);
				}
				$total += $sum;
			}
			$col++;
			if ($total != 0) {
				$sheet->getStyle($col . $colnum)->getNumberFormat()->setFormatCode('#,##0');
				$sheet->setCellValueExplicit($col++ . $colnum, $total, DataType::TYPE_NUMERIC);
			} else {
				$sheet->setCellValue($col++ . $colnum, $total);
			}
			$colnum++;
		}

		//************************************************************    TOTAL ALL QTY'
		$row_qty = $colnum;
		$sheet->mergeCells('A' . $colnum . ':F' . $colnum);
		$sheet->getStyle('A' . $colnum . ':F' . $colnum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A' . $colnum . ':F' . $colnum)->getFont()->setBold(true);
		$sheet->setCellValue('A' . $colnum, "Total All Qty");
		$total = 0;
		$col = "G";
		foreach ($periode as $date) {
			$sum = $this->get_qty_total($arr_category, $date);
			if ($sum != 0) {
				$sheet->getStyle($col . $colnum)->getNumberFormat()->setFormatCode('#,##0.00');
				$sheet->setCellValueExplicit($col++ . $colnum, $sum, DataType::TYPE_NUMERIC);
			} else {
				$sheet->setCellValue($col++ . $colnum, $sum);
			}
			$total += $sum;
		}
		$sheet->setCellValue($col++ . $colnum, $total);
		$colnum++;

		//************************************************************    TOTAL ALL RUPIAH
		$row_rp = $colnum;
		$sheet->mergeCells('A' . $colnum . ':F' . $colnum);
		$sheet->getStyle('A' . $colnum . ':F' . $colnum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A' . $colnum . ':F' . $colnum)->getFont()->setBold(true);
		$sheet->setCellValue('A' . $colnum, "Total All Rupiah");
		$total = 0;
		$col = "G";
		$row_rp = $colnum;
		foreach ($periode as $date) {
			$sum = $this->get_price_total($arr_category, $date);
			if ($sum != 0) {
				$sheet->getStyle($col . $colnum)->getNumberFormat()->setFormatCode('#,##0');
				$sheet->setCellValueExplicit($col++ . $colnum, $sum, DataType::TYPE_NUMERIC);
			} else {
				$sheet->setCellValue($col++ . $colnum, $sum);
			}
			$total += $sum;
		}
		$col++;
		if ($total != 0) {
			$sheet->getStyle($col . $colnum)->getNumberFormat()->setFormatCode('#,##0');
			$sheet->setCellValueExplicit($col++ . $colnum, $total, DataType::TYPE_NUMERIC);
		} else {
			$sheet->setCellValue($col++ . $colnum, $total);
		}
		$colnum++;

		//************************************************************    TOTAL ALL DISKON
		$row_dsc = $colnum;
		$sheet->mergeCells('A' . $colnum . ':F' . $colnum);
		$sheet->getStyle('A' . $colnum . ':F' . $colnum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A' . $colnum . ':F' . $colnum)->getFont()->setBold(true);
		$sheet->setCellValue('A' . $colnum, "Total Diskon");
		$total = 0;
		$col = "G";
		foreach ($periode as $date) {
			$this->db->select("(SalesDiscTotal + sum(SalesDetailDisc * SalesDetailQty)) as total")
				->join("TblSalesDetail", "TblSales.SalesCode=TblSalesDetail.SalesDetailRef ", "left")
				->where("SalesDate", $date)
				->where_not_in("SalesStatusPayment", array(0, 3))
				->group_by("SalesCode");
			if ($store != "-") $this->db->where("MsWorkplaceId", $store);
			$data = $this->db->get("TblSales")->result();
			$subtotal = 0;
			foreach ($data as $row) {
				$subtotal += $row->total;
			}
			if ($subtotal != 0) {
				$sheet->getStyle($col . $colnum)->getNumberFormat()->setFormatCode('#,##0');
				$sheet->setCellValueExplicit($col++ . $colnum, $subtotal, DataType::TYPE_NUMERIC);
			} else {
				$sheet->setCellValue($col++ . $colnum, $subtotal);
			}
			$total += $subtotal;
		}
		$col++;
		if ($total != 0) {
			$sheet->getStyle($col . $colnum)->getNumberFormat()->setFormatCode('#,##0');
			$sheet->setCellValueExplicit($col++ . $colnum, $total, DataType::TYPE_NUMERIC);
		} else {
			$sheet->setCellValue($col++ . $colnum, $total);
		}
		$colnum++;

		//************************************************************    TOTAL RP SETELAH DISKON
		$row_rp_dsc = $colnum;
		$sheet->mergeCells('A' . $colnum . ':F' . $colnum);
		$sheet->getStyle('A' . $colnum . ':F' . $colnum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A' . $colnum . ':F' . $colnum)->getFont()->setBold(true);
		$sheet->setCellValue('A' . $colnum, "Total Rupiah Setelah Diskon");
		$total = 0;
		$col = "G";
		foreach ($periode as $date) {
			$sheet->getStyle($col . $colnum)->getNumberFormat()->setFormatCode('#,##0');
			$sheet->setCellValue($col . $colnum, "=" . $col . $row_rp . "-" . $col . $row_dsc);
			$col++;
		}
		$lastcol = $col;
		$col++;
		$sheet->getStyle($col . $colnum)->getNumberFormat()->setFormatCode('#,##0');
		$sheet->setCellValue($col++ . $colnum,  "=sum(F" . $colnum . ":" . $lastcol . $colnum . ")");
		$colnum++;


		//************************************************************    TOTAL BIAYA PENGIRIMAN
		$sheet->mergeCells('A' . $colnum . ':F' . $colnum);
		$sheet->getStyle('A' . $colnum . ':F' . $colnum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A' . $colnum . ':F' . $colnum)->getFont()->setBold(true);
		$sheet->setCellValue('A' . $colnum, "Total Biaya Pengiriman");
		$total = 0;
		$col = "G";
		foreach ($periode as $date) {
			$this->db->select("sum(SalesDeliveryTotal) as sum")
				->where("SalesDate", $date)
				->where_not_in("SalesStatusPayment", array(0, 3));
			if ($store != "-") $this->db->where("MsWorkplaceId", $store);
			$count = ($this->db->get("TblSales")->row())->sum;

			$sheet->getStyle($col . $colnum)->getNumberFormat()->setFormatCode('#,##0');
			$sheet->setCellValue($col++ . $colnum, $count);
			$total += $count;
		}
		$col++;
		$sheet->getStyle($col . $colnum)->getNumberFormat()->setFormatCode('#,##0');
		$sheet->setCellValue($col++ . $colnum, $total);
		$colnum++;

		//************************************************************    TOTAL CUSTOMER
		$row_cs = $colnum;
		$sheet->mergeCells('A' . $colnum . ':F' . $colnum);
		$sheet->getStyle('A' . $colnum . ':F' . $colnum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A' . $colnum . ':F' . $colnum)->getFont()->setBold(true);
		$sheet->setCellValue('A' . $colnum, "Total Customer");
		$total = 0;
		$col = "G";
		foreach ($periode as $date) {
			$this->db
				->where("SalesDate", $date)
				->where_not_in("SalesStatusPayment", array(0, 3));
			if ($store != "-") $this->db->where("MsWorkplaceId", $store);
			$count = $this->db->get("TblSales")->num_rows();

			$sheet->getStyle($col . $colnum)->getNumberFormat()->setFormatCode('#,##0');
			$sheet->setCellValue($col++ . $colnum, $count);
			$total += $count;
		}
		$col++;
		$sheet->getStyle($col . $colnum)->getNumberFormat()->setFormatCode('#,##0');
		$sheet->setCellValue($col++ . $colnum, $total);
		$colnum++;

		//************************************************************    TOTAL Average Per Customer By Qty
		$sheet->mergeCells('A' . $colnum . ':F' . $colnum);
		$sheet->getStyle('A' . $colnum . ':F' . $colnum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A' . $colnum . ':F' . $colnum)->getFont()->setBold(true);
		$sheet->setCellValue('A' . $colnum, "Average Per Customer By Qty");
		$total = 0;
		$col = "G";
		foreach ($periode as $date) {
			$sheet->getStyle($col . $colnum)->getNumberFormat()->setFormatCode('#,##0.00');
			$sheet->setCellValue($col . $colnum, "=IFERROR(" . $col . $row_qty . "/" . $col . $row_cs . ",0)");
			$col++;
		}
		$sheet->getStyle($col . $colnum)->getNumberFormat()->setFormatCode('#,##0.00');
		$sheet->setCellValue($col++ . $colnum,  "=sum(F" . $colnum . ":" . $lastcol . $colnum . ")");
		$colnum++;

		//************************************************************    TOTAL Average Per Customer By Rupiah
		$sheet->mergeCells('A' . $colnum . ':F' . $colnum);
		$sheet->getStyle('A' . $colnum . ':F' . $colnum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A' . $colnum . ':F' . $colnum)->getFont()->setBold(true);
		$sheet->setCellValue('A' . $colnum, "Average Per Customer By Rupiah");
		$total = 0;
		$col = "G";
		foreach ($periode as $date) {
			$sheet->getStyle($col . $colnum)->getNumberFormat()->setFormatCode('#,##0.00');
			$sheet->setCellValue($col . $colnum, "=IFERROR(" . $col . $row_rp_dsc . "/" . $col . $row_cs . ",0)");
			$col++;
		}
		$col++;
		$sheet->getStyle($col . $colnum)->getNumberFormat()->setFormatCode('#,##0.00');
		$sheet->setCellValue($col++ . $colnum,  "=sum(F" . $colnum . ":" . $lastcol . $colnum . ")");
		$colnum++;

		//echo JSON_ENCODE($arr_category);
		$sheet->freezePane('G6');
		$spreadsheet->setActiveSheetIndex(0);

		$writer = new Xlsx($spreadsheet); // instantiate Xlsx
		$filename = 'Data Sales Item By Periode ' . $workplace . " " . $datestart . " to " . $dateend; // set filename for excel file to be exported
		header('Content-Type: application/vnd.ms-excel'); // generate excel file
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');	// download file

	}

	public function sales_periode_load()
	{
		$store = $this->input->post("store");
		$datestart = $this->input->post("datestart");
		$dateend = $this->input->post("dateend");
		if ($store == "-") {
			$workplace = "Semua Toko";
		} else {
			$workplace = ($this->db->select("MsWorkplaceCode")->where("MsWorkplaceId", $store)->get("TblMsWorkplace")->row())->MsWorkplaceCode;
		}

		$content = '<h2 class="fw-bold">Report Penjualan By Periode (' . $workplace . ')</h2>
                  <h6><b>' . date_format(date_create($datestart), "d M Y") . '</b> sampai <b>' . date_format(date_create($dateend), "d M Y") . '</b></h6>';


		$periode = $this->getDatesFromRange($datestart, $dateend);
		$coldate = "";
		$coldate1 = "";
		foreach ($periode as $date) {
			if (date_format(date_create($date), "D") == "Sun") {
				$coldate .= "<th class='text-danger'>" . date_format(date_create($date), "d M") . "</th>";
				$coldate1 .= "<th class='text-danger'>" . date_format(date_create($date), "D") . "</th>";
			} else {
				$coldate .= "<th>" . date_format(date_create($date), "d M") . "</th>";
				$coldate1 .= "<th>" . date_format(date_create($date), "D") . "</th>";
			}
		}
		$content .= '<table class="table table-sm table-bordered border-secondary">
                     <thead class="align-middle text-center">
                        <tr>
                           <th scope="col" rowspan="2">kode</th>
                           <th scope="col" rowspan="2">nama</th>
                           <th scope="col" rowspan="2">Ukuran</th>
                           <th scope="col" rowspan="2">Satuan</th>
                           <th scope="col" rowspan="2">Harga</th>
									' . $coldate . '
                           <th scope="col" rowspan="2">Total Qty</th>
                           <th scope="col" rowspan="2">Total Harga</th> </tr>
                        <tr>
                           
									' . $coldate1 . '
                        </tr>
                     </thead>
						</table>';
		echo $content;
	}
	function get_index_date($arr, $key_cat, $value)
	{
		$index = -1;
		$no = 0;
		foreach ($arr[$key_cat]["data"] as $arr_1 => $key_1) {
			$no++;
			if ($key_1["date"] == $value) {
				$index = $arr_1;
				break;
			}
		}
		if ($index == -1) {
		}
		return $index;
	}
	function get_qty($arr, $value)
	{
		foreach ($arr as $arr_1 => $key_1) {
			if ($key_1["date"] == $value) {
				return $key_1["Qty"];
			}
		}
		return 0;
	}
	function get_qty_total($arr, $value)
	{
		$total = 0;
		foreach ($arr as $arr_1 => $key_1) {
			foreach ($key_1["data"] as $arr_2 => $key_2) {
				if ($key_2["date"] == $value) {
					$total += $key_2["Qty"];
					break;
				}
			}
		}
		return $total;
	}
	function get_price($arr, $value)
	{
		foreach ($arr as $arr_1 => $key_1) {
			if ($key_1["date"] == $value) {
				return $key_1["Price"];
			}
		}
		return 0;
	}
	function get_price_total($arr, $value)
	{
		$total = 0;
		foreach ($arr as $arr_1 => $key_1) {
			foreach ($key_1["data"] as $arr_2 => $key_2) {
				if ($key_2["date"] == $value) {
					$total += $key_2["Price"];
					break;
				}
			}
		}
		return $total;
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

	public function sales_category_load()
	{
		$store = $this->input->post("store");
		$this->db
			->join("TblSalesDetail", "TblSales.SalesCode = TblSalesDetail.SalesDetailRef", "LEFT")
			->join("TblMsItem", "TblMsItem.MsItemId = TblSalesDetail.MsItemId", "LEFT")
			->join("TblMsVendor", "TblMsVendor.MsVendorCode = TblSalesDetail.MsVendorCode", "LEFT")
			->join("TblMsItemCategory", "TblMsItem.MsItemCatId = TblMsItemCategory.MsItemCatId", "LEFT")
			->where("SalesDate >=", $this->input->post("datestart"))
			->where("SalesDate <=", $this->input->post("dateend"))
			->where_in("SalesStatusPayment", array(1, 2));
		if ($store != "-") $this->db->where("MsWorkplaceId", $store);
		$category = $this->db->group_by("MsItemCatCode")->get("TblSales")->result();
		echo '
		<div class="row ">
			<div class="col-sm-12 text-center ">
				<h4 class="font-weight-bold">LAPORAN PENJUALAN</h4>
				<h6 class="text-muted">Periode : ' . date_format(date_create($this->input->post("datestart")), "d/m/Y") . ' - ' . date_format(date_create($this->input->post("dateend")), "d/m/Y") . '</h6>
				<h6 class="text-muted">Type : Category</h6>
			</div>';
		$datatable = 0;
		foreach ($category as $row_cat) {
			$this->db->select("TblMsItemCategory.MsItemCatCode,TblMsItemCategory.MsItemCatName,TblSalesDetail.MsVendorCode,TblMsItem.MsItemCode,TblMsItem.MsItemName,TblMsItem.MsItemSize,sum(TblSalesDetail.SalesDetailQty) as qty,TblMsItem.MsItemUoM")
				->join("TblSalesDetail", "TblSales.SalesCode = TblSalesDetail.SalesDetailRef", "LEFT")
				->join("TblMsItem", "TblMsItem.MsItemId = TblSalesDetail.MsItemId", "LEFT")
				->join("TblMsVendor", "TblMsVendor.MsVendorCode = TblSalesDetail.MsVendorCode", "LEFT")
				->join("TblMsItemCategory", "TblMsItem.MsItemCatId = TblMsItemCategory.MsItemCatId", "LEFT")
				->where("SalesDate >=", $this->input->post("datestart"))
				->where("SalesDate <=", $this->input->post("dateend"))
				->where("MsItemCatCode", $row_cat->MsItemCatCode)
				->where_in("SalesStatusPayment", array(1, 2));

			if ($store != "-")   $this->db->where("MsWorkplaceId", $store);
			$data =  $this->db->group_by(array("MsItemName", "MsItemCatCode"))->order_by("sum(TblSalesDetail.SalesDetailQty) DESC")->get("TblSales")->result();
			echo '
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">				
						<div class="row">				    
							<div class="col">				        
								<span class="card-title" style="font-size:10px;color:gray">Category :</span>				        
								<br><span class="card-title font-weight-bold" style="font-size:14px;">' . $row_cat->MsItemCatCode . ' - ' . $row_cat->MsItemCatName . '</span>				        
							</div>			   
						</div>			
					</div>
					<div class="card-body">				
						<div id="chart_div_' . $datatable . '" style="min-height: 450px;"></div>
						<div class="table-responsive">
							<table class="table table-sm">
								<thead class="thead-light">
									<tr>
										<th scope="col">#</th>
										<th scope="col">Nama Item</th>
										<th scope="col">Ukuran</th>
										<th scope="col">Qty</th>
									</tr>
								</thead>
								<tbody>';
			$no = 1;
			$qty = 0;
			foreach ($data as $row_data) {
				echo '	<tr>
										<th scope="row">' . $no . '</th>
										<td>' . $row_data->MsItemCode . ' - ' . $row_data->MsItemName . ' (' . $row_data->MsVendorCode . ') </td>
										<td>' . $row_data->MsItemSize . '</td>
										<td>' . number_format($row_data->qty, 2) . ' ' . $row_data->MsItemUoM . '</td>
									</tr>';
				$no++;
				$qty +=  $row_data->qty;
			}


			echo '				</tbody>
								<tfooter>
									<tr>
										<th scope="row" colspan="3" class="text-end">Total Penjualan(Qty)</th> 
										<th scope="col">' . $qty . '</th>
									</tr>
								</tfooter>
							</table>
						</div>
						<script>
							google.charts.load("current", {"packages":["bar"]});
							google.charts.setOnLoadCallback(drawStuff_' . $datatable . ');

							function drawStuff_' . $datatable . '() {
								var data = new google.visualization.arrayToDataTable([
									["Nama Item", "Terjual"],';
			foreach ($data as $row_data) {
				echo '["' . $row_data->MsItemCode . ' - ' . $row_data->MsItemName . ' (' . $row_data->MsVendorCode . ')", ' . $row_data->qty . '],';
			}
			echo '	]);

								var options = {
									title: "Penjualan BATA EXPOSE",
									legend: { position: "top" },
									bars: "horizontal", // Required for Material Bar Charts.
									axes: {
										x: {
											0: { side: "top", label: "Total Terjual"} // Top x-axis.
										}
									},
									bar: { groupWidth: "90%" },
									hAxis: {
										direction:-1,
										slantedText:true,
										slantedTextAngle:90 // here you can even use 180
									}

								};

								var chart = new google.charts.Bar(document.getElementById("chart_div_' . $datatable . '"));
								chart.draw(data, options);
							};
							$(window).resize(function(){
								drawStuff_' . $datatable . '();
							});
						</script>
					</div>
				</div>
			</div>';
			$datatable++;
		}
		echo '</div>';
	}
	public function sales_category_export()
	{
		$this->db
			->join("TblSalesDetail", "TblSales.SalesCode = TblSalesDetail.SalesDetailRef", "LEFT")
			->join("TblMsItem", "TblMsItem.MsItemId = TblSalesDetail.MsItemId", "LEFT")
			->join("TblMsVendor", "TblMsVendor.MsVendorCode = TblSalesDetail.MsVendorCode", "LEFT")
			->join("TblMsItemCategory", "TblMsItem.MsItemCatId = TblMsItemCategory.MsItemCatId", "LEFT")
			->where("SalesDate >=", $this->input->post("datestart"))
			->where("SalesDate <=", $this->input->post("dateend"))
			->where_in("SalesStatusPayment", array(1, 2));
		if ($store = $this->input->post("store") != "-") {
			$this->db->where("MsWorkplaceId", $this->input->post("store"));
			$header = ($this->db->where("MsWorkplaceId", $this->input->post("store"))->get("TblMsWorkplace")->row())->MsWorkplaceCode;
		} else {
			$header = "Semua Toko";
		}
		$category = $this->db->group_by("MsItemCatCode")->get("TblSales")->result();


		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()->setCreator('Syahrul Fauzan')
			->setLastModifiedBy('Syahrul Fauzan')
			->setTitle('Office 2007 XLSX Test Document')
			->setSubject('Office 2007 XLSX Test Document')
			->setDescription('EXPORT BY OBI-WEB')
			->setKeywords('office 2007 openxml php')
			->setCategory('Application');

		$worksheet = $spreadsheet->getActiveSheet();
		$worksheet->setTitle("Laporan Sales Item By Category");


		$worksheet->setCellValue('A1', 'REPORT SALES BY CATEGORY');
		$worksheet->setCellValue('A2', 'Toko : ' . $header);
		$worksheet->setCellValue('A3', "Periode : " . $this->input->post("datestart") . " " . $this->input->post("dateend"));
		$worksheet->mergeCells('A1:E1');
		$worksheet->mergeCells('A2:E2');
		$worksheet->mergeCells('A3:E3');
		$worksheet->getStyle('A1:E1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$worksheet->getStyle('A1:E1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$worksheet->getStyle('A1:E1')->getFont()->setSize(15);
		$worksheet->getStyle('A1:E1')->getFont()->setBold(true);

		$worksheet->getStyle('A2:E3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$worksheet->getStyle('A2:E3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$worksheet->getStyle('A2:E3')->getFont()->setSize(12);
		$worksheet->getStyle('A2:E3')->getFont()->setBold(true);

		$row_number = 5;
		foreach ($category as $row_cat) {
			$this->db->select("TblMsItemCategory.MsItemCatCode,TblMsItemCategory.MsItemCatName,TblSalesDetail.MsVendorCode,TblMsItem.MsItemCode,TblMsItem.MsItemName,TblMsItem.MsItemSize,sum(TblSalesDetail.SalesDetailQty) as qty,TblMsItem.MsItemUoM")
				->join("TblSalesDetail", "TblSales.SalesCode = TblSalesDetail.SalesDetailRef", "LEFT")
				->join("TblMsItem", "TblMsItem.MsItemId = TblSalesDetail.MsItemId", "LEFT")
				->join("TblMsVendor", "TblMsVendor.MsVendorCode = TblSalesDetail.MsVendorCode", "LEFT")
				->join("TblMsItemCategory", "TblMsItem.MsItemCatId = TblMsItemCategory.MsItemCatId", "LEFT")
				->where("SalesDate >=", $this->input->post("datestart"))
				->where("SalesDate <=", $this->input->post("dateend"))
				->where("MsItemCatCode", $row_cat->MsItemCatCode)
				->where_in("SalesStatusPayment", array(1, 2));

			if ($store = $this->input->post("store") != "-")   $this->db->where("MsWorkplaceId", $this->input->post("store"));
			$data =  $this->db->group_by(array("MsItemName", "MsItemCatCode"))->order_by("sum(TblSalesDetail.SalesDetailQty) DESC")->get("TblSales")->result();

			$no = 1;
			$row_chart_min = $row_number;
			$row_chart_max = $row_number + 19;
			$row_number += 20;
			$worksheet->setCellValue('A' . $row_number, 'No.');
			$worksheet->setCellValue('B' . $row_number, 'Nama Item');
			$worksheet->setCellValue('C' . $row_number, 'Ukuran');
			$worksheet->setCellValue('D' . $row_number, 'Qty');
			$worksheet->setCellValue('E' . $row_number, 'UoM');
			$worksheet->getStyle('A' . $row_number . ':E' . $row_number)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$worksheet->getStyle('A' . $row_number . ':E' . $row_number)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
			$worksheet->getStyle('A' . $row_number . ':E' . $row_number)->getFont()->setSize(12);
			$worksheet->getStyle('A' . $row_number . ':E' . $row_number)->getFont()->setBold(true);

			$row_number++;
			$row_start_data = $row_number;
			$row_end_data = $row_number;
			foreach ($data as $row_data) {
				$worksheet->setCellValue('A' . $row_number, $no);
				$worksheet->setCellValue('B' . $row_number, $row_data->MsItemCode . ' - ' . $row_data->MsItemName . ' (' . $row_data->MsVendorCode . ')');
				$worksheet->setCellValue('C' . $row_number, $row_data->MsItemSize);
				$worksheet->setCellValue('D' . $row_number, $row_data->qty);
				$worksheet->setCellValue('E' . $row_number, $row_data->MsItemUoM);
				$row_end_data = $row_number;
				$row_number++;
				$no++;
			}

			$dataSeriesLabels = [
				new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, '$D$' . ($row_start_data - 1), null, 1),
			];
			$xAxisTickValues = [
				new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, '$B$' . $row_end_data . ':$B$' . $row_start_data, null, $no),
			];
			$dataSeriesValues = [
				new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, '$D$' . $row_end_data . ':$D$' . $row_start_data, null, $no),
			];
			$series = new DataSeries(
				DataSeries::TYPE_BARCHART,
				DataSeries::GROUPING_STACKED,
				range(count($dataSeriesValues) - 1, 0),
				$dataSeriesLabels,
				$xAxisTickValues,
				$dataSeriesValues
			);
			$series->setPlotDirection(DataSeries::DIRECTION_BAR);
			$plotArea = new PlotArea(null, [$series]);
			$legend = new Legend(Legend::POSITION_RIGHT, null, false);
			$title = new Title($row_cat->MsItemCatName);
			$chart = new Chart(
				'chart1', // name
				$title, // title
				$legend, // legend
				$plotArea, // plotArea
				true, // plotVisibleOnly
				DataSeries::EMPTY_AS_GAP, // displayBlanksAs
				null, // xAxisLabel
				null  // yAxisLabel
			);
			$chart->setTopLeftPosition('A' . $row_chart_min);
			$chart->setBottomRightPosition('F' . $row_chart_max);
			$worksheet->addChart($chart);

			$row_number += 2;
		}
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(8);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(60);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		// Save Excel 2007 file
		$filename = "tester";
		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->setIncludeCharts(true);

		$filename = "REPORT SALES BY CATEGORY " . $this->input->post("datestart") . " " . $this->input->post("dateend"); // set filename for excel file to be exported
		header('Content-Type: application/vnd.ms-excel'); // generate excel file
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');	// download file
	}

	public function sales_vendor_load()
	{
		$category = $this->db
			->join("TblSalesDetail", "TblSales.SalesCode = TblSalesDetail.SalesDetailRef", "LEFT")
			->join("TblMsItem", "TblMsItem.MsItemId = TblSalesDetail.MsItemId", "LEFT")
			->join("TblMsVendor", "TblMsVendor.MsVendorCode = TblSalesDetail.MsVendorCode", "LEFT")
			->join("TblMsItemCategory", "TblMsItem.MsItemCatId = TblMsItemCategory.MsItemCatId", "LEFT")
			->where("SalesDate >=", $this->input->post("datestart"))
			->where("SalesDate <=", $this->input->post("dateend"))
			->where_in("SalesStatusPayment", array(1, 2))
			->where("MsWorkplaceId", $this->input->post("store"))->group_by("TblSalesDetail.MsVendorCode")->get("TblSales")->result();
		echo '
		<div class="row ">
			<div class="col-sm-12 text-center ">
				<h4 class="font-weight-bold">LAPORAN PENJUALAN</h4>
				<h6 class="text-muted">Periode : ' . date_format(date_create($this->input->post("datestart")), "d/m/Y") . ' - ' . date_format(date_create($this->input->post("dateend")), "d/m/Y") . '</h6>
				<h6 class="text-muted">Type : Vendor</h6>
			</div>';
		$datatable = 0;
		foreach ($category as $row_cat) {
			$data = $this->db->select("TblMsItemCategory.MsItemCatCode,TblMsItemCategory.MsItemCatName,TblSalesDetail.MsVendorCode,TblMsItem.MsItemCode,TblMsItem.MsItemName,TblMsItem.MsItemSize,sum(TblSalesDetail.SalesDetailQty) as qty,TblMsItem.MsItemUoM")
				->join("TblSalesDetail", "TblSales.SalesCode = TblSalesDetail.SalesDetailRef", "LEFT")
				->join("TblMsItem", "TblMsItem.MsItemId = TblSalesDetail.MsItemId", "LEFT")
				->join("TblMsVendor", "TblMsVendor.MsVendorCode = TblSalesDetail.MsVendorCode", "LEFT")
				->join("TblMsItemCategory", "TblMsItem.MsItemCatId = TblMsItemCategory.MsItemCatId", "LEFT")
				->where("SalesDate >=", $this->input->post("datestart"))
				->where("SalesDate <=", $this->input->post("dateend"))
				->where("TblSalesDetail.MsVendorCode", $row_cat->MsVendorCode)
				->where_in("SalesStatusPayment", array(1, 2))
				->where("MsWorkplaceId", $this->input->post("store"))->group_by(array("MsItemName", "TblSalesDetail.MsVendorCode"))->order_by("sum(TblSalesDetail.SalesDetailQty) DESC")->get("TblSales")->result();
			echo '
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">				
						<div class="row">				    
							<div class="col">				        
								<span class="card-title" style="font-size:10px;color:gray">Category :</span>				        
								<br><span class="card-title font-weight-bold" style="font-size:14px;">' . $row_cat->MsVendorCode . ' - ' . $row_cat->MsVendorName . '</span>				        
							</div>			   
						</div>			
					</div>
					<div class="card-body">				
						<div id="chart_div_' . $datatable . '" style="min-height: 450px;"></div>
						<div class="table-responsive">
							<table class="table table-sm">
								<thead class="thead-light">
									<tr>
										<th scope="col">#</th>
										<th scope="col">Nama Item</th>
										<th scope="col">Ukuran</th>
										<th scope="col">Qty</th>
									</tr>
								</thead>
								<tbody>';
			$no = 1;
			$qty = 0;
			foreach ($data as $row_data) {
				echo '	<tr>
										<th scope="row">' . $no . '</th>
										<td>' . $row_data->MsItemCode . ' - ' . $row_data->MsItemName . ' (' . $row_data->MsVendorCode . ') </td>
										<td>' . $row_data->MsItemSize . '</td>
										<td>' . number_format($row_data->qty) . ' ' . $row_data->MsItemUoM . '</td>
									</tr>';
				$no++;
				$qty +=  $row_data->qty;
			}


			echo '				</tbody>
			
								<caption>Total Penjualan(Qty) : ' . $qty . '</caption>
							</table>
						</div>
						<script>
							google.charts.load("current", {"packages":["bar"]});
							google.charts.setOnLoadCallback(drawStuff_' . $datatable . ');

							function drawStuff_' . $datatable . '() {
								var data = new google.visualization.arrayToDataTable([
									["Nama Item", "Terjual"],';
			foreach ($data as $row_data) {
				echo '["' . $row_data->MsItemCode . ' - ' . $row_data->MsItemName . ' (' . $row_data->MsVendorCode . ')", ' . $row_data->qty . '],';
			}
			echo '	]);

								var options = {
									title: "Penjualan BATA EXPOSE",
									legend: { position: "top" },
									bars: "horizontal", // Required for Material Bar Charts.
									axes: {
										x: {
											0: { side: "top", label: "Total Terjual"} // Top x-axis.
										}
									},
									bar: { groupWidth: "90%" },
									hAxis: {
										direction:-1,
										slantedText:true,
										slantedTextAngle:90 // here you can even use 180
									}

								};

								var chart = new google.charts.Bar(document.getElementById("chart_div_' . $datatable . '"));
								chart.draw(data, options);
							};
							$(window).resize(function(){
								drawStuff_' . $datatable . '();
							  });
						</script>
					</div>
				</div>
			</div>';
			$datatable++;
		}
		echo '</div>';
	}
	public function sales_vendor_export()
	{

		$category = $this->db
			->join("TblSalesDetail", "TblSales.SalesCode = TblSalesDetail.SalesDetailRef", "LEFT")
			->join("TblMsItem", "TblMsItem.MsItemId = TblSalesDetail.MsItemId", "LEFT")
			->join("TblMsVendor", "TblMsVendor.MsVendorCode = TblSalesDetail.MsVendorCode", "LEFT")
			->join("TblMsItemCategory", "TblMsItem.MsItemCatId = TblMsItemCategory.MsItemCatId", "LEFT")
			->where("SalesDate >=", $this->input->post("datestart"))
			->where("SalesDate <=", $this->input->post("dateend"))
			->where_in("SalesStatusPayment", array(1, 2))
			->where("MsWorkplaceId", $this->input->post("store"))->group_by("TblSalesDetail.MsVendorCode")->get("TblSales")->result();

		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()->setCreator('Syahrul Fauzan')
			->setLastModifiedBy('Syahrul Fauzan')
			->setTitle('Office 2007 XLSX Test Document')
			->setSubject('Office 2007 XLSX Test Document')
			->setDescription('EXPORT BY OBI-WEB')
			->setKeywords('office 2007 openxml php')
			->setCategory('Application');



		$worksheet = $spreadsheet->getActiveSheet();
		$worksheet->setTitle("Laporan Sales Item By Vendor");

		$header = ($this->db->where("MsWorkplaceId", $this->input->post("store"))->get("TblMsWorkplace")->row())->MsWorkplaceCode;

		$worksheet->setCellValue('A1', 'REPORT SALES BY VENDOR');
		$worksheet->setCellValue('A2', 'Toko : ' . $header);
		$worksheet->setCellValue('A3', "Periode : " . $this->input->post("datestart") . " " . $this->input->post("dateend"));
		$worksheet->mergeCells('A1:E1');
		$worksheet->mergeCells('A2:E2');
		$worksheet->mergeCells('A3:E3');
		$worksheet->getStyle('A1:E1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$worksheet->getStyle('A1:E1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$worksheet->getStyle('A1:E1')->getFont()->setSize(15);
		$worksheet->getStyle('A1:E1')->getFont()->setBold(true);

		$worksheet->getStyle('A2:E3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$worksheet->getStyle('A2:E3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$worksheet->getStyle('A2:E3')->getFont()->setSize(12);
		$worksheet->getStyle('A2:E3')->getFont()->setBold(true);

		$row_number = 5;
		foreach ($category as $row_cat) {
			$data = $this->db->select("TblMsItemCategory.MsItemCatCode,TblMsItemCategory.MsItemCatName,TblSalesDetail.MsVendorCode,TblMsItem.MsItemCode,TblMsItem.MsItemName,TblMsItem.MsItemSize,sum(TblSalesDetail.SalesDetailQty) as qty,TblMsItem.MsItemUoM")
				->join("TblSalesDetail", "TblSales.SalesCode = TblSalesDetail.SalesDetailRef", "LEFT")
				->join("TblMsItem", "TblMsItem.MsItemId = TblSalesDetail.MsItemId", "LEFT")
				->join("TblMsVendor", "TblMsVendor.MsVendorCode = TblSalesDetail.MsVendorCode", "LEFT")
				->join("TblMsItemCategory", "TblMsItem.MsItemCatId = TblMsItemCategory.MsItemCatId", "LEFT")
				->where("SalesDate >=", $this->input->post("datestart"))
				->where("SalesDate <=", $this->input->post("dateend"))
				->where("TblSalesDetail.MsVendorCode", $row_cat->MsVendorCode)
				->where_in("SalesStatusPayment", array(1, 2))
				->where("MsWorkplaceId", $this->input->post("store"))->group_by(array("MsItemName", "TblSalesDetail.MsVendorCode"))->order_by("sum(TblSalesDetail.SalesDetailQty) DESC")->get("TblSales")->result();

			$no = 1;
			$row_chart_min = $row_number;
			$row_chart_max = $row_number + 19;
			$row_number += 20;
			$worksheet->setCellValue('A' . $row_number, 'No.');
			$worksheet->setCellValue('B' . $row_number, 'Nama Item');
			$worksheet->setCellValue('C' . $row_number, 'Ukuran');
			$worksheet->setCellValue('D' . $row_number, 'Qty');
			$worksheet->setCellValue('E' . $row_number, 'UoM');
			$worksheet->getStyle('A' . $row_number . ':E' . $row_number)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$worksheet->getStyle('A' . $row_number . ':E' . $row_number)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
			$worksheet->getStyle('A' . $row_number . ':E' . $row_number)->getFont()->setSize(12);
			$worksheet->getStyle('A' . $row_number . ':E' . $row_number)->getFont()->setBold(true);

			$row_number++;
			$row_start_data = $row_number;
			$row_end_data = $row_number;
			foreach ($data as $row_data) {
				$worksheet->setCellValue('A' . $row_number, $no);
				$worksheet->setCellValue('B' . $row_number, $row_data->MsItemCode . ' - ' . $row_data->MsItemName . ' (' . $row_data->MsVendorCode . ')');
				$worksheet->setCellValue('C' . $row_number, $row_data->MsItemSize);
				$worksheet->setCellValue('D' . $row_number, $row_data->qty);
				$worksheet->setCellValue('E' . $row_number, $row_data->MsItemUoM);
				$row_end_data = $row_number;
				$row_number++;
				$no++;
			}

			$dataSeriesLabels = [
				new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, '$D$' . ($row_start_data - 1), null, 1),
			];
			$xAxisTickValues = [
				new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, '$B$' . $row_end_data . ':$B$' . $row_start_data, null, $no),
			];
			$dataSeriesValues = [
				new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, '$D$' . $row_end_data . ':$D$' . $row_start_data, null, $no),
			];
			$series = new DataSeries(
				DataSeries::TYPE_BARCHART,
				DataSeries::GROUPING_STACKED,
				range(count($dataSeriesValues) - 1, 0),
				$dataSeriesLabels,
				$xAxisTickValues,
				$dataSeriesValues
			);
			$series->setPlotDirection(DataSeries::DIRECTION_BAR);
			$plotArea = new PlotArea(null, [$series]);
			$legend = new Legend(Legend::POSITION_RIGHT, null, false);
			$title = new Title($row_cat->MsVendorCode . ' - ' . $row_cat->MsVendorName);
			$chart = new Chart(
				'chart1', // name
				$title, // title
				$legend, // legend
				$plotArea, // plotArea
				true, // plotVisibleOnly
				DataSeries::EMPTY_AS_GAP, // displayBlanksAs
				null, // xAxisLabel
				null  // yAxisLabel
			);
			$chart->setTopLeftPosition('A' . $row_chart_min);
			$chart->setBottomRightPosition('F' . $row_chart_max);
			$worksheet->addChart($chart);

			$row_number += 2;
		}
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(8);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(60);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		// Save Excel 2007 file
		$filename = "tester";
		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->setIncludeCharts(true);

		$filename = "REPORT SALES BY VENDOR " . $this->input->post("datestart") . " " . $this->input->post("dateend"); // set filename for excel file to be exported
		header('Content-Type: application/vnd.ms-excel'); // generate excel file
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');	// download file
	}

	public function sales_cogs_load()
	{
		$storeid = $this->input->post("store");
		if ($storeid == 0) {
			$store = "Semua Toko";
			$data_store = $this->db->query("Select * from TblMsWorkplace where MsWorkplaceType=0")->result();
		} else {
			$store = $this->model_app->get_single_data("MsWorkplaceCode", "TblMsWorkplace", array("MsWorkplaceId" => $storeid));
			$data_store = $this->db->query("Select * from TblMsWorkplace where MsWorkplaceType=0 and MsWorkplaceId='" . $storeid . "'")->result();
		}


		/*************************************** RANGKUMAN **************************************/
		echo '
		<div class="row ">
			<div class="col-sm-12 text-center ">
				<h4 class="font-weight-bold">LAPORAN PENJUALAN BY COGS</h4>
				<h6 class="text-muted">Periode : ' . date_format(date_create($this->input->post("datestart")), "d F Y") . ' - ' . date_format(date_create($this->input->post("dateend")), "d F Y") . '</h6> 
			</div>';
		$content = '';
		$total_item = 0;
		$total_optional = 0;
		$total_pengiriman = 0;
		$total_diskon = 0;
		$total_grandtotal = 0;
		$total_cogs = 0;
		$total_grand = 0;
		foreach ($data_store as $row) {
			$data = $this->db->query('
				SELECT 
					a.SalesCode,
					a.MsWorkplaceCode, 
					sum(a.ItemSales) AS ItemSales,
					sum(a.optional) AS optional,
					sum(a.DiskonItem) + sum(a.SalesDiscTotal) AS DiskonItem,
					sum(a.SalesDeliveryTotal) AS SalesDeliveryTotal,
					sum(a.SalesGrandTotal) AS SalesGrandTotal,
					sum(a.itemCogs) AS itemCogs
					FROM 
				(SELECT    
					SalesCode,
					MsWorkplaceCode, 
					(select sum(SalesOptionalPrice) from TblSalesOptional where SalesOptionalRef=SalesCode) as optional,
					sum(SalesDetailPrice * SalesDetailQty) AS ItemSales,
					sum(SalesDetailDisc * SalesDetailQty) AS DiskonItem,
					sum(MsCogsTotal * SalesDetailQty) AS itemCogs,
					SalesDeliveryTotal,
					SalesDiscTotal,
					SalesGrandTotal
				FROM TblMsWorkplace 
				LEFT JOIN TblSales ON TblSales.MsWorkplaceId=TblMsWorkplace.MsWorkplaceId 
				LEFT JOIN TblSalesDetail ON TblSales.SalesCode=TblSalesDetail.SalesDetailRef 
				LEFT JOIN TblMsCogs ON TblSalesDetail.MsItemId = TblMsCogs.MsItemId AND TblSalesDetail.MsVendorCode= (SELECT MsVendorCode from TblMsVendor where MsVendorId=TblMsCogs.MsVendorId)
				WHERE 
					SalesDate >= "' . $this->input->post("datestart") . '" 
					AND SalesDate <= "' . $this->input->post("dateend") . '" 
					AND SalesStatusPayment > 0 
					AND TblSales.MsWorkplaceId=' . $row->MsWorkplaceId . '
				GROUP BY SalesCode
				ORDER BY MsWorkplaceCode) a')->row();
			$totalitem =  (empty($data->ItemSales) ? 0 : $data->ItemSales);
			$totaloptional =  (empty($data->optional) ? 0 : $data->optional);
			$DiskonItem =  (empty($data->DiskonItem) ? 0 : $data->DiskonItem);
			$SalesDeliveryTotal =  (empty($data->SalesDeliveryTotal) ? 0 : $data->SalesDeliveryTotal);
			$SalesGrandTotal =  (empty($data->SalesGrandTotal) ? 0 : $data->SalesGrandTotal);
			$itemCogs =  (empty($data->itemCogs) ? 0 : $data->itemCogs);
			$profit =  $SalesGrandTotal - $itemCogs - $SalesDeliveryTotal - (empty($data->optional) ? 0 : $data->optional);

			$content .= '
				<tr> 
					<td>' . $row->MsWorkplaceId . '</td>
				    <td style="text-align:center;width:1.5rem"><span data-bs-toggle="tooltip" data-bs-placement="right" title="Lihat Detail Transaksi" class="nested close"></span></td>
					<td>' . $row->MsWorkplaceCode . ' - ' . $row->MsWorkplaceName . '</td>
					<td>' . $totalitem . '</td> 
					<td>' . $totaloptional . '</td> 
					<td>' . $DiskonItem . '</td> 
					<td>' . $SalesDeliveryTotal . '</td> 
					<td>' . $SalesGrandTotal . '</td> 
					<td>' . $itemCogs . '</td> 
					<td>' . $totaloptional . '</td> 
					<td>' . $SalesDeliveryTotal . '</td> 
					<td>' . $profit . '</td> 
				</tr>';
			$total_item += $totalitem;
			$total_optional += $totaloptional;
			$total_diskon += $DiskonItem;
			$total_pengiriman += $SalesDeliveryTotal;
			$total_grandtotal += $SalesGrandTotal;
			$total_cogs += $itemCogs;
			$total_grand += $profit;
		}
		echo '
			<div class="col-12"> 
				<div class="table-responsive">
					<table class="table table-bordered" id="table-ringkasan" style="width: 100%;font-size:0.6rem">
						<thead class="table-secondary text-nowrap"  >
							<tr style="text-align:center;vertical-align:middle"> 
								<th rowspan="2"></th> 
								<th rowspan="2">#</th> 
								<th rowspan="2">Toko</th> 
								<th colspan="5">Penjualan</th> 
								<th colspan="4">Profit</th>  
							</tr>
							<tr style="text-align:center;vertical-align:middle"> 
								<th class="text-center">Item<span class="text-success ps-2">(<i class="fa fa-plus"></i>)</span></th>
								<th class="text-center">Optional<span class="text-success ps-2">(<i class="fa fa-plus"></i>)</span></th>
								<th class="text-center">Diskon<span class="text-danger ps-2">(<i class="fa fa-minus"></i>)</span></th>
								<th class="text-center">Pengiriman<span class="text-success ps-2">(<i class="fa fa-plus"></i>)</span></th> 
								<th class="text-center">Total Sales<span class="text-primary ps-2">(<i class="fa fa-equals"></i>)</span></th>
								<th class="text-center">COGS Item<span class="text-danger ps-2">(<i class="fa fa-minus"></i>)</span></th>
								<th class="text-center">Optional<span class="text-danger ps-2">(<i class="fa fa-minus"></i>)</span></th>
								<th class="text-center">Pengiriman<span class="text-danger ps-2">(<i class="fa fa-minus"></i>)</span></th>
								<th class="text-center">Profit<span class="text-primary ps-2">(<i class="fa fa-equals"></i>)</span></th>
							</tr>
						</thead>
						<tbody>
							' . $content . '
						</tbody>
						<tfoot class="table-light"> 
							<tr style=";vertical-align:middle"> 
								<th></th> 
								<th></th> 
								<th>Total</th>
								<th>
									<div class="d-flex flex-row"> 
										<div>Rp.</div>
										<div class="flex-fill text-end">' . number_format($total_item, 0) . '</div>
									</div>
								</th>
								<th>
									<div class="d-flex flex-row"> 
										<div>Rp.</div>
										<div class="flex-fill text-end">' . number_format($total_optional, 0) . '</div>
									</div>
								</th>
								<th>
									<div class="d-flex flex-row"> 
										<div>Rp.</div>
										<div class="flex-fill text-end">' . number_format($total_diskon, 0) . '</div>
									</div>
								</th>
								<th>
									<div class="d-flex flex-row"> 
										<div>Rp.</div>
										<div class="flex-fill text-end">' . number_format($total_pengiriman, 0) . '</div>
									</div>
								</th>
								<th>
									<di
									$("[data-bs-toggle=\'tooltip\']").tooltip();v class="d-flex flex-row"> 
										<div>Rp.</div>
										<div class="flex-fill text-end ">' . number_format($total_grandtotal, 0) . '</div>
									</div>
								</th>
								<th>
									<div class="d-flex flex-row"> 
										<div>Rp.</div>
										<div class="flex-fill text-end">' . number_format($total_cogs, 0) . '</div>
									</div>
								</th>
								<th>
									<div class="d-flex flex-row"> 
										<div>Rp.</div>
										<div class="flex-fill text-end">' . number_format($total_optional, 0) . '</div>
									</div>
								</th>
								<th>
									<div class="d-flex flex-row"> 
										<div>Rp.</div>
										<div class="flex-fill text-end">' . number_format($total_pengiriman, 0) . '</div>
									</div>
								</th>
								<th>
									<div class="d-flex flex-row"> 
										<div>Rp.</div>
										<div class="flex-fill text-end">' . number_format($total_grand, 0) . '</div>
									</div>
								</th>
							</tr>
						</thead>
					</table> 
				</div>
			</div>';
		echo '</div>
		
		<script> 
			var counter= 0;
			$("[data-bs-toggle=\'tooltip\']").tooltip();
			var oTable = $("#table-ringkasan").DataTable({
				"responsive": false,
				"searching": false,
				"lengthChange": false,	 
				"paging": false,
				"initComplete":function( settings, json){
					 setTimeout(function () {
						$($.fn.dataTable.tables( true ) ).DataTable().columns.adjust().draw();
					},1);   
				},
				columnDefs: [
					{ targets: [1], orderable: false},
					{ targets: [0], visible: false},
					{
						targets: [3,4,5,6,8,9,10],  
						render: function(data,type){
							if (type === "display") {
								return \'<div class="d-flex flex-row"><div>Rp.</div><div class="flex-fill text-end">\' + number_format(parseInt(data)) + \'</div></div>\';
							}
							return data;
						}, 
						className: "text-end"
					},
					{
						targets: [7,11],
						class: "table-primary",
						render: function(data,type){
							if (type === "display") {
								return \'<div class="d-flex flex-row"><div>Rp.</div><div class="flex-fill text-end">\' + number_format(parseInt(data)) + \'</div></div>\';
							}
							return data;
						}, 
					}
				]  
			});	 
			$("#table-ringkasan tbody td span").on("click", function () {
				var nTr = $(this).parents("tr")[0];  
				var row = oTable.row( nTr );
				if (row.child.isShown()) {
				   /* This row is already open - close it */
				   $(this).removeClass("open").addClass("close");  
				   row.child.hide(); 
				}
				else {
				   /* Open this row */
				   row.child(\'<div class="display-in-table" id="display-content-\'+ counter +\'"></div><div id="wait-content-\'+ counter +\'" class="load-container load4" style="display: block;"><div class="load-progress"></div></div>\').show(); 
				   show_display($("#display-content-" + counter),$("#wait-content-" + counter),row.data()[0],counter);
				   $("#display-content-" + counter).parents("tr").addClass("bg-table-1");
				   $(this).removeClass("close").addClass("open"); 
				   counter++;
				}
		  	});  
			function show_display(divdisplay,divloader,header,nourut){  
				$(divdisplay).hide();
				$.ajax({
					type: "POST",
					data: {
					   "datestart": "' . $this->input->post("datestart") . '" ,
					   "dateend": "' . $this->input->post("dateend") . '" ,
					   "store": header,
					   "nourut": nourut, 
					},
					url: "' . base_url("function/client_export_sales/sales_cogs_detail_load") . '",
					success: function(data) {
						$(divloader).hide(); 
						$(divdisplay).html(data);
						$(divdisplay).show();
					}
				 })
			} 
		</script>
		';



		/*************************************** DETAIL **************************************/
	}
	public function sales_cogs_detail_load()
	{
		$storecode = $this->input->post("store");
		$datestart = $this->input->post("datestart");
		$dateend = $this->input->post("dateend");
		$id = $this->input->post("nourut");
		$data = $this->db->query('	
			SELECT    
				SalesCode,
				MsWorkplaceCode, 
				MsWorkplaceName, 
				MsEmpName, 
				(select sum(SalesOptionalPrice) from TblSalesOptional where SalesOptionalRef=SalesCode) as optional,
				MsCustomerId,
				SalesDate,
				sum(SalesDetailPrice * SalesDetailQty) AS ItemSales,
				sum(SalesDetailDisc * SalesDetailQty) AS DiskonItem,
				sum(MsCogsTotal * SalesDetailQty) AS itemCogs,
				SalesDeliveryTotal,
				SalesDiscTotal,
				SalesGrandTotal
			FROM TblMsWorkplace 
			LEFT JOIN TblSales ON TblSales.MsWorkplaceId=TblMsWorkplace.MsWorkplaceId 
			LEFT JOIN TblMsEmployee ON TblSales.MsEmpId=TblMsEmployee.MsEmpId 
			LEFT JOIN TblSalesDetail ON TblSales.SalesCode=TblSalesDetail.SalesDetailRef 
			LEFT JOIN TblMsCogs ON TblSalesDetail.MsItemId = TblMsCogs.MsItemId AND TblSalesDetail.MsVendorCode= (SELECT MsVendorCode from TblMsVendor where MsVendorId=TblMsCogs.MsVendorId)
			WHERE 
				SalesDate >= "' . $this->input->post("datestart") . '" 
				AND SalesDate <= "' . $this->input->post("dateend") . '" 
				AND SalesStatusPayment > 0 
				AND TblSales.MsWorkplaceId=' . $this->input->post("store") . '
			GROUP BY SalesCode
			ORDER BY SalesDate')->result();
		$content = "";
		foreach ($data as $row) {
			$content .= '	
				<tr class="bg-white">	 
					<td style="text-align:center;width:1.5rem"><span data-bs-toggle="tooltip" data-bs-placement="right" title="Lihat Detail Transaksi" class="nested close"></span></td>
					<td>' . $row->SalesCode . '</td>
					<td>' . $row->SalesDate . '</td>
					<td>' . $this->model_app->get_customer_name($row->MsCustomerId) . '</td>
					<td>' . $row->MsEmpName . '</td> 
					<td>' . $row->ItemSales . '</td>  
					<td>' . (empty($row->optional) ? 0 : $row->optional) . '</td>  
					<td>' . ($row->DiskonItem + $row->SalesDiscTotal) . '</td> 
					<td>' . $row->SalesDeliveryTotal . '</td>  
					<td>' . $row->SalesGrandTotal . '</td> 
					<td>' . $row->itemCogs . '</td> 
					<td>' . (empty($row->optional) ? 0 : $row->optional) . '</td>  
					<td>' . $row->SalesDeliveryTotal . '</td>  
					<td>' . ($row->SalesGrandTotal - $row->itemCogs - $row->SalesDeliveryTotal - (empty($row->optional) ? 0 : $row->optional)) . '</td> 
				</tr>';
		}

		echo '
			<div class="row-table-1" style="padding-left:2rem">
				<div class="row pt-2">
					<div class="col-sm-12 col-md-6">
						<h6 class="fw-bold">List Invoice</h4>
					</div>
					<div class="col-sm-12 col-md-6"> 
						<div class="row align-items-center">
							<label for="tb_row" class="col-sm-3 col-form-label">Pencarian</label>
							<div class="col-sm-9">
								<input type="search" id="input-detail-' . $id . '" class="form-control form-control-sm" placeholder="" aria-controls="table-detail-0">
							</div>
						</div>  
					</div>
				</div>
				<table class="table table-bordered" id="table-detail-' . $id . '">
					<thead class="table-secondary text-nowrap"> 
						<tr style="text-align:center;vertical-align:middle">  
							<th rowspan="2">#</th> 
							<th rowspan="2">No. Sales</th> 
							<th rowspan="2">Tgl.</th> 
							<th rowspan="2">Pelanggan</th> 
							<th rowspan="2">Admin</th> 
							<th colspan="5">Penjualan</th> 
							<th colspan="4">Profit</th>  
						</tr>
						<tr style="text-align:center;vertical-align:middle">    
							<th class="text-center">Item<span class="text-success ps-2">(<i class="fa fa-plus"></i>)</span></th>
							<th class="text-center">Optional<span class="text-success ps-2">(<i class="fa fa-plus"></i>)</span></th>
							<th class="text-center">Diskon<span class="text-danger ps-2">(<i class="fa fa-minus"></i>)</span></th>
							<th class="text-center">Pengiriman<span class="text-success ps-2">(<i class="fa fa-plus"></i>)</span></th> 
							<th class="text-center">Sales<span class="text-primary ps-2">(<i class="fa fa-equals"></i>)</span></th>
							<th class="text-center">COGS Item<span class="text-danger ps-2">(<i class="fa fa-minus"></i>)</span></th>
							<th class="text-center">Optional<span class="text-success ps-2">(<i class="fa fa-minus"></i>)</span></th>
							<th class="text-center">Pengiriman<span class="text-danger ps-2">(<i class="fa fa-minus"></i>)</span></th>
							<th class="text-center">Profit<span class="text-primary ps-2">(<i class="fa fa-equals"></i>)</span></th>
						</tr> 
					</thead>
					<tbody>' . $content . '</tbody>
					<tfoot>
						<tr class="table-secondary">
							<th colspan="5" class ="text-center">Total</th> 
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
					</tfoot>
				</table>
			</div>
			<script> 
			 	var counter' . $id . ' = 0; 
				var oTable' . $id . ' = $("#table-detail-' . $id . '").DataTable({   
					"searching": true,
					"scrollY": "300px", 
					"scrollCollapse": true,
					"responsive": false, 
					"lengthChange": false,	 
					"paging": false,
					"AutoWidth": false, 
					columnDefs: [
						{ targets: [0], orderable: false}, 
						{ targets: [2,3,4], visible: false}, 
						{
							targets: [1],
							"render": function ( data, type, row, meta ) {
								var html=\'<div class="d-flex">\';
								html+=\'	<span class="flex-fill">\' + row[1] + \'</span>\';
								html+=\'	<span class="fw-bold">\' + row[2] + \'</span>\';
								html+=\'</div>\';
								html+=\'<div class="d-flex">\'; 
								html+=\'	<span class="fw-bold">\' + row[3] + \'</span>\';
								html+=\'</div>\'; 
								html+=\'<div class="d-flex">\'; 
								html+=\'	<span class="float-end">(\' + row[4] + \')</span>\';
								html+=\'</div> \';
								return html;
							}
						},
						{
							targets: [5,6,7,8,10,11,12],  
							render: function(data,type){
								if (type === "display") {
									return \'<div class="d-flex flex-row"><div>Rp.</div><div class="flex-fill text-end" >\' + number_format(parseInt(data)) + \'</div></div>\';
								}
								return data;
							}, 
							className: "text-end"
						},
						{
							targets: [9,13],
							class: "table-primary",
							render: function(data,type){
								if (type === "display") {
									return \'<div class="d-flex flex-row"><div>Rp.</div><div class="flex-fill text-end" >\' + number_format(parseInt(data)) + \'</div></div>\';
								}
								return data;
							}, 
						}
					] ,
					"initComplete":function( settings, json){
						 setTimeout(function () {
							$($.fn.dataTable.tables( true ) ).DataTable().columns.adjust().draw();
						},1);   
					},
					footerCallback: function (row, data, start, end, display) {
						var api = this.api();
			 
						// Remove the formatting to get integer data for summation
						var intVal = function (i) {
							return typeof i === \'string\' ? i.replace(/[\$,]/g, \'\') * 1 : typeof i === \'number\' ? i : 0;
						};
			  
						pageTotal = api.column(5, { page: \'current\' }).data().reduce(function (a, b) {return intVal(a) + intVal(b); }, 0); 
						$(api.column(5).footer()).html(\'<div class="d-flex flex-row"><div>Rp.</div><div class="flex-fill text-end" >\' + number_format(parseInt(pageTotal)) + \'</div></div>\');

						pageTotal = api.column(6, { page: \'current\' }).data().reduce(function (a, b) {return intVal(a) + intVal(b); }, 0); 
						$(api.column(6).footer()).html(\'<div class="d-flex flex-row"><div>Rp.</div><div class="flex-fill text-end" >\' + number_format(parseInt(pageTotal)) + \'</div></div>\');

						pageTotal = api.column(7, { page: \'current\' }).data().reduce(function (a, b) {return intVal(a) + intVal(b); }, 0); 
						$(api.column(7).footer()).html(\'<div class="d-flex flex-row"><div>Rp.</div><div class="flex-fill text-end" >\' + number_format(parseInt(pageTotal)) + \'</div></div>\');

						pageTotal = api.column(8, { page: \'current\' }).data().reduce(function (a, b) {return intVal(a) + intVal(b); }, 0); 
						$(api.column(8).footer()).html(\'<div class="d-flex flex-row"><div>Rp.</div><div class="flex-fill text-end" >\' + number_format(parseInt(pageTotal)) + \'</div></div>\');

						pageTotal = api.column(9, { page: \'current\' }).data().reduce(function (a, b) {return intVal(a) + intVal(b); }, 0); 
						$(api.column(9).footer()).html(\'<div class="d-flex flex-row"><div>Rp.</div><div class="flex-fill text-end" >\' + number_format(parseInt(pageTotal)) + \'</div></div>\');

						pageTotal = api.column(10, { page: \'current\' }).data().reduce(function (a, b) {return intVal(a) + intVal(b); }, 0); 
						$(api.column(10).footer()).html(\'<div class="d-flex flex-row"><div>Rp.</div><div class="flex-fill text-end" >\' + number_format(parseInt(pageTotal)) + \'</div></div>\');

						pageTotal = api.column(11, { page: \'current\' }).data().reduce(function (a, b) {return intVal(a) + intVal(b); }, 0); 
						$(api.column(11).footer()).html(\'<div class="d-flex flex-row"><div>Rp.</div><div class="flex-fill text-end" >\' + number_format(parseInt(pageTotal)) + \'</div></div>\');
						
						pageTotal = api.column(12, { page: \'current\' }).data().reduce(function (a, b) {return intVal(a) + intVal(b); }, 0); 
						$(api.column(12).footer()).html(\'<div class="d-flex flex-row"><div>Rp.</div><div class="flex-fill text-end" >\' + number_format(parseInt(pageTotal)) + \'</div></div>\');
					
						pageTotal = api.column(13, { page: \'current\' }).data().reduce(function (a, b) {return intVal(a) + intVal(b); }, 0); 
						$(api.column(13).footer()).html(\'<div class="d-flex flex-row"><div>Rp.</div><div class="flex-fill text-end" >\' + number_format(parseInt(pageTotal)) + \'</div></div>\');
					},
				});	   
				$("#table-detail-' . $id . '_filter").hide();
				$("#input-detail-' . $id . '").keyup(function(){ 
					oTable' . $id . '.search($(this).val()).draw() ;
				});
				$("#table-detail-' . $id . ' tbody td .nested").on("click", function () {
					var nTr = $(this).parents("tr")[0];  
					var row = oTable' . $id . '.row( nTr );
					if (row.child.isShown()) { 
						$(this).removeClass("open").addClass("close");  
						row.child.hide(); 
					} else { 
						row.child(\'<div class="display-in-table" id="display-detail-content-\'+ counter' . $id . ' +\'"></div><div id="wait-detail-content-\'+ counter' . $id . ' +\'" class="load-container load4" style="display: block;"><div class="load-progress"></div></div>\').show(); 
						show_display_detail($("#display-detail-content-" + counter' . $id . '),$("#wait-detail-content-" + counter' . $id . '),row.data()[1],counter' . $id . ');
						$("#display-detail-content-" + counter' . $id . ').parent().parent("tr").addClass("bg-table-2"); 
						$(this).removeClass("close").addClass("open"); 
						counter' . $id . '++;
					}
				});  
				function show_display_detail(divdisplay,divloader,header,nourut){  
					$(divdisplay).hide();
					$.ajax({
						type: "POST",
						data: {
						   "datestart": "' . $this->input->post("datestart") . '" ,
						   "dateend": "' . $this->input->post("dateend") . '" ,
						   "code": header,
						   "nourut": nourut, 
						},
						url: "' . base_url("function/client_export_sales/sales_cogs_detail_item_load") . '",
						success: function(data) {
							$(divloader).hide(); 
							$(divdisplay).html(data);
							$(divdisplay).show();
						}
					 })
				} 
			</script>
			';
	}
	public function sales_cogs_detail_item_load()
	{
		$code = $this->input->post("code");
		$datestart = $this->input->post("datestart");
		$dateend = $this->input->post("dateend");
		$id = $this->input->post("nourut");

		$data = $this->db->query('SELECT 
			concat(MsItemCode," - ",MsItemName," (",MsVendorCode,")") AS ItemName,
			MsItemSize,
			concat(SalesDetailQty," ",MsItemUom) AS qty, 
			SalesDetailPrice,
			(SalesDetailPrice * SalesDetailQty) AS Subtotal,
			(SalesDetailDisc * SalesDetailQty) AS Disc, 
			(SalesDetailPrice * SalesDetailQty) - (SalesDetailDisc * SalesDetailQty) AS Total,
			(SalesDetailCogs * SalesDetailQty) AS COGS,
			(SalesDetailPrice * SalesDetailQty) - (SalesDetailDisc * SalesDetailQty) - (SalesDetailCogs * SalesDetailQty) AS profit
			FROM TblSalesDetail 
			LEFT JOIN TblMsItem ON TblMsItem.MsItemId=TblSalesDetail.MsItemId
			WHERE SalesDetailRef="' . $code . '"
		')->result();
		$total = 0;
		$profit = 0;
		$cogs = 0;
		$content = '';
		foreach ($data as $row) {
			$content .= '<tr>
							<td>' . $row->ItemName . '</td>
							<td>' . $row->MsItemSize . '</td>
							<td>' . $row->qty . '</td>
							<td>' . $row->SalesDetailPrice . '</td>
							<td>' . $row->Subtotal . '</td>
							<td>' . $row->Disc . '</td>
							<td>' . $row->Total . '</td>
							<td>' . $row->COGS . '</td>
							<td>' . $row->profit . '</td>
						</tr>';
			$total += $row->Total;
			$profit += $row->profit;
			$cogs += $row->COGS;
		}

		$data = $this->db->query('SELECT 
			SalesOptionalDesc,
			SalesOptionalPrice
			FROM TblSalesOptional  
			WHERE SalesOptionalRef="' . $code . '"
		')->result();

		foreach ($data as $row) {
			$content .= '<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>' . $row->SalesOptionalDesc . '</td> 
							<td>' . $row->SalesOptionalPrice . '</td> 
							<td>' . $row->SalesOptionalPrice . '</td>
							<td>0</td>
						</tr>';
			$total += $row->SalesOptionalPrice;
			$cogs += $row->SalesOptionalPrice;
		}
		echo '
			<div class="row-table-1" style="padding-left:2rem">
				<div class="row py-2">
					<div class="col-sm-12 col-md-6">
						<h6 class="fw-bold">List Item</h4>
					</div>
					<div class="col-sm-12 col-md-6"> 
						 
					</div>
				</div>
				<table class="table table-bordered" id="table-detail-item-' . $id . '">
					<thead class="table-secondary text-nowrap"> 
						<tr style="text-align:center;vertical-align:middle">  
							<th>Nama Item</th> 
							<th>Ukuran</th> 
							<th>Jumlah</th> 
							<th>Harga Satuan</th> 
							<th>Sub Total</th> 
							<th>Disc</th> 
							<th>Total</th>  
							<th>Cogs</th>   
							<th>Profit</th> 
						</tr> 
					</thead>
					<tbody class="bg-white">' . $content . '</tbody> 
					<tfoot>
						<tr class="table-secondary">
							<th colspan="6" class ="text-center">Total</th> 
							<th><div class="d-flex flex-row"><div>Rp.</div><div class="flex-fill text-end" >' . number_format($total, 0) . '</div></div></th>
							<th><div class="d-flex flex-row"><div>Rp.</div><div class="flex-fill text-end" >' . number_format($cogs, 0) . '</div></div></th>
							<th><div class="d-flex flex-row"><div>Rp.</div><div class="flex-fill text-end" >' . number_format($profit, 0) . '</div></div></th> 
						</tr>
					</tfoot>
				</table>
			</div>
			<script> 
				var oTableItem' . $id . ' = $("#table-detail-item-' . $id . '").DataTable({    
					"responsive": false, 
					"lengthChange": false,	 
					"paging": false,
					"AutoWidth": false,
					"ordering": false,
					"searching": false,
					"createdRow": function( row, data, dataIndex ) {
						if(data[0] === ""){ 
							// // Add COLSPAN attribute
							$("td:eq(0)", row).attr("colspan", 6);
				
							// // Hide required number of columns
							// // next to the cell with COLSPAN attribute
							$("td:eq(1)", row).css("display", "none");
							$("td:eq(2)", row).css("display", "none");
							$("td:eq(3)", row).css("display", "none");
							$("td:eq(4)", row).css("display", "none");
							$("td:eq(5)", row).css("display", "none");
				
							// // Update cell data
							this.api().cell($("td:eq(0)", row)).data(data[5]);
						}
					  },
					columnDefs: [  
						{
							targets: [3,4,5,7],  
							render: function(data,type){
								if (type === "display") {
									return \'<div class="d-flex flex-row"><div>Rp.</div><div class="flex-fill text-end" >\' + number_format(parseInt(data)) + \'</div></div>\';
								}
							
							}, 
							className: "text-end"
						},
						{
							targets: [6,8],
							class: "table-primary",
							render: function(data,type){
								if (type === "display") {
									return \'<div class="d-flex flex-row"><div>Rp.</div><div class="flex-fill text-end" >\' + number_format(parseInt(data)) + \'</div></div>\';
								}
								return data;
							}, 
						}
					] , 
				});	   
			</script>
			';
	}
	public function sales_payment_load()
	{
		$data = $this->db
			->join("TblMsCustomer", "TblSales.MsCustomerId=TblMsCustomer.MsCustomerId", "left")
			->join("TblMsEmployee", "TblSales.MsEmpId=TblMsEmployee.MsEmpId", "left")
			->where("SalesDate >=", $this->input->post("datestart"))
			->where("SalesDate <=", $this->input->post("dateend"))
			->where("TblSales.MsWorkplaceId", $this->input->post("store"))
			->where_in("SalesStatusPayment", array(1, 2))->order_by("SalesDate ASC")->get("TblSales")->result();
		echo '
		<div class="row ">
			<div class="col-sm-12 text-center ">
				<h4 class="font-weight-bold">LAPORAN PENJUALAN BY PAYMENT</h4>
				<h6 class="text-muted">Periode : ' . date_format(date_create($this->input->post("datestart")), "d/m/Y") . ' - ' . date_format(date_create($this->input->post("dateend")), "d/m/Y") . '</h6>
				<h6 class="text-muted">Toko : ' . ($this->db->where("MsWorkplaceId", $this->input->post("store"))->get("TblMsWorkplace")->row())->MsWorkplaceCode . '</h6>
			</div>
			<div class="table-responsive">
				<table class="table table-sm">
					<thead class="thead-light">
						<tr>
							<th scope="col">#</th>
							<th scope="col">Transaksi</th>
							<th scope="col">Customer</th>
							<th scope="col">Item</th>
							<th scope="col">Pembayaran</th>
						</tr>
					</thead>
					<tbody>';
		$no = 1;
		foreach ($data as $row) {
			$trans = '
				<div class="d-flex flex-column">
					<div><span class="text-secondary pe-2">Tanggal</span>' . $row->SalesDate . '</div> 
					<div><span class="text-secondary pe-2">No. Inv</span>' . $row->SalesCode . '</div> 
					<div><span class="text-secondary pe-2">Admin</span>' . $row->MsEmpName . '</div>  
				</div>
			';
			$cust = '
				<div class="d-flex flex-column">
					<div class="fw-bold"> ' . $this->model_app->get_customer_name_by_array(array("MsCustomerName" => $row->MsCustomerName, "MsCustomerCompany" => $row->MsCustomerCompany)) . '</div>
					<div>' . $this->model_app->get_customer_telp_by_array(array("MsCustomerTelp1" => $row->MsCustomerTelp1, "MsCustomerTelp2" => $row->MsCustomerTelp2)) . '</div>
					<div style="max-width:20rem"><small>' . $row->MsCustomerAddress . '</small></div>
				</div>
			';
			$data_item = $this->db->join("TblMsItem", "TblMsItem.MsItemId=TblSalesDetail.MsItemId", "left")->where("SalesDetailRef", $row->SalesCode)->get("TblSalesDetail")->result();
			$item = '<div class="d-flex flex-column">';
			foreach ($data_item as $rows) {
				$item .= '<div>' . $rows->MsItemCode . ' - ' . $rows->MsItemName . ' | <span class="fw-bold">' . $rows->SalesDetailQty . ' ' . $rows->MsItemUoM . '</span></div>';
			}
			$item .= "</div>";
			$data_payment = $this->db->join("TblMsMethod", "TblMsMethod.MsMethodId=TblSalesPayment.MsMethodId", "left")->where("PaymentRef", $row->SalesCode)->get("TblSalesPayment")->result();
			$payment = '<div class="d-flex flex-column">';
			$payment .= '<div class="mb-1"> <small>Total Transaksi</small> <span class="fw-bold"> Rp. ' . number_format($row->SalesGrandTotal, 0) . ' </span></div><small class="fw-bold">Pembayaran</small>';
			$total_pem = $row->SalesGrandTotal;
			foreach ($data_payment as $rows) {
				$total_pem -= $rows->PaymentTotal;
				$payment .= '<div><small>' . $rows->MsMethodCode . ' - ' . $rows->MsMethodName . ' </small>| <span class="fw-bold"> Rp. ' . number_format($rows->PaymentTotal, 0) . ' </span></div>';
			}
			$payment .= '<div class="mt-1"><small>Sisa pembayaran</small> <span class="fw-bold"> Rp. ' . number_format($total_pem, 0) . ' </span></div>';
			$payment .= "</div>";
			echo '
			<tr>
				<td>' . $no . '</td>
				<td>' . $trans . '</td>
				<td>' . $cust . '</td>
				<td>' . $item . '</td>
				<td>' . $payment . '</td> 
			</tr>
			';
			$no++;
		}
		echo '
					</tbody>
				</table>
			</div>
		</div>';
	}
	public function sales_payment_export()
	{
		$data = $this->db
			->join("TblMsCustomer", "TblSales.MsCustomerId=TblMsCustomer.MsCustomerId", "left")
			->join("TblMsEmployee", "TblSales.MsEmpId=TblMsEmployee.MsEmpId", "left")
			->where("SalesDate >=", $this->input->post("datestart"))
			->where("SalesDate <=", $this->input->post("dateend"))
			->where("TblSales.MsWorkplaceId", $this->input->post("store"))
			->where_in("SalesStatusPayment", array(1, 2))->order_by("SalesDate ASC")->get("TblSales")->result();

		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()->setCreator('Syahrul Fauzan')
			->setLastModifiedBy('Syahrul Fauzan')
			->setTitle('Office 2007 XLSX Test Document')
			->setSubject('Office 2007 XLSX Test Document')
			->setDescription('EXPORT BY OBI-WEB')
			->setKeywords('office 2007 openxml php')
			->setCategory('Application');



		$worksheet = $spreadsheet->getActiveSheet();
		$worksheet->setTitle("Laporan Sales Item By Payment");

		$header = ($this->db->where("MsWorkplaceId", $this->input->post("store"))->get("TblMsWorkplace")->row())->MsWorkplaceCode;

		$worksheet->setCellValue('A1', 'REPORT SALES BY PAYMENT');
		$worksheet->setCellValue('A2', 'Toko : ' . $header);
		$worksheet->setCellValue('A3', "Periode : " . $this->input->post("datestart") . " " . $this->input->post("dateend"));
		$worksheet->getStyle('A1:E1')->getFont()->setSize(15);
		$worksheet->getStyle('A1:E1')->getFont()->setBold(true);
		$worksheet->getStyle('A2:E3')->getFont()->setSize(12);
		$worksheet->getStyle('A2:E3')->getFont()->setBold(true);


		$worksheet->setCellValue('A5', 'No.')->mergeCells('A5:A6');
		$worksheet->setCellValue('B5', 'Transaksi')->mergeCells('B5:D5')->setCellValue('B6', 'Tanggal')->setCellValue('C6', 'Kode')->setCellValue('D6', 'Admin');
		$worksheet->setCellValue('E5', 'Customer')->mergeCells('E5:G5')->setCellValue('E6', 'Nama')->setCellValue('F6', 'Telp')->setCellValue('G6', 'Alamat');
		$worksheet->setCellValue('H5', 'Item 1')->mergeCells('H5:I5')->setCellValue('H6', 'Nama')->setCellValue('I6', 'Total');
		$worksheet->setCellValue('J5', 'Item 2')->mergeCells('J5:K5')->setCellValue('J6', 'Nama')->setCellValue('K6', 'Total');
		$worksheet->setCellValue('L5', 'Item 3')->mergeCells('L5:M5')->setCellValue('L6', 'Nama')->setCellValue('M6', 'Total');
		$worksheet->setCellValue('N5', 'Item 4')->mergeCells('N5:O5')->setCellValue('N6', 'Nama')->setCellValue('O6', 'Total');
		$worksheet->setCellValue('P5', 'Item 5')->mergeCells('P5:Q5')->setCellValue('P6', 'Nama')->setCellValue('Q6', 'Total');
		$worksheet->setCellValue('R5', 'Payment 1')->mergeCells('R5:S5')->setCellValue('R6', 'Type')->setCellValue('S6', 'Total');
		$worksheet->setCellValue('T5', 'Payment 2')->mergeCells('T5:U5')->setCellValue('T6', 'Type')->setCellValue('U6', 'Total');
		$worksheet->setCellValue('V5', 'Payment 3')->mergeCells('V5:W5')->setCellValue('V6', 'Type')->setCellValue('W6', 'Total');
		$worksheet->setCellValue('X5', 'Sub Total')->mergeCells('X5:X6');
		$worksheet->setCellValue('Y5', 'Pengiriman')->mergeCells('Y5:Y6');
		$worksheet->setCellValue('Z5', 'Diskon')->mergeCells('Z5:Z6');
		$worksheet->setCellValue('AA5', 'Grand Total')->mergeCells('AA5:AA6');
		$worksheet->setCellValue('AB5', 'Total Bayar')->mergeCells('AB5:AB6');
		$worksheet->setCellValue('AC5', 'Sisa')->mergeCells('AC5:AC6');

		$worksheet->getStyle('A5:AC6')->getFont()->setSize(11);
		$worksheet->getStyle('A5:AC6')->getFont()->setBold(true);
		$worksheet->getStyle('A5:AC6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$worksheet->getStyle('A5:AC6')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

		$row_number = 7;
		$no = 1;
		foreach ($data as $row) {
			$worksheet->setCellValue('A' . $row_number, $no);
			$worksheet->setCellValue('B' . $row_number, $row->SalesDate);
			$worksheet->setCellValue('C' . $row_number, $row->SalesCode);
			$worksheet->setCellValue('D' . $row_number, $row->MsEmpName);
			$worksheet->setCellValue('E' . $row_number, $this->model_app->get_customer_name_by_array(array("MsCustomerName" => $row->MsCustomerName, "MsCustomerCompany" => $row->MsCustomerCompany)));
			$worksheet->setCellValue('F' . $row_number, $this->model_app->get_customer_telp_by_array(array("MsCustomerTelp1" => $row->MsCustomerTelp1, "MsCustomerTelp2" => $row->MsCustomerTelp2)));
			$worksheet->setCellValue('G' . $row_number, $row->MsCustomerAddress);

			$data_item = $this->db->join("TblMsItem", "TblMsItem.MsItemId=TblSalesDetail.MsItemId", "left")->where("SalesDetailRef", $row->SalesCode)->get("TblSalesDetail")->result();
			$col = "H";
			foreach ($data_item as $rows) {
				$worksheet->setCellValue($col . $row_number, $rows->MsItemCode . ' - ' . $rows->MsItemName);
				$col++;
				$worksheet->setCellValue($col . $row_number, $rows->SalesDetailQty . ' ' . $rows->MsItemUoM);
				$col++;
			}

			$total_sisa = $row->SalesGrandTotal;
			$total_pem = 0;
			$data_payment = $this->db->join("TblMsMethod", "TblMsMethod.MsMethodId=TblSalesPayment.MsMethodId", "left")->where("PaymentRef", $row->SalesCode)->get("TblSalesPayment")->result();
			$col = "R";
			foreach ($data_payment as $rows) {
				$worksheet->setCellValue($col . $row_number, $rows->MsMethodCode . ' - ' . $rows->MsMethodName);
				$col++;
				$worksheet->setCellValue($col . $row_number, $rows->PaymentTotal);
				$col++;
				$total_sisa -= $rows->PaymentTotal;
				$total_pem += $rows->PaymentTotal;
			}

			$worksheet->setCellValue('X' . $row_number, $row->SalesSubTotal);
			$worksheet->setCellValue('Y' . $row_number, $row->SalesDeliveryTotal);
			$worksheet->setCellValue('Z' . $row_number, $row->SalesDiscTotal);
			$worksheet->setCellValue('AA' . $row_number, $row->SalesGrandTotal);
			$worksheet->setCellValue('AB' . $row_number, $total_pem);
			$worksheet->setCellValue('AC' . $row_number, $total_sisa);


			$row_number++;
			$no++;
		}

		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(30);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(30);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(30);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(50);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(30);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(30);
		$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(30);
		$spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(30);
		$spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(30);
		$spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('U')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('V')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('W')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('X')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('Y')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('Z')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('AA')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('AB')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('AC')->setWidth(15);

		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->setIncludeCharts(true);

		$filename = "REPORT SALES BY PAYMENT " . $this->input->post("datestart") . " " . $this->input->post("dateend"); // set filename for excel file to be exported
		header('Content-Type: application/vnd.ms-excel'); // generate excel file
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');	// download file
	}
	public function sales_load_qr($id, $store)
	{
		$this->load->library('ciqrcode');

		header("Content-Type: image/png");
		$params['data'] = ($store == 1 ? 'https://bit.ly/3i4sM1r' : ($store == 2 ? 'https://bit.ly/3o2AUDf' : 'https://bit.ly/3EPUit0')); //site_url("report/sales/") . $id;
		$this->ciqrcode->generate($params);
	}
	public function sales_load_qr_delivery($id)
	{
		$this->load->library('ciqrcode');

		header("Content-Type: image/png");
		$params['data'] = site_url("report/pengiriman/") . $id;
		$this->ciqrcode->generate($params);
	}
	public function sales_load_qr_po($id)
	{
		$this->load->library('ciqrcode');

		header("Content-Type: image/png");
		$params['data'] = site_url("report/po/") . $id;
		$this->ciqrcode->generate($params);
	}
	public function create_qr_code($lat, $lng)
	{
		$this->load->library('ciqrcode');
		header("Content-Type: image/png");
		$params['data'] = "https://maps.google.com/?q=" . $lat . "," . $lng;
		$this->ciqrcode->generate($params);
	}
}
 
