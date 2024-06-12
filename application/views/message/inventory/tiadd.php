<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-xl">
      <div class="modal-content" name="form-action">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;Terima barang (TI)</h6>
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
                     <label for="InvTICode" class="col-sm-3 col-form-label">No. Doc<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-9">
                        <input id="InvTICode" name="InvTICode" type="text" class="form-control form-control-sm" value="<?= $_code ?>" readonly>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="InvTIDate" class="col-sm-3 col-form-label">Tanggal<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-9">
                        <input id="InvTIDate" name="InvTIDate" type="text" class="form-control form-control-sm" value="">
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="MsEmpId" class="col-sm-3 col-form-label">Admin<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-9">
                        <input id="MsEmpId" name="MsEmpId" type="text" class="form-control form-control-sm" value="<?= $_session['MsEmpName'] ?>" readonly>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="InvTIDst" class="col-sm-3 col-form-label">Ke Toko</label>
                     <div class="col-sm-9">
                        <input id="InvTIDst" name="InvTIDst" type="text" data-val="0" class="form-control form-control-sm" value="-" readonly>
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
                     <label for="InvTIRef" class="col-sm-3 col-form-label">No. Ref </label>
                     <div class="col-sm-9 group-input">
                        <input id="InvTIRef" name="InvTIRef" type="text" class="form-control form-control-sm" value="" placeholder="Cari data TI" readonly>
                        <button class="btn btn-danger btn-sm close" id="remove-sales" style="display: none;" type="button"><i class="fas fa-times" aria-hidden="true"></i></button>
                        <button class="btn btn-success btn-sm" id="action-sales" type="button"><i class="fas fa-search" aria-hidden="true"></i></button>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="InvTISrc" class="col-sm-3 col-form-label">Dari Toko</label>
                     <div class="col-sm-9">
                        <div class="input-group">
                           <input id="InvTISrc" name="InvTISrc" type="text" data-val="0" class="form-control form-control-sm" value="-" readonly>
                        </div>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="InvTIRemarks" class="col-sm-3 col-form-label">Keterangan</label>
                     <div class="col-sm-9">
                        <textarea class="form-control form-control-sm" id="InvTIRemarks" name="InvTIRemarks"></textarea>
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
<div class="modal fade " id="modal-action-sales" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-lg ">
      <div class="modal-content" name="form-action-armada">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-search text-primary" aria-hidden="true"></i> &nbsp;List Kirim Barang</h5>
               <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-sm-6 col-md-3">
                  <div class="row mb-1 align-items-center">
                     <label for="datastore" class="col-form-label">Ke Toko</label>
                     <div class="col">
                        <div class="input-group">
                           <select class="custom-select custom-select-sm form-select form-select-sm" id="InvTODst" name="InvTODst" style="width:100%">
                           </select>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-sm-6 col-md-3">
                  <div class="row mb-1 align-items-center">
                     <label for="datastore" class="col-form-label">Dari Toko</label>
                     <div class="col">
                        <div class="input-group">
                           <select class="custom-select custom-select-sm form-select form-select-sm" id="InvTOSrc" name="InvTOSrc" style="width:100%">
                           </select>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-sm-12 col-md-6">
                  <div class="row mb-1 align-items-center">
                     <label for="search-data-sales" class="col-form-label">Pencarian<sup class="error">&nbsp;*</sup></label>
                     <div class="col">
                        <input id="search-data-sales" name="search-data-sales" type="text" class="form-control form-control-sm" value="" placeholder="cari No. TO/Nama item">
                     </div>
                  </div>
               </div>

            </div>
            <div id="wait" class="load-container load4" style="display: block;">
               <div class="load-progress"></div>
            </div>
            <div id="tb_data_sales" style="display: none;max-height:400px;overflow-y: auto;">
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
         </div>
      </div>
   </div>
