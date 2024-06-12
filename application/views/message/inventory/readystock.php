<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-xl">
      <div class="modal-content" name="form-action">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-check text-success" aria-hidden="true"></i> &nbsp;Ready Stock</h6>
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
                        <input id="ProduksiCode" name="ProduksiCode" type="text" class="form-control form-control-sm" value="" readonly>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="ProduksiDate" class="col-sm-3 col-form-label">Tanggal<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-9">
                        <input id="ProduksiDate" name="ProduksiDate" type="text" class="form-control form-control-sm" value="">
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
                        <textarea class="form-control form-control-sm" id="ProduksiRemarks" name="ProduksiRemarks"></textarea>
                     </div>
                  </div>
               </div>
                <div class="col-xl-6 col-11 my-1">
                    <div class="row mb-1 align-items-center">
                        <div class="label-border-right">
                            <span class="label-dialog"> </span>
                        </div>
                    </div>
                    <div class="row mb-1 align-items-center">
                        <label for="ProduksiRef" class="col-sm-3 col-form-label">No. Ref<sup class="error">&nbsp;*</sup></label>
                        <div class="col-sm-9">
                            <input id="ProduksiRef" name="ProduksiRef" type="text" class="form-control form-control-sm" value="<?= $_dataitem->PODetailRef ?>" readonly>
                        </div>
                    </div>
                    <div class="row mb-1 align-items-center">
                        <label for="MsItemIdRef" class="col-sm-3 col-form-label">Item<sup class="error">&nbsp;*</sup></label>
                        <div class="col-sm-9">
                            <input id="MsItemIdRef" name="MsItemIdRef" type="text" class="form-control form-control-sm" value="<?= $_dataitem->MsItemCode." - ".$_dataitem->MsItemName ?>" readonly>
                        </div>
                    </div>
                    <div class="row mb-1 align-items-center">
                        <label for="MsVendorCodeRef" class="col-sm-3 col-form-label">Vendor<sup class="error">&nbsp;*</sup></label>
                        <div class="col-sm-3">
                            <input id="MsVendorCodeRef" name="MsVendorCodeRef" type="text" class="form-control form-control-sm" value="<?= $_dataitem->MsVendorCode ?>" readonly>
                        </div>
                        <label for="TOCode" class="col-sm-2 col-form-label">Ukuran<sup class="error">&nbsp;*</sup></label>
                        <div class="col-sm-4">
                            <input id="TOCode" name="TOCode" type="text" class="form-control form-control-sm" value="<?= $_dataitem->MsItemSize ?>" readonly>
                        </div>
                    </div>
                    <div class="row mb-1 align-items-center">
                        <label for="ProduksiQty" class="col-sm-3 col-form-label">Qty<sup class="error">&nbsp;*</sup></label>
                        <div class="col-sm-3">
                            <input id="ProduksiQty" name="ProduksiQty" type="text" class="form-control form-control-sm double" value="">
                        </div> 
                        <label for="ProduksiQtyRef" class="col-sm-2 col-form-label">Dari PO</label>
                        <label for="ProduksiQty" class="col-sm-3 col-form-label fw-bold"><?= $_dataitem->PODetailQty. " ".$_dataitem->MsItemUoM ?></label>
                </div>
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
    var datestartready = moment();
    var req_status_add = 0;

    $("#ProduksiDate").daterangepicker({
        singleDatePicker: true,
        startDate: datestartready,
        showDropdowns: true,
        locale: {
            "format": "DD/MM/YYYY",
            "customRangeLabel": "Pilih Tanggal Sendiri",
        }
    },function(start, end) {
        datestartready = start;
        get_code();
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
    $('#MsWorkplaceId,#MsEmpId').on('select2:select', function (e) {
        get_code();
    });
    $("#MsEmpId").select2({ 
        dropdownParent: $("#modal-action .modal-content"),
    })
    load_dst(); 
    function get_code(){
        $.ajax({
            type: "POST",
            data:{
                workplace : $("#MsWorkplaceId").val(),
                month :  datestartready.format("MM"),
                year : datestartready.format("YYYY"),
                EmpId: $("#MsEmpId").val()
            },
            url: "<?= site_url('message/message_inventory/ready_stock_code/') ?>",
            success: function(data) {
                $("#ProduksiCode").val(data); 
            } 
        })
    }
    get_code();

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
            "ProduksiCode": $("#ProduksiCode").val(),
            "ProduksiDate": moment(datestartready).format('YYYY-MM-DD'),
            "ProduksiDate2": moment().format('YYYY-MM-DD'),
            "MsEmpId": $("#MsEmpId").val(),
            "MsStaffId": 0,
            "ProduksiRef": "<?= $_dataitem->PODetailRef ?>",
            "MsItemId": "<?= $_dataitem->MsItemId ?>",
            "MsVendorCode": "<?= $_dataitem->MsVendorCode ?>",
            "ProduksiType" : 1,
            "ProduksiStatus" : 2,
            "ProduksiRemarks" : $("#ProduksiRemarks").val(),
            "ProduksiQty" : $("#ProduksiQty").val(),
            "MsWorkplaceId" : $("#MsWorkplaceId").val(),
        };
        /* -------------------------------------------------     SEND DATA SERVER    ---------------------------------------------- */
        $.ajax({
            method: "POST",
            url: "<?= site_url("function/client_data_inventory/data_produksi_add") ?>",
            data: {
                "data": dataheader, 
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
                    text: 'Tambah data berhasil',
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
                    text: 'Tambah data gagal',
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