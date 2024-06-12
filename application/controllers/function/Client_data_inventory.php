<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Client_data_inventory extends CI_Controller
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


   function data_to_add()
   {
      $status = true;
      $sales = $this->input->post("data");
      $sales += ["InvTOLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $sales += ["InvTOCreateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->insert('TblInvTO', $sales);
      if (null !== $this->input->post("item")) {
         $dataitem = $this->input->post("item");
         foreach ($dataitem as $row) {
            $this->db->insert('TblInvTODetail', $row);
         }
      }
      echo $status;
      $this->m_inventory->insert_trans_from_to($sales["InvTOCode"]);
      exit;
   }

   function data_to_edit($id)
   {
      $status = true;
      $sales = $this->input->post("data");
      $sales += ["InvTOLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->update('TblInvTO', $sales, array("InvTOId" => $id));
      if (null !== $this->input->post("item")) {
         $dataitem = $this->input->post("item");
         $this->db->delete('TblInvTODetail', array('InvTODetailRef' =>  $sales["InvTOCode"]));
         foreach ($dataitem as $row) {
            $this->db->insert('TblInvTODetail', $row);
         }
      }
      echo $status;
      $this->m_inventory->insert_trans_from_to($sales["InvTOCode"]);
      exit;
   }

   function data_to_delete($id)
   {

      $code = $this->model_app->get_single_data("InvTOCode", "TblInvTO", array("InvTOId" => $id));
      $this->db->delete('TblInvTODetail', array('InvTODetailRef' =>  $code));
      $this->db->delete('TblInvTO', array('InvTOCode' =>  $code));
      $this->m_inventory->delete_trans_plus($code);

      echo ($this->db->affected_rows() != 1 ? "true" : "false");
   }

   function get_data_to($id)
   {
      $dataheader = $this->db->select("*,src.MsWorkplaceId as srcid,src.MsWorkplaceCode as srccode,dst.MsWorkplaceId as dstid,dst.MsWorkplaceCode as dstcode")
         ->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblInvTO.MsEmpId", "left")
         ->join("TblMsWorkplace as src", "src.MsWorkplaceId=TblInvTO.InvTOSrc", "left")
         ->join("TblMsWorkplace as dst", "dst.MsWorkplaceId=TblInvTO.InvTODst", "left")
         ->where("InvTOId", $id)->get("TblInvTO")->row();
      $datadetail = $this->db
         ->join("TblMsItem", "TblMsItem.MsItemId=TblInvTODetail.MsItemId", "left")
         ->join("TblMsItemCategory", "TblMsItemCategory.MsItemCatId=TblMsItem.MsItemCatId", "left")
         ->where("InvTODetailRef", $dataheader->InvTOCode)->get("TblInvTODetail")->result();
      echo json_encode(array(
         "dataheader" => $dataheader,
         "datadetail" => $datadetail
      ));
      exit;
   }

   function data_ti_add()
   {
      $status = true;
      $sales = $this->input->post("data");
      $sales += ["InvTILastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $sales += ["InvTICreateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->insert('TblInvTI', $sales);
      if (null !== $this->input->post("item")) {
         $dataitem = $this->input->post("item");
         foreach ($dataitem as $row) {
            $this->db->insert('TblInvTIDetail', $row);
         }
      }
      $this->db->update("TblInvTO", array("InvTOStatus" => 1), array("InvTOCode" => $sales["InvTIRef"]));
      echo $status;
      $this->m_inventory->insert_trans_from_ti($sales["InvTICode"]);
      exit;
   }
   function data_ti_edit($id)
   {
      $status = true;
      $sales = $this->input->post("data");
      $sales += ["InvTILastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->update('TblInvTI', $sales, array("InvTIId" => $id));
      if (null !== $this->input->post("item")) {
         $dataitem = $this->input->post("item");
         $this->db->delete('TblInvTIDetail', array('InvTIDetailRef' =>  $sales["InvTICode"]));
         foreach ($dataitem as $row) {
            $this->db->insert('TblInvTIDetail', $row);
         }
      }
      echo $status;
      $this->m_inventory->insert_trans_from_ti($sales["InvTICode"]);
      exit;
   }
   function data_ti_delete($id)
   {

      $code = $this->model_app->get_single_data("InvTICode", "TblInvTI", array("InvTIId" => $id));
      $this->db->delete('TblInvTIDetail', array('InvTIDetailRef' =>  $code));
      $this->db->delete('TblInvTI', array('InvTICode' =>  $code));
      $this->m_inventory->delete_trans_min($code);

      echo ($this->db->affected_rows() != 1 ? "true" : "false");
   }

   function data_waste_add()
   {
      $status = true;
      $sales = $this->input->post("data");
      $sales += ["InvWasteLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $sales += ["InvWasteCreateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->insert('TblInvWaste', $sales);
      if (null !== $this->input->post("item")) {
         $dataitem = $this->input->post("item");
         foreach ($dataitem as $row) {
            $this->db->insert('TblInvWasteDetail', $row);
         }
      }
      echo $status;
      $this->m_inventory->insert_trans_from_waste($sales["InvWasteCode"]);
      exit;
   }
   function data_waste_edit($id)
   {
      $status = true;
      $sales = $this->input->post("data");
      $sales += ["InvWasteLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->update('TblInvWaste', $sales, array("InvWasteId" => $id));
      if (null !== $this->input->post("item")) {
         $dataitem = $this->input->post("item");
         $this->db->delete('TblInvWasteDetail', array('InvWasteDetailRef' =>  $sales["InvWasteCode"]));
         foreach ($dataitem as $row) {
            $this->db->insert('TblInvWasteDetail', $row);
         }
      }
      echo $status;
      $this->m_inventory->insert_trans_from_waste($sales["InvWasteCode"]);
      exit;
   }
   function data_waste_delete($id)
   {
      $code = $this->model_app->get_single_data("InvWasteCode", "TblInvWaste", array("InvWasteId" => $id));
      $this->db->delete('TblInvWasteDetail', array('InvWasteDetailRef' =>  $code));
      $this->db->delete('TblInvWaste', array('InvWasteCode' =>  $code));
      $this->m_inventory->delete_trans_plus($code);

      echo ($this->db->affected_rows() != 1 ? "true" : "false");
   }

   function data_sample_add()
   {
      $status = true;
      $sales = $this->input->post("data");
      $sales += ["InvSampleLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $sales += ["InvSampleCreateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->insert('TblInvSample', $sales);
      if (null !== $this->input->post("item")) {
         $dataitem = $this->input->post("item");
         foreach ($dataitem as $row) {
            $this->db->insert('TblInvSampleDetail', $row);
         }
      }
      echo $status;
      $this->m_inventory->insert_trans_from_sample($sales["InvSampleCode"]);
      exit;
   }
   function data_sample_edit($id)
   {
      $status = true;
      $sales = $this->input->post("data");
      $sales += ["InvSampleLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->update('TblInvSample', $sales, array("InvSampleId" => $id));
      if (null !== $this->input->post("item")) {
         $dataitem = $this->input->post("item");
         $this->db->delete('TblInvSampleDetail', array('InvSampleDetailRef' =>  $sales["InvSampleCode"]));
         foreach ($dataitem as $row) {
            $this->db->insert('TblInvSampleDetail', $row);
         }
      }
      echo $status;
      $this->m_inventory->insert_trans_from_sample($sales["InvSampleCode"]);
      exit;
   }
   function data_sample_delete($id)
   {
      $code = $this->model_app->get_single_data("InvSampleCode", "TblInvSample", array("InvSampleId" => $id));
      $this->db->delete('TblInvSampleDetail', array('InvSampleDetailRef' =>  $code));
      $this->db->delete('TblInvSample', array('InvSampleCode' =>  $code));
      $this->m_inventory->delete_trans_plus($code);

      echo ($this->db->affected_rows() != 1 ? "true" : "false");
   }

   function buffer_stock($id)
   {
      $this->db->update('TblInvStock', $this->input->post(), array("InvStockId" => $id));
      echo true;
      exit;
   }
   function get_data_stock($id)
   {
      $dataheader =  $this->db->join("TblMsItem", "TblMsItem.MsItemId=TblInvStock.MsItemId", "left")
         ->join("TblMsVendor", "TblMsVendor.MsVendorId=TblInvStock.MsVendorId", "left")
         ->join("TblMsWorkplace", "TblMsWorkplace.MsWorkplaceId=TblInvStock.MsWorkplaceId", "left")
         ->where("TblInvStock.MsWorkplaceId", $id)->get("TblInvStock")->result();
      echo json_encode($dataheader);
      exit;
   }
   function data_so_add()
   {
      $status = true;
      $sales = $this->input->post("data");
      $sales += ["InvSOLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $sales += ["InvSOCreateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->insert('TblInvSO', $sales);
      if (null !== $this->input->post("item")) {
         $dataitem = $this->input->post("item");
         foreach ($dataitem as $row) {
            $this->db->insert('TblInvSODetail', $row);
         }
      }
      echo $status;
      $this->m_inventory->insert_trans_from_so($sales["InvSOCode"]);
      exit;
   }

   function data_produksi_add(){
      
      $status = true;
      $sales = $this->input->post("data");
      $sales += ["ProduksiLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $sales += ["ProduksiCreateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->insert('TblProduksi', $sales);
      $this->data_produksi_po_update($sales["ProduksiRef"]);
      echo $status;
      exit;
   }


   function data_produksi_cetak(){
      
      $status = true;
      $sales = $this->input->post("data");
      $sales += ["ProduksiLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $sales += ["ProduksiCreateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->insert('TblProduksi', $sales);
      if (null !== $this->input->post("detail")){
         $dataitem = $this->input->post("detail");
         foreach ($dataitem as $row) {
            $this->db->insert('TblProduksiDetail', $row);
         }
      }
      $this->data_produksi_po_update($sales["ProduksiRef"]); 
      $this->m_inventory->insert_trans_from_produksi_detail($sales["ProduksiCode"]);
      echo $status;
      exit;
   }
   function data_produksi_cetak_edit(){ 
      $status = true;
      $sales = $this->input->post("data");
      $sales += ["ProduksiLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->update('TblProduksi', $sales,array("ProduksiCode" => $this->input->post("code")));
      if (null !== $this->input->post("detail")){
         $this->db->delete("TblProduksiDetail",array("ProduksiDetailRef" => $this->input->post("code")));
         $dataitem = $this->input->post("detail");
         foreach ($dataitem as $row) {
            $this->db->insert('TblProduksiDetail', $row);
         }
      }
      $this->data_produksi_po_update($sales["ProduksiRef"]); 
      $this->m_inventory->insert_trans_from_produksi_detail($this->input->post("code"));
      echo $status;
      exit;
   }

   function data_produksi_kering(){ 
      $status = true;
      $sales = $this->input->post("data");
      $sales += ["ProduksiLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->update('TblProduksi', $sales,array("ProduksiCode" => $this->input->post("code")));
      if (null !== $this->input->post("detail")){
         $this->db->delete("TblProduksiDetail",array("ProduksiDetailRef" => $this->input->post("code")));
         $dataitem = $this->input->post("detail");
         foreach ($dataitem as $row) {
            $this->db->insert('TblProduksiDetail', $row);
         }
      }
      $this->data_produksi_po_update($sales["ProduksiRef"]); 
      $this->m_inventory->insert_trans_from_produksi_detail($this->input->post("code"));
      echo $status;
      exit;
   }
   function data_produksi_ready(){ 
      $status = true;
      $sales = $this->input->post("data");
      $sales += ["ProduksiLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->update('TblProduksi', $sales,array("ProduksiCode" => $this->input->post("code")));
      if (null !== $this->input->post("detail")){
         $this->db->delete("TblProduksiDetail",array("ProduksiDetailRef" => $this->input->post("code")));
         $dataitem = $this->input->post("detail");
         foreach ($dataitem as $row) {
            $this->db->insert('TblProduksiDetail', $row);
         }
      }
      $this->data_produksi_po_update($sales["ProduksiRef"]); 
      $this->m_inventory->insert_trans_from_produksi_detail($this->input->post("code"));
      $this->m_inventory->insert_trans_from_produksi($this->input->post("code"));
      echo $status;
      exit;
   }

   function data_produksi_po_update($refcode = "ALY/XIII/03/PO-0044/11/IX/2022"){
      $detail = $this->db->where("PODetailRef",$refcode)->get("TblPODetail")->result();
      $totalpo = 0;
      $totalready = 0;
      $totalproses = 0;
      foreach($detail as $row){
         $totalpo += $row->PODetailQty;
         $detailready = $this->db
            ->where("ProduksiRef",$row->PODetailRef)
            ->where("MsVendorCode",$row->MsVendorCode)
            ->where("MsItemId",$row->MsItemId)
            ->get("TblProduksi")->result();
         foreach($detailready as $rowdetail){
            if($rowdetail->ProduksiStatus==2){
               $totalready += $rowdetail->ProduksiQty; 
            }else{
               $totalproses += $rowdetail->ProduksiQty; 
            } 
         }
      }
      if(( $totalready+ $totalproses) > 0){ 
         $this->db->update("TblPO",array("POStatus"=>1),array("POCode"=>$refcode));
      }
      if($totalpo <= $totalready){ 
         $this->db->update("TblPO",array("POStatus"=>2),array("POCode"=>$refcode));
      }

      
   }

}
