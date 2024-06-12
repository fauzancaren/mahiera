<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Message_pembelian extends CI_Controller
{
   function __construct()
   {
      parent::__construct();
      $this->load->model('model_app');

      date_default_timezone_set('Asia/Jakarta');
   }
   function po_add()
   {
      $data["_session"] = $this->session->userdata();
      $data["_vendor"] =  $this->db->where("MsVendorIsActive=1")->get("TblMsVendor")->result();
      $data["_code"] = $this->model_app->get_next_po($this->session->userdata("MsWorkplaceId"), date("m"), date("Y"), $this->session->userdata("MsEmpId"));
      echo $this->load->view('message/pembelian/poadd', $data, TRUE);
   }

   function po_edit($id)
   {
      $data["_data"] = $this->db->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblPO.MsEmpId")->join("TblMsVendor", "TblMsVendor.MsVendorId=TblPO.MsVendorId")->where("POId", $id)->get("TblPO")->row();
      $data["_vendor"] =  $this->db->where("MsVendorIsActive=1")->get("TblMsVendor")->result();
      $data["_detail"] = $this->db->join("TblMsItem", "TblMsItem.MsItemId=TblPODetail.MsItemId")->where("PODetailRef", $data["_data"]->POCode)->get("TblPODetail")->result();
      echo $this->load->view('message/pembelian/poedit', $data, TRUE);
   }

   function grpo_add()
   {
      $data["_workplace"] = $this->session->userdata("MsWorkplaceId");
      $data["_MsEmpName"] = $this->session->userdata("MsEmpName");
      $data["_vendor"] =  $this->db->where("MsVendorIsActive=1")->get("TblMsVendor")->result();
      $data["_dataworkplace"] =  $this->db->where("MsWorkplaceIsActive=1")->get("TblMsWorkplace")->result();
      $data["_code"] = $this->model_app->get_next_grpo($this->session->userdata("MsWorkplaceId"), date("m"), date("Y"), $this->session->userdata("MsEmpId"));
      echo $this->load->view('message/pembelian/grpoadd', $data, TRUE);
   }
   function grpo_edit($id)
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
         ->join("TblMsItem", "TblGRPODetail.MsItemId=TblMsItem.MsItemId", "left")
         ->join("TblMsItemCategory", "TblMsItemCategory.MsItemCatId=TblMsItem.MsItemCatId", "left")
         ->where("GRPODetailRef", $data["_grpo"]->GRPOCode)
         ->get("TblGRPODetail")->result();

      $data["_dataworkplace"] =  $this->db->where("MsWorkplaceIsActive=1")->get("TblMsWorkplace")->result();
      $data["_session"] = $this->session->userdata();
      echo $this->load->view('message/pembelian/grpoedit', $data, TRUE);
   }

   function po_grpo_add($id)
   {
      $data["_session"] = $this->session->userdata();
      $data["_vendor"] =  $this->db->where("MsVendorIsActive=1")->get("TblMsVendor")->result();
      $data["_po"] =  $this->db->join("TblMsVendor", "TblMsVendor.MsVendorId=TblPO.MsVendorId")->where("POId", $id)->get("TblPO")->row();
      $data["_dataworkplace"] =  $this->db->where("MsWorkplaceIsActive=1")->get("TblMsWorkplace")->result();
      $data["_code"] = $this->model_app->get_next_grpo($this->session->userdata("MsWorkplaceId"), date("m"), date("Y"), $this->session->userdata("MsEmpId"));
      echo $this->load->view('message/pembelian/grpoadd_po', $data, TRUE);
   }
   function po_grpo_edit($id)
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
         ->join("TblMsItem", "TblGRPODetail.MsItemId=TblMsItem.MsItemId", "left")
         ->join("TblMsItemCategory", "TblMsItemCategory.MsItemCatId=TblMsItem.MsItemCatId", "left")
         ->where("GRPODetailRef", $data["_grpo"]->GRPOCode)
         ->get("TblGRPODetail")->result();

      $data["_dataworkplace"] =  $this->db->where("MsWorkplaceIsActive=1")->get("TblMsWorkplace")->result();
      $data["_session"] = $this->session->userdata();
      echo $this->load->view('message/pembelian/grpoedit_po', $data, TRUE);
   }
   function po_delivery_add($id)
   {
      $data["_session"] = $this->session->userdata();
      $data["_dataref"] = $this->db
         ->select("*, TblPO.SalesRef, TblPO.MsEmpId, TblPO.MsWorkplaceId")
         ->join("TblMsWorkplace", "TblMsWorkplace.MsWorkplaceId=TblPO.MsWorkplaceId", "left")
         ->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblPO.MsEmpId", "left")
         ->join("TblSales", "TblSales.SalesCode=TblPO.SalesRef", "left")
         ->where("POId", $id)->get("TblPO")->row();
      $data["_item"] = $this->db
         ->join("TblMsItem", "TblPODetail.MsItemId=TblMsItem.MsItemId", "left")
         ->join("TblMsVendor", "TblMsVendor.MsVendorCode=TblPODetail.MsVendorCode", "left")
         ->join("TblMsItemCategory", "TblMsItemCategory.MsItemCatId=TblMsItem.MsItemCatId", "left")
         ->where("PODetailRef", $data["_dataref"]->POCode)
         ->get("TblPODetail")->result();
      $data["_itemdelivery"] = $this->db
         ->join("TblMsItem", "TblDeliveryDetail.MsItemId=TblMsItem.MsItemId")
         ->join("TblMsVendor", "TblMsVendor.MsVendorCode=TblDeliveryDetail.MsVendorCode")
         ->join("TblMsItemCategory", "TblMsItemCategory.MsItemCatId=TblMsItem.MsItemCatId")
         ->join("TblDelivery", "TblDelivery.DeliveryCode=TblDeliveryDetail.DeliveryDetailRef")
         ->where("DeliveryRef2", $data["_dataref"]->POCode)
         ->get("TblDeliveryDetail")->result();

      echo $this->load->view('message/pembelian/delivery_po', $data, TRUE);
   }
   function po_delivery_edit($id)
   {
      $data["_delivery"] = $this->db
         ->join("TblMsWorkplace", "TblDelivery.MsWorkplaceId=TblMsWorkplace.MsWorkplaceId")
         ->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblDelivery.MsEmpId")
         ->where("DeliveryId", $id)->get("TblDelivery")->row();

      $data["_po"] = $this->db->where("POCode", $data["_delivery"]->DeliveryRef2)->get("TblPO")->row();
      $data["_podetail"] = $this->db->where("PODetailRef", $data["_delivery"]->DeliveryRef2)->get("TblPODetail")->result();
      if ($data["_delivery"]->DeliveryRef != "") {
         $data["_sales"] = $this->db
            ->join("TblMsCustomer", "TblSales.MsCustomerId=TblMsCustomer.MsCustomerId")
            ->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblSales.MsEmpId")
            ->join("TblMsWorkplace", "TblSales.MsWorkplaceId=TblMsWorkplace.MsWorkplaceId")
            ->where("SalesCode", $data["_delivery"]->DeliveryRef)->get("TblSales")->row();
      } else {
         $data["_sales"] = null;
      }

      $data["_itemdelivery"] = $this->db
         ->join("TblMsItem", "TblDeliveryDetail.MsItemId=TblMsItem.MsItemId")
         ->join("TblMsVendor", "TblMsVendor.MsVendorCode=TblDeliveryDetail.MsVendorCode")
         ->join("TblMsItemCategory", "TblMsItemCategory.MsItemCatId=TblMsItem.MsItemCatId")
         ->join("TblDelivery", "TblDelivery.DeliveryCode=TblDeliveryDetail.DeliveryDetailRef")
         ->where("DeliveryRef2", $data["_delivery"]->DeliveryRef2)
         ->where("DeliveryId !=", $id)
         ->get("TblDeliveryDetail")->result();

      $data["_detaildelivery"] = $this->db
         ->join("TblMsItem", "TblDeliveryDetail.MsItemId=TblMsItem.MsItemId")
         ->join("TblMsVendor", "TblMsVendor.MsVendorCode=TblDeliveryDetail.MsVendorCode")
         ->join("TblMsItemCategory", "TblMsItemCategory.MsItemCatId=TblMsItem.MsItemCatId")
         ->join("TblDelivery", "TblDelivery.DeliveryCode=TblDeliveryDetail.DeliveryDetailRef")
         ->where("DeliveryCode", $data["_delivery"]->DeliveryCode)
         ->get("TblDeliveryDetail")->result();
      echo $this->load->view('message/pembelian/delivery_po_edit', $data, TRUE);
   }
   function po_delivery_proses($id)
   {
      $data["_delivery"] = $this->db
         ->join("TblMsWorkplace", "TblDelivery.MsWorkplaceId=TblMsWorkplace.MsWorkplaceId")
         ->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblDelivery.MsEmpId")
         ->where("DeliveryId", $id)->get("TblDelivery")->row();
      $data["_detaildelivery"] = $this->db
         ->join("TblMsItem", "TblDeliveryDetail.MsItemId=TblMsItem.MsItemId")
         ->join("TblMsVendor", "TblMsVendor.MsVendorCode=TblDeliveryDetail.MsVendorCode")
         ->join("TblMsItemCategory", "TblMsItemCategory.MsItemCatId=TblMsItem.MsItemCatId")
         ->join("TblDelivery", "TblDelivery.DeliveryCode=TblDeliveryDetail.DeliveryDetailRef")
         ->where("DeliveryCode", $data["_delivery"]->DeliveryCode)
         ->get("TblDeliveryDetail")->result();
      echo $this->load->view('message/pembelian/delivery_po_proses', $data, TRUE);
   }
}
