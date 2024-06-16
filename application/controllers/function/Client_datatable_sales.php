<?php
defined('BASEPATH') or exit('No direct script access allowed');
ini_set('max_execution_time', 0);
class Client_datatable_sales extends CI_Controller
{
      function __construct()
      {
            parent::__construct();
            $this->load->model('penjualan/Model_penjualan', 'm_penjualan');
            $this->load->model('model_app');
            $this->load->helper('directory');
            $this->load->library('image_lib');

            date_default_timezone_set('Asia/Jakarta');
      }

      function get_data_quotation()
      {
            // SETUP DATATABLE
            $this->m_penjualan->table = 'TblQuotation';
            $this->m_penjualan->tablejoin = array(
                  array(0 => 'TblQuoDetail', 1 => 'TblQuotation.QuoCode=TblQuoDetail.QuoDetailRef'),
                  array(0 => 'TblQuoOptional', 1 => 'TblQuotation.QuoCode=TblQuoOptional.QuoOptionalRef'),
                  array(0 => 'TblMsProduk', 1 => 'TblMsProduk.MsProdukId=TblQuoDetail.MsProdukId'),
                  array(0 => 'TblMsCustomer', 1 => 'TblQuotation.MsCustomerId=TblMsCustomer.MsCustomerId'),
                  array(0 => 'TblMsCustomerDelivery', 1 => 'TblQuotation.MsCustomerDeliveryId=TblMsCustomerDelivery.MsCustomerDeliveryId'),
                  array(0 => 'TblMsEmployee', 1 => 'TblMsEmployee.MsEmpId=TblQuotation.MsEmpId'),
            );
            $this->m_penjualan->column_search = array(
                  'TblMsCustomer.MsCustomerCode',
                  'MsCustomerName',
                  'MsCustomerCompany',
                  'MsCustomerAddress',
                  "MsCustomerDeliveryAddress",
                  'QuoCode',
                  'MsProdukCode',
                  'MsProdukName'
            ); //set column field database for datatable searchable 
            //$this->m_penjualan->order = array('QuoDate' => 'DESC', 'QuoId' => 'DESC'); // default order 
            $this->m_penjualan->group = array('QuoCode');
            $this->m_penjualan->order = array('QuoDate' => 'DESC', 'QuoId' => 'DESC'); // default order  
            // PROSES DATA
            $list = $this->m_penjualan->get_datatables();
            $data = array();
            $no = $_POST['start'];
            $img = 1;
            $date = "";
            foreach ($list as $master) {

                  $customer = ($master->MsCustomerTypeId == 1 ? $master->MsCustomerName : $master->MsCustomerName . ' (' . $master->MsCustomerCompany . ')');
                  $customertelp = (($master->MsCustomerTelp2 == "" || $master->MsCustomerTelp2 == "-") ? $master->MsCustomerTelp1 : $master->MsCustomerTelp1 . " / " . $master->MsCustomerTelp2);
                  if ($master->QuoStatus == 0) {
                        $status = '<span class="text-info"><i class="fas fa-stopwatch"></i>&nbsp;Menunggu</span>';
                        $actionmenu = '  
                        <button class="btn btn-primary btn-sm py-1 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                              Tindakan
                        </button>
                        <ul class="dropdown-menu dropdown-menu-sm w-16rem" >
                              <li><a class="dropdown-item" onclick="quo_change_header(\'' . $master->QuoId . '\',\'' . $master->QuoHeader . '\')"><i class="fas fa-copyright" style="min-width:20px"></i>&nbsp;Ganti Header/Logo</a></li>
                              <li><hr class="dropdown-divider"></li>
                              <li><a class="dropdown-item" onclick="quo_edit_data(\'' . $master->QuoId . '\')"><i class="fas fa-pencil-alt"  style="min-width:20px"></i>&nbsp;Edit Data</a></li>
                              <li><a class="dropdown-item" onclick="quo_delete_data(\'' . $master->QuoId . '\')"><i class="fas fa-times"  style="min-width:20px"></i>&nbsp;Batalkan Data</a></li>
                              <li><a class="dropdown-item" onclick="quo_print_data(\'' . $master->QuoId . '\')"><i class="fas fa-print"  style="min-width:20px"></i>&nbsp;Export atau Print Data</a></li> 
                        </ul>';
                  } elseif ($master->QuoStatus == 1) {
                        $status = '<span class="text-success"><i class="fas fa-check-circle "></i>&nbsp;Selesai</span>';
                        $actionmenu = '   
                        <button class="btn btn-primary btn-sm py-1 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                              Tindakan
                        </button>
                        <ul class="dropdown-menu dropdown-menu-sm w-16rem" >
                              <li><a class="dropdown-item" onclick="quo_print_data(\'' . $master->QuoId . '\')"><i class="fas fa-print"  style="min-width:20px"></i>&nbsp;Export atau Print Data</a></li>
                              <li><hr class="dropdown-divider"></li>
                              <li><a class="dropdown-item" onclick="quo_forward_data(\'' . $master->QuoId . '\')"><i class="fas fa-level-up-alt"  style="min-width:20px"></i>&nbsp;Lihat Sales Order</a></li>
                        </ul>';
                  } elseif ($master->QuoStatus == 2) {
                        $status = '<span class="text-danger"><i class="fas fa-times-circle "></i>&nbsp;Dibatalkan</span>';
                        $actionmenu = '';
                  }
                  if (isset($_POST['search']['mode'])) {
                        $actionmenu = '
                        <button class="btn btn-success btn-sm py-1" type="button" onclick="quo_select(\'' . $master->QuoId . '\')">
                              pilih data ini
                        </button>';
                  } 
                  /* ------------------    Mengambil data Item -----------------*/
                  $totaldiscitem = 0;
                  $item = ""; 
                  $query = $this->db->join("TblMsProduk","TblMsProduk.MsProdukId=TblQuoDetail.MsProdukId") 
                  ->join("TblMsProdukSatuan","TblMsProdukSatuan.SatuanId=TblQuoDetail.SatuanId")->where("QuoDetailRef",$master->QuoCode)->get("TblQuoDetail")->result();

                  foreach ($query as $row) {
                        if ($row->QuoDetailDiscTypeAll == 1) {
                              $totaldiscitem += $row->QuoDetailDisc * $row->QuoDetailQty;
                              $price = '  <span class="strikethrough">
                                                <span class="fw-bold" style="color: gray;font-size:0.7rem;">Rp. ' . number_format($row->QuoDetailPrice) . '</span>
                                                <span style="color: gray;font-size:0.7rem;">/' . $row->SatuanName . '</span>
                                          </span>&nbsp;
                                          <span class="fw-bold" style="color: gray;font-size:0.7rem;">Rp. ' . number_format($row->QuoDetailPrice - $row->QuoDetailDisc) . '</span>
                                          <span style="color: gray;font-size:0.7rem;">/' . $row->SatuanName . '</span>
                                          <br>';
                              $total = '  <span class="strikethrough">
                                                <span class="fw-bold" style="color: gray;font-size:0.7rem;">Rp. ' . number_format($row->QuoDetailQty * $row->QuoDetailPrice) . '</span>
                                          </span><br>
                                          <span class="fw-bold text-orange" style="font-size:0.7rem;">Rp. ' . number_format($row->QuoDetailTotal) . '</span>
                                          <br>';
                        }elseif($row->QuoDetailDiscTypeAll == 2){       
                              $totaldiscitem += $row->QuoDetailDiscTotal; 
                              $price = '  <span class="fw-bold" style="color: gray;font-size:0.7rem;">Rp. ' . number_format($row->QuoDetailPrice) . '</span>
                              <span style="color: gray;font-size:0.7rem;">/' . $row->SatuanName . '</span><br>';
                              $total = '  <span class="strikethrough">
                                                <span class="fw-bold" style="color: gray;font-size:0.7rem;">Rp. ' . number_format($row->QuoDetailQty * $row->QuoDetailPrice) . '</span>
                                          </span><br>
                                          <span class="fw-bold text-orange" style="font-size:0.7rem;">Rp. ' . number_format($row->QuoDetailTotal) . '</span>
                                          <br>';
                        } else {
                              $price = '  <span class="fw-bold" style="color: gray;font-size:0.7rem;">Rp. ' . number_format($row->QuoDetailPrice) . '</span>
                                          <span style="color: gray;font-size:0.7rem;">/' . $row->SatuanName . '</span><br>';
                              $total = '  <span class="fw-bold text-orange" style="font-size:0.7rem;">Rp. ' . number_format($row->QuoDetailTotal) . '</span>
                                          <br>';
                        }
                        $item .= '<div class="row py-1 g-2">
                                    <div class="col-md-4 col-12 ps-md-4">
                                          <span class="fw-bold" style="font-size:0.7rem;">' . $row->MsProdukCode . ' - ' . $row->MsProdukName . ' </span><br>
                                          ' . $price . '
                                    </div>
                                    <div class="col-md-3 col-8 px-md-2 mt-0 mt-md-1">';
                                   // $item .= $row->QuoDetailVarian;
                                    $varian =  JSON_DECODE($row->QuoDetailVarian); 
                                    foreach ($varian as $x => $y) {  
                                          $item .= '  <div class="row">
                                                            <div class="col-auto pe-0" style="min-width:70px;">
                                                                  <span class="fw-bold text-secondary">'.$x.'</span>
                                                            </div>      
                                                            <div class="col pe-0">
                                                                  <span class="text-dark fw-bold">'.$y.'</span>
                                                            </div>
                                                      </div>';
                                    }
                                         
                                         
                                   // foreach($data_split_var as $row1){
                              //           
                                    //} 
                        $item .= '</div>
                                    <div class="col-md-2 col-4">
                                          <span class="fw-bold text-secondary">Qty</span><br>
                                          <span class="text-dark fw-bold" style="font-size:0.9rem;">' . number_format($row->QuoDetailQty, 2) . ' ' . $row->SatuanName . '</span>
                                    </div>
                                    <div class="col-md-auto col-4 px-md-4 mt-0 mt-md-1">
                                          <span style="color: gray;">Total Transaksi</span><br>
                                          ' . $total . '
                                    </div>
                              </div> ';
                  }
                  if (strlen($item) == 0) $item = "<div class='text-center'>Tidak Ada Data</div>";

                  /* ------------------    Mengambil data Optional -----------------*/
                  $optional = "";
                  $query = $this->db->query("select * from TblQuoOptional where QuoOptionalRef='" . $master->QuoCode . "'")->result();
                  foreach ($query as $row) {
                        $optional .= '    <div class="row py-1 g-2">
                                                <div class="col-md-9 col-8  ps-md-4">
                                                <span style="color: gray;">Deskripsi</span><br>
                                                      <span class="fw-bold" style="font-size:0.7rem;">' . $row->QuoOptionalDesc . ' </span>
                                                </div>
                                                <div class="col-md-3 col-4">
                                                      <span style="color: gray;">Total Transaksi</span><br>
                                                      <span class="fw-bold text-orange">Rp. ' . number_format($row->QuoOptionalPrice) . '</span>
                                                </div>
                                          </div> ';
                  }
                  if (strlen($optional) != 0) {
                        $optional = "<hr class='my-0'>" . $optional;
                  }

                  /* ------------------    Mengambil data Pengiriman -----------------*/
                  $delivery = "";
                  if ($master->QuoDelStatus == 0) {
                        $delivery = "<div class='text-center'>Tidak Ada Data</div>";
                  } else {
                        $del = $this->db->where("MsCustomerDeliveryId", $master->MsCustomerDeliveryId)->get("TblMsCustomerDelivery");
                        if ($del->num_rows() > 0) {
                              $del = $del->row();
                              $delivery = '<div class="row py-1 g-2">
                                          <div class="col-md-2 col-4 ps-md-4">
                                                <span style="color: gray;">Service</span><br>
                                                <span class="fw-bold" style="font-size:0.7rem;">' . $this->model_app->get_single_data("MsDeliveryName", "TblMsDelivery", array("MsDeliveryId" => $master->QuoDelService)) . ' </span>
                                          </div>
                                          <div class="col-md-2 col-4">
                                                <span style="color: gray;">Penerima</span><br>
                                                <span class="fw-bold" style="font-size:0.7rem;">' . $del->MsCustomerDeliveryReceive . ' </span>
                                          </div>
                                          <div class="col-md-2 col-4">
                                                <span style="color: gray;">Telp</span><br>
                                                <span class="fw-bold" style="font-size:0.7rem;">' . $del->MsCustomerDeliveryTelp . ' </span>
                                          </div>
                                          <div class="col-md-6 col-12">
                                                <span style="color: gray;">Alamat</span><br>
                                                <span class="fw-bold" style="font-size:0.7rem;">' . $del->MsCustomerDeliveryAddress . ' </span>
                                          </div>
                                    </div> ';
                        } else {
                              $delivery = '';
                        }
                  }

                  if ($date != $master->QuoDate) {
                        $date = $master->QuoDate;
                        $datetext = '<div class="flex bg-light my-2">
                        <span class="fw-bold">' . date_format(date_create($master->QuoDate), "d F Y") . '</span></div>';
                  } else {
                        $datetext = "";
                  }
                  $html_tooltip_payment = '<span class=\'tool-desc\'>Dibuat oleh : <br>' . $master->QuoCreateUser . ' <br>(' . $master->QuoCreate . ')</span><br>
                  <span class=\'tool-desc\'>Terakhir Diubah : <br>' . $master->QuoLastUpdateUser . ' <br>(' . $master->QuoLastUpdate . ')</span><br>';
                  $row = array();
                  $row[] = $datetext . '<div class="row datatable-header">
                              <div class="col-md-5 col-sm-12 p-1 g-1 " >
                                    <div class="row align-items-center">
                                          <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                <img src="' . base_url("asset/image/logo/logo-") . $master->QuoHeader . '-200.png" class="rounded" width="40">
                                          </div>      
                                          <div class="col pe-0">
                                                <span class="fw-bold text-orange" style="font-size:11px;">' . $master->QuoCode . '</span>
                                                <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_payment . '"></i>
                                          </div>
                                    </div>
                                    <div class="row">
                                          <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                          </div>      
                                          <div class="col pe-0">
                                                <span class="text-dark text-uppercase" style="font-size:12px;">' . $customer . '</span>
                                          </div>
                                    </div>
                                    <div class="row">
                                          <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                                          </div>      
                                          <div class="col pe-0">
                                                <span class="text-dark text-uppercase" style="font-size:12px;">' . $customertelp . '</span>
                                          </div>
                                    </div>
                                    <div class="row">
                                          <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                                          </div>      
                                          <div class="col pe-0">
                                                <span class="text-dark" style="font-size:12px;">' . $master->MsCustomerAddress . '</span>
                                          </div>
                                    </div>
                              </div>
                              <div class="col-md-3 col-sm-6 p-1 g-1" >
                                    <div class="row">
                                          <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-calendar-alt"></i></span>
                                          </div>      
                                          <div class="col pe-0">
                                                <span class="text-dark" style="font-size:12px;">' . date_format(date_create($master->QuoDate), "d F Y") . '</span>
                                          </div>
                                    </div>
                                    <div class="row">
                                          <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-user-tie"></i></span>
                                          </div>      
                                          <div class="col pe-0">
                                                <span class="text-dark" style="font-size:12px;">' .  $master->MsEmpName . '</span>
                                          </div>
                                    </div>
                                    <div class="row">
                                          <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                <span class="text-secondary" style="font-size:12px;"><i class="fas fa-exclamation-circle"></i></span>
                                          </div>      
                                          <div class="col pe-0">
                                                <span class="text-dark" style="font-size:12px;">' . $status . '</span>
                                          </div>
                                    </div>
                              </div>
                              <div class="col-md-4 col-sm-6 g-1" >
                                    <div class="box-in-table p-1 "> 
                                          <div class="row border-bottom border-secondary mx-2">
                                                <div class="col-auto pe-0 ps-0" style="min-width:70px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">Disc Item&nbsp;<i class="far fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Disc item sudah terhitung dalam sub total"></i></span>
                                                </div>      
                                                <div class="col-auto px-0" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                </div>      
                                                <div class="col text-end pe-0">
                                                      <span class="fw-bold text-dark" style="font-size:12px;">' . number_format($totaldiscitem) . '</span>
                                                </div>      
                                          </div>
                                          <div class="row mx-2">
                                                <div class="col-auto pe-0 ps-0" style="min-width:70px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">Sub Total</span>
                                                </div>      
                                                <div class="col-auto px-0" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                </div>      
                                                <div class="col text-end pe-0">
                                                      <span class="fw-bold text-dark" style="font-size:12px;">' . number_format($master->QuoSubTotal) . '</span>
                                                </div>      
                                          </div>
                                          <div class="row mx-2">
                                                <div class="col-auto pe-0 ps-0" style="min-width:70px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">Pengiriman</span>
                                                </div>      
                                                <div class="col-auto px-0" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                </div>      
                                                <div class="col text-end pe-0">
                                                      <span class="fw-bold text-dark" style="font-size:12px;">' . number_format($master->QuoDeliveryTotal) . '</span>
                                                </div>      
                                          </div>
                                          <div class="row mx-2">
                                                <div class="col-auto pe-0 ps-0" style="min-width:70px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">Diskon</span>
                                                </div>      
                                                <div class="col-auto px-0" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                </div>      
                                                <div class="col text-end pe-0">
                                                      <span class="fw-bold text-dark" style="font-size:12px;">' . number_format($master->QuoDiscTotal) . '</span>
                                                </div>      
                                          </div>
                                          <div class="row mx-2">
                                                <div class="col-auto pe-0 ps-0" style="min-width:70px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">Grand Total</span>
                                                </div>      
                                                <div class="col-auto px-0" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                </div>      
                                                <div class="col text-end pe-0">
                                                      <span class="fw-bold text-dark" style="font-size:12px;">' . number_format($master->QuoGrandTotal) . '</span>
                                                </div>      
                                          </div> 
                                    </div>
                              </div>  
                              <div class="col-12 g-1">
                                    <ul class="nav nav-tabs" role="tablist">
                                          <li class="nav-item" role="presentation">
                                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#detail-item-' . $master->QuoId . '" type="button" role="tab" aria-controls="detail-item-' . $master->QuoId . '" aria-selected="true">Detail Item</button>
                                          </li>
                                          <li class="nav-item" role="presentation">
                                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#detail-delivery-' . $master->QuoId . '" type="button" role="tab" aria-controls="detail-delivery-' . $master->QuoId . '" aria-selected="false">Pengiriman</button>
                                          </li>  
                                    </ul>
                                    <div class="tab-content" >
                                          <div class="tab-pane p-2 border border-top-0 fade show active" id="detail-item-' . $master->QuoId . '"" role="tabpanel" aria-labelledby="detail-item-' . $master->QuoId . '">
                                                ' . $item . '
                                                ' . $optional . '
                                          </div>
                                          <div class="tab-pane p-2 border border-top-0 fade" id="detail-delivery-' . $master->QuoId . '"" role="tabpanel" aria-labelledby="detail-delivery-' . $master->QuoId . '">
                                                ' . $delivery . '
                                          </div>
                                    </div>
                              </div> 
                              <div class="datatable-action py-2 mt-1"> 
                                    <div class="dropdown float-end dropup">' . $actionmenu . ' 
                                    </div>
                              </div>
                              <script>
                                    $("[data-bs-toggle=\'tooltip\']").tooltip()
                              </script>
                        </div>';
                  $row[] = $master->QuoId;
                  $data[] = $row;
                  if ($img > 5) {
                        $img = 1;
                  } else {
                        $img++;
                  };
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->m_penjualan->count_all(),
                  "recordsFiltered" => $this->m_penjualan->count_filtered(),
                  "data" => $data,
            );
            //output to json format
            echo json_encode($output);
      }

