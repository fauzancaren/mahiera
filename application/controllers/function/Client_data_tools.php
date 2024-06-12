<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Client_data_tools extends CI_Controller
{
   function __construct()
   {
      parent::__construct();
      $this->load->model('model_app');
      $this->load->model('Model_fullcalender', "Fullcalendar_model");
      date_default_timezone_set('Asia/Jakarta');
   }
   function qr_scan()
   {
      $this->db->insert("TblQrScan", $this->input->post());
   }

   function qr_delete($id)
   {
      $this->db->delete(
         'TblQrCode',
         array('QrCodeId' => $id)
      );
      echo ($this->db->affected_rows() != 1) ? "false" : "true";
      exit;
   }

   function qr_add()
   {
      //upload file
      $data = substr($this->input->post("data"), strpos($this->input->post("data"), ",") + 1);
      $decodedData = base64_decode($data);
      $location = 'asset/image/qrcode/' . $this->input->post("fname"); //untuk lokal
      file_put_contents(FCPATH . $location, $decodedData);

      //insert qrcode
      $qrCodeData = $this->input->post("qrCode");
      $qrCodeData = json_decode($qrCodeData);

      $this->db->insert('TblQrCode', $qrCodeData);

      $this->db->select_max('QrCodeId');
      $res1 = $this->db->get('TblQrCode');

      if ($res1->num_rows() > 0) {
         $res2 = $res1->result_array();
         $result = $res2[0]['QrCodeId'];
         //insert sosial media
         $sosialMediaData = $this->input->post("sosialMedia");
         $sosialMediaData = json_decode($sosialMediaData);
         if ($sosialMediaData) {
            foreach ($sosialMediaData as $row) {
               $data = array(
                  'QrSosialMediaType' => $row->QrSosialMediaType,
                  'QrSosialMediaUrl' => $row->QrSosialMediaUrl,
                  'QrSosialMediaText' => $row->QrSosialMediaText,
                  'QrSosialMediaRef' => $result,
                  'QrSosialMediaPosition' => $row->QrSosialMediaPosition
               );
               $this->db->insert('TblQrSosialMedia', $data);
            }
            return true;
         }
      }
      return false;
   }

   // function qr_edit($id)
   // {
   //    $qrcode = $this->input->post("qrCode");
   //    $sosialMediaData = $this->input->post("sosialMedia");

   //    if (!empty($_FILES['file']['name'])) {
   //       if (!file_exists('asset/image/qrcode/')) {
   //          mkdir("asset/image/qrcode", 0777);
   //       }

   //       $config['upload_path'] = 'asset/image/qrcode/';
   //       $config['allowed_types'] = 'gif|jpg|jpeg|png';
   //       $config['max_size'] = 1000000;
   //       $config['file_name'] = $_FILES['file']['name'];

   //       $this->load->library('upload', $config);

   //       if ($this->upload->do_upload('qrCodeHeaderImage')) {
   //          $this->upload->data();
   //          $dataupload = array(
   //             "QrCodeImage" => $_FILES['file']['name'],
   //          );
   //       }

   //       $this->Fullcalendar_model->editQrCode($id, $dataupload, $qrcode);
   //       $this->Fullcalendar_model->deleteSosialMedia($id);

   //       if ($this->input->post("sosialMedia")) {

   //                foreach ($sosialMediaData as $row) {
   //                      $data = array(
   //                         'QrSosialMediaType' => $row["QrSosialMediaType"],
   //                         'QrSosialMediaUrl' => $row['QrSosialMediaUrl'],
   //                         'QrSosialMediaText' => $row['QrSosialMediaText'],
   //                         'QrSosialMediaRef' => $row['QrSosialMediaRef'],
   //                         'QrSosialMediaPosition' => $row['QrSosialMediaPosition']
   //                      );
   //                   $this->Fullcalendar_model->insertSosialMedia($data);
   //                }
   //                return true;
   //             }
   //             return false;
   //    }
   // }

   function qr_edit($id)
   {
      //upload file
      $data = substr($this->input->post("data"), strpos($this->input->post("data"), ",") + 1);
      $decodedData = base64_decode($data);
      $location = 'asset/image/qrcode/' . $this->input->post("fname"); //untuk lokal
      file_put_contents(FCPATH . $location, $decodedData);

      //update qrcode
      $qrCodeData = $this->input->post("qrCode");
      $qrCodeData = json_decode($qrCodeData);

      $this->db->where('QrCodeId', $id);
      $this->db->update('TblQrCode', $qrCodeData);

      //delete sosial media
      $this->db->where('QrSosialMediaRef', $id);
      $this->db->delete('TblQrSosialMedia');

      //insert sosial media
      $sosialMediaData = $this->input->post("sosialMedia");
      $sosialMediaData = json_decode($sosialMediaData);
      if ($sosialMediaData) {
         foreach ($sosialMediaData as $row) {
            $data = array(
               'QrSosialMediaType' => $row->QrSosialMediaType,
               'QrSosialMediaUrl' => $row->QrSosialMediaUrl,
               'QrSosialMediaText' => $row->QrSosialMediaText,
               'QrSosialMediaRef' => $row->QrSosialMediaRef,
               'QrSosialMediaPosition' => $row->QrSosialMediaPosition
            );
            $this->db->insert('TblQrSosialMedia', $data);
         }
         return true;
      }
      return false;
   }

   function plainProjectGet()
   {
      $event_data = $this->Fullcalendar_model->fetch_all_event();

      foreach ($event_data as $row) {
         $color = null;
         if ($row->MsEmpPositionId == '1') {
            $color = '#493a64';
            $bgcolor = '#727575';
         } else
         if ($row->MsEmpPositionId == '2') {
            $color = '3a71b5';
            $bgcolor = '#727575';
         } else
         if ($row->MsEmpPositionId == '3') {
            $color = '#93c47d';
            $bgcolor = '#727575';
         } else
         if ($row->MsEmpPositionId == '4') {
            $color = '#527772';
            $bgcolor = '#727575';
         } else
         if ($row->MsEmpPositionId == '5') {
            $color = '#a8c3f7';
            $bgcolor = '#727575';
         } else
         if ($row->MsEmpPositionId == '6') {
            $color = '#b8953d';
            $bgcolor = '#727575';
         } else
         if ($row->MsEmpPositionId == '7') {
            $color = '#ff6666p';
            $bgcolor = '#727575';
         } else
         if ($row->MsEmpPositionId == '8') {
            $color = '#8a2138';
            $bgcolor = '#727575';
         } else
         if ($row->MsEmpPositionId == '9') {
            $color = '#81d8d0';
            $bgcolor = '#727575';
         } else
         if ($row->MsEmpPositionId == '10') {
            $color = '#294b69';
            $bgcolor = '#727575';
         } else
         if ($row->MsEmpPositionId == '11') {
            $color = '#1aff03';
            $bgcolor = '#727575';
         } else
         if ($row->MsEmpPositionId == '12') {
            $color = '#5b4579';
            $bgcolor = '#727575';
         } else
         if ($row->MsEmpPositionId == '13') {
            $color = '#b6c565';
            $bgcolor = '#727575';
         } else
         if ($row->MsEmpPositionId == '14') {
            $color = '#b30a69';
            $bgcolor = '#727575';
         } else
         if ($row->MsEmpPositionId == '15') {
            $color = '#4cb84c';
            $bgcolor = '#727575';
         } else
         if ($row->MsEmpPositionId == '16') {
            $color = '#baaf9e';
            $bgcolor = '#727575';
         } else
         if ($row->MsEmpPositionId == '17') {
            $color = '#525fa2';
            $bgcolor = '#727575';
         } else
         if ($row->MsEmpPositionId == '18') {
            $color = '#cc4f20';
            $bgcolor = '#727575';
         } else
         if ($row->MsEmpPositionId == '19') {
            $color = '#ffa17e';
            $bgcolor = '#727575';
         } else
         if ($row->MsEmpPositionId == '20') {
            $color = '#6b76af';
            $bgcolor = '#727575';
         } else
         if ($row->MsEmpPositionId == '21') {
            $color = '#d3dca2';
            $bgcolor = '#727575';
         } else
         if ($row->MsEmpPositionId == '22') {
            $color = '#3a4895';
            $bgcolor = '#727575';
         } else
         if ($row->MsEmpPositionId == '23') {
            $color = '#655d45';
            $bgcolor = '#727575';
         } else
         if ($row->MsEmpPositionId == '') {
            $color = '#c8c3d0';
            $bgcolor = '#727575';
         }
         $data[] = array(
            'id' => $row->PlainProjectId,
            'title' => $row->PlainProjectTitle,
            'start' => $row->PlainProjectStartDate,
            'end' => $row->PlainProjectEndDate,
            'divisi' => $row->MsEmpPositionId,
            'color' => $color,
            'borderColor' => $bgcolor
         );
      }
      echo json_encode($data);
   }

   function plainProjectDetailEdit($id)
   {
      var_dump($this->input->post('project'));
      if ($this->input->post("progresif")) {
         $dataproject = $this->input->post("project");
         $dataprogres = $this->input->post("progresif");

         $this->Fullcalendar_model->editProject($dataproject, $id);
         $this->Fullcalendar_model->deleteProgres($id);

         foreach ($dataprogres as $row) {
            $data = array(
               'PlainProjectProgresTitle' => $row['PlainProjectProgresTitle'],
               'PlainProjectProgresStart' => $row['PlainProjectProgresStart'],
               'PlainProjectProgresEnd' => $row['PlainProjectProgresEnd'],
               'PlainProjectProgresDesk' => $row['PlainProjectProgresDesk'],
               'PlainProjectProgresRef' => $row['PlainProjectProgresRef']

            );
            $this->Fullcalendar_model->editProgres($data);
         }
         return true;
      }
      return false;
   }
   function plainProjectAdd()
   {
      if ($this->input->post('title')) {
         $data = array(
            'PlainProjectTitle' => $this->input->post('title'),
            'MsDivisiId' => $this->input->post('divisi'),
            'PlainProjectStartDate' => $this->input->post('start'),
            'PlainProjectEndDate' => $this->input->post('end'),
            'PlainProjectStatus' => "proses"
         );
         $this->Fullcalendar_model->addProject($data);
      }
   }
   function plainProjectProgresAdd()
   {
      if ($this->input->post('ref')) {
         $data = array(
            'PlainProjectProgresTitle' => $this->input->post('title'),
            'PlainProjectProgresStart' => $this->input->post('start'),
            'PlainProjectProgresEnd' => $this->input->post('end'),
            'PlainProjectProgresDesk' => $this->input->post('deskripsi'),
            'PlainProjectProgresRef' => $this->input->post('ref')

         );
         $data2 = array(
            'PlainProjectPersentase' => $this->input->post('persen')
         );
         $this->Fullcalendar_model->addProgres($data, $data2, $this->input->post('ref'));
      }
   }
   function plainProjectEdit()
   {
      if ($this->input->post('id')) {
         $data = array(
            'PlainProjectTitle' => $this->input->post('title'),
            'MsDivisiId' => $this->input->post('divisi'),
            'PlainProjectStartDate' => $this->input->post('start'),
            'PlainProjectEndDate' => $this->input->post('end'),
         );
         $this->Fullcalendar_model->editProject($data, $this->input->post('id'));
      }
   }
   function plainProjectProgresEdit()
   {
      if ($this->input->post('id')) {
         $data = array(
            'PlainProjectProgresTitle' => $this->input->post('title'),
            'PlainProjectProgresDesk' => $this->input->post('deskripsi'),
            'PlainProjectProgresStart' => $this->input->post('start'),
            'PlainProjectProgresEnd' => $this->input->post('end'),
         );
         $this->Fullcalendar_model->editSubProgres($data, $this->input->post('id'));
      }
   }
   function plainProjectExtend()
   {
      $data = array(
         'PlainProjectId' => $this->input->post('id'),
         'PlainProjectStartDate' => $this->input->post('start'),
         'PlainProjectEndDate' => $this->input->post('end'),
         'PlainProjectStatus' => "extend"
      );
      $this->Fullcalendar_model->extendProject($data, $this->input->post('id'));
   }
   function plainProjectFinish()
   {
      $data = array(
         'PlainProjectId' => $this->input->post('id'),
         'PlainProjectStatus' => "finish"
      );
      $this->Fullcalendar_model->finishProject($data, $this->input->post('id'));
   }
   // function plainProjectUpdateUseModal ()
   // {
   //    if($this->input->post('id'))
   //    {
   //       $data = array(
   //          'PlainProjectTitle' => $this->input->post('title'),
   //          'PlainProjectStartDate' => $this->input->post('start'),
   //          'PlainProjectEndDate' => $this->input->post('end')
   //       );
   //       $this->Fullcalendar_model->editProject($data, $this->input->post('id'));
   //    }
   // }
   function plainProjectDelete()
   {
      if ($this->input->post('id')) {
         $this->Fullcalendar_model->deleteProject($this->input->post('id'));
      }
   }
   function progresDelete()
   {
      if ($this->input->post('id')) {
         $this->Fullcalendar_model->deleteSubProgres($this->input->post('id'));
      }
   }

   function get_scan_qr_code()
   {
      $begin = new DateTime($this->input->post("startdate"));
      $end   = new DateTime($this->input->post("enddate"));

      for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
         $total = $this->db->where("QrScanDate", $i->format("Y-m-d"))->where("QrScanRef", $this->input->post("id"))->get("TblQrScan")->num_rows();
         $output[] = array(
            'day'   => $i->format("M d"),
            'total'  => $total,
         );
      }
      echo json_encode($output);
   }
   function get_scan_qr_code_os()
   {
      $total = $this->db->select("QrScanOS, COUNT(QrScanId) as count")
         ->where("QrScanDate >=", $this->input->post("startdate"))
         ->where("QrScanDate <=", $this->input->post("enddate"))
         ->where("QrScanRef", $this->input->post("id"))
         ->group_by("QrScanOS")->get("TblQrScan")->result();
      $output = array();
      foreach ($total as $row) {
         $output[] = array(
            'os'   => $row->QrScanOS,
            'total'  => $row->count,
         );
      }
      echo json_encode($output);
   }

   function get_scan_countries()
   {
      echo '<table class="table table-borderless table-sm m-4">
               <thead>
                  <tr>
                     <th scope="col">#</th>
                     <th scope="col">Country</th>
                     <th scope="col">Scans</th>
                     <th scope="col">%</th>
                  </tr>
               </thead>
               <tbody>';
      $data = $this->db->select("QrScanCountry, COUNT(QrScanId) as count")
         ->where("QrScanDate >=", $this->input->post("startdate"))
         ->where("QrScanDate <=", $this->input->post("enddate"))
         ->where("QrScanRef", $this->input->post("id"))
         ->group_by("QrScanCountry")->get("TblQrScan")->result();

      $datacount = ($this->db->select("COUNT(QrScanId) as count")
         ->where("QrScanDate >=", $this->input->post("startdate"))
         ->where("QrScanDate <=", $this->input->post("enddate"))
         ->where("QrScanRef", $this->input->post("id"))->get("TblQrScan")->row())->count;

      $no = 1;
      foreach ($data as $row) {
         echo '<tr>
                  <th scope="row">' . $no . '</th>
                  <td>' . $this->model_app->exchange_code_country($row->QrScanCountry) . '</td>
                  <td>' . $row->count . '</td>
                  <td>' . (100 / (int) $datacount) * $row->count . ' %</td>
               </tr>';
         $no++;
      }
      echo '   </tbody>
            </table>';
   }
   function get_scan_cities()
   {
      echo '<table class="table table-borderless table-sm m-4">
               <thead>
                  <tr>
                     <th scope="col">#</th>
                     <th scope="col">City</th>
                     <th scope="col">Scans</th>
                     <th scope="col">%</th>
                  </tr>
               </thead>
               <tbody>';
      $data = $this->db->select("QrScanCity, COUNT(QrScanId) as count")
         ->where("QrScanDate >=", $this->input->post("startdate"))
         ->where("QrScanDate <=", $this->input->post("enddate"))
         ->where("QrScanRef", $this->input->post("id"))
         ->group_by("QrScanCity")->get("TblQrScan")->result();

      $datacount = ($this->db->select("COUNT(QrScanId) as count")
         ->where("QrScanDate >=", $this->input->post("startdate"))
         ->where("QrScanDate <=", $this->input->post("enddate"))
         ->where("QrScanRef", $this->input->post("id"))->get("TblQrScan")->row())->count;

      $no = 1;
      foreach ($data as $row) {
         echo '<tr>
                  <th scope="row">' . $no . '</th>
                  <td>' .  $row->QrScanCity . '</td>
                  <td>' . $row->count . '</td>
                  <td>' . (100 / (int) $datacount) * $row->count . ' %</td>
               </tr>';
         $no++;
      }
      echo '   </tbody>
            </table>';
   }
   function get_divisi($ref)
   {
      $data = "";
      $getdivisi = $this->db->where("MsDivisiId", $ref)->get("TblMsDivisi")->row();
      if ($getdivisi) {
         $getdivisi1 = $this->db->where("MsDivisiId", $getdivisi->MsDivisiRef)->get("TblMsDivisi")->row();
         if ($getdivisi1) {
            $data = $this->get_divisi($getdivisi1->MsDivisiId) . "<span data-bs-toggle='tooltip' data-bs-placement='top' title='" . $getdivisi->MsDivisiName . "'>&nbsp;<i class='fas fa-angle-right'></i>&nbsp;" . $getdivisi->MsDivisiCode . "</span>";
         } else {
            $data = "<span data-bs-toggle='tooltip' data-bs-placement='top' title='" . $getdivisi->MsDivisiName . "'>" . $getdivisi->MsDivisiCode . "</span>";
         }
      } else {
         $data = "-";
      }
      return $data;
   }
   function get_data_project()
   {
      $datestart = $this->input->post("startDate");
      $dateend = $this->input->post("endDate");
      $divisi = $this->input->post("divisi");
      $search = $this->input->post("search");

      $check_data_project = function ($datestart, $dateend, $start, $end) {
         $curdate    = new DateTime($datestart);
         $finishdate = new DateTime($dateend);
         $startproject = new DateTime($start);
         $endproject = new DateTime($end);
         $isCheck = false;
         for ($i = $curdate; $i <= $finishdate; $i->modify('+1 day')) {
            if ($startproject <= $i && $endproject >= $i) {
               $isCheck = true;
               break;
            }
         }
         return $isCheck;
      };
      $data = $this->db
         ->order_by("MsDivisiId ASC ,PlainProjectStartDate")
         ->get("TblPlainProject")
         ->result();
      $data_project = array();
      foreach ($data as $row) {
         if ($check_data_project($datestart, $dateend, $row->PlainProjectStartDate, $row->PlainProjectEndDate)) {

            $data = $this->db
               ->where("PlainProjectProgresRef", $row->PlainProjectId)
               ->order_by("PlainProjectProgresStart")
               ->get("TblPlainProjectProgres")
               ->result();

            $data_project_list = array();
            foreach ($data as $row1) {
               $data_project_list[] =  array(
                  "id" => $row1->PlainProjectProgresId,
                  "title" => $row1->PlainProjectProgresTitle,
                  "desc" => $row1->PlainProjectProgresDesk,
                  "startdate" => $row1->PlainProjectProgresStart,
                  "enddate" => $row1->PlainProjectProgresEnd,
               );
            }

            $data_project[] = array(
               "id" => $row->PlainProjectId,
               "title" => $row->PlainProjectTitle,
               "divisi" => $this->get_divisi($row->MsDivisiId),
               "startdate" => $row->PlainProjectStartDate,
               "enddate" => $row->PlainProjectEndDate,
               "persentase" => $row->PlainProjectPersentase,
               "status" => $row->PlainProjectStatus,
               "subs" =>  $data_project_list
            );
         }
      }
      echo json_encode($data_project);
   }
   function load_project_table()
   {
      $start = $this->input->post("start");
      $end = $this->input->post("end");
   }

   function assetAdd()
   {
      if ($this->input->post('device')) {
         $data = array(
            'assetDivisiIdRef' => $this->input->post('divisiAsset'),
            'AssetTypeRef' => $this->input->post('device'),
            'AssetDetailMerk' => $this->input->post('merkDevice'),
            'AssetDetailType' => $this->input->post('type'),
            'AssetDetailUser' => $this->input->post('user'),
            'MsWorkplaceIdRef' => $this->input->post('grai'),
            'AssetDetailStatus' => $this->input->post('status'),
            'AssetDetailDeskripsi' => $this->input->post('deskripsi')
         );
         $this->Fullcalendar_model->addAsset($data);
      }
   }

   function assetEdit()
   {
      if ($this->input->post('id')) {
         $data = array(
            'assetDivisiIdRef' => $this->input->post('divisiAsset'),
            'AssetTypeRef' => $this->input->post('device'),
            'AssetDetailMerk' => $this->input->post('merkDevice'),
            'AssetDetailType' => $this->input->post('type'),
            'AssetDetailUser' => $this->input->post('user'),
            'MsWorkplaceIdRef' => $this->input->post('grai'),
            'AssetDetailStatus' => $this->input->post('status'),
            'AssetDetailDeskripsi' => $this->input->post('deskripsi')
         );
         $this->Fullcalendar_model->EditAsset($data, $this->input->post('id'));
      }
   }

   function assetStatus_add()
   {
      $this->db->insert('TblAssetKelola', $this->input->post());
      echo ($this->db->affected_rows() != 1) ? "false" : "true";
      exit;
   }

   function assetStatus_delete($id)
   {
      $this->db->delete('TblAssetKelola', array("assetKelolaId" => $id));
      echo ($this->db->affected_rows() != 1) ? "false" : "true";
      exit;
   }

   function assetStatus_edit($id)
   {
      $this->db->update('TblAssetKelola', $this->input->post(), array("assetKelolaId" => $id));
      echo ($this->db->affected_rows() != 1) ? "false" : "true";
      exit;
   }
}