</div>
<script>
   /*  ARRAY SELECT */
   var datestart = moment();
   var req_status_add = 0;

   $("#InvTIDate").daterangepicker({
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

      $('input[name="grpodetailqty"]').each(function(index) {
         $(this).keyup(function() {
            var val = parseInt(this.value.replace(/,/g, ''));
            if (val > parseInt(table_data[index][4])) {
               table_data[index][5] = table_data[index][4];
               this.value = table_data[index][4];
            } else {
               table_data[index][5] = val;
            }
         });
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
            table_data[index][4] = this.value.replaceAll(",", "");;
         });
      });
      $(".input-in-table").each(function(key, value) {
         value.focus()
      })
   }
   refresh_data_table();


   load_to_dst = function() {
      var data = [];
      data_vendor.forEach(element => {
         data.push({
            id: element["MsWorkplaceId"],
            text: element["MsWorkplaceCode"]
         });
      });
      $("#InvTODst").select2({
         data: data,
         dropdownParent: $("#modal-action-sales .modal-content"),
      })
      $('#InvTODst').on('select2:select', function(e) {
         load_to_src(false);
         load_data_sales();
      });
   }
   load_to_src = function(val = true) {
      var data = [];
      data.push({
         id: "",
         text: "Semua Toko"
      });
      data_vendor.forEach(element => {
         if ($("#InvTODst").val() != element["MsWorkplaceId"]) {
            data.push({
               id: element["MsWorkplaceId"],
               text: element["MsWorkplaceCode"]
            });
         }
      });
      if (!val) {
         $('#InvTOSrc option').remove();
         $("#InvTOSrc").select2('destroy');
      }
      $("#InvTOSrc").select2({
         data: data,
         dropdownParent: $("#modal-action-sales .modal-content"),
      })
      $('#InvTOSrc').on('select2:select', function(e) {
         load_data_sales();
      });
   }

   load_to_dst();
   $('#InvTODst').val(<?= $this->session->userdata("MsWorkplaceId") ?>); // Change the value or make some change to the internal state
   $('#InvTODst').trigger('change.select2'); // Notify only Select2 of changes 
   load_to_src();



   load_data_sales = function() {
      $("#wait").show();
      $("#tb_data_sales").hide();
      $.ajax({
         type: "POST",
         url: "<?php echo site_url('function/client_datatable_inventory/get_data_ti_ref/') ?>",
         data: {
            "search": $("#search-data-sales").val(),
            "InvTODst": $("#InvTODst").val(),
            "InvTOSrc": $("#InvTOSrc").val(),
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
   $('#search-data-sales').keyup(function() {
      load_data_sales();
   });
   $("#action-sales").click(function() {
      $("#modal-action-sales").modal("show");
      $("#modal-action").modal("hide");
   })
   $("#modal-action-sales").on("show.bs.modal", function() {
      $("#modal-action").modal("hide");
      load_data_sales();
   });
   $("#modal-action-sales").on("shown.bs.modal", function() {
      $("#modal-action").modal("hide");
   });
   $("#modal-action-sales").on("hidden.bs.modal", function() {
      $("#modal-action").modal("show");
   });
   $("#modal-action-sales").modal("show");
   load_data_sales();

   InvTO_select = function(id) {
      $("#modal-action-sales").modal("hide");
      $.ajax({
         type: "POST",
         dataType: "json",
         url: "<?php echo site_url('function/client_data_inventory/get_data_to/') ?>" + id,
         success: function(response) {
            console.log(response["dataheader"]);
            $('#InvTIRemarks').val(response["dataheader"]["InvTORemarks"]);
            $('#InvTIRef').val(response["dataheader"]["InvTOCode"]);
            $('#InvTISrc').val(response["dataheader"]["srccode"]);
            $('#InvTIDst').val(response["dataheader"]["dstcode"]);
            $('#InvTISrc').data("val", response["dataheader"]["srcid"]);
            $('#InvTIDst').data("val", response["dataheader"]["dstid"]);
            $("#remove-sales").show();
            $("#detail-customer").html("");
            table_data = [];
            counter = 0;
            for (let i = 0; i < response["datadetail"].length; i++) {
               counter++;
               var htmlItem = '<div class="row">';
               htmlItem += '   <div class="col-lg-6 col-12 mb-lg-0 mb-2" >';
               htmlItem += '       <span class="fw-bold">' + response["datadetail"][i]["MsItemCode"] + '-' + response["datadetail"][i]["MsItemName"] + ' (' + response["datadetail"][i]["MsVendorCode"] + ')</span><br>';
               htmlItem += '       <span>Rp. ' + response["datadetail"][i]["MsItemPrice"] + '</span>&nbsp;|&nbsp;<span>' + response["datadetail"][i]["MsItemSize"] + '</span>&nbsp;|&nbsp;' + response["datadetail"][i]["MsItemPcsM2"] + '</span>';
               htmlItem += '   </div>';
               htmlItem += '   <div class="col-lg-3 col-6">';
               htmlItem += '       Qty TO : <input type="text" class="input-in-table double" name="podetailqty" value="' + response["datadetail"][i]["InvTODetailQty"] + '" disabled/><span>&nbsp;(' + response["datadetail"][i]["MsItemUoM"] + ')</span>';
               htmlItem += '   </div>';
               htmlItem += '   <div class="col-lg-3 col-6">';
               htmlItem += '       Qty Receive : <input type="text" class="input-in-table double" name="grpodetailqty" value="' + response["datadetail"][i]["InvTODetailQty"] + '" disabled/><span>&nbsp;(' + response["datadetail"][i]["MsItemUoM"] + ')</span>';
               htmlItem += '   </div>';
               table_data.push([counter, htmlItem, response["datadetail"][i]["MsItemId"], response["datadetail"][i]["MsVendorCode"], response["datadetail"][i]["InvTODetailQty"], response["datadetail"][i]["InvTODetailQty"]]);
            }
            $("#btn-submit").attr("disabled", false);
            refresh_data_table();
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
         "InvTICode": $("#InvTICode").val(),
         "InvTIDate": moment(datestart).format('YYYY-MM-DD'),
         "InvTIDate2": moment().format('YYYY-MM-DD'),
         "InvTISrc": $("#InvTISrc").data("val"),
         "InvTIDst": $("#InvTIDst").data("val"),
         "MsEmpId": <?= $_session["MsEmpId"] ?>,
         "InvTIRemarks": $("#InvTIRemarks").val(),
         "InvTIRef": $("#InvTIRef").val(),
      };
      var detailitem = [];
      for (var i = 0; table_data.length > i; i++) {
         /* data_item (html,itemid,vendorcode,price,qty,disc,uom,total) */
         var data = {
            "MsItemId": table_data[i][2],
            "msVendorCode": table_data[i][3],
            "InvTIDetailQtyRef": table_data[i][4],
            "InvTIDetailQty": table_data[i][5],
            "InvTIDetailRef": $("#InvTICode").val(),
         };
         detailitem.push(data);
      }
      /* -------------------------------------------------     SEND DATA SERVER    ---------------------------------------------- */
      $.ajax({
         method: "POST",
         url: "<?= site_url("function/client_data_inventory/data_ti_add") ?>",
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