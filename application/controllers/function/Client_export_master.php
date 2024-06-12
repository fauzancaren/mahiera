<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Client_export_master extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('model_app');
		$this->load->library('pdf');
		date_default_timezone_set('Asia/Jakarta');
	}

	/*
    *       EXPORT DATA TOKO
    */

	function data_toko_export_excel()
	{
		$data = $this->db->query("SELECT * FROM TblMsWorkplace")->result();

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

		$sheet->setCellValue('C2', 'DATA TOKO');
		$sheet->getRowDimension(2)->setRowHeight(40);
		$sheet->mergeCells("C2:I2");
		$sheet->getStyle("C2:I2")->getFont()->setSize(26);
		$sheet->getStyle("C2:I2")->getFont()->setBold(true);
		$sheet->getStyle("C2")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("C2")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

		//---------------------------  Header Table
		$sheet->setCellValue('A3', 'No');
		$sheet->setCellValue('B3', 'Kode');
		$sheet->setCellValue('C3', 'Nama');
		$sheet->setCellValue('D3', 'Tipe');
		$sheet->setCellValue('E3', 'Alamat');
		$sheet->setCellValue('F3', 'Telp 1');
		$sheet->setCellValue('G3', 'Telp 2');
		$sheet->setCellValue('H3', 'Fax');
		$sheet->setCellValue('I3', 'Status');
		$sheet->getRowDimension(3)->setRowHeight(25);
		$sheet->getStyle("A3:I3")->getFont()->setBold(true);
		$sheet->getStyle("A3:I3")->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
		$sheet->getStyle('A3:I3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
		$sheet->getStyle('A3:I3')->getFill()->getStartColor()->setARGB('FF25221d');
		$sheet->getStyle("A3:I3")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("A3:I3")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

		$sheet->getStyle('A3:I3')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle('A3:I3')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle('A3:I3')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle('A3:I3')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		//---------------------------  Isi Table
		$kolom = 4;
		$nomor = 1;
		foreach ($data as $row) {

			$sheet->getRowDimension($kolom)->setRowHeight(25);
			$sheet->getStyle("A" . $kolom . ":I" . $kolom)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("A" . $kolom . ":I" . $kolom)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			$sheet->getStyle("A" . $kolom . ":I" . $kolom)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle("A" . $kolom . ":I" . $kolom)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle("A" . $kolom . ":I" . $kolom)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle("A" . $kolom . ":I" . $kolom)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

			$sheet->setCellValue('A' . $kolom, $nomor);
			$sheet->setCellValue('B' . $kolom, $row->MsWorkplaceCode);
			$sheet->setCellValue('C' . $kolom, $row->MsWorkplaceName);
			$sheet->setCellValue('D' . $kolom, ($row->MsWorkplaceType == 0 ? "TOKO" : "GUDANG"));
			$sheet->setCellValue('E' . $kolom, $row->MsWorkplaceAddress);
			$sheet->setCellValue('F' . $kolom, $row->MsWorkplaceTelp1);
			$sheet->setCellValue('G' . $kolom, $row->MsWorkplaceTelp2);
			$sheet->setCellValue('H' . $kolom, $row->MsWorkplaceFax);
			$sheet->setCellValue('I' . $kolom, ($row->MsWorkplaceIsActive == 1 ? "Aktif" : "Tidak Aktif"));

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
		header('Content-Disposition: attachment;filename="Data-master-datatoko.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
		//$writer->save("upload/data-master-datatoko.xlsx");
		//header("Content-Type: application/vnd.ms-excel");
		//redirect(base_url()."upload/test.xlsx");        
	}
	function data_toko_export_pdf()
	{
		$data['datatable'] = $this->db->query("SELECT * FROM TblMsWorkplace")->result();

		//$this->pdf->setPaper('A4', 'potrait');
		$this->pdf->setPaper('A4', 'landscape');
		$this->pdf->set_option('isRemoteEnabled', true);
		$this->pdf->filename = "Export Data Toko.pdf";
		$this->pdf->load_view('report/masterdata/datatoko', $data);
	}
	/*
    *       EXPORT DATA JABATAN
    */
	function data_jabatan_export_excel()
	{
		$data = $this->db->query("SELECT * FROM TblMsEmployeePosition")->result();

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
		$sheet->mergeCells("C1:D1");
		$sheet->getStyle("C1:D1")->getFont()->setSize(36);
		$sheet->getStyle("C1:D1")->getFont()->setBold(true);
		$sheet->getStyle("C1")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("C1")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);

		$sheet->setCellValue('C2', 'DATA JABATAN');
		$sheet->getRowDimension(2)->setRowHeight(40);
		$sheet->mergeCells("C2:D2");
		$sheet->getStyle("C2:D2")->getFont()->setSize(26);
		$sheet->getStyle("C2:D2")->getFont()->setBold(true);
		$sheet->getStyle("C2")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("C2")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

		//---------------------------  Header Table
		$sheet->setCellValue('A3', 'No');
		$sheet->setCellValue('B3', 'Kode');
		$sheet->setCellValue('C3', 'Nama');
		$sheet->setCellValue('D3', 'Status');
		$sheet->getRowDimension(3)->setRowHeight(25);
		$sheet->getStyle("A3:D3")->getFont()->setBold(true);
		$sheet->getStyle("A3:D3")->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
		$sheet->getStyle('A3:D3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
		$sheet->getStyle('A3:D3')->getFill()->getStartColor()->setARGB('FF25221d');
		$sheet->getStyle("A3:D3")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("A3:D3")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

		$sheet->getStyle('A3:D3')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle('A3:D3')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle('A3:D3')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle('A3:D3')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		//---------------------------  Isi Table
		$kolom = 4;
		$nomor = 1;
		foreach ($data as $row) {

			$sheet->getRowDimension($kolom)->setRowHeight(25);
			$sheet->getStyle("A" . $kolom . ":D" . $kolom)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("A" . $kolom . ":D" . $kolom)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			$sheet->getStyle("A" . $kolom . ":D" . $kolom)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle("A" . $kolom . ":D" . $kolom)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle("A" . $kolom . ":D" . $kolom)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle("A" . $kolom . ":D" . $kolom)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

			$sheet->setCellValue('A' . $kolom, $nomor);
			$sheet->setCellValue('B' . $kolom, $row->MsEmpPositionCode);
			$sheet->setCellValue('C' . $kolom, $row->MsEmpPositionName);
			$sheet->setCellValue('D' . $kolom, ($row->MsEmpPositionIsActive == 1 ? "Aktif" : "Tidak Aktif"));

			$kolom++;
			$nomor++;
		}

		$sheet->getColumnDimension('A')->setAutoSize(false);
		$sheet->getColumnDimension('A')->setWidth(10);
		$sheet->getColumnDimension('B')->setAutoSize(false);
		$sheet->getColumnDimension('B')->setWidth(20);
		$sheet->getColumnDimension('C')->setAutoSize(false);
		$sheet->getColumnDimension('C')->setWidth(70);
		$sheet->getColumnDimension('D')->setAutoSize(false);
		$sheet->getColumnDimension('D')->setWidth(30);
		$sheet->setShowGridlines(false);

		$writer = new Xlsx($spreadsheet);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data-master-datajabatan.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
		//$writer->save("upload/data-master-datatoko.xlsx");
		//header("Content-Type: application/vnd.ms-excel");
		//redirect(base_url()."upload/test.xlsx");        
	}
	function data_jabatan_export_pdf()
	{
		$data['datatable'] = $this->db->query("SELECT * FROM TblMsEmployeePosition")->result();

		$this->pdf->setPaper('A4', 'potrait');
		//$this->pdf->setPaper('A4', 'landscape');
		$this->pdf->set_option('isRemoteEnabled', true);
		$this->pdf->filename = "Export Data Jabatan.pdf";
		$this->pdf->load_view('report/masterdata/datajabatan', $data);
	}
	/*
    *       EXPORT DATA KARYAWAN
    */
	function data_karyawan_export_person_pdf($id)
	{
		$dataemployee = $this->db->query("SELECT * FROM TblMsEmployee as b 
												left join TblMsWorkplace as c on b.MsWorkplaceId=c.MsWorkplaceId
												left join TblMsEmployeePosition as d on d.MsEmpPositionId=b.MsEmpPositionId WHERE MsEmpId=$id")
			->result();

		$data['datatable'] = (array) $dataemployee[0];
		//$data_html = $this->load->view('report/masterdata/datakaryawanperson', $data, TRUE);

		//$mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
		//$mpdf->AddPage('L');  Landscape
		//$mpdf->WriteHTML($data_html);
		//$mpdf->Output();

		$this->pdf->setPaper('A4', 'potrait');
		$this->pdf->set_option('isRemoteEnabled', true);
		$this->pdf->filename = "Export Data Jabatan.pdf";
		$this->pdf->load_view('report/masterdata/datakaryawanperson', $data);


		// $this->load->view('report/masterdata/datakaryawanperson', $data);
	}
	function data_karyawan_export_excel()
	{
		$data = $this->db->query("SELECT * FROM TblMsEmployee as b 
									left join TblMsWorkplace as c on b.MsWorkplaceId=c.MsWorkplaceId
									left join TblMsEmployeePosition as d on d.MsEmpPositionId=b.MsEmpPositionId")->result();

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
		$sheet->mergeCells("C1:D1");
		$sheet->getStyle("C1:D1")->getFont()->setSize(36);
		$sheet->getStyle("C1:D1")->getFont()->setBold(true);
		$sheet->getStyle("C1")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("C1")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);

		$sheet->setCellValue('C2', 'DATA KARYAWAN');
		$sheet->getRowDimension(2)->setRowHeight(40);
		$sheet->mergeCells("C2:D2");
		$sheet->getStyle("C2:D2")->getFont()->setSize(26);
		$sheet->getStyle("C2:D2")->getFont()->setBold(true);
		$sheet->getStyle("C2")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("C2")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

		//---------------------------  Header Table

		$sheet->setCellValue('A3', 'Detail');
		$sheet->mergeCells('A3:E3');
		$sheet->setCellValue('F3', 'Personal');
		$sheet->mergeCells('F3:K3');
		$sheet->setCellValue('L3', 'perusahaan');
		$sheet->mergeCells('L3:N3');
		$sheet->setCellValue('O3', 'Akun Bank');
		$sheet->mergeCells('O3:Q3');
		$sheet->getRowDimension(3)->setRowHeight(25);
		$sheet->setCellValue('A4', 'No');
		$sheet->setCellValue('B4', 'Kode');
		$sheet->setCellValue('C4', 'Nama');
		$sheet->setCellValue('D4', 'No.Kartu');
		$sheet->setCellValue('E4', 'Status');
		$sheet->setCellValue('F4', 'NIK');
		$sheet->setCellValue('G4', 'Tempat Tanggal Lahir');
		$sheet->setCellValue('H4', 'Jenis Kelamin');
		$sheet->setCellValue('I4', 'No. Telp');
		$sheet->setCellValue('J4', 'Email');
		$sheet->setCellValue('K4', 'Alamat');
		$sheet->setCellValue('L4', 'Mulai Bekerja');
		$sheet->setCellValue('M4', 'Jabatan');
		$sheet->setCellValue('N4', 'Toko');
		$sheet->setCellValue('O4', 'Bank');
		$sheet->setCellValue('P4', 'Rekening');
		$sheet->setCellValue('Q4', 'A/N');
		$sheet->getRowDimension(4)->setRowHeight(25);
		$sheet->getStyle('A3:Q4')->getFont()->setBold(true);
		$sheet->getStyle('A3:Q4')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
		$sheet->getStyle('A3:Q4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
		$sheet->getStyle('A3:Q4')->getFill()->getStartColor()->setARGB('FF25221d');
		$sheet->getStyle('A3:Q4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A3:Q4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

		$sheet->getStyle('A3:Q4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle('A3:Q4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle('A3:Q4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle('A3:Q4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		//---------------------------  Isi Table
		$kolom = 5;
		$nomor = 1;
		foreach ($data as $row) {

			$sheet->getRowDimension($kolom)->setRowHeight(25);
			$sheet->getStyle("A" . $kolom . ":Q" . $kolom)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("A" . $kolom . ":Q" . $kolom)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			$sheet->getStyle("A" . $kolom . ":Q" . $kolom)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle("A" . $kolom . ":Q" . $kolom)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle("A" . $kolom . ":Q" . $kolom)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle("A" . $kolom . ":Q" . $kolom)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

			$sheet->setCellValue('A' . $kolom, $nomor);
			$sheet->setCellValue('B' . $kolom, $row->MsEmpCode);
			$sheet->setCellValue('C' . $kolom, $row->MsEmpName);
			$sheet->setCellValue('D' . $kolom, $row->MsEmpCard);
			$sheet->setCellValue('E' . $kolom, ($row->MsEmpIsActive == 1 ? "Aktif" : "Tidak Aktif"));
			$sheet->setCellValue('F' . $kolom, $row->MsEmpNip);
			$sheet->setCellValue('G' . $kolom, $row->MsEmpBirthPlace . ', ' . date_format(date_create($row->MsEmpBirthDate), "d F Y"));
			$sheet->setCellValue('H' . $kolom, ($row->MsEmpGender == "M" ? 'Laki-laki' : 'Perempuan'));
			$sheet->setCellValue('I' . $kolom, $row->MsEmpTlp);
			$sheet->setCellValue('J' . $kolom, $row->MsEmpEmail);
			$sheet->setCellValue('K' . $kolom, $row->MsEmpAddress);
			$sheet->setCellValue('L' . $kolom, date_format(date_create($row->MsEmpStartWork), "d F Y"));
			$sheet->setCellValue('M' . $kolom, $row->MsEmpPositionName);
			$sheet->setCellValue('N' . $kolom, $row->MsWorkplaceName);
			$sheet->setCellValue('O' . $kolom, $row->MsEmpBank);
			$sheet->setCellValue('P' . $kolom, $row->MsEmpRekNo);
			$sheet->setCellValue('Q' . $kolom, $row->MsEmpRekName);

			$kolom++;
			$nomor++;
		}

		$sheet->getColumnDimension('A')->setAutoSize(false);
		$sheet->getColumnDimension('A')->setWidth(10);
		$sheet->getColumnDimension('B')->setAutoSize(false);
		$sheet->getColumnDimension('B')->setWidth(20);
		$sheet->getColumnDimension('C')->setAutoSize(false);
		$sheet->getColumnDimension('C')->setWidth(70);
		$sheet->getColumnDimension('D')->setAutoSize(false);
		$sheet->getColumnDimension('D')->setWidth(30);
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
		$sheet->getColumnDimension('Q')->setAutoSize(true);
		$sheet->setShowGridlines(false);

		$writer = new Xlsx($spreadsheet);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data-master-datakaryawan.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
		//$writer->save("upload/data-master-datatoko.xlsx");
		//header("Content-Type: application/vnd.ms-excel");
		//redirect(base_url()."upload/test.xlsx");        
	}
	function data_karyawan_export_pdf()
	{
		$data['datatable'] = $this->db->query("SELECT * FROM TblMsEmployee as b 
												left join TblMsWorkplace as c on b.MsWorkplaceId=c.MsWorkplaceId
												left join TblMsEmployeePosition as d on d.MsEmpPositionId=b.MsEmpPositionId")->result();
		$data_html = $this->load->view('report/masterdata/datakaryawan', $data, TRUE);

		//$this->pdf->setPaper('A4', 'potrait');
		$this->pdf->setPaper('A4', 'landscape');
		$this->pdf->set_option('isRemoteEnabled', true);
		$this->pdf->filename = "Export Data Karyawan.pdf";
		$this->pdf->load_view('report/masterdata/datakaryawan', $data);
	}
	/*
    *       EXPORT DATA STAFF
    */
	function data_staff_export_excel()
	{
		$data = $this->db->query("SELECT * FROM TblMsStaff")->result();

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
		$sheet->mergeCells("C1:D1");
		$sheet->getStyle("C1:D1")->getFont()->setSize(36);
		$sheet->getStyle("C1:D1")->getFont()->setBold(true);
		$sheet->getStyle("C1")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("C1")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);

		$sheet->setCellValue('C2', 'DATA STAFF');
		$sheet->getRowDimension(2)->setRowHeight(40);
		$sheet->mergeCells("C2:D2");
		$sheet->getStyle("C2:D2")->getFont()->setSize(26);
		$sheet->getStyle("C2:D2")->getFont()->setBold(true);
		$sheet->getStyle("C2")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("C2")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

		//---------------------------  Header Table
		$sheet->setCellValue('A3', 'No');
		$sheet->setCellValue('B3', 'Kode');
		$sheet->setCellValue('C3', 'Nama');
		$sheet->setCellValue('D3', 'Alamat');
		$sheet->setCellValue('E3', 'Telp');
		$sheet->setCellValue('F3', 'Status');
		$sheet->getRowDimension(3)->setRowHeight(25);
		$sheet->getStyle("A3:F3")->getFont()->setBold(true);
		$sheet->getStyle("A3:F3")->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
		$sheet->getStyle('A3:F3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
		$sheet->getStyle('A3:F3')->getFill()->getStartColor()->setARGB('FF25221d');
		$sheet->getStyle("A3:F3")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("A3:F3")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

		$sheet->getStyle('A3:F3')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle('A3:F3')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle('A3:F3')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle('A3:F3')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		//---------------------------  Isi Table
		$kolom = 4;
		$nomor = 1;
		foreach ($data as $row) {

			$sheet->getRowDimension($kolom)->setRowHeight(25);
			$sheet->getStyle("A" . $kolom . ":F" . $kolom)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("A" . $kolom . ":F" . $kolom)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			$sheet->getStyle("A" . $kolom . ":F" . $kolom)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle("A" . $kolom . ":F" . $kolom)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle("A" . $kolom . ":F" . $kolom)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle("A" . $kolom . ":F" . $kolom)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

			$sheet->setCellValue('A' . $kolom, $nomor);
			$sheet->setCellValue('B' . $kolom, $row->StaffCode);
			$sheet->setCellValue('C' . $kolom, $row->StaffName);
			$sheet->setCellValue('D' . $kolom, $row->StaffAddress);
			$sheet->setCellValue('E' . $kolom, $row->StaffTelp);
			$sheet->setCellValue('F' . $kolom, ($row->StaffIsActive == 1 ? "Aktif" : "Tidak Aktif"));

			$kolom++;
			$nomor++;
		}

		$sheet->getColumnDimension('A')->setAutoSize(false);
		$sheet->getColumnDimension('A')->setWidth(10);
		$sheet->getColumnDimension('B')->setAutoSize(false);
		$sheet->getColumnDimension('B')->setWidth(20);
		$sheet->getColumnDimension('C')->setAutoSize(false);
		$sheet->getColumnDimension('C')->setWidth(30);
		$sheet->getColumnDimension('D')->setAutoSize(false);
		$sheet->getColumnDimension('D')->setWidth(70);
		$sheet->getColumnDimension('E')->setAutoSize(true);
		$sheet->getColumnDimension('F')->setAutoSize(true);
		$sheet->setShowGridlines(false);

		$writer = new Xlsx($spreadsheet);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data-master-datastaff.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
		//$writer->save("upload/data-master-datatoko.xlsx");
		//header("Content-Type: application/vnd.ms-excel");
		//redirect(base_url()."upload/test.xlsx");        
	}
	function data_staff_export_pdf()
	{
		$data['datatable'] = $this->db->query("SELECT * FROM TblMsStaff")->result();

		$this->pdf->setPaper('A4', 'potrait');
		//$this->pdf->setPaper('A4', 'landscape');
		$this->pdf->set_option('isRemoteEnabled', true);
		$this->pdf->filename = "Export Data Staff.pdf";
		$this->pdf->load_view('report/masterdata/datastaff', $data);
	}
	/*
    *       EXPORT DATA ITEM CATEGORY
    */
	function data_item_category_export_excel()
	{
		$data = $this->db->query("SELECT * FROM TblMsItemCategory")->result();

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
		$sheet->mergeCells("C1:D1");
		$sheet->getStyle("C1:D1")->getFont()->setSize(36);
		$sheet->getStyle("C1:D1")->getFont()->setBold(true);
		$sheet->getStyle("C1")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("C1")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);

		$sheet->setCellValue('C2', 'DATA ITEM CATEGORY');
		$sheet->getRowDimension(2)->setRowHeight(40);
		$sheet->mergeCells("C2:D2");
		$sheet->getStyle("C2:D2")->getFont()->setSize(26);
		$sheet->getStyle("C2:D2")->getFont()->setBold(true);
		$sheet->getStyle("C2")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("C2")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

		//---------------------------  Header Table
		$sheet->setCellValue('A3', 'No');
		$sheet->setCellValue('B3', 'Kode');
		$sheet->setCellValue('C3', 'Nama');
		$sheet->setCellValue('D3', 'Status');
		$sheet->getRowDimension(3)->setRowHeight(25);
		$sheet->getStyle("A3:D3")->getFont()->setBold(true);
		$sheet->getStyle("A3:D3")->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
		$sheet->getStyle('A3:D3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
		$sheet->getStyle('A3:D3')->getFill()->getStartColor()->setARGB('FF25221d');
		$sheet->getStyle("A3:D3")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("A3:D3")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

		$sheet->getStyle('A3:D3')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle('A3:D3')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle('A3:D3')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle('A3:D3')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		//---------------------------  Isi Table
		$kolom = 4;
		$nomor = 1;
		foreach ($data as $row) {

			$sheet->getRowDimension($kolom)->setRowHeight(25);
			$sheet->getStyle("A" . $kolom . ":D" . $kolom)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("A" . $kolom . ":D" . $kolom)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			$sheet->getStyle("A" . $kolom . ":D" . $kolom)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle("A" . $kolom . ":D" . $kolom)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle("A" . $kolom . ":D" . $kolom)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle("A" . $kolom . ":D" . $kolom)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

			$sheet->setCellValue('A' . $kolom, $nomor);
			$sheet->setCellValue('B' . $kolom, $row->MsItemCatCode);
			$sheet->setCellValue('C' . $kolom, $row->MsItemCatName);
			$sheet->setCellValue('D' . $kolom, ($row->MsItemCatIsActive == 1 ? "Aktif" : "Tidak Aktif"));

			$kolom++;
			$nomor++;
		}

		$sheet->getColumnDimension('A')->setAutoSize(false);
		$sheet->getColumnDimension('A')->setWidth(10);
		$sheet->getColumnDimension('B')->setAutoSize(false);
		$sheet->getColumnDimension('B')->setWidth(20);
		$sheet->getColumnDimension('C')->setAutoSize(false);
		$sheet->getColumnDimension('C')->setWidth(70);
		$sheet->getColumnDimension('D')->setAutoSize(false);
		$sheet->getColumnDimension('D')->setWidth(30);
		$sheet->setShowGridlines(false);

		$writer = new Xlsx($spreadsheet);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data-master-dataitemcategory.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
		//$writer->save("upload/data-master-datatoko.xlsx");
		//header("Content-Type: application/vnd.ms-excel");
		//redirect(base_url()."upload/test.xlsx");        
	}
	function data_item_category_export_pdf()
	{
		$data['datatable'] = $this->db->query("SELECT * FROM TblMsItemCategory")->result();

		$this->pdf->setPaper('A4', 'potrait');
		//$this->pdf->setPaper('A4', 'landscape');
		$this->pdf->set_option('isRemoteEnabled', true);
		$this->pdf->filename = "Export Data Item Category.pdf";
		$this->pdf->load_view('report/masterdata/dataitemcategory', $data);
	}
	/*
    *       EXPORT DATA ITEM MASTER
    */
	function data_item_master_export_excel()
	{
		$data = $this->db->query("SELECT * FROM TblMsItem 
									left join TblMsItemCategory on TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId
									left join TblMsVendor on TblMsItem.MsItemVendor like concat('%',TblMsVendor.MsVendorCode,'%')
									order by MsItemCatCode asc,MsItemCode asc , MsVendorCode asc")->result();

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
		$sheet->mergeCells("C1:D1");
		$sheet->getStyle("C1:D1")->getFont()->setSize(36);
		$sheet->getStyle("C1:D1")->getFont()->setBold(true);
		$sheet->getStyle("C1")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("C1")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);

		$sheet->setCellValue('C2', 'DATA ITEM MASTER');
		$sheet->getRowDimension(2)->setRowHeight(40);
		$sheet->mergeCells("C2:D2");
		$sheet->getStyle("C2:D2")->getFont()->setSize(26);
		$sheet->getStyle("C2:D2")->getFont()->setBold(true);
		$sheet->getStyle("C2")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("C2")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

		//---------------------------  Header Table
		$sheet->setCellValue('A3', 'No');
		$sheet->setCellValue('B3', 'Kategori');
		$sheet->setCellValue('C3', 'Kode');
		$sheet->setCellValue('D3', 'Nama');
		$sheet->setCellValue('E3', 'Ukuran');
		$sheet->setCellValue('F3', 'Satuan');
		$sheet->setCellValue('G3', 'Supplier');
		$sheet->setCellValue('H3', 'Status Jual');
		$sheet->setCellValue('I3', 'Status Item');
		$sheet->setCellValue('J3', 'Harga Jual');
		$sheet->getRowDimension(3)->setRowHeight(25);
		$colomrange = "A3:J3";
		$sheet->getStyle($colomrange)->getFont()->setBold(true);
		$sheet->getStyle($colomrange)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
		$sheet->getStyle($colomrange)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
		$sheet->getStyle($colomrange)->getFill()->getStartColor()->setARGB('FF25221d');
		$sheet->getStyle($colomrange)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle($colomrange)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

		$sheet->getStyle($colomrange)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle($colomrange)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle($colomrange)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle($colomrange)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		//---------------------------  Isi Table
		$kolom = 4;
		$nomor = 1;
		foreach ($data as $row) {
			$colomrange = "A" . $kolom . ":J" . $kolom;
			$sheet->getRowDimension($kolom)->setRowHeight(25);
			$sheet->getStyle($colomrange)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle($colomrange)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			$sheet->getStyle($colomrange)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($colomrange)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($colomrange)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($colomrange)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

			$sheet->setCellValue('A' . $kolom, $nomor);
			$sheet->setCellValue('B' . $kolom, $row->MsItemCatCode . ' - ' . $row->MsItemCatName);
			$sheet->setCellValue('C' . $kolom, $row->MsItemCode);
			$sheet->setCellValue('D' . $kolom, $row->MsItemName);
			$sheet->setCellValue('E' . $kolom, $row->MsItemSize);
			$sheet->setCellValue('F' . $kolom, $row->MsItemUoM);
			$sheet->setCellValue('G' . $kolom, $row->MsVendorCode);
			$sheet->setCellValue('H' . $kolom, ($row->MsItemSales == 1 ? "Aktif" : "Tidak Aktif"));
			$sheet->setCellValue('I' . $kolom, ($row->MsItemIsActive == 1 ? "Aktif" : "Tidak Aktif"));
			$sheet->setCellValue('J' . $kolom, $row->MsItemPrice);

			$kolom++;
			$nomor++;
		}

		$sheet->getColumnDimension('A')->setAutoSize(false);
		$sheet->getColumnDimension('A')->setWidth(10);
		$sheet->getColumnDimension('B')->setAutoSize(false);
		$sheet->getColumnDimension('B')->setWidth(20);
		$sheet->getColumnDimension('C')->setAutoSize(false);
		$sheet->getColumnDimension('C')->setWidth(30);
		$sheet->getColumnDimension('D')->setAutoSize(false);
		$sheet->getColumnDimension('D')->setWidth(70);
		$sheet->getColumnDimension('E')->setAutoSize(true);
		$sheet->getColumnDimension('F')->setAutoSize(true);
		$sheet->getColumnDimension('G')->setAutoSize(true);
		$sheet->getColumnDimension('H')->setAutoSize(true);
		$sheet->getColumnDimension('I')->setAutoSize(true);
		$sheet->getColumnDimension('J')->setAutoSize(true);
		$sheet->setShowGridlines(false);

		$writer = new Xlsx($spreadsheet);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data-master-dataitemmaster.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
		//$writer->save("upload/data-master-datatoko.xlsx");
		//header("Content-Type: application/vnd.ms-excel");
		//redirect(base_url()."upload/test.xlsx");        
	}
	function data_item_master_export_pdf()
	{
		$data['datatable'] = $this->db->query("SELECT * FROM TblMsItem 
		left join TblMsItemCategory on TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId
		left join TblMsVendor on TblMsItem.MsItemVendor like concat('%',TblMsVendor.MsVendorCode,'%')
		order by MsItemCatCode asc,MsItemCode asc , MsVendorCode asc")->result();

		//$this->pdf->setPaper('A4', 'potrait');
		$this->pdf->setPaper('A4', 'landscape');
		$this->pdf->set_option('isRemoteEnabled', true);
		$this->pdf->filename = "Export Data Item Master.pdf";
		$this->pdf->load_view('report/masterdata/dataitemmaster', $data);
	}
	/*
    *       EXPORT DATA Vendor
    */
	function data_vendor_export_excel()
	{
		$data = $this->db->query("SELECT * FROM TblMsVendor")->result();

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
		$sheet->mergeCells("C1:D1");
		$sheet->getStyle("C1:D1")->getFont()->setSize(36);
		$sheet->getStyle("C1:D1")->getFont()->setBold(true);
		$sheet->getStyle("C1")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("C1")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);

		$sheet->setCellValue('C2', 'DATA VENDOR');
		$sheet->getRowDimension(2)->setRowHeight(40);
		$sheet->mergeCells("C2:D2");
		$sheet->getStyle("C2:D2")->getFont()->setSize(26);
		$sheet->getStyle("C2:D2")->getFont()->setBold(true);
		$sheet->getStyle("C2")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("C2")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

		//---------------------------  Header Table
		$sheet->setCellValue('A3', 'No');
		$sheet->setCellValue('B3', 'Kode');
		$sheet->setCellValue('C3', 'Nama');
		$sheet->setCellValue('D3', 'Status');
		$sheet->getRowDimension(3)->setRowHeight(25);
		$sheet->getStyle("A3:D3")->getFont()->setBold(true);
		$sheet->getStyle("A3:D3")->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
		$sheet->getStyle('A3:D3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
		$sheet->getStyle('A3:D3')->getFill()->getStartColor()->setARGB('FF25221d');
		$sheet->getStyle("A3:D3")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("A3:D3")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

		$sheet->getStyle('A3:D3')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle('A3:D3')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle('A3:D3')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle('A3:D3')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		//---------------------------  Isi Table
		$kolom = 4;
		$nomor = 1;
		foreach ($data as $row) {

			$sheet->getRowDimension($kolom)->setRowHeight(25);
			$sheet->getStyle("A" . $kolom . ":D" . $kolom)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("A" . $kolom . ":D" . $kolom)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			$sheet->getStyle("A" . $kolom . ":D" . $kolom)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle("A" . $kolom . ":D" . $kolom)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle("A" . $kolom . ":D" . $kolom)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle("A" . $kolom . ":D" . $kolom)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

			$sheet->setCellValue('A' . $kolom, $nomor);
			$sheet->setCellValue('B' . $kolom, $row->MsVendorCode);
			$sheet->setCellValue('C' . $kolom, $row->MsVendorName);
			$sheet->setCellValue('D' . $kolom, ($row->MsVendorIsActive == 1 ? "Aktif" : "Tidak Aktif"));

			$kolom++;
			$nomor++;
		}

		$sheet->getColumnDimension('A')->setAutoSize(false);
		$sheet->getColumnDimension('A')->setWidth(10);
		$sheet->getColumnDimension('B')->setAutoSize(false);
		$sheet->getColumnDimension('B')->setWidth(20);
		$sheet->getColumnDimension('C')->setAutoSize(false);
		$sheet->getColumnDimension('C')->setWidth(70);
		$sheet->getColumnDimension('D')->setAutoSize(false);
		$sheet->getColumnDimension('D')->setWidth(30);
		$sheet->setShowGridlines(false);

		$writer = new Xlsx($spreadsheet);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data-master-datavendor.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
		//$writer->save("upload/data-master-datatoko.xlsx");
		//header("Content-Type: application/vnd.ms-excel");
		//redirect(base_url()."upload/test.xlsx");        
	}
	function data_vendor_export_pdf()
	{
		$data['datatable'] = $this->db->query("SELECT * FROM TblMsVendor")->result();

		$this->pdf->setPaper('A4', 'potrait');
		//$this->pdf->setPaper('A4', 'landscape');
		$this->pdf->set_option('isRemoteEnabled', true);
		$this->pdf->filename = "Export Data Vendor.pdf";
		$this->pdf->load_view('report/masterdata/datavendor', $data);
	}

	/*
    *       EXPORT DATA ITEM MASTER
    */
	function data_customer_export_excel()
	{
		$data = $this->db->query("SELECT * FROM TblMsCustomer 
									left join TblMsCustomerType on TblMsCustomerType.MsCustomerTypeId = TblMsCustomer.MsCustomerTypeId")->result();

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
		$sheet->mergeCells("C1:D1");
		$sheet->getStyle("C1:D1")->getFont()->setSize(36);
		$sheet->getStyle("C1:D1")->getFont()->setBold(true);
		$sheet->getStyle("C1")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("C1")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM);

		$sheet->setCellValue('C2', 'DATA ITEM MASTER');
		$sheet->getRowDimension(2)->setRowHeight(40);
		$sheet->mergeCells("C2:D2");
		$sheet->getStyle("C2:D2")->getFont()->setSize(26);
		$sheet->getStyle("C2:D2")->getFont()->setBold(true);
		$sheet->getStyle("C2")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("C2")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

		//---------------------------  Header Table
		$sheet->setCellValue('A3', 'No');
		$sheet->setCellValue('B3', 'Kategori');
		$sheet->setCellValue('C3', 'Perusahaan');
		$sheet->setCellValue('D3', 'Deskripsi');
		$sheet->setCellValue('E3', 'Kode');
		$sheet->setCellValue('F3', 'Nama');
		$sheet->setCellValue('G3', 'Telp 1');
		$sheet->setCellValue('H3', 'Telp 2');
		$sheet->setCellValue('I3', 'Fax');
		$sheet->setCellValue('J3', 'Email');
		$sheet->setCellValue('K3', 'Alamat');
		$sheet->setCellValue('L3', 'Status');
		$sheet->getRowDimension(3)->setRowHeight(25);
		$colomrange = "A3:L3";
		$sheet->getStyle($colomrange)->getFont()->setBold(true);
		$sheet->getStyle($colomrange)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
		$sheet->getStyle($colomrange)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
		$sheet->getStyle($colomrange)->getFill()->getStartColor()->setARGB('FF25221d');
		$sheet->getStyle($colomrange)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle($colomrange)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

		$sheet->getStyle($colomrange)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle($colomrange)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle($colomrange)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle($colomrange)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		//---------------------------  Isi Table
		$kolom = 4;
		$nomor = 1;
		foreach ($data as $row) {
			$colomrange = "A" . $kolom . ":L" . $kolom;
			$sheet->getRowDimension($kolom)->setRowHeight(25);
			$sheet->getStyle($colomrange)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle($colomrange)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

			$sheet->getStyle($colomrange)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($colomrange)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($colomrange)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($colomrange)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

			$sheet->setCellValue('A' . $kolom, $nomor);
			$sheet->setCellValue('B' . $kolom, $row->MsCustomerTypeName);
			$sheet->setCellValue('C' . $kolom, $row->MsCustomerCompany);
			$sheet->setCellValue('D' . $kolom, $row->MsCustomerRemarks);
			$sheet->setCellValue('E' . $kolom, $row->MsCustomerCode);
			$sheet->setCellValue('F' . $kolom, $row->MsCustomerName);
			$sheet->setCellValue('G' . $kolom, $row->MsCustomerTelp1);
			$sheet->setCellValue('H' . $kolom, $row->MsCustomerTelp2);
			$sheet->setCellValue('I' . $kolom, $row->MsCustomerFax);
			$sheet->setCellValue('J' . $kolom, $row->MsCustomerEmail);
			$sheet->setCellValue('K' . $kolom, $row->MsCustomerAddress);
			$sheet->setCellValue('L' . $kolom, ($row->MsCustomerIsActive == 1 ? "Aktif" : "Tidak Aktif"));

			$kolom++;
			$nomor++;
		}

		$sheet->getColumnDimension('A')->setAutoSize(false);
		$sheet->getColumnDimension('A')->setWidth(10);
		$sheet->getColumnDimension('B')->setAutoSize(false);
		$sheet->getColumnDimension('B')->setWidth(20);
		$sheet->getColumnDimension('C')->setAutoSize(false);
		$sheet->getColumnDimension('C')->setWidth(30);
		$sheet->getColumnDimension('D')->setAutoSize(false);
		$sheet->getColumnDimension('D')->setWidth(70);
		$sheet->getColumnDimension('E')->setAutoSize(true);
		$sheet->getColumnDimension('F')->setAutoSize(true);
		$sheet->getColumnDimension('G')->setAutoSize(true);
		$sheet->getColumnDimension('H')->setAutoSize(true);
		$sheet->getColumnDimension('I')->setAutoSize(true);
		$sheet->getColumnDimension('J')->setAutoSize(true);
		$sheet->getColumnDimension('K')->setAutoSize(true);
		$sheet->getColumnDimension('L')->setAutoSize(true);
		$sheet->setShowGridlines(false);

		$writer = new Xlsx($spreadsheet);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data-master-dataCustomer.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
		//$writer->save("upload/data-master-datatoko.xlsx");
		//header("Content-Type: application/vnd.ms-excel");
		//redirect(base_url()."upload/test.xlsx");        
	}
	function data_customer_export_pdf()
	{
		$data['datatable'] = $this->db->query("SELECT * FROM TblMsCustomer 
									left join TblMsCustomerType on TblMsCustomerType.MsCustomerTypeId = TblMsCustomer.MsCustomerTypeId")->result();

		//$this->pdf->setPaper('A4', 'potrait');
		$this->pdf->setPaper('A4', 'landscape');
		$this->pdf->set_option('isRemoteEnabled', true);
		$this->pdf->filename = "Export Data Customer.pdf";
		$this->pdf->load_view('report/masterdata/datacustomer', $data);
	}
}
