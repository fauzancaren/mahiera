<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Client_data_sales extends CI_Controller
{
   function __construct()
   {
      parent::__construct();
      $this->load->model('model_app');
      $this->load->helper('directory');
      $this->load->library('image_lib');
      $this->load->model('inventory/Model_inventory', 'm_inventory');
      date_default_timezone_set('Asia/Jakarta');
   }

   public function get_data_customer()
   {
      $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : NULL;;
      $resultCount = 10;
      $end = ($page - 1) * $resultCount;
      $start = $end + $resultCount;

      $search = isset($_REQUEST['search']) ? $_REQUEST['search'] : NULL;
      $query = $this->db->query("SELECT * FROM TblMsCustomer
                                 LEFT JOIN TblMsCustomerType on TblMsCustomer.MsCustomerTypeId =TblMsCustomerType.MsCustomerTypeId 
                                 WHERE (
                                    MsCustomerCode like '%{$search}%' or 
                                    MsCustomerCompany like '%{$search}%' or
                                    MsCustomerName like '%{$search}%' or
                                    MsCustomerAddress like '%{$search}%' or
                                    MsCustomerTelp1 like '%{$search}%' or
                                    MsCustomerTelp2 like '%{$search}%' or
                                    MsCustomerRemarks like '%{$search}%' or
                                    MsCustomerEmail like '%{$search}%' or
                                    MsCustomerTypeName like '%{$search}%'
                                 ) ORDER BY MsCustomerId DESC LIMIT {$end},{$start}")->result();
      $list = array();
      $key = 0;
      foreach ($query as $row) {
         $customer = $row->MsCustomerCode . " - " . ($row->MsCustomerTypeId == 1 ? $row->MsCustomerName : $row->MsCustomerName . ' (' . $row->MsCustomerCompany . ')');
         $customertelp = (($row->MsCustomerTelp2 == "" || $row->MsCustomerTelp2 == "-") ? $row->MsCustomerTelp1 : $row->MsCustomerTelp1 . " / " . $row->MsCustomerTelp2);
         $htmlItem = '
                        <div class="col-12" >
                           <span style="font-size:0.75rem" class="fw-bold">' . $customer . '</span><br>
                           <span style="font-size:0.6rem">' . $customertelp . '</span><br>
                           <span style="font-size:0.6rem">' . $row->MsCustomerAddress . '</span><br>
                           <span style="font-size:0.6rem">Note : ' . $row->MsCustomerRemarks . '</span><br>
                        </div>';
         $list[$key]['id'] = $row->MsCustomerId;
         $list[$key]['text'] = $customer;
         $list[$key]['html'] = $htmlItem;
         $list[$key]['MsCustomerId'] = $row->MsCustomerId;
         $list[$key]['customer'] = $customer;
         $list[$key]['telp'] = $customertelp;
         $list[$key]['Address'] = $row->MsCustomerAddress;
         $key++;
      }
      echo json_encode(['results' => $list, "count_filtered" => $key + 1]);
      exit;
   }
   public function get_data_armada()
   {
      $search = isset($_REQUEST['search']) ? $_REQUEST['search'] : NULL;
      $query = $this->db->query("SELECT * FROM TblMsDelivery WHERE MsDeliveryIsActive='1' and 
                                    MsDeliveryName like '%{$search}%'")->result();

      $list = array();
      $key = 0;
      foreach ($query as $row) {
         $list[$key]['id'] = $row->MsDeliveryId;
         $list[$key]['text'] = $row->MsDeliveryName;
         $key++;
      }
      echo json_encode($list);
      exit;
   }
   public function get_max_customer($id = null)
   {
      if (is_null($id)) {
         $query = $this->db->query("SELECT * FROM TblMsCustomer
               LEFT JOIN TblMsCustomerType on TblMsCustomer.MsCustomerTypeId =TblMsCustomerType.MsCustomerTypeId 
               WHERE MsCustomerIsActive='1' ORDER BY MsCustomerId DESC LIMIT 1")->result();
      } else {
         $query = $this->db->query("SELECT * FROM TblMsCustomer
               LEFT JOIN TblMsCustomerType on TblMsCustomer.MsCustomerTypeId =TblMsCustomerType.MsCustomerTypeId 
               WHERE MsCustomerId='{$id}'")->result();
      }

      $list = array();
      $key = 0;
      foreach ($query as $row) {
         $customer = $row->MsCustomerCode . " - " . ($row->MsCustomerTypeId == 1 ? $row->MsCustomerName : $row->MsCustomerName . ' (' . $row->MsCustomerCompany . ')');
         $customertelp = (($row->MsCustomerTelp2 == "" || $row->MsCustomerTelp2 == "-") ? $row->MsCustomerTelp1 : $row->MsCustomerTelp1 . " / " . $row->MsCustomerTelp2);
         $htmlItem = '
         <div class="col-12" >
         <span style="font-size:0.75rem" class="fw-bold">' . $customer . '</span><br>
         <span style="font-size:0.6rem">' . $customertelp . '</span><br>
         <span style="font-size:0.6rem">' . $row->MsCustomerAddress . '</span><br>
         <span style="font-size:0.6rem">Note : ' . $row->MsCustomerRemarks . '</span><br>
         </div>';
         $list = array(
            'id' => $row->MsCustomerId,
            'text' => $customer,
            'html' => $htmlItem,
            'MsCustomerId' => $row->MsCustomerId,
            'customer' => $customer,
            'telp' => $customertelp,
            'Address' => $row->MsCustomerAddress,
         );
      }
      echo json_encode($list);
      exit;
   }

   public function get_data_history()
   {
      $sales = $this->db->where("SalesCode",  $this->input->post("SalesCode"))->where("SalesEditRef", $this->input->post("SalesRef"))->get("TblSalesBackup")->row();
      $detail = $this->db
         ->join("TblMsItem", "TblMsItem.MsItemId=TblSalesDetailBackup.MsItemId", "left")
         ->join("TblMsVendor", "TblSalesDetailBackup.MsVendorCode=TblMsVendor.MsVendorCode", "left")
         ->join("TblMsItemCategory", "TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId", "left")
         ->join("TblMsCogs", "TblMsItem.MsItemId = TblMsCogs.MsItemId AND TblMsVendor.MsVendorId = TblMsCogs.MsVendorId ", "left")
         ->join("TblInvStock", "TblMsItem.MsItemId = TblInvStock.MsItemId AND TblMsVendor.MsVendorId = TblInvStock.MsVendorId AND TblInvStock.MsWorkplaceId = " . $sales->MsWorkplaceId, "left")
         ->where("SalesDetailRef", $sales->SalesCode)->where("SalesDetailEditRef", $this->input->post("SalesRef"))->get("TblSalesDetailBackup")->result();
      $optional = $this->db->where("SalesOptionalRef", $sales->SalesCode)->where("SalesOptionalEditRef", $this->input->post("SalesRef"))->get("TblSalesOptionalBackup")->result();

      echo json_encode(array(
         "sales" => $sales,
         "detail" => $detail,
         "optional" => $optional,
      ));
      exit;
   }
   public function get_del_customer($id)
   {
      $query = $this->db->query("SELECT * FROM TblMsCustomerDelivery WHERE MsCustomerId='{$id}'")->result();

      echo json_encode($query);
      exit;
   }
   public function get_del_store($id = null)
   {

      if($id){
         $query = $this->db->query("SELECT * FROM TblMsWorkplace WHERE MsWorkplaceId='{$id}'")->row();

         echo json_encode($query);
         exit;
      }
      
   }

   public function get_next_quotation()
   {
      $MsWorkplaceId = $this->input->post("MsWorkplaceId");
      $MsEmpId = $this->input->post("MsEmpId");
      $QuoDate = explode("/", $this->input->post("QuoDate"));

      echo $this->model_app->get_next_quotation($MsWorkplaceId, $QuoDate[1], $QuoDate[2], $MsEmpId);
   }

   public function get_total_card($store)
   {
      if ($store == "-") {
         $count_payment = ($this->db->select("count(SalesStatusPayment) as count")->where_in("SalesStatusPayment", array(1))->get("TblSales")->row())->count;
         $min_payment = ($this->db->select("min(SalesDate) as data")->where_in("SalesStatusPayment", array(1))->get("TblSales")->row())->data;
         $count_trans = ($this->db->select("SUM(SalesGrandTotal) as data")->where_in("SalesStatusPayment", array(1))->get("TblSales")->row())->data -
            ($this->db->select("SUM(PaymentTotal) as data")->join("TblSalesPayment", "SalesCode=PaymentRef", "left")->where_in("SalesStatusPayment", array(1))->get("TblSales")->row())->data;
      } else {
         $count_payment = ($this->db->select("count(SalesStatusPayment) as count")->where_in("SalesStatusPayment", array(1))->where("MsWorkplaceId", $store)->get("TblSales")->row())->count;
         $min_payment = ($this->db->select("min(SalesDate) as data")->where_in("SalesStatusPayment", array(1))->where("MsWorkplaceId", $store)->get("TblSales")->row())->data;
         $count_trans = ($this->db->select("SUM(SalesGrandTotal) as data")->where_in("SalesStatusPayment", array(1))->where("MsWorkplaceId", $store)->get("TblSales")->row())->data -
            ($this->db->select("SUM(PaymentTotal) as data")->join("TblSalesPayment", "SalesCode=PaymentRef", "left")->where_in("SalesStatusPayment", array(1))->where("MsWorkplaceId", $store)->get("TblSales")->row())->data;
      }
      echo json_encode(array(
         "payment" => $count_trans,
         "datepayment" => $min_payment,
         "trans" => $count_payment,
      ));
      exit;
   }
   public function get_card_category()
   {
      $datestart = $this->input->post("datestart");
      $dateend = $this->input->post("dateend");
      $store = $this->input->post("store");
      $this->db->select("MsItemCatName,SUM(SalesDetailQty) as qty")
         ->join("TblMsProduk", "TblMsProduk.MsProdukCatId=TblMsItemCategory.MsItemCatId", "LEFT OUTER")
         ->join("TblSalesDetail", "TblSalesDetail.MsProdukId=TblMsProduk.MsProdukId", "LEFT OUTER")
         ->join("TblSales", "TblSales.SalesCode=TblSalesDetail.SalesDetailRef", "LEFT OUTER")
         ->where_in("SalesStatusPayment", array(1, 2))->where("SalesDate >=", $datestart)->where("SalesDate <=", $dateend)->where("MsItemCatIsActive", 1);
      if ($store != "-") $this->db->where("MsWorkplaceId", $store);
      $result = $this->db->group_by("TblMsProduk.MsProdukCatId")->get("TblMsItemCategory")->result();
      $html = "";
      foreach ($result as $row) {
         $html .= '<div class="d-flex">
                     <span class="flex-grow-1 text-secondary">' . $row->MsItemCatName . '</span>
                     <span>' . number_format($row->qty, 2) . '</span>
                  </div>';
      }
      if ($html == "") {
         $html .= '<div class=" text-center"> 
                     <span>Tidak Ada Data</span>
                  </div>';
      }
      echo $html;
   }
   public function get_card_admin()
   {
      $datestart = $this->input->post("datestart");
      $dateend = $this->input->post("dateend");
      $store = $this->input->post("store");
      $this->db->select("MsEmpCode,MsEmpName,TblMsEmployee.MsEmpId")->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblSales.MsEmpId")
         ->where_in("SalesStatusPayment", array(1, 2))
         ->where("SalesDate >=", $datestart)
         ->where("SalesDate <=", $dateend);
      if ($store != "-") $this->db->where("TblSales.MsWorkplaceId", $store);
      $result = $this->db->group_by("TblSales.MsEmpId")->get("TblSales")->result();
      $html = '<div class="d-flex flex-column header show">';
      foreach ($result as $row) {
         $html .=  '<div class="d-flex fw-bold align-items-center mb-1">
                  <img src="' . base_url() . '/asset/image/employee/' . $row->MsEmpCode . '.png" alt="' . $row->MsEmpName . '" height="40" width="40" class="rounded-circle me-2">
                  <span class="flex-grow-1 text-secondary">' . $row->MsEmpName . '</span>
                  <span class="action-admin-show" onclick=show_detail(this,' . $row->MsEmpId . ')>Lihat detail<i class="fas fa-chevron-right pointer ps-2"></i></span>
               </div>';
      }
      $html .= '</div>';
      if ($html == '<div class="d-flex flex-column header show"></div>') {
         $html = '<div class=" text-center fw-bold"> 
                     <span>Tidak Ada Data</span>
                  </div>';
      }
      echo $html . '<div class="d-flex flex-column fw-bold detail"></div>';
   }
   public function get_card_admin_category($id)
   {
      $datestart = $this->input->post("datestart");
      $dateend = $this->input->post("dateend");
      $store = $this->input->post("store");
      $employee = $this->db->where("MsEmpId", $id)->get("TblMsEmployee")->row();
      $this->db->select("MsItemCatName,SUM(SalesDetailQty) as qty")
         ->join("TblMsProduk", "TblMsProduk.MsProdukCatId=TblMsItemCategory.MsItemCatId", "LEFT OUTER")
         ->join("TblSalesDetail", "TblSalesDetail.MsProdukId=TblMsProduk.MsProdukId", "LEFT OUTER")
         ->join("TblSales", "TblSales.SalesCode=TblSalesDetail.SalesDetailRef", "LEFT OUTER")
         ->where_in("SalesStatusPayment", array(1, 2))->where("SalesDate >=", $datestart)->where("SalesDate <=", $dateend)->where("MsItemCatIsActive", 1)->where("MsEmpId", $id);
      if ($store != "-") $this->db->where("MsWorkplaceId", $store);
      $result = $this->db->group_by("TblMsProduk.MsProdukCatId")->get("TblMsItemCategory")->result();

      $html = '<div class="d-flex align-items-center">
                  <span class="action-admin-show py-2 flex-grow-1 " onclick=show_list(this)><i class="fas fa-chevron-left pointer pe-2"></i>List Admin </span>
                  <img src="' . base_url() . '/asset/image/employee/' . $employee->MsEmpCode . '.png" alt="agus maulana" height="40" width="40" class="rounded-circle me-2">
                  <span class="text-secondary">' . $employee->MsEmpName . '</span>
               </div>';
      $html1 = "";
      foreach ($result as $row) {
         $html1 .= '<div class="d-flex">
                     <span class="flex-grow-1 text-secondary">' . $row->MsItemCatName . '</span>
                     <span>' . number_format($row->qty, 2) . '</span>
                  </div>';
      }
      if ($html1 == "") {
         $html .= '<div class=" text-center"> 
                     <span>Tidak Ada Data</span>
                  </div>';
      } else {
         $html .= $html1;
      }
      echo $html;
   }
   public function get_alert_sales($id)
   {
      $date = $this->input->post("datemin");
      $this->db->where("SalesDate <=", $date)->where("SalesStatusPayment", 0);
      if ($id != "-") $this->db->where("MsWorkplaceId =", $id);
      $result = $this->db->get("TblSales")->result();
      $doc_count = 0;
      $date_min = date_create($date);
      foreach ($result as $row) {
         $doc_count++;
         if ($date_min > date_create($row->SalesDate)) $date_min = date_create($row->SalesDate);
      }
      $html = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
      $html .= '<strong>ada ' . $doc_count . ' dokument! </strong> yang akan segera dibatalkan otomatis oleh sistem.';
      $html .= '<a onclick = "get_list_payment_remove()" class="cursor"> Lihat selengkapnya </a>';
      $html .= '<button type="button" class = "btn-close" data-bs-dismiss = "alert" aria-label = "Close"></button>';
      $html .= '</div>';
      if ($doc_count > 0) {
         echo json_encode(array(
            "html" => $html,
            "datemin" => date_format($date_min, "Y-m-d"),
         ));
      } else {
         echo json_encode(array(
            "html" => "",
            "datemin" => date_format($date_min, "Y-m-d"),
         ));
      }
      exit;
   }
   public function get_quo_code($id)
   {
      echo $this->model_app->get_single_data("QuoCode", "TblQuotation", array("QuoId" => $id));
      exit;
   }

   // ==============================================  UPDATE DATA QUO
   public function data_quotation_add()
   {
      $status = true;
      $data = $this->input->post("data");
      $data += ["QuoLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $data += ["QuoCreateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->insert('TblQuotation', $data);
      if ($status && ($this->db->affected_rows() != 1)) $status = false;

      if (null !== $this->input->post("item")) {
         $dataitem = $this->input->post("item");
         foreach ($dataitem as $row) {
            $this->db->insert('TblQuoDetail', $row);
            if ($status && ($this->db->affected_rows() != 1)) $status = false;
         }
      }
      if (null !== $this->input->post("optional")) {
         $dataoptional = $this->input->post("optional");
         foreach ($dataoptional as $row) {
            $this->db->insert('TblQuoOptional', $row);
            if ($status && ($this->db->affected_rows() != 1)) $status = false;
         }
      }
      // ============================================== INSERT NOTIF
      $datanotif = array(
         "NotifHeader" => "Penawaran Berhasil Dibuat <i class='ps-1 text-success fas fa-check'></i>",
         "NotifDesc" => "Penawaran berhasil dibuat oleh <b>" . $this->session->userdata("MsEmpName") . "</b> dengan No. Quotation <b>" . $data["QuoCode"] . "</b> atas nama <b>" . $this->model_app->get_customer_name($data["MsCustomerId"]) . "</b>",
         "NotifType" => "QUOTATION",
         "NotifRef" => $data["QuoCode"],
         "NotifRefDate" => $data["QuoDate"],
         "MsWorkplaceId" => $data["MsWorkplaceId"],
      );
      $this->model_app->insert_notif($datanotif);

      echo $status;
      exit;
   }

   public function data_quotation_header($id, $val)
   {
      $data = $this->db->where("QuoId", $id)->get("TblQuotation")->row(); 
      $this->db->update('TblQuotation', array('QuoHeader' => $val), array('QuoId' => $id));
      echo ($this->db->affected_rows() != 1) ? false : true; 
      // ============================================== INSERT Log Perubahan Header
      $logheader = array(
         "QuoHeaderOldId" => $data->QuoHeader,
         "QuoHeaderNewId" => $val,
         "QuoCode" => $data->QuoCode,
         "LastUpdateUser" => $this->session->userdata("MsEmpCode") . "-" . $this->session->userdata("MsEmpName"),
      );
      $this->db->insert("TblQuoHeaderBackup", $logheader);

      // ============================================== INSERT NOTIF
      $datanotif = array(
         "NotifHeader" => "Penawaran Berhasil Diubah <i class='ps-1 text-warning fas fa-pencil-alt'></i>",
         "NotifDesc" => "Penawaran diubah Header oleh <b>" . $this->session->userdata("MsEmpName") . "</b> dari <b>" . $this->model_app->get_store($data->QuoHeader) . "</b> ke <b>" . $this->model_app->get_store($val) . "</b> dengan No. Quotation <b>" . $data->QuoCode . "</b> atas nama <b>" . $this->model_app->get_customer_name($data->MsCustomerId) . "</b>",
         "NotifType" => "QUOTATION",
         "NotifRef" => $data->QuoCode,
         "NotifRefDate" => $data->QuoDate,
         "MsWorkplaceId" => $data->MsWorkplaceId,
      );
      $this->model_app->insert_notif($datanotif);
      exit;
   }

   public function data_quotation_edit($id)
   {
      $dataold = $this->db->select("* ,(QuoEditRef + 1) as QuoEditRef")->where("QuoId", $id)->get("TblQuotation")->row();
      $datadetailold = $this->db->select("* ,".$dataold->QuoEditRef." as QuoDetailEditRef")->where("QuoDetailRef", $dataold->QuoCode)->get("TblQuoDetail");
      $dataoptionalold = $this->db->select("* ,".$dataold->QuoEditRef." as QuoDetailEditRef")->where("QuoOptionalRef", $dataold->QuoCode)->get("TblQuoOptional");

      // ========================= CREATE BACKUP DATA
      $this->db->insert("TblQuotationBackup", $dataold);
      if ($datadetailold->num_rows() > 0) $this->db->insert_batch("TblQuoDetailBackup", $datadetailold->result());
      if ($dataoptionalold->num_rows() > 0) $this->db->insert_batch("TblQuoOptionalBackup", $dataoptionalold->result());

      $status = true;
      $data = $this->input->post("data");
      $data += ["QuoLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->update('TblQuotation', $data, array("QuoId" => $id));
      if ($status && ($this->db->affected_rows() != 1)) $status = false;

      $this->db->delete('TblQuoDetail', array('QuoDetailRef' => $this->model_app->get_single_data("QuoCode", "TblQuotation", array("QuoId" => $id))));
      if (null !== $this->input->post("item")) {
         $dataitem = $this->input->post("item");
         foreach ($dataitem as $row) {
            $this->db->insert('TblQuoDetail', $row);
            if ($status && ($this->db->affected_rows() != 1)) $status = false;
         }
      }

      $this->db->delete('TblQuoOptional', array('QuoOptionalRef' => $this->model_app->get_single_data("QuoCode", "TblQuotation", array("QuoId" => $id))));
      if (null !== $this->input->post("optional")) {
         $dataoptional = $this->input->post("optional");
         foreach ($dataoptional as $row) {
            $this->db->insert('TblQuoOptional', $row);
            if ($status && ($this->db->affected_rows() != 1)) $status = false;
         }
      }
      // ============================================== INSERT NOTIF
      $datanotif = array(
         "NotifHeader" => "Penawaran Berhasil Diubah <i class='ps-1 text-warning fas fa-pencil-alt'></i>",
         "NotifDesc" => "Penawaran diubah oleh <b>" . $this->session->userdata("MsEmpName") . "</b>  dengan No. Quotation <b>" . $dataold->QuoCode . "</b> atas nama <b>" . $this->model_app->get_customer_name($dataold->MsCustomerId) . "</b>",
         "NotifType" => "QUOTATION",
         "NotifRef" => $dataold->QuoCode,
         "NotifRefDate" => $dataold->QuoDate,
         "MsWorkplaceId" => $dataold->MsWorkplaceId,
      );
      $this->model_app->insert_notif($datanotif);

      echo $status;
      exit;
   }

   public function data_quotation_disabled($id)
   {

      $data = $this->db->where("QuoId", $id)->get("TblQuotation")->row();

      $this->db->update('TblQuotation', array('QuoStatus' => 2), array('QuoId' => $id));
      echo ($this->db->affected_rows() != 1) ? false : true;

      // ============================================== INSERT NOTIF
      $datanotif = array(
         "NotifHeader" => "Penawaran Berhasil dibatalkan <i class='fas fa-times-circle text-danger'></i>",
         "NotifDesc" => "Penawaran dibatalkan oleh <b>" . $this->session->userdata("MsEmpName") . "</b> dengan No. Quotation <b>" . $data->QuoCode . "</b> atas nama <b>" . $this->model_app->get_customer_name($data->MsCustomerId) . "</b>",
         "NotifType" => "QUOTATION",
         "NotifRef" => $data->QuoCode,
         "NotifRefDate" => $data->QuoDate,
         "MsWorkplaceId" => $data->MsWorkplaceId,
      );
      $this->model_app->insert_notif($datanotif);

      exit;
   }

   public function get_data_quotation($id)
   {
      $dataquo = $this->db->where("QuoId", $id)->get("TblQuotation")->row(); 
      $dataitem = $this->db->join("TblMsSatuan","TblQuoDetail.SatuanId=TblMsSatuan.SatuanId")->join("TblMsProduk","TblMsProduk.MsProdukId=TblQuoDetail.MsProdukId")->where("QuoDetailRef", $dataquo->QuoCode)->get("TblQuoDetail")->result();  
      $arr_item = array();    
      foreach($dataitem as $row){
         $arr_item[] = array(
            "MsProdukId"=>$row->MsProdukId,
            "MsProdukCode"=>$row->MsProdukCode,
            "MsProdukName"=>$row->MsProdukName,
            "MsProdukImage"=>(file_exists(getcwd() . "/asset/image/produk/" .  $row->MsProdukId."/".$row->MsProdukCode."_1.png") ?
                              base_url("asset/image/produk/".$row->MsProdukId."/".$row->MsProdukCode."_1.png") : base_url("asset/image/mgs-erp/defaultitem.png")),
            "MsProdukVarian"=>$row->MsProdukVarian,
            "selected"=>explode("|",$row->QuoDetailVarian),
            "MsProdukDetail"=>$this->db->join("TblMsSatuan","TblMsProdukDetail.SatuanId=TblMsSatuan.SatuanId")->where("MsProdukDetailRef",$row->MsProdukId)->get("TblMsProdukDetail")->result(),
            "MsProdukStock"=>$this->db->where("MsProdukId",$row->MsProdukId)->get("TblMsProdukStock")->result(),
            "price"=>$row->QuoDetailPrice,
            "qty"=>$row->QuoDetailQty,
            "pricetotal"=>$row->QuoDetailTotal,
            "discitemprice"=>$row->QuoDetailDisc,
            "discitempersen"=>$row->QuoDetailDiscPercen,
            "discitemtype"=>$row->QuoDetailDiscType,
            "disctype"=>$row->QuoDetailDiscTypeAll,
            "disctotalprice"=>$row->QuoDetailDiscTotal,
            "disctotalpersen"=>$row->QuoDetailDiscTotalPercen,
            "disctotaltype"=>$row->QuoDetailDiscTotalType,
            "cogs"=>$row->QuoDetailCogs,
            "uom"=>$row->SatuanName,
         ); 
      }
      $datadetailquo = $arr_item;
      $dataoptionalquo = $this->db
         ->where("QuoOptionalRef", $dataquo->QuoCode)->get("TblQuoOptional")->result();
      echo json_encode(array(
         "header" => $dataquo,
         "detail" => $datadetailquo,
         "optional" => $dataoptionalquo,
      ));
      exit;
   }

   // ==============================================  FUNCTION GET DATA

   function get_data_approve()
   {
      $toko = $this->input->post("tb_status");
      $search = $this->input->post("tb_search");
      if ($toko != "-") $this->db->like("TblSales.MsWorkplaceId", $toko);
      $this->db->join('TblSales', 'TblSales.SalesCode = TblSalesRequest.SalesCode');
      $this->db->join('TblMsCustomer', 'TblSales.MsCustomerId=TblMsCustomer.MsCustomerId');
      $this->db->join('TblMsEmployee', 'TblSalesRequest.SalesRequestUser=TblMsEmployee.MsEmpId');

      $this->db->where("SalesRequestApprove", 0);
      $this->db->group_start();
      $this->db->like("TblSales.SalesCode", $search)->or_like("MsCustomerName", $search)->or_like("MsCustomerCompany", $search)->or_like("MsCustomerCode", $search);
      $this->db->group_end();
      $master = $this->db->get("TblSalesRequest")->result();
      $html = "";
      $no = 0;
      foreach ($master as $row) {
         $sales_telp = (($row->MsCustomerTelp2 == "" || $row->MsCustomerTelp2 == "-") ? $row->MsCustomerTelp1 : $row->MsCustomerTelp1 . " / " . $row->MsCustomerTelp2);
         if ($row->SalesRequestType == "SALES EDIT") {
            $note = "Pengajuan <span class='text-primary'>Perubahan</span> Data Sales";
            $action = "approve_click(" . $row->SalesId . "," . $row->SalesRequestId . ")";
         } else if ($row->SalesRequestType == "SALES REMOVE") {
            $note = "Pengajuan <span class='text-danger'>Pembatalan</span> Data Sales";
            $action = "remove_click(" . $row->SalesId . "," . $row->SalesRequestId . ")";
         } else if ($row->SalesRequestType == "DELIVERY PRINT") {
            $note = "Pengajuan <span class='text-primary'>Print</span> pengiriman";
            $action = "delivery_click(" . $row->SalesId . "," . $row->SalesRequestId . ")";
         }
         $html .= '<div class="row datatable-header mb-1"> 
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
                     <div class="col-md-5 col-sm-12 p-1 g-1"> 
                        <div class="row">
                           <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                 <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-user-alt"></i></span>
                           </div>      
                           <div class="col pe-0">
                                 <span class="text-dark text-uppercase fw-bold" style="font-size:12px;">' .  $row->MsEmpName . '</span>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                 <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-sticky-note"></i></span>
                           </div>      
                           <div class="col pe-0">
                                 <span class="text-dark text-uppercase fw-bold" style="font-size:12px;">' .  $note . '</span>
                           </div>
                        </div> 
                        <div class="row">
                           <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                 <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-clipboard"></i></span>
                           </div>      
                           <div class="col pe-0">
                                 <span class="text-dark" style="font-size:12px;">' .  $row->SalesRequestDesc . '</span>
                           </div>
                        </div> 
                     </div>
                     <div class="col-md-2 col-sm-12 p-1 g-1 align-items-center">
                        <button type="button" class="btn btn-outline-success btn-sm mx-1" onclick="' . $action . '" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                           <i class="fas fa-share-square"></i>  
                           <span class="fw-bold">
                           &nbsp;Approve
                           </span>
                        </button>
                     </div>
                  </div>';
      }
      if ($html == "") {
         $html = '<img src="' . base_url("asset/image/mgs-erp/iconnotfound.png") . '" class="rounded mx-auto d-block" width="300px">';
      }
      echo $html;
   }

   function data_sales_approve()
   {
      $this->db->update(
         "TblSalesRequest",
         array(
            "SalesRequestApprove" =>  1,
            "SalesRequestApproveUser" =>  $this->session->userdata("MsEmpId"),
            "SalesRequestApproveCreate" => date("Y-m-d H:i:s")
         ),
         array("SalesRequestId" => $this->input->post("ApproveId"))
      );
      $this->db->update("TblSales", array("SalesRequestEdit" => 2), array("SalesId" => $this->input->post("SalesId")));

      $dataold = $this->db->where("SalesId", $this->input->post("SalesId"))->get("TblSales")->row();
      // ============================================== INSERT NOTIF
      $datanotif = array(
         "NotifHeader" => "Edit Sales Berhasil diapproval <i class='ps-1 text-success fas fa-check'></i>",
         "NotifDesc" => "Edit Sales diapprove oleh <b>" . $this->session->userdata("MsEmpName") . "</b>  dengan No. Sales <b>" . $dataold->SalesCode . "</b> atas nama <b>" . $this->model_app->get_customer_name($dataold->MsCustomerId) . "</b>",
         "NotifType" => "SALES",
         "NotifRef" => $dataold->SalesCode,
         "NotifRefDate" => $dataold->SalesDate,
         "MsWorkplaceId" => $dataold->MsWorkplaceId,
      );
      $this->model_app->insert_notif($datanotif);
      echo "true";
      exit;
   }
   function data_sales_approve_cancel()
   {
      $this->db->update(
         "TblSalesRequest",
         array(
            "SalesRequestApprove" =>  1,
            "SalesRequestApproveUser" =>  $this->session->userdata("MsEmpId"),
            "SalesRequestApproveCreate" => date("Y-m-d H:i:s")
         ),
         array("SalesRequestId" => $this->input->post("ApproveId"))
      );
      $this->db->update("TblSales", array("SalesRequestCancel" => 0, "SalesStatusPayment" => 3), array("SalesId" => $this->input->post("SalesId")));

      $dataold = $this->db->where("SalesId", $this->input->post("SalesId"))->get("TblSales")->row();
      $dataapprove = $this->db->join("TblMsEmployee", "MsEmpId=SalesRequestUser")->where("SalesRequestId", $this->input->post("ApproveId"))->get("TblSalesRequest")->row();
      $this->db->insert(
         'TblSalesLog',
         array(
            "SalesLogRef" =>  $dataold->SalesCode,
            "SalesLogDesc" => "<b>Sales</b> telah <b><span style='color:red'>DIBATALKAN</span></b> oleh <b>" . $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")  . "</b> permintaan dari <b>" . $dataapprove->MsEmpName . "</b>"
         )
      );
      // ============================================== INSERT NOTIF
      $datanotif = array(
         "NotifHeader" => "Sales Berhasil dibatalkan <i class='ps-1 text-success fas fa-check'></i>",
         "NotifDesc" => "Request pembatalan Sales diapprove oleh <b>" . $this->session->userdata("MsEmpName") . "</b>  dengan No. Sales <b>" . $dataold->SalesCode . "</b> atas nama <b>" . $this->model_app->get_customer_name($dataold->MsCustomerId) . "</b>",
         "NotifType" => "SALES",
         "NotifRef" => $dataold->SalesCode,
         "NotifRefDate" => $dataold->SalesDate,
         "MsWorkplaceId" => $dataold->MsWorkplaceId,
      );
      $this->model_app->insert_notif($datanotif);
      echo "true";
      exit;
   }
   function data_sales_approve_delivery()
   {
      $this->db->update(
         "TblSalesRequest",
         array(
            "SalesRequestApprove" =>  1,
            "SalesRequestApproveUser" =>  $this->session->userdata("MsEmpId"),
            "SalesRequestApproveCreate" => date("Y-m-d H:i:s")
         ),
         array("SalesRequestId" => $this->input->post("ApproveId"))
      );
      $this->db->update("TblSales", array("SalesDeliveryRequest" => 2), array("SalesId" => $this->input->post("SalesId")));

      $dataold = $this->db->where("SalesId", $this->input->post("SalesId"))->get("TblSales")->row();
      // ============================================== INSERT NOTIF
      $datanotif = array(
         "NotifHeader" => "Aprroval Print Pengiriman berhasil<i class='ps-1 text-success fas fa-check'></i>",
         "NotifDesc" => "Print Pengiriman berhasil diapprove oleh <b>" . $this->session->userdata("MsEmpName") . "</b>  dengan No. Sales <b>" . $dataold->SalesCode . "</b> atas nama <b>" . $this->model_app->get_customer_name($dataold->MsCustomerId) . "</b>",
         "NotifType" => "SALES",
         "NotifRef" => $dataold->SalesCode,
         "NotifRefDate" => $dataold->SalesDate,
         "MsWorkplaceId" => $dataold->MsWorkplaceId,
      );
      $this->model_app->insert_notif($datanotif);
      echo "true";
      exit;
   }

   function valid_data_delivery($id)
   {
      if ($this->session->userdata("login_mode") == "Superuser" || $this->session->userdata("login_mode") == "Finance") {
         echo "2";
         return;
      }
      $data_delivery = $this->db->join("TblSales", "TblSales.SalesCode=TblDelivery.DeliveryRef", "left")->where("DeliveryId", $id)->get("TblDelivery")->row();
      if ($data_delivery->SalesStatusPayment == null)  echo "2";
      if ($data_delivery->SalesStatusPayment < 2) {
         if ($data_delivery->SalesDeliveryRequest == 0) echo "0";
         if ($data_delivery->SalesDeliveryRequest == 1) echo "1";
         if ($data_delivery->SalesDeliveryRequest == 2) echo "2";
      } else {
         echo "2";
      }
   }
   public function get_next_sales()
   {
      $MsWorkplaceId = $this->input->post("MsWorkplaceId");
      $MsEmpId = $this->input->post("MsEmpId");
      $Date = explode("/", $this->input->post("SalesDate"));

      echo $this->model_app->get_next_sales($MsWorkplaceId, $Date[1], $Date[2], $MsEmpId);
   }
   public function get_sales_code($id)
   {
      echo $this->model_app->get_single_data("SalesCode", "TblSales", array("SalesId" => $id));
      exit;
   }
   public function get_data_sales($id)
   {
      $result = $this->db->join("TblQuotation", "TblQuotation.QuoCode=TblSales.SalesRef", "left")->where("QuoId", $id)->get("TblSales")->row();
      header('Content-type: application/json');
      echo json_encode($result);
      exit;
   }
   public function get_sales_log($id)
   {
      $data = $this->db->where("SalesLogRef", $this->model_app->get_single_data("SalesCode", "TblSales", array("SalesId" => $id)))->get("TblSalesLog")->result();
      $html = "<ul>";
      foreach ($data as $row) {
         $now = date_create($row->SalesLogCreate);
         $now->modify('+7 hours');
         //$new_time = date("Y-m-d H:i:s", strtotime('+7 hours', $now)); // $now + 3 hours
         $html .= "<li><div><time>" .  date_format($now, "Y-m-d H:i:s")  . "</time>" . $row->SalesLogDesc . "</div></li>";
      }
      $html .= "</ul>";
      echo $html;
      exit;
   }
   public function get_sales_request($id)
   {
      $data = $this->db->where("SalesCode", $this->model_app->get_single_data("SalesCode", "TblSales", array("SalesId" => $id)))->get("TblSalesRequest")->result();
      $html = "<ul>";
      foreach ($data as $row) {
         if ($row->SalesRequestApprove > 0) {
            $approval = "<time>" .  date_format(date_create($row->SalesRequestApproveCreate), "Y-m-d H:i:s")  . "</time>Request Telah diapprove oleh <b>" .
               $this->model_app->get_single_data("MsEmpName", "TblMsEmployee", array("MsEmpId" => $row->SalesRequestApproveUser)) . "</b>";
         } else {
            $approval = "masih menunggu approval dari superuser";
         }
         $html .= "<li><div><time>" .  date_format(date_create($row->SalesRequestUserCreate), "Y-m-d H:i:s")  . "</time>Request Telah dibuat oleh <b>" .
            $this->model_app->get_single_data("MsEmpName", "TblMsEmployee", array("MsEmpId" => $row->SalesRequestUser)) . "</b> dengan keterangan <br><b>" . $row->SalesRequestDesc . "</b></div><div>" . $approval . "</div></li>";
      }
      $html .= "</ul>";
      echo $html;
      exit;
   }
   public function upload_file()
   {
      $this->model_app->upload_file($_POST['data'], $_POST['fname']);
   }
   public function remove_file()
   {
      $this->model_app->remove_file($_POST['fname']);
   }
   public function data_sales_add()
   {
      $status = true;
      $sales = $this->input->post("data");
      $sales += ["SalesLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $sales += ["SalesCreateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->insert('TblSales', $sales);
      if ($status && ($this->db->affected_rows() != 1)) $status = false;
      if ($sales["SalesRef"] != "") {
         $this->db->update('TblQuotation', array('QuoStatus' => 1), array('QuoCode' => $sales["SalesRef"]));
         $this->db->insert(
            'TblSalesLog',
            array(
               "SalesLogRef" => $sales["SalesCode"],
               "SalesLogDesc" => "<b>Sales</b> Telah <span style='color:green'>dibuat</span> oleh <b>" . $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
                  . "</b> dari referensi no. quotation <b>" . $sales["SalesRef"] . "</b>"
            )
         );

         // ============================================== INSERT NOTIF
         $datanotif = array(
            "NotifHeader" => "Penawaran Berhasil Diteruskan ke Penjualan <i class='ps-1 text-success fas fa-check'></i>",
            "NotifDesc" => "Penawaran berhasil diteruskan oleh <b>" . $this->session->userdata("MsEmpName") . "</b> dengan No. Quotation <b>" . $sales["SalesRef"] . "</b> atas nama <b>" . $this->model_app->get_customer_name($sales["MsCustomerId"]) . "</b> ke No. Sales  <b>" . $sales["SalesCode"] . "</b>",
            "NotifType" => "QUOTATION",
            "NotifRef" => $sales["SalesRef"],
            "NotifRefDate" => $sales["SalesDate"],
            "MsWorkplaceId" => $sales["MsWorkplaceId"],
         );
         $this->model_app->insert_notif($datanotif);
      } else {
         $this->db->insert(
            'TblSalesLog',
            array(
               "SalesLogRef" => $sales["SalesCode"],
               "SalesLogDesc" => "<b>Sales</b> Telah <span style='color:green'>dibuat</span> oleh <b>" . $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
                  . "</b>"
            )
         );
      }
      if (null !== $this->input->post("item")) {
         $dataitem = $this->input->post("item");
         foreach ($dataitem as $row) {
            $this->db->insert('TblSalesDetail', $row);
            if ($status && ($this->db->affected_rows() != 1)) $status = false;
         }
      }
      if (null !== $this->input->post("optional")) {
         $dataoptional = $this->input->post("optional");
         foreach ($dataoptional as $row) {
            $this->db->insert('TblSalesOptional', $row);
            if ($status && ($this->db->affected_rows() != 1)) $status = false;
         }
      }
      echo $status;

      // ============================================== INSERT NOTIF
      $datanotif = array(
         "NotifHeader" => "Penjualan Berhasil Dibuat <i class='ps-1 text-success fas fa-check'></i>",
         "NotifDesc" => "Penjualan berhasil dibuat oleh <b>" . $this->session->userdata("MsEmpName") . "</b> dengan No. Sales <b>" . $sales["SalesCode"] . "</b> atas nama <b>" . $this->model_app->get_customer_name($sales["MsCustomerId"]) . "</b>",
         "NotifType" => "SALES",
         "NotifRef" => $sales["SalesCode"],
         "NotifRefDate" => $sales["SalesDate"],
         "MsWorkplaceId" => $sales["MsWorkplaceId"],
      );
      $this->model_app->insert_notif($datanotif); 
      exit;
   }
   public function data_sales_edit($id)
   {
      $status = true;
      $datasales = $this->db->where("SalesId", $id)->get("TblSales")->row();

      // INSERT BACKUP 
      $dataold = array(
         "SalesCode" => $datasales->SalesCode,
         "SalesDate" => $datasales->SalesDate,
         "SalesDate2" => $datasales->SalesDate2,
         "SalesHeader" => $datasales->SalesHeader,
         "MsEmpId" => $datasales->MsEmpId,
         "SalesSubTotal" => $datasales->SalesSubTotal,
         "SalesDiscTotal" => $datasales->SalesDiscTotal,
         "SalesDeliveryTotal" => $datasales->SalesDeliveryTotal,
         "SalesGrandTotal" => $datasales->SalesGrandTotal,
         "SalesDelStatus" => $datasales->SalesDelStatus,
         "MsDeliveryId" => $datasales->MsDeliveryId,
         "SalesStatus" => $datasales->SalesStatus,
         "MsWorkplaceId" => $datasales->MsWorkplaceId,
         "SalesRef" => $datasales->SalesRef,
         "SalesPromoCode" => $datasales->SalesPromoCode,
         "MsCustomerId" => $datasales->MsCustomerId,
         "MsCustomerDeliveryId" => $datasales->MsCustomerDeliveryId,
         "SalesStatusPayment" => $datasales->SalesStatusPayment,
         "SalesStatusDelivery" => $datasales->SalesStatusDelivery,
         "SalesStatusPO" => $datasales->SalesStatusPO,
         "SalesCreate" => $datasales->SalesCreate,
         "SalesCreateUser" => $datasales->SalesCreateUser,
         "SalesLastUpdate" => $datasales->SalesLastUpdate,
         "SalesLastUpdateUser" => $datasales->SalesLastUpdateUser,
         "SalesRequestEdit" => $datasales->SalesRequestEdit,
         "SalesCountEdit" => $datasales->SalesCountEdit,
         "SalesRequestCancel" => $datasales->SalesRequestCancel,
         "SalesEditRef" => $datasales->SalesCountEdit + 1,
      );
      $this->db->insert("TblSalesBackup",  $dataold);
      $datadetailsales = $this->db->query("select * ," . (intval($datasales->SalesCountEdit) + 1) . " as SalesDetailEditRef from TblSalesDetail where SalesDetailRef='" . $datasales->SalesCode . "'");
      if ($datadetailsales->num_rows() > 0) $this->db->insert_batch("TblSalesDetailBackup",  $datadetailsales->result());

      $dataoptionalsales = $this->db->query("select * ," . (intval($datasales->SalesCountEdit) + 1) . " as SalesOptionalEditRef from TblSalesOptional where SalesOptionalRef='" . $datasales->SalesCode . "'");
      if ($dataoptionalsales->num_rows() > 0) $this->db->insert_batch("TblSalesOptionalBackup",  $dataoptionalsales->result());

      $this->db->update("TblSales", array("SalesCountEdit" => (intval($datasales->SalesCountEdit) + 1), "SalesRequestEdit" => 0), array("SalesId" => $id));



      $sales = $this->input->post("data");
      $sales += ["SalesLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->update('TblSales', $sales, array("SalesId" => $id));

      $this->db->insert(
         'TblSalesLog',
         array(
            "SalesLogRef" => $datasales->SalesCode,
            "SalesLogDesc" => "<b>Sales</b> Telah <span style='color:green'>di ubah </span> oleh <b>" . $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
               . "</b>"
         )
      );
      if (null !== $this->input->post("item")) {
         $dataitem = $this->input->post("item");
         $this->db->delete('TblSalesDetail', array("SalesDetailRef" => $datasales->SalesCode));
         foreach ($dataitem as $row) {
            $this->db->insert('TblSalesDetail', $row);
            if ($status && ($this->db->affected_rows() != 1)) $status = false;
         }
      }
      $this->db->delete('TblSalesOptional', array("SalesOptionalRef" => $datasales->SalesCode));
      if (null !== $this->input->post("optional")) {
         $dataoptional = $this->input->post("optional");
         foreach ($dataoptional as $row) {
            $this->db->insert('TblSalesOptional', $row);
            if ($status && ($this->db->affected_rows() != 1)) $status = false;
         }
      }

      // CHANGE STATUS payment
      $data = $this->db
         ->query("Select ifnull(sum(PaymentTotal),0) as total from TblSalesPayment Where PaymentRef='" . $datasales->SalesCode . "'")
         ->row();
      if ($datasales->SalesGrandTotal == $data->total) {
         $this->db->update('TblSales', array('SalesStatusPayment' => 2), array('SalesCode' => $datasales->SalesCode));
      } else {
         if ($data->total == 0) {
            $this->db->update('TblSales', array('SalesStatusPayment' => 0), array('SalesCode' => $datasales->SalesCode));
         } else if ($datasales->SalesGrandTotal > $data->total) {
            $this->db->update('TblSales', array('SalesStatusPayment' => 1), array('SalesCode' => $datasales->SalesCode));
         } else {
            $this->db->update('TblSales', array('SalesStatusPayment' => 2), array('SalesCode' => $datasales->SalesCode));
         }
      }

      // CHANGE STATUS Delivery   
      $totaldelivery = ($this->db
         ->query("Select ifnull(sum(DeliveryDetailQty),0) as total from TblDelivery left join TblDeliveryDetail on DeliveryCode=DeliveryDetailRef Where DeliveryRef='" . $datasales->SalesCode . "'")
         ->row())->total;
      $totalsales = ($this->db
         ->query("Select ifnull(sum(SalesDetailQty),0) as total from TblSales left join TblSalesDetail on SalesCode=SalesDetailRef Where SalesCode='" . $datasales->SalesCode . "'")
         ->row())->total;
      if ($totaldelivery < $totalsales) {
         $this->db->update('TblSales', array('SalesStatusDelivery' => 0), array('SalesCode' => $datasales->SalesCode));
      }

      // CHANGE STATUS PO   
      $totalPO = ($this->db
         ->query("Select ifnull(sum(PODetailQty),0) as total from TblPO left join TblPODetail on POCode=PODetailRef Where SalesRef='" . $datasales->SalesCode . "'")
         ->row())->total;
      if ($totalPO < $totalsales) {
         $this->db->update('TblSales', array('SalesStatusPO' => 0), array('SalesCode' => $datasales->SalesCode));
      }

      // UPDATE STOCK
     // $this->m_inventory->insert_trans_from_sales($datasales->SalesCode);

      // ============================================== INSERT NOTIF
      $datanotif = array(
         "NotifHeader" => "Penjualan Berhasil Diubah <i class='ps-1 text-warning fas fa-pencil-alt'></i>",
         "NotifDesc" => "Penjualan berhasil Diubah oleh <b>" . $this->session->userdata("MsEmpName") . "</b> dengan No. Sales <b>" . $datasales->SalesCode . "</b> atas nama <b>" . $this->model_app->get_customer_name($sales["MsCustomerId"]) . "</b>",
         "NotifType" => "SALES",
         "NotifRef" => $datasales->SalesCode,
         "NotifRefDate" => $sales["SalesDate"],
         "MsWorkplaceId" => $sales["MsWorkplaceId"],
      );
      $this->model_app->insert_notif($datanotif);
      echo $status;
      exit;
   }
   public function data_sales_header($id, $val)
   {
      $data = $this->db->where("SalesId", $id)->get("TblSales")->row();
      $headerold = $this->model_app->get_single_data("SalesHeader", "TblSales", array("SalesId" => $id));
      $storeold = $this->model_app->get_store($headerold);
      $storenew = $this->model_app->get_store($val);
      $this->db->insert(
         'TblSalesLog',
         array(
            "SalesLogRef" => $this->model_app->get_single_data("SalesCode", "TblSales", array("SalesId" => $id)),
            "SalesLogDesc" => "<b>Sales</b> " . $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
               . "</b> telah mengubah header dari <b>" . $storeold . "</b> menjadi <b>" . $storenew . "</b>"
         )
      );
      $this->db->update('TblSales', array('SalesHeader' => $val, "SalesLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")), array('SalesId' => $id));

      // ============================================== INSERT NOTIF
      $datanotif = array(
         "NotifHeader" => "Penjualan Berhasil Diubah <i class='ps-1 text-warning fas fa-pencil-alt'></i>",
         "NotifDesc" => "Penjualan diubah Header oleh <b>" . $this->session->userdata("MsEmpName") . "</b> dari <b>" . $storeold . "</b> ke <b>" . $storenew . "</b> dengan No. Sales <b>" . $data->SalesCode . "</b> atas nama <b>" . $this->model_app->get_customer_name($data->MsCustomerId) . "</b>",
         "NotifType" => "SALES",
         "NotifRef" => $data->SalesCode,
         "NotifRefDate" => $data->SalesDate,
         "MsWorkplaceId" => $data->MsWorkplaceId,
      );
      $this->model_app->insert_notif($datanotif);

      echo ($this->db->affected_rows() != 1) ? false : true;
   }
   public function data_sales_disabled($id)
   {
      $data = $this->db->where("SalesId", $id)->get("TblSales")->row();
      $this->db->insert(
         'TblSalesLog',
         array(
            "SalesLogRef" => $this->model_app->get_single_data("SalesCode", "TblSales", array("SalesId" => $id)),
            "SalesLogDesc" => "<b>Sales</b> telah <b><span style='color:red'>DIBATALKAN</span></b> oleh <b>" . $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
               . "</b>"
         )
      );

      $this->db->update('TblSales', array('SalesStatusPayment' => 3, 'SalesStatusDelivery' => 3, 'SalesStatusPO' => 3,), array('SalesId' => $id));
      echo ($this->db->affected_rows() != 1) ? false : true;

      // ============================================== INSERT NOTIF
      $datanotif = array(
         "NotifHeader" => "Penjualan Berhasil dibatalkan <i class='ps-1 fas fa-times-circle text-danger'></i>",
         "NotifDesc" => "Penjualan dibatalkan oleh <b>" . $this->session->userdata("MsEmpName") . "</b> dengan No. Sales <b>" . $data->SalesCode . "</b> atas nama <b>" . $this->model_app->get_customer_name($data->MsCustomerId) . "</b>",
         "NotifType" => "SALES",
         "NotifRef" => $data->SalesCode,
         "NotifRefDate" => $data->SalesDate,
         "MsWorkplaceId" => $data->MsWorkplaceId,
      );
      $this->model_app->insert_notif($datanotif);

      exit;
   }
   public function request_edit($id)
   {
      $datasales = $this->db->where("SalesId", $id)->get("TblSales")->row();
      $this->db->update("TblSales", array("SalesRequestEdit" => 1), array("SalesId" => $id));
      $this->db->insert(
         'TblSalesRequest',
         array(
            "SalesRequestDesc" => $this->input->post("request"),
            "SalesCode" => $this->model_app->get_single_data("SalesCode", "TblSales", array("SalesId" => $id)),
            "SalesRequestUser" => $this->session->userdata("MsEmpId"),
            "SalesRequestUserCreate" => date("Y-m-d H:i:s"),
            "SalesRequestType" => "SALES EDIT"
         )
      );

      $datanotif = array(
         "NotifHeader" => "Ada Approval Edit Penjualan <i class='ps-1 fas fa-dolar-sign text-success'></i>",
         "NotifDesc" => "Ada pengajuan edit sales dari <b>" . $this->session->userdata("MsEmpName") . "</b> dengan No. Sales <b>" . $datasales->SalesCode . "</b> atas nama <b>" . $this->model_app->get_customer_name($datasales->MsCustomerId) . "</b>",
         "NotifType" => "APPROVE SALES",
         "NotifRef" => $datasales->SalesCode,
         "NotifRefDate" => $datasales->SalesCode,
         "MsWorkplaceId" => $datasales->MsWorkplaceId,
      );
      $this->model_app->insert_notif_approve_superuser($datanotif);
      echo true;
   }
   public function request_delivery($id)
   {
      $datasales = $this->db->join("TblDelivery", "TblSales.SalesCode=TblDelivery.DeliveryRef")->where("DeliveryId", $id)->get("TblSales")->row();
      $this->db->update("TblSales", array("SalesDeliveryRequest" => 1), array("SalesId" => $datasales->SalesId));
      $this->db->insert(
         'TblSalesRequest',
         array(
            "SalesRequestDesc" => $this->input->post("request"),
            "SalesCode" => $datasales->SalesCode,
            "SalesRequestUser" => $this->session->userdata("MsEmpId"),
            "SalesRequestUserCreate" => date("Y-m-d H:i:s"),
            "SalesRequestType" => "DELIVERY PRINT"
         )
      );

      $datanotif = array(
         "NotifHeader" => "Ada Approval Print Pengiriman <i class='ps-1 fas fa-dolar-sign text-success'></i>",
         "NotifDesc" => "Ada pengajuan print pengiriman dari <b>" . $this->session->userdata("MsEmpName") . "</b> dengan No. Sales <b>" . $datasales->SalesCode . "</b> atas nama <b>" . $this->model_app->get_customer_name($datasales->MsCustomerId) . "</b>",
         "NotifType" => "APPROVE SALES",
         "NotifRef" => $datasales->SalesCode,
         "NotifRefDate" => $datasales->SalesCode,
         "MsWorkplaceId" => $datasales->MsWorkplaceId,
      );
      $this->model_app->insert_notif_approve_superuser($datanotif);
      echo true;
   }
   public function request_remove($id)
   {
      $datasales = $this->db->where("SalesId", $id)->get("TblSales")->row();
      $this->db->update("TblSales", array("SalesRequestCancel" => 1), array("SalesId" => $id));
      $this->db->insert(
         'TblSalesRequest',
         array(
            "SalesRequestDesc" => $this->input->post("request"),
            "SalesCode" => $this->model_app->get_single_data("SalesCode", "TblSales", array("SalesId" => $id)),
            "SalesRequestUser" => $this->session->userdata("MsEmpId"),
            "SalesRequestUserCreate" => date("Y-m-d H:i:s"),
            "SalesRequestType" => "SALES REMOVE"
         )
      );

      $datanotif = array(
         "NotifHeader" => "Ada Approval Pembatalan Penjualan <i class='ps-1 fas fa-dolar-sign text-success'></i>",
         "NotifDesc" => "Ada pengajuan batalkan sales dari <b>" . $this->session->userdata("MsEmpName") . "</b> dengan No. Sales <b>" . $datasales->SalesCode . "</b> atas nama <b>" . $this->model_app->get_customer_name($datasales->MsCustomerId) . "</b>",
         "NotifType" => "APPROVE SALES",
         "NotifRef" => $datasales->SalesCode,
         "NotifRefDate" => $datasales->SalesCode,
         "MsWorkplaceId" => $datasales->MsWorkplaceId,
      );
      $this->model_app->insert_notif_approve_superuser($datanotif);
      echo true;
   }

   public function data_sales_payment_add()
   {
      $this->db->insert(
         'TblSalesLog',
         array(
            "SalesLogRef" => $this->input->post("PaymentRef"),
            "SalesLogDesc" => "<b>Pembayaran</b> telah <span style='color:green'>dibuat</span> oleh <b>" . $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
               . "</b> sebesar <b>Rp. " . number_format($this->input->post("PaymentTotal")) . "</b> dengan tipe pembayaran <b>" .
               $this->model_app->get_single_data("MsMethodName", "TblMsMethod", array("MsMethodId" => $this->input->post("MsMethodId"))) . "</b>"
         )
      ); 
      $status = true;
      $paymentdetail = array(
         "PaymentCardName" => $this->input->post("PaymentCardName"),
         "PaymentRef" => $this->input->post("PaymentRef"),
         "PaymentRef2" => $this->input->post("PaymentRef2"),
         "PaymentDate" => $this->input->post("PaymentDate"),
         "PaymentImage" => $this->input->post("PaymentImage"),
         "PaymentTotal" => $this->input->post("PaymentTotal"),
         "MsMethodId" => $this->input->post("MsMethodId"),
         "PaymentType" => $this->input->post("PaymentType"),
         "PaymentApprove" => ($this->input->post("MsMethodId") == 3 ? "0" : "1"),
         "PaymentLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName"),
      );
      $this->db->insert('TblSalesPayment', $paymentdetail);
      if ($status && ($this->db->affected_rows() != 1)) $status = false;


      // UPDATE STOCK
      //$this->m_inventory->insert_trans_from_sales($this->input->post("PaymentRef"));

      $id = $this->db->select_max('PaymentId')->get('TblSalesPayment')->row()->PaymentId;
      $result = $this->db->where("SalesCode", $this->input->post("PaymentRef"))->get("TblSales")->row();
      $arr_finance = array(
         "FinancialDate" => $this->input->post("PaymentDate"),
         "FinancialDescription" => "(auto) Dana Masuk Dari Customer " . $this->model_app->get_customer_name($result->MsCustomerId)  . " Sales no. " . $result->SalesCode,
         "FinancialTotal" => $this->input->post("PaymentTotal"),
         "MsWorkplaceId" => $result->MsWorkplaceId,
         "IsDelete" => "0",
         "FinancialRef" => $result->SalesCode,
         "FinancialRef2" => $id
      );
      if ($this->input->post("MsMethodId") == 1) {
         $arr = $arr_finance;
         $arr +=  array("FinancialCategory" => '28',  "FinancialType" => '1');
         $this->db->insert("TblFinancial", $arr);
      } elseif ($this->input->post("MsMethodId") == 2) {
         $arr = $arr_finance;
         $arr +=  array("FinancialCategory" => '30',  "FinancialType" => '1');
         $this->db->insert("TblFinancial", $arr);

         $arr = $arr_finance;
         $arr +=  array("FinancialCategory" => '31',  "FinancialType" => '0');
         $this->db->insert("TblFinancial", $arr);
      } else {

         $datanotif = array(
            "NotifHeader" => "Ada Approval Pembayaran <i class='ps-1 fas fa-dolar-sign text-success'></i>",
            "NotifDesc" => "Ada pembayaran yang dibuat oleh <b>" . $this->session->userdata("MsEmpName") . "</b> dengan No. Sales <b>" . $datasales->SalesCode . "</b> atas nama <b>" . $this->input->post("PaymentCardName") . "</b>" . " sebesar <b>Rp. " . number_format($this->input->post("PaymentTotal")) . "</b> dengan tipe pembayaran <b>" .
               $this->model_app->get_single_data("MsMethodName", "TblMsMethod", array("MsMethodId" => $this->input->post("MsMethodId"))) . "</b>",
            "NotifType" => "APPROVE",
            "NotifRef" => $datasales->SalesCode,
            "NotifRefDate" => $this->input->post("PaymentDate"),
            "MsWorkplaceId" => $datasales->MsWorkplaceId,
         );
         $this->model_app->insert_notif_approve($datanotif);
      }

      // CHANGE STATUS SALES
      $data = $this->db
         ->query("Select sum(PaymentTotal) as total from TblSalesPayment Where PaymentRef='" . $this->input->post("PaymentRef") . "'")
         ->row();
      $datasales = $this->db
         ->query("Select * from TblSales Where SalesCode='" . $this->input->post("PaymentRef") . "'")
         ->row();
      if ($datasales->SalesGrandTotal > $data->total) {
         $this->db->update('TblSales', array('SalesStatusPayment' => 1), array('SalesCode' => $this->input->post("PaymentRef")));
      } else {
         $this->db->update('TblSales', array('SalesStatusPayment' => 2), array('SalesCode' => $this->input->post("PaymentRef")));
      }

      // MOVE FILE PAYMENT
      if ($this->input->post("PaymentImage") != "") {
         $data = $this->db
            ->query("Select SalesId from TblSales Where SalesCode='" . $this->input->post("PaymentRef") . "'")
            ->row();
         $this->model_app->move_file($this->input->post("PaymentImage"), $data->SalesId);
      }

      // Update Date Sales
      $sales = $this->db->query('SELECT SalesCode,SalesDate, mindate from TblSales 
         left JOIN (SELECT PaymentRef,min(PaymentDate) AS mindate FROM TblSalesPayment GROUP BY PaymentRef) AS a ON SalesCode=a.PaymentRef
         WHERE SalesCode = "' . $this->input->post("PaymentRef") . '"')->row();
      if ($sales->SalesDate != $sales->mindate) {
         $this->db->update("TblSales", array("SalesDate" => $sales->mindate), array("SalesCode" => $this->input->post("PaymentRef")));
         $this->db->insert(
            'TblSalesLog',
            array(
               "SalesLogRef" => $this->input->post("PaymentRef"),
               "SalesLogDesc" => "tanggal <b>Sales</b> telah <span style='color:green'>diubah</span> oleh <b>System</b> mengikuti pembayaran pertama yaitu <b>" . $sales->mindate . "</b>"
            )
         );
      }


      // ============================================== INSERT NOTIF
      $datanotif = array(
         "NotifHeader" => "Pembayaran Berhasil dibuat <i class='ps-1 text-success fas fa-check'></i>",
         "NotifDesc" => "Pembayaran dibuat oleh <b>" . $this->session->userdata("MsEmpName") . "</b> dengan No. Sales <b>" . $datasales->SalesCode . "</b> atas nama <b>" . $this->model_app->get_customer_name($datasales->MsCustomerId) . "</b>" . " sebesar <b>Rp. " . number_format($this->input->post("PaymentTotal")) . "</b> dengan tipe pembayaran <b>" .
            $this->model_app->get_single_data("MsMethodName", "TblMsMethod", array("MsMethodId" => $this->input->post("MsMethodId"))) . "</b>",
         "NotifType" => "SALES",
         "NotifRef" => $datasales->SalesCode,
         "NotifRefDate" => $datasales->SalesDate,
         "MsWorkplaceId" => $datasales->MsWorkplaceId,
      );
      $this->model_app->insert_notif($datanotif);

      echo $status;
      exit;
   }
   public function data_sales_payment_edit()
   {
      $dataold = $this->db->where("PaymentId", $this->input->post("PaymentId"))->get("TblSalesPayment")->row();
      $message = "";
      if ($dataold->PaymentCardName != $this->input->post("PaymentCardName")) {
         $message = "Nama dari <b>" . $dataold->PaymentCardName . "</b> menjadi <b>" . $this->input->post("PaymentCardName") . "</b> ";
      }
      if ($dataold->PaymentTotal != $this->input->post("PaymentTotal")) {
         $message = "total dari <b>" . $dataold->PaymentTotal . "</b> menjadi <b>" . $this->input->post("PaymentTotal") . "</b> ";
      }
      if ($dataold->MsMethodId != $this->input->post("MsMethodId")) {
         $metodnew = $this->model_app->get_single_data("MsMethodName", "TblMsMethod", array("MsMethodId" => $this->input->post("MsMethodId")));
         $metodold = $this->model_app->get_single_data("MsMethodName", "TblMsMethod", array("MsMethodId" => $dataold->MsMethodId));
         $message = "metode bayar dari <b>" . $metodold . "</b> menjadi <b>" . $metodnew . "</b> ";
      }
      if ($dataold->PaymentDate != $this->input->post("PaymentDate")) {
         $message = "tanggal dari <b>" . $dataold->PaymentDate . "</b> menjadi <b>" . $this->input->post("PaymentDate") . "</b> ";
      }
      $this->db->insert(
         'TblSalesLog',
         array(
            "SalesLogRef" => $this->input->post("PaymentRef"),
            "SalesLogDesc" => "<b>Pembayaran</b> telah <span style='color:orange'>diubah</span> oleh <b>" . $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
               . "</b> dengan perubahan " .  $message
         )
      );

      $total = $this->model_app->get_single_data("SalesGrandTotal", "TblSales", array("SalesCode" => $this->input->post("PaymentRef")));
      $sisa = $total - $this->input->post("PaymentTotal");
      $data = $this->db
         ->query("Select count(PaymentTotal) as total from TblSalesPayment Where PaymentRef='" . $this->input->post("PaymentRef") . "' and not PaymentId='" . $this->input->post("PaymentId") . "'")
         ->row();
    
      $status = true;
      $paymentdetail = array(
         "PaymentCardName" => $this->input->post("PaymentCardName"), 
         "PaymentDate" => $this->input->post("PaymentDate"),
         "PaymentImage" => $this->input->post("PaymentImage"),
         "PaymentTotal" => $this->input->post("PaymentTotal"),
         "MsMethodId" => $this->input->post("MsMethodId"),
         "PaymentApprove" => ($this->input->post("MsMethodId") == 3 ? "0" : "1"),
         "PaymentType" => $this->input->post("PaymentType"),
         "PaymentLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName"),
      );

      $this->db->update('TblSalesPayment', $paymentdetail, array('PaymentId' => $this->input->post("PaymentId")));
      if ($status && ($this->db->affected_rows() != 1)) $status = false;

      $this->db->delete("TblFinancial", array("FinancialRef2" => $this->input->post("PaymentId"), "FinancialRef" => $this->input->post("PaymentRef")));
      $result = $this->db->where("SalesCode", $this->input->post("PaymentRef"))->get("TblSales")->row();
      $arr_finance = array(
         "FinancialDate" => $this->input->post("PaymentDate"),
         "FinancialDescription" => "(auto) Dana Masuk Dari Customer " . $this->model_app->get_customer_name($result->MsCustomerId)  . " Sales no. " . $result->SalesCode,
         "FinancialTotal" => $this->input->post("PaymentTotal"),
         "MsWorkplaceId" => $result->MsWorkplaceId,
         "IsDelete" => "0",
         "FinancialRef" => $result->SalesCode,
         "FinancialRef2" =>  $this->input->post("PaymentId")
      );
      if ($this->input->post("MsMethodId") == 1) {
         $arr = $arr_finance;
         $arr +=  array("FinancialCategory" => '28',  "FinancialType" => '1');
         $this->db->insert("TblFinancial", $arr);
      } elseif ($this->input->post("MsMethodId") == 2) {
         $arr = $arr_finance;
         $arr +=  array("FinancialCategory" => '30',  "FinancialType" => '1');
         $this->db->insert("TblFinancial", $arr);

         $arr = $arr_finance;
         $arr +=  array("FinancialCategory" => '31',  "FinancialType" => '0');
         $this->db->insert("TblFinancial", $arr);
      }

      // CHANGE STATUS SALES
      $data = $this->db
         ->query("Select sum(PaymentTotal) as total from TblSalesPayment Where PaymentRef='" . $this->input->post("PaymentRef") . "'")
         ->row();
      if ($total > $data->total) {
         $this->db->update('TblSales', array('SalesStatusPayment' => 1), array('SalesCode' => $this->input->post("PaymentRef")));
      } else {
         $this->db->update('TblSales', array('SalesStatusPayment' => 2), array('SalesCode' => $this->input->post("PaymentRef")));
      }


      // MOVE FILE PAYMENT

      //echo $this->input->post("paymentImageOld") . '/' . $this->input->post("id");
      $this->model_app->remove_old_file($this->input->post("PaymentImageOld"), $this->input->post("id"));
      if ($this->input->post("PaymentImage") != "") {
         $this->model_app->move_file($this->input->post("PaymentImage"), $this->input->post("id"));
      }
      //Update Date Sales
      $sales = $this->db->query('SELECT SalesCode,SalesDate, mindate from TblSales 
         left JOIN (SELECT PaymentRef,min(PaymentDate) AS mindate FROM TblSalesPayment GROUP BY PaymentRef) AS a ON SalesCode=a.PaymentRef
         WHERE SalesCode = "' . $this->input->post("PaymentRef") . '"')->row();
      if ($sales->SalesDate != $sales->mindate) {
         $this->db->update("TblSales", array("SalesDate" => $sales->mindate), array("SalesCode" => $this->input->post("PaymentRef")));
         $this->db->insert(
            'TblSalesLog',
            array(
               "SalesLogRef" => $this->input->post("PaymentRef"),
               "SalesLogDesc" => "tanggal <b>Sales</b> telah <span style='color:green'>diubah</span> oleh <b>System</b> mengikuti pembayaran pertama yaitu <b>" . $sales->mindate . "</b>"
            )
         );
      }

      echo $status;
      exit;
   }
   public function data_payment_disabled($id)
   {
      $status = true;
      $salesCode = $this->model_app->get_single_data("PaymentRef", "TblSalesPayment", array("PaymentId" => $id));
      $image = $this->model_app->get_single_data("PaymentImage", "TblSalesPayment", array("PaymentId" => $id));
      $salesid = $this->model_app->get_single_data("SalesId", "TblSales", array("SalesCode" => $salesCode));

      $dataold = $this->db->where("PaymentId", $id)->get("TblSalesPayment")->row();
      $this->db->insert(
         'TblSalesLog',
         array(
            "SalesLogRef" => $salesCode,
            "SalesLogDesc" => "<b>Pembayaran</b> atas nama <b>" . $dataold->PaymentCardName . "</b> dengan total <b>Rp. " .  number_format($dataold->PaymentTotal) .
               "</b> <span style='color:red'>dihapus</span> oleh <b>" . $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName") . "</b>"
         )
      );
      $this->model_app->remove_old_file($image, $salesid);
      $this->db->delete("TblFinancial", array("FinancialRef2" => $id, "FinancialRef" => $this->model_app->get_single_data("PaymentRef", "TblSalesPayment", array('PaymentId' =>  $id))));
      $this->db->delete('TblSalesPayment', array('PaymentId' =>  $id));
      $status = ($this->db->affected_rows() != 1) ? false : true;

      $total = $this->model_app->get_single_data("SalesGrandTotal", "TblSales", array("SalesCode" => $salesCode));
      $data = $this->db
         ->query("Select ifnull(sum(PaymentTotal),0) as total from TblSalesPayment Where PaymentRef='" . $salesCode . "'")
         ->row();
      $sisa = $total - $data->total;
      if ($sisa > 0) {
         $this->db->update('TblSales', array('SalesStatusPayment' => 0), array('SalesCode' => $salesCode));
      } else {
         $this->db->update('TblSales', array('SalesStatusPayment' => 1), array('SalesCode' => $salesCode));
      }
      echo $status;
      exit;
   }

   public function get_delivery_code($id)
   {
      echo $this->model_app->get_single_data("DeliveryCode", "TblDelivery", array("DeliveryId" => $id));
      exit;
   }
   public function data_delivery_add()
   {
      $status = true;
      $sales = $this->input->post("data");
      $sales += ["DeliveryLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $sales += ["DeliveryCreateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->insert('TblDelivery', $sales);
      if ($status && ($this->db->affected_rows() != 1)) $status = false;
      $itemstring = "";
      if (null !== $this->input->post("item")) {
         $dataitem = $this->input->post("item");
         foreach ($dataitem as $row) {
            $this->db->insert('TblDeliveryDetail', $row);
            if ($status && ($this->db->affected_rows() != 1)) $status = false;
            $itemmaster = $this->db->where("MsItemId", $row["MsItemId"])->get("TblMsItem")->row();
            $itemstring .= " | " . $itemmaster->MsItemCode . " - " . $itemmaster->MsItemName . " (" . $row["MsVendorCode"] . ") " . $row["DeliveryDetailQty"] . " " . $itemmaster->MsItemUoM;
         }
      }
      $totalsales = $this->db->query('SELECT SUM(SalesDetailQty) as total FROM TblSalesDetail WHERE SalesDetailRef="' . $sales["DeliveryRef"] . '"')->row();
      $totaldelivery = $this->db->query('SELECT SUM(DeliveryDetailQty) as total FROM TblDeliveryDetail left join TblDelivery on DeliveryDetailRef = DeliveryCode WHERE DeliveryRef="' . $sales["DeliveryRef"] . '"')->row();
      if ($totalsales->total <= $totaldelivery->total) {
         $this->db->update('TblSales', array('SalesStatusDelivery' => 1), array('SalesCode' => $sales["DeliveryRef"]));
      } else {
         $this->db->update('TblSales', array('SalesStatusDelivery' => 0), array('SalesCode' => $sales["DeliveryRef"]));
      }
      if ($status && ($this->db->affected_rows() != 1)) $status = false;
      echo $status;

      $this->db->insert(
         'TblSalesLog',
         array(
            "SalesLogRef" => $sales["DeliveryRef"],
            "SalesLogDesc" => "<b>Pengiriman</b> telah <span style='color:green'>dibuat</span> oleh <b>" . $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName") . "</b> dengan item " . $itemstring
         )
      );
      exit;
   }
   public function data_delivery_edit($id)
   {
      $status = true;
      $sales = $this->input->post("data");
      $sales += ["DeliveryLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->update('TblDelivery', $sales, array("DeliveryId" => $id));
      if ($status && ($this->db->affected_rows() != 1)) $status = false;

      $itemstring = "";
      $code = $this->model_app->get_single_data("DeliveryCode", "TblDelivery", array("DeliveryId" => $id));
      $ref = $this->model_app->get_single_data("DeliveryRef", "TblDelivery", array("DeliveryId" => $id));
      if (null !== $this->input->post("item")) {
         $datanew = $this->input->post("item");
         $this->db->delete('TblDeliveryDetail', array('DeliveryDetailRef' =>  $code));
         foreach ($datanew as $row) {
            $this->db->insert('TblDeliveryDetail', $row);
            if ($status && ($this->db->affected_rows() != 1)) $status = false;
            $itemmaster = $this->db->where("MsItemId", $row["MsItemId"])->get("TblMsItem")->row();
            $itemstring .= " | " . $itemmaster->MsItemCode . " - " . $itemmaster->MsItemName . " (" . $row["MsVendorCode"] . ") " . $row["DeliveryDetailQty"] . " " . $itemmaster->MsItemUoM;
         }
      }


      $totalsales = $this->db->query('SELECT SUM(SalesDetailQty) as total FROM TblSalesDetail WHERE SalesDetailRef="' . $ref . '"')->row();
      $totaldelivery = $this->db->query('SELECT SUM(DeliveryDetailQty) as total FROM TblDeliveryDetail left join TblDelivery on DeliveryDetailRef = DeliveryCode WHERE DeliveryRef="' . $ref . '"')->row();
      echo $totalsales->total . "<br>";
      echo $totaldelivery->total . "<br>";
      if ($totalsales->total <= $totaldelivery->total) {
         $this->db->update('TblSales', array('SalesStatusDelivery' => 1), array('SalesCode' => $ref));
      } else {
         $this->db->update('TblSales', array('SalesStatusDelivery' => 0), array('SalesCode' => $ref));
      }
      if ($status && ($this->db->affected_rows() != 1)) $status = false;
      echo $status;
      $this->db->insert(
         'TblSalesLog',
         array(
            "SalesLogRef" => $ref,
            "SalesLogDesc" => "<b>Pengiriman</b> dengan No. Delivery <b>" . $code . "</b> telah <span style='color:orange'>diubah</span> oleh <b>" .
               $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName") . "</b> dengan item " . $itemstring
         )
      );
      exit;
   }
   public function data_delivery_remove($id)
   {
      $status = true;
      $code = $this->model_app->get_single_data("DeliveryCode", "TblDelivery", array("DeliveryId" => $id));
      $ref = $this->model_app->get_single_data("DeliveryRef", "TblDelivery", array("DeliveryId" => $id));

      $this->db->delete('TblDeliveryDetail', array('DeliveryDetailRef' =>  $code));
      $this->db->delete('TblDelivery', array('DeliveryCode' =>  $code));

      if ($status && ($this->db->affected_rows() != 1)) $status = false;

      $totalsales = $this->db->query('SELECT SUM(SalesDetailQty) as total FROM TblSalesDetail WHERE SalesDetailRef="' . $ref . '"')->row();
      $totaldelivery = $this->db->query('SELECT SUM(DeliveryDetailQty) as total FROM TblDeliveryDetail left join TblDelivery on DeliveryDetailRef = DeliveryCode WHERE DeliveryRef="' . $ref . '"')->row();
      echo $totalsales->total . "<br>";
      echo $totaldelivery->total . "<br>";
      if ($totalsales->total <= $totaldelivery->total) {
         $this->db->update('TblSales', array('SalesStatusDelivery' => 1), array('SalesCode' => $ref));
      } else {
         $this->db->update('TblSales', array('SalesStatusDelivery' => 0), array('SalesCode' => $ref));
      }
      if ($status && ($this->db->affected_rows() != 1)) $status = false;
      echo $status;

      $this->db->insert(
         'TblSalesLog',
         array(
            "SalesLogRef" => $ref,
            "SalesLogDesc" => "<b>Pengiriman</b> dengan No. Delivery <b>" . $code . "</b> telah <span style='color:red'>dihapus</span> oleh <b>" .
               $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName") . "</b>"
         )
      );
      exit;
   }

   
   public function data_delivery_proses($id)
   {
      $status = true;
      $sales = $this->input->post("data");
      $sales += ["DeliveryLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->update('TblDelivery', $sales, array("DeliveryId" => $id));
      if ($status && ($this->db->affected_rows() != 1)) $status = false;

      $itemstring = "";
      $code = $this->model_app->get_single_data("DeliveryCode", "TblDelivery", array("DeliveryId" => $id));
      $ref = $this->model_app->get_single_data("DeliveryRef", "TblDelivery", array("DeliveryId" => $id));
      if (null !== $this->input->post("item")) {
         $datanew = $this->input->post("item");
         $this->db->delete('TblDeliveryDetail', array('DeliveryDetailRef' =>  $code));
         foreach ($datanew as $row) {
            $this->db->insert('TblDeliveryDetail', $row);
            if ($status && ($this->db->affected_rows() != 1)) $status = false;
            $itemmaster = $this->db->where("MsItemId", $row["MsItemId"])->get("TblMsItem")->row();
            $itemstring .= " | " . $itemmaster->MsItemCode . " - " . $itemmaster->MsItemName . " (" . $row["MsVendorCode"] . ") " . $row["DeliveryDetailQty"] . " " . $itemmaster->MsItemUoM;
         }
      }


      $totalsales = $this->db->query('SELECT SUM(SalesDetailQty) as total FROM TblSalesDetail WHERE SalesDetailRef="' . $ref . '"')->row();
      $totaldelivery = $this->db->query('SELECT SUM(DeliveryDetailQty) as total FROM TblDeliveryDetail left join TblDelivery on DeliveryDetailRef = DeliveryCode WHERE DeliveryRef="' . $ref . '"')->row();
      echo $totalsales->total . "<br>";
      echo $totaldelivery->total . "<br>";
      if ($totalsales->total <= $totaldelivery->total) {
         $this->db->update('TblSales', array('SalesStatusDelivery' => 1), array('SalesCode' => $ref));
      } else {
         $this->db->update('TblSales', array('SalesStatusDelivery' => 0), array('SalesCode' => $ref));
      }
      if ($status && ($this->db->affected_rows() != 1)) $status = false;
      echo $status;
      $this->db->insert(
         'TblSalesLog',
         array(
            "SalesLogRef" => $ref,
            "SalesLogDesc" => "<b>Pengiriman</b> dengan No. Delivery <b>" . $code . "</b> telah <span style='color:blue'>diproses</span> oleh <b>" .
               $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName") . "</b> dengan item " . $itemstring
         )
      );
      exit;
   } 

   public function data_delivery_upload_pengantaran($id)
   {
      if (!file_exists('asset/image/pengiriman/')) {
         mkdir("asset/image/pengiriman", 0777);
      }
      if (!file_exists('asset/image/pengiriman/' . $id . '/')) {
         mkdir("asset/image/pengiriman/" . $id, 0777);
      }

      if (file_exists('asset/image/pengiriman/' . $id . '/tandatangan_pengiriman.png')) {
         unlink('asset/image/pengiriman/' . $id . '/tandatangan_pengiriman.png');
      }
      if (file_exists('asset/image/pengiriman/' . $id . '/bukti_pengiriman.png')) {
         unlink('asset/image/pengiriman/' . $id . '/bukti_pengiriman.png');
      }

      $file = $_POST['filetandatangan']; //your data in base64 'data:image/png....';
      $img = str_replace('data:image/png;base64,', '', $file);
      file_put_contents('asset/image/pengiriman/' . $id . '/tandatangan_pengiriman.png', base64_decode($img));

      $file = $_POST['filepengiriman']; //your data in base64 'data:image/png....';
      $img = str_replace('data:image/png;base64,', '', $file);
      file_put_contents('asset/image/pengiriman/' . $id . '/bukti_pengiriman.png', base64_decode($img));
   } 

   public function data_delivery_upload_penerima($id)
   {
      if (!file_exists('asset/image/pengiriman/')) {
         mkdir("asset/image/pengiriman", 0777);
      }
      if (!file_exists('asset/image/pengiriman/' . $id . '/')) {
         mkdir("asset/image/pengiriman/" . $id, 0777);
      }

      if (file_exists('asset/image/pengiriman/' . $id . '/tandatangan_penerima.png')) {
         unlink('asset/image/pengiriman/' . $id . '/tandatangan_penerima.png');
      }
      if (file_exists('asset/image/pengiriman/' . $id . '/bukti_penerima.png')) {
         unlink('asset/image/pengiriman/' . $id . '/bukti_penerima.png');
      }

      $file = $_POST['filetandatangan']; //your data in base64 'data:image/png....';
      $img = str_replace('data:image/png;base64,', '', $file);
      file_put_contents('asset/image/pengiriman/' . $id . '/tandatangan_penerima.png', base64_decode($img));

      $file = $_POST['filepengiriman']; //your data in base64 'data:image/png....';
      $img = str_replace('data:image/png;base64,', '', $file);
      file_put_contents('asset/image/pengiriman/' . $id . '/bukti_penerima.png', base64_decode($img));
   } 


   public function data_delivery_date($id)
   {
      $status = true;
      $sales = $this->input->post();
      $sales += ["DeliveryLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->update('TblDelivery', $sales, array("DeliveryId" => $id));
      if ($status && ($this->db->affected_rows() != 1)) $status = false;
      echo $status;

      $code = $this->model_app->get_single_data("DeliveryCode", "TblDelivery", array("DeliveryId" => $id));
      $ref = $this->model_app->get_single_data("DeliveryRef", "TblDelivery", array("DeliveryId" => $id));
      $this->db->insert(
         'TblSalesLog',
         array(
            "SalesLogRef" => $ref,
            "SalesLogDesc" => "<b>Pengiriman</b> dengan No. Delivery <b>" . $code . "</b> telah <span style='color:orange'>diubah</span> tanggal oleh <b>" .
               $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName") . "</b> menjadi " .  $this->input->post("DeliveryDate")
         )
      );
      exit;
   }
   public function get_list_delivery($date)
   {
      
      $query = $this->db->join("TblSales", "TblSales.SalesCode=TblDelivery.DeliveryRef", "left")
         ->join("TblMsCustomerDelivery", "TblMsCustomerDelivery.MsCustomerDeliveryId=TblDelivery.MsCustomerDeliveryId", "left")
         ->join("TblMsDelivery", "TblDelivery.MsDeliveryId = TblMsDelivery.MsDeliveryId", "left")
         ->where("DeliveryDate", $date)->where("TblDelivery.MsDeliveryId", 1)->get("TblDelivery")->result();
      $delivery = '';
      foreach ($query as $row) { 
         $query1 = $this->db->join("TblMsProduk","TblMsProduk.MsProdukId=TblDeliveryDetail.MsProdukId") 
         ->join("TblMsSatuan","TblMsSatuan.SatuanId=TblDeliveryDetail.SatuanId")->where("DeliveryDetailRef",$row->DeliveryCode)->get("TblDeliveryDetail")->result();
         $detaildelivery = "";
         foreach ($query1 as $row1) {
            $detaildelivery .= '    <div class="row align-items-center border-light border-bottom border-top me-1 py-1">
                                                                  <div class="col-6">
                                                                        <span class="text-dark fw-bold" style="font-size:0.7rem!important;">' . $row1->MsProdukCode . '-' . $row1->MsProdukName . '</span><br>
                                                                        <span class="text-secondary" style="font-size:0.75rem"><span class="text-dark fw-bold" style="font-size:0.7rem!important;">' . $row1->DeliveryDetailVarian . '</span></span>
                                                                  </div> 
                                                                  <div class="col-3 text-right">
                                                                        <span class="text-secondary" style="font-size:0.75rem">Qty</span><br>
                                                                        <span class="text-dark fw-bold" style="font-size:0.7rem!important;">' . $row1->DeliveryDetailQty . ' ' . $row1->SatuanName . '</span>
                                                                  </div>
                                                                  <div class="col-3 text-right">
                                                                        <span class="text-secondary" style="font-size:0.75rem">Spare</span><br>
                                                                        <span class="text-dark fw-bold" style="font-size:0.7rem!important;">' . $row1->DeliveryDetailSpareQty . ' ' . $row1->SatuanName . '</span>
                                                                  </div>
                                                            </div>';
         }
         if ($row->DeliveryStatus == 0) {
            $valueprogress = 30;
            $button = ' <div class="col-md-12 d-flex">
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_edit(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-pencil-alt"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Edit
                                                            </span>
                                                      </button>
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_print(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-print"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Print
                                                            </span>
                                                      </button>
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_delete(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-times"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Hapus
                                                            </span>
                                                      </button>
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1 ms-auto" onclick="delivery_proses(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem"> 
                                                            <i class="fas fa-share-square"></i>
                                                            <span class="fw-bold">
                                                            &nbsp;Proses
                                                            </span>
                                                      </button>
                                                </div>';
         } else if ($row->DeliveryStatus == 1) {
            $valueprogress = 65;
            $button = ' <div class="col-md-12 d-flex">
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_edit(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-pencil-alt"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Edit
                                                            </span>
                                                      </button>
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_print(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-print"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Print
                                                            </span>
                                                      </button>
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_delete(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-times"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Hapus
                                                            </span>
                                                      </button>
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1 ms-auto" onclick="delivery_selesai(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-share-square"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Selesaikan
                                                            </span>
                                                      </button>
                                                </div>';
         } else if ($row->DeliveryStatus == 2) {
            $valueprogress = 100;
            $button = ' <div class="col-md-12 d-flex"> 
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_print(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-print"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Print
                                                            </span>
                                                      </button>  
                                                </div>';
         }
         $delivery .= '<div class="mx-2 p-2" style="border-bottom: 1px dashed #ff7900;text-align:left;">
                                          <div class="row py-1 g-1">
                                                <div class="col-lg-3 col-md-6 col-12">
                                                      <span class="text-secondary label-span" style="font-size:0.7rem!important">No. Delivery</span><span class="text-dark fw-bold" style="font-size:0.7rem!important;">' . $row->DeliveryCode . '</span><br>
                                                      <span class="text-secondary label-span" style="font-size:0.7rem!important">Rit</span><span class="text-dark fw-bold" style="font-size:0.7rem!important;">' . $row->DeliveryRit . '</span><br>
                                                      <span class="text-secondary label-span" style="font-size:0.7rem!important">Tgl. kirim</span><span class="text-dark fw-bold" style="font-size:0.7rem!important;">' . date_format(date_create($row->DeliveryDate), "d F Y") . '</span><br>
                                                      <span class="text-secondary label-span" style="font-size:0.7rem!important">Penerima</span><span class="text-dark fw-bold" style="font-size:0.7rem!important;">' . $row->MsCustomerDeliveryReceive . ' </span><span class="text-dark fw-bold" style="font-size:0.7rem!important;">(' . $row->MsCustomerDeliveryTelp . ')</span>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-12">
                                                      <span class="text-secondary label-span" style="font-size:0.7rem!important">Armada</span><span class="text-dark fw-bold" style="font-size:0.7rem!important;">' . $row->MsDeliveryName . '</span><br>
                                                      <div class="list-progress" style="">
                                                            <span class="fa-stack text-secondary ' . ($row->DeliveryStatus >= 0 ? "success" : "") . '" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="dijadwalkan">
                                                                  <i class="fas fa-circle fa-stack-2x" ></i>
                                                                  <i class="fas fa-calendar-alt fa-stack-1x"></i>
                                                            </span>
                                                            <span class="fa-stack text-secondary ' . ($row->DeliveryStatus >= 1 ? "success" : "") . '" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="dikirim">
                                                                  <i class="fas fa-circle fa-stack-2x" ></i>
                                                                  <i class="fas fa-shipping-fast fa-stack-1x" ></i>
                                                            </span>
                                                            <span class="fa-stack text-secondary ' . ($row->DeliveryStatus >= 2 ? "success" : "") . '" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="diterima">
                                                                  <i class="fas fa-circle fa-stack-2x"></i>
                                                                  <i class="fas fa-people-carry fa-stack-1x"></i>
                                                            </span>
                                                            <div class="progress">
                                                                  <div class="progress-bar bg-success" role="progressbar" style="width: ' . $valueprogress . '%" aria-valuenow="' . $valueprogress . '" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                      </div>
                                                </div>
                                                <div class="col-lg-5 ps-lg-2 col-12">
                                                      <span class="text-secondary" style="font-size:0.75rem">Alamat</span><br><span class="text-dark fw-bold" style="font-size:0.7rem!important;">' . $row->MsCustomerDeliveryAddress . '</span><br>
                                                      <span class="text-secondary" style="font-size:0.75rem">Titik Map</span><br>
                                                      <div class="bg-pinpoint">
                                                            <i class="fas fa-map-marker-alt fa-2x"></i>
                                                            <span class="label-small px-1">' . $row->MsCustomerDeliveryName . '</span>
                                                            <a class="btn btn-light py-1 ms-auto btn-sm" href="https://maps.google.com/?q=' . $row->MsCustomerDeliveryLat . ',' . $row->MsCustomerDeliveryLng . '" target="_blank" style="min-width: 5rem;">Lihat Map</a>
                                                      </div>
                                                </div>
                                                <div class="col-md-12 d-flex flex-column " style="border: 1px solid #d2cac0;border-radius: 0.25rem;">
                                                      ' . $detaildelivery . '
                                                </div> 
                                          </div>
                                          </div>  ';
      }

      echo json_encode(array(
         "data" => $query,
         "html" => $delivery
      ));
      exit;
   }

   public function get_data_delivery($id)
   {
      $date = ($this->db->select("DeliveryDate")->where("DeliveryId", $id)->get("TblDelivery")->row())->DeliveryDate;
      $html = '<h4 class="fw-bold">Ganti Tanggal</h4>
               <div class="row mb-1 align-items-center text-start" >      
                  <label for="DeliveryoldDate" class="col-sm-5 col-form-label">Tanggal Sebelumnya</label>      
                  <div class = "col-sm-7" >         
                     <input id = "DeliveryoldDate" name = "DeliveryDate" type = "text"  class = "form-control form-control-sm" value = "' . date_format(date_create($date), "d-m-Y") . '" disabled>       
                  </div>   
               </div>
               <div class="row mb-1 align-items-center text-start" >      
                  <label for="DeliverynewDate" class="col-sm-5 col-form-label">Tanggal Sebelumnya</label>      
                  <div class = "col-sm-7" >         
                     <input id = "DeliverynewDate" name = "DeliverynewDate" type = "text"  class = "form-control form-control-sm" value = "">       
                  </div>   
               </div>
               <script> 
                  var datenew = moment("' . $date . '");
                  $("#DeliverynewDate").daterangepicker({
                     singleDatePicker: true,
                     startDate: datenew,
                     showDropdowns: true,
                     locale: {
                        "format": "DD/MM/YYYY",
                        "customRangeLabel": "Pilih Tanggal Sendiri",
                     }
                  }, function(start, end) {
                     datenew = start; 
                  });
               </script>';

      echo json_encode($html);
      exit;
   }
   public function data_po_add()
   {
      $status = true;
      $sales = $this->input->post("data");
      $sales += ["POLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $sales += ["POCreateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->insert('TblPO', $sales);
      if ($status && ($this->db->affected_rows() != 1)) $status = false;

      $itemstring = "";
      if (null !== $this->input->post("item")) {
         $dataitem = $this->input->post("item");
         foreach ($dataitem as $row) {
            $this->db->insert('TblPODetail', $row);
            if ($status && ($this->db->affected_rows() != 1)) $status = false;
            $itemmaster = $this->db->where("MsItemId", $row["MsItemId"])->get("TblMsItem")->row();
            $itemstring .= " | " . $itemmaster->MsItemCode . " - " . $itemmaster->MsItemName . " " .   $row["PODetailQty"]  . " " . $itemmaster->MsItemUoM;
         }
      }

      /* --------------   CEK STATUS ----------------- */
      $data_sales = $this->db
         ->join("TblMsVendor", "TblMsVendor.MsVendorCode = TblSalesDetail.MsVendorCode")
         ->where("SalesDetailRef", $sales["SalesRef"])
         ->get("TblSalesDetail")->result();
      $statuspo = true;
      foreach ($data_sales as $row) {
         $totalPO = $this->db
            ->select("SUM(PODetailQty) as total")
            ->join("TblPO", "PODetailRef = POCode")
            ->where("SalesRef", $row->SalesDetailRef)
            ->where("MsItemId", $row->MsItemId)
            ->where("MsVendorId", $row->MsVendorId)
            ->get("TblPODetail")->row();

         if ($row->SalesDetailQty <= $totalPO->total) {
            $this->db->update('TblSalesDetail', array('SalesDetailPO' => 1), array('SalesDetailRef' => $row->SalesDetailRef, 'MsItemId' => $row->MsItemId, 'MsVendorCode' => $row->MsVendorCode));
            echo $row->MsItemId . " - " . $row->MsVendorCode;
            echo "STATUS : 1<br>";
         } else {
            $this->db->update('TblSalesDetail', array('SalesDetailPO' => 0), array('SalesDetailRef' => $row->SalesDetailRef, 'MsItemId' => $row->MsItemId, 'MsVendorCode' => $row->MsVendorCode));
            $statuspo = false;
            echo $row->MsItemId . " - " . $row->MsVendorCode;
            echo "STATUS : 0<br>";
         }
      }
      if ($statuspo == true) $this->db->update('TblSales', array('SalesStatusPO' => 1), array('SalesCode' => $sales["SalesRef"]));
      if ($status && ($this->db->affected_rows() != 1)) $status = false;
      echo $status;

      $this->db->insert(
         'TblSalesLog',
         array(
            "SalesLogRef" => $sales["SalesRef"],
            "SalesLogDesc" => "<b>PO</b> telah <span style='color:green'>dibuat</span> oleh <b>" . $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName") . "</b> dengan item " . $itemstring
         )
      );
      exit;
   }
   public function data_po_edit($id)
   {
      $status = true;
      $sales = $this->input->post("data");
      $sales += ["POLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->update('TblPO', $sales, array("POId" => $id));
      if ($status && ($this->db->affected_rows() != 1)) $status = false;

      $itemstring = "";
      $code = $this->model_app->get_single_data("POCode", "TblPO", array("POId" => $id));
      $ref = $this->model_app->get_single_data("SalesRef", "TblPO", array("POId" => $id));
      if (null !== $this->input->post("item")) {
         $this->db->delete('TblPODetail', array('PODetailRef' =>  $code));
         $dataitem = $this->input->post("item");
         foreach ($dataitem as $row) {
            $this->db->insert('TblPODetail', $row);
            if ($status && ($this->db->affected_rows() != 1)) $status = false;
            $itemmaster = $this->db->where("MsItemId", $row["MsItemId"])->get("TblMsItem")->row();
            $itemstring .= " | " . $itemmaster->MsItemCode . " - " . $itemmaster->MsItemName . " (" . $row["MsVendorCode"] . ") " . $row["DeliveryDetailQty"] . " " . $itemmaster->MsItemUoM;
         }
      }

      /* --------------   CEK STATUS ----------------- */
      $data_sales = $this->db
         ->join("TblMsVendor", "TblMsVendor.MsVendorCode = TblSalesDetail.MsVendorCode")
         ->where("SalesDetailRef", $ref)
         ->get("TblSalesDetail")->result();
      $statuspo = true;
      foreach ($data_sales as $row) {
         $totalPO = $this->db
            ->select("SUM(PODetailQty) as total")
            ->join("TblPO", "PODetailRef = POCode")
            ->where("SalesRef", $row->SalesDetailRef)
            ->where("MsItemId", $row->MsItemId)
            ->where("MsVendorId", $row->MsVendorId)
            ->get("TblPODetail")->row();

         if ($row->SalesDetailQty <= $totalPO->total) {
            $this->db->update('TblSalesDetail', array('SalesDetailPO' => 1), array('SalesDetailRef' => $row->SalesDetailRef, 'MsItemId' => $row->MsItemId, 'MsVendorCode' => $row->MsVendorCode));
            echo $row->MsItemId . " - " . $row->MsVendorCode;
            echo "STATUS : 1<br>";
         } else {
            $this->db->update('TblSalesDetail', array('SalesDetailPO' => 0), array('SalesDetailRef' => $row->SalesDetailRef, 'MsItemId' => $row->MsItemId, 'MsVendorCode' => $row->MsVendorCode));
            $statuspo = false;
            echo $row->MsItemId . " - " . $row->MsVendorCode;
            echo "STATUS : 0<br>";
         }
      }
      if ($statuspo == true) {
         $this->db->update('TblSales', array('SalesStatusPO' => 1), array('SalesCode' => $ref));
      } else {
         $this->db->update('TblSales', array('SalesStatusPO' => 0), array('SalesCode' => $ref));
      }
      if ($status && ($this->db->affected_rows() != 1)) $status = false;
      echo $status;
      $this->db->insert(
         'TblSalesLog',
         array(
            "SalesLogRef" => $ref,
            "SalesLogDesc" => "<b>PO</b> dengan No. PO <b>" . $code . "</b> telah <span style='color:orange'>diubah</span> oleh <b>" .
               $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName") . "</b> dengan item " . $itemstring
         )
      );
      exit;
   }
   public function get_po_code($id)
   {
      echo $this->model_app->get_single_data("POCode", "TblPO", array("POId" => $id));
      exit;
   }
   public function data_po_remove($id)
   {
      $status = true;
      $code = $this->model_app->get_single_data("POCode", "TblPO", array("POId" => $id));
      $ref = $this->model_app->get_single_data("SalesRef", "TblPO", array("POId" => $id));
      $vendorid = $this->model_app->get_single_data("MsVendorId", "TblPO", array("POId" => $id));
      $vendor = $this->model_app->get_single_data("MsVendorCode", "TblMsVendor", array("MsVendorId" => $vendorid));
      $itemid = $this->model_app->get_single_data("MsItemId", "TblPODetail", array("PODetailRef" => $code));

      $this->db->delete('TblPODetail', array('PODetailRef' =>  $code));
      $this->db->delete('TblPO', array('POCode' =>  $code));
      $this->db->update('TblSalesDetail', array('SalesDetailPO' => 0), array('SalesDetailRef' => $ref, 'MsItemId' => $itemid, 'MsVendorCode' => $vendor));

      if ($status && ($this->db->affected_rows() != 1)) $status = false;

      $totalsales = $this->db->query('SELECT SUM(SalesDetailQty) as total FROM TblSalesDetail WHERE SalesDetailRef="' . $ref . '" and SalesDetailType=0')->row();
      $totaldelivery = $this->db->query('SELECT SUM(PODetailQty) as total FROM TblPODetail left join TblPO on PODetailRef = POCode WHERE SalesRef="' . $ref . '"')->row();
      echo $totalsales->total . "<br>";
      echo $totaldelivery->total . "<br>";
      if ($totalsales->total <= $totaldelivery->total) {
         $this->db->update('TblSales', array('SalesStatusPO' => 1), array('SalesCode' => $ref));
      } else {
         $this->db->update('TblSales', array('SalesStatusPO' => 0), array('SalesCode' => $ref));
      }
      if ($status && ($this->db->affected_rows() != 1)) $status = false;
      echo $status;
      $this->db->insert(
         'TblSalesLog',
         array(
            "SalesLogRef" => $ref,
            "SalesLogDesc" => "<b>PO</b> dengan No. PO <b>" . $code . "</b> telah <span style='color:red'>dihapus</span> oleh <b>" .
               $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName") . "</b>"
         )
      );
      exit;
   }
   public function data_po_selesai($id)
   {
      $this->db->update('TblPO', array("POStatus" => 2), array("POId" => $id));
      echo ($this->db->affected_rows() != 1 ? true : false);
      exit;
   }
   public function update_po($code)
   {
      $datasales = $this->db->join("TblSalesDetail", "TblSales.SalesCode=TblSalesDetail.SalesDetailRef")->where("SalesCode", $code)->where("SalesDetailType", 0)->get("TblSales")->result();
      $datasales = $this->db->join("TblPO", "TblPO.POCode=TblPODetail.PODetailRef")->where("PORef", $code)->get("TblPODetail")->result();
      $status = 0;
      foreach ($datasales as $row) {
         $total_delivery = 0;
         foreach ($datasales as $rows) {
            if ($row->MsItemId == $rows->MsItemId && $row->MsVendorCode == $rows->MsVendorCode) {
               $total_delivery +=  $rows->DeliveryDetailQty;
            }
         }
         if ($row->SalesDetailQty > $total_delivery) $status = 1;
      }
      if ($status == 1) {
         $this->db->update("TblSales", array("SalesStatusPO" => 0), array("SalesCode" => $code));
         return;
      } /* *Status 1 jika pengiriman terpenuhi tetapi masih ada prngiriman yang belum selesai*/
      $delivery = $this->db->where_in("POStatus", array("0", "1"))->where("PORef", $code)->get("TblDelivery");
      if ($delivery->num_rows() > 0) {
         $this->db->update("TblSales", array("SalesStatusPO" => 1), array("SalesCode" => $code));
         return;
      } else {
         $this->db->update("TblSales", array("SalesStatusPO" => 2), array("SalesCode" => $code));
         return;
      }
   }

   public function data_grpo_add()
   {
      $status = true;
      $sales = $this->input->post("data");
      $sales += ["GRPOLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $sales += ["GRPOCreateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->insert('TblGRPO', $sales);
      if ($status && ($this->db->affected_rows() != 1)) $status = false; 
      $this->db->update('TblDelivery', array('DeliveryStatus' => 3), array('DeliveryCode' => $sales["GRPORef2"]));
      $itemstring = "";
      if (null !== $this->input->post("item")) {
         $dataitem = $this->input->post("item");
         foreach ($dataitem as $row) {
            $this->db->insert('TblGRPODetail', $row);
            if ($status && ($this->db->affected_rows() != 1)) $status = false;
            $itemmaster = $this->db->where("MsProdukId", $row["MsProdukId"])->get("TblMsProduk")->row();
            $itemstring .= " | " . $itemmaster->MsProdukCode . " - " . $itemmaster->MsProdukName . " " .   $row["GRPODetailQty"];
         }
      }


      /* --------------   CEK STATUS ----------------- */
      $data_grpo = $this->db->join("TblGRPODetail", "GRPODetailRef=GRPOCode", "left")->where("GRPORef", $sales["GRPORef"])->get("TblGRPO")->result();
      $data_po = $this->db->join("TblPODetail", "PODetailRef=POCode", "left")->where("POCode", $sales["GRPORef"])->get("TblPO")->result();
      $QtyPO = 0;
      $Qty = 0;
      foreach ($data_po as $row) {
         $QtyPO += $row->PODetailQty;
         foreach ($data_grpo as $row1) {
            if (($row->MsProdukId == $row1->MsProdukId) && ($row->PODetailVarian == $row1->GRPODetailVarian)) $Qty += $row1->GRPODetailQty;
         }
         $salescode = $row->SalesRef;
      }
      if ($QtyPO <= $Qty)   $this->db->update('TblPO', array('POStatus' => 2), array('POCode' => $sales["GRPORef"]));

      echo $QtyPO;
      echo "|";
      echo $Qty;
      /* --------------   BUAT LOG SALES ----------------- */
      $this->db->insert(
         'TblSalesLog',
         array(
            "SalesLogRef" => $salescode,
            "SalesLogDesc" => "<b>GRPO</b> telah <span style='color:green'>dibuat</span> oleh <b>" . $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName") . "</b> dengan item " . $itemstring
         )
      );

      /* --------------   BUAT TRANSAKSI INVENTORY ----------------- */
      $this->m_inventory->insert_trans_from_grpo($sales["GRPOCode"]);
      exit;
   }
   public function data_grpo_edit($id)
   {
      $status = true;
      $sales = $this->input->post("data");
      $sales += ["GRPOLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->update('TblGRPO', $sales, array("GRPOId" => $id));
      if ($status && ($this->db->affected_rows() != 1)) $status = false;

      $itemstring = "";

      $code = $this->model_app->get_single_data("GRPOCode", "TblGRPO", array("GRPOId" => $id));
      if (null !== $this->input->post("item")) {
         $this->db->delete('TblGRPODetail', array('GRPODetailRef' =>  $code));
         $dataitem = $this->input->post("item");
         foreach ($dataitem as $row) {
            $this->db->insert('TblGRPODetail', $row);
            if ($status && ($this->db->affected_rows() != 1)) $status = false;
            $itemmaster = $this->db->where("MsProdukId", $row["MsProdukId"])->get("TblMsProduk")->row();
            $itemstring .= " | " . $itemmaster->MsProdukCode . " - " . $itemmaster->MsProdukName . " " .   $row["GRPODetailQty"];
         }
      }

      /* --------------   CEK STATUS ----------------- */
      $data_grpo = $this->db->join("TblGRPODetail", "GRPODetailRef=GRPOCode", "left")->where("GRPORef", $sales["GRPORef"])->get("TblGRPO")->result();
      $data_po = $this->db->join("TblPODetail", "PODetailRef=POCode", "left")->where("POCode", $sales["GRPORef"])->get("TblPO")->result();
      $QtyPO = 0;
      $Qty = 0;
      foreach ($data_po as $row) {
         $QtyPO += $row->PODetailQty;
         foreach ($data_grpo as $row1) {
            if (($row->MsItemId == $row1->MsItemId) && ($row->MsVendorCode == $row1->MsVendorCode)) $Qty += $row1->GRPODetailQty;
         }
         $salescode = $row->SalesRef;
      }
      if ($QtyPO <= $Qty) {
         $this->db->update('TblPO', array('POStatus' => 2), array('POCode' => $sales["GRPORef"]));
      } else {

         $this->db->update('TblPO', array('POStatus' => 1), array('POCode' => $sales["GRPORef"]));
      }

      echo true;
      /* --------------   BUAT LOG SALES ----------------- */
      $this->db->insert(
         'TblSalesLog',
         array(
            "SalesLogRef" => $salescode,
            "SalesLogDesc" => "<b>GRPO</b> telah <span style='color:orange'>diubah</span> oleh <b>" . $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName") . "</b> dengan item " . $itemstring
         )
      );

      /* --------------   BUAT LOG GRPO ----------------- */
      $this->m_inventory->insert_trans_from_grpo($code);
      exit;
   }
   public function data_grpo_remove($id)
   {
      $data_old = $this->db->join("TblPO", "TblPO.POCode=TblGRPO.GRPORef", "left")
         ->where("GRPOId", $id)->get("TblGRPO")->row();

      $this->db->delete('TblGRPODetail', array('GRPODetailRef' =>  $data_old->GRPOCode));
      $this->db->delete('TblGRPO', array('GRPOCode' => $data_old->GRPOCode));

      /* --------------   CEK STATUS ----------------- */
      $this->db->update('TblPO', array('POStatus' => 1), array('POCode' => $data_old->GRPORef));

      echo true;
      /* --------------   BUAT LOG SALES ----------------- */
      $this->db->insert(
         'TblSalesLog',
         array(
            "SalesLogRef" => $data_old->SalesRef,
            "SalesLogDesc" => "<b>GRPO</b> telah <span style='color:orange'>diubah</span> oleh <b>" . $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName") . "</b>"
         )
      );

      /* --------------   BUAT LOG GRPO ----------------- */
      $this->m_inventory->delete_trans_min($data_old->GRPOCode);
      exit;
   }


   public function data_to_add()
   {
      $status = true;
      $sales = $this->input->post("data");
      $sales += ["InvTOLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $sales += ["InvTOCreateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->insert('TblInvTO', $sales);
      if ($status && ($this->db->affected_rows() != 1)) $status = false;

      $itemstring = "";
      if (null !== $this->input->post("item")) {
         $dataitem = $this->input->post("item");
         foreach ($dataitem as $row) {
            $this->db->insert('TblInvTODetail', $row);
            if ($status && ($this->db->affected_rows() != 1)) $status = false;
            // $itemmaster = $this->db
            //    ->join("TblMsSatuan","TblMsProduk.MsProdukId=TblMsSatuan.SatuanId")
            //    ->where("MsProdukId", $row["MsProdukId"])->get("TblMsProduk")->row();
            // $itemstring .= " | " . $itemmaster->MsProdukCode . " - " . $itemmaster->MsProdukName . " " .   $row["InvTODetailQty"]  . " " . $itemmaster->MsItemUoM;
         }
      }
      echo true;
      /* --------------   CEK STATUS ----------------- */
      $this->db->insert(
         'TblSalesLog',
         array(
            "SalesLogRef" => $sales["SalesRef"],
            "SalesLogDesc" => "<b>TO</b> telah <span style='color:green'>dibuat</span> oleh <b>" . $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName") . "</b> dengan item " . $itemstring
         )
      );

      /* --------------   BUAT LOG GRPO ----------------- */
      $this->m_inventory->insert_trans_from_to($sales["InvTOCode"]);
      exit;
   }
   public function data_to_edit($id)
   {
      $status = true;
      $sales = $this->input->post("data");
      $sales += ["InvTOLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->update('TblInvTO', $sales, array("InvTOId" => $id));
      if ($status && ($this->db->affected_rows() != 1)) $status = false;

      $itemstring = "";
      if (null !== $this->input->post("item")) {
         $this->db->delete('TblInvTODetail', array('InvTODetailRef' =>  $sales["InvTOCode"]));
         $dataitem = $this->input->post("item");
         foreach ($dataitem as $row) {
            $this->db->insert('TblInvTODetail', $row);
            if ($status && ($this->db->affected_rows() != 1)) $status = false;
            // $itemmaster = $this->db->where("MsProdukId", $row["MsProdukId"])->get("TblMsProduk")->row();
            // $itemstring .= " | " . $itemmaster->MsItemCode . " - " . $itemmaster->MsItemName . " " .   $row["InvTODetailQty"]  . " " . $itemmaster->MsItemUoM;
         }
      }
      echo true;
      /* --------------   CEK STATUS ----------------- */
      $this->db->insert(
         'TblSalesLog',
         array(
            "SalesLogRef" => $sales["SalesRef"],
            "SalesLogDesc" => "<b>TO</b> telah <span style='color:orange'>diubah</span> oleh <b>" . $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName") . "</b> dengan item " . $itemstring
         )
      );

      /* --------------   BUAT LOG GRPO ----------------- */
      $this->m_inventory->insert_trans_from_to($sales["InvTOCode"]);
      exit;
   }
   public function data_to_remove($id)
   {
      $data_old = $this->db->where("InvTOId", $id)->get("TblInvTO")->row();

      $this->db->delete('TblInvTO', array('InvTOCode' =>  $data_old->InvTOCode));
      $this->db->delete('TblInvTODetail', array('InvTODetailRef' => $data_old->InvTOCode));

      echo true;
      /* --------------   BUAT LOG SALES ----------------- */
      $this->db->insert(
         'TblSalesLog',
         array(
            "SalesLogRef" => $data_old->SalesRef,
            "SalesLogDesc" => "<b>TO</b> telah <span style='color:red'>dihapus</span> oleh <b>" . $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName") . "</b>"
         )
      );  

      /* --------------   BUAT LOG GRPO ----------------- */
      $this->m_inventory->insert_trans_from_to($data_old->InvTOCode);
      exit;
   }

   public function data_ti_add()
   {
      $status = true;
      $sales = $this->input->post("data");
      $sales += ["InvTILastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $sales += ["InvTICreateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->insert('TblInvTI', $sales);
      if ($status && ($this->db->affected_rows() != 1)) $status = false;

      $itemstring = "";
      if (null !== $this->input->post("item")) {
         $dataitem = $this->input->post("item");
         foreach ($dataitem as $row) {
            $this->db->insert('TblInvTIDetail', $row);
            if ($status && ($this->db->affected_rows() != 1)) $status = false;
            //$itemmaster = $this->db->where("MsItemId", $row["MsItemId"])->get("TblMsItem")->row();
            //$itemstring .= " | " . $itemmaster->MsItemCode . " - " . $itemmaster->MsItemName . " " .   $row["InvTIDetailQty"]  . " " . $itemmaster->MsItemUoM;
         }
      }
      echo true;
      /* --------------   CEK STATUS ----------------- */
      $data_to = $this->db->join("TblInvTODetail", "InvTODetailRef=InvTOCode", "left")->where("InvTOCode", $sales["InvTIRef"])->get("TblInvTO")->result();
      $data_ti = $this->db->join("TblInvTIDetail", "InvTIDetailRef=InvTICode", "left")->where("InvTIRef", $sales["InvTIRef"])->get("TblInvTI")->result();
      $QtyPO = 0;
      $Qty = 0;
      foreach ($data_to as $row) {
         $QtyPO += $row->InvTODetailQty;
         foreach ($data_ti as $row1) {
            if (($row->MsItemId == $row1->MsItemId) && ($row->MsVendorCode == $row1->MsVendorCode)) $Qty += $row1->InvTIDetailQty;
         }
         $salescode = $row->SalesRef;
      }
      if ($QtyPO <= $Qty) $this->db->update('TblInvTO', array('InvTOStatus' => 1), array('InvTOCode' => $sales["InvTIRef"]));

      echo true;
      $this->db->insert(
         'TblSalesLog',
         array(
            "SalesLogRef" =>  $salescode,
            "SalesLogDesc" => "<b>TI</b> telah <span style='color:green'>dibuat</span> oleh <b>" . $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName") . "</b> dengan item " . $itemstring
         )
      );

      /* --------------   BUAT LOG GRPO ----------------- */
      $this->m_inventory->insert_trans_from_ti($sales["InvTICode"]);
      exit;
   }
   public function data_ti_remove($id)
   {
      $data_old = $this->db->join("TblInvTO", "InvTOCode=InvTIRef", "left")->where("InvTIId", $id)->get("TblInvTI")->row();

      $this->db->delete('TblInvTI', array('InvTICode' =>  $data_old->InvTICode));
      $this->db->delete('TblInvTIDetail', array('InvTIDetailRef' => $data_old->InvTICode));

      $this->db->update('TblInvTO', array('InvTOStatus' => 0), array('InvTOCode' => $data_old->InvTOCode));

      /* --------------   BUAT LOG SALES ----------------- */
      $this->db->insert(
         'TblSalesLog',
         array(
            "SalesLogRef" => $data_old->SalesRef,
            "SalesLogDesc" => "<b>TO</b> telah <span style='color:red'>dihapus</span> oleh <b>" . $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName") . "</b>"
         )
      );

      /* --------------   BUAT LOG GRPO ----------------- */
      $logtrans = $this->m_inventory->insert_trans_from_ti($data_old->InvTICode);
      echo json_encode($logtrans);
      exit;
   }

   public function data_sales_performa_add()
   {
      echo JSON_ENCODE($this->input->post());
      $paymentdetail = array(
         "PerformaCardName" => $this->input->post("PerformaCardName"),
         "PerformaRef" => $this->input->post("PerformaRef"),
         "PerformaDate" => $this->input->post("PerformaDate"),
         "PerformaTotal" => $this->input->post("PerformaTotal"),
         "MsMethodId" => $this->input->post("MsMethodId"),
         "PerformaType" => $this->input->post("PerformaType"),
         "PerformaCreateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName"),
         "PerformaLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName"),
      );
      $this->db->insert('TblSalesPerforma', $paymentdetail);
      echo ($this->db->affected_rows() != 1 ? false : true);
      $this->db->insert(
         'TblSalesLog',
         array(
            "SalesLogRef" => $this->input->post("PerformaRef"),
            "SalesLogDesc" => "<b>Performa Invoice</b> telah <span style='color:green'>dibuat</span> oleh <b>" . $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
               . "</b> sebesar <b>Rp. " . number_format($this->input->post("PerformaTotal")) . "</b> dengan tipe pembayaran <b>" .
               $this->model_app->get_single_data("MsMethodName", "TblMsMethod", array("MsMethodId" => $this->input->post("MsMethodId"))) . "</b>"
         )
      );


      $maxid = ($this->db->select("Max(PerformaId) as max")->get("TblSalesPerforma")->row())->max;
      $this->db->update('TblSalesPayment', array("PaymentRef2"=>$maxid), array("PaymentId" =>  $this->input->post("PaymentId")));

      exit;
   }

   public function data_sales_performa_edit($id)
   {
      $dataold = $this->db->where("PerformaId", $id)->get("TblSalesPerforma")->row();
      $message = "";
      if ($dataold->PerformaCardName != $this->input->post("PerformaCardName")) {
         $message = "Nama dari <b>" . $dataold->PerformaCardName . "</b> menjadi <b>" . $this->input->post("PerformaCardName") . "</b> ";
      }
      if ($dataold->PerformaTotal != $this->input->post("PerformaTotal")) {
         $message = "total dari <b>" . $dataold->PerformaTotal . "</b> menjadi <b>" . $this->input->post("PerformaTotal") . "</b> ";
      }
      if ($dataold->MsMethodId != $this->input->post("MsMethodId")) {
         $metodnew = $this->model_app->get_single_data("MsMethodName", "TblMsMethod", array("MsMethodId" => $this->input->post("MsMethodId")));
         $metodold = $this->model_app->get_single_data("MsMethodName", "TblMsMethod", array("MsMethodId" => $dataold->MsMethodId));
         $message = "metode bayar dari <b>" . $metodold . "</b> menjadi <b>" . $metodnew . "</b> ";
      }
      if ($dataold->PerformaDate != $this->input->post("PerformaDate")) {
         $message = "tanggal dari <b>" . $dataold->PerformaDate . "</b> menjadi <b>" . $this->input->post("PerformaDate") . "</b> ";
      }
      $this->db->insert(
         'TblSalesLog',
         array(
            "SalesLogRef" => $dataold->PerformaRef,
            "SalesLogDesc" => "<b>Performa Invoice</b> telah <span style='color:orange'>diubah</span> oleh <b>" . $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
               . "</b> dengan perubahan " .  $message
         )
      );
      $paymentdetail = array(
         "PerformaCardName" => $this->input->post("PerformaCardName"),
         "PerformaDate" => $this->input->post("PerformaDate"),
         "PerformaTotal" => $this->input->post("PerformaTotal"),
         "MsMethodId" => $this->input->post("MsMethodId"),
         "PerformaType" => $this->input->post("PerformaType"),
         "PerformaLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName"),
      );
      $this->db->update('TblSalesPerforma', $paymentdetail, array("PerformaId" => $id));
      echo ($this->db->affected_rows() != 1 ? false : true);
      exit;
   }

   public function data_sale_performa_remove($id)
   {
      $row = $this->db->where("PerformaId", $id)->get("TblSalesPerforma")->row();
      $this->db->insert(
         'TblSalesLog',
         array(
            "SalesLogRef" => $row->PerformaRef,
            "SalesLogDesc" => "<b>Performa Invoice</b> atas nama <b>" . $row->PerformaCardName . "</b> dengan total <b>Rp. " .  number_format($row->PerformaTotal) .
               "</b> <span style='color:red'>dihapus</span> oleh <b>" . $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName") . "</b>"
         )
      );

      $this->db->delete('TblSalesPerforma', array('PerformaId' =>  $id));
      echo ($this->db->affected_rows() != 1 ? "false" : "true");
      exit;
   }

   public function data_sale_performa_success($id)
   {
      $row = $this->db->where("PerformaId", $id)->get("TblSalesPerforma")->row();
      $this->db->insert(
         'TblSalesLog',
         array(
            "SalesLogRef" => $row->PerformaRef,
            "SalesLogDesc" => "<b>Performa Invoice</b> atas nama <b>" . $row->PerformaCardName . "</b> dengan total <b>Rp. " .  number_format($row->PerformaTotal) .
               "</b> <span style='color:green'>diselesaikan</span> oleh <b>" . $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName") . "</b>"
         )
      );
      $this->db->update('TblSalesPerforma', array("PerformaStatus" => 1), array("PerformaId" => $id));
      echo ($this->db->affected_rows() != 1 ? false : true);
      exit;
   }

   public function data_kunjungan_add()
   {

      $this->db->insert('TblVisitor', $this->input->post());
      echo ($this->db->affected_rows() != 1 ? false : true);
      exit;
   }
   public function data_kunjungan_edit($id)
   {

      $this->db->update('TblVisitor', $this->input->post(), array("visitorId" => $id));
      echo ($this->db->affected_rows() != 1 ? false : true);
      exit;
   }
   public function data_kunjungan_delete($id)
   {
      $this->db->delete('TblVisitor',  array("visitorId" => $id));
      echo ($this->db->affected_rows() != 1 ? false : true);
      exit;
   }


   public function customer_upload_file($id_store, $id_cust)
   {
      if (!empty($_FILES['file']['name'])) {
         if (!file_exists('asset/image/file/customer/')) {
            mkdir("asset/image/file/customer", 0777);
         }
         if (!file_exists('asset/image/file/customer/' . $id_cust . '/')) {
            mkdir("asset/image/file/customer/" . $id_cust, 0777);
         }
         $filename = preg_replace('/\s+/', '_',  $_FILES['file']['name']);
         // Set preference
         $config['upload_path'] = 'asset/image/file/customer/' . $id_cust;
         $config['allowed_types'] = '*';
         $config['max_size'] = '100000'; // max_size in kb
         $config['file_name'] = $filename;

         //Load upload library
         $this->load->library('upload', $config);
         // File upload
         if ($this->upload->do_upload('file')) {
            // Get data about the file
            $uploadData = $this->upload->data();
            $data = array(
               "MsCustomerId" => $id_cust,
               "FileCustomerDesc" => $_FILES['file']['name'],
               "FileCustomerImage" => $filename,
               "MsWorkplaceId" => $id_store,
            );
            $this->db->insert('TblFileCustomer', $data);
            echo ($this->db->affected_rows() != 1 ? false : true);
            echo $uploadData;
            exit;
         }
      }
   }
   public function customer_rename_file($id)
   {
      $this->db->update('TblFileCustomer', $this->input->post(), array("FileCustomerId" => $id));
      echo ($this->db->affected_rows() != 1 ? false : true);
      exit;
   }

   public function customer_delete_file($id, $name, $fileid)
   {
      $location = 'asset/image/file/customer/' . $id . '/' . $name; //untuk lokal
      unlink(FCPATH . $location);
      $location = 'asset/image/file/cache/' . $id . '/' . $name; //untuk lokal
      unlink(FCPATH . $location);

      $this->db->delete('TblFileCustomer',  array("FileCustomerId" => $fileid));
      echo ($this->db->affected_rows() != 1 ? false : true);
      exit;
   }
}