      function get_data_sales_old()
      {
            // SETUP DATATABLE
            $this->m_penjualan->table = 'TblSales';
            $this->m_penjualan->tablejoin = array(
                  array(0 => 'TblSalesDetail', 1 => 'TblSales.SalesCode=TblSalesDetail.SalesDetailRef'),
                  array(0 => 'TblSalesOptional', 1 => 'TblSales.SalesCode=TblSalesOptional.SalesOptionalRef'),
                  array(0 => 'TblMsProduk', 1 => 'TblMsProduk.MsProdukId=TblSalesDetail.MsItemId'),
                  array(0 => 'TblMsCustomer', 1 => 'TblSales.MsCustomerId=TblMsCustomer.MsCustomerId'),
            );
            $this->m_penjualan->column_search = array(
                  'TblMsCustomer.MsCustomerCode',
                  'MsCustomerName',
                  'MsCustomerCompany',
                  'MsCustomerAddress',
                  'SalesCode',
                  'MsProdukCode',
                  'MsProdukName'
            ); //set column field database for datatable searchable 
            $this->m_penjualan->order = array('SalesDate' => 'DESC', 'SalesId' => 'DESC'); // default order 
            $this->m_penjualan->group = array('SalesCode');
            // PROSES DATA
            $list = $this->m_penjualan->get_datatables();
            $data = array();
            $this->m_penjualan->select = array(
                  "SalesCode",
                  "MsCustomerTypeId",
                  "MsCustomerName",
                  "MsCustomerCompany",
                  "MsCustomerTelp1",
                  "MsCustomerTelp2",
                  "SalesStatusPayment",
                  "SalesStatusDelivery",
                  "SalesDelStatus",
                  "SalesDate",
                  "SalesHeader",
                  "MsCustomerAddress",
                  "MsEmpId",
                  "SalesSubTotal",
                  "SalesDeliveryTotal",
                  "SalesDiscTotal",
                  "SalesGrandTotal",
                  "SalesId",
            );
            $date = "";
            foreach ($list as $master) {
                  /* -------------------------------------- GET CUSTOMER ------------------------------*/
                  $sales_customer = ($master->MsCustomerTypeId == 1 ? $master->MsCustomerName : $master->MsCustomerName . ' (' . $master->MsCustomerCompany . ')');
                  $sales_telp = (($master->MsCustomerTelp2 == "" || $master->MsCustomerTelp2 == "-") ? $master->MsCustomerTelp1 : $master->MsCustomerTelp1 . " / " . $master->MsCustomerTelp2);
                  /* ----------------------------------------------------------------------------------*/

                  /* -------------------------------------- SET STATUS --------------------------------*/
                  $sales_date_tempo = "";
                  $html_tooltip_payment = '
                        <span class=\'fa-stack text-secondary tool-info\'>
                              <i class=\'far fa-circle fa-stack-2x\'></i>
                              <i class=\'fas fa-dollar-sign fa-stack-1x\'></i>
                        </span>
                        <span class=\'tool-desc\'>Belum Lunas</span><br>
                        <span class=\'fa-stack text-primary tool-info\'>
                              <i class=\'far fa-circle fa-stack-2x\'></i>
                              <i class=\'fas fa-dollar-sign fa-stack-1x\'></i>
                        </span>
                        <span class=\'tool-desc\'>Sudah DP</span><br>
                        <span class=\'fa-stack text-success tool-info\'>
                              <i class=\'far fa-circle fa-stack-2x\'></i>
                              <i class=\'fas fa-dollar-sign fa-stack-1x\'></i>
                        </span>
                        <span class=\'tool-desc\'>Sudah Lunas</span><br>
                        <span class=\'fa-stack text-danger tool-info\'>
                              <i class=\'far fa-circle fa-stack-2x\'></i>
                              <i class=\'fas fa-dollar-sign fa-stack-1x\'></i>
                        </span>
                        <span class=\'tool-desc\'>Dibatalkan</span><br>';

                  if ($master->SalesStatusPayment == 0) {
                        $sales_payment = '
                        <span class="fa-stack text-secondary" style="vertical-align: top;font-size:0.8rem"  data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_payment .
                              '">
                              <i class="far fa-circle fa-stack-2x"></i>
                              <i class="fas fa-dollar-sign fa-stack-1x"></i>
                        </span>';
                        $sales_payment_status = '<div class="tool-desc fw-bold bg-0">Belum Bayar</div>';
                        $sales_date_tempo =
                              '<div class="row me-2"> 
                                    <div class="col pe-0">
                                          <span class="text-danger time-banned fw-bold" style="font-size:12px;" data-date="' . $master->SalesDate . '">'  . date_format(date_create($master->SalesDate), "Y/m/d H:i:s") . '</span>
                                    </div>
                              </div>';
                  } elseif ($master->SalesStatusPayment == 1) {
                        $sales_payment = '
                        <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem"   data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_payment .
                              '">
                              <i class="far fa-circle fa-stack-2x"></i>
                              <i class="fas fa-dollar-sign fa-stack-1x"></i>
                        </span>';
                        $sales_payment_status = '<div class="tool-desc fw-bold bg-1">Sudah DP</div>';
                  } elseif ($master->SalesStatusPayment == 2) {
                        $sales_payment = '
                        <span class="fa-stack text-success" style="vertical-align: top;font-size:0.8rem"  data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_payment .
                              '">
                              <i class="far fa-circle fa-stack-2x"></i>
                              <i class="fas fa-dollar-sign fa-stack-1x"></i>
                        </span>';
                        $sales_payment_status = '<div class="tool-desc fw-bold bg-2">Sudah Lunas</div>';
                  } elseif ($master->SalesStatusPayment == 3) {
                        $sales_payment = '
                        <span class="fa-stack text-danger" style="vertical-align: top;font-size:0.8rem"   data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_payment .
                              '">
                              <i class="far fa-circle fa-stack-2x"></i>
                              <i class="fas fa-dollar-sign fa-stack-1x"></i>
                        </span>';
                        $sales_payment_status = '<div class="tool-desc fw-bold bg-3">Dibatalkan</div>';
                  }
                  $html_tooltip_delivery = '
                        <span class=\'fa-stack text-secondary tool-info\'>
                              <i class=\'far fa-circle fa-stack-2x\'></i>
                              <i class=\'fas fa-truck fa-stack-1x\'></i>
                        </span>
                        <span class=\'tool-desc\'>Belum Dijadwalkan</span><br>

                        <span class=\'fa-stack text-primary tool-info\'>
                              <i class=\'far fa-circle fa-stack-2x\'></i>
                              <i class=\'fas fa-truck fa-stack-1x\'></i>
                        </span>
                        <span class=\'tool-desc\'>Pengiriman</span><br>

                        <span class=\'fa-stack text-success tool-info\'>
                              <i class=\'far fa-circle fa-stack-2x\'></i>
                              <i class=\'fas fa-truck fa-stack-1x\'></i>
                        </span>
                        <span class=\'tool-desc\'>Selesai</span><br>

                        <span class=\'fa-stack text-danger tool-info\'>
                              <i class=\'far fa-circle fa-stack-2x\'></i>
                              <i class=\'fas fa-truck fa-stack-1x\'></i>
                        </span>
                        <span class=\'tool-desc\'>Dibatalkan</span><br>

                        <span class=\'fa-stack text-info tool-info\'>
                              <i class=\'far fa-circle fa-stack-2x\'></i>
                              <i class=\'fas fa-truck fa-stack-1x\'></i>
                        </span>
                        <span class=\'tool-desc\'>Tidak Ada Pengiriman</span><br>';
                  if ($master->SalesStatusDelivery == 0) {
                        $sales_delivery = '
                        <span class="fa-stack text-secondary" style="vertical-align: top;font-size:0.8rem"  data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_delivery . '">
                              <i class="far fa-circle fa-stack-2x"></i>
                              <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                        </span>';
                  } elseif ($master->SalesStatusDelivery == 1) {
                        $sales_delivery = '
                        <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem"   data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_delivery . '">
                              <i class="far fa-circle fa-stack-2x"></i>
                              <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                        </span>';
                  } elseif ($master->SalesStatusDelivery == 2) {
                        $sales_delivery = '
                        <span class="fa-stack text-success" style="vertical-align: top;font-size:0.8rem"   data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_delivery . '">
                              <i class="far fa-circle fa-stack-2x"></i>
                              <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                        </span>';
                  } elseif ($master->SalesStatusDelivery == 3) {
                        $sales_delivery = '
                        <span class="fa-stack text-danger" style="vertical-align: top;font-size:0.8rem"   data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_delivery . '">
                              <i class="far fa-circle fa-stack-2x"></i>
                              <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                        </span>';
                  } elseif ($master->SalesStatusDelivery == 4) {
                        $sales_delivery = '
                        <span class="fa-stack text-info" style="vertical-align: top;font-size:0.8rem"   data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_delivery . '">
                              <i class="far fa-circle fa-stack-2x"></i>
                              <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                        </span>';
                  }
                  $html_tooltip_po = '
                        <span class=\'fa-stack text-secondary tool-info\'>
                              <i class=\'far fa-circle fa-stack-2x\'></i>
                              <i class=\'fas fa-cubes fa-stack-1x\'></i>
                        </span>
                        <span class=\'tool-desc\'>Belum PO</span><br>

                        <span class=\'fa-stack text-primary tool-info\'>
                              <i class=\'far fa-circle fa-stack-2x\'></i>
                              <i class=\'fas fa-cubes fa-stack-1x\'></i>
                        </span>
                        <span class=\'tool-desc\'>Proses Vendor</span><br>

                        <span class=\'fa-stack text-success tool-info\'>
                              <i class=\'far fa-circle fa-stack-2x\'></i>
                              <i class=\'fas fa-cubes fa-stack-1x\'></i>
                        </span>
                        <span class=\'tool-desc\'>Ready</span><br>

                        <span class=\'fa-stack text-danger tool-info\'>
                              <i class=\'far fa-circle fa-stack-2x\'></i>
                              <i class=\'fas fa-cubes fa-stack-1x\'></i>
                        </span>
                        <span class=\'tool-desc\'>Dibatalkan</span><br>';
                  if ($master->SalesStatusPO == 0) {
                        $sales_po = '
                        <span class="fa-stack text-secondary" style="vertical-align: top;font-size:0.8rem"   data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_po . '">
                              <i class="far fa-circle fa-stack-2x"></i>
                              <i class="fas fa-cubes fa-stack-1x"></i>
                        </span>';
                  } elseif ($master->SalesStatusPO == 1) {
                        $sales_po = '
                        <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem"    data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_po . '">
                              <i class="far fa-circle fa-stack-2x"></i>
                              <i class="fas fa-cubes fa-stack-1x"></i>
                        </span>';
                  } elseif ($master->SalesStatusPO == 2) {
                        $sales_po = '
                        <span class="fa-stack text-success" style="vertical-align: top;font-size:0.8rem"   data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_po . '">
                              <i class="far fa-circle fa-stack-2x"></i>
                              <i class="fas fa-cubes fa-stack-1x"></i>
                        </span>';
                  } elseif ($master->SalesStatusPO == 3) {
                        $sales_po = '
                        <span class="fa-stack text-danger" style="vertical-align: top;font-size:0.8rem"   data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_po . '">
                              <i class="far fa-circle fa-stack-2x"></i>
                              <i class="fas fa-cubes fa-stack-1x"></i>
                        </span>';
                  }
                  /* ----------------------------------------------------------------------------------*/

                  /* -------------------------------------- DATA ITEM ---------------------------------*/
                  $totaldiscitem = 0;
                  $item = "";
                  $detail_item = "";
                  $query = $this->db->join("TblMsProduk","TblMsProduk.MsProdukId=TblSalesDetail.MsProdukId") 
                  ->join("TblMsSatuan","TblMsSatuan.SatuanId=TblSalesDetail.SatuanId")->where("SalesDetailRef",$master->SalesCode)->get("TblSalesDetail")->result();
                  foreach ($query as $row) { 
                        $detail_item .= "   " . $row->MsProdukName . " " .  $row->SalesDetailVarian . " (" . number_format($row->SalesDetailQty, 2) . " " . $row->SatuanName . ")\n";
                        if ($row->SalesDetailDiscTypeAll == 1) {
                              $totaldiscitem += $row->SalesDetailDisc * $row->SalesDetailQty;
                              $price = '  <span class="strikethrough">
                                                <span class="fw-bold" style="color: gray;font-size:0.7rem;">Rp. ' . number_format($row->SalesDetailPrice) . '</span>
                                          </span><br>
                                          <span class="fw-bold text-dark" style="font-size:0.9rem;">Rp. ' . number_format($row->SalesDetailPrice - $row->SalesDetailDisc) . '</span> 
                                          <br>';
                              $total = '  <span class="strikethrough">
                                                <span class="fw-bold" style="color: gray;font-size:0.7rem;">Rp. ' . number_format($row->SalesDetailQty * $row->SalesDetailPrice) . '</span>
                                          </span><br>
                                          <span class="fw-bold text-dark" style="font-size:0.9rem;">Rp. ' . number_format($row->SalesDetailTotal) . '</span>
                                          <br>';
                        }elseif($row->SalesDetailDiscTypeAll == 2){       
                              $totaldiscitem += $row->SalesDetailDiscTotal; 
                              $price = '  <span class="fw-bold text-dark" style=" font-size:0.9rem;">Rp. ' . number_format($row->SalesDetailPrice) . '</span><br>';
                              $total = '  <span class="strikethrough">
                                                <span class="fw-bold" style="color: gray; font-size:0.7rem;">Rp. ' . number_format($row->SalesDetailQty * $row->SalesDetailPrice) . '</span>
                                          </span><br>
                                          <span class="fw-bold text-dark" style="font-size:0.9rem;">Rp. ' . number_format($row->SalesDetailTotal) . '</span>
                                          <br>';
                        } else {
                              $price = '  <span class="fw-bold text-dark" style=" font-size:0.9rem;">Rp. ' . number_format($row->SalesDetailPrice) . '</span><br>';
                              $total = '  <span class="fw-bold text-dark" style="font-size:0.9rem;">Rp. ' . number_format($row->SalesDetailTotal) . '</span>
                                          <br>';
                        }
                        if (file_exists(getcwd() . "/asset/image/produk/" .  $row->MsProdukId."/".$row->MsProdukCode."_1.png")) {
                              $urlimage = base_url("asset/image/produk/".$row->MsProdukId."/".$row->MsProdukCode."_1.png");
                        }else{ 
                              $urlimage = base_url("asset/image/mgs-erp/defaultitem.png");
                        }
                        $data_split_var =  explode("|",$row->SalesDetailVarian);
                        $varian = "";
                        foreach($data_split_var as $row1){
                               $data_split_var_row =  explode(":",$row1);
                               $varian .= '  <div class="row">
                                                 <div class="col-auto pe-0" style="min-width:70px;">
                                                       <span class="fw-bold text-secondary">'.$data_split_var_row[0].'</span>
                                                 </div>      
                                                 <div class="col pe-0">
                                                       <span class="text-dark fw-bold">'.$data_split_var_row[1].'</span>
                                                 </div>
                                           </div>';
                        } 
                        $item .= '<div class="row py-1 g-1 align-items-center bg-light">  
                                    <div class="col-md-6 col-12">
                                          <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                      <img class="lazy" style="width: 5rem; background: rgb(241, 241, 241); padding: 0.25rem; height: 5rem; object-fit: contain;" src="'.$urlimage.'">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                      <div class="row">
                                                            <span class="fw-bold" style="font-size:0.9rem;">' . $row->MsProdukCode . ' - ' . $row->MsProdukName . ' </span>
                                                      </div>    
                                                      '. $varian .'
                                                </div>
                                          </div> 
                                    </div>
                                    <div class="col-md-2 col-4">
                                          <span class="fw-bold text-secondary">Qty</span><br>
                                          <span class="text-dark fw-bold" style="font-size:0.9rem;">' . number_format($row->SalesDetailQty, 2) . ' ' . $row->SatuanName . '</span>
                                    </div>
                                    <div class="col-md-2 col-4">
                                          <span class="fw-bold text-secondary">Harga</span><br>
                                          ' . $price . '
                                    </div> 
                                    <div class="col-md-2 col-4 px-md-4 mt-0 mt-md-1 text-end">
                                          <span class="fw-bold text-secondary">Total</span><br>
                                          ' . $total . '
                                    </div>
                              </div> ';
                  }
                  if (strlen($item) == 0) $item = "<div class='text-center'>Tidak Ada Data</div>";
                  /* ----------------------------------------------------------------------------------*/

                  /* -------------------------------------- DATA OPTIONAL -----------------------------*/
                  $optional = "";
                  $query = $this->db->query("select * from TblSalesOptional where SalesOptionalRef='" . $master->SalesCode . "'")->result();
                  foreach ($query as $row) {
                        $detail_item .= "   " . $row->SalesOptionalDesc . ")\n";

                        $optional .= '<div class="row py-1 g-1 bg-light">
                                          <div class="col-8">
                                                <span class="fw-bold text-secondary">Deskripsi</span><br> 
                                                <span class="fw-bold text-dark" style="font-size:0.9rem;">' . $row->SalesOptionalDesc . ' </span>
                                          </div>
                                          <div class="col-4 px-md-4 mt-0 mt-md-1 text-end">
                                                <span class="fw-bold text-secondary">Total</span><br> 
                                                <span class="fw-bold text-dark" style="font-size:0.9rem;">Rp. ' . number_format($row->SalesOptionalPrice) . '</span>
                                          </div>
                                    </div> ';
                  }
                  if (strlen($optional) != 0) $optional = " " . $optional;
                  /* ----------------------------------------------------------------------------------*/

                  /* -------------------------------------- DATA PERFORMA ------------------------------*/
                  $performa = "";
                  $totalperforma = 0;
                  $allowaddperforma = 1;
                  $query = $this->db->query("select * from TblSalesPerforma AS a left join TblMsMethod AS b ON a.MsMethodId = b.MsMethodId WHERE PerformaRef='" . $master->SalesCode . "'")->result();
                  foreach ($query as $row) {
                        $performa .= '<div class="row py-1 g-2 align-items-center border-bottom">
                                          <div class="col-md-2 col-8 ps-md-4">
                                                <span class="text-secondary">Metode Pembayaran</span><br>
                                                <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->MsMethodCode . '-' . $row->MsMethodName . '</span>
                                          </div>
                                          <div class="col-md-1 col-4">
                                                <span class="text-secondary">Tipe</span><br>
                                                <span class="text-dark fw-bold" style="font-size:0.7rem;">' . ($row->PerformaType == 1 ? "Deposit" : "Pelunasan") . '</span>
                                          </div>
                                          <div class="col-md-2 col-4">
                                                <span class="text-secondary">Atas Nama</span><br>
                                                <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->PerformaCardName . '</span>
                                          </div>
                                          <div class="col-md-1 col-4">
                                                <span class="text-secondary">Tanggal</span><br>
                                                <span class="text-dark fw-bold" style="font-size:0.7rem;">' . date_format(date_create($row->PerformaDate), "d F Y") . '</span>
                                          </div>
                                          <div class="col-md-2 col-4">
                                                <span class="text-secondary">Total</span><br>
                                                <span class="text-dark fw-bold" style="font-size:0.7rem;">' . number_format($row->PerformaTotal) . '</span>
                                          </div>
                                          <div class="col-md-1 col-4">
                                                <span class="text-secondary">Status</span><br>
                                                <span class="' . ($row->PerformaStatus == 0 ? "text-danger" : "text-success") . ' fw-bold " style="font-size:0.7rem;">' . ($row->PerformaStatus == 0 ? "pending" : "selesai") . '</span>
                                          </div>
                                          <div class="col-md-3 col-8">
                                                <span class="text-secondary">Action</span><br>
                                                ';
                        if ($row->PerformaStatus == 0) {
                              $performa .= ' <button type="button" class="btn btn-transparent btn-sm" aria-expanded="false" onclick="performa_edit(' . $row->PerformaId . ')" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-pencil-alt"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Edit
                                                      </span>
                                                </button>
                                                <button type="button" class="btn btn-transparent btn-sm" aria-expanded="false" onclick="performa_cancel(' . $row->PerformaId . ')" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-times"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Batalkan
                                                      </span>
                                                </button>
                                                <button type="button" class="btn btn-transparent btn-sm" aria-expanded="false" onclick="performa_success(' . $row->PerformaId . ')" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-check"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Selesaikan
                                                      </span>
                                                </button>';
                        } else {
                              $performa .= ' 
                                                <button type="button" class="btn btn-transparent btn-sm" aria-expanded="false" onclick="performa_cancel(' . $row->PerformaId . ')" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-times"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Batalkan
                                                      </span>
                                                </button>';
                        }
                        $performa .= ' </div>
                                    </div> ';
                        $totalperforma += $row->PerformaTotal;
                        if ($row->PerformaStatus == 0) $allowaddperforma = 0;
                  }
                  if (strlen($performa) == 0) $performa = '<div class="text-center">Belum Ada Performa invoice yang dibuat</div><br>';

                  /* -----------------------------------------------------------------------------------*/


                  /* -------------------------------------- DATA PEMBAYARAN ---------------------------------*/
                  $payment = "";
                  $status_transaksi = "";
                  $paymenttotal = 0;
                  $notif_payment = 0;
                  $query = $this->db->query("select * from TblSalesPayment AS a left join TblMsMethod AS b ON a.MsMethodId = b.MsMethodId WHERE PaymentRef='" . $master->SalesCode . "'")->result();
                  foreach ($query as $row) {

                        if ($row->PaymentType == "D") {
                              $status_transaksi .= "   *Deposit: " . $row->PaymentDate . " Rp. " . number_format($row->PaymentTotal) . "(" . $row->MsMethodName . ")\n";
                        } else {
                              $status_transaksi .= "   *Pelunasan: " . $row->PaymentDate . " Rp. " . number_format($row->PaymentTotal) . "(" . $row->MsMethodName . ")\n";
                        }
                        $paymenttotal += $row->PaymentTotal;
                        if ($row->PaymentApprove == 1) {
                              $approve = '<span class="fa-stack text-success"  style="font-size: 0.6rem;" data-bs-toggle="tooltip" data-bs-placement="top" title="Sudah diverifikasi">
                                                      <i class="fas fa-certificate fa-stack-2x"></i>
                                                      <i class="fas fa-check fa-stack-1x text-white" style="font-size: 0.5rem;"></i>
                                                </span>';
                        } else {
                              $notif_payment++;
                              $approve = ' <span class="fa-stack text-warning"  style="font-size: 0.6rem;" data-bs-toggle="tooltip" data-bs-placement="top" title="Belum diverifikasi">
                                                      <i class="fas fa-certificate fa-stack-2x"></i>
                                                      <i class="fas fa-exclamation fa-stack-1x text-danger" style="font-size: 0.5rem;"></i>
                                                </span>';
                        }
                        $payment .= '<div class="row py-1 g-2 align-items-center border-bottom">
                                          <div class="col-md-2 col-8 ps-md-4">
                                                <span class="text-secondary">Metode Pembayaran</span><br>
                                                <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->MsMethodCode . '-' . $row->MsMethodName . '</span>
                                                ' . $approve . '
                                          </div>
                                          <div class="col-md-1 col-4">
                                                <span class="text-secondary">Tipe</span><br>
                                                <span class="text-dark fw-bold" style="font-size:0.7rem;">' . ($row->PaymentType == "D" ? "Deposit" : "Pelunasan") . '</span>
                                          </div>
                                          <div class="col-md-2 col-4">
                                                <span class="text-secondary">Atas Nama</span><br>
                                                <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->PaymentCardName . '</span>
                                          </div>
                                          <div class="col-md-1 col-4">
                                                <span class="text-secondary">Tanggal</span><br>
                                                <span class="text-dark fw-bold" style="font-size:0.7rem;">' . date_format(date_create($row->PaymentDate), "d F Y") . '</span>
                                          </div>
                                          <div class="col-md-2 col-4">
                                                <span class="text-secondary">Total</span><br>
                                                <span class="text-dark fw-bold" style="font-size:0.7rem;">' . number_format($row->PaymentTotal) . '</span>
                                          </div>
                                          <div class="col-md-1 col-4">
                                                <span class="text-secondary">Bukti</span><br>
                                                <button type="button" class="btn btn-transparent btn-sm" aria-expanded="false" onclick="payment_view(' . $master->SalesId . ',\'' . $row->PaymentImage . '\')" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-eye"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Lihat
                                                      </span>
                                                </button>
                                          </div>
                                          <div class="col-md-3 col-8">
                                                <span class="text-secondary">Action</span><br>
                                                <button type="button" class="btn btn-transparent btn-sm" aria-expanded="false" onclick="payment_edit(' . $row->PaymentId . ')" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-pencil-alt"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Edit
                                                      </span>
                                                </button>';
                        if ($master->SalesStatusPayment != 3 && ($this->session->userdata("login_mode") == "Superuser" || $this->session->userdata("login_mode") == "Finance")) $payment .= '
                                          
                                                <button type="button" class="btn btn-transparent btn-sm" aria-expanded="false" onclick="payment_cancel(' . $row->PaymentId . ')" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-times"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Batalkan
                                                      </span>
                                                </button>';

                        $payment .= ' </div> </div> ';
                  }
                  if (strlen($payment) == 0) $payment = '<div class="text-center">Belum Ada pembayaran yang dibuat</div><br>';
                  /* ----------------------------------------------------------------------------------*/

                  /* -------------------------------------- DATA Delivery -----------------------------*/
                  // $delivery = "";
                  $notif_delivery = 0;
                  // $query = $this->db
                  //       ->join("TblMsCustomerDelivery", "TblDelivery.MsCustomerDeliveryId = TblMsCustomerDelivery.MsCustomerDeliveryId", "left")
                  //       ->join("TblMsWorkplace", "TblMsWorkplace.MsWorkplaceId = TblDelivery.MsCustomerDeliveryId", "left")
                  //       ->join("TblMsDelivery", "TblDelivery.MsDeliveryId = TblMsDelivery.MsDeliveryId", "left")
                  //       ->where("DeliveryRef", $master->SalesCode)
                  //       ->get("TblDelivery")->result();
                  // if ($master->SalesDelStatus == 0) {
                  //       $delivery = "<div class='text-center'>Tidak Ada Pengiriman</div><br>";
                  // } else {
                  //       foreach ($query as $row) {

                  //             if ($row->DeliveryType > 2) {
                  //                   $receive = $row->MsWorkplaceName;
                  //                   $telepon = $row->MsWorkplaceTelp1;
                  //                   $address = $row->MsWorkplaceAddress;
                  //                   $mapname =  $row->MsWorkplaceMap;
                  //                   $maplat = $row->MsWorkplaceLat;
                  //                   $maplng = $row->MsWorkplaceLng;
                  //             } else {
                  //                   $receive = $row->MsCustomerDeliveryReceive;
                  //                   $telepon = $row->MsCustomerDeliveryTelp;
                  //                   $address = $row->MsCustomerDeliveryAddress;
                  //                   $mapname =  $row->MsCustomerDeliveryName;
                  //                   $maplat = $row->MsCustomerDeliveryLat;
                  //                   $maplng = $row->MsCustomerDeliveryLng;
                  //             }

                  //             if ($row->DeliveryType == 0) {
                  //                   $header = "TOKO <i class='fas fa-long-arrow-alt-right'></i> CUSTOMER";
                  //                   $ref =  ' <div class="row">
                  //                               <div class="col-4">
                  //                                     <span class="text-secondary label-span">No. Ref</span>
                  //                               </div>
                  //                               <div class="col-auto">
                  //                                     <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->DeliveryRef2 . '</span>
                  //                               </div> 
                  //                         </div> ';
                  //             } else if ($row->DeliveryType == 1) {
                  //                   $header = "GUDANG <i class='fas fa-long-arrow-alt-right'></i> CUSTOMER";
                  //                   $ref =  ' <div class="row">
                  //                               <div class="col-4">
                  //                                     <span class="text-secondary label-span">No. Ref</span>
                  //                               </div>
                  //                               <div class="col-auto">
                  //                                     <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->DeliveryRef2 . '</span>
                  //                               </div> 
                  //                         </div> ';
                  //             } else if ($row->DeliveryType == 2) {
                  //                   $header = "VENDOR <i class='fas fa-long-arrow-alt-right'></i> CUSTOMER";
                  //                   $ref =  ' <div class="row">
                  //                               <div class="col-4">
                  //                                     <span class="text-secondary label-span">No. Ref</span>
                  //                               </div>
                  //                               <div class="col-auto">
                  //                                     <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->DeliveryRef2 . '</span>
                  //                               </div> 
                  //                               </div> ';
                  //             } else if ($row->DeliveryType == 3) {
                  //                   $header = "VENDOR <i class='fas fa-long-arrow-alt-right'></i> TOKO";
                  //                   $ref = ' <div class="row">
                  //                               <div class="col-4">
                  //                                     <span class="text-secondary label-span">No. Ref</span>
                  //                               </div>
                  //                               <div class="col-auto">
                  //                                     <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->DeliveryRef2 . '</span>
                  //                               </div> 
                  //                               </div> ';
                  //             } else if ($row->DeliveryType == 4) {
                  //                   $header = "VENDOR <i class='fas fa-long-arrow-alt-right'></i> GUDANG";
                  //                   $ref = ' <div class="row">
                  //                               <div class="col-4">
                  //                                     <span class="text-secondary label-span">No. Ref</span>
                  //                               </div>
                  //                               <div class="col-auto">
                  //                                     <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->DeliveryRef2 . '</span>
                  //                               </div> 
                  //                         </div> ';
                  //             }

                  //             $query1 = $this->db->query("select * from TblDeliveryDetail left join TblMsItem on TblDeliveryDetail.MsItemId=TblMsItem.MsItemId LEFT JOIN TblMsItemCategory on TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId  where DeliveryDetailRef='" . $row->DeliveryCode . "'")->result();
                  //             $detaildelivery = "";
                  //             foreach ($query1 as $row1) {
                  //                   $detaildelivery .= '    <div class="row align-items-center border-light border-bottom border-top me-1 py-1">
                  //                                                 <div class="col-4">
                  //                                                       <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemCode . '-' . $row1->MsItemName . '</span><br>
                  //                                                       <span class="text-secondary">Ukuran : <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemSize . '</span></span>
                  //                                                 </div>
                  //                                                 <div class="col-2">
                  //                                                       <span class="text-secondary">Vendor</span><br>
                  //                                                       <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsVendorCode . '</span>
                  //                                                 </div>
                  //                                                 <div class="col-3 text-right">
                  //                                                       <span class="text-secondary">Qty</span><br>
                  //                                                       <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->DeliveryDetailQty . ' ' . $row1->MsItemUoM . '</span>
                  //                                                 </div>
                  //                                                 <div class="col-3 text-right">
                  //                                                       <span class="text-secondary">Sapre Qty</span><br>
                  //                                                       <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->DeliveryDetailSpareQty . ' ' . $row1->MsItemUoM . '</span>
                  //                                                 </div>
                  //                                           </div>';
                  //             }

                  //             if ($row->DeliveryStatus == 0) {
                  //                   $notif_delivery++;
                  //                   $valueprogress = 30;
                  //                   if($row->MsDeliveryId>1){
                  //                         $button_proses = ' <button type="button" class="btn btn-transparent btn-sm mx-1 ms-auto" onclick="delivery_proses(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem"> 
                  //                         <i class="fas fa-share-square"></i>
                  //                         <span class="fw-bold">
                  //                         &nbsp;Proses
                  //                         </span>
                  //                         </button>';
                  //                   }else{
                  //                         $button_proses = '';
                  //                   }
                  //                   $button = ' <div class="col-md-12 d-flex">
                  //                                     <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_edit(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                  //                                           <i class="fas fa-pencil-alt"></i>  
                  //                                           <span class="fw-bold">
                  //                                           &nbsp;Edit
                  //                                           </span>
                  //                                     </button>
                  //                                     <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_print(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                  //                                           <i class="fas fa-print"></i>  
                  //                                           <span class="fw-bold">
                  //                                           &nbsp;Print
                  //                                           </span>
                  //                                     </button>
                  //                                     <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_delete(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                  //                                           <i class="fas fa-times"></i>  
                  //                                           <span class="fw-bold">
                  //                                           &nbsp;Hapus
                  //                                           </span>
                  //                                     </button>
                  //                                     '.$button_proses.'
                  //                               </div>';
                  //             } else if ($row->DeliveryStatus == 1) {
                  //                   $notif_delivery++;
                  //                   $valueprogress = 60;
                  //                   if($row->MsDeliveryId>1){
                  //                         $button_proses = '
                  //                         <button type="button" class="btn btn-transparent btn-sm mx-1 ms-auto" onclick="delivery_proses_view(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem"> 
                  //                               <i class="fas fa-share-square"></i>
                  //                               <span class="fw-bold">
                  //                               &nbsp;Lihat Bukti Pengiriman
                  //                               </span>
                  //                         </button> 
                  //                         <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_selesai(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem"> 
                  //                               <i class="fas fa-share-square"></i>
                  //                               <span class="fw-bold">
                  //                               &nbsp;Selesaikan
                  //                               </span>
                  //                         </button>';
                  //                   }else{
                  //                         $button_proses = '';
                  //                   }
                  //                   $button = ' <div class="col-md-12 d-flex">
                  //                                     <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_edit(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                  //                                           <i class="fas fa-pencil-alt"></i>  
                  //                                           <span class="fw-bold">
                  //                                           &nbsp;Edit
                  //                                           </span>
                  //                                     </button>
                  //                                     <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_print(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                  //                                           <i class="fas fa-print"></i>  
                  //                                           <span class="fw-bold">
                  //                                           &nbsp;Print
                  //                                           </span>
                  //                                     </button>
                  //                                     <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_delete(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                  //                                           <i class="fas fa-times"></i>  
                  //                                           <span class="fw-bold">
                  //                                           &nbsp;Hapus
                  //                                           </span>
                  //                                     </button>
                  //                                     '.$button_proses.'
                  //                               </div>';
                  //             } else if ($row->DeliveryStatus == 2) {
                  //                   $valueprogress = 100;
                  //                   $button = ' <div class="col-md-12 d-flex"> 
                  //                                     <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_print(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                  //                                           <i class="fas fa-print"></i>  
                  //                                           <span class="fw-bold">
                  //                                           &nbsp;Print
                  //                                           </span>
                  //                                     </button>  
                  //                                     <button type="button" class="btn btn-transparent btn-sm mx-1 ms-auto" onclick="delivery_proses_view(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem"> 
                  //                                           <i class="fas fa-share-square"></i>
                  //                                           <span class="fw-bold">
                  //                                           &nbsp;Lihat Bukti Pengiriman
                  //                                           </span>
                  //                                     </button> 
                  //                                     <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_selesai_view(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem"> 
                  //                                           <i class="fas fa-share-square"></i>
                  //                                           <span class="fw-bold">
                  //                                           &nbsp;Lihat Bukti Selesai
                  //                                           </span>
                  //                                     </button> 
                  //                               </div>';
                  //             }
                  //             // Pengiriman dari 
                  //             $tipe = substr($row->DeliveryRef2,12,2);
                  //             if($tipe=="PO"){
                  //                   $headeref = '<div class="row"> 
                  //                                     <div class="col-auto">
                  //                                           <span class="text-dark fw-bold" style="font-size:1rem;"><b>Pengiriman dari Pembelian</b></span>
                  //                                     </div>
                  //                               </div>';
                  //             }else if($tipe=="TO"){
                  //                   $headeref = '<div class="row"> 
                  //                                     <div class="col-auto">
                  //                                           <span class="text-dark fw-bold" style="font-size:1rem;"><b>Pengiriman dari Transfer Barang</b></span>
                  //                                     </div>
                  //                               </div>';
                  //             }else{
                  //                   $headeref = '';
                  //             }
                  //             if ($row->DeliveryJenis == 1) $via = "ENGKEL";
                  //             if ($row->DeliveryJenis == 2) $via = "PICK-UP";
                  //             if ($row->DeliveryJenis == 3) $via = "PS";
                  //             $delivery .= '<div class="m-2 px-4 py-2 shadow-sm" style="border-bottom: 1px dashed #ff7900;background: #f9f9f9;border: 1px solid #bdbdbd;border-radius: 5px;border-radius: 5px;box-shadow: 5px 0px 0px #ff7900 inset !important;">
                  //                         <div class="row py-1 g-1">
                  //                               <div class="col-lg-3 col-md-6 col-12">
                  //                                     ' . $headeref . '
                  //                                     <div class="row"> 
                  //                                           <div class="col-auto">
                  //                                                 <span class="text-dark fw-bold" style="font-size:1rem;">' . $header . '</span>
                  //                                           </div>
                  //                                     </div>
                  //                                     ' . $ref . '
                  //                                     <div class="row">
                  //                                           <div class="col-4">
                  //                                                 <span class="text-secondary label-span">No. Delivery</span>
                  //                                           </div>
                  //                                           <div class="col-auto">
                  //                                                 <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->DeliveryCode . '</span>
                  //                                           </div>
                  //                                     </div>
                  //                                     <div class="row">
                  //                                           <div class="col-4">
                  //                                                 <span class="text-secondary label-span">Pengiriman Ke</span>
                  //                                           </div>
                  //                                           <div class="col-auto">
                  //                                                 <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->DeliveryRit . '</span>
                  //                                           </div>
                  //                                     </div>
                  //                                     <div class="row">
                  //                                           <div class="col-4">
                  //                                                 <span class="text-secondary label-span">Armada</span>
                  //                                           </div>
                  //                                           <div class="col-auto">
                  //                                                 <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->MsDeliveryName . ($row->MsDeliveryId == 1 ? " (" . $via . ")" : "") . ' </span>
                  //                                           </div>
                  //                                     </div>   
                  //                               </div>
                  //                               <div class="col-lg-4 col-md-6 col-12">
                  //                                     <div class="list-progress" style="">
                  //                                           <span class="fa-stack text-secondary ' . ($row->DeliveryStatus >= 0 ? "success" : "") . '" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="dijadwalkan">
                  //                                                 <i class="fas fa-circle fa-stack-2x" ></i>
                  //                                                 <i class="fas fa-calendar-alt fa-stack-1x"></i>
                  //                                           </span>
                  //                                           <span class="fa-stack text-secondary ' . ($row->DeliveryStatus >= 1 ? "success" : "") . '" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="dikirim">
                  //                                                 <i class="fas fa-circle fa-stack-2x" ></i>
                  //                                                 <i class="fas fa-shipping-fast fa-stack-1x" ></i>
                  //                                           </span>
                  //                                           <span class="fa-stack text-secondary ' . ($row->DeliveryStatus >= 2 ? "success" : "") . '" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="diterima">
                  //                                                 <i class="fas fa-circle fa-stack-2x"></i>
                  //                                                 <i class="fas fa-people-carry fa-stack-1x"></i>
                  //                                           </span>
                  //                                           <div class="progress">
                  //                                                 <div class="progress-bar bg-success" role="progressbar" style="width: ' . $valueprogress . '%" aria-valuenow="' . $valueprogress . '" aria-valuemin="0" aria-valuemax="100"></div>
                  //                                           </div>
                  //                                     </div>
                  //                                     <div class="list-tanggal" style="">
                  //                                           <span>'. date_format(date_create($row->DeliveryDate),"d M Y").'</span> 
                  //                                           <span>'. ($row->DeliveryDateKirim != "0000-00-00" ? date_format(date_create($row->DeliveryDateKirim),"d M Y") : "N/A").'</span> 
                  //                                           <span>'. ($row->DeliveryDateFinish != "0000-00-00" ?  date_format(date_create($row->DeliveryDateFinish),"d M Y") : "N/A").'</span> 
                  //                                     </div>
                  //                                     <div class="row">
                  //                                           <div class="col-4">
                  //                                                 <span class="text-secondary label-span">Catatan</span>
                  //                                           </div>
                  //                                           <div class="col-auto">
                  //                                                 <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->DeliveryRemarks . '</span>
                  //                                           </div>
                  //                                     </div>  
                  //                               </div>
                  //                               <div class="col-lg-5 ps-lg-2 col-12">
                  //                                     <div class="row">
                  //                                           <div class="col-2">
                  //                                                 <span class="text-secondary label-span">Penerima</span>
                  //                                           </div>
                  //                                           <div class="col-10">
                  //                                                 <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $receive . '</span><span class="text-dark fw-bold" style="font-size:0.7rem;">(' . $telepon . ')</span>
                  //                                           </div>
                  //                                     </div>   
                  //                                     <div class="row">
                  //                                           <div class="col-2">
                  //                                                 <span class="text-secondary label-span">Alamat</span>
                  //                                           </div>
                  //                                           <div class="col-10">
                  //                                                 <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $address . '</span></span>
                  //                                           </div>
                  //                                     </div>    
                  //                                     <span class="text-secondary">Titik Map</span><br>
                  //                                     <div class="bg-pinpoint">
                  //                                           <i class="fas fa-map-marker-alt fa-2x"></i>
                  //                                           <span class="label-small px-1">' . $mapname . '</span>
                  //                                           <a class="btn btn-light py-1 ms-auto btn-sm" href="https://maps.google.com/?q=' . $maplat . ',' . $maplng . '" target="_blank" style="min-width: 5rem;">Lihat Map</a>
                  //                                     </div>
                  //                               </div>
                  //                               <div class="col-md-12 d-flex flex-column " style="border: 1px solid #d2cac0;border-radius: 0.25rem;">
                  //                                     ' . $detaildelivery . '
                  //                               </div>
                  //                               ' . $button . '
                  //                         </div>
                  //                         </div>  ';
                  //       }

                  //       if (strlen($delivery) == 0) $delivery = '<div class="text-center">Belum Ada pengiriman yang dibuat</div><br>';
                  // }
                  /* -----------------------------------------------------------------------------------*/

                  /* -------------------------------------- DATA PEMBELIAN ------------------------------------*/
                  $po = "";
                  $notif_po = 0;
                  $query = $this->db
                        ->select("* , a.MsWorkplaceCode as src , b.MsWorkplaceCode as dst")
                        ->join("TblMsVendor", "TblPO.MsVendorCode=TblMsVendor.MsVendorCode", "left")
                        ->join("TblMsWorkplace as a", "a.MsWorkplaceId=TblPO.MsWorkplaceId", "left")
                        ->join("TblMsWorkplace as b", "b.MsWorkplaceId=TblPO.PODst", "left")
                        ->like("SalesRef", $master->SalesCode)
                        ->get("TblPO")->result();
                  foreach ($query as $row) {
 
                        /* ========= DETAIL PO============ */  
                        $query1 = $this->db->join("TblMsProduk","TblMsProduk.MsProdukId=TblPODetail.MsProdukId") 
                        ->join("TblMsSatuan","TblMsSatuan.SatuanId=TblPODetail.SatuanId")->where("PODetailRef",$row->POCode)->get("TblPODetail")->result();
                        $detailpo = "";
                        foreach ($query1 as $row1) {
                              $detailpo .= '    <div class="row align-items-center border-light border-bottom border-top me-2 py-1">
                                                      <div class="col-8">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsProdukCode . '-' . $row1->MsProdukName .'</span><br>
                                                            <span class="text-secondary text-dark" style="font-size:0.7rem;">' . $row1->PODetailVarian . '</span>
                                                      </div>
                                                      <div class="col-4 text-right">
                                                            <span class="text-secondary">Qty</span><br>
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->PODetailQty . ' ' . $row1->SatuanName . '</span>
                                                      </div>
                                                </div>';
                        }

                        /* ========= Delivery PO============ */ 
                        $data_delivery = $this->db
                              ->join("TblMsCustomerDelivery", "TblDelivery.MsCustomerDeliveryId = TblMsCustomerDelivery.MsCustomerDeliveryId", "left")
                              ->join("TblMsWorkplace", "TblMsWorkplace.MsWorkplaceId = TblDelivery.MsCustomerDeliveryId", "left")
                              ->join("TblMsDelivery", "TblDelivery.MsDeliveryId = TblMsDelivery.MsDeliveryId", "left")
                              ->where("DeliveryRef2", $row->POCode)
                              ->get("TblDelivery")->result();
                        $datadelivery = "";
                        foreach ($data_delivery as $row1) {
                              if ($row1->DeliveryType > 2) {
                                    $receive = $row1->MsWorkplaceName;
                                    $telepon = $row1->MsWorkplaceTelp1;
                                    $address = $row1->MsWorkplaceAddress;
                                    $mapname =  $row1->MsWorkplaceMap;
                                    $maplat = $row1->MsWorkplaceLat;
                                    $maplng = $row1->MsWorkplaceLng;
                              } else {
                                    $receive = $row1->MsCustomerDeliveryReceive;
                                    $telepon = $row1->MsCustomerDeliveryTelp;
                                    $address = $row1->MsCustomerDeliveryAddress;
                                    $mapname =  $row1->MsCustomerDeliveryName;
                                    $maplat = $row1->MsCustomerDeliveryLat;
                                    $maplng = $row1->MsCustomerDeliveryLng;
                              }

                              if ($row1->DeliveryType == 0) {
                                    $header = "TOKO <i class='fas fa-long-arrow-alt-right'></i> CUSTOMER";
                                    $ref = '';
                              } else if ($row1->DeliveryType == 1) {
                                    $header = "GUDANG <i class='fas fa-long-arrow-alt-right'></i> CUSTOMER";
                                    $ref = '';
                              } else if ($row1->DeliveryType == 2) {
                                    $header = "VENDOR <i class='fas fa-long-arrow-alt-right'></i> CUSTOMER";
                                    $ref =  ' <div class="row">
                                                <div class="col-4">
                                                      <span class="text-secondary label-span">No. PO</span>
                                                </div>
                                                <div class="col-auto">
                                                      <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->DeliveryRef2 . '</span>
                                                </div> 
                                                </div> ';
                              } else if ($row1->DeliveryType == 3) {
                                    $header = "VENDOR <i class='fas fa-long-arrow-alt-right'></i> TOKO";
                                    $ref = ' <div class="row">
                                                <div class="col-4">
                                                      <span class="text-secondary label-span">No. PO</span>
                                                </div>
                                                <div class="col-auto">
                                                      <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->DeliveryRef2 . '</span>
                                                </div> 
                                                </div> ';
                              } else if ($row1->DeliveryType == 4) {
                                    $header = "VENDOR <i class='fas fa-long-arrow-alt-right'></i> GUDANG";
                                    $ref = ' <div class="row">
                                                <div class="col-4">
                                                      <span class="text-secondary label-span">No. PO</span>
                                                </div>
                                                <div class="col-auto">
                                                      <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->DeliveryRef2 . '</span>
                                                </div> 
                                          </div> ';
                              }
                              $query1 = $this->db->join("TblMsProduk","TblMsProduk.MsProdukId=TblDeliveryDetail.MsProdukId") 
                                          ->join("TblMsSatuan","TblMsSatuan.SatuanId=TblDeliveryDetail.SatuanId")->where("DeliveryDetailRef",$row1->DeliveryCode)->get("TblDeliveryDetail")->result();
                              $detaildelivery = "";
                              foreach ($query1 as $row2) {
                                    $detaildelivery .= '    <div class="row align-items-center border-light border-bottom border-top me-1 py-1">
                                                                  <div class="col-6">
                                                                        <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row2->MsProdukCode . '-' . $row2->MsProdukName . '</span><br>
                                                                        <span class="text-secondary"><span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row2->DeliveryDetailVarian . '</span></span>
                                                                  </div> 
                                                                  <div class="col-3 text-right">
                                                                        <span class="text-secondary">Qty</span><br>
                                                                        <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row2->DeliveryDetailQty . ' ' . $row2->SatuanName . '</span>
                                                                  </div>
                                                                  <div class="col-3 text-right">
                                                                        <span class="text-secondary">Spare</span><br>
                                                                        <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row2->DeliveryDetailSpareQty . ' ' . $row2->SatuanName . '</span>
                                                                  </div>
                                                            </div>';
                              }
                              if ($row1->DeliveryStatus == 0) {
                                    $valueprogress_delivery = 30;
                                    if($row1->MsDeliveryId>1){
                                          $button_proses = ' <button type="button" class="btn btn-transparent btn-sm mx-1 ms-auto" onclick="delivery_proses(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem"> 
                                          <i class="fas fa-share-square"></i>
                                          <span class="fw-bold">
                                          &nbsp;Proses
                                          </span>
                                          </button>';
                                    }else{
                                          $button_proses = '';
                                    }
                                    $button_delivery = ' <div class="col-md-12 d-flex">
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_edit(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-pencil-alt"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Edit
                                                            </span>
                                                      </button>
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_print(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-print"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Print
                                                            </span>
                                                      </button>
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_delete(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-times"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Hapus
                                                            </span>
                                                      </button>
                                                      '.$button_proses.'
                                                </div>';
                              } else if ($row1->DeliveryStatus == 1) {
                                    $valueprogress_delivery = 65;
                                    if($row1->MsDeliveryId>1){
                                          $button_proses = ' <button type="button" class="btn btn-transparent btn-sm mx-1 ms-auto" onclick="delivery_selesai(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem"> 
                                          <i class="fas fa-share-square"></i>
                                          <span class="fw-bold">
                                          &nbsp;Selesaikan
                                          </span>
                                          </button>';
                                    }else{
                                          $button_proses = '';
                                    }
                                    $button_delivery = ' <div class="col-md-12 d-flex">
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_edit(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-pencil-alt"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Edit
                                                            </span>
                                                      </button>
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_print(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-print"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Print
                                                            </span>
                                                      </button>
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_delete(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-times"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Hapus
                                                            </span>
                                                      </button>
                                                    '.$button_proses.'
                                                </div>';
                              } else if ($row1->DeliveryStatus == 2) {
                                    $valueprogress_delivery = 100;
                                    $button_delivery = ' <div class="col-md-12 d-flex"> 
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_print(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-print"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Print
                                                            </span>
                                                      </button>  
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1 ms-auto" onclick="delivery_transfer(' . $row1->DeliveryId . ',\'PO\')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem"> 
                                                            <i class="fas fa-share-square"></i>
                                                            <span class="fw-bold">
                                                            &nbsp;Buat GRPO
                                                            </span>
                                                      </button> 
                                                </div>';
                              }else if ($row1->DeliveryStatus == 3) {
                                    $valueprogress_delivery = 100;
                                    $button_delivery = ' <div class="col-md-12 d-flex"> 
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_print(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-print"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Print
                                                            </span>
                                                      </button>   
                                                </div>';
                              }

                              if ($row1->DeliveryJenis == 1) $via = "ENGKEL";
                              if ($row1->DeliveryJenis == 2) $via = "PICK-UP";
                              if ($row1->DeliveryJenis == 3) $via = "PS";
                              $datadelivery .= '<div class="m-2 px-4 py-2 shadow-sm" style="box-shadow: 5px 0px 0px #0d6efd inset !important;background: #f9f9f9;border: 1px solid #bdbdbd;border-radius: 5px;">
                                          <div class="row py-1 g-1">
                                                <div class="col-lg-3 col-md-6 col-12">
                                                      <div class="row"> 
                                                            <div class="col-auto">
                                                                  <span class="text-dark fw-bold" style="font-size:1rem;">' . $header . '</span>
                                                            </div>
                                                      </div>
                                                      ' . $ref . '
                                                      <div class="row">
                                                            <div class="col-4">
                                                                  <span class="text-secondary label-span">No. Delivery</span>
                                                            </div>
                                                            <div class="col-auto">
                                                                  <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->DeliveryCode . '</span>
                                                            </div>
                                                      </div>
                                                      <div class="row">
                                                            <div class="col-4">
                                                                  <span class="text-secondary label-span">Pengiriman Ke</span>
                                                            </div>
                                                            <div class="col-auto">
                                                                  <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->DeliveryRit . '</span>
                                                            </div>
                                                      </div>
                                                      <div class="row">
                                                            <div class="col-4">
                                                                  <span class="text-secondary label-span">Tgl. kirim</span>
                                                            </div>
                                                            <div class="col-auto">
                                                                  <span class="text-dark fw-bold" style="font-size:0.7rem;">' . date_format(date_create($row1->DeliveryDate), "d F Y") . '</span>
                                                            </div>
                                                      </div> 
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-12">
                                                      <div class="row">
                                                            <div class="col-4">
                                                                  <span class="text-secondary label-span">Armada</span>
                                                            </div>
                                                            <div class="col-auto">
                                                                  <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsDeliveryName . ($row1->MsDeliveryId == 1 ? " (" . $via . ")" : "") . ' </span>
                                                            </div>
                                                      </div>  
                                                      <div class="list-progress" style="">
                                                            <span class="fa-stack text-secondary ' . ($row1->DeliveryStatus >= 0 ? "success" : "") . '" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="dijadwalkan">
                                                                  <i class="fas fa-circle fa-stack-2x" ></i>
                                                                  <i class="fas fa-calendar-alt fa-stack-1x"></i>
                                                            </span>
                                                            <span class="fa-stack text-secondary ' . ($row1->DeliveryStatus >= 1 ? "success" : "") . '" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="dikirim">
                                                                  <i class="fas fa-circle fa-stack-2x" ></i>
                                                                  <i class="fas fa-shipping-fast fa-stack-1x" ></i>
                                                            </span>
                                                            <span class="fa-stack text-secondary ' . ($row1->DeliveryStatus >= 2 ? "success" : "") . '" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="diterima">
                                                                  <i class="fas fa-circle fa-stack-2x"></i>
                                                                  <i class="fas fa-people-carry fa-stack-1x"></i>
                                                            </span>
                                                            <div class="progress">
                                                                  <div class="progress-bar bg-success" role="progressbar" style="width: ' . $valueprogress_delivery . '%" aria-valuenow="' . $valueprogress_delivery . '" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                      </div>
                                                      <div class="row">
                                                            <div class="col-4">
                                                                  <span class="text-secondary label-span">Catatan</span>
                                                            </div>
                                                            <div class="col-auto">
                                                                  <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->DeliveryRemarks . '</span>
                                                            </div>
                                                      </div>  
                                                </div>
                                                <div class="col-lg-5 ps-lg-2 col-12">
                                                      <div class="row">
                                                            <div class="col-2">
                                                                  <span class="text-secondary label-span">Penerima</span>
                                                            </div>
                                                            <div class="col-10">
                                                                  <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $receive . '</span><span class="text-dark fw-bold" style="font-size:0.7rem;">(' . $telepon . ')</span>
                                                            </div>
                                                      </div>   
                                                      <div class="row">
                                                            <div class="col-2">
                                                                  <span class="text-secondary label-span">Alamat</span>
                                                            </div>
                                                            <div class="col-10">
                                                                  <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $address . '</span></span>
                                                            </div>
                                                      </div>    
                                                      <span class="text-secondary">Titik Map</span><br>
                                                      <div class="bg-pinpoint">
                                                            <i class="fas fa-map-marker-alt fa-2x"></i>
                                                            <span class="label-small px-1">' . $mapname . '</span>
                                                            <a class="btn btn-light py-1 ms-auto btn-sm" href="https://maps.google.com/?q=' . $maplat . ',' . $maplng . '" target="_blank" style="min-width: 5rem;">Lihat Map</a>
                                                      </div>
                                                </div>
                                                <div class="col-md-12 d-flex flex-column " style="border: 1px solid #d2cac0;border-radius: 0.25rem;">
                                                      ' . $detaildelivery . '
                                                </div>
                                                ' . $button_delivery . '
                                          </div>
                                    </div>  ';
                        }
                        if ($datadelivery == "")  $datadelivery = '<div class="text-center fw-bold mt-2">Belum Ada pengiriman yang dibuat</div><br>';

                        /* ========= GRPO PO============ */
                        $header_grpo = $this->db
                              ->select("*, TblGRPO.MsWorkplaceId")
                              ->join("TblMsVendor", "TblGRPO.MsVendorId=TblMsVendor.MsvendorId", "left")
                              ->join("TblMsWorkplace", "TblMsWorkplace.MsWorkplaceId=TblGRPO.MsWorkplaceId", "left")
                              ->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblGRPO.MsEmpId", "left")
                              ->like("GRPORef", $row->POCode)
                              ->get("TblGRPO")->result();
                        $grpo = "";
                        foreach ($header_grpo as $rows_grpo) {
                              if ($rows_grpo->MsWorkplaceId == 0) {
                                    $_receivegrpo = "CUSTOMER";
                              } else {
                                    $_receivegrpo = $rows_grpo->MsWorkplaceCode;
                              }
                              
                              $query1 = $this->db->join("TblMsProduk","TblMsProduk.MsProdukId=TblGRPODetail.MsProdukId") 
                                          ->join("TblMsSatuan","TblMsSatuan.SatuanId=TblGRPODetail.SatuanId")->where("GRPODetailRef",$row->POCode)->get("TblGRPODetail")->result();
                              $detailgrpo = "";
                              foreach ($query1 as $row1) { 
                                    $detailgrpo .= '    <div class="row align-items-center border-light border-bottom border-top me-1 py-1">
                                                                  <div class="col-6">
                                                                        <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsProdukCode . '-' . $row1->MsProdukName . '</span><br>
                                                                        <span class="text-secondary"><span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->GRPIDetailVarian . '</span></span>
                                                                  </div> 
                                                                  <div class="col-3 text-right">
                                                                        <span class="text-secondary">Qty</span><br>
                                                                        <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->GRPODetailQty . ' ' . $row1->SatuanName . '</span>
                                                                  </div>
                                                                  <div class="col-3 text-right">
                                                                        <span class="text-secondary">Spare</span><br>
                                                                        <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->GRPODetailSpareQty . ' ' . $row1->SatuanName . '</span>
                                                                  </div>
                                                            </div>';   
                              }
                              $grpo .= '<div class="m-2 px-4 py-2 shadow-sm" style="box-shadow: 5px 0px 0px #0d6efd inset !important;background: #f9f9f9;border: 1px solid #bdbdbd;border-radius: 5px;">
                                    <div class="row py-1">
                                          <div class="col-lg-4 col-md-6 col-12">
                                                <span class="fw-bold" style="font-size:1rem">Good Receipt PO (GRPO)</span><br> 
                                                <div class="row">
                                                      <div class="col-4">
                                                            <span class="text-secondary label-span">No. GRPO</span>
                                                      </div>
                                                      <div class="col-auto">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $rows_grpo->GRPOCode . '</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-4">
                                                            <span class="text-secondary label-span">Tgl. GRPO</span>
                                                      </div>
                                                      <div class="col-auto">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . date_format(date_create($rows_grpo->GRPODate), "d F Y") . '</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-4">
                                                            <span class="text-secondary label-span">Vendor</span>
                                                      </div>
                                                      <div class="col-auto">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $rows_grpo->MsVendorCode . '</span>
                                                      </div>
                                                </div> 
                                          </div>
                                          <div class="col-lg-4 col-md-6 col-12">
                                                <div class="row">
                                                      <div class="col-4">
                                                            <span class="text-secondary label-span">Terima di</span>
                                                      </div>
                                                      <div class="col-auto">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $_receivegrpo . '</span>
                                                      </div>
                                                </div> 
                                                <div class="row">
                                                      <div class="col-4">
                                                            <span class="text-secondary label-span">Admin</span>
                                                      </div>
                                                      <div class="col-auto">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $rows_grpo->MsEmpName . '</span>
                                                      </div>
                                                </div> 
                                                <div class="row">
                                                      <div class="col-4">
                                                            <span class="text-secondary label-span">Catatan</span>
                                                      </div>
                                                      <div class="col-auto">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $rows_grpo->GRPORemarks . '</span>
                                                      </div>
                                                </div>  
                                          </div> 
                                          <div class="col-lg-4 col-md-12 col-12">
                                                <div class="row">
                                                      <div class="col-4">
                                                            <span class="text-secondary label-span">Referensi</span>
                                                      </div>
                                                      <div class="col-auto">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $rows_grpo->GRPORef . '</span>
                                                      </div>
                                                </div>  
                                          </div> 
                                          <div class="col-md-12 d-flex flex-column mt-1" style="border: 1px solid #d2cac0;border-radius: 0.25rem;">
                                                ' . $detailgrpo . '
                                          </div>
                                          <div class="col-md-12 d-flex pt-2">
                                                <button type="button" onclick="grpo_edit(\'' . $rows_grpo->GRPOId . '\')" class="btn btn-transparent btn-sm mx-1" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-pencil-alt"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Edit
                                                      </span>
                                                </button>
                                                <button type="button" class="btn btn-transparent btn-sm mx-1 dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false" style="border: 1px solid !important;font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-print"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Print
                                                      </span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-sm w-16rem">
                                                      <li><a class="dropdown-item" onclick="grpo_print_a5(\'' . $rows_grpo->GRPOId . '\')"><i class="fas fa-file"  style="min-width:20px"></i>&nbsp;Print ukuran A5</a></li>
                                                      <li><a class="dropdown-item" onclick="grpo_print_a6(\'' . $rows_grpo->GRPOId . '\')"><i class="fas fa-file"  style="min-width:20px"></i>&nbsp;Print ukuran A6</a></li>
                                                </ul>
                                                <button type="button" onclick="grpo_delete(\'' . $rows_grpo->GRPOId . '\')" class="btn btn-transparent btn-sm mx-1" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-times"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Hapus
                                                      </span>
                                                </button> 
                                          </div>
                                    </div> 
                              </div>
                        <script>
                              $("[data-bs-toggle=\'tooltip\']").tooltip()
                        </script>';
                        }
                        if ($grpo == "")  $grpo = '<div class="text-center fw-bold mt-2">Belum Ada GRPO yang dibuat</div><br>';


                        if ($row->POStatus == 0) {
                              $notif_po++;
                              $valueprogress = 30;
                              $button = ' <div class="col-md-12 d-flex pt-2">
                                                <button type="button" onclick="po_edit(\'' . $row->POId . '\')" class="btn btn-transparent btn-sm mx-1 ms-auto" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-pencil-alt"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Edit
                                                      </span>
                                                </button>
                                                <div class="dropdown">
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1 dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false" style="border: 1px solid !important;font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-print"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Print
                                                            </span>
                                                      </button>
                                                      <ul class="dropdown-menu dropdown-menu-sm w-16rem">
                                                            <li><a class="dropdown-item" onclick="po_print_a5(\'' . $row->POId . '\')"><i class="fas fa-file"  style="min-width:20px"></i>&nbsp;Print ukuran A5</a></li>
                                                            <li><a class="dropdown-item" onclick="po_print_a6(\'' . $row->POId . '\')"><i class="fas fa-file"  style="min-width:20px"></i>&nbsp;Print ukuran A6</a></li>
                                                      </ul>
                                                </div>
                                                <button type="button" onclick="po_delete(\'' . $row->POId . '\')" class="btn btn-transparent btn-sm mx-1" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-times"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Hapus
                                                      </span>
                                                </button>  
                                          </div>';
                        } else if ($row->POStatus == 1) {
                              $notif_po++;
                              $valueprogress = 65;
                              $button = ' <div class="col-md-12 d-flex pt-2">
                                                <button type="button" onclick="po_edit(\'' . $row->POId . '\')" class="btn btn-transparent btn-sm mx-1 ms-auto" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-pencil-alt"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Edit
                                                      </span>
                                                </button>
                                                <div class="dropdown">
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1 dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false" style="border: 1px solid !important;font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-print"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;PrintBelum Ada GRPO yang dibuat

                                                            </span>
                                                      </button>
                                                      <ul class="dropdown-menu dropdown-menu-sm w-16rem">
                                                            <li><a class="dropdown-item" onclick="po_print_a5(\'' . $row->POId . '\')"><i class="fas fa-file"  style="min-width:20px"></i>&nbsp;Print ukuran A5</a></li>
                                                            <li><a class="dropdown-item" onclick="po_print_a6(\'' . $row->POId . '\')"><i class="fas fa-file"  style="min-width:20px"></i>&nbsp;Print ukuran A6</a></li>
                                                      </ul>
                                                </div>
                                                <button type="button" onclick="po_delete(\'' . $row->POId . '\')" class="btn btn-transparent btn-sm mx-1" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-times"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Hapus
                                                      </span>
                                                </button>  
                                          </div>';
                        } else if ($row->POStatus == 2) {
                              $valueprogress = 100;
                              $button = ' <div class="col-md-12 d-flex pt-2" >     
                                                <div class="dropdown  ms-auto">   
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1 dropdown-toggle "  data-bs-toggle="dropdown" aria-expanded="false" style="border: 1px solid !important;font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-print"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Print
                                                            </span>
                                                      </button>
                                                      <ul class="dropdown-menu dropdown-menu-sm w-16rem">
                                                            <li><a class="dropdown-item" onclick="po_print_a5(\'' . $row->POId . '\')"><i class="fas fa-file"  style="min-width:20px"></i>&nbsp;Print ukuran A5</a></li>
                                                            <li><a class="dropdown-item" onclick="po_print_a6(\'' . $row->POId . '\')"><i class="fas fa-file"  style="min-width:20px"></i>&nbsp;Print ukuran A6</a></li>
                                                      </ul>
                                                </div> 
                                          </div>';
                        }

                        $po .= '<div class="m-2 px-4 py-2 shadow-sm" style="border-bottom: 1px dashed #ff7900;background: #f9f9f9;border: 1px solid #bdbdbd;border-radius: 5px;box-shadow: 5px 0px 0px #ff7900 inset !important;">
                                    <div class="row py-1 g-1">
                                          <div class="col-12">
                                                <span class="fw-bold" style="font-size:1rem">Purchase Order (' . ($row->SalesRef == "" ? "PO STOCK" : "PO Sales") . ')
                                          </div>  
                                          <div class="col-lg-4 col-md-6 col-12">
                                                <div class="row g-1">
                                                      <div class="col-2">
                                                            <span class="text-dark fw-bold label-span">No. Doc</span>
                                                      </div> 
                                                      <div class="col-10">
                                                            <span class="text-secondary " style="font-size:0.7rem;">' . $row->POCode . '</span>
                                                      </div>  
                                                      <div class="col-2">
                                                            <span class="text-dark fw-bold label-span">Tgl PO</span>
                                                      </div> 
                                                      <div class="col-10">
                                                            <span class="text-secondary " style="font-size:0.7rem;">' . date_format(date_create($row->PODate), "d F Y") . '</span>
                                                      </div>   
                                                      <div class="col-2">
                                                            <span class="text-dark fw-bold label-span">Toko</span>
                                                      </div> 
                                                      <div class="col-10">
                                                            <span class="text-secondary " style="font-size:0.7rem;">' . $row->src . '</span>
                                                      </div>  
                                                      <div class="col-2">
                                                            <span class="text-dark fw-bold label-span">Pembuat</span>
                                                      </div> 
                                                      <div class="col-10">
                                                            <span class="text-secondary " style="font-size:0.7rem;">' . $this->model_app->get_single_data("MsEmpName", "TblMsEmployee", array("MsEmpId" => $master->MsEmpId))  . '</span>
                                                      </div> 
                                                </div>
                                          </div>
                                          <div class="col-lg-4 col-md-6 col-12">
                                                <div class="row g-1">
                                                      <div class="col-2">
                                                            <span class="text-dark fw-bold label-span">Vendor</span>
                                                      </div> 
                                                      <div class="col-10">
                                                            <span class="text-secondary " style="font-size:0.7rem;">' . $row->MsVendorCode . '</span>
                                                      </div>  
                                                      <div class="col-2">
                                                            <span class="text-dark fw-bold label-span">Kirim Ke</span>
                                                      </div> 
                                                      <div class="col-10">
                                                            <span class="text-secondary " style="font-size:0.7rem;">' . ($row->PODst == 0 ? "CUSTOMER" : $row->dst) . '</span>
                                                      </div>  
                                                      <div class="col-2">
                                                            <span class="text-dark fw-bold label-span">Catatan</span>
                                                      </div> 
                                                      <div class="col-10">
                                                            <span class="text-secondary " style="font-size:0.7rem;">' . $row->PORemarks . '</span>
                                                      </div>  
                                                </div> 
                                          </div>
                                          <div class="col-lg-4 col-md-12 col-12">
                                                <div class="list-progress" style="">
                                                      <span class="fa-stack text-secondary ' . ($row->POStatus >= 0 ? "success" : "") . '" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="dijadwalkan">
                                                            <i class="fas fa-circle fa-stack-2x" ></i>
                                                            <i class="fas fa-calendar-alt fa-stack-1x"></i>
                                                      </span>
                                                      <span class="fa-stack text-secondary ' . ($row->POStatus >= 1 ? "success" : "") . '" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="diproses">
                                                            <i class="fas fa-circle fa-stack-2x" ></i>
                                                            <i class="fas fa-project-diagram fa-stack-1x" ></i>
                                                      </span>
                                                      <span class="fa-stack text-secondary ' . ($row->POStatus >= 2 ? "success" : "") . '" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="diterima">
                                                            <i class="fas fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-people-carry fa-stack-1x"></i>
                                                      </span>
                                                      <div class="progress">
                                                            <div class="progress-bar bg-success" role="progressbar" style="width: ' . $valueprogress . '%" aria-valuenow="' . $valueprogress . '" aria-valuemin="0" aria-valuemax="100"></div>
                                                      </div>
                                                </div>
                                          </div> 
                                          ' . $button . '
                                    </div>
                                    <ul class="nav nav-tabs" role="tablist">
                                          <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="item-tab" data-bs-toggle="tab" data-bs-target="#item-' . $row->POId . '" type="button" role="tab" aria-controls="item-' . $row->POId . '" aria-selected="false">Detail Item</button>
                                          </li> 
                                          <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="delivery-tab" data-bs-toggle="tab" data-bs-target="#delivery-' . $row->POId . '" type="button" role="tab" aria-controls="delivery-' . $row->POId . '" aria-selected="false">Pengiriman</button>
                                          </li> 
                                          <li class="nav-item" role="presentation">
                                                <button class="nav-link " id="grpo-tab" data-bs-toggle="tab" data-bs-target="#grpo-' . $row->POId . '" type="button" role="tab" aria-controls="grpo-' . $row->POId . '" aria-selected="true">Goods Receipt PO</button>
                                          </li>
                                    </ul>
                                    <div class="tab-content">
                                          <div class="tab-pane p-2 fade show active" id="item-' . $row->POId . '" role="tabpanel" aria-labelledby="item-tab">
                                                ' . $detailpo . '  
                                          </div> 
                                          <div class="tab-pane fade" id="delivery-' . $row->POId . '" role="tabpanel" aria-labelledby="delivery-tab">
                                                ' . $datadelivery . ' 
                                                <div class="text-center">
                                                      <button class="btn btn-success btn-sm mt-2 py-1" type="button" onclick="delivery_add(' . $master->SalesId . ',\'PO\',' . $row->POId . ')"> 
                                                            <small><span class="fas fa-plus"></span>&nbsp;Buat Pengiriman</small>
                                                      </button>
                                                </div>
                                          </div> 
                                          <div class="tab-pane fade" id="grpo-' . $row->POId . '" role="tabpanel" aria-labelledby="grpo-tab">
                                                ' . $grpo . '  
                                          </div>
                                    </div> 
                              </div> ';
                  }
                  if (strlen($po) == 0) $po = '<div class="text-center">Belum Ada PO yang dibuat</div><br>';
                  /* -----------------------------------------------------------------------------------*/

                  /* -------------------------------------- DATA TRANSFER ------------------------------*/
                  $notif_transfer = 0;
                  $transfer = "";
                  $query = $this->db
                        ->select("*, a.MsWorkplaceCode as dstcode, b.MsWorkplaceCode as srccode")
                        ->join("TblMsWorkplace as a", "a.MsWorkplaceId=c.InvTODst", "LEFT")
                        ->join("TblMsWorkplace as b", "b.MsWorkplaceId=c.InvTOSrc", "LEFT")
                        ->like("SalesRef", $master->SalesCode)
                        ->get("TblInvTO as c")->result();
                  foreach ($query as $row) {
 
                        /* ========= DETAIL TO============ */ 
                        $query1 = $this->db->join("TblMsProduk","TblMsProduk.MsProdukId=TblInvTODetail.MsProdukId") 
                              ->join("TblMsSatuan","TblMsSatuan.SatuanId=TblInvTODetail.SatuanId")
                              ->where("InvTODetailRef",$row->InvTOCode)
                              ->get("TblInvTODetail")->result();
                        $detailto = "";
                        foreach ($query1 as $row1) {
                              $detailto .= '    <div class="row align-items-center border-light border-bottom border-top me-2 py-1">
                                                      <div class="col-8">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsProdukCode . '-' . $row1->MsProdukName . '</span><br>
                                                            <span class="text-secondary text-dark fw-bold" style="font-size:0.7rem;">' . $row1->InvTODetailVarian . '</span>
                                                      </div>
                                                      <div class="col-4 text-right">
                                                            <span class="text-secondary">Qty</span><br>
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->InvTODetailQty . ' ' . $row1->SatuanName . '</span>
                                                      </div>
                                                </div>';
                        }

                        /* ========= Delivery TO============ */ 
                        $data_delivery = $this->db
                              ->join("TblMsCustomerDelivery", "TblDelivery.MsCustomerDeliveryId = TblMsCustomerDelivery.MsCustomerDeliveryId", "left")
                              ->join("TblMsWorkplace", "TblMsWorkplace.MsWorkplaceId = TblDelivery.MsCustomerDeliveryId", "left")
                              ->join("TblMsDelivery", "TblDelivery.MsDeliveryId = TblMsDelivery.MsDeliveryId", "left")
                              ->where("DeliveryRef2", $row->InvTOCode)
                              ->get("TblDelivery")->result();
                        $datadelivery = "";
                        foreach ($data_delivery as $row1) {
                              if ($row1->DeliveryType > 2) {
                                    $receive = $row1->MsWorkplaceName;
                                    $telepon = $row1->MsWorkplaceTelp1;
                                    $address = $row1->MsWorkplaceAddress;
                                    $mapname =  $row1->MsWorkplaceMap;
                                    $maplat = $row1->MsWorkplaceLat;
                                    $maplng = $row1->MsWorkplaceLng;
                              } else {
                                    $receive = $row1->MsCustomerDeliveryReceive;
                                    $telepon = $row1->MsCustomerDeliveryTelp;
                                    $address = $row1->MsCustomerDeliveryAddress;
                                    $mapname =  $row1->MsCustomerDeliveryName;
                                    $maplat = $row1->MsCustomerDeliveryLat;
                                    $maplng = $row1->MsCustomerDeliveryLng;
                              }

                              if ($row1->DeliveryType == 0) {
                                    $header = "TOKO <i class='fas fa-long-arrow-alt-right'></i> CUSTOMER";
                                    $ref =  ' <div class="row">
                                                <div class="col-4">
                                                      <span class="text-secondary label-span">No. TO</span>
                                                </div>
                                                <div class="col-auto">
                                                      <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->DeliveryRef2 . '</span>
                                                </div> 
                                                </div> ';
                              } else if ($row1->DeliveryType == 1) {
                                    $header = "GUDANG <i class='fas fa-long-arrow-alt-right'></i> CUSTOMER";
                                    $ref =  ' <div class="row">
                                                <div class="col-4">
                                                      <span class="text-secondary label-span">No. TO</span>
                                                </div>
                                                <div class="col-auto">
                                                      <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->DeliveryRef2 . '</span>
                                                </div> 
                                                </div> ';
                              } else if ($row1->DeliveryType == 2) {
                                    $header = "VENDOR <i class='fas fa-long-arrow-alt-right'></i> CUSTOMER";
                                    $ref =  ' <div class="row">
                                                <div class="col-4">
                                                      <span class="text-secondary label-span">No. TO</span>
                                                </div>
                                                <div class="col-auto">
                                                      <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->DeliveryRef2 . '</span>
                                                </div> 
                                                </div> ';
                              } else if ($row1->DeliveryType == 3) {
                                    $header = "VENDOR <i class='fas fa-long-arrow-alt-right'></i> TOKO";
                                    $ref = ' <div class="row">
                                                <div class="col-4">
                                                      <span class="text-secondary label-span">No. TO</span>
                                                </div>
                                                <div class="col-auto">
                                                      <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->DeliveryRef2 . '</span>
                                                </div> 
                                                </div> ';
                              } else if ($row1->DeliveryType == 4) {
                                    $header = "VENDOR <i class='fas fa-long-arrow-alt-right'></i> GUDANG";
                                    $ref = ' <div class="row">
                                                <div class="col-4">
                                                      <span class="text-secondary label-span">No. TO</span>
                                                </div>
                                                <div class="col-auto">
                                                      <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->DeliveryRef2 . '</span>
                                                </div> 
                                          </div> ';
                              }
                              $query1 = $this->db->join("TblMsProduk","TblMsProduk.MsProdukId=TblDeliveryDetail.MsProdukId") 
                                     ->join("TblMsSatuan","TblMsSatuan.SatuanId=TblDeliveryDetail.SatuanId")->where("DeliveryDetailRef",$row1->DeliveryCode)->get("TblDeliveryDetail")->result();
                              $detaildelivery = "";
                              foreach ($query1 as $row2) {
                                    $detaildelivery .= '    <div class="row align-items-center border-light border-bottom border-top me-1 py-1">
                                                                  <div class="col-6">
                                                                        <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row2->MsProdukCode . '-' . $row2->MsProdukName . '</span><br>
                                                                        <span class="text-secondary"><span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row2->DeliveryDetailVarian . '</span></span>
                                                                  </div> 
                                                                  <div class="col-3 text-right">
                                                                        <span class="text-secondary">Qty</span><br>
                                                                        <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row2->DeliveryDetailQty . ' ' . $row2->SatuanName . '</span>
                                                                  </div>
                                                                  <div class="col-3 text-right">
                                                                        <span class="text-secondary">Spare</span><br>
                                                                        <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row2->DeliveryDetailSpareQty . ' ' . $row2->SatuanName . '</span>
                                                                  </div>
                                                            </div>';
                              } 
                              if ($row1->DeliveryStatus == 0) {
                                    $valueprogress_delivery = 30;
                                    if($row1->MsDeliveryId>1){
                                          $button_proses = ' <button type="button" class="btn btn-transparent btn-sm mx-1 ms-auto" onclick="delivery_proses(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem"> 
                                          <i class="fas fa-share-square"></i>
                                          <span class="fw-bold">
                                          &nbsp;Proses
                                          </span>
                                          </button>';
                                    }else{
                                          $button_proses = '';
                                    }
                                    $button_delivery = ' <div class="col-md-12 d-flex">
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_edit(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-pencil-alt"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Edit
                                                            </span>
                                                      </button>
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_print(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-print"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Print
                                                            </span>
                                                      </button>
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_delete(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-times"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Hapus
                                                            </span>
                                                      </button>
                                                      '.$button_proses.'
                                                </div>';
                              } else if ($row1->DeliveryStatus == 1) {
                                    $valueprogress_delivery = 65;
                                    if($row1->MsDeliveryId>1){
                                          $button_proses = ' <button type="button" class="btn btn-transparent btn-sm mx-1 ms-auto" onclick="delivery_selesai(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem"> 
                                          <i class="fas fa-share-square"></i>
                                          <span class="fw-bold">
                                          &nbsp;Selesaikan
                                          </span>
                                          </button>';
                                    }else{
                                          $button_proses = '';
                                    }
                                    $button_delivery = ' <div class="col-md-12 d-flex">
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_edit(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-pencil-alt"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Edit
                                                            </span>
                                                      </button>
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_print(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-print"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Print
                                                            </span>
                                                      </button>
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_delete(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-times"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Hapus
                                                            </span>
                                                      </button>
                                                    '.$button_proses.'
                                                </div>';
                              } else if ($row1->DeliveryStatus == 2) {
                                    $valueprogress_delivery = 100;
                                    $button_delivery = ' <div class="col-md-12 d-flex"> 
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_print(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-print"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Print
                                                            </span>
                                                      </button>  
                                                </div>';
                              }

                              if ($row1->DeliveryJenis == 1) $via = "ENGKEL";
                              if ($row1->DeliveryJenis == 2) $via = "PICK-UP";
                              if ($row1->DeliveryJenis == 3) $via = "PS";
                              $datadelivery .= '<div class="m-2 px-4 py-2 shadow-sm" style="box-shadow: 5px 0px 0px #0d6efd inset !important;background: #f9f9f9;border: 1px solid #bdbdbd;border-radius: 5px;">
                                          <div class="row py-1 g-1">
                                                <div class="col-lg-3 col-md-6 col-12">
                                                      <div class="row"> 
                                                            <div class="col-auto">
                                                                  <span class="text-dark fw-bold" style="font-size:1rem;">' . $header . '</span>
                                                            </div>
                                                      </div>
                                                      ' . $ref . '
                                                      <div class="row">
                                                            <div class="col-4">
                                                                  <span class="text-secondary label-span">No. Delivery</span>
                                                            </div>
                                                            <div class="col-auto">
                                                                  <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->DeliveryCode . '</span>
                                                            </div>
                                                      </div>
                                                      <div class="row">
                                                            <div class="col-4">
                                                                  <span class="text-secondary label-span">Pengiriman Ke</span>
                                                            </div>
                                                            <div class="col-auto">
                                                                  <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->DeliveryRit . '</span>
                                                            </div>
                                                      </div>
                                                      <div class="row">
                                                            <div class="col-4">
                                                                  <span class="text-secondary label-span">Tgl. kirim</span>
                                                            </div>
                                                            <div class="col-auto">
                                                                  <span class="text-dark fw-bold" style="font-size:0.7rem;">' . date_format(date_create($row1->DeliveryDate), "d F Y") . '</span>
                                                            </div>
                                                      </div> 
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-12">
                                                      <div class="row">
                                                            <div class="col-4">
                                                                  <span class="text-secondary label-span">Armada</span>
                                                            </div>
                                                            <div class="col-auto">
                                                                  <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsDeliveryName . ($row1->MsDeliveryId == 1 ? " (" . $via . ")" : "") . ' </span>
                                                            </div>
                                                      </div>  
                                                      <div class="list-progress" style="">
                                                            <span class="fa-stack text-secondary ' . ($row1->DeliveryStatus >= 0 ? "success" : "") . '" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="dijadwalkan">
                                                                  <i class="fas fa-circle fa-stack-2x" ></i>
                                                                  <i class="fas fa-calendar-alt fa-stack-1x"></i>
                                                            </span>
                                                            <span class="fa-stack text-secondary ' . ($row1->DeliveryStatus >= 1 ? "success" : "") . '" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="dikirim">
                                                                  <i class="fas fa-circle fa-stack-2x" ></i>
                                                                  <i class="fas fa-shipping-fast fa-stack-1x" ></i>
                                                            </span>
                                                            <span class="fa-stack text-secondary ' . ($row1->DeliveryStatus >= 2 ? "success" : "") . '" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="diterima">
                                                                  <i class="fas fa-circle fa-stack-2x"></i>
                                                                  <i class="fas fa-people-carry fa-stack-1x"></i>
                                                            </span>
                                                            <div class="progress">
                                                                  <div class="progress-bar bg-success" role="progressbar" style="width: ' . $valueprogress_delivery . '%" aria-valuenow="' . $valueprogress_delivery . '" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                      </div>
                                                      <div class="row">
                                                            <div class="col-4">
                                                                  <span class="text-secondary label-span">Catatan</span>
                                                            </div>
                                                            <div class="col-auto">
                                                                  <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->DeliveryRemarks . '</span>
                                                            </div>
                                                      </div>  
                                                </div>
                                                <div class="col-lg-5 ps-lg-2 col-12">
                                                      <div class="row">
                                                            <div class="col-2">
                                                                  <span class="text-secondary label-span">Penerima</span>
                                                            </div>
                                                            <div class="col-10">
                                                                  <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $receive . '</span><span class="text-dark fw-bold" style="font-size:0.7rem;">(' . $telepon . ')</span>
                                                            </div>
                                                      </div>   
                                                      <div class="row">
                                                            <div class="col-2">
                                                                  <span class="text-secondary label-span">Alamat</span>
                                                            </div>
                                                            <div class="col-10">
                                                                  <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $address . '</span></span>
                                                            </div>
                                                      </div>    
                                                      <span class="text-secondary">Titik Map</span><br>
                                                      <div class="bg-pinpoint">
                                                            <i class="fas fa-map-marker-alt fa-2x"></i>
                                                            <span class="label-small px-1">' . $mapname . '</span>
                                                            <a class="btn btn-light py-1 ms-auto btn-sm" href="https://maps.google.com/?q=' . $maplat . ',' . $maplng . '" target="_blank" style="min-width: 5rem;">Lihat Map</a>
                                                      </div>
                                                </div>
                                                <div class="col-md-12 d-flex flex-column " style="border: 1px solid #d2cac0;border-radius: 0.25rem;">
                                                      ' . $detaildelivery . '
                                                </div>
                                                ' . $button_delivery . '
                                          </div>
                                          </div>  ';
                        }
                        if ($datadelivery == "")  $datadelivery = '<div class="text-center fw-bold mt-2">Belum Ada pengiriman yang dibuat</div><br>';

                        /* ========= Terima Barang TI============ */ 
                        $header_ti = $this->db
                              ->select("*, a.MsWorkplaceCode as dstcode, b.MsWorkplaceCode as srccode")
                              ->join("TblMsWorkplace as a", "a.MsWorkplaceId=c.InvTIDst", "LEFT")
                              ->join("TblMsWorkplace as b", "b.MsWorkplaceId=c.InvTISrc", "LEFT")
                              ->join("TblMsEmployee", "TblMsEmployee.MsEmpId=c.MsEmpId", "LEFT")
                              ->like("InvTIRef", $row->InvTOCode)
                              ->get("TblInvTI as c")->result();
                        $transferti = "";
                        foreach ($header_ti as $rows_ti) {
                              if ($rows_ti->InvTIDst == 0) {
                                    $_receiveti = "CUSTOMER";
                              } else {
                                    $_receiveti = $rows_ti->dstcode;
                              }
                              $detailti = "";
                              $query1 = $this->db->query("select * from TblInvTIDetail 
                              LEFT JOIN TblMsItem on TblInvTIDetail.MsItemId=TblMsItem.MsItemId 
                              LEFT JOIN TblMsItemCategory on TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId  
                              where InvTIDetailRef='" . $rows_ti->InvTICode . "'")->result();
                              foreach ($query1 as $row1) {
                                    $detailti .= '    <div class="row align-items-center border-light border-bottom border-top me-2 py-1">
                                                      <div class="col-8">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemCode . '-' . $row1->MsItemName . ' (' . $row1->MsVendorCode . ')</span><br>
                                                            <span class="text-secondary">Ukuran : <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemSize . '</span></span>
                                                      </div>
                                                      <div class="col-4 text-right">
                                                            <span class="text-secondary">Qty</span><br>
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->InvTIDetailQty . ' ' . $row1->MsItemUoM . '</span>
                                                      </div>
                                                </div>';
                              }
                              $transferti .= '<div class="m-2 px-4 py-2 shadow-sm" style="box-shadow: 5px 0px 0px #0d6efd inset !important;background: #f9f9f9;border: 1px solid #bdbdbd;border-radius: 5px;">
                                    <div class="row py-1">
                                          <div class="col-lg-4 col-md-6 col-12">
                                                <span class="fw-bold" style="font-size:1rem">Terima Barang (TI)</span><br> 
                                                <div class="row">
                                                      <div class="col-4">
                                                            <span class="text-secondary label-span">No. TI</span>
                                                      </div>
                                                      <div class="col-auto">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $rows_ti->InvTICode . '</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-4">
                                                            <span class="text-secondary label-span">Tgl. TI</span>
                                                      </div>
                                                      <div class="col-auto">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . date_format(date_create($rows_ti->InvTIDate), "d F Y") . '</span>
                                                      </div>
                                                </div> 
                                          </div>
                                          <div class="col-lg-4 col-md-6 col-12">
                                                <div class="row">
                                                      <div class="col-4">
                                                            <span class="text-secondary label-span">Terima di</span>
                                                      </div>
                                                      <div class="col-auto">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $_receiveti . '</span>
                                                      </div>
                                                </div> 
                                                <div class="row">
                                                      <div class="col-4">
                                                            <span class="text-secondary label-span">Admin</span>
                                                      </div>
                                                      <div class="col-auto">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $rows_ti->MsEmpName . '</span>
                                                      </div>
                                                </div> 
                                                <div class="row">
                                                      <div class="col-4">
                                                            <span class="text-secondary label-span">Catatan</span>
                                                      </div>
                                                      <div class="col-auto">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $rows_ti->InvTIRemarks . '</span>
                                                      </div>
                                                </div>  
                                          </div> 
                                          <div class="col-lg-4 col-md-12 col-12">
                                                <div class="row">
                                                      <div class="col-4">
                                                            <span class="text-secondary label-span">Referensi</span>
                                                      </div>
                                                      <div class="col-auto">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $rows_ti->InvTIRef . '</span>
                                                      </div>
                                                </div>  
                                          </div> 
                                          <div class="col-md-12 d-flex flex-column mt-1" style="border: 1px solid #d2cac0;border-radius: 0.25rem;">
                                                ' . $detailti . '
                                          </div>
                                          <div class="col-md-12 d-flex pt-2">
                                                <button type="button" onclick="transfer_in_edit(\'' . $rows_ti->InvTIId . '\')" class="btn btn-transparent btn-sm mx-1" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-pencil-alt"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Edit
                                                      </span>
                                                </button>
                                                <button type="button" onclick="transfer_in_print(\'' . $rows_ti->InvTIId . '\')" class="btn btn-transparent btn-sm mx-1" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-print"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Print
                                                      </span>
                                                </button> 
                                                <button type="button" onclick="transfer_in_delete(\'' . $rows_ti->InvTIId . '\')" class="btn btn-transparent btn-sm mx-1" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-times"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Hapus
                                                      </span>
                                                </button> 
                                          </div>
                                    </div> 
                              </div>';
                        }     
                        if ($transferti == "")  $transferti = '<div class="text-center fw-bold mt-2">Belum Ada Terima Barang yang dibuat</div><br>';

                        
                        if ($row->InvTOStatus == 0) {
                              $notif_transfer++;
                              $valueprogress = 50;
                              $button = ' <div class="col-md-12 d-flex pt-2">
                                                <button type="button" onclick="transfer_out_edit(\'' . $row->InvTOId . '\')" class="btn btn-transparent btn-sm mx-1 ms-auto" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-pencil-alt"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Edit
                                                      </span>
                                                </button>
                                                <button type="button" onclick="transfer_out_print(\'' . $row->InvTOId . '\')" class="btn btn-transparent btn-sm mx-1" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-print"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Print
                                                      </span>
                                                </button> 
                                                <button type="button" onclick="transfer_out_delete(\'' . $row->InvTOId . '\')" class="btn btn-transparent btn-sm mx-1" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-times"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Hapus
                                                      </span>
                                                </button>    
                                          </div>';
                        } else if ($row->InvTOStatus == 1) {
                              $valueprogress = 100;
                              $button = ' <div class="col-md-12 d-flex pt-2">   
                                                <button type="button" onclick="transfer_out_print(\'' . $row->InvTOId . '\')" class="btn btn-transparent btn-sm mx-1 ms-auto" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-print"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Print
                                                      </span>
                                                </button>  
                                          </div>';
                        }
                      
                        $transfer .= '<div class="m-2 px-4 py-2 shadow-sm" style="border-bottom: 1px dashed #ff7900;background: #f9f9f9;border: 1px solid #bdbdbd;border-radius: 5px;box-shadow: 5px 0px 0px #ff7900 inset !important;">
                                          <div class="row py-1">
                                                <div class="col-lg-4 col-md-6 col-12">
                                                      <span class="fw-bold" style="font-size:1rem">Kirim Barang (TO)</span><br>
                                                      <span class="text-secondary label-span">No. Doc</span><span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->InvTOCode . '</span><br>
                                                      <span class="text-secondary label-span">Tgl TO</span><span class="text-dark fw-bold" style="font-size:0.7rem;">' . date_format(date_create($row->InvTODate), "d F Y") . '</span><br> 
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-12">
                                                      <span class="fw-bold" style="font-size:1rem">' . $row->srccode . ' <i class="fas fa-long-arrow-alt-right"></i> ' . ($row->InvTODst == 0 ? "CUSTOMER" : $row->dstcode) . '</span><br> 
                                                      <span class="text-secondary label-span">admin</span><span class="text-dark fw-bold" style="font-size:0.7rem;">' . $this->model_app->get_single_data("MsEmpName", "TblMsEmployee", array("MsEmpId" => $master->MsEmpId)) . '</span><br>
                                                      <span class="text-secondary label-span">Catatan</span><span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->InvTORemarks . '</span>
                                                </div>
                                                <div class="col-lg-4 col-md-12 col-12">
                                                      <div class="list-progress-2" style="">
                                                            <span class="fa-stack text-secondary ' . ($row->InvTOStatus >= 0 ? "success" : "") . '" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="dijadwalkan">
                                                                  <i class="fas fa-circle fa-stack-2x" ></i>
                                                                  <i class="fas fa-calendar-alt fa-stack-1x"></i>
                                                            </span>
                                                            <span class="fa-stack text-secondary ' . ($row->InvTOStatus >= 1 ? "success" : "") . '" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="diterima">
                                                                  <i class="fas fa-circle fa-stack-2x"></i>
                                                                  <i class="fas fa-people-carry fa-stack-1x"></i>
                                                            </span>
                                                            <div class="progress">
                                                                  <div class="progress-bar bg-success" role="progressbar" style="width: ' . $valueprogress . '%" aria-valuenow="' . $valueprogress . '" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                      </div>
                                                </div> 
                                                ' . $button . '
                                          </div> 
                                          
                                          <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                      <button class="nav-link active" id="item-tab" data-bs-toggle="tab" data-bs-target="#item-to-' . $row->InvTOId . '" type="button" role="tab" aria-controls="item-to-' . $row->InvTOId . '" aria-selected="false">Detail Item</button>
                                                </li> 
                                                <li class="nav-item" role="presentation">
                                                      <button class="nav-link" id="delivery-tab" data-bs-toggle="tab" data-bs-target="#delivery-to-' . $row->InvTOId . '" type="button" role="tab" aria-controls="delivery-to-' . $row->InvTOId. '" aria-selected="false">Pengiriman</button>
                                                </li> 
                                                <li class="nav-item" role="presentation">
                                                      <button class="nav-link " id="grpo-tab" data-bs-toggle="tab" data-bs-target="#grpo-to-' . $row->InvTOId . '" type="button" role="tab" aria-controls="grpo-to-' . $row->InvTOId . '" aria-selected="true">Terima Barang (TI)</button>
                                                </li>
                                          </ul>
                                          <div class="tab-content">
                                                <div class="tab-pane p-2 fade show active" id="item-to-' . $row->InvTOId . '" role="tabpanel" aria-labelledby="item-tab">
                                                      ' . $detailto . '  
                                                </div> 
                                                <div class="tab-pane fade" id="delivery-to-' . $row->InvTOId . '" role="tabpanel" aria-labelledby="delivery-tab">
                                                      ' . $datadelivery . ' 
                                                      <div class="text-center">
                                                            <button class="btn btn-success btn-sm mt-2 py-1" type="button" onclick="delivery_add(' . $master->SalesId . ',\'TO\',' . $row->InvTOId . ')"> 
                                                                  <small><span class="fas fa-plus"></span>&nbsp;Buat Pengiriman</small>
                                                            </button>
                                                      </div>
                                                </div> 
                                                <div class="tab-pane fade" id="grpo-to-' . $row->InvTOId . '" role="tabpanel" aria-labelledby="grpo-tab">
                                                      ' . $transferti . ' 
                                                      <div class="text-center">
                                                            <button class="btn btn-success btn-sm mt-2 py-1" type="button" onclick="transfer_out_selesai(' . $row->InvTOId . ')"> 
                                                                  <small><span class="fas fa-plus"></span>&nbsp;Buat Penerimaan</small>
                                                            </button>
                                                      </div>
                                                </div>
                                          </div> 
                                    </div> ';

                      
                  }
                  if (strlen($transfer) == 0) $transfer = '<div class="text-center">Belum Ada Transfer Barang yang dibuat</div><br>';







                  /* -----------------------------------------------------------------------------------*/


                  /* -------------------------------------- DATA SALES ------------------------------*/
                  if ($date != $master->SalesDate) {
                        $date = $master->SalesDate;
                        $content = '<div class="flex bg-light text my-2 px-2"><span class="fw-bold">' . date_format(date_create($master->SalesDate), "d F Y") . '</span></div>';
                  } else {
                        $content = "";
                  }
                  
                  $promoname = $this->db->where("PromoCode",$master->SalesPromoCode)->get("TblPromo")->row();
                  $sales_promo ="";

                  if($promoname){
                        $sales_promo = "<div class='badge rounded-pill text-bg-primary me-2' style='font-size:0.75rem'>".$promoname->PromoName."</div>";
                  }
                  $html_tooltip_payment = '<span class=\'tool-desc\'>Dibuat oleh : <br>' . $master->SalesCreateUser . ' <br>(' . $master->SalesCreate . ')</span><br>
                  <span class=\'tool-desc\'>Terakhir Diubah : <br>' . $master->SalesLastUpdateUser . ' <br>(' . $master->SalesLastUpdate . ')</span><br>';
                  $content .= ' <div class="row datatable-header">';

                  /* -------------------------------------- DATA HEADER ------------------------------*/

                  $content .= ' <div class="col-md-8 col-sm-6 p-1 g-1 " >
                                    <div class="d-flex">
                                          <div class="flex-shrink-0">
                                                <img src="' . base_url("asset/image/logo/logo-") . $master->SalesHeader . '-200.png" class="rounded" width="60">
                                          </div>
                                          <div class="flex-grow-1">
                                                <div class="d-flex flex-wrap ms-2 pb-2">
                                                      <span class="fw-bold text-orange py-1" style="font-size:11px;">
                                                            ' . $master->SalesCode . '
                                                            <i class="fas fa-info-circle px-2" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_payment . '"></i>
                                                      </span>
                                                      <div class="d-inline pe-2 py-1">
                                                            <span class="fw-bold text-secondary pe-1" style="font-size:12px;"><i class="fas fa-calendar-alt"></i></span> 
                                                            <span class="text-dark" style="font-size:0.8rem;">' . date_format(date_create($master->SalesDate), "j M Y") . '</span>
                                                      </div>  
                                                      <div class="d-inline pe-2 py-1">
                                                            <span class="fw-bold text-secondary pe-1" style="font-size:12px;"><i class="fas fa-user-tie"></i></span> 
                                                            <span class="text-dark" style="font-size:12px;">' . $this->model_app->get_single_data("MsEmpName", "TblMsEmployee", array("MsEmpId" => $master->MsEmpId)) . '</span>  
                                                      </div>
                                                      ' . $sales_payment_status  . ' 
                                                      ' . $sales_date_tempo  . '  
                                                      ' . $sales_promo  . '  
                                                </div> 
                                          </div>
                                    </div> 
                                    <div class="row">
                                          <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                          </div>      
                                          <div class="col pe-0">
                                                <span class="text-dark text-uppercase" style="font-size:12px;">' . $sales_customer . '</span>
                                          </div>
                                    </div>
                                    <div class="row">
                                          <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                                          </div>      
                                          <div class="col pe-0">
                                                <span class="text-dark text-uppercase" style="font-size:12px;">' . $sales_telp . '</span>
                                          </div>
                                    </div>
                                    <div class="row">
                                          <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                                          </div>      
                                          <div class="col pe-0">
                                                <span class="text-dark" style="font-size:12px;">' . $master->MsCustomerAddress . '</span>
                                          </div>
                                    </div>
                              </div>';


                  /* -------------------------------------- DATA HEADER TOTAL ------------------------------*/
                  $content .= ' <div class="col-md-4 col-sm-6 g-1" >
                                    <div class="box-in-table p-1 ">
                                          <div class="row border-bottom border-secondary mx-2">
                                                <div class="col-auto pe-0 ps-0" style="min-width:70px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">Disc Item&nbsp;<i class="far fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Disc item sudah terhitung dalam sub total"></i></span>
                                                </div>      
                                                <div class="col-auto px-0" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                </div>      
                                                <div class="col text-end pe-0">
                                                      <span class="fw-bold text-dark" style="font-size:12px;">' . number_format($totaldiscitem) . '</span>
                                                </div>      
                                          </div>
                                          <div class="row mx-2">
                                                <div class="col-auto pe-0 ps-0" style="min-width:70px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">Sub Total</span>
                                                </div>      
                                                <div class="col-auto px-0" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                </div>      
                                                <div class="col text-end pe-0">
                                                      <span class="fw-bold text-dark" style="font-size:12px;">' . number_format($master->SalesSubTotal) . '</span>
                                                </div>      
                                          </div>
                                          <div class="row mx-2">
                                                <div class="col-auto pe-0 ps-0" style="min-width:70px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">Pengiriman</span>
                                                </div>      
                                                <div class="col-auto px-0" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                </div>      
                                                <div class="col text-end pe-0">
                                                      <span class="fw-bold text-dark" style="font-size:12px;">' . number_format($master->SalesDeliveryTotal) . '</span>
                                                </div>      
                                          </div>
                                          <div class="row mx-2">
                                                <div class="col-auto pe-0 ps-0" style="min-width:70px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">Diskon</span>
                                                </div>      
                                                <div class="col-auto px-0" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                </div>      
                                                <div class="col text-end pe-0">
                                                      <span class="fw-bold text-dark" style="font-size:12px;">' . number_format($master->SalesDiscTotal) . '</span>
                                                </div>      
                                          </div>
                                          <div class="row border-bottom border-secondary mx-2">
                                                <div class="col-auto pe-0 ps-0" style="min-width:70px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">Grand Total</span>
                                                </div>      
                                                <div class="col-auto px-0" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                </div>      
                                                <div class="col text-end pe-0">
                                                      <span class="fw-bold text-dark" style="font-size:12px;">' . number_format($master->SalesGrandTotal) . '</span>
                                                </div>      
                                          </div>
                                          <div class="row border-bottom border-secondary mx-2">
                                                <div class="col-auto pe-0 ps-0" style="min-width:70px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">Bayar</span>
                                                </div>      
                                                <div class="col-auto px-0" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                </div>      
                                                <div class="col text-end pe-0">
                                                      <span class="fw-bold text-dark" style="font-size:12px;">' . number_format($paymenttotal) . '</span>
                                                </div>      
                                          </div>
                                          <div class="row mx-2">
                                                <div class="col-auto pe-0 ps-0" style="min-width:70px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">Sisa</span>
                                                </div>      
                                                <div class="col-auto px-0" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                </div>      
                                                <div class="col text-end pe-0">
                                                      <span class="fw-bold text-dark" style="font-size:12px;">' . number_format($master->SalesGrandTotal - $paymenttotal) . '</span>
                                                </div>      
                                          </div>
                                    </div>
                              </div>';


                  /* -------------------------------------------------------------------------------------------
                  -----------------------------------   DATA TAB PANEL Header ----------------------------------
                  ---------------------------------------------------------------------------------------------*/
                  $content .=   $item . $optional ;
                  $content .= ' <div class="col-12 g-2 ">
                                    <ul class="nav nav-tabs" role="tablist">
                                          <li class="nav-item" role="presentation">
                                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#detail-pay-' . $master->SalesId . '" type="button" role="tab" aria-controls="detail-pay-' . $master->SalesId . '" aria-selected="false"><i class="fas fa-file-invoice-dollar pe-2"></i>Pembayaran</button>
                                          </li> 
                                          <li class="nav-item" role="presentation">
                                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#detail-item-' . $master->SalesId . '" type="button" role="tab" aria-controls="detail-item-' . $master->SalesId . '" aria-selected="true"><i class="fas fa-cubes pe-2"></i>Barang</button>
                                          </li>
                                    </ul>';

                  /* -------------------------------------------------------------------------------------------
                  -----------------------------------   DATA TAB PANEL DETAIL ----------------------------------
                  ---------------------------------------------------------------------------------------------*/
                  $content .= ' <div class="tab-content" >
                                    <div class="tab-pane p-2 border border-top-0 fade show active" id="detail-pay-' . $master->SalesId . '"" role="tabpanel" aria-labelledby="detail-pay-' . $master->SalesId . '">
                                          ' . $transfer . '
                                          <div class="text-center">
                                                <button class="btn btn-success btn-sm mt-2 py-1" type="button" onclick="transfer_add(' . $master->SalesId . ')"> 
                                                      <small><span class="fas fa-plus"></span>&nbsp;Tambah Kirim Barang</small>
                                                </button>
                                          </div> 
                                    </div>
                                    <div class="tab-pane p-2 border border-top-0 fade" id="detail-item-' . $master->SalesId . '"" role="tabpanel" aria-labelledby="detail-item-' . $master->SalesId . '">
                                          ' . $performa . '
                                          <div class="text-center">';
                                          /*************************/ if ($allowaddperforma == 0) {
                                                $content .= '           <button class="btn btn-primary btn-sm mt-2 py-1" type="button" onclick="performa_print(' . $master->SalesId . ')">
                                                                              <small><span class="fas fa-print"></span>&nbsp;Print Performa</small>
                                                                        </button>';
                                          }
                                          /*************************/ if ($totalperforma < $master->SalesGrandTotal && $allowaddperforma == 1 && $master->SalesStatusPayment != 3) {
                                                $content .= '           <button class="btn btn-success btn-sm mt-2 py-1" type="button" onclick="performa_add(' . $master->SalesId . ')"> 
                                                                              <small><span class="fas fa-plus"></span>&nbsp;Tambah Performa Invoice</small>
                                                                        </button>';
                                          }
                                          $content .= '           </div>
                                    </div> 
                                    <div class="tab-pane p-2 border border-top-0 fade" id="detail-payment-' . $master->SalesId . '"" role="tabpanel" aria-labelledby="detail-payment-' . $master->SalesId . '">
                                          ' . $payment . ' 
                                                      <div class="text-center">';
                                          /*************************/ $hrefwhatsapp = "https://web.whatsapp.com/send?text=" . urlencode("*TRANSAKSI " . $sales_customer . "* \n " .
                                          "Nama: " . $sales_customer . "\n" .
                                          "Status transaksi: \n" . $status_transaksi .
                                          "Detail Item: \n" . $detail_item .
                                          "Status barang: \n" .
                                          "Pengiriman: \n" .
                                          "Tgl Pengiriman: \n" .
                                          "Status PO: \n" .
                                          site_url("report/sales/") . $master->SalesId);
                                          /*************************/ if ($master->SalesStatusPayment != 0 && $master->SalesStatusPayment != 3)
                                                $content .= '           <button class="btn btn-primary btn-sm mt-2 py-1" type="button" onclick="payment_print(' . $master->SalesId . ')">
                                                                                                      <small><span class="fas fa-print"></span>&nbsp;Print Pembayaran</small>
                                                                                                </button>
                                                                                                <a class="btn btn-primary btn-sm mt-2 py-1" href="' . $hrefwhatsapp . '" target="web.whatsapp.com">
                                                                                                      <small><i class="fa fa-share-alt" aria-hidden="true"></i>&nbsp;Whatsapp</small>
                                                                                                </a>';
                                          /*************************/ if ($master->SalesStatusPayment < 2)
                                                $content .= '           <button class="btn btn-success btn-sm mt-2 py-1" type="button" onclick="payment_add(' . $master->SalesId . ')">
                                                                                                      <small><span class="fas fa-plus"></span>&nbsp;Tambah Pembayaran</small>
                                                                                                </button>';
                                          /*************************/ $content .= '           
                                          </div>
                                    </div>'; 
                                    $content .= '  
                                    <div class="tab-pane p-2 border border-top-0 fade" id="detail-po-' . $master->SalesId . '"" role="tabpanel" aria-labelledby="detail-po-' . $master->SalesId . '">
                                          ' . $po . ' 
                                          <div class="text-center">
                                                <button class="btn btn-success btn-sm mt-2 py-1" type="button" onclick="po_add(' . $master->SalesId . ')"> 
                                                      <small><span class="fas fa-plus"></span>&nbsp;Tambah PO</small>
                                                </button>
                                          </div>
                                    </div>
                                    <div class="tab-pane p-2 border border-top-0 fade" id="detail-kirim-' . $master->SalesId . '"" role="tabpanel" aria-labelledby="detail-kirim-' . $master->SalesId . '">
                                          ' . $transfer . '
                                          <div class="text-center">
                                                <button class="btn btn-success btn-sm mt-2 py-1" type="button" onclick="transfer_add(' . $master->SalesId . ')"> 
                                                      <small><span class="fas fa-plus"></span>&nbsp;Tambah Kirim Barang</small>
                                                </button>
                                          </div>
                                    </div>
                              </div>
                        </div> ';


                  if ($master->SalesStatusPayment == 0) {
                        $menu = '   <li><a class="dropdown-item" onclick="sales_change_header(\'' . $master->SalesId . '\',\'' . $master->SalesHeader . '\')"><i class="fas fa-copyright" style="min-width:20px"></i>&nbsp;Ganti Header/Logo</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" data-request="' . $master->SalesRequestEdit . '" data-superuser="1" onclick="sales_edit_data(\'' . $master->SalesId . '\',this)"><i class="fas fa-pencil-alt"  style="min-width:20px"></i>&nbsp;Edit Data</a></li>
                                    <li><a class="dropdown-item" data-request="1" data-superuser="1" onclick="sales_delete_data(\'' . $master->SalesId . '\',this)"><i class="fas fa-times"  style="min-width:20px"></i>&nbsp;Batalkan Data</a></li>
                                    <li><a class="dropdown-item" onclick="sales_print_data(\'' . $master->SalesId . '\')"><i class="fas fa-print"  style="min-width:20px"></i>&nbsp;Export atau Print Data</a></li>';
                  } elseif ($master->SalesStatusPayment == 1) {
                        $menu = '   <li><a class="dropdown-item" onclick="sales_change_header(\'' . $master->SalesId . '\',\'' . $master->SalesHeader . '\')"><i class="fas fa-copyright" style="min-width:20px"></i>&nbsp;Ganti Header/Logo</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" data-request="' . $master->SalesRequestEdit . '" data-superuser="' .  ($this->session->userdata("login_mode") == "Superuser" || $this->session->userdata("login_mode") == "Finance"  ? "1" : "0") . '" onclick="sales_edit_data(\'' . $master->SalesId . '\',this)" ><i class="fas fa-pencil-alt"  style="min-width:20px"></i>&nbsp;Edit Data</a></li>
                                    <li><a class="dropdown-item" data-request="' . $master->SalesRequestCancel . '" data-superuser="' .  ($this->session->userdata("login_mode") == "Superuser" || $this->session->userdata("login_mode") == "Finance"  ? "1" : "0") . '" onclick="sales_delete_data(\'' . $master->SalesId . '\',this)"><i class="fas fa-times"  style="min-width:20px"></i>&nbsp;Batalkan Data</a></li>
                                    <li><a class="dropdown-item" onclick="sales_print_data(\'' . $master->SalesId . '\')"><i class="fas fa-print"  style="min-width:20px"></i>&nbsp;Export atau Print Data</a></li>';
                  } elseif ($master->SalesStatusPayment == 2) {
                        $menu = '   <li><a class="dropdown-item" onclick="sales_change_header(\'' . $master->SalesId . '\',\'' . $master->SalesHeader . '\')"><i class="fas fa-copyright" style="min-width:20px"></i>&nbsp;Ganti Header/Logo</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" data-request="' . $master->SalesRequestEdit . '" data-superuser="' .  ($this->session->userdata("login_mode") == "Superuser" || $this->session->userdata("login_mode") == "Finance"  ? "1" : "0") . '" onclick="sales_edit_data(\'' . $master->SalesId . '\',this)" ><i class="fas fa-pencil-alt"  style="min-width:20px"></i>&nbsp;Edit Data</a></li>
                                    <li><a class="dropdown-item" data-request="' . $master->SalesRequestCancel . '" data-superuser="' .  ($this->session->userdata("login_mode") == "Superuser" || $this->session->userdata("login_mode") == "Finance"  ? "1" : "0") . '" onclick="sales_delete_data(\'' . $master->SalesId . '\',this)"><i class="fas fa-times"  style="min-width:20px"></i>&nbsp;Batalkan Data</a></li>
                                    <li><a class="dropdown-item" onclick="sales_print_data(\'' . $master->SalesId . '\')"><i class="fas fa-print"  style="min-width:20px"></i>&nbsp;Export atau Print Data</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" onclick="sales_return_data(\'' . $master->SalesId . '\')"><i class="fas fa-exchange-alt"  style="min-width:20px"></i>&nbsp;Retur Penjualan</a></li>';
                  } else {
                        $menu = ' ';
                  }

                  $content .= ' 
                        <div class="datatable-action px-0 py-2 mt-1">
                              <button type="button" class="btn btn-outline-secondary btn-sm me-1" onclick="log_sales(' . $master->SalesId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                    <i class="fas fa-clipboard-list pe-1"></i><span class="fw-bold">Activity</span>
                              </button>  
                              <button type="button" class="btn btn-outline-secondary btn-sm me-1" onclick="log_approve(' . $master->SalesId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                    <i class="fas fa-check pe-1"></i><span class="fw-bold">Approval</span>
                              </button>  
                              <button type="button" class="btn btn-outline-secondary btn-sm me-1" onclick="log_edit(' . $master->SalesId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                    <i class="fas fa-pencil-alt pe-1"></i><span class="fw-bold">History</span>
                              </button> 
                              <div class="dropdown float-end dropup">   
                                    <button class="btn btn-primary btn-sm py-1 dropdown-toggle dropnone" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                          <i class="fas fa-ellipsis-v pe-sm-2 pe-0"></i><span class="d-sm-inline-block d-none" >Tindakan</span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-sm w-16rem" style="">
                                          ' . $menu . '
                                    </ul>
                              </div> 
                        </div> 
                        <script>
                              $("[data-bs-toggle=\'tooltip\']").tooltip();
                              
                        </script>
                  </div>';


                  $row = array();
                  $row[] = $content;
                  $row[] = $master->SalesId;
                  $data[] = $row;
            }


            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->m_penjualan->count_all(),
                  "recordsFiltered" => $this->m_penjualan->count_filtered(),
                  "data" => $data,
            );
            //output to json format
            echo json_encode($output);
      }

      function get_data_sales()
      {
            // SETUP DATATABLE
            $this->m_penjualan->table = 'TblSales';
            $this->m_penjualan->tablejoin = array(
                  array(0 => 'TblSalesDetail', 1 => 'TblSales.SalesCode=TblSalesDetail.SalesDetailRef'),
                  array(0 => 'TblSalesOptional', 1 => 'TblSales.SalesCode=TblSalesOptional.SalesOptionalRef'),
                  array(0 => 'TblMsProduk', 1 => 'TblMsProduk.MsProdukId=TblSalesDetail.MsProdukId'),
                  array(0 => 'TblMsCustomer', 1 => 'TblSales.MsCustomerId=TblMsCustomer.MsCustomerId'),
            );
            $this->m_penjualan->column_search = array(
                  'TblMsCustomer.MsCustomerCode',
                  'MsCustomerName',
                  'MsCustomerCompany',
                  'MsCustomerAddress',
                  'SalesCode',
                  'MsProdukCode',
                  'MsProdukName'
            ); //set column field database for datatable searchable 
            $this->m_penjualan->order = array('SalesDate' => 'DESC', 'SalesId' => 'DESC'); // default order 
            $this->m_penjualan->group = array('SalesCode');
            // PROSES DATA
            $list = $this->m_penjualan->get_datatables();
            $data = array();
            $this->m_penjualan->select = array(
                  "SalesCode",
                  "MsCustomerTypeId",
                  "MsCustomerName",
                  "MsCustomerCompany",
                  "MsCustomerTelp1",
                  "MsCustomerTelp2",
                  "SalesStatusPayment",
                  "SalesStatusDelivery",
                  "SalesDelStatus",
                  "SalesDate",
                  "SalesHeader",
                  "MsCustomerAddress",
                  "MsEmpId",
                  "SalesSubTotal",
                  "SalesDeliveryTotal",
                  "SalesDiscTotal",
                  "SalesGrandTotal",
                  "SalesId",
            );
            $date = "";
            foreach ($list as $master) { 
                  /* -------------------------------------- MENU ACTION ------------------------------*/
                        if ($master->SalesStatusPayment == 0) {
                              $menu = '   <li><a class="dropdown-item" onclick="sales_change_header(\'' . $master->SalesId . '\',\'' . $master->SalesHeader . '\')"><i class="fas fa-copyright" style="min-width:20px"></i>&nbsp;Ganti Header/Logo</a></li>
                                          <li><hr class="dropdown-divider"></li>
                                          <li><a class="dropdown-item" data-request="' . $master->SalesRequestEdit . '" data-superuser="1" onclick="sales_edit_data(\'' . $master->SalesId . '\',this)"><i class="fas fa-pencil-alt"  style="min-width:20px"></i>&nbsp;Edit Data</a></li>
                                          <li><a class="dropdown-item" data-request="1" data-superuser="1" onclick="sales_delete_data(\'' . $master->SalesId . '\',this)"><i class="fas fa-times"  style="min-width:20px"></i>&nbsp;Batalkan Data</a></li>
                                          <li><a class="dropdown-item" onclick="sales_print_data(\'' . $master->SalesId . '\')"><i class="fas fa-print"  style="min-width:20px"></i>&nbsp;Export atau Print Data</a></li>';
                        } elseif ($master->SalesStatusPayment == 1) {
                              $menu = '   <li><a class="dropdown-item" onclick="sales_change_header(\'' . $master->SalesId . '\',\'' . $master->SalesHeader . '\')"><i class="fas fa-copyright" style="min-width:20px"></i>&nbsp;Ganti Header/Logo</a></li>
                                          <li><hr class="dropdown-divider"></li>
                                          <li><a class="dropdown-item" data-request="' . $master->SalesRequestEdit . '" data-superuser="' .  ($this->session->userdata("login_mode") == "Superuser" || $this->session->userdata("login_mode") == "Finance"  ? "1" : "0") . '" onclick="sales_edit_data(\'' . $master->SalesId . '\',this)" ><i class="fas fa-pencil-alt"  style="min-width:20px"></i>&nbsp;Edit Data</a></li>
                                          <li><a class="dropdown-item" data-request="' . $master->SalesRequestCancel . '" data-superuser="' .  ($this->session->userdata("login_mode") == "Superuser" || $this->session->userdata("login_mode") == "Finance"  ? "1" : "0") . '" onclick="sales_delete_data(\'' . $master->SalesId . '\',this)"><i class="fas fa-times"  style="min-width:20px"></i>&nbsp;Batalkan Data</a></li>
                                          <li><a class="dropdown-item" onclick="sales_print_data(\'' . $master->SalesId . '\')"><i class="fas fa-print"  style="min-width:20px"></i>&nbsp;Export atau Print Data</a></li>';
                        } elseif ($master->SalesStatusPayment == 2) {
                              $menu = '   <li><a class="dropdown-item" onclick="sales_change_header(\'' . $master->SalesId . '\',\'' . $master->SalesHeader . '\')"><i class="fas fa-copyright" style="min-width:20px"></i>&nbsp;Ganti Header/Logo</a></li>
                                          <li><hr class="dropdown-divider"></li>
                                          <li><a class="dropdown-item" data-request="' . $master->SalesRequestEdit . '" data-superuser="' .  ($this->session->userdata("login_mode") == "Superuser" || $this->session->userdata("login_mode") == "Finance"  ? "1" : "0") . '" onclick="sales_edit_data(\'' . $master->SalesId . '\',this)" ><i class="fas fa-pencil-alt"  style="min-width:20px"></i>&nbsp;Edit Data</a></li>
                                          <li><a class="dropdown-item" data-request="' . $master->SalesRequestCancel . '" data-superuser="' .  ($this->session->userdata("login_mode") == "Superuser" || $this->session->userdata("login_mode") == "Finance"  ? "1" : "0") . '" onclick="sales_delete_data(\'' . $master->SalesId . '\',this)"><i class="fas fa-times"  style="min-width:20px"></i>&nbsp;Batalkan Data</a></li>
                                          <li><a class="dropdown-item" onclick="sales_print_data(\'' . $master->SalesId . '\')"><i class="fas fa-print"  style="min-width:20px"></i>&nbsp;Export atau Print Data</a></li>
                                          <li><hr class="dropdown-divider"></li>
                                          <li><a class="dropdown-item" onclick="sales_return_data(\'' . $master->SalesId . '\')"><i class="fas fa-exchange-alt"  style="min-width:20px"></i>&nbsp;Retur Penjualan</a></li>';
                        } else {
                              $menu = ' ';
                        }
                  /* ----------------------------------------------------------------------------------*/

                  /* -------------------------------------- GET CUSTOMER ------------------------------*/
                        $sales_customer = ($master->MsCustomerTypeId == 1 ? $master->MsCustomerName : $master->MsCustomerName . ' (' . $master->MsCustomerCompany . ')');
                        $sales_telp = (($master->MsCustomerTelp2 == "" || $master->MsCustomerTelp2 == "-") ? $master->MsCustomerTelp1 : $master->MsCustomerTelp1 . " / " . $master->MsCustomerTelp2);
                  /* ----------------------------------------------------------------------------------*/

                  /* -------------------------------------- SET STATUS --------------------------------*/
                        $sales_date_tempo = ""; 
                        if ($master->SalesStatusPayment == 0) { 
                              $sales_payment_status = '<div class="tool-desc fw-bold bg-0">Belum Bayar</div>';
                              $sales_date_tempo =
                                    '<div class="row me-2"> 
                                          <div class="col pe-0">
                                                <span class="text-danger time-banned fw-bold" style="font-size:12px;" data-date="' . $master->SalesDate . '">'  . date_format(date_create($master->SalesDate), "Y/m/d H:i:s") . '</span>
                                          </div>
                                    </div>';
                        } elseif ($master->SalesStatusPayment == 1) { 
                              $sales_payment_status = '<div class="tool-desc fw-bold bg-1">Sudah DP</div>';
                        } elseif ($master->SalesStatusPayment == 2) { 
                              $sales_payment_status = '<div class="tool-desc fw-bold bg-2">Sudah Lunas</div>';
                        } elseif ($master->SalesStatusPayment == 3) { 
                              $sales_payment_status = '<div class="tool-desc fw-bold bg-3">Dibatalkan</div>';
                        }  
                  /* ----------------------------------------------------------------------------------*/

                  /* -------------------------------------- DATA ITEM ---------------------------------*/
                        $totaldiscitem = 0;
                        $item = "";
                        $detail_item = "";
                        $query = $this->db->join("TblMsProduk","TblMsProduk.MsProdukId=TblSalesDetail.MsProdukId") 
                        ->join("TblMsSatuan","TblMsSatuan.SatuanId=TblSalesDetail.SatuanId")->where("SalesDetailRef",$master->SalesCode)->get("TblSalesDetail")->result();
                        foreach ($query as $row) { 
                              $detail_item .= "   " . $row->MsProdukName . " " .  $row->SalesDetailVarian . " (" . number_format($row->SalesDetailQty, 2) . " " . $row->SatuanName . ")\n";
                              if ($row->SalesDetailDiscTypeAll == 1) {
                                    $totaldiscitem += $row->SalesDetailDisc * $row->SalesDetailQty;
                                    $price = '  <span class="strikethrough">
                                                      <span class="fw-bold" style="color: gray;font-size:0.7rem;">Rp. ' . number_format($row->SalesDetailPrice) . '</span>
                                                </span><br>
                                                <span class="fw-bold text-dark" style="font-size:0.9rem;">Rp. ' . number_format($row->SalesDetailPrice - $row->SalesDetailDisc) . '</span> 
                                                <br>';
                                    $total = '  <span class="strikethrough">
                                                      <span class="fw-bold" style="color: gray;font-size:0.7rem;">Rp. ' . number_format($row->SalesDetailQty * $row->SalesDetailPrice) . '</span>
                                                </span><br>
                                                <span class="fw-bold text-dark" style="font-size:0.9rem;">Rp. ' . number_format($row->SalesDetailTotal) . '</span>
                                                <br>';
                              }elseif($row->SalesDetailDiscTypeAll == 2){       
                                    $totaldiscitem += $row->SalesDetailDiscTotal; 
                                    $price = '  <span class="fw-bold text-dark" style=" font-size:0.9rem;">Rp. ' . number_format($row->SalesDetailPrice) . '</span><br>';
                                    $total = '  <span class="strikethrough">
                                                      <span class="fw-bold" style="color: gray; font-size:0.7rem;">Rp. ' . number_format($row->SalesDetailQty * $row->SalesDetailPrice) . '</span>
                                                </span><br>
                                                <span class="fw-bold text-dark" style="font-size:0.9rem;">Rp. ' . number_format($row->SalesDetailTotal) . '</span>
                                                <br>';
                              } else {
                                    $price = '  <span class="fw-bold text-dark" style=" font-size:0.9rem;">Rp. ' . number_format($row->SalesDetailPrice) . '</span><br>';
                                    $total = '  <span class="fw-bold text-dark" style="font-size:0.9rem;">Rp. ' . number_format($row->SalesDetailTotal) . '</span>
                                                <br>';
                              }
                              if (file_exists(getcwd() . "/asset/image/produk/" .  $row->MsProdukId."/".$row->MsProdukCode."_1.png")) {
                                    $urlimage = base_url("asset/image/produk/".$row->MsProdukId."/".$row->MsProdukCode."_1.png");
                              }else{ 
                                    $urlimage = base_url("asset/image/mgs-erp/defaultitem.png");
                              }
                              $data_split_var =  explode("|",$row->SalesDetailVarian);
                              $varian = "";
                              foreach($data_split_var as $row1){
                                    $data_split_var_row =  explode(":",$row1);
                                    $varian .= '  <div class="row">
                                                      <div class="col-auto pe-0" style="min-width:70px;">
                                                            <span class="fw-bold text-secondary">'.$data_split_var_row[0].'</span>
                                                      </div>      
                                                      <div class="col pe-0">
                                                            <span class="text-dark fw-bold">'.$data_split_var_row[1].'</span>
                                                      </div>
                                                </div>';
                              } 
                              $item .= '<div class="row py-1 g-1 align-items-center bg-light">  
                                          <div class="col-md-6 col-12">
                                                <div class="d-flex">
                                                      <div class="flex-shrink-0">
                                                            <img class="lazy" style="width: 5rem; background: rgb(241, 241, 241); padding: 0.25rem; height: 5rem; object-fit: contain;" src="'.$urlimage.'">
                                                      </div>
                                                      <div class="flex-grow-1 ms-3">
                                                            <div class="row">
                                                                  <span class="fw-bold" style="font-size:0.9rem;">' . $row->MsProdukCode . ' - ' . $row->MsProdukName . ' </span>
                                                            </div>    
                                                            '. $varian .'
                                                      </div>
                                                </div> 
                                          </div>
                                          <div class="col-md-2 col-4">
                                                <span class="fw-bold text-secondary">Qty</span><br>
                                                <span class="text-dark fw-bold" style="font-size:0.9rem;">' . number_format($row->SalesDetailQty, 2) . ' ' . $row->SatuanName . '</span>
                                          </div>
                                          <div class="col-md-2 col-4">
                                                <span class="fw-bold text-secondary">Harga</span><br>
                                                ' . $price . '
                                          </div> 
                                          <div class="col-md-2 col-4 px-md-4 mt-0 mt-md-1 text-end">
                                                <span class="fw-bold text-secondary">Total</span><br>
                                                ' . $total . '
                                          </div>
                                    </div> ';
                        }
                        if (strlen($item) == 0) $item = "<div class='text-center'>Tidak Ada Data</div>";
                  /* ----------------------------------------------------------------------------------*/

                  /* -------------------------------------- DATA OPTIONAL -----------------------------*/
                        $optional = "";
                        $query = $this->db->query("select * from TblSalesOptional where SalesOptionalRef='" . $master->SalesCode . "'")->result();
                        foreach ($query as $row) {
                              $detail_item .= "   " . $row->SalesOptionalDesc . ")\n";

                              $optional .= '<div class="row py-1 g-1 bg-light">
                                                <div class="col-8">
                                                      <span class="fw-bold text-secondary">Deskripsi</span><br> 
                                                      <span class="fw-bold text-dark" style="font-size:0.9rem;">' . $row->SalesOptionalDesc . ' </span>
                                                </div>
                                                <div class="col-4 px-md-4 mt-0 mt-md-1 text-end">
                                                      <span class="fw-bold text-secondary">Total</span><br> 
                                                      <span class="fw-bold text-dark" style="font-size:0.9rem;">Rp. ' . number_format($row->SalesOptionalPrice) . '</span>
                                                </div>
                                          </div> ';
                        }
                        if (strlen($optional) != 0) $optional = " " . $optional;
                  /* ----------------------------------------------------------------------------------*/ 

                  /* -------------------------------------- DATA LIST SALES PERIODE -------------------*/
                        if ($date != $master->SalesDate) {
                              $date = $master->SalesDate;
                              $content = '<div class="flex bg-light text my-2 px-2"><span class="fw-bold">' . date_format(date_create($master->SalesDate), "d F Y") . '</span></div>';
                        } else {
                              $content = "";
                        }
                        
                        $promoname = $this->db->where("PromoCode",$master->SalesPromoCode)->get("TblPromo")->row();
                        $sales_promo ="";

                        if($promoname){
                              $sales_promo = "<div class='badge rounded-pill text-bg-primary me-2' style='font-size:0.75rem'>".$promoname->PromoName."</div>";
                        }
                        $html_tooltip_payment = '
                              <span class=\'tool-desc\'>Dibuat oleh : <br>' . $master->SalesCreateUser . ' <br>(' . $master->SalesCreate . ')</span><br>
                              <span class=\'tool-desc\'>Terakhir Diubah : <br>' . $master->SalesLastUpdateUser . ' <br>(' . $master->SalesLastUpdate . ')</span><br>';
                        $content .= ' <div class="row datatable-header">';
                  /* ----------------------------------------------------------------------------------*/ 
                  


                  /* -------------------------------------- DATA PEMBAYARAN ---------------------------*/ 
                        $index_payment = 0;
                        $payment = ""; 
                        $paymenttotal = 0;
                        $performatotal = 0;
                        $notif_payment = 0;


                        $query_pay_timeline = $this->db->join("TblMsMethod","TblMsMethod.MsMethodId=TblSalesPerforma.MsMethodId")->where("PerformaRef", $master->SalesCode)->get("TblSalesPerforma")->result();
                        foreach ($query_pay_timeline as $row) { 
                              // get ref
                              $query = $this->db->join("TblMsMethod","TblMsMethod.MsMethodId=TblSalesPayment.MsMethodId")->where("PaymentRef2", $row->PerformaId)->get("TblSalesPayment")->row();
                              $paymentref = "";
                              if($query){
                                    if ($query->PaymentApprove == 1) {
                                          $approve = '<span class="fa-stack text-success"  style="font-size: 0.6rem;" data-bs-toggle="tooltip" data-bs-placement="top" title="Sudah diverifikasi">
                                                                  <i class="fas fa-certificate fa-stack-2x"></i>
                                                                  <i class="fas fa-check fa-stack-1x text-white" style="font-size: 0.5rem;"></i>
                                                            </span>';
                                    } else {
                                          $notif_payment++;
                                          $approve = ' <span class="fa-stack text-warning"  style="font-size: 0.6rem;" data-bs-toggle="tooltip" data-bs-placement="top" title="Belum diverifikasi">
                                                                  <i class="fas fa-certificate fa-stack-2x"></i>
                                                                  <i class="fas fa-exclamation fa-stack-1x text-danger" style="font-size: 0.5rem;"></i>
                                                            </span>';
                                    }
                                    
                                    $paymenttotal += $query->PaymentTotal;
                                    $paymentref = '
                                          <ul class="time-line" >
                                                <li>  
                                                      <div class="card border-0 shadow">
                                                            <div class="card-body p-2">
                                                                  <span class="fw-bold" style="font-size:0.9rem">INVOICE '.$approve.'</span>
                                                                  <div class="row" style="font-size:0.75rem">
                                                                        <div class="col-6 col-md-2">
                                                                              <span class="fw-bold text-secondary" style="font-size:0.7rem">Tanggal</span><br>
                                                                              <span class="fw-bold text-dark">'.$query->PaymentDate.'</span>
                                                                        </div>
                                                                        <div class="col-6 col-md-2">
                                                                              <span class="fw-bold text-secondary" style="font-size:0.7rem">Metode</span><br>
                                                                              <span class="fw-bold text-dark">'.$query->MsMethodCode.'</span>
                                                                        </div>
                                                                        <div class="col-12 col-md-3">
                                                                              <span class="fw-bold text-secondary" style="font-size:0.7rem">Nama</span><br>
                                                                              <span class="fw-bold text-dark">'.$query->PaymentCardName.'</span>
                                                                        </div>
                                                                        <div class="col-4 col-md-2">
                                                                              <span class="fw-bold text-secondary" style="font-size:0.7rem">Type</span><br>
                                                                              <span class="fw-bold text-dark">'.($query->PaymentType == "D" ? "DP" : "Pelunasan").'</span>
                                                                        </div>
                                                                        <div class="col-8 col-md-2">
                                                                              <span class="fw-bold text-secondary" style="font-size:0.7rem">Total</span><br>
                                                                              <span class="fw-bold text-dark">Rp. '.number_format($query->PaymentTotal).'</span>
                                                                        </div> 
                                                                        <div class="col-12 col-md-1 text-end">   
                                                                              <hr class="my-1 d-md-none d-block">                             
                                                                              <div class="dropdown">
                                                                                    <a class="btn btn-sm btn-primary dropdown-toggle dropnone" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i><span class="ms-auto ms-md-none d-inline-block d-sm-none ps-2 ps-md-0" >Tindakan</span></a> 
                                                                                    <ul class="dropdown-menu dropdown-menu-sm">
                                                                                          <li><a class="dropdown-item" onclick="payment_view(' . $master->SalesId . ' ,\''.$query->PaymentImage.'\')"><i class="fas fa-eye" style="min-width:20px"></i>&nbsp;Lihat Bukti</a></li>
                                                                                          <li><hr class="dropdown-divider"></li>
                                                                                          <li><a class="dropdown-item" onclick="payment_edit(' . $query->PaymentId . ' )"><i class="fas fa-pencil-alt" style="min-width:20px"></i>&nbsp;Edit</a></li> 
                                                                                          <li><a class="dropdown-item" onclick="payment_print(' . $query->PaymentId . ' )"><i class="fas fa-print" style="min-width:20px"></i>&nbsp;Print</a></li> 
                                                                                          <li><a class="dropdown-item" onclick="payment_cancel(' . $query->PaymentId . ')"><i class="fas fa-times" style="min-width:20px"></i>&nbsp;Hapus</a></li>  
                                                                                    </ul>
                                                                              </div>
                                                                        </div>   
                                                                  </div>
                                                            </div>
                                                      </div>  
                                                </li>
                                          </ul>';

                              }
                              $payment .= ' 
                                          <li>  
                                                <div class="card border-0 shadow">
                                                      <div class="card-body p-2">
                                                            <span class="fw-bold" style="font-size:0.9rem">PROFORMA INVOICE</span>
                                                            <div class="row" style="font-size:0.75rem">
                                                                  <div class="col-6 col-md-2">
                                                                        <span class="fw-bold text-secondary" style="font-size:0.7rem">Tanggal</span><br>
                                                                        <span class="fw-bold text-dark">'.$row->PerformaDate.'</span>
                                                                  </div>
                                                                  <div class="col-6 col-md-2">
                                                                        <span class="fw-bold text-secondary" style="font-size:0.7rem">Metode</span><br>
                                                                        <span class="fw-bold text-dark">'.$row->MsMethodCode.'</span>
                                                                  </div>
                                                                  <div class="col-12 col-md-3">
                                                                        <span class="fw-bold text-secondary" style="font-size:0.7rem">Nama</span><br>
                                                                        <span class="fw-bold text-dark">'.$row->PerformaCardName.'</span>
                                                                  </div>
                                                                  <div class="col-4 col-md-2">
                                                                        <span class="fw-bold text-secondary" style="font-size:0.7rem">Type</span><br>
                                                                        <span class="fw-bold text-dark">'.($row->PerformaType == 1 ? "DP" : "Pelunasan").'</span>
                                                                  </div>
                                                                  <div class="col-8 col-md-2">
                                                                        <span class="fw-bold text-secondary" style="font-size:0.7rem">Total</span><br>
                                                                        <span class="fw-bold text-dark">Rp. '.number_format($row->PerformaTotal).'</span>
                                                                  </div> 
                                                                  <div class="col-12 col-md-1 text-end">   
                                                                        <hr class="my-1 d-md-none d-block">                             
                                                                        <div class="dropdown">
                                                                              <a class="btn btn-sm btn-primary dropdown-toggle dropnone" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i><span class="ms-auto ms-md-none d-inline-block d-sm-none ps-2 ps-md-0" >Tindakan</span></a> 
                                                                              <ul class="dropdown-menu dropdown-menu-sm">
                                                                                    <li><a class="dropdown-item d-none" onclick="performa_add(' . $master->SalesId . ' )"><i class="fas fa-eye" style="min-width:20px"></i>&nbsp;Lihat Bukti</a></li>
                                                                                    <li><hr class="dropdown-divider  d-none"></li>
                                                                                    <li><a class="dropdown-item" onclick="performa_edit(' . $row->PerformaId . ' )"><i class="fas fa-pencil-alt" style="min-width:20px"></i>&nbsp;Edit</a></li> 
                                                                                    <li><a class="dropdown-item" onclick="performa_print(' . $row->PerformaId . ' )"><i class="fas fa-print" style="min-width:20px"></i>&nbsp;Print</a></li> 
                                                                                    <li><a class="dropdown-item" onclick="performa_cancel(' . $row->PerformaId . ')"><i class="fas fa-times" style="min-width:20px"></i>&nbsp;Hapus</a></li> 
                                                                                    <li><hr class="dropdown-divider '.($query ? "d-none" : "").'"></li>
                                                                                    <li><a class="dropdown-item '.($query ? "d-none" : "").'" onclick="payment_add(' . $master->SalesId . ','.$row->PerformaId.')"><i class="fas fa-exchange-alt" style="min-width:20px"></i>&nbsp;Buat Invoice</a></li> 
                                                                              </ul>
                                                                        </div>
                                                                  </div>   
                                                            </div>
                                                      </div>
                                                </div> 
                                                '.$paymentref.' 
                                          </li>';

                              $performatotal += $row->PerformaTotal;
                        }  

                        $query = $this->db->join("TblMsMethod","TblMsMethod.MsMethodId=TblSalesPayment.MsMethodId")
                              ->group_start()->where("PaymentRef2", "")->or_where("PaymentRef2", "0")->group_end()->where("PaymentRef", $master->SalesCode)->get("TblSalesPayment")->result();
                        foreach ($query as $row) {  
                              if ($row->PaymentApprove == 1) {
                                    $approve = '<span class="fa-stack text-success"  style="font-size: 0.6rem;" data-bs-toggle="tooltip" data-bs-placement="top" title="Sudah diverifikasi">
                                                            <i class="fas fa-certificate fa-stack-2x"></i>
                                                            <i class="fas fa-check fa-stack-1x text-white" style="font-size: 0.5rem;"></i>
                                                      </span>';
                              } else {
                                    $approve = ' <span class="fa-stack text-warning"  style="font-size: 0.6rem;" data-bs-toggle="tooltip" data-bs-placement="top" title="Belum diverifikasi">
                                                            <i class="fas fa-certificate fa-stack-2x"></i>
                                                            <i class="fas fa-exclamation fa-stack-1x text-danger" style="font-size: 0.5rem;"></i>
                                                      </span>';
                              }
                              
                              $paymenttotal += $row->PaymentTotal;
                              $payment .= ' 
                                          <li>  
                                                <div class="card border-0 shadow">
                                                      <div class="card-body p-2">
                                                            <span class="fw-bold" style="font-size:0.9rem">INVOICE '.$approve.'</span>
                                                            <div class="row" style="font-size:0.75rem">
                                                                  <div class="col-6 col-md-2">
                                                                        <span class="fw-bold text-secondary" style="font-size:0.7rem">Tanggal</span><br>
                                                                        <span class="fw-bold text-dark">'.$row->PaymentDate.'</span>
                                                                  </div>
                                                                  <div class="col-6 col-md-2">
                                                                        <span class="fw-bold text-secondary" style="font-size:0.7rem">Metode</span><br>
                                                                        <span class="fw-bold text-dark">'.$row->MsMethodCode.'</span>
                                                                  </div>
                                                                  <div class="col-12 col-md-3">
                                                                        <span class="fw-bold text-secondary" style="font-size:0.7rem">Nama</span><br>
                                                                        <span class="fw-bold text-dark">'.$row->PaymentCardName.'</span>
                                                                  </div>
                                                                  <div class="col-4 col-md-2">
                                                                        <span class="fw-bold text-secondary" style="font-size:0.7rem">Type</span><br>
                                                                        <span class="fw-bold text-dark">'.($row->PaymentType == "D" ? "DP" : "Pelunasan").'</span>
                                                                  </div>
                                                                  <div class="col-8 col-md-2">
                                                                        <span class="fw-bold text-secondary" style="font-size:0.7rem">Total</span><br>
                                                                        <span class="fw-bold text-dark">Rp. '.number_format($row->PaymentTotal).'</span>
                                                                  </div> 
                                                                  <div class="col-12 col-md-1 text-end">   
                                                                        <hr class="my-1 d-md-none d-block">                             
                                                                        <div class="dropdown">
                                                                              <a class="btn btn-sm btn-primary dropdown-toggle dropnone" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i><span class="ms-auto ms-md-none d-inline-block d-sm-none ps-2 ps-md-0" >Tindakan</span></a> 
                                                                              <ul class="dropdown-menu dropdown-menu-sm">
                                                                                    <li><a class="dropdown-item" onclick="payment_view(' . $master->SalesId . ' ,\''.$row->PaymentImage.'\')"><i class="fas fa-eye" style="min-width:20px"></i>&nbsp;Lihat Bukti</a></li>
                                                                                    <li><hr class="dropdown-divider"></li>
                                                                                    <li><a class="dropdown-item" onclick="payment_edit(' . $row->PaymentId . ' )"><i class="fas fa-pencil-alt" style="min-width:20px"></i>&nbsp;Edit</a></li> 
                                                                                    <li><a class="dropdown-item" onclick="payment_print(' . $row->PaymentId . ' )"><i class="fas fa-print" style="min-width:20px"></i>&nbsp;Print</a></li> 
                                                                                    <li><a class="dropdown-item" onclick="payment_cancel(' . $row->PaymentId . ')"><i class="fas fa-times" style="min-width:20px"></i>&nbsp;Hapus</a></li> 
                                                                                    <li><hr class="dropdown-divider"></li>
                                                                                    <li><a class="dropdown-item" onclick="performa_add(' . $master->SalesId . ','.$row->PaymentId.')"><i class="fas fa-exchange-alt" style="min-width:20px"></i>&nbsp;Buat Proforma Invoice</a></li>  
                                                                              </ul>
                                                                        </div>
                                                                  </div>   
                                                            </div>
                                                      </div>
                                                </div>  
                                          </li> 
                                          ';   
                        }  
                        if (strlen($payment) == 0) $payment = '<li><div class="card border-0 shadow  d-inline-block">
                        <div class="card-body p-2"><span class="fw-bold text-dark" style="font-size:12px;">Belum Ada pembayaran yang dibuat</span></div></div></li>';
                  /* ----------------------------------------------------------------------------------*/

                  /* -------------------------------------- DATA BARANG ---------------------------*/ 
                        $session_item_PO = array();
                        $po = "";
                        $notif_po = 0;
                        $query = $this->db
                              ->select("* , a.MsWorkplaceCode as src , b.MsWorkplaceCode as dst")
                              ->join("TblMsVendor", "TblPO.MsVendorCode=TblMsVendor.MsVendorCode", "left")
                              ->join("TblMsWorkplace as a", "a.MsWorkplaceId=TblPO.MsWorkplaceId", "left")
                              ->join("TblMsWorkplace as b", "b.MsWorkplaceId=TblPO.PODst", "left")
                              ->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblPO.MsEmpId", "left")
                              ->like("SalesRef", $master->SalesCode)
                              ->get("TblPO")->result();
                        foreach ($query as $row) {  

                              //get data item PO
                              $query = $this->db->join("TblMsProduk","TblMsProduk.MsProdukId=TblPODetail.MsProdukId") 
                                    ->join("TblMsSatuan","TblMsSatuan.SatuanId=TblPODetail.SatuanId")->where("PODetailRef",$row->POCode)->get("TblPODetail")->result();
                              $itempo = "";
                              foreach($query as $rowitem){  
                                    if (file_exists(getcwd() . "/asset/image/produk/" .  $rowitem->MsProdukId."/".$rowitem->MsProdukCode."_1.png")) {
                                          $urlimage = base_url("asset/image/produk/".$rowitem->MsProdukId."/".$rowitem->MsProdukCode."_1.png");
                                    }else{ 
                                          $urlimage = base_url("asset/image/mgs-erp/defaultitem.png");
                                    }
                                    $data_split_var =  explode("|",$rowitem->PODetailVarian);
                                    $varian = "";
                                    $varianarr = ""; 
                                    foreach($data_split_var as $row1){
                                          $data_split_var_row =  explode(":",$row1);
                                          $varianarr .= $data_split_var_row[0] .":".$data_split_var_row[1]."|";
                                          $varian .= '   
                                                <div class="col-md-2 col-4">
                                                      <span class="fw-bold text-secondary" style="font-size:0.75rem">'.$data_split_var_row[0].'</span><br>
                                                      <span class="text-dark fw-bold" style="font-size:0.8rem;">'.$data_split_var_row[1].'</span>
                                                </div> ';
                                    } 
                                    $itempo .= '<div class="row py-1 g-1 align-items-center bg-light">  
                                                      <div class="col-md-1 col-6"> 
                                                            <img class="lazy" style="width: 2.5rem; background: rgb(241, 241, 241); padding: 0.25rem; height: 2.5rem; object-fit: contain;" src="'.$urlimage.'"> 
                                                      </div>
                                                            
                                                      <div class="col-md-3 col-4">
                                                            <span class="fw-bold text-secondary" style="font-size:0.75rem">Nama</span><br>
                                                            <span class="text-dark fw-bold" style="font-size:0.8rem;">'.$rowitem->MsProdukCode.' - '.$rowitem->MsProdukName.'</span>
                                                      </div> 
                                                      ' . $varian . ' 
                                                      
                                                      <div class="col-md-2 col-4">
                                                            <span class="fw-bold text-secondary" style="font-size:0.75rem">Qty</span><br>
                                                            <span class="text-dark fw-bold" style="font-size:0.8rem;">'.$rowitem->PODetailQty.' '.$rowitem->SatuanName.'</span>
                                                      </div> 
                                                </div> ';  
                                    array_push($session_item_PO,array("Varian"=>$varianarr,"code"=>$rowitem->MsProdukCode,"qty"=>$rowitem->PODetailQty,"ref"=>0,"receive"=>0)); 

                                                
                              }


                              //get data pengiriman 
                              $data_delivery = $this->db
                                    ->join("TblMsCustomerDelivery", "TblDelivery.MsCustomerDeliveryId = TblMsCustomerDelivery.MsCustomerDeliveryId", "left")
                                    ->join("TblMsWorkplace", "TblMsWorkplace.MsWorkplaceId = TblDelivery.MsCustomerDeliveryId", "left")
                                    ->join("TblMsDelivery", "TblDelivery.MsDeliveryId = TblMsDelivery.MsDeliveryId", "left")
                                    ->where("DeliveryRef2", $row->POCode)
                                    ->get("TblDelivery")->result();
                              $datadelivery = ""; 
                              $delivery = ""; 
                              foreach ($data_delivery as $row1) {
                                    if ($row1->DeliveryType > 2) {
                                          $receive = $row1->MsWorkplaceName;
                                          $telepon = $row1->MsWorkplaceTelp1;
                                          $address = $row1->MsWorkplaceAddress;
                                          $mapname =  $row1->MsWorkplaceMap;
                                          $maplat = $row1->MsWorkplaceLat;
                                          $maplng = $row1->MsWorkplaceLng;
                                    } else {
                                          $receive = $row1->MsCustomerDeliveryReceive;
                                          $telepon = $row1->MsCustomerDeliveryTelp;
                                          $address = $row1->MsCustomerDeliveryAddress;
                                          $mapname =  $row1->MsCustomerDeliveryName;
                                          $maplat = $row1->MsCustomerDeliveryLat;
                                          $maplng = $row1->MsCustomerDeliveryLng;
                                    }
      
                                    if ($row1->DeliveryType == 0) {
                                          $header = "TOKO <i class='fas fa-long-arrow-alt-right'></i> CUSTOMER";
                                          $ref = '';
                                    } else if ($row1->DeliveryType == 1) {
                                          $header = "GUDANG <i class='fas fa-long-arrow-alt-right'></i> CUSTOMER";
                                          $ref = '';
                                    } else if ($row1->DeliveryType == 2) {
                                          $header = "VENDOR <i class='fas fa-long-arrow-alt-right'></i> CUSTOMER";
                                          $ref =  ' <div class="row">
                                                      <div class="col-4">
                                                            <span class="text-secondary label-span">No. PO</span>
                                                      </div>
                                                      <div class="col-auto">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->DeliveryRef2 . '</span>
                                                      </div> 
                                                      </div> ';
                                    } else if ($row1->DeliveryType == 3) {
                                          $header = "VENDOR <i class='fas fa-long-arrow-alt-right'></i> TOKO";
                                          $ref = ' <div class="row">
                                                      <div class="col-4">
                                                            <span class="text-secondary label-span">No. PO</span>
                                                      </div>
                                                      <div class="col-auto">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->DeliveryRef2 . '</span>
                                                      </div> 
                                                      </div> ';
                                    } else if ($row1->DeliveryType == 4) {
                                          $header = "VENDOR <i class='fas fa-long-arrow-alt-right'></i> GUDANG";
                                          $ref = ' <div class="row">
                                                      <div class="col-4">
                                                            <span class="text-secondary label-span">No. PO</span>
                                                      </div>
                                                      <div class="col-auto">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->DeliveryRef2 . '</span>
                                                      </div> 
                                                </div> ';
                                    }

                                    if ($row1->DeliveryStatus == 0) {
                                          $valueprogress_delivery = 30;
                                          if($row1->MsDeliveryId>1){
                                                $button_proses = ' <button type="button" class="btn btn-transparent btn-sm mx-1 ms-auto" onclick="delivery_proses(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem"> 
                                                <i class="fas fa-share-square"></i>
                                                <span class="fw-bold">
                                                &nbsp;Proses
                                                </span>
                                                </button>';
                                          }else{
                                                $button_proses = '';
                                          }
                                          $button_delivery = ' <div class="col-md-12 d-flex">
                                                            <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_edit(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                                  <i class="fas fa-pencil-alt"></i>  
                                                                  <span class="fw-bold">
                                                                  &nbsp;Edit
                                                                  </span>
                                                            </button>
                                                            <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_print(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                                  <i class="fas fa-print"></i>  
                                                                  <span class="fw-bold">
                                                                  &nbsp;Print
                                                                  </span>
                                                            </button>
                                                            <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_delete(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                                  <i class="fas fa-times"></i>  
                                                                  <span class="fw-bold">
                                                                  &nbsp;Hapus
                                                                  </span>
                                                            </button>
                                                            '.$button_proses.'
                                                      </div>';
                                    } else if ($row1->DeliveryStatus == 1) {
                                          $valueprogress_delivery = 65;
                                          if($row1->MsDeliveryId>1){
                                                $button_proses = ' <button type="button" class="btn btn-transparent btn-sm mx-1 ms-auto" onclick="delivery_selesai(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem"> 
                                                <i class="fas fa-share-square"></i>
                                                <span class="fw-bold">
                                                &nbsp;Selesaikan
                                                </span>
                                                </button>';
                                          }else{
                                                $button_proses = '';
                                          }
                                          $button_delivery = ' <div class="col-md-12 d-flex">
                                                            <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_edit(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                                  <i class="fas fa-pencil-alt"></i>  
                                                                  <span class="fw-bold">
                                                                  &nbsp;Edit
                                                                  </span>
                                                            </button>
                                                            <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_print(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                                  <i class="fas fa-print"></i>  
                                                                  <span class="fw-bold">
                                                                  &nbsp;Print
                                                                  </span>
                                                            </button>
                                                            <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_delete(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                                  <i class="fas fa-times"></i>  
                                                                  <span class="fw-bold">
                                                                  &nbsp;Hapus
                                                                  </span>
                                                            </button>
                                                          '.$button_proses.'
                                                      </div>';
                                    } else if ($row1->DeliveryStatus == 2) {
                                          $valueprogress_delivery = 100;
                                          $button_delivery = ' <div class="col-md-12 d-flex"> 
                                                            <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_print(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                                  <i class="fas fa-print"></i>  
                                                                  <span class="fw-bold">
                                                                  &nbsp;Print
                                                                  </span>
                                                            </button>  
                                                            <button type="button" class="btn btn-transparent btn-sm mx-1 ms-auto" onclick="delivery_transfer(' . $row1->DeliveryId . ',\'PO\')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem"> 
                                                                  <i class="fas fa-share-square"></i>
                                                                  <span class="fw-bold">
                                                                  &nbsp;Buat GRPO
                                                                  </span>
                                                            </button> 
                                                      </div>';
                                    }else if ($row1->DeliveryStatus == 3) {
                                          $valueprogress_delivery = 100;
                                          $button_delivery = ' <div class="col-md-12 d-flex"> 
                                                            <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_print(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                                  <i class="fas fa-print"></i>  
                                                                  <span class="fw-bold">
                                                                  &nbsp;Print
                                                                  </span>
                                                            </button>   
                                                      </div>';
                                    }
      
                                    if ($row1->DeliveryJenis == 1) $via = "ENGKEL";
                                    if ($row1->DeliveryJenis == 2) $via = "PICK-UP";
                                    if ($row1->DeliveryJenis == 3) $via = "PS"; 


                                    $query1 = $this->db->join("TblMsProduk","TblMsProduk.MsProdukId=TblDeliveryDetail.MsProdukId") 
                                                ->join("TblMsSatuan","TblMsSatuan.SatuanId=TblDeliveryDetail.SatuanId")->where("DeliveryDetailRef",$row1->DeliveryCode)->get("TblDeliveryDetail")->result();

                                    $detaildelivery = ""; 
                                    foreach($query1 as $rowitem){  
                                          if (file_exists(getcwd() . "/asset/image/produk/" .  $rowitem->MsProdukId."/".$rowitem->MsProdukCode."_1.png")) {
                                                $urlimage = base_url("asset/image/produk/".$rowitem->MsProdukId."/".$rowitem->MsProdukCode."_1.png");
                                          }else{ 
                                                $urlimage = base_url("asset/image/mgs-erp/defaultitem.png");
                                          }
                                          $data_split_var =  explode("|",$rowitem->DeliveryDetailVarian);
                                          $varian = "";
                                          $varianarr = "";
                                          foreach($data_split_var as $rowvarian){
                                                $data_split_var_row =  explode(":",$rowvarian);
                                                $varianarr .= $data_split_var_row[0] .":".$data_split_var_row[1]."|";
                                                $varian .= '   
                                                      <div class="col-md-2 col-4">
                                                            <span class="fw-bold text-secondary" style="font-size:0.75rem">'.$data_split_var_row[0].'</span><br>
                                                            <span class="text-dark fw-bold" style="font-size:0.8rem;">'.$data_split_var_row[1].'</span>
                                                      </div> ';
                                          } 
                                          $detaildelivery .= '<div class="row py-1 g-1 align-items-center bg-light">  
                                                            <div class="col-md-1 col-6"> 
                                                                  <img class="lazy" style="width: 2.5rem; background: rgb(241, 241, 241); padding: 0.25rem; height: 2.5rem; object-fit: contain;" src="'.$urlimage.'"> 
                                                            </div>
                                                                  
                                                            <div class="col-md-3 col-4">
                                                                  <span class="fw-bold text-secondary" style="font-size:0.75rem">Nama</span><br>
                                                                  <span class="text-dark fw-bold" style="font-size:0.8rem;">'.$rowitem->MsProdukCode.' - '.$rowitem->MsProdukName.'</span>
                                                            </div> 
                                                            ' . $varian . ' 
                                                            
                                                            <div class="col-md-1 col-4">
                                                                  <span class="fw-bold text-secondary" style="font-size:0.75rem">Qty</span><br>
                                                                  <span class="text-dark fw-bold" style="font-size:0.8rem;">'.$rowitem->DeliveryDetailQty.' '.$rowitem->SatuanName.'</span>
                                                            </div> 
                                                            <div class="col-md-1 col-4">
                                                                  <span class="fw-bold text-secondary" style="font-size:0.75rem">Spare</span><br>
                                                                  <span class="text-dark fw-bold" style="font-size:0.8rem;">'.$rowitem->DeliveryDetailSpareQty.' '.$rowitem->SatuanName.'</span>
                                                            </div> 
                                                      </div> ';  

                                          //update qty delivery
                                          foreach($session_item_PO as $key => $rowsession){
                                                if ($rowsession['code'] == $rowitem->MsProdukCode && $rowsession['Varian'] == $varianarr)  $session_item_PO[$key]['ref'] += $rowitem->DeliveryDetailQty; 
                                          }
                                    } 
                                    //get data GRPO  
                                    $header_grpo = $this->db
                                    ->select("*, TblGRPO.MsWorkplaceId")
                                    ->join("TblMsVendor", "TblGRPO.MsVendorId=TblMsVendor.MsvendorId or TblGRPO.MsVendorCode=TblMsVendor.MsVendorCode", "left")
                                    ->join("TblMsWorkplace", "TblMsWorkplace.MsWorkplaceId=TblGRPO.MsWorkplaceId", "left")
                                    ->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblGRPO.MsEmpId", "left")
                                    ->like("GRPORef2", $row1->DeliveryCode)
                                    ->get("TblGRPO")->result();
                                    $grpo = ""; 
                                    foreach ($header_grpo as $rows_grpo) {
                                          if ($rows_grpo->GRPODst == 0) {
                                                $_receivegrpo = "CUSTOMER";
                                          } else {
                                                $_receivegrpo = $rows_grpo->MsWorkplaceCode;
                                          }

                                          $query1 = $this->db->join("TblMsProduk","TblMsProduk.MsProdukId=TblGRPODetail.MsProdukId") 
                                                ->join("TblMsSatuan","TblMsSatuan.SatuanId=TblGRPODetail.SatuanId")->where("GRPODetailRef",$rows_grpo->GRPOCode)->get("TblGRPODetail")->result();
                                          $detailgrpo = "";  
                                          foreach($query1 as $rowitem){  
                                                if (file_exists(getcwd() . "/asset/image/produk/" .  $rowitem->MsProdukId."/".$rowitem->MsProdukCode."_1.png")) {
                                                      $urlimage = base_url("asset/image/produk/".$rowitem->MsProdukId."/".$rowitem->MsProdukCode."_1.png");
                                                }else{ 
                                                      $urlimage = base_url("asset/image/mgs-erp/defaultitem.png");
                                                }
                                                $data_split_var =  explode("|",$rowitem->GRPODetailVarian);
                                                $varian = "";
                                                $varianarr = "";
                                                foreach($data_split_var as $rowvarian){
                                                      $data_split_var_row =  explode(":",$rowvarian);
                                                      $varianarr .= $data_split_var_row[0] .":".$data_split_var_row[1]."|";
                                                      $varian .= '   
                                                            <div class="col-md-2 col-4">
                                                                  <span class="fw-bold text-secondary" style="font-size:0.75rem">'.$data_split_var_row[0].'</span><br>
                                                                  <span class="text-dark fw-bold" style="font-size:0.8rem;">'.$data_split_var_row[1].'</span>
                                                            </div> ';
                                                } 
                                                $detailgrpo .= '<div class="row py-1 g-1 align-items-center bg-light">  
                                                            <div class="col-md-1 col-6"> 
                                                                  <img class="lazy" style="width: 2.5rem; background: rgb(241, 241, 241); padding: 0.25rem; height: 2.5rem; object-fit: contain;" src="'.$urlimage.'"> 
                                                            </div>
                                                                  
                                                            <div class="col-md-3 col-4">
                                                                  <span class="fw-bold text-secondary" style="font-size:0.75rem">Nama</span><br>
                                                                  <span class="text-dark fw-bold" style="font-size:0.8rem;">'.$rowitem->MsProdukCode.' - '.$rowitem->MsProdukName.'</span><br>
                                                                  <span class="text-secondary" style="font-size:0.8rem;">Catatan : '.$rowitem->GRPODetailWasteDesc.'</span>
                                                            </div> 
                                                            ' . $varian . ' 
                                                            
                                                            <div class="col-md-1 col-4">
                                                                  <span class="fw-bold text-secondary" style="font-size:0.75rem">Qty</span><br>
                                                                  <span class="text-dark fw-bold" style="font-size:0.8rem;">'.$rowitem->GRPODetailQty.' '.$rowitem->SatuanName.'</span>
                                                            </div> 
                                                            <div class="col-md-1 col-4">
                                                                  <span class="fw-bold text-secondary" style="font-size:0.75rem">Rusak</span><br>
                                                                  <span class="text-dark fw-bold" style="font-size:0.8rem;">'.$rowitem->GRPODetailWasteQty.' '.$rowitem->SatuanName.'</span>
                                                            </div> 
                                                      </div> ';  

                                                            //update qty GRPO
                                                            foreach($session_item_PO as $key => $rowsession){
                                                                  if ($rowsession['code'] == $rowitem->MsProdukCode && $rowsession['Varian'] == $varianarr)  $session_item_PO[$key]['receive'] += $rowitem->GRPODetailQty; 
                                                            }
                                          }  
                                          $grpo .= '
                                                <li>  
                                                      <div class="card border-0 shadow">
                                                            <div class="card-body p-2">
                                                                  <span class="fw-bold" style="font-size:0.9rem">
                                                                  <span class="fa-stack fa-1x">
                                                                        <i class="fas fa-square fa-stack-2x"></i>
                                                                        <i class="fas fa-hands fa-stack-1x text-white"></i> 
                                                                  </span>GRPO VENDOR ('.$rows_grpo->GRPOCode .')</span>
                                                                  <div class="row mb-2" style="font-size:0.75rem"> 
                                                                        <div class="col-6 col-md-2">
                                                                              <span class="fw-bold text-secondary" style="font-size:0.7rem">Tanggal</span><br>
                                                                              <span class="fw-bold text-dark">'.date_format(date_create($rows_grpo->GRPODate), "d F Y") . '</span>
                                                                        </div> 
                                                                        <div class="col-6 col-md-1">
                                                                              <span class="fw-bold text-secondary" style="font-size:0.7rem">Vendor</span><br>
                                                                              <span class="fw-bold text-dark">'.$rows_grpo->MsVendorCode . '</span>
                                                                        </div> 
                                                                        <div class="col-6 col-md-2">
                                                                              <span class="fw-bold text-secondary" style="font-size:0.7rem">Tujuan</span><br>
                                                                              <span class="fw-bold text-dark">'.$_receivegrpo . '</span>
                                                                        </div> 
                                                                        <div class="col-6 col-md-2">
                                                                              <span class="fw-bold text-secondary" style="font-size:0.7rem">Admin</span><br>
                                                                              <span class="fw-bold text-dark">'.$rows_grpo->MsEmpName . '</span>
                                                                        </div> 
                                                                        <div class="col-6 col-md-4">
                                                                              <span class="fw-bold text-secondary" style="font-size:0.7rem">Keterangan</span><br>
                                                                              <span class="fw-bold text-dark">'.$rows_grpo->GRPORemarks . '</span>
                                                                        </div> 
                                                                        <div class="col-6 col-md-1 text-end">
                                                                              <hr class="my-1 d-md-none d-block">                             
                                                                              <div class="dropdown">
                                                                                    <a class="btn btn-sm btn-primary dropdown-toggle dropnone" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i><span class="ms-auto ms-md-none d-inline-block d-sm-none ps-2 ps-md-0" >Tindakan</span></a> 
                                                                                    <ul class="dropdown-menu dropdown-menu-sm"> 
                                                                                          <li><a class="dropdown-item" onclick="grpo_edit(' . $rows_grpo->GRPOId . ')"><i class="fas fa-pencil-alt" style="min-width:20px"></i>&nbsp;Edit</a></li> 
                                                                                          <li><a class="dropdown-item" onclick="grpo_print_a5(' . $rows_grpo->GRPOId . ')"><i class="fas fa-print" style="min-width:20px"></i>&nbsp;Print</a></li>  
                                                                                          <li><a class="dropdown-item" onclick="grpo_delete(' . $rows_grpo->GRPOId . ')"><i class="fas fa-times" style="min-width:20px"></i>&nbsp;Hapus</a></li> 
                                                                                    </ul>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  '.$detailgrpo.'
                                                            </div>
                                                      </div>
                                                </li>
                                                ';
                                    }
                                    $delivery .= '
                                          <li>  
                                                <div class="card border-0 shadow">
                                                      <div class="card-body p-2">
                                                            <span class="fw-bold" style="font-size:0.9rem"> 
                                                                  <span class="fa-stack fa-1x">
                                                                        <i class="fas fa-square fa-stack-2x"></i>
                                                                        <i class="fas fa-truck fa-stack-1x text-white"></i> 
                                                                  </span>PENGIRIMAN ('.$row1->DeliveryCode .')</span>
                                                            <div class="row mb-2" style="font-size:0.75rem"> 
                                                                  <div class="col-6 col-md-2">
                                                                        <span class="fw-bold text-secondary" style="font-size:0.7rem">Tanggal</span><br>
                                                                        <span class="fw-bold text-dark">'.date_format(date_create($row1->DeliveryDate), "d F Y") . '</span>
                                                                  </div>
                                                                  <div class="col-6 col-md-1">
                                                                        <span class="fw-bold text-secondary" style="font-size:0.7rem">RIT</span><br>
                                                                        <span class="fw-bold text-dark">'.$row1->DeliveryRit.'</span>
                                                                  </div>
                                                                  <div class="col-6 col-md-3">
                                                                        <span class="fw-bold text-secondary" style="font-size:0.7rem">Armada</span><br>
                                                                        <span class="fw-bold text-dark">'.$row1->MsDeliveryName. ($row1->MsDeliveryId == 1 ? " (" . $via . ")" : "") . '</span>
                                                                  </div>
                                                                  <div class="col-6 col-md-2">
                                                                        <span class="fw-bold text-secondary" style="font-size:0.7rem">Penerima</span><br>
                                                                        <span class="fw-bold text-dark">'.$receive . '</span>
                                                                  </div> 
                                                                  <div class="col-6 col-md-4 text-end">
                                                                        <hr class="my-1 d-md-none d-block">                             
                                                                        <div class="dropdown">
                                                                              <a class="btn btn-sm btn-primary dropdown-toggle dropnone" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i><span class="ms-auto ms-md-none d-inline-block d-sm-none ps-2 ps-md-0" >Tindakan</span></a> 
                                                                              <ul class="dropdown-menu dropdown-menu-sm"> 
                                                                                    <li><a class="dropdown-item" onclick="delivery_edit(' . $row1->DeliveryId . ')"><i class="fas fa-pencil-alt" style="min-width:20px"></i>&nbsp;Edit</a></li> 
                                                                                    <li><a class="dropdown-item" onclick="delivery_print(' . $row1->DeliveryId . ')"><i class="fas fa-print" style="min-width:20px"></i>&nbsp;Print</a></li>  
                                                                                    <li><a class="dropdown-item" onclick="delivery_delete(' . $row1->DeliveryId . ')"><i class="fas fa-times" style="min-width:20px"></i>&nbsp;Hapus</a></li> 
                                                                                    <li><hr class="dropdown-divider '.(strlen($grpo) > 0 ? "d-none" :"").'"></li>
                                                                                    <li><a class="dropdown-item '.(strlen($grpo) > 0 ? "d-none" :"").'" onclick="delivery_transfer(' . $row1->DeliveryId . ',\'PO\')"><i class="fas fa-exchange-alt" style="min-width:20px"></i>&nbsp;Buat GRPO</a></li> 
                                                                              </ul>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-6 col-md-12">
                                                                        <span class="fw-bold text-secondary" style="font-size:0.7rem">Alamat</span><br>
                                                                        <span class="fw-bold text-dark">'.$address . '</span>
                                                                  </div> 
                                                            </div>
                                                            '.$detaildelivery.'
                                                      </div>
                                                </div>
                                          </li> 
                                          '.$grpo;
                                     
                                  


                              }

                              $create_delivery = null;
                              foreach($session_item_PO as $rowsession){
                                    if($rowsession['ref'] < $rowsession['qty']) $create_delivery = true;
                                    
                              }


                              $po .= '
                                    <li>  
                                          <div class="card border-0 shadow">
                                                <div class="card-body p-2">
                                                      <span class="fw-bold" style="font-size:0.9rem"> 
                                                            <span class="fa-stack fa-1x">
                                                            <i class="fas fa-square fa-stack-2x"></i>
                                                            <i class="fas fa-boxes fa-stack-1x text-white"></i> 
                                                      </span>PO VENDOR ('.$row->POCode.')</span>
                                                      <div class="row mb-2" style="font-size:0.75rem"> 
                                                            <div class="col-6 col-md-2">
                                                                  <span class="fw-bold text-secondary" style="font-size:0.7rem">Tanggal</span><br>
                                                                  <span class="fw-bold text-dark">'.date_format(date_create($row->PODate), "d F Y").'</span>
                                                            </div>
                                                            <div class="col-6 col-md-2">
                                                                  <span class="fw-bold text-secondary" style="font-size:0.7rem">Estimasi</span><br>
                                                                  <span class="fw-bold text-dark">'.date_format(date_create($row->POEstimate), "d F Y").'</span>
                                                            </div>
                                                            <div class="col-6 col-md-1">
                                                                  <span class="fw-bold text-secondary" style="font-size:0.7rem">Vendor</span><br>
                                                                  <span class="fw-bold text-dark">'.$row->MsVendorCode.'</span>
                                                            </div>
                                                            <div class="col-6 col-md-2">
                                                                  <span class="fw-bold text-secondary" style="font-size:0.7rem">Admin</span><br>
                                                                  <span class="fw-bold text-dark">'.$row->MsEmpName.'</span>  
                                                            </div>
                                                            <div class="col-6 col-md-2">
                                                                  <span class="fw-bold text-secondary" style="font-size:0.7rem">Tujuan</span><br>
                                                                  <span class="fw-bold text-dark">VENDOR<i class="fas fa-long-arrow-alt-right"></i>'.($row->PODst == 0 ? "CUSTOMER" : $row->dst).'</span>  
                                                            </div>
                                                            <div class="col-6 col-md-2">
                                                                  <span class="fw-bold text-secondary" style="font-size:0.7rem">Keterangan</span><br>
                                                                  <span class="fw-bold text-dark">'.$row->PORemarks.'</span>  
                                                            </div>
                                                            <div class="col-6 col-md-1 text-end">
                                                                  <hr class="my-1 d-md-none d-block">                             
                                                                  <div class="dropdown">
                                                                        <a class="btn btn-sm btn-primary dropdown-toggle dropnone" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i><span class="ms-auto ms-md-none d-inline-block d-sm-none ps-2 ps-md-0" >Tindakan</span></a> 
                                                                        <ul class="dropdown-menu dropdown-menu-sm"> 
                                                                              <li><a class="dropdown-item" onclick="po_edit(' . $row->POId . ')"><i class="fas fa-pencil-alt" style="min-width:20px"></i>&nbsp;Edit</a></li> 
                                                                              <li><a class="dropdown-item" onclick="po_print_a5(' . $row->POId . ')"><i class="fas fa-print" style="min-width:20px"></i>&nbsp;Print A5</a></li> 
                                                                              <li><a class="dropdown-item" onclick="po_print_a6(' . $row->POId . ')"><i class="fas fa-print" style="min-width:20px"></i>&nbsp;Print A6</a></li> 
                                                                              <li><a class="dropdown-item" onclick="po_delete(' . $row->POId . ')"><i class="fas fa-times" style="min-width:20px"></i>&nbsp;Hapus</a></li> 
                                                                              <li><hr class="dropdown-divider '.($create_delivery ? "" : "d-none").'"></li>
                                                                              <li><a class="dropdown-item '.($create_delivery ? "" : "d-none").'" onclick="delivery_add(' . $master->SalesId . ',\'PO\',' . $row->POId . ')"><i class="fas fa-exchange-alt" style="min-width:20px"></i>&nbsp;Buat Pengiriman</a></li> 
                                                                        </ul>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      '.$itempo .'
                                                </div>
                                          </div> 
                                          <ul class="time-line" > 
                                                '.$delivery.'
                                          </ul>
                                    </li>';
                        }





                        $delivery = "";
                        $session_item_TO = array();
                        $query = $this->db
                              ->select("*, a.MsWorkplaceCode as dstcode, b.MsWorkplaceCode as srccode")
                              ->join("TblMsWorkplace as a", "a.MsWorkplaceId=c.InvTODst", "LEFT")
                              ->join("TblMsWorkplace as b", "b.MsWorkplaceId=c.InvTOSrc", "LEFT")
                              ->join("TblMsEmployee", "TblMsEmployee.MsEmpId=c.MsEmpId", "left")
                              ->like("SalesRef", $master->SalesCode)
                              ->get("TblInvTO as c")->result();
                        foreach ($query as $row) { 
                               //get data item PO
                              $query = $this->db->join("TblMsProduk","TblMsProduk.MsProdukId=TblInvTODetail.MsProdukId") 
                                    ->join("TblMsSatuan","TblMsSatuan.SatuanId=TblInvTODetail.SatuanId")->where("InvTODetailRef",$row->InvTOCode)->get("TblInvTODetail")->result();
                              $itemto = "";
                              foreach($query as $rowitem){  
                                    if (file_exists(getcwd() . "/asset/image/produk/" .  $rowitem->MsProdukId."/".$rowitem->MsProdukCode."_1.png")) {
                                          $urlimage = base_url("asset/image/produk/".$rowitem->MsProdukId."/".$rowitem->MsProdukCode."_1.png");
                                    }else{ 
                                          $urlimage = base_url("asset/image/mgs-erp/defaultitem.png");
                                    }
                                    $data_split_var =  explode("|",$rowitem->InvTODetailVarian);
                                    $varian = "";
                                    $varianarr = ""; 
                                    foreach($data_split_var as $row1){
                                          $data_split_var_row =  explode(":",$row1);
                                          $varianarr .= $data_split_var_row[0] .":".$data_split_var_row[1]."|";
                                          $varian .= '   
                                                <div class="col-md-2 col-4">
                                                      <span class="fw-bold text-secondary" style="font-size:0.75rem">'.$data_split_var_row[0].'</span><br>
                                                      <span class="text-dark fw-bold" style="font-size:0.8rem;">'.$data_split_var_row[1].'</span>
                                                </div> ';
                                    } 
                                    $itemto .= '<div class="row py-1 g-1 align-items-center bg-light">  
                                                      <div class="col-md-1 col-6"> 
                                                            <img class="lazy" style="width: 2.5rem; background: rgb(241, 241, 241); padding: 0.25rem; height: 2.5rem; object-fit: contain;" src="'.$urlimage.'"> 
                                                      </div>
                                                            
                                                      <div class="col-md-3 col-4">
                                                            <span class="fw-bold text-secondary" style="font-size:0.75rem">Nama</span><br>
                                                            <span class="text-dark fw-bold" style="font-size:0.8rem;">'.$rowitem->MsProdukCode.' - '.$rowitem->MsProdukName.'</span>
                                                      </div> 
                                                      ' . $varian . ' 
                                                      
                                                      <div class="col-md-2 col-4">
                                                            <span class="fw-bold text-secondary" style="font-size:0.75rem">Qty</span><br>
                                                            <span class="text-dark fw-bold" style="font-size:0.8rem;">'.$rowitem->InvTODetailQty.' '.$rowitem->SatuanName.'</span>
                                                      </div> 
                                                </div> ';  
                                    array_push($session_item_TO,array("Varian"=>$varianarr,"code"=>$rowitem->MsProdukCode,"qty"=>$rowitem->InvTODetailQty,"ref"=>0,"receive"=>0)); 
                              }

                              
                              //get data pengiriman 
                              $data_delivery = $this->db
                                    ->join("TblMsCustomerDelivery", "TblDelivery.MsCustomerDeliveryId = TblMsCustomerDelivery.MsCustomerDeliveryId", "left")
                                    ->join("TblMsWorkplace", "TblMsWorkplace.MsWorkplaceId = TblDelivery.MsCustomerDeliveryId", "left")
                                    ->join("TblMsDelivery", "TblDelivery.MsDeliveryId = TblMsDelivery.MsDeliveryId", "left")
                                    ->where("DeliveryRef2", $row->InvTOCode)
                                    ->get("TblDelivery")->result();
                              $datadelivery = ""; 
                              $delivery = ""; 
                              foreach ($data_delivery as $row1) {
                                    if ($row1->DeliveryType > 2) {
                                          $receive = $row1->MsWorkplaceName;
                                          $telepon = $row1->MsWorkplaceTelp1;
                                          $address = $row1->MsWorkplaceAddress;
                                          $mapname =  $row1->MsWorkplaceMap;
                                          $maplat = $row1->MsWorkplaceLat;
                                          $maplng = $row1->MsWorkplaceLng;
                                    } else {
                                          $receive = $row1->MsCustomerDeliveryReceive;
                                          $telepon = $row1->MsCustomerDeliveryTelp;
                                          $address = $row1->MsCustomerDeliveryAddress;
                                          $mapname =  $row1->MsCustomerDeliveryName;
                                          $maplat = $row1->MsCustomerDeliveryLat;
                                          $maplng = $row1->MsCustomerDeliveryLng;
                                    }
      
                                    if ($row1->DeliveryType == 0) {
                                          $header = "TOKO <i class='fas fa-long-arrow-alt-right'></i> CUSTOMER";
                                          $ref = '';
                                    } else if ($row1->DeliveryType == 1) {
                                          $header = "GUDANG <i class='fas fa-long-arrow-alt-right'></i> CUSTOMER";
                                          $ref = '';
                                    } else if ($row1->DeliveryType == 2) {
                                          $header = "VENDOR <i class='fas fa-long-arrow-alt-right'></i> CUSTOMER";
                                          $ref =  ' <div class="row">
                                                      <div class="col-4">
                                                            <span class="text-secondary label-span">No. PO</span>
                                                      </div>
                                                      <div class="col-auto">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->DeliveryRef2 . '</span>
                                                      </div> 
                                                      </div> ';
                                    } else if ($row1->DeliveryType == 3) {
                                          $header = "VENDOR <i class='fas fa-long-arrow-alt-right'></i> TOKO";
                                          $ref = ' <div class="row">
                                                      <div class="col-4">
                                                            <span class="text-secondary label-span">No. PO</span>
                                                      </div>
                                                      <div class="col-auto">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->DeliveryRef2 . '</span>
                                                      </div> 
                                                      </div> ';
                                    } else if ($row1->DeliveryType == 4) {
                                          $header = "VENDOR <i class='fas fa-long-arrow-alt-right'></i> GUDANG";
                                          $ref = ' <div class="row">
                                                      <div class="col-4">
                                                            <span class="text-secondary label-span">No. PO</span>
                                                      </div>
                                                      <div class="col-auto">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->DeliveryRef2 . '</span>
                                                      </div> 
                                                </div> ';
                                    }

                                    if ($row1->DeliveryStatus == 0) {
                                          $valueprogress_delivery = 30;
                                          if($row1->MsDeliveryId>1){
                                                $button_proses = ' <button type="button" class="btn btn-transparent btn-sm mx-1 ms-auto" onclick="delivery_proses(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem"> 
                                                <i class="fas fa-share-square"></i>
                                                <span class="fw-bold">
                                                &nbsp;Proses
                                                </span>
                                                </button>';
                                          }else{
                                                $button_proses = '';
                                          }
                                          $button_delivery = ' <div class="col-md-12 d-flex">
                                                            <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_edit(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                                  <i class="fas fa-pencil-alt"></i>  
                                                                  <span class="fw-bold">
                                                                  &nbsp;Edit
                                                                  </span>
                                                            </button>
                                                            <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_print(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                                  <i class="fas fa-print"></i>  
                                                                  <span class="fw-bold">
                                                                  &nbsp;Print
                                                                  </span>
                                                            </button>
                                                            <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_delete(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                                  <i class="fas fa-times"></i>  
                                                                  <span class="fw-bold">
                                                                  &nbsp;Hapus
                                                                  </span>
                                                            </button>
                                                            '.$button_proses.'
                                                      </div>';
                                    } else if ($row1->DeliveryStatus == 1) {
                                          $valueprogress_delivery = 65;
                                          if($row1->MsDeliveryId>1){
                                                $button_proses = ' <button type="button" class="btn btn-transparent btn-sm mx-1 ms-auto" onclick="delivery_selesai(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem"> 
                                                <i class="fas fa-share-square"></i>
                                                <span class="fw-bold">
                                                &nbsp;Selesaikan
                                                </span>
                                                </button>';
                                          }else{
                                                $button_proses = '';
                                          }
                                          $button_delivery = ' <div class="col-md-12 d-flex">
                                                            <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_edit(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                                  <i class="fas fa-pencil-alt"></i>  
                                                                  <span class="fw-bold">
                                                                  &nbsp;Edit
                                                                  </span>
                                                            </button>
                                                            <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_print(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                                  <i class="fas fa-print"></i>  
                                                                  <span class="fw-bold">
                                                                  &nbsp;Print
                                                                  </span>
                                                            </button>
                                                            <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_delete(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                                  <i class="fas fa-times"></i>  
                                                                  <span class="fw-bold">
                                                                  &nbsp;Hapus
                                                                  </span>
                                                            </button>
                                                          '.$button_proses.'
                                                      </div>';
                                    } else if ($row1->DeliveryStatus == 2) {
                                          $valueprogress_delivery = 100;
                                          $button_delivery = ' <div class="col-md-12 d-flex"> 
                                                            <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_print(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                                  <i class="fas fa-print"></i>  
                                                                  <span class="fw-bold">
                                                                  &nbsp;Print
                                                                  </span>
                                                            </button>  
                                                            <button type="button" class="btn btn-transparent btn-sm mx-1 ms-auto" onclick="delivery_transfer(' . $row1->DeliveryId . ',\'PO\')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem"> 
                                                                  <i class="fas fa-share-square"></i>
                                                                  <span class="fw-bold">
                                                                  &nbsp;Buat GRPO
                                                                  </span>
                                                            </button> 
                                                      </div>';
                                    }else if ($row1->DeliveryStatus == 3) {
                                          $valueprogress_delivery = 100;
                                          $button_delivery = ' <div class="col-md-12 d-flex"> 
                                                            <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_print(' . $row1->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                                  <i class="fas fa-print"></i>  
                                                                  <span class="fw-bold">
                                                                  &nbsp;Print
                                                                  </span>
                                                            </button>   
                                                      </div>';
                                    }
      
                                    if ($row1->DeliveryJenis == 1) $via = "ENGKEL";
                                    if ($row1->DeliveryJenis == 2) $via = "PICK-UP";
                                    if ($row1->DeliveryJenis == 3) $via = "PS"; 


                                    $query1 = $this->db->join("TblMsProduk","TblMsProduk.MsProdukId=TblDeliveryDetail.MsProdukId") 
                                                ->join("TblMsSatuan","TblMsSatuan.SatuanId=TblDeliveryDetail.SatuanId")->where("DeliveryDetailRef",$row1->DeliveryCode)->get("TblDeliveryDetail")->result();

                                    $detaildelivery = ""; 
                                    foreach($query1 as $rowitem){  
                                          if (file_exists(getcwd() . "/asset/image/produk/" .  $rowitem->MsProdukId."/".$rowitem->MsProdukCode."_1.png")) {
                                                $urlimage = base_url("asset/image/produk/".$rowitem->MsProdukId."/".$rowitem->MsProdukCode."_1.png");
                                          }else{ 
                                                $urlimage = base_url("asset/image/mgs-erp/defaultitem.png");
                                          }
                                          $data_split_var =  explode("|",$rowitem->DeliveryDetailVarian);
                                          $varian = "";
                                          $varianarr = "";
                                          foreach($data_split_var as $rowvarian){
                                                $data_split_var_row =  explode(":",$rowvarian);
                                                $varianarr .= $data_split_var_row[0] .":".$data_split_var_row[1]."|";
                                                $varian .= '   
                                                      <div class="col-md-2 col-4">
                                                            <span class="fw-bold text-secondary" style="font-size:0.75rem">'.$data_split_var_row[0].'</span><br>
                                                            <span class="text-dark fw-bold" style="font-size:0.8rem;">'.$data_split_var_row[1].'</span>
                                                      </div> ';
                                          } 
                                          $detaildelivery .= '<div class="row py-1 g-1 align-items-center bg-light">  
                                                            <div class="col-md-1 col-6"> 
                                                                  <img class="lazy" style="width: 2.5rem; background: rgb(241, 241, 241); padding: 0.25rem; height: 2.5rem; object-fit: contain;" src="'.$urlimage.'"> 
                                                            </div>
                                                                  
                                                            <div class="col-md-3 col-4">
                                                                  <span class="fw-bold text-secondary" style="font-size:0.75rem">Nama</span><br>
                                                                  <span class="text-dark fw-bold" style="font-size:0.8rem;">'.$rowitem->MsProdukCode.' - '.$rowitem->MsProdukName.'</span>
                                                            </div> 
                                                            ' . $varian . ' 
                                                            
                                                            <div class="col-md-1 col-4">
                                                                  <span class="fw-bold text-secondary" style="font-size:0.75rem">Qty</span><br>
                                                                  <span class="text-dark fw-bold" style="font-size:0.8rem;">'.$rowitem->DeliveryDetailQty.' '.$rowitem->SatuanName.'</span>
                                                            </div> 
                                                            <div class="col-md-1 col-4">
                                                                  <span class="fw-bold text-secondary" style="font-size:0.75rem">Spare</span><br>
                                                                  <span class="text-dark fw-bold" style="font-size:0.8rem;">'.$rowitem->DeliveryDetailSpareQty.' '.$rowitem->SatuanName.'</span>
                                                            </div> 
                                                      </div> ';  

                                          //update qty delivery
                                          foreach($session_item_PO as $key => $rowsession){
                                                if ($rowsession['code'] == $rowitem->MsProdukCode && $rowsession['Varian'] == $varianarr)  $session_item_PO[$key]['ref'] += $rowitem->DeliveryDetailQty; 
                                          }
                                    } 


                                    //get data TI  
                                    $header_ti = $this->db
                                          ->select("*, a.MsWorkplaceCode as dstcode, b.MsWorkplaceCode as srccode")
                                          ->join("TblMsWorkplace as a", "a.MsWorkplaceId=c.InvTIDst", "LEFT")
                                          ->join("TblMsWorkplace as b", "b.MsWorkplaceId=c.InvTISrc", "LEFT")
                                          ->join("TblMsEmployee", "TblMsEmployee.MsEmpId=c.MsEmpId", "LEFT")
                                          ->like("InvTIRef", $row->InvTOCode)
                                          ->get("TblInvTI as c")->result();
                                    $transferti = ""; 
                                    foreach ($header_ti as $rows_ti) {
                                          if ($rows_ti->InvTIDst == 0) {
                                                $_receiveti = "CUSTOMER";
                                          } else {
                                                $_receiveti = $rows_ti->dstcode;
                                          }
                                          if ($rows_ti->InvTISrc == 0) {
                                                $_fromti = "CUSTOMER";
                                          } else {
                                                $_fromti = $rows_ti->srccode;
                                          }

                                          $query1 = $this->db->join("TblMsProduk","TblMsProduk.MsProdukId=TblInvTIDetail.MsProdukId") 
                                                ->join("TblMsSatuan","TblMsSatuan.SatuanId=TblInvTIDetail.SatuanId")->where("InvTIDetailRef",$rows_ti->InvTICode)->get("TblInvTIDetail")->result();
                                          $detailti = "";  
                                          foreach($query1 as $rowitem){  
                                                if (file_exists(getcwd() . "/asset/image/produk/" .  $rowitem->MsProdukId."/".$rowitem->MsProdukCode."_1.png")) {
                                                      $urlimage = base_url("asset/image/produk/".$rowitem->MsProdukId."/".$rowitem->MsProdukCode."_1.png");
                                                }else{ 
                                                      $urlimage = base_url("asset/image/mgs-erp/defaultitem.png");
                                                }
                                                $data_split_var =  explode("|",$rowitem->InvTIDetailVarian);
                                                $varian = "";
                                                $varianarr = "";
                                                foreach($data_split_var as $rowvarian){
                                                      $data_split_var_row =  explode(":",$rowvarian);
                                                      $varianarr .= $data_split_var_row[0] .":".$data_split_var_row[1]."|";
                                                      $varian .= '   
                                                            <div class="col-md-2 col-4">
                                                                  <span class="fw-bold text-secondary" style="font-size:0.75rem">'.$data_split_var_row[0].'</span><br>
                                                                  <span class="text-dark fw-bold" style="font-size:0.8rem;">'.$data_split_var_row[1].'</span>
                                                            </div> ';
                                                } 
                                                $detailti .= '<div class="row py-1 g-1 align-items-center bg-light">  
                                                            <div class="col-md-1 col-6"> 
                                                                  <img class="lazy" style="width: 2.5rem; background: rgb(241, 241, 241); padding: 0.25rem; height: 2.5rem; object-fit: contain;" src="'.$urlimage.'"> 
                                                            </div>
                                                                  
                                                            <div class="col-md-3 col-4">
                                                                  <span class="fw-bold text-secondary" style="font-size:0.75rem">Nama</span><br>
                                                                  <span class="text-dark fw-bold" style="font-size:0.8rem;">'.$rowitem->MsProdukCode.' - '.$rowitem->MsProdukName.'</span>
                                                            </div> 
                                                            ' . $varian . ' 
                                                            
                                                            <div class="col-md-1 col-4">
                                                                  <span class="fw-bold text-secondary" style="font-size:0.75rem">Qty</span><br>
                                                                  <span class="text-dark fw-bold" style="font-size:0.8rem;">'.$rowitem->InvTIDetailQty.' '.$rowitem->SatuanName.'</span>
                                                            </div> 
                                                            <div class="col-md-1 col-4">
                                                                  <span class="fw-bold text-secondary" style="font-size:0.75rem">Spare</span><br>
                                                                  <span class="text-dark fw-bold" style="font-size:0.8rem;">'.$rowitem->InvTIDetailSpareQty.' '.$rowitem->SatuanName.'</span>
                                                            </div> 
                                                      </div> ';  

                                                //update qty TO
                                                foreach($session_item_PO as $key => $rowsession){
                                                      if ($rowsession['code'] == $rowitem->MsProdukCode && $rowsession['Varian'] == $varianarr)  $session_item_PO[$key]['receive'] += $rowitem->InvTIDetailQty; 
                                                }
                                          }  
                                          $transferti .= '
                                                <li>  
                                                      <div class="card border-0 shadow">
                                                            <div class="card-body p-2">
                                                                  <span class="fw-bold" style="font-size:0.9rem">
                                                                  <span class="fa-stack fa-1x">
                                                                        <i class="fas fa-square fa-stack-2x"></i>
                                                                        <i class="fas fa-hands fa-stack-1x text-white"></i> 
                                                                  </span>Transfer IN ('.$rows_ti->InvTICode .')</span>
                                                                  <div class="row mb-2" style="font-size:0.75rem"> 
                                                                        <div class="col-6 col-md-2">
                                                                              <span class="fw-bold text-secondary" style="font-size:0.7rem">Tanggal</span><br>
                                                                              <span class="fw-bold text-dark">'.date_format(date_create($rows_ti->InvTIDate), "d F Y") . '</span>
                                                                        </div> 
                                                                        <div class="col-6 col-md-2">
                                                                              <span class="fw-bold text-secondary" style="font-size:0.7rem">Admin</span><br>
                                                                              <span class="fw-bold text-dark">'.$rows_ti->MsEmpName . '</span>
                                                                        </div> 
                                                                        <div class="col-6 col-md-1">
                                                                              <span class="fw-bold text-secondary" style="font-size:0.7rem">Dari</span><br>
                                                                              <span class="fw-bold text-dark">'.$_fromti . '</span>
                                                                        </div> 
                                                                        <div class="col-6 col-md-2">
                                                                              <span class="fw-bold text-secondary" style="font-size:0.7rem">Tujuan</span><br>
                                                                              <span class="fw-bold text-dark">'.$_receiveti . '</span>
                                                                        </div> 
                                                                        <div class="col-6 col-md-4">
                                                                              <span class="fw-bold text-secondary" style="font-size:0.7rem">Keterangan</span><br>
                                                                              <span class="fw-bold text-dark">'.$rows_ti->InvTIRemarks . '</span>
                                                                        </div> 
                                                                        <div class="col-6 col-md-1 text-end">
                                                                              <hr class="my-1 d-md-none d-block">                             
                                                                              <div class="dropdown">
                                                                                    <a class="btn btn-sm btn-primary dropdown-toggle dropnone" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i><span class="ms-auto ms-md-none d-inline-block d-sm-none ps-2 ps-md-0" >Tindakan</span></a> 
                                                                                    <ul class="dropdown-menu dropdown-menu-sm"> 
                                                                                          <li><a class="dropdown-item" onclick="transfer_in_edit(' . $rows_ti->InvTIId . ')"><i class="fas fa-pencil-alt" style="min-width:20px"></i>&nbsp;Edit</a></li> 
                                                                                          <li><a class="dropdown-item" onclick="transfer_in_print(' . $rows_ti->InvTIId . ')"><i class="fas fa-print" style="min-width:20px"></i>&nbsp;Print</a></li>  
                                                                                          <li><a class="dropdown-item" onclick="transfer_in_delete(' . $rows_ti->InvTIId . ')"><i class="fas fa-times" style="min-width:20px"></i>&nbsp;Hapus</a></li> 
                                                                                    </ul>
                                                                              </div>
                                                                        </div>
                                                                  </div>
                                                                  '.$detailti.'
                                                            </div>
                                                      </div>
                                                </li>
                                                ';
                                    }
                                    $delivery .= '
                                          <li>  
                                                <div class="card border-0 shadow">
                                                      <div class="card-body p-2">
                                                            <span class="fw-bold" style="font-size:0.9rem"> 
                                                                  <span class="fa-stack fa-1x">
                                                                        <i class="fas fa-square fa-stack-2x"></i>
                                                                        <i class="fas fa-truck fa-stack-1x text-white"></i> 
                                                                  </span>PENGIRIMAN ('.$row1->DeliveryCode .')</span>
                                                            <div class="row mb-2" style="font-size:0.75rem"> 
                                                                  <div class="col-6 col-md-2">
                                                                        <span class="fw-bold text-secondary" style="font-size:0.7rem">Tanggal</span><br>
                                                                        <span class="fw-bold text-dark">'.date_format(date_create($row1->DeliveryDate), "d F Y") . '</span>
                                                                  </div>
                                                                  <div class="col-6 col-md-1">
                                                                        <span class="fw-bold text-secondary" style="font-size:0.7rem">RIT</span><br>
                                                                        <span class="fw-bold text-dark">'.$row1->DeliveryRit.'</span>
                                                                  </div>
                                                                  <div class="col-6 col-md-3">
                                                                        <span class="fw-bold text-secondary" style="font-size:0.7rem">Armada</span><br>
                                                                        <span class="fw-bold text-dark">'.$row1->MsDeliveryName. ($row1->MsDeliveryId == 1 ? " (" . $via . ")" : "") . '</span>
                                                                  </div>
                                                                  <div class="col-6 col-md-2">
                                                                        <span class="fw-bold text-secondary" style="font-size:0.7rem">Penerima</span><br>
                                                                        <span class="fw-bold text-dark">'.$receive . '</span>
                                                                  </div> 
                                                                  <div class="col-6 col-md-4 text-end">
                                                                        <hr class="my-1 d-md-none d-block">                             
                                                                        <div class="dropdown">
                                                                              <a class="btn btn-sm btn-primary dropdown-toggle dropnone" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i><span class="ms-auto ms-md-none d-inline-block d-sm-none ps-2 ps-md-0" >Tindakan</span></a> 
                                                                              <ul class="dropdown-menu dropdown-menu-sm"> 
                                                                                    <li><a class="dropdown-item" onclick="delivery_edit(' . $row1->DeliveryId . ')"><i class="fas fa-pencil-alt" style="min-width:20px"></i>&nbsp;Edit</a></li> 
                                                                                    <li><a class="dropdown-item" onclick="delivery_print(' . $row1->DeliveryId . ')"><i class="fas fa-print" style="min-width:20px"></i>&nbsp;Print</a></li>  
                                                                                    <li><a class="dropdown-item" onclick="delivery_delete(' . $row1->DeliveryId . ')"><i class="fas fa-times" style="min-width:20px"></i>&nbsp;Hapus</a></li> 
                                                                                    <li><hr class="dropdown-divider '.(strlen($transferti) > 0 ? "d-none" :"").'"></li>
                                                                                    <li><a class="dropdown-item '.(strlen($transferti) > 0 ? "d-none" :"").'" onclick="delivery_transfer(' . $row1->DeliveryId . ',\'TO\')"><i class="fas fa-exchange-alt" style="min-width:20px"></i>&nbsp;Buat Transfer In</a></li> 
                                                                              </ul>
                                                                        </div>
                                                                  </div>
                                                                  <div class="col-6 col-md-12">
                                                                        <span class="fw-bold text-secondary" style="font-size:0.7rem">Alamat</span><br>
                                                                        <span class="fw-bold text-dark">'.$address . '</span>
                                                                  </div> 
                                                            </div>
                                                            '.$detaildelivery.'
                                                      </div>
                                                </div>
                                          </li> 
                                          '.$transferti;
                                     
                                  


                              }

                              $create_delivery = null;
                              foreach($session_item_TO as $rowsession){
                                    if($rowsession['ref'] < $rowsession['qty']) $create_delivery = true;
                                    
                              }
 
                              $po .= '
                              <li>  
                                    <div class="card border-0 shadow">
                                          <div class="card-body p-2">
                                                <span class="fw-bold" style="font-size:0.9rem">  
                                                <span class="fa-stack fa-1x">
                                                      <i class="fas fa-square fa-stack-2x"></i>
                                                      <i class="fas fa-dolly fa-stack-1x text-white"></i> 
                                                </span>Transfer OUT ('.$row->InvTOCode.')</span>
                                                <div class="row mb-2" style="font-size:0.75rem"> 
                                                      <div class="col-6 col-md-2">
                                                            <span class="fw-bold text-secondary" style="font-size:0.7rem">Tanggal</span><br>
                                                            <span class="fw-bold text-dark">'.date_format(date_create($row->InvTODate), "d F Y").'</span>
                                                      </div> 
                                                      <div class="col-6 col-md-2">
                                                            <span class="fw-bold text-secondary" style="font-size:0.7rem">Admin</span><br>
                                                            <span class="fw-bold text-dark">'.$row->MsEmpName.'</span>  
                                                      </div>
                                                      <div class="col-6 col-md-1">
                                                            <span class="fw-bold text-secondary" style="font-size:0.7rem">Dari</span><br>
                                                            <span class="fw-bold text-dark">'.$row->srccode.'</span>
                                                      </div>
                                                      <div class="col-6 col-md-1">
                                                            <span class="fw-bold text-secondary" style="font-size:0.7rem">Tujuan</span><br>
                                                            <span class="fw-bold text-dark">'.($row->dstcode == "" ? "CUSTOMER" : $row->dstcode).'</span>
                                                      </div>
                                                      <div class="col-6 col-md-5">
                                                            <span class="fw-bold text-secondary" style="font-size:0.7rem">Keterangan</span><br>
                                                            <span class="fw-bold text-dark">'.$row->InvTORemarks.'</span>  
                                                      </div>
                                                      <div class="col-6 col-md-1 text-end">
                                                            <hr class="my-1 d-md-none d-block">                             
                                                            <div class="dropdown">
                                                                  <a class="btn btn-sm btn-primary dropdown-toggle dropnone" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i><span class="ms-auto ms-md-none d-inline-block d-sm-none ps-2 ps-md-0" >Tindakan</span></a> 
                                                                  <ul class="dropdown-menu dropdown-menu-sm"> 
                                                                        <li><a class="dropdown-item" onclick="transfer_out_edit(' . $row->InvTOId . ')"><i class="fas fa-pencil-alt" style="min-width:20px"></i>&nbsp;Edit</a></li> 
                                                                        <li><a class="dropdown-item" onclick="transfer_out_print(' . $row->InvTOId . ')"><i class="fas fa-print" style="min-width:20px"></i>&nbsp;Print</a></li> 
                                                                        <li><a class="dropdown-item" onclick="transfer_out_delete(' . $row->InvTOId . ')"><i class="fas fa-times" style="min-width:20px"></i>&nbsp;Hapus</a></li> 
                                                                        <li><hr class="dropdown-divider '.($create_delivery ? "" : "d-none").'"></li>
                                                                        <li><a class="dropdown-item '.($create_delivery ? "" : "d-none").'" onclick="delivery_add(' . $master->SalesId . ',\'TO\',' . $row->InvTOId . ')"><i class="fas fa-exchange-alt" style="min-width:20px"></i>&nbsp;Buat Pengiriman</a></li> 
                                                                  </ul>
                                                            </div>
                                                      </div>
                                                </div>
                                                '.$itemto .'
                                          </div>
                                    </div> 
                                    <ul class="time-line" > 
                                          '.$delivery.'
                                    </ul>
                              </li>';

                        }
                        if (strlen($po) == 0) $po = '<li><div class="card border-0 shadow  d-inline-block">
                        <div class="card-body p-2"><span class="fw-bold text-dark" style="font-size:12px;">Belum Ada Dokument barang yang dibuat</span></div></div></li>';
                  /* --------------------------------------------------------------------------------*/


                  /* -------------------------------------- DATA HEADER -------------------------------*/ 
                        $content .= '
                              <div class="col-md-8 col-sm-6 p-1 g-1" >
                                    <div class="d-flex">
                                          <div class="flex-shrink-0">
                                                <img src="' . base_url("asset/image/logo/logo-") . $master->SalesHeader . '-200.png" class="rounded" width="60">
                                          </div>
                                          <div class="flex-grow-1">
                                                <div class="d-flex flex-wrap ms-2 pb-2">
                                                      <span class="fw-bold text-orange py-1" style="font-size:11px;">
                                                            ' . $master->SalesCode . '
                                                            <i class="fas fa-info-circle px-2" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_payment . '"></i>
                                                      </span>
                                                      <div class="d-inline pe-2 py-1">
                                                            <span class="fw-bold text-secondary pe-1" style="font-size:12px;"><i class="fas fa-calendar-alt"></i></span> 
                                                            <span class="text-dark" style="font-size:0.8rem;">' . date_format(date_create($master->SalesDate), "j M Y") . '</span>
                                                      </div>  
                                                      <div class="d-inline pe-2 py-1">
                                                            <span class="fw-bold text-secondary pe-1" style="font-size:12px;"><i class="fas fa-user-tie"></i></span> 
                                                            <span class="text-dark" style="font-size:12px;">' . $this->model_app->get_single_data("MsEmpName", "TblMsEmployee", array("MsEmpId" => $master->MsEmpId)) . '</span>  
                                                      </div>
                                                      ' . $sales_payment_status  . ' 
                                                      ' . $sales_date_tempo  . '  
                                                      ' . $sales_promo  . '  
                                                </div> 
                                          </div>
                                    </div> 
                                    <div class="row">
                                          <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                          </div>      
                                          <div class="col pe-0">
                                                <span class="text-dark text-uppercase" style="font-size:12px;">' . $sales_customer . '</span>
                                          </div>
                                    </div>
                                    <div class="row">
                                          <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                                          </div>      
                                          <div class="col pe-0">
                                                <span class="text-dark text-uppercase" style="font-size:12px;">' . $sales_telp . '</span>
                                          </div>
                                    </div>
                                    <div class="row">
                                          <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                                          </div>      
                                          <div class="col pe-0">
                                                <span class="text-dark" style="font-size:12px;">' . $master->MsCustomerAddress . '</span>
                                          </div>
                                    </div>
                              </div> 
                              <div class="col-md-4 col-sm-6 g-1" >
                                    <div class="box-in-table p-1 ">
                                          <div class="row border-bottom border-secondary mx-2">
                                                <div class="col-auto pe-0 ps-0" style="min-width:70px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">Disc Item&nbsp;<i class="far fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Disc item sudah terhitung dalam sub total"></i></span>
                                                </div>      
                                                <div class="col-auto px-0" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                </div>      
                                                <div class="col text-end pe-0">
                                                      <span class="fw-bold text-dark" style="font-size:12px;">' . number_format($totaldiscitem) . '</span>
                                                </div>      
                                          </div>
                                          <div class="row mx-2">
                                                <div class="col-auto pe-0 ps-0" style="min-width:70px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">Sub Total</span>
                                                </div>      
                                                <div class="col-auto px-0" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                </div>      
                                                <div class="col text-end pe-0">
                                                      <span class="fw-bold text-dark" style="font-size:12px;">' . number_format($master->SalesSubTotal) . '</span>
                                                </div>      
                                          </div>
                                          <div class="row mx-2">
                                                <div class="col-auto pe-0 ps-0" style="min-width:70px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">Pengiriman</span>
                                                </div>      
                                                <div class="col-auto px-0" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                </div>      
                                                <div class="col text-end pe-0">
                                                      <span class="fw-bold text-dark" style="font-size:12px;">' . number_format($master->SalesDeliveryTotal) . '</span>
                                                </div>      
                                          </div>
                                          <div class="row mx-2">
                                                <div class="col-auto pe-0 ps-0" style="min-width:70px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">Diskon</span>
                                                </div>      
                                                <div class="col-auto px-0" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                </div>      
                                                <div class="col text-end pe-0">
                                                      <span class="fw-bold text-dark" style="font-size:12px;">' . number_format($master->SalesDiscTotal) . '</span>
                                                </div>      
                                          </div>
                                          <div class="row border-bottom border-secondary mx-2">
                                                <div class="col-auto pe-0 ps-0" style="min-width:70px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">Grand Total</span>
                                                </div>      
                                                <div class="col-auto px-0" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                </div>      
                                                <div class="col text-end pe-0">
                                                      <span class="fw-bold text-dark" style="font-size:12px;">' . number_format($master->SalesGrandTotal) . '</span>
                                                </div>      
                                          </div>
                                          <div class="row border-bottom border-secondary mx-2">
                                                <div class="col-auto pe-0 ps-0" style="min-width:70px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">Bayar</span>
                                                </div>      
                                                <div class="col-auto px-0" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                </div>      
                                                <div class="col text-end pe-0">
                                                      <span class="fw-bold text-dark" style="font-size:12px;">' . number_format($paymenttotal) . '</span>
                                                </div>      
                                          </div>
                                          <div class="row mx-2">
                                                <div class="col-auto pe-0 ps-0" style="min-width:70px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">Sisa</span>
                                                </div>      
                                                <div class="col-auto px-0" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:10px;">: Rp.</span>
                                                </div>      
                                                <div class="col text-end pe-0">
                                                      <span class="fw-bold text-dark" style="font-size:12px;">' . number_format($master->SalesGrandTotal - $paymenttotal) . '</span>
                                                </div>      
                                          </div>
                                    </div>
                              </div>' . $item . $optional; 
                  /* ----------------------------------------------------------------------------------*/ 

                  /*-----------------------------------   DATA TAB  ------------------------------------*/ 
                        $content .= ' 
                              <div class="col-12 g-2 ">
                                    <ul class="nav nav-tabs" role="tablist">
                                          <li class="nav-item" role="presentation">
                                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#detail-pay-' . $master->SalesId . '" type="button" role="tab" aria-controls="detail-pay-' . $master->SalesId . '" aria-selected="false"><i class="fas fa-file-invoice-dollar pe-2"></i>Pembayaran</button>
                                          </li> 
                                          <li class="nav-item" role="presentation">
                                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#detail-item-' . $master->SalesId . '" type="button" role="tab" aria-controls="detail-item-' . $master->SalesId . '" aria-selected="true"><i class="fas fa-cubes pe-2"></i>Barang</button>
                                          </li>
                                    </ul>
                                    <div class="tab-content">
                                         
                                    <div class="tab-pane p-2 border border-top-0 fade show active" id="detail-pay-' . $master->SalesId . '"" role="tabpanel" aria-labelledby="detail-pay-' . $master->SalesId . '">  
                                                <ul class="time-line" > 
                                                      '.$payment.' 
                                                      <li class="'.($master->SalesGrandTotal > $performatotal && $master->SalesGrandTotal > $performatotal? "" : "d-none").'">  
                                                            <div class="dropdown">
                                                                  <a class="btn btn-sm btn-success dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">Tambah</a> 
                                                                  <ul class="dropdown-menu dropdown-menu-sm">
                                                                        <li><a class="dropdown-item '.($master->SalesGrandTotal > $performatotal ? "" : "d-none").'" onclick="performa_add(' . $master->SalesId . ',0)"><i class="fas fa-handshake" style="min-width:20px"></i>&nbsp;Buat Proforma</a></li>
                                                                        <li><a class="dropdown-item '.($master->SalesGrandTotal > $paymenttotal ? "" : "d-none").'" onclick="payment_add(' . $master->SalesId . ',0)"><i class="fas fa-money-bill" style="min-width:20px"></i>&nbsp;Buat Invoice</a></li> 
                                                                  </ul>
                                                            </div>
                                                      </li>
                                                </ul>
                                          </div>


                                          <div class="tab-pane p-2 border border-top-0 fade" id="detail-item-' . $master->SalesId . '"" role="tabpanel" aria-labelledby="detail-item-' . $master->SalesId . '"> 
                                                <ul class="time-line" >
                                                '.$po.'
                                                      <li>  
                                                            <div class="dropdown">
                                                                  <a class="btn btn-sm btn-success dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Tambah</a>  
                                                                  <ul class="dropdown-menu dropdown-menu-sm"> 
                                                                        <li><a class="dropdown-item" onclick="po_add(' . $master->SalesId.')"><i class="fas fa-boxes" style="min-width:20px"></i>&nbsp;Buat Purchase Order (PO)</a></li>
                                                                        <li><a class="dropdown-item" onclick="transfer_add(' . $master->SalesId.')"><i class="fas fa-exchange-alt" style="min-width:20px"></i>&nbsp;Buat Transfer Out (TO)</a></li> 
                                                                  </ul>
                                                            </div>
                                                      </li>
                                                </ul>
                                          </div>  
                                    </div>
                              </div>  
                              <div class="datatable-action px-0 py-2 mt-1">
                                    <button type="button" class="btn btn-outline-secondary btn-sm me-1" onclick="log_sales(' . $master->SalesId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                          <i class="fas fa-clipboard-list pe-1"></i><span class="fw-bold">Activity</span>
                                    </button>  
                                    <button type="button" class="btn btn-outline-secondary btn-sm me-1" onclick="log_approve(' . $master->SalesId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                          <i class="fas fa-check pe-1"></i><span class="fw-bold">Approval</span>
                                    </button>  
                                    <button type="button" class="btn btn-outline-secondary btn-sm me-1" onclick="log_edit(' . $master->SalesId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                          <i class="fas fa-pencil-alt pe-1"></i><span class="fw-bold">History</span>
                                    </button> 
                                    <div class="dropdown float-end dropup">   
                                          <button class="btn btn-primary btn-sm py-1 dropdown-toggle dropnone" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v pe-sm-2 pe-0"></i><span class="d-sm-inline-block d-none" >Tindakan</span>
                                          </button>
                                          <ul class="dropdown-menu dropdown-menu-sm w-16rem" style="">
                                                ' . $menu . '
                                          </ul>
                                    </div> 
                              </div> 
                              <script>
                                    $("[data-bs-toggle=\'tooltip\']").tooltip();
                                    
                              </script>
                        </div>';


                  $row = array();
                  $row[] = $content;
                  $row[] = $master->SalesId;
                  $data[] = $row;
            }


            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->m_penjualan->count_all(),
                  "recordsFiltered" => $this->m_penjualan->count_filtered(),
                  "data" => $data,
            );
            //output to json format
            echo json_encode($output);
      }

      function get_data_sales_ref()
      {
            $search = $this->input->post("search");
            $vendor = $this->model_app->get_single_data("MsVendorCode", "TblMsVendor", array("MsVendorId" => $this->input->post("vendor")));
            $datestart = $this->input->post("datestart");
            $dateend = $this->input->post("dateend");
            $store = $this->input->post("MsWorkplaceId");

            $this->db
                  ->join("TblSalesDetail", "TblSales.SalesCode=TblSalesDetail.SalesDetailRef", "left")
                  ->join("TblSalesOptional", "TblSales.SalesCode=TblSalesOptional.SalesOptionalRef", "left")
                  ->join("TblMsItem", "TblMsItem.MsItemId=TblSalesDetail.MsItemId", "left")
                  ->join("TblMsCustomer", "TblSales.MsCustomerId=TblMsCustomer.MsCustomerId", "left")
                  ->group_start()
                  ->like("TblMsCustomer.MsCustomerCode", $search)
                  ->or_like("MsCustomerName", $search)
                  ->or_like("MsCustomerCompany", $search)
                  ->or_like("MsCustomerAddress", $search)
                  ->or_like("SalesCode", $search)
                  ->or_like("MsItemCode", $search)
                  ->or_like("MsItemName", $search)
                  ->group_end()
                  ->where("MsWorkplaceId", $store)
                  ->where("SalesDate >=", $datestart)
                  ->where("SalesDate <=", $dateend);

            if ($vendor != "WHO")
                  $this->db->where("MsVendorCode", $vendor);

            $data = $this->db->order_by('SalesDate DESC,SalesId DESC')
                  ->group_by('SalesCode')
                  ->get("TblSales", 0, 10)->result();
            $content = "";
            foreach ($data as $row) {
                  $sales_telp = (($row->MsCustomerTelp2 == "" || $row->MsCustomerTelp2 == "-") ? $row->MsCustomerTelp1 : $row->MsCustomerTelp1 . " / " . $row->MsCustomerTelp2);
                  /* -------------------------------------- SET STATUS --------------------------------*/
                  $html_tooltip_payment = '
                        <span class=\'fa-stack text-secondary tool-info\'>
                              <i class=\'far fa-circle fa-stack-2x\'></i>
                              <i class=\'fas fa-dollar-sign fa-stack-1x\'></i>
                        </span>
                        <span class=\'tool-desc\'>Belum Lunas</span><br>
                        <span class=\'fa-stack text-primary tool-info\'>
                              <i class=\'far fa-circle fa-stack-2x\'></i>
                              <i class=\'fas fa-dollar-sign fa-stack-1x\'></i>
                        </span>
                        <span class=\'tool-desc\'>Sudah DP</span><br>
                        <span class=\'fa-stack text-success tool-info\'>
                              <i class=\'far fa-circle fa-stack-2x\'></i>
                              <i class=\'fas fa-dollar-sign fa-stack-1x\'></i>
                        </span>
                        <span class=\'tool-desc\'>Sudah Lunas</span><br>
                        <span class=\'fa-stack text-danger tool-info\'>
                              <i class=\'far fa-circle fa-stack-2x\'></i>
                              <i class=\'fas fa-dollar-sign fa-stack-1x\'></i>
                        </span>
                        <span class=\'tool-desc\'>Dibatalkan</span><br>';

                  if ($row->SalesStatusPayment == 0) {
                        $sales_payment = '
                        <span class="fa-stack text-secondary" style="vertical-align: top;font-size:0.8rem"  data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_payment . '">
                              <i class="far fa-circle fa-stack-2x"></i>
                              <i class="fas fa-dollar-sign fa-stack-1x"></i>
                        </span>';
                  } elseif ($row->SalesStatusPayment == 1) {
                        $sales_payment = '
                        <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem"   data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_payment . '">
                              <i class="far fa-circle fa-stack-2x"></i>
                              <i class="fas fa-dollar-sign fa-stack-1x"></i>
                        </span>';
                  } elseif ($row->SalesStatusPayment == 2) {
                        $sales_payment = '
                        <span class="fa-stack text-success" style="vertical-align: top;font-size:0.8rem"  data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_payment . '">
                              <i class="far fa-circle fa-stack-2x"></i>
                              <i class="fas fa-dollar-sign fa-stack-1x"></i>
                        </span>';
                  } elseif ($row->SalesStatusPayment == 3) {
                        $sales_payment = '
                        <span class="fa-stack text-danger" style="vertical-align: top;font-size:0.8rem"   data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_payment . '">
                              <i class="far fa-circle fa-stack-2x"></i>
                              <i class="fas fa-dollar-sign fa-stack-1x"></i>
                        </span>';
                  }
                  $html_tooltip_delivery = '
                        <span class=\'fa-stack text-secondary tool-info\'>
                              <i class=\'far fa-circle fa-stack-2x\'></i>
                              <i class=\'fas fa-truck fa-stack-1x\'></i>
                        </span>
                        <span class=\'tool-desc\'>Belum Dijadwalkan</span><br>

                        <span class=\'fa-stack text-primary tool-info\'>
                              <i class=\'far fa-circle fa-stack-2x\'></i>
                              <i class=\'fas fa-truck fa-stack-1x\'></i>
                        </span>
                        <span class=\'tool-desc\'>Pengiriman</span><br>

                        <span class=\'fa-stack text-success tool-info\'>
                              <i class=\'far fa-circle fa-stack-2x\'></i>
                              <i class=\'fas fa-truck fa-stack-1x\'></i>
                        </span>
                        <span class=\'tool-desc\'>Selesai</span><br>

                        <span class=\'fa-stack text-danger tool-info\'>
                              <i class=\'far fa-circle fa-stack-2x\'></i>
                              <i class=\'fas fa-truck fa-stack-1x\'></i>
                        </span>
                        <span class=\'tool-desc\'>Dibatalkan</span><br>

                        <span class=\'fa-stack text-info tool-info\'>
                              <i class=\'far fa-circle fa-stack-2x\'></i>
                              <i class=\'fas fa-truck fa-stack-1x\'></i>
                        </span>
                        <span class=\'tool-desc\'>Tidak Ada Pengiriman</span><br>';
                  if ($row->SalesStatusDelivery == 0) {
                        $sales_delivery = '
                        <span class="fa-stack text-secondary" style="vertical-align: top;font-size:0.8rem"  data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_delivery . '">
                              <i class="far fa-circle fa-stack-2x"></i>
                              <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                        </span>';
                  } elseif ($row->SalesStatusDelivery == 1) {
                        $sales_delivery = '
                        <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem"   data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_delivery . '">
                              <i class="far fa-circle fa-stack-2x"></i>
                              <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                        </span>';
                  } elseif ($row->SalesStatusDelivery == 2) {
                        $sales_delivery = '
                        <span class="fa-stack text-success" style="vertical-align: top;font-size:0.8rem"   data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_delivery . '">
                              <i class="far fa-circle fa-stack-2x"></i>
                              <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                        </span>';
                  } elseif ($row->SalesStatusDelivery == 3) {
                        $sales_delivery = '
                        <span class="fa-stack text-danger" style="vertical-align: top;font-size:0.8rem"   data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_delivery . '">
                              <i class="far fa-circle fa-stack-2x"></i>
                              <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                        </span>';
                  } elseif ($row->SalesStatusDelivery == 4) {
                        $sales_delivery = '
                        <span class="fa-stack text-info" style="vertical-align: top;font-size:0.8rem"   data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_delivery . '">
                              <i class="far fa-circle fa-stack-2x"></i>
                              <i class="fas fa-truck fa-stack-1x" style="font-size:0.5rem"></i>
                        </span>';
                  }
                  $html_tooltip_po = '
                        <span class=\'fa-stack text-secondary tool-info\'>
                              <i class=\'far fa-circle fa-stack-2x\'></i>
                              <i class=\'fas fa-cubes fa-stack-1x\'></i>
                        </span>
                        <span class=\'tool-desc\'>Belum PO</span><br>

                        <span class=\'fa-stack text-primary tool-info\'>
                              <i class=\'far fa-circle fa-stack-2x\'></i>
                              <i class=\'fas fa-cubes fa-stack-1x\'></i>
                        </span>
                        <span class=\'tool-desc\'>Proses Vendor</span><br>

                        <span class=\'fa-stack text-success tool-info\'>
                              <i class=\'far fa-circle fa-stack-2x\'></i>
                              <i class=\'fas fa-cubes fa-stack-1x\'></i>
                        </span>
                        <span class=\'tool-desc\'>Ready</span><br>

                        <span class=\'fa-stack text-danger tool-info\'>
                              <i class=\'far fa-circle fa-stack-2x\'></i>
                              <i class=\'fas fa-cubes fa-stack-1x\'></i>
                        </span>
                        <span class=\'tool-desc\'>Dibatalkan</span><br>';
                  if ($row->SalesStatusPO == 0) {
                        $sales_po = '
                        <span class="fa-stack text-secondary" style="vertical-align: top;font-size:0.8rem"   data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_po . '">
                              <i class="far fa-circle fa-stack-2x"></i>
                              <i class="fas fa-cubes fa-stack-1x"></i>
                        </span>';
                  } elseif ($row->SalesStatusPO == 1) {
                        $sales_po = '
                        <span class="fa-stack text-primary" style="vertical-align: top;font-size:0.8rem"    data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_po . '">
                              <i class="far fa-circle fa-stack-2x"></i>
                              <i class="fas fa-cubes fa-stack-1x"></i>
                        </span>';
                  } elseif ($row->SalesStatusPO == 2) {
                        $sales_po = '
                        <span class="fa-stack text-success" style="vertical-align: top;font-size:0.8rem"   data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_po . '">
                              <i class="far fa-circle fa-stack-2x"></i>
                              <i class="fas fa-cubes fa-stack-1x"></i>
                        </span>';
                  } elseif ($row->SalesStatusPO == 3) {
                        $sales_po = '
                        <span class="fa-stack text-danger" style="vertical-align: top;font-size:0.8rem"   data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_po . '">
                              <i class="far fa-circle fa-stack-2x"></i>
                              <i class="fas fa-cubes fa-stack-1x"></i>
                        </span>';
                  }
                  /* ----------------------------------------------------------------------------------*/
                  $this->db->join("TblMsItem", "TblSalesDetail.MsItemId=TblMsItem.MsItemId", "left")
                        ->join("TblMsItemCategory", "TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId ", "left")
                        ->where("SalesDetailRef", $row->SalesCode);
                  if ($vendor != "WHO")
                        $this->db->where("MsVendorCode", $vendor);
                  $query = $this->db->get("TblSalesDetail")->result();

                  $item = "";
                  foreach ($query as $rows) {
                        $item .= '<div class="row py-1 g-2">
                                    <div class="col-md-4 col-12 ps-md-4">
                                          <span class="fw-bold" style="font-size:0.7rem;">' . $rows->MsItemCode . ' - ' . $rows->MsItemName . ' </span> 
                                    </div>
                                    <div class="col-md-8 col-8 px-md-2 mt-0 mt-md-1">
                                          <div class="row g-1 mt-0 mt-md-1" style="font-size:0.75rem">
                                                <div class="col-md-6 mt-0 mt-md-1"> 
                                                      <div class="row">
                                                            <div class="col-auto pe-0" style="min-width:70px;">
                                                                  <span class="fw-bold">Vendor</span>
                                                            </div>      
                                                            <div class="col pe-0">
                                                                  <span class="fw-bold">' . $rows->MsVendorCode . '</span>
                                                            </div>
                                                      </div>
                                                </div>
                                                <div class="col-md-6 mt-0 mt-md-1">
                                                      <div class="row">
                                                            <div class="col-auto pe-0" style="min-width:70px;">
                                                                  <span class="fw-bold text-secondary">Ukuran</span>
                                                            </div>      
                                                            <div class="col pe-0">
                                                                  <span class="text-dark fw-bold">' . $rows->MsItemSize . '</span>
                                                            </div>
                                                      </div>
                                                      <div class="row">
                                                            <div class="col-auto pe-0 " style="min-width:70px;">
                                                                  <span class="fw-bold text-secondary">Qty</span>
                                                            </div>      
                                                            <div class="col pe-0">
                                                                  <span class="text-dark fw-bold">' . number_format($rows->SalesDetailQty) . ' ' . $rows->MsItemUoM . '</span>
                                                            </div>
                                                      </div>
                                                      <div class="row">
                                                            <div class="col-auto pe-0 " style="min-width:70px;">
                                                                  <span class="fw-bold text-secondary">Sudah Di PO</span>
                                                            </div>      
                                                            <div class="col pe-0">
                                                                  <span class="text-dark fw-bold">' . $this->get_data_qty($row->SalesCode, $rows->MsItemId, $rows->MsVendorCode) . ' ' . $rows->MsItemUoM . '</span>
                                                            </div>
                                                      </div>
                                                </div>
                                          </div>
                                    </div> 
                              </div> ';
                  }
                  if (strlen($item) == 0) $item = "<div class='text-center'>Tidak Ada Data</div>";

                  $content .= '<div class="row datatable-header m-1">
                                    <div class="col-md-5 col-sm-12 p-1 g-1">
                                          <div class="row"> 
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <img src="' . base_url("asset/image/logo/logo-") . $row->SalesHeader . '-200.png" class="rounded" width="40">
                                                </div>      
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-orange" style="font-size:11px;">' . $row->SalesCode . '</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                                </div>      
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">' . $this->model_app->get_customer_name($row->MsCustomerId) . '</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                                                </div>      
                                                <div class="col pe-0">
                                                      <span class="text-dark text-uppercase" style="font-size:12px;">' . $sales_telp . '</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                                                </div>      
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">' . $row->MsCustomerAddress . '</span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 p-1 g-1" >
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-calendar-alt"></i></span>
                                                </div>      
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">' . date_format(date_create($row->SalesDate), "d F Y") . '</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-user-tie"></i></span>
                                                </div>      
                                                <div class="col pe-0">
                                                      <span class="text-dark" style="font-size:12px;">' . $this->model_app->get_single_data("MsEmpName", "TblMsEmployee", array("MsEmpId" => $row->MsEmpId)) . '</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col pe-0" style="margin-top: 0.5rem;">
                                                ' . $sales_payment .  '
                                                </div>
                                          </div>
                                    </div> 
                                    <div class="col-12 g-1">
                                          <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                      <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#detail-item-' . $row->SalesId . '" type="button" role="tab" aria-controls="detail-item-' . $row->SalesId . '" aria-selected="true">Detail Item</button>
                                                </li> 
                                          </ul>
                                          <div class="tab-content" >
                                                <div class="tab-pane p-2 border border-top-0 fade show active" id="detail-item-' . $row->SalesId . '"" role="tabpanel" aria-labelledby="detail-item-' . $row->SalesId . '">
                                                      ' . $item . ' 
                                                </div> 
                                          </div>
                                    </div> 
                                    <div class="datatable-action py-2 mt-1"> 
                                          <div class="dropdown float-end dropup"> 
                                                <button class="btn btn-success btn-sm py-1" type="button" onclick="sales_select(\'' . $row->SalesId . '\',\'' . $row->MsVendorCode . '\')">
                                                      pilih data ini
                                                </button>
                                          </div>
                                    </div>
                              </div>
                              <script>
                                    $("[data-bs-toggle=\'tooltip\']").tooltip();
                                    
                              </script>';
            }
            if ($content == "") {
                  $content = '
                        <div>
					<img src="' . base_url("asset/image/iconnotfound.png") . '" class="rounded mx-auto d-block" alt="...">
				</div>';
            }
            echo $content;
      }

      function get_data_qty($code, $item, $vendor)
      {
            $datadetail = $this->db
                  ->join("TblPODetail", "TblPO.POCode=TblPODetail.PODetailRef", "left")
                  ->join("TblMsItem", "TblMsItem.MsItemId=TblPODetail.MsItemId", "left")
                  ->join("TblMsVendor", "TblPODetail.MsVendorCode=TblMsVendor.MsVendorCode", "left")
                  ->join("TblMsItemCategory", "TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId", "left")
                  ->where("SalesRef", $code)->get("TblPO")->result();
            $count = 0;
            foreach ($datadetail as $rows) {

                  if ($rows->MsItemId == $item && $rows->MsVendorCode == $vendor) {
                        $count += $rows->PODetailQty;
                  }
            }
            return $count;
      }
      
      function get_data_kunjungan()
      {
            // SETUP DATATABLE
            $this->m_penjualan->table = 'TblVisitor';
            $this->m_penjualan->tablejoin = array(
                  array(0 => 'TblMsWorkplace', 1 => 'TblMsWorkplace.MsWorkplaceId=TblVisitor.MsWorkplaceId')
            );
            $this->m_penjualan->column_order = array(null, 'VisitorDate', 'MsWorkplaceCode', 'VisitorType', 'VisitorName', 'VisitorDescription', 'VisitorVia'); //set column field database for datatable orderable
            $this->m_penjualan->column_search = array('VisitorDate', 'MsWorkplaceCode', 'VisitorType', 'VisitorName', 'VisitorDescription', 'VisitorVia'); //set column field database for datatable searchable 
            $this->m_penjualan->order = array('VisitorDate' => 'desc'); // default order 

            // PROSES DATA
            $list = $this->m_penjualan->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $master) {
                  $no++;
                  $row = array();
                  $row[] = $no;
                  $row[] = $master->VisitorDate;
                  $row[] = $master->MsWorkplaceCode;
                  $row[] = ($master->VisitorType == 0 ? '<span class="text-danger">Baru</span>' : '<span class="text-primary">Lama</span>');
                  $row[] = $master->VisitorVia;
                  $row[] = ' 
                              <span class="fa-stack ' . ($master->VisitorKonsultasi == 0 ? 'text-muted' : 'text-success') . '" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="Konsultasi">
                                    <i class="far fa-circle fa-stack-2x"></i>
                                    <i class="fas fa-chalkboard-teacher fa-stack-1x"></i>
                              </span>
                              <span class="fa-stack ' . ($master->VisitorSampel == 0 ? 'text-muted' : 'text-success') . '" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="sampel">
                                    <i class="far fa-circle fa-stack-2x"></i>
                                    <i class="fas fa-cubes fa-stack-1x"></i>
                              </span>
                              <span class="fa-stack ' . ($master->VisitorPembelian == 0 ? 'text-muted' : 'text-success') . '" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="Pembelian">
                                    <i class="far fa-circle fa-stack-2x"></i>
                                    <i class="fas fa-shopping-bag fa-stack-1x"></i>
                              </span>
                              <span class="fa-stack ' . ($master->VisitorPengambilan == 0 ? 'text-muted' : 'text-success') . '" style="vertical-align: top;font-size:0.8rem" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="Pengambilan">
                                    <i class="far fa-circle fa-stack-2x"></i>
                                    <i class="fas fa-truck-loading fa-stack-1x"></i>
                              </span>
                              
                              <script>
                                    $("[data-bs-toggle=\'tooltip\']").tooltip()
                              </script>';
                  $row[] = $master->VisitorName;
                  $row[] = $master->VisitorDescription;
                  $row[] = ' 
                              <div class="d-flex flex-row">
                                    <a onclick="edit_click(' . $master->VisitorId . ')" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                                    <a onclick="delete_click(' . $master->VisitorId . ')" class="me-2 text-danger pointer" title="Edit Data"><i class="fas fa-times"></i></a>
                              </div>';
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->m_penjualan->count_all(),
                  "recordsFiltered" => $this->m_penjualan->count_filtered(),
                  "data" => $data,
            );
            //output to json format
            echo json_encode($output);
      }

      function get_list_cs()
      {
            $data = $this->db->query("SELECT * FROM (SELECT *,MAX(FileCustomerDate) AS filedate FROM  `TblFileCustomer` GROUP BY MsCustomerId) AS TblFileCustomer
                                          JOIN `TblMsCustomer` ON `TblMsCustomer`.`MsCustomerId`=`TblFileCustomer`.`MsCustomerId` 
                                          WHERE `TblFileCustomer`.`MsWorkplaceId` = '" . $this->input->post("MsWorkplaceId") . "' AND 
                                          ( `MsCustomerName` LIKE '%" . $this->input->post("search") . "%' ESCAPE '!' OR 
                                          `MsCustomerCompany` LIKE '%" . $this->input->post("search") . "%' ESCAPE '!' OR 
                                          `MsCustomerAddress` LIKE '%" . $this->input->post("search") . "%' ESCAPE '!' OR 
                                          `FileCustomerDesc` LIKE '%" . $this->input->post("search") . "%' ESCAPE '!' ) order by filedate desc")->result();
            $no = 0;
            $list = "";
            $first = "";
            foreach ($data as $row) {
                  $total = $this->db
                        ->join("TblMsCustomer", "TblMsCustomer.MsCustomerId=TblFileCustomer.MsCustomerId")
                        ->where("TblFileCustomer.MsCustomerId", $row->MsCustomerId)
                        ->group_start()
                        ->like("MsCustomerName", $this->input->post("search"))
                        ->or_like("MsCustomerCompany", $this->input->post("search"))
                        ->or_like("MsCustomerAddress", $this->input->post("search"))
                        ->or_like("FileCustomerDesc", $this->input->post("search"))
                        ->group_end()
                        ->count_all_results("TblFileCustomer");
                  if ($no == 0) $first = $row->MsCustomerId;
                  $list .= '<li ' . ($no == 0 ? 'class="active"' : '') . '>
                        <a data-id="' . $row->MsCustomerId . '">
                              <span class="fw-bold">' . $this->model_app->get_customer_name($row->MsCustomerId) . '</span><br>
                              <span style="font-size: 0.75rem;">' . $row->MsCustomerAddress . '</span><br>
                              <span class="fw-bold text-primary" style="font-size: 0.6rem;">Total File : ' . $total . ' | Last update : ' . $row->filedate . '</span>
                        </a>
                  </li>';
                  $no++;
            }

            $count = $this->db
                  ->join("TblMsCustomer", "TblMsCustomer.MsCustomerId=TblFileCustomer.MsCustomerId")
                  ->where("TblFileCustomer.MsWorkplaceId", $this->input->post("MsWorkplaceId"))
                  ->group_start()
                  ->like("MsCustomerName", $this->input->post("search"))
                  ->or_like("MsCustomerCompany", $this->input->post("search"))
                  ->or_like("MsCustomerAddress", $this->input->post("search"))
                  ->or_like("FileCustomerDesc", $this->input->post("search"))
                  ->group_end()
                  ->count_all_results('TblFileCustomer');

            $data = array(
                  "list" => $list,
                  "total" => $no,
                  "file" => $count,
                  "first" => $first,

            );
            echo json_encode($data);
      }

      function get_list_file($id)
      {
            $data = $this->db
                  ->join("TblMsCustomer", "TblMsCustomer.MsCustomerId=TblFileCustomer.MsCustomerId")
                  ->where("TblFileCustomer.MsCustomerId", $id)
                  ->group_start()
                  ->like("MsCustomerName", $this->input->post("search"))
                  ->or_like("MsCustomerCompany", $this->input->post("search"))
                  ->or_like("MsCustomerAddress", $this->input->post("search"))
                  ->or_like("FileCustomerDesc", $this->input->post("search"))
                  ->group_end()
                  ->get("TblFileCustomer")->result();
            if ($data) {
                  $header = (array)$data[0];
                  $totalrow = 0;

                  $body = '<div id="cust-' . $id . '"  class="body flex">';
                  foreach ($data as $row) {

                        $totalrow++;
                        $keys = $row->FileCustomerDesc;
                        $exploded = explode('.', $keys);
                        $img = "";
                        $info = 'data-title="' . $this->model_app->get_customer_name($header["MsCustomerId"]) . ' | ' . $keys . '" data-url="' . site_url("asset/image/file/customer/") . $id . "/" . $row->FileCustomerImage . '" data-filename="' . $keys . '" data-folder="' . $id . '"';
                        if (end($exploded) == "pdf") {
                              $img = '<i id="img-' . $totalrow . '" onclick="show_pdf(this)" ' . $info . ' class="fa fa-file-pdf-o" aria-hidden="true" ></i>';
                        } else if (end($exploded) == "doc" || end($exploded) == "docx") {
                              $img = '<i id="img-' . $totalrow . '" onclick="show_file(this)" ' . $info . ' class="fa fa-file-word-o" aria-hidden="true"></i>';
                        } else if (end($exploded) == "xlsx" || end($exploded) == "xls") {
                              $img = '<i id="img-' . $totalrow . '" onclick="show_file(this)" ' . $info . ' class="fa fa-file-excel-o" aria-hidden="true" ></i>';
                        } else {
                              $img = '<img id="img-' . $totalrow . '" src="' . site_url("function/client_datatable_sales/resize_image/") .  $id . "/" . $row->FileCustomerImage  . '" alt="' . $this->model_app->get_customer_name($header["MsCustomerId"]) . ' | ' . $keys . '" ' . $info . '/>';
                        }
                        $body .= '  <div class="file-content">
                        <div class="file text-center">     
                              ' . $img . '
                        </div>
                        <div class="title d-inline-block text-truncate" style="max-width: 150px;">
                              <span>' . $keys . '</span><br>
                              <span>' . $row->FileCustomerDate . '</span>
                        </div>
                        <div class="btn-group-vertical  btn-group-sm d-flex rounded flex-column action" role="group" aria-label="Button group with nested dropdown">
                              <button type="button" class="btn btn-light " onclick="$(\'#img-' . $totalrow . '\').click()"><i class="fas fa-eye" aria-hidden="true" ></i></button>
                              <button type="button" class="btn btn-light " onclick="edit_file($(\'#img-' . $totalrow . '\'),\'' . $row->FileCustomerId . '\')"><i class="fas fa-pencil-alt" aria-hidden="true" ></i></button>
                              <button type="button" class="btn btn-light " onclick="delete_file($(\'#img-' . $totalrow . '\'),\'' . $row->FileCustomerId . '\')"><i class="fas fa-times" aria-hidden="true" ></i></button>
                        </div>
                        </div>';
                  }
                  $body .= '  <div class="file-content" onclick="tambah_file(' . $id . ',' . $header["MsWorkplaceId"] . ')">
                              <div class="file text-center text-success">  
                                    <i class="fas fa-plus-circle fa-6x"></i>
                              </div>
                              <div class="title d-inline-block text-truncate" style="max-width: 150px;">
                                    <span>Tambah File</span>
                              </div>
                        </div></div>';
                  $content = '<div class="d-block">
                  <span class="header">' . $this->model_app->get_customer_name($header["MsCustomerId"]) . '</span><br>
                  <span class="detail">' . $header["MsCustomerAddress"] . '</span>

                  <span class="header-end">Total File : ' . $totalrow . '</span>
                  </div>' . $body . '
            <script>
                  var viewer' . $id . ' = new Viewer(document.getElementById("cust-' . $id . '"), {
                        url(image) {
                              return image.src.replace("function/client_datatable_sales/resize_image", "asset/image/file/customer");
                        },
                  })
                  
            </script>';
                  echo $content;
            }
      }

      public function resize_image($id, $name)
      {
            if (!file_exists('asset/image/file/cache/')) {
                  mkdir("asset/image/file/cache", 0777);
            }
            if (!file_exists('asset/image/file/cache/' . $id . '/')) {
                  mkdir("asset/image/file/cache/" . $id, 0777);
            }
            $source_path = $_SERVER['DOCUMENT_ROOT'] . '/asset/image/file/customer/' . $id . '/' . $name;
            $target_path = $_SERVER['DOCUMENT_ROOT'] . '/asset/image/file/cache/' . $id . '/' . $name;
            $config_manip = array(
                  'image_library' => 'gd2',
                  'source_image' => $source_path,
                  'new_image' => $target_path,
                  'maintain_ratio' => TRUE,
                  'width' => 200,
                  'height' => 200
            );
            $this->load->library('image_lib');
            $this->image_lib->clear();
            $this->image_lib->initialize($config_manip);
            if (!$this->image_lib->resize()) {
                  echo $this->image_lib->display_errors();
            } else {
                  // header('Content-Length: ' . filesize($target_path)); //<-- sends filesize header
                  // header('Content-Type: image/jpg'); //<-- send mime-type header
                  // header('Content-Disposition: inline; filename="' . $target_path . '";'); //<-- sends filename     header
                  // $this->output->set_content_type(get_mime_by_extension($target_path));
                  // $this->output->set_output(file_get_contents($target_path));
                  header("Content-type: image/jpeg");
                  readfile($target_path);
                  exit(0);
            }
      }
}
