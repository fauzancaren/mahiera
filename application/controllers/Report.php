<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('cookie');
		$this->load->model('model_app');
	}
	function sales_new($id)
	{
		$result = $this->db->join("TblMsCustomer", "TblMsCustomer.MsCustomerId=TblSales.MsCustomerId")
			->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblSales.MsEmpId")
			->where("SalesId", $id)->get("TblSales")->row();
		$result1 = $this->db->where("MsCustomerId", $result->MsCustomerId)->get("TblMsCustomer")->row();
		$customername = $result1->MsCustomerTypeId == 1 ? $result1->MsCustomerName : $result1->MsCustomerCompany . ' (' . $result1->MsCustomerName . ')';
		$customerTelp = $result1->MsCustomerTelp2 == "" ? $result1->MsCustomerTelp1 : $result1->MsCustomerTelp1 . '/' . $result1->MsCustomerTelp2;
		$data["customer"] = $customername;
		$data["date_pembelian"] = date_format(date_create($result->SalesDate), "j F Y");
		$data["code"] = $result->SalesCode;

		$content = ' 
						<div class="header">
							<img src="' . base_url() . 'asset/image/kop/Header' . $result->MsWorkplaceId . '.jpg" style="width: 90%;margin-top:0.75rem">
							<div class="top-right">Sales Order</div>
								<div class="printdate">Create Date : ' . $result->SalesCreate . '</div>
                     </div>
							<table style="width: 100%;margin-left:10px;margin-top:0px;border-collapse: collapse;"> 
								<tr>
									<td align="left" valign="top" colspan="3" style="width:60%;font-size:13px">Kepada Yth:</td>
									<td align="left" valign="top" style="width:10%;font-size:13px">Tanggal</td>
									<td align="left" valign="top" style="width:2%;font-size:13px">:</td>
									<td align="left" valign="top" style="width:28%;font-size:13px">' . date_format(date_create($result->SalesDate), "j F Y") . '</td>
								</tr >
							</table>
							<table style="width: 100%;margin-left:10px;margin-top:0px;border-collapse: collapse;"> 
								<tr>
									<td align="left" valign="top" style="width:10%;font-size:13px">Nama</td>
									<td align="left" valign="top" style="width:2%;font-size:13px">:</td>
									<td align="left" valign="top" style="width:48%;font-size:13px;font-weight:bold">' . $customername . '</td>
									<td align="left" valign="top" style="width:10%;font-size:13px">No. Invoice</td>
									<td align="left" valign="top"style="width:2%;font-size:13px">:</td>
									<td align="left" valign="top" style="width:28%;font-size:13px">' . $result->SalesCode . '</td>
								</tr >
							</table>
							<table style="width: 100%;margin-left:10px;margin-top:0px;border-collapse: collapse;"> 
							<tr>
								<td align="left" valign="top" style="width:10%;font-size:13px">No. Telp</td>
								<td align="left" valign="top" style="width:2%;font-size:13px">:</td>
								<td align="left" valign="top" style="width:48%;font-size:13px;font-weight:bold">' . $customerTelp . '</td>
								<td align="left" valign="top" style="width:10%;font-size:13px">Admin</td>
								<td align="left" valign="top" style="width:2%;font-size:13px">:</td>
								<td align="left" valign="top" style="width:28%;font-size:13px">' . $result->MsEmpName . '</td>
							</tr >
							</table>
							<table style="width: 100%;margin-left:10px;margin-top:0px;margin-bottom:5px;border-collapse: collapse;"> 
								<tr>
									<td align="left" valign="top" style="width:10%;font-size:13px">Alamat</td>
									<td align="left" valign="top" style="width:2%;font-size:13px">:</td>
									<td align="left" valign="top" style="width:48%;font-size:13px">' . $result->MsCustomerAddress . '</td>
									<td align="left" valign="top" style="width:10%;font-size:13px">Ref.</td>
									<td align="left" valign="top" style="width:2%;font-size:13px">:</td>
									<td align="left" valign="top" style="width:28%;font-size:13px">' . $result->SalesRef . '</td>
								</tr >
							</table>';
		$result2 =  $this->db->join('TblMsItem', 'TblMsItem.MsItemId=TblSalesDetail.MsItemId', "left")
			->join('TblMsItemCategory', 'TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId', "left")
			->where("SalesDetailRef", $result->SalesCode)->get("TblSalesDetail")->result();
		$no = 0;
		$disc = false;
		$item = "";
		foreach ($result2 as $rowsitem) {
			$no++;
			if ($rowsitem->SalesDetailDisc > 0) $disc = true;
			$item = $item .		'
							<tr style="font-size:13px;vertical-align: top;" >
								<td style=text-align:center>' . $no . '</td>
								<td>' . $rowsitem->MsItemCatName . '</td>
								<td><span style="font-size:13px;">' . $rowsitem->MsItemCode . '-' . $rowsitem->MsItemName . '<span></td>
								<td><span style="font-size:13px;">' . $rowsitem->MsItemSize . '</span></td>
                        <td>' . $rowsitem->MsItemUoM . '</td>
								<td style="font-size:13px;text-align: right;">' . number_format($rowsitem->SalesDetailQty, 2) . '</td>
								<td style="font-size:13px;text-align: right;">' . number_format($rowsitem->SalesDetailPrice) . '</td>
								' . ($rowsitem->SalesDetailDisc > 0 ? '<td style="font-size:13px;text-align: right;">' . number_format($rowsitem->SalesDetailDisc) . '</td>' : '') . '
								<td style="font-size:13px;text-align: right;">' . number_format($rowsitem->SalesDetailTotal) . '</td>
                     </tr>';
		}
		$content .= '
						<table class="center" style="width: 95%;border-collapse: collapse;border-bottom: 1px solid black;">
							<tr>
								<th style="text-align:center;">No.</th>
								<th style="text-align:left;">Kategori</th>
								<th style="text-align:left;">Nama Item</th>
								<th style="text-align:left;">Ukuran</th>
								<th style="text-align:left;">Satuan</th>
								<th style="text-align: right;">Qty</th>
								<th style="text-align: right;">Harga</th>
								' . ($disc ? '<th style="text-align: right;">Disc</th>' : '') . '
								<th style="text-align: right;">Harga Total</th>
							</tr>' . $item;

		$result3 = $this->db->where("SalesOptionalRef", $result->SalesCode)->get("TblSalesOptional")->result();
		if ($result3) {
			$content = $content . '<tr> 
										<td colspan="2">
											<span style="margin-left:40px;padding:5px;font-size:13px;font-weight: bold;">Biaya Lain Lain</span>
										</td>
									</tr>';
			$no = 0;
			foreach ($result3 as $rowsitems) {
				$no++;
				$content = $content . '<tr style="font-size:13px;vertical-align: top;" >
											<td style="text-align:center">' . $no . '</td>
											<td colspan="7">' . $rowsitems->SalesOptionalDesc . '</td>
											<td style="font-size:13px;text-align: right;">' . number_format($rowsitems->SalesOptionalPrice) . '</td>
										</tr>';
			}
		}
		$content = $content . '            </table>
                        
                        <table style="width: 100%;margin-left:10px:margin-top:0px"> 
							<tr>
                                <td align="left" valign="top" style="width:30%;font-size:13px">
                                    <table style="width: 100%;margin-left:10px:margin-top:0px">
                                        <tr>
                                            <td align="center" valign="top" style="width:50%;border:1px solid black;text-decoration: underline;height:100px">Penerima/Pembeli</td>
                                            <td align="center" valign="top" style="width:50%;border:1px solid black;text-decoration: underline;height:100px">Admin</td>
                                        </tr>
                                    </table>
                                </td>
								<td align="left" valign="top" style="width:40%;font-size:11px">Note :<br>
		                            1. Pembayaran <b>DP 50% dan pelunasan</b> sebelum pengiriman<br>
		                            2. pembayaran melalui transfer pada No. Rekening<br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>BCA     498 0375 990 a/n       <br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OMAHBATA INDONESIA CV.<br></b>
                                    3.  Harap konfirmasi ke kami apabila atas nama di rekening <br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;<b>berbeda</b> dengan atas nama yang tertera di invoice. <br>
                                    4.  DP atau Pelunasan yang sudah masuk tidak bisa <br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;<b>dikembalikan(Refund)</b><br>
                                    5.  Barang yang sudah dibeli tidak dapat <b>dikembalikam/ditukar</b><br>
                                </td>
                                <td align="left" valign="top" style="width:30%;font-size:13px">
                                    <table style="width: 100%;margin-right:13px:margin-top:0px">
                                        <tr>
                                            <td align="right" valign="top" style="width:47%;font-size:13px;font-weight:bold">Sub Total</td>
                                            <td align="right" valign="top" style="width:50%;font-size:13px;font-weight:bold">' . number_format($result->SalesSubTotal) . '</td>
                                        </tr>
													 ' . ($result->SalesDiscTotal > 0 ? ' <tr>
                                            <td align="right" valign="top" style="width:47%;font-size:13px;font-weight:bold">Disc</td>
                                            <td align="right" valign="top" style="width:50%;font-size:13px;font-weight:bold">' . number_format($result->SalesDiscTotal) . '</td>
                                        </tr>' : '') . '
                                        <tr>
                                            <td align="right" valign="top" style="width:47%;font-size:13px;font-weight:bold">Delivery</td>
                                            <td align="right" valign="top" style="width:50%;font-size:13px;font-weight:bold">' . number_format($result->SalesDeliveryTotal) . '</td>
                                        </tr>
                                        <tr>
                                            <td align="right" valign="top" style="width:47%;font-size:13px;font-weight:bold">Grand Total</td>
                                            <td align="right" valign="top" style="width:50%;font-size:13px;font-weight:bold">' . number_format($result->SalesGrandTotal) . '</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr >
						</table>
        ';
		$data["content"] = $content;

		$result = $this->db->join("TblMsCustomer", "TblMsCustomer.MsCustomerId=TblSales.MsCustomerId")
			->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblSales.MsEmpId")
			->where("SalesId", $id)->get("TblSales")->row();
		$result1 = $this->db->where("MsCustomerId", $result->MsCustomerId)->get("TblMsCustomer")->row();
		$customername = $result1->MsCustomerTypeId == 1 ? $result1->MsCustomerName : $result1->MsCustomerCompany . ' (' . $result1->MsCustomerName . ')';
		$customerTelp = $result1->MsCustomerTelp2 == "" ? $result1->MsCustomerTelp1 : $result1->MsCustomerTelp1 . '/' . $result1->MsCustomerTelp2;

		$content = ' 
						<div class="header">
                            <img src="' . base_url() . 'asset/image/kop/Header' . $result->MsWorkplaceId . '.jpg" style="width: 90%;margin-top:0.75rem">
                            <div class="top-right">INVOICE</div>
                            <div class="printdate">Last Update : ' . $result->SalesLastUpdate . '</div>
                        </div>
                        <table style="width: 100%;margin-left:10px;margin-top:0px;border-collapse: collapse;"> 
							<tr>
								<td align="left" valign="top" colspan="3" style="width:60%;font-size:13px">Kepada Yth:</td>
								<td align="left" valign="top" style="width:10%;font-size:13px">Tanggal</td>
								<td align="left" valign="top" style="width:2%;font-size:13px">:</td>
								<td align="left" valign="top" style="width:28%;font-size:13px">' . date_format(date_create($result->SalesDate), "j F Y") . '</td>
                            </tr >
						</table>
                        <table style="width: 100%;margin-left:10px;margin-top:0px;border-collapse: collapse;"> 
							<tr>
								<td align="left" valign="top" style="width:10%;font-size:13px">Nama</td>
								<td align="left" valign="top" style="width:2%;font-size:13px">:</td>
								<td align="left" valign="top" style="width:48%;font-size:13px;font-weight:bold">' . $customername . '</td>
								<td align="left" valign="top" style="width:10%;font-size:13px">No. Invoice</td>
								<td align="left" valign="top"style="width:2%;font-size:13px">:</td>
								<td align="left" valign="top" style="width:28%;font-size:13px">' . $result->SalesCode . '</td>
                            </tr >
						</table>
                        <table style="width: 100%;margin-left:10px;margin-top:0px;border-collapse: collapse;"> 
							<tr>
								<td align="left" valign="top" style="width:10%;font-size:13px">No. Telp</td>
								<td align="left" valign="top" style="width:2%;font-size:13px">:</td>
								<td align="left" valign="top" style="width:48%;font-size:13px;font-weight:bold">' . $customerTelp . '</td>
								<td align="left" valign="top" style="width:10%;font-size:13px">Admin</td>
								<td align="left" valign="top" style="width:2%;font-size:13px">:</td>
								<td align="left" valign="top" style="width:28%;font-size:13px">' . $result->MsEmpName . '</td>
                            </tr >
						</table>
                        <table style="width: 100%;margin-left:10px;margin-top:0px;margin-bottom:5px;border-collapse: collapse;"> 
							<tr>
								<td align="left" valign="top" style="width:10%;font-size:13px">Alamat</td>
								<td align="left" valign="top" style="width:2%;font-size:13px">:</td>
								<td align="left" valign="top" style="width:48%;font-size:13px">' . $result->MsCustomerAddress . '</td>
								<td align="left" valign="top" style="width:10%;font-size:13px">Ref.</td>
								<td align="left" valign="top" style="width:2%;font-size:13px">:</td>
								<td align="left" valign="top" style="width:28%;font-size:13px">' . $result->SalesRef . '</td>
                            </tr >
						</table>';


		$result2 = $this->db->join("TblMsItem", "TblMsItem.MsItemId=TblSalesDetail.MsItemId")
			->join("TblMsItemCategory", "TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId")
			->where("SalesDetailRef", $result->SalesCode)->get("TblSalesDetail")->result();


		$no = 0;
		$disc = false;
		$item = "";
		foreach ($result2 as $rowsitem) {
			$no++;
			if ($rowsitem->SalesDetailDisc > 0) $disc = true;
			$item = $item .		'
							<tr style="font-size:13px;vertical-align: top;" >
								<td style=text-align:center>' . $no . '</td>
								<td>' . $rowsitem->MsItemCatName . '</td>
								<td><span style="font-size:13px;">' . $rowsitem->MsItemCode . '-' . $rowsitem->MsItemName . '<span></td>
								<td><span style="font-size:13px;">' . $rowsitem->MsItemSize . '</span></td>
                        <td>' . $rowsitem->MsItemUoM . '</td>
								<td style="font-size:13px;text-align: right;">' . number_format($rowsitem->SalesDetailQty, 2) . '</td>
								<td style="font-size:13px;text-align: right;">' . number_format($rowsitem->SalesDetailPrice) . '</td>
								' . ($rowsitem->SalesDetailDisc > 0 ? '<td style="font-size:13px;text-align: right;">' . number_format($rowsitem->SalesDetailDisc) . '</td>' : '') . '
								<td style="font-size:13px;text-align: right;">' . number_format($rowsitem->SalesDetailTotal) . '</td>
                     </tr>';
		}
		$content .= '
						<table class="center" style="width: 95%;border-collapse: collapse;border-bottom: 1px solid black;">
							<tr>
								<th style="text-align:center;">No.</th>
								<th style="text-align:left;">Kategori</th>
								<th style="text-align:left;">Nama Item</th>
								<th style="text-align:left;">Ukuran</th>
								<th style="text-align:left;">Satuan</th>
								<th style="text-align: right;">Qty</th>
								<th style="text-align: right;">Harga</th>
								' . ($disc ? '<th style="text-align: right;">Disc</th>' : '') . '
								<th style="text-align: right;">Harga Total</th>
							</tr>' . $item;

		$result3 = $this->db->where("SalesOptionalRef", $result->SalesCode)->get("TblSalesOptional")->result();

		if ($result3) {
			$content = $content . '<tr> 
											<td colspan="2">
												<span style="margin-left:40px;padding:5px;font-size:13px;font-weight: bold;">Biaya Lain Lain</span>
											</td>
										</tr>';
			$no = 0;
			foreach ($result3 as $rowsitems) {
				$no++;
				$content = $content . '<tr style="font-size:13px;vertical-align: top;" >
												<td style="text-align:center">' . $no . '</td>
												<td colspan="7">' . $rowsitems->SalesOptionalDesc . '</td>
												<td style="font-size:13px;text-align: right;">' . number_format($rowsitems->SalesOptionalPrice) . '</td>
											</tr>';
			}
		}
		$content = $content . '            </table>
                        
                        <table style="width: 100%;margin-left:10px:margin-top:0px"> 
							<tr>
                                <td align="left" valign="top" style="width:30%;font-size:13px">
                                    <table style="width: 100%;margin-left:10px:margin-top:0px">
                                        <tr>
                                            <td align="center" valign="top" style="width:50%;border:1px solid black;text-decoration: underline;height:100px">Penerima/Pembeli</td>
                                            <td align="center" valign="top" style="width:50%;border:1px solid black;text-decoration: underline;height:100px">Admin</td>
                                        </tr>
                                    </table>
                                </td>
								<td align="left" valign="top" style="width:30%;font-size:11px">Note :<br>
		                            1. pembayaran melalui transfer pada No. Rekening<br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>BCA     498 0375 990 a/n       <br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OMAHBATA INDONESIA CV.<br></b>
                                    2.  DP atau Pelunasan yang sudah masuk tidak bisa <br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;<b>dikembalikan(Refund)</b><br>
									3.  Barang yang sudah dibeli tidak dapat <br>
										&nbsp;&nbsp;&nbsp;&nbsp;<b>dikembalikam/ditukar</b><br>
                                </td>
                                <td align="left" valign="top" style="width:40%;font-size:13px">
                                    <table style="width: 100%;margin-right:13px;margin-top:0px;border-collapse: collapse; ">
                                        <tr>
                                            <td align="right" valign="top" style="width:70%;font-size:13px;font-weight:bold">Sub Total</td>
                                            <td align="right" valign="top" style="width:30%;font-size:13px;font-weight:bold">' . number_format($result->SalesSubTotal) . '</td>
                                        </tr>
													 ' . ($result->SalesDiscTotal > 0 ? ' <tr>
                                            <td align="right" valign="top" style="width:47%;font-size:13px;font-weight:bold">Disc</td>
                                            <td align="right" valign="top" style="width:50%;font-size:13px;font-weight:bold">' . number_format($result->SalesDiscTotal) . '</td>
                                        </tr>' : '') . '
                                        <tr>
                                            <td align="right" valign="top" style="width:70%;font-size:13px;font-weight:bold">Delivery</td>
                                            <td align="right" valign="top" style="width:30%;font-size:13px;font-weight:bold">' . number_format($result->SalesDeliveryTotal) . '</td>
                                        </tr>
                                        <tr style="border: 1px solid black">
                                            <td align="right" valign="top" style="width:70%;font-size:13px;font-weight:bold">Grand Total</td>
                                            <td align="right" valign="top" style="width:30%;font-size:13px;font-weight:bold">' . number_format($result->SalesGrandTotal) . '</td>
                                        </tr>
									</table>
									<hr style="margin:1px"></hr>
									<table style="width: 100%;margin-right:13px;margin-top:0px;border-collapse: collapse;">';

		$jointable1 = array(
			array(0 => 'TblMsMethod', 1 => 'TblSalesPayment.MsMethodId=TblMsMethod.MsMethodId')
		);
		$result2 = $this->db->join("TblMsMethod", "TblSalesPayment.MsMethodId=TblMsMethod.MsMethodId")->where("PaymentRef", $result->SalesCode)->get("TblSalesPayment")->result();
		$payment = $result->SalesGrandTotal;
		foreach ($result2 as $row) {
			$content = $content . '
											<tr>
												<td align="right" valign="top" style="width:70%;font-size:13px;font-weight:bold">' . $row->MsMethodName . ' (' . $row->PaymentDate . ')</td>
												<td align="right" valign="top" style="width:30%;font-size:13px;font-weight:bold">' . number_format($row->PaymentTotal) . '</td>
											</tr>';
			$payment = $payment - $row->PaymentTotal;
		}
		$content = $content . '
									</table>
									<hr style="margin:1px"></hr>
                                    <table style="width: 100%;margin-right:13px;margin-top:0px;border-collapse: collapse; ">
                                        <tr>
                                            <td align="right" valign="top" style="width:70%;font-size:13px;font-weight:bold">Sisa Pembayaran</td>
                                            <td align="right" valign="top" style="width:30%;font-size:13px;font-weight:bold">' . number_format($payment) . '</td>
                                        </tr>
									</table>
                                </td>
                            </tr >
						</table>
		';

		$data["content2"] = $content;

		$list_file = array();
		$dir = "asset/image/payment/" . $id . "/";

		// buka directory, dan baca isinya
		if (is_dir($dir)) {
			if ($dh = opendir($dir)) {
				while (($file = readdir($dh)) !== false) {
					$list_file[] = $file;
				}
				closedir($dh);
			}
		}
		$content = "";
		if (isset($list_file)) {
			$content .= '<div class="flex-container">';
			for ($a = 0; $a < count($list_file); $a++) {
				if ($list_file[$a] != '.' && $list_file[$a] != '..') {
					$file = $list_file[$a];
					$content .=  '	<div">
										<img src="' . base_url() . $dir . $list_file[$a] . '" alt="' . base_url() . $dir . $list_file[$a] . '" class="img-thumbnail">
									</div>';
				}
			}
			$content .=  '</div>';
		}

		$data["content3"] = $content;
		$this->load->view('report/sales', $data);
	}
	function sales($id)
	{
		$data["_data"] = $this->db->query("select * from TblSales left join TblMsCustomer ON TblSales.MsCustomerId=TblMsCustomer.MsCustomerId left join TblMsEmployee on TblSales.MsEmpId=TblMsEmployee.MsEmpId where SalesId='{$id}' ")->row();
		$data["_detail"] = $this->db->join("TblMsItem", "TblMsItem.MsItemId=TblSalesDetail.MsItemId", "Left")->join("TblMsItemCategory", "TblMsItemCategory.MsItemCatId=TblMsItem.MsItemCatId")->where("SalesDetailRef", $data["_data"]->SalesCode)->get("TblSalesDetail")->result();
		$data["_optional"] = $this->db->where("SalesOptionalRef", $data["_data"]->SalesCode)->get("TblSalesOptional")->result();
		$data["_payment"] = $this->db->join("TblMsMethod", "TblMsMethod.MsMethodId=TblSalesPayment.MsMethodId")->where("PaymentRef", $data["_data"]->SalesCode)->get("TblSalesPayment")->result();
		$data["_delivery"] = $this->db
			->join("TblMsCustomerDelivery", "TblDelivery.MsCustomerDeliveryId = TblMsCustomerDelivery.MsCustomerDeliveryId")
			->join("TblMsDelivery", "TblDelivery.MsDeliveryId = TblMsDelivery.MsDeliveryId")
			->where("DeliveryRef", $data["_data"]->SalesCode)
			->get("TblDelivery")->result();
		$this->load->view('share/template', $data);
	}
	function pengiriman($id)
	{
		$data["_delivery"] = $this->db
			->join("TblMsCustomerDelivery", "TblDelivery.MsCustomerDeliveryId = TblMsCustomerDelivery.MsCustomerDeliveryId")
			->join("TblMsDelivery", "TblDelivery.MsDeliveryId = TblMsDelivery.MsDeliveryId")
			->where("DeliveryId", $id)
			->get("TblDelivery")->result();
		$this->load->view('share/templatedelivery', $data);
	}

	function po($id)
	{
		$data["_delivery"] = $this->db
			->join("TblMsVendor", "TblPO.MsVendorId=TblMsVendor.MsvendorId")
			->join("TblSales", "TblSales.SalesCode=TblPO.SalesRef")
			->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblSales.MsEmpId")
			->where("POId", $id)
			->get("TblPO")->result();
		$this->load->view('share/templatepo', $data);
	}
	function repair()
	{
		$result = $this->db->query("SELECT * FROM TblDelivery 
						LEFT JOIN TblMsCustomerDelivery ON TblMsCustomerDelivery.MsCustomerDeliveryId=TblDelivery.MsCustomerDeliveryId 
						WHERE TblMsCustomerDelivery.MsCustomerDeliveryId IS NULL AND DeliveryDate >= '2021-11-11'")->result();
		$no = 0;
		foreach ($result as $row) {
			echo $row->DeliveryRef;
			$data = $this->db->where("SalesCode", $row->DeliveryRef)->get("TblSales")->row();
			echo " -> ";
			echo $data->MsCustomerDeliveryId;
			//echo " -> ";
			//echo $data->MsCustomerDeliveryId;
			echo "<br>";
			$no++;
			//$this->db->update("TblDelivery", array("MsCustomerDeliveryId" => $data->MsCustomerDeliveryId), array("DeliveryRef" => $row->DeliveryRef));
		}
		echo "Data -> " . $no;
	}

	function test()
	{
		$this->load->view('test');
	}
}
