<?php
defined('BASEPATH') or exit('No direct script access allowed');
ini_set('max_execution_time', 0);
class Client_datatable_inventory extends CI_Controller
{
      function __construct()
      {
            parent::__construct();
            $this->load->model('pengiriman/Model_pengiriman', 'm_inventory');
            $this->load->model('model_app');

            date_default_timezone_set('Asia/Jakarta');
      }
      function get_data_stock()
      {
            // SETUP DATATABLE
            $this->m_inventory->table = 'TblInvStock';
            $this->m_inventory->tablejoin = array(
                  array(0 => 'TblMsItem', 1 => 'TblInvStock.MsItemId=TblMsItem.MsItemId'),
                  array(0 => 'TblMsVendor', 1 => 'TblMsVendor.MsVendorId=TblInvStock.MsVendorId'),
                  array(0 => 'TblMsWorkplace', 1 => 'TblMsWorkplace.MsWorkplaceId = TblInvStock.MsWorkplaceId')
            );
            $this->m_inventory->column_order = array(null, 'MsItemCode', 'MsItemName', "MsVendorCode", 'MsWorkplaceCode', 'MsItemSize', 'InvStockQty', 'InvStockBuffer'); //set column field database for datatable orderable
            $this->m_inventory->column_search = array('MsItemCode', 'MsItemName', "MsVendorCode", 'MsWorkplaceCode', 'MsItemSize', 'InvStockQty', 'InvStockBuffer'); //set column field database for datatable searchable 
            $this->m_inventory->order = array('MsItemCode' => 'asc', 'MsWorkplaceCode' => 'asc'); // default order 

            // PROSES DATA
            $list = $this->m_inventory->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $master) {
                  $no++;
                  $row = array();
                  $row[] = $no;
                  $row[] = $master->MsItemCode;
                  $row[] = $master->MsItemName;
                  $row[] = $master->MsVendorCode;
                  $row[] = $master->MsWorkplaceCode;
                  $row[] = $master->MsItemSize;
                  $row[] = $master->InvStockQty;
                  $row[] = $master->InvStockBuffer . '&nbsp;<a onclick="edit_buffer(' . $master->InvStockId . ')" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>';
                  $row[] = ' <a onclick="log_click(' . $master->InvStockId . ')" class="me-2 text-primary pointer" title="Log Data"><i class="fas fa-exchange-alt"></i>&nbsp;Log Data</a>';
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->m_inventory->count_all(),
                  "recordsFiltered" => $this->m_inventory->count_filtered(),
                  "data" => $data,
            );
            //output to json format
            echo json_encode($output);
      }
      function get_list_stock(){
              // SETUP DATATABLE
            $pagenow = $this->input->post("page");
            $search = $this->input->post("search"); 
            $kategori = $this->input->post("kategori");
            $store = $this->input->post("store");
            $varian = $this->input->post("varian");
            $page = ((int)$pagenow * 10) - 10;

            $this->db->join("TblMsItemCategory","a.MsProdukCatId=TblMsItemCategory.MsItemCatId"); 
            if($kategori!="") $this->db->where("MsProdukCatId",$kategori); 
            if($varian != null){ 
                  $where_in_varian = "MsProdukId in (SELECT MsProdukDetailRef FROM TblMsProdukDetail WHERE "; 
                  foreach($varian as $key => $value) {
                        if($key == 0) {
                              $where_in_varian .= "LOWER(MsProdukDetailVarian) LIKE '%".strtolower($value)."%' ";
                        } else {
                              $where_in_varian .= "or LOWER(MsProdukDetailVarian) LIKE '%".strtolower($value)."%' "; 
                        } 
                  }  
                  $where_in_varian .= ")";
                  $this->db->where($where_in_varian, NULL, FALSE);
            }
            $this->db->group_start()->like("MsProdukCode",$search)->or_like("MsProdukName",$search)->or_like("a.MsProdukVarian",$search)->group_end();
            $count =  $this->db->get("TblMsProduk as a")->num_rows();

            $this->db->join("TblMsItemCategory","a.MsProdukCatId=TblMsItemCategory.MsItemCatId");  
            if($kategori!="") $this->db->where("MsProdukCatId",$kategori);
            if($varian != null){ 
                  $where_in_varian = "MsProdukId in (SELECT MsProdukDetailRef FROM TblMsProdukDetail WHERE "; 
                  foreach($varian as $key => $value) {
                        if($key == 0) {
                              $where_in_varian .= "LOWER(MsProdukDetailVarian) LIKE '%".strtolower($value)."%' ";
                        } else {
                              $where_in_varian .= "or LOWER(MsProdukDetailVarian) LIKE '%".strtolower($value)."%' "; 
                        } 
                  }  
                  $where_in_varian .= ")";
                  $this->db->where($where_in_varian, NULL, FALSE);
            }
            $this->db->group_start()->like("MsProdukCode",$search)->or_like("MsProdukName",$search)->or_like("a.MsProdukVarian",$search)->group_end();
            $list = $this->db->limit(10,$page)->get("TblMsProduk as a")->result(); 



            $data = array();
            foreach ($list as $master) {
                  if (file_exists(getcwd() . "/asset/image/produk/" .  $master->MsProdukId."/".$master->MsProdukCode."_1.png")) {
                        $urlimage = base_url("asset/image/produk/".$master->MsProdukId."/".$master->MsProdukCode."_1.png");
                  }else{ 
                        $urlimage = base_url("asset/image/mgs-erp/defaultitem.png");
                  }
                  $row = array();
                  $this->db->join("TblMsSatuan","TblMsSatuan.SatuanId=TblMsProdukDetail.SatuanId")
                        ->join("TblMsBerat","TblMsBerat.BeratId=TblMsProdukDetail.BeratId")
                        ->join("TblMsProdukStock","(TblMsProdukStock.MsProdukId=TblMsProdukDetail.MsProdukDetailRef and TblMsProdukStock.MsProdukVarian=TblMsProdukDetail.MsProdukDetailVarian)")
                        ->join("TblMsWorkplace","TblMsWorkplace.MsWorkplaceId=TblMsProdukStock.MsWorkplaceId");
                  if($store!="") $this->db->where("TblMsProdukStock.MsWorkplaceId",$store);
                  if($varian != null){
                        $this->db->group_start();
                        foreach($varian as $key => $value) {
                              if($key == 0) {
                                    $this->db->like('MsProdukDetailVarian', $value);
                              } else {
                                    $this->db->or_like('MsProdukDetailVarian', $value);
                              }
                        }
                        $this->db->group_end();
                  }
                 
                  $datastock =  $this->db->where("MsProdukDetailRef",$master->MsProdukId)->get("TblMsProdukDetail")->result();
                  
                  $row["MsProdukId"] = $master->MsProdukId;
                  $row["MsProdukCode"] = $master->MsProdukCode;
                  $row["MsProdukName"] = $master->MsProdukName;
                  $row["MsProdukCategory"] = $master->MsItemCatName;
                  $row["MsProdukVarian"] = $master->MsProdukVarian;
                  $row["MsProdukImage"] = $urlimage;  
                  $row["MsProdukStock"] = $datastock;
                        
                        
                  $data[] = $row;
            } 
            $output = array( 
            "data" => $data,
            "count" => $count,
            );

            //output to json format
            echo json_encode($output);
      }

      
      function get_data_trans()
      {

            $list = $this->db->query('CALL tracking(' . $_POST['search']['status1'] . ',' . $_POST['search']['status'] . ',"' . $_POST['search']['status2'] . '","' . $_POST['search']['tanggalstart'] . '","' . $_POST['search']['tanggalend'] . '")');
            $data = array();
            foreach ($list->result() as $master) {
                  $row = array();
                  $row[] = $master->TransDate;
                  $row[] = $master->TransType;
                  $row[] = $master->TransCode;
                  $row[] = $master->TransLastStock;
                  $row[] = ($master->TransQtyMin == 0 ? $master->TransQtyPlus : "-" . $master->TransQtyMin);
                  $row[] = $master->TransStock;
                  $row[] = $master->TransRemarks;
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $list->num_rows(),
                  "recordsFiltered" =>  $list->num_rows(),
                  "data" => $data,
            );
            //output to json format
            echo json_encode($output);
      }

      function get_data_to()
      {
            // SETUP DATATABLE
            $this->m_inventory->table = 'TblInvTO';
            $this->m_inventory->select = array("TblInvTO.InvTODate", "TblInvTO.InvTOCode", "a.MsWorkplaceCode as source", "b.MsWorkplaceCode as dest", "c.MsEmpName", "TblInvTO.InvTORemarks", "TblInvTO.InvTOId", "InvTOStatus");
            $this->m_inventory->tablejoin = array(
                  array(0 => 'TblMsWorkplace as a', 1 => 'a.MsWorkplaceId=TblInvTO.InvTOSrc'),
                  array(0 => 'TblMsWorkplace as b', 1 => 'b.MsWorkplaceId=TblInvTO.InvTODst'),
                  array(0 => 'TblMsEmployee as c', 1 => 'c.MsEmpId=TblInvTO.MsEmpId')
            );
            $this->m_inventory->column_order = array(null, 'InvTODate', 'InvTOCode', 'source', 'dest', 'MsEmpName', 'InvTORemarks', 'InvTOStatus'); //set column field database for datatable orderable
            $this->m_inventory->column_search = array('InvTODate', 'InvTOCode', 'source', 'dest', 'MsEmpName', 'InvTORemarks', 'InvTOStatus'); //set column field database for datatable searchable 
            $this->m_inventory->order = array('InvTODate' => 'desc', 'InvTOId' => 'desc'); // default order 

            // PROSES DATA
            $list = $this->m_inventory->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $master) {
                  $no++;
                  if ($master->InvTOStatus == 0) {
                        $action = '  
                        <div class="d-flex flex-row">
                              <a onclick="edit_click(' . $master->InvTOId . ')" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                              <a onclick="print_click(' . $master->InvTOId . ')" class="me-2 text-primary pointer" title="Edit Data"><i class="fas fa-print"></i></a> 
                              <a onclick="delete_click(' . $master->InvTOId . ')" class="me-2 text-danger pointer" title="Edit Data"><i class="fas fa-times"></i></a>
                        </div>';
                  } else {
                        $action = '  
                        <div class="d-flex flex-row">
                              <a onclick="print_click(' . $master->InvTOId . ')" class="me-2 text-primary pointer" title="Edit Data"><i class="fas fa-print"></i></a> 
                        </div>';
                  }
                  $row = array();
                  $row[] = $no;
                  $row[] = $master->InvTODate;
                  $row[] = $master->InvTOCode;
                  $row[] = $master->source;
                  $row[] = $master->dest;
                  $row[] = $master->MsEmpName;
                  $row[] = $master->InvTORemarks;
                  $row[] = $master->InvTOStatus;
                  $row[] = $master->InvTOCode;
                  $row[] = $action;
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->m_inventory->count_all(),
                  "recordsFiltered" => $this->m_inventory->count_filtered(),
                  "data" => $data,
            );
            //output to json format
            echo json_encode($output);
      }

      function get_detail_to()
      {
            $query1 = $this->db->query("select * from TblInvTODetail left join TblMsItem on TblInvTODetail.MsItemId=TblMsItem.MsItemId LEFT JOIN TblMsItemCategory on TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId  where InvTODetailRef='" . $this->input->post("code") . "'")->result();
            $detailpo = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;width:100%">';
            foreach ($query1 as $row1) {
                  $detailpo .= '    <tr><td><div class="row align-items-center border-light border-bottom border-top me-2 py-1">
                                    <div class="col-8">
                                          <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemCode . '-' . $row1->MsItemName . ' (' . $row1->MsVendorCode . ')</span><br>
                                          <span class="text-secondary">Ukuran : <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemSize . '</span></span>
                                    </div>
                                    <div class="col-4 text-right">
                                          <span class="text-secondary">Qty</span><br>
                                          <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->InvTODetailQty . ' ' . $row1->MsItemUoM . '</span>
                                    </div>
                              </div>
                              </tr></td>';
            }
            echo  $detailpo . '</table>';
      }

      function get_data_ti_ref()
      {
            $search = $this->input->post("search");

            $data = $this->db
                  ->join("TblInvTODetail", "TblInvTODetail.InvTODetailRef=TblInvTO.InvTOCode", "left")
                  ->join("TblMsItem", "TblMsItem.MsItemId=TblInvTODetail.MsItemId", "left")
                  ->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblInvTO.MsEmpId", "left")
                  ->group_start()
                  ->like("InvTOCode", $search)
                  ->or_like("InvTORemarks", $search)
                  ->or_like("MsItemName", $search)
                  ->or_like("MsItemCode", $search)
                  ->group_end()
                  ->where("InvTOStatus", "0")
                  ->like("TblInvTO.InvTOSrc", $this->input->post("InvTOSrc"))
                  ->like("TblInvTO.InvTODst", $this->input->post("InvTODst"))
                  ->group_by("InvTOCode")
                  ->order_by('InvTODate DESC,InvTOId DESC')
                  ->get("TblInvTO", 10)->result();
            $content = "";
            foreach ($data as $row) {
                  $query = $this->db->query("select * from TblInvTODetail 
                  left join TblMsItem on TblInvTODetail.MsItemId=TblMsItem.MsItemId 
                  LEFT JOIN TblMsItemCategory on TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId  
                  where InvTODetailRef='" . $row->InvTOCode . "'")->result();
                  $item = "";
                  foreach ($query as $rows) {
                        $item .= '<div class="row py-1 g-2">
                                    <div class="col-md-4 col-12 ps-md-4">
                                          <span class="fw-bold" style="font-size:0.7rem;">' . $rows->MsItemCode . ' - ' . $rows->MsItemName . ' </span> 
                                          <div class="row">  
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;">Vendor</span>
                                                </div>    
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-dark" style="font-size:11px;">' . $row->MsVendorCode  . '</span>
                                                </div>
                                          </div> 
                                    </div>
                                    <div class="col-md-8 col-8 px-md-2 mt-0 mt-md-1">
                                          <div class="row g-1 mt-0 mt-md-1" style="font-size:0.75rem"> 
                                                <div class="col-md-6 mt-0 mt-md-1">
                                                      <div class="row">
                                                            <div class="col-auto pe-0" style="min-width:70px;">
                                                                  <span class="fw-bold text-secondary">Ukuran</span>
                                                            </div>      
                                                            <div class="col pe-0">
                                                                  <span class="text-dark fw-bold">' . $rows->MsItemSize . '</span>
                                                            </div>
                                                      </div>
                                                      <div class="row">
                                                            <div class="col-auto pe-0 " style="min-width:70px;">
                                                                  <span class="fw-bold text-secondary">Qty</span>
                                                            </div>      
                                                            <div class="col pe-0">
                                                                  <span class="text-dark fw-bold">' . number_format($rows->InvTODetailQty) . ' ' . $rows->MsItemUoM . '</span>
                                                            </div>
                                                      </div>
                                                </div>
                                          </div>
                                    </div> 
                              </div> ';
                  }
                  if (strlen($item) == 0) $item = "<div class='text-center'>Tidak Ada Data</div>";

                  $content .= '<div class="row datatable-header m-1">
                                    <div class="col-md-6 col-sm-12 p-1 g-1">
                                          <div class="row">  
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;"><i class="fas fa-id-card"></i></span>
                                                </div>    
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-orange" style="font-size:11px;">' . $row->InvTOCode . '</span>
                                                </div>
                                          </div> 
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;">Tanggal</span>
                                                </div>      
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-dark" style="font-size:12px;">' . date_format(date_create($row->InvTODate), "d F Y") . '</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-dark" style="font-size:12px;">' . $this->model_app->get_single_data("MsWorkplaceCode", "TblMsWorkplace", array("MsWorkplaceId" => $row->InvTOSrc)) . '</span>
                                                      <i class="fas fa-arrow-right"></i></span>
                                                </div>      
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-dark" style="font-size:12px;">' . $this->model_app->get_single_data("MsWorkplaceCode", "TblMsWorkplace", array("MsWorkplaceId" => $row->InvTODst)) . '</span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 p-1 g-1" >
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;">Admin</span>
                                                </div>      
                                                <div class="col pe-0"> 
                                                      <span class="fw-bold text-dark" style="font-size:12px;">' .  $row->MsEmpName   . '</span>
                                                </div>
                                          </div>  
                                          <div class="row">  
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;">Keterangan</span>
                                                </div>    
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-dark" style="font-size:11px;">' . $row->InvTORemarks . '</span>
                                                </div>
                                          </div> 
                                    </div> 
                                    <div class="col-12 g-1">
                                          <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                      <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#detail-item-' . $row->InvTOId . '" type="button" role="tab" aria-controls="detail-item-' . $row->InvTOId . '" aria-selected="true">Detail Item</button>
                                                </li> 
                                          </ul>
                                          <div class="tab-content" >
                                                <div class="tab-pane p-2 border border-top-0 fade show active" id="detail-item-' . $row->InvTOId . '"" role="tabpanel" aria-labelledby="detail-item-' . $row->InvTOId . '">
                                                      ' . $item . ' 
                                                </div> 
                                          </div>
                                    </div> 
                                    <div class="datatable-action py-2 mt-1"> 
                                          <div class="dropdown float-end dropup"> 
                                                <button class="btn btn-success btn-sm py-1" type="button" onclick="InvTO_select(\'' . $row->InvTOId . '\' )">
                                                      pilih data ini
                                                </button>
                                          </div>
                                    </div>
                              </div>';
            }
            if ($content == "") {
                  $content = '
                        <div>
					<img src="' . base_url("asset/image/mgs-erp/iconnotfound.png") . '" class="rounded mx-auto d-block" alt="...">
				</div>';
            }
            echo $content;
      }

      function get_data_ti()
      {
            // SETUP DATATABLE
            $this->m_inventory->table = 'TblInvTI';
            $this->m_inventory->select = array("TblInvTI.InvTIDate", "TblInvTI.InvTICode", "TblInvTI.InvTIRef", "a.MsWorkplaceCode as source", "b.MsWorkplaceCode as dest", "c.MsEmpName", "TblInvTI.InvTIRemarks", "TblInvTI.InvTIId");
            $this->m_inventory->tablejoin = array(
                  array(0 => 'TblMsWorkplace as a', 1 => 'a.MsWorkplaceId=TblInvTI.InvTISrc'),
                  array(0 => 'TblMsWorkplace as b', 1 => 'b.MsWorkplaceId=TblInvTI.InvTIDst'),
                  array(0 => 'TblMsEmployee as c', 1 => 'c.MsEmpId=TblInvTI.MsEmpId')
            );
            $this->m_inventory->column_order = array(null, 'InvTIDate', 'InvTICode', 'InvTIRef', 'source', 'dest', 'MsEmpName', 'InvTIRemarks'); //set column field database for datatable orderable
            $this->m_inventory->column_search = array('InvTIDate', 'InvTICode', 'InvTIRef', 'source', 'dest', 'MsEmpName', 'InvTIRemarks'); //set column field database for datatable searchable 
            $this->m_inventory->order = array('InvTIDate' => 'desc', 'InvTIId' => 'desc'); // default order 

            // PROSES DATA
            $list = $this->m_inventory->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $master) {

                  $no++;
                  $row = array();
                  $row[] = $no;
                  $row[] = $master->InvTIDate;
                  $row[] = $master->InvTICode;
                  $row[] = $master->InvTIRef;
                  $row[] = $master->source;
                  $row[] = $master->dest;
                  $row[] = $master->MsEmpName;
                  $row[] = $master->InvTIRemarks;
                  $row[] = $master->InvTICode;
                  $row[] = '  
                  <div class="d-flex flex-row">
                        <a onclick="print_click(' . $master->InvTIId . ')" class="me-2 text-primary pointer" title="Edit Data"><i class="fas fa-print"></i></a> 
                  </div>';
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->m_inventory->count_all(),
                  "recordsFiltered" => $this->m_inventory->count_filtered(),
                  "data" => $data,
            );
            //output to json format
            echo json_encode($output);
      }

      function get_detail_ti()
      {
            $query1 = $this->db->query("select * from TblInvTIDetail left join TblMsItem on TblInvTIDetail.MsItemId=TblMsItem.MsItemId LEFT JOIN TblMsItemCategory on TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId  where InvTIDetailRef='" . $this->input->post("code") . "'")->result();
            $detailpo = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;width:100%">';
            foreach ($query1 as $row1) {
                  $detailpo .= '    <tr><td><div class="row align-items-center border-light border-bottom border-top me-2 py-1">
                                    <div class="col-8">
                                          <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemCode . '-' . $row1->MsItemName . ' (' . $row1->MsVendorCode . ')</span><br>
                                          <span class="text-secondary">Ukuran : <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemSize . '</span></span>
                                    </div>
                                    <div class="col-4 text-right">
                                          <span class="text-secondary">Qty</span><br>
                                          <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->InvTIDetailQty . ' ' . $row1->MsItemUoM . '</span>
                                    </div>
                              </div>
                              </tr></td>';
            }
            echo  $detailpo . '</table>';
      }

      function get_data_waste()
      {
            // SETUP DATATABLE
            $this->m_inventory->table = 'TblInvWaste';
            $this->m_inventory->select = array("InvWasteDate", "InvWasteCode", "MsWorkplaceCode", "MsEmpName", "InvWasteRemarks", "InvWasteId");
            $this->m_inventory->tablejoin = array(
                  array(0 => 'TblMsWorkplace', 1 => 'TblMsWorkplace.MsWorkplaceId=TblInvWaste.MsWorkplaceId'),
                  array(0 => 'TblMsEmployee', 1 => 'TblMsEmployee.MsEmpId=TblInvWaste.MsEmpId')
            );
            $this->m_inventory->column_order = array(null, 'InvWasteDate', 'InvWasteCode',  'MsWorkplaceCode', 'MsEmpName', 'InvWasteRemarks'); //set column field database for datatable orderable
            $this->m_inventory->column_search = array('InvWasteDate', 'InvWasteCode', 'MsWorkplaceCode',   'MsEmpName', 'InvWasteRemarks'); //set column field database for datatable searchable 
            $this->m_inventory->order = array('InvWasteDate' => 'desc', 'InvWasteId' => 'desc'); // default order 

            // PROSES DATA
            $list = $this->m_inventory->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $master) {
                  $no++;
                  $row = array();
                  $row[] = $no;
                  $row[] = $master->InvWasteDate;
                  $row[] = $master->InvWasteCode;
                  $row[] = $master->MsWorkplaceCode;
                  $row[] = $master->MsEmpName;
                  $row[] = $master->InvWasteRemarks;
                  $row[] = $master->InvWasteCode;
                  $row[] = '  
                  <div class="d-flex flex-row">
                        <a onclick="edit_click(' . $master->InvWasteId . ')" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                        <a onclick="print_click(' . $master->InvWasteId . ')" class="me-2 text-primary pointer" title="Edit Data"><i class="fas fa-print"></i></a> 
                        <a onclick="delete_click(' . $master->InvWasteId . ')" class="me-2 text-danger pointer" title="Edit Data"><i class="fas fa-times"></i></a>
                  </div>';
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->m_inventory->count_all(),
                  "recordsFiltered" => $this->m_inventory->count_filtered(),
                  "data" => $data,
            );
            //output to json format
            echo json_encode($output);
      }

      function get_detail_waste()
      {
            $query1 = $this->db->query("select * from TblInvWasteDetail 
            left join TblMsItem on TblInvWasteDetail.MsItemId=TblMsItem.MsItemId 
            LEFT JOIN TblMsItemCategory on TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId
            where InvWasteDetailRef='" . $this->input->post("code") . "'")->result();
            $detailpo = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;width:100%">';
            foreach ($query1 as $row1) {
                  $detailpo .= '    <tr><td><div class="row align-items-center border-light border-bottom border-top me-2 py-1">
                                    <div class="col-8">
                                          <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemCode . '-' . $row1->MsItemName . ' (' . $row1->MsVendorCode . ')</span><br>
                                          <span class="text-secondary">Ukuran : <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemSize . '</span></span>
                                    </div>
                                    <div class="col-4 text-right">
                                          <span class="text-secondary">Qty</span><br>
                                          <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->InvWasteDetailQty . ' ' . $row1->MsItemUoM . '</span>
                                    </div>
                              </div>
                              </tr></td>';
            }
            echo  $detailpo . '</table>';
      }

      function get_data_sample()
      {
            // SETUP DATATABLE
            $this->m_inventory->table = 'TblInvSample';
            $this->m_inventory->select = array("InvSampleDate", "InvSampleCode", "MsWorkplaceCode", "MsEmpName", "TblMsCustomer.MsCustomerId", "InvSampleRemarks", "InvSampleId");
            $this->m_inventory->tablejoin = array(
                  array(0 => 'TblMsWorkplace', 1 => 'TblMsWorkplace.MsWorkplaceId=TblInvSample.MsWorkplaceId'),
                  array(0 => 'TblMsEmployee', 1 => 'TblMsEmployee.MsEmpId=TblInvSample.MsEmpId'),
                  array(0 => 'TblMsCustomer', 1 => 'TblMsCustomer.MsCustomerId=TblInvSample.MsCustomerId')
            );
            $this->m_inventory->column_order = array(null, 'InvSampleDate', 'InvSampleCode',  'MsWorkplaceCode', 'MsEmpName', "TblMsCustomer.MsCustomerId", 'InvSampleRemarks'); //set column field database for datatable orderable
            $this->m_inventory->column_search = array('InvSampleDate', 'InvSampleCode', 'MsWorkplaceCode',   'MsEmpName', "MsCustomerName", "MsCustomerAddress", "MsCustomerCode", "MsCustomerTelp1", "MsCustomerTelp2", 'InvSampleRemarks'); //set column field database for datatable searchable 
            $this->m_inventory->order = array('InvSampleDate' => 'desc', 'InvSampleId' => 'desc'); // default order 

            // PROSES DATA
            $list = $this->m_inventory->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $master) {
                  $no++;
                  $row = array();
                  $row[] = $no;
                  $row[] = $master->InvSampleDate;
                  $row[] = $master->InvSampleCode;
                  $row[] = $master->MsWorkplaceCode;
                  $row[] = $master->MsEmpName;
                  $row[] =  $this->model_app->get_customer_name($master->MsCustomerId);
                  $row[] = $master->InvSampleRemarks;
                  $row[] = $master->InvSampleCode;
                  $row[] = '  
                  <div class="d-flex flex-row">
                        <a onclick="edit_click(' . $master->InvSampleId . ')" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                        <a onclick="print_click(' . $master->InvSampleId . ')" class="me-2 text-primary pointer" title="Edit Data"><i class="fas fa-print"></i></a> 
                        <a onclick="delete_click(' . $master->InvSampleId . ')" class="me-2 text-danger pointer" title="Edit Data"><i class="fas fa-times"></i></a>
                  </div>';
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->m_inventory->count_all(),
                  "recordsFiltered" => $this->m_inventory->count_filtered(),
                  "data" => $data,
            );
            //output to json format
            echo json_encode($output);
      }

      function get_detail_sample()
      {
            $query1 = $this->db->query("select * from TblInvSampleDetail 
            left join TblMsItem on TblInvSampleDetail.MsItemId=TblMsItem.MsItemId 
            LEFT JOIN TblMsItemCategory on TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId
            where InvSampleDetailRef='" . $this->input->post("code") . "'")->result();
            $detailpo = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;width:100%">';
            foreach ($query1 as $row1) {
                  $detailpo .= '    <tr><td><div class="row align-items-center border-light border-bottom border-top me-2 py-1">
                                    <div class="col-8">
                                          <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemCode . '-' . $row1->MsItemName . ' (' . $row1->MsVendorCode . ')</span><br>
                                          <span class="text-secondary">Ukuran : <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemSize . '</span></span>
                                    </div>
                                    <div class="col-4 text-right">
                                          <span class="text-secondary">Qty</span><br>
                                          <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->InvSampleDetailQty . ' ' . $row1->MsItemUoM . '</span>
                                    </div>
                              </div>
                              </tr></td>';
            }
            echo  $detailpo . '</table>';
      }

      function get_data_so()
      {
            // SETUP DATATABLE
            $this->m_inventory->table = 'TblInvSO';
            $this->m_inventory->select = array("InvSODate", "InvSOCode", "MsWorkplaceCode", "MsEmpName", "InvSORemarks", "InvSOId");
            $this->m_inventory->tablejoin = array(
                  array(0 => 'TblMsWorkplace', 1 => 'TblMsWorkplace.MsWorkplaceId=TblInvSO.MsWorkplaceId'),
                  array(0 => 'TblMsEmployee', 1 => 'TblMsEmployee.MsEmpId=TblInvSO.MsEmpId')
            );
            $this->m_inventory->column_order = array(null, 'InvSODate', 'InvSOCode',  'MsWorkplaceCode', 'MsEmpName', 'InvSORemarks'); //set column field database for datatable orderable
            $this->m_inventory->column_search = array('InvSODate', 'InvSOCode', 'MsWorkplaceCode',   'MsEmpName', 'InvSORemarks'); //set column field database for datatable searchable 
            $this->m_inventory->order = array('InvSODate' => 'desc', 'InvSOId' => 'desc'); // default order 

            // PROSES DATA
            $list = $this->m_inventory->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $master) {
                  $no++;
                  $row = array();
                  $row[] = $no;
                  $row[] = $master->InvSODate;
                  $row[] = $master->InvSOCode;
                  $row[] = $master->MsWorkplaceCode;
                  $row[] = $master->MsEmpName;
                  $row[] = $master->InvSORemarks;
                  $row[] = $master->InvSOCode;
                  $row[] = '  
                  <div class="d-flex flex-row"> 
                        <a onclick="print_click(' . $master->InvSOId . ')" class="me-2 text-primary pointer" title="Edit Data"><i class="fas fa-print"></i></a>  
                  </div>';
                  $data[] = $row;
            }
            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->m_inventory->count_all(),
                  "recordsFiltered" => $this->m_inventory->count_filtered(),
                  "data" => $data,
            );
            //output to json format
            echo json_encode($output);
      }
      
      function get_detail_so()
      {
            $query1 = $this->db->query("select * from TblInvSODetail 
            left join TblMsItem on TblInvSODetail.MsItemId=TblMsItem.MsItemId 
            LEFT JOIN TblMsItemCategory on TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId
            where InvSODetailRef='" . $this->input->post("code") . "'")->result();
            $detailpo = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;width:100%">';
            foreach ($query1 as $row1) {
                  $detailpo .= '    <tr><td><div class="row align-items-center border-light border-bottom border-top me-2 py-1">
                                    <div class="col-6">
                                          <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemCode . '-' . $row1->MsItemName . ' (' . $row1->MsVendorCode . ')</span><br>
                                          <span class="text-secondary">Ukuran : <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemSize . '</span></span>
                                    </div>
                                    <div class="col-2 text-right">
                                          <span class="text-secondary">Stock Awal</span><br>
                                          <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->InvSODetailQtyOld . ' ' . $row1->MsItemUoM . '</span>
                                    </div>
                                    <div class="col-2 text-right">
                                          <span class="text-secondary">Qty Adj</span><br>
                                          <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->InvSODetailQtyAdj . ' ' . $row1->MsItemUoM . '</span>
                                    </div>
                                    <div class="col-2 text-right">
                                          <span class="text-secondary">Stock Akhir</span><br>
                                          <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->InvSODetailQtyNew . ' ' . $row1->MsItemUoM . '</span>
                                    </div>
                              </div>
                              </tr></td>';
            }
            echo  $detailpo . '</table>';
      }

      function get_menu_produksi_baru(){
            $datapo = $this->db
            ->select("*, store.MsWorkplaceCode as toko,dst.MsWorkplaceCode as tujuan")
            ->join("TblMsWorkplace as store","store.MsWorkplaceId=TblPO.MsWorkplaceId","left")
            ->join("TblMsWorkplace as dst","dst.MsWorkplaceId=TblPO.PODst","left")
            ->join("TblMsEmployee","TblMsEmployee.MsEmpId=TblPO.MsEmpId","left")
            ->where_in("POStatus",array(0,1))->where("MsVendorId",17)->get("TblPO")->result();
            $number = 0;
            $content = "";  
            foreach($datapo as $row){
                  $number++;
                  $item = "";
                  $dataitem = $this->db
                        ->join("TblMsItem","TblMsItem.MsItemId=TblPODetail.MsItemId")
                        ->where("PODetailRef",$row->POCode)->get("TblPODetail")->result();

                  foreach($dataitem as $rowitem){
                        $dataready = $this->db 
                              ->where("ProduksiRef",$row->POCode)
                              ->where("MsItemId",$rowitem->MsItemId)
                              ->where("MsVendorCode",$rowitem->MsVendorCode) 
                              ->get("TblProduksi")->result();
                        $countready = 0;
                        $countprogress = 0;
                        foreach($dataready as $rowready){ 
                             if( $rowready->ProduksiStatus == 2) $countready += $rowready->ProduksiQty;
                             if( $rowready->ProduksiStatus < 2) $countprogress += $rowready->ProduksiQty;
                              
                        }
 
                        if( ($countready + $countprogress) < $rowitem->PODetailQty ){
                              $item .= '  <div class="row border-bottom">
                                    <div class="col-md-4 col-12">
                                          <div class="d-flex flex-column">
                                                <span class="fw-bold fs-5">'.$rowitem->MsItemName.' ('.$rowitem->MsVendorCode.')</span>
                                                <span>'.$rowitem->MsItemSize.'</span>
                                          </div>
                                    </div>
                                    <div class="col-md-2 col-12">
                                          <div class="d-flex flex-column">
                                                <span>Qty</span>
                                                <span class="fw-bold fs-5">'.$rowitem->PODetailQty.' '.$rowitem->MsItemUoM.'</span>
                                          </div>
                                    </div>
                                    <div class="col-md-2 col-12">
                                          <div class="d-flex flex-column">
                                                <span>Sedang Diproses</span>
                                                <span class="fw-bold fs-5">'.$countprogress.' '.$rowitem->MsItemUoM.'</span>
                                          </div>
                                    </div>
                                    <div class="col-md-2 col-12">
                                          <div class="d-flex flex-column">
                                                <span>Ready Stock</span>
                                                <span class="fw-bold fs-5">'.$countready.' '.$rowitem->MsItemUoM.'</span>
                                          </div>
                                    </div>
                                    <div class="col-md-2 col-12 justify-content-center">
                                          <div class="d-flex">
                                                <button class="btn btn-sm btn-success m-2 fw-bold '.($countready >= $rowitem->PODetailQty ? "disabled" : "").'" onclick="ready_stock(\''.$rowitem->MsItemId.'\',\''.$rowitem->MsVendorCode.'\',\''.$row->POCode.'\')">Ready Stock</button>
                                                <button class="btn btn-sm btn-primary m-2 fw-bold ms-0 '.($countprogress >= $rowitem->PODetailQty ? "disabled" : "").'" onclick="proses_cetak(\''.$rowitem->MsItemId.'\',\''.$rowitem->MsVendorCode.'\',\''.$row->POCode.'\')">Proses Cetak</button>
                                          </div>
                                    </div>
                              </div>';
                        }
                       
                  }
                  if($item != ""){
                        $content .= '<div class="row datatable-header align-items-center mb-2" style="font-size:0.75rem"> 
                        <div class="col-12">
                              <span class="fw-bold" style="font-size:1rem">Purchase Order (' . ($row->SalesRef == "" ? "PO STOCK" : "PO Sales") . ')
                        </div>  
                        <div class="col-md-4 col-12">
                              <div class="row">
                                    <div class="col-4">
                                          <span class="text-secondary">No. PO</span>
                                    </div>
                                    <div class="col-8">
                                          <span class="fw-bold">'.$row->POCode.'</span>
                                    </div>
                              </div>
                              <div class="row">
                                    <div class="col-4">
                                          <span class="text-secondary">No. Ref</span>
                                    </div>
                                    <div class="col-8">
                                          <span class="fw-bold">'.$row->SalesRef.'</span>
                                    </div>
                              </div>
                              <div class="row">
                                    <div class="col-4">
                                          <span class="text-secondary">Tgl. Pembuatan</span>
                                    </div>
                                    <div class="col-8">
                                          <span class="fw-bold">'.date_format(date_create($row->PODate),"j M Y").'</span>
                                    </div>
                              </div>
                              <div class="row">
                                    <div class="col-4">
                                          <span class="text-secondary">Tgl. Estimasi</span>
                                    </div>
                                    <div class="col-8">
                                          <span class="fw-bold">'.date_format(date_create($row->POEstimate),"j M Y") .'</span>
                                    </div>
                              </div>
                        </div>
                        <div class="col-md-4 col-12"> 
                              <div class="row">
                                    <div class="col-4">
                                          <span class="text-secondary">Toko</span>
                                    </div>
                                    <div class="col-8">
                                          <span class="fw-bold">'.$row->toko.'</span>
                                    </div>
                              </div>
                              <div class="row">
                                    <div class="col-4">
                                          <span class="text-secondary">Kirim Ke</span>
                                    </div>
                                    <div class="col-8">
                                          <span class="fw-bold">'.($row->tujuan=="" ? "Customer" : $row->tujuan).'</span>
                                    </div>
                              </div>
                              <div class="row">
                                    <div class="col-4">
                                          <span class="text-secondary">Pembuat</span>
                                    </div>
                                    <div class="col-8">
                                          <span class="fw-bold">'.$row->MsEmpName.'</span>
                                    </div>
                              </div>
                        </div>
                        <div class="col-md-4 col-12"> 
                              <div class="row">
                                    <div class="col-4">
                                          <span class="text-secondary">Catatan</span>
                                    </div>
                                    <div class="col-8">
                                          <span class="fw-bold">'.$row->PORemarks.'</span>
                                    </div>
                              </div>
                        </div>
                        <div class="col-12 my-2">
                              <div class="d-inline bg-success bg-gradient px-2 py-1" >
                                    <span class="fw-bold text-white">Detail Item</span>
                              </div>
                        </div>
                        <div class="col-12">
                              '.$item.'
                        </div>
                  </div>';
                  }
                
            }
            if ($content == "") {
                  $content = '<img src="' . base_url("asset/image/mgs-erp/iconnotfound.png") . '" class="rounded mx-auto d-block" width="300px">';
            }
            echo $content;
      }

      function get_menu_produksi_cetak(){
            $result = $this->db
                  ->join("TblMsItem","TblMsItem.MsItemId=TblProduksi.MsItemId")
                  ->join("TblPO","TblPO.POCode=TblProduksi.ProduksiRef")
                  ->join("TblMsStaff","TblMsStaff.StaffId=TblProduksi.MsStaffId")
                  ->where("ProduksiStatus",0)
                  ->get("TblProduksi")->result(); 
            $content = "";  
            foreach($result as $row){
                  $content .= '<div class="row datatable-header mb-2" style="font-size:0.75rem"> 
                                    <div class="col-12">
                                          <span class="fw-bold fs-5">' . $row->MsItemCode . ' - ' . $row->MsItemName . '
                                    </div>
                                    <div class="col-md-4 col-12">
                                          <div class="row">
                                                <div class="col-4">
                                                      <span class="text-secondary">No. PO</span>
                                                </div>
                                                <div class="col-8">
                                                      <span class="fw-bold">'.$row->ProduksiRef.'</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-4">
                                                      <span class="text-secondary">No. Ref</span>
                                                </div>
                                                <div class="col-8">
                                                      <span class="fw-bold">'.$row->SalesRef.'</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-4">
                                                      <span class="text-secondary">Tgl. PO</span>
                                                </div>
                                                <div class="col-8">
                                                      <span class="fw-bold">'.date_format(date_create($row->PODate),"j M Y").'</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-4">
                                                      <span class="text-secondary">Tgl. Estimasi PO</span>
                                                </div>
                                                <div class="col-8">
                                                      <span class="fw-bold">'.date_format(date_create($row->POEstimate),"j M Y") .'</span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                          <div class="row">
                                                <div class="col-4">
                                                      <span class="text-secondary">No. Produksi</span>
                                                </div>
                                                <div class="col-8">
                                                      <span class="fw-bold">'.$row->ProduksiCode.'</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-4">
                                                      <span class="text-secondary">Tgl. Cetak</span>
                                                </div>
                                                <div class="col-8">
                                                      <span class="fw-bold">'.date_format(date_create($row->ProduksiDateCetak),"j M Y").'</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-4">
                                                      <span class="text-secondary">Staff Cetak</span>
                                                </div>
                                                <div class="col-8">
                                                      <span class="fw-bold">'.$row->StaffName.'</span>
                                                </div>
                                          </div> 
                                          <div class="row">
                                                <div class="col-4">
                                                      <span class="text-secondary">Catatan</span>
                                                </div>
                                                <div class="col-8">
                                                      <span class="fw-bold">'.$row->ProduksiRemarks.'</span>
                                                </div>
                                          </div> 
                                    </div>
                                    
                                    <div class="col-md-2 col-12">
                                          <div class="row">
                                                <div class="d-flex flex-column">
                                                      <span>Diproses</span>
                                                      <span class="fw-bold fs-5">'.$row->ProduksiQty.' '.$row->MsItemUoM.'</span>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-2 col-12 justify-content-center">
                                          <div class="d-flex">
                                                <button class="btn btn-sm btn-warning m-2 fw-bold" onclick="edit_proses_cetak(\''.$row->ProduksiId.'\')">Edit</button>
                                                <button class="btn btn-sm btn-primary m-2 fw-bold ms-0 " onclick="proses_kering(\''.$row->ProduksiId.'\')">Pengeringan</button>
                                          </div>
                                    </div>
                              </div>' ; 
            }
            if ($content == "") {
                  $content = '<img src="' . base_url("asset/image/mgs-erp/iconnotfound.png") . '" class="rounded mx-auto d-block" width="300px">';
            }
            echo $content;
      }

      function get_menu_produksi_proses(){
            $result = $this->db
                  ->join("TblMsItem","TblMsItem.MsItemId=TblProduksi.MsItemId")
                  ->join("TblPO","TblPO.POCode=TblProduksi.ProduksiRef")
                  ->join("TblMsStaff","TblMsStaff.StaffId=TblProduksi.MsStaffId")
                  ->where("ProduksiStatus",1)
                  ->get("TblProduksi")->result(); 
            $content = "";  
            foreach($result as $row){
                  $content .= '<div class="row datatable-header mb-2" style="font-size:0.75rem"> 
                        <div class="col-12">
                              <span class="fw-bold fs-5">' . $row->MsItemCode . ' - ' . $row->MsItemName . '
                        </div>
                        <div class="col-md-4 col-12">
                              <div class="row">
                                    <div class="col-4">
                                          <span class="text-secondary">No. PO</span>
                                    </div>
                                    <div class="col-8">
                                          <span class="fw-bold">'.$row->ProduksiRef.'</span>
                                    </div>
                              </div>
                              <div class="row">
                                    <div class="col-4">
                                          <span class="text-secondary">No. Ref</span>
                                    </div>
                                    <div class="col-8">
                                          <span class="fw-bold">'.$row->SalesRef.'</span>
                                    </div>
                              </div>
                              <div class="row">
                                    <div class="col-4">
                                          <span class="text-secondary">Tgl. PO</span>
                                    </div>
                                    <div class="col-8">
                                          <span class="fw-bold">'.date_format(date_create($row->PODate),"j M Y").'</span>
                                    </div>
                              </div>
                              <div class="row">
                                    <div class="col-4">
                                          <span class="text-secondary">Tgl. Estimasi PO</span>
                                    </div>
                                    <div class="col-8">
                                          <span class="fw-bold">'.date_format(date_create($row->POEstimate),"j M Y") .'</span>
                                    </div>
                              </div>
                        </div>
                        <div class="col-md-4 col-12">
                              <div class="row">
                                    <div class="col-4">
                                          <span class="text-secondary">No. Produksi</span>
                                    </div>
                                    <div class="col-8">
                                          <span class="fw-bold">'.$row->ProduksiCode.'</span>
                                    </div>
                              </div>
                              <div class="row">
                                    <div class="col-4">
                                          <span class="text-secondary">Tgl. Cetak</span>
                                    </div>
                                    <div class="col-8">
                                          <span class="fw-bold">'.date_format(date_create($row->ProduksiDateCetak),"j M Y").'</span>
                                    </div>
                              </div>
                              <div class="row">
                                    <div class="col-4">
                                          <span class="text-secondary">Tgl. Pengeringan</span>
                                    </div>
                                    <div class="col-8">
                                          <span class="fw-bold">'.date_format(date_create($row->ProduksiDateKering),"j M Y").'</span>
                                    </div>
                              </div>
                              <div class="row">
                                    <div class="col-4">
                                          <span class="text-secondary">Staff Cetak</span>
                                    </div>
                                    <div class="col-8">
                                          <span class="fw-bold">'.$row->StaffName.'</span>
                                    </div>
                              </div> 
                              <div class="row">
                                    <div class="col-4">
                                          <span class="text-secondary">Catatan</span>
                                    </div>
                                    <div class="col-8">
                                          <span class="fw-bold">'.$row->ProduksiRemarks.'</span>
                                    </div>
                              </div> 
                        </div>
                        
                        <div class="col-md-2 col-12">
                              <div class="row">
                                    <div class="d-flex flex-column">
                                          <span>Diproses</span>
                                          <span class="fw-bold fs-5">'.$row->ProduksiQty.' '.$row->MsItemUoM.'</span>
                                    </div>
                              </div>
                        </div>
                        <div class="col-md-2 col-12 justify-content-center">
                              <div class="d-flex">
                                    <button class="btn btn-sm btn-warning m-2 fw-bold" onclick="edit_proses_kering(\''.$row->ProduksiId.'\')">Edit</button>
                                    <button class="btn btn-sm btn-primary m-2 fw-bold ms-0 " onclick="proses_ready(\''.$row->ProduksiId.'\')">Selesai</button>
                              </div>
                        </div>
                  </div>' ; 
            }
            if ($content == "") {
                  $content = '<img src="' . base_url("asset/image/mgs-erp/iconnotfound.png") . '" class="rounded mx-auto d-block" width="300px">';
            }
            echo $content;
      }
      
      function get_menu_produksi_selesai(){
            $result = $this->db
                  ->join("TblMsItem","TblMsItem.MsItemId=TblProduksi.MsItemId")
                  ->join("TblPO","TblPO.POCode=TblProduksi.ProduksiRef")
                  ->join("TblMsStaff","TblMsStaff.StaffId=TblProduksi.MsStaffId","left")
                  ->where("ProduksiStatus",2)
                  ->get("TblProduksi")->result(); 
            $content = "";  
            foreach($result as $row){
                  $content .= '<div class="row datatable-header mb-2" style="font-size:0.75rem"> 
                        <div class="col-12">
                              <span class="fw-bold fs-5">('.($row->ProduksiType == 1 ? "READY STOCK" : "PRODUKSI").') ' . $row->MsItemCode . ' - ' . $row->MsItemName . '
                        </div>
                        <div class="col-md-4 col-12">
                              <div class="row">
                                    <div class="col-4">
                                          <span class="text-secondary">No. PO</span>
                                    </div>
                                    <div class="col-8">
                                          <span class="fw-bold">'.$row->ProduksiRef.'</span>
                                    </div>
                              </div>
                              <div class="row">
                                    <div class="col-4">
                                          <span class="text-secondary">No. Ref</span>
                                    </div>
                                    <div class="col-8">
                                          <span class="fw-bold">'.$row->SalesRef.'</span>
                                    </div>
                              </div>
                              <div class="row">
                                    <div class="col-4">
                                          <span class="text-secondary">Tgl. PO</span>
                                    </div>
                                    <div class="col-8">
                                          <span class="fw-bold">'.date_format(date_create($row->PODate),"j M Y").'</span>
                                    </div>
                              </div>
                              <div class="row">
                                    <div class="col-4">
                                          <span class="text-secondary">Tgl. Estimasi PO</span>
                                    </div>
                                    <div class="col-8">
                                          <span class="fw-bold">'.date_format(date_create($row->POEstimate),"j M Y") .'</span>
                                    </div>
                              </div>
                        </div>
                        <div class="col-md-4 col-12">
                              <div class="row">
                                    <div class="col-4">
                                          <span class="text-secondary">No. Produksi</span>
                                    </div>
                                    <div class="col-8">
                                          <span class="fw-bold">'.$row->ProduksiCode.'</span>
                                    </div>
                              </div>
                              <div class="row">
                                    <div class="col-4">
                                          <span class="text-secondary">Tgl. Cetak</span>
                                    </div>
                                    <div class="col-8">
                                          <span class="fw-bold">'.date_format(date_create($row->ProduksiDateCetak),"j M Y").'</span>
                                    </div>
                              </div>
                              <div class="row">
                                    <div class="col-4">
                                          <span class="text-secondary">Tgl. Pengeringan</span>
                                    </div>
                                    <div class="col-8">
                                          <span class="fw-bold">'.date_format(date_create($row->ProduksiDateKering),"j M Y").'</span>
                                    </div>
                              </div>
                              <div class="row">
                                    <div class="col-4">
                                          <span class="text-secondary">Tgl. Selesai</span>
                                    </div>
                                    <div class="col-8">
                                          <span class="fw-bold">'.date_format(date_create($row->ProduksiDate),"j M Y").'</span>
                                    </div>
                              </div>
                              <div class="row">
                                    <div class="col-4">
                                          <span class="text-secondary">Staff Cetak</span>
                                    </div>
                                    <div class="col-8">
                                          <span class="fw-bold">'.$row->StaffName.'</span>
                                    </div>
                              </div> 
                              <div class="row">
                                    <div class="col-4">
                                          <span class="text-secondary">Catatan</span>
                                    </div>
                                    <div class="col-8">
                                          <span class="fw-bold">'.$row->ProduksiRemarks.'</span>
                                    </div>
                              </div> 
                        </div>
                        
                        <div class="col-md-2 col-12">
                              <div class="row">
                                    <div class="d-flex flex-column">
                                          <span>Diproses</span>
                                          <span class="fw-bold fs-5">'.$row->ProduksiQty.' '.$row->MsItemUoM.'</span>
                                    </div>
                              </div>
                        </div>
                        <div class="col-md-2 col-12 justify-content-center">
                              <div class="d-flex">
                                    <button class="btn btn-sm btn-warning m-2 fw-bold" onclick="edit_proses_selesai(\''.$row->ProduksiId.'\')">Edit</button>
                                    <button class="btn btn-sm btn-primary m-2 fw-bold ms-0 " onclick="proses_kirim(\''.$row->ProduksiId.'\')">Kirim Barang</button>
                              </div>
                        </div>
                  </div>' ; 
            }
            if ($content == "") {
                  $content = '<img src="' . base_url("asset/image/mgs-erp/iconnotfound.png") . '" class="rounded mx-auto d-block" width="300px">';
            }
            echo $content;
      }

      function get_data_cetak_dash(){
            $result = $this->db->query("SELECT *,(SELECT IFNULL(SUM(ProduksiQty),0) FROM TblProduksi WHERE ProduksiStatus=0 AND MsStaffId=Staffid) AS count FROM TblMsStaff ORDER BY COUNT desc")->result();
            echo json_encode($result);
      }

      function get_data_history(){
            
            /********* 
             * 
             * function get last Stock
             * 
             * PARAMETER AJAX
                  $_POST['search']['value'];
                  $_POST['search']['regex'];
                  $_POST['search']['tanggalstart'];
                  $_POST['search']['tanggalend'];
                  $_POST['search']['MsProdukStockId'];  
             * 
             * 
            */ 
            $data_stock = $this->db->where("MsProdukStockId",$_POST['search']['MsProdukStockId'])->get("TblMsProdukStock")->row();
           
            $this->db->where("MsProdukId",$data_stock->MsProdukId)->where("MsWorkplaceId",$data_stock->MsWorkplaceId);
            $datavarian = explode("|",$data_stock->MsProdukVarian);
            for($i = 0; count($datavarian)>$i;$i++){
                $this->db->like('REPLACE(lower(MsProdukVarian)," ","")', str_replace(" ","",strtolower($datavarian[$i])));
            } 
            $data_trans = $this->db->get("TblMsProdukTrans")->result();

            $data = array();
            $stockawal = 0;
            $no = 0;
            foreach($data_trans as $row){
                  $no++;
                  $rows = array();
                  $stockmin = 0;
                  $stockplus = 0; 
                  $stockakhir = 0; 
                  /* 
                        PARAMETER KODE TRANSAKSI
                        (PLUS) = TI,GRPO,
                        (MIN) = PO,BR,TO 
                  */
                  if($row->MsProdukTransType == "PO" || $row->MsProdukTransType == "BR" || $row->MsProdukTransType == "TO" ){
                        $stockmin =  $row->MsProdukTransQty;
                  }
                  if($row->MsProdukTransType == "GRPO" || $row->MsProdukTransType == "TI" ){
                        $stockplus =  $row->MsProdukTransQty;
                  }

                  $stockakhir = $stockawal + $stockplus - $stockmin; 
                  $rows["date"] = $row->MsProdukTransDate; 
                  $rows["type"] = $row->MsProdukTransType; 
                  $rows["ref"] = $row->MsProdukTransRef; 
                  $rows["stkawal"] = $stockawal; 
                  $rows["stkpls"] = $stockplus; 
                  $rows["stkmns"] = $stockmin; 
                  $rows["stkend"] = $stockakhir;
                  $rows["desc"] = "-";
                  $data[] = $rows;
 
                  $stockawal = $stockakhir;
            } 

            $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $no,
                  "recordsFiltered" => $no,
                  "data" => $data,
            );
            //output to json format
            echo json_encode($output);
      }
}
