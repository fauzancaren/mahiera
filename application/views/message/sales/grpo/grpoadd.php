<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-xl">
      <div class="modal-content" name="form-action">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;Good Receipt PO (GRPO)</h6>
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
                        <input id="POCode" name="POCode" type="text" class="form-control form-control-sm" value="<?= $_code ?>" readonly>
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
                              <option value="<?= $_po->MsVendorCode ?>"><?= $_po->MsVendorCode . ' - ' . $_po->MsVendorName ?></option>
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
                                 echo '<option value="' . $key->MsWorkplaceId . '" >' . $key->MsWorkplaceCode . '</option>';
                              }
                              ?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="POName" class="col-sm-3 col-form-label">Admin<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-9">
                        <input id="POName" name="POName" type="text" class="form-control form-control-sm" value="<?= $_session["MsEmpName"] ?>" readonly>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="PORemarks" class="col-sm-3 col-form-label">Keterangan</label>
                     <div class="col-sm-9">
                        <textarea class="form-control form-control-sm" id="PORemarks" name="PORemarks"></textarea>
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
                        <input id="SalesRef" name="SalesRef" type="text" class="form-control form-control-sm" value="<?= $_po->POCode ?>" placeholder="Cari data PO" readonly>
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

   var data_store = <?= JSON_ENCODE($_dataworkplace) ?>;
   var data_po = <?= JSON_ENCODE($_po) ?>;
   var data_delivery = <?= JSON_ENCODE($_detaildelivery) ?>;

   var table_data = [];
   var t = $("#tb_data_item").DataTable({
      "searching": false,
      "ajax": function(data, callback, settings) {
         callback({
            data: table_data
         }) //reloads data 
      }, 
      "columnDefs": [
         { 
            "targets": [0],
            "data": "html",
         } 
      ],
      "lengthChange": false,
      "paging": false,
      "ordering": false,
      "autoWidth": true,
      "info": false
   });
   t.on("draw", function() {
      $(".get-item").each(function(index, thisrow) {
         function total_item() {
            var sisa = (table_data[index]["grpodetailqty"] - table_data[index]["PODetailQty"]);
            // if (table_data[index]["grpodetailqty"] > sisa) {
            //    // data_item[index][6] = sisa;
            //    //$(thisrow).find('input[name="DeliveryDetailQty"]').val(sisa);
            // };
         }
         var textqty = $(thisrow).find('input[name="GRPODetailQty"]').val(table_data[index]["GRPODetailQty"]).keyup(function() {
            table_data[index]["GRPODetailQty"] = this.value.replaceAll(",", "");
            total_item();
         }).focusout(function() {
            if (this.value == "" || this.value == "-") {
               $(this).val(0);
            }
         }).focus();
         var textqty2 = $(thisrow).find('input[name="GRPODetailWasteQty"]').val(table_data[index]["GRPODetailWasteQty"]).keyup(function() {
            table_data[index]["GRPODetailWasteQty"] = this.value.replaceAll(",", "");
            total_item();
         }).focusout(function() {
            if (this.value == "" || this.value == "-") {
               $(this).val(0);
            }
         });
         var textqtyDesc = $(thisrow).find('textarea[name="GRPODetailWasteDesc"]').val(table_data[index]["GRPODetailWasteDesc"]).keyup(function() {
            table_data[index]["GRPODetailWasteDesc"] = this.value; 
         });
          
         total_item();
      });

      var doubleinputs = Array.from(document.getElementsByClassName("double"));
      doubleinputs.forEach(function(doubleinput) {
         new Cleave(doubleinput, {
            numeral: true,
            numeralDecimalMark: ".",
            delimiter: ","
         })
      });
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
   });
   $("#MsWorkplaceId").val(data_po["PODst"]).attr("disabled",true); 
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

   $("#detail-customer").html("");
   if (!(data_po["SalesRef"] == "" || data_po["SalesRef"] == "-")) {
      if (data_po["MsCustomerCompany"] == "-") {
         var cust = data_po["MsCustomerName"];
      } else if (data_po["MsCustomerName"] == "-") {
         var cust = data_po["MsCustomerCompany"];
      } else {
         var cust = data_po["MsCustomerName"] + " (" + data_po["MsCustomerCompany"] + ")";
      }
      if (data_po["MsCustomerTelp2"] == "-" || data_po["MsCustomerTelp2"] == "") {
         var telp = data_po["MsCustomerTelp1"];
      } else {
         var telp = data_po["MsCustomerTelp1"] + "/" + data_po["MsCustomerTelp2"];
      }
      var html = '<div class = "card shadow-sm card-delivery select" >';
      html += '<div class = "p-2 ps-4">';
      html += '<span class = "card-text" > PO Dari sales </span><br>';
      html += '<span class = "card-title fw-bold" >' + data_po["SalesRef"] + '</span><br>';
      html += '<span class = "card-text" >' + cust + '</span><br> ';
      html += '<span class = "card-text" >' + telp + '</span><br> ';
      html += '<span class = "card-text" >' + data_po["MsCustomerAddress"] + '</span><br> ';
      html += '</div></div>';
      $("#detail-customer").html(html);
   } else {
      var html = '<div class = "card shadow-sm card-delivery select" >';
      html += '<div class = "p-2 ps-4">';
      html += '<span class = "card-text" > PO Manual tanpa sales </span><br>';
      html += '<span class = "card-title fw-bold" >' + data_po["PORemarks"] + '</span><br>';
      html += '<span class = "card-title" >Dibuat oleh ' + data_po["POName"] + '</span><br>';
      html += '</div></div>';
      $("#detail-customer").html(html);
   }

   table_data = []; 
   for (let i = 0; i < data_delivery.length; i++) { 
      var htmlItem = `  <div class="row  row-table get-item"> 
                           <div class="col-lg-6 col-12 mb-lg-0 mb-2"> 
                              <span class="fw-bold">${data_delivery[i]["MsProdukCode"]}-${data_delivery[i]["MsProdukName"]}</span><br> 
                              <span>${data_delivery[i]["DeliveryDetailVarian"]}</span> 
                           </div> 
                           <div class="col-lg-3 col-12 ">
                              <div class="d-flex">
                                 <div class="d-flex flex-column px-1">
                                    <span>Qty PO (${data_delivery[i]["SatuanName"]})</span> 
                                    <input type="text" class="input-in-table double" name="podetailqty" value="${data_delivery[i]["DeliveryDetailQty"]}" disabled/>
                                 </div>  
                                 <div class="d-flex flex-column px-1">
                                    <span>Diterima (${data_delivery[i]["SatuanName"]})</span> 
                                    <input type="text" class="input-in-table double" name="GRPODetailQty" value="${data_delivery[i]["DeliveryDetailQty"]}"/>
                                 </div>   
                                 <div class="d-flex flex-column px-1">
                                    <span>Rusak (${data_delivery[i]["SatuanName"]})</span> 
                                    <input type="text" class="input-in-table double" name="GRPODetailWasteQty" value="${data_delivery[i]["DeliveryDetailSpareQty"]}"/>
                                 </div>   
                              </div>
                           </div>
                           <div class="col-lg-3 col-12"> 
                              <div class="d-flex flex-column px-2">
                                 <span>Catatan :</span> 
                                 <textarea class="form-control form-control-sm" name="GRPODetailWasteDesc"></textarea>
                              </div>   
                           </div>
                        </div>`;

      
      var arr = [];
         arr["html"] = htmlItem;
         arr["MsProdukId"] = data_delivery[i]['MsProdukId'];
         arr["GRPODetailVarian"] = data_delivery[i]['DeliveryDetailVarian'];
         arr["SatuanName"] = data_delivery[i]['SatuanName'];
         arr["GRPODetailQty"] = data_delivery[i]['DeliveryDetailQty']; 
         arr["GRPODetailWasteQty"] = 0; 
         arr["GRPODetailWasteDesc"] = ""; 
         arr["PODetailQty"] = data_delivery[i]['DeliveryDetailQty']; 
         arr["SatuanId"] = data_delivery[i]['SatuanId']; 
         table_data.push(arr);  
   }
   $("#btn-submit").attr("disabled", false);
   t.ajax.reload();

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
         "GRPOCode": $("#POCode").val(),
         "GRPODate": moment(datestart).format('YYYY-MM-DD'),
         "GRPODate2": moment().format('YYYY-MM-DD'),
         "MsVendorCode": $("#MsVendorId").val(),
         "GRPORef": $("#SalesRef").val(),
         "GRPORef2": "<?= $_delivery->DeliveryCode ?>",
         "MsEmpId": <?= $_session["MsEmpId"] ?>,
         "GRPORemarks": $("#PORemarks").val(),
         "GRPODst": $("#MsWorkplaceId").val(),
         "MsWorkplaceId": <?= $_session["MsWorkplaceId"] ?>,
      };
      var detailitem = [];
      for (var i = 0; table_data.length > i; i++) {
         /* data_item (html,itemid,vendorcode,price,qty,disc,uom,total) */
         var data = {
            "MsProdukId": table_data[i]["MsProdukId"],
            "GRPODetailVarian": table_data[i]["GRPODetailVarian"],
            "GRPODetailQty": table_data[i]["GRPODetailQty"],
            "GRPODetailWasteQty": table_data[i]["GRPODetailWasteQty"],
            "GRPODetailWasteDesc": table_data[i]["GRPODetailWasteDesc"],
            "SatuanId": table_data[i]["SatuanId"],
            "GRPODetailRef": $("#POCode").val(),
         };
         detailitem.push(data);
      }

      /* -------------------------------------------------     SEND DATA SERVER    ---------------------------------------------- */
      $.ajax({
         method: "POST",
         url: "<?= site_url("function/client_data_sales/data_grpo_add") ?>",
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
                  text: 'Simpan data berhasil',
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
                  text: 'Simpan data gagal',
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