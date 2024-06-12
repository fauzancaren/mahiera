<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TblRoster
{
   public $MsEmpId;
   public $RosterDate;
   public $RosterTipe;
   public $RosterId;
}
class Message_absensi extends CI_Controller
{
   function __construct()
   {
      parent::__construct();
      $this->load->model('model_app');
      date_default_timezone_set('Asia/Jakarta');
   }
   function absensi_syncron(){ 
      echo $this->load->view('message/absensi/log/syncron_absen', null, TRUE);
   }
   function absensi_add()
   {
      $data["_workplace"] = $this->db->where("MsWorkplaceIsActive", 1)->get("TblMsWorkplace")->result();
      $data["_employee"] = $this->db->where("MsEmpIsActive", 1)->get("TblMsEmployee")->result();
      echo $this->load->view('message/absensi/log/add_absen', $data, TRUE);
   }
   function absensi_edit($id)
   {

      $data["_absen"] = $this->db->where("AbsenId", $id)->get("TblAbsen")->row();
      $data["_workplace"] = $this->db->where("MsWorkplaceIsActive", 1)->get("TblMsWorkplace")->result();
      $data["_employee"] = $this->db->where("MsEmpIsActive", 1)->get("TblMsEmployee")->result();
      echo $this->load->view('message/absensi/log/edit_absen', $data, TRUE);
   }
   function absensi_comment($id)
   {
      $data["_absen"] = $this->db->where("AbsenId", $id)->get("TblAbsen")->row();
      echo $this->load->view('message/absensi/log/comment_absen', $data, TRUE);
   }
   function roster_update($empid, $date, $id)
   {
      if ($id == "-") {
         $roster = new TblRoster;
         $roster->MsEmpId = $empid;
         $roster->RosterDate = $date;
         $roster->RosterTipe = "P";
         $roster->RosterId = $id;
         $data["_roster"] = $roster;
      } else {
         $data["_roster"] =  $this->db->where("RosterId", $id)->get("TblRoster")->row();
      }
      $data["_rosterlist"] = $this->db->get("TblRosterList")->result();
      $data["_employee"] = $this->db->where("MsEmpIsActive", 1)->get("TblMsEmployee")->result();
      echo $this->load->view('message/absensi/roster/updateroster', $data, TRUE);
   }
   function kehadiran_add()
   {
      $data["_employee"] = $this->db->where("MsEmpIsActive", 1)->get("TblMsEmployee")->result();
      $data["_kelola"] = $this->db->get("TblAbsenKelolaType")->result();
      echo $this->load->view('message/absensi/kehadiran/add_kehadiran', $data, TRUE);
   }
   function kehadiran_edit($id)
   {
      $data["_data"] = $this->db->where("AbsenKelolaId", $id)->get("TblAbsenKelola")->row();
      $data["_employee"] = $this->db->where("MsEmpIsActive", 1)->get("TblMsEmployee")->result();
      $data["_kelola"] = $this->db->get("TblAbsenKelolaType")->result();
      echo $this->load->view('message/absensi/kehadiran/edit_kehadiran', $data, TRUE);
   }

   function listroster_add()
   {
      echo $this->load->view('message/absensi/listroster/add_listroster', null, TRUE);
   }
   function listroster_edit($id)
   {
      $data["_data"] = $this->db->where("RosterListId", $id)->get("TblRosterList")->row();
      echo $this->load->view('message/absensi/listroster/edit_listroster', $data, TRUE);
   }

   function lembur_add()
   {
      $data["_employee"] = $this->db->where("MsEmpIsActive", 1)->get("TblMsEmployee")->result();
      $data["_kelola"] = $this->db->get("TblAbsenLemburType")->result();
      echo $this->load->view('message/absensi/lembur/add_lembur', $data, TRUE);
   }
   function lembur_edit($id)
   {
      $data["_data"] = $this->db->where("AbsenLemburId", $id)->get("TblAbsenLembur")->row();
      $data["_employee"] = $this->db->where("MsEmpIsActive", 1)->get("TblMsEmployee")->result();
      $data["_kelola"] = $this->db->get("TblAbsenLemburType")->result();
      echo $this->load->view('message/absensi/lembur/edit_lembur', $data, TRUE);
   }
}
