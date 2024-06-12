<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-xl">
      <div class="modal-content" name="form-action">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;Stock Opname(SO)</h6>
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
                     <label for="TOCode" class="col-sm-3 col-form-label">No. Doc<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-9">
                        <input id="TOCode" name="TOCode" type="text" class="form-control form-control-sm" value="<?= $_code ?>" readonly>
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
               </div>
               <div class="col-xl-6 col-11 my-1">
                  <div class="row mb-1 align-items-center">
                     <div class="label-border-right">
                        <span class="label-dialog"> </span>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="datavendor" class="col-sm-3 col-form-label">Toko</label>
                     <div class="col-sm-9">
                        <div class="input-group">
                           <select class="custom-select custom-select-sm form-select form-select-sm" id="MsWorkplaceId" name="MsWorkplaceId" style="width:100%">
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
                        <div class="card ">
                           <div class="card-body p-2 ">
                              <div class="row justify-content-center">
                                 <div class="col-6">
                                    <div class="row mb-1 align-items-center">
                                       <label for="searchdata" class="col-sm-3 col-form-label">Cari nama item</label>
                                       <div class="col-sm-9 group-input">
                                          <input id="searchdata" name="searchdata" type="text" class="form-control form-control-sm" value="" placeholder="masukan nama item, kode atau vendor">
                                          <button class="btn btn-danger btn-sm close" id="btnsearchdataremove" style="display: none;" type="button"><i class="fas fa-times" aria-hidden="true"></i></button>
                                          <button class="btn btn-primary btn-sm" id="btnsearchdata" type="button"><i class="fas fa-search" aria-hidden="true"></i></button>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-6">
                                    <div class="d-flex flex-row-reverse mb-2">
                                       <input type="file" id="fileExcel" name="fileExcel" style="display:none">
                                       <button class="btn btn-success btn-sm py-1 me-1" id="upload-data-so" type="button">
                                          <i class="fas fa-plus" aria-hidden="true"></i>
                                          <span class="fw-bold">
                                             &nbsp;Upload File
                                          </span>
                                       </button>
                                       <button class="btn btn-primary btn-sm py-1 me-1" id="export-data-so" type="button">
                                          <i class="fas fa-file-export" aria-hidden="true"></i>
                                          <span class="fw-bold">
                                             &nbsp;Export File
                                          </span>
                                       </button>
                                    </div>
                                 </div>
                              </div>
                              <table id="tb_data_item" class="table table-hover align-middle responsive" style='font-family:"Sans-serif", Helvetica; font-size:80%;width:100%'>
                                 <thead class="thead-light">
                                    <tr>
                                       <th>StockId</th>
                                       <th>No.</th>
                                       <th>kode</th>
                                       <th>Nama</th>
                                       <th>Vendor</th>
                                       <th>Toko</th>
                                       <th>Ukuran</th>
                                       <th>UoM</th>
                                       <th>Stock awal</th>
                                       <th>Stock Akhir</th>
                                       <th>Adj. Stock</th>
                                       <th>MsItemId</th>
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
   $(document).ready(function() {
      /*  ARRAY SELECT */
      var datestart = moment();
      var req_status_add = 0;
      var table_data = [];
      var t = $("#tb_data_item").DataTable({
         "scrollY": '300px',
         "width": '100%',
         "sScrollXInner": "100%",
         "scrollCollapse": true,
         "fixedColumns": false,
         "data": table_data,
         "columnDefs": [{
            "targets": [0],
            "visible": false,
            "searchable": false
         }, {
            "targets": [11],
            "visible": false,
            "searchable": false
         }],
         "columns": [{
               "data": 0,
               "defaultContent": ""
            },
            {
               "data": 1,
               "defaultContent": ""
            },
            {
               "data": 2,
               "defaultContent": ""
            },
            {
               "data": 3,
               "defaultContent": ""
            },
            {
               "data": 4,
               "defaultContent": ""
            },
            {
               "data": 5,
               "defaultContent": ""
            },
            {
               "data": 6,
               "defaultContent": ""
            },
            {
               "data": 7,
               "defaultContent": ""
            },
            {
               render: function(data, type, row, meta) {
                  return "<span class=\"label-old\">" + number_format(Number(row[8]), 2, '.', ',') + "</span>";
               }
            },
            {
               render: function(data, type, row, meta) {
                  return " <input type=\"text\" data-index =\"" + meta.row + "\"data-stockid=\"" + row[0] + "\" name=\"input-stock\" class=\"form-control form-control-sm double\" value=\"" + row[9] + "\">";
               }
            },
            {
               render: function(data, type, row, meta) {
                  return "<span class=\"label-new\">" + number_format(Number(row[10]), 2, '.', ',') + "</span>";
               }
            },
            {
               "data": 11,
               "defaultContent": ""
            },
         ],
         "lengthChange": false,
         "paging": false,
         "autoWidth": false,
         "processing": true,
         "serverSide": false,
         "dom": '<"top"i>rt<"bottom"><"clear">'
      });
      t.on('draw', function() {
         var doubleinputs = Array.from(document.getElementsByClassName("double"));
         doubleinputs.forEach(function(doubleinput) {
            new Cleave(doubleinput, {
               numeral: true,
               numeralDecimalMark: ".",
               delimiter: ","
            })
            $(doubleinput).keyup(function() {
               if ($(this).val() == "") {
                  $(this).val(0);
               }
               var idx_table = $(this).data("index");
               var dataold = $(this).parent().parent().find('.label-old').text().replaceAll(",", "");
               var datanew = $(this).val().replaceAll(",", "");
               var adj = Number(datanew) - Number(dataold);
               var some_number = number_format(Number(adj), 2, '.', ',');
               $(this).parent().parent().find('.label-new').text(some_number);
               table_data[idx_table][8] = dataold;
               table_data[idx_table][9] = datanew;
               table_data[idx_table][10] = adj;
            })
         });
         console.log("draw in out");
      });
      var search = $.fn.dataTable.util.throttle(
         function(val) {
            t.search(val).draw();
         },
         400 // Search delay in ms
      );
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
         $('#MsWorkplaceId').on('select2:select', function(e) {
            load_data();
         });
      }
      load_dst();
      $('#MsWorkplaceId').val(<?= $this->session->userdata("MsWorkplaceId") ?>); // Change the value or make some change to the internal state
      $('#MsWorkplaceId').trigger('change.select2'); // Notify only Select2 of changes 
      load_data = function() {
         var no = 1;
         $.ajax({
            method: "POST",
            dataType: "json",
            url: "<?= site_url("function/client_data_inventory/get_data_stock/") ?>" + $('#MsWorkplaceId').val(),
            success: function(data) {
               table_data = [];
               data.forEach(rows => {
                  table_data.push([
                     rows["InvStockId"],
                     no,
                     rows["MsItemCode"],
                     rows["MsItemName"],
                     rows["MsVendorCode"],
                     rows["MsWorkplaceCode"],
                     rows["MsItemSize"],
                     rows["MsItemUoM"],
                     rows["InvStockQty"],
                     0,
                     rows["InvStockQty"],
                     rows["MsItemId"]
                  ]);
                  no++;
               });
               t.clear().rows.add(table_data).draw();
               t.columns.adjust().draw();
            }
         });
      }

      load_data();
      $("#searchdata").on('keypress', function(e) {
         if (e.which == 13) {
            t.search($('#searchdata').val()).draw();
         }
      });
      $('#searchdata').on('keyup', function() {
         if (this.value.length > 0) {
            $("#btnsearchdataremove").show();
         } else {
            $("#btnsearchdataremove").hide();
         }
      });

      $('#btnsearchdataremove').on('click', function() {
         $('#searchdata').val("");
         t.search($('#searchdata').val()).draw();
      });
      $('#btnsearchdata').on('click', function() {
         t.search($('#searchdata').val()).draw();
      });

      t.on("click", "tr", function() {
         $(this).find("input").focus();
      });
      $("#export-data-so").click(function() {
         window.open('<?php echo site_url('function/client_export_inventory/data_so_excel/') ?>' + $('#MsWorkplaceId').val(), '_blank');
      })
      $("#upload-data-so").unbind().bind().click(function(e) {
         e.stopPropagation();
         $("#fileExcel").show().trigger('click').hide();
      });
      $("#fileExcel").unbind().bind().on("change", function(e) {
         var formData = new FormData();
         formData.append('file', $('#fileExcel').prop('files')[0]);
         $.ajax({
            url: ' <?= site_url('function/client_export_inventory/upload_so_excel') ?>',
            type: 'POST',
            data: formData,
            dataType: "json",
            cache: false,
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            success: function(data) {
               var data_upload = data;
               console.log(data_upload);
               data_upload.forEach(row => {
                  $("input[data-stockid='" + row["InvStockId"] + "']").val(row["MsItemStock"]).keyup();
               });
            }
         });
      });
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
         var dataheader = {
            "InvSOCode": $("#TOCode").val(),
            "InvSODate": moment(datestart).format('YYYY-MM-DD'),
            "InvSORemarks": moment().format('YYYY-MM-DD'),
            "MsWorkplaceId": $("#MsWorkplaceId").val(),
            "MsEmpId": <?= $_session["MsEmpId"] ?>,
         };
         var detailitem = [];
         for (var i = 0; table_data.length > i; i++) {
            /* data_item (html,itemid,vendorcode,price,qty,disc,uom,total) */
            var data = {
               "MsItemId": table_data[i][11],
               "msVendorCode": table_data[i][4],
               "InvSODetailQtyOld": table_data[i][8],
               "InvSODetailQtyNew": table_data[i][9],
               "InvSODetailQtyAdj": table_data[i][10],
               "InvSODetailRef": $("#TOCode").val(),
            };
            detailitem.push(data);
         }
         /* -------------------------------------------------     SEND DATA SERVER    ---------------------------------------------- */
         $.ajax({
            method: "POST",
            url: "<?= site_url("function/client_data_inventory/data_so_add") ?>",
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
   });
</script>