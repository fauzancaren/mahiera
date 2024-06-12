<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Client extends CI_Controller
{
	function __construct()
	{
		parent::__construct(); 
		if ($this->session->userdata('login_status') != TRUE) {
			$this->session->set_flashdata('notif', '<div class="alert alert-danger" role="alert">anda belum login, silahkan login terlebih dahulu!!!</div>');
			redirect('login', 'refresh');
		};
		if( empty($this->session->userdata('login_uuid'))){
			$this->session->set_flashdata('notif', '<div class="alert alert-danger" role="alert">anda belum login, silahkan login terlebih dahulu!!!</div>');
			redirect('login', 'refresh');
		} 

		$this->load->model('model_app');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		$this->load->library('user_agent');
		if ($this->agent->is_browser())
		{
			// $agent = $this->agent->browser().' '.$this->agent->version();
			$agent = false;
		}
		elseif ($this->agent->is_robot())
		{
			// $agent = $this->agent->robot();
			$agent = false;
		}
		elseif ($this->agent->is_mobile())
		{
			//$agent = $this->agent->mobile();
			$agent = true;
		}
		else
		{
			//$agent = 'Unidentified User Agent';
			$agent = false;
		}
		$data['_sessionuser'] = $this->session->userdata();
		$data['_agent'] = $agent;
		$employee = $this->db->where("MsEmpIsActive",1)->get("TblMsEmployee")->result();
		$emp = [];
		foreach($employee as $row){
			$emp[] = array(
				"code"=> $row->MsEmpCode,
				"nama"=> $row->MsEmpName,
				"image"=> $this->model_app->get_base_64_by_id($row->MsEmpCode), 
				"status"=>false
			);
		}
		$data['_users'] = $emp;
		
		set_cookie('username', $this->session->userdata('MsEmpCode'), '3600');
		set_cookie('password', $this->session->userdata('MsEmpPass'), '3600');
		set_cookie('uuid', $this->session->userdata('login_uuid'), '3600');  
		
		if ($this->session->userdata('login_auth') != TRUE){
			$this->load->view('template/auth', $data);
		}else{
			$this->load->view('template/mainmenu2', $data);
		}

	}

	public function get_content($active, $menu,$id)
	{
		$this->session->set_userdata('menu_mode', $menu);
		$this->session->set_userdata('menu_active', $active);
		$this->session->set_userdata('menu_id', $id);

		$data = $this->db->where("MenuId",$id)->get("TblMenuObi")->row(); 
		if($data->MenuPath!= ""){
			$result["view"] = $this->load->view($data->MenuPath, '', TRUE);
			echo $result["view"];
		}else{ 
			echo "Tidak ada path menu ini ".$data->MenuPath;
		} 
	}

	public function get_side_menu_last()
	{
		//Superuser, Admin Toko, Admin Warehouse, Logistik, expedisi
		switch ($this->session->userdata("login_mode")) {
			case "Superuser":
				echo '<ul>
						<!-- Dashboard -->
						<li> 
							<a class="text-menu-side" name="menu-dashboard" onclick="menuselect(\'menu-dashboard\',\'-\')">
								<i class="fas fa-tachometer-alt"  data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard"></i>
								<div class="text-span"><span>&nbsp;Dashboard</span></div>
							</a>
						</li> 

						<!-- MASTER DATA -->
						<li> 
							<a class="collapsed header-collapse" name="menu-master-data" href="#master-data" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-database"  data-bs-toggle="tooltip" data-bs-placement="right" title="Master Data"></i>
								<div class="text-span"><span>&nbsp;Master Data</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="master-data">
								<li class="divider">
									<span style="font-size:12px">&nbsp;TOKO</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="master-datatoko" onclick="menuselect(\'master-datatoko\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Data Toko</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;KARYAWAN</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="master-datajabatan" onclick="menuselect(\'master-datajabatan\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Data Jabatan</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="master-datakaryawan"  onclick="menuselect(\'master-datakaryawan\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Data Karyawan</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="master-datastaffcetak"  onclick="menuselect(\'master-datastaffcetak\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Data Staff Cetak</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;ITEM MASTER</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="master-itemkategory"  onclick="menuselect(\'master-itemkategory\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Item Kategori</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="master-itemmaster"  onclick="menuselect(\'master-itemmaster\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Item Master</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="master-itemlisting"  onclick="menuselect(\'master-itemlisting\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Item Listing</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="master-billofmaterial"  onclick="menuselect(\'master-billofmaterial\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Bill of Material</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;SUPPLIER</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="master-datasupplier"  onclick="menuselect(\'master-datasupplier\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Data Supplier</span></div>
									</a>
								</li>
								
								<li class="divider">
									<span style="font-size:12px">&nbsp;PENGIRIMAN</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="master-datapengiriman"  onclick="menuselect(\'master-datapengiriman\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Tipe Pengiriman</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;PELANGGAN</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="master-datatipecustomer"  onclick="menuselect(\'master-datatipecustomer\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Tipe Pelanggan</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="master-datacustomer"  onclick="menuselect(\'master-datacustomer\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Data Pelanggan</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;FINANCE</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="master-tipepembayaran"  onclick="menuselect(\'master-tipepembayaran\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Tipe Pembayaran</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="master-costofgoodssales"  onclick="menuselect(\'master-costofgoodssales\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Cost of Goods Sales</span></div>
									</a>
								</li>
							</ul>
						</li>
						
						<!-- PENJUALAN -->
						<li>
							<a class="collapsed header-collapse" name="menu-penjualan" href="#penjualan" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-shopping-bag"  data-bs-toggle="tooltip" data-bs-placement="right" title="Penjualan"></i>
								<div class="text-span"><span>&nbsp;Penjualan</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="penjualan">
								<li>
									<a class="text-menu-side" name="penjualan-quotation"  onclick="menuselect(\'penjualan-quotation\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Penawaran (Quotatation)</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-salesorder"  onclick="menuselect(\'penjualan-salesorder\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Penjualan (Sales Order)</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-salesrequest" onclick="menuselect(\'penjualan-salesrequest\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Request Approval Penjualan</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Additional</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-pengunjung"  onclick="menuselect(\'penjualan-pengunjung\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Data Pengunjung</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-file"  onclick="menuselect(\'penjualan-file\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;File Pelanggan</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Report</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-report-item-category"  onclick="menuselect(\'penjualan-report-item-category\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Report Sales Item Kategori</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-report-item-vendor"  onclick="menuselect(\'penjualan-report-item-vendor\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Report Sales Item Vendor</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-report-payment"  onclick="menuselect(\'penjualan-report-payment\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Report Sales Payment</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-report-invoice"  onclick="menuselect(\'penjualan-report-invoice\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Report Sales by Invoice</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-report-periode"  onclick="menuselect(\'penjualan-report-periode\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Report Sales Periode</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-report-cogs"  onclick="menuselect(\'penjualan-report-cogs\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Report Sales By COGS</span></div>
									</a>
								</li>
							</ul>
						</li>
						
						<!-- PEMBELIAN -->
						<li>
							<a class="collapsed header-collapse" name="menu-pembelian" href="#pembelian" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-luggage-cart"  data-bs-toggle="tooltip" data-bs-placement="right" title="Pembelian"></i>
								<div class="text-span"><span>&nbsp;Pembelian</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="pembelian">
								<li>
									<a class="text-menu-side" name="pembelian-povendor"  onclick="menuselect(\'pembelian-povendor\',\'menu-pembelian\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;PO Vendor</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="pembelian-grpovendor"  onclick="menuselect(\'pembelian-grpovendor\',\'menu-pembelian\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;GRPO Vendor</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Internal</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="pembelian-podivisi"  onclick="menuselect(\'pembelian-podivisi\',\'menu-pembelian\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;PO Vendor</span></div>
									</a>
								</li> 
							</ul>
						</li>

						<!-- FINANCE -->
						<li>
							<a class="collapsed header-collapse" name="menu-finance" href="#finance" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-money-bill-alt" data-bs-toggle="tooltip" data-bs-placement="right" title="Finance"></i>
								<div class="text-span"><span>&nbsp;Finance</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="finance">
								<li>
									<a class="text-menu-side" name="finance-approve"  onclick="menuselect(\'finance-approve\',\'menu-finance\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Transaksi Approve</span></div>
									</a>
								</li>
								
								<li>
									<a class="text-menu-side" name="finance-salespayment" onclick="menuselect(\'finance-salespayment\',\'menu-finance\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Hutang Penjualan</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Toko</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="finance-pettycash"  onclick="menuselect(\'finance-pettycash\',\'menu-finance\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Kas Kecil (Petty Cash)</span></div>
									</a>
								</li>
							</ul>
						</li>

						<!-- INVENTORY -->
						<li>
							<a class="collapsed header-collapse" name="menu-inventory" href="#inventori" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-warehouse" data-bs-toggle="tooltip" data-bs-placement="right" title="Inventory"></i>
								<div class="text-span"><span>&nbsp;Inventori</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="inventori">
								<li>
									<a class="text-menu-side" name="inventory-transin"  onclick="menuselect(\'inventory-transin\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Terima Barang</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="inventory-transout"  onclick="menuselect(\'inventory-transout\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Kirim Barang</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Additional</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="inventory-waste"  onclick="menuselect(\'inventory-waste\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Barang Rusak</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="inventory-sampel"  onclick="menuselect(\'inventory-sampel\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Barang Sampel</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Produksi</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="inventory-Produksi"  onclick="menuselect(\'inventory-Produksi\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Produksi</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Hasil Akhir</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="inventory-stock"  onclick="menuselect(\'inventory-stock\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Stok Barang</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="inventory-stockopname"  onclick="menuselect(\'inventory-stockopname\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Stok Opname</span></div>
									</a>
								</li>
							</ul>
						</li>
						
						<!-- PENGIRIMAN -->
						<li>
							<a class="collapsed header-collapse" name="menu-pengiriman" href="#pengiriman" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-truck" data-bs-toggle="tooltip" data-bs-placement="right" title="Pengiriman"></i>
								<div class="text-span"><span>&nbsp;Pengiriman</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="pengiriman">
								<li>
									<a class="text-menu-side" name="pengiriman-list"  onclick="menuselect(\'pengiriman-list\',\'menu-pengiriman\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Daftar pengiriman</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="pengiriman-progress"  onclick="menuselect(\'pengiriman-progress\',\'menu-pengiriman\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Sedang Progress</span></div>
									</a>
								</li>
							</ul>
						</li>

						<!-- ABSENSI -->
						<li>
							<a class="collapsed header-collapse" name="menu-absensi" href="#absensi" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-users" data-bs-toggle="tooltip" data-bs-placement="right" title="Absensi"></i>
								<div class="text-span"><span>&nbsp;Absensi</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="absensi">
								<li>
									<a class="text-menu-side" name="absensi-log"  onclick="menuselect(\'absensi-log\',\'menu-absensi\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Catatan Absen</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Schedule</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="absensi-listroster"  onclick="menuselect(\'absensi-listroster\',\'menu-absensi\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;List Roster</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="absensi-roster"  onclick="menuselect(\'absensi-roster\',\'menu-absensi\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Schedule/Roster</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Pengelolaan</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="absensi-izinsakit"  onclick="menuselect(\'absensi-izinsakit\',\'menu-absensi\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Keterangan Izin/Sakit</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="absensi-Lemburan"  onclick="menuselect(\'absensi-Lemburan\',\'menu-absensi\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Keterangan Lemburan</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Pengelolaan</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="absensi-Proses"  onclick="menuselect(\'absensi-Proses\',\'menu-absensi\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Proses Absen Karyawan</span></div>
									</a>
								</li>
							</ul>
						</li>
 
						<!-- TOOLS -->
						<li>
							<a class="collapsed header-collapse" name="menu-tools" href="#tools" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-briefcase" data-bs-toggle="tooltip" data-bs-placement="right" title="tools"></i>
								<div class="text-span"><span>&nbsp;Tools</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="tools">
								<li>
									<a class="text-menu-side" name="tools-qr-code"  onclick="menuselect(\'tools-qr-code\',\'menu-tools\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Visit QR Code</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="tools-timeline-project"  onclick="menuselect(\'tools-timeline-project\',\'menu-tools\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Visit Timeline Project</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="tools-asset"  onclick="menuselect(\'tools-asset\',\'menu-tools\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Asset</span></div>
									</a>
								</li>
							</ul>
						</li>
					</ul>
					<script>
						$("[data-bs-toggle=\'tooltip\']").tooltip()
					</script>';
				break;
			case "Ekspedisi":
				echo '	
					<ul>
						<!-- Dashboard -->
						<li> 
							<a class="text-menu-side" name="menu-dashboard" onclick="menuselect(\'menu-dashboard\',\'-\')">
								<i class="fas fa-tachometer-alt"  data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard"></i>
								<div class="text-span"><span>&nbsp;Dashboard</span></div>
							</a>
						</li> 
					<!-- PENGIRIMAN -->
						<li>
							<a class="collapsed header-collapse" name="menu-pengiriman" href="#pengiriman" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-truck" data-bs-toggle="tooltip" data-bs-placement="right" title="Pengiriman"></i>
								<div class="text-span"><span>&nbsp;Pengiriman</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="pengiriman">
								<li>
									<a class="text-menu-side" name="pengiriman-progress"  onclick="menuselect(\'pengiriman-progress\',\'menu-pengiriman\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Sedang Progress</span></div>
									</a>
								</li>
							</ul>
						</li>
						</ul>';
				break;
			case "Admin Toko":
				echo '<ul>
						<!-- Dashboard -->
						<li> 
							<a class="text-menu-side" name="menu-dashboard" onclick="menuselect(\'menu-dashboard\',\'-\')">
								<i class="fas fa-tachometer-alt"  data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard"></i>
								<div class="text-span"><span>&nbsp;Dashboard</span></div>
							</a>
						</li> 
						
						<!-- MASTER DATA -->
						<li> 
							<a class="collapsed header-collapse" name="menu-master-data" href="#master-data" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-database"  data-bs-toggle="tooltip" data-bs-placement="right" title="Master Data"></i>
								<div class="text-span"><span>&nbsp;Master Data</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="master-data"> 
								<li class="divider">
									<span style="font-size:12px">&nbsp;PELANGGAN</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="master-datatipecustomer"  onclick="menuselect(\'master-datatipecustomer\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Tipe Pelanggan</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="master-datacustomer"  onclick="menuselect(\'master-datacustomer\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Data Pelanggan</span></div>
									</a>
								</li> 
							</ul>
						</li>
						
						<!-- PENJUALAN -->
						<li>
							<a class="collapsed header-collapse" name="menu-penjualan" href="#penjualan" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-shopping-bag"  data-bs-toggle="tooltip" data-bs-placement="right" title="Penjualan"></i>
								<div class="text-span"><span>&nbsp;Penjualan</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="penjualan">
								<li>
									<a class="text-menu-side" name="penjualan-quotation"  onclick="menuselect(\'penjualan-quotation\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Penawaran (Quotatation)</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-salesorder"  onclick="menuselect(\'penjualan-salesorder\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Penjualan (Sales Order)</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Additional</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-pengunjung"  onclick="menuselect(\'penjualan-pengunjung\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Data Pengunjung</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-file"  onclick="menuselect(\'penjualan-file\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;File Pelanggan</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Report</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-report-item-category"  onclick="menuselect(\'penjualan-report-item-category\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Report Sales Item Kategori</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-report-item-vendor"  onclick="menuselect(\'penjualan-report-item-vendor\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Report Sales Item Vendor</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-report-invoice"  onclick="menuselect(\'penjualan-report-invoice\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Report Sales by Invoice</span></div>
									</a>
								</li>
							</ul>
						</li>
						
						<!-- PEMBELIAN -->
						<li>
							<a class="collapsed header-collapse" name="menu-pembelian" href="#pembelian" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-luggage-cart"  data-bs-toggle="tooltip" data-bs-placement="right" title="Pembelian"></i>
								<div class="text-span"><span>&nbsp;Pembelian</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="pembelian">
								<li>
									<a class="text-menu-side" name="pembelian-povendor"  onclick="menuselect(\'pembelian-povendor\',\'menu-pembelian\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;PO Vendor</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="pembelian-grpovendor"  onclick="menuselect(\'pembelian-grpovendor\',\'menu-pembelian\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;GRPO Vendor</span></div>
									</a>
								</li>
							</ul>
						</li>

						<!-- FINANCE -->
						<li>
							<a class="collapsed header-collapse" name="menu-finance" href="#finance" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-money-bill-alt" data-bs-toggle="tooltip" data-bs-placement="right" title="Finance"></i>
								<div class="text-span"><span>&nbsp;Finance</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="finance"> 
								<li>
									<a class="text-menu-side" name="finance-pettycash"  onclick="menuselect(\'finance-pettycash\',\'menu-finance\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Kas Kecil (Petty Cash)</span></div>
									</a>
								</li>
							</ul>
						</li>

						<!-- INVENTORY -->
						<li>
							<a class="collapsed header-collapse" name="menu-inventory" href="#inventori" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-warehouse" data-bs-toggle="tooltip" data-bs-placement="right" title="Inventory"></i>
								<div class="text-span"><span>&nbsp;Inventori</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="inventori">
								<li>
									<a class="text-menu-side" name="inventory-transin"  onclick="menuselect(\'inventory-transin\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Terima Barang</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="inventory-transout"  onclick="menuselect(\'inventory-transout\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Kirim Barang</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Additional</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="inventory-waste"  onclick="menuselect(\'inventory-waste\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Barang Rusak</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Produksi</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="inventory-Produksi"  onclick="menuselect(\'inventory-Produksi\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Produksi</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Hasil Akhir</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="inventory-stock"  onclick="menuselect(\'inventory-stock\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Stok Barang</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="inventory-stockopname"  onclick="menuselect(\'inventory-stockopname\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Stok Opname</span></div>
									</a>
								</li>
							</ul>
						</li>
						
						<!-- PENGIRIMAN -->
						<li>
							<a class="collapsed header-collapse" name="menu-pengiriman" href="#pengiriman" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-truck" data-bs-toggle="tooltip" data-bs-placement="right" title="Pengiriman"></i>
								<div class="text-span"><span>&nbsp;Pengiriman</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="pengiriman">
								<li>
									<a class="text-menu-side" name="pengiriman-list"  onclick="menuselect(\'pengiriman-list\',\'menu-pengiriman\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Daftar pengiriman</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="pengiriman-progress"  onclick="menuselect(\'pengiriman-progress\',\'menu-pengiriman\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Sedang Progress</span></div>
									</a>
								</li>
							</ul>
						</li>

					</ul>
					<script>
						$("[data-bs-toggle=\'tooltip\']").tooltip()
					</script>';
				break;

			case "Accounting":
					echo '<ul>
							<!-- Dashboard -->
							<li> 
								<a class="text-menu-side" name="menu-dashboard" onclick="menuselect(\'menu-dashboard\',\'-\')">
									<i class="fas fa-tachometer-alt"  data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard"></i>
									<div class="text-span"><span>&nbsp;Dashboard</span></div>
								</a>
							</li>

							<!-- MASTER DATA -->
							<li> 
							<a class="collapsed header-collapse" name="menu-master-data" href="#master-data" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-database"  data-bs-toggle="tooltip" data-bs-placement="right" title="Master Data"></i>
								<div class="text-span"><span>&nbsp;Master Data</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="master-data">
								<li class="divider">
									<span style="font-size:12px">&nbsp;FINANCE</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="master-tipepembayaran"  onclick="menuselect(\'master-tipepembayaran\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Tipe Pembayaran</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="master-costofgoodssales"  onclick="menuselect(\'master-costofgoodssales\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Cost of Goods Sales</span></div>
									</a>
								</li>
							</ul>
							</li>
							
							<!-- PENJUALAN -->
							<li>
								<a class="collapsed header-collapse" name="menu-penjualan" href="#penjualan" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
									<i class="fas fa-shopping-bag"  data-bs-toggle="tooltip" data-bs-placement="right" title="Penjualan"></i>
									<div class="text-span"><span>&nbsp;Penjualan</span></div>
								</a>
								<ul class="treeview-menu ps-0 collapse" id="penjualan">
									<li>
										<a class="text-menu-side" name="penjualan-quotation"  onclick="menuselect(\'penjualan-quotation\',\'menu-penjualan\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Penawaran (Quotatation)</span></div>
										</a>
									</li>
									<li>
										<a class="text-menu-side" name="penjualan-salesorder"  onclick="menuselect(\'penjualan-salesorder\',\'menu-penjualan\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Penjualan (Sales Order)</span></div>
										</a>
									</li>
									<li>
										<a class="text-menu-side" name="penjualan-salesrequest" onclick="menuselect(\'penjualan-salesrequest\',\'menu-penjualan\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Request Approval Penjualan</span></div>
										</a>
									</li>
									<li class="divider">
										<span style="font-size:12px">&nbsp;Additional</span></div>
									</li>
									<li>
										<a class="text-menu-side" name="penjualan-pengunjung"  onclick="menuselect(\'penjualan-pengunjung\',\'menu-penjualan\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Data Pengunjung</span></div>
										</a>
									</li>
									<li>
										<a class="text-menu-side" name="penjualan-file"  onclick="menuselect(\'penjualan-file\',\'menu-penjualan\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;File Pelanggan</span></div>
										</a>
									</li>
									<li class="divider">
										<span style="font-size:12px">&nbsp;Report</span></div>
									</li>
									<li>
										<a class="text-menu-side" name="penjualan-report-item-category"  onclick="menuselect(\'penjualan-report-item-category\',\'menu-penjualan\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Report Sales Item Kategori</span></div>
										</a>
									</li>
									<li>
										<a class="text-menu-side" name="penjualan-report-item-vendor"  onclick="menuselect(\'penjualan-report-item-vendor\',\'menu-penjualan\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Report Sales Item Vendor</span></div>
										</a>
									</li>
									<li>
										<a class="text-menu-side" name="penjualan-report-payment"  onclick="menuselect(\'penjualan-report-payment\',\'menu-penjualan\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Report Sales Payment</span></div>
										</a> 
									</li> 
									<li>
										<a class="text-menu-side" name="penjualan-report-periode"  onclick="menuselect(\'penjualan-report-periode\',\'menu-penjualan\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Report Sales Periode</span></div>
										</a>
									</li>
									<li>
										<a class="text-menu-side" name="penjualan-report-cogs"  onclick="menuselect(\'penjualan-report-cogs\',\'menu-penjualan\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Report Sales By COGS</span></div>
										</a>
									</li>
								</ul>
							</li>
							
							<!-- PEMBELIAN -->
							<li>
								<a class="collapsed header-collapse" name="menu-pembelian" href="#pembelian" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
									<i class="fas fa-luggage-cart"  data-bs-toggle="tooltip" data-bs-placement="right" title="Pembelian"></i>
									<div class="text-span"><span>&nbsp;Pembelian</span></div>
								</a>
								<ul class="treeview-menu ps-0 collapse" id="pembelian">
									<li>
										<a class="text-menu-side" name="pembelian-povendor"  onclick="menuselect(\'pembelian-povendor\',\'menu-pembelian\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;PO Vendor</span></div>
										</a>
									</li>
									<li>
										<a class="text-menu-side" name="pembelian-grpovendor"  onclick="menuselect(\'pembelian-grpovendor\',\'menu-pembelian\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;GRPO Vendor</span></div>
										</a>
									</li>
								</ul>
							</li>
	
							<!-- FINANCE -->
							<li>
								<a class="collapsed header-collapse" name="menu-finance" href="#finance" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
									<i class="fas fa-money-bill-alt" data-bs-toggle="tooltip" data-bs-placement="right" title="Finance"></i>
									<div class="text-span"><span>&nbsp;Finance</span></div>
								</a>
								<ul class="treeview-menu ps-0 collapse" id="finance"> 
									<li>
										<a class="text-menu-side" name="finance-approve"  onclick="menuselect(\'finance-approve\',\'menu-finance\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Transaksi Approve</span></div>
										</a>
									</li>
									<li>
										<a class="text-menu-side" name="finance-salespayment" onclick="menuselect(\'finance-salespayment\',\'menu-finance\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Hutang Penjualan</span></div>
										</a>
									</li>
									<li class="divider">
										<span style="font-size:12px">&nbsp;Toko</span></div>
									</li>
									<li>
										<a class="text-menu-side" name="finance-pettycash"  onclick="menuselect(\'finance-pettycash\',\'menu-finance\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Kas Kecil (Petty Cash)</span></div>
										</a>
									</li>
								</ul>
							</li>
							
							<!-- PENGIRIMAN -->
							<li>
								<a class="collapsed header-collapse" name="menu-pengiriman" href="#pengiriman" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
									<i class="fas fa-truck" data-bs-toggle="tooltip" data-bs-placement="right" title="Pengiriman"></i>
									<div class="text-span"><span>&nbsp;Pengiriman</span></div>
								</a>
								<ul class="treeview-menu ps-0 collapse" id="pengiriman">
									<li>
										<a class="text-menu-side" name="pengiriman-list"  onclick="menuselect(\'pengiriman-list\',\'menu-pengiriman\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Daftar pengiriman</span></div>
										</a>
									</li>
									<li>
										<a class="text-menu-side" name="pengiriman-progress"  onclick="menuselect(\'pengiriman-progress\',\'menu-pengiriman\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Sedang Progress</span></div>
										</a>
									</li>
								</ul>
							</li>
	
						</ul>
						<script>
							$("[data-bs-toggle=\'tooltip\']").tooltip()
						</script>';
					break;

			case "Admin Warehouse":
				echo '<ul>
							<!-- Dashboard -->
							<li> 
								<a class="text-menu-side" name="menu-dashboard" onclick="menuselect(\'menu-dashboard\',\'-\')">
									<i class="fas fa-tachometer-alt"  data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard"></i>
									<div class="text-span"><span>&nbsp;Dashboard</span></div>
								</a>
							</li> 
							
							<!-- MASTER DATA -->
							<li> 
								<a class="collapsed header-collapse" name="menu-master-data" href="#master-data" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
									<i class="fas fa-database"  data-bs-toggle="tooltip" data-bs-placement="right" title="Master Data"></i>
									<div class="text-span"><span>&nbsp;Master Data</span></div>
								</a>
								<ul class="treeview-menu ps-0 collapse" id="master-data">
									<li class="divider">
										<span style="font-size:12px">&nbsp;TOKO</span></div>
									</li>
									<li>
										<a class="text-menu-side" name="master-datatoko" onclick="menuselect(\'master-datatoko\',\'menu-master-data\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Data Toko</span></div>
										</a>
									</li>
									<li class="divider">
										<span style="font-size:12px">&nbsp;KARYAWAN</span></div>
									</li>
									<li>
										<a class="text-menu-side" name="master-datajabatan" onclick="menuselect(\'master-datajabatan\',\'menu-master-data\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Data Jabatan</span></div>
										</a>
									</li>
									<li>
										<a class="text-menu-side" name="master-datakaryawan"  onclick="menuselect(\'master-datakaryawan\',\'menu-master-data\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Data Karyawan</span></div>
										</a>
									</li>
									<li>
										<a class="text-menu-side" name="master-datastaffcetak"  onclick="menuselect(\'master-datastaffcetak\',\'menu-master-data\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Data Staff Cetak</span></div>
										</a>
									</li>
									<li class="divider">
										<span style="font-size:12px">&nbsp;ITEM MASTER</span></div>
									</li>
									<li>
										<a class="text-menu-side" name="master-itemkategory"  onclick="menuselect(\'master-itemkategory\',\'menu-master-data\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Item Kategori</span></div>
										</a>
									</li>
									<li>
										<a class="text-menu-side" name="master-itemmaster"  onclick="menuselect(\'master-itemmaster\',\'menu-master-data\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Item Master</span></div>
										</a>
									</li>
									<li>
										<a class="text-menu-side" name="master-itemlisting"  onclick="menuselect(\'master-itemlisting\',\'menu-master-data\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Item Listing</span></div>
										</a>
									</li>
									<li>
										<a class="text-menu-side" name="master-billofmaterial"  onclick="menuselect(\'master-billofmaterial\',\'menu-master-data\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Bill of Material</span></div>
										</a>
									</li>
									<li class="divider">
										<span style="font-size:12px">&nbsp;SUPPLIER</span></div>
									</li>
									<li>
										<a class="text-menu-side" name="master-datasupplier"  onclick="menuselect(\'master-datasupplier\',\'menu-master-data\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Data Supplier</span></div>
										</a>
									</li>
									
									<li class="divider">
										<span style="font-size:12px">&nbsp;PENGIRIMAN</span></div>
									</li>
									<li>
										<a class="text-menu-side" name="master-datapengiriman"  onclick="menuselect(\'master-datapengiriman\',\'menu-master-data\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Tipe Pengiriman</span></div>
										</a>
									</li>
									<li class="divider">
										<span style="font-size:12px">&nbsp;PELANGGAN</span></div>
									</li>
									<li>
										<a class="text-menu-side" name="master-datatipecustomer"  onclick="menuselect(\'master-datatipecustomer\',\'menu-master-data\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Tipe Pelanggan</span></div>
										</a>
									</li>
									<li>
										<a class="text-menu-side" name="master-datacustomer"  onclick="menuselect(\'master-datacustomer\',\'menu-master-data\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Data Pelanggan</span></div>
										</a>
									</li>
									<li class="divider">
										<span style="font-size:12px">&nbsp;FINANCE</span></div>
									</li>
									<li>
										<a class="text-menu-side" name="master-tipepembayaran"  onclick="menuselect(\'master-tipepembayaran\',\'menu-master-data\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Tipe Pembayaran</span></div>
										</a>
									</li>
									<li>
										<a class="text-menu-side" name="master-costofgoodssales"  onclick="menuselect(\'master-costofgoodssales\',\'menu-master-data\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Cost of Goods Sales</span></div>
										</a>
									</li>
								</ul>
							</li>
							
							<!-- PENJUALAN -->
							<li>
								<a class="collapsed header-collapse" name="menu-penjualan" href="#penjualan" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
									<i class="fas fa-shopping-bag"  data-bs-toggle="tooltip" data-bs-placement="right" title="Penjualan"></i>
									<div class="text-span"><span>&nbsp;Penjualan</span></div>
								</a>
								<ul class="treeview-menu ps-0 collapse" id="penjualan">
									<li>
										<a class="text-menu-side" name="penjualan-quotation"  onclick="menuselect(\'penjualan-quotation\',\'menu-penjualan\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Penawaran (Quotatation)</span></div>
										</a>
									</li>
									<li>
										<a class="text-menu-side" name="penjualan-salesorder"  onclick="menuselect(\'penjualan-salesorder\',\'menu-penjualan\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Penjualan (Sales Order)</span></div>
										</a>
									</li>
									<li class="divider">
										<span style="font-size:12px">&nbsp;Additional</span></div>
									</li>
									<li>
										<a class="text-menu-side" name="penjualan-pengunjung"  onclick="menuselect(\'penjualan-pengunjung\',\'menu-penjualan\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Data Pengunjung</span></div>
										</a>
									</li>
									<li>
										<a class="text-menu-side" name="penjualan-file"  onclick="menuselect(\'penjualan-file\',\'menu-penjualan\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;File Pelanggan</span></div>
										</a>
									</li>
								</ul>
							</li>
							
							<!-- PEMBELIAN -->
							<li>
								<a class="collapsed header-collapse" name="menu-pembelian" href="#pembelian" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
									<i class="fas fa-luggage-cart"  data-bs-toggle="tooltip" data-bs-placement="right" title="Pembelian"></i>
									<div class="text-span"><span>&nbsp;Pembelian</span></div>
								</a>
								<ul class="treeview-menu ps-0 collapse" id="pembelian">
									<li>
										<a class="text-menu-side" name="pembelian-povendor"  onclick="menuselect(\'pembelian-povendor\',\'menu-pembelian\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;PO Vendor</span></div>
										</a>
									</li>
								</ul>
							</li>

							<!-- FINANCE -->
							<li>
								<a class="collapsed header-collapse" name="menu-finance" href="#finance" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
									<i class="fas fa-money-bill-alt" data-bs-toggle="tooltip" data-bs-placement="right" title="Finance"></i>
									<div class="text-span"><span>&nbsp;Finance</span></div>
								</a>
								<ul class="treeview-menu ps-0 collapse" id="finance"> 
									<li>
										<a class="text-menu-side" name="finance-pettycash"  onclick="menuselect(\'finance-pettycash\',\'menu-finance\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Kas Kecil (Petty Cash)</span></div>
										</a>
									</li>
								</ul>
							</li>

							<!-- INVENTORY -->
							<li>
								<a class="collapsed header-collapse" name="menu-inventory" href="#inventori" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
									<i class="fas fa-warehouse" data-bs-toggle="tooltip" data-bs-placement="right" title="Inventory"></i>
									<div class="text-span"><span>&nbsp;Inventori</span></div>
								</a>
								<ul class="treeview-menu ps-0 collapse" id="inventori">
									<li>
										<a class="text-menu-side" name="inventory-transin"  onclick="menuselect(\'inventory-transin\',\'menu-inventory\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Terima Barang</span></div>
										</a>
									</li>
									<li>
										<a class="text-menu-side" name="inventory-transout"  onclick="menuselect(\'inventory-transout\',\'menu-inventory\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Kirim Barang</span></div>
										</a>
									</li>
									<li class="divider">
										<span style="font-size:12px">&nbsp;Additional</span></div>
									</li>
									<li>
										<a class="text-menu-side" name="inventory-waste"  onclick="menuselect(\'inventory-waste\',\'menu-inventory\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Barang Rusak</span></div>
										</a>
									</li>
									<li class="divider">
										<span style="font-size:12px">&nbsp;Produksi</span></div>
									</li>
									<li>
										<a class="text-menu-side" name="inventory-Produksi"  onclick="menuselect(\'inventory-Produksi\',\'menu-inventory\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Produksi</span></div>
										</a>
									</li>
									<li class="divider">
										<span style="font-size:12px">&nbsp;Hasil Akhir</span></div>
									</li>
									<li>
										<a class="text-menu-side" name="inventory-stock"  onclick="menuselect(\'inventory-stock\',\'menu-inventory\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Stok Barang</span></div>
										</a>
									</li>
									<li>
										<a class="text-menu-side" name="inventory-stockopname"  onclick="menuselect(\'inventory-stockopname\',\'menu-inventory\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Stok Opname</span></div>
										</a>
									</li>
								</ul>
							</li>
							
							<!-- PENGIRIMAN -->
							<li>
								<a class="collapsed header-collapse" name="menu-pengiriman" href="#pengiriman" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
									<i class="fas fa-truck" data-bs-toggle="tooltip" data-bs-placement="right" title="Pengiriman"></i>
									<div class="text-span"><span>&nbsp;Pengiriman</span></div>
								</a>
								<ul class="treeview-menu ps-0 collapse" id="pengiriman">
									<li>
										<a class="text-menu-side" name="pengiriman-list"  onclick="menuselect(\'pengiriman-list\',\'menu-pengiriman\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Daftar pengiriman</span></div>
										</a>
									</li>
									<li>
										<a class="text-menu-side" name="pengiriman-progress"  onclick="menuselect(\'pengiriman-progress\',\'menu-pengiriman\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Sedang Progress</span></div>
										</a>
									</li>
								</ul>
							</li>
							
							<!-- ABSENSI -->
							<li>
								<a class="collapsed header-collapse" name="menu-absensi" href="#absensi" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
									<i class="fas fa-users" data-bs-toggle="tooltip" data-bs-placement="right" title="Absensi"></i>
									<div class="text-span"><span>&nbsp;Absensi</span></div>
								</a>
								<ul class="treeview-menu ps-0 collapse" id="absensi">
									<li>
										<a class="text-menu-side" name="absensi-log"  onclick="menuselect(\'absensi-log\',\'menu-absensi\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Catatan Absen</span></div>
										</a>
									</li>
									<li class="divider">
										<span style="font-size:12px">&nbsp;Schedule</span></div>
									</li>
									<li>
										<a class="text-menu-side" name="absensi-listroster"  onclick="menuselect(\'absensi-listroster\',\'menu-absensi\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;List Roster</span></div>
										</a>
									</li>
									<li>
										<a class="text-menu-side" name="absensi-roster"  onclick="menuselect(\'absensi-roster\',\'menu-absensi\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Schedule/Roster</span></div>
										</a>
									</li>
									<li class="divider">
										<span style="font-size:12px">&nbsp;Pengelolaan</span></div>
									</li>
									<li>
										<a class="text-menu-side" name="absensi-izinsakit"  onclick="menuselect(\'absensi-izinsakit\',\'menu-absensi\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Keterangan Izin/Sakit</span></div>
										</a>
									</li>
									<li>
										<a class="text-menu-side" name="absensi-Lemburan"  onclick="menuselect(\'absensi-Lemburan\',\'menu-absensi\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Keterangan Lemburan</span></div>
										</a>
									</li>
									<li class="divider">
										<span style="font-size:12px">&nbsp;Pengelolaan</span></div>
									</li>
									<li>
										<a class="text-menu-side" name="absensi-Proses"  onclick="menuselect(\'absensi-Proses\',\'menu-absensi\')">
											<i class="far fa-circle"></i> 
											<div class="text-span"><span>&nbsp;Proses Absen Karyawan</span></div>
										</a>
									</li>
								</ul>
							</li>
						</ul>
						<script>
							$("[data-bs-toggle=\'tooltip\']").tooltip()
						</script>';
				break;
			case "Finance":
				echo '<ul>
						<!-- Dashboard -->
						<li> 
							<a class="text-menu-side" name="menu-dashboard" onclick="menuselect(\'menu-dashboard\',\'-\')">
								<i class="fas fa-tachometer-alt"  data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard"></i>
								<div class="text-span"><span>&nbsp;Dashboard</span></div>
							</a>
						</li> 
 
						<!-- MASTER DATA -->
						<li> 
							<a class="collapsed header-collapse" name="menu-master-data" href="#master-data" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-database"  data-bs-toggle="tooltip" data-bs-placement="right" title="Master Data"></i>
								<div class="text-span"><span>&nbsp;Master Data</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="master-data">
								<li class="divider">
									<span style="font-size:12px">&nbsp;TOKO</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="master-datatoko" onclick="menuselect(\'master-datatoko\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Data Toko</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;KARYAWAN</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="master-datajabatan" onclick="menuselect(\'master-datajabatan\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Data Jabatan</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="master-datakaryawan"  onclick="menuselect(\'master-datakaryawan\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Data Karyawan</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="master-datastaffcetak"  onclick="menuselect(\'master-datastaffcetak\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Data Staff Cetak</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;ITEM MASTER</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="master-itemkategory"  onclick="menuselect(\'master-itemkategory\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Item Kategori</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="master-itemmaster"  onclick="menuselect(\'master-itemmaster\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Item Master</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="master-itemlisting"  onclick="menuselect(\'master-itemlisting\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Item Listing</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="master-billofmaterial"  onclick="menuselect(\'master-billofmaterial\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Bill of Material</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;SUPPLIER</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="master-datasupplier"  onclick="menuselect(\'master-datasupplier\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Data Supplier</span></div>
									</a>
								</li>
								
								<li class="divider">
									<span style="font-size:12px">&nbsp;PENGIRIMAN</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="master-datapengiriman"  onclick="menuselect(\'master-datapengiriman\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Tipe Pengiriman</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;PELANGGAN</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="master-datatipecustomer"  onclick="menuselect(\'master-datatipecustomer\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Tipe Pelanggan</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="master-datacustomer"  onclick="menuselect(\'master-datacustomer\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Data Pelanggan</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;FINANCE</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="master-tipepembayaran"  onclick="menuselect(\'master-tipepembayaran\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Tipe Pembayaran</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="master-costofgoodssales"  onclick="menuselect(\'master-costofgoodssales\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Cost of Goods Sales</span></div>
									</a>
								</li>
							</ul>
						</li>
						
						<!-- PENJUALAN -->
						<li>
							<a class="collapsed header-collapse" name="menu-penjualan" href="#penjualan" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-shopping-bag"  data-bs-toggle="tooltip" data-bs-placement="right" title="Penjualan"></i>
								<div class="text-span"><span>&nbsp;Penjualan</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="penjualan">
								<li>
									<a class="text-menu-side" name="penjualan-quotation"  onclick="menuselect(\'penjualan-quotation\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Penawaran (Quotatation)</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-salesorder"  onclick="menuselect(\'penjualan-salesorder\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Penjualan (Sales Order)</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-salesrequest" onclick="menuselect(\'penjualan-salesrequest\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Request Approval Penjualan</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Additional</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-pengunjung"  onclick="menuselect(\'penjualan-pengunjung\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Data Pengunjung</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-file"  onclick="menuselect(\'penjualan-file\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;File Pelanggan</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Report</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-report-item-category"  onclick="menuselect(\'penjualan-report-item-category\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Report Sales Item Kategori</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-report-item-vendor"  onclick="menuselect(\'penjualan-report-item-vendor\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Report Sales Item Vendor</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-report-payment"  onclick="menuselect(\'penjualan-report-payment\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Report Sales Payment</span></div>
									</a> 
								</li> 
								<li>
									<a class="text-menu-side" name="penjualan-report-periode"  onclick="menuselect(\'penjualan-report-periode\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Report Sales Periode</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-report-cogs"  onclick="menuselect(\'penjualan-report-cogs\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Report Sales By COGS</span></div>
									</a>
								</li>
							</ul>
						</li>
						
						<!-- PEMBELIAN -->
						<li>
							<a class="collapsed header-collapse" name="menu-pembelian" href="#pembelian" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-luggage-cart"  data-bs-toggle="tooltip" data-bs-placement="right" title="Pembelian"></i>
								<div class="text-span"><span>&nbsp;Pembelian</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="pembelian">
								<li>
									<a class="text-menu-side" name="pembelian-povendor"  onclick="menuselect(\'pembelian-povendor\',\'menu-pembelian\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;PO Vendor</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="pembelian-grpovendor"  onclick="menuselect(\'pembelian-grpovendor\',\'menu-pembelian\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;GRPO Vendor</span></div>
									</a>
								</li>
							</ul>
						</li>

						<!-- FINANCE -->
						<li>
							<a class="collapsed header-collapse" name="menu-finance" href="#finance" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-money-bill-alt" data-bs-toggle="tooltip" data-bs-placement="right" title="Finance"></i>
								<div class="text-span"><span>&nbsp;Finance</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="finance"> 
								<li>
									<a class="text-menu-side" name="finance-approve"  onclick="menuselect(\'finance-approve\',\'menu-finance\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Transaksi Approve</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Toko</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="finance-pettycash"  onclick="menuselect(\'finance-pettycash\',\'menu-finance\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Kas Kecil (Petty Cash)</span></div>
									</a>
								</li>
							</ul>
						</li>

						<!-- INVENTORY -->
						<li>
							<a class="collapsed header-collapse" name="menu-inventory" href="#inventori" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-warehouse" data-bs-toggle="tooltip" data-bs-placement="right" title="Inventory"></i>
								<div class="text-span"><span>&nbsp;Inventori</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="inventori">
								<li>
									<a class="text-menu-side" name="inventory-transin"  onclick="menuselect(\'inventory-transin\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Terima Barang</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="inventory-transout"  onclick="menuselect(\'inventory-transout\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Kirim Barang</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Additional</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="inventory-waste"  onclick="menuselect(\'inventory-waste\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Barang Rusak</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Produksi</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="inventory-Produksi"  onclick="menuselect(\'inventory-Produksi\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Produksi</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Hasil Akhir</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="inventory-stock"  onclick="menuselect(\'inventory-stock\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Stok Barang</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="inventory-stockopname"  onclick="menuselect(\'inventory-stockopname\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Stok Opname</span></div>
									</a>
								</li>
							</ul>
						</li>
						
						<!-- PENGIRIMAN -->
						<li>
							<a class="collapsed header-collapse" name="menu-pengiriman" href="#pengiriman" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-truck" data-bs-toggle="tooltip" data-bs-placement="right" title="Pengiriman"></i>
								<div class="text-span"><span>&nbsp;Pengiriman</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="pengiriman">
								<li>
									<a class="text-menu-side" name="pengiriman-list"  onclick="menuselect(\'pengiriman-list\',\'menu-pengiriman\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Daftar pengiriman</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="pengiriman-progress"  onclick="menuselect(\'pengiriman-progress\',\'menu-pengiriman\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Sedang Progress</span></div>
									</a>
								</li>
							</ul>
						</li>
						
						<!-- ABSENSI -->
						<li>
							<a class="collapsed header-collapse" name="menu-absensi" href="#absensi" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-users" data-bs-toggle="tooltip" data-bs-placement="right" title="Absensi"></i>
								<div class="text-span"><span>&nbsp;Absensi</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="absensi">
								<li>
									<a class="text-menu-side" name="absensi-log"  onclick="menuselect(\'absensi-log\',\'menu-absensi\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Catatan Absen</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Schedule</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="absensi-listroster"  onclick="menuselect(\'absensi-listroster\',\'menu-absensi\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;List Roster</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="absensi-roster"  onclick="menuselect(\'absensi-roster\',\'menu-absensi\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Schedule/Roster</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Pengelolaan</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="absensi-izinsakit"  onclick="menuselect(\'absensi-izinsakit\',\'menu-absensi\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Keterangan Izin/Sakit</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="absensi-Lemburan"  onclick="menuselect(\'absensi-Lemburan\',\'menu-absensi\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Keterangan Lemburan</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Pengelolaan</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="absensi-Proses"  onclick="menuselect(\'absensi-Proses\',\'menu-absensi\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Proses Absen Karyawan</span></div>
									</a>
								</li>
							</ul>
						</li>

					</ul>';
				break;

			case "Logistik":
				echo '<ul>
				 		<!-- Dashboard -->
						<li> 
							<a class="active text-menu-side" onclick="menuselect(\'dashboard\')">
								<i class="fas fa-tachometer-alt"></i>
								<div class="text-span"><span>&nbsp;Dashboard</span></div>
							</a>
						</li> 
 
						<!-- INVENTORY -->
						<li>
							<a class="collapsed header-collapse" name="menu-inventory" href="#inventori" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-warehouse"></i>
								<div class="text-span"><span>&nbsp;Inventori</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="inventori">
								<li>
									<a class="text-menu-side" name=""  onclick="menuselect(\'inventory-transin\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Terima Barang</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name=""  onclick="menuselect(\'inventory-transout\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Kirim Barang</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Additional</span></div>
								</li>
								<li>
									<a class="text-menu-side" name=""  onclick="menuselect(\'inventory-waste\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Barang Rusak</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Produksi</span></div>
								</li>
								<li>
									<a class="text-menu-side" name=""  onclick="menuselect(\'inventory-Produksi\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Produksi</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Hasil Akhir</span></div>
								</li>
								<li>
									<a class="text-menu-side" name=""  onclick="menuselect(\'inventory-stock\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Stok Barang</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name=""  onclick="menuselect(\'inventory-stockopname\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Stok Opname</span></div>
									</a>
								</li>
							</ul>
						</li>
						
						<!-- PENGIRIMAN -->
						<li>
							<a class="collapsed header-collapse" name="menu-pengiriman" href="#pengiriman" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-truck"></i>
								<div class="text-span"><span>&nbsp;Pengiriman</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="pengiriman">
								<li>
									<a class="text-menu-side" name=""  onclick="menuselect(\'pengiriman-list\',\'menu-pengiriman\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Daftar pengiriman</span></div>
									</a>
								</li>
							</ul>
						</li>
 
					</ul>';
				break;

			case "Hrd":
				echo '
					<ul>
						<!-- Dashboard -->
						<li> 
							<a class="text-menu-side" name="menu-dashboard" onclick="menuselect(\'menu-dashboard\',\'-\')">
								<i class="fas fa-tachometer-alt"  data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard"></i>
								<div class="text-span"><span>&nbsp;Dashboard</span></div>
							</a>
						</li> 
						<li> 
							<a class="collapsed header-collapse" name="menu-master-data" href="#master-data" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-database"  data-bs-toggle="tooltip" data-bs-placement="right" title="Master Data"></i>
								<div class="text-span"><span>&nbsp;Master Data</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="master-data">
								<li class="divider">
									<span style="font-size:12px">&nbsp;KARYAWAN</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="master-datajabatan" onclick="menuselect(\'master-datajabatan\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Data Jabatan</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="master-datakaryawan"  onclick="menuselect(\'master-datakaryawan\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Data Karyawan</span></div>
									</a>
								</li>
							</ul>
						</li>
						<!-- ABSENSI -->
						<li>
							<a class="collapsed header-collapse" name="menu-absensi" href="#absensi" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-users" data-bs-toggle="tooltip" data-bs-placement="right" title="Absensi"></i>
								<div class="text-span"><span>&nbsp;Absensi</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="absensi">
								<li>
									<a class="text-menu-side" name="absensi-log"  onclick="menuselect(\'absensi-log\',\'menu-absensi\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Catatan Absen</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Schedule</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="absensi-listroster"  onclick="menuselect(\'absensi-listroster\',\'menu-absensi\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;List Roster</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="absensi-roster"  onclick="menuselect(\'absensi-roster\',\'menu-absensi\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Schedule/Roster</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Pengelolaan</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="absensi-izinsakit"  onclick="menuselect(\'absensi-izinsakit\',\'menu-absensi\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Keterangan Izin/Sakit</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="absensi-Lemburan"  onclick="menuselect(\'absensi-Lemburan\',\'menu-absensi\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Keterangan Lemburan</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Pengelolaan</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="absensi-Proses"  onclick="menuselect(\'absensi-Proses\',\'menu-absensi\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Proses Absen Karyawan</span></div>
									</a>
								</li>
							</ul>
						</li>
						
						<!-- TOOLS -->
						<li>
							<a class="collapsed header-collapse" name="menu-tools" href="#tools" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-briefcase" data-bs-toggle="tooltip" data-bs-placement="right" title="tools"></i>
								<div class="text-span"><span>&nbsp;Tools</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="tools"> 
								<li>
									<a class="text-menu-side" name="tools-timeline-project"  onclick="menuselect(\'tools-timeline-project\',\'menu-tools\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Visit Timeline Project</span></div>
									</a>
								</li>
							</ul>
						</li>
					</ul>
					<script>
						$("[data-bs-toggle=\'tooltip\']").tooltip()
					</script>';
				break;
			case "Digital Marketing":
				echo '<ul>
						<!-- Dashboard -->
						<li> 
							<a class="text-menu-side" name="menu-dashboard" onclick="menuselect(\'menu-dashboard\',\'-\')">
								<i class="fas fa-tachometer-alt"  data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard"></i>
								<div class="text-span"><span>&nbsp;Dashboard</span></div>
							</a>
						</li> 

						<!-- MASTER DATA -->
						<li> 
							<a class="collapsed header-collapse" name="menu-master-data" href="#master-data" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-database"  data-bs-toggle="tooltip" data-bs-placement="right" title="Master Data"></i>
								<div class="text-span"><span>&nbsp;Master Data</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="master-data">
								<li class="divider">
									<span style="font-size:12px">&nbsp;PELANGGAN</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="master-datatipecustomer"  onclick="menuselect(\'master-datatipecustomer\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Tipe Pelanggan</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="master-datacustomer"  onclick="menuselect(\'master-datacustomer\',\'menu-master-data\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Data Pelanggan</span></div>
									</a>
								</li>
							</ul>
						</li>
						
						<!-- PENJUALAN -->
						<li>
							<a class="collapsed header-collapse" name="menu-penjualan" href="#penjualan" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-shopping-bag"  data-bs-toggle="tooltip" data-bs-placement="right" title="Penjualan"></i>
								<div class="text-span"><span>&nbsp;Penjualan</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="penjualan">
								<li>
									<a class="text-menu-side" name="penjualan-quotation"  onclick="menuselect(\'penjualan-quotation\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Penawaran (Quotatation)</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-salesorder"  onclick="menuselect(\'penjualan-salesorder\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Penjualan (Sales Order)</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-salesrequest" onclick="menuselect(\'penjualan-salesrequest\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Request Approval Penjualan</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Additional</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-pengunjung"  onclick="menuselect(\'penjualan-pengunjung\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Data Pengunjung</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-file"  onclick="menuselect(\'penjualan-file\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;File Pelanggan</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Report</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-report-item-category"  onclick="menuselect(\'penjualan-report-item-category\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Report Sales Item Kategori</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-report-item-vendor"  onclick="menuselect(\'penjualan-report-item-vendor\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Report Sales Item Vendor</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-report-payment"  onclick="menuselect(\'penjualan-report-payment\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Report Sales Payment</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="penjualan-report-periode"  onclick="menuselect(\'penjualan-report-periode\',\'menu-penjualan\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Report Sales Periode</span></div>
									</a>
								</li>
							</ul>
						</li>
						
						<!-- PEMBELIAN -->
						<li>
							<a class="collapsed header-collapse" name="menu-pembelian" href="#pembelian" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-luggage-cart"  data-bs-toggle="tooltip" data-bs-placement="right" title="Pembelian"></i>
								<div class="text-span"><span>&nbsp;Pembelian</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="pembelian">
								<li>
									<a class="text-menu-side" name="pembelian-povendor"  onclick="menuselect(\'pembelian-povendor\',\'menu-pembelian\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;PO Vendor</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="pembelian-grpovendor"  onclick="menuselect(\'pembelian-grpovendor\',\'menu-pembelian\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;GRPO Vendor</span></div>
									</a>
								</li>
							</ul>
						</li> 
						<!-- INVENTORY -->
						<li>
							<a class="collapsed header-collapse" name="menu-inventory" href="#inventori" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-warehouse" data-bs-toggle="tooltip" data-bs-placement="right" title="Inventory"></i>
								<div class="text-span"><span>&nbsp;Inventori</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="inventori">
								<li>
									<a class="text-menu-side" name="inventory-transin"  onclick="menuselect(\'inventory-transin\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Terima Barang</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="inventory-transout"  onclick="menuselect(\'inventory-transout\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Kirim Barang</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Additional</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="inventory-waste"  onclick="menuselect(\'inventory-waste\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Barang Rusak</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="inventory-sampel"  onclick="menuselect(\'inventory-sampel\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Barang Sampel</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Produksi</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="inventory-Produksi"  onclick="menuselect(\'inventory-Produksi\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Produksi</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Hasil Akhir</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="inventory-stock"  onclick="menuselect(\'inventory-stock\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Stok Barang</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="inventory-stockopname"  onclick="menuselect(\'inventory-stockopname\',\'menu-inventory\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Stok Opname</span></div>
									</a>
								</li>
							</ul>
						</li>
						
						<!-- PENGIRIMAN -->
						<li>
							<a class="collapsed header-collapse" name="menu-pengiriman" href="#pengiriman" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-truck" data-bs-toggle="tooltip" data-bs-placement="right" title="Pengiriman"></i>
								<div class="text-span"><span>&nbsp;Pengiriman</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="pengiriman">
								<li>
									<a class="text-menu-side" name="pengiriman-list"  onclick="menuselect(\'pengiriman-list\',\'menu-pengiriman\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Daftar pengiriman</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="pengiriman-progress"  onclick="menuselect(\'pengiriman-progress\',\'menu-pengiriman\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Sedang Progress</span></div>
									</a>
								</li>
							</ul>
						</li>

						<!-- ABSENSI -->
						<li>
							<a class="collapsed header-collapse" name="menu-absensi" href="#absensi" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-users" data-bs-toggle="tooltip" data-bs-placement="right" title="Absensi"></i>
								<div class="text-span"><span>&nbsp;Absensi</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="absensi">
								<li>
									<a class="text-menu-side" name="absensi-log"  onclick="menuselect(\'absensi-log\',\'menu-absensi\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Catatan Absen</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Schedule</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="absensi-listroster"  onclick="menuselect(\'absensi-listroster\',\'menu-absensi\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;List Roster</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="absensi-roster"  onclick="menuselect(\'absensi-roster\',\'menu-absensi\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Schedule/Roster</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Pengelolaan</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="absensi-izinsakit"  onclick="menuselect(\'absensi-izinsakit\',\'menu-absensi\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Keterangan Izin/Sakit</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="absensi-Lemburan"  onclick="menuselect(\'absensi-Lemburan\',\'menu-absensi\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Keterangan Lemburan</span></div>
									</a>
								</li>
								<li class="divider">
									<span style="font-size:12px">&nbsp;Pengelolaan</span></div>
								</li>
								<li>
									<a class="text-menu-side" name="absensi-Proses"  onclick="menuselect(\'absensi-Proses\',\'menu-absensi\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Proses Absen Karyawan</span></div>
									</a>
								</li>
							</ul>
						</li>

						
						<!-- TOOLS -->
						<li>
							<a class="collapsed header-collapse" name="menu-tools" href="#tools" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
								<i class="fas fa-briefcase" data-bs-toggle="tooltip" data-bs-placement="right" title="tools"></i>
								<div class="text-span"><span>&nbsp;Tools</span></div>
							</a>
							<ul class="treeview-menu ps-0 collapse" id="tools">
								<li>
									<a class="text-menu-side" name="tools-qr-code"  onclick="menuselect(\'tools-qr-code\',\'menu-tools\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Visit QR Code</span></div>
									</a>
								</li>
								<li>
									<a class="text-menu-side" name="tools-timeline-project"  onclick="menuselect(\'tools-timeline-project\',\'menu-tools\')">
										<i class="far fa-circle"></i> 
										<div class="text-span"><span>&nbsp;Visit Timeline Project</span></div>
									</a>
								</li>
							</ul>
						</li>
					</ul>
					<script>
						$("[data-bs-toggle=\'tooltip\']").tooltip()
					</script>';
				break;
			default:
				echo "";
		}
	}

	public function get_side_menu(){
		
		$menu = $this->db->where("MenuParent",0)->get("TblMenuObi")->result();
		$menuhtml = "<ul>";
		foreach($menu as $row){
			// VALIDASI MENU LIST DENGAN USERMODE
			$datauser = $this->db
				->join("TblMenuListing","TblMenuListing.MenuListingId=TblMenuListingDetail.MenuListingId")
				->where("MenuId",$row->MenuId)
				->where("MenuListingName",$this->session->userdata("login_mode"))
				->get("TblMenuListingDetail")->row();
			if(isset($datauser)){
				if($datauser->MenuListingDetailStatus==1){
					$count = $this->db->where("MenuParent",$row->MenuId)->get("TblMenuObi")->num_rows();
					if($count == 0){
						$menuhtml .= '<!-- '.$row->MenuText.' -->';
						$menuhtml .= '<li>';
						$menuhtml .= '	<a class="text-menu-side" name="menu-'.strtolower(str_replace(" ","-",$row->MenuText)).'" onclick="menuselect('.$row->MenuId.',\'menu-'.strtolower(str_replace(" ","-",$row->MenuText)).'\',\'-\')">
											'.$row->MenuIcon.'
											<div class="text-span"><span>&nbsp;'.$row->MenuText.'</span></div>
										</a>';
						$menuhtml .= '</li>';
					}else{
						
						$submenu = $this->db->where("MenuParent",$row->MenuId)->order_by("MenuHeader asc")->get("TblMenuObi")->result();
						$menuhtml .= '<!-- '.$row->MenuText.' -->';
						$menuhtml .= '<li>';
						$menuhtml .= '	<a class="text-menu-side" name="menu-'.strtolower(str_replace(" ","-",$row->MenuText)).'" href="#'.strtolower(str_replace(" ","-",$row->MenuText)).'" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
											'.$row->MenuIcon.'
											<div class="text-span"><span>&nbsp;'.$row->MenuText.'</span></div>
										</a> 
										<ul class="treeview-menu ps-0 collapse" id="'.strtolower(str_replace(" ","-",$row->MenuText)).'">'; 
						$lastheader = "";
						foreach($submenu as $rowsub){
							
			// VALIDASI MENU LIST DENGAN USERMODE
							$datauser = $this->db
								->join("TblMenuListing","TblMenuListing.MenuListingId=TblMenuListingDetail.MenuListingId")
								->where("MenuId",$rowsub->MenuId)
								->where("MenuListingName",$this->session->userdata("login_mode"))
								->get("TblMenuListingDetail")->row();
							if(isset($datauser)){
								if($datauser->MenuListingDetailStatus==1){
									if($lastheader != $rowsub->MenuHeader){
										$menuhtml .= '<li class="divider"> <span style="font-size:12px">&nbsp;'.$rowsub->MenuHeader.'</span></div> </li>';
										$lastheader = $rowsub->MenuHeader;
									}
									$menuhtml .= '<li>
													<a class="text-menu-side" name="'.strtolower(str_replace(" ","-",$rowsub->MenuText)).'" onclick="menuselect('.$rowsub->MenuId.',\''.strtolower(str_replace(" ","-",$rowsub->MenuText)).'\',\'menu-'.strtolower(str_replace(" ","-",$row->MenuText)).'\')">
														'.$rowsub->MenuIcon.'
														<div class="text-span"><span>&nbsp;'.$rowsub->MenuText.'</span></div>
													</a>
												</li>';
								}
							} 
		
						}
		
						$menuhtml .= '</ul></li>';
					}
				}
			} 
		}
		$menuhtml .= '</ul>
					<script>
						$("[data-bs-toggle=\'tooltip\']").tooltip()
					</script>';
		echo $menuhtml;
	}

	
	public function get_side_menu_new(){
		
		$menu = $this->db->where("MenuParent",0)->get("TblMenuObi")->result();
		$menuhtml = "";
		foreach($menu as $row){
			// VALIDASI MENU LIST DENGAN USERMODE
			$datauser = $this->db
				->join("TblMenuListing","TblMenuListing.MenuListingId=TblMenuListingDetail.MenuListingId")
				->where("MenuId",$row->MenuId)
				->where("MenuListingName",$this->session->userdata("login_mode"))
				->get("TblMenuListingDetail")->row();
			if(isset($datauser)){
				if($datauser->MenuListingDetailStatus==1){
					$count = $this->db->where("MenuParent",$row->MenuId)->get("TblMenuObi")->num_rows();
					if($count == 0){
						$menuhtml .= '<!-- '.$row->MenuText.' -->';
						$menuhtml .= '<li>';
						$menuhtml .= '	<a class="d-flex align-items-center text-decoration-none" name="menu-'.strtolower(str_replace(" ","-",$row->MenuText)).'" onclick="menuselect('.$row->MenuId.',\'menu-'.strtolower(str_replace(" ","-",$row->MenuText)).'\',\'-\')">
											'.$row->MenuIcon.'
											<span>'.$row->MenuText.'</span>
										</a>';
						$menuhtml .= '</li>';
					}else{
						
						$submenu = $this->db->where("MenuParent",$row->MenuId)->order_by("MenuHeader asc")->get("TblMenuObi")->result();
						$menuhtml .= '<!-- '.$row->MenuText.' -->';
						$menuhtml .= '<li >';
						$menuhtml .= '	<a class="d-flex align-items-center text-decoration-none drop collapsed" name="menu-'.strtolower(str_replace(" ","-",$row->MenuText)).'" href="#'.strtolower(str_replace(" ","-",$row->MenuText)).'" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
											'.$row->MenuIcon.'
											<span>&nbsp;'.$row->MenuText.'</span>
										</a> 
										<ul class="treeview-menu collapse" id="'.strtolower(str_replace(" ","-",$row->MenuText)).'">'; 
						$lastheader = "";
						foreach($submenu as $rowsub){
							
							// VALIDASI MENU LIST DENGAN USERMODE
							$datauser = $this->db
								->join("TblMenuListing","TblMenuListing.MenuListingId=TblMenuListingDetail.MenuListingId")
								->where("MenuId",$rowsub->MenuId)
								->where("MenuListingName",$this->session->userdata("login_mode"))
								->get("TblMenuListingDetail")->row();
							if(isset($datauser)){
								if($datauser->MenuListingDetailStatus==1){
									if($lastheader != $rowsub->MenuHeader){
										$menuhtml .= '<li class="divider"> <span>'.substr($rowsub->MenuHeader,3).'</span></li>';
										$lastheader = $rowsub->MenuHeader;
									}
									$menuhtml .= '<li>
													<a class="text-menu-side" name="'.strtolower(str_replace(" ","-",$rowsub->MenuText)).'" onclick="menuselect('.$rowsub->MenuId.',\''.strtolower(str_replace(" ","-",$rowsub->MenuText)).'\',\'menu-'.strtolower(str_replace(" ","-",$row->MenuText)).'\')">
														<span>'.$rowsub->MenuText.'</span>
													</a>
												</li>';
								}
							} 
		
						}
		
						$menuhtml .= '</ul></li>';
					}
				}
			} 
		}
		$menuhtml .= ' 
					<script>
						$("[data-bs-toggle=\'tooltip\']").tooltip()
					</script>';
		echo $menuhtml;
	}
	public function get_employee()
	{
		$query = $this->db->query("SELECT * FROM TblMsEmployee where MsEmpIsActive='0'");
		$json = array();
		foreach ($query->result() as $row) {
			$sess_array = array(
				'MsEmpId' => $row->MsEmpId,
				'MsEmpCode' => $row->MsEmpCode,
				'MsEmpName' => $row->MsEmpName,
				'MsEmpPositionId' => $row->MsEmpPositionId,
				'MsEmpPass' => $row->MsEmpPass,
				'MsWorkplaceId' => $row->MsWorkplaceId,
				'MsEmpImage' => $this->model_app->get_base_64_by_id($row->MsEmpCode),
				'MsEmpLastLogin' => $row->MsEmpLastLogin,
			);
			array_push($json, $sess_array);
		}
		header('Content-type: application/json');
		echo json_encode($json);
	}

	public function get_dashboard_category($toko, $tahun)
	{

		$query = $this->db->query("CALL grafik_penjualan_category('{$toko}','{$tahun}')");
		$data =  $query->result();
		$this->db->close();
		$header = array();
		$row = array();
		//
		//print_r($data);
		foreach ($data as $index => $key) {
			$header = array();
			$rows = array();
			foreach ($key as $index1 => $key1) {
				array_push($header, $index1);
				array_push($rows, (is_numeric($key1) ? (float)$key1 : $key1));
			}
			array_push($row, $rows);
		}
		$data = array_merge(array($header), $row);
		header('Content-type: application/json');
		echo json_encode($data);
		//echo json_encode($row);

		//$dataarray = json_decode($data_table,true);
		//echo $dataarray;

	}

	public function get_dashboard_vendor($toko, $tahun)
	{

		$query = $this->db->query("CALL grafik_penjualan_vendor('{$toko}','{$tahun}')");
		$data =  $query->result();
		$this->db->close();
		$header = array();
		$row = array();
		//
		//print_r($data);
		foreach ($data as $index => $key) {
			$header = array();
			$rows = array();
			foreach ($key as $index1 => $key1) {
				array_push($header, $index1);
				array_push($rows, (is_numeric($key1) ? (float)$key1 : $key1));
			}
			array_push($row, $rows);
		}
		$data = array_merge(array($header), $row);
		header('Content-type: application/json');
		echo json_encode($data);
		//echo json_encode($row);

		//$dataarray = json_decode($data_table,true);
		//echo $dataarray;

	}

	public function get_dashboard_sales($toko)
	{
		$data = array();
		$this->db->where('MsWorkplaceId', $toko);
		$this->db->where('SalesStatus', '0');
		$result = $this->db->get('TblSales')->num_rows();
		$this->db->close();
		array_push($data, array("sales" => $result));

		$this->db->where('MsWorkplaceId', $toko);
		$this->db->where('SalesStatus!=0');
		$this->db->where('SalesStatusPayment<2');
		$result = $this->db->get('TblSales')->num_rows();
		$this->db->close();
		array_push($data, array("payment" => $result));

		$this->db->where('MsWorkplaceId', $toko);
		$this->db->where('SalesStatus!=0');
		$this->db->where('SalesStatusDelivery<2');
		$result = $this->db->get('TblSales')->num_rows();
		$this->db->close();
		array_push($data, array("delivery" => $result));

		$this->db->where('MsWorkplaceId', $toko);
		$this->db->where_not('SalesStatus', '0');
		$this->db->where('SalesStatusPO<2');
		$result = $this->db->get('TblSales')->num_rows();
		$this->db->close();
		array_push($data, array("po" => $result));

		echo JSON_ENCODE($data);
	}

	public function get_notification()
	{
		$jsonencode = $this->db->where("NotifId >", $this->input->post("NotifId"))->where("MsEmpId", $this->session->userdata("MsEmpId"))->limit(10)->get("TblNotification")->result();
		$notif = $this->db->select("count(NotifId) as count")->where("NotifRead", 0)->where("MsEmpId", $this->session->userdata("MsEmpId"))->get("TblNotification")->row();
		header('Content-type: application/json');
		$data = array(
			"detail" => $jsonencode,
			"count" => $notif->count
		);
		echo json_encode($data);
	}
	
	public function update_notification($id)
	{
		$this->db->update("TblNotification", array("NotifRead" => 1), array("NotifId" => $id));
	}

	public function dateserver(){
		echo date("Y/m/d H:i:s");
	}
}
