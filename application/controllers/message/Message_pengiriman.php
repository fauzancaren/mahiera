<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Message_pengiriman extends CI_Controller
{
   function __construct()
   {
      parent::__construct();
      $this->load->model('model_app');
      date_default_timezone_set('Asia/Jakarta');
   }

   function proses_pengiriman($id)
   {
      $data["_delivery"] = $this->db
         ->join('TblMsCustomerDelivery', 'TblDelivery.MsCustomerDeliveryId=TblMsCustomerDelivery.MsCustomerDeliveryId', "left")
         ->join('TblSales', 'TblSales.SalesCode=TblDelivery.DeliveryRef', "left")
         ->join('TblMsEmployee', 'TblSales.MsEmpId=TblMsEmployee.MsEmpId', "left")
         ->join('TblMsCustomer', 'TblSales.MsCustomerId=TblMsCustomer.MsCustomerId', "left")
         ->join('TblMsWorkplace', 'TblSales.MsWorkplaceId=TblMsWorkplace.MsWorkplaceId', "left")
         ->join('TblMsDelivery', 'TblDelivery.MsDeliveryId=TblMsDelivery.MsDeliveryId', "left")
         ->where("DeliveryId", $id)
         ->get("TblDelivery")->row();
      $data["_item"] = $this->db
         ->join("TblMsItem", "TblDeliveryDetail.MsItemId=TblMsItem.MsItemId", "left")
         ->join("TblMsVendor", "TblMsVendor.MsVendorCode=TblDeliveryDetail.MsVendorCode", "left")
         ->join("TblMsItemCategory", "TblMsItemCategory.MsItemCatId=TblMsItem.MsItemCatId", "left")
         ->where("DeliveryDetailRef", $data["_delivery"]->DeliveryCode)
         ->get("TblDeliveryDetail")->result();
      $data["_customer"] = $this->model_app->get_customer_name($data["_delivery"]->MsCustomerId);
      echo $this->load->view('message/pengiriman/prosespengiriman', $data, TRUE);
   }
   function selesai_pengiriman($id)
   {
      $data["_delivery"] = $this->db
         ->join('TblMsCustomerDelivery', 'TblDelivery.MsCustomerDeliveryId=TblMsCustomerDelivery.MsCustomerDeliveryId', "left")
         ->join('TblSales', 'TblSales.SalesCode=TblDelivery.DeliveryRef', "left")
         ->join('TblMsEmployee', 'TblSales.MsEmpId=TblMsEmployee.MsEmpId', "left")
         ->join('TblMsCustomer', 'TblSales.MsCustomerId=TblMsCustomer.MsCustomerId', "left")
         ->join('TblMsWorkplace', 'TblSales.MsWorkplaceId=TblMsWorkplace.MsWorkplaceId', "left")
         ->join('TblMsDelivery', 'TblDelivery.MsDeliveryId=TblMsDelivery.MsDeliveryId', "left")
         ->where("DeliveryId", $id)
         ->get("TblDelivery")->row();
      $data["_item"] = $this->db
         ->join("TblDeliverySpare", "TblDeliverySpare.MsItemId=TblDeliveryDetail.MsItemId and TblDeliverySpare.MsVendorCode=TblDeliveryDetail.MsVendorCode", "left")
         ->join("TblMsItem", "TblDeliveryDetail.MsItemId=TblMsItem.MsItemId")
         ->join("TblMsVendor", "TblMsVendor.MsVendorCode=TblDeliveryDetail.MsVendorCode")
         ->join("TblMsItemCategory", "TblMsItemCategory.MsItemCatId=TblMsItem.MsItemCatId")
         ->where("DeliveryDetailRef", $data["_delivery"]->DeliveryCode)
         ->get("TblDeliveryDetail")->result();
      $data["_customer"] = $this->model_app->get_customer_name($data["_delivery"]->MsCustomerId);
      echo $this->load->view('message/pengiriman/selesaipengiriman', $data, TRUE);
   }
   function ganti_pengiriman($id)
   {
      $data["_delivery"] = $this->db->where("DeliveryId", $id)->get("TblDelivery")->row();
      echo $this->load->view('message/pengiriman/gantipengiriman', $data, TRUE);
   }
   function view_pengiriman($id)
   {
      $data["_delivery"] = $this->db
         ->join('TblMsCustomerDelivery', 'TblDelivery.MsCustomerDeliveryId=TblMsCustomerDelivery.MsCustomerDeliveryId', "left")
         ->join('TblSales', 'TblSales.SalesCode=TblDelivery.DeliveryRef', "left")
         ->join('TblMsEmployee', 'TblSales.MsEmpId=TblMsEmployee.MsEmpId', "left")
         ->join('TblMsCustomer', 'TblSales.MsCustomerId=TblMsCustomer.MsCustomerId', "left")
         ->join('TblMsWorkplace', 'TblSales.MsWorkplaceId=TblMsWorkplace.MsWorkplaceId', "left")
         ->join('TblMsDelivery', 'TblDelivery.MsDeliveryId=TblMsDelivery.MsDeliveryId', "left")
         ->where("DeliveryId", $id)
         ->get("TblDelivery")->row();
      $data["_item"] = $this->db
         ->join("TblDeliverySpare", "TblDeliverySpare.MsItemId=TblDeliveryDetail.MsItemId and TblDeliverySpare.MsVendorCode=TblDeliveryDetail.MsVendorCode", "left")
         ->join("TblMsItem", "TblDeliveryDetail.MsItemId=TblMsItem.MsItemId")
         ->join("TblMsVendor", "TblMsVendor.MsVendorCode=TblDeliveryDetail.MsVendorCode")
         ->join("TblMsItemCategory", "TblMsItemCategory.MsItemCatId=TblMsItem.MsItemCatId")
         ->where("DeliveryDetailRef", $data["_delivery"]->DeliveryCode)
         ->get("TblDeliveryDetail")->result();
      $data["_customer"] = $this->model_app->get_customer_name($data["_delivery"]->MsCustomerId);
      echo $this->load->view('message/pengiriman/viewpengiriman', $data, TRUE);
   }

   
   function add_rit_pengiriman()
   { 
      echo $this->load->view('message/pengiriman/addritpengiriman', null, TRUE);
   }
}
