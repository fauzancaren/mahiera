<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-xl">
      <div class="modal-content" name="form-action">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp;PURCHASE ORDER</h6>
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
                     <label for="POCode" class="col-sm-3 col-form-label">No. Doc<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-9">
                        <input id="POCode" name="POCode" type="text" class="form-control form-control-sm" value="<?= $_data->POCode ?>" readonly>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="PODate" class="col-sm-3 col-form-label">Tanggal<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-9">
                        <input id="PODate" name="PODate" type="text" class="form-control form-control-sm" value="">
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="datavendor" class="col-sm-3 col-form-label">Vendor</label>
                     <div class="col-sm-9">
                        <div class="input-group">
                           <select class="custom-select custom-select-sm form-select form-select-sm" id="datavendor" name="datavendor" style="width:100%" disabled>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="MsWorkplaceId" class="col-sm-3 col-form-label">Toko</label>
                     <div class="col-sm-3 ">
                        <div class="input-group">
                           <select class="custom-select custom-select-sm form-select form-select-sm  display-store" id="MsWorkplaceId" name="MsWorkplaceId" style="width:100%">';
                              <?php
                              $db = $this->db->get("TblMsWorkplace")->result();
                              foreach ($db as $key) {
                                 echo '<option value="' . $key->MsWorkplaceId . '" ' . ($_data->MsWorkplaceId == $key->MsWorkplaceId ? "selected" : "") . '>' . $key->MsWorkplaceCode . '</option>';
                              }
                              ?>
                           </select>
                        </div>
                     </div>
                     <label for="PODst" class="col-sm-3 col-form-label">Dikirim Ke</label>
                     <div class="col-sm-3 ">
                        <div class="input-group">
                           <select class="custom-select custom-select-sm form-select form-select-sm  display-store" id="PODst" name="PODst" style="width:100%">';
                              <option value="0" <?= ($_data->PODst == 0 ? "selected" : "") ?>>CUSTOMER</option>
                              <?php
                              $db = $this->db->get("TblMsWorkplace")->result();
                              foreach ($db as $key) {
                                 echo '<option value="' . $key->MsWorkplaceId . '" ' . ($_data->PODst == $key->MsWorkplaceId ? "selected" : "") . '>' . $key->MsWorkplaceCode . '</option>';
                              }
                              ?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="POName" class="col-sm-3 col-form-label">Admin<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-9">
                        <div class="input-group">
                           <select class="custom-select custom-select-sm form-select form-select-sm " id="MsEmpId" name="MsEmpId" style="width:100%">';
                              <?php
                              $db = $this->db->get("TblMsEmployee")->result();
                              foreach ($db as $key) {
                                 echo '<option value="' . $key->MsEmpId . '" ' . ($_data->MsEmpId == $key->MsEmpId ? "selected" : "") . '>' . $key->MsEmpName . '</option>';
                              }
                              ?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="POEstimate" class="col-sm-3 col-form-label">Estimasi Selesai<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-9">
                        <input id="POEstimate" name="POEstimate" type="text" class="form-control form-control-sm" value="">
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="PORemarks" class="col-sm-3 col-form-label">Catatan</label>
                     <div class="col-sm-9">
                        <textarea class="form-control form-control-sm" id="PORemarks" name="PORemarks"><?= $_data->PORemarks ?></textarea>
                     </div>
                  </div>
               </div>
               <div class="col-xl-6 col-11 my-1">
                  <div class="row mb-1 align-items-center">
                     <div class="label-border-right">
                        <span class="label-dialog">Reference</span>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="SalesRef" class="col-sm-3 col-form-label">No. Ref<sup class="error">&nbsp;(optional)</sup></label>
                     <div class="col-sm-9 group-input">
                        <input id="SalesRef" name="SalesRef" type="text" class="form-control form-control-sm" value="<?= $_data->SalesRef ?>" placeholder="Cari data sales" readonly>
                     </div>
                  </div>

                  <div class="row mb-1 align-items-center">
                     <div class="col-sm-9 offset-3" id="detail-customer">
                     </div>
                  </div>
               </div>
               <div class="col-lg-12 col-11 my-1">
                  <div class="row justify-content-center">
                     <div class="col-12">
                        <div class="row mb-1 align-items-center">
                           <div class="label-border-right mb-3" style="position:relative">
                              <span class="label-dialog">Detail Item</span>
                           </div>
                        </div>
                     </div>
                     <div class="col-12">
                        <button class="btn btn-success btn-sm py-1 me-1" id="add-item-bom" type="button">
                           <i class="fas fa-plus" aria-hidden="true"></i>
                           <span class="fw-bold">
                              &nbsp;Tambah Item Baru
                           </span>
                        </button>
                        <div class="card " style="min-height:100px;">
                           <div class="card-body p-2 ">
                              <table id="tb_data_item" class="table table-hover align-middle responsive" style='font-family:"Sans-serif", Helvetica; font-size:80%;width:100%'>
                                 <thead class="thead-dark" style="display:none;">
                                    <tr>
                                       <th>html</th>
                                       <th>MsItemId</th>
                                       <th>MsVendorCode</th>
                                       <th>MsItemUoM</th>
                                       <th>SalesDetailQty</th>
                                       <th>PODetailQtyTotal</th>
                                       <th>PODetailQty</th>
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
            <button type="submit" class="btn btn-success" id="btn-submit">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
         </div>
      </div>
   </div>
