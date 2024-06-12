<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Message_financial extends CI_Controller
{
   function __construct()
   {
      parent::__construct();
      $this->load->model('model_app');
      date_default_timezone_set('Asia/Jakarta');
   }

   function petty_cash_add()
   {
      $data["_workplace"] = $this->session->userdata("MsWorkplaceId");
      echo $this->load->view('message/financial/pettycashadd', $data, TRUE);
   }
   function petty_cash_view($id)
   {
      $data["_session"] = $this->session->userdata();
      $data["_finance"] = $this->db->join("TblFinanceCategory", "FinancialCategory = FinanceCatId")->where("FinancialId", $id)->get("TblFinancial")->row();
      echo $this->load->view('message/financial/pettycashview', $data, TRUE);
   }
   function petty_cash_edit($id)
   {
      $data["_session"] = $this->session->userdata();
      $data["_finance"] = $this->db->join("TblFinanceCategory", "FinancialCategory = FinanceCatId")->where("FinancialId", $id)->get("TblFinancial")->row();
      $data["_kategori"] = $this->db->join("TblFinanceCategory as a", "a.FinanceCatId = b.FinanceCatParent")
         ->where("b.FinanceCatId", $data["_finance"]->FinancialCategory)
         ->select("a.FinanceCatName as FinanceCatName")
         ->get("TblFinanceCategory as b")->row();
      echo $this->load->view('message/financial/pettycashedit', $data, TRUE);
   }
}
