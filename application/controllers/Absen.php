<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absen extends CI_Controller
{
   function __construct()
   {
      parent::__construct();
      $this->load->model('model_app');
      $this->load->helper('cookie');
   }
   function index()
   {
      //$this->load->view('report/absensi/warehouse');
      $result = $this->db->query("SELECT SalesCode FROM TblSales GROUP BY SalesCode HAVING COUNT(*)>1")->result();
      foreach ($result as $row) {
         echo "SELECT * FROM TblSales WHERE SalesCode='" . $row->SalesCode . "';<br>";
         echo "SELECT * FROM TblSalesDetail WHERE SalesDetailRef='" . $row->SalesCode . "';<br>";
         echo  "SELECT * FROM TblSalesOptional WHERE SalesOptionalRef='" . $row->SalesCode . "';<br><br>";
      }
   }
   function test()
   { 
      $data = "XP9WN2NYC9O0qX1xGNbLZ0rNDkWED3bE3qP9e0qN1ieR2e9eC1CBW3IB2CO1OD1sKX1xIN4PYZyz";
      echo $this->model_app->DecryptedPassword($data);
   }
   function update()
   {
      $sales = $this->Model_app->get_single_data("MsEmpName", "TblMsEmployee", array("MsEmpId" => 24));
      echo $sales;
   }
   function update_sales_expired()
   {
      $date = date('Y-m-d', strtotime('-2 months'));
      $data = $this->db->where("SalesDate <=", $date)->where("SalesStatusPayment", 0)->get("TblSales")->result();
      foreach ($data as $row) {
         $this->db->update("TblSales", array("SalesStatusPayment" => 3), array("SalesCode" => $row->SalesCode));

         // ============================================== INSERT NOTIF
         $datanotif = array(
            "NotifHeader" => "Penjualan Berhasil dibatalkan <i class='ps-1 fas fa-times-circle text-danger'></i>",
            "NotifDesc" => "Penjualan dibatalkan oleh system karena melebihi batas waktu pembayaran dengan No. Sales <b>" . $row->SalesCode . "</b> atas nama <b>" . $this->model_app->get_customer_name($row->MsCustomerId) . "</b>",
            "NotifType" => "SALES",
            "NotifRef" => $row->SalesCode,
            "NotifRefDate" => $row->SalesDate,
            "MsWorkplaceId" => $row->MsWorkplaceId,
         );
         $this->model_app->insert_notif($datanotif);
      }
   }
   function test_update()
   {
      echo "*- update success -*";
   }
}