</div>
<script>
   /*  ARRAY SELECT */
   var datestart = moment("<?= $_data->PODate ?>");
   var dateestimate = moment("<?= $_data->POEstimate ?>");
   var req_status_add = 0;

   $("#PODate").daterangepicker({
      singleDatePicker: true,
      startDate: datestart,
      showDropdowns: true,
      locale: {
         "format": "DD/MM/YYYY",
         "customRangeLabel": "Pilih Tanggal Sendiri",
      }
   }, function(start, end) {
      datestart = start;
      $('#POEstimate').data('daterangepicker').minDate = start;
      if (dateestimate < datestart) {
         dateestimate = datestart;
         $('#POEstimate').data('daterangepicker').startDate = start;
         $('#POEstimate').val(start.format("DD/MM/YYYY"));
      }
   });

   $("#POEstimate").daterangepicker({
      singleDatePicker: true,
      startDate: dateestimate,
      minDate: datestart,
      showDropdowns: true,
      locale: {
         "format": "DD/MM/YYYY",
         "customRangeLabel": "Pilih Tanggal Sendiri",
      }
   }, function(start, end) {
      dateestimate = start;
   });
   var table_data = [];
   var t = $("#tb_data_item").DataTable({
      "searching": false,
      "ajax": function(data, callback, settings) {
         callback({
            data: table_data
         }) //reloads data 
      },
      "columns": [{
            "width": 5
         },
         null,
      ],
      "columnDefs": [{
         "targets": [2, 3],
         "visible": false,
      }, ],
      "lengthChange": false,
      "paging": false,
      "ordering": false,
      "autoWidth": true,
      "info": false
   });


   var counter = 1;
   $("#add-item-bom").on("click", function() {
      var htmlItem = '<div class="row">';
      htmlItem += '   <div class="col-lg-7 col-12 mb-lg-0 mb-2" >';
      htmlItem += '       <select class="custom-select custom-select-sm form-select form-select-sm selectitem" placeholder="cari nama item/"></select>';
      htmlItem += '   </div>';
      table_data.push([counter, htmlItem, "-", "-", 0]);
      $("#add-item-bom").prop("disabled", true);

      refresh_data_table(false);
   });

   t.on("click", "tr", function() {
      $(this).find("input").focus();
   });

   t.on("draw", function() {
      $(".selectitem").select2({
         placeholder: "Cari Nama Item",
         dropdownParent: $("#modal-action .modal-content"),
         ajax: {
            dataType: "json",
            url: "<?= site_url("function/client_data_master/get_data_master_item/") ?>" + $("#datavendor").val(),
            delay: 800,
            data: function(params) {
               return {
                  search: params.term
               }
            },
            processResults: function(data, page) {
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
            return data['text'];
         }
      });
      $(".selectitem").select2("open");
      $(".select2-search__field").each(function(key, value) {
         value.focus()
      })

      $(".selectitem").on("select2:open", function(e) {
         //console.log("open-select");
         const selectId = e.target.id
         $(".select2-search__field").each(function(key, value) {
            value.focus()
         })
      })
      $(".selectitem").on("select2:select", function(e) {
         var data = e.params.data;

         for (var i = 0; table_data.length > i; i++) {
            if (table_data[i][2] == data.MsItemId && table_data[i][3] == data.MsVendorCode) {
               Swal.fire({
                  icon: 'error',
                  text: 'Data Sudah Ada',
                  showConfirmButton: false,
                  allowOutsideClick: false,
                  allowEscapeKey: false,
                  timer: 1000
               });
               $(this).select2("open");
               return false;
            }
         }
         var htmlItem = '<div class="row">';
         htmlItem += '   <div class="col-lg-7 col-12 mb-lg-0 mb-2" >';
         htmlItem += '       <span class="fw-bold">' + data.MsItemCode + '-' + data.MsItemName + '</span><br>';
         htmlItem += '       <span>Supplier : <b>' + data.MsVendorCode + '</b></span><br>';
         htmlItem += '       <span>Rp. ' + data.MsItemPrice + '</span>&nbsp;|&nbsp;<span>' + data.MsItemSize + '</span>&nbsp;|&nbsp;' + data.MsItemPcsM2 + '</span>';
         htmlItem += '   </div>';
         htmlItem += '   <div class="col-lg-3 col-6">';
         htmlItem += '       Qty<span>&nbsp;(' + data.MsItemUoM + ')</span> : <input type="text" class="input-in-table double" name="MsItemBomDetailCount" value=""/>';
         htmlItem += '   </div>';
         htmlItem += '   <div class="col-lg-2 col-6">';
         htmlItem += '       <div class="d-flex flex-row justify-content-end">';
         htmlItem += '           <a onclick="hapus_item_click(' + data.MsItemId + ',\'' + data.MsVendorCode + '\')" class="me-2 text-danger pointer m-2" title="Hapus Item"><i class="fas fa-trash-alt fa-lg"></i></a>';
         htmlItem += '       </div>';
         htmlItem += '   </div>';
         table_data[table_data.length - 1][1] = htmlItem;
         table_data[table_data.length - 1][2] = data.MsItemId;
         table_data[table_data.length - 1][3] = data.MsVendorCode;
         table_data[table_data.length - 1][4] = 0;

         $("#add-item-bom").prop("disabled", false);
         refresh_data_table();

      });

      $('input[name="MsItemBomDetailCount"]').each(function(index) {
         $(this).val(table_data[index][4]);
      });
   });
   hapus_item_click = function(MsItemId, MsVendorCode) {
      for (var i = 0; table_data.length > i; i++) {
         if (table_data[i][2] == MsItemId && table_data[i][3] == MsVendorCode) {
            var index = i;
            const swalWithBootstrapButtons = Swal.mixin({
               customClass: {
                  confirmButton: 'btn btn-success mx-1',
                  cancelButton: 'btn btn-secondary mx-1'
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
   refresh_data_table = function(change = true) {
      for (var i = 0; table_data.length > i; i++) {
         table_data[i][0] = i + 1;
      }
      t.ajax.reload();
      var doubleinputs = Array.from(document.getElementsByClassName("double"));
      doubleinputs.forEach(function(doubleinput) {
         new Cleave(doubleinput, {
            numeral: true,
            numeralDecimalMark: ".",
            delimiter: ","
         })
      });
      $('input[name="MsItemBomDetailCount"]').each(function(index) {
         $(this).keyup(function() {
            table_data[index][4] = this.value;
         });
      });
      $(".input-in-table").each(function(key, value) {
         value.focus()
      })
   }
   refresh_data_table();

   var data_vendor = <?= JSON_ENCODE($_vendor) ?>;
   var data = [];
   data.push({
      id: <?= $_data->MsVendorId ?>,
      text: "<?= $_data->MsVendorCode ?>" + " - " + "<?= $_data->MsVendorName ?>"
   });
   $("#MsWorkplaceId,#MsEmpId,#PODst").select2({
      dropdownParent: $("#modal-action .modal-content"),
   })
   $("#datavendor").select2({
      data: data,
      dropdownParent: $("#modal-action .modal-content"),
   })
   $('#datavendor').on('select2:select', function(e) {
      table_data = [];

      $("#add-item-bom").prop("disabled", false);
      t.ajax.reload();
      load_data_sales();
   });
   table_data = [];
   data["detail"] = <?= json_encode($_detail) ?>;
   for (let i = 0; i < data["detail"].length; i++) {
      counter++;
      var htmlItem = '<div class="row">';
      htmlItem += '   <div class="col-lg-7 col-12 mb-lg-0 mb-2" >';
      htmlItem += '       <span class="fw-bold">' + data["detail"][i]["MsItemCode"] + '-' + data["detail"][i]["MsItemName"] + ' (' + data["detail"][i]["MsVendorCode"] + ')</span><br>';
      htmlItem += '       <span>' + data["detail"][i]["MsItemSize"] + '</span>&nbsp;|&nbsp;' + data["detail"][i]["MsItemPcsM2"] + '</span>';
      htmlItem += '   </div>';
      htmlItem += '   <div class="col-lg-3 col-6">';
      htmlItem += '       Qty<span>&nbsp;(' + data["detail"][i]["MsItemUoM"] + ')</span> : <input type="text" class="input-in-table double" name="MsItemBomDetailCount" value=""/>';
      htmlItem += '   </div>';
      htmlItem += '   <div class="col-lg-2 col-6">';
      htmlItem += '       <div class="d-flex flex-row justify-content-end">';
      htmlItem += '           <a onclick="hapus_item_click(' + data["detail"][i]["MsItemId"] + ',\'' + data["detail"][i]["MsVendorCode"] + '\')" class="me-2 text-danger pointer m-2" title="Hapus Item"><i class="fas fa-trash-alt fa-lg"></i></a>';
      htmlItem += '       </div>';
      htmlItem += '   </div>';
      table_data.push([counter, htmlItem, data["detail"][i]["MsItemId"], data["detail"][i]["MsVendorCode"], data["detail"][i]["PODetailQty"]]);
   }
   if ($("#SalesRef").val() == "") {
      $("#add-item-bom").prop("disabled", false);
   } else {

      $("#add-item-bom").prop("disabled", true);
   }
   refresh_data_table();
   /* load data */
   load_data_sales = function() {
      $("#wait").show();
      $("#tb_data_sales").hide();
      console.log($("#datavendor").val());
      $.ajax({
         type: "POST",
         url: "<?php echo site_url('function/client_datatable_sales/get_data_sales_ref/') ?>",
         data: {
            "search": $("#search-data-sales").val(),
            "vendor": $("#datavendor").val(),
         },
         success: function(response) {
            $("#tb_data_sales").html(response);
            $("#wait").hide();
            $("#tb_data_sales").show();
         },
         error: function(xhr, status, error) {
            console.log(xhr.responseText);
            req_status = 0;
         }
      });
   }





   $("#btn-submit").click(function() {
      if (table_data.length == 0) {
         Swal.fire({
            icon: 'error',
            text: 'Data Item Belum ada',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            timer: 1500
         });
         return false;
      }
      var total = 0;
      for (let i = 0; i < table_data.length; i++) {
         console.log(table_data[i][4]);
         if (table_data[i][4] == 0) {
            Swal.fire({
               icon: 'error',
               text: 'Data Qty tidak boleh kosong',
               showConfirmButton: false,
               allowOutsideClick: false,
               allowEscapeKey: false,
               timer: 1500
            });
            return false;
         }
      };
      var dataheader = {
         "POCode": $("#POCode").val(),
         "PODate": datestart.format('YYYY-MM-DD'),
         "POEstimate": dateestimate.format('YYYY-MM-DD'),
         "MsVendorId": $("#datavendor").val(),
         "SalesRef": $("#SalesRef").val(),
         "POName": $("#POName").val(),
         "PORemarks": $("#PORemarks").val(),
         "POStatus": 0,
         "MsWorkplaceId": $("#MsWorkplaceId").val(),
         "MsEmpId": $("#MsEmpId").val(),
         "PODst": $("#PODst").val(),
         "PODelete": 0,
      };

      var detailitem = [];
      for (var i = 0; table_data.length > i; i++) {
         /* data_item (html,itemid,vendorcode,price,qty,disc,uom,total) */
         var data = {
            "MsItemId": table_data[i][2],
            "PODetailQty": table_data[i][4],
            "PODetailRef": $("#POCode").val(),
            "PODetailStatus": 0,
         };
         detailitem.push(data);
      }
      /* -------------------------------------------------     SEND DATA SERVER    ---------------------------------------------- */
      $.ajax({
         method: "POST",
         url: "<?= site_url("function/client_data_pembelian/data_po_edit/") ?>" + <?= $_data->POId ?>,
         data: {
            "data": dataheader,
            "item": detailitem,
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
                  text: 'Edit data berhasil',
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
                  text: 'Edit data gagal',
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