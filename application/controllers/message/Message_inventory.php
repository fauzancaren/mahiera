<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Message_inventory extends CI_Controller
{
   function __construct()
   {
      parent::__construct();
      $this->load->model('model_app');
      date_default_timezone_set('Asia/Jakarta');
   }
   function stock_view($id)
   {
      $data["_dataitem"] = $this->db->join("TblMsItem", "TblMsItem.MsItemId=TblInvStock.MsItemId", "left")
         ->join("TblMsVendor", "TblMsVendor.MsVendorId=TblInvStock.MsVendorId", "left")
         ->join("TblMsItemCategory", "TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId", "left")
         ->join("TblMsWorkplace", "TblMsWorkplace.MsWorkplaceId=TblInvStock.MsWorkplaceId", "left")
         ->where("InvStockId", $id)->get("TblInvStock")->row();
      echo $this->load->view('message/inventory/stockview', $data, TRUE);
   }

   function transfer_out()
   {
      $data["_session"] = $this->session->userdata();
      $data["_store"] = $this->db->where("MsWorkplaceIsActive", 1)->where("msWorkplaceType", 0)->get("TblMsWorkplace")->result();
      $data["_code"] = $this->model_app->get_next_to($this->session->userdata("MsWorkplaceId"), date("m"), date("Y"), $this->session->userdata("MsEmpId"));
      echo $this->load->view('message/inventory/toadd', $data, TRUE);
   }
   function transfer_out_edit($id)
   {
      $data["_data"] = $this->db->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblInvTO.MsEmpId", "left")->where("InvTOId", $id)->get("TblInvTO")->row();
      $data["_detail"] = $this->db->join("TblMsItem", "TblMsItem.MsItemId=TblInvTODetail.MsItemId")->where("InvTODetailRef", $data["_data"]->InvTOCode)->get("TblInvTODetail")->result();
      $data["_session"] = $this->session->userdata();
      $data["_store"] = $this->db->where("MsWorkplaceIsActive", 1)->where("msWorkplaceType", 0)->get("TblMsWorkplace")->result();
      echo $this->load->view('message/inventory/toedit', $data, TRUE);
   }
   function transfer_in()
   {
      $data["_session"] = $this->session->userdata();
      $data["_store"] = $this->db->where("MsWorkplaceIsActive", 1)->where("msWorkplaceType", 0)->get("TblMsWorkplace")->result();
      $data["_code"] = $this->model_app->get_next_ti($this->session->userdata("MsWorkplaceId"), date("m"), date("Y"), $this->session->userdata("MsEmpId"));
      echo $this->load->view('message/inventory/tiadd', $data, TRUE);
   }
   function transfer_in_edit($id)
   {
      $data["_data"] = $this->db->select("*,(select MsWorkplaceCode from TblMsWorkplace where MsWorkplaceId=InvTIDst) as DstCode,(select MsWorkplaceCode from TblMsWorkplace where MsWorkplaceId=InvTISrc) as SrcCode")
         ->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblInvTI.MsEmpId", "left")->where("InvTIId", $id)->get("TblInvTI")->row();
      $data["_detail"] = $this->db->join("TblMsItem", "TblMsItem.MsItemId=TblInvTIDetail.MsItemId")->where("InvTIDetailRef", $data["_data"]->InvTICode)->get("TblInvTIDetail")->result();
      $data["_session"] = $this->session->userdata();
      $data["_store"] = $this->db->where("MsWorkplaceIsActive", 1)->where("msWorkplaceType", 0)->get("TblMsWorkplace")->result();
      echo $this->load->view('message/inventory/tiedit', $data, TRUE);
   }
   function item_waste()
   {
      $data["_session"] = $this->session->userdata();
      $data["_store"] = $this->db->where("MsWorkplaceIsActive", 1)->where("msWorkplaceType", 0)->get("TblMsWorkplace")->result();
      $data["_code"] = $this->model_app->get_next_iw($this->session->userdata("MsWorkplaceId"), date("m"), date("Y"), $this->session->userdata("MsEmpId"));
      echo $this->load->view('message/inventory/wasteadd', $data, TRUE);
   }
   function item_waste_edit($id)
   {
      $data["_data"] = $this->db->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblInvWaste.MsEmpId", "left")->where("InvWasteId", $id)->get("TblInvWaste")->row();
      $data["_detail"] = $this->db->join("TblMsItem", "TblMsItem.MsItemId=TblInvWasteDetail.MsItemId")->where("InvWasteDetailRef", $data["_data"]->InvWasteCode)->get("TblInvWasteDetail")->result();
      $data["_session"] = $this->session->userdata();
      $data["_store"] = $this->db->where("MsWorkplaceIsActive", 1)->where("msWorkplaceType", 0)->get("TblMsWorkplace")->result();
      echo $this->load->view('message/inventory/wasteedit', $data, TRUE);
   }
   function item_sample()
   {
      $data["_session"] = $this->session->userdata();
      $data["_store"] = $this->db->where("MsWorkplaceIsActive", 1)->where("msWorkplaceType", 0)->get("TblMsWorkplace")->result();
      $data["_code"] = $this->model_app->get_next_is($this->session->userdata("MsWorkplaceId"), date("m"), date("Y"), $this->session->userdata("MsEmpId"));
      echo $this->load->view('message/inventory/sampleadd', $data, TRUE);
   }
   function item_sample_edit($id)
   {
      $data["_data"] = $this->db->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblInvSample.MsEmpId", "left")->join("TblMsCustomer", "TblMsCustomer.MsCustomerId=TblInvSample.MsCustomerId", "left")->where("InvSampleId", $id)->get("TblInvSample")->row();
      $data["_customer"] = $this->model_app->get_customer_name($data["_data"]->MsCustomerId);
      $data["_detail"] = $this->db->join("TblMsItem", "TblMsItem.MsItemId=TblInvSampleDetail.MsItemId")->where("InvSampleDetailRef", $data["_data"]->InvSampleCode)->get("TblInvSampleDetail")->result();
      $data["_session"] = $this->session->userdata();
      $data["_store"] = $this->db->where("MsWorkplaceIsActive", 1)->where("MsWorkplaceType", 0)->get("TblMsWorkplace")->result();
      echo $this->load->view('message/inventory/sampleedit', $data, TRUE);
   }
   function stock_opname()
   {
      $data["_session"] = $this->session->userdata();
      $data["_store"] = $this->db->where("MsWorkplaceIsActive", 1)->get("TblMsWorkplace")->result();
      $data["_code"] = $this->model_app->get_next_so($this->session->userdata("MsWorkplaceId"), date("m"), date("Y"), $this->session->userdata("MsEmpId"));
      echo $this->load->view('message/inventory/stockopnameadd', $data, TRUE);
   }
   function item_history($id)
   {

     
      $item = $this->db->join("TblMsProduk","TblMsProdukStock.MsProdukId=TblMsProduk.MsProdukId","left")
         ->join("TblMsItemCategory","TblMsItemCategory.MsItemCatId=TblMsProduk.MsProdukCatId","left")
         ->join("TblMsWorkplace","TblMsWorkplace.MsWorkplaceId=TblMsProdukStock.MsWorkplaceId","left") 
         ->select("*,TblMsProdukStock.MsProdukVarian")
         ->where("MsProdukStockId",$id)->get("TblMsProdukStock")->row();

      if (file_exists(getcwd() . "/asset/image/produk/" .  $item->MsProdukId."/".$item->MsProdukCode."_1.png")) {
         $urlimage = base_url("asset/image/produk/".$item->MsProdukId."/".$item->MsProdukCode."_1.png");
      }else{ 
         $urlimage = base_url("asset/image/mgs-erp/defaultitem.png");
      }  


      //getDetail Varian
      $datavarian = explode("|",$item->MsProdukVarian);
      $this->db->join("TblMsSatuan","TblMsSatuan.SatuanId=TblMsProdukDetail.SatuanId");
      for($i = 0; count($datavarian)>$i;$i++){
         $this->db->like('REPLACE(lower(MsProdukDetailVarian)," ","")', str_replace(" ","",strtolower($datavarian[$i])));
      } 
      $datadetail = $this->db->get("TblMsProdukDetail")->row_array();


      $row = array();
      $row["MsProdukId"] = $item->MsProdukId;
      $row["MsProdukCode"] = $item->MsProdukCode;
      $row["MsProdukName"] = $item->MsProdukName;
      $row["MsProdukCategory"] = $item->MsItemCatName;
      $row["MsWorkplaceCode"] = $item->MsWorkplaceCode;
      $row["MsProdukVarian"] = $item->MsProdukVarian;
      $row["MsProdukImage"] = $urlimage;   
      $row["MsProdukStockId"] = $item->MsProdukStockId;
      $row["MsProdukStockQty"] = $item->MsProdukStockQty;
      $row["detail"] = $datadetail;
      $data["_item"] = $row;


      $data["_session"] = $this->session->userdata();
      $data["_store"] = $this->db->where("MsWorkplaceIsActive", 1)->where("msWorkplaceType", 0)->get("TblMsWorkplace")->result(); 
      echo $this->load->view('message/inventory/item_history', $data, TRUE);
   } 

   function buffer_edit($id)
   {
      $data["_data"] = $this->db->where("InvStockId", $id)->get("TblInvStock")->row();
      echo $this->load->view('message/inventory/bufferstock', $data, TRUE);
   }


   function ready_stock_code(){
      echo $this->model_app->get_next_pd($this->input->post("workplace"),$this->input->post("month"),$this->input->post("year"),$this->input->post("EmpId"));
   }
   function ready_stock()
   {
     // $data["_data"] = $this->db->where("InvStockId", $id)->get("TblInvStock")->row();
      $data["_session"] = $this->session->userdata();
      $data["_store"] = $this->db->where("MsWorkplaceType",1)->where("MsWorkplaceIsActive", 1)->get("TblMsWorkplace")->result(); 
      $data["_dataitem"] = $this->db
         ->join("TblMsItem","TblMsItem.MsItemId=TblPODetail.MsItemId")
         ->where("TblMsItem.MsItemId",$this->input->post("item"))
         ->where("MsVendorCode",$this->input->post("vendor"))
         ->where("PODetailRef",$this->input->post("code"))
         ->get("TblPODetail")->row();
      echo $this->load->view('message/inventory/readystock', $data, TRUE);
   }

   function cek_item_bom(){
      $result = $this->db
         ->where("MsItemId",$this->input->post("item"))
         ->where("MsVendorCode",$this->input->post("vendor"))
         ->get("TblMsItemBom")->row();
      if($result){
         echo "true";
      }else{
         echo "false";
      }
   }
   function proses_cetak()
   {
     // $data["_data"] = $this->db->where("InvStockId", $id)->get("TblInvStock")->row();
      $data["_session"] = $this->session->userdata();
      $data["_store"] = $this->db->where("MsWorkplaceType",1)->where("MsWorkplaceIsActive", 1)->get("TblMsWorkplace")->result(); 
      $data["_dataitem"] = $this->db
         ->join("TblMsItem","TblMsItem.MsItemId=TblPODetail.MsItemId")
         ->where("TblMsItem.MsItemId",$this->input->post("item"))
         ->where("MsVendorCode",$this->input->post("vendor"))
         ->where("PODetailRef",$this->input->post("code"))
         ->get("TblPODetail")->row();
      $data["_databom"] = $this->db
         ->join("TblMsItemBomDetail","TblMsItemBom.MsItemBomId=TblMsItemBomDetail.MsItemBomId")
         ->join("TblMsItem","TblMsItemBomDetail.MsItemId=TblMsItem.MsItemId")
         ->where("TblMsItemBom.MsItemId",$this->input->post("item"))
         ->where("TblMsItemBom.MsVendorCode",$this->input->post("vendor"))
         ->get("TblMsItemBom")->result();
      echo $this->load->view('message/inventory/prosescetak', $data, TRUE);
   }
   function proses_cetak_edit($id)
   {
     // $data["_data"] = $this->db->where("InvStockId", $id)->get("TblInvStock")->row();
      $data["_session"] = $this->session->userdata();
      $data["_store"] = $this->db->where("MsWorkplaceType",1)->where("MsWorkplaceIsActive", 1)->get("TblMsWorkplace")->result(); 
      $data["_dataproduksi"] = $this->db
         ->join("TblMsItem","TblMsItem.MsItemId=TblProduksi.MsItemId")
         ->join("TblPODetail","PODetailRef=ProduksiRef and TblPODetail.MsItemId=TblProduksi.MsItemId and TblPODetail.MsVendorCode=TblProduksi.MsVendorCode")
         ->where("ProduksiId",$id) 
         ->get("TblProduksi")->row();
      $data["_databom"] = $this->db 
         ->join("TblMsItem","TblProduksiDetail.MsItemId=TblMsItem.MsItemId")
         ->where("ProduksiDetailRef",$data["_dataproduksi"]->ProduksiCode) 
         ->get("TblProduksiDetail")->result();
      echo $this->load->view('message/inventory/prosescetakedit', $data, TRUE);
   }
   function proses_kering($id)
   {
     // $data["_data"] = $this->db->where("InvStockId", $id)->get("TblInvStock")->row();
      $data["_session"] = $this->session->userdata();
      $data["_store"] = $this->db->where("MsWorkplaceType",1)->where("MsWorkplaceIsActive", 1)->get("TblMsWorkplace")->result(); 
      $data["_dataproduksi"] = $this->db
         ->join("TblMsItem","TblMsItem.MsItemId=TblProduksi.MsItemId")
         ->join("TblPODetail","PODetailRef=ProduksiRef and TblPODetail.MsItemId=TblProduksi.MsItemId and TblPODetail.MsVendorCode=TblProduksi.MsVendorCode")
         ->where("ProduksiId",$id) 
         ->get("TblProduksi")->row();
      $data["_databom"] = $this->db 
         ->join("TblMsItem","TblProduksiDetail.MsItemId=TblMsItem.MsItemId")
         ->where("ProduksiDetailRef",$data["_dataproduksi"]->ProduksiCode) 
         ->get("TblProduksiDetail")->result();
      echo $this->load->view('message/inventory/proseskering', $data, TRUE);
   }
   function proses_kering_edit($id)
   {
     // $data["_data"] = $this->db->where("InvStockId", $id)->get("TblInvStock")->row();
      $data["_session"] = $this->session->userdata();
      $data["_store"] = $this->db->where("MsWorkplaceType",1)->where("MsWorkplaceIsActive", 1)->get("TblMsWorkplace")->result(); 
      $data["_dataproduksi"] = $this->db
         ->join("TblMsItem","TblMsItem.MsItemId=TblProduksi.MsItemId")
         ->join("TblPODetail","PODetailRef=ProduksiRef and TblPODetail.MsItemId=TblProduksi.MsItemId and TblPODetail.MsVendorCode=TblProduksi.MsVendorCode")
         ->where("ProduksiId",$id) 
         ->get("TblProduksi")->row();
      $data["_databom"] = $this->db 
         ->join("TblMsItem","TblProduksiDetail.MsItemId=TblMsItem.MsItemId")
         ->where("ProduksiDetailRef",$data["_dataproduksi"]->ProduksiCode) 
         ->get("TblProduksiDetail")->result();
      echo $this->load->view('message/inventory/proseskeringedit', $data, TRUE);
   }

   function proses_ready($id)
   {
     // $data["_data"] = $this->db->where("InvStockId", $id)->get("TblInvStock")->row();
      $data["_session"] = $this->session->userdata();
      $data["_store"] = $this->db->where("MsWorkplaceType",1)->where("MsWorkplaceIsActive", 1)->get("TblMsWorkplace")->result(); 
      $data["_dataproduksi"] = $this->db
         ->join("TblMsItem","TblMsItem.MsItemId=TblProduksi.MsItemId")
         ->join("TblPODetail","PODetailRef=ProduksiRef and TblPODetail.MsItemId=TblProduksi.MsItemId and TblPODetail.MsVendorCode=TblProduksi.MsVendorCode")
         ->where("ProduksiId",$id) 
         ->get("TblProduksi")->row();
      $data["_databom"] = $this->db 
         ->join("TblMsItem","TblProduksiDetail.MsItemId=TblMsItem.MsItemId")
         ->where("ProduksiDetailRef",$data["_dataproduksi"]->ProduksiCode) 
         ->get("TblProduksiDetail")->result();
      echo $this->load->view('message/inventory/prosesready', $data, TRUE);
   }
}
