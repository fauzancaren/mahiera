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
                        <input id="InvTICode" name="InvTICode" type="text" class="form-control form-control-sm" value="<?= $_data->InvTICode ?>" readonly>
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
                        <input id="MsEmpId" name="MsEmpId" type="text" class="form-control form-control-sm" value="<?= $_data->MsEmpName ?>" readonly>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="InvTIDst" class="col-sm-3 col-form-label">Ke Toko</label>
                     <div class="col-sm-9">
                        <input id="InvTIDst" name="InvTIDst" type="text" data-val="<?= $_data->InvTIDst ?>" class="form-control form-control-sm" value="<?= $_data->DstCode ?>" readonly>
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
                        <input id="InvTIRef" name="InvTIRef" type="text" class="form-control form-control-sm" value="<?= $_data->InvTIRef ?>" placeholder="Cari data TI" readonly>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="InvTISrc" class="col-sm-3 col-form-label">Dari Toko</label>
                     <div class="col-sm-9">
                        <div class="input-group">
                           <input id="InvTISrc" name="InvTISrc" type="text" data-val="<?= $_data->InvTISrc ?>" class="form-control form-control-sm" value="<?= $_data->SrcCode ?>" readonly>
                        </div>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="InvTIRemarks" class="col-sm-3 col-form-label">Keterangan</label>
                     <div class="col-sm-9">
                        <textarea class="form-control form-control-sm" id="InvTIRemarks" name="InvTIRemarks"><?= $_data->InvTIRemarks ?></textarea>
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
   var datestart = moment("<?= $_data->InvTIDate ?>");
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
   var data_detail = <?= JSON_ENCODE($_detail) ?>;

   var table_data = [];
   var counter = 0;
   for (let i = 0; i < data_detail.length; i++) {
      counter++;
      var htmlItem = '<div class="row">';
      htmlItem += '   <div class="col-lg-6 col-12 mb-lg-0 mb-2" >';
      htmlItem += '       <span class="fw-bold">' + data_detail[i]["MsItemCode"] + '-' + data_detail[i]["MsItemName"] + ' (' + data_detail[i]["MsVendorCode"] + ')</span><br>';
      htmlItem += '       <span>Rp. ' + data_detail[i]["MsItemPrice"] + '</span>&nbsp;|&nbsp;<span>' + data_detail[i]["MsItemSize"] + '</span>&nbsp;|&nbsp;' + data_detail[i]["MsItemPcsM2"] + '</span>';
      htmlItem += '   </div>';
      htmlItem += '   <div class="col-lg-3 col-6">';
      htmlItem += '       Qty TO : <input type="text" class="input-in-table double" name="podetailqty" value="' + data_detail[i]["InvTIDetailQtyRef"] + '" disabled/><span>&nbsp;(' + data_detail[i]["MsItemUoM"] + ')</span>';
      htmlItem += '   </div>';
      htmlItem += '   <div class="col-lg-3 col-6">';
      htmlItem += '       Qty Receive : <input type="text" class="input-in-table double" name="grpodetailqty" value="' + data_detail[i]["InvTIDetailQty"] + '"/><span>&nbsp;(' + data_detail[i]["MsItemUoM"] + ')</span>';
      htmlItem += '   </div>';
      table_data.push([counter, htmlItem, data_detail[i]["MsItemId"], data_detail[i]["MsVendorCode"], data_detail[i]["InvTIDetailQtyRef"], data_detail[i]["InvTIDetailQty"]]);
   }
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
   t.on("click", "tr", function() {
      $(this).find("input").focus();
   });

   t.on("draw", function() {
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
         "MsEmpId": <?= $_session["MsEmpId"] ?>,
         "InvTIRemarks": $("#InvTIRemarks").val(),
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
         url: "<?= site_url("function/client_data_inventory/data_ti_edit/") . $_data->InvTIId ?>",
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