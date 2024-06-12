<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Client_datatable_financial extends CI_Controller
{
      function __construct()
      {
            parent::__construct();
            $this->load->model('penjualan/Model_penjualan', 'm_master');

            date_default_timezone_set('Asia/Jakarta');
      }

      function get_financial_approve()
      {
            // SETUP DATATABLE
            $this->m_master->table = 'TblSalesPayment';
            $this->m_master->tablejoin = array(
                  array(0 => 'TblSales', 1 => 'TblSales.SalesCode = TblSalesPayment.PaymentRef'),
                  array(0 => 'TblMsCustomer', 1 => 'TblSales.MsCustomerId=TblMsCustomer.MsCustomerId'),
                  array(0 => 'TblMsMethod', 1 => 'TblMsMethod.MsMethodId=TblSalesPayment.MsMethodId'),
            );
            $this->m_master->column_order = array(null); //set column field database for datatable orderable
            $this->m_master->column_search = array('SalesCode', 'MsMethodName'); //set column field database for datatable searchable 
            $this->m_master->order = array('PaymentDate' => 'asc'); // default order 

            // PROSES DATA
            $list = $this->m_master->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $master) {
                  $sales_customer = ($master->MsCustomerTypeId == 1 ? $master->MsCustomerName : $master->MsCustomerName . ' (' . $master->MsCustomerCompany . ')');
                  $html_tooltip_payment = '<span class=\'tool-desc\'>Dibuat oleh : <br>' . $master->SalesCreateUser . ' <br>(' . $master->SalesCreate . ')</span><br>
                  <span class=\'tool-desc\'>Terakhir Diubah : <br>' . $master->SalesLastUpdateUser . ' <br>(' . $master->SalesLastUpdate . ')</span><br>';
                  $sales_telp = (($master->MsCustomerTelp2 == "" || $master->MsCustomerTelp2 == "-") ? $master->MsCustomerTelp1 : $master->MsCustomerTelp1 . " / " . $master->MsCustomerTelp2);
                  $no++;
                  $row = array();
                  $row[] = $no;
                  $row[] = '
                     <div class="row align-items-center">
                           <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                 <img src="' . base_url("asset/image/logo/logo-") . $master->SalesHeader . '-200.png" class="rounded" width="40">
                           </div>      
                           <div class="col pe-0">
                                 <span class="fw-bold text-orange" style="font-size:11px;">' . $master->SalesCode . '</span>
                                 <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $html_tooltip_payment . '"></i>
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
                     </div>';
                  $row[] = '
                     <div class="row">
                           <div class="col-auto pe-0 " style="min-width:8rem;">
                                 <span class="fw-bold text-secondary" style="font-size:12px;">Metode Pembayaran</span>
                           </div>      
                           <div class="col pe-0">
                                 <span class="fw-bold text-dark text-uppercase" style="font-size:12px;">' . $master->MsMethodName . '</span>
                           </div>
                     </div>
                     <div class="row">
                           <div class="col-auto pe-0 " style="min-width:8rem;">
                                 <span class="fw-bold text-secondary" style="font-size:12px;">Atas Nama</span>
                           </div>      
                           <div class="col pe-0">
                                 <span class="fw-bold text-dark text-uppercase" style="font-size:12px;">' . $master->PaymentCardName . '</span>
                           </div>
                     </div>
                     <div class="row">
                           <div class="col-auto pe-0 " style="min-width:8rem;">
                                 <span class="fw-bold text-secondary" style="font-size:12px;">Tanggal</span>
                           </div>      
                           <div class="col pe-0">
                                 <span class="fw-bold text-dark" style="font-size:12px;">' . date_format(date_create($master->PaymentDate), "d F Y") . '</span>
                           </div>
                     </div>
                     <div class="row">
                           <div class="col-auto pe-0 " style="min-width:8rem;">
                                 <span class="fw-bold text-secondary" style="font-size:12px;">Total</span>
                           </div>      
                           <div class="col pe-0">
                                 <span class="fw-bold text-dark" style="font-size:12px;">' . number_format($master->PaymentTotal) . '</span>
                           </div>
                     </div>
                     <div class="row">
                           <div class="col-auto pe-0 " style="min-width:8rem;">
                                 <span class="fw-bold text-secondary" style="font-size:12px;">Bukti Transaksi</span>
                           </div>      
                           <div class="col pe-0">
                              <button type="button" class="btn btn-transparent btn-sm" aria-expanded="false" onclick="payment_view(' . $master->SalesId . ',\'' . $master->PaymentImage . '\')" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                 <i class="fas fa-eye"></i>  
                                 <span class="fw-bold">
                                 &nbsp;Lihat
                                 </span>
                              </button>
                           </div>
                     </div>
                     <script>
                           $("[data-bs-toggle=\'tooltip\']").tooltip()
                     </script>';
                  $row[] = ($master->PaymentApprove == 0 ? '<button type="button" class="btn btn-sm btn-outline-success py-1" onclick="approve_click(' . $master->PaymentId . ')">Approve</button>' : '');
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->m_master->count_all(),
                  "recordsFiltered" => $this->m_master->count_filtered(),
                  "data" => $data,
            );

            //output to json format
            echo json_encode($output);
      }
}
