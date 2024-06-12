<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-xl">
      <div class="modal-content" name="form-action">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp;Good Receipt PO (GRPO)</h6>
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
                        <input id="POCode" name="POCode" type="text" class="form-control form-control-sm" value="<?= $_grpo->GRPOCode ?>" readonly>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="PODate" class="col-sm-3 col-form-label">Tanggal<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-9">
                        <input id="PODate" name="PODate" type="text" class="form-control form-control-sm" value="">
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="MsVendorId" class="col-sm-3 col-form-label">Vendor</label>
                     <div class="col-sm-9">
                        <div class="input-group">
                           <select class="custom-select custom-select-sm form-select form-select-sm" id="MsVendorId" name="MsVendorId" style="width:100%" disabled>
                              <option value="<?= $_grpo->MsVendorId ?>"><?= $_grpo->MsVendorCode . ' - ' . $_grpo->MsVendorName ?></option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="MsWorkplaceId" class="col-sm-3 col-form-label">Terima di</label>
                     <div class="col-sm-9">
                        <div class="input-group">
                           <select class="custom-select custom-select-sm form-control form-control-sm" id="MsWorkplaceId" name="MsWorkplaceId" style="width:100%">
                              <option value="0">CUSTOMER</option>
                              <?php
                              foreach ($_dataworkplace as $key) {
                                 echo '<option value="' . $key->MsWorkplaceId . '"  ' . ($this->session->userdata("MsWorkplaceId") == $key->MsWorkplaceId ? "selected" : "") . '>' . $key->MsWorkplaceCode . '</option>';
                              }
                              ?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="POName" class="col-sm-3 col-form-label">Admin<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-9">
                        <input id="POName" name="POName" type="text" class="form-control form-control-sm" value="<?= $_grpo->MsEmpName ?>" readonly>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="PORemarks" class="col-sm-3 col-form-label">Keterangan</label>
                     <div class="col-sm-9">
                        <textarea class="form-control form-control-sm" id="PORemarks" name="PORemarks"><?= $_grpo->GRPORemarks ?></textarea>
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
                        <input id="SalesRef" name="SalesRef" type="text" class="form-control form-control-sm" value="<?= $_grpo->GRPORef ?>" placeholder="Cari data PO" readonly>
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
            <button type="submit" class="btn btn-success" id="btn-submit" disabled>Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
         </div>
      </div>
   </div>
