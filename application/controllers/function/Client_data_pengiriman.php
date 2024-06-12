<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Client_data_pengiriman extends CI_Controller
{
   function __construct()
   {
      parent::__construct();
      $this->load->model('model_app');
      date_default_timezone_set('Asia/Jakarta');
   }
   // #################### Delivery ###################

   function get_color(){
      array(
         "#C23B23",
         "#F39A27",
         "#EADA52",
         "#03C03C",
         "#579ABE",
         "#976ED7",  
      );
   }
   function build_calendar()
   {
      $month = $this->input->post("month");
      $year = $this->input->post("year");
      $store = $this->input->post("store");
      $armada = $this->input->post("armada");
      $search = $this->input->post("search");
      
      $jsonlibur = json_decode(file_get_contents("https://raw.githubusercontent.com/guangrei/APIHariLibur_V2/main/calendar.json"), true); 
      $daysOfWeek = array('Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'); 
      $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year); 
      $numberDays = date('t', $firstDayOfMonth); 
      $dateComponents = getdate($firstDayOfMonth); 
      $monthName = $dateComponents['month']; 
      $dayOfWeek = $dateComponents['wday'];

      // Create the table tag opener and day headers
      $calendar = '
         <div class="d-flex justify-content-between bd-highlight mb-3 border-top border-bottom">
            <div class="p-2 bd-highlight">
               <button onclick="prev()" type="button" class="btn btn-primary btn-lg">
                  <i class="fa fa-chevron-left"></i>
               </button>
            </div>
            <div class="p-2 bd-highlight">
               <h3 class="text-uppercase">' . $monthName . " " . $year . '</h3>
            </div>
            <div class="p-2 bd-highlight">
               <button onclick="next()" type="button" class="btn btn-primary btn-lg">
                  <i class="fa fa-chevron-right"></i>
               </button>
            </div>
         </div>';
      $calendar .= "<div style='font-size:12px'><span>Note :</span><br>";
      $calendar .= "
         <span>
            <i class='fas fa-store pe-1' style='color:#007bff'></i> = HOPST
         </span>|
         <span>
            <i class='fas fa-store pe-1' style='color:#17a2b8'></i> = WHPST
         </span>|
         <span>
            <i class='fas fa-store pe-1' style='color:#ffc107'></i> = OBBSD
         </span>|
         <span>
            <i class='fas fa-store pe-1' style='color:#28a745'></i> = OBBGR
         </span>|
         <span>
            <i class='fas fa-store pe-1' style='color:#4ec3de'></i> = OTHER
         </span>";
      $calendar .= "<table class='calendar table border'>";
      $calendar .= "<tr>";
      foreach ($daysOfWeek as $day) {
         $calendar .= "<th class='header'>$day</th>";
      }
      $currentDay = 1;
      $calendar .= "</tr>
      <tr>";
      if ($dayOfWeek > 0) {
         $calendar .= "<td colspan='$dayOfWeek'>&nbsp;</td>";
      }
      $month = str_pad($month, 2, "0", STR_PAD_LEFT);
      while ($currentDay <= $numberDays) {

         if ($dayOfWeek == 7) {

            $dayOfWeek = 0;
            $calendar .= "</tr><tr>";
         }
         $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
         $date = "$year-$month-$currentDayRel";
         $arr = $this->model_app->tanggalMerah( $date, $jsonlibur);

         $content = '
                        <div class="number-calender fw-bold" style="font-size: 12px;color:' . $arr[0] . '" data-bs-toggle="tooltip"  title="' . $arr[1] . '">
                           ' . $currentDay . '
                        </div>
                        <div class="overflow-auto" style="min-height:150px;">';
         //********************************** GET DATA
         $this->db
            ->join("TblSales", "TblSales.SalesCode=TblDelivery.DeliveryRef")
            ->join("TblMsCustomer", "TblSales.MsCustomerId=TblMsCustomer.MsCustomerId")
            ->join("TblMsDelivery", "TblMsDelivery.MsDeliveryId=TblDelivery.MsDeliveryId")
            ->join("TblMsCustomerDelivery", "TblMsCustomerDelivery.MsCustomerDeliveryId=TblDelivery.MsCustomerDeliveryId")
            ->where("DeliveryDate", "$year-$month-$currentDayRel");
         if ($armada != "-") $this->db->where("TblMsDelivery.MsDeliveryId", $armada);
         if ($store != "-") $this->db->where("TblDelivery.MsWorkplaceId", $store);
         if ($search != "") {
            $this->db->group_start()
               ->like("MsCustomerName", $search)
               ->or_like("MsCustomerCompany", $search)
               ->or_like("TblMsCustomer.MsCustomerCode", $search)
               ->or_like("DeliveryCode", $search)
               ->or_like("DeliveryRef", $search)
               ->group_end();
         }
         $result = $this->db->order_by("TblMsDelivery.MsDeliveryId ASC,TblDelivery.MsWorkplaceId ASC")->get("TblDelivery")->result();
         $delivery = array();
         foreach ($result as $row) {
            if (!in_array($row->MsDeliveryName, $delivery)) {
               $delivery += array($row->MsDeliveryName => array());
            }
            if ($row->DeliveryStatus == 0) {
               $status = "PERSIAPAN";
               $border = "border-left:5px solid #4ec3de!important";
            } else  if ($row->DeliveryStatus == 1) {
               $status = "PENGIRIMAN";
               $border = "border-left:5px solid #2b1df2!important";
            } else  if ($row->DeliveryStatus == 2) {
               $status = "DITERIMA";
               $border = "border-left:5px solid #28a745!important";
            } else  if ($row->DeliveryStatus == 3) {
               $status = "SELESAI";
               $border = "border-left:5px solid #28a745!important";
            }
            //FILTER DELIVERY
            $data = array(
               "DeliveryId" => $row->DeliveryId,
               "data" => $this->model_app->get_customer_name($row->MsCustomerId),
               "tooltip" => "<b>RIT : " . $row->DeliveryRit ."</b>&nbsp;|&nbsp;<b>Status : " . $status . "</b><br><small>" . $row->DeliveryCode . "<br>" 
               . $row->SalesCode . "<br></small>" . $this->model_app->get_customer_name($row->MsCustomerId) . "<br>" . $row->MsCustomerDeliveryAddress,
               "border-left" => $border,
            );
            // if ($row->MsDeliveryName == "OMAHBATA") {
            //    $data += array("color" => "#ffebd5");
            // } else if ($row->MsDeliveryName == "PS") {
            //    $data +=  array("color" => "#ffb6c1");
            // } else {
            //    $data += array("color" => "#9fff80");
            // }
            $data += array("color" => $row->MsDeliveryColor);

            if ((substr($row->DeliveryCode, 9, 2) == "01")) {
               $data += array("store" =>'
               <span class="fa-stack small pe-1" style="color:#007bff">
                  <i class="fas fa-square fa-stack-2x"></i> 
                  <i class="fas fa-store fa-stack-1x text-white" ></i>
               </span>');
            } else if ((substr($row->DeliveryCode, 9, 2) == "02")) {
               $data += array("store" =>'
               <span class="fa-stack small pe-1" style="color:#17a2b8">
                  <i class="fas fa-square fa-stack-2x"></i> 
                  <i class="fas fa-store fa-stack-1x text-white" ></i>
               </span>'); 
            } else if ((substr($row->DeliveryCode, 9, 2) == "03")) {
               $data += array("store" =>'
               <span class="fa-stack small pe-1" style="color:#ffc107">
                  <i class="fas fa-square fa-stack-2x"></i> 
                  <i class="fas fa-store fa-stack-1x text-white" ></i>
               </span>');  
            } else if ((substr($row->DeliveryCode, 9, 2) == "04")) {
               $data += array("store" =>'
               <span class="fa-stack small pe-1" style="color:#28a745">
                  <i class="fas fa-square fa-stack-2x"></i> 
                  <i class="fas fa-store fa-stack-1x text-white" ></i>
               </span>'); 
            } else {
               $data += array("store" =>'
               <span class="fa-stack small pe-1" style="color:#4ec3de">
                  <i class="fas fa-square fa-stack-2x"></i> 
                  <i class="fas fa-store fa-stack-1x text-white" ></i>
               </span>');  
            }
            $delivery[$row->MsDeliveryName][] = $data;
         }
         foreach ($delivery as $row => $key) {
            $color = "";
            $detail = "";
            //$detail = '<ul style="list-style-type: none;padding-inline-start:10px;" class="the-node" >';
            foreach ($key as $rows) {
               // $content .= '<li data-id="' . $rows["DeliveryId"] . '" id="' . $rows["DeliveryId"] . '" class="data-item">
               //                <span class="badge text-start text-truncate" data-bs-toggle="tooltip" data-bs-html="true" data-bs-container="body" title="' . $rows["tooltip"] . '" 
               //                style="width:100%;color:black;background-color:  ' . $rows["color"] . '; ">
               //                ' . $rows["data"] . '
               //                </span> 
               //                <div class="icon-active">
               //                   <i class="fas fa-dollar-sign text-danger"></i>
               //                   <i class="fas fa-dollar-sign text-success"></i>
               //                   <i class="fas fa-flag"></i>
               //                </div>
               //             </li>'; 
               // $detail .= '<li data-id="' . $rows["DeliveryId"] . '" id="' . $rows["DeliveryId"] . '" class="data-item">
               //                <div class="d-block mb-1 text-truncate" data-bs-toggle="tooltip" data-bs-html="true" data-bs-container="body" title="' . $rows["tooltip"] . '"
               //                   style="width:8rem; font-size:0.745rem;font-weight:bold">  
               //                   <i class="fas fa-circle" style="color:'.$rows["color"].';font-size:0.5rem"></i>' . $rows["data"] . ' 
               //                </div> 
               //             </li>';
               $detail .= ' <div class="d-block mx-2 del-list" data-bs-toggle="tooltip" data-bs-html="true" data-bs-container="body" title="' . $rows["tooltip"] . '"
                               style="font-size:0.745rem;font-weight:bold">  
                               ' . $rows["store"] . '' . $rows["data"] . ' 
                               
                               <div class="action btn-group btn-group-sm" role="group">
                                  <button type="button" class="btn btn-secondary btn-sm py-0 px-1" onclick="print_detail(' . $rows["DeliveryId"] . ')"><span class="fas fa-print"></span></button>
                                  <button type="button" class="btn btn-secondary btn-sm py-0 px-1 more-option" data-id="' . $rows["DeliveryId"] . '"><span class="fas fa-ellipsis-v"></span></button>
                               </div>
                            </div> ';

               $color = $rows["color"]; 
            }
            //$detail .= '</ul>';
            $content .= '<div class="d-block mt-2 mx-2" style="font-size: 12px;background: ' . $color . ' !important;">
                           <span class="ms-2 fw-bold  text-white"  >' . $row . '</span>
                        </div>';
            $content .=  $detail;
         }
         $content .= "</div>";

         if ($dayOfWeek == 0 || $arr[2] == 0) {
            $calendar .= "<td style='height:100px;max-width:14%;width:14%' class='day border bg-light p-0' rel='$date'>$content</td>";
         } else {
            $calendar .= "<td style='height:100px;max-width:14%;width:14%' class='day border p-0' rel='$date'>$content</td>";
         }

         // Increment counters

         $currentDay++;
         $dayOfWeek++;
      }



      // Complete the row of the last week in month, if necessary

      if ($dayOfWeek != 7) {

         $remainingDays = 7 - $dayOfWeek;
         $calendar .= "<td colspan='$remainingDays'>&nbsp;</td>";
      }

      $calendar .= "</tr>";

      $calendar .= "</table>";
      $calendar .= "
      <script>
         $(\"[data-bs-toggle='tooltip']\").tooltip()
                              
      </script>
                                    ";


      echo $calendar;
   }

   function get_content_jadwal()
   {
      echo $this->load->view('content/pengiriman/jadwal', null, TRUE);
   }
   function get_content_persiapan()
   {
      echo $this->load->view('content/pengiriman/persiapan', null, TRUE);
   }
   function get_content_terima()
   {
      echo $this->load->view('content/pengiriman/diterima', null, TRUE);
   }
   function get_content_pengiriman()
   {
      echo $this->load->view('content/pengiriman/pengiriman', null, TRUE);
   }
   function get_data_progress()
   {
      $driver = $this->input->post("driver");
      $jenis = $this->input->post("jenis");

      $this->db->where("DeliveryStatus", 1);
      if ($driver != "") $this->db->like("DeliveryDriver", $driver);
      if ($jenis != "") $this->db->like("Deliveryjenis", $jenis);
      $master = $this->db->get("TblDelivery")->result();
      $html = "";
      foreach ($master as $row) {
         $pieces = explode(",", $row->DeliveryDriver);
         $emp = "";
         for ($i = 0; $i <= count($pieces) - 1; $i++) {
            $emp .= $this->model_app->get_single_data("MsEmpName", "TblMsEmployee", array("MsEmpId" => $pieces[$i])) . "<br>";
         }
         $sales = $this->db->join("TblMsEmployee", "TblSales.MsEmpId=TblMsEmployee.MsEmpId")
            ->join("TblMsCustomerDelivery", "TblSales.MsCustomerDeliveryId=TblMsCustomerDelivery.MsCustomerDeliveryId")
            ->where("SalesCode", $row->DeliveryRef)
            ->get("TblSales")->row();
         $deliverydetail =  $this->db->join("TblMsItem", "TblDeliveryDetail.MsItemId=TblMsItem.MsItemId", "left")
            ->join("TblMsItemCategory", "TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId", "left")
            ->join("TblDeliverySpare", "TblDeliveryDetail.DeliveryDetailRef=TblDeliverySpare.DeliverySpareRef", "left")
            ->where("DeliveryDetailRef", $row->DeliveryCode)
            ->get("TblDeliveryDetail")->result();
         $detaildelivery = "";
         foreach ($deliverydetail as $row1) {
            $detaildelivery .= '    <div class="row align-items-center border-light border-bottom border-top me-1 py-1">
                                                                  <div class="col-6">
                                                                        <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemCode . '-' . $row1->MsItemName . '</span><br>
                                                                        <span class="text-secondary">Ukuran : <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemSize . '</span></span><br>
                                                                        <span class="text-secondary">Vendor : <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsVendorCode . '</span></span>
                                                                  </div>
                                                                  <div class="col-3">
                                                                        <span class="text-secondary">Qty</span><br>
                                                                        <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->DeliveryDetailQty . ' ' . $row1->MsItemUoM . '</span>
                                                                  </div>
                                                                  <div class="col-3 text-right">
                                                                        <span class="text-secondary">Spare</span><br>
                                                                        <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->DeliverySpareQty . ' ' . $row1->MsItemUoM . '</span>
                                                                  </div>
                                                            </div>';
         }
         $html .= '<div class="row datatable-header"> 
                     <div class="col-md-5 col-sm-12 p-1 g-1">
                        <div class="row mb-1 align-items-center">
                           <div class="label-border-right">
                              <span class="label-dialog">Dokumen</span>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-auto pe-0" style="min-width:100px;">
                              <span class="fw-bold text-secondary" style="font-size:12px;">No. Doc</span>
                           </div>      
                           <div class="col pe-0">
                              <span class="text-dark fw-bold" style="font-size:12px;">' .  $row->DeliveryCode . '</span>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-auto pe-0" style="min-width:100px;">
                              <span class="fw-bold text-secondary" style="font-size:12px;">Tgl.</span>
                           </div>      
                           <div class="col pe-0">
                              <span class="text-dark fw-bold" style="font-size:12px;">' .  $row->DeliveryDate . '</span>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-auto pe-0" style="min-width:100px;">
                              <span class="fw-bold text-secondary" style="font-size:12px;">Driver</span>
                           </div>      
                           <div class="col pe-0">
                              <span class="text-dark fw-bold" style="font-size:12px;">' .  $emp . '</span>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-auto pe-0" style="min-width:100px;">
                              <span class="fw-bold text-secondary" style="font-size:12px;">Jenis</span>
                           </div>      
                           <div class="col pe-0">
                              <span class="text-dark fw-bold" style="font-size:12px;">' .  ($row->DeliveryJenis == 1 ? "PICK-UP" : "ENGKEL") . '</span>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-5 col-sm-12 p-1 g-1">
                        <div class="row mb-1 align-items-center">
                           <div class="label-border-right">
                              <span class="label-dialog">Reference</span>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-auto pe-0" style="min-width:100px;">
                              <span class="fw-bold text-secondary" style="font-size:12px;">No. Sales</span>
                           </div>      
                           <div class="col pe-0">
                              <span class="text-dark fw-bold" style="font-size:12px;">' .  $row->DeliveryRef . '</span>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-auto pe-0" style="min-width:100px;">
                              <span class="fw-bold text-secondary" style="font-size:12px;">Admin</span>
                           </div>      
                           <div class="col pe-0">
                              <span class="text-dark fw-bold" style="font-size:12px;">' .  $sales->MsEmpName . '</span>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-auto pe-0" style="min-width:100px;">
                              <span class="fw-bold text-secondary" style="font-size:12px;">Customer</span>
                           </div>      
                           <div class="col pe-0">
                              <span class="text-dark fw-bold" style="font-size:12px;">' .  $this->model_app->get_customer_name($sales->MsCustomerId) . '</span>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-auto pe-0" style="min-width:100px;">
                              <span class="fw-bold text-secondary" style="font-size:12px;">Penerima</span>
                           </div>      
                           <div class="col pe-0">
                              <span class="text-dark fw-bold" style="font-size:12px;">' .  $sales->MsCustomerDeliveryReceive . '</span>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-auto pe-0" style="min-width:100px;">
                              <span class="fw-bold text-secondary" style="font-size:12px;">Telp</span>
                           </div>      
                           <div class="col pe-0">
                              <span class="text-dark fw-bold" style="font-size:12px;">' .  $sales->MsCustomerDeliveryTelp . '<br>
                                 <a class="btn btn-primary btn-sm py-1"  href="https://api.whatsapp.com/send?phone=' . $this->model_app->get_numberphone_valid($sales->MsCustomerDeliveryTelp) . '"><i class="fas fa-comment pe-1"></i>Whatsapp</a>
                                 <a class="btn btn-primary btn-sm py-1" href="tel:' .  $sales->MsCustomerDeliveryTelp . '"><i class="fas fa-phone-square-alt pe-1"></i>Telepon</a>
                              </span>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-auto pe-0" style="min-width:100px;">
                              <span class="fw-bold text-secondary" style="font-size:12px;">Alamat</span>
                           </div>      
                           <div class="col pe-0">
                              <span class="text-dark fw-bold" style="font-size:12px;">' .  $sales->MsCustomerDeliveryAddress . '</span><br>
                              <a class="btn btn-primary py-1 ms-auto btn-sm" href="https://maps.google.com/?q=' . $sales->MsCustomerDeliveryLat . ',' . $sales->MsCustomerDeliveryLng . '" target="_blank" style="min-width: 5rem;"><i class="fas fa-map-marked-alt pe-1"></i>Lihat Map</a>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-2 col-sm-12 p-1 g-1 align-items-center">
                        <button type="button" class="btn btn-outline-success btn-sm mx-1" onclick="delivery_selesai(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                           <i class="fas fa-share-square"></i>  
                           <span class="fw-bold">
                           &nbsp;Selesaikan Pengiriman
                           </span>
                        </button>
                     </div>
                     <div class="col-12 card">' .
            $detaildelivery . '
                     </div>
                  </div>';
      }
      if ($html == "") {
         $html = '<img src="' . base_url("asset/image/mgs-erp/iconnotfound.png") . '" class="rounded mx-auto d-block" width="300px">';
      }
      echo $html;
   }
   function proses_pengiriman($id)
   {
      $status = true;
      $delivery = $this->input->post("data");
      $delivery += ["DeliveryLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->update('TblDelivery', $delivery, array("DeliveryId" => $id));
      $code = $this->model_app->get_single_data("DeliveryCode", "TblDelivery", array("DeliveryId" => $id));
      if (null !== $this->input->post("item")) {
         $this->db->delete('TblDeliveryDetail', array('DeliveryDetailRef' => $code));
         $dataitem = $this->input->post("item");
         foreach ($dataitem as $row) {
            $this->db->insert('TblDeliveryDetail', $row);
            if ($status && ($this->db->affected_rows() != 1)) $status = false;
         }
      }
      if (null !== $this->input->post("spare")) {
         $this->db->delete('TblDeliverySpare', array('DeliverySpareRef' =>  $code));
         $dataitem = $this->input->post("spare");
         foreach ($dataitem as $row) {
            $this->db->insert('TblDeliverySpare', $row);
            if ($status && ($this->db->affected_rows() != 1)) $status = false;
         }
      }
      if ($status && ($this->db->affected_rows() != 1)) $status = false;
      echo $status;
      $deliveryRef = $this->model_app->get_single_data("DeliveryRef", "TblDelivery", array("DeliveryId" => $id));
      if ($delivery["DeliveryStatus"] == 1 && strpos($deliveryRef, "SL-")) {
         $this->db->insert(
            'TblSalesLog',
            array(
               "SalesLogRef" => $deliveryRef,
               "SalesLogDesc" => "<b>Pengiriman</b> dengan No. <b>" . $code . "</b> telah <span style='color:blue'>diproses</span> oleh <b>" . $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName") . "</b>"
            )
         );
      }
      if ($delivery["DeliveryStatus"] == 2 && strpos($deliveryRef, "SL-")) {
         $this->db->insert(
            'TblSalesLog',
            array(
               "SalesLogRef" => $deliveryRef,
               "SalesLogDesc" => "<b>Pengiriman</b> dengan No. <b>" . $code . "</b> telah <span style='color:green'>diselesaikan</span> oleh <b>" . $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName") . "</b>"
            )
         );
      }
      if (strpos($deliveryRef, "SL-")) {
         $this->update_status_pengiriman($deliveryRef);
      }

      exit;
   }

   function update_status_pengiriman($code)
   {
      $datasales = $this->db->join("TblSalesDetail", "TblSales.SalesCode=TblSalesDetail.SalesDetailRef")->where("SalesCode", $code)->get("TblSales")->result();
      $datadelivery = $this->db->join("TblDeliveryDetail", "TblDelivery.DeliveryCode=TblDeliveryDetail.DeliveryDetailRef")->where("DeliveryRef", $code)->get("TblDelivery")->result();
      /* *Status 0 jika pengiriman belum terpenuhi */
      $status = 0;
      foreach ($datasales as $row) {
         $total_delivery = 0;
         foreach ($datadelivery as $rows) {
            if ($row->MsItemId == $rows->MsItemId && $row->MsVendorCode == $rows->MsVendorCode) {
               $total_delivery +=  $rows->DeliveryDetailQty;
            }
         }
         if ($row->SalesDetailQty > $total_delivery) $status = 1;
      }
      if ($status == 1) {
         $this->db->update("TblSales", array("SalesStatusDelivery" => 0), array("SalesCode" => $code));
         return;
      }

      /* *Status 1 jika pengiriman terpenuhi tetapi masih ada prngiriman yang belum selesai*/
      $delivery = $this->db->where_in("DeliveryStatus", array("0", "1"))->where("DeliveryRef", $code)->get("TblDelivery");
      if ($delivery->num_rows() > 0) {
         $this->db->update("TblSales", array("SalesStatusDelivery" => 1), array("SalesCode" => $code));
         return;
      } else {
         $this->db->update("TblSales", array("SalesStatusDelivery" => 2), array("SalesCode" => $code));
         return;
      }
   }
   public function upload_file_bukti($id_store, $id_cust, $id_deliver)
   {
      if (!empty($_FILES['file']['name'])) {
         if (!file_exists('asset/image/file/customer/')) {
            mkdir("asset/image/file/customer", 0777);
         }
         if (!file_exists('asset/image/file/customer/' . $id_cust . '/')) {
            mkdir("asset/image/file/customer/" . $id_cust, 0777);
         }
         // Set preference
         $config['upload_path'] = 'asset/image/file/customer/' . $id_cust;
         $config['allowed_types'] = '*';
         $config['max_size'] = '100000'; // max_size in kb
         $config['file_name'] = $_FILES['file']['name'];

         //Load upload library
         $this->load->library('upload', $config);
         // File upload
         if ($this->upload->do_upload('file')) {
            // Get data about the file
            $uploadData = $this->upload->data();
            $data = array(
               "MsCustomerId" => $id_cust,
               "FileCustomerDesc" => "Bukti_Pengiriman.png",
               "FileCustomerImage" => $_FILES['file']['name'],
               "MsWorkplaceId" => $id_store,
            );
            $this->db->insert('TblFileCustomer', $data);
            echo ($this->db->affected_rows() != 1 ? false : true);
         }
      }
      if (!empty($_FILES['file']['name'])) {
         if (!file_exists('asset/image/pengiriman/')) {
            mkdir("asset/image/pengiriman", 0777);
         }
         if (!file_exists('asset/image/pengiriman/' . $id_deliver . '/')) {
            mkdir("asset/image/pengiriman/" . $id_deliver, 0777);
         }
         // Set preference
         $config['upload_path'] = 'asset/image/pengiriman/' . $id_deliver;
         $config['allowed_types'] = '*';
         $config['max_size'] = '100000'; // max_size in kb
         $config['file_name'] = $_FILES['file']['name'];

         //Load upload library
         $this->load->library('upload', $config);
         // File upload
         if ($this->upload->do_upload('file')) {
            // Get data about the file
            $uploadData = $this->upload->data();
            exit;
         }
      }
   }
   public function upload_file_tanda_tangan($id)
   {
      if (!file_exists('asset/image/pengiriman/')) {
         mkdir("asset/image/pengiriman", 0777);
      }
      if (!file_exists('asset/image/pengiriman/' . $id . '/')) {
         mkdir("asset/image/pengiriman/" . $id, 0777);
      }
      $file = $_POST['file']; //your data in base64 'data:image/png....';
      $img = str_replace('data:image/png;base64,', '', $file);
      file_put_contents('asset/image/pengiriman/' . $id . '/tandatangan.png', base64_decode($img));
   }
}
