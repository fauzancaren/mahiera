<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-xl">
      <div class="modal-content" name="form-action">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-share-square text-primary" aria-hidden="true"></i> &nbsp;Selesaikan Pengiriman</h6>
            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="row justify-content-center">
               <div class="col-xl-6 col-11 my-1">
                  <div class="row mb-1 align-items-center">
                     <div class="label-border-right">
                        <span class="label-dialog">Reference</span>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="PORef" class="col-form-label">No. Sales</label>
                     <div class="col">
                        <input id="PORef" name="PORef" type="text" class="form-control form-control-sm" value="<?= $_delivery->SalesCode ?>" readonly>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="MsWokrplaceCode" class="col-form-label">Toko</label>
                     <div class="col">
                        <input id="MsWokrplaceCode" name="MsWokrplaceCode" type="text" class="form-control form-control-sm" value="<?= $_delivery->MsWorkplaceCode ?>" readonly>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="POAdmin" class="col-form-label">Admin</label>
                     <div class="col">
                        <input id="POAdmin" name="POAdmin" type="text" class="form-control form-control-sm" value="<?= $_delivery->MsEmpName ?>" readonly>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="POAdmin" class="col-form-label">Customer</label>
                     <div class="col">
                        <input id="POAdmin" name="POAdmin" type="text" class="form-control form-control-sm" value="<?= $_customer ?>" readonly>
                     </div>
                  </div>
               </div>
               <div class="col-lg-6 col-11 my-1">
                  <div class="row mb-1 align-items-center">
                     <div class="label-border-right">
                        <span class="label-dialog">Dokument</span>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="DeliveryCode" class="col-form-label">No. Doc<sup class="error">&nbsp;*</sup></label>
                     <div class="col">
                        <input id="DeliveryCode" name="DeliveryCode" type="text" class="form-control form-control-sm" value="<?= $_delivery->DeliveryCode ?>" readonly>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <div class="col-8">
                        <div class="row align-items-center">
                           <label for="DeliveryDate" class="   col-form-label">Tanggal Kirim<sup class="error">&nbsp;*</sup></label>
                           <div class="col">
                              <input id="DeliveryDate" name="DeliveryDate" type="text" class="form-control form-control-sm" value="">
                           </div>
                        </div>
                     </div>
                     <div class="col-4">
                        <div class="row align-items-center">
                           <label for="PODate" class="col-form-label-2">RIT<sup class="error">&nbsp;*</sup></label>
                           <div class="col">
                              <input type="text" class="form-control form-control-sm" value="<?= $_delivery->DeliveryRit ?>" readonly>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <div class="col-8">
                        <div class="row align-items-center">
                           <label for="MsVendorId" class="col-form-label">Armada</label>
                           <div class="col">
                              <div class="input-group">
                                 <select class="custom-select custom-select-sm form-control form-control-sm" id="MsDeliveryId" name="MsDeliveryId">
                                    <?php
                                    $this->db->where("MsDeliveryIsActive", "1");
                                    $query = $this->db->get('TblMsDelivery')->result();
                                    foreach ($query as $key) {
                                       echo '<option value="' . $key->MsDeliveryId . '" ' . ($_delivery->MsDeliveryId == $key->MsDeliveryId ? "selected" : "") . '>' . $key->MsDeliveryName . '</option>';
                                    }
                                    ?>
                                 </select>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-4">
                        <div class="row mb-1 align-items-center MsEmpId">
                           <label for="DeliveryJenis" class="col-form-label-2">Jenis</label>
                           <div class="col">
                              <select class="custom-select custom-select-sm form-control form-control-sm" id="DeliveryJenis" name="DeliveryJenis">
                                 <option value="1" <?= ($_delivery->DeliveryJenis == 1 ? "selected" : "") ?>>PICK-UP</option>
                                 <option value="2" <?= ($_delivery->DeliveryJenis == 2 ? "selected" : "") ?>>ENGKEL</option>
                              </select>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center MsEmpId">
                     <label for="MsVendorId" class="col-form-label">Driver</label>
                     <div class="col">
                        <select class="custom-select custom-select-sm form-control form-control-sm select-modal" id="MsEmpId" name="MsEmpId" style="width:100%" multiple="multiple" required>
                           <?php
                           $db = $this->db->where("MsEmpPositionId", "11")->where("MsEmpIsActive", 1)->get("TblMsEmployee")->result();
                           foreach ($db as $key) {
                              echo '<option value="' . $key->MsEmpId . '">' . $key->MsEmpCode . ' - ' . $key->MsEmpName . '</option>';
                           }
                           ?>
                        </select>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="POAdmin" class="col-form-label">Penerima</label>
                     <div class="col">
                        <input id="POAdmin" name="POAdmin" type="text" class="form-control form-control-sm" value="<?= $_delivery->MsCustomerDeliveryReceive ?>">
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="POAdmin" class="col-form-label">Alamat Kirim</label>
                     <div class="col">
                        <textarea id="POAdmin" name="POAdmin" type="text" class="form-control form-control-sm"><?= $_delivery->MsCustomerDeliveryAddress ?></textarea>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="PORemarks" class="col-form-label">Keterangan</label>
                     <div class="col">
                        <textarea class="form-control form-control-sm" id="PORemarks" name="PORemarks"></textarea>
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
                                       <th>DeliveryDetailQty</th>
                                       <th>DeliverySpare</th>
                                    </tr>
                                 </thead>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="col-xl-6 col-11 my-1">
                  <div class="row mb-1 align-items-center">
                     <label for="PORemarks" class="col-form-label">Tanda Tangan :</label>
                     <div class="col">
                        <div id="sig"></div>
                        <button id="clear" class="btn btn-sm btn-outline-primary">Hapus Tanda Tangan</button>
                        <textarea id="signature64" name="signed" style="display: none"></textarea>
                     </div>
                  </div>
               </div>
               <div class="col-xl-6 col-11 my-1">
                  <div class="row mb-1 align-items-center">
                     <label for="drop_zone" class="col-sm-3 col-form-label">Bukti Pengantaran</label>
                     <div class="col-sm-9">
                        <div class="border">
                           <div class="dropzone" id="file-upload">
                              <div class="dz-message">
                                 <span style="font-size:0.85rem">geser dan tarik file disini atau klik untuk upload</span><br>
                                 <span style="font-size:0.6rem">format file bisa dokumen(word,excel,pdf) atau gambar(png,jpeg,jpg)</span>
                              </div>
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
   var datestart = moment("<?= $_delivery->DeliveryDate ?>");
   $("#DeliveryDate").daterangepicker({
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
   $("#MsDeliveryId").change(function() {
      if ($(this).val() == 1) {
         $(".MsEmpId").show();
      } else {
         $(".MsEmpId").hide();
         $(".select-modal").val('').trigger('change');
      }
   })
   $(".select-modal").select2({
      dropdownParent: $("#modal-action .modal-content"),
      placeholder: "pilih driver yang mengantar",
   });
   var driver = "<?= $_delivery->DeliveryDriver ?>".split(",");

   $('.select-modal').val(driver);
   $('.select-modal').trigger('change'); // Notify any JS components that the value changed

   $("#MsDeliveryId").val("<?= $_delivery->MsDeliveryId ?>").trigger('change');
   var data_item = [];
   var data_item_edit = <?= JSON_ENCODE($_item) ?>;
   for (var i = 0; data_item_edit.length > i; i++) {
      var htmlItem = '<div class="row row-table get-item">';
      htmlItem += '     <div class="col-lg-5 col-12 mb-lg-0 mb-2" >';
      htmlItem += '       <span class="fw-bold">' + data_item_edit[i]['MsItemCode'] + '-' + data_item_edit[i]['MsItemName'] + ' (' + data_item_edit[i]['MsVendorCode'] + ')</span><br>';
      htmlItem += '       <span  style="color:gray;font-size:0.6rem">' + data_item_edit[i]['MsItemCatName'] + '&nbsp;|&nbsp;' + data_item_edit[i]['MsItemSize'] + '&nbsp;|&nbsp;' + data_item_edit[i]['MsItemPcsM2'] + '</span>';
      htmlItem += '     </div>';
      htmlItem += '     <div class="col-lg-7 col-12">';
      htmlItem += '       <div class="row" >';
      htmlItem += '          <div class="col-6 pe-0">';
      htmlItem += '             <div class="d-flex flex-column">';
      htmlItem += '                <span  style="color:gray;">Qty&nbsp;(' + data_item_edit[i]['MsItemUoM'] + ')</span>';
      htmlItem += '                <input type="text" class="input-in-table double" name="DeliveryDetailQty" style="min-width:8rem" value="' + data_item_edit[i]['DeliveryDetailQty'] + '" readonly/>';
      htmlItem += '             </div>';
      htmlItem += '          </div>';
      htmlItem += '          <div class="col-6 ps-1 pe-0">';
      htmlItem += '             <div class="d-flex flex-column">';
      htmlItem += '                <span  style="color:gray;">Spare&nbsp;(' + data_item_edit[i]['MsItemUoM'] + ')</span>';
      htmlItem += '                <input type="text" class="input-in-table double" name="DeliverySpareQty" style="min-width:8rem" value="' + (data_item_edit[i]['DeliverySpareQty'] ?? '0') + '"/>';
      htmlItem += '             </div>';
      htmlItem += '          </div>';
      htmlItem += '        </div>';
      htmlItem += '     </div>';
      data_item.push([htmlItem,
         data_item_edit[i]['MsItemId'],
         data_item_edit[i]['MsVendorCode'],
         data_item_edit[i]['MsItemUoM'],
         data_item_edit[i]['DeliveryDetailQty'],
         (data_item_edit[i]['DeliverySpareQty'] ?? '0'),
      ]);

   }
   var tbl_item = $("#tb_data_item").DataTable({
      "searching": false,
      "ajax": function(data, callback, settings) {
         callback({
            data: data_item
         }) //reloads data 
      },
      "columnDefs": [{
         "targets": [1, 2, 3, 4, 5],
         "visible": false,
      }, ],
      "lengthChange": false,
      "paging": false,
      "ordering": false,
      "autoWidth": true,
      "info": false
   });

   tbl_item.on("draw", function() {
      $(".get-item").each(function(index, thisrow) {
         var textqty = $(thisrow).find('input[name="DeliveryDetailQty"]').val(data_item[index][4]).keyup(function() {
            data_item[index][4] = this.value.replaceAll(",", "");
         }).focusout(function() {
            if (this.value == "" || this.value == "-") {
               $(this).val(0);
            }
         }).focus();
         var textqty = $(thisrow).find('input[name="DeliverySpareQty"]').val(data_item[index][5]).keyup(function() {
            data_item[index][5] = this.value.replaceAll(",", "");
         }).focusout(function() {
            if (this.value == "" || this.value == "-") {
               $(this).val(0);
            }
         });

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

   var sig = $('#sig').signature({
      syncField: '#signature64',
      syncFormat: 'PNG'
   });

   $('#clear').click(function(e) {
      e.preventDefault();
      sig.signature('clear');
      $("#signature64").val('');
   });
   Dropzone.autoDiscover = false;
   var myDropzone = new Dropzone(".dropzone", {
      addRemoveLinks: true,
      dictRemoveFile: '<i class="fas fa-times-circle text-danger"></i>',
      autoProcessQueue: false,
      maxFilesize: 10,
      parallelUploads: 1,
      maxFiles: 1,
      uploadMultiple: false,
      acceptedFiles: "image/*",
      url: "<?= site_url("function/client_data_sales/customer_upload_file/id_toko/id_cust") ?>",
      renameFile: function(file) {
         let newName = "bukti_pengiriman." + (file.type.split("/"))[1];
         return newName;
      }
   });

   myDropzone.on("addedfile", function(file) {
      var maxFiles = 1;
      for (var i = myDropzone.files.length - maxFiles - 1; i >= 0; i--) {
         var f = myDropzone.files[i];
         if (f.upload.uuid !== file.upload.uuid)
            myDropzone.removeFile(f);
      }
   });
   document.onpaste = function(event) {
      var items = (event.clipboardData || event.originalEvent.clipboardData).items;
      for (index in items) {
         var item = items[index];
         if (item.kind === 'file') {
            // adds the file to your dropzone instance
            myDropzone.addFile(item.getAsFile())
         }
      }
   }
   var file_kosong = "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/4gIoSUNDX1BST0ZJTEUAAQEAAAIYAAAAAAIQAABtbnRyUkdCIFhZWiAAAAAAAAAAAAAAAABhY3NwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAQAA9tYAAQAAAADTLQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAlkZXNjAAAA8AAAAHRyWFlaAAABZAAAABRnWFlaAAABeAAAABRiWFlaAAABjAAAABRyVFJDAAABoAAAAChnVFJDAAABoAAAAChiVFJDAAABoAAAACh3dHB0AAAByAAAABRjcHJ0AAAB3AAAADxtbHVjAAAAAAAAAAEAAAAMZW5VUwAAAFgAAAAcAHMAUgBHAEIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAFhZWiAAAAAAAABvogAAOPUAAAOQWFlaIAAAAAAAAGKZAAC3hQAAGNpYWVogAAAAAAAAJKAAAA+EAAC2z3BhcmEAAAAAAAQAAAACZmYAAPKnAAANWQAAE9AAAApbAAAAAAAAAABYWVogAAAAAAAA9tYAAQAAAADTLW1sdWMAAAAAAAAAAQAAAAxlblVTAAAAIAAAABwARwBvAG8AZwBsAGUAIABJAG4AYwAuACAAMgAwADEANv/bAEMAAwICAgICAwICAgMDAwMEBgQEBAQECAYGBQYJCAoKCQgJCQoMDwwKCw4LCQkNEQ0ODxAQERAKDBITEhATDxAQEP/bAEMBAwMDBAMECAQECBALCQsQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEP/AABEIAO4BSAMBIgACEQEDEQH/xAAVAAEBAAAAAAAAAAAAAAAAAAAACf/EABQQAQAAAAAAAAAAAAAAAAAAAAD/xAAUAQEAAAAAAAAAAAAAAAAAAAAA/8QAFBEBAAAAAAAAAAAAAAAAAAAAAP/aAAwDAQACEQMRAD8AqmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD/9k=";
   myDropzone.on("sending", function(file, xhr, formData) {
      // Will send the filesize along with the file as POST data.
      formData.append("filesize", file.size);
      formData.append("fileName", "<?= $_delivery->DeliveryId ?>" + "_bukti");
   });
   myDropzone.on("queuecomplete", function(file) {
      $("#modal-action").modal("hide");
   });
   $('#btn-submit').click(function() {
      if ($("#sig").signature('toDataURL', 'image/jpeg') == file_kosong) {
         Swal.fire({
            icon: 'error',
            text: 'harus masukan tanda tangan penerima',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            timer: 1500
         });
         return false;
      }
      if (!myDropzone.files.length) {
         Swal.fire({
            icon: 'error',
            text: 'Bukti pengantaran harus dimasukan',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            timer: 1500
         });
         return false;
      }

      var detailitem = [];
      var detailitemspare = [];
      for (var i = 0; i < data_item.length; i++) {
         var data = {
            "MsItemId": data_item[i][1],
            "MsVendorCode": data_item[i][2],
            "DeliveryDetailQty": data_item[i][4],
            "DeliveryDetailRef": $("#DeliveryCode").val(),
         };
         detailitem.push(data);
         if (data_item[i][5] > 0) {
            var data = {
               "MsItemId": data_item[i][1],
               "MsVendorCode": data_item[i][2],
               "DeliverySpareQty": data_item[i][5],
               "DeliverySpareRef": $("#DeliveryCode").val(),
            };
            detailitemspare.push(data);

         }
      }
      var dataheader = {
         "DeliveryDate": moment(datestart).format('YYYY-MM-DD'),
         "MsDeliveryId": $("#MsDeliveryId").val(),
         "DeliveryDriver": $(".select-modal").val().toString(),
         "DeliveryJenis": $("#DeliveryJenis").val(),
         "DeliveryStatus": 2,
      };

      $.ajax({
         method: "POST",
         url: "<?= site_url("function/client_data_pengiriman/proses_pengiriman/") ?>" + <?= $_delivery->DeliveryId ?>,
         data: {
            "data": dataheader,
            "item": detailitem,
            "spare": detailitemspare
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
                     $.ajax({
                        method: "POST",
                        url: "<?= site_url("function/client_data_pengiriman/upload_file_tanda_tangan/") ?>" + <?= $_delivery->DeliveryId ?>,
                        data: {
                           "file": $("#sig").signature('toDataURL', 'image/png')
                        }
                     });
                     myDropzone.options.url = "<?= site_url("function/client_data_pengiriman/upload_file_bukti/" . $_delivery->MsWorkplaceId . "/" . $_delivery->MsCustomerId) . "/" . $_delivery->DeliveryId  ?>";
                     myDropzone.processQueue();
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
   });
   
</script>