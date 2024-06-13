<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Client_datatable extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('master/Model_master', 'm_master');

        date_default_timezone_set('Asia/Jakarta');
    }

    function get_master_toko()
    {
        // SETUP DATATABLE
        $this->m_master->table = 'TblMsWorkplace';
        $this->m_master->column_order = array(null, 'MsWorkplaceCode', 'MsWorkplaceName', 'MsWorkplaceAddress'); //set column field database for datatable orderable
        $this->m_master->column_search = array('MsWorkplaceCode', 'MsWorkplaceName', 'MsWorkplaceAddress'); //set column field database for datatable searchable 
        $this->m_master->order = array('MsWorkplaceId' => 'asc'); // default order 

        // PROSES DATA
        $list = $this->m_master->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $master) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $master->MsWorkplaceCode;
            $row[] = $master->MsWorkplaceName;
            $row[] = ($master->MsWorkplaceIsActive == 0 ? '<span class="badge rounded-pill bg-danger pointer" onclick="enable_click(' . $master->MsWorkplaceId . ')">Tidak Aktif</span>' : '<span class="badge rounded-pill bg-success pointer" onclick="delete_click(' . $master->MsWorkplaceId . ')">Aktif</span>');
            $row[] = ' <div class="d-flex flex-row">
                        <a onclick="view_click(' . $master->MsWorkplaceId . ')" class="me-2 text-info pointer" title="View Data"><i class="fas fa-eye"></i></a>
                        <a onclick="edit_click(' . $master->MsWorkplaceId . ')" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                    </div>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_master->count_all(),
            "recordsFiltered" => $this->m_master->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    function get_master_menu_listing()
    {
        // SETUP DATATABLE
        $this->m_master->table = 'TblMenuListing';
        $this->m_master->column_order = array(null, 'MenuListingName'); //set column field database for datatable orderable
        $this->m_master->column_search = array('MenuListingName'); //set column field database for datatable searchable  
        $this->m_master->order = array('MenuListingName' => 'asc'); // default order 
        // PROSES DATA
        $list = $this->m_master->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $master) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $master->MenuListingName; 
            $row[] = '  <div class="d-flex flex-row">
                            <a onclick="edit_click(' . $master->MenuListingId . ')" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                        </div>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_master->count_all(),
            "recordsFiltered" => $this->m_master->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function get_master_jabatan()
    {
        // SETUP DATATABLE
        $this->m_master->table = 'TblMsEmployeePosition';
        $this->m_master->column_order = array(null, 'MsEmpPositionCode', 'MsEmpPositionName'); //set column field database for datatable orderable
        $this->m_master->column_search = array('MsEmpPositionCode', 'MsEmpPositionName'); //set column field database for datatable searchable 
        $this->m_master->order = array('MsEmpPositionId' => 'asc'); // default order 

        // PROSES DATA
        $list = $this->m_master->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $master) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $master->MsEmpPositionCode;
            $row[] = $master->MsEmpPositionName;
            $row[] = ($master->MsEmpPositionIsActive == 0 ? '<span class="badge rounded-pill bg-danger pointer" onclick="enable_click(' . $master->MsEmpPositionId . ')">Tidak Aktif</span>' : '<span class="badge rounded-pill bg-success pointer" onclick="delete_click(' . $master->MsEmpPositionId . ')">Aktif</span>');
            $row[] = ' <div class="d-flex flex-row">
                        <a onclick="view_click(' . $master->MsEmpPositionId . ')" class="me-2 text-info pointer" title="View Data"><i class="fas fa-eye"></i></a>
                        <a onclick="edit_click(' . $master->MsEmpPositionId . ')" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                    </div>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_master->count_all(),
            "recordsFiltered" => $this->m_master->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }

    function get_master_karyawan()
    {
        // SETUP DATATABLE
        $this->m_master->table = 'TblMsEmployee';
        $this->m_master->column_order = array(null, 'MsEmpCode', 'MsEmpName', 'MsEmpIsActive'); //set column field database for datatable orderable
        $this->m_master->column_search = array('MsEmpCode', 'MsEmpName'); //set column field database for datatable searchable 
        $this->m_master->order = array('MsEmpId' => 'asc'); // default order 

        // PROSES DATA
        $list = $this->m_master->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $master) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $master->MsEmpCode;
            $row[] = $master->MsEmpName;
            $row[] = ($master->MsEmpIsActive == 0 ? '<span class="badge rounded-pill bg-danger pointer" onclick="enable_click(' . $master->MsEmpId . ')">Tidak Aktif</span>' : '<span class="badge rounded-pill bg-success pointer" onclick="delete_click(' . $master->MsEmpId . ')">Aktif</span>');
            $row[] = ' <div class="d-flex flex-row">
                            <a onclick="view_click(' . $master->MsEmpId . ')" class="me-2 text-info pointer" title="View Data"><i class="fas fa-eye"></i></a>
                            <a onclick="edit_click(' . $master->MsEmpId . ')" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                        </div>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_master->count_all(),
            "recordsFiltered" => $this->m_master->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function get_master_staffcetak()
    {
        // SETUP DATATABLE
        $this->m_master->table = 'TblMsStaff';
        $this->m_master->column_order = array(null, 'StaffCode', 'StaffName'); //set column field database for datatable orderable
        $this->m_master->column_search = array('StaffCode', 'StaffName'); //set column field database for datatable searchable 
        $this->m_master->order = array('StaffId' => 'asc'); // default order 

        // PROSES DATA
        $list = $this->m_master->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $master) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $master->StaffCode;
            $row[] = $master->StaffName;
            $row[] = ($master->StaffIsActive == 0 ? '<span class="badge rounded-pill bg-danger pointer" onclick="enable_click(' . $master->StaffId . ')" >Tidak Aktif</span>' : '<span class="badge rounded-pill bg-success pointer" onclick="delete_click(' . $master->StaffId . ')">Aktif</span>');
            $row[] = ' <div class="d-flex flex-row">
                        <a onclick="view_click(' . $master->StaffId . ')" class="me-2 text-info pointer" title="View Data"><i class="fas fa-eye"></i></a>
                        <a onclick="edit_click(' . $master->StaffId . ')" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                    </div>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_master->count_all(),
            "recordsFiltered" => $this->m_master->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function get_master_item_category()
    {
        // SETUP DATATABLE
        $this->m_master->table = 'TblMsProdukCategory';
        $this->m_master->column_order = array(null, 'MsProdukCatCode', 'MsProdukCatName', 'MsProdukCatVisible'); //set column field database for datatable orderable
        $this->m_master->column_search = array('MsProdukCatCode', 'MsProdukCatName', 'MsProdukCatVisible'); //set column field database for datatable searchable 
        $this->m_master->order = array('MsProdukCatId' => 'asc'); // default order 

        // PROSES DATA
        $list = $this->m_master->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $master) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $master->MsProdukCatCode;
            $row[] = $master->MsProdukCatName;
            $row[] = ($master->MsProdukCatIsActive == 0 ? '<span class="badge rounded-pill bg-danger pointer"  onclick="enable_click(' . $master->MsProdukCatId . ')">Tidak Aktif</span>' : '<span class="badge rounded-pill bg-success pointer" onclick="delete_click(' . $master->MsProdukCatId . ')">Aktif</span>');
            $row[] =  ' <div class="d-flex flex-row">
                        <a onclick="view_click(' . $master->MsProdukCatId . ')" class="me-2 text-info pointer" title="View Data"><i class="fas fa-eye"></i></a>
                        <a onclick="edit_click(' . $master->MsProdukCatId . ')" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                    </div>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_master->count_all(),
            "recordsFiltered" => $this->m_master->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function get_item(){
         // SETUP DATATABLE
        $data = array();
        $dataproduk = $this->db->join("TblMsProdukCategory","TblMsProdukCategory.MsProdukCatId=TblMsProduk.MsProdukCatId")->get("TblMsProduk")->result();
        $no= 0;
        foreach ($dataproduk as $master) { 
            if (file_exists(getcwd() . "/asset/image/produk/" .  $master->MsProdukId."/".$master->MsProdukCode."_1.png")) {
               $urlimage = base_url("asset/image/produk/".$master->MsProdukId."/".$master->MsProdukCode."_1.png");
            }else{ 
               $urlimage = base_url("asset/image/mgs-erp/defaultitem.png");
            }
            $no++;
            $row = array();
            $row["no"] = $no;
            $row["image"] = $urlimage;
            $row["Category"] = $master->MsProdukCatCode . ' - ' . $master->MsProdukCatName;
            $row["Code"] = $master->MsProdukCode;
            $row["Name"] = $master->MsProdukName; 
            $row["Sale"] = ($master->MsProdukSale == 0 ? '<span onclick="enable_sales_click(' . $master->MsProdukId . ')" class="badge rounded-pill bg-danger pointer">Tidak Aktif</span>' : '<span onclick="disable_sales_click(' . $master->MsProdukId . ')" class="badge rounded-pill bg-success pointer">Aktif</span>');
            $row["Stock"] = ($master->MsProdukStock == 0 ? '<span onclick="enable_active_click(' . $master->MsProdukId . ')" class="badge rounded-pill bg-danger pointer">Tidak Aktif</span>' : '<span onclick="disable_active_click(' . $master->MsProdukId . ')" class="badge rounded-pill bg-success pointer">Aktif</span>');
            $row["action"] = '
                <div class="d-flex flex-row">
                    <a onclick="view_click(' . $master->MsProdukId . ')" class="me-2 text-info pointer" title="View Data"><i class="fas fa-eye"></i></a>
                    <a onclick="edit_click(' . $master->MsProdukId . ')" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                </div>';
            $row["detail"] = $this->db->join("TblMsProdukBerat","TblMsProdukDetail.BeratId = TblMsProdukBerat.BeratId")->join("TblMsProdukSatuan","TblMsProdukDetail.SatuanId = TblMsProdukSatuan.SatuanId")->where("MsProdukDetailRef",$master->MsProdukId)->get("TblMsProdukDetail")->result();
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $no,
            "recordsFiltered" => $no,
            "data" => $data,
        ); 
        echo json_encode($output);
    }

    function get_list_produk(){
        $pagenow = $this->input->post("page");
        $search = $this->input->post("search"); 
        $kategori = $this->input->post("kategori");
        $page = ((int)$pagenow * 9) - 9;

        if($kategori!="0") $this->db->where("MsProdukCatId",$kategori);
        $this->db->group_start()->like("MsProdukCode",$search)->or_like("MsProdukName",$search)->or_like("MsProdukVarian",$search)->group_end();
        $list = $this->db->limit(9,$page)->get("TblMsProduk")->result();

        if($kategori!="0") $this->db->where("MsProdukCatId",$kategori);
        $this->db->group_start()->like("MsProdukCode",$search)->or_like("MsProdukName",$search)->or_like("MsProdukVarian",$search)->group_end();
        $count =  $this->db->get("TblMsProduk")->num_rows();
        $data = array();
        foreach ($list as $master) {
            if (file_exists(getcwd() . "/asset/image/produk/" .  $master->MsProdukId."/".$master->MsProdukCode."_1.png")) {
                $urlimage = base_url("asset/image/produk/".$master->MsProdukId."/".$master->MsProdukCode."_1.png");
             }else{ 
                $urlimage = base_url("asset/image/mgs-erp/defaultitem.png");
             }
            $row = array();
            $row["MsProdukId"] = $master->MsProdukId;
            $row["MsProdukCode"] = $master->MsProdukCode;
            $row["MsProdukName"] = $master->MsProdukName;
            $row["MsProdukVarian"] = $master->MsProdukVarian;
            $row["MsProdukImage"] = $urlimage; 
            $row["MsProdukDetail"] = $this->db->join("TblMsProdukSatuan","TblMsProdukSatuan.SatuanId=TblMsProdukDetail.SatuanId")->where("MsProdukDetailRef",$master->MsProdukId)->get("TblMsProdukDetail")->result();
            $row["MsProdukStock"] =  $this->db->where("MsProdukId",$master->MsProdukId)->get("TblMsProdukStock")->result();
            $data[] = $row;
        } 
        $output = array( 
            "data" => $data,
            "count" => $count,
        );

        //output to json format
        echo json_encode($output);
    }
    function get_master_item()
    {
        // SETUP DATATABLE
        $this->m_master->table = 'TblMsItem';
        $this->m_master->tablejoin = array(
            array(0 => 'TblMsItemCategory', 1 => 'TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId'),
            array(0 => 'TblMsVendor', 1 => "TblMsItem.MsItemVendor like concat('%',TblMsVendor.MsVendorCode,'%')")
        );
        $this->m_master->column_order = array(null, 'MsItemCatCode', 'MsItemCode', 'MsItemName', 'MsItemSize', 'MsItemUoM', 'MsItemVendor'); //set column field database for datatable orderable
        $this->m_master->column_search = array('MsItemCode', 'MsItemName'); //set column field database for datatable searchable 
        $this->m_master->order = array('MsItemCatCode' => 'asc', 'MsItemCode' => 'asc'); // default order 
        $this->m_master->group = array('TblMsItemCategory.MsItemCatCode', 'MsItemCode');
        // PROSES DATA
        $list = $this->m_master->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $master) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $master->MsItemCatCode . ' - ' . $master->MsItemCatName;
            $row[] = $master->MsItemCode;
            $row[] = $master->MsItemName;
            $row[] = $master->MsItemSize;
            $row[] = $master->MsItemUoM;
            $row[] = $master->MsItemVendor;
            $row[] = number_format($master->MsItemPrice,0);
            $row[] = ($master->MsItemSales == 0 ? '<span onclick="enable_sales_click(' . $master->MsItemId . ')" class="badge rounded-pill bg-danger pointer">Tidak Aktif</span>' : '<span onclick="disable_sales_click(' . $master->MsItemId . ')" class="badge rounded-pill bg-success pointer">Aktif</span>');
            $row[] = ($master->MsItemIsActive == 0 ? '<span onclick="enable_active_click(' . $master->MsItemId . ')" class="badge rounded-pill bg-danger pointer">Tidak Aktif</span>' : '<span onclick="disable_active_click(' . $master->MsItemId . ')" class="badge rounded-pill bg-success pointer">Aktif</span>');
            $row[] = '
                <div class="d-flex flex-row">
                    <a onclick="view_click(' . $master->MsItemId . ')" class="me-2 text-info pointer" title="View Data"><i class="fas fa-eye"></i></a>
                    <a onclick="edit_click(' . $master->MsItemId . ')" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                </div>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_master->count_all(),
            "recordsFiltered" => $this->m_master->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function get_master_item_listing()
    {
        // SETUP DATATABLE
        $this->m_master->table = 'TblInvStock';
        $this->m_master->tablejoin = array(
            array(0 => 'TblMsVendor', 1 => 'ifnull(TblInvStock.MsVendorId,0) = TblMsVendor.MsVendorId'),
            array(0 => 'TblMsItem', 1 => 'TblMsItem.MsItemId=TblInvStock.MsItemId'),
            array(0 => 'TblMsItemCategory', 1 => 'TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId'),
            array(0 => 'TblMsWorkplace', 1 => 'TblMsWorkplace.MsWorkplaceId=TblInvStock.MsWorkplaceId')
        );
        $this->m_master->column_order = array(
            null,
            'MsWorkplaceCode',
            'MsItemCatCode',
            'MsItemCode',
            'MsItemName',
            'MsItemSize',
            'MsItemUoM',
            'MsVendorCode',
            'InvStockVisible',
        ); //set column field database for datatable orderable
        $this->m_master->column_search = array('MsItemCode', 'MsItemName'); //set column field database for datatable searchable 
        $this->m_master->order = array('MsWorkplaceCode' => 'asc', 'MsItemCatCode' => 'asc', 'MsItemCode' => 'asc'); // default order 
        $this->m_master->group = array('TblMsItemCategory.MsItemCatCode', 'MsItemCode', 'MsVendorCode', 'TblMsWorkplace.MsWorkplaceId');
        // PROSES DATA
        $list = $this->m_master->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $master) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $master->MsWorkplaceCode;
            $row[] = $master->MsItemCatCode . ' - ' . $master->MsItemCatName;
            $row[] = $master->MsItemCode;
            $row[] = $master->MsItemName;
            $row[] = $master->MsItemSize;
            $row[] = $master->MsItemUoM;
            $row[] = $master->MsVendorCode;
            $row[] = ($master->InvStockVisible == 0 ? '<span onclick="enable_active_click(' . $master->InvStockId . ')" class="badge rounded-pill bg-danger pointer">Tidak Aktif</span>' : '<span onclick="disable_active_click(' . $master->InvStockId . ')" class="badge rounded-pill bg-success pointer">Aktif</span>');
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_master->count_all(),
            "recordsFiltered" => $this->m_master->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function get_master_vendor()
    {
        // SETUP DATATABLE
        $this->m_master->table = 'TblMsVendor';
        $this->m_master->column_order = array(null, 'MsVendorCode', 'MsVendorName'); //set column field database for datatable orderable
        $this->m_master->column_search = array('MsVendorCode', 'MsVendorName'); //set column field database for datatable searchable 
        $this->m_master->order = array('MsVendorId' => 'asc'); // default order 

        // PROSES DATA
        $list = $this->m_master->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $master) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $master->MsVendorCode;
            $row[] = $master->MsVendorName;
            $row[] = ($master->MsVendorIsActive == 0 ? '<span class="badge rounded-pill bg-danger pointer"  onclick="enable_click(' . $master->MsVendorId . ')" >Tidak Aktif</span>' : '<span class="badge rounded-pill bg-success pointer" onclick="delete_click(' . $master->MsVendorId . ')" >Aktif</span>');
            $row[] = ' <div class="d-flex flex-row">
                        <a onclick="view_click(' . $master->MsVendorId . ')" class="me-2 text-info pointer" title="View Data"><i class="fas fa-eye"></i></a>
                        <a onclick="edit_click(' . $master->MsVendorId . ')" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                    </div>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_master->count_all(),
            "recordsFiltered" => $this->m_master->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }

    function get_master_customer_type()
    {
        // SETUP DATATABLE
        $this->m_master->table = 'TblMsCustomerType';
        $this->m_master->column_order = array(null, 'MsCustomerTypeName'); //set column field database for datatable orderable
        $this->m_master->column_search = array('MsCustomerTypeName'); //set column field database for datatable searchable 
        $this->m_master->order = array('MsCustomerTypeId' => 'asc'); // default order 

        // PROSES DATA
        $list = $this->m_master->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $master) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $master->MsCustomerTypeName;
            $row[] = ($master->MsCustomerTypeIsActive == 0 ? '<span class="badge rounded-pill bg-danger pointer" onclick="enable_click(' . $master->MsCustomerTypeId . ')" >Tidak Aktif</span>' : '<span class="badge rounded-pill bg-success pointer" onclick="delete_click(' . $master->MsCustomerTypeId . ')">Aktif</span>');
            $row[] = ' <div class="d-flex flex-row">
                        <a onclick="view_click(' . $master->MsCustomerTypeId . ')" class="me-2 text-info pointer" title="View Data"><i class="fas fa-eye"></i></a>
                        <a onclick="edit_click(' . $master->MsCustomerTypeId . ')" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                    </div>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_master->count_all(),
            "recordsFiltered" => $this->m_master->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }

    function get_master_customer()
    {
        // SETUP DATATABLE
        $this->m_master->table = 'TblMsCustomer';
        $this->m_master->column_order = array(null, 'MsCustomerCode', 'MsCustomerName', 'MsCustomerTypeName', 'MsCustomerCompany', 'MsCustomerAddress'); //set column field database for datatable orderable
        $this->m_master->column_search = array('MsCustomerCode', 'MsCustomerName', 'MsCustomerCode', 'MsCustomerTypeName', 'MsCustomerCompany', 'MsCustomerAddress'); //set column field database for datatable searchable 
        $this->m_master->order = array('MsCustomerId' => 'desc'); // default order 
        $this->m_master->tablejoin = array(
            array(0 => 'TblMsCustomerType', 1 => "TblMsCustomerType.MsCustomerTypeId = TblMsCustomer.MsCustomerTypeId")
        );
        // PROSES DATA
        $list = $this->m_master->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $master) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $master->MsCustomerTypeName;
            $row[] = $master->MsCustomerCode;
            $row[] = $master->MsCustomerName;
            $row[] = $master->MsCustomerCompany;
            $row[] = $master->MsCustomerAddress;
            $row[] = ($master->MsCustomerIsActive == 0 ? '<span onclick="enable_click(' . $master->MsCustomerId . ')" class="badge rounded-pill bg-danger pointer">Tidak Aktif</span>' : '<span onclick="delete_click(' . $master->MsCustomerId . ')" class="badge rounded-pill bg-success pointer">Aktif</span>');
            $row[] =  ' <div class="d-flex flex-row">
                            <a onclick="view_click(' . $master->MsCustomerId . ')" class="me-2 text-info pointer" title="View Data"><i class="fas fa-eye"></i></a>
                            <a onclick="edit_click(' . $master->MsCustomerId . ')" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                        </div>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_master->count_all(),
            "recordsFiltered" => $this->m_master->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }

    function get_master_pembayaran_type()
    {
        // SETUP DATATABLE
        $this->m_master->table = 'TblMsMethod';
        $this->m_master->column_order = array(null, 'MsMethodCode', 'MsMethodName'); //set column field database for datatable orderable
        $this->m_master->column_search = array('MsMethodCode', 'MsMethodName'); //set column field database for datatable searchable 
        $this->m_master->order = array('MsMethodId' => 'asc'); // default order 

        // PROSES DATA
        $list = $this->m_master->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $master) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $master->MsMethodCode;
            $row[] = $master->MsMethodName;
            $row[] = ($master->MsMethodIsActive == 0 ? '<span onclick="enable_click(' . $master->MsMethodId . ')" class="badge rounded-pill bg-danger pointer">Tidak Aktif</span>' : '<span onclick="delete_click(' . $master->MsMethodId . ')" class="badge rounded-pill bg-success pointer">Aktif</span>');
            $row[] = '
                <div class="d-flex flex-row">
                    <a onclick="view_click(' . $master->MsMethodId . ')" class="me-2 text-info pointer" title="View Data"><i class="fas fa-eye"></i></a>
                    <a onclick="edit_click(' . $master->MsMethodId . ')" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                </div>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_master->count_all(),
            "recordsFiltered" => $this->m_master->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }

    function get_master_item_bom()
    {
        // SETUP DATATABLE
        $this->m_master->table = 'TblMsItem';
        $this->m_master->select = array(
            'MsItemBomId',
            'MsItemCatCode',
            'MsItemCatName',
            'MsItemCode',
            'MsItemName',
            'MsItemSize',
            'MsItemUoM',
            'TblMsItem.MsItemId',
        );
        $this->m_master->tablejoin = array(
            array(0 => 'TblMsVendor', 1 => 'TblMsItem.MsItemVendor like concat("%",TblMsVendor.MsVendorCode,"%")', 2 => "left"),
            array(0 => 'TblMsItemCategory', 1 => 'TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId', 2 => "left"),
            array(0 => 'TblMsItemBom', 1 => 'TblMsItem.MsItemId=TblMsItemBom.MsItemId', 2 => "left"),
        );
        $this->m_master->column_order = array(
            null,
            'MsItemCatCode',
            'MsItemCode',
            'MsItemName',
            'MsItemSize',
            'MsItemUoM',
        ); //set column field database for datatable orderable
        $this->m_master->column_search = array('MsItemCode', 'MsItemName'); //set column field database for datatable searchable 
        $this->m_master->order = array('MsItemCatCode' => 'asc', 'MsItemCode' => 'asc'); // default order 
        $this->m_master->group = array();
        // PROSES DATA
        $list = $this->m_master->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $master) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $master->MsItemCatCode . ' - ' . $master->MsItemCatName;
            $row[] = $master->MsItemCode;
            $row[] = $master->MsItemName;
            $row[] = $master->MsItemSize;
            $row[] = $master->MsItemUoM;
            $row[] = ($master->MsItemBomId == null ? '<span class="badge rounded-pill bg-danger">Tidak Ada</span>' : '<span class="badge rounded-pill bg-success">Ada</span>');
            $row[] = '
                <div class="d-flex flex-row">
                    <a onclick="edit_click(' . $master->MsItemId . ',' . ($master->MsItemBomId == null ? null : $master->MsItemBomId) . ')" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                </div>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_master->count_all(),
            "recordsFiltered" => $this->m_master->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function get_master_select_item_bom()
    {
        // SETUP DATATABLE
        $this->m_master->table = 'TblMsItemBom';
        $this->m_master->select = array(
            'MsItemBomId',
            'MsItemCatCode',
            'MsItemCatName',
            'MsItemCode',
            'MsItemName',
            'MsItemSize',
            'MsItemUoM',
            'MsItemBomCount',
            'TblMsItemBom.MsVendorCode',
            'MsItemPrice',
            'MsItemPcsM2',
            'TblMsItem.MsItemId',
        );
        $this->m_master->tablejoin = array(
            array(0 => 'TblMsItem', 1 => 'TblMsItemBom.MsItemId=TblMsItem.MsItemId'),
            array(0 => 'TblMsItemCategory', 1 => 'TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId'),
        );
        $this->m_master->column_order = array(
            null,
            'MsItemCatCode',
            'MsItemCode',
            'MsItemName',
            'MsItemSize',
            'MsItemUoM',
        ); //set column field database for datatable orderable
        $this->m_master->column_search = array('MsItemCode', 'MsItemName'); //set column field database for datatable searchable 
        $this->m_master->order = array('MsItemCatCode' => 'asc', 'MsItemCode' => 'asc'); // default order 
        $this->m_master->group = array();
        // PROSES DATA
        $list = $this->m_master->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $master) {
            $query = $this->db->query("select * from TblMsItemBomDetail left join TblMsItem on TblMsItemBomDetail.MsItemId=TblMsItem.MsItemId LEFT JOIN TblMsItemCategory on TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId  where MsItemBomId='" . $master->MsItemBomId . "'")->result();
            $item = "";
            foreach ($query as $row) {
                $item .= '  <div class="row">
                                <div class="col-lg-6">
                                    <span class="fw-bolder" style="font-size:12px;">' . $row->MsItemCode . '-' . $row->MsItemName . ' (' . $row->MsVendorCode . ')</span>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <span>' . $row->MsItemSize . '</span>&nbsp;|&nbsp;' . $row->MsItemPcsM2 . '</span>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <span>Total : <span class="fw-bolder" style="font-size:12px;">' . $row->MsItemBomDetailCount . '</span>&nbsp;' . $row->MsItemUoM . '</span>
                                </div>
                            </div>';
            }
            if (strlen($item) == 0) $item = '<div class="text-center"><span class="card-text">Tidak Ada Data</span></div>';
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<div class="row" data-bs-toggle="collapse" href="#data-item-bom-' . $master->MsItemBomId . '">
                        <div class="col-lg-6" >
                            <span class="fw-bolder" style="font-size:14px;">' . $master->MsItemCode . '-' . $master->MsItemName . ' (' . $master->MsVendorCode . ')</span>
                        </div>
                        <div class="col-lg-6" >
                            <span>Total : <span class="fw-bolder" style="font-size:14px;">' . $master->MsItemBomCount . '</span>&nbsp;' . $master->MsItemUoM . '</span>
                        </div>
                        <div class="col-lg-6" >
                            <span>kategori : <b>' . $master->MsItemCatCode . '-' . $master->MsItemCatName . '</b></span>
                        </div>
                        <div class="col-lg-6">
                            <span>Rp. ' . $master->MsItemPrice . '</span>&nbsp;|&nbsp;<span>' . $master->MsItemSize . '</span>&nbsp;|&nbsp;' . $master->MsItemPcsM2 . '</span>
                        </div>
                    </div>
                    
                    <div class="collapse my-2" id="data-item-bom-' . $master->MsItemBomId . '">
                        <div class="card card-body">
                        ' . $item . '
                        </div>
                    </div>';
            $row[] = $master->MsItemBomId;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_master->count_all(),
            "recordsFiltered" => $this->m_master->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function get_master_item_cogs()
    {
        // SETUP DATATABLE
        $this->m_master->table = 'TblMsItem';
        $this->m_master->select = array(
            'MsItemCatCode',
            'MsItemCatName',
            'MsItemCode',
            'MsItemName',
            'MsItemSize',
            'MsItemUoM',
            'MsVendorCode',
            'MsCogsTotal',
            'MsCogsId',
            'TblMsItem.MsItemId',
            'TblMsVendor.MsVendorId'
        );
        $this->m_master->tablejoin = array(
            array(0 => 'TblMsVendor', 1 => 'TblMsItem.MsItemVendor like concat("%",TblMsVendor.MsVendorCode,"%")', 2 => "left"),
            array(0 => 'TblMsItemCategory', 1 => 'TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId', 2 => "left"),
            array(0 => 'TblMsCogs', 1 => "(TblMsCogs.MsItemId=TblMsItem.MsItemId AND TblMsVendor.MsVendorId=TblMsCogs.MsVendorId)", 2 => "left"),
        );
        $this->m_master->column_order = array(
            null,
            'MsItemCatCode',
            'MsItemCode',
            'MsItemName',
            'MsItemSize',
            'MsItemUoM',
            'MsVendorCode',
            'MsCogsTotal',
        ); //set column field database for datatable orderable
        $this->m_master->column_search = array('MsItemCode', 'MsItemName'); //set column field database for datatable searchable 
        $this->m_master->order = array('MsItemCatCode' => 'asc', 'MsItemCode' => 'asc'); // default order 
        $this->m_master->group = array();
        // PROSES DATA
        $list = $this->m_master->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $master) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $master->MsItemCatCode . ' - ' . $master->MsItemCatName;
            $row[] = $master->MsItemCode;
            $row[] = $master->MsItemName;
            $row[] = $master->MsItemSize;
            $row[] = $master->MsItemUoM;
            $row[] = $master->MsVendorCode;
            $row[] = $master->MsCogsTotal;
            $row[] = '
                <div class="d-flex flex-row">
                   <a onclick="edit_click(' . $master->MsVendorId . ',' . $master->MsItemId . ',' . $master->MsCogsId . ')" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                </div>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_master->count_all(),
            "recordsFiltered" => $this->m_master->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function get_master_delivery()
    {
        // SETUP DATATABLE
        $this->m_master->table = 'TblMsDelivery';
        $this->m_master->column_order = array(null, 'MsDeliveryName'); //set column field database for datatable orderable
        $this->m_master->column_search = array('MsDeliveryName'); //set column field database for datatable searchable 
        $this->m_master->order = array('MsDeliveryId' => 'asc'); // default order 

        // PROSES DATA
        $list = $this->m_master->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $master) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $master->MsDeliveryName;
            $row[] = ($master->MsDeliveryIsActive == 0 ? '<span class="badge rounded-pill bg-danger pointer" onclick="enable_click(' . $master->MsDeliveryId . ')" >Tidak Aktif</span>' : '<span class="badge rounded-pill bg-success pointer" onclick="delete_click(' . $master->MsDeliveryId . ')">Aktif</span>');
            $row[] = ' <div class="d-flex flex-row">
                        <a onclick="view_click(' . $master->MsDeliveryId . ')" class="me-2 text-info pointer" title="View Data"><i class="fas fa-eye"></i></a>
                        <a onclick="edit_click(' . $master->MsDeliveryId . ')" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>
                    </div>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_master->count_all(),
            "recordsFiltered" => $this->m_master->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }
}
