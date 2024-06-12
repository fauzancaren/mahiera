<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Message_sales extends CI_Controller
{
   function __construct()
   {
      parent::__construct();
      $this->load->model('model_app');
      date_default_timezone_set('Asia/Jakarta');
   }
   function data_delivery_edit($id)
   {
      $data["_delivery"] = $this->db->where("MsCustomerDeliveryId", $id)->get("TblMsCustomerDelivery")->row();
      echo $this->load->view('message/sales/edit_delivery', $data, TRUE);
   }
   function data_delivery_select($id)
   {
      echo $this->load->view('message/sales/select_delivery', array("id" => $id), TRUE);
   }
   function quotation_add()
   {
      echo $this->load->view('message/sales/quotation/quotation_add', '', TRUE);
   }
   function quotation_change_header($id, $select)
   {
      echo $this->load->view('message/sales/quotation/quotation_change_header', array("id" => $id, "value" => $select), TRUE);
   }
   function quotation_edit($id)
   {
      $data["quotation"] = $this->db->query("select * from TblQuotation where QuoId='{$id}'")->row(); 
      $data["optional"] = $this->db->query("select * from TblQuoOptional where QuoOptionalRef='{$data["quotation"]->QuoCode}'")->result();
      $dataitem = $this->db
      ->join("TblMsSatuan","TblQuoDetail.SatuanId=TblMsSatuan.SatuanId")
      ->join("TblMsProduk","TblMsProduk.MsProdukId=TblQuoDetail.MsProdukId")
      ->where("QuoDetailRef", $data["quotation"]->QuoCode)->get("TblQuoDetail")->result();  
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
      $data["dataitem"] = $arr_item;
      $data["store"] = $this->db->get("TblMsWorkplace")->result();
      echo $this->load->view('message/sales/quotation/quotation_edit',$data, TRUE);
   }

   function show_image()
   {
      echo $this->load->view('message/sales/show_image', $this->input->post(), TRUE);
   }
   function show_file()
   {
      echo $this->load->view('message/sales/show_file', '', TRUE);
   }

   function sales_add()
   {
      echo $this->load->view('message/sales/sales/sales_add', '', TRUE);
   }
   function sales_edit($id)
   {
      $data["_sales"] = $this->db->where("SalesId", $id)->get("TblSales")->row();
      $dataitem = $this->db->join("TblMsSatuan","TblSalesDetail.SatuanId=TblMsSatuan.SatuanId")->join("TblMsProduk","TblMsProduk.MsProdukId=TblSalesDetail.MsProdukId")->where("SalesDetailRef", $data["_sales"]->SalesCode)->get("TblSalesDetail")->result();  
      $arr_item = array();    
      foreach($dataitem as $row){
         $arr_item[] = array(
            "MsProdukId"=>$row->MsProdukId,
            "MsProdukCode"=>$row->MsProdukCode,
            "MsProdukName"=>$row->MsProdukName,
            "MsProdukImage"=>(file_exists(getcwd() . "/asset/image/produk/" .  $row->MsProdukId."/".$row->MsProdukCode."_1.png") ?
                              base_url("asset/image/produk/".$row->MsProdukId."/".$row->MsProdukCode."_1.png") : base_url("asset/image/mgs-erp/defaultitem.png")),
            "MsProdukVarian"=>$row->MsProdukVarian,
            "selected"=>explode("|",$row->SalesDetailVarian),
            "MsProdukDetail"=>$this->db->join("TblMsSatuan","TblMsProdukDetail.SatuanId=TblMsSatuan.SatuanId")->where("MsProdukDetailRef",$row->MsProdukId)->get("TblMsProdukDetail")->result(),
            "MsProdukStock"=>$this->db->where("MsProdukId",$row->MsProdukId)->get("TblMsProdukStock")->result(),
            "price"=>$row->SalesDetailPrice,
            "qty"=>$row->SalesDetailQty,
            "pricetotal"=>$row->SalesDetailTotal,
            "discitemprice"=>$row->SalesDetailDisc,
            "discitempersen"=>$row->SalesDetailDiscPercen,
            "discitemtype"=>$row->SalesDetailDiscType,
            "disctype"=>$row->SalesDetailDiscTypeAll,
            "disctotalprice"=>$row->SalesDetailDiscTotal,
            "disctotalpersen"=>$row->SalesDetailDiscTotalPercen,
            "disctotaltype"=>$row->SalesDetailDiscTotalType,
            "cogs"=>$row->SalesDetailCogs,
            "uom"=>$row->SatuanName,
         ); 
      }
      $data["_detail"] = $arr_item;
      $data["_optional"] = $this->db
         ->where("SalesOptionalRef", $data["_sales"]->SalesCode)->get("TblSalesOptional")->result();
      $data["store"] = $this->db->get("TblMsWorkplace")->result();
      echo $this->load->view('message/sales/sales/sales_edit', $data, TRUE);
   }
   function sales_history($id)
   {
      $data["_sales"] = $this->db->where("SalesId", $id)->get("TblSales")->row();
      if ($data["_sales"]->SalesCountEdit > 0) {
         echo $this->load->view('message/sales/sales/sales_history', $data, TRUE);
      } else {
         echo "false";
      }
   }
   function sales_change_header($id, $select)
   {
      echo $this->load->view('message/sales/sales/sales_change_header', array("id" => $id, "value" => $select), TRUE);
   }

   function sales_payment_add($id,$ref)
   {

      $code = $this->model_app->get_single_data("SalesCode", "TblSales", array("SalesId" => $id));
      $ref = $this->db->where("PerformaId",$ref)->get("TblSalesPerforma")->row();
      $total = $this->model_app->get_single_data("SalesGrandTotal", "TblSales", array("SalesId" => $id));
      $customerid = $this->model_app->get_single_data("MsCustomerId", "TblSales", array("SalesId" => $id));
      $customerName = $this->model_app->get_customer_name($customerid);
      
      $data = $this->db
         ->query("Select SUM(PaymentTotal) as total from TblSalesPayment Where PaymentRef='" . $code . "'")
         ->row();
      $sisa = $total - $data->total;
      echo $this->load->view('message/sales/payment/sales_payment_add', array("code" => $code, "sisa" => $sisa, "total" => $total, "customer" => $customerName, "ref" => $ref), TRUE);
   }

   function sales_payment_edit($id)
   {
      $data['_payment'] = $this->db->where("PaymentId", $id)->get("TblSalesPayment")->row();
      $data['_id'] = $this->model_app->get_single_data("SalesId", "TblSales", array("SalesCode" => $data['_payment']->PaymentRef));
      echo $this->load->view('message/sales/payment/sales_payment_edit', $data, TRUE);
   }

   function sales_delivery_add($id)
   {
      if ($this->input->post("tipe") == "PO") {
         $data["_dataref"] = $this->db->where("POId", $this->input->post("id"))->get("TblPO")->row();
         if ($data["_dataref"] != null) {
            $data["_datarefDetail"] = $this->db
               ->join("TblMsProduk", "TblPODetail.MsProdukId=TblMsProduk.MsProdukId")  
               ->join("TblMsSatuan","TblPODetail.SatuanId=TblMsSatuan.SatuanId")
               ->join("TblSalesDetail", "TblSalesDetail.MsProdukId=TblPODetail.MsProdukId and TblSalesDetail.SalesDetailVarian=TblPODetail.PODetailVarian", "left")
               ->where("SalesDetailRef", $data["_dataref"]->SalesRef)
               ->where("PODetailRef", $data["_dataref"]->POCode)
               ->get("TblPODetail")->result();
            $data["_datarefDelivery"] = $this->db
               ->join("TblMsProduk", "TblDeliveryDetail.MsProdukId=TblMsProduk.MsProdukId")  
               ->join("TblMsSatuan","TblDeliveryDetail.SatuanId=TblMsSatuan.SatuanId")
               ->join("TblDelivery", "TblDelivery.DeliveryCode=TblDeliveryDetail.DeliveryDetailRef")
               ->where("DeliveryRef2", $data["_dataref"]->POCode)
               ->get("TblDeliveryDetail")->result();
         } else {
            $data["_datarefDetail"] = null;
            $data["_datarefDelivery"] = null;
         }
         $data["_type"] = "PO";
      } else if ($this->input->post("tipe") == "TO") {
         $data["_dataref"] = $this->db->where("InvTOId", $this->input->post("id"))->get("TblInvTO")->row();
         if ($data["_dataref"] != null) {
            $data["_datarefDetail"] = $this->db
               ->join("TblMsProduk", "TblInvTODetail.MsProdukId=TblMsProduk.MsProdukId")  
               ->join("TblMsSatuan","TblInvTODetail.SatuanId=TblMsSatuan.SatuanId")
               ->join("TblSalesDetail", "TblSalesDetail.MsProdukId=TblInvTODetail.MsProdukId and TblSalesDetail.SalesDetailVarian=TblInvTODetail.InvTODetailVarian", "left")
               ->where("SalesDetailRef", $data["_dataref"]->SalesRef)
               ->where("InvTODetailRef", $data["_dataref"]->InvTOCode)
               ->get("TblInvTODetail")->result();
            $data["_datarefDelivery"] = $this->db
               ->join("TblMsProduk", "TblDeliveryDetail.MsProdukId=TblMsProduk.MsProdukId")  
               ->join("TblMsSatuan","TblDeliveryDetail.SatuanId=TblMsSatuan.SatuanId")
               ->join("TblDelivery", "TblDelivery.DeliveryCode=TblDeliveryDetail.DeliveryDetailRef")
               ->where("DeliveryRef2", $data["_dataref"]->InvTOCode)
               ->get("TblDeliveryDetail")->result();
         } else {
            $data["_datarefDetail"] = null;
            $data["_datarefDelivery"] = null;
         }
         $data["_type"] = "TO";
      } else {
         $data["_dataref"] = null;
         $data["_datarefDetail"] = null;
         $data["_datarefDelivery"] = null;
         $data["_type"] = null;
      }

      $data["_sales"] = $this->db
         ->join("TblMsCustomer", "TblSales.MsCustomerId=TblMsCustomer.MsCustomerId")
         ->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblSales.MsEmpId")
         ->join("TblMsWorkplace", "TblSales.MsWorkplaceId=TblMsWorkplace.MsWorkplaceId")
         ->where("SalesId", $id)->get("TblSales")->row();
      $data["_item"] = $this->db
         ->join("TblMsProduk", "TblSalesDetail.MsProdukId=TblMsProduk.MsProdukId")  
         ->join("TblMsSatuan","TblSalesDetail.SatuanId=TblMsSatuan.SatuanId") 
         ->where("SalesDetailRef", $data["_sales"]->SalesCode)
         ->get("TblSalesDetail")->result();
      $data["_itemdelivery"] = $this->db
         ->join("TblMsProduk", "TblDeliveryDetail.MsProdukId=TblMsProduk.MsProdukId")  
         ->join("TblMsSatuan","TblDeliveryDetail.SatuanId=TblMsSatuan.SatuanId") 
         ->join("TblDelivery", "TblDelivery.DeliveryCode=TblDeliveryDetail.DeliveryDetailRef")
         ->where("DeliveryRef", $data["_sales"]->SalesCode)
         ->get("TblDeliveryDetail")->result();
      $data["_code"] = $this->model_app->get_next_delivery($data["_sales"]->MsWorkplaceId, date("m"), date("Y"), $this->session->userdata("MsEmpId"));
      $data["_rit"] = $this->db->query("SELECT IFNULL(max(deliveryRit) + 1,1) AS rit FROM TblDelivery WHERE DeliveryRef='" . $data["_sales"]->SalesCode . "'")->row();
      
      echo $this->load->view('message/sales/delivery/sales_delivery_add', $data, TRUE);
   }
   function sales_delivery_edit($id)
   {
      $data["_delivery"] = $this->db->where("DeliveryId", $id)->get("TblDelivery")->row();
      $data["_sales"] = $this->db
         ->join("TblMsCustomer", "TblSales.MsCustomerId=TblMsCustomer.MsCustomerId")
         ->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblSales.MsEmpId")
         ->join("TblMsWorkplace", "TblSales.MsWorkplaceId=TblMsWorkplace.MsWorkplaceId")
         ->where("SalesCode", $data["_delivery"]->DeliveryRef)->get("TblSales")->row();

      if(substr($data["_delivery"]->DeliveryRef2,12,2) == "PO"){
         $data["_itemref"] = $this->db
            ->where("POCode", $data["_delivery"]->DeliveryRef2) 
            ->get("TblPO")->row();
         $data["_itemrefdetail"] = $this->db 
            ->join("TblMsProduk", "TblPODetail.MsProdukId=TblMsProduk.MsProdukId")  
            ->join("TblMsSatuan","TblPODetail.SatuanId=TblMsSatuan.SatuanId") 
            ->join("TblPO", "TblPO.POCode=TblPODetail.PODetailRef")
            ->where("POCode", $data["_delivery"]->DeliveryRef2) 
            ->get("TblPODetail")->result();
         $data["_type"] = "PO";

         $data["_otherdetaildelivery"] = $this->db
         ->join("TblMsProduk", "TblDeliveryDetail.MsProdukId=TblMsProduk.MsProdukId")  
         ->join("TblMsSatuan","TblDeliveryDetail.SatuanId=TblMsSatuan.SatuanId") 
         ->join("TblDelivery", "TblDelivery.DeliveryCode=TblDeliveryDetail.DeliveryDetailRef")
         ->where("DeliveryRef2", $data["_delivery"]->DeliveryRef2)
         ->where("DeliveryId !=", $id)
         ->get("TblDeliveryDetail")->result();
      }
      if(substr($data["_delivery"]->DeliveryRef2,12,2) == "TO"){
         $data["_itemrefdetail"] = $this->db
            ->join("TblMsProduk", "TblPODetail.MsProdukId=TblMsProduk.MsProdukId")  
            ->join("TblMsSatuan","TblPODetail.SatuanId=TblMsSatuan.SatuanId") 
            ->join("TblPO", "TblPO.POCode=TblPODetail.PODetailRef")
            ->where("POCode", $data["_delivery"]->DeliveryRef2) 
            ->get("TblPODetail")->result();
         $data["_type"] = "TO";

         $data["_otherdetaildelivery"] = $this->db
         ->join("TblMsProduk", "TblDeliveryDetail.MsProdukId=TblMsProduk.MsProdukId")  
         ->join("TblMsSatuan","TblDeliveryDetail.SatuanId=TblMsSatuan.SatuanId") 
         ->join("TblDelivery", "TblDelivery.DeliveryCode=TblDeliveryDetail.DeliveryDetailRef")
         ->where("DeliveryRef2", $data["_itemref"]->POCode)
         ->where("DeliveryId !=", $id)
         ->get("TblDeliveryDetail")->result();
      } 
      $data["_detaildelivery"] = $this->db
         ->join("TblMsProduk", "TblDeliveryDetail.MsProdukId=TblMsProduk.MsProdukId")  
         ->join("TblMsSatuan","TblDeliveryDetail.SatuanId=TblMsSatuan.SatuanId") 
         ->join("TblDelivery", "TblDelivery.DeliveryCode=TblDeliveryDetail.DeliveryDetailRef")
         ->where("DeliveryCode", $data["_delivery"]->DeliveryCode)
         ->get("TblDeliveryDetail")->result();
      echo $this->load->view('message/sales/delivery/sales_delivery_edit', $data, TRUE);
   }
   function sales_delivery_selesai($id)
   {
      $data["_delivery"] = $this->db->where("DeliveryId", $id)->get("TblDelivery")->row();
      $data["_sales"] = $this->db
         ->join("TblMsCustomer", "TblSales.MsCustomerId=TblMsCustomer.MsCustomerId")
         ->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblSales.MsEmpId")
         ->join("TblMsWorkplace", "TblSales.MsWorkplaceId=TblMsWorkplace.MsWorkplaceId")
         ->where("SalesCode", $data["_delivery"]->DeliveryRef)->get("TblSales")->row();

      $data["_itemsales"] = $this->db
         ->join("TblMsItem", "TblSalesDetail.MsItemId=TblMsItem.MsItemId")
         ->join("TblMsVendor", "TblMsVendor.MsVendorCode=TblSalesDetail.MsVendorCode")
         ->join("TblMsItemCategory", "TblMsItemCategory.MsItemCatId=TblMsItem.MsItemCatId")
         ->where("SalesDetailRef", $data["_sales"]->SalesCode)
         ->get("TblSalesDetail")->result();

      $data["_itemdelivery"] = $this->db
         ->join("TblMsItem", "TblDeliveryDetail.MsItemId=TblMsItem.MsItemId")
         ->join("TblMsVendor", "TblMsVendor.MsVendorCode=TblDeliveryDetail.MsVendorCode")
         ->join("TblMsItemCategory", "TblMsItemCategory.MsItemCatId=TblMsItem.MsItemCatId")
         ->join("TblDelivery", "TblDelivery.DeliveryCode=TblDeliveryDetail.DeliveryDetailRef")
         ->where("DeliveryRef", $data["_sales"]->SalesCode)
         ->where("DeliveryId !=", $id)
         ->get("TblDeliveryDetail")->result();

      $data["_detaildelivery"] = $this->db
         ->join("TblMsItem", "TblDeliveryDetail.MsItemId=TblMsItem.MsItemId")
         ->join("TblMsVendor", "TblMsVendor.MsVendorCode=TblDeliveryDetail.MsVendorCode")
         ->join("TblMsItemCategory", "TblMsItemCategory.MsItemCatId=TblMsItem.MsItemCatId")
         ->join("TblDelivery", "TblDelivery.DeliveryCode=TblDeliveryDetail.DeliveryDetailRef")
         ->where("DeliveryCode", $data["_delivery"]->DeliveryCode)
         ->get("TblDeliveryDetail")->result();
      echo $this->load->view('message/sales/delivery/sales_delivery_selesai', $data, TRUE);
   }
   function sales_delivery_proses($id)
   {
      $data["_delivery"] = $this->db->where("DeliveryId", $id)->get("TblDelivery")->row();
      $data["_sales"] = $this->db
         ->join("TblMsCustomer", "TblSales.MsCustomerId=TblMsCustomer.MsCustomerId")
         ->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblSales.MsEmpId")
         ->join("TblMsWorkplace", "TblSales.MsWorkplaceId=TblMsWorkplace.MsWorkplaceId")
         ->where("SalesCode", $data["_delivery"]->DeliveryRef)->get("TblSales")->row();

      if(substr($data["_delivery"]->DeliveryRef2,12,2) == "PO"){
         $data["_itemref"] = $this->db
            ->where("POCode", $data["_delivery"]->DeliveryRef2) 
            ->get("TblPO")->row();
         $data["_itemrefdetail"] = $this->db 
            ->join("TblMsProduk", "TblPODetail.MsProdukId=TblMsProduk.MsProdukId")  
            ->join("TblMsSatuan","TblPODetail.SatuanId=TblMsSatuan.SatuanId") 
            ->join("TblPO", "TblPO.POCode=TblPODetail.PODetailRef")
            ->where("POCode", $data["_delivery"]->DeliveryRef2) 
            ->get("TblPODetail")->result();
         $data["_type"] = "PO";

         $data["_otherdetaildelivery"] = $this->db
         ->join("TblMsProduk", "TblDeliveryDetail.MsProdukId=TblMsProduk.MsProdukId")  
         ->join("TblMsSatuan","TblDeliveryDetail.SatuanId=TblMsSatuan.SatuanId") 
         ->join("TblDelivery", "TblDelivery.DeliveryCode=TblDeliveryDetail.DeliveryDetailRef")
         ->where("DeliveryRef2", $data["_delivery"]->DeliveryRef2)
         ->where("DeliveryId !=", $id)
         ->get("TblDeliveryDetail")->result();
      }
      if(substr($data["_delivery"]->DeliveryRef2,12,2) == "TO"){
         $data["_itemrefdetail"] = $this->db
            ->join("TblMsProduk", "TblPODetail.MsProdukId=TblMsProduk.MsProdukId")  
            ->join("TblMsSatuan","TblPODetail.SatuanId=TblMsSatuan.SatuanId") 
            ->join("TblPO", "TblPO.POCode=TblPODetail.PODetailRef")
            ->where("POCode", $data["_delivery"]->DeliveryRef2) 
            ->get("TblPODetail")->result();
         $data["_type"] = "TO";

         $data["_otherdetaildelivery"] = $this->db
         ->join("TblMsProduk", "TblDeliveryDetail.MsProdukId=TblMsProduk.MsProdukId")  
         ->join("TblMsSatuan","TblDeliveryDetail.SatuanId=TblMsSatuan.SatuanId") 
         ->join("TblDelivery", "TblDelivery.DeliveryCode=TblDeliveryDetail.DeliveryDetailRef")
         ->where("DeliveryRef2", $data["_itemref"]->POCode)
         ->where("DeliveryId !=", $id)
         ->get("TblDeliveryDetail")->result();
      } 
      $data["_itemsales"] = $this->db
         ->join("TblMsItem", "TblSalesDetail.MsItemId=TblMsItem.MsItemId")
         ->join("TblMsVendor", "TblMsVendor.MsVendorCode=TblSalesDetail.MsVendorCode")
         ->join("TblMsItemCategory", "TblMsItemCategory.MsItemCatId=TblMsItem.MsItemCatId")
         ->where("SalesDetailRef", $data["_sales"]->SalesCode)
         ->get("TblSalesDetail")->result();

      $data["_itemdelivery"] = $this->db
         ->join("TblMsItem", "TblDeliveryDetail.MsItemId=TblMsItem.MsItemId")
         ->join("TblMsVendor", "TblMsVendor.MsVendorCode=TblDeliveryDetail.MsVendorCode")
         ->join("TblMsItemCategory", "TblMsItemCategory.MsItemCatId=TblMsItem.MsItemCatId")
         ->join("TblDelivery", "TblDelivery.DeliveryCode=TblDeliveryDetail.DeliveryDetailRef")
         ->where("DeliveryRef", $data["_sales"]->SalesCode)
         ->where("DeliveryId !=", $id)
         ->get("TblDeliveryDetail")->result();

      $data["_detaildelivery"] = $this->db
         ->join("TblMsItem", "TblDeliveryDetail.MsItemId=TblMsItem.MsItemId")
         ->join("TblMsVendor", "TblMsVendor.MsVendorCode=TblDeliveryDetail.MsVendorCode")
         ->join("TblMsItemCategory", "TblMsItemCategory.MsItemCatId=TblMsItem.MsItemCatId")
         ->join("TblDelivery", "TblDelivery.DeliveryCode=TblDeliveryDetail.DeliveryDetailRef")
         ->where("DeliveryCode", $data["_delivery"]->DeliveryCode)
         ->get("TblDeliveryDetail")->result();
 
      echo $this->load->view('message/sales/delivery/sales_delivery_proses', $data, TRUE);
   }
   function sales_delivery_transfer($id,$type){ 
      $data["_delivery"] = $this->db->where("DeliveryId", $id)->get("TblDelivery")->row(); 
      if($type == "PO"){ 
         
         $data["_session"] = $this->session->userdata();
         $data["_vendor"] =  $this->db->where("MsVendorIsActive=1")->get("TblMsVendor")->result();
         $data["_po"] = $this->db->select("*,TblPO.SalesRef")
            ->join("TblMsVendor", "TblMsVendor.MsVendorCode=TblPO.MsVendorCode")
            ->join("TblSales", "TblSales.SalesCode=TblPO.SalesRef", "left")
            ->join("TblMsCustomer", "TblMsCustomer.MsCustomerId=TblSales.MsCustomerId", "left")
            ->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblPO.MsEmpId", "left")->where("POCode", $data["_delivery"]->DeliveryRef2)->get("TblPO")->row();
         $data["_dataworkplace"] =  $this->db->where("MsWorkplaceIsActive=1")->get("TblMsWorkplace")->result();
         $data["_code"] = $this->model_app->get_next_grpo($this->session->userdata("MsWorkplaceId"), date("m"), date("Y"), $this->session->userdata("MsEmpId"));


         $data["_detaildelivery"] = $this->db
         ->join("TblMsProduk", "TblDeliveryDetail.MsProdukId=TblMsProduk.MsProdukId")  
         ->join("TblMsSatuan","TblDeliveryDetail.SatuanId=TblMsSatuan.SatuanId") 
         ->join("TblDelivery", "TblDelivery.DeliveryCode=TblDeliveryDetail.DeliveryDetailRef")
         ->where("DeliveryCode", $data["_delivery"]->DeliveryCode)
         ->get("TblDeliveryDetail")->result();
         echo $this->load->view('message/sales/grpo/grpoadd', $data, TRUE);
      }
      if($type == "TO"){ 
         
         $data["_session"] = $this->session->userdata();
         $data["_vendor"] =  $this->db->where("MsVendorIsActive=1")->get("TblMsVendor")->result();
         $data["_to"] = $this->db->select("*,TblInvTO.SalesRef") 
            ->join("TblSales", "TblSales.SalesCode=TblInvTO.SalesRef", "left")
            ->join("TblMsCustomer", "TblMsCustomer.MsCustomerId=TblSales.MsCustomerId", "left")
            ->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblInvTO.MsEmpId", "left")->where("InvTOCode", $data["_delivery"]->DeliveryRef2)->get("TblInvTO")->row();
         $data["_dataworkplace"] =  $this->db->where("MsWorkplaceIsActive=1")->get("TblMsWorkplace")->result();
         $data["_code"] = $this->model_app->get_next_ti($this->session->userdata("MsWorkplaceId"), date("m"), date("Y"), $this->session->userdata("MsEmpId"));


         $data["_detaildelivery"] = $this->db
            ->join("TblMsProduk", "TblDeliveryDetail.MsProdukId=TblMsProduk.MsProdukId")  
            ->join("TblMsSatuan","TblDeliveryDetail.SatuanId=TblMsSatuan.SatuanId") 
            ->join("TblDelivery", "TblDelivery.DeliveryCode=TblDeliveryDetail.DeliveryDetailRef")
            ->where("DeliveryCode", $data["_delivery"]->DeliveryCode)
            ->get("TblDeliveryDetail")->result();
         echo $this->load->view('message/sales/transfer/terima_add', $data, TRUE);  
      }
      
   }

   function sales_po_add($id)
   {

      $data["_sales"] = $this->db
         ->join("TblMsCustomer", "TblSales.MsCustomerId=TblMsCustomer.MsCustomerId")
         ->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblSales.MsEmpId")
         ->join("TblMsWorkplace", "TblSales.MsWorkplaceId=TblMsWorkplace.MsWorkplaceId")
         ->where("SalesId", $id)->get("TblSales")->row();
      $detailvarian = $this->db 
         ->where("SalesDetailRef", $data["_sales"]->SalesCode)  
         ->get("TblSalesDetail")->result();
      $vendor = array();
      foreach($detailvarian as $row){ 
         $arr = explode("|", $row->SalesDetailVarian);
         foreach($arr as $row2){
            $arr1 = explode(":", $row2);
            if($arr1[0] == "Vendor" && !in_array($arr1[1], $vendor)){
               array_push($vendor,$arr1[1]); 
            }
         }
      } 
      $data["_vendor"] = $this->db->where_in("MsVendorCode",$vendor)->get("TblMsVendor")->result();
      $data["_item"] = $this->db
         ->join("TblMsProduk", "TblSalesDetail.MsProdukId=TblMsProduk.MsProdukId")  
         ->join("TblMsSatuan","TblSalesDetail.SatuanId=TblMsSatuan.SatuanId")
         ->where("SalesDetailRef", $data["_sales"]->SalesCode)
         ->get("TblSalesDetail")->result();
      $data["_itempo"] = $this->db
         ->join("TblPO", "TblPO.POCode=TblPODetail.PODetailRef")
         ->join("TblMsProduk", "TblPODetail.MsProdukId=TblMsProduk.MsProdukId")  
         ->join("TblMsSatuan","TblPODetail.SatuanId=TblMsSatuan.SatuanId")
         ->where("SalesRef", $data["_sales"]->SalesCode)
         ->get("TblPODetail")->result();
      $data["_code"] = $this->model_app->get_next_po($data["_sales"]->MsWorkplaceId, date("m"), date("Y"), $this->session->userdata("MsEmpId"));
      $data["_user"] = $this->session->userdata();
      echo $this->load->view('message/sales/po/sales_po_add', $data, TRUE);
   }
   function sales_po_edit($id)
   {
      $data["_po"] = $this->db
         ->select("*, TblPO.MsWorkplaceId")
         ->join("TblMsVendor", "TblPO.MsVendorCode=TblMsVendor.MsVendorCode", "left")
         ->join("TblMsEmployee", "TblPO.MsEmpId=TblMsEmployee.MsEmpId", "left")
         ->where("POId", $id)->get("TblPO")->row();
      $data["_sales"] = $this->db
         ->join("TblMsCustomer", "TblSales.MsCustomerId=TblMsCustomer.MsCustomerId", "left")
         ->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblSales.MsEmpId", "left")
         ->join("TblMsWorkplace", "TblSales.MsWorkplaceId=TblMsWorkplace.MsWorkplaceId", "left")
         ->where("SalesCode", $data["_po"]->SalesRef)->get("TblSales")->row();
      $data["_item"] = $this->db
         ->join("TblPO", "TblPO.POCode=TblPODetail.PODetailRef", "left")
         ->join("TblMsProduk", "TblPODetail.MsProdukId=TblMsProduk.MsProdukId")  
         ->join("TblMsSatuan","TblPODetail.SatuanId=TblMsSatuan.SatuanId")
         ->where("SalesRef", $data["_po"]->SalesRef)
         ->where("PODetailRef !=", $data["_po"]->POCode)
         ->get("TblPODetail")->result();
      $data["_itempo"] = $this->db
         ->join("TblPO", "TblPO.POCode=TblPODetail.PODetailRef", "left")
         ->join("TblMsProduk", "TblPODetail.MsProdukId=TblMsProduk.MsProdukId")  
         ->join("TblMsSatuan","TblPODetail.SatuanId=TblMsSatuan.SatuanId")
         ->join("TblSalesDetail", "TblSalesDetail.MsProdukId=TblPODetail.MsProdukId and TblSalesDetail.SalesDetailVarian=TblPODetail.PODetailVarian AND TblSalesDetail.SalesDetailRef=TblPO.SalesRef", "left")
         ->where("POCode", $data["_po"]->POCode)
         ->get("TblPODetail")->result(); 
      echo $this->load->view('message/sales/po/sales_po_edit', $data, TRUE);
   }
   function sales_grpo_add($id)
   {
      $data["_session"] = $this->session->userdata();
      $data["_vendor"] =  $this->db->where("MsVendorIsActive=1")->get("TblMsVendor")->result();
      $data["_po"] =  $this->db->join("TblMsVendor", "TblMsVendor.MsVendorCode=TblPO.MsVendorCode or TblMsVendor.MsVendorId=TblPO.MsVendorId")->where("POId", $id)->get("TblPO")->row();
      $data["_dataworkplace"] =  $this->db->where("MsWorkplaceIsActive=1")->get("TblMsWorkplace")->result();
      $data["_code"] = $this->model_app->get_next_grpo($this->session->userdata("MsWorkplaceId"), date("m"), date("Y"), $this->session->userdata("MsEmpId"));
      echo $this->load->view('message/sales/grpo/grpoadd', $data, TRUE);
   }

   function sales_grpo_edit($id)
   {
      $data["_grpo"] = $this->db
         ->select("*, TblGRPO.MsWorkplaceId")
         ->join("TblMsVendor", "TblGRPO.MsVendorId=TblMsVendor.MsVendorId", "left")
         ->join("TblMsEmployee", "TblGRPO.MsEmpId=TblMsEmployee.MsEmpId", "left")
         ->join("TblPO", "TblPO.POCode=TblGRPO.GRPORef", "left")
         ->where("GRPOId", $id)->get("TblGRPO")->row();
      $data["_sales"] = $this->db
         ->join("TblMsCustomer", "TblSales.MsCustomerId=TblMsCustomer.MsCustomerId", "left")
         ->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblSales.MsEmpId", "left")
         ->join("TblMsWorkplace", "TblSales.MsWorkplaceId=TblMsWorkplace.MsWorkplaceId", "left")
         ->where("SalesCode", $data["_grpo"]->SalesRef)->get("TblSales")->row(); 
      $data["_item"] = $this->db
         ->join("TblGRPO", "TblGRPO.GRPOCode=TblGRPODetail.GRPODetailRef", "left")
         ->join("TblPODetail", "TblPODetail.PODetailRef=TblGRPO.GRPORef and TblPODetail.MsProdukId=TblGRPODetail.MsProdukId and TblPODetail.PODetailVarian=TblGRPODetail.GRPODetailVarian", "left")
         ->join("TblMsProduk", "TblPODetail.MsProdukId=TblMsProduk.MsProdukId")  
         ->join("TblMsSatuan","TblPODetail.SatuanId=TblMsSatuan.SatuanId") 
         ->where("GRPODetailRef =", $data["_grpo"]->GRPOCode)
         ->get("TblGRPODetail")->result();
      $data["_dataworkplace"] =  $this->db->where("MsWorkplaceIsActive=1")->get("TblMsWorkplace")->result();
      $data["_session"] = $this->session->userdata();
      echo $this->load->view('message/sales/grpo/grpoedit', $data, TRUE);
   }



   function sales_performa_add($id,$index)
   {
      $ref = $this->db->where("PaymentId",$index)->get("TblSalesPayment")->row(); 
      $code = $this->model_app->get_single_data("SalesCode", "TblSales", array("SalesId" => $id));
      $total = $this->model_app->get_single_data("SalesGrandTotal", "TblSales", array("SalesId" => $id));
      $customerid = $this->model_app->get_single_data("MsCustomerId", "TblSales", array("SalesId" => $id));
      $customerName = $this->model_app->get_customer_name($customerid);
      $data = $this->db
         ->query("Select SUM(PerformaTotal) as total from TblSalesPerforma Where PerformaRef='" . $code . "'")
         ->row();
      $sisa = $total - $data->total;
      echo $this->load->view('message/sales/performa/sales_performa_add', array("code" => $code, "sisa" => $sisa, "total" => $total, "customer" => $customerName,"ref" => $ref), TRUE);
   }
   function sales_performa_edit($id)
   {
      $data["_data"] = $this->db->where("PerformaId", $id)->get("TblSalesPerforma")->row();
      $data["_total"] = $this->model_app->get_single_data("SalesGrandTotal", "TblSales", array("SalesCode" => $data["_data"]->PerformaRef));
      echo $this->load->view('message/sales/performa/sales_performa_edit', $data, TRUE);
   }
   function sales_performa_success($id)
   {
      $data['_performa'] = $this->db->where("PerformaId", $id)->get("TblSalesPerforma")->row();
      $data['_id'] = $this->model_app->get_single_data("SalesId", "TblSales", array("SalesCode" => $data['_performa']->PerformaRef));
      echo $this->load->view('message/sales/performa/sales_performa_success', $data, TRUE);
   }


   function sales_transfer_out($id)
   {
      $data["_sales"] = $this->db->where("SalesId", $id)->get("TblSales")->row();
      $data["_session"] = $this->session->userdata();
      $data["_store"] = $this->db->where("MsWorkplaceIsActive", 1)->get("TblMsWorkplace")->result();
      $data["_code"] = $this->model_app->get_next_to($this->session->userdata("MsWorkplaceId"), date("m"), date("Y"), $this->session->userdata("MsEmpId"));

      $data["_item"] = $this->db 
         ->join("TblMsSatuan","TblSalesDetail.SatuanId=TblMsSatuan.SatuanId")
         ->join("TblMsProduk","TblMsProduk.MsProdukId=TblSalesDetail.MsProdukId") 
         ->where("SalesDetailRef", $data["_sales"]->SalesCode)
         ->get("TblSalesDetail")->result();

      echo $this->load->view('message/sales/transfer/kirim_add', $data, TRUE);
   }

   function sales_transfer_out_edit($id)
   {
      $data["_transferout"] = $this->db->join("TblSales", "TblSales.SalesCode=TblInvTO.SalesRef")->where("InvTOId", $id)->get("TblInvTO")->row();
      $data["_session"] = $this->session->userdata();
      $data["_store"] = $this->db->where("MsWorkplaceIsActive", 1)->get("TblMsWorkplace")->result();

      $data["_itemref"] = $this->db
         ->join("TblMsSatuan","TblSalesDetail.SatuanId=TblMsSatuan.SatuanId")
         ->join("TblMsProduk","TblMsProduk.MsProdukId=TblSalesDetail.MsProdukId") 
         ->where("SalesDetailRef", $data["_transferout"]->SalesCode)
         ->get("TblSalesDetail")->result();
      $data["_item"] = $this->db
         ->join("TblMsSatuan","TblInvTODetail.SatuanId=TblMsSatuan.SatuanId")
         ->join("TblMsProduk","TblMsProduk.MsProdukId=TblInvTODetail.MsProdukId") 
         ->where("InvTODetailRef", $data["_transferout"]->InvTOCode)
         ->get("TblInvTODetail")->result();

      echo $this->load->view('message/sales/transfer/kirim_edit', $data, TRUE);
   }

   function sales_transfer_in($id)
   {
      $data["_sales"] = $this->db->where("InvTOId", $id)->get("TblInvTO")->row();
      $data["_session"] = $this->session->userdata();
      $data["_store"] = $this->db->where("MsWorkplaceIsActive", 1)->get("TblMsWorkplace")->result();
      $data["_code"] = $this->model_app->get_next_ti($this->session->userdata("MsWorkplaceId"), date("m"), date("Y"), $this->session->userdata("MsEmpId"));

      $data["_item"] = $this->db
         ->join("TblMsItem", "TblInvTODetail.MsItemId=TblMsItem.MsItemId", "left")
         ->join("TblMsVendor", "TblMsVendor.MsVendorCode=TblInvTODetail.MsVendorCode", "left")
         ->join("TblMsItemCategory", "TblMsItemCategory.MsItemCatId=TblMsItem.MsItemCatId", "left")
         ->where("InvTODetailRef", $data["_sales"]->InvTOCode)
         ->get("TblInvTODetail")->result();
      $data["_itemref"] = $this->db
         ->join("TblMsItem", "TblInvTIDetail.MsItemId=TblMsItem.MsItemId", "left")
         ->join("TblMsVendor", "TblMsVendor.MsVendorCode=TblInvTIDetail.MsVendorCode", "left")
         ->join("TblMsItemCategory", "TblMsItemCategory.MsItemCatId=TblMsItem.MsItemCatId", "left")
         ->where("InvTIDetailRef", $data["_sales"]->InvTOCode)
         ->get("TblInvTIDetail")->result();

      echo $this->load->view('message/sales/transfer/terima_add', $data, TRUE);
   }

   function sales_transfer_in_edit($id)
   {
      $data["_transferin"] = $this->db
         ->join("TblInvTO", "TblInvTI.InvTIRef=TblInvTO.InvTOCode", "left")
         ->join("TblSales", "TblSales.SalesCode=TblInvTO.SalesRef", "left")
         ->where("InvTIId", $id)->get("TblInvTI")->row();
      $data["_session"] = $this->session->userdata();
      $data["_store"] = $this->db->where("MsWorkplaceIsActive", 1)->get("TblMsWorkplace")->result();

      $data["_item"] = $this->db
         ->join("TblMsItem", "TblInvTODetail.MsItemId=TblMsItem.MsItemId", "left")
         ->join("TblMsVendor", "TblMsVendor.MsVendorCode=TblInvTODetail.MsVendorCode", "left")
         ->join("TblMsItemCategory", "TblMsItemCategory.MsItemCatId=TblMsItem.MsItemCatId", "left")
         ->where("InvTODetailRef", $data["_transferin"]->InvTOCode)
         ->get("TblInvTODetail")->result();
      $data["_itemref"] = $this->db
         ->join("TblMsItem", "TblInvTIDetail.MsItemId=TblMsItem.MsItemId", "left")
         ->join("TblMsVendor", "TblMsVendor.MsVendorCode=TblInvTIDetail.MsVendorCode", "left")
         ->join("TblMsItemCategory", "TblMsItemCategory.MsItemCatId=TblMsItem.MsItemCatId", "left")
         ->where("InvTIDetailRef", $data["_sales"]->InvTOCode)
         ->get("TblInvTIDetail")->result();

      echo $this->load->view('message/sales/transfer/terima_edit', $data, TRUE);
   }
   
   function kunjungan_add()
   {
      echo $this->load->view('message/sales/kunjungan/kunjungan_add', '', TRUE);
   }
   function kunjungan_edit($id)
   {
      $data["_visitor"] = $this->db->where("VisitorId", $id)->get("TblVisitor")->row();
      echo $this->load->view('message/sales/kunjungan/kunjungan_edit', $data, TRUE);
   }


   function file_upload()
   {
      echo $this->load->view('message/sales/file/upload_file_customer', null, TRUE);
   }
   function file_upload_cs()
   {
      $data["_store"] = $this->input->post("Store");
      $data["_cust"] = $this->input->post("Customer");
      echo $this->load->view('message/sales/file/upload_file', $data, TRUE);
   }
}
