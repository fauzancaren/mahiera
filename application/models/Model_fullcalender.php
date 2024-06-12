<?php

use FontLib\Table\Type\name;
use PhpOffice\PhpSpreadsheet\Calculation\Database\DSum;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_fullcalender extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function fetch_all_event()
    {

        return $this->db->select([
            "TblPlainProject.PlainProjectId",
            "TblPlainProject.PlainProjectTitle",
            "TblPlainProject.PlainProjectStartDate",
            "TblPlainProject.PlainProjectEndDate",
            "TblMsEmployeePosition.MsEmpPositionId"
        ])
            ->join('TblMsEmployeePosition', 'TblMsEmployeePosition.MsEmpPositionId = TblPlainProject.MsEmpPositionId', 'left')
            ->get("TblPlainProject")->result();
    }

    function addProject($data)
    {
        $this->db->insert('TblPlainProject', $data);
    }
    function addProgres($data, $data2, $id)
    {
        $this->db->insert('TblPlainProjectProgres', $data);
        $this->db->where('PlainProjectId', $id);
        $this->db->update('TblPlainProject', $data2);
    }
    function editProgres($data)
    {
        $this->db->insert('TblPlainProjectProgres', $data);
    }
    function editSubProgres($data, $id)
    {
        $this->db->where('PlainProjectProgresId', $id);
        $this->db->update('TblPlainProjectProgres', $data);
    }
    function deleteProgres($id)
    {
        $this->db->where('PlainProjectProgresRef', $id);
        $this->db->delete('TblPlainProjectProgres');
    }
    function editProject($data, $id)
    {
        $this->db->where('PlainProjectId', $id);
        $this->db->update('TblPlainProject', $data);
    }

    function extendProject($data, $id)
    {
        $this->db->where('PlainProjectId', $id);
        $this->db->update('TblPlainProject', $data);
    }
    function finishProject($data, $id)
    {
        $this->db->where('PlainProjectId', $id);
        $this->db->update('TblPlainProject', $data);
    }
    function deleteProject($id)
    {
        $this->db->where('PlainProjectId', $id);
        $this->db->delete('TblPlainProject');
        $this->db->where('PlainProjectProgresRef', $id);
        $this->db->delete('TblPlainProjectProgres');
    }
    function deleteSubProgres($id)
    {
        $this->db->where('PlainProjectProgresId', $id);
        $this->db->delete('TblPlainProjectProgres');
    }
    function editQrCode($id, $qrcode)
    {
        // $data = [
        //     "QrCodeNickName" => $qrcode['QrCodeNickName'], true,
        //     "QrCodeName" => $qrcode['QrCodeName'], true,
        //     "QrCodeHeadColor" => $qrcode['QrCodeHeadColor'], true,
        //     "QrCodeHeadLine" => $qrcode['QrCodeHeadLine'], true,
        //     "QrCodeAboutUs" => $qrcode['QrCodeAboutUs'], true,
        //     "QrCodeImage" => $dataUpload['upload_data']['file_name']
        // ];
        $this->db->where('QrCodeId', $id);
        $this->db->update('TblQrCode', $qrcode);
    }

    function insertQrCode($data)
    {
        $this->db->insert('TblQrCode', $data);
    }

    function deleteSosialMedia($id)
    {
        $this->db->where('QrSosialMediaRef', $id);
        $this->db->delete('TblQrSosialMedia');
    }
    function insertSosialMedia($data)
    {
        $this->db->insert('TblQrSosialMedia', $data);
    }

    function addAsset($data)
    {
        $this->db->insert('TblAssetListing', $data);
    }

    function EditAsset($data, $id)
    {
        $this->db->where('AssetDetailId', $id);
        $this->db->update('TblAssetListing', $data);
    }
}
