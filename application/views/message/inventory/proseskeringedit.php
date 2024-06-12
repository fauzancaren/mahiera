<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" name="form-action">
            <div class="modal-header bg-dark">
                <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp;Edit Proses Kering - <?= $_dataproduksi->MsItemName ?></h6>
                <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-11 my-1">
                        <div class="row mb-1 align-items-center">
                            <div class="label-border-right">
                                <span class="label-dialog">Dokumen</span>
                            </div>
                        </div>
                        <div class="row mb-1 align-items-center">
                            <label for="ProduksiCode" class="col-sm-3 col-form-label">No. Doc<sup class="error">&nbsp;*</sup></label>
                            <div class="col-sm-9">
                                <input id="ProduksiCode" name="ProduksiCode" type="text" class="form-control form-control-sm" value="<?= $_dataproduksi->ProduksiCode ?>" readonly>
                            </div>
                        </div> 
                        <div class="row mb-1 align-items-center">
                                <label for="MsEmpId" class="col-sm-3 col-form-label">Admin<sup class="error">&nbsp;*</sup></label>
                                <div class="col-sm-9">
                                <select class="custom-select custom-select-sm form-select form-select-sm " id="MsEmpId" name="MsEmpId" style="width:100%">';
                                    <?php
                                        $db = $this->db->get("TblMsEmployee")->result();
                                        foreach ($db as $key) {
                                            echo '<option value="' . $key->MsEmpId . '" ' . ($_session["MsEmpId"] == $key->MsEmpId ? "selected" : "") . '>' . $key->MsEmpName . '</option>';
                                        }
                                    ?>
                                </select> 
                                </div>
                        </div>
                        <div class="row mb-1 align-items-center">
                            <label for="MsWorkplaceId" class="col-sm-3 col-form-label">Toko</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                <select class="custom-select custom-select-sm form-select form-select-sm" id="MsWorkplaceId" name="MsWorkplaceId" style="width:100%">
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-1 align-items-center">
                            <label for="ProduksiRemarks" class="col-sm-3 col-form-label">Keterangan</label>
                            <div class="col-sm-9">
                                <textarea class="form-control form-control-sm" id="ProduksiRemarks" name="ProduksiRemarks"><?= $_dataproduksi->ProduksiRemarks ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-11 my-1">
                        <div class="row mb-1 align-items-center">
                            <div class="label-border-right">
                                <span class="label-dialog">Detail PO</span>
                            </div>
                        </div>
                        <div class="row mb-1 align-items-center">
                            <label for="ProduksiRef" class="col-sm-3 col-form-label">No. Ref<sup class="error">&nbsp;*</sup></label>
                            <div class="col-sm-9">
                                <input id="ProduksiRef" name="ProduksiRef" type="text" class="form-control form-control-sm" value="<?= $_dataproduksi->ProduksiRef ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-1 align-items-center">
                            <label for="MsItemIdRef" class="col-sm-3 col-form-label">Item<sup class="error">&nbsp;*</sup></label>
                            <div class="col-sm-9">
                                <input id="MsItemIdRef" name="MsItemIdRef" type="text" class="form-control form-control-sm" value="<?= $_dataproduksi->MsItemCode." - ".$_dataproduksi->MsItemName ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-1 align-items-center">
                            <label for="MsVendorCodeRef" class="col-sm-3 col-form-label">Vendor<sup class="error">&nbsp;*</sup></label>
                            <div class="col-sm-3">
                                <input id="MsVendorCodeRef" name="MsVendorCodeRef" type="text" class="form-control form-control-sm" value="<?= $_dataproduksi->MsVendorCode ?>" readonly>
                            </div>
                            <label for="TOCode" class="col-sm-2 col-form-label">Ukuran<sup class="error">&nbsp;*</sup></label>
                            <div class="col-sm-4">
                                <input id="TOCode" name="TOCode" type="text" class="form-control form-control-sm" value="<?= $_dataproduksi->MsItemSize ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-1 align-items-center"> 
                            <label for="ProduksiQtyRef" class="col-sm-3 col-form-label">Total PO</label>
                            <div class="col-sm-9">
                                <input id="ProduksiQtyRef" name="ProduksiQtyRef" type="text" class="form-control form-control-sm" value="<?= $_dataproduksi->PODetailQty. " ".$_dataproduksi->MsItemUoM  ?>" readonly>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-11 my-1">
                        <div class="row mb-1 align-items-center">
                            <div class="label-border-right">
                                <span class="label-dialog">Produksi</span>
                            </div>
                        </div> 
                        <div class="row mb-1 align-items-center">
                            <label for="ProduksiDateCetak" class="col-sm-3 col-form-label">Tanggal Cetak<sup class="error">&nbsp;*</sup></label>
                            <div class="col-sm-9">
                                <input id="ProduksiDateCetak" name="ProduksiDateCetak" type="text" class="form-control form-control-sm" value="">
                            </div>
                        </div>
                        <div class="row mb-1 align-items-center">
                            <label for="ProduksiDateKering" class="col-sm-3 col-form-label">Tanggal Kering<sup class="error">&nbsp;*</sup></label>
                            <div class="col-sm-9">
                                <input id="ProduksiDateKering" name="ProduksiDateKering" type="text" class="form-control form-control-sm" value="">
                            </div>
                        </div>
                        <div class="row mb-1 align-items-center">
                            <label for="MsEmpId" class="col-sm-3 col-form-label">Staff Cetak<sup class="error">&nbsp;*</sup></label>
                            <div class="col-sm-9">
                                <select class="custom-select custom-select-sm form-select form-select-sm " id="MsStaffId" name="MsStaffId" style="width:100%">';
                                    <?php
                                        $db = $this->db->get("TblMsStaff")->result();
                                        foreach ($db as $key) {
                                            echo '<option value="' . $key->StaffId . '" >' . $key->StaffName . '</option>';
                                        }
                                    ?>
                                </select> 
                            </div>
                        </div>
                        <div class="row mb-1 align-items-center">
                            <label for="ProduksiQty" class="col-sm-3 col-form-label">Jumlah Cetak<sup class="error">&nbsp;*</sup></label>
                            <div class="col-sm-3">
                                <input id="ProduksiQty" name="ProduksiQty" type="text" class="form-control form-control-sm double" value="<?= $_dataproduksi->ProduksiQty ?>">
                            </div>  
                            <label for="ProduksiQty" class="col-sm-3 col-form-label fw-bold"><?= $_dataproduksi->MsItemUoM ?></label>
                        </div> 
                    </div>
                    <div class="col-xl-6 col-11 my-1">
                        <div class="row mb-1 align-items-center">
                            <div class="label-border-right">
                                <span class="label-dialog">Detail Produksi</span>
                            </div>
                        </div> 
                        <div class="row mx-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checkproduksi" <?= ($_dataproduksi->ProduksiAuto == 1 ? "checked" : "" )?>>
                                <label class="form-check-label" for="checkproduksi">
                                    Otomatis menggunakan satu standar <span class="fw-bold" id="produksi-std"></span>
                                </label>
                            </div>
                        </div>
                        <div id="detail-bom"></div> 
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="btn-submit">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<div id="dialog-customer">
</div>
<script>
    /*  ARRAY SELECT */
    var datestartready = moment("<?= $_dataproduksi->ProduksiDateCetak ?>"); 
    var datestartkering = moment(); 
    var req_status_add = 0;

    $("#ProduksiDateCetak").daterangepicker({
        singleDatePicker: true,
        startDate: datestartready,
        showDropdowns: true,
        locale: {
            "format": "DD/MM/YYYY",
            "customRangeLabel": "Pilih Tanggal Sendiri",
        }
    },function(start, end) {
        datestartready = start; 
    });
    $("#ProduksiDateKering").daterangepicker({
        singleDatePicker: true,
        startDate: datestartkering,
        showDropdowns: true,
        locale: {
            "format": "DD/MM/YYYY",
            "customRangeLabel": "Pilih Tanggal Sendiri",
        }
    },function(start, end) {
        datestartkering = start; 
    });

    var data_vendor = <?= JSON_ENCODE($_store) ?>; 
    load_dst = function(val = true) {
        var data = [];
        data_vendor.forEach(element => {
            data.push({
                id: element["MsWorkplaceId"],
                text: element["MsWorkplaceCode"] + " - " + element["MsWorkplaceName"]
            });
        });
        if (!val) {
            $('#MsWorkplaceId option').remove();
            $("#MsWorkplaceId").select2('destroy');
        }
        $("#MsWorkplaceId").select2({
            data: data,
            dropdownParent: $("#modal-action .modal-content"),
        })
    } 
    $("#MsEmpId,#MsStaffId").select2({ 
        dropdownParent: $("#modal-action .modal-content"),
    })
    load_dst();   
    var data_bom = <?= JSON_ENCODE($_databom) ?>; 
    var number= 0;
    function ucwords (str) {
        return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
            return $1.toUpperCase();
        });
    }
    data_bom.forEach(element => { 
        number++;
        $("#detail-bom").append(`<div class="row mx-2 align-items-center border-bottom border-opacity-10">
                                    <div class='col-1'>` + number + `</div>
                                    <div class='col-6'>
                                        <div class='d-flex flex-column'>
                                            <span class='fw-bold'>` + element["MsItemName"] +`</span>
                                            <span>` + element["MsItemSize"] +` | ` + element["MsVendorCode"] +`</span>
                                        </div>
                                    </div> 
                                    <div class='col-3'>
                                        <div class='d-flex flex-column'>
                                            <input type='text' class='form-control form-control-sm double bom-detail' value='`+  element["ProduksiDetailQty"] +`' data-id="` + element["MsItemId"] +`" data-vendor="` + element["MsVendorCode"] +`" data-std="` + element["ProduksiDetailStdQty"] +`" data-head-std="<?= $_dataproduksi->ProduksiStdQty ?>" disabled>
                                        </div>
                                    </div>
                                    <div class='col-2'>` + element["MsItemUoM"] +`</div>
                                </div>`);
                                
    });
    var stdbom = 0;
    $("#ProduksiQty").keyup(function(){
        $("input.bom-detail").each(function() {
            stdbom =  $(this).data("head-std");
            $(this).val($("#ProduksiQty").val() / $(this).data("head-std") *  $(this).data("std"));
            $("#produksi-std").html("( 1:"+ parseFloat($("#ProduksiQty").val()/$(this).data("head-std")).toFixed(2) +" )");
        });
       
    });
    $("#checkproduksi").change(function(){
        if(this.checked){
            $("input.bom-detail").each(function() {
                $(this).attr("disabled",true);  
                $(this).val($("#ProduksiQty").val() / $(this).data("head-std") *  $(this).data("std")); 
            })
        }else{ 
            $("input.bom-detail").each(function() {
                $(this).attr("disabled",false);
            })
        }
    })
    $("#ProduksiQty").trigger("keyup");
    $("#checkproduksi").trigger("change");
    var doubleinputs = Array.from(document.getElementsByClassName("double"));
      doubleinputs.forEach(function(doubleinput) {
         new Cleave(doubleinput, {
            numeral: true,
            numeralDecimalMark: ".",
            delimiter: ","
         })
      }); 
    $("#btn-submit").click(function() {
        if ($("#ProduksiQty").val() == 0) {
            Swal.fire({
                icon: 'error',
                text: 'Qty tidak boleh kosong',
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                timer: 1500
            });
            return false;
        }
        
        var dataheader = {
            "ProduksiDateCetak": moment(datestartready).format('YYYY-MM-DD'), 
            "ProduksiDateKering": moment(datestartkering).format('YYYY-MM-DD'), 
            "MsEmpId": $("#MsEmpId").val(),
            "MsStaffId": $("#MsStaffId").val(), 
            "MsWorkplaceId" : $("#MsWorkplaceId").val(),   
            "ProduksiRemarks" : $("#ProduksiRemarks").val(), 
            "ProduksiQty" : $("#ProduksiQty").val(),
            "ProduksiRef" : $("#ProduksiRef").val(),
            "ProduksiStatus" : 1,
            "ProduksiAuto" : $('#checkproduksi').is(":checked") ? 1 : 0,
        };

        var detailitem = [];
        $("input.bom-detail").each(function() {
            var data = {
                "MsItemId": $(this).data("id"),
                "msVendorCode": $(this).data("vendor"),
                "ProduksiDetailQty": $(this).val(),
                "ProduksiDetailStdQty": $(this).data("std"),
                "ProduksiDetailRef": $("#ProduksiCode").val(),
            };
            detailitem.push(data);
        }) 
        /* -------------------------------------------------     SEND DATA SERVER    ---------------------------------------------- */
        $.ajax({
            method: "POST",
            url: "<?= site_url("function/client_data_inventory/data_produksi_kering") ?>",
            data: {
                "code": $("#ProduksiCode").val(), 
                "data": dataheader, 
                "detail": detailitem, 
            },
            before: function() {
                req_status_add = 1;
            },
            success: function(data) {
                req_status_add = 0;
                $("#btn-submit").html("Simpan");
                console.log(data);
                if (data) {
                    Swal.fire({
                        icon: 'success',
                        text: 'Proses Kering berhasil',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        timer: 1500,
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            load_data_table();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        text: 'Proses Kering gagal',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        timer: 1500
                    });
                }
            }
        });
    })
</script>