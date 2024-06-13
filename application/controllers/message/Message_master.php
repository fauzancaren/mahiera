<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Message_master extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('model_app');

        date_default_timezone_set('Asia/Jakarta');
    }

    /*
    *       MODAL DATA TOKO
    */

    function data_toko_add()
    {
        echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered ">
                <form class="modal-content" name="create-toko">
                    <div class="modal-header bg-dark">
                        <h6 class="modal-title text-white"><i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;Tambah Data Toko</h5>
                        <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div  class="row justify-content-center">
                            <div class="col-10">
                                <div class="row mb-1">
                                    <label for="MsWorkplaceIsActive" class="col-sm-3 col-form-label">Status<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-switch">
                                            <input id="MsWorkplaceIsActive" name="MsWorkplaceIsActive" class="form-check-input" type="checkbox" " checked>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mb-1">
                                    <label for="MsWorkplaceCode" class="col-sm-3 col-form-label">Kode<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <input id="MsWorkplaceCode" name="MsWorkplaceCode" type="text" class="form-control form-control-sm" value="">
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label for="MsWorkplaceName" class="col-sm-3 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <input id="MsWorkplaceName" name="MsWorkplaceName" type="text" class="form-control form-control-sm" value="">
                                        <span id="MsWorkplaceNameErr" class="text-input-error"></span>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label for="tb_search" class="col-sm-3 col-form-label">Tipe</label>
                                    <div class="col-sm-9">
                                        <select id="MsWorkplaceType" name="MsWorkplaceType"  class="form-select form-select-sm" aria-label="form-select-sm example">
                                            <option value="0">Toko</option>
                                            <option value="1">Gudang</option>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-1">
                                    <label for="tb_search" class="col-sm-3 col-form-label">Alamat<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <textarea id="MsWorkplaceAddress" name="MsWorkplaceAddress"  class="form-control form-control-sm"></textarea>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label for="tb_search" class="col-sm-3 col-form-label">Telp 1</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="MsWorkplaceTelp1" name="MsWorkplaceTelp1" class="form-control form-control-sm input-phone" value="">
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label for="tb_search" class="col-sm-3 col-form-label">Telp 2</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="MsWorkplaceTelp2" name="MsWorkplaceTelp2" class="form-control form-control-sm input-phone" value="">
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label for="tb_search" class="col-sm-3 col-form-label">Fax</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="MsWorkplaceFax" name="MsWorkplaceFax" class="form-control form-control-sm input-phone" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"   id="btn-submit"        >Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
        
        <script>
            var req_status_add = 0;
            var datesCollection = document.getElementsByClassName("input-phone");
            var phones = Array.from(datesCollection);

            phones.forEach(function (phone) {
                new Cleave(phone, {
                    phone: true,
                    phoneRegionCode: "ID"
                })
            });
            
            $(function() { 
                $("form[name=\'create-toko\']").validate({
                    rules: {
                        MsWorkplaceCode: {
                            "required": true,
                            "remote": "' . site_url("function/client_data_master/validate_kode_toko") . '",
                        },
                        MsWorkplaceName: "required",
                        MsWorkplaceAddress: "required",
                    },
                    messages: {
                        MsWorkplaceCode: { 
                            required: "Masukan kode toko",
                            remote: "Kode toko sudah ada"
                        },
                        MsWorkplaceName: "Masukan Nama toko",
                        MsWorkplaceAddress: "Masukan Alamat toko",
                    },
                    submitHandler: function(form) {
                        if(!req_status_add){
                            $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                            $.ajax({
                                method: "POST",
                                url: "' . site_url("function/client_data_master/data_toko_add") . '",
                                data: $("form[name=\'create-toko\']").serialize(),
                                before: function(){ 
                                    req_status_add = 1;
                                },
                                success: function(data) {
                                    req_status_add = 0;
                                    $("#btn-submit").html("Simpan");
                                    
                                    if(data){
                                        Swal.fire({
                                            icon: \'success\',
                                            text: \'Tambah data berhasil\',
                                            showConfirmButton: false,
                                            allowOutsideClick: false,
                                            allowEscapeKey: false,
                                            timer: 1500,
                                        }).then((result) => {
                                            if (result.dismiss === Swal.DismissReason.timer) {
                                                load_data_table();
                                            }
                                        });
                                    }else{
                                        Swal.fire({
                                            icon: \'error\',
                                            text: \'Tambah data gagal\',
                                            showConfirmButton: false,
                                            allowOutsideClick: false,
                                            allowEscapeKey: false,
                                            timer: 1500
                                        });
                                    }
                                }
                            });
                            return false;
                        }
                    }
                });
            });
        </script>';
    }
    function data_toko_view($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsWorkplace where MsWorkplaceId=" . $id);
        foreach ($query->result() as $row) {
            echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered ">
                    <div class="modal-content">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-eye text-info" aria-hidden="true"></i> &nbsp;Detail Data Toko</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row justify-content-center">
                                <div class="col-10">
                                    <div class="row mb-1">
                                        <label for="MsWorkplaceIsActive" class="col-sm-3 col-form-label">Status</label>
                                        <div class="col-sm-9">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="MsWorkplaceIsActive" ' . ($row->MsWorkplaceIsActive == 1 ? "checked" : "") . ' disabled>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-1">
                                        <label for="tb_search" class="col-sm-3 col-form-label">Kode</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control form-control-sm" value="' . $row->MsWorkplaceCode . '" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="tb_search" class="col-sm-3 col-form-label">Nama</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control form-control-sm" value="' . $row->MsWorkplaceName . '" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="tb_search" class="col-sm-3 col-form-label">Tipe</label>
                                        <div class="col-sm-9">
                                            <select id="MsWorkplaceType" class="form-select form-select-sm" aria-label="form-select-sm example" disabled>
                                                <option value="0" ' . ($row->MsWorkplaceType == 0 ? "Selected" : "") . '>Toko</option>
                                                <option value="1" ' . ($row->MsWorkplaceType == 1 ? "Selected" : "") . '>Gudang</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mb-1">
                                        <label for="tb_search" class="col-sm-3 col-form-label">Alamat</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control form-control-sm" readonly>' . $row->MsWorkplaceAddress . '</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="tb_search" class="col-sm-3 col-form-label">Telp 1</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control form-control-sm input-phone" value="' . $row->MsWorkplaceTelp1 . '" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="tb_search" class="col-sm-3 col-form-label">Telp 2</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control form-control-sm input-phone" value="' . $row->MsWorkplaceTelp2 . '" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="tb_search" class="col-sm-3 col-form-label">Fax</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control form-control-sm input-phone" value="' . $row->MsWorkplaceFax . '" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <script>
                var datesCollection = document.getElementsByClassName("input-phone");
                var phones = Array.from(datesCollection);

                phones.forEach(function (phone) {
                    new Cleave(phone, {
                        phone: true,
                        phoneRegionCode: "ID"
                    })
                });
            </script>';
        }
    }
    function data_toko_edit($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsWorkplace where MsWorkplaceId='" . $id . "'");
        foreach ($query->result() as $row) {
            echo '<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form class="modal-content" name="edit-toko">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp;Edit Data Toko</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row justify-content-center">
                                <div class="col-10">
                                    <div class="row mb-1">
                                        <label for="MsWorkplaceIsActive" class="col-sm-3 col-form-label">Status</label>
                                        <div class="col-sm-9">
                                            <div class="form-check form-switch">
                                                <input  id="MsWorkplaceIsActive"  name="MsWorkplaceIsActive" class="form-check-input" type="checkbox"' . ($row->MsWorkplaceIsActive == 1 ? "checked" : "") . '>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-1">
                                        <label for="MsWorkplaceCode" class="col-sm-3 col-form-label">Kode</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="MsWorkplaceCode" name="MsWorkplaceCode" class="form-control form-control-sm" value="' . $row->MsWorkplaceCode . '" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="MsWorkplaceName" class="col-sm-3 col-form-label">Nama</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="MsWorkplaceName" name="MsWorkplaceName" class="form-control form-control-sm" value="' . $row->MsWorkplaceName . '" >
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="tb_search" class="col-sm-3 col-form-label">Tipe</label>
                                        <div class="col-sm-9">
                                            <select id="MsWorkplaceType" name="MsWorkplaceType" class="form-select form-select-sm" aria-label="form-select-sm example">
                                                <option value="0" ' . ($row->MsWorkplaceType == 0 ? "Selected" : "") . '>Toko</option>
                                                <option value="1" ' . ($row->MsWorkplaceType == 1 ? "Selected" : "") . '>Gudang</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mb-1">
                                        <label for="tb_search" class="col-sm-3 col-form-label">Alamat</label>
                                        <div class="col-sm-9">
                                            <textarea id="MsWorkplaceAddress" name="MsWorkplaceAddress" class="form-control form-control-sm">' . $row->MsWorkplaceAddress . '</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="tb_search" class="col-sm-3 col-form-label">Telp 1</label>
                                        <div class="col-sm-9">
                                            <input id="MsWorkplaceTelp1" name="MsWorkplaceTelp1" type="text" class="form-control form-control-sm input-phone" value="' . $row->MsWorkplaceTelp1 . '">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="tb_search" class="col-sm-3 col-form-label">Telp 2</label>
                                        <div class="col-sm-9">
                                            <input id="MsWorkplaceTelp2" name="MsWorkplaceTelp2" type="text" class="form-control form-control-sm input-phone" value="' . $row->MsWorkplaceTelp2 . '">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="tb_search" class="col-sm-3 col-form-label">Fax</label>
                                        <div class="col-sm-9">
                                            <input id="MsWorkplaceFax" name="MsWorkplaceFax" type="text" class="form-control form-control-sm input-phone" value="' . $row->MsWorkplaceFax . '">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn-submit">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <script>
                var req_status_add = 0;
                var datesCollection = document.getElementsByClassName("input-phone");
                var phones = Array.from(datesCollection);

                phones.forEach(function (phone) {
                    new Cleave(phone, {
                        phone: true,
                        phoneRegionCode: "ID"
                    })
                });
                
                $(function() { 
                    $("form[name=\'edit-toko\']").validate({
                        rules: {
                            MsWorkplaceCode: "required",
                            MsWorkplaceName: "required",
                            MsWorkplaceAddress: "required",
                        },
                        messages: {
                            MsWorkplaceCode: "Masukan kode toko",
                            MsWorkplaceName: "Masukan Nama toko",
                            MsWorkplaceAddress: "Masukan Alamat toko",
                        },
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_toko_edit/") . $id . '",
                                    data: $("form[name=\'edit-toko\']").serialize(),
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Edit data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Edit data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>';
        }
    }
    function data_toko_delete($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsWorkplace where MsWorkplaceId=" . $id);
        foreach ($query->result() as $row) {
            echo '<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form class="modal-content" name="delete-toko">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-ban text-danger" aria-hidden="true"></i> &nbsp;Nonaktifkan Data Toko</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span class="fw-normal" >Anda yakin ingin menonaktifkan toko </span>
                            <span class="fw-bold" >' . $row->MsWorkplaceCode . '</span>
                            <span class="fw-normal" >?</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn-submit" >Setuju</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                var req_status_add = 0;
                $(function() { 
                    $("form[name=\'delete-toko\']").validate({
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_toko_delete/") . $id . '",
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Nonaktifkan data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Nonaktifkan data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>';
        }
    }
    function data_toko_enable($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsWorkplace where MsWorkplaceId=" . $id);
        foreach ($query->result() as $row) {
            echo '<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form class="modal-content" name="enable-toko">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-check text-success" aria-hidden="true"></i> &nbsp;Mengaktifkan Data Toko</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span class="fw-normal" >Anda yakin ingin mengaktifkan toko </span>
                            <span class="fw-bold" >' . $row->MsWorkplaceCode . '</span>
                            <span class="fw-normal" >?</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn-submit" >Setuju</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                var req_status_add = 0;
                $(function() { 
                    $("form[name=\'enable-toko\']").validate({
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_toko_enable/") . $id . '",
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Nonaktifkan data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Nonaktifkan data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>';
        }
    }

    /*
    *       MODAL DATA JABATAN
    */
    function data_jabatan_add()
    {
        echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered ">
                <form class="modal-content" name="create-jabatan">
                    <div class="modal-header bg-dark">
                        <h6 class="modal-title text-white"><i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;Tambah Data Jabatan</h5>
                        <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div  class="row justify-content-center">
                            <div class="col-10">
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpPositionIsActive" class="col-sm-3 col-form-label">Status<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-switch">
                                            <input id="MsEmpPositionIsActive" name="MsEmpPositionIsActive" class="form-check-input" type="checkbox" checked>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpPositionCode" class="col-sm-3 col-form-label">Kode<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpPositionCode" name="MsEmpPositionCode" type="text" class="form-control form-control-sm" value="">
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpPositionName" class="col-sm-3 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpPositionName" name="MsEmpPositionName" type="text" class="form-control form-control-sm" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"   id="btn-submit"        >Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
        
        <script>
            var req_status_add = 0;
            var datesCollection = document.getElementsByClassName("input-phone");
            var phones = Array.from(datesCollection);

            phones.forEach(function (phone) {
                new Cleave(phone, {
                    phone: true,
                    phoneRegionCode: "ID"
                })
            });
            
            $(function() { 
                $("form[name=\'create-jabatan\']").validate({
                    rules: {
                        MsEmpPositionCode: {
                            "required": true,
                            "remote": "' . site_url("function/client_data_master/validate_kode_jabatan") . '",
                        },
                        MsEmpPositionName: "required",
                    },
                    messages: {
                        MsEmpPositionCode: { 
                            required: "Masukan kode Jabatan",
                            remote: "Kode Jabatan sudah ada"
                        },
                        MsEmpPositionName: "Masukan Nama Jabatan",
                    },
                    submitHandler: function(form) {
                        if(!req_status_add){
                            $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                            $.ajax({
                                method: "POST",
                                url: "' . site_url("function/client_data_master/data_jabatan_add") . '",
                                data: $("form[name=\'create-jabatan\']").serialize(),
                                before: function(){ 
                                    req_status_add = 1;
                                },
                                success: function(data) {
                                    req_status_add = 0;
                                    $("#btn-submit").html("Simpan");
                                    
                                    if(data){
                                        Swal.fire({
                                            icon: \'success\',
                                            text: \'Tambah data berhasil\',
                                            showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                            timer: 1500,
                                        }).then((result) => {
                                            if (result.dismiss === Swal.DismissReason.timer) {
                                                load_data_table();
                                            }
                                        });
                                    }else{
                                        Swal.fire({
                                            icon: \'error\',
                                            text: \'Tambah data gagal\',
                                            showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                            timer: 1500
                                        });
                                    }
                                }
                            });
                            return false;
                        }
                    }
                });
            });
        </script>';
    }
    function data_jabatan_view($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsEmployeePosition where MsEmpPositionId=" . $id);
        foreach ($query->result() as $row) {
            echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered ">
                    <form class="modal-content" name="create-jabatan">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-eye text-info" aria-hidden="true"></i> &nbsp;Detail Data Jabatan</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div  class="row justify-content-center">
                                <div class="col-10">
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsEmpPositionIsActive" class="col-sm-3 col-form-label">Status<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <div class="form-check form-switch">
                                                <input id="MsEmpPositionIsActive" name="MsEmpPositionIsActive" class="form-check-input" type="checkbox" ' . ($row->MsEmpPositionIsActive == 1 ? "checked" : "") . ' disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsEmpPositionCode" class="col-sm-3 col-form-label">Kode<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <input id="MsEmpPositionCode" name="MsEmpPositionCode" type="text" class="form-control form-control-sm" value="' . $row->MsEmpPositionCode . '" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsEmpPositionName" class="col-sm-3 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <input id="MsEmpPositionName" name="MsEmpPositionName" type="text" class="form-control form-control-sm" value="' . $row->MsEmpPositionName . '" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
            ';
        }
    }
    function data_jabatan_edit($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsEmployeePosition where MsEmpPositionId=" . $id);
        foreach ($query->result() as $row) {
            echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered ">
                    <form class="modal-content" name="create-jabatan">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp; Edit Data Jabatan</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div  class="row justify-content-center">
                                <div class="col-10">
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsEmpPositionIsActive" class="col-sm-3 col-form-label">Status<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <div class="form-check form-switch">
                                                <input id="MsEmpPositionIsActive" name="MsEmpPositionIsActive" class="form-check-input" type="checkbox" ' . ($row->MsEmpPositionIsActive == 1 ? "checked" : "") . '>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsEmpPositionCode" class="col-sm-3 col-form-label">Kode<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <input id="MsEmpPositionCode" name="MsEmpPositionCode" type="text" class="form-control form-control-sm" value="' . $row->MsEmpPositionCode . '">
                                        </div>
                                    </div>
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsEmpPositionName" class="col-sm-3 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <input id="MsEmpPositionName" name="MsEmpPositionName" type="text" class="form-control form-control-sm" value="' . $row->MsEmpPositionName . '">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success"   id="btn-submit"        >Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <script>
                var req_status_add = 0;
                var datesCollection = document.getElementsByClassName("input-phone");
                var phones = Array.from(datesCollection);

                phones.forEach(function (phone) {
                    new Cleave(phone, {
                        phone: true,
                        phoneRegionCode: "ID"
                    })
                });
                
                $(function() { 
                    $("form[name=\'create-jabatan\']").validate({
                        rules: {
                            MsEmpPositionCode: {
                                "required": true,
                                "remote": "' . site_url("function/client_data_master/validate_kode_jabatan/") . $row->MsEmpPositionCode . '",
                            },
                            MsEmpPositionName: "required",
                        },
                        messages: {
                            MsEmpPositionCode: { 
                                required: "Masukan kode Jabatan",
                                remote: "Kode Jabatan sudah ada"
                            },
                            MsEmpPositionName: "Masukan Nama Jabatan",
                        },
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_jabatan_edit/") . $id . '",
                                    data: $("form[name=\'create-jabatan\']").serialize(),
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Edit data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Tambah data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>
            ';
        }
    }
    function data_jabatan_delete($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsEmployeePosition where MsEmpPositionId=" . $id)->result();
        foreach ($query as $row) {
            echo '<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form class="modal-content" name="delete-jabatan">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-ban text-danger" aria-hidden="true"></i> &nbsp;Nonaktifkan Data Jabatan</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span class="fw-normal" >Anda yakin ingin menonaktifkan</span>
                            <span class="fw-bold" >' . $row->MsEmpPositionCode . ' - ' . $row->MsEmpPositionName . '</span>
                            <span class="fw-normal" >?</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn-submit" >Setuju</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                var req_status_add = 0;
                $(function() { 
                    $("form[name=\'delete-jabatan\']").validate({
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_jabatan_delete/") . $id . '",
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Nonaktifkan data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Nonaktifkan data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>';
        }
    }
    function data_jabatan_enable($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsEmployeePosition where MsEmpPositionId=" . $id)->result();
        foreach ($query as $row) {
            echo '<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form class="modal-content" name="enable-jabatan">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-check text-success" aria-hidden="true"></i> &nbsp;Mengaktifkan Data Jabatan</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span class="fw-normal" >Anda yakin ingin mengaktifkan </span>
                            <span class="fw-bold" >' . $row->MsEmpPositionCode . ' - ' . $row->MsEmpPositionName . '</span>
                            <span class="fw-normal" >?</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn-submit" >Setuju</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                var req_status_add = 0;
                $(function() { 
                    $("form[name=\'enable-jabatan\']").validate({
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_jabatan_enable/") . $id . '",
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Nonaktifkan data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Nonaktifkan data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>';
        }
    }

    /*
    *       MODAL DATA KARYAWAN
    */
    function data_karyawan_add()
    {
        $data_toko = $this->db->query("SELECT * FROM TblMsWorkplace where MsWorkplaceIsActive='1'")->result();
        $data_jabatan = $this->db->query("SELECT * FROM TblMsEmployeePosition where MsEmpPositionIsActive ='1'")->result();
        $data_akses = $this->db->query("SELECT * FROM TblMenuListing")->result();
        echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg modal-dialog-centered ">
                <form class="modal-content" name="form-action">
                    <div class="modal-header bg-dark">
                        <h6 class="modal-title text-white"><i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;Tambah Data Karyawan</h5>
                        <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <div class="col-lg-4 col-11 my-1">
                                <div class="small-box justify-content-center">
                                    <label class="cabinet p-auto">
                                        <input type="file" class="form-control item-img file" id="MsEmpImageFile" name="MsEmpImageFile" accept="image/*">
                                        <figure>
                                            <img src="' . $this->model_app->get_base_64_by_id(0) . '"  class="img-circular m-auto" id="MsEmpImage" name="MsEmpImage" />
                                            <figcaption class="text-center"><i class="fas fa-camera"></i>&nbsp; Change</figcaption>
                                        </figure>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-8 col-11 my-1">
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpIsActive" class="col-sm-3 col-form-label">Status<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-switch">
                                            <input id="MsEmpIsActive" name="MsEmpIsActive" class="form-check-input" type="checkbox" checked>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpCode" class="col-sm-3 col-form-label">Kode<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpCode" name="MsEmpCode" type="text" class="form-control form-control-sm" value="' . $this->model_app->get_next_id_employee() . '" readonly>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpPositionName" class="col-sm-3 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpName" name="MsEmpName" type="text" class="form-control form-control-sm" value="">
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpPositionName" class="col-sm-3 col-form-label">No Kartu (Absen)</label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpCard" name="MsEmpCard" type="text" class="form-control form-control-sm" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 col-11 my-1">
                                <div class="row mb-1 align-items-center">
                                    <div class="label-border-right">
                                        <span class="label-dialog">Personal</span>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpNip" class="col-sm-3 col-form-label">NIP/NIK</label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpNip" name="MsEmpNip" type="text" class="form-control form-control-sm" value="">
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpBirthPlace" class="col-sm-3 col-form-label">Tempat Lahir</label>
                                    <div class="col-sm-4 pe-sm-0">
                                        <input id="MsEmpBirthPlace" name="MsEmpBirthPlace" type="text" class="form-control form-control-sm" value="">
                                    </div>
                                    <label for="MsEmpBirthDate" class="col-sm-2 col-form-label ">Tgl Lahir</label>
                                    <div class="col-sm-3 ps-sm-0">
                                        <input id="MsEmpBirthDate" name="MsEmpBirthDate" type="text" class="form-control form-control-sm" value="">
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpGender" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="MsEmpGender" id="MsEmpGender1" value="M" Checked>
                                            <label class="col-form-label" for="MsEmpGender1">Laki-laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="MsEmpGender" id="MsEmpGender2" value="F">
                                            <label class="col-form-label" for="MsEmpGender2">Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpTlp" class="col-sm-3 col-form-label">No. Telp</label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpTlp" name="MsEmpTlp" type="text" class="form-control form-control-sm input-phone" value="">
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpEmail" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpEmail" name="MsEmpEmail" type="email" class="form-control form-control-sm" value="">
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpAddress" class="col-sm-3 col-form-label">Alamat</label>
                                    <div class="col-sm-9">
                                        <textarea id="MsEmpAddress" name="MsEmpAddress" class="form-control form-control-sm"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-11 my-1">
                                <div class="row mb-1 align-items-center">
                                    <div class="label-border-right">
                                        <span class="label-dialog">Perusahaan</span>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpStartWork" class="col-sm-3 col-form-label">Mulai Bekerja</label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpStartWork" name="MsEmpStartWork" type="text" class="form-control form-control-sm" value="">
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpPositionId" class="col-sm-3 col-form-label">Jabatan</label>
                                    <div class="col-sm-9">
                                        <select class="form-select form-control-sm" id="MsEmpPositionId" name="MsEmpPositionId" style="width: 100%">
                                            ';
        foreach ($data_jabatan as $key) {
            echo '<option value="' . $key->MsEmpPositionId . '">' . $key->MsEmpPositionCode . ' - ' . $key->MsEmpPositionName . '</option>';
        }
        echo '
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsWorkplaceId" class="col-sm-3 col-form-label">Toko</label>
                                    <div class="col-sm-9">
                                        <select class="form-select form-select-sm" id="MsWorkplaceId" name="MsWorkplaceId" style="width: 100%">
                                            ';
        foreach ($data_toko as $key) {
            echo '<option value="' . $key->MsWorkplaceId . '">' . $key->MsWorkplaceCode . ' - ' . $key->MsWorkplaceName . '</option>';
        }
        echo '
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsWorkplaceId" class="col-sm-3 col-form-label">Akses</label>
                                    <div class="col-sm-9">
                                        <select class="form-select form-select-sm" id="MsEmpMode" name="MsEmpMode" style="width: 100%">
                                            ';
        foreach ($data_akses as $key) {
            echo '<option value="' . $key->MenuListingName . '" selected>' . $key->MenuListingName .   '</option>';
        }
        echo '
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <div class="label-border-right">
                                        <span class="label-dialog">Akun Bank</span>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpBank" class="col-sm-3 col-form-label">Bank</label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpBank" name="MsEmpBank" type="text" class="form-control form-control-sm" value="">
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpRekNo" class="col-sm-3 col-form-label">Rekening</label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpRekNo" name="MsEmpRekNo" type="text" class="form-control form-control-sm" value="">
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpRekName" class="col-sm-3 col-form-label">A/N</label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpRekName" name="MsEmpRekName" type="text" class="form-control form-control-sm" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"   id="btn-submit"        >Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="upload-demo" class="center-block m-auto"></div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default float-start" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="cropImageBtn" class="btn btn-primary float-end">Crop</button>
                    </div>
                </div>
            </div>
        </div>
        <script>   
        
            var MsPosition = $("#MsEmpPositionId").select2({
                dropdownParent: $("#modal-action .modal-content")
            }); 
            var MsWorkplace = $("#MsWorkplaceId").select2({
                dropdownParent: $("#modal-action .modal-content")
            });  
            var MsEmpMode = $("#MsEmpMode").select2({
                dropdownParent: $("#modal-action .modal-content")
            }); 

            MsWorkplace.val(3);
            MsWorkplace.trigger("change");
            var dtstartBirthDate = moment();
            var dtstartStartWork = moment();                
            $("#MsEmpBirthDate").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                startDate: dtstartBirthDate,
                locale: {
                    format: "DD/MM/YYYY"
                }
            },txt_date);
            txt_date(dtstartBirthDate);
            function txt_date(start) {
                $("#MsEmpBirthDate").html(start.format("DD/MM/YYYY"));
                //send function to window
                dtstartBirthDate = start;
                var vDate = {
                        strDate : function() {
                            return start.format("YYYY-MM-DD");
                    }
                };
                
                window.MsEmpBirthDate = vDate;
            }
        
            $("#MsEmpStartWork").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                startDate: dtstartStartWork,
                locale: {
                    format: "DD/MM/YYYY"
                }
            },txt_date);
            txt_date(dtstartStartWork);
            function txt_date(start) {
                $("#MsEmpStartWork").html(start.format("DD/MM/YYYY"));
                dtstartStartWork = start;
                //send function to window
                var vDate = {
                        strDate : function() {
                            return start.format("YYYY-MM-DD");
                    }
                };
                window.MsEmpStartWork = vDate;
            }                                   
            //$("#MsEmpImage").attr("src", "https://user.gadjian.com/static/images/personnel_boy.png");
            var $uploadCrop,
            tempFilename,
            rawImg,
            imageId;
            

            function readFile(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $(".upload-demo").addClass("ready");
                        $("#cropImagePop").modal("show");
                        rawImg = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                }
                else {
                    swal.fire("Sorry - you\'re browser doesn\'t support the FileReader API");
                }
            }

            $uploadCrop = $("#upload-demo").croppie({
                viewport: {
                    width: 150,
                    height: 150,
                    type: "circle"
                },
                enforceBoundary: false,
                enableExif: true
            });
            $("#cropImagePop").on("shown.bs.modal", function(){
               // alert("Shown pop");
                $uploadCrop.croppie("bind", {
                    url: rawImg
                }).then(function(){
                    console.log("jQuery bind complete");
                });
            });

            $("#MsEmpImageFile").on("change", function () {
                imageId = $(this).data("id"); 
                tempFilename = $(this).val();
                $("#cancelCropBtn").data("id", imageId); 
                readFile(this); 
            });
            $("#cropImageBtn").on("click", function (ev) {
                $uploadCrop.croppie("result", {
                    circle: false, 
                    type: "base64",
                    format: "png",
                    size: {width: 150, height: 150}
                }).then(function (resp) {
                    $("#MsEmpImage").attr("src", resp);
                    $("#cropImagePop").modal("hide");
                });
            });
			// End upload preview image


            var req_status_add = 0;
            var datesCollection = document.getElementsByClassName("input-phone");
            var phones = Array.from(datesCollection);

            phones.forEach(function (phone) {
                new Cleave(phone, {
                    phone: true,
                    phoneRegionCode: "ID"
                })
            });
            
            $(function() { 
                $("form[name=\'form-action\']").validate({
                    rules: {
                        MsEmpName: "required",
                        MsEmpPositionName: "required",
                    },
                    messages: {
                        MsEmpPositionCode:"Masukan kode Jabatan",
                        MsEmpPositionName: "Masukan Nama Jabatan",
                    },
                    submitHandler: function(form) {
                        if(!req_status_add){
                            $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                            $.ajax({
                                method: "POST",
                                url: "' . site_url("function/client_data_master/data_karyawan_add") . '",
                                data: {
                                        "MsEmpCode" : $("#MsEmpCode").val(),
                                        "MsEmpName" : $("#MsEmpName").val(),
                                        "MsEmpBirthDate" : $("#MsEmpBirthDate").val(),
                                        "MsEmpEmail" : $("#MsEmpEmail").val(),
                                        "MsEmpTlp" : $("#MsEmpTlp").val(),
                                        "MsEmpAddress" : $("#MsEmpAddress").val(),
                                        "MsEmpIsActive" : ($("#MsEmpIsActive").prop("checked")==false?null:"on"),
                                        "MsEmpStartWork" : $("#MsEmpStartWork").val(),
                                        "MsEmpPositionId" : $("#MsEmpPositionId").val(),
                                        "MsWorkplaceId" : $("#MsWorkplaceId").val(),
                                        "MsEmpMode" : $("#MsEmpMode").val(),
                                        "MsEmpBank" : $("#MsEmpBank").val(),
                                        "MsEmpRekNo" : $("#MsEmpRekNo").val(),
                                        "MsEmpRekName" : $("#MsEmpRekName").val(),
                                        "MsEmpNip" : $("#MsEmpNip").val(),
                                        "MsEmpBirthPlace" : $("#MsEmpBirthPlace").val(),
                                        "MsEmpCard" : $("#MsEmpCard").val(),
                                        "MsEmpGender" : $("input[name=\'MsEmpGender\']:checked").val(),
                                        "MsEmpImage" : $("#MsEmpImage").prop("src"),
                                },
                                before: function(){ 
                                    req_status_add = 1;
                                },
                                success: function(data) {
                                    req_status_add = 0;
                                    $("#btn-submit").html("Simpan");
                                    
                                    if(data){
                                        Swal.fire({
                                            icon: \'success\',
                                            text: \'Tambah data berhasil\',
                                            showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                            timer: 1500,
                                        }).then((result) => {
                                            if (result.dismiss === Swal.DismissReason.timer) {
                                                load_data_table();
                                            }
                                        });
                                    }else{
                                        Swal.fire({
                                            icon: \'error\',
                                            text: \'Tambah data gagal\',
                                            showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                            timer: 1500
                                        });
                                    }
                                }
                            });
                            return false;
                        }
                    }
                });
            });
        </script>';
    }
    function data_karyawan_view($id)
    {
        $data_karyawan = $this->db->query("SELECT * FROM TblMsEmployee where MsEmpId='" . $id . "'")->row_array(); 
        $data_toko = $this->db->query("SELECT * FROM TblMsWorkplace where MsWorkplaceId='" . $data_karyawan['MsWorkplaceId'] . "'")->result(); 
        $data_akses = $this->db->query("SELECT * FROM TblMenuListing where MenuListingName='" . $data_karyawan['MsEmpMode'] . "'")->result();
        $data_jabatan = $this->db->query("SELECT * FROM TblMsEmployeePosition where MsEmpPositionId ='" . $data_karyawan['MsEmpPositionId'] . "'")->result();
        echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg modal-dialog-centered ">
                <form class="modal-content" name="form-action">
                    <div class="modal-header bg-dark">
                        <h6 class="modal-title text-white"><i class="fas fa-eye text-info" aria-hidden="true"></i> &nbsp;View Data Karyawan</h5>
                        <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <div class="col-lg-4 col-11 my-1">
                                <div class="small-box justify-content-center">
                                    <label class="cabinet p-auto">
                                        <input type="file" class="form-control item-img file" id="MsEmpImageFile" name="MsEmpImageFile" accept="image/*" disabled>
                                        <figure>
                                            <img src="' . $this->model_app->get_base_64_by_id($data_karyawan['MsEmpCode']) . '"  class="img-circular m-auto" id="MsEmpImage" name="MsEmpImage" />
                                            <figcaption class="text-center"><i class="fas fa-camera"></i>&nbsp; Change</figcaption>
                                        </figure>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-8 col-11 my-1">
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpIsActive" class="col-sm-3 col-form-label">Status<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-switch">
                                            <input id="MsEmpIsActive" name="MsEmpIsActive" class="form-check-input" type="checkbox" ' . ($data_karyawan['MsEmpIsActive'] == 1 ? 'checked' : '') . ' disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpCode" class="col-sm-3 col-form-label">Kode<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpCode" name="MsEmpCode" type="text" class="form-control form-control-sm" value="' . $data_karyawan['MsEmpCode'] . '" readonly>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpPositionName" class="col-sm-3 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpName" name="MsEmpName" type="text" class="form-control form-control-sm" value="' . $data_karyawan['MsEmpName'] . '" readonly>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpPositionName" class="col-sm-3 col-form-label">No Kartu (Absen)</label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpCard" name="MsEmpCard" type="text" class="form-control form-control-sm" value="' . $data_karyawan['MsEmpCard'] . '" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 col-11 my-1">
                                <div class="row mb-1 align-items-center">
                                    <div class="label-border-right">
                                        <span class="label-dialog">Personal</span>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpNip" class="col-sm-3 col-form-label">NIP/NIK</label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpNip" name="MsEmpNip" type="text" class="form-control form-control-sm" value="' . $data_karyawan['MsEmpNip'] . '" readonly>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpBirthPlace" class="col-sm-3 col-form-label">Tempat Lahir</label>
                                    <div class="col-sm-4 pe-sm-0">
                                        <input id="MsEmpBirthPlace" name="MsEmpBirthPlace" type="text" class="form-control form-control-sm"  value="' . $data_karyawan['MsEmpBirthPlace'] . '" readonly>
                                    </div>
                                    <label for="MsEmpBirthDate" class="col-sm-2 col-form-label ">Tgl Lahir</label>
                                    <div class="col-sm-3 ps-sm-0">
                                        <input id="MsEmpBirthDate" name="MsEmpBirthDate" type="text" class="form-control form-control-sm" value="' . $data_karyawan['MsEmpBirthDate'] . '" disabled>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpGender" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="MsEmpGender" id="MsEmpGender1" value="M" ' . ($data_karyawan['MsEmpGender'] == 'M' ? 'checked' : '') . ' disabled>
                                            <label class="col-form-label" for="MsEmpGender1">Laki-laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="MsEmpGender" id="MsEmpGender2" value="F" ' . ($data_karyawan['MsEmpGender'] == 'F' ? 'checked' : '') . ' disabled>
                                            <label class="col-form-label" for="MsEmpGender2">Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpTlp" class="col-sm-3 col-form-label">No. Telp</label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpTlp" name="MsEmpTlp" type="text" class="form-control form-control-sm input-phone" value="' . $data_karyawan['MsEmpTlp'] . '" readonly>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpEmail" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpEmail" name="MsEmpEmail" type="email" class="form-control form-control-sm" value="' . $data_karyawan['MsEmpEmail'] . '" readonly>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpAddress" class="col-sm-3 col-form-label">Alamat</label>
                                    <div class="col-sm-9">
                                        <textarea id="MsEmpAddress" name="MsEmpAddress" class="form-control form-control-sm" readonly>' . $data_karyawan['MsEmpAddress'] . '</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-11 my-1">
                                <div class="row mb-1 align-items-center">
                                    <div class="label-border-right">
                                        <span class="label-dialog">Perusahaan</span>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpStartWork" class="col-sm-3 col-form-label">Mulai Bekerja</label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpStartWork" name="MsEmpStartWork" type="text" class="form-control form-control-sm" value="' . $data_karyawan['MsEmpStartWork'] . '" disabled>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpPositionId" class="col-sm-3 col-form-label">Jabatan</label>
                                    <div class="col-sm-9">
                                        <select class="form-select form-control-sm" id="MsEmpPositionId" name="MsEmpPositionId" style="width: 100%" disabled>
                                            ';
        foreach ($data_jabatan as $key) {
            echo '<option value="' . $key->MsEmpPositionId . '">' . $key->MsEmpPositionCode . ' - ' . $key->MsEmpPositionName . '</option>';
        }
        echo '
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsWorkplaceId" class="col-sm-3 col-form-label">Toko</label>
                                    <div class="col-sm-9">
                                        <select class="form-select form-select-sm" id="MsWorkplaceId" name="MsWorkplaceId" style="width: 100%" disabled>
                                            ';
        foreach ($data_toko as $key) {
            echo '<option value="' . $key->MsWorkplaceId . '">' . $key->MsWorkplaceCode . ' - ' . $key->MsWorkplaceName . '</option>';
        }
        echo '
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsWorkplaceId" class="col-sm-3 col-form-label">Akses</label>
                                    <div class="col-sm-9">
                                        <select class="form-select form-select-sm" id="MsEmpMode" name="MsEmpMode" style="width: 100%" disabled>
                                            ';
        foreach ($data_akses as $key) {
            echo '<option value="' . $key->MenuListingName . '">' . $key->MenuListingName . '</option>';
        }
        echo '
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <div class="label-border-right">
                                        <span class="label-dialog">Akun Bank</span>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpBank" class="col-sm-3 col-form-label">Bank</label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpBank" name="MsEmpBank" type="text" class="form-control form-control-sm" value="' . $data_karyawan['MsEmpBank'] . '" disabled>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpRekNo" class="col-sm-3 col-form-label">Rekening</label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpRekNo" name="MsEmpRekNo" type="text" class="form-control form-control-sm" value="' . $data_karyawan['MsEmpRekNo'] . '" disabled>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpRekName" class="col-sm-3 col-form-label">A/N</label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpRekName" name="MsEmpRekName" type="text" class="form-control form-control-sm" value="' . $data_karyawan['MsEmpRekName'] . '" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="window.open(\'' . site_url('export/karyawan/') . $id . '\',\'_blank\')"><i class="fas fa-file-pdf"></i>&nbsp;Export</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="upload-demo" class="center-block m-auto"></div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default float-start" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="cropImageBtn" class="btn btn-primary float-end">Crop</button>
                    </div>
                </div>
            </div>
        </div>
        <script>   
            // --------------------------------------------      SETUP COMBO AND DATE
            var MsPosition = $("#MsEmpPositionId").select2({
                dropdownParent: $("#modal-action .modal-content")
            }); 
            var MsWorkplace = $("#MsWorkplaceId").select2({
                dropdownParent: $("#modal-action .modal-content")
            }); 
            
            //MsWorkplace.val(3);
            //MsWorkplace.trigger("change");

            var dtstartBirthDate = moment("' . $data_karyawan['MsEmpBirthDate'] . '");
            var dtstartStartWork = moment("' . $data_karyawan['MsEmpStartWork'] . '");                
            $("#MsEmpBirthDate").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                startDate: dtstartBirthDate,
                locale: {
                    format: "DD/MM/YYYY"
                }
            },txt_date);
            txt_date(dtstartBirthDate);
            function txt_date(start) {
                $("#MsEmpBirthDate").html(start.format("DD/MM/YYYY"));
                //send function to window
                dtstartBirthDate = start;
                var vDate = {
                        strDate : function() {
                            return start.format("YYYY-MM-DD");
                    }
                };
                
                window.MsEmpBirthDate = vDate;
            }
        
            $("#MsEmpStartWork").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                startDate: dtstartStartWork,
                locale: {
                    format: "DD/MM/YYYY"
                }
            },txt_date);
            txt_date(dtstartStartWork);
            function txt_date(start) {
                $("#MsEmpStartWork").html(start.format("DD/MM/YYYY"));
                dtstartStartWork = start;
                //send function to window
                var vDate = {
                        strDate : function() {
                            return start.format("YYYY-MM-DD");
                    }
                };
                window.MsEmpStartWork = vDate;
            }    
            // --------------------------------------------      END COMBO AND DATE


            // --------------------------------------------      Start upload preview image
            //$("#MsEmpImage").attr("src", "https://user.gadjian.com/static/images/personnel_boy.png");
            var $uploadCrop,
            tempFilename,
            rawImg,
            imageId;
            function readFile(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $(".upload-demo").addClass("ready");
                        $("#cropImagePop").modal("show");
                        rawImg = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                }
                else {
                    swal.fire("Sorry - you\'re browser doesn\'t support the FileReader API");
                }
            }

            $uploadCrop = $("#upload-demo").croppie({
                viewport: {
                    width: 150,
                    height: 150,
                    type: "circle"
                },
                enforceBoundary: false,
                enableExif: true
            });
            $("#cropImagePop").on("shown.bs.modal", function(){
               // alert("Shown pop");
                $uploadCrop.croppie("bind", {
                    url: rawImg
                }).then(function(){
                    console.log("jQuery bind complete");
                });
            });

            $("#MsEmpImageFile").on("change", function () {
                imageId = $(this).data("id"); 
                tempFilename = $(this).val();
                $("#cancelCropBtn").data("id", imageId); 
                readFile(this); 
            });
            $("#cropImageBtn").on("click", function (ev) {
                $uploadCrop.croppie("result", {
                    circle: false, 
                    type: "base64",
                    format: "png",
                    size: {width: 150, height: 150}
                }).then(function (resp) {
                    $("#MsEmpImage").attr("src", resp);
                    $("#cropImagePop").modal("hide");
                });
            });
			// --------------------------------------------      End upload preview image


            var req_status_add = 0;
            var datesCollection = document.getElementsByClassName("input-phone");
            var phones = Array.from(datesCollection);

            phones.forEach(function (phone) {
                new Cleave(phone, {
                    phone: true,
                    phoneRegionCode: "ID"
                })
            });
        </script>';
    }
    function data_karyawan_edit($id)
    {
        $data_karyawan = $this->db->query("SELECT * FROM TblMsEmployee where MsEmpId='" . $id . "'")->row_array(); 
        $data_toko = $this->db->query("SELECT * FROM TblMsWorkplace where MsWorkplaceIsActive='1'")->result();
        $data_akses = $this->db->query("SELECT * FROM TblMenuListing")->result();
        $data_jabatan = $this->db->query("SELECT * FROM TblMsEmployeePosition where MsEmpPositionIsActive='1'")->result();
        echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg modal-dialog-centered ">
                <form class="modal-content" name="form-action">
                    <div class="modal-header bg-dark">
                        <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp;Edit Data Karyawan</h5>
                        <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <div class="col-lg-4 col-11 my-1">
                                <div class="small-box justify-content-center">
                                    <label class="cabinet p-auto">
                                        <input type="file" class="form-control item-img file" id="MsEmpImageFile" name="MsEmpImageFile" accept="image/*">
                                        <figure>
                                            <img src="' . $this->model_app->get_base_64_by_id($data_karyawan['MsEmpCode']) . '"  class="img-circular m-auto" id="MsEmpImage" name="MsEmpImage" />
                                            <figcaption class="text-center"><i class="fas fa-camera"></i>&nbsp; Change</figcaption>
                                        </figure>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-8 col-11 my-1">
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpIsActive" class="col-sm-3 col-form-label">Status<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-switch">
                                            <input id="MsEmpIsActive" name="MsEmpIsActive" class="form-check-input" type="checkbox" ' . ($data_karyawan['MsEmpIsActive'] == 1 ? 'checked' : '') . '>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpCode" class="col-sm-3 col-form-label">Kode<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpCode" name="MsEmpCode" type="text" class="form-control form-control-sm" value="' . $data_karyawan['MsEmpCode'] . '" readonly>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpPositionName" class="col-sm-3 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpName" name="MsEmpName" type="text" class="form-control form-control-sm" value="' . $data_karyawan['MsEmpName'] . '">
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpPositionName" class="col-sm-3 col-form-label">No Kartu (Absen)</label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpCard" name="MsEmpCard" type="text" class="form-control form-control-sm" value="' . $data_karyawan['MsEmpCard'] . '">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 col-11 my-1">
                                <div class="row mb-1 align-items-center">
                                    <div class="label-border-right">
                                        <span class="label-dialog">Personal</span>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpNip" class="col-sm-3 col-form-label">NIP/NIK</label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpNip" name="MsEmpNip" type="text" class="form-control form-control-sm" value="' . $data_karyawan['MsEmpNip'] . '">
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpBirthPlace" class="col-sm-3 col-form-label">Tempat Lahir</label>
                                    <div class="col-sm-4 pe-sm-0">
                                        <input id="MsEmpBirthPlace" name="MsEmpBirthPlace" type="text" class="form-control form-control-sm"  value="' . $data_karyawan['MsEmpBirthPlace'] . '">
                                    </div>
                                    <label for="MsEmpBirthDate" class="col-sm-2 col-form-label ">Tgl Lahir</label>
                                    <div class="col-sm-3 ps-sm-0">
                                        <input id="MsEmpBirthDate" name="MsEmpBirthDate" type="text" class="form-control form-control-sm" value="' . $data_karyawan['MsEmpBirthDate'] . '">
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpGender" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="MsEmpGender" id="MsEmpGender1" value="M" ' . ($data_karyawan['MsEmpGender'] == 'M' ? 'checked' : '') . '>
                                            <label class="col-form-label" for="MsEmpGender1">Laki-laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="MsEmpGender" id="MsEmpGender2" value="F" ' . ($data_karyawan['MsEmpGender'] == 'F' ? 'checked' : '') . '>
                                            <label class="col-form-label" for="MsEmpGender2">Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpTlp" class="col-sm-3 col-form-label">No. Telp</label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpTlp" name="MsEmpTlp" type="text" class="form-control form-control-sm input-phone" value="' . $data_karyawan['MsEmpTlp'] . '">
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpEmail" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpEmail" name="MsEmpEmail" type="email" class="form-control form-control-sm" value="' . $data_karyawan['MsEmpEmail'] . '">
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpAddress" class="col-sm-3 col-form-label">Alamat</label>
                                    <div class="col-sm-9">
                                        <textarea id="MsEmpAddress" name="MsEmpAddress" class="form-control form-control-sm">' . $data_karyawan['MsEmpAddress'] . '</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-11 my-1">
                                <div class="row mb-1 align-items-center">
                                    <div class="label-border-right">
                                        <span class="label-dialog">Perusahaan</span>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpStartWork" class="col-sm-3 col-form-label">Mulai Bekerja</label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpStartWork" name="MsEmpStartWork" type="text" class="form-control form-control-sm" value="' . $data_karyawan['MsEmpStartWork'] . '">
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpPositionId" class="col-sm-3 col-form-label">Jabatan</label>
                                    <div class="col-sm-9">
                                        <select class="form-select form-control-sm" id="MsEmpPositionId" name="MsEmpPositionId" style="width: 100%">
                                            ';
        foreach ($data_jabatan as $key) {
            echo '<option value="' . $key->MsEmpPositionId . '">' . $key->MsEmpPositionCode . ' - ' . $key->MsEmpPositionName . '</option>';
        }
        echo '
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsWorkplaceId" class="col-sm-3 col-form-label">Toko</label>
                                    <div class="col-sm-9">
                                        <select class="form-select form-select-sm" id="MsWorkplaceId" name="MsWorkplaceId" style="width: 100%">
                                            ';
        foreach ($data_toko as $key) {
            echo '<option value="' . $key->MsWorkplaceId . '">' . $key->MsWorkplaceCode . ' - ' . $key->MsWorkplaceName . '</option>';
        }
        echo '
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsWorkplaceId" class="col-sm-3 col-form-label">Akses</label>
                                    <div class="col-sm-9">
                                        <select class="form-select form-select-sm" id="MsEmpMode" name="MsEmpMode" style="width: 100%">
                                            ';
        foreach ($data_akses as $key) {
            echo '<option value="' . $key->MenuListingName . '">' . $key->MenuListingName . '</option>';
        }
        echo '
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <div class="label-border-right">
                                        <span class="label-dialog">Akun Bank</span>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpBank" class="col-sm-3 col-form-label">Bank</label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpBank" name="MsEmpBank" type="text" class="form-control form-control-sm" value="' . $data_karyawan['MsEmpBank'] . '" >
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpRekNo" class="col-sm-3 col-form-label">Rekening</label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpRekNo" name="MsEmpRekNo" type="text" class="form-control form-control-sm" value="' . $data_karyawan['MsEmpRekNo'] . '" >
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsEmpRekName" class="col-sm-3 col-form-label">A/N</label>
                                    <div class="col-sm-9">
                                        <input id="MsEmpRekName" name="MsEmpRekName" type="text" class="form-control form-control-sm" value="' . $data_karyawan['MsEmpRekName'] . '">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"   id="btn-submit"        >Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="upload-demo" class="center-block m-auto"></div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default float-start" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="cropImageBtn" class="btn btn-primary float-end">Crop</button>
                    </div>
                </div>
            </div>
        </div>
        <script>   
            // --------------------------------------------      SETUP COMBO AND DATE
            var MsPosition = $("#MsEmpPositionId").select2({
                dropdownParent: $("#modal-action .modal-content")
            }); 
            var MsWorkplace = $("#MsWorkplaceId").select2({
                dropdownParent: $("#modal-action .modal-content")
            }); 
            var MsEmpMode = $("#MsEmpMode").select2({
                dropdownParent: $("#modal-action .modal-content")
            }); 
            
            MsWorkplace.val(' . $data_karyawan['MsWorkplaceId'] . ');
            MsWorkplace.trigger("change");
            MsPosition.val(' . $data_karyawan['MsEmpPositionId'] . ');
            MsPosition.trigger("change");
            MsEmpMode.val("' . $data_karyawan['MsEmpMode'] . '");
            MsEmpMode.trigger("change");

            var dtstartBirthDate = moment("' . $data_karyawan['MsEmpBirthDate'] . '");
            var dtstartStartWork = moment("' . $data_karyawan['MsEmpStartWork'] . '");                
            $("#MsEmpBirthDate").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                startDate: dtstartBirthDate,
                locale: {
                    format: "DD/MM/YYYY"
                }
            },txt_date);
            txt_date(dtstartBirthDate);
            function txt_date(start) {
                $("#MsEmpBirthDate").html(start.format("DD/MM/YYYY"));
                //send function to window
                dtstartBirthDate = start;
                var vDate = {
                        strDate : function() {
                            return start.format("YYYY-MM-DD");
                    }
                };
                
                window.MsEmpBirthDate = vDate;
            }
        
            $("#MsEmpStartWork").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                startDate: dtstartStartWork,
                locale: {
                    format: "DD/MM/YYYY"
                }
            },txt_date);
            txt_date(dtstartStartWork);
            function txt_date(start) {
                $("#MsEmpStartWork").html(start.format("DD/MM/YYYY"));
                dtstartStartWork = start;
                //send function to window
                var vDate = {
                        strDate : function() {
                            return start.format("YYYY-MM-DD");
                    }
                };
                window.MsEmpStartWork = vDate;
            }    
            // --------------------------------------------      END COMBO AND DATE


            // --------------------------------------------      Start upload preview image
            //$("#MsEmpImage").attr("src", "https://user.gadjian.com/static/images/personnel_boy.png");
            var $uploadCrop,
            tempFilename,
            rawImg,
            imageId;
            function readFile(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $(".upload-demo").addClass("ready");
                        $("#cropImagePop").modal("show");
                        rawImg = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                }
                else {
                    swal.fire("Sorry - you\'re browser doesn\'t support the FileReader API");
                }
            }

            $uploadCrop = $("#upload-demo").croppie({
                viewport: {
                    width: 150,
                    height: 150,
                    type: "circle"
                },
                enforceBoundary: false,
                enableExif: true
            });
            $("#cropImagePop").on("shown.bs.modal", function(){
               // alert("Shown pop");
                $uploadCrop.croppie("bind", {
                    url: rawImg
                }).then(function(){
                    console.log("jQuery bind complete");
                });
            });

            $("#MsEmpImageFile").on("change", function () {
                imageId = $(this).data("id"); 
                tempFilename = $(this).val();
                $("#cancelCropBtn").data("id", imageId); 
                readFile(this); 
            });
            $("#cropImageBtn").on("click", function (ev) {
                $uploadCrop.croppie("result", {
                    circle: false, 
                    type: "base64",
                    format: "png",
                    size: {width: 150, height: 150}
                }).then(function (resp) {
                    $("#MsEmpImage").attr("src", resp);
                    $("#cropImagePop").modal("hide");
                });
            });
			// --------------------------------------------      End upload preview image


            var req_status_add = 0;
            var datesCollection = document.getElementsByClassName("input-phone");
            var phones = Array.from(datesCollection);

            phones.forEach(function (phone) {
                new Cleave(phone, {
                    phone: true,
                    phoneRegionCode: "ID"
                })
            });
            $(function() { 
                $("form[name=\'form-action\']").validate({
                    rules: {
                        MsEmpName: "required",
                        MsEmpPositionName: "required",
                    },
                    messages: {
                        MsEmpPositionCode:"Masukan kode Jabatan",
                        MsEmpPositionName: "Masukan Nama Jabatan",
                    },
                    submitHandler: function(form) {
                        if(!req_status_add){
                            $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                            $.ajax({
                                method: "POST",
                                url: "' . site_url("function/client_data_master/data_karyawan_edit/") . $id . '",
                                data: {
                                        "MsEmpCode" : $("#MsEmpCode").val(),
                                        "MsEmpName" : $("#MsEmpName").val(),
                                        "MsEmpBirthDate" : $("#MsEmpBirthDate").val(),
                                        "MsEmpEmail" : $("#MsEmpEmail").val(),
                                        "MsEmpTlp" : $("#MsEmpTlp").val(),
                                        "MsEmpAddress" : $("#MsEmpAddress").val(),
                                        "MsEmpIsActive" : ($("#MsEmpIsActive").prop("checked")==false?null:"on"),
                                        "MsEmpStartWork" : $("#MsEmpStartWork").val(),
                                        "MsEmpPositionId" : $("#MsEmpPositionId").val(),
                                        "MsWorkplaceId" : $("#MsWorkplaceId").val(),
                                        "MsEmpMode" : $("#MsEmpMode").val(),
                                        "MsEmpBank" : $("#MsEmpBank").val(),
                                        "MsEmpRekNo" : $("#MsEmpRekNo").val(),
                                        "MsEmpRekName" : $("#MsEmpRekName").val(),
                                        "MsEmpNip" : $("#MsEmpNip").val(),
                                        "MsEmpBirthPlace" : $("#MsEmpBirthPlace").val(),
                                        "MsEmpCard" : $("#MsEmpCard").val(),
                                        "MsEmpGender" : $("input[name=\'MsEmpGender\']:checked").val(),
                                        "MsEmpImage" : $("#MsEmpImage").prop("src"),
                                },
                                before: function(){ 
                                    req_status_add = 1;
                                },
                                success: function(data) {
                                    req_status_add = 0;
                                    $("#btn-submit").html("Simpan");
                                    
                                    if(data){
                                        Swal.fire({
                                            icon: \'success\',
                                            text: \'Tambah data berhasil\',
                                            showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                            timer: 1500,
                                        }).then((result) => {
                                            if (result.dismiss === Swal.DismissReason.timer) {
                                                load_data_table();
                                            }
                                        });
                                    }else{
                                        Swal.fire({
                                            icon: \'error\',
                                            text: \'Tambah data gagal\',
                                            showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                            timer: 1500
                                        });
                                    }
                                }
                            });
                            return false;
                        }
                    }
                });
            });
        </script>';
    }
    function data_karyawan_delete($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsEmployee where MsEmpId=" . $id)->result();
        foreach ($query as $row) {
            echo '<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form class="modal-content" name="delete-karyawan">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-ban text-danger" aria-hidden="true"></i> &nbsp;Nonaktifkan Data Karyawan</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span class="fw-normal" >Anda yakin ingin menonaktifkan</span>
                            <span class="fw-bold" >' . $row->MsEmpCode . ' - ' . $row->MsEmpName . '</span>
                            <span class="fw-normal" >?</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn-submit" >Setuju</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                var req_status_add = 0;
                $(function() { 
                    $("form[name=\'delete-karyawan\']").validate({
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_karyawan_delete/") . $id . '",
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Nonaktifkan data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Nonaktifkan data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>';
        }
    }
    function data_karyawan_enable($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsEmployee where MsEmpId=" . $id)->result();
        foreach ($query as $row) {
            echo '<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form class="modal-content" name="delete-karyawan">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-check text-success" aria-hidden="true"></i> &nbsp;Mengaktifkan Data Karyawan</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span class="fw-normal" >Anda yakin ingin mengaktifkan</span>
                            <span class="fw-bold" >' . $row->MsEmpCode . ' - ' . $row->MsEmpName . '</span>
                            <span class="fw-normal" >?</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn-submit" >Setuju</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                var req_status_add = 0;
                $(function() { 
                    $("form[name=\'delete-karyawan\']").validate({
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_karyawan_enable/") . $id . '",
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Mengaktifkan data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Mengaktifkan data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>';
        }
    }

    /*
    *       MODAL DATA STAFF
    */
    function data_staff_add()
    {
        echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered ">
                <form class="modal-content" name="form-action">
                    <div class="modal-header bg-dark">
                        <h6 class="modal-title text-white"><i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;Tambah Data Staff Cetak</h5>
                        <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div  class="row justify-content-center">
                            <div class="col-10">
                                <div class="row mb-1">
                                    <label for="StaffIsActive" class="col-sm-3 col-form-label">Status<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-switch">
                                            <input id="StaffIsActive" name="StaffIsActive" class="form-check-input" type="checkbox" " checked>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label for="StaffCode" class="col-sm-3 col-form-label">Kode<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <input id="StaffCode" name="StaffCode" type="text" class="form-control form-control-sm" value="' . $this->model_app->get_next_id_staff() . '" readonly>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label for="StaffName" class="col-sm-3 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <input id="StaffName" name="StaffName" type="text" class="form-control form-control-sm" value="">
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label for="tb_search" class="col-sm-3 col-form-label">Alamat<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <textarea id="StaffAddress" name="StaffAddress"  class="form-control form-control-sm"></textarea>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label for="tb_search" class="col-sm-3 col-form-label">Telp</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="StaffTelp" name="StaffTelp" class="form-control form-control-sm input-phone" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"   id="btn-submit"        >Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
        
        <script>
            var req_status_add = 0;
            var datesCollection = document.getElementsByClassName("input-phone");
            var phones = Array.from(datesCollection);

            phones.forEach(function (phone) {
                new Cleave(phone, {
                    phone: true,
                    phoneRegionCode: "ID"
                })
            });
            
            $(function() { 
                $("form[name=\'form-action\']").validate({
                    rules: {
                        StaffCode: "required",
                        StaffName: "required",
                        StaffAddress: "required",
                    },
                    messages: {
                        StaffCode: "Masukan kode Staff",
                        StaffName: "Masukan Nama Staff",
                        StaffAddress: "Masukan Alamat Staff",
                    },
                    submitHandler: function(form) {
                        if(!req_status_add){
                            $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                            $.ajax({
                                method: "POST",
                                url: "' . site_url("function/client_data_master/data_staff_add") . '",
                                data: $("form[name=\'form-action\']").serialize(),
                                before: function(){ 
                                    req_status_add = 1;
                                },
                                success: function(data) {
                                    req_status_add = 0;
                                    $("#btn-submit").html("Simpan");
                                    
                                    if(data){
                                        Swal.fire({
                                            icon: \'success\',
                                            text: \'Tambah data berhasil\',
                                            showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                            timer: 1500,
                                        }).then((result) => {
                                            if (result.dismiss === Swal.DismissReason.timer) {
                                                load_data_table();
                                            }
                                        });
                                    }else{
                                        Swal.fire({
                                            icon: \'error\',
                                            text: \'Tambah data gagal\',
                                            showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                            timer: 1500
                                        });
                                    }
                                }
                            });
                            return false;
                        }
                    }
                });
            });
        </script>';
    }
    function data_staff_view($id)
    {
        $data_staff = $this->db->query("SELECT * FROM TblMsStaff where StaffId='" . $id . "'")->result();
        $data_staff = (array)$data_staff[0];
        echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered ">
                <form class="modal-content" name="form-action">
                    <div class="modal-header bg-dark">
                        <h6 class="modal-title text-white"><i class="fas fa-eye text-info" aria-hidden="true"></i> &nbsp;View Data Staff Cetak</h5>
                        <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div  class="row justify-content-center">
                            <div class="col-10">
                                <div class="row mb-1">
                                    <label for="StaffIsActive" class="col-sm-3 col-form-label">Status<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-switch">
                                            <input id="StaffIsActive" name="StaffIsActive" class="form-check-input" type="checkbox" ' . ($data_staff['StaffIsActive'] == 1 ? 'checked' : '') . ' disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label for="StaffCode" class="col-sm-3 col-form-label">Kode<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <input id="StaffCode" name="StaffCode" type="text" class="form-control form-control-sm" value="' . $data_staff['StaffCode'] . '" readonly>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label for="StaffName" class="col-sm-3 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <input id="StaffName" name="StaffName" type="text" class="form-control form-control-sm" value="' . $data_staff['StaffName'] . '" readonly>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label for="StaffAddress" class="col-sm-3 col-form-label">Alamat<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <textarea id="StaffAddress" name="StaffAddress"  class="form-control form-control-sm" readonly>' . $data_staff['StaffAddress'] . '</textarea>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label for="StaffTelp" class="col-sm-3 col-form-label">Telp</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="StaffTelp" name="StaffTelp" class="form-control form-control-sm input-phone" value="' . $data_staff['StaffTelp'] . '" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
        
        <script>
            var req_status_add = 0;
            var datesCollection = document.getElementsByClassName("input-phone");
            var phones = Array.from(datesCollection);

            phones.forEach(function (phone) {
                new Cleave(phone, {
                    phone: true,
                    phoneRegionCode: "ID"
                })
            });
            
            $(function() { 
                $("form[name=\'form-action\']").validate({
                    rules: {
                        StaffCode: "required",
                        StaffName: "required",
                        StaffAddress: "required",
                    },
                    messages: {
                        StaffCode: "Masukan kode Staff",
                        StaffName: "Masukan Nama Staff",
                        StaffAddress: "Masukan Alamat Staff",
                    },
                    submitHandler: function(form) {
                        if(!req_status_add){
                            $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                            $.ajax({
                                method: "POST",
                                url: "' . site_url("function/client_data_master/data_staff_add") . '",
                                data: $("form[name=\'form-action\']").serialize(),
                                before: function(){ 
                                    req_status_add = 1;
                                },
                                success: function(data) {
                                    req_status_add = 0;
                                    $("#btn-submit").html("Simpan");
                                    
                                    if(data){
                                        Swal.fire({
                                            icon: \'success\',
                                            text: \'Tambah data berhasil\',
                                            showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                            timer: 1500,
                                        }).then((result) => {
                                            if (result.dismiss === Swal.DismissReason.timer) {
                                                load_data_table();
                                            }
                                        });
                                    }else{
                                        Swal.fire({
                                            icon: \'error\',
                                            text: \'Tambah data gagal\',
                                            showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                            timer: 1500
                                        });
                                    }
                                }
                            });
                            return false;
                        }
                    }
                });
            });
        </script>';
    }
    function data_staff_edit($id)
    {
        $data_staff = $this->db->query("SELECT * FROM TblMsStaff where StaffId='" . $id . "'")->result();
        $data_staff = (array)$data_staff[0];
        echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered ">
                <form class="modal-content" name="form-action">
                    <div class="modal-header bg-dark">
                        <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp;Edit Data Staff Cetak</h5>
                        <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div  class="row justify-content-center">
                            <div class="col-10">
                                <div class="row mb-1">
                                    <label for="StaffIsActive" class="col-sm-3 col-form-label">Status<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-switch">
                                            <input id="StaffIsActive" name="StaffIsActive" class="form-check-input" type="checkbox" ' . ($data_staff['StaffIsActive'] == 1 ? 'checked' : '') . '>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label for="StaffCode" class="col-sm-3 col-form-label">Kode<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <input id="StaffCode" name="StaffCode" type="text" class="form-control form-control-sm" value="' . $data_staff['StaffCode'] . '" readonly>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label for="StaffName" class="col-sm-3 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <input id="StaffName" name="StaffName" type="text" class="form-control form-control-sm" value="' . $data_staff['StaffName'] . '">
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label for="StaffAddress" class="col-sm-3 col-form-label">Alamat<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <textarea id="StaffAddress" name="StaffAddress"  class="form-control form-control-sm">' . $data_staff['StaffAddress'] . '</textarea>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label for="StaffTelp" class="col-sm-3 col-form-label">Telp</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="StaffTelp" name="StaffTelp" class="form-control form-control-sm input-phone" value="' . $data_staff['StaffTelp'] . '">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"   id="btn-submit"        >Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
        
        <script>
            var req_status_add = 0;
            var datesCollection = document.getElementsByClassName("input-phone");
            var phones = Array.from(datesCollection);

            phones.forEach(function (phone) {
                new Cleave(phone, {
                    phone: true,
                    phoneRegionCode: "ID"
                })
            });
            
            $(function() { 
                $("form[name=\'form-action\']").validate({
                    rules: {
                        StaffCode: "required",
                        StaffName: "required",
                        StaffAddress: "required",
                    },
                    messages: {
                        StaffCode: "Masukan kode Staff",
                        StaffName: "Masukan Nama Staff",
                        StaffAddress: "Masukan Alamat Staff",
                    },
                    submitHandler: function(form) {
                        if(!req_status_add){
                            $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                            $.ajax({
                                method: "POST",
                                url: "' . site_url("function/client_data_master/data_staff_edit/") . $id . '",
                                data: $("form[name=\'form-action\']").serialize(),
                                before: function(){ 
                                    req_status_add = 1;
                                },
                                success: function(data) {
                                    req_status_add = 0;
                                    $("#btn-submit").html("Simpan");
                                    
                                    if(data){
                                        Swal.fire({
                                            icon: \'success\',
                                            text: \'Edit data berhasil\',
                                            showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                            timer: 1500,
                                        }).then((result) => {
                                            if (result.dismiss === Swal.DismissReason.timer) {
                                                load_data_table();
                                            }
                                        });
                                    }else{
                                        Swal.fire({
                                            icon: \'error\',
                                            text: \'Edit data gagal\',
                                            showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                            timer: 1500
                                        });
                                    }
                                }
                            });
                            return false;
                        }
                    }
                });
            });
        </script>';
    }
    function data_staff_delete($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsStaff where StaffId=" . $id)->result();
        foreach ($query as $row) {
            echo '<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-ban text-danger" aria-hidden="true"></i> &nbsp;Nonaktifkan Data Staff</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span class="fw-normal" >Anda yakin ingin menonaktifkan</span>
                            <span class="fw-bold" >' . $row->StaffCode . ' - ' . $row->StaffName . '</span>
                            <span class="fw-normal" >?</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn-submit" >Setuju</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                var req_status_add = 0;
                $(function() { 
                    $("form[name=\'form-action\']").validate({
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_staff_delete/") . $id . '",
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Nonaktifkan data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Nonaktifkan data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>';
        }
    }
    function data_staff_enable($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsStaff where StaffId=" . $id)->result();
        foreach ($query as $row) {
            echo '<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-check text-success" aria-hidden="true"></i> &nbsp;Mengaktifkan Data Staff</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span class="fw-normal" >Anda yakin ingin mengaktifkan</span>
                            <span class="fw-bold" >' . $row->StaffCode . ' - ' . $row->StaffName . '</span>
                            <span class="fw-normal" >?</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn-submit" >Setuju</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                var req_status_add = 0;
                $(function() { 
                    $("form[name=\'form-action\']").validate({
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_staff_enable/") . $id . '",
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Mengaktifkan data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Mengaktifkan data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>';
        }
    }

    /*
    *       MODAL Data Produk CATEGORY
    */
    function data_item_category_add()
    {
        echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered ">
                <form class="modal-content" name="form-action">
                    <div class="modal-header bg-dark">
                        <h6 class="modal-title text-white"><i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;Tambah Data Produk Kategori</h5>
                        <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div  class="row justify-content-center">
                            <div class="col-10">
                                <div class="row mb-1 align-items-center">
                                    <label for="MsItemCatIsActive" class="col-sm-3 col-form-label">Status<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-switch">
                                            <input id="MsItemCatIsActive" name="MsItemCatIsActive" class="form-check-input" type="checkbox" checked>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsItemCatCode" class="col-sm-3 col-form-label">Kode<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <input id="MsItemCatCode" name="MsItemCatCode" type="text" class="form-control form-control-sm" value="">
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsItemCatName" class="col-sm-3 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <input id="MsItemCatName" name="MsItemCatName" type="text" class="form-control form-control-sm" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"   id="btn-submit"        >Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
        
        <script>
            var req_status_add = 0;
            var datesCollection = document.getElementsByClassName("input-phone");
            var phones = Array.from(datesCollection);

            phones.forEach(function (phone) {
                new Cleave(phone, {
                    phone: true,
                    phoneRegionCode: "ID"
                })
            });
            
            $(function() { 
                $("form[name=\'form-action\']").validate({
                    rules: {
                        MsItemCatCode: {
                            "required": true,
                            "remote": "' . site_url("function/client_data_master/validate_kode_item_category") . '",
                        },
                        MsItemCatName: "required",
                    },
                    messages: {
                        MsItemCatCode: { 
                            required: "Masukan kode Item Kategori",
                            remote: "Kode Item Kategori sudah ada"
                        },
                        MsItemCatName: "Masukan Nama Item Kategori",
                    },
                    submitHandler: function(form) {
                        if(!req_status_add){
                            $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                            $.ajax({
                                method: "POST",
                                url: "' . site_url("function/client_data_master/data_item_category_add") . '",
                                data: $("form[name=\'form-action\']").serialize(),
                                before: function(){ 
                                    req_status_add = 1;
                                },
                                success: function(data) {
                                    req_status_add = 0;
                                    $("#btn-submit").html("Simpan");
                                    
                                    if(data){
                                        Swal.fire({
                                            icon: \'success\',
                                            text: \'Tambah data berhasil\',
                                            showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                            timer: 1500,
                                        }).then((result) => {
                                            if (result.dismiss === Swal.DismissReason.timer) {
                                                load_data_table();
                                            }
                                        });
                                    }else{
                                        Swal.fire({
                                            icon: \'error\',
                                            text: \'Tambah data gagal\',
                                            showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                            timer: 1500
                                        });
                                    }
                                }
                            });
                            return false;
                        }
                    }
                });
            });
        </script>';
    }
    function data_item_category_view($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsItemCategory where MsItemCatId=" . $id);
        foreach ($query->result() as $row) {
            echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered ">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-eye text-info" aria-hidden="true"></i> &nbsp;Detail Data Produk Kategori</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div  class="row justify-content-center">
                                <div class="col-10">
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsItemCatIsActive" class="col-sm-3 col-form-label">Status<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <div class="form-check form-switch">
                                                <input id="MsItemCatIsActive" name="MsItemCatIsActive" class="form-check-input" type="checkbox" ' . ($row->MsItemCatIsActive == 1 ? "checked" : "") . ' disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsItemCatCode" class="col-sm-3 col-form-label">Kode<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <input id="MsItemCatCode" name="MsItemCatCode" type="text" class="form-control form-control-sm" value="' . $row->MsItemCatCode . '" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsItemCatName" class="col-sm-3 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <input id="MsItemCatName" name="MsItemCatName" type="text" class="form-control form-control-sm" value="' . $row->MsItemCatName . '" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
            ';
        }
    }
    function data_item_category_edit($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsItemCategory where MsItemCatId=" . $id);
        foreach ($query->result() as $row) {
            echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered ">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp; Edit Data Produk Kategori</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div  class="row justify-content-center">
                                <div class="col-10">
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsItemCatIsActive" class="col-sm-3 col-form-label">Status<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <div class="form-check form-switch">
                                                <input id="MsItemCatIsActive" name="MsItemCatIsActive" class="form-check-input" type="checkbox" ' . ($row->MsItemCatIsActive == 1 ? "checked" : "") . '>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsItemCatCode" class="col-sm-3 col-form-label">Kode<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <input id="MsItemCatCode" name="MsItemCatCode" type="text" class="form-control form-control-sm" value="' . $row->MsItemCatCode . '">
                                        </div>
                                    </div>
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsItemCatName" class="col-sm-3 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <input id="MsItemCatName" name="MsItemCatName" type="text" class="form-control form-control-sm" value="' . $row->MsItemCatName . '">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success"   id="btn-submit"        >Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <script>
                var req_status_add = 0;
                var datesCollection = document.getElementsByClassName("input-phone");
                var phones = Array.from(datesCollection);

                phones.forEach(function (phone) {
                    new Cleave(phone, {
                        phone: true,
                        phoneRegionCode: "ID"
                    })
                });
                
                $(function() { 
                    $("form[name=\'form-action\']").validate({
                        rules: {
                            MsItemCatCode: {
                                "required": true,
                                "remote": "' . site_url("function/client_data_master/validate_kode_item_category/") . $row->MsItemCatCode . '",
                            },
                            MsItemCatName: "required",
                        },
                        messages: {
                            MsItemCatCode: { 
                                required: "Masukan kode Item Kategori",
                                remote: "Kode Item Kategori sudah ada"
                            },
                            MsItemCatName: "Masukan Nama Item Kategori",
                        },
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_item_category_edit/") . $id . '",
                                    data: $("form[name=\'form-action\']").serialize(),
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Edit data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Tambah data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>
            ';
        }
    }
    function data_item_category_delete($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsItemCategory where MsItemCatId=" . $id)->result();
        foreach ($query as $row) {
            echo '<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-ban text-danger" aria-hidden="true"></i> &nbsp;Nonaktifkan Data Produk Kategori</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span class="fw-normal" >Anda yakin ingin menonaktifkan</span>
                            <span class="fw-bold" >' . $row->MsItemCatCode . ' - ' . $row->MsItemCatName . '</span>
                            <span class="fw-normal" >?</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn-submit" >Setuju</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                var req_status_add = 0;
                $(function() { 
                    $("form[name=\'form-action\']").validate({
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_item_category_delete/") . $id . '",
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Nonaktifkan data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Nonaktifkan data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>';
        }
    }
    function data_item_category_enable($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsItemCategory where MsItemCatId=" . $id)->result();
        foreach ($query as $row) {
            echo '<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-check text-success" aria-hidden="true"></i> &nbsp;Mengaktifkan Data Produk Kategori</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span class="fw-normal" >Anda yakin ingin mengaktifkan</span>
                            <span class="fw-bold" >' . $row->MsItemCatCode . ' - ' . $row->MsItemCatName . '</span>
                            <span class="fw-normal" >?</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn-submit" >Setuju</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                var req_status_add = 0;
                $(function() { 
                    $("form[name=\'form-action\']").validate({
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_item_category_enable/") . $id . '",
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Mengaktifkan data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Mengaktifkan data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>';
        }
    }

    /*
    *       MODAL Data Produk MASTER
    */
    function data_item_master_add()
    { 
        $data["satuan"] = $this->db->get("TblMsProdukSatuan")->result();
        $data["berat"]= $this->db->get("TblMsProdukBerat")->result();
        $data["category"]= $this->db->get("TblMsProdukCategory")->result();
        echo $this->load->view('message/master/item_add', $data, TRUE);
    }
    function data_item_master_view($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsItem where MsItemId=" . $id)->result();
        $query = $query[0];
        echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg modal-dialog-centered ">
                <form class="modal-content" name="form-action">
                    <div class="modal-header bg-dark">
                        <h6 class="modal-title text-white"><i class="fas fa-eye text-info" aria-hidden="true"></i> &nbsp;Detail Data Produk Master</h5>
                        <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <div class="col-lg-6 col-11 my-1">
                                <div class="row mb-1 align-items-center">
                                    <label for="MsItemIsActive" class="col-sm-4 col-form-label">Status Item<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-8">
                                        <div class="form-check form-switch">
                                            <input id="MsItemIsActive" name="MsItemIsActive" class="form-check-input" type="checkbox" ' . ($query->MsItemIsActive == 1 ? 'checked' : '') . ' disabled>
                                            <label class="col-form-label label-check-enable" for="MsItemIsActive" style="display: ' . ($query->MsItemIsActive == 1 ? 'inline' : 'none') . ';">Aktif</label>
                                            <label class="col-form-label label-check-disable" for="MsItemIsActive" style="display: ' . ($query->MsItemIsActive == 0 ? 'inline' : 'none') . ';">Tidak Aktif</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsItemSales" class="col-sm-4 col-form-label">Status Jual<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-8">
                                        <div class="form-check form-switch">
                                            <input id="MsItemSales" name="MsItemSales" class="form-check-input" type="checkbox" ' . ($query->MsItemSales == 1 ? 'checked' : '') . ' disabled>
                                            <label class="col-form-label label-check-enable" for="MsItemSales" style="display: ' . ($query->MsItemSales == 1 ? 'inline' : 'none') . ';">Aktif</label>
                                            <label class="col-form-label label-check-disable" for="MsItemSales" style="display: ' . ($query->MsItemSales == 0 ? 'inline' : 'none') . ';">Tidak Aktif</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsItemCatId" class="col-sm-4 col-form-label">Kategori</label>
                                    <div class="col-sm-8">
                                        <select class="custom-select custom-select-sm form-control form-control-sm select-modal" id="MsItemCatId" name="MsItemCatId" style="width:100%" disabled>';
        $db = $this->db->get("TblMsItemCategory")->result();
        foreach ($db as $key) {
            if ($query->MsItemCatId == $key->MsItemCatId) {
                echo '<option value="' . $key->MsItemCatId . '" data-kode="' . $key->MsItemCatCode . '" selected>' . $key->MsItemCatCode . ' - ' . $key->MsItemCatName . '</option>';
            } else {
                echo '<option value="' . $key->MsItemCatId . '" data-kode="' . $key->MsItemCatCode . '">' . $key->MsItemCatCode . ' - ' . $key->MsItemCatName . '</option>';
            }
        }
        echo '
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsItemCode" class="col-sm-4 col-form-label">Kode<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-8">
                                        <input id="MsItemCode" name="MsItemCode" type="text" class="form-control form-control-sm" value="' . $query->MsItemCode . '" readonly>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsItemName" class="col-sm-4 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-8">
                                        <input id="MsItemName" name="MsItemName" type="text" class="form-control form-control-sm" value="' . $query->MsItemName . '" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-11 my-1">
                                <div class="row mb-1 align-items-center">
                                    <div class="label-border-right">
                                        <span class="label-dialog">Deskripsi Item</span>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsItemSize" class="col-sm-3 col-form-label">Ukuran</label>
                                    <div class="col-sm-9">
                                        <input id="MsItemSize" name="MsItemSize" type="text" class="form-control form-control-sm" value="' . $query->MsItemSize . '" placeholder="20 x 20 x 10cm" readonly>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsItemWeight" class="col-sm-3 col-form-label">Berat</label>
                                    <div class="col-sm-4">
                                        <input id="MsItemWeight" name="MsItemWeight" type="text" class="form-control form-control-sm double" value="' . $query->MsItemWeight . '" placeholder="0.00" readonly>
                                    </div>
                                    <label for="MsItemUoM" class="col-sm-2 pe-sm-0 col-form-label">Satuan</label>
                                    <div class="col-sm-3">
                                        <input id="MsItemUoM" name="MsItemUoM" type="text" class="form-control form-control-sm" value="' . $query->MsItemUoM . '" placeholder="PCS" readonly>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsItemPcsM2" class="col-sm-3 col-form-label">Pcs/M2</label>
                                    <div class="col-sm-4">
                                        <input id="MsItemPcsM2" name="MsItemPcsM2" type="text" class="form-control form-control-sm" value="' . $query->MsItemPcsM2 . '" placeholder="25 Pcs" readonly>
                                    </div>
                                    <label for="MsItemPcs" class="col-sm-2 pe-sm-0 col-form-label">Konversi</label>
                                    <div class="col-sm-3">
                                        <input id="MsItemPcs" name="MsItemPcs" type="text" class="form-control form-control-sm price" value="' . $query->MsItemPcs . '" placeholder="0" readonly>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsItemPrice" class="col-sm-3 col-form-label">Harga Jual</label>
                                    <div class="col-sm-9">
                                        <input id="MsItemPrice" name="MsItemPrice" type="text" class="form-control form-control-sm price" value="' . $query->MsItemPrice . '" placeholder="0" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 my-lg-0 col-11 my-1">
                                <div class="row mb-1 align-items-center">
                                    <div class="label-border-right">
                                        <span class="label-dialog">Stock</span>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsItemVendor" class="col-sm-2 col-form-label">Vendor</label>
                                    <div class="col-sm-10">
                                        <select class="custom-select custom-select-sm form-control form-control-sm select-modal" id="MsItemVendor" name="MsItemVendor" style="width:100%" multiple="multiple" disabled>';
        $db = $this->db->get("TblMsVendor")->result();
        foreach ($db as $key) {
            echo '<option value="' . $key->MsVendorCode . '">' . $key->MsVendorCode . ' - ' . $key->MsVendorName . '</option>';
        }
        echo '
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div> 
        <script>
            var req_status_add = 0;
            var checkArrays = Array.from(document.getElementsByClassName("form-check-input"));
            
            checkArrays.forEach(function (checkArray) {
                $(checkArray).change(function() {
                    var mom = $(this).parents().eq(0); 
                    $(mom).children(".label-check-enable").hide();
                    $(mom).children(".label-check-disable").hide();
                    if(this.checked) {
                        $(mom).children(".label-check-enable").show();
                    }else{
                        $(mom).children(".label-check-disable").show();
                    }
                });
            });
            $("#MsItemCatId").on("change",function(){
                $.ajax({
                    method: "POST",
                    url: "' . site_url("function/client_data_master/next_kode_item_master") . '",
                    data : {
                        "MsItemCatId": $("#MsItemCatId").val(),
                        "MsItemCatCode": $("#MsItemCatId").find(":selected").data("kode"),
                    },
                    success: function(data) {
                        $("#MsItemCode").val(data);
                    }
                });
            });
            $(".select-modal").select2({
                dropdownParent: $("#modal-action .modal-content")
            });

            var doubleinputs = Array.from(document.getElementsByClassName("double"));
            doubleinputs.forEach(function (doubleinput) {
                new Cleave(doubleinput, {
                    numeral: true,
                    numeralDecimalMark: ".",
                    delimiter:          ","
                })
            });

            var priceinputs = Array.from(document.getElementsByClassName("price"));
            priceinputs.forEach(function (priceinput) {
                new Cleave(priceinput, {
                    numeral: true,
                    delimiter:          ",",
                    numeralDecimalScale: 0,
                    numeralThousandsGroupStyle: "thousand"
                })
            });
            var vendorold = ("' . $query->MsItemVendor . '").split(";");
            console.log(vendorold);
            $("#MsItemVendor").val(vendorold);
            $("#MsItemVendor").trigger("change");
        </script>
        ';
    }
    function data_item_master_edit($id)
    { 
        try{
            $configfile = getcwd() . "/asset/image/produk/".$id; 
            $myfiles = array_diff(scandir($configfile), array('.', '..'));  
        }catch(Exception $e) {
            $myfiles = array();
        }
        
        $dataimage = array();
        foreach($myfiles as $file){ 
            $dataimage[] = 'data:image/png;base64,' . base64_encode(file_get_contents(getcwd() . "/asset/image/produk/".$id."/".$file));
        } 
        $data["satuan"] = $this->db->get("TblMsProdukSatuan")->result();
        $data["berat"]= $this->db->get("TblMsProdukBerat")->result();
        $data["produk"]= $this->db->where("MsProdukId",$id)->get("TblMsProduk")->row();
        $var =  json_decode($data["produk"]->MsProdukVarian);
        $varian = array();
        foreach($var as $key=>$value)
        {
            $value_varian = array();
            foreach($value as $val){ 
            }
            $arr = array(
                "varian" => $key,
                "html" => '<div class="row row-table get-item my-2">
                                <div class="col-12 col-md-3">
                                    <select class="custom-select custom-select-sm form-select form-select-sm selectvarian" placeholder="pilih varian" style="width:100%" disabled>
                                        <option value="1" select>Vendor</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-8">
                                    <select class="custom-select custom-select-sm form-control form-control-sm selectvarianvalue" style="width:100%" multiple="multiple" data-type="Vendor" required></select>
                                </div>

                                <div class="col-auto px-0">
                                    <span class="badge text-bg-secondary">Default</span>
                                </div>
                            </div>',
                "value" => $key, 
            ); 
            array_push($varian,$arr); 
        } 
        $data["varian"] = $varian;



        $data["produkdetail"]= $this->db->where("MsProdukDetailRef",$id)->get("TblMsProdukDetail")->result();
        $data["produkimage"]=$dataimage;
        echo $this->load->view('message/master/item_edit', $data, TRUE);
    }
    function data_item_master_disable_jual($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsItem where MsItemId=" . $id)->result();
        foreach ($query as $row) {
            echo '<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-ban text-danger" aria-hidden="true"></i> &nbsp;Nonaktifkan Data Produk Jual</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span class="fw-normal" >jika dinonaktifkan Item </span>
                            <span class="fw-bold" >' . $row->MsItemCode . ' - ' . $row->MsItemName . ' </span>
                            <span class="fw-normal" >tidak akan terlihat di list item penjualan, Anda yakin ingin menonaktifkan penjualan item ini?</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn-submit" >Setuju</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                var req_status_add = 0;
                $(function() { 
                    $("form[name=\'form-action\']").validate({
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_item_master_disable_jual/") . $id . '",
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Nonaktifkan data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Nonaktifkan data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>';
        }
    }
    function data_item_master_enable_jual($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsItem where MsItemId=" . $id)->result();
        foreach ($query as $row) {
            echo '<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-check text-success" aria-hidden="true"></i> &nbsp;Mengaktifkan Data Produk Jual</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span class="fw-normal" >jika diaktifkan Item </span>
                            <span class="fw-bold" >' . $row->MsItemCode . ' - ' . $row->MsItemName . ' </span>
                            <span class="fw-normal" >akan terlihat di list item penjualan, Anda yakin ingin mengaktifkan penjualan item ini?</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn-submit" >Setuju</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                var req_status_add = 0;
                $(function() { 
                    $("form[name=\'form-action\']").validate({
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_item_master_enable_jual/") . $id . '",
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Nonaktifkan data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Nonaktifkan data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>';
        }
    }
    function data_item_master_disable($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsItem where MsItemId=" . $id)->result();
        foreach ($query as $row) {
            echo '<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-ban text-danger" aria-hidden="true"></i> &nbsp;Nonaktifkan Data Item</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span class="fw-normal" >Anda yakin ingin menonaktifkan</span>
                            <span class="fw-bold" >' . $row->MsItemCode . ' - ' . $row->MsItemName . '</span>
                            <span class="fw-normal" >?</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn-submit" >Setuju</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                var req_status_add = 0;
                $(function() { 
                    $("form[name=\'form-action\']").validate({
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_item_master_disable/") . $id . '",
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Nonaktifkan data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Nonaktifkan data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>';
        }
    }
    function data_item_master_enable($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsItem where MsItemId=" . $id)->result();
        foreach ($query as $row) {
            echo '<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-check text-success" aria-hidden="true"></i> &nbsp;Mengaktifkan Data Item</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span class="fw-normal" >Anda yakin ingin mengaktifkan</span>
                            <span class="fw-bold" >' . $row->MsItemCode . ' - ' . $row->MsItemName . '</span>
                            <span class="fw-normal" >?</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn-submit" >Setuju</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                var req_status_add = 0;
                $(function() { 
                    $("form[name=\'form-action\']").validate({
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_item_master_enable/") . $id . '",
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Nonaktifkan data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Nonaktifkan data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>';
        }
    }
    

    function data_item_master_select()
    { 
        echo $this->load->view('message/master/master_select', null, TRUE);
    }
    /*
    *       MODAL Data Produk LISTING
    */
    function data_item_listing_disable($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsItem left join TblInvStock on TblMsItem.MsItemId=TblInvStock.MsItemId where InvStockId=" . $id)->result();
        foreach ($query as $row) {
            echo '<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-ban text-danger" aria-hidden="true"></i> &nbsp;Nonaktifkan Data Produk Listing</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span class="fw-normal" >Anda yakin ingin menonaktifkan</span>
                            <span class="fw-bold" >' . $row->MsItemCode . ' - ' . $row->MsItemName . '</span>
                            <span class="fw-normal" >?</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn-submit" >Setuju</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                var req_status_add = 0;
                $(function() { 
                    $("form[name=\'form-action\']").validate({
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_item_listing_disable/") . $id . '",
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Nonaktifkan data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Nonaktifkan data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>';
        }
    }
    function data_item_listing_enable($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsItem left join TblInvStock on TblMsItem.MsItemId=TblInvStock.MsItemId where InvStockId=" . $id)->result();
        foreach ($query as $row) {
            echo '<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-check text-success" aria-hidden="true"></i> &nbsp;Mengaktifkan Data Item</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span class="fw-normal" >Anda yakin ingin mengaktifkan</span>
                            <span class="fw-bold" >' . $row->MsItemCode . ' - ' . $row->MsItemName . '</span>
                            <span class="fw-normal" >?</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn-submit" >Setuju</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                var req_status_add = 0;
                $(function() { 
                    $("form[name=\'form-action\']").validate({
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_item_listing_enable/") . $id . '",
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Nonaktifkan data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Nonaktifkan data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>';
        }
    }

    /*
    *       MODAL DATA VENDOR
    */
    function data_vendor_add()
    {
        echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered ">
                <form class="modal-content" name="form-action">
                    <div class="modal-header bg-dark">
                        <h6 class="modal-title text-white"><i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;Tambah Data Vendor</h5>
                        <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div  class="row justify-content-center">
                            <div class="col-10">
                                <div class="row mb-1 align-items-center">
                                    <label for="MsVendorIsActive" class="col-sm-3 col-form-label">Status<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-switch">
                                            <input id="MsVendorIsActive" name="MsVendorIsActive" class="form-check-input" type="checkbox" checked>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsVendorCode" class="col-sm-3 col-form-label">Kode<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <input id="MsVendorCode" name="MsVendorCode" type="text" class="form-control form-control-sm" value="">
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsVendorName" class="col-sm-3 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <input id="MsVendorName" name="MsVendorName" type="text" class="form-control form-control-sm" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"   id="btn-submit"        >Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
        
        <script>
            var req_status_add = 0;
            var datesCollection = document.getElementsByClassName("input-phone");
            var phones = Array.from(datesCollection);

            phones.forEach(function (phone) {
                new Cleave(phone, {
                    phone: true,
                    phoneRegionCode: "ID"
                })
            });
            
            $(function() { 
                $("form[name=\'form-action\']").validate({
                    rules: {
                        MsVendorCode: {
                            "required": true,
                            "remote": "' . site_url("function/client_data_master/validate_kode_vendor") . '",
                        },
                        MsVendorName: "required",
                    },
                    messages: {
                        MsVendorCode: { 
                            required: "Masukan kode Vendor",
                            remote: "Kode Vendor sudah ada"
                        },
                        MsVendorName: "Masukan Nama Vendor",
                    },
                    submitHandler: function(form) {
                        if(!req_status_add){
                            $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                            $.ajax({
                                method: "POST",
                                url: "' . site_url("function/client_data_master/data_vendor_add") . '",
                                data: $("form[name=\'form-action\']").serialize(),
                                before: function(){ 
                                    req_status_add = 1;
                                },
                                success: function(data) {
                                    req_status_add = 0;
                                    $("#btn-submit").html("Simpan");
                                    
                                    if(data){
                                        Swal.fire({
                                            icon: \'success\',
                                            text: \'Tambah data berhasil\',
                                            showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                            timer: 1500,
                                        }).then((result) => {
                                            if (result.dismiss === Swal.DismissReason.timer) {
                                                load_data_table();
                                            }
                                        });
                                    }else{
                                        Swal.fire({
                                            icon: \'error\',
                                            text: \'Tambah data gagal\',
                                            showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                            timer: 1500
                                        });
                                    }
                                }
                            });
                            return false;
                        }
                    }
                });
            });
        </script>';
    }
    function data_vendor_view($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsVendor where MsVendorId=" . $id);
        foreach ($query->result() as $row) {
            echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered ">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-eye text-info" aria-hidden="true"></i> &nbsp;Detail Data Vendor</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div  class="row justify-content-center">
                                <div class="col-10">
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsVendorIsActive" class="col-sm-3 col-form-label">Status<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <div class="form-check form-switch">
                                                <input id="MsVendorIsActive" name="MsVendorIsActive" class="form-check-input" type="checkbox" ' . ($row->MsVendorIsActive == 1 ? "checked" : "") . ' disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsVendorCode" class="col-sm-3 col-form-label">Kode<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <input id="MsVendorCode" name="MsVendorCode" type="text" class="form-control form-control-sm" value="' . $row->MsVendorCode . '" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsVendorName" class="col-sm-3 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <input id="MsVendorName" name="MsVendorName" type="text" class="form-control form-control-sm" value="' . $row->MsVendorName . '" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
            ';
        }
    }
    function data_vendor_edit($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsVendor where MsVendorId=" . $id);
        foreach ($query->result() as $row) {
            echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered ">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp; Edit Data Vendor</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div  class="row justify-content-center">
                                <div class="col-10">
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsVendorIsActive" class="col-sm-3 col-form-label">Status<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <div class="form-check form-switch">
                                                <input id="MsVendorIsActive" name="MsVendorIsActive" class="form-check-input" type="checkbox" ' . ($row->MsVendorIsActive == 1 ? "checked" : "") . '>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsVendorCode" class="col-sm-3 col-form-label">Kode<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <input id="MsVendorCode" name="MsVendorCode" type="text" class="form-control form-control-sm" value="' . $row->MsVendorCode . '">
                                        </div>
                                    </div>
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsVendorName" class="col-sm-3 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <input id="MsVendorName" name="MsVendorName" type="text" class="form-control form-control-sm" value="' . $row->MsVendorName . '">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success"   id="btn-submit"        >Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <script>
                var req_status_add = 0;
                var datesCollection = document.getElementsByClassName("input-phone");
                var phones = Array.from(datesCollection);

                phones.forEach(function (phone) {
                    new Cleave(phone, {
                        phone: true,
                        phoneRegionCode: "ID"
                    })
                });
                
                $(function() { 
                    $("form[name=\'form-action\']").validate({
                        rules: {
                            MsVendorCode: {
                                "required": true,
                                "remote": "' . site_url("function/client_data_master/validate_kode_vendor/") . $row->MsVendorCode . '",
                            },
                            MsVendorName: "required",
                        },
                        messages: {
                            MsVendorCode: { 
                                required: "Masukan kode Vendor",
                                remote: "Kode Vendor sudah ada"
                            },
                            MsVendorName: "Masukan Nama Vendor",
                        },
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_vendor_edit/") . $id . '",
                                    data: $("form[name=\'form-action\']").serialize(),
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Edit data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Tambah data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>
            ';
        }
    }
    function data_vendor_delete($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsVendor where MsVendorId=" . $id)->result();
        foreach ($query as $row) {
            echo '<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-ban text-danger" aria-hidden="true"></i> &nbsp;Nonaktifkan Data Vendor</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span class="fw-normal" >Anda yakin ingin menonaktifkan</span>
                            <span class="fw-bold" >' . $row->MsVendorCode . ' - ' . $row->MsVendorName . '</span>
                            <span class="fw-normal" >?</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn-submit" >Setuju</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                var req_status_add = 0;
                $(function() { 
                    $("form[name=\'form-action\']").validate({
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_vendor_delete/") . $id . '",
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Nonaktifkan data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Nonaktifkan data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>';
        }
    }
    function data_vendor_enable($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsVendor where MsVendorId=" . $id)->result();
        foreach ($query as $row) {
            echo '<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-check text-success" aria-hidden="true"></i> &nbsp;Mengaktifkan Data Vendor</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span class="fw-normal" >Anda yakin ingin mengaktifkan</span>
                            <span class="fw-bold" >' . $row->MsVendorCode . ' - ' . $row->MsVendorName . '</span>
                            <span class="fw-normal" >?</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn-submit" >Setuju</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                var req_status_add = 0;
                $(function() { 
                    $("form[name=\'form-action\']").validate({
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_vendor_enable/") . $id . '",
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Mengaktifkan data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Mengaktifkan data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>';
        }
    }

    /*
    *       MODAL DATA CUSTOMER TIPE
    */
    function data_customer_type_add()
    {
        echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered ">
                <form class="modal-content" name="form-action">
                    <div class="modal-header bg-dark">
                        <h6 class="modal-title text-white"><i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;Tambah Data Tipe Pelanggan</h5>
                        <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div  class="row justify-content-center">
                            <div class="col-10">
                                <div class="row mb-1 align-items-center">
                                    <label for="MsDeliveryIsActive" class="col-sm-3 col-form-label">Status<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-switch">
                                            <input id="MsCustomerTypeIsActive" name="MsCustomerTypeIsActive" class="form-check-input" type="checkbox" checked>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsCustomerTypeName" class="col-sm-3 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <input id="MsCustomerTypeName" name="MsCustomerTypeName" type="text" class="form-control form-control-sm" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"   id="btn-submit"        >Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
        
        <script>
            var req_status_add = 0;
            var datesCollection = document.getElementsByClassName("input-phone");
            var phones = Array.from(datesCollection);

            phones.forEach(function (phone) {
                new Cleave(phone, {
                    phone: true,
                    phoneRegionCode: "ID"
                })
            });
            
            $(function() { 
                $("form[name=\'form-action\']").validate({
                    rules: {
                        MsCustomerTypeName: {
                            "required": true,
                            "remote": "' . site_url("function/client_data_master/validate_kode_customer_type") . '",
                        },
                    },
                    messages: {
                        MsCustomerTypeName: { 
                            required: "Masukan Nama Tipe Pelanggan",
                            remote: "Nama Tipe Pelanggan sudah ada"
                        },
                    },
                    submitHandler: function(form) {
                        if(!req_status_add){
                            $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                            $.ajax({
                                method: "POST",
                                url: "' . site_url("function/client_data_master/data_customer_type_add") . '",
                                data: $("form[name=\'form-action\']").serialize(),
                                before: function(){ 
                                    req_status_add = 1;
                                },
                                success: function(data) {
                                    req_status_add = 0;
                                    $("#btn-submit").html("Simpan");
                                    
                                    if(data){
                                        Swal.fire({
                                            icon: \'success\',
                                            text: \'Tambah data berhasil\',
                                            showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                            timer: 1500,
                                        }).then((result) => {
                                            if (result.dismiss === Swal.DismissReason.timer) {
                                                load_data_table();
                                            }
                                        });
                                    }else{
                                        Swal.fire({
                                            icon: \'error\',
                                            text: \'Tambah data gagal\',
                                            showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                            timer: 1500
                                        });
                                    }
                                }
                            });
                            return false;
                        }
                    }
                });
            });
        </script>';
    }
    function data_customer_type_view($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsCustomerType where MsCustomerTypeId=" . $id);
        foreach ($query->result() as $row) {
            echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered ">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-eye text-info" aria-hidden="true"></i> &nbsp;Detail Data Tipe Pelanggan</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div  class="row justify-content-center">
                                <div class="col-10">
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsCustomerTypeIsActive" class="col-sm-3 col-form-label">Status<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <div class="form-check form-switch">
                                                <input id="MsCustomerTypeIsActive" name="MsCustomerTypeIsActive" class="form-check-input" type="checkbox" ' . ($row->MsCustomerTypeIsActive == 1 ? "checked" : "") . ' disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsCustomerTypeName" class="col-sm-3 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <input id="MsCustomerTypeName" name="MsCustomerTypeName" type="text" class="form-control form-control-sm" value="' . $row->MsCustomerTypeName . '" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
            ';
        }
    }
    function data_customer_type_edit($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsCustomerType where MsCustomerTypeId=" . $id);
        foreach ($query->result() as $row) {
            echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered ">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp; Edit Data Tipe Pelanggan</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div  class="row justify-content-center">
                                <div class="col-10">
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsCustomerTypeIsActive" class="col-sm-3 col-form-label">Status<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <div class="form-check form-switch">
                                                <input id="MsCustomerTypeIsActive" name="MsCustomerTypeIsActive" class="form-check-input" type="checkbox" ' . ($row->MsCustomerTypeIsActive == 1 ? "checked" : "") . '>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsCustomerTypeName" class="col-sm-3 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <input id="MsCustomerTypeName" name="MsCustomerTypeName" type="text" class="form-control form-control-sm" value="' . $row->MsCustomerTypeName . '">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success"   id="btn-submit"        >Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <script>
                var req_status_add = 0;
                var datesCollection = document.getElementsByClassName("input-phone");
                var phones = Array.from(datesCollection);

                phones.forEach(function (phone) {
                    new Cleave(phone, {
                        phone: true,
                        phoneRegionCode: "ID"
                    })
                });
                
                $(function() { 
                    $("form[name=\'form-action\']").validate({
                        rules: {
                            MsCustomerTypeName: {
                                "required": true,
                                "remote": "' . site_url("function/client_data_master/validate_kode_customer_type/") . $row->MsCustomerTypeName . '",
                            },
                        },
                        messages: {
                            MsCustomerTypeName: { 
                                required: "Masukan kode Tipe Pelanggan",
                                remote: "Kode Tipe Pelanggan sudah ada"
                            },
                        },
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_customer_type_edit/") . $id . '",
                                    data: $("form[name=\'form-action\']").serialize(),
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Edit data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Tambah data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>
            ';
        }
    }
    function data_customer_type_delete($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsCustomerType where MsCustomerTypeId=" . $id)->result();
        foreach ($query as $row) {
            echo '<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-ban text-danger" aria-hidden="true"></i> &nbsp;Nonaktifkan Data Tipe Pelanggan</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span class="fw-normal" >Anda yakin ingin menonaktifkan</span>
                            <span class="fw-bold" >' . $row->MsCustomerTypeName . '</span>
                            <span class="fw-normal" >?</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn-submit" >Setuju</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                var req_status_add = 0;
                $(function() { 
                    $("form[name=\'form-action\']").validate({
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_customer_type_delete/") . $id . '",
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Nonaktifkan data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Nonaktifkan data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>';
        }
    }
    function data_customer_type_enable($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsCustomerType where MsCustomerTypeId=" . $id)->result();
        foreach ($query as $row) {
            echo '<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-check text-success" aria-hidden="true"></i> &nbsp;Mengaktifkan Data Tipe Pelanggan</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span class="fw-normal" >Anda yakin ingin mengaktifkan</span>
                            <span class="fw-bold" >' . $row->MsCustomerTypeName . '</span>
                            <span class="fw-normal" >?</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn-submit" >Setuju</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                var req_status_add = 0;
                $(function() { 
                    $("form[name=\'form-action\']").validate({
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_customer_type_enable/") . $id . '",
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Mengaktifkan data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Mengaktifkan data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>';
        }
    } 

    /*
    *       MODAL DATA LISTING SYSTEM
    */
    function data_system_listing_add()
    {
        $data["_menu"] = $this->db->order_by("MenuParent asc")->get("TblMenuObi")->result();
        echo $this->load->view('message/master/listingsystem_add', $data, TRUE);
    }
    function data_system_listing_edit($id)
    {
        $data["_listing"] = $this->db->where("MenuListingId",$id)->get("TblMenuListing")->row();
        $data["_listingdetail"] = $this->db->where("MenuListingId",$data["_listing"]->MenuListingId)->get("TblMenuListingDetail")->result();
        $data["_menu"] = $this->db->order_by("MenuParent asc")->get("TblMenuObi")->result();
        echo $this->load->view('message/master/listingsystem_edit', $data, TRUE);
    }
    /*
    *       MODAL DATA CUSTOMER
    */
    function data_customer_add()
    {
        $data["_code"] = $this->model_app->get_next_id_customer();
        echo $this->load->view('message/master/customer_add', $data, TRUE);
    }
    function data_customer_view($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsCustomer as a left join TblMsCustomerType as b on a.MsCustomerTypeId=b.MsCustomerTypeId where MsCustomerId=" . $id)->result();
        $query1 = $this->db->query("SELECT * FROM TblMsCustomerDelivery where MsCustomerId=" . $id)->result();
        foreach ($query as $row) {
            echo '
            <div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-lg modal-dialog-centered ">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-eye text-info" aria-hidden="true"></i> &nbspDetail Data Pelanggan</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row justify-content-center">
                                <div class="col-lg-6 col-11 my-1">
                                    <div  class="row justify-content-center">
                                        <div class="col-12">
                                            <div class="row mb-1 align-items-center">
                                                <label for="MsCustomerIsActive" class="col-sm-2 col-form-label">Status<sup class="error">&nbsp;*</sup></label>
                                                <div class="col-sm-10">
                                                    <div class="form-check form-switch">
                                                        <input id="MsCustomerIsActive" name="MsCustomerIsActive" class="form-check-input" type="checkbox" ' . ($row->MsCustomerIsActive == 1 ? "checked" : "") . ' disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-1 align-items-center">
                                                <label for="MsCustomerCode" class="col-sm-2 col-form-label">Kode<sup class="error">&nbsp;*</sup></label>
                                                <div class="col-sm-10">
                                                    <input id="MsCustomerCode" name="MsCustomerCode" type="text" class="form-control form-control-sm" value="' . $row->MsCustomerCode . '" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-1 align-items-center">
                                                <div class="label-border-right">
                                                    <span class="label-dialog">Tipe Pelanggan</span>
                                                </div>
                                            </div>
                                            <div class="row mb-1 align-items-center">
                                                <label for="MsCustomerTypeId" class="col-sm-2 col-form-label">Kategori<sup class="error">&nbsp;*</sup></label>
                                                <div class="col-sm-5 col-5  pe-0">
                                                    <div class="input-group">
                                                        <select class="custom-select custom-select-sm form-select form-select-sm" id="MsCustomerTypeId" name="MsCustomerTypeId" disabled>
                                                            <option value="1" selected="selected">' . $row->MsCustomerTypeName . '</option>
                                                        </select>    
                                                    </div>
                                                </div>
                                                <div class="col-sm-5 col-7">
                                                    <input id="MsCustomerCompany" name="MsCustomerCompany" type="text" class="form-control form-control-sm" value="' . $row->MsCustomerCompany . '" readonly placeholder="isi nama perusahaan">
                                                </div>
                                            </div>
                                            <div class="row mb-1 align-items-center">
                                                <label for="MsCustomerRemarks" class="col-sm-2 col-form-label">Note</label>
                                                <div class="col-sm-10">
                                                    <input id="MsCustomerRemarks" name="MsCustomerRemarks" type="text" class="form-control form-control-sm" value="' . $row->MsCustomerRemarks . '" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-1 align-items-center">
                                                <div class="label-border-right">
                                                    <span class="label-dialog">Personal</span>
                                                </div>
                                            </div>
                                            <div class="row mb-1 align-items-center">
                                                <label for="MsCustomerName" class="col-sm-2 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                                                <div class="col-sm-10">
                                                    <input id="MsCustomerName" name="MsCustomerName" type="text" class="form-control form-control-sm" value="' . $row->MsCustomerName . '" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-1 align-items-center">
                                                <label for="MsCustomerTelp1" class="col-sm-2 col-form-label">Telp.</label>
                                                <div class="col-sm-4 col-5 pe-0">
                                                    <input id="MsCustomerTelp1" name="MsCustomerTelp1" type="text" class="form-control form-control-sm input-phone" value="' . $row->MsCustomerTelp1 . '" readonly>
                                                </div>
                                                <label class="col-sm-2 col-2 col-form-label text-center">/</label>
                                                <div class="col-sm-4 col-5 ps-0">
                                                    <input id="MsCustomerTelp2" name="MsCustomerTelp2" type="text" class="form-control form-control-sm input-phone" value="' . $row->MsCustomerTelp2 . '" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-1 align-items-center">
                                                <label for="MsCustomerFax" class="col-sm-2 col-form-label">Fax.</label>
                                                <div class="col-sm-10">
                                                    <input id="MsCustomerFax" name="MsCustomerFax" type="text" class="form-control form-control-sm" value="' . $row->MsCustomerFax . '" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-1 align-items-center">
                                                <label for="MsCustomerEmail" class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input id="MsCustomerEmail" name="MsCustomerEmail" type="Email" class="form-control form-control-sm" value="' . $row->MsCustomerEmail . '" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-1 align-items-center">
                                                <label for="MsCustomerAddress" class="col-sm-2 col-form-label">Alamat</label>
                                                <div class="col-sm-10">
                                                    <textarea id="MsCustomerAddress" name="MsCustomerAddress" class="form-control form-control-sm" readonly>' . $row->MsCustomerAddress . '</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-11 my-1">
                                    <div  class="row justify-content-center">
                                        <div class="col-12">
                                            <div class="row mb-1 align-items-center">
                                                <div class="label-border-right">
                                                    <span class="label-dialog">Alamat Pengiriman</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="card ">
                                                <div class="card-body p-2 ">
                                                    <div id="data-pengiriman" class="d-flex flex-column mt-1" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                var datadelivery = ' . JSON_ENCODE($query1) . ';
                function load_datadelivery(){
                    var htmldelivery ="";
                    var orderflex = 2;
                    for(var i = 0; datadelivery.length > i; i++){
                        if(datadelivery[i]["MsCustomerDeliveryUtama"]==1){
                            htmldelivery +=      \'<div class="card shadow-sm card-delivery select order-1">\';
                        }else{
                            htmldelivery +=      \'<div class="card shadow-sm card-delivery order-\' + orderflex + \'">\';
                            orderflex++;
                        }
                        htmldelivery +=     \'  <div class="p-2 ps-4">\';
                        htmldelivery +=     \'      <span class="card-title fw-bold">\' + datadelivery[i]["MsCustomerDeliveryReceive"] + (datadelivery[i]["MsCustomerDeliveryUtama"]==1? \'&nbsp;<span class="badge bg-secondary">Utama</span>\' : "") + \'</span><br>\';
                        htmldelivery +=     \'      <span class="card-text">\' + datadelivery[i]["MsCustomerDeliveryTelp"] + \'</span><br>\';
                        htmldelivery +=     \'      <span class="card-text">\' + datadelivery[i]["MsCustomerDeliveryAddress"] + \'</span><br>\';
                        htmldelivery +=     \'      <div class="py-2 d-flex align-items-center text-secondary">\';
                        htmldelivery +=     \'          <i class="fas fa-map-marker-alt fa-2x pe-2"></i>\';
                        htmldelivery +=     \'          <span class="label-small">\' + datadelivery[i]["MsCustomerDeliveryName"] + \'</span>\';
                        htmldelivery +=     \'      </div>\';
                        htmldelivery +=     \'  </div>\';
                        htmldelivery +=     \'</div>\';
                    }
                    $("#data-pengiriman").html(htmldelivery);
                }
                load_datadelivery();
            </script>';
        }
    }
    function data_customer_edit($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsCustomer as a left join TblMsCustomerType as b on a.MsCustomerTypeId=b.MsCustomerTypeId where MsCustomerId=" . $id)->row();
        $query1 = $this->db->query("SELECT * FROM TblMsCustomerDelivery where MsCustomerId=" . $id)->result();

        $data["_customer"] = $query;
        $data["_deliverycustomer"] = $query1;
        echo $this->load->view('message/master/customer_edit', $data, TRUE);
    }
    function data_customer_delete($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsCustomer where MsCustomerId=" . $id)->result();
        foreach ($query as $row) {
            echo '<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-ban text-danger" aria-hidden="true"></i> &nbsp;Nonaktifkan Data Pelanggan</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span class="fw-normal" >Anda yakin ingin menonaktifkan</span>
                            <span class="fw-bold" >' . $row->MsCustomerName . '</span>
                            <span class="fw-normal" >?</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn-submit" >Setuju</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                var req_status_add = 0;
                $(function() { 
                    $("form[name=\'form-action\']").validate({
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_customer_delete/") . $id . '",
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Nonaktifkan data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Nonaktifkan data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>';
        }
    }
    function data_customer_enable($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsCustomer where MsCustomerId=" . $id)->result();
        foreach ($query as $row) {
            echo '<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-check text-success" aria-hidden="true"></i> &nbsp;Mengaktifkan Data Pelanggan</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span class="fw-normal" >Anda yakin ingin mengaktifkan</span>
                            <span class="fw-bold" >' . $row->MsCustomerName . '</span>
                            <span class="fw-normal" >?</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn-submit" >Setuju</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                var req_status_add = 0;
                $(function() { 
                    $("form[name=\'form-action\']").validate({
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_customer_enable/") . $id . '",
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Mengaktifkan data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Mengaktifkan data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>';
        }
    }

    /*
    *       MODAL DATA TIPE PEMBAYARAN
    */
    function data_method_add()
    {
        echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered ">
                <form class="modal-content" name="form-action">
                    <div class="modal-header bg-dark">
                        <h6 class="modal-title text-white"><i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;Tambah Data Tipe Pembayaran</h5>
                        <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div  class="row justify-content-center">
                            <div class="col-10">
                                <div class="row mb-1 align-items-center">
                                    <label for="MsMethodIsActive" class="col-sm-3 col-form-label">Status<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-switch">
                                            <input id="MsMethodIsActive" name="MsMethodIsActive" class="form-check-input" type="checkbox" checked>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsMethodCode" class="col-sm-3 col-form-label">Kode<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <input id="MsMethodCode" name="MsMethodCode" type="text" class="form-control form-control-sm" value="">
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsMethodName" class="col-sm-3 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <input id="MsMethodName" name="MsMethodName" type="text" class="form-control form-control-sm" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"   id="btn-submit"        >Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
        
        <script>
            var req_status_add = 0;
            var datesCollection = document.getElementsByClassName("input-phone");
            var phones = Array.from(datesCollection);

            phones.forEach(function (phone) {
                new Cleave(phone, {
                    phone: true,
                    phoneRegionCode: "ID"
                })
            });
            
            $(function() { 
                $("form[name=\'form-action\']").validate({
                    rules: {
                        MsMethodCode: {
                            "required": true,
                            "remote": "' . site_url("function/client_data_master/validate_kode_method") . '",
                        },
                        MsMethodName: "required",
                    },
                    messages: {
                        MsMethodCode: { 
                            required: "Masukan kode Tipe Pembayaran",
                            remote: "Kode Tipe Pembayaran sudah ada"
                        },
                        MsMethodName: "Masukan Nama Tipe Pembayaran",
                    },
                    submitHandler: function(form) {
                        if(!req_status_add){
                            $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                            $.ajax({
                                method: "POST",
                                url: "' . site_url("function/client_data_master/data_method_add") . '",
                                data: $("form[name=\'form-action\']").serialize(),
                                before: function(){ 
                                    req_status_add = 1;
                                },
                                success: function(data) {
                                    req_status_add = 0;
                                    $("#btn-submit").html("Simpan");
                                    if(data){
                                        Swal.fire({
                                            icon: \'success\',
                                            text: \'Tambah data berhasil\',
                                            showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                            timer: 1500,
                                        }).then((result) => {
                                            if (result.dismiss === Swal.DismissReason.timer) {
                                                load_data_table();
                                            }
                                        });
                                    }else{
                                        Swal.fire({
                                            icon: \'error\',
                                            text: \'Tambah data gagal\',
                                            showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                            timer: 1500
                                        });
                                    }
                                }
                            });
                            return false;
                        }
                    }
                });
            });
        </script>';
    }
    function data_method_view($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsMethod  where MsMethodId=" . $id)->result();
        foreach ($query as $row) {
            echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered ">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-eye text-info" aria-hidden="true"></i> &nbsp;Detail Data Tipe Pembayaran</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div  class="row justify-content-center">
                                <div class="col-10">
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsMethodIsActive" class="col-sm-3 col-form-label">Status<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <div class="form-check form-switch">
                                                <input id="MsMethodIsActive" name="MsMethodIsActive" class="form-check-input" type="checkbox"  ' . ($row->MsMethodIsActive == 1 ? "checked" : "") . ' disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsMethodCode" class="col-sm-3 col-form-label">Kode<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <input id="MsMethodCode" name="MsMethodCode" type="text" class="form-control form-control-sm" value="' . $row->MsMethodCode . '" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsMethodName" class="col-sm-3 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <input id="MsMethodName" name="MsMethodName" type="text" class="form-control form-control-sm" value="' . $row->MsMethodName . '" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>';
        }
    }
    function data_method_edit($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsMethod  where MsMethodId=" . $id)->result();
        foreach ($query as $row) {
            echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered ">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp;Edit Data Tipe Pembayaran</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div  class="row justify-content-center">
                                <div class="col-10">
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsMethodIsActive" class="col-sm-3 col-form-label">Status<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <div class="form-check form-switch">
                                                <input id="MsMethodIsActive" name="MsMethodIsActive" class="form-check-input" type="checkbox"  ' . ($row->MsMethodIsActive == 1 ? "checked" : "") . '>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsMethodCode" class="col-sm-3 col-form-label">Kode<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <input id="MsMethodCode" name="MsMethodCode" type="text" class="form-control form-control-sm" value="' . $row->MsMethodCode . '">
                                        </div>
                                    </div>
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsMethodName" class="col-sm-3 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <input id="MsMethodName" name="MsMethodName" type="text" class="form-control form-control-sm" value="' . $row->MsMethodName . '">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success"   id="btn-submit"        >Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div> 
            
            <script>
                var req_status_add = 0;
                $(function() { 
                    $("form[name=\'form-action\']").validate({
                        rules: {
                            MsMethodCode: {
                                "required": true,
                                "remote": "' . site_url("function/client_data_master/validate_kode_method/") . $row->MsMethodCode . '",
                            },
                            MsMethodName: "required",
                        },
                        messages: {
                            MsMethodCode: { 
                                required: "Masukan kode Tipe Pembayaran",
                                remote: "Kode Tipe Pembayaran sudah ada"
                            },
                            MsMethodName: "Masukan Nama Tipe Pembayaran",
                        },
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_method_edit/") . $id . '",
                                    data: $("form[name=\'form-action\']").serialize(),
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Simpan data berhasil\',
                                                showConfirmButton: false,
                                                    allowOutsideClick: false,
                                                    allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Simpan data gagal\',
                                                showConfirmButton: false,
                                                    allowOutsideClick: false,
                                                    allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>';
        }
    }
    function data_method_delete($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsMethod where MsMethodId=" . $id)->result();
        foreach ($query as $row) {
            echo '<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-ban text-danger" aria-hidden="true"></i> &nbsp;Nonaktifkan Data Tipe Pembayaran</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span class="fw-normal" >Anda yakin ingin menonaktifkan</span>
                            <span class="fw-bold" >' . $row->MsMethodCode . ' - ' . $row->MsMethodName . '</span>
                            <span class="fw-normal" >?</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn-submit" >Setuju</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                var req_status_add = 0;
                $(function() { 
                    $("form[name=\'form-action\']").validate({
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_method_delete/") . $id . '",
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Nonaktifkan data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Nonaktifkan data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>';
        }
    }
    function data_method_enable($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsMethod where MsMethodId=" . $id)->result();
        foreach ($query as $row) {
            echo '<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-check text-success" aria-hidden="true"></i> &nbsp;Mengaktifkan Data Tipe Pembayaran</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span class="fw-normal" >Anda yakin ingin mengaktifkan</span>
                            <span class="fw-bold" >' . $row->MsMethodCode . ' - ' . $row->MsMethodName . '</span>
                            <span class="fw-normal" >?</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn-submit" >Setuju</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                var req_status_add = 0;
                $(function() { 
                    $("form[name=\'form-action\']").validate({
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_method_enable/") . $id . '",
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Mengaktifkan data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Mengaktifkan data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>';
        }
    }

    /*
    *       MODAL DATA COGS
    */

    function data_cogs_add($MsItemId, $MsVendorId)
    {
        echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered ">
                <form class="modal-content" name="form-action">
                    <div class="modal-header bg-dark">
                        <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp;Edit Data COGS</h5>
                        <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div  class="row justify-content-center">
                            <div class="col-10">
                                <div class="row mb-1 align-items-center">
                                    <label for="MsCogsTotal" class="col-sm-3 col-form-label">Total<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <input id="MsCogsTotal" name="MsCogsTotal" type="text" class="form-control form-control-sm price" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"   id="btn-submit"        >Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div> 
        
        <script>
            var req_status_add = 0;
            var priceinputs = Array.from(document.getElementsByClassName("price"));
            priceinputs.forEach(function (priceinput) {
                new Cleave(priceinput, {
                    numeral: true,
                    delimiter:          ",",
                    numeralDecimalScale: 0,
                    numeralThousandsGroupStyle: "thousand"
                })
            });
            $(function() { 
                $("form[name=\'form-action\']").validate({
                    rules: {
                        MsCogsTotal: "required",
                    },
                    messages: {
                        MsMethodCode: "Masukan Nilai Cogs",
                    },
                    submitHandler: function(form) {
                        if(!req_status_add){
                            $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                            $.ajax({
                                method: "POST",
                                url: "' . site_url("function/client_data_master/data_cogs_add/") . $MsItemId . '/' . $MsVendorId . '",
                                data: $("form[name=\'form-action\']").serialize(),
                                before: function(){ 
                                    req_status_add = 1;
                                },
                                success: function(data) {
                                    req_status_add = 0;
                                    $("#btn-submit").html("Simpan");
                                    
                                    if(data){
                                        Swal.fire({
                                            icon: \'success\',
                                            text: \'Simpan data berhasil\',
                                            showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                            timer: 1500,
                                        }).then((result) => {
                                            if (result.dismiss === Swal.DismissReason.timer) {
                                                load_data_table();
                                            }
                                        });
                                    }else{
                                        Swal.fire({
                                            icon: \'error\',
                                            text: \'Simpan data gagal\',
                                            showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                            timer: 1500
                                        });
                                    }
                                }
                            });
                            return false;
                        }
                    }
                });
            });
        </script>';
    }
    function data_cogs_edit($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsCogs  where MsCogsId=" . $id)->result();
        foreach ($query as $row) {
            echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered ">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp;Edit Data COGS</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div  class="row justify-content-center">
                                <div class="col-10">
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsCogsTotal" class="col-sm-3 col-form-label">Total<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <input id="MsCogsTotal" name="MsCogsTotal" type="text" class="form-control form-control-sm price" value="' . $row->MsCogsTotal . '">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success"   id="btn-submit"        >Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div> 
            
            <script>
                var req_status_add = 0;
                var priceinputs = Array.from(document.getElementsByClassName("price"));
                priceinputs.forEach(function (priceinput) {
                    new Cleave(priceinput, {
                        numeral: true,
                        delimiter:          ",",
                        numeralDecimalScale: 0,
                        numeralThousandsGroupStyle: "thousand"
                    })
                });
                $(function() { 
                    $("form[name=\'form-action\']").validate({
                        rules: {
                            MsCogsTotal: "required",
                        },
                        messages: {
                            MsMethodCode: "Masukan Nilai Cogs",
                        },
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_cogs_edit/") . $id . '",
                                    data: $("form[name=\'form-action\']").serialize(),
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Simpan data berhasil\',
                                                showConfirmButton: false,
                                                    allowOutsideClick: false,
                                                    allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Simpan data gagal\',
                                                showConfirmButton: false,
                                                    allowOutsideClick: false,
                                                    allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>';
        }
    }

    /*
    *       MODAL Data Produk BOM
    */
    function data_bom_action($itemid, $bomid = null)
    {
        $query = $this->db->query("SELECT * FROM TblMsItem LEFT JOIN TblMsItemCategory on TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId  where MsItemId=" . $itemid)->result();
        $query = (array) $query[0];
        if ($bomid != "undefined") {
            $bomdata = $this->db->query("SELECT MsItemBomCount FROM TblMsItemBom where MsItemBomId='" . $bomid . "'")->result();
            $bomcount = $bomdata[0]->MsItemBomCount;

            $bomdetail = $this->db->query("select * from TblMsItemBomDetail 
                                    left join TblMsItem on TblMsItemBomDetail.MsItemId=TblMsItem.MsItemId 
                                    LEFT JOIN TblMsItemCategory on TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId  
                                    where MsItemBomId='" . $bomid . "'")->result();

            $list = array();
            $no = 0;
            foreach ($bomdetail as $row) {

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
            $bomdetail = json_encode($list);
            $mode = "edit";
        } else {
            $mode = "add";
            $bomcount = "";
            $bomdetail = json_encode(array());
        }
        echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg">
                <form class="modal-content" name="form-action">
                    <div class="modal-header bg-dark">
                        <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp;Edit Bill Of Material</h5>
                        <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <div class="card card-delivery select">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="row mb-1 align-items-center">
                                                    <label for="MsItemCatId" class="col-3 col-form-label">Kategori</label>
                                                    <label for="MsItemCatId" class="col-1 col-form-label">:</label>
                                                    <label for="MsItemCatId" class="col-8 fw-bold">' . $query['MsItemCatCode'] . ' - ' . $query['MsItemCatName'] . '</label>
                                                </div>
                                                <div class="row mb-1 align-items-center">
                                                    <label for="MsItemCatId" class="col-3 col-form-label">Nama Item</label>
                                                    <label for="MsItemCatId" class="col-1 col-form-label">:</label>
                                                    <label for="MsItemCatId" class="col-8 fw-bold">' . $query['MsItemCode'] . ' - ' . $query['MsItemName'] . '</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row mb-1 align-items-center">
                                                    <label for="MsItemCatId" class="col-3 col-form-label">Ukuran</label>
                                                    <label for="MsItemCatId" class="col-1 col-form-label">:</label>
                                                    <label for="MsItemCatId" class="col-8 fw-bold">' . $query['MsItemSize'] . '</label>
                                                </div>
                                                <div class="row mb-1 align-items-center">
                                                    <label for="MsItemBomCount" class="col-3 col-form-label">Hasil Cetak</label>
                                                    <label for="MsItemBomCount" class="col-1 col-form-label">:</label>
                                                    <div class="col-5">
                                                        <input id="MsItemBomCount" name="MsItemBomCount" type="text" class="form-control form-control-sm double" value="' . $bomcount . '">
                                                    </div>
                                                    <label for="MsItemBomCount" class="col-3 col-form-label">' . $query['MsItemUoM'] . '</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div  class="row justify-content-center" ">
                                    <div class="col-12">
                                        <div class="row mb-1 align-items-center">
                                            <div class="label-border-right">
                                                <span class="label-dialog">Detail Item BOM</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="card " style="min-height:150px;">
                                            <div class="card-body p-2 ">
                                                <div class="d-flex justify-content-start border-1 border-bottom pb-2">
                                                    <button class="btn btn-success btn-sm py-1 me-1" id="add-item-bom" type="button">
                                                        <i class="fas fa-plus" aria-hidden="true"></i>
                                                        <span class="fw-bold">
                                                            &nbsp;Tambah Item Baru
                                                        </span>
                                                    </button>
                                                    <button class="btn btn-primary btn-sm py-1" id="btn-import" type="button" >
                                                        <i class="fas fa-sync-alt"></i>
                                                        <span class="fw-bold">
                                                            &nbsp;Duplikasi Dari item Lain
                                                        </span>
                                                    </button>  
                                                </div>
                                                <table id="tb_data_bom" class="table table-hover align-middle responsive"  style=\'font-family:"Sans-serif", Helvetica; font-size:80%;width:100%\'>
                                                    <thead class="thead-dark" style="display:none;">
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nama Item</th>
                                                            <th>MsItemId</th>
                                                            <th>MsVendorCode</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"   id="btn-submit"        >Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="modal fade" id="select-ready-bom" tabindex="-1" role="dialog" data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content shadow">
                    <div class="modal-header bg-dark">
                        <h6 class="modal-title text-white"><i class="fas fa-check-square text-primary" aria-hidden="true"></i> &nbsp;Pilih Item Bill Of Material</h5>
                        <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="collapse mb-1 bg-search shadow-sm" id="list-filter-data-dropdown">
                            <div class="card card-body">
                                <div class="row mb-1 align-items-center">
                                    <label for="tb_data_row" class="col-lg-3 col-form-label">Tampilkan</label>
                                    <div class="col-3">
                                        <select class="custom-select custom-select-sm form-control form-control-sm" id="tb_data_row" name="tb_data_row">
                                            <option value="5" selected>5</option>
                                            <option value="10" >10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                    <label class="col-3 col-form-label ps-0">baris</label>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="tb_data_row" class="col-lg-3 col-form-label">Pilih Kategori</label>
                                    <div class="col-lg-9">
                                        <select class="custom-select custom-select-sm form-control form-control-sm" id="tb_data_select" name="tb_data_select" style="width:100%">
                                            <option value="" selected>Semua Kategori</option>';
        $db = $this->db->query("SELECT * FROM TblMsItemCategory left join TblMsItem on TblMsItemCategory.MsItemCatId = TblMsItem.MsItemCatId WHERE MsitemVendor LIKE '%who%' GROUP by TblMsItem.MsItemCatId")->result();
        foreach ($db as $key) {
            echo '<option value="' . $key->MsItemCatId . '">' . $key->MsItemCatCode . ' - ' . $key->MsItemCatName . '</option>';
        }
        echo '
                                        </select>
                                    </div>  
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-1">
                            <div class="col-lg-6 col-9 input-filter">
                                <i class="fas fa-search text-secondary"></i>
                                <input type="text" class="form-control form-control-sm i-search" placeholder="Cari Nama Item" id="text-search-select-bom"/>
                            </div>
                            <div class="col-lg-6 col-3">
                                <button class="btn btn-secondary btn-sm p-1  float-end" type="button" data-bs-toggle="collapse" href="#list-filter-data-dropdown" id="btn-filter-data"><i class="fas fa-filter"></i></button>
                            </div>
                        </div>
                        <table id="tb_data_item_bom" class="table table-hover align-middle responsive"  style=\'font-family:"Sans-serif", Helvetica; font-size:80%;width:100%\'>
                            <thead class="thead-dark" style="display:none;">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Item</th>
                                    <th>Bom Id</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success"   id="btn-select-ready-bom"        >Pilih</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            
            /**
            **       Script untuk modal utama
            **
            **/
            var mode_action = "' . $mode . '";
            var table_data = ' . $bomdetail . ';
            var t = $("#tb_data_bom").DataTable( {
                "searching": false,
                "ajax": function (data, callback, settings) {
                    callback({ data: table_data }) //reloads data 
                },
                "columns": [
                    { "width": 5 },
                    null,
                ],
                "columnDefs": [
                    {
                        "targets": [ 2,3 ],
                        "visible": false,
                    },
                ],
                "lengthChange": false,
                "paging": false,
                "ordering": false,
                "autoWidth": true,
                "info": false
            });

            var counter = 1;
            $("#add-item-bom").on( "click", function () {
                var htmlItem = \'<div class="row">\';
                htmlItem    += \'   <div class="col-lg-7 col-12 mb-lg-0 mb-2" >\';
                htmlItem    += \'       <select class="custom-select custom-select-sm form-select form-select-sm selectitem" placeholder="cari nama item/"></select>\';
                htmlItem    += \'   </div>\';
                table_data.push([counter,htmlItem,"-","-",0]);
                $("#add-item-bom").prop("disabled",true);
                
                refresh_data_table(false);
            });

            t.on("click","tr",function() {
                $(this).find("input").focus();
            });

            t.on("draw", function () {
                $(".selectitem").select2({
                    placeholder: "Cari Nama Item",
                    dropdownParent: $("#modal-action .modal-content"),
                    ajax: {
                        dataType: "json",
                        url: "' . site_url("function/client_data_master/get_data_master_item") . '",
                        delay: 800,
                        data: function(params) {
                            return {
                                search: params.term
                            }
                        },
                        processResults: function (data, page) {
                            return {
                                results: data
                            };
                        },
                    },
                    escapeMarkup: function(m) {
                        return m;
                    },
                    templateResult: function template(data) {
                        if ($(data.html).length === 0) {
                            return data.text;
                        }
                        return $(data.html);
                    },
                    templateSelection: function templateSelect(data) {
                        if ($(data.html).length === 0) {
                            return data.text;
                        }
                        //
                        return data[\'text\'];
                    }
                });
                $(".selectitem").select2("open");
                $(".select2-search__field").each(function (key,value) {
                    value.focus()
                })
                
                $(".selectitem").on("select2:open", function(e) {
                    //console.log("open-select");
                    const selectId = e.target.id
                    $(".select2-search__field").each(function (key,value) {
                        value.focus()
                    })
                })
                $(".selectitem").on("select2:select", function (e) {
                    var data = e.params.data;
                    
                    for(var i = 0;table_data.length>i;i++){
                        if(table_data[i][2]==data.MsItemId && table_data[i][3]==data.MsVendorCode){
                            Swal.fire({
                                icon: \'error\',
                                text: \'Data Sudah Ada\',
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                timer: 1000
                            });
                            $(this).select2("open");
                            return false;
                        }
                    }
                    var htmlItem = \'<div class="row">\';
                    htmlItem    += \'   <div class="col-lg-7 col-12 mb-lg-0 mb-2" >\';
                    htmlItem    += \'       <span class="fw-bold">\' + data.MsItemCode + \'-\' + data.MsItemName + \'</span><br>\';
                    htmlItem    += \'       <span>Supplier : <b>\' + data.MsVendorCode + \'</b></span><br>\';
                    htmlItem    += \'       <span>Rp. \' + data.MsItemPrice + \'</span>&nbsp;|&nbsp;<span>\' + data.MsItemSize + \'</span>&nbsp;|&nbsp;\' + data.MsItemPcsM2 + \'</span>\';
                    htmlItem    += \'   </div>\';
                    htmlItem    += \'   <div class="col-lg-3 col-6">\';
                    htmlItem    += \'       Qty<span>&nbsp;(\' + data.MsItemUoM + \')</span> : <input type="text" class="input-in-table double" name="MsItemBomDetailCount" value=""/>\';
                    htmlItem    += \'   </div>\';
                    htmlItem    += \'   <div class="col-lg-2 col-6">\';
                    htmlItem    += \'       <div class="d-flex flex-row justify-content-end">\';
                    htmlItem    += \'           <a onclick="hapus_item_click(\' + data.MsItemId + \',\\\'\' + data.MsVendorCode + \'\\\')" class="me-2 text-danger pointer m-2" title="Hapus Item"><i class="fas fa-trash-alt fa-lg"></i></a>\';
                    htmlItem    += \'       </div>\';
                    htmlItem    += \'   </div>\';
                    table_data[table_data.length - 1][1] = htmlItem;
                    table_data[table_data.length - 1][2] = data.MsItemId;
                    table_data[table_data.length - 1][3] = data.MsVendorCode;
                    table_data[table_data.length - 1][4] = 0;

                    $("#add-item-bom").prop("disabled",false);
                    refresh_data_table();

                });
                
                $(\'input[name="MsItemBomDetailCount"]\').each(function(index) {
                    $(this).val(table_data[index][4]);
                });
            });
            hapus_item_click = function(MsItemId,MsVendorCode){
                for(var i = 0;table_data.length>i;i++){
                    if(table_data[i][2]==MsItemId && table_data[i][3]==MsVendorCode){
                        var index = i;
                        const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: \'btn btn-success mx-1\',
                                cancelButton: \'btn btn-secondary mx-1\'
                            },
                            buttonsStyling: false
                        })
                        swalWithBootstrapButtons.fire({
                            title: "Hapus Item!",
                            html: "apakah anda yakin ingin menghapus Item ini!",
                            icon: "warning",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showCancelButton: true,
                            confirmButtonText: "Lanjutkan",
                            cancelButtonText: "Tidak",
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                table_data.splice(index, 1);
                                refresh_data_table();
                            }
                        })
                    }
                }
            }
            refresh_data_table = function(change = true){
                for(var i = 0;table_data.length>i;i++){
                    table_data[i][0]=i+1;
                }
                t.ajax.reload();
                var doubleinputs = Array.from(document.getElementsByClassName("double"));
                doubleinputs.forEach(function (doubleinput) {
                    new Cleave(doubleinput, {
                        numeral: true,
                        numeralDecimalMark: ".",
                        delimiter:          ","
                    })
                });
                $(\'input[name="MsItemBomDetailCount"]\').each(function(index) {
                    $(this).keyup(function(){
                        table_data[index][4] = this.value;
                        console.log(table_data[index][4]);
                    });
                });
                $(".input-in-table").each(function (key,value) {
                    value.focus()
                })
            }
            $("#btn-import").on( "click", function () {
                $("#select-ready-bom").modal("show");
            });
            refresh_data_table();


            /**
            **       Script untuk modal Select
            **
            **/
            var table_select_bom = $("#tb_data_item_bom").DataTable( {
                "responsive": true,
                "searching": false,
                "lengthChange": false,
                "pageLength" : parseInt($("#tb_data_row").val()),
                "processing": true,
                "serverSide": true,
                select: true,
                "ajax": {
                    "url": "' . site_url("function/client_datatable/get_master_select_item_bom") . '",
                    "type": "POST",
                    "data": function(data){
                        data.search["value"] = $("#text-search-select-bom").val();
                        data.search["status"] = $("#tb_data_select").val();
                        data.search["colstatus"] = "TblMsItem.MsItemCatId";
                    }
                },
                "columns": [
                    { "width": 5 },
                    null,
                ],
                "columnDefs": [
                    {
                        "targets": [ 2],
                        "visible": false,
                    },
                ],
                "pagingType": "simple",
                "order": [],
                "createdRow": function( row, data, dataIndex ) {
                    $(row).addClass( "tb-text-top" );
                }
            });
            new $.fn.dataTable.FixedHeader(table_select_bom);
            table_select_bom.on( "select", function ( e, dt, type, indexes ) {
                if (type === "row") {
                    var data = table_select_bom.rows(indexes).data();
                    console.log("this select",data[0][2]);
                    bom_id = data[0][2];
                    $("#btn-select-ready-bom").prop("disabled",false);
                }
            });
            
            table_select_bom.on( "deselect", function ( e, dt, type, indexes ) {
                if (type === "row") {
                    var data = table_select_bom.rows(indexes).data();
                    console.log("this deselect",data[0][2]);
                    bom_id = "";
                    $("#btn-select-ready-bom").prop("disabled",true);
                }
            } );

            $("#tb_data_select").select2({
                dropdownParent: $("#select-ready-bom .modal-content"),
            });
            $("#tb_data_select,#tb_data_row").change(function(){
                $("#list-filter-data-dropdown").collapse("show");
                table_select_bom.ajax.reload(null, false).responsive.recalc().columns.adjust();  
            });
            $("#text-search-select-bom").keyup(function(){
                table_select_bom.ajax.reload(null, false).responsive.recalc().columns.adjust();  
            });
            $("#list-filter-data-dropdown").on("shown.bs.collapse", function () {
                $("#tb_data_select").select2("open");
            })

            $("#btn-select-ready-bom").click(function(){
                $("#btn-select-ready-bom").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                $.ajax({
                    method: "POST",
                    dataType: "json",
                    url: "' . site_url("function/client_data_master/get_bom_detail/") . '" + bom_id,
                    success: function(data) {
                        $("#btn-select-ready-bom").html("Pilih");
                        table_data = data;
                        console.log(table_data);
                        $("#select-ready-bom").modal("hide");
                        refresh_data_table();
                    }
                });
            });
            $("#select-ready-bom").on("show.bs.modal", function () { 
                $("#modal-action").modal("hide");
            });
            $("#select-ready-bom").on("hide.bs.modal", function () { 
                $("#modal-action").modal("show");
            });

            var req_status_add = 0;
            $("form[name=\'form-action\']").validate({
                rules: {
                    MsItemBomCount: "required",
                },
                messages: {
                    MsItemBomCount: "Masukan Nilai Hasil satu kali cetak",
                },
                submitHandler: function(form) {
                    if(table_data.length==0){
                        Swal.fire({
                            icon: \'error\',
                            text: \'Data Detail item bom harus dimasukan terlebih dahulu\',
                            showConfirmButton: false,
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                            timer: 1500
                        });
                        return false;
                    }
                    for(var i = 0;table_data.length>i;i++){
                        if(parseFloat(table_data[i][4])<=0){
                            Swal.fire({
                                icon: \'error\',
                                text: \'Data Detail item bom harus dimasukan terlebih dahulu\',
                                showConfirmButton: false,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                timer: 1500
                            });
                            return false;
                        };
                    }
                    if(!req_status_add){
                        $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                        if(mode_action=="add"){
                            var url_action = "' . site_url("function/client_data_master/data_bom_add/") . '";
                        }else{
                            var url_action = "' . site_url("function/client_data_master/data_bom_edit/") . $bomid . '";
                        }
                        $.ajax({
                            method: "POST",
                            url: url_action,
                            data: {
                                "MsVendorCode" : "WHO",
                                "MsItemId" : "' . $itemid . '",
                                "MsItemBomCount" : $("#MsItemBomCount").val(),
                                "data_detail" : table_data
                            },
                            before: function(){ 
                                req_status_add = 1;
                            },
                            success: function(data) {
                                req_status_add = 0;
                                $("#btn-submit").html("Simpan");
                                
                                if(data){
                                    Swal.fire({
                                        icon: \'success\',
                                        text: \'Simpan data berhasil\',
                                        showConfirmButton: false,
                                            allowOutsideClick: false,
                                            allowEscapeKey: false,
                                        timer: 1500,
                                    }).then((result) => {
                                        if (result.dismiss === Swal.DismissReason.timer) {
                                            load_data_table();
                                        }
                                    });
                                }else{
                                    Swal.fire({
                                        icon: \'error\',
                                        text: \'Simpan data gagal\',
                                        showConfirmButton: false,
                                            allowOutsideClick: false,
                                            allowEscapeKey: false,
                                        timer: 1500
                                    });
                                }
                            }
                        });
                        return false;
                    }
                }
            });
        </script>';
    }


    /*
    *       MODAL DATA DELIVERY
    */
    function data_delivery_add()
    {
        echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered ">
                <form class="modal-content" name="form-action">
                    <div class="modal-header bg-dark">
                        <h6 class="modal-title text-white"><i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;Tambah Data Tipe Pengiriman</h5>
                        <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div  class="row justify-content-center">
                            <div class="col-10">
                                <div class="row mb-1 align-items-center">
                                    <label for="MsDeliveryIsActive" class="col-sm-3 col-form-label">Status<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-switch">
                                            <input id="MsDeliveryIsActive" name="MsDeliveryIsActive" class="form-check-input" type="checkbox" checked>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-1 align-items-center">
                                    <label for="MsDeliveryName" class="col-sm-3 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                                    <div class="col-sm-9">
                                        <input id="MsDeliveryName" name="MsDeliveryName" type="text" class="form-control form-control-sm" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"   id="btn-submit"        >Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
        
        <script>
            var req_status_add = 0;
            var datesCollection = document.getElementsByClassName("input-phone");
            var phones = Array.from(datesCollection);

            phones.forEach(function (phone) {
                new Cleave(phone, {
                    phone: true,
                    phoneRegionCode: "ID"
                })
            });
            
            $(function() { 
                $("form[name=\'form-action\']").validate({
                    rules: {
                        MsDeliveryName: {
                            "required": true,
                            "remote": "' . site_url("function/client_data_master/validate_kode_delivery") . '",
                        },
                    },
                    messages: {
                        MsDeliveryName: { 
                            required: "Masukan Nama Tipe Pengiriman",
                            remote: "Nama Tipe Pengiriman sudah ada"
                        },
                    },
                    submitHandler: function(form) {
                        if(!req_status_add){
                            $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                            $.ajax({
                                method: "POST",
                                url: "' . site_url("function/client_data_master/data_delivery_add") . '",
                                data: $("form[name=\'form-action\']").serialize(),
                                before: function(){ 
                                    req_status_add = 1;
                                },
                                success: function(data) {
                                    req_status_add = 0;
                                    $("#btn-submit").html("Simpan");
                                    
                                    if(data){
                                        Swal.fire({
                                            icon: \'success\',
                                            text: \'Tambah data berhasil\',
                                            showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                            timer: 1500,
                                        }).then((result) => {
                                            if (result.dismiss === Swal.DismissReason.timer) {
                                                load_data_table();
                                            }
                                        });
                                    }else{
                                        Swal.fire({
                                            icon: \'error\',
                                            text: \'Tambah data gagal\',
                                            showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                            timer: 1500
                                        });
                                    }
                                }
                            });
                            return false;
                        }
                    }
                });
            });
        </script>';
    }
    function data_delivery_view($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsDelivery where MsDeliveryId=" . $id);
        foreach ($query->result() as $row) {
            echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered ">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-eye text-info" aria-hidden="true"></i> &nbsp;Detail Data Tipe Pengiriman</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div  class="row justify-content-center">
                                <div class="col-10">
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsDeliveryIsActive" class="col-sm-3 col-form-label">Status<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <div class="form-check form-switch">
                                                <input id="MsDeliveryIsActive" name="MsDeliveryIsActive" class="form-check-input" type="checkbox" ' . ($row->MsDeliveryIsActive == 1 ? "checked" : "") . ' disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsDeliveryName" class="col-sm-3 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <input id="MsDeliveryName" name="MsDeliveryName" type="text" class="form-control form-control-sm" value="' . $row->MsDeliveryName . '" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
            ';
        }
    }
    function data_delivery_edit($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsDelivery where MsDeliveryId=" . $id);
        foreach ($query->result() as $row) {
            echo '<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered ">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp; Edit Data Tipe Pengiriman</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div  class="row justify-content-center">
                                <div class="col-10">
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsDeliveryIsActive" class="col-sm-3 col-form-label">Status<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <div class="form-check form-switch">
                                                <input id="MsDeliveryIsActive" name="MsDeliveryIsActive" class="form-check-input" type="checkbox" ' . ($row->MsDeliveryIsActive == 1 ? "checked" : "") . '>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-1 align-items-center">
                                        <label for="MsDeliveryName" class="col-sm-3 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-sm-9">
                                            <input id="MsDeliveryName" name="MsDeliveryName" type="text" class="form-control form-control-sm" value="' . $row->MsDeliveryName . '">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success"   id="btn-submit"        >Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <script>
                var req_status_add = 0;
                var datesCollection = document.getElementsByClassName("input-phone");
                var phones = Array.from(datesCollection);

                phones.forEach(function (phone) {
                    new Cleave(phone, {
                        phone: true,
                        phoneRegionCode: "ID"
                    })
                });
                
                $(function() { 
                    $("form[name=\'form-action\']").validate({
                        rules: {
                            MsDeliveryName: {
                                "required": true,
                                "remote": "' . site_url("function/client_data_master/validate_kode_delivery/") . $row->MsDeliveryName . '",
                            },
                        },
                        messages: {
                            MsDeliveryName: { 
                                required: "Masukan kode Tipe Pengiriman",
                                remote: "Kode Tipe Pengiriman sudah ada"
                            },
                        },
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_delivery_edit/") . $id . '",
                                    data: $("form[name=\'form-action\']").serialize(),
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Edit data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Tambah data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>
            ';
        }
    }
    function data_delivery_delete($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsDelivery where MsDeliveryId=" . $id)->result();
        foreach ($query as $row) {
            echo '<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-ban text-danger" aria-hidden="true"></i> &nbsp;Nonaktifkan Data Tipe Pengiriman</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span class="fw-normal" >Anda yakin ingin menonaktifkan</span>
                            <span class="fw-bold" >' . $row->MsDeliveryName . '</span>
                            <span class="fw-normal" >?</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn-submit" >Setuju</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                var req_status_add = 0;
                $(function() { 
                    $("form[name=\'form-action\']").validate({
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_delivery_delete/") . $id . '",
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Nonaktifkan data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Nonaktifkan data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>';
        }
    }
    function data_delivery_enable($id)
    {
        $query = $this->db->query("SELECT * FROM TblMsDelivery where MsDeliveryId=" . $id)->result();
        foreach ($query as $row) {
            echo '<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form class="modal-content" name="form-action">
                        <div class="modal-header bg-dark">
                            <h6 class="modal-title text-white"><i class="fas fa-check text-success" aria-hidden="true"></i> &nbsp;Mengaktifkan Data Tipe Pelanggan</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span class="fw-normal" >Anda yakin ingin mengaktifkan</span>
                            <span class="fw-bold" >' . $row->MsDeliveryName . '</span>
                            <span class="fw-normal" >?</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn-submit" >Setuju</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                var req_status_add = 0;
                $(function() { 
                    $("form[name=\'form-action\']").validate({
                        submitHandler: function(form) {
                            if(!req_status_add){
                                $("#btn-submit").html(\'<i class="fas fa-circle-notch fa-spin"></i> Loading\');
                                $.ajax({
                                    method: "POST",
                                    url: "' . site_url("function/client_data_master/data_delivery_enable/") . $id . '",
                                    before: function(){ 
                                        req_status_add = 1;
                                    },
                                    success: function(data) {
                                        req_status_add = 0;
                                        $("#btn-submit").html("Simpan");
                                        
                                        if(data){
                                            Swal.fire({
                                                icon: \'success\',
                                                text: \'Mengaktifkan data berhasil\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500,
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    load_data_table();
                                                }
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: \'error\',
                                                text: \'Mengaktifkan data gagal\',
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timer: 1500
                                            });
                                        }
                                    }
                                });
                                return false;
                            }
                        }
                    });
                });
            </script>';
        }
    }
}
