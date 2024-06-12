<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-xl">
      <div class="modal-content" name="form-action">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;PURCHASE ORDER - <?= ($_sales->MsCustomerTypeId == 1 ? $_sales->MsCustomerName : $_sales->MsCustomerName . ' (' . $_sales->MsCustomerCompany . ')') ?></h6>
            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="row justify-content-center">
               <div class="col-lg-6 col-11 my-1">
                  <div class="row mb-1 align-items-center">
                     <div class="label-border-right">
                        <span class="label-dialog">Dokument</span>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="POCode" class="col-sm-3 col-form-label">No. Doc<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-9">
                        <input id="POCode" name="POCode" type="text" class="form-control form-control-sm" value="" readonly>
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
                           <select class="custom-select custom-select-sm form-select form-select-sm" id="MsVendorId" name="MsVendorId" style="width:100%">
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="MsWorkplaceId" class="col-sm-3 col-form-label">Toko</label>
                     <div class="col-sm-3 ">
                        <div class="input-group">
                           <select class="custom-select custom-select-sm form-select form-select-sm " id="MsWorkplaceId" name="MsWorkplaceId" style="width:100%">';
                              <?php
                              $db = $this->db->get("TblMsWorkplace")->result();
                              foreach ($db as $key) {
                                 echo '<option value="' . $key->MsWorkplaceId . '" ' . ($_user["MsWorkplaceId"] == $key->MsWorkplaceId ? "selected" : "") . '>' . $key->MsWorkplaceCode . '</option>';
                              }
                              ?>
                           </select>
                        </div>
                     </div>
                     <label for="PODst" class="col-sm-3 col-form-label">Dikirim Ke</label>
                     <div class="col-sm-3 ">
                        <div class="input-group">
                           <select class="custom-select custom-select-sm form-select form-select-sm " id="PODst" name="PODst" style="width:100%">';
                              <option value="0">CUSTOMER</option>
                              <?php
                              $db = $this->db->get("TblMsWorkplace")->result();
                              foreach ($db as $key) {
                                 echo '<option value="' . $key->MsWorkplaceId . '">' . $key->MsWorkplaceCode . '</option>';
                              }
                              ?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="POName" class="col-sm-3 col-form-label">Admin<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-9 ">
                        <div class="input-group">
                           <select class="custom-select custom-select-sm form-select form-select-sm " id="MsEmpId" name="MsEmpId" style="width:100%">';
                              <?php
                              $db = $this->db->get("TblMsEmployee")->result();
                              foreach ($db as $key) {
                                 echo '<option value="' . $key->MsEmpId . '" ' . ($_user["MsEmpId"] == $key->MsEmpId ? "selected" : "") . '>' . $key->MsEmpName . '</option>';
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
                     <label for="PORef" class="col-sm-3 col-form-label">No. Sales<sup class="error">&nbsp;(optional)</sup></label>
                     <div class="col-sm-9">
                        <input id="PORef" name="PORef" type="text" class="form-control form-control-sm" value="<?= $_sales->SalesCode ?>" readonly>
                     </div>
                  </div>
                  <div class="col-sm-9 offset-3">
                     <div class="card shadow-sm card-delivery select">
                        <div class="p-2 ps-4">
                           <span class="card-title fw-bold"><?= $_sales->MsCustomerCode . " - " . ($_sales->MsCustomerCompany == "-" ? $_sales->MsCustomerName : ($_sales->MsCustomerName == "-" ? $_sales->MsCustomerCompany : $_sales->MsCustomerName . " (" . $_sales->MsCustomerCompany . ")"))    ?></span><br>
                           <span class="card-text"><?= ($_sales->MsCustomerTelp2 == "-" ? $_sales->MsCustomerTelp1 : $_sales->MsCustomerTelp1 . " / " . $_sales->MsCustomerTelp2) ?></span><br>
                           <span class="card-text"><?= $_sales->MsCustomerAddress ?></span><br>
                           <span class="card-text fw-bold">admin : <?= $_sales->MsEmpName ?></span><br>
                        </div>
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
            <button type="submit" class="btn btn-success" id="btn-submit">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
         </div>
      </div>
   </div>
</div>
<script>
   /*  ARRAY SELECT */
   var datestart = moment();
   var dateestimate = moment().add(7, "days");
   var req_status_add = 0;

   function next_kode() {
      if (typeof window.ajaxRequestSingle !== "undefined") {
         window.ajaxRequestSingle.abort();
      }

      window.ajaxRequestSingle = $.ajax({
         method: "POST",
         url: "<?= site_url("function/client_data_pembelian/get_next_po") ?>",
         data: {
            "MsWorkplaceId": $("#MsWorkplaceId").val(),
            "MsEmpId": $("#MsEmpId").val(),
            "Month": datestart.format('MM'),
            "Year": datestart.format('YYYY')
         },
         success: function(data) {
            $("#POCode").val(data)
         }
      });
   }
   next_kode();
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
      next_kode();

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


   var data_vendor = <?= JSON_ENCODE($_vendor) ?>;
   var data = [];
   for (var i = 0; data_vendor.length > i; i++) {
      datas = {
         id: data_vendor[i]['MsVendorCode'],
         text: data_vendor[i]['MsVendorCode'] + " - " + data_vendor[i]['MsVendorName']
      };
      data.push(datas)
   }

   $('#MsVendorId').select2({
      placeholder: "Cari PO",
      dropdownParent: $("#modal-action .modal-content"),
      data: data
   });
   $('#MsVendorId').on('select2:select', function(e) {
      get_detail_item();
      tbl_item.ajax.reload();
   });

   $('#MsEmpId,#MsWorkplaceId,#PODst').select2({
      dropdownParent: $("#modal-action .modal-content")
   });

   $("#MsEmpId , #MsWorkplaceId").on("change.select2", function(e) {
      next_kode();
   });
   /* data_item (html,itemid,vendorcode,uom,SalesDetailQty,PODetailQtyTotal,PODetailQty) */
   var data_item = [];
   var data_item_edit = <?= JSON_ENCODE($_item) ?>;
   var data_po = <?= JSON_ENCODE($_itempo) ?>;

   function get_sum_po(itemid, vendor) {
      var total = 0;
      for (var i = 0; data_po.length > i; i++) {
         if (itemid == data_po[i]['MsProdukId'] && vendor == data_po[i]['PODetailVarian']) {
            total += parseFloat(data_po[i]['PODetailQty']);
         }
      }
      return total;
   }

   function get_detail_item() {
      data_item = []; 
      for (var i = 0; data_item_edit.length > i; i++) { 
         if ($('#MsVendorId').val() == "WHO" || data_item_edit[i]['SalesDetailVarian'].includes($('#MsVendorId').val())) {
            var total_po = get_sum_po(data_item_edit[i]['MsProdukId'], data_item_edit[i]['SalesDetailVarian']);
            var htmlItem = '<div class="row row-table get-item">';
            htmlItem += '     <div class="col-lg-5 col-12 mb-lg-0 mb-2" >';
            htmlItem += '       <span class="fw-bold">' + data_item_edit[i]['MsProdukCode'] + '-' + data_item_edit[i]['MsProdukName'] + '</span><br>'; 
            htmlItem += '       <span  style="color:gray;font-size:0.6rem">' + data_item_edit[i]['SalesDetailVarian'] + '</span>';
            htmlItem += '     </div>';
            htmlItem += '     <div class="col-lg-7 col-12">';
            htmlItem += '       <div class="row" >';
            htmlItem += '          <div class="col-4 pe-0">';
            htmlItem += '             <div class="d-flex flex-column">';
            htmlItem += '                <span  style="color:gray;">Yang Sudah di PO :</span>';
            htmlItem += '                <span class="fw-bold style="color:gray;" name="PODetailQtyTotal">' + total_po + ' ' + data_item_edit[i]['SatuanName'] + '</span>';
            htmlItem += '             </div>';
            htmlItem += '          </div>';
            htmlItem += '          <div class="col-4 ps-1 pe-0">';
            htmlItem += '             <div class="d-flex flex-column">';
            htmlItem += '                <span  style="color:gray;">Total dari penjualan :</span>';
            htmlItem += '                <span class="fw-bold style="color:gray;" name="SalesDetailQty">' + data_item_edit[i]['SalesDetailQty'] + ' ' + data_item_edit[i]['SatuanName'] + '</span>';
            htmlItem += '             </div>';
            htmlItem += '          </div>';
            htmlItem += '          <div class="col-4 ps-1 pe-0">';
            htmlItem += '             <div class="d-flex flex-column">';
            htmlItem += '                <span  style="color:gray;">Qty&nbsp;(' + data_item_edit[i]['SatuanName'] + ')</span>';
            htmlItem += '                <input type="text" class="input-in-table double" name="PODetailQty" style="min-width:90px" value=""/>';
            htmlItem += '             </div>';
            htmlItem += '          </div>';
            htmlItem += '        </div>';
            htmlItem += '     </div>';
            var arr = [];
               arr["html"] = htmlItem;
               arr["MsProdukId"] = data_item_edit[i]['MsProdukId'];
               arr["PODetailVarian"] = data_item_edit[i]['SalesDetailVarian'];
               arr["SatuanName"] = data_item_edit[i]['SatuanName'];
               arr["SalesDetailQty"] = data_item_edit[i]['SalesDetailQty'];
               arr["PODetailQtyTotal"] = total_po;
               arr["PODetailQty"] = data_item_edit[i]['SalesDetailQty'];
               arr["SatuanId"] = data_item_edit[i]['SatuanId']; 
            data_item.push(arr);   
         }
      }
   }
   var tbl_item = $("#tb_data_item").DataTable({
      "searching": false,
      "ajax": function(data, callback, settings) {
         callback({
            data: data_item
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

   tbl_item.on("draw", function() {
      $(".get-item").each(function(index, thisrow) { 
         var textqty = $(thisrow).find('input[name="PODetailQty"]').val(data_item[index]["PODetailQty"]).keyup(function() {
            data_item[index]["PODetailQty"] = this.value.replaceAll(",", "");
            total_item();
         }).focusout(function() {
            if (this.value == "" || this.value == "-") {
               $(this).val(0);
            }
         }).focus(); 
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


   get_detail_item();
   tbl_item.ajax.reload();

   $("#btn-submit").click(async function() {
      if (!req_status_add) {
         $("#btn-submit").html('<i class="fas fa-circle-notch fa-spin"></i> Loading');
         if (data_item.length == 0) {
            $("#btn-submit").html('Simpan');
            Swal.fire({
               icon: 'error',
               text: 'Data item tidak boleh kosong',
               showConfirmButton: false,
               allowOutsideClick: false,
               allowEscapeKey: false,
               timer: 1500
            });
            return;
         }

         var totalqty = 0;
         for (var i = 0; data_item.length > i; i++) {
            totalqty += data_item[i][6];
         }
         if (totalqty == 0) {
            $("#btn-submit").html('Simpan');
            Swal.fire({
               icon: 'error',
               text: 'Qty tidak boleh 0',
               showConfirmButton: false,
               allowOutsideClick: false,
               allowEscapeKey: false,
               timer: 1500
            });
            return;
         }
         var dataheader = {
            "POCode": $("#POCode").val(),
            "PODate": datestart.format('YYYY-MM-DD'),
            "PODate2": datestart.format('YYYY-MM-DD'),
            "POEstimate": dateestimate.format('YYYY-MM-DD'),
            "MsVendorCode": $("#MsVendorId").val(),
            "SalesRef": $("#PORef").val(),
            "POName": $("#POName").val(),
            "PORemarks": $("#PORemarks").val(),
            "POStatus": ($("#MsVendorId").val() == "WHO" ? "0" : "1"),
            "MsWorkplaceId": $("#MsWorkplaceId").val(),
            "MsEmpId": $("#MsEmpId").val(),
            "PODst": $("#PODst").val(),
            "PODelete": 0,
         };

         var detailitem = [];
         for (var i = 0; data_item.length > i; i++) {
            /* data_item (html,itemid,vendorcode,price,qty,disc,uom,total) */
            if (data_item[i]["PODetailQty"] > 0) {
               var data = {
                  "MsProdukId": data_item[i]["MsProdukId"],
                  "PODetailVarian": data_item[i]["PODetailVarian"],
                  "SatuanId": data_item[i]["SatuanId"],
                  "PODetailStatus": ($("#MsVendorId").val() == "WHO" ? 0 : 1),
                  "PODetailQty": data_item[i]["PODetailQty"],
                  "PODetailRef": $("#POCode").val(),
               };
               detailitem.push(data);
            }
         }

         /* -------------------------------------------------     SEND DATA SERVER    ---------------------------------------------- */
         $.ajax({
            method: "POST",
            url: "<?= site_url("function/client_data_sales/data_po_add") ?>",
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
                        $.redirect('<?php echo site_url('export/datasales/po/a5/-') ?>', {
                           'code': $("#POCode").val(),
                        }, "POST", "_blank");
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
      }
   });
</script>