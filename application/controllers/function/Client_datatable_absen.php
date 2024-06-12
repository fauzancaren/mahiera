<?php
defined('BASEPATH') or exit('No direct script access allowed');
ini_set('max_execution_time', 0);
class Client_datatable_absen extends CI_Controller
{
   function __construct()
   {
      parent::__construct();
      $this->load->model('penjualan/Model_penjualan', 'm_penjualan');
      $this->load->model('model_app');
      $this->load->helper('directory');
      $this->load->library('image_lib');

      date_default_timezone_set('Asia/Jakarta');
   }
   function get_data_absen()
   {
      // SETUP DATATABLE
      $this->m_penjualan->table = 'TblAbsen';
      $this->m_penjualan->tablejoin = array(
         array(0 => 'TblMsWorkplace', 1 => 'TblAbsen.MsWorkplaceId=TblMsWorkplace.MsWorkplaceId'),
      );
      $this->m_penjualan->column_order = array(null, 'TblAbsen.MsEmpCode', 'TblAbsen.MsEmpName', 'TblAbsen.AbsenDate', 'TblAbsen.AbsenTime', 'MsWorkplaceCode', 'TblAbsen.System'); //set column field database for datatable orderable
      $this->m_penjualan->column_search = array('MsEmpCode', 'MsEmpName', 'AbsenDate', 'AbsenTime', 'MsWorkplaceCode', 'System'); //set column field database for datatable searchable 
      $this->m_penjualan->order = array('TblAbsen.MsWorkplaceId' => 'asc'); // default order 

      // PROSES DATA
      $list = $this->m_penjualan->get_datatables();
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $master) {
         $no++;
         $row = array();
         $row[] = $no;
         $row[] = $master->MsEmpCode;
         $row[] = $master->MsEmpName;
         $row[] = $master->AbsenDate;
         $row[] = $master->AbsenTime;
         $row[] = $master->MsWorkplaceCode;
         $row[] = ($master->System == 0 ? '<span class="badge rounded-pill bg-success pointer">System</span>' : '<span class="badge rounded-pill bg-warning pointer">Manual</span>');
         $row[] = $master->AbsenDesc;
         $row[] = '  <div class="d-flex flex-row">
                        <a onclick="edit_click(' . $master->AbsenId . ')" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                        <a onclick="comment_click(' . $master->AbsenId . ')" class="me-2 text-info pointer" title="Comment Data"><i class="fas fa-comment"></i></a>
                     </div>';
         $data[] = $row;
      }
      $output = array(
         "draw" => $_POST['draw'],
         "recordsTotal" => $this->m_penjualan->count_all(),
         "recordsFiltered" => $this->m_penjualan->count_filtered(),
         "data" => $data,
      );
      //output to json format
      echo json_encode($output);
   }
   function get_data_list_roster()
   {
      // SETUP DATATABLE
      $this->m_penjualan->table = 'TblRosterList';
      $this->m_penjualan->column_order = array(null, 'RosterListCode', 'RosterListDesc', 'RosterListTimeIn', 'RosterListTimeOut'); //set column field database for datatable orderable
      $this->m_penjualan->column_search = array('RosterListCode', 'RosterListDesc', 'RosterListTimeIn', 'RosterListTimeOut'); //set column field database for datatable searchable 
      $this->m_penjualan->order = array('RosterListId' => 'asc'); // default order 

      // PROSES DATA
      $list = $this->m_penjualan->get_datatables();
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $master) {
         $no++;
         $row = array();
         $row[] = $no;
         $row[] = $master->RosterListCode;
         $row[] = $master->RosterListDesc;
         $row[] = $master->RosterListTimeIn;
         $row[] = $master->RosterListTimeOut;
         $row[] = '  <div class="d-flex flex-row">
                        <a onclick="edit_click(' . $master->RosterListId . ')" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                        <a onclick="delete_click(' . $master->RosterListId . ')" class="me-2 text-danger pointer" title="delete Data"><i class="fas fa-trash-alt"></i></a>
                     </div>';
         $data[] = $row;
      }
      $output = array(
         "draw" => $_POST['draw'],
         "recordsTotal" => $this->m_penjualan->count_all(),
         "recordsFiltered" => $this->m_penjualan->count_filtered(),
         "data" => $data,
      );
      //output to json format
      echo json_encode($output);
   }
   function get_data_list_izinsakit()
   {
      // SETUP DATATABLE
      $this->m_penjualan->table = 'TblAbsenKelola';
      $this->m_penjualan->tablejoin = array(
         array(0 => "TblMsEmployee", 1 => "TblMsEmployee.MsEmpId=TblAbsenKelola.MsEmpId")
      );
      $this->m_penjualan->column_order = array(null, 'MsEmpName', 'AbsenKelolaDesc', 'AbsenKelolaDate'); //set column field database for datatable orderable
      $this->m_penjualan->column_search = array('MsEmpCode', 'MsEmpName', 'AbsenKelolaDesc','AbsenKelolaNote','AbsenKelolaDate'); //set column field database for datatable searchable 
      $this->m_penjualan->order = array('AbsenKelolaDate' => 'DESC'); // default order 
      // PROSES DATA
      $list = $this->m_penjualan->get_datatables();
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $master) {
         $no++;
         $row = array();
         $row[] = $no;
         $row[] = $master->MsEmpCode . "-" . $master->MsEmpName;
         $row[] = $master->AbsenKelolaDesc;
         $row[] = $master->AbsenKelolaNote;
         $row[] = $master->AbsenKelolaDate;
         $row[] = '  <div class="d-flex flex-row">
                        <a onclick="edit_click(' . $master->AbsenKelolaId . ')" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                        <a onclick="delete_click(' . $master->AbsenKelolaId . ')" class="me-2 text-danger pointer" title="delete Data"><i class="fas fa-trash-alt"></i></a>
                     </div>';
         $data[] = $row;
      }
      $output = array(
         "draw" => $_POST['draw'],
         "recordsTotal" => $this->m_penjualan->count_all(),
         "recordsFiltered" => $this->m_penjualan->count_filtered(),
         "data" => $data,
      );
      //output to json format
      echo json_encode($output);
   }
   function get_data_list_lembur()
   {
      // SETUP DATATABLE
      $this->m_penjualan->table = 'TblAbsenLembur';
      $this->m_penjualan->tablejoin = array(
         array(0 => "TblMsEmployee", 1 => "TblMsEmployee.MsEmpId=TblAbsenLembur.MsEmpId"),
         array(0 => "TblAbsenLemburType", 1 => "TblAbsenLemburType.AbsenLemburTypeId=TblAbsenLembur.AbsenLemburType")
      );
      $this->m_penjualan->column_order = array(null, 'MsEmpName', 'AbsenLemburDesc', 'AbsenLemburDate'); //set column field database for datatable orderable
      $this->m_penjualan->column_search = array('MsEmpCode', 'MsEmpName', 'AbsenLemburDesc', 'AbsenLemburDate'); //set column field database for datatable searchable 
      $this->m_penjualan->order = array('AbsenLemburDate' => 'DESC'); // default order 
      // PROSES DATA
      $list = $this->m_penjualan->get_datatables();
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $master) {
         $no++;
         $row = array();
         $row[] = $no;
         $row[] = $master->MsEmpCode . "-" . $master->MsEmpName;
         $row[] = $master->AbsenLemburDate;
         $row[] = $master->AbsenLemburTypeName;
         $row[] = $master->AbsenLemburDesc;
         $row[] = '  <div class="d-flex flex-row">
                        <a onclick="edit_click(' . $master->AbsenLemburId . ')" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                        <a onclick="delete_click(' . $master->AbsenLemburId . ')" class="me-2 text-danger pointer" title="delete Data"><i class="fas fa-trash-alt"></i></a>
                     </div>';
         $data[] = $row;
      }
      $output = array(
         "draw" => $_POST['draw'],
         "recordsTotal" => $this->m_penjualan->count_all(),
         "recordsFiltered" => $this->m_penjualan->count_filtered(),
         "data" => $data,
      );
      //output to json format
      echo json_encode($output);
   }
}
