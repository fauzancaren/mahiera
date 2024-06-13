<?php
defined('BASEPATH') or exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Client_data_master extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('model_app');
        date_default_timezone_set('Asia/Jakarta');
    }

    /*
    |       ACTION DATA TOKO
    |
    |
    |       penambahan toko baru akan berpengaruh pada TblInvStock 
    |       Otomatis akan menambahkan stock berdasarkan item yang ada
    |
    |
    */
    public function validate_kode_toko()
    {
        $query = $this->db->query("SELECT * FROM TblMsWorkplace where MsWorkplaceCode='" . $_GET['MsWorkplaceCode'] . "'")->result();
        if ($query) {
            echo 'false';
        } else {
            echo 'true';
        }
        exit;
    }
    public function data_toko_add()
    {
        $status = true;
        // Insert Data Toko
        $data = array(
            "MsWorkplaceCode" => $this->input->post("MsWorkplaceCode"),
            "MsWorkplaceName" => $this->input->post("MsWorkplaceName"),
            "MsWorkplaceAddress" => $this->input->post("MsWorkplaceAddress"),
            "MsWorkplaceTelp1" => preg_replace('/\s+/', '', $this->input->post("MsWorkplaceTelp1")),
            "MsWorkplaceTelp2" => preg_replace('/\s+/', '', $this->input->post("MsWorkplaceTelp2")),
            "MsWorkplaceFax" => preg_replace('/\s+/', '', $this->input->post("MsWorkplaceFax")),
            "MsWorkplaceIsActive" => ($this->input->post("MsWorkplaceIsActive") == "" ? "0" : "1"),
            "MsWorkplaceType" => $this->input->post("MsWorkplaceType"),
            "MsWorkplaceLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName"),
        );
        $this->db->insert('TblMsWorkplace', $data);
        if ($status && ($this->db->affected_rows() != 1)) $data = false;
        // Get ID Toko
        $query = $this->db->query("SELECT MsWorkplaceId FROM TblMsWorkplace where MsWorkplaceCode='" . $this->input->post("MsWorkplaceCode") . "'")->result();
        $dataid = $query[0]->MsWorkplaceId;

        // Loop data item
        $query = $this->db->query("SELECT * FROM TblMsItem LEFT JOIN TblMsVendor on MsItemVendor like concat('%',MsVendorCode,'%')")->result();
        foreach ($query as $row) {
            $data = array(
                "MsItemId" => $row->MsItemId,
                "MsVendorId" => $row->MsVendorId,
                "MsWorkplaceId" => $dataid,
                "InvStockQty" => 0,
                "InvStockBuffer" => 0,
                "InvStockVisible" => 1,
            );
            $this->db->insert('TblInvStock', $data);
            if ($status && ($this->db->affected_rows() != 1)) $data = false;
        }
        echo $status;
        exit;
    }
    public function data_toko_edit($id)
    {
        $data = array(
            "MsWorkplaceCode" => $this->input->post("MsWorkplaceCode"),
            "MsWorkplaceName" => $this->input->post("MsWorkplaceName"),
            "MsWorkplaceAddress" => $this->input->post("MsWorkplaceAddress"),
            "MsWorkplaceTelp1" => preg_replace('/\s+/', '', $this->input->post("MsWorkplaceTelp1")),
            "MsWorkplaceTelp2" => preg_replace('/\s+/', '', $this->input->post("MsWorkplaceTelp2")),
            "MsWorkplaceFax" => preg_replace('/\s+/', '', $this->input->post("MsWorkplaceFax")),
            "MsWorkplaceIsActive" => ($this->input->post("MsWorkplaceIsActive") == "" ? "0" : "1"),
            "MsWorkplaceType" => $this->input->post("MsWorkplaceType"),
            "MsWorkplaceLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName"),
        );
        $this->db->update('TblMsWorkplace', $data, array('MsWorkplaceId' => $id));

        echo ($this->db->affected_rows() != 1) ? "false" : "true";
        exit;
    }
    public function data_toko_delete($id)
    {
        $this->db->update(
            'TblMsWorkplace',
            array(
                'MsWorkplaceIsActive' => 0,
                'MsWorkplaceLastUpdateUser' => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
            ),
            array('MsWorkplaceId' => $id)
        );
        echo ($this->db->affected_rows() != 1) ? "false" : "true";
        exit;
    }
    public function data_toko_enable($id)
    {
        $this->db->update(
            'TblMsWorkplace',
            array(
                'MsWorkplaceIsActive' => 1,
                'MsWorkplaceLastUpdateUser' => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
            ),
            array('MsWorkplaceId' => $id)
        );
        echo ($this->db->affected_rows() != 1) ? "false" : "true";
        exit;
    }

    /*
    *       ACTION DATA JABATAN
    */
    public function validate_kode_jabatan($kode = null)
    {
        if (!$kode == null) {
            $query = $this->db->query("SELECT * FROM TblMsEmployeePosition where MsEmpPositionCode='" . $_GET['MsEmpPositionCode'] . "' and not MsEmpPositionCode = '" . $kode . "'")->result();
        } else {
            $query = $this->db->query("SELECT * FROM TblMsEmployeePosition where MsEmpPositionCode='" . $_GET['MsEmpPositionCode'] . "'")->result();
        }
        if ($query) {
            echo 'false';
        } else {
            echo 'true';
        }
        exit;
    }
    public function data_jabatan_add()
    {
        $status = true;
        // Insert Data Toko
        $data = array(
            "MsEmpPositionCode" => $this->input->post("MsEmpPositionCode"),
            "MsEmpPositionName" => $this->input->post("MsEmpPositionName"),
            "MsEmpPositionIsActive" => ($this->input->post("MsEmpPositionIsActive") == "" ? "0" : "1"),
            "MsEmpPositionLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName"),
        );
        $this->db->insert('TblMsEmployeePosition', $data);

        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }
    public function data_jabatan_edit($id)
    {
        $data = array(
            "MsEmpPositionCode" => $this->input->post("MsEmpPositionCode"),
            "MsEmpPositionName" => $this->input->post("MsEmpPositionName"),
            "MsEmpPositionIsActive" => ($this->input->post("MsEmpPositionIsActive") == "" ? "0" : "1"),
            "MsEmpPositionLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName"),
        );
        $this->db->update('TblMsEmployeePosition', $data, array('MsEmpPositionId' => $id));

        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }
    public function data_jabatan_delete($id)
    {
        $this->db->update(
            'TblMsEmployeePosition',
            array(
                'MsEmpPositionIsActive' => 0,
                'MsEmpPositionLastUpdateUser' => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
            ),
            array('MsEmpPositionId' => $id)
        );
        echo ($this->db->affected_rows() != 1) ? "false" : "true";
        exit;
    }
    public function data_jabatan_enable($id)
    {
        $this->db->update(
            'TblMsEmployeePosition',
            array(
                'MsEmpPositionIsActive' => 1,
                'MsEmpPositionLastUpdateUser' => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
            ),
            array('MsEmpPositionId' => $id)
        );
        echo ($this->db->affected_rows() != 1) ? "false" : "true";
        exit;
    }

    /*
    *       ACTION DATA JABATAN
    */
    public function convert_data_dd_mm_yyyy($data)
    {
        $date = explode("/", $data);
        return $date[2] . "-" . $date[1] . "-" . $date[0];
    }
    public function data_karyawan_add()
    {
        $data = array(
            "MsEmpCode" => $this->input->post('MsEmpCode'),
            "MsEmpName" => $this->input->post('MsEmpName'),
            "MsEmpBirthDate" => $this->convert_data_dd_mm_yyyy($this->input->post('MsEmpBirthDate')),
            "MsEmpEmail" => $this->input->post('MsEmpEmail'),
            "MsEmpTlp" => $this->input->post('MsEmpTlp'),
            "MsEmpAddress" => $this->input->post('MsEmpAddress'),
            "MsEmpIsActive" => ($this->input->post("MsEmpIsActive") == "" ? "0" : "1"),
            "MsEmpStartWork" => $this->convert_data_dd_mm_yyyy($this->input->post('MsEmpStartWork')),
            "MsEmpPositionId" => $this->input->post('MsEmpPositionId'),
            "MsWorkplaceId" => $this->input->post('MsWorkplaceId'),
            "MsEmpMode" => $this->input->post('MsEmpMode'),
            "MsEmpBank" => $this->input->post('MsEmpBank'),
            "MsEmpRekNo" => $this->input->post('MsEmpRekNo'),
            "MsEmpRekName" => $this->input->post('MsEmpRekName'),
            "MsEmpNip" => $this->input->post('MsEmpNip'),
            "MsEmpGender" => $this->input->post('MsEmpGender'),
            "MsEmpBirthPlace" => $this->input->post('MsEmpBirthPlace'),
            "MsEmpCard" => $this->input->post('MsEmpCard'),
            "MsEmpLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName"),
        );
        $dataimage = $this->input->post('MsEmpImage');
        $this->model_app->base_64_to_image($dataimage, $data['MsEmpCode']);

        $this->db->insert('TblMsEmployee', $data);
        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }
    public function data_karyawan_edit($id)
    {
        $data = array(
            "MsEmpName" => $this->input->post('MsEmpName'),
            "MsEmpBirthDate" => $this->convert_data_dd_mm_yyyy($this->input->post('MsEmpBirthDate')),
            "MsEmpEmail" => $this->input->post('MsEmpEmail'),
            "MsEmpTlp" => $this->input->post('MsEmpTlp'),
            "MsEmpAddress" => $this->input->post('MsEmpAddress'),
            "MsEmpIsActive" => ($this->input->post("MsEmpIsActive") == "" ? "0" : "1"),
            "MsEmpStartWork" => $this->convert_data_dd_mm_yyyy($this->input->post('MsEmpStartWork')),
            "MsEmpPositionId" => $this->input->post('MsEmpPositionId'),
            "MsWorkplaceId" => $this->input->post('MsWorkplaceId'),
            "MsEmpBank" => $this->input->post('MsEmpBank'),
            "MsEmpRekNo" => $this->input->post('MsEmpRekNo'),
            "MsEmpRekName" => $this->input->post('MsEmpRekName'),
            "MsEmpNip" => $this->input->post('MsEmpNip'),
            "MsEmpMode" => $this->input->post('MsEmpMode'),
            "MsEmpGender" => $this->input->post('MsEmpGender'),
            "MsEmpBirthPlace" => $this->input->post('MsEmpBirthPlace'),
            "MsEmpCard" => $this->input->post('MsEmpCard'),
            "MsEmpLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName"),
        );

        $dataimage = $this->input->post('MsEmpImage');
        $this->model_app->base_64_to_image($dataimage, $this->input->post('MsEmpCode'));

        $this->db->update('TblMsEmployee', $data, array('MsEmpId' => $id));
        echo ($this->db->affected_rows() != 1) ? false : true;

        exit;
    }
    public function data_karyawan_delete($id)
    {
        $this->db->update(
            'TblMsEmployee',
            array(
                'MsEmpIsActive' => 0,
                'MsEmpLastUpdateUser' => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
            ),
            array('MsEmpId' => $id)
        );
        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }
    public function data_karyawan_enable($id)
    {
        $this->db->update(
            'TblMsEmployee',
            array(
                'MsEmpIsActive' => 1,
                'MsEmpLastUpdateUser' => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
            ),
            array('MsEmpId' => $id)
        );
        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }

    /*
    *       ACTION DATA JABATAN
    */ 
    public function data_staff_add()
    {
        $data = array(
            "StaffCode" => $this->input->post("StaffCode"),
            "StaffName" => $this->input->post("StaffName"),
            "StaffTelp" => $this->input->post("StaffTelp"),
            "StaffAddress" => $this->input->post("StaffAddress"),
            "StaffIsActive" => ($this->input->post("StaffIsActive") == "" ? "0" : "1"),
            "StaffLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName"),
        );
        $this->db->insert('TblMsStaff', $data);

        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }
    public function data_staff_edit($id)
    {
        $data = array(
            "StaffName" => $this->input->post("StaffName"),
            "StaffTelp" => $this->input->post("StaffTelp"),
            "StaffAddress" => $this->input->post("StaffAddress"),
            "StaffIsActive" => ($this->input->post("StaffIsActive") == "" ? "0" : "1"),
            "StaffLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName"),
        );
        $this->db->update('TblMsStaff', $data, array('StaffId' => $id));

        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }
    public function data_staff_delete($id)
    {
        $this->db->update(
            'TblMsStaff',
            array(
                'StaffIsActive' => 0,
                'StaffLastUpdateUser' => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
            ),
            array('StaffId' => $id)
        );
        echo ($this->db->affected_rows() != 1) ? "false" : "true";
        exit;
    }
    public function data_staff_enable($id)
    {
        $this->db->update(
            'TblMsStaff',
            array(
                'StaffIsActive' => 1,
                'StaffLastUpdateUser' => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
            ),
            array('StaffId' => $id)
        );
        echo ($this->db->affected_rows() != 1) ? "false" : "true";
        exit;
    }

    /*
    *       ACTION DATA ITEM CATEGORY
    */
    public function validate_kode_item_category($kode = null)
    {
        if (!$kode == null) {
            $query = $this->db->query("SELECT * FROM TblMsItemCategory where MsItemCatCode='" . $_GET['MsItemCatCode'] . "' and not MsItemCatCode = '" . $kode . "'")->result();
        } else {
            $query = $this->db->query("SELECT * FROM TblMsItemCategory where MsItemCatCode='" . $_GET['MsItemCatCode'] . "'")->result();
        }
        if ($query) {
            echo 'false';
        } else {
            echo 'true';
        }
        exit;
    }
    public function data_item_category_add()
    {
        $data = array(
            "MsItemCatCode" => $this->input->post("MsItemCatCode"),
            "MsItemCatName" => $this->input->post("MsItemCatName"),
            "MsItemCatIsActive" => ($this->input->post("MsItemCatIsActive") == "" ? "0" : "1"),
            "MsItemCatLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName"),
        );
        $this->db->insert('TblMsItemCategory', $data);

        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }
    public function data_item_category_edit($id)
    {
        $data = array(
            "MsItemCatCode" => $this->input->post("MsItemCatCode"),
            "MsItemCatName" => $this->input->post("MsItemCatName"),
            "MsItemCatIsActive" => ($this->input->post("MsItemCatIsActive") == "" ? "0" : "1"),
            "MsItemCatLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName"),
        );

        $this->db->update('TblMsItemCategory', $data, array('MsItemCatId' => $id));

        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }
    public function data_item_category_delete($id)
    {
        $this->db->update(
            'TblMsItemCategory',
            array(
                'MsItemCatIsActive' => 0,
                'MsItemCatLastUpdateUser' => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
            ),
            array('MsItemCatId' => $id)
        );
        echo ($this->db->affected_rows() != 1) ? "false" : "true";
        exit;
    }
    public function data_item_category_enable($id)
    {
        $this->db->update(
            'TblMsItemCategory',
            array(
                'MsItemCatIsActive' => 1,
                'MsItemCatLastUpdateUser' => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
            ),
            array('MsItemCatId' => $id)
        );
        echo ($this->db->affected_rows() != 1) ? "false" : "true";
        exit;
    }

    /*
    *       ACTION DATA ITEM MASTER
    */
    public function next_kode_item_master()
    {
        echo $this->model_app->get_next_id_item_master($this->input->post());
        exit;
    }
    public function next_kode_item()
    {
        echo $this->model_app->get_next_id_item($this->input->post());
        exit;
    }
    public function data_item_add(){
       
        $id = 0;
        $header = $this->input->post("header"); 
        $data = array(
            "MsProdukCatId" => $header["MsProdukCatId"],
            "MsProdukStock" => $header["MsProdukStock"],
            "MsProdukSale" =>  $header["MsProdukSale"],
            "MsProdukCode" =>  $header["MsProdukCode"],
            "MsProdukName" =>  $header["MsProdukName"],
            "MsProdukDesc" =>  $header["MsProdukDesc"],
            "MsProdukVarian" => $header["MsProdukVarian"],
        );  
        $this->db->insert('TblMsProduk', $data); //insert data header
        if ($this->db->affected_rows() == 1) {
            $this->db->select_max('MsProdukId');
            $query = $this->db->get('TblMsProduk')->row();
            $id = $query->MsProdukId; 
            $detail = $this->input->post("detail"); 
            foreach($detail as $det){
                $data = array(
                    "MsProdukDetailPrice" => $det["MsProdukDetailPrice"],
                    "MsProdukDetailCogs" =>  $det["MsProdukDetailCogs"],
                    "MsProdukDetailVarian" => $det["MsProdukVarian"],
                    "BeratId" =>  $det["BeratId"],
                    "MsProdukDetailBerat" =>  $det["BeratQty"],
                    "SatuanId" =>  $det["SatuanId"],
                    "MsProdukDetailRef" =>  $id, 
                    "MsProdukDetailpcsM2" => $det["MsProdukDetailpcsM2"],  
                );   
                $this->db->insert('TblMsProdukDetail', $data); //insert data detail
                
                $query = $this->db->get('TblMsWorkplace')->result();
                foreach($query as $row){
                    $data = array(
                        "MsProdukVarian" => $det["MsProdukVarian"],
                        "MsProdukId" =>  $id, 
                        "MsWorkplaceId" => $row->MsWorkplaceId,
                        "MsProdukStockQty" =>  0, 
                        "MsProdukStockBuffer" =>  0, 
                    );   
                    $this->db->insert('TblMsProdukStock', $data); //insert data detail
                }
            }
            
            echo $id;

            //insert data image 
            if (!file_exists('asset/image/produk/')) {
                mkdir("asset/image/produk", 0777);
            }
            if (!file_exists('asset/image/produk/' . $id . '/')) {
                mkdir("asset/image/produk/" . $id, 0777);
            }
            $image = $this->input->post("image");
            $no = 1;
            foreach($image as $img){ 
                imagepng(imagecreatefromstring(file_get_contents($img)), "asset/image/produk/". $id."/".$header["MsProdukCode"]."_".$no.".png");
                $no++; 
            }
           
        } else {
            echo 0;
        } 
        exit;
    } 

    
    public function data_item_edit($id){ 
        $header = $this->input->post("header"); 
        $data = array(
            "MsProdukCatId" => $header["MsProdukCatId"],
            "MsProdukStock" => $header["MsProdukStock"],
            "MsProdukSale" =>  $header["MsProdukSale"],
            "MsProdukCode" =>  $header["MsProdukCode"],
            "MsProdukName" =>  $header["MsProdukName"],
            "MsProdukDesc" =>  $header["MsProdukDesc"],
            "MsProdukVarian" => $header["MsProdukVarian"],
        );  
        $this->db->update('TblMsProduk', $data,array("MsProdukId"=>$id)); //update data header 
        $detail = $this->input->post("detail"); 
        foreach($detail as $det){
            $data = array(
                "MsProdukDetailPrice" => $det["MsProdukDetailPrice"],
                "MsProdukDetailVarian" => $det["MsProdukDetailVarian"],
                "BeratId" =>  $det["BeratId"],
                "MsProdukDetailBerat" =>  $det["BeratQty"],
                "SatuanId" =>  $det["SatuanId"],
                "MsProdukDetailRef" =>  $det["MsProdukDetailRef"], 
            );   
            if($det["MsProdukDetailId"]==0){ 
                $this->db->insert('TblMsProdukDetail', $data); //insert data detail 
            }else{
                $this->db->update('TblMsProdukDetail', $data,array("MsProdukDetailId"=>$det["MsProdukDetailId"])); //update data detail 
            } 
        }
        $removedata = $this->db->where("MsProdukDetailRef",$id)->get("TblMsProdukDetail")->result();
        foreach($removedata as $row){
            $is_exist = false;
            foreach($detail as $row1){
                if($row->MsProdukDetailVarian == $row1["MsProdukDetailVarian"]){
                    $is_exist = true;
                    break;
                }
            }
            if(!$is_exist) $this->db->delete("TblMsProdukDetail",array("MsProdukDetailId"=>$row->MsProdukDetailId)); 
        }
        
        echo $id;

        //insert data image 
        if (!file_exists('asset/image/produk/')) {
            mkdir("asset/image/produk", 0777);
        }
        if (!file_exists('asset/image/produk/' . $id . '/')) {
            mkdir("asset/image/produk/" . $id, 0777);
        }
        unlink('asset/image/produk/' . $id . '/*');
        $image = $this->input->post("image");
        $no = 1;
        foreach($image as $img){ 
            imagepng(imagecreatefromstring(file_get_contents($img)), "asset/image/produk/". $id."/".$header["MsProdukCode"]."_".$no.".png");
            $no++; 
        }
        
        exit;
    } 
    public function data_item_master_add()
    {
        $vendor = $this->input->post("MsItemVendor");
        $vendortext = "";
        foreach ($vendor as $key) {
            $vendortext .= $key . ";";
        }
        $vendortext = substr($vendortext, 0, -1);
        $data = array(
            "MsItemCode" => $this->input->post("MsItemCode"),
            "MsItemName" => $this->input->post("MsItemName"),
            "MsItemCatId" => $this->input->post("MsItemCatId"),
            "MsItemSales" => ($this->input->post("MsItemSales") == "" ? "0" : "1"),
            "MsItemIsActive" => ($this->input->post("MsItemIsActive") == "" ? "0" : "1"),
            "MsItemSize" => $this->input->post("MsItemSize"),
            "MsItemWeight" => $this->input->post("MsItemWeight"),
            "MsItemUoM" => $this->input->post("MsItemUoM"),
            "MsItemPcsM2" => $this->input->post("MsItemPcsM2"),
            "MsItemPcs" => str_replace(",", "", $this->input->post("MsItemPcs")),
            "MsItemPrice" => str_replace(",", "", $this->input->post("MsItemPrice")),
            "MsItemVendor" => $vendortext,
            "MsItemLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName"),
        );
        $this->db->insert('TblMsItem', $data);
        if ($this->db->affected_rows() == 1) {
            $this->db->select_max('MsItemId');
            $query = $this->db->get('TblMsItem')->result();
            $id = $query[0]->MsItemId;
            foreach ($vendor as $value) {
                $this->model_app->create_stock($id, $value);
            }
            echo true;
        } else {
            echo false;
        }
        exit;
    }
    public function data_item_master_edit($id)
    {
        $vendorold = $this->input->post("MsItemVendorOld");
        $vendor = $this->input->post("MsItemVendor");
        $vendortext = "";
        foreach ($vendor as $key) {
            $vendortext .= $key . ";";
        }
        $vendortext = substr($vendortext, 0, -1);
        $data = array(
            "MsItemName" => $this->input->post("MsItemName"),
            "MsItemCatId" => $this->input->post("MsItemCatId"),
            "MsItemSales" => ($this->input->post("MsItemSales") == "" ? "0" : "1"),
            "MsItemIsActive" => ($this->input->post("MsItemIsActive") == "" ? "0" : "1"),
            "MsItemSize" => $this->input->post("MsItemSize"),
            "MsItemWeight" => $this->input->post("MsItemWeight"),
            "MsItemUoM" => $this->input->post("MsItemUoM"),
            "MsItemPcsM2" => $this->input->post("MsItemPcsM2"),
            "MsItemPcs" => str_replace(",", "", $this->input->post("MsItemPcs")),
            "MsItemPrice" => str_replace(",", "", $this->input->post("MsItemPrice")),
            "MsItemVendor" => $vendortext,
            "MsItemLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName"),
        );
        $this->db->update('TblMsItem', $data, array('MsItemId' => $id));
        if ($this->db->affected_rows() == 1) {

            // CREATE STOCK
            $create = array_diff_assoc($vendor, $vendorold); // mencari perbaruan yang baru
            foreach ($create as $value) {
                $this->model_app->create_stock($id, $value);
            }

            // DELETE STOCK
            $create = array_diff_assoc($vendorold, $vendor); // mencari perbaruan yang dihapus
            foreach ($create as $value) {
                $this->model_app->delete_stock($id, $value);
            }

            echo true;
        } else {
            echo false;
        }
        exit;
    }
    public function data_item_master_disable_jual($id)
    {
        $this->db->update(
            'TblMsItem',
            array(
                'MsItemSales' => 0,
                'MsItemLastUpdateUser' => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
            ),
            array('MsItemId' => $id)
        );
        echo ($this->db->affected_rows() != 1) ? "false" : "true";
        exit;
    }
    public function data_item_master_enable_jual($id)
    {
        $this->db->update(
            'TblMsItem',
            array(
                'MsItemSales' => 1,
                'MsItemLastUpdateUser' => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
            ),
            array('MsItemId' => $id)
        );
        echo ($this->db->affected_rows() != 1) ? "false" : "true";
        exit;
    }
    public function data_item_master_disable($id)
    {
        $this->db->update(
            'TblMsItem',
            array(
                'MsItemIsActive' => 0,
                'MsItemLastUpdateUser' => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
            ),
            array('MsItemId' => $id)
        );
        echo ($this->db->affected_rows() != 1) ? "false" : "true";
        exit;
    }
    public function data_item_master_enable($id)
    {
        $this->db->update(
            'TblMsItem',
            array(
                'MsItemIsActive' => 1,
                'MsItemLastUpdateUser' => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
            ),
            array('MsItemId' => $id)
        );
        echo ($this->db->affected_rows() != 1) ? "false" : "true";
        exit;
    }

    /*
    *       ACTION DATA ITEM Listing
    */
    public function data_item_listing_enable($id)
    {
        $this->db->update(
            'TblInvStock',
            array(
                'InvStockVisible' => 1,
            ),
            array('InvStockId' => $id)
        );
        echo ($this->db->affected_rows() != 1) ? "false" : "true";
        exit;
    }
    public function data_item_listing_disable($id)
    {
        $this->db->update(
            'TblInvStock',
            array(
                'InvStockVisible' => 0,
            ),
            array('InvStockId' => $id)
        );
        echo ($this->db->affected_rows() != 1) ? "false" : "true";
        exit;
    }

    /*
    *       ACTION DATA VENDOR
    */
    public function validate_kode_vendor($kode = null)
    {
        if (!$kode == null) {
            $query = $this->db->query("SELECT * FROM TblMsVendor where MsVendorCode='" . $_GET['MsVendorCode'] . "' and not MsVendorCode = '" . $kode . "'")->result();
        } else {
            $query = $this->db->query("SELECT * FROM TblMsVendor where MsVendorCode='" . $_GET['MsVendorCode'] . "'")->result();
        }
        if ($query) {
            echo 'false';
        } else {
            echo 'true';
        }
        exit;
    }
    public function data_vendor_add()
    {
        $data = array(
            "MsVendorCode" => $this->input->post("MsVendorCode"),
            "MsVendorName" => $this->input->post("MsVendorName"),
            "MsVendorIsActive" => ($this->input->post("MsVendorIsActive") == "" ? "0" : "1"),
            "MsVendorLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName"),
        );
        $this->db->insert('TblMsVendor', $data);

        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }
    public function data_vendor_edit($id)
    {
        $data = array(
            "MsVendorCode" => $this->input->post("MsVendorCode"),
            "MsVendorName" => $this->input->post("MsVendorName"),
            "MsVendorIsActive" => ($this->input->post("MsVendorIsActive") == "" ? "0" : "1"),
            "MsVendorLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName"),
        );

        $this->db->update('TblMsVendor', $data, array('MsVendorId' => $id));

        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }
    public function data_vendor_delete($id)
    {
        $this->db->update(
            'TblMsVendor',
            array(
                'MsVendorIsActive' => 0,
                'MsVendorLastUpdateUser' => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
            ),
            array('MsVendorId' => $id)
        );
        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }
    public function data_vendor_enable($id)
    {
        $this->db->update(
            'TblMsVendor',
            array(
                'MsVendorIsActive' => 1,
                'MsVendorLastUpdateUser' => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
            ),
            array('MsVendorId' => $id)
        );
        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }

    /*
    *       ACTION DATA CUSTOMER TYPE
    */

    public function get_data_customer_type()
    {
        $search = isset($_REQUEST['search']) ? $_REQUEST['search'] : NULL;
        $query = $this->db->query("SELECT * FROM TblMsCustomerType where MsCustomerTypeIsActive='1' and MsCustomerTypeName like '%" . $search . "%'")->result();

        $list = array();
        $key = 0;
        foreach ($query as $row) {
            $list[$key]['id'] = $row->MsCustomerTypeId;
            $list[$key]['value'] = $row->MsCustomerTypeId;
            $list[$key]['text'] = $row->MsCustomerTypeName;
            $key++;
        }
        echo json_encode($list);
        exit;
    }
    public function validate_kode_customer_type($kode = null)
    {
        if (!$kode == null) {
            $query = $this->db->query("SELECT * FROM TblMsCustomerType where MsCustomerTypeName='" . $_GET['MsCustomerTypeName'] . "' and not MsCustomerTypeName = '" . $kode . "'")->result();
        } else {
            $query = $this->db->query("SELECT * FROM TblMsCustomerType where MsCustomerTypeName='" . $_GET['MsCustomerTypeName'] . "'")->result();
        }
        if ($query) {
            echo 'false';
        } else {
            echo 'true';
        }
        exit;
    }
    public function data_customer_type_add()
    {
        $data = array(
            "MsCustomerTypeName" => $this->input->post("MsCustomerTypeName"),
            "MsCustomerTypeIsActive" => ($this->input->post("MsCustomerTypeIsActive") == "" ? "0" : "1"),
            "MsCustomerTypeLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName"),
        );
        $this->db->insert('TblMsCustomerType', $data);
        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }
    public function data_customer_type_edit($id)
    {
        $data = array(
            "MsCustomerTypeName" => $this->input->post("MsCustomerTypeName"),
            "MsCustomerTypeIsActive" => ($this->input->post("MsCustomerTypeIsActive") == "" ? "0" : "1"),
            "MsCustomerTypeLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName"),
        );

        $this->db->update('TblMsCustomerType', $data, array('MsCustomerTypeId' => $id));

        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }
    public function data_customer_type_delete($id)
    {
        $this->db->update(
            'TblMsCustomerType',
            array(
                'MsCustomerTypeIsActive' => 0,
                'MsCustomerTypeLastUpdateUser' => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
            ),
            array('MsCustomerTypeId' => $id)
        );
        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }
    public function data_customer_type_enable($id)
    {
        $this->db->update(
            'TblMsCustomerType',
            array(
                'MsCustomerTypeIsActive' => 1,
                'MsCustomerTypeLastUpdateUser' => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
            ),
            array('MsCustomerTypeId' => $id)
        );
        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }
    
    public function get_data_city()
    {
        $type = $this->input->post("type");
        $select = $this->input->post("select");
        if($type == "prov"){
            $query = $this->db->query("SELECT * FROM TblMsProvince")->result();
            $list = array();
            $key = 0;
            foreach ($query as $row) {
                $list[$key]['id'] = $row->MsProvinceId;
                $list[$key]['value'] = $row->MsProvinceName;
                $list[$key]['text'] = $row->MsProvinceName;
                $list[$key]['kode'] = "";
                $key++;
            }
            echo json_encode($list);
            exit;
        }
        if($type == "kota"){
            $query = $this->db->query("SELECT * FROM TblMsRegency where MsProvinceId = '".$select["prov"]["id"]."'")->result();
            $list = array();
            $key = 0;
            foreach ($query as $row) {
                $list[$key]['id'] = $row->MsRegencyId;
                $list[$key]['value'] = $row->MsRegencyName;
                $list[$key]['text'] = $row->MsRegencyName;
                $list[$key]['kode'] = "";
                $key++;
            }
            echo json_encode($list);
            exit;
        }
        if($type == "kec"){
            $query = $this->db->query("SELECT * FROM TblMsDistrict where MsProvinceId = '".$select["prov"]["id"]."' and MsRegencyId = '".$select["kota"]["id"]."'")->result();
            $list = array();
            $key = 0;
            foreach ($query as $row) {
                $list[$key]['id'] = $row->MsDistrictId;
                $list[$key]['value'] = $row->MsDistrictName;
                $list[$key]['text'] = $row->MsDistrictName;
                $list[$key]['kode'] = "";
                $key++;
            }
            echo json_encode($list);
            exit;
        }
        if($type == "poscode"){
            $query = $this->db->query("SELECT * FROM TblMsVillage where MsProvinceId = '".$select["prov"]["id"]."' and MsRegencyId = '".$select["kota"]["id"]."' and MsDistrictId = '".$select["kec"]["id"]."'")->result();
            $list = array();
            $key = 0;
            foreach ($query as $row) {
                $list[$key]['id'] = $row->MsVillageId;
                $list[$key]['value'] = $row->MsVillageName;
                $list[$key]['kode'] = $row->MsVillageKodePos;
                $list[$key]['text'] = "<b>".$row->MsVillageKodePos . "</b>, " .$row->MsVillageName;
                $key++;
            }
            echo json_encode($list);
            exit;
        }
        
    }
    
    public function get_data_city_search()
    {
        $search = $this->input->post("search"); 
        $query = $this->db->join("TblMsProvince","TblMsProvince.MsProvinceId=TblMsVillage.MsProvinceId")
            ->join("TblMsRegency","TblMsRegency.MsRegencyId=TblMsVillage.MsRegencyId")
            ->join("TblMsDistrict","TblMsDistrict.MsDistrictId=TblMsVillage.MsDistrictId")
            ->like("MsProvinceName",$search)->or_like("MsRegencyName",$search)->or_like("MsDistrictName",$search)->or_like("MsVillageName",$search)->or_like("MsVillageKodePos",$search)
            ->get("TblMsVillage",100,0)->result();
        $list = array();
        $key = 0;
        foreach ($query as $row) {
            $list[$key]['prov']['id'] = $row->MsProvinceId;
            $list[$key]['prov']['value'] = $row->MsProvinceName; 
            $list[$key]['kota']['id'] = $row->MsRegencyId;
            $list[$key]['kota']['value'] = $row->MsRegencyName; 
            $list[$key]['kec']['id'] = $row->MsDistrictId;
            $list[$key]['kec']['value'] = $row->MsDistrictName; 
            $list[$key]['poscode']['id'] = $row->MsVillageId;
            $list[$key]['poscode']['value'] = $row->MsVillageName; 
            $list[$key]['poscode']['kode'] = $row->MsVillageKodePos; 
            $list[$key]['text'] =  "<b>".$row->MsVillageKodePos . "</b>, " .$row->MsVillageName. ", " .$row->MsDistrictName. ", " .$row->MsRegencyName. ", " .$row->MsProvinceName;
            $key++;
        }
        echo json_encode($list);
        exit; 
    }
    /*
    *       ACTION DATA CUSTOMER
    */

   
    public function data_customer_add()
    {
        $status = true;
        $data = array(
            "MsCustomerCode" => $this->input->post("MsCustomerCode"),
            "MsCustomerTypeId" => $this->input->post("MsCustomerTypeId"),
            "MsCustomerCompany" => $this->input->post("MsCustomerCompany"),
            "MsCustomerName" => $this->input->post("MsCustomerName"),
            "MsCustomerAddress" => $this->input->post("MsCustomerAddress"),
            "MsCustomerTelp1" => $this->input->post("MsCustomerTelp1"),
            "MsCustomerTelp2" => $this->input->post("MsCustomerTelp2"),
            "MsCustomerFax" => $this->input->post("MsCustomerFax"),
            "MsCustomerRemarks" => $this->input->post("MsCustomerRemarks"),
            "MsCustomerEmail" => $this->input->post("MsCustomerEmail"),
            "MsCustomerInstagram" => $this->input->post("MsCustomerInstagram"),
            "MsVillageId" => $this->input->post("MsVillageId"), 
            "MsCustomerIsActive" => ($this->input->post("MsCustomerIsActive") == "" ? "0" : "1"),
            "MsCustomerLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName"),
        );
        $this->db->insert('TblMsCustomer', $data);
        if ($status && ($this->db->affected_rows() != 1)) $status = false;

        $query = $this->db->query("SELECT MsCustomerId FROM TblMsCustomer where MsCustomerCode='" . $this->input->post("MsCustomerCode") . "'")->result();
        $dataid = $query[0]->MsCustomerId;

        $datadelivery = $this->input->post("data_delivery");
        foreach ($datadelivery as $row) {
            $data = array(
                "MsCustomerDeliveryName" => $row['MsCustomerDeliveryName'],
                "MsCustomerId" => $dataid,
                "MsCustomerDeliveryLat" => $row['MsCustomerDeliveryLat'],
                "MsCustomerDeliveryLng" => $row['MsCustomerDeliveryLng'],
                "MsCustomerDeliveryReceive" => $row['MsCustomerDeliveryReceive'],
                "MsCustomerDeliveryTelp" => $row['MsCustomerDeliveryTelp'],
                "MsCustomerDeliveryAddress" => $row['MsCustomerDeliveryAddress'],
                "MsCustomerDeliveryUtama" => $row['MsCustomerDeliveryUtama'],
            );
            $this->db->insert('TblMsCustomerDelivery', $data);
            if ($status && ($this->db->affected_rows() != 1)) $status = false;
        }
        echo $status;
        exit;
    }
    public function data_customer_edit($id)
    {
        $status = true;
        $data = array(
            "MsCustomerTypeId" => $this->input->post("MsCustomerTypeId"),
            "MsCustomerCompany" => $this->input->post("MsCustomerCompany"),
            "MsCustomerName" => $this->input->post("MsCustomerName"),
            "MsCustomerAddress" => $this->input->post("MsCustomerAddress"),
            "MsCustomerTelp1" => $this->input->post("MsCustomerTelp1"),
            "MsCustomerTelp2" => $this->input->post("MsCustomerTelp2"),
            "MsCustomerFax" => $this->input->post("MsCustomerFax"),
            "MsCustomerRemarks" => $this->input->post("MsCustomerRemarks"),
            "MsCustomerEmail" => $this->input->post("MsCustomerEmail"),
            "MsCustomerInstagram" => $this->input->post("MsCustomerInstagram"),
            "MsVillageId" => $this->input->post("MsVillageId"),
            "MsCustomerIsActive" => ($this->input->post("MsCustomerIsActive") == "" ? "0" : "1"),
            "MsCustomerLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName"),
        );
        $this->db->update('TblMsCustomer', $data, array('MsCustomerId' => $id));
        $this->db->delete('TblMsCustomerDelivery', array('MsCustomerId' => $id));
        $datadelivery = $this->input->post("data_delivery");
        foreach ($datadelivery as $row) {
            $data = array(
                "MsCustomerDeliveryId" => $row['MsCustomerDeliveryId'],
                "MsCustomerDeliveryName" => $row['MsCustomerDeliveryName'],
                "MsCustomerId" => $id,
                "MsCustomerDeliveryLat" => $row['MsCustomerDeliveryLat'],
                "MsCustomerDeliveryLng" => $row['MsCustomerDeliveryLng'],
                "MsCustomerDeliveryReceive" => $row['MsCustomerDeliveryReceive'],
                "MsCustomerDeliveryTelp" => $row['MsCustomerDeliveryTelp'],
                "MsCustomerDeliveryAddress" => $row['MsCustomerDeliveryAddress'],
                "MsCustomerDeliveryUtama" => $row['MsCustomerDeliveryUtama'],
            );
            $this->db->insert('TblMsCustomerDelivery', $data);
            if ($status && ($this->db->affected_rows() != 1)) $status = false;
        }
        echo $status;
        exit;
    }
    public function data_customer_delete($id)
    {
        $this->db->update(
            'TblMsCustomer',
            array(
                'MsCustomerIsActive' => 0,
                'MsCustomerLastUpdateUser' => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
            ),
            array('MsCustomerId' => $id)
        );
        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }
    public function data_customer_enable($id)
    {
        $this->db->update(
            'TblMsCustomer',
            array(
                'MsCustomerIsActive' => 1,
                'MsCustomerLastUpdateUser' => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
            ),
            array('MsCustomerId' => $id)
        );
        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }
    public function data_cs_delivery_add($id)
    {
        $data = array(
            "MsCustomerDeliveryReceive" => $this->input->post("MsCustomerDeliveryReceive"),
            "MsCustomerDeliveryTelp" => $this->input->post("MsCustomerDeliveryTelp"),
            "MsCustomerDeliveryAddress" => $this->input->post("MsCustomerDeliveryAddress"),
            "MsCustomerDeliveryName" => $this->input->post("MsCustomerDeliveryName"),
            "MsCustomerDeliveryLat" => $this->input->post("MsCustomerDeliveryLat"),
            "MsCustomerDeliveryLng" => $this->input->post("MsCustomerDeliveryLng"),
            "MsCustomerDeliveryLng" => $this->input->post("MsCustomerDeliveryLng"),
            "MsCustomerId" => $id,
            "MsCustomerDeliveryUtama" => 0,
        );

        $this->db->insert('TblMsCustomerDelivery', $data);

        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }
    public function data_cs_delivery_edit()
    {
        $data = array(
            "MsCustomerDeliveryReceive" => $this->input->post("MsCustomerDeliveryReceive"),
            "MsCustomerDeliveryTelp" => $this->input->post("MsCustomerDeliveryTelp"),
            "MsCustomerDeliveryAddress" => $this->input->post("MsCustomerDeliveryAddress"),
            "MsCustomerDeliveryName" => $this->input->post("MsCustomerDeliveryName"),
            "MsCustomerDeliveryLat" => $this->input->post("MsCustomerDeliveryLat"),
            "MsCustomerDeliveryLng" => $this->input->post("MsCustomerDeliveryLng"),
        );

        $this->db->update('TblMsCustomerDelivery', $data, array('MsCustomerDeliveryId' => $this->input->post("MsCustomerDeliveryId")));

        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }
    public function data_cs_delivery_utama()
    {
        $this->db->update(
            'TblMsCustomerDelivery',
            array('MsCustomerDeliveryUtama' => 0),
            array('MsCustomerId' => $this->input->post("MsCustomerId"))
        );
        $this->db->update(
            'TblMsCustomerDelivery',
            array('MsCustomerDeliveryUtama' => 1),
            array('MsCustomerDeliveryId' => $this->input->post("MsCustomerDeliveryId"))
        );

        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }
    public function data_cs_delivery_delete($id)
    {
        $this->db->where('MsCustomerDeliveryId', $id);
        $this->db->delete('TblMsCustomerDelivery');
        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }

    /*
    *       ACTION DATA TIPE PEMBAYARAN
    */
    public function validate_kode_method($kode = null)
    {
        if (!$kode == null) {
            $query = $this->db->query("SELECT * FROM TblMsMethod where MsMethodCode='" . $_GET['MsMethodCode'] . "' and not MsMethodCode = '" . $kode . "'")->result();
        } else {
            $query = $this->db->query("SELECT * FROM TblMsMethod where MsMethodCode='" . $_GET['MsMethodCode'] . "'")->result();
        }
        if ($query) {
            echo 'false';
        } else {
            echo 'true';
        }
        exit;
    }
    public function data_method_add()
    {
        $data = array(
            "MsMethodCode" => $this->input->post("MsMethodCode"),
            "MsMethodName" => $this->input->post("MsMethodName"),
            "MsMethodIsActive" => ($this->input->post("MsMethodIsActive") == "" ? "0" : "1"),
            "MsMethodLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName"),
        );
        $this->db->insert('TblMsMethod', $data);

        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }
    public function data_method_edit($id)
    {
        $data = array(
            "MsMethodCode" => $this->input->post("MsMethodCode"),
            "MsMethodName" => $this->input->post("MsMethodName"),
            "MsMethodIsActive" => ($this->input->post("MsMethodIsActive") == "" ? "0" : "1"),
            "MsMethodLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName"),
        );

        $this->db->update('TblMsMethod', $data, array('MsMethodId' => $id));
        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }
    public function data_method_delete($id)
    {
        $this->db->update(
            'TblMsMethod',
            array(
                'MsMethodIsActive' => 0,
                'MsMethodLastUpdateUser' => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
            ),
            array('MsMethodId' => $id)
        );
        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }
    public function data_method_enable($id)
    {
        $this->db->update(
            'TblMsMethod',
            array(
                'MsMethodIsActive' => 1,
                'MsMethodLastUpdateUser' => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
            ),
            array('MsMethodId' => $id)
        );
        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }
    /*
    *       ACTION DATA TIPE PEMBAYARAN
    */
    public function data_cogs_edit($id)
    {
        $data = array(
            "MsCogsTotal" => str_replace(",", "", $this->input->post("MsCogsTotal")),
        );

        $this->db->update('TblMsCogs', $data, array('MsCogsId' => $id));

        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }
    public function data_cogs_add($MsItemId, $MsVendorId)
    {
        $data = array(
            "MsCogsTotal" => str_replace(",", "", $this->input->post("MsCogsTotal")),
            "MsVendorId" => $MsVendorId,
            "MsItemId" => $MsItemId,
        );

        $this->db->insert('TblMsCogs', $data);

        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }


    public function get_data_master_item($vendor = null)
    {
        $search = isset($_REQUEST['search']) ? $_REQUEST['search'] : NULL;
        $this->db->join("TblMsVendor", "TblMsItem.MsItemVendor like concat('%',TblMsVendor.MsVendorCode,'%')", "LEFT");
        $this->db->join("TblMsItemCategory", "TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId ", "LEFT");
        $this->db->where("MsItemIsActive", 1);
        $this->db->group_start();
        $this->db->like("MsItemName", $search);
        $this->db->or_like("MsItemCode", $search);
        $this->db->group_end();
        if ($vendor != null) {
            $this->db->where("MsVendorId", $vendor);
        }
        $query = $this->db->get("TblMsItem")->result();

        $list = array();
        $key = 0;
        foreach ($query as $row) {
            $htmlItem = '<div class="row border-bottom border-1">
                            <div class="col-12" >
                                <span class="fw-bold">' . $row->MsItemCode . '-' . $row->MsItemName . ' (' . $row->MsVendorCode . ')</span><br>
                                <span>kategori : <b>' . $row->MsItemCatCode . '-' . $row->MsItemCatName . '</b></span><br>
                                <span>Rp. ' . $row->MsItemPrice . '</span>&nbsp;|&nbsp;<span>' . $row->MsItemSize . '</span>&nbsp;|&nbsp;' . $row->MsItemPcsM2 . '</span>
                            </div>
                            <div class="col-lg-2 col-6">
                                <div class="d-flex flex-row justify-content-end">
                                </div>
                            </div>';
            $list[$key]['id'] = $row->MsItemId;
            $list[$key]['text'] = $row->MsItemCode . '-' . $row->MsItemName . ' (' . $row->MsVendorCode . ')';
            $list[$key]['html'] = $htmlItem;
            $list[$key]['MsItemId'] = $row->MsItemId;
            $list[$key]['MsItemCode'] = $row->MsItemCode;
            $list[$key]['MsItemName'] = $row->MsItemName;
            $list[$key]['MsVendorCode'] = $row->MsVendorCode;
            $list[$key]['MsItemCatCode'] = $row->MsItemCatCode;
            $list[$key]['MsItemCatName'] = $row->MsItemCatName;
            $list[$key]['MsItemPrice'] = $row->MsItemPrice;
            $list[$key]['MsItemSize'] = $row->MsItemSize;
            $list[$key]['MsItemPcsM2'] = $row->MsItemPcsM2;
            $list[$key]['MsItemUoM'] = $row->MsItemUoM;
            $key++;
        }
        echo json_encode($list);
        exit;
    }
    public function get_data_master_item_with_stock($id)
    {
        $search = isset($_REQUEST['search']) ? $_REQUEST['search'] : NULL;
        $query = $this->db->query("SELECT * FROM TblMsItem 
                                    LEFT JOIN TblMsVendor on TblMsItem.MsItemVendor like concat('%',TblMsVendor.MsVendorCode,'%') 
                                    LEFT JOIN TblMsItemCategory on TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId 
                                    LEFT JOIN TblInvStock ON TblMsItem.MsItemId = TblInvStock.MsItemId AND TblMsVendor.MsVendorId = TblInvStock.MsVendorId AND TblInvStock.MsWorkplaceId = {$id}
                                    WHERE MsItemIsActive='1' and (MsItemName like '%{$search}%' or MsItemCode like '%{$search}%')")->result();

        $list = array();
        $key = 0;
        foreach ($query as $row) {
            $htmlItem = '<span class="fw-bold">' . $row->MsItemCode . '-' . $row->MsItemName . ' (' . $row->MsVendorCode . ')</span><br>
                        <span class="fw-bold" style="font-size:0.7rem">
                            Rp. ' . number_format($row->MsItemPrice) . '/<sup style="color:gray;">' . $row->MsItemUoM . '</sup>&nbsp;|&nbsp;
                            <span class="' . ($row->InvStockBuffer > $row->InvStockQty ? "text-danger" : "text-success") . '" > stock : ' . number_format($row->InvStockQty) . '</span>
                        </span><br>
                        <span style="color:gray;font-size:0.6rem">' . $row->MsItemCatName . '&nbsp;|&nbsp;' . $row->MsItemSize . '&nbsp;|&nbsp;' . $row->MsItemPcsM2 . '</span>';
            $list[$key]['id'] = $row->MsItemId;
            $list[$key]['text'] = $row->MsItemCode . '-' . $row->MsItemName . ' (' . $row->MsVendorCode . ')';
            $list[$key]['html'] = $htmlItem;
            $list[$key]['MsItemId'] = $row->MsItemId;
            $list[$key]['MsItemCode'] = $row->MsItemCode;
            $list[$key]['MsItemName'] = $row->MsItemName;
            $list[$key]['MsVendorCode'] = $row->MsVendorCode;
            $list[$key]['MsItemCatCode'] = $row->MsItemCatCode;
            $list[$key]['MsItemCatName'] = $row->MsItemCatName;
            $list[$key]['MsItemPrice'] = $row->MsItemPrice;
            $list[$key]['MsItemSize'] = $row->MsItemSize;
            $list[$key]['MsItemPcsM2'] = $row->MsItemPcsM2;
            $list[$key]['MsItemUoM'] = $row->MsItemUoM;
            $list[$key]['InvStockBuffer'] = $row->InvStockBuffer;
            $list[$key]['InvStockQty'] = $row->InvStockQty;
            $key++;
        }
        echo json_encode($list);
        exit;
    }
    public function get_data_master_item_sales_with_stock($id)
    {
        $search = isset($_REQUEST['search']) ? $_REQUEST['search'] : NULL;
        $query = $this->db->query("SELECT * FROM TblMsItem 
                                    LEFT JOIN TblMsVendor on TblMsItem.MsItemVendor like concat('%',TblMsVendor.MsVendorCode,'%') 
                                    LEFT JOIN TblMsItemCategory on TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId 
                                    LEFT JOIN TblInvStock ON TblMsItem.MsItemId = TblInvStock.MsItemId AND TblMsVendor.MsVendorId = TblInvStock.MsVendorId AND TblInvStock.MsWorkplaceId = {$id}
                                    LEFT JOIN TblMsCogs ON TblMsItem.MsItemId = TblMsCogs.MsItemId AND TblMsVendor.MsVendorId = TblMsCogs.MsVendorId 
                                    WHERE MsItemIsActive='1' and not MsCogsTotal IS null and (MsItemName like '%{$search}%')")->result();

        $list = array();
        $key = 0;
        foreach ($query as $row) {
            $htmlItem = '<span class="fw-bold">' . $row->MsItemCode . '-' . $row->MsItemName . ' (' . $row->MsVendorCode . ')</span><br>
                        <span class="fw-bold" style="font-size:0.7rem">
                            Rp. ' . number_format($row->MsItemPrice) . '/<sup style="color:gray;">' . $row->MsItemUoM . '</sup>&nbsp;|&nbsp;
                            <span class="' . ($row->InvStockBuffer > $row->InvStockQty ? "text-danger" : "text-success") . '" > stock : ' . number_format($row->InvStockQty) . '</span>
                        </span><br>
                        <span style="color:gray;font-size:0.6rem">' . $row->MsItemCatName . '&nbsp;|&nbsp;' . $row->MsItemSize . '&nbsp;|&nbsp;' . $row->MsItemPcsM2 . '</span>';
            $list[$key]['id'] = $row->MsItemId;
            $list[$key]['text'] = $row->MsItemCode . '-' . $row->MsItemName . ' (' . $row->MsVendorCode . ')';
            $list[$key]['html'] = $htmlItem;
            $list[$key]['MsItemId'] = $row->MsItemId;
            $list[$key]['MsItemCode'] = $row->MsItemCode;
            $list[$key]['MsItemName'] = $row->MsItemName;
            $list[$key]['MsVendorCode'] = $row->MsVendorCode;
            $list[$key]['MsItemCatCode'] = $row->MsItemCatCode;
            $list[$key]['MsItemCatName'] = $row->MsItemCatName;
            $list[$key]['MsItemPrice'] = $row->MsItemPrice;
            $list[$key]['MsItemSize'] = $row->MsItemSize;
            $list[$key]['MsItemPcsM2'] = $row->MsItemPcsM2;
            $list[$key]['MsItemUoM'] = $row->MsItemUoM;
            $list[$key]['InvStockBuffer'] = $row->InvStockBuffer;
            $list[$key]['InvStockQty'] = $row->InvStockQty;
            $list[$key]['MsCogsTotal'] = $row->MsCogsTotal;
            $key++;
        }
        echo json_encode($list);
        exit;
    }

    public function get_data_item_varian(){
        $search = isset($_REQUEST['search']) ? $_REQUEST['search'] : "";
        $select = isset($_POST['select']) ? $_POST['select'] : "";
        $query = $this->db->like("VarianName",$search)->where_not_in("VarianName",$select)->get("TblMsProdukVarian")->result();
        $list = array();
        $key = 0;
        foreach ($query as $row) {
            $htmlItem = '<span class="fw-bold">' . $row->VarianName . '</span>';
            $list[$key]['id'] = $row->VarianId;
            $list[$key]['text'] = $row->VarianName;
            $list[$key]['html'] = $htmlItem; 
            $key++;
        }
        echo json_encode($list);
        exit;
    }
    public function get_data_item_berat(){
        $search = isset($_REQUEST['search']) ? $_REQUEST['search'] : "";
        $select = isset($_POST['select']) ? $_POST['select'] : "";
        $query = $this->db->like("BeratName",$search)->where_not_in("BeratName",$select)->get("TblMsProdukBerat")->result();
        $list = array();
        $key = 0;
        foreach ($query as $row) {
            $htmlItem = '<span class="fw-bold">' . $row->BeratName . ' ('.$row->BeratCode.')</span>';
            $list[$key]['id'] = $row->BeratId;
            $list[$key]['text'] = "(".$row->BeratCode.")";
            $list[$key]['html'] = $htmlItem; 
            $key++;
        }
        echo json_encode($list);
        exit;
    }
    public function get_data_item_satuan(){
        $search = isset($_REQUEST['search']) ? $_REQUEST['search'] : "";
        $select = isset($_POST['select']) ? $_POST['select'] : "";
        $query = $this->db->like("SatuanName",$search)->where_not_in("SatuanName",$select)->get("TblMsProdukSatuan")->result();
        $list = array();
        $key = 0;
        foreach ($query as $row) {
            $htmlItem = '<span class="fw-bold">' . $row->SatuanName . ' </span>';
            $list[$key]['id'] = $row->SatuanId;
            $list[$key]['text'] = $row->SatuanName;
            $list[$key]['html'] = $htmlItem; 
            $key++;
        }
        echo json_encode($list);
        exit;
    }
    public function get_data_item_varian_value(){
        $search = isset($_REQUEST['search']) ? $_REQUEST['search'] : ""; 
        $type = isset($_POST['type']) ? $_POST['type'] : "";
        if($type=="Vendor"){ 
            $query = $this->db->like("MsVendorCode",$search)->or_like("MsVendorName",$search)->get("TblMsVendor")->result();
            $list = array();
            $key = 0;
            foreach ($query as $row) {
                $htmlItem = '<span class="fw-bold">' . $row->MsVendorCode . ' - ' . $row->MsVendorName . '</span>';
                $list[$key]['id'] = $row->MsVendorId;
                $list[$key]['text'] = $row->MsVendorCode;
                $list[$key]['html'] = $htmlItem; 
                $key++;
            }
            if($key == 0){
                $list[$key]['id'] = "0";
                $list[$key]['text'] = "0";
                $list[$key]['html'] =
                '<button class="btn btn-success btn-sm py-1 me-1 rounded-pill" type="button" style="font-size: 0.6rem;" onclick="add_value_vendor(\''.$search.'\')">
                                    <i class="fas fa-plus" aria-hidden="true"></i>
                                    <span class="fw-bold">
                                        &nbsp;Tambah Vendor Baru
                                    </span>
                                </button>';
            }
            echo json_encode($list);
            exit;
        }  
        if($type=="Warna"){ 
            $query = $this->db->like("WarnaName",$search)->get("TblMsProdukWarna")->result();
            $list = array();
            $key = 0;
            foreach ($query as $row) {
                $htmlItem = '<span class="fw-bold">' . $row->WarnaName .'</span>';
                $list[$key]['id'] = $row->WarnaId;
                $list[$key]['text'] = $row->WarnaName;
                $list[$key]['html'] = $htmlItem; 
                $key++;
            }
            if($key == 0){
                $list[$key]['id'] = "0";
                $list[$key]['text'] = "0";
                $list[$key]['html'] =
                '<button class="btn btn-success btn-sm py-1 me-1 rounded-pill" type="button" style="font-size: 0.6rem;" onclick="add_value_warna(\''.$search.'\')">
                                    <i class="fas fa-plus" aria-hidden="true"></i>
                                    <span class="fw-bold">
                                        &nbsp;Tambah Warna Baru
                                    </span>
                                </button>';
            }
            echo json_encode($list);
            exit;
        }
        if($type=="Ukuran"){ 
            $query = $this->db->like("SizeName",$search)->get("TblMsProdukSize")->result();
            $list = array();
            $key = 0;
            foreach ($query as $row) {
                $htmlItem = '<span class="fw-bold">' . $row->SizeName .'</span>';
                $list[$key]['id'] = $row->SizeId;
                $list[$key]['text'] = $row->SizeName;
                $list[$key]['html'] = $htmlItem; 
                $key++;
            }
            if($key == 0){
                $list[$key]['id'] = "0";
                $list[$key]['text'] = "0";
                $list[$key]['html'] =
                '<button class="btn btn-success btn-sm py-1 me-1 rounded-pill" type="button" style="font-size: 0.6rem;" onclick="add_value_ukuran(\''.$search.'\')">
                                    <i class="fas fa-plus" aria-hidden="true"></i>
                                    <span class="fw-bold">
                                        &nbsp;Tambah Ukuran Baru
                                    </span>
                                </button>';
            }
            echo json_encode($list);
            exit;
        }
      
    }
    public function get_bom_detail($id)
    {
        $query = $this->db->query("select * from TblMsItemBomDetail 
                                    left join TblMsItem on TblMsItemBomDetail.MsItemId=TblMsItem.MsItemId 
                                    LEFT JOIN TblMsItemCategory on TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId  
                                    where MsItemBomId='" . $id . "'")->result();

        $list = array();
        $no = 0;
        foreach ($query as $row) {
            $listitem = array();
            $htmlItem = '<div class="row">
                            <div class="col-lg-7 col-12 mb-lg-0 mb-2" >
                                <span class="fw-bold">' . $row->MsItemCode . '-' . $row->MsItemName . '</span><br>
                                <span>Supplier : <b>' . $row->MsVendorCode . '</b></span><br>
                                <span>Rp. ' . $row->MsItemPrice . '</span>&nbsp;|&nbsp;<span>' . $row->MsItemSize . '</span>&nbsp;|&nbsp;' . $row->MsItemPcsM2 . '</span>
                            </div>
                            <div class="col-lg-3 col-6">
                                Qty<span>&nbsp;(' . $row->MsItemUoM . ')</span> : <input type="text" class="input-in-table double" name="MsItemBomDetailCount" value="' . $row->MsItemBomDetailCount . '" />
                            </div>
                            <div class="col-lg-2 col-6">
                                <div class="d-flex flex-row justify-content-end">
                                    <a onclick="hapus_item_click(' . $row->MsItemId . ',\'' . $row->MsVendorCode . '\')" class="me-2 text-danger pointer m-2" title="Hapus Item"><i class="fas fa-trash-alt fa-lg"></i></a>
                                </div>
                            </div>';
            $listitem[] = $no + 1;
            $listitem[] = $htmlItem;
            $listitem[] = $row->MsItemId;
            $listitem[] = $row->MsVendorCode;
            $listitem[] = $row->MsItemBomDetailCount;
            $no++;
            $list[] = $listitem;
        }
        echo json_encode($list);
        exit;
    }
    public function data_bom_add()
    {
        $status = true;
        $data = array(
            "MsVendorCode" => $this->input->post("MsVendorCode"),
            "MsItemId" => $this->input->post("MsItemId"),
            "MsItemBomCount" => $this->input->post("MsItemBomCount"),
        );
        $this->db->insert('TblMsItemBom', $data);
        if ($status && ($this->db->affected_rows() != 1)) $status = false;

        $query = $this->db->query("SELECT max(MsItemBomId) as max FROM TblMsItemBom")->result();
        $dataid = $query[0]->max;

        $datadetail = $this->input->post("data_detail");
        foreach ($datadetail as $row) {
            $data = array(
                "MsItemId" => $row[2],
                "MsItemBomId" => $dataid,
                "MsVendorCode" => $row[3],
                "MsItemBomDetailCount" => $row[4],
            );
            $this->db->insert('TblMsItemBomDetail', $data);
            if ($status && ($this->db->affected_rows() != 1)) $status = false;
        }
        echo $status;
        exit;
    }
    public function data_bom_edit($id)
    {
        $status = true;
        $data = array(
            "MsVendorCode" => $this->input->post("MsVendorCode"),
            "MsItemId" => $this->input->post("MsItemId"),
            "MsItemBomCount" => $this->input->post("MsItemBomCount"),
        );
        $this->db->update('TblMsItemBom', $data, array('MsItemBomId' => $id));
        $this->db->delete('TblMsItemBomDetail', array('MsItemBomId' => $id));

        $datadetail = $this->input->post("data_detail");
        foreach ($datadetail as $row) {
            $data = array(
                "MsItemId" => $row[2],
                "MsItemBomId" => $id,
                "MsVendorCode" => $row[3],
                "MsItemBomDetailCount" => $row[4],
            );
            $this->db->insert('TblMsItemBomDetail', $data);
            if ($status && ($this->db->affected_rows() != 1)) $status = false;
        }
        echo $status;
        exit;
    }


    public function validate_kode_delivery($kode = null)
    {
        if (!$kode == null) {
            $query = $this->db->query("SELECT * FROM TblMsDelivery where MsDeliveryName='" . $_GET['MsDeliveryName'] . "' and not MsDeliveryName = '" . $kode . "'")->result();
        } else {
            $query = $this->db->query("SELECT * FROM TblMsDelivery where MsDeliveryName='" . $_GET['MsDeliveryName'] . "'")->result();
        }
        if ($query) {
            echo 'false';
        } else {
            echo 'true';
        }
        exit;
    }
    public function data_delivery_add()
    {
        $data = array(
            "MsDeliveryName" => $this->input->post("MsDeliveryName"),
            "MsDeliveryIsActive" => ($this->input->post("MsDeliveryIsActive") == "" ? "0" : "1"),
            "MsDeliveryLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName"),
        );
        $this->db->insert('TblMsDelivery', $data);
        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }
    public function data_delivery_edit($id)
    {
        $data = array(
            "MsDeliveryName" => $this->input->post("MsDeliveryName"),
            "MsDeliveryIsActive" => ($this->input->post("MsDeliveryIsActive") == "" ? "0" : "1"),
            "MsDeliveryLastUpdateUser" => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName"),
        );

        $this->db->update('TblMsDelivery', $data, array('MsDeliveryId' => $id));

        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }
    public function data_delivery_delete($id)
    {
        $this->db->update(
            'TblMsDelivery',
            array(
                'MsDeliveryIsActive' => 0,
                'MsDeliveryLastUpdateUser' => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
            ),
            array('MsDeliveryId' => $id)
        );
        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }
    public function data_delivery_enable($id)
    {
        $this->db->update(
            'TblMsDelivery',
            array(
                'MsDeliveryIsActive' => 1,
                'MsDeliveryLastUpdateUser' => $this->session->userdata("MsEmpCode") . " - " . $this->session->userdata("MsEmpName")
            ),
            array('MsDeliveryId' => $id)
        );
        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }

    public function reset_password()
    {
        $this->db->update('TblMsEmployee', array("MsEmpPass" => $this->model_app->EncryptedPassword($this->input->post("MsEmpPass"))), array("MsEmpId" => $this->session->userdata("MsEmpId")));
        echo ($this->db->affected_rows() != 1) ? false : true;
        exit;
    }



    public function data_system_listing_add(){
        $status = true;
        $this->db->insert('TblMenuListing', array("MenuListingName"=>$this->input->post("MenuListingName")));
        $max_id = ($this->db->select_max('MenuListingId')->get("TblMenuListing")->row())->MenuListingId;
        $MenuListingDetail = $this->input->post("MenuListingDetail"); 
        foreach ($MenuListingDetail as $row) {
            $row += ["MenuListingId" => $max_id];
            $this->db->insert('TblMenuListingDetail', $row);
            if ($status && ($this->db->affected_rows() != 1)) $status = false;
        }
        echo $status;
        exit;
    }  
    public function data_system_listing_edit($id){
        $status = true;
        $this->db->update('TblMenuListing', array("MenuListingName"=>$this->input->post("MenuListingName")),array("MenuListingId"=>$id));
        $this->db->delete('TblMenuListingDetail', array('MenuListingId' => $id));
        $this->db->insert_batch('TblMenuListingDetail',$this->input->post("MenuListingDetail")); 
        echo true;
        exit;
    }

    public function update_employee_whatsapp(){
        $status = true;
        $this->db->update('TblMsEmployee',array("MsEmpWhatsapp"=>$this->input->post("MsEmpWhatsapp")),array("MsEmpId"=>$this->input->post("MsEmpId")));
        if ($status && ($this->db->affected_rows() != 1)) $status = false;  
        $this->session->unset_userdata('MsEmpWhatsapp'); 
        $this->session->set_userdata(array('MsEmpWhatsapp'=>$this->input->post("MsEmpWhatsapp")));
        echo $status;
        exit;
    }

    public function update_employee_email(){
        $status = true;
        $this->db->update('TblMsEmployee',array("MsEmpEmail"=>$this->input->post("MsEmpEmail")),array("MsEmpId"=>$this->input->post("MsEmpId")));
        if ($status && ($this->db->affected_rows() != 1)) $status = false;  
        $this->session->unset_userdata('MsEmpEmail'); 
        $this->session->set_userdata(array('MsEmpEmail'=>$this->input->post("MsEmpEmail")));
        echo $status;
        exit;
    }


    public function send_employee_whatsapp(){ 
        $uuid = $this->session->userdata("login_uuid");
        $user = $this->session->userdata("MsEmpId");
        $date = $this->input->post("datetime"); 
        $code = str_pad(random_int(0, 999999), 6, 0, STR_PAD_LEFT);  
        $old = $this->db->where("SysVerifikasiUUID",$uuid)->where("SysVerifikasiUser",$user)->where("SysVerifikasiType",1)->where("SysVerifikasiDate >", date_format(date_create(),"Y-m-d H:i:s"))->get("TblSysVerifikasi");
        $data_arr  = array(
            "SysVerifikasiUUID"=>$uuid,
            "SysVerifikasiUser"=>$user,
            "SysVerifikasiDate"=>$date,
            "SysVerifikasiCode"=>$code,
            "SysVerifikasiType"=>1, 
        );
        if($old->num_rows() > 0){
           echo JSON_ENCODE($old->row());  
        }else{
            $this->db->insert("TblSysVerifikasi",$data_arr); 
            echo JSON_ENCODE($data_arr); 
            $codesplit = str_split($code, 3);

            $post_data="sender=082122313612&number=62".
                $this->session->userdata("MsEmpWhatsapp")."&message=".
                urlencode(
                    'Halo, '. $this->session->userdata("MsEmpName").PHP_EOL.PHP_EOL.'JANGAN MEMBERITAHU KODE VERIFIKASI INI KE SIAPAPUN.'.PHP_EOL.'kode untuk melakukan verifikasi : OBI- *'.$codesplit[0]." ".$codesplit[1].'*'
                );
            
            //WITH BUTTON
            // $post_data="sender=082122313612&number=62".
            // $this->session->userdata("MsEmpWhatsapp")."&message=".
            // urlencode(
            //     'Halo, '. $this->session->userdata("MsEmpName").PHP_EOL.PHP_EOL.'JANGAN MEMBERITAHU KODE VERIFIKASI INI KE SIAPAPUN.'.PHP_EOL.'kode untuk melakukan verifikasi : OBI- *'.$codesplit[0]." ".$codesplit[1].'*'
            // )."&url=".urlencode(base_url("login/bypass/".$uuid."/".$code));

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://omahbata.ddns.net:2000/send-message");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));   
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
            $result = curl_exec($ch); 
            curl_close($ch); 
        }  
    }


    public function send_notif_approval(){
        $post_data="sender=082122313612&message=".
        urlencode('Ada 1 permintaan request print invoice dari Admin 1 HOPST')."&url=".urlencode(base_url("login/bypass"));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://omahbata.ddns.net:2000/send-approval");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));   
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        $result = curl_exec($ch); 
        curl_close($ch);  
    }
    public function send_employee_email(){ 

        $uuid = $this->session->userdata("login_uuid");
        $user = $this->session->userdata("MsEmpId");
        $date = $this->input->post("datetime"); 
        $code = str_pad(random_int(0, 999999), 6, 0, STR_PAD_LEFT);  
        $old = $this->db->where("SysVerifikasiUUID",$uuid)->where("SysVerifikasiUser",$user)->where("SysVerifikasiType",2)->where("SysVerifikasiDate >", date_format(date_create(),"Y-m-d H:i:s"))->get("TblSysVerifikasi");
        $data_arr  = array(
            "SysVerifikasiUUID"=>$uuid,
            "SysVerifikasiUser"=>$user,
            "SysVerifikasiDate"=>$date,
            "SysVerifikasiCode"=>$code, 
            "SysVerifikasiType"=>2, 
        );
        if($old->num_rows() > 0){
           echo JSON_ENCODE($old->row());  
        }else{
            $this->db->insert("TblSysVerifikasi",$data_arr); 
            $code = str_split($code, 3);
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->Mailer = "smtp";
            $mail->SMTPDebug  = 0;  
            $mail->SMTPAuth   = TRUE;
            $mail->SMTPSecure = "tls";
            $mail->Port       = 587;
            $mail->Host       = "smtp.gmail.com";
            $mail->Username   = "itcenteromahbata@gmail.com";
            $mail->Password   = "kpqspsqpavlbhbbp";

            $mail->IsHTML(true);
            $mail->AddAddress($this->session->userdata("MsEmpEmail"), $this->session->userdata("MsEmpName"));
            $mail->SetFrom("itcenteromahbata@gmail.com", "OBI-SERVER"); 
            $mail->Subject = "Kode Verifikasi 2 Langkah";
            $content =  $this->template_email_verifikasi( $this->session->userdata("MsEmpName"),   $code[0]." ".$code[1]);
            $mail->MsgHTML($content);  
            if(!$mail->Send()) { 
                var_dump($mail); 
            } 
            echo JSON_ENCODE($data_arr); 
        }  
    } 
    function convert_base_url($url){
        return base_url().$url;
    }
    function template_email_verifikasi($username,$kode){
        $body = '<table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#fff">
                    <tbody>
                        <tr>
                            <td>
                                <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="color:#000;">
                                                    <tbody>
                                                        <tr>
                                                            <td width="100%" style="font-weight:400;text-align:left;border-bottom:0 dotted transparent;border-left:0 dotted transparent;border-right:0 dotted transparent;border-top:0 dotted transparent;vertical-align:top;padding-top:5px">
                                                                <table width="100%"  border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse: separate; border-left: 0;  border-spacing: 0px; border-bottom-left-radius: 5rem; border-bottom-right-radius: 5rem;  background: #ffa447; height: 100px;">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="width:100%;padding-right:0;padding-left:0;text-align: center;">
                                                                                <h1 style="color:white;margin-bottom:0">
                                                                                    <img src="'.$this->convert_base_url("asset/image/mgs-erp/logowhite.png").'" width="40" height="40" class="d-inline-block align-top me-2" alt="">
                                                                                    OBI-ERP
                                                                                </h1>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width:100%;padding-right:0;padding-left:0;text-align: center;color: #ffebb0;">
                                                                                Aplikasi Internal Omahbata Indonesia 
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="text-align: center;">
                                                                                <table width="70%"  border="0" cellpadding="0" cellspacing="0" role="presentation" style="    box-shadow: 0px 0px 12px 0px #b1b1b1;height: 30px;margin-left:15%;margin-top:20px;border-collapse: separate; border-left: 0;  border-spacing: 0px; border-top-left-radius: 20px; border-top-right-radius: 20px;  background: #ffffff;">
                                                                            
                                                                                </table> 
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>  
                                                            </td> 
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: center;">
                                                                <table width="70%"  border="0" cellpadding="0" cellspacing="0" role="presentation" style="box-shadow: 0px 8px 12px 0px #b1b1b1;margin-left:15%;border-collapse: separate; border-left: 0;  border-spacing: 0px; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;  background: #ffffff;">
                                                                    <tr>
                                                                        <td style="text-align: center;">
                                                                            <h2 style="margin-top:0; ">Kode Verifikasi</h2>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="text-align: start;padding-left:20px;padding-right:20px;color:rgb(77, 77, 77);padding-bottom: 30px;">
                                                                            <p>Hi, '.$username.'</p>
                                                                            <p>Kode ini akan berakhir dalam <b>15 menit</b>. Jangan Memberi tahu kode ini kepada siapapun.</p> 
                                                                            <p>kode verifikasi :<span style="border: 1px solid #ffd79b;background-color: #ffead2;padding:10px;display: inline-block;margin-left: 10px;color:#ff5600"><b>OBI- '.$kode.'</b>
                                                                            </p> 
                                                                            <span style="font-size: 0.7rem;"><i>jika anda tidak merasa login aplikasi, segera hubungi IT CENTER OMAHBATA</i></span> 
                                                                        </td>
                                                                    </tr> 
                                                                </table> 
                                                            </td> 
                                                        </tr>
                                                        <tr> 
                                                            <td style="text-align: center;padding-top:50px;" >
                                                                <table width="70%"  border="0" cellpadding="0" cellspacing="0" role="presentation" style="margin-left:15%;border-collapse: separate; border-left: 0;  border-spacing: 0px; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;  background: #ffffff;">
                                                                    <tr>
                                                                        <td style="text-align: start">
                                                                            <span style="margin-top:0; font-weight: bold;">Our Branch :</span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="text-align: center;border-top:1px solid gray;"> 
                                                                            <img src="'.$this->convert_base_url("asset/image/logo/logo-1-200.png").'" alt="" height="50"> 
                                                                            <img src="'.$this->convert_base_url("asset/image/logo/logo-2-200.png").'" alt="" height="50"> 
                                                                            <img src="'.$this->convert_base_url("asset/image/logo/logo-3-200.png").'" alt="" height="50"> 
                                                                            <img src="'.$this->convert_base_url("asset/image/logo/logo-4-200.png").'" alt="" height="50"> 
                                                                            <img src="'.$this->convert_base_url("asset/image/logo/logo-5-200.png").'" alt="" height="50"> 
                                                                            <img src="'.$this->convert_base_url("asset/image/logo/logo-7-200.png").'" alt="" height="50">  
                                                                        </td>
                                                                    </tr> 
                                                                </table>
                                                            </td>
                                                        </tr> 
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td  >
                                                <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="height:50px;color:#000;width:600px;background-image: url('.$this->convert_base_url("asset/image/mgs-erp/bg-login.png").');  background-repeat: tr;   background-size: 200px 100px;" width="600">
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table> 
                            </td>
                        </tr>
                    </tbody>
                </table> ';
        return $body;
   
    } 
    public function success_employee_verify(){ 
        delete_cookie('auth');
        set_cookie('auth', true, '3600');   
        $this->session->set_userdata('login_auth',true);
    }




}
