<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-xl">
      <div class="modal-content" name="form-action">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp;Terima barang (TI)</h6>
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
                     <label for="SalesCode" class="col-sm-3 col-form-label">No. TO<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-9">
                        <input id="SalesCode" name="SalesCode" type="text" class="form-control form-control-sm" value="<?= $_transferin->InvTOCode ?>" readonly>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="TOCode" class="col-sm-3 col-form-label">No. TI<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-9">
                        <input id="TOCode" name="TOCode" type="text" class="form-control form-control-sm" value="<?= $_transferin->InvTICode ?>" readonly>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="PODate" class="col-sm-3 col-form-label">Tanggal<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-9">
                        <input id="PODate" name="PODate" type="text" class="form-control form-control-sm" value="">
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="POName" class="col-sm-3 col-form-label">Admin<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-9">
                        <input id="POName" name="POName" type="text" class="form-control form-control-sm" value="<?= $_session['MsEmpName'] ?>" readonly>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="datavendor" class="col-sm-3 col-form-label">Dari Toko</label>
                     <div class="col-sm-9">
                        <div class="input-group">
                           <select class="custom-select custom-select-sm form-select form-select-sm" id="InvTOSrc" name="InvTOSrc" style="width:100%" disabled>
                           </select>
                        </div>
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
                     <label for="datavendor" class="col-sm-3 col-form-label">Kirim Ke</label>
                     <div class="col-sm-9">
                        <div class="input-group">
                           <select class="custom-select custom-select-sm form-select form-select-sm" id="InvTODst" name="InvTODst" style="width:100%">
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="TORemarks" class="col-sm-3 col-form-label">Keterangan</label>
                     <div class="col-sm-9">
                        <textarea class="form-control form-control-sm" id="TORemarks" name="TORemarks"></textarea>
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
                                       <th>InvTODetailQtyTotal</th>
                                       <th>InvTODetailQty</th>
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
   var datestart = moment();
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
   });

   var data_vendor = <?= JSON_ENCODE($_store) ?>;

   load_src = function() {
      var data = [];
      data_vendor.forEach(element => {
         data.push({
            id: element["MsWorkplaceId"],
            text: element["MsWorkplaceCode"] + " - " + element["MsWorkplaceName"]
         });
      });
      $("#InvTOSrc").select2({
         data: data,
         dropdownParent: $("#modal-action .modal-content"),
      })
      $('#InvTOSrc').on('select2:select', function(e) {
         load_dst(false);
      });
   }
   load_dst = function(val = true) {
      var data = [];
      data.push({
         id: 0,
         text: "CUSTOMER"
      });
      data_vendor.forEach(element => {
         if ($("#InvTOSrc").val() != element["MsWorkplaceId"]) {
            data.push({
               id: element["MsWorkplaceId"],
               text: element["MsWorkplaceCode"] + " - " + element["MsWorkplaceName"]
            });
         }
      });
      if (!val) {
         $('#InvTODst option').remove();
         $("#InvTODst").select2('destroy');
      }
      $("#InvTODst").select2({
         data: data,
         dropdownParent: $("#modal-action .modal-content"),
      })
   }
   load_src();
   $('#InvTOSrc').val(<?= $_transferin->InvTOSrc ?>); // Change the value or make some change to the internal state
   $('#InvTOSrc').trigger('change.select2'); // Notify only Select2 of changes 
   load_dst();
   $('#InvTODst').val(<?= $_transferin->InvTODst ?>); // Change the value or make some change to the internal state
   $('#InvTODst').trigger('change.select2'); // Notify only Select2 of changes 


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
            url: "<?= site_url("function/client_data_master/get_data_master_item/") ?>",
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
         htmlItem += '       <span>' + data.MsItemSize + '</span>&nbsp;|&nbsp;' + data.MsItemPcsM2 + '</span>';
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
            table_data[index][4] = this.value.replaceAll(",", "");
         });
      });
      $(".input-in-table").each(function(key, value) {
         value.focus()
      })
   }
   var data_item_edit = <?= JSON_ENCODE($_item) ?>;
   var data_item = <?= JSON_ENCODE($_itemref) ?>;

   function get_sum_ti(itemid, vendor) {
      var total = 0;
      for (var i = 0; data_item.length > i; i++) {
         if (itemid == data_item[i]['MsItemId'] && vendor == data_item[i]['MsVendorCode']) {
            total += parseFloat(data_item[i]['InvTIDetailQty']);
         }
      }
      return total;
   }


   for (var i = 0; data_item_edit.length > i; i++) {
      var totaltransfer = get_sum_ti(data_item_edit[i]['MsItemId'], data_item_edit[i]['MsVendorCode']);
      var htmlItem = '<div class="row">';
      htmlItem += '   <div class="col-6 mb-lg-0 mb-2" >';
      htmlItem += '       <span class="fw-bold">' + data_item_edit[i]['MsItemCode'] + '-' + data_item_edit[i]['MsItemName'] + ' (' + data_item_edit[i]['MsVendorCode'] + ')</span><br>';
      htmlItem += '       <span>' + data_item_edit[i]['MsItemSize'] + '</span>&nbsp;|&nbsp;' + data_item_edit[i]['MsItemPcsM2'] + '</span>';
      htmlItem += '   </div>';
      htmlItem += '   <div class="col-2 ps-1 pe-0">';
      htmlItem += '        <div class="d-flex flex-column">';
      htmlItem += '             <span  style="color:gray;">Total dari Transfer :</span>';
      htmlItem += '             <span class="fw-bold style="color:gray;" name="SalesDetailQty">' + data_item_edit[i]['InvTODetailQty'] + ' ' + data_item_edit[i]['MsItemUoM'] + '</span>';
      htmlItem += '        </div>';
      htmlItem += '   </div>';
      htmlItem += '   <div class="col-2 ps-1 pe-0">';
      htmlItem += '        <div class="d-flex flex-column">';
      htmlItem += '             <span  style="color:gray;">Total sudah diterima :</span>';
      htmlItem += '             <span class="fw-bold style="color:gray;" name="SalesDetailQty">' + totaltransfer + ' ' + data_item_edit[i]['MsItemUoM'] + '</span>';
      htmlItem += '        </div>';
      htmlItem += '   </div>';
      htmlItem += '   <div class="col-2">';
      htmlItem += '       Qty<span>&nbsp;(' + data_item_edit[i]['MsItemUoM'] + ')</span> : <input type="text" class="input-in-table double" name="MsItemBomDetailCount" value=""/>';
      htmlItem += '   </div>';
      table_data.push([counter, htmlItem,
         data_item_edit[i]['MsItemId'],
         data_item_edit[i]['MsVendorCode'],
         data_item_edit[i]['InvTODetailQty'],
      ]);
      counter++;
   }
   console.log(table_data);
   refresh_data_table();

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
         total += table_data[i][4];
      };
      if (total == 0) {
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


      var dataheader = {
         "InvTIRef": $("#SalesCode").val(),
         "InvTICode": $("#TOCode").val(),
         "InvTIDate": moment(datestart).format('YYYY-MM-DD'),
         "InvTIDate2": moment().format('YYYY-MM-DD'),
         "InvTISrc": $("#InvTOSrc").val(),
         "InvTIDst": $("#InvTODst").val(),
         "MsEmpId": <?= $_session["MsEmpId"] ?>,
         "InvTIRemarks": $("#TORemarks").val(),
      };
      var detailitem = [];
      for (var i = 0; table_data.length > i; i++) {
         /* data_item (html,itemid,vendorcode,price,qty,disc,uom,total) */
         if (table_data[i][4] > 0) {
            var data = {
               "MsItemId": table_data[i][2],
               "msVendorCode": table_data[i][3],
               "InvTIDetailQty": table_data[i][4],
               "InvTIDetailRef": $("#TOCode").val(),
            };
            detailitem.push(data);
         }
      }
      /* -------------------------------------------------     SEND DATA SERVER    ---------------------------------------------- */
      $.ajax({
         method: "POST",
         url: "<?= site_url("function/client_data_sales/data_ti_add") ?>",
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
                  text: 'Tambah data berhasil',
                  showConfirmButton: false,
                  allowOutsideClick: false,
                  allowEscapeKey: false,
                  timer: 1500,
               }).then((result) => {
                  if (result.dismiss === Swal.DismissReason.timer) {
                     load_data_table_sales();
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