<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Client_datatable_tools extends CI_Controller
{
   function __construct()
   {
      parent::__construct();
      $this->load->model('tools/Model_tools', 'm_tools');
      $this->load->model('model_app');
      date_default_timezone_set('Asia/Jakarta');
   }

   function get_visit_assetStatus()
   {
      // SETUP DATATABLE
      $this->m_tools->table = 'TblAssetKelola';
      $this->m_tools->tablejoin = array(
         array(0 => "TblAssetKelolaType", 1 => "TblAssetKelolaType.assetKelolaTypeId=TblAssetKelola.assetKelolaTypeIdRef"),
         array(0 => "TblAssetListing", 1 => "TblAssetListing.AssetDetailId=TblAssetKelola.AssetDetailIdRef"),
         array(0 => 'TblMsWorkplace', 1 => 'TblAssetListing.MsWorkplaceIdRef=TblMsWorkplace.MsWorkplaceId'),
         array(0 => "TblAsset", 1 => "TblAsset.AssetId=TblAssetListing.AssetTypeRef"),
      );
      $this->m_tools->column_order = array(null, 'AssetName', 'assetKelolaDesc', 'assetKelolaDate'); //set column field database for datatable orderable
      $this->m_tools->column_search = array('AssetName', 'assetKelolaDesc','assetKelolaDate'); //set column field database for datatable searchable 
      $this->m_tools->order = array('assetKelolaDate' => 'DESC'); // default order 
      // PROSES DATA
      $list = $this->m_tools->get_datatables();
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $master) {
         $no++;
         $row = array();
         $row[] = $no;
         $row[] = $master->AssetName;
         $row[] = $master->AssetDetailMerk;
         $row[] = $master->AssetDetailType;
         $row[] = $master->MsWorkplaceCode;
         $row[] = $master->assetKelolaDate;
         $row[] = $master->assetKelolaTypeName;
         $row[] = $master->assetKelolaNote;
         $row[] = '  <div class="d-flex flex-row">
                        <a onclick="edit_click(' . $master->assetKelolaId . ')" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                        <a onclick="delete_click(' . $master->assetKelolaId . ')" class="me-2 text-danger pointer" title="delete Data"><i class="fas fa-trash-alt"></i></a>
                     </div>';
         $data[] = $row;
      }
      $output = array(
         "draw" => $_POST['draw'],
         "recordsTotal" => $this->m_tools->count_all(),
         "recordsFiltered" => $this->m_tools->count_filtered(),
         "data" => $data,
      );
      //output to json format
      echo json_encode($output);
   }

   function get_visit_asset()
   {
      // SETUP DATATABLE
      $this->m_tools->table = 'TblAssetListing';
      $this->m_tools->tablejoin = array(
         array(0 => 'TblMsWorkplace', 1 => 'TblAssetListing.MsWorkplaceIdRef=TblMsWorkplace.MsWorkplaceId'),
         array(0 => 'TblAsset', 1 => 'TblAssetListing.AssetTypeRef=TblAsset.AssetId'),
         array(0 => 'TblAssetDivisi', 1 => 'TblAssetListing.assetDivisiIdRef=TblAssetDivisi.assetDivisiId'),
      );
      $this->m_tools->column_order = array(null, 'AssetName', 'TblAssetListing.AssetDetailMerk', 'TblAssetListing.AssetDetailUser', 'MsWorkplaceCode'); //set column field database for datatable orderable
      $this->m_tools->column_search = array('AssetDetailMerk', 'AssetName'); //set column field database for datatable searchable 
      $this->m_tools->order = array('TblAssetListing.MsWorkplaceIdRef' => 'asc'); // default order 

      // PROSES DATA
      $list = $this->m_tools->get_datatables();
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $master) {
         $no++;
         $row = array();
         $row[] = $no;
         $row[] = $master->assetDivisiCode;
         $row[] = $master->AssetName;
         $row[] = $master->AssetDetailMerk;
         $row[] = $master->AssetDetailType;
         $row[] = $master->MsWorkplaceCode;
         $row[] = $master->AssetDetailUser;
         $row[] = ($master->AssetDetailStatus == 1 ? '<span class="badge rounded-pill bg-success pointer">Active</span>' : '<span class="badge rounded-pill bg-danger pointer">NonActive</span>');
         $row[] = '  <div class="d-flex flex-row">
                        <a onclick="view_click(' . $master->AssetDetailId . ')" class="me-2 text-secondary pointer" title="View Data"><i class="fas fa-eye"></i></a>
                        <a onclick="edit_click(' . $master->AssetDetailId . ')" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                     </div>';
         $data[] = $row;
      }
      $output = array(
         "draw" => $_POST['draw'],
         "recordsTotal" => $this->m_tools->count_all(),
         "recordsFiltered" => $this->m_tools->count_filtered(),
         "data" => $data,
      );
      //output to json format
      echo json_encode($output);
   }

   function get_visit_qr()
   {
      // SETUP DATATABLE
      $this->m_tools->table = 'TblQrCode';
      $this->m_tools->tablejoin = array();
      $this->m_tools->column_order = array(null); //set column field database for datatable orderable
      $this->m_tools->column_search = array('QrCodeName', 'QrCodeNickName'); //set column field database for datatable searchable 
      $this->m_tools->order = array('QrCodeName' => 'asc'); // default order 

      // PROSES DATA
      $list = $this->m_tools->get_datatables();
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $master) {
         $row = array();
         $row[] = '<div class="card">
                     <div class="card-body p-4 text-secondary"> 
                        <div class="row">
                           <div class="col-md-6 col-sm-12 ">  
                              <i class="fas fa-bullhorn pe-2"></i><span>Sosial</span> 
                              <div class="row">
                                 <h3 class="fw-bold">QR Code ' . $master->QrCodeName . '</h3>
                                 <div class="d-flex flex-row">
                                    <div class="d-block pe-4">
                                       <i class="fas fa-calendar pe-2"></i><span>' . date_format(date_create($master->QrCodeDate), "F j, Y") . '</span> 
                                    </div>
                                    <div class="d-block">
                                       <i class="fas fa-link pe-2"></i><a class="text-decoration-none" target="_blank" href="' . site_url("share/qrcode/") . $master->QrCodeNickName . '">' . site_url("share/qrcode/") . $master->QrCodeNickName . '</a> 
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6 col-sm-12">
                              <div class="row">
                                 <div class="col-4">
                                    <h2 class="fw-bold mb-0">' . $this->db->where("QrScanRef", $master->QrCodeId)->get('TblQrScan')->num_rows() . '<span style="font-size:1rem">/' .  $this->db->where("QrScanRef", $master->QrCodeId)->group_by("QrScanUUID")->get('TblQrScan')->num_rows() . '</span></h2>
                                    <span style="font-size:1rem">scans</span>
                                    <div class="d-block mt-2">
                                       <a class="text-secondary action-label" onclick="detail_click(' . $master->QrCodeId . ')">Lihat Detail <i class="fas fa-arrow-right"></i></a>
                                    </div>
                                 </div>
                                 <div class="col-4">
                                    <img src="' . base_url("function/client_datatable_tools/get_barcode/") . $master->QrCodeNickName . '" width="100"/>
                                 </div>
                                 <div class="col-4">
                                    <button class="btn btn-primary w-100">Download</button> 
                                    <div class="d-flex flex-row mt-4 text-center" style="font-size: 1rem;">
                                       <a onclick="view_click(' . $master->QrCodeId . ')" class="text-secondary pointer flex-fill" title="View Data"><i class="fas fa-eye"></i></a>
                                       <a onclick="edit_click(' . $master->QrCodeId . ')" class="text-secondary pointer flex-fill" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                                       <a onclick="delete_click(' . $master->QrCodeId . ')" class="text-secondary pointer flex-fill" title="Delete Data"><i class="fas fa-trash-alt"></i></a>
                                    </div>
                                 </div>
                              </div>
                           </div> 
                        </div>
                     </div>
                  </div>';
         $data[] = $row;
      }
      $output = array(
         "draw" => $_POST['draw'],
         "recordsTotal" => $this->m_tools->count_all(),
         "recordsFiltered" => $this->m_tools->count_filtered(),
         "data" => $data,
      );

      //output to json format
      echo json_encode($output);
   }
   public function get_barcode($id)
   {
      $this->load->library('ciqrcode');
      header("Content-Type: image/png");
      $params['data'] = site_url("share/qrcode/") . $id;
      $this->ciqrcode->generate($params);
   }
   // public function barcodeAdd()
   // {
   //    $this->load->library('ciqrcode');
   //    header("Content-Type: image/png");
   //    $params['data'] = "https://preview.omahbata.com/home/about";
   //    $this->ciqrcode->generate($params);
   // }
}
