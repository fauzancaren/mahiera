<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Client_data_pembelian extends CI_Controller
{
   function __construct()
   {
      parent::__construct();
      $this->load->model('model_app');
      $this->load->model('inventory/Model_inventory', 'm_inventory');
      date_default_timezone_set('Asia/Jakarta');
   }
   function get_next_po()
   {
      echo $this->model_app->get_next_po($this->input->post("MsWorkplaceId"), $this->input->post("Month"), $this->input->post("Year"), $this->input->post("MsEmpId"));
   }
   function get_next_delivery()
   {
      echo $this->model_app->get_next_delivery($this->input->post("MsWorkplaceId"), $this->input->post("Month"), $this->input->post("Year"), $this->input->post("MsEmpId"));
   }
   function data_po_add()
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
         }
      }
      echo $status;

      if ($sales["SalesRef"] == "") exit;
      /* --------------   CEK STATUS ----------------- */
      $data_sales = $this->db
         ->join("TblMsVendor", "TblMsVendor.MsVendorCode = TblSalesDetail.MsVendorCode")
         ->where("SalesDetailType", 0)
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
   function data_po_delete($id)
   {

      $code = $this->model_app->get_single_data("POCode", "TblPO", array("POId" => $id));
      $this->db->delete('TblPODetail', array('PODetailRef' =>  $code));
      $this->db->delete('TblPO', array('POCode' =>  $code));

      echo ($this->db->affected_rows() != 1 ? "true" : "false");
   }
   function data_po_edit($id)
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
         ->where("SalesDetailType", 0)
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

   function sales_ref($id, $vendor)
   {
      $dataSales = $this->db
         ->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblSales.MsEmpId", "left")
         ->join("TblMsCustomer", "TblSales.MsCustomerId=TblMsCustomer.MsCustomerId", "left")
         ->where("SalesId", $id)->get("TblSales")->row();

      $sales_telp = (($dataSales->MsCustomerTelp2 == "" || $dataSales->MsCustomerTelp2 == "-") ? $dataSales->MsCustomerTelp1 : $dataSales->MsCustomerTelp1 . " / " . $dataSales->MsCustomerTelp2);
      $customercard = '
                  <div class="card shadow-sm card-delivery select">   
                     <div class="p-2 ps-4">      
                        <span class="card-title fw-bold">' . $dataSales->MsCustomerCode . ' - ' . $this->model_app->get_customer_name($dataSales->MsCustomerId) . '</span><br>      
                        <span class="card-text">' . $sales_telp . '</span><br>      
                        <span class="card-text">' . $dataSales->MsCustomerAddress . '</span><br>   
                        <span class="card-text fw-bold">Admin : ' . $dataSales->MsEmpName . '</span><br>   
                     </div>    
                  </div>';
      $this->db
         ->join("TblMsItem", "TblMsItem.MsItemId=TblSalesDetail.MsItemId", "left")
         ->join("TblMsVendor", "TblSalesDetail.MsVendorCode=TblMsVendor.MsVendorCode", "left")
         ->join("TblMsItemCategory", "TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId", "left")
         ->where("SalesDetailRef", $dataSales->SalesCode);
      if ($vendor != "WHO")
         $this->db->where("TblSalesDetail.MsVendorCode", $vendor);
      $datadetailSales = $this->db->get("TblSalesDetail")->result();
      $datadetail = $this->db
         ->join("TblPODetail", "TblPO.POCode=TblPODetail.PODetailRef", "left")
         ->join("TblMsItem", "TblMsItem.MsItemId=TblPODetail.MsItemId", "left")
         ->join("TblMsVendor", "TblPODetail.MsVendorCode=TblMsVendor.MsVendorCode", "left")
         ->join("TblMsItemCategory", "TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId", "left")
         ->where("SalesRef", $dataSales->SalesCode)->get("TblPO")->result();
      echo json_encode(array(
         "header" => $dataSales,
         "detail" => $datadetailSales,
         "detailref" => $datadetail,
         "card" => $customercard,
      ));
      exit;
   }
   function get_data_po($id)
   {
      $dataheader = $this->db->select("*,TblPO.SalesRef")
         ->join("TblSales", "TblSales.SalesCode=TblPO.SalesRef", "left")
         ->join("TblMsCustomer", "TblMsCustomer.MsCustomerId=TblSales.MsCustomerId", "left")
         ->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblPO.MsEmpId", "left")
         ->where("POId", $id)->get("TblPO")->row();
      $datadetail = $this->db
         ->join("TblMsItem", "TblMsItem.MsItemId=TblPODetail.MsItemId", "left")
         ->join("TblMsItemCategory", "TblMsItemCategory.MsItemCatId=TblMsItem.MsItemCatId", "left")
         ->where("PODetailRef", $dataheader->POCode)->get("TblPODetail")->result();
      echo json_encode(array(
         "dataheader" => $dataheader,
         "datadetail" => $datadetail
      ));
      exit;
   }
   function data_grpo_add()
   {
      $status = true;
      $sales = $this->input->post("data");
      $sales += ["GRPOLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $sales += ["GRPOCreateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];
      $this->db->insert('TblGRPO', $sales);
      if ($status && ($this->db->affected_rows() != 1)) $status = false;
      if (null !== $this->input->post("item")) {
         $dataitem = $this->input->post("item");
         foreach ($dataitem as $row) {
            $this->db->insert('TblGRPODetail', $row);
         }
      }
      echo $status;
      $this->db->update('TblPO', array('POStatus' => 2), array('POCode' => $sales["GRPORef"]));

      $this->m_inventory->insert_trans_from_grpo($sales["GRPOCode"]);
      exit;
   }
   function data_grpo_edit($id)
   {
      $status = true;
      $sales = $this->input->post("data");
      $sales += ["GRPOLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")];

      $this->db->update('TblGRPO', $sales, array("GRPOId" => $id));

      if ($status && ($this->db->affected_rows() != 1)) $status = false;

      $this->db->delete('TblGRPODetail',   array("GRPODetailRef" => $this->input->post("code")));

      if (null !== $this->input->post("item")) {
         $dataitem = $this->input->post("item");
         foreach ($dataitem as $row) {
            $this->db->insert('TblGRPODetail', $row);
         }
      }

      echo $status;

      $this->m_inventory->insert_trans_from_grpo($this->input->post("code"));
      exit;
   }
}
