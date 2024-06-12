<?php
defined('BASEPATH') or exit('No direct script access allowed');
ini_set('max_execution_time', 0);
class Client_datatable_pembelian extends CI_Controller
{
      function __construct()
      {
            parent::__construct();
            $this->load->model('pengiriman/Model_pengiriman', 'm_penjualan');
            $this->load->model('model_app');

            date_default_timezone_set('Asia/Jakarta');
      }
      function get_data_po()
      {
            // SETUP DATATABLE
            $this->m_penjualan->table = 'TblPO';
            $this->m_penjualan->tablejoin = array(
                  array(0 => 'TblMsWorkplace as a', 1 => 'a.MsWorkplaceId=TblPO.MsWorkplaceId', 2 => 'left'),
                  array(0 => 'TblMsWorkplace as b', 1 => 'b.MsWorkplaceId=TblPO.PODst', 2 => 'left'),
                  array(0 => 'TblMsVendor', 1 => 'TblMsVendor.MsVendorId=TblPO.MsVendorId', 2 => 'left'),
                  array(0 => 'TblMsEmployee', 1 => 'TblMsEmployee.MsEmpId=TblPO.MsEmpId', 2 => 'left')
            );
            $this->m_penjualan->column_order = array(null, 'PODate', 'MsWorkplaceCode', null, 'POCode', 'PORef', 'PORemarks'); //set column field database for datatable orderable
            $this->m_penjualan->column_search = array('PODate', 'a.MsWorkplaceCode', 'b.MsWorkplaceCode', 'MsEmpName', 'POCode', 'PORef', 'PORemarks'); //set column field database for datatable searchable 
            $this->m_penjualan->order = array('PODate' => 'desc', 'POId' => 'desc'); // default order 
            $this->m_penjualan->select = "* , a.MsWorkplaceCode as src , b.MsWorkplaceCode as dst";
            // PROSES DATA
            $list = $this->m_penjualan->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $master) {
                  $query1 = $this->db->join("TblMsItem", "TblPODetail.MsItemId=TblMsItem.MsItemId", "left")
                        ->join("TblMsItemCategory", "TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId", "left")
                        ->where("PODetailRef", $master->POCode)->get("TblPODetail")->result();
                  $detailpo = "";
                  foreach ($query1 as $row1) {
                        $detailpo .= '    <div class="row align-items-center border-light border-bottom border-top me-2 py-1">
                                                      <div class="col-8">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemCode . '-' . $row1->MsItemName . ' (' . $row1->MsVendorCode . ')</span><br>
                                                            <span class="text-secondary">Ukuran : <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemSize . '</span></span>
                                                      </div>
                                                      <div class="col-4 text-right">
                                                            <span class="text-secondary">Qty</span><br>
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->PODetailQty . ' ' . $row1->MsItemUoM . '</span>
                                                      </div>
                                                </div>';
                  }


                  if ($master->POStatus == 0) {
                        $valueprogress = 30;
                        $button = ' <div class="col-md-12 d-flex pt-2">
                                                <button type="button" onclick="edit_click(\'' . $master->POId . '\')" class="btn btn-transparent btn-sm mx-1 ms-auto" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-pencil-alt"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Edit
                                                      </span>
                                                </button>
                                                <div class="dropdown" >
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1 dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false" style="border: 1px solid;font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-print"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Print
                                                            </span>
                                                      </button>
                                                      <ul class="dropdown-menu dropdown-menu-sm w-16rem">
                                                            <li><a class="dropdown-item" onclick="po_print_a5(\'' . $master->POId . '\')"><i class="fas fa-file"  style="min-width:20px"></i>&nbsp;Print ukuran A5</a></li>
                                                            <li><a class="dropdown-item" onclick="po_print_a6(\'' . $master->POId . '\')"><i class="fas fa-file"  style="min-width:20px"></i>&nbsp;Print ukuran A6</a></li>
                                                      </ul>
                                                </div>
                                                <button type="button" onclick="delete_click(\'' . $master->POId . '\')" class="btn btn-transparent btn-sm mx-1" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-times"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Hapus
                                                      </span>
                                                </button>  
                                          </div>';
                  } else if ($master->POStatus == 1) {
                        $valueprogress = 65;
                        $button = ' <div class="col-md-12 d-flex pt-2">
                                                <button type="button" onclick="edit_click(\'' . $master->POId . '\')" class="btn btn-transparent btn-sm mx-1 ms-auto" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-pencil-alt"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Edit
                                                      </span>
                                                </button>
                                                <div class="dropdown">
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1 dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false" style="border: 1px solid;font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-print"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Print
                                                            </span>
                                                      </button>
                                                      <ul class="dropdown-menu dropdown-menu-sm w-16rem">
                                                            <li><a class="dropdown-item" onclick="po_print_a5(\'' . $master->POId . '\')"><i class="fas fa-file"  style="min-width:20px"></i>&nbsp;Print ukuran A5</a></li>
                                                            <li><a class="dropdown-item" onclick="po_print_a6(\'' . $master->POId . '\')"><i class="fas fa-file"  style="min-width:20px"></i>&nbsp;Print ukuran A6</a></li>
                                                      </ul>
                                                </div>
                                                <button type="button" onclick="delete_click(\'' . $master->POId . '\')" class="btn btn-transparent btn-sm mx-1" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-times"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Hapus
                                                      </span>
                                                </button>  
                                          </div>';
                  } else if ($master->POStatus == 2) {
                        $valueprogress = 100;
                        $button = ' <div class="col-md-12 d-flex pt-2" >     
                                                <div class="dropdown  ms-auto">   
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1 dropdown-toggle "  data-bs-toggle="dropdown" aria-expanded="false" style="border: 1px solid;font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-print"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Print
                                                            </span>
                                                      </button>
                                                      <ul class="dropdown-menu dropdown-menu-sm w-16rem">
                                                            <li><a class="dropdown-item" onclick="po_print_a5(\'' . $master->POId . '\')"><i class="fas fa-file"  style="min-width:20px"></i>&nbsp;Print ukuran A5</a></li>
                                                            <li><a class="dropdown-item" onclick="po_print_a6(\'' . $master->POId . '\')"><i class="fas fa-file"  style="min-width:20px"></i>&nbsp;Print ukuran A6</a></li>
                                                      </ul>
                                                </div> 
                                          </div>';
                  }


                  /* ========= Delivery ============ */
                  $delivery = "";
                  $data_delivery = $this->db
                        ->join("TblMsCustomerDelivery", "TblDelivery.MsCustomerDeliveryId = TblMsCustomerDelivery.MsCustomerDeliveryId", "left")
                        ->join("TblMsWorkplace", "TblMsWorkplace.MsWorkplaceId = TblDelivery.MsCustomerDeliveryId", "left")
                        ->join("TblMsDelivery", "TblDelivery.MsDeliveryId = TblMsDelivery.MsDeliveryId", "left")
                        ->where("DeliveryRef2", $master->POCode)
                        ->get("TblDelivery")->result();
                  foreach ($data_delivery as $row) {
                        if ($row->DeliveryType > 2) {
                              $receive = $row->MsWorkplaceName;
                              $telepon = $row->MsWorkplaceTelp1;
                              $address = $row->MsWorkplaceAddress;
                              $mapname =  $row->MsWorkplaceMap;
                              $maplat = $row->MsWorkplaceLat;
                              $maplng = $row->MsWorkplaceLng;
                        } else {
                              $receive = $row->MsCustomerDeliveryReceive;
                              $telepon = $row->MsCustomerDeliveryTelp;
                              $address = $row->MsCustomerDeliveryAddress;
                              $mapname =  $row->MsCustomerDeliveryName;
                              $maplat = $row->MsCustomerDeliveryLat;
                              $maplng = $row->MsCustomerDeliveryLng;
                        }

                        if ($row->DeliveryType == 0) {
                              $header = "TOKO <i class='fas fa-long-arrow-alt-right'></i> CUSTOMER";
                              $ref = '';
                        } else if ($row->DeliveryType == 1) {
                              $header = "GUDANG <i class='fas fa-long-arrow-alt-right'></i> CUSTOMER";
                              $ref = '';
                        } else if ($row->DeliveryType == 2) {
                              $header = "VENDOR <i class='fas fa-long-arrow-alt-right'></i> CUSTOMER";
                              $ref =  ' <div class="row">
                                                <div class="col-4">
                                                      <span class="text-secondary label-span">No. PO</span>
                                                </div>
                                                <div class="col-auto">
                                                      <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->DeliveryRef2 . '</span>
                                                </div> 
                                                </div> ';
                        } else if ($row->DeliveryType == 3) {
                              $header = "VENDOR <i class='fas fa-long-arrow-alt-right'></i> TOKO";
                              $ref = ' <div class="row">
                                                <div class="col-4">
                                                      <span class="text-secondary label-span">No. PO</span>
                                                </div>
                                                <div class="col-auto">
                                                      <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->DeliveryRef2 . '</span>
                                                </div> 
                                                </div> ';
                        } else if ($row->DeliveryType == 4) {
                              $header = "VENDOR <i class='fas fa-long-arrow-alt-right'></i> GUDANG";
                              $ref = ' <div class="row">
                                                <div class="col-4">
                                                      <span class="text-secondary label-span">No. PO</span>
                                                </div>
                                                <div class="col-auto">
                                                      <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->DeliveryRef2 . '</span>
                                                </div> 
                                          </div> ';
                        }

                        $query1 = $this->db->query("select * from TblDeliveryDetail left join TblMsItem on TblDeliveryDetail.MsItemId=TblMsItem.MsItemId LEFT JOIN TblMsItemCategory on TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId  where DeliveryDetailRef='" . $row->DeliveryCode . "'")->result();
                        $detaildelivery = "";
                        foreach ($query1 as $row1) {
                              $detaildelivery .= '    <div class="row align-items-center border-light border-bottom border-top me-1 py-1">
                                                                  <div class="col-6">
                                                                        <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemCode . '-' . $row1->MsItemName . '</span><br>
                                                                        <span class="text-secondary">Ukuran : <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemSize . '</span></span>
                                                                  </div>
                                                                  <div class="col-2">
                                                                        <span class="text-secondary">Vendor</span><br>
                                                                        <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsVendorCode . '</span>
                                                                  </div>
                                                                  <div class="col-2 text-right">
                                                                        <span class="text-secondary">Qty</span><br>
                                                                        <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->DeliveryDetailQty . ' ' . $row1->MsItemUoM . '</span>
                                                                  </div>
                                                                  <div class="col-2 text-right">
                                                                        <span class="text-secondary">Spare</span><br>
                                                                        <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->DeliveryDetailSpareQty . ' ' . $row1->MsItemUoM . '</span>
                                                                  </div>
                                                            </div>';
                        }
                        if ($row->DeliveryStatus == 0) {
                              $valueprogress_delivery = 30;
                              $button_delivery = ' <div class="col-md-12 d-flex">
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_edit(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-pencil-alt"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Edit
                                                            </span>
                                                      </button>
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_print(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-print"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Print
                                                            </span>
                                                      </button>
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_delete(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-times"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Hapus
                                                            </span>
                                                      </button>
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1 ms-auto" onclick="delivery_proses(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem"> 
                                                            <i class="fas fa-share-square"></i>
                                                            <span class="fw-bold">
                                                            &nbsp;Proses Pengiriman
                                                            </span>
                                                      </button>
                                                </div>';
                        } else if ($row->DeliveryStatus == 1) {
                              $valueprogress_delivery = 65;
                              $button_delivery = ' <div class="col-md-12 d-flex">
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_edit(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-pencil-alt"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Edit
                                                            </span>
                                                      </button>
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_print(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-print"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Print
                                                            </span>
                                                      </button>
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_delete(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-times"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Hapus
                                                            </span>
                                                      </button>
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1 ms-auto" onclick="delivery_selesai(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-share-square"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Selesaikan
                                                            </span>
                                                      </button>
                                                </div>';
                        } else if ($row->DeliveryStatus == 2) {
                              $valueprogress_delivery = 100;
                              $button_delivery = ' <div class="col-md-12 d-flex"> 
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_print(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-print"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Print
                                                            </span>
                                                      </button>  
                                                </div>';
                        }

                        if ($row->DeliveryJenis == 1) $via = "ENGKEL";
                        if ($row->DeliveryJenis == 2) $via = "PICK-UP";
                        if ($row->DeliveryJenis == 3) $via = "PS";
                        $delivery .= '<div class="m-2 px-4 py-2 shadow-sm" style="box-shadow: 5px 0px 0px #0d6efd inset !important;background: #f9f9f9;border: 1px solid #bdbdbd;border-radius: 5px;">
                                          <div class="row py-1 g-1">
                                                <div class="col-lg-4 col-md-6 col-12">
                                                      <div class="row"> 
                                                            <div class="col-auto">
                                                                  <span class="text-dark fw-bold" style="font-size:1rem;">' . $header . '</span>
                                                            </div>
                                                      </div>
                                                      ' . $ref . '
                                                      <div class="row">
                                                            <div class="col-4">
                                                                  <span class="text-secondary label-span">No. Delivery</span>
                                                            </div>
                                                            <div class="col-auto">
                                                                  <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->DeliveryCode . '</span>
                                                            </div>
                                                      </div>
                                                      <div class="row">
                                                            <div class="col-4">
                                                                  <span class="text-secondary label-span">Pengiriman Ke</span>
                                                            </div>
                                                            <div class="col-auto">
                                                                  <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->DeliveryRit . '</span>
                                                            </div>
                                                      </div>
                                                      <div class="row">
                                                            <div class="col-4">
                                                                  <span class="text-secondary label-span">Tgl. kirim</span>
                                                            </div>
                                                            <div class="col-auto">
                                                                  <span class="text-dark fw-bold" style="font-size:0.7rem;">' . date_format(date_create($row->DeliveryDate), "d F Y") . '</span>
                                                            </div>
                                                      </div> 
                                                </div>
                                                <div class="col-lg-3 col-md-6 col-12">
                                                      <div class="row">
                                                            <div class="col-4">
                                                                  <span class="text-secondary label-span">Armada</span>
                                                            </div>
                                                            <div class="col-auto">
                                                                  <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->MsDeliveryName . ($row->MsDeliveryId == 1 ? " (" . $via . ")" : "") . ' </span>
                                                            </div>
                                                      </div>  
                                                      <div class="list-progress" style="">
                                                            <span class="fa-stack text-secondary ' . ($row->DeliveryStatus >= 0 ? "success" : "") . '" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="dijadwalkan">
                                                                  <i class="fas fa-circle fa-stack-2x" ></i>
                                                                  <i class="fas fa-calendar-alt fa-stack-1x"></i>
                                                            </span>
                                                            <span class="fa-stack text-secondary ' . ($row->DeliveryStatus >= 1 ? "success" : "") . '" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="dikirim">
                                                                  <i class="fas fa-circle fa-stack-2x" ></i>
                                                                  <i class="fas fa-shipping-fast fa-stack-1x" ></i>
                                                            </span>
                                                            <span class="fa-stack text-secondary ' . ($row->DeliveryStatus >= 2 ? "success" : "") . '" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="diterima">
                                                                  <i class="fas fa-circle fa-stack-2x"></i>
                                                                  <i class="fas fa-people-carry fa-stack-1x"></i>
                                                            </span>
                                                            <div class="progress">
                                                                  <div class="progress-bar bg-success" role="progressbar" style="width: ' . $valueprogress_delivery . '%" aria-valuenow="' . $valueprogress_delivery . '" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                      </div>
                                                      <div class="row">
                                                            <div class="col-4">
                                                                  <span class="text-secondary label-span">Catatan</span>
                                                            </div>
                                                            <div class="col-auto">
                                                                  <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->DeliveryRemarks . '</span>
                                                            </div>
                                                      </div>  
                                                </div>
                                                <div class="col-lg-5 ps-lg-2 col-12">
                                                      <div class="row">
                                                            <div class="col-2">
                                                                  <span class="text-secondary label-span">Penerima</span>
                                                            </div>
                                                            <div class="col-10">
                                                                  <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $receive . '</span><span class="text-dark fw-bold" style="font-size:0.7rem;">(' . $telepon . ')</span>
                                                            </div>
                                                      </div>   
                                                      <div class="row">
                                                            <div class="col-2">
                                                                  <span class="text-secondary label-span">Alamat</span>
                                                            </div>
                                                            <div class="col-10">
                                                                  <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $address . '</span></span>
                                                            </div>
                                                      </div>    
                                                      <span class="text-secondary">Titik Map</span><br>
                                                      <div class="bg-pinpoint">
                                                            <i class="fas fa-map-marker-alt fa-2x"></i>
                                                            <span class="label-small px-1">' . $mapname . '</span>
                                                            <a class="btn btn-light py-1 ms-auto btn-sm" href="https://maps.google.com/?q=' . $maplat . ',' . $maplng . '" target="_blank" style="min-width: 5rem;">Lihat Map</a>
                                                      </div>
                                                </div>
                                                <div class="col-md-12 d-flex flex-column " style="border: 1px solid #d2cac0;border-radius: 0.25rem;">
                                                      ' . $detaildelivery . '
                                                </div>
                                                ' . $button_delivery . '
                                          </div>
                                          </div>  ';

                        // $delivery .= '<li class="list-group-item list-group-item-action p-0"> 
                        //                         <div class="d-flex justify-content-between align-items-center">
                        //                               <div class="d-flex flex-column m-2">
                        //                                     <span class="fw-bold mb-1">' . $row1->DeliveryCode . '</span>
                        //                                     <small>' . $row1->DeliveryDate . '</small>
                        //                               </div>
                        //                               <div class="d-flex flex-row"> 
                        //                                     <a onclick="delivery_edit(' . $row1->DeliveryId . ')" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                        //                                     <a onclick="delivery_print(' . $row1->DeliveryId . ')" class="me-2 text-primary pointer" title="Delete Data"><i class="fas fa-print"></i></a>
                        //                               </div>
                        //                         </div>  
                        //                   </li>';
                  }
                  if ($delivery == "")  $delivery = '<div class="text-center fw-bold mt-2">Belum Ada pengiriman yang dibuat</div><br>';

                  /* ========= GRPO ============ */
                  $header_grpo = $this->db
                        ->select("*, TblGRPO.MsWorkplaceId")
                        ->join("TblMsVendor", "TblGRPO.MsVendorId=TblMsVendor.MsvendorId", "left")
                        ->join("TblMsWorkplace", "TblMsWorkplace.MsWorkplaceId=TblGRPO.MsWorkplaceId", "left")
                        ->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblGRPO.MsEmpId", "left")
                        ->like("GRPORef", $master->POCode)
                        ->get("TblGRPO")->result();
                  $grpo = "";
                  foreach ($header_grpo as $rows_grpo) {
                        if ($rows_grpo->MsWorkplaceId == 0) {
                              $_receivegrpo = "CUSTOMER";
                        } else {
                              $_receivegrpo = $rows_grpo->MsWorkplaceCode;
                        }
                        $query1 = $this->db->query("select * from TblGRPODetail left join TblMsItem on TblGRPODetail.MsItemId=TblMsItem.MsItemId LEFT JOIN TblMsItemCategory on TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId  where GRPODetailRef='" . $rows_grpo->GRPOCode . "'")->result();
                        $detailgrpo = "";
                        foreach ($query1 as $row1) {
                              $detailgrpo .= '    <div class="row align-items-center border-light border-bottom border-top me-2 py-1">
                                                      <div class="col-8">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemCode . '-' . $row1->MsItemName . ' (' . $row1->MsVendorCode . ')</span><br>
                                                            <span class="text-secondary">Ukuran : <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemSize . '</span></span>
                                                      </div>
                                                      <div class="col-4 text-right">
                                                            <span class="text-secondary">Qty</span><br>
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->GRPODetailQty . ' ' . $row1->MsItemUoM . '</span>
                                                      </div>
                                                </div>';
                        }
                        $grpo .= '<div class="m-2 ms-4 px-4 py-2 shadow-sm" style="box-shadow: 5px 0px 0px #0d6efd inset !important;background: #f9f9f9;border: 1px solid #bdbdbd;border-radius: 5px;">
                                    <div class="row py-1">
                                          <div class="col-lg-4 col-md-6 col-12">
                                                <span class="fw-bold" style="font-size:1rem">Good Receipt PO (GRPO)</span><br> 
                                                <div class="row">
                                                      <div class="col-4">
                                                            <span class="text-secondary label-span">No. GRPO</span>
                                                      </div>
                                                      <div class="col-auto">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $rows_grpo->GRPOCode . '</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-4">
                                                            <span class="text-secondary label-span">Tgl. GRPO</span>
                                                      </div>
                                                      <div class="col-auto">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . date_format(date_create($rows_grpo->GRPODate), "d F Y") . '</span>
                                                      </div>
                                                </div>
                                                <div class="row">
                                                      <div class="col-4">
                                                            <span class="text-secondary label-span">Vendor</span>
                                                      </div>
                                                      <div class="col-auto">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $rows_grpo->MsVendorCode . '</span>
                                                      </div>
                                                </div> 
                                          </div>
                                          <div class="col-lg-4 col-md-6 col-12">
                                                <div class="row">
                                                      <div class="col-4">
                                                            <span class="text-secondary label-span">Terima di</span>
                                                      </div>
                                                      <div class="col-auto">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $_receivegrpo . '</span>
                                                      </div>
                                                </div> 
                                                <div class="row">
                                                      <div class="col-4">
                                                            <span class="text-secondary label-span">Admin</span>
                                                      </div>
                                                      <div class="col-auto">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $rows_grpo->MsEmpName . '</span>
                                                      </div>
                                                </div> 
                                                <div class="row">
                                                      <div class="col-4">
                                                            <span class="text-secondary label-span">Catatan</span>
                                                      </div>
                                                      <div class="col-auto">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $rows_grpo->GRPORemarks . '</span>
                                                      </div>
                                                </div>  
                                          </div> 
                                          <div class="col-lg-4 col-md-12 col-12">
                                                <div class="row">
                                                      <div class="col-4">
                                                            <span class="text-secondary label-span">Referensi</span>
                                                      </div>
                                                      <div class="col-auto">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $rows_grpo->GRPORef . '</span>
                                                      </div>
                                                </div>  
                                          </div> 
                                          <div class="col-md-12 d-flex flex-column mt-1" style="border: 1px solid #d2cac0;border-radius: 0.25rem;">
                                                ' . $detailgrpo . '
                                          </div>
                                          <div class="col-md-12 d-flex pt-2">
                                                <button type="button" onclick="grpo_edit(\'' . $rows_grpo->GRPOId . '\')" class="btn btn-transparent btn-sm mx-1" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-pencil-alt"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Edit
                                                      </span>
                                                </button>
                                                <button type="button" class="btn btn-transparent btn-sm mx-1 dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false" style="border:1px solid;font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-print"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Print
                                                      </span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-sm w-16rem">
                                                      <li><a class="dropdown-item" onclick="grpo_print_a5(\'' . $rows_grpo->GRPOId . '\')"><i class="fas fa-file"  style="min-width:20px"></i>&nbsp;Print ukuran A5</a></li>
                                                      <li><a class="dropdown-item" onclick="grpo_print_a6(\'' . $rows_grpo->GRPOId . '\')"><i class="fas fa-file"  style="min-width:20px"></i>&nbsp;Print ukuran A6</a></li>
                                                </ul>
                                                <button type="button" onclick="grpo_delete(\'' . $rows_grpo->GRPOId . '\')" class="btn btn-transparent btn-sm mx-1" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-times"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Hapus
                                                      </span>
                                                </button> 
                                          </div>
                                    </div> 
                              </div>
                        <script>
                              $("[data-bs-toggle=\'tooltip\']").tooltip()
                        </script>';
                  }
                  if ($grpo == "")  $grpo = '<div class="text-center fw-bold mt-2">Belum Ada GRPO yang dibuat</div><br>';
                  $po = '<div class="m-2 px-4 py-2 shadow-sm" style="border-bottom: 1px dashed #ff7900;background: #f9f9f9;border: 1px solid #bdbdbd;border-radius: 5px;box-shadow: 5px 0px 0px #ff7900 inset !important;">
                                    <div class="row py-1 g-1">
                                          <div class="col-12">
                                                <span class="fw-bold" style="font-size:1rem">Purchase Order (' . ($master->SalesRef == "" ? "PO STOCK" : "PO Sales") . ')
                                          </div>  
                                          <div class="col-lg-4 col-md-6 col-12">
                                                <div class="row g-1">
                                                      <div class="col-2">
                                                            <span class="text-dark fw-bold label-span">No. Doc</span>
                                                      </div> 
                                                      <div class="col-10">
                                                            <span class="text-secondary " style="font-size:0.7rem;">' . $master->POCode . '</span>
                                                      </div>  
                                                      <div class="col-2">
                                                            <span class="text-dark fw-bold label-span">Tgl PO</span>
                                                      </div> 
                                                      <div class="col-10">
                                                            <span class="text-secondary " style="font-size:0.7rem;">' . date_format(date_create($master->PODate), "d F Y") . '</span>
                                                      </div>   
                                                      <div class="col-2">
                                                            <span class="text-dark fw-bold label-span">Toko</span>
                                                      </div> 
                                                      <div class="col-10">
                                                            <span class="text-secondary " style="font-size:0.7rem;">' . $master->src . '</span>
                                                      </div>  
                                                      <div class="col-2">
                                                            <span class="text-dark fw-bold label-span">Pembuat</span>
                                                      </div> 
                                                      <div class="col-10">
                                                            <span class="text-secondary " style="font-size:0.7rem;">' . $this->model_app->get_single_data("MsEmpName", "TblMsEmployee", array("MsEmpId" => $master->MsEmpId))  . '</span>
                                                      </div> 
                                                </div>
                                          </div>
                                          <div class="col-lg-4 col-md-6 col-12">
                                                <div class="row g-1">
                                                      <div class="col-2">
                                                            <span class="text-dark fw-bold label-span">Vendor</span>
                                                      </div> 
                                                      <div class="col-10">
                                                            <span class="text-secondary " style="font-size:0.7rem;">' . $master->MsVendorCode . '</span>
                                                      </div>  
                                                      <div class="col-2">
                                                            <span class="text-dark fw-bold label-span">Kirim Ke</span>
                                                      </div> 
                                                      <div class="col-10">
                                                            <span class="text-secondary " style="font-size:0.7rem;">' . ($master->PODst == 0 ? "CUSTOMER" : $master->dst) . '</span>
                                                      </div>  
                                                      <div class="col-2">
                                                            <span class="text-dark fw-bold label-span">Estimasi</span>
                                                      </div> 
                                                      <div class="col-10">
                                                            <span class="text-secondary " style="font-size:0.7rem;">' . date_format(date_create($master->POEstimate), "d F Y") . '</span>
                                                      </div>   
                                                      <div class="col-2">
                                                            <span class="text-dark fw-bold label-span">Catatan</span>
                                                      </div> 
                                                      <div class="col-10">
                                                            <span class="text-secondary " style="font-size:0.7rem;">' . $master->PORemarks . '</span>
                                                      </div>  
                                                </div> 
                                          </div>
                                          <div class="col-lg-4 col-md-12 col-12">
                                                <div class="list-progress" style="">
                                                      <span class="fa-stack text-secondary ' . ($master->POStatus >= 0 ? "success" : "") . '" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="dijadwalkan">
                                                            <i class="fas fa-circle fa-stack-2x" ></i>
                                                            <i class="fas fa-calendar-alt fa-stack-1x"></i>
                                                      </span>
                                                      <span class="fa-stack text-secondary ' . ($master->POStatus >= 1 ? "success" : "") . '" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="diproses">
                                                            <i class="fas fa-circle fa-stack-2x" ></i>
                                                            <i class="fas fa-project-diagram fa-stack-1x" ></i>
                                                      </span>
                                                      <span class="fa-stack text-secondary ' . ($master->POStatus >= 2 ? "success" : "") . '" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="diterima">
                                                            <i class="fas fa-circle fa-stack-2x"></i>
                                                            <i class="fas fa-people-carry fa-stack-1x"></i>
                                                      </span>
                                                      <div class="progress">
                                                            <div class="progress-bar bg-success" role="progressbar" style="width: ' . $valueprogress . '%" aria-valuenow="' . $valueprogress . '" aria-valuemin="0" aria-valuemax="100"></div>
                                                      </div>
                                                </div>
                                          </div> 
                                          ' . $button . '
                                    </div>
                                    <ul class="nav nav-tabs" role="tablist">
                                          <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="item-tab" data-bs-toggle="tab" data-bs-target="#item-' . $master->POId . '" type="button" role="tab" aria-controls="item-' . $master->POId . '" aria-selected="false">Detail Item</button>
                                          </li> 
                                          <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="delivery-tab" data-bs-toggle="tab" data-bs-target="#delivery-' . $master->POId . '" type="button" role="tab" aria-controls="delivery-' . $master->POId . '" aria-selected="false">Pengiriman</button>
                                          </li> 
                                          <li class="nav-item" role="presentation">
                                                <button class="nav-link " id="grpo-tab" data-bs-toggle="tab" data-bs-target="#grpo-' . $master->POId . '" type="button" role="tab" aria-controls="grpo-' . $master->POId . '" aria-selected="true">Good Receipt From PO</button>
                                          </li>
                                    </ul>
                                    <div class="tab-content">
                                          <div class="tab-pane p-2 fade show active" id="item-' . $master->POId . '" role="tabpanel" aria-labelledby="item-tab">
                                                ' . $detailpo . '  
                                          </div> 
                                          <div class="tab-pane fade" id="delivery-' . $master->POId . '" role="tabpanel" aria-labelledby="delivery-tab">
                                                ' . $delivery . ' 
                                                <div class="text-center">
                                                      <button class="btn btn-success btn-sm mt-2 py-1" type="button" onclick="delivery_add(' . $master->POId . ')"> 
                                                            <small><span class="fas fa-plus"></span>&nbsp;Buat Pengiriman</small>
                                                      </button>
                                                </div>
                                          </div> 
                                          <div class="tab-pane fade" id="grpo-' . $master->POId . '" role="tabpanel" aria-labelledby="grpo-tab">
                                                ' . $grpo . ' 
                                                <div class="text-center">
                                                      <button class="btn btn-success btn-sm mt-2 py-1" type="button" onclick="grpo_add(' . $master->POId . ')"> 
                                                            <small><span class="fas fa-plus"></span>&nbsp;Buat Penerimaan</small>
                                                      </button>
                                                </div>
                                          </div>
                                    </div>

                              </div> ';



                  $row = array();
                  $row[] = $po;
                  $row[] = $master->POId;
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
      function get_detail_po()
      {
            $query1 = $this->db->query("select * from TblPODetail left join TblMsItem on TblPODetail.MsItemId=TblMsItem.MsItemId LEFT JOIN TblMsItemCategory on TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId  where PODetailRef='" . $this->input->post("code") . "'")->result();
            $detailpo = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;width:100%">';
            foreach ($query1 as $row1) {
                  $detailpo .= '    <tr><td><div class="row align-items-center border-light border-bottom border-top me-2 py-1">
                                    <div class="col-8">
                                          <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemCode . '-' . $row1->MsItemName . '</span><br>
                                          <span class="text-secondary">Ukuran : <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemSize . '</span></span>
                                    </div>
                                    <div class="col-4 text-right">
                                          <span class="text-secondary">Qty</span><br>
                                          <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->PODetailQty . ' ' . $row1->MsItemUoM . '</span>
                                    </div>
                              </div>
                              </tr></td>';
            }
            echo  $detailpo . '</table>';
      }
      function get_data_po_ref()
      {
            $search = $this->input->post("search");
            $store = $this->input->post("store");

            $data = $this->db
                  ->join("TblMsVendor", "TblMsVendor.MsVendorId=TblPO.MsVendorId", "left")
                  ->join("TblPODetail", "TblPO.POCode=TblPODetail.PODetailRef", "left")
                  ->join("TblMsItem", "TblMsItem.MsItemId=TblPODetail.MsItemId", "left")
                  ->join("TblSales", "TblSales.SalesCode=TblPO.SalesRef", "left")
                  ->join("TblMsCustomer", "TblMsCustomer.MsCustomerId=TblSales.MsCustomerId", "left")
                  ->join("TblMsEmployee", "TblMsEmployee.MsEmpId=TblSales.MsEmpId", "left")
                  ->group_start()
                  ->like("POCode", $search)
                  ->or_like("PORemarks", $search)
                  ->or_like("MsCustomerName", $search)
                  ->or_like("MsCustomerCompany", $search)
                  ->group_end()
                  ->where("POStatus !=", 2)
                  ->where("TblPO.MsWorkplaceId", $store)
                  ->group_by("POCode")
                  ->order_by('PODate DESC,POId DESC')
                  ->get("TblPO", 10)->result();
            $content = "";
            foreach ($data as $row) {
                  $query = $this->db->query("select * from TblPODetail 
                  left join TblMsItem on TblPODetail.MsItemId=TblMsItem.MsItemId 
                  LEFT JOIN TblMsItemCategory on TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId  
                  where PODetailRef='" . $row->POCode . "'")->result();
                  $item = "";
                  foreach ($query as $rows) {
                        $item .= '<div class="row py-1 g-2">
                                    <div class="col-md-4 col-12 ps-md-4">
                                          <span class="fw-bold" style="font-size:0.7rem;">' . $rows->MsItemCode . ' - ' . $rows->MsItemName . ' </span> 
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
                                                                  <span class="text-dark fw-bold">' . number_format($rows->PODetailQty) . ' ' . $rows->MsItemUoM . '</span>
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
                                                      <span class="fw-bold text-orange" style="font-size:11px;">' . $row->POCode . '</span>
                                                </div>
                                          </div> 
                                          <div class="row">  
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;">Vendor</span>
                                                </div>    
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-dark" style="font-size:11px;">' . $row->MsVendorCode . ' - ' . $row->MsVendorName . '</span>
                                                </div>
                                          </div> 
                                          <div class="row">  
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;">Keterangan</span>
                                                </div>    
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-dark" style="font-size:11px;">' . $row->PORemarks . '</span>
                                                </div>
                                          </div> 
                                    </div>
                                    <div class="col-md-6 col-sm-12 p-1 g-1" >
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;">Tanggal</span>
                                                </div>      
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-dark" style="font-size:12px;">' . date_format(date_create($row->PODate), "d F Y") . '</span>
                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;">Admin</span>
                                                </div>      
                                                <div class="col pe-0"> 
                                                      <span class="fw-bold text-dark" style="font-size:12px;">' . ($row->POName == "-" ? $row->MsEmpName : $row->POName) . '</span>
                                                </div>
                                          </div> 
                                          <div class="row">
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;">Kode Sales</span>
                                                </div>      
                                                <div class="col pe-0"> 
                                                      <span class="fw-bold text-dark" style="font-size:12px;">' . $row->SalesCode . '</span>
                                                </div>
                                          </div> 
                                          <div class="row">  
                                                <div class="col-auto pe-0 text-center" style="min-width:30px;">
                                                      <span class="fw-bold text-secondary" style="font-size:12px;">Customer</span>
                                                </div>    
                                                <div class="col pe-0">
                                                      <span class="fw-bold text-dark" style="font-size:11px;">' . $row->MsCustomerName . '</span>
                                                </div>
                                          </div> 
                                    </div> 
                                    <div class="col-12 g-1">
                                          <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                      <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#detail-item-' . $row->POId . '" type="button" role="tab" aria-controls="detail-item-' . $row->POId . '" aria-selected="true">Detail Item</button>
                                                </li> 
                                          </ul>
                                          <div class="tab-content" >
                                                <div class="tab-pane p-2 border border-top-0 fade show active" id="detail-item-' . $row->POId . '"" role="tabpanel" aria-labelledby="detail-item-' . $row->POId . '">
                                                      ' . $item . ' 
                                                </div> 
                                          </div>
                                    </div> 
                                    <div class="datatable-action py-2 mt-1"> 
                                          <div class="dropdown float-end dropup"> 
                                                <button class="btn btn-success btn-sm py-1" type="button" onclick="po_select(\'' . $row->POId . '\' )">
                                                      pilih data ini
                                                </button>
                                          </div>
                                    </div>
                              </div>';
            }
            if ($content == "") {
                  $content = '
                        <div>
					<img src="' . base_url("asset/image/iconnotfound.png") . '" class="rounded mx-auto d-block" alt="...">
				</div>';
            }
            echo $content;
      }
      function get_data_grpo()
      {
            // SETUP DATATABLE
            $this->m_penjualan->table = 'TblGRPO';
            $this->m_penjualan->tablejoin = array(
                  array(0 => 'TblMsWorkplace', 1 => 'TblMsWorkplace.MsWorkplaceId=TblGRPO.MsWorkplaceId'),
                  array(0 => 'TblMsVendor', 1 => 'TblMsVendor.MsVendorId=TblGRPO.MsVendorId')
            );
            $this->m_penjualan->column_order = array(null, 'GRPODate', 'MsWorkplaceCode', null, 'GRPOCode', 'GRPORef', 'GRPORemarks'); //set column field database for datatable orderable
            $this->m_penjualan->column_search = array('GRPODate', 'MsWorkplaceCode', 'GRPOCode', 'GRPORef', 'GRPORemarks'); //set column field database for datatable searchable 
            $this->m_penjualan->order = array('GRPODate' => 'desc', 'GRPOId' => 'desc'); // default order 

            // PROSES DATA
            $list = $this->m_penjualan->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $master) {
                  $no++;
                  $row = array();
                  $row[] = $no;
                  $row[] = $master->GRPODate;
                  $row[] = $master->MsWorkplaceCode;
                  $row[] = $master->GRPOCode;
                  $row[] = $master->GRPORef;
                  $row[] = $master->MsVendorCode;
                  $row[] = $master->GRPORemarks;
                  $row[] = $master->GRPOCode;
                  $row[] = '  
                  <div class="d-flex flex-row">
                        <a onclick="edit_click(' . $master->GRPOId . ')" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                        <a onclick="grpo_print_a5(' . $master->GRPOId . ')" class="me-2 text-primary pointer" title="Edit Data"><i class="fas fa-print"></i></a> 
                        <a onclick="delete_click(' . $master->GRPOId . ')" class="me-2 text-danger pointer" title="Edit Data"><i class="fas fa-times"></i></a>
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
      function get_detail_grpo()
      {
            $query1 = $this->db->query("select * from TblGRPODetail left join TblMsItem on TblGRPODetail.MsItemId=TblMsItem.MsItemId LEFT JOIN TblMsItemCategory on TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId  where GRPODetailRef='" . $this->input->post("code") . "'")->result();
            $detailpo = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;width:100%">';
            foreach ($query1 as $row1) {
                  $detailpo .= '    <tr><td><div class="row align-items-center border-light border-bottom border-top me-2 py-1">
                                    <div class="col-8">
                                          <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemCode . '-' . $row1->MsItemName . '</span><br>
                                          <span class="text-secondary">Ukuran : <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemSize . '</span></span>
                                    </div>
                                    <div class="col-4 text-right">
                                          <span class="text-secondary">Qty</span><br>
                                          <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->GRPODetailQty . ' ' . $row1->MsItemUoM . '</span>
                                    </div>
                              </div>
                              </tr></td>';
            }
            echo  $detailpo . '</table>';
      }
}
