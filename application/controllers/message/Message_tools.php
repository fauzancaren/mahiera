<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Message_tools extends CI_Controller
{
   function __construct()
   {
      parent::__construct();
      $this->load->model('model_app');
      date_default_timezone_set('Asia/Jakarta');
   }
   function data_visit_qr_code_add()
   {
      $data["_dataSosial"] = null;
      $data["_data"] = null;
      echo $this->load->view('message/tools/visit_qr_code_add', $data, true);
   }
   function data_visit_qr_code_edit($id)
   {
      $data["_dataSosial"] = $this->db->join("TblMsSosialMedia", "TblMsSosialMedia.MsSosialMediaId=TblQrSosialMedia.QrSosialMediaType", "left")->where("QrSosialMediaRef", $id)->get("TblQrSosialMedia")->result();
      $data["_data"] = $this->db->where("QrCodeId", $id)->get("TblQrCode")->row();
      echo $this->load->view('message/tools/visit_qr_code_edit', $data, TRUE);
   }
   function data_visit_qr_code_view($id)
   {
      $data["_dataSosial"] = $this->db->join("TblMsSosialMedia", "TblMsSosialMedia.MsSosialMediaId=TblQrSosialMedia.QrSosialMediaType", "left")->where("QrSosialMediaRef", $id)->get("TblQrSosialMedia")->result();
      $data["_data"] = $this->db->where("QrCodeId", $id)->get("TblQrCode")->row();
      echo $this->load->view('message/tools/visit_qr_code_view', $data, TRUE);
   }
   function data_visit_qr_code_detail($id)
   {
      $data["_qrcode"] = $this->db->where("QrCodeId", $id)->get("TblQrCode")->row();
      echo $this->load->view('message/tools/visit_qr_code_detail', $data, true);
   }
   function data_plain_project_add()
   {
      echo $this->load->view('message/tools/plain_project_add', null, true);
   }
   function data_progres_project_add($id)
   {
      $data["_plainProject"] = $this->db->where("PlainProjectId", $id)->get("TblPlainProject")->row();
      echo $this->load->view('message/tools/progres_project_add', $data, true);
   }
   function data_progres_project_edit($id)
   {
      // $data["_plainProject"] = $this->db->where("PlainProjectId", $idProject)->get("TblPlainProject")->row();
      $data["_plainProjectProgres"] = $this->db->where("PlainProjectProgresId", $id)->get("TblPlainProjectProgres")->row();
      $data["_plainProject"] = $this->db->where("PlainProjectId", $data["_plainProjectProgres"]->PlainProjectProgresRef)->get("TblPlainProject")->row();
      echo $this->load->view('message/tools/progres_project_edit', $data, true);
   }
   function data_plain_project_edit($id)
   {
      $data["_plainProject"] = $this->db->where("PlainProjectId", $id)->get("TblPlainProject")->row();
      echo $this->load->view('message/tools/plain_project_edit', $data, true);
   }
   function data_plain_project_extend($id)
   {
      $data["_plainProject"] = $this->db->where("PlainProjectId", $id)->get("TblPlainProject")->row();
      echo $this->load->view('message/tools/plain_project_extend', $data, true);
   }

   function data_plain_project_show($id)
   {
      $data["_plainProjectProgres"] = $this->db->where('PlainProjectProgresRef', $id)->get('TblPlainProjectProgres')->result();
      // $data["_plainProject"] = $this->db->join('TblMsEmployeePosition', 'TblMsEmployeePosition.MsEmpPositionId = TblPlainProject.MsEmpPositionId', 'left')->where("PlainProjectId", $id)->get("TblPlainProject")->row();
      $data["_plainProject"] = $this->db->where("PlainProjectId", $id)->get("TblPlainProject")->row();
      echo $this->load->view('message/tools/plain_project_view', $data, true);
   }

   function data_asset_edit($id)
   {
      $data["_assetListing"] = $this->db->join("TblAsset", "TblAsset.AssetId=TblAssetListing.AssetTypeRef", "left")->where("AssetDetailId", $id)->get("TblAssetListing")->row();
      echo $this->load->view('message/tools/asset_edit', $data, true);
   }

   function data_asset_add()
   {
      echo $this->load->view('message/tools/asset_add', null, true);
   }

   function data_asset_view($id)
   {
      $data["_assetListing"] = $this->db->join("TblAsset", "TblAsset.AssetId=TblAssetListing.AssetTypeRef", "left")->where("AssetDetailId", $id)->get("TblAssetListing")->row();
      echo $this->load->view('message/tools/asset_view', $data, true);
   }

   function data_assetStatus_add()
   {
      $data["_asset"] = $this->db->where("AssetDetailStatus", 1)->get("TblAssetListing")->result();
      // $data["_asset"] = $this->db->join('TblMsWorkplace', 'TblMsWorkplace.MsWorkplaceId = TblAssetListing.MsWorkplaceIdRef', 'left')->where("AssetDetailStatus", 1)->get("TblAssetListing")->row();
      $data["_kelola"] = $this->db->get("TblAssetKelolaType")->result();
      echo $this->load->view('message/tools/assetStatus_add', $data, true);
   }

   function data_assetStatus_edit($id)
   {
      $data["_data"] = $this->db->where("assetKelolaId", $id)->get("TblAssetKelola")->row();
      $data["_asset"] = $this->db->where("AssetDetailStatus", 1)->get("TblAssetListing")->result();
      $data["_kelola"] = $this->db->get("TblAssetKelolaType")->result();
      echo $this->load->view('message/tools/assetStatus_edit', $data, true);
   }
}
