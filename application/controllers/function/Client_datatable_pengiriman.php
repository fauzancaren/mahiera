<?php
defined('BASEPATH') or exit('No direct script access allowed');
ini_set('max_execution_time', 0);
class Client_datatable_pengiriman extends CI_Controller
{
   function __construct()
   {
      parent::__construct();
      $this->load->model('pengiriman/Model_pengiriman', 'm_penjualan');
      $this->load->model('model_app');

      date_default_timezone_set('Asia/Jakarta');
   }

   function get_data_pengiriman()
   {
      // SETUP DATATABLE
      $this->m_penjualan->table = 'TblDelivery';
      $this->m_penjualan->tablejoin = array(
         array(0 => 'TblDeliveryDetail', 1 => 'TblDelivery.DeliveryCode=TblDeliveryDetail.DeliveryDetailRef'),
         array(0 => 'TblMsDelivery', 1 => 'TblDelivery.MsDeliveryId=TblMsDelivery.MsDeliveryId'),
         array(0 => 'TblMsItem', 1 => 'TblMsItem.MsItemId=TblDeliveryDetail.MsItemId'),
         array(0 => 'TblMsCustomerDelivery', 1 => 'TblDelivery.MsCustomerDeliveryId=TblMsCustomerDelivery.MsCustomerDeliveryId'),
         array(0 => 'TblSales', 1 => 'TblSales.SalesCode=TblDelivery.DeliveryRef'),
         array(0 => 'TblMsCustomer', 1 => 'TblSales.MsCustomerId=TblMsCustomer.MsCustomerId'),
      );
      $this->m_penjualan->column_search = array(
         'TblMsCustomer.MsCustomerCode',
         'MsCustomerName',
         'MsCustomerCompany',
         'MsCustomerAddress',
         'SalesCode',
         'DeliveryCode',
         'MsItemCode',
         'MsItemName'
      ); //set column field database for datatable searchable 
      $this->m_penjualan->order = array('DeliveryDate' => 'DESC', 'DeliveryId' => 'DESC'); // default order 
      $this->m_penjualan->group = array('DeliveryCode');
      // PROSES DATA
      $list = $this->m_penjualan->get_datatables();

      $data = array();
      $date = "";
      foreach ($list as $master) {
         $query1 = $this->db
            ->join("TblMsItem", "TblDeliveryDetail.MsItemId = TblMsItem.MsItemId")
            ->join("TblMsItemCategory", "TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId")
            ->join("TblDeliverySpare", "TblDeliverySpare.MsItemId=TblDeliveryDetail.MsItemId", "LEFT")
            ->where("DeliveryDetailRef", $master->DeliveryCode)
            ->get("TblDeliveryDetail")->result();

         $detailitem = "";
         foreach ($query1 as $row1) {
            $detailitem .= '  <div class="row align-items-center border-light border-bottom border-top me-2 py-1">
                                 <div class="col-6">
                                    <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemCode . '-' . $row1->MsItemName . '</span><br>
                                    <span class="text-secondary">Ukuran : <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemSize . '</span></span>
                                 </div>
                                 <div class="col-3 text-right">
                                    <span class="text-secondary">Qty</span><br>
                                    <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->DeliveryDetailQty . ' ' . $row1->MsItemUoM . '</span>
                                 </div>
                                 <div class="col-3 text-right">
                                    <span class="text-secondary">Spare</span><br>
                                    <span class="text-dark fw-bold" style="font-size:0.7rem;">' . ($row1->DeliverySpareQty == "" ? "0" : $row1->DeliverySpareQty) . ' ' . $row1->MsItemUoM . '</span>
                                 </div>
                              </div>';
         }
         $html = "";
         if ($master->DeliveryStatus == 0) {
            $valueprogress = 30;
            $button = '
                        <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_proses(' . $master->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                           <i class="fas fa-share-square"></i>  
                           <span class="fw-bold">
                           &nbsp;Lanjutkan Pengiriman
                           </span>
                        </button>';
         } else if ($master->DeliveryStatus == 1) {
            $valueprogress = 65;
            $button = '
                        <button type="button" class="btn btn-outline-success btn-sm mx-1" onclick="delivery_selesai(' . $master->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                           <i class="fas fa-share-square"></i>  
                           <span class="fw-bold">
                           &nbsp;Selesaikan Pengiriman
                           </span>
                        </button>';
         } else if ($master->DeliveryStatus == 2) {
            $valueprogress = 100;
            $button = '';
         }
         if ($date != $master->DeliveryDate)
            $html .= '<div class="flex bg-light my-2"><span class="fw-bold">' . date_format(date_create($master->DeliveryDate), "d F Y") . '</span></div>';
         $html .= '<div class="row datatable-header align-items-center"> 
                     <div class="col-md-5 col-sm-12 p-1 g-1 " >
                        <div class="row align-items-center">
                           <div class="col-auto pe-0 text-center" style="min-width:30px;">
                              <img src="' . base_url("asset/image/logo/logo-") . $master->SalesHeader . '-200.png" class="rounded" width="40">
                           </div>      
                           <div class="col pe-0">
                              <span class="fw-bold text-orange" style="font-size:11px;">' . $master->DeliveryCode . '</span><br>
                              <span class="text-dark text-uppercase" style="font-size:12px;">' . $this->model_app->get_customer_name($master->MsCustomerId) . '</span>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-auto pe-0 text-center" style="min-width:30px;">
                              <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                           </div>      
                           <div class="col pe-0">
                              <span class="text-dark text-uppercase" style="font-size:12px;">' . $master->MsCustomerDeliveryReceive . '</span>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-auto pe-0 text-center" style="min-width:30px;">
                              <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-phone-square-alt"></i></span>
                           </div>      
                           <div class="col pe-0">
                              <span class="text-dark text-uppercase" style="font-size:12px;">' . $master->MsCustomerDeliveryTelp . '</span>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-auto pe-0 text-center" style="min-width:30px;">
                              <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-house-user"></i></span>
                           </div>      
                           <div class="col pe-0">
                              <span class="text-dark" style="font-size:12px;">' . $master->MsCustomerDeliveryAddress . '</span>
                           </div>
                        </div>
                     </div>';
         if ($master->DeliveryStatus == 1) {
            if ($master->MsDeliveryId  == "OMAHBATA") {
               $pieces = explode(",", $master->DeliveryDriver);
               $emp = "";
               for ($i = 0; $i <= count($pieces) - 1; $i++) {
                  $emp .= $this->model_app->get_single_data("MsEmpName", "TblMsEmployee", array("MsEmpId" => $pieces[$i])) . "<br>";
               }
               $htmltitle = " <b>Sedang Dikirim</b><br>
                              Armada : OMAHBATA<br>
                              Jenis : " . ($master->DeliveryJenis == 1 ? "PICKUP" : "ENGKEL") . "<br>
                              Driver : <br>" . $emp;
            } else {
               $htmltitle = " <b>Sedang Dikirim</b><br>
                              Armada : " . $master->MsDeliveryName;
            }
         } elseif ($master->DeliveryStatus == 2) {
            if ($master->MsDeliveryName == "OMAHBATA") {
               $pieces = explode(",", $master->DeliveryDriver);
               $emp = "";
               for ($i = 0; $i <= count($pieces) - 1; $i++) {
                  $emp .= $this->model_app->get_single_data("MsEmpName", "TblMsEmployee", array("MsEmpId" => $pieces[$i])) . "<br>";
               }
               $htmltitle = " <b>Pengiriman Selesai</b><br>
                              Armada : OMAHBATA<br>
                              Jenis : " . ($master->DeliveryJenis == 1 ? "PICKUP" : "ENGKEL") . "<br>
                              Driver : <br>" . $emp;
            } else {
               $htmltitle = " <b>Pengiriman Selesai</b><br>
                              Armada : " . $master->MsDeliveryName;
            }
         } else {
            $htmltitle = "<b>Belum Di kirim</b>";
         }
         $html .= '
                     <div class="col-md-4 col-12">
                        <span class="text-secondary label-span">Armada</span><span class="text-dark fw-bold" style="font-size:0.7rem;">' . $master->MsDeliveryName . '</span><br>
                        <div class="list-progress" style="" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="' . $htmltitle . '">
                           <span class="fa-stack text-secondary ' . ($master->DeliveryStatus >= 0 ? "success" : "") . '" >
                              <i class="fas fa-circle fa-stack-2x" ></i>
                              <i class="fas fa-calendar-alt fa-stack-1x"></i>
                           </span><span class="fa-stack text-secondary ' . ($master->DeliveryStatus >= 1 ? "success" : "") . '" >
                              <i class="fas fa-circle fa-stack-2x" ></i>
                              <i class="fas fa-shipping-fast fa-stack-1x" ></i>
                           </span>
                           <span class="fa-stack text-secondary ' . ($master->DeliveryStatus >= 2 ? "success" : "") . '">
                              <i class="fas fa-circle fa-stack-2x"></i>
                              <i class="fas fa-people-carry fa-stack-1x"></i>
                           </span>
                           <div class="progress">
                              <div class="progress-bar bg-success" role="progressbar" style="width: ' . $valueprogress . '%" aria-valuenow="' . $valueprogress . '" aria-valuemin="0" aria-valuemax="100"></div>
                           </div>
                        </div><br>' . $button . '
                     </div>
                     <div class="col-md-3 col-12 d-flex flex-column">
                        <button type="button" class="btn btn-outline-danger btn-sm m-1" onclick="delivery_delete(' . $master->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                           <i class="fas fa-times"></i>  
                           <span class="fw-bold">
                           &nbsp;Hapus
                           </span>
                        </button>
                        <button type="button" class="btn btn-outline-primary btn-sm  m-1" onclick="delivery_print(' . $master->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                           <i class="fas fa-print"></i>  
                           <span class="fw-bold">
                           &nbsp;Print
                           </span>
                        </button>
                        <button type="button" class="btn btn-outline-warning btn-sm m-1" onclick="delivery_edit(' . $master->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                           <i class="fas fa-pencil-alt"></i>  
                           <span class="fw-bold">
                           &nbsp;Edit
                           </span>
                        </button>
                     </div>
                     ' . $detailitem . '
                  </div>
                        <script>
                              $("[data-bs-toggle=\'tooltip\']").tooltip()
                        </script>';

         $row = array();
         $row[] = $html;
         $row[] = $master->DeliveryId;
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

   function get_data_pengiriman_ref()
   {
         $search = $this->input->post("search");
         $tanggal = $this->input->post("tanggal");
         $exc = $this->input->post("exception") ?? "";

         $data = $this->db
               ->join("TblDeliveryDetail", "TblDeliveryDetail.DeliveryDetailRef=TblDelivery.DeliveryCode", "left")  
               ->join("TblMsItem", "TblMsItem.MsItemId=TblDeliveryDetail.MsItemId", "left") 
               ->join("TblMsDelivery", "TblDelivery.MsDeliveryId=TblMsDelivery.MsDeliveryId", "left")  
               ->join("TblMsCustomerDelivery", "TblDelivery.MsCustomerDeliveryId=TblMsCustomerDelivery.MsCustomerDeliveryId", "left") 
               ->join("TblSales", "TblSales.SalesCode=TblDelivery.DeliveryRef", "left") 
               ->join("TblMsCustomer", "TblSales.MsCustomerId=TblMsCustomer.MsCustomerId", "left")  
               ->group_start()
               ->like("TblMsCustomer.MsCustomerCode", $search)
               ->or_like("MsCustomerName", $search)
               ->or_like("MsCustomerCompany", $search)
               ->or_like("MsCustomerAddress", $search)
               ->or_like("SalesCode", $search)
               ->or_like("DeliveryCode", $search)
               ->or_like("MsItemCode", $search)
               ->or_like("MsItemName", $search)
               ->group_end()
               ->where("DeliveryDate", $tanggal) 
               ->where("TblDelivery.MsDeliveryId", 1) 
               ->where_not_in("DeliveryCode", $exc) 
               ->order_by('DeliveryDate DESC,DeliveryId DESC')
               ->group_by('DeliveryCode')
               ->get("TblDelivery", 0, 20)->result();
         $content = "";
         foreach ($data as $row){
            $query1 = $this->db->query("select * from TblDeliveryDetail left join TblMsItem on TblDeliveryDetail.MsItemId=TblMsItem.MsItemId LEFT JOIN TblMsItemCategory on TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId  where DeliveryDetailRef='" . $row->DeliveryCode . "'")->result();
            $detaildelivery = "";
            foreach ($query1 as $row1) {
                  $detaildelivery .= '    <div class="row align-items-center border-light border-bottom border-top me-1 py-1">
                                                <div class="col-6">
                                                      <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemCode . '-' . $row1->MsItemName . '</span><br>
                                                      <span class="text-secondary">Ukuran : <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemSize . '</span></span>
                                                </div>
                                                <div class="col-3">
                                                      <span class="text-secondary">Vendor</span><br>
                                                      <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsVendorCode . '</span>
                                                </div>
                                                <div class="col-3 text-right">
                                                      <span class="text-secondary">Qty</span><br>
                                                      <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->DeliveryDetailQty . ' ' . $row1->MsItemUoM . '</span>
                                                </div>
                                          </div>';
            } 
            $content .= '
            <div class="pb-4">
            <div class="card p-2"  >
                           <div class="row py-1 g-1">
                                 <div class="col-md-5 col-12">
                                       <span class="text-secondary label-span" style="font-size:0.75rem">No. Delivery</span><span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->DeliveryCode . '</span><br>
                                       <span class="text-secondary label-span" style="font-size:0.75rem">Armada</span><span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->MsDeliveryName . '</span><br>
                                       <span class="text-secondary label-span" style="font-size:0.75rem">Rit</span><span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->DeliveryRit . '</span><br>
                                       <span class="text-secondary label-span" style="font-size:0.75rem">Tgl. kirim</span><span class="text-dark fw-bold" style="font-size:0.7rem;">' . date_format(date_create($row->DeliveryDate), "d F Y") . '</span><br>
                                       <span class="text-secondary label-span" style="font-size:0.75rem">Penerima</span><span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->MsCustomerDeliveryReceive . ' </span><span class="text-dark fw-bold" style="font-size:0.7rem;">(' . $row->MsCustomerDeliveryTelp . ')</span>
                                 </div> 
                                 <div class="col-md-7 ps-lg-2 col-12">
                                       <span class="text-secondary" style="font-size:0.75rem">Alamat</span><br><span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->MsCustomerDeliveryAddress . '</span><br>
                                       <span class="text-secondary" style="font-size:0.75rem">Titik Map</span><br>
                                       <div class="bg-pinpoint">
                                             <i class="fas fa-map-marker-alt fa-2x"></i>
                                             <span class="label-small px-1">' . $row->MsCustomerDeliveryName . '</span>
                                             <a class="btn btn-light py-1 ms-auto btn-sm" href="https://maps.google.com/?q=' . $row->MsCustomerDeliveryLat . ',' . $row->MsCustomerDeliveryLng . '" target="_blank" style="min-width: 5rem;">Lihat Map</a>
                                       </div>
                                 </div>
                                 <div class="col-md-12 d-flex flex-column " style="border: 1px solid #d2cac0;border-radius: 0.25rem;">
                                       '.$detaildelivery.'
                                 </div> 
                                 <button type="button" class="btn btn-success btn-sm" aria-expanded="false" onclick="delivery_select(' . $row->DeliveryId . ')" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                        
                                       <span class="fw-bold">
                                       &nbsp;Pilih Data ini
                                       </span>
                                 </button>
                           </div>
                        </div> 
                        </div>  '; 
         }
         if ($content == "") {
               $content = '
                     <div>
            <img src="' . base_url("asset/image/mgs-erp/iconnotfound.png") . '" class="rounded mx-auto d-block" alt="...">
         </div>';
         }
         echo $content; 
   }

   function get_data_delivery($id){
      $data = $this->db  
         ->join("TblMsDelivery", "TblDelivery.MsDeliveryId=TblMsDelivery.MsDeliveryId", "left")  
         ->join("TblMsCustomerDelivery", "TblDelivery.MsCustomerDeliveryId=TblMsCustomerDelivery.MsCustomerDeliveryId", "left")  
         ->where("DeliveryId", $id)   
         ->get("TblDelivery")->row();
      $detail = $this->db 
            ->join("TblMsItem", "TblMsItem.MsItemId=TblDeliveryDetail.MsItemId", "left")  
            ->where("DeliveryDetailRef", $data->DeliveryCode)   
            ->get("TblDeliveryDetail")->result();
      echo json_encode(array(
         "header"=>$data,
         "detail"=>$detail,
      ));
   }


   function rit_home(){
      $search = $this->input->post("search");
      $armada = $this->input->post("armada");
      $tanggalstart = $this->input->post("start");
      $tanggalend = $this->input->post("end"); 

      $data = $this->db
         ->join("TblDeliveryDetail", "TblDeliveryDetail.DeliveryDetailRef=TblDelivery.DeliveryCode", "left")  
         ->join("TblMsItem", "TblMsItem.MsItemId=TblDeliveryDetail.MsItemId", "left") 
         ->join("TblMsDelivery", "TblDelivery.MsDeliveryId=TblMsDelivery.MsDeliveryId", "left")  
         ->join("TblMsCustomerDelivery", "TblDelivery.MsCustomerDeliveryId=TblMsCustomerDelivery.MsCustomerDeliveryId", "left") 
         ->join("TblSales", "TblSales.SalesCode=TblDelivery.DeliveryRef", "left") 
         ->join("TblMsCustomer", "TblSales.MsCustomerId=TblMsCustomer.MsCustomerId", "left")  
         ->group_start()
         ->like("TblMsCustomer.MsCustomerCode", $search)
         ->or_like("MsCustomerName", $search)
         ->or_like("MsCustomerCompany", $search)
         ->or_like("MsCustomerAddress", $search)
         ->or_like("SalesCode", $search)
         ->or_like("DeliveryCode", $search)
         ->or_like("MsItemCode", $search)
         ->or_like("MsItemName", $search)
         ->group_end()
         ->where("DeliveryDate >=", $tanggalstart) 
         ->where("DeliveryDate <=", $tanggalend) 
         ->where("TblDelivery.MsDeliveryId", 1)  
         ->order_by('DeliveryDate DESC,DeliveryId DESC')
         ->group_by('DeliveryCode')
         ->get("TblDelivery", 0, 20)->result();

      $content = "";

   }
   function rit_set(){
      $search = $this->input->post("search");
      $armada = $this->input->post("armada");
      $tanggalstart = $this->input->post("start");
      $tanggalend = $this->input->post("end"); 
   }
   function rit_finish(){
      $search = $this->input->post("search");
      $armada = $this->input->post("armada");
      $tanggalstart = $this->input->post("start");
      $tanggalend = $this->input->post("end"); 
   }
}