</div>
<script>
   /*  ARRAY SELECT */
   var datestart = moment('<?= $_grpo->GRPODate ?>');
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

   var data_store = <?= JSON_ENCODE($_dataworkplace) ?>;

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

   load_select = function() {
      var data = [];
      if ($("#SalesRef").val() == "") {
         data_vendor.forEach(element => {
            data.push({
               id: element["MsVendorId"],
               text: element["MsVendorCode"] + " - " + element["MsVendorName"]
            });
         });
         $("#datavendor").select2({
            data: data,
            dropdownParent: $("#modal-action .modal-content"),
         });
         $('#datavendor').on('select2:select', function(e) {
            table_data = [];
            $("#add-item-bom").prop("disabled", false);
            t.ajax.reload();
            load_data_sales();
         });
      }
   }
   load_select();

   load_data_sales = function() {
      $("#wait").show();
      $("#tb_data_sales").hide();
      $.ajax({
         type: "POST",
         url: "<?php echo site_url('function/client_datatable_pembelian/get_data_po_ref/') ?>",
         data: {
            "search": $("#search-data-sales").val(),
            "store": $("#datastore").val(),
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
   $("#MsWorkplaceId").select2({
      dropdownParent: $("#modal-action .modal-content"),
   })
   $("#MsWorkplaceId").val(<?= $_grpo->MsWorkplaceId ?>).trigger("change");
   $('#search-data-sales').keyup(function() {
      load_data_sales();
   });

   $('#datastore').change(function() {
      load_data_sales();
   });

   $('#GRPOHold').change(function() {
      if (this.checked) {
         $('#GRPORemarksHold').attr("readonly", false);
      } else {
         $('#GRPORemarksHold').attr("readonly", true);
      }
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
   refresh_data_table = function() {
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
      $('input[name="grpodetailqty"]').each(function(index) {
         $(this).keyup(function() {
            table_data[index][4] = this.value.replaceAll(",", "");
         });
      });
      $(".input-in-table").each(function(key, value) {
         value.focus()
      })
   }

   $.ajax({
      type: "POST",
      dataType: "json",
      url: "<?php echo site_url('function/client_data_pembelian/get_data_po/') . $_grpo->POId ?>",
      success: function(response) {
         $("#detail-customer").html("");
         if (!(response["dataheader"]["SalesRef"] == "" || response["dataheader"]["SalesRef"] == "-")) {
            if (response["dataheader"]["MsCustomerCompany"] == "-") {
               var cust = response["dataheader"]["MsCustomerName"];
            } else if (response["dataheader"]["MsCustomerName"] == "-") {
               var cust = response["dataheader"]["MsCustomerCompany"];
            } else {
               var cust = response["dataheader"]["MsCustomerName"] + " (" + response["dataheader"]["MsCustomerCompany"] + ")";
            }
            if (response["dataheader"]["MsCustomerTelp2"] == "-" || response["dataheader"]["MsCustomerTelp2"] == "") {
               var telp = response["dataheader"]["MsCustomerTelp1"];
            } else {
               var telp = response["dataheader"]["MsCustomerTelp1"] + "/" + response["dataheader"]["MsCustomerTelp2"];
            }
            var html = '<div class = "card shadow-sm card-delivery select" >';
            html += '<div class = "p-2 ps-4">';
            html += '<span class = "card-text" > PO Dari sales </span><br>';
            html += '<span class = "card-title fw-bold" >' + response["dataheader"]["SalesRef"] + '</span><br>';
            html += '<span class = "card-text" >' + cust + '</span><br> ';
            html += '<span class = "card-text" >' + telp + '</span><br> ';
            html += '<span class = "card-text" >' + response["dataheader"]["MsCustomerAddress"] + '</span><br> ';
            html += '</div></div>';
            $("#detail-customer").html(html);
         } else {
            var html = '<div class = "card shadow-sm card-delivery select" >';
            html += '<div class = "p-2 ps-4">';
            html += '<span class = "card-text" > PO Manual tanpa sales </span><br>';
            html += '<span class = "card-title fw-bold" >' + response["dataheader"]["PORemarks"] + '</span><br>';
            html += '<span class = "card-title" >Dibuat oleh ' + response["dataheader"]["POName"] + '</span><br>';
            html += '</div></div>';
            $("#detail-customer").html(html);
         }
         table_data = [];
         counter = 0;
         var item = <?= JSON_ENCODE($_item) ?>;

         function get_sum_po(itemid, vendor) {
            var total = 0;
            for (var i = 0; response["datadetail"].length > i; i++) {
               if (itemid == response["datadetail"][i]['MsItemId'] && vendor == response["datadetail"][i]['MsVendorCode']) {
                  total += parseFloat(response["datadetail"][i]['PODetailQty']);
               }
            }
            return total;
         }
         for (let i = 0; i < item.length; i++) {
            counter++;
            var htmlItem = '<div class="row">';
            htmlItem += '   <div class="col-lg-6 col-12 mb-lg-0 mb-2" >';
            htmlItem += '       <span class="fw-bold">' + item[i]["MsItemCode"] + '-' + item[i]["MsItemName"] + ' (' + item[i]["MsVendorCode"] + ')</span><br>';
            htmlItem += '       <span>' + item[i]["MsItemSize"] + '</span>&nbsp;|&nbsp;' + item[i]["MsItemPcsM2"] + '</span>';
            htmlItem += '   </div>';
            htmlItem += '   <div class="col-lg-3 col-6">';
            htmlItem += '       Qty PO : <input type="text" class="input-in-table double" name="podetailqty" value="' + get_sum_po(item[i]["MsItemId"], item[i]["MsVendorCode"]) + '" disabled/><span>&nbsp;(' + item[i]["MsItemUoM"] + ')</span>';
            htmlItem += '   </div>';
            htmlItem += '   <div class="col-lg-3 col-6">';
            htmlItem += '       Qty Receive : <input type="text" class="input-in-table double" name="grpodetailqty" value="' + item[i]["GRPODetailQty"] + '"/><span>&nbsp;(' + item[i]["MsItemUoM"] + ')</span>';
            htmlItem += '   </div>';
            table_data.push([counter, htmlItem, item[i]["MsItemId"], item[i]["MsVendorCode"], item[i]["GRPODetailQty"], get_sum_po(item[i]["MsItemId"], item[i]["MsVendorCode"])]);
         }
         refresh_data_table();
         $("#btn-submit").attr("disabled", false);

      },
      error: function(xhr, status, error) {
         console.log(xhr.responseText);
         req_status = 0;
      }
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
      var total = 0;
      for (let i = 0; i < table_data.length; i++) {
         if (table_data[i][3] == 0) {
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
         "GRPODate": moment(datestart).format('YYYY-MM-DD'),
         "MsVendorId": $("#MsVendorId").val(),
         "MsEmpId": <?= $_session["MsEmpId"] ?>,
         "GRPORemarks": $("#PORemarks").val(),
         "GRPORef": $("#SalesRef").val(),
         "MsWorkplaceId": $("#MsWorkplaceId").val(),
      };
      var detailitem = [];
      for (var i = 0; table_data.length > i; i++) {
         /* data_item (html,itemid,vendorcode,price,qty,disc,uom,total) */
         var data = {
            "MsItemId": table_data[i][2],
            "MsVendorCode": table_data[i][3],
            "GRPODetailQty": table_data[i][4],
            "GRPODetailRef": $("#POCode").val(),
         };
         detailitem.push(data);
      }

      /* -------------------------------------------------     SEND DATA SERVER    ---------------------------------------------- */
      $.ajax({
         method: "POST",
         url: "<?= site_url("function/client_data_sales/data_grpo_edit/") . $_grpo->GRPOId ?>",
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
                  text: 'Simpan data perubahan berhasil',
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
                  text: 'Simpan data perubahan gagal',
                  showConfirmButton: false,
                  allowOutsideClick: false,
                  allowEscapeKey: false,
                  timer: 1500
               });
            }
         }
      });
   });
</script>