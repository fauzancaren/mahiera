<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Share extends CI_Controller
{
   function __construct()
   {
      parent::__construct();
      $this->load->helper('cookie');
      $this->load->model('model_app');
   }
   function qrcode($id)
   {
      $data["_qrcode"] = $this->db->where("QrCodeNickName", $id)->get("TblQrCode")->row();
      $data["_sosialmedia"] = $this->db->join("TblMsSosialMedia", "TblMsSosialMedia.MsSosialMediaId=TblQrSosialMedia.QrSosialMediaType", "left")->where("QrSosialMediaRef", $data["_qrcode"]->QrCodeId)->get("TblQrSosialMedia")->result();

      $this->load->view("share/templatesQr", $data);
   }
}
