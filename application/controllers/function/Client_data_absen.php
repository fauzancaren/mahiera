<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Client_data_absen extends CI_Controller
{
   function __construct()
   {
      parent::__construct();
      $this->load->model('model_app');
      $this->load->helper('directory');
      $this->load->library('image_lib');
      date_default_timezone_set('Asia/Jakarta');
   }
   function absen_add()
   {
      $this->db->insert('TblAbsen', $this->input->post());
      echo ($this->db->affected_rows() != 1) ? "false" : "true";
      exit;
   }
   function absen_edit($id)
   {
      $this->db->update('TblAbsen', $this->input->post(), array("AbsenId" => $id));
      echo ($this->db->affected_rows() != 1) ? "false" : "true";
      exit;
   }

   function absen_delete($id)
   {
      $this->db->delete('TblAbsen', array("AbsenId" => $id));
      echo ($this->db->affected_rows() != 1) ? "false" : "true";
      exit;
   }

   function schedule_update()
   {
      $data = $this->input->post("data");
      foreach ($data as $row) {
         for ($i = 0; $i < count($row["MsEmpId"]); $i++) {
            $data_old = $this->db->where("MsEmpId", $row["MsEmpId"][$i])->where("RosterDate", $row["RosterDate"])->get("TblRoster")->row();
            if (isset($data_old)) {
               $this->db->update('TblRoster', array("RosterDate" => $row["RosterDate"], "RosterTipe" => $row["RosterTipe"], "MsEmpId" => $row["MsEmpId"][$i]), array("RosterId" => $data_old->RosterId));
            } else {
               $this->db->insert('TblRoster', array("RosterDate" => $row["RosterDate"], "RosterTipe" => $row["RosterTipe"], "MsEmpId" => $row["MsEmpId"][$i]));
            }
         }
      }
      echo ($this->db->affected_rows() != 1) ? "false" : "true";
      exit;
   }
   function kehadiran_add()
   {
      $this->db->insert('TblAbsenKelola', $this->input->post());
      echo ($this->db->affected_rows() != 1) ? "false" : "true";
      exit;
   }
   function kehadiran_edit($id)
   {
      $this->db->update('TblAbsenKelola', $this->input->post(), array("AbsenKelolaId" => $id));
      echo ($this->db->affected_rows() != 1) ? "false" : "true";
      exit;
   }
   function kehadiran_delete($id)
   {
      $this->db->delete('TblAbsenKelola', array("AbsenKelolaId" => $id));
      echo ($this->db->affected_rows() != 1) ? "false" : "true";
      exit;
   }


   public function validate_kode_list_roster($id = null)
   {
      if ($id == null) {
         $query = $this->db->query("SELECT * FROM TblRosterList where RosterListCode='" . $_GET['RosterListCode'] . "'")->result();
         if ($query) {
            echo 'false';
         } else {
            echo 'true';
         }
         exit;
      } else {
         $query = $this->db->query("SELECT * FROM TblRosterList where RosterListCode='" . $_GET['RosterListCode'] . "' and not RosterListId='" . $id . "'")->result();
         if ($query) {
            echo 'false';
         } else {
            echo 'true';
         }
         exit;
      }
   }
   function data_list_roster_add()
   {
      $this->db->insert('TblRosterList', $this->input->post());
      echo ($this->db->affected_rows() != 1) ? "false" : "true";
      exit;
   }
   function data_list_roster_edit($id)
   {
      $this->db->update('TblRosterList', $this->input->post(), array("RosterListId" => $id));
      echo ($this->db->affected_rows() != 1) ? "false" : "true";
      exit;
   }
   function data_list_roster_delete($id)
   {
      $this->db->delete('TblRosterList', array("RosterListId" => $id));
      echo ($this->db->affected_rows() != 1) ? "false" : "true";
      exit;
   }

   function lembur_add()
   {
      $this->db->insert('TblAbsenLembur', $this->input->post());
      echo ($this->db->affected_rows() != 1) ? "false" : "true";
      exit;
   }
   function lembur_edit($id)
   {
      $this->db->update('TblAbsenLembur', $this->input->post(), array("AbsenLemburId" => $id));
      echo ($this->db->affected_rows() != 1) ? "false" : "true";
      exit;
   }
   function lembur_delete($id)
   {
      $this->db->delete('TblAbsenLembur', array("AbsenLemburId" => $id));
      echo ($this->db->affected_rows() != 1) ? "false" : "true";
      exit;
   }

   function get_absen_fingerspot($nowdate){  
      /* -------------------     PARAMETER FINGERSPOT -------------*/
      /* lihat data di fingerspot.io atau di http://fingerspot.io/download/Quick_Guide_API_SDK_Fingerspot.iO.pdf */
      $cloudid = 'C2697842931D1B38';   
      $format_date = 6;
      $property = 'date_time';
      $direction = 'asc';
      $export_type = 'json';
      $current = date('Ymdhms');
      $auth = md5($cloudid.$nowdate.$current.'Y00BCI2EGB2110MK'); 
      $data_url = "http://api.fingerspot.io/api/download/attendance_log/{$cloudid}/{$nowdate}/{$format_date}/{$property}/{$direction}/{$export_type}/{$auth}/{$current}";
      
      /* -----------------------------------------------------------*/
      // get data now
      $curl = curl_init($data_url);
      curl_setopt($curl, CURLOPT_URL, $data_url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
      $headers = array( 
         "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
         "Accept-Encoding: gzip, deflate",
         "Accept-Language: id-ID,id;q=0.9,en;q=0.8",
         "Cache-Control: no-cache",
         "Connection: keep-alive", 
         "Cookie: _ga=GA1.2.188722438.1656736013; _gid=GA1.2.1495122764.1657682350",
         "Host: api.fingerspot.io",
         "Pragma: no-cache",
         "Upgrade-Insecure-Requests: 1",
         "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36",
      );
      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); 
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

      $resp = curl_exec($curl);
      curl_close($curl);
      $obj = JSON_DECODE($resp); 
      
      if(!$obj->success){  
         $message1 = "";
         switch($obj->msg) {
            case "IO_API_ERR_0" :
                $message1 = "Akses API tidak tersedia antara pukul 06.00 s/d 08.59 WIB dan 14.00 s/d 15.59 WIB";
                break;
            case "IO_API_ERR_1" :
                $message1 = "Mesin tidak ditemukan";
                break;
            case "IO_API_ERR_2" :
                $message1 = "Akun tidak ditemukan";
                break;
            case "IO_API_ERR_3" :
                $message1 = "Parameter {auth} tidak sesuai";
                break;
            case "IO_API_ERR_4" :
                $message1 = "Akun melebihi DUE DATE";
                break;
            case "IO_API_ERR_5" :
                $message1 = "Mesin belum berlangganan API SDK";
                break;
            case "IO_API_ERR_6" :
                $message1 = "Belum berlangganan AddOn API SDK scan GPS";
                break;
            case "IO_API_ERR_7" :
                $message1 = "Sudah mencapai limit 100 kali request API per hari";
                break;
            default:
                $message1 = "tdak ada keterangan";
        } 
         $data = array(
            "status"=>false,
            "message"=>"Gagal Mengambil data dari server",
            "error"=>$message1, 
         );
         echo JSON_ENCODE($data);
         exit;  
      }else{  
         $data = array(
            "status"=>true,
            "message"=>"Berhasil Mengambil data dari server",
            "data"=>$obj->data, 
         );
         echo JSON_ENCODE($data); 
         exit;  
      }
   }
   function add_absen_fingerspot(){ 
      $datetime = explode(" ",$this->input->post("Date_Time"));
      $date = $datetime[0];
      $time = $datetime[1]; 
      $empcode = $this->input->post("PIN"); 
      $cloudid = $this->input->post("Cloud_ID"); 
      switch(strlen($empcode)) {
         case 1 :
            $empcode = "ID0000".$empcode;
            break;
         case 2 :
            $empcode = "ID000".$empcode;
            break;
         case 3 :
            $empcode = "ID00".$empcode;
            break;
         case 4 :
            $empcode = "ID0".$empcode;
            break;
         case 5 :
            $empcode = "ID".$empcode;
            break;
         default:
            $empcode = "ID00000";
      }    
      switch( $cloudid) {
         case "C2697842931D1B38" :
            $workplace = 2; 
            break;
         default:
            $workplace = 0;
      }   
      
      $result = $this->db->where("AbsenDate",$date)->where("AbsenTime",$time)->where("MsEmpCode",$empcode)->get("TblAbsen")->num_rows();
      $empname = ($this->db->where("MsEmpCode",$empcode)->get("TblMsEmployee")->row())->MsEmpName; 
      if ($result == 0) {
         $this->db->insert("TblAbsen",array(
            "AbsenDate"=>$date,
            "AbsenTime"=>$time,
            "MsEmpCode"=>$empcode,
            "MsEmpName"=>$empname,
            "System"=>0,
            "MsWorkplaceId"=>$workplace,
         ));
         echo ($this->db->affected_rows() != 1) ? "false" : "true";
         $data = array(
            "status"=>($this->db->affected_rows() != 1) ? false : true,
            "message"=>"Data berhasil diimport", 
            "date"=>$datetime, 
            "name"=>$empname, 
         );
         echo JSON_ENCODE($data);
         exit;   
      }else{
         $data = array(
            "status"=>false,
            "message"=>"Data sudah ada di database", 
            "date"=>$datetime, 
            "name"=>$empname, 
         );
         echo JSON_ENCODE($data);
         exit;  
      }
   }
}
