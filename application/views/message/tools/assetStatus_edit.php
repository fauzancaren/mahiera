<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-dialog-centered ">
      <div class="modal-content" name="create-toko">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp;Edit Keterangan Asset</h5>
               <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class=" row mb-1">
               <label for="assetKelolaId" class="col-sm-3 col-form-label">Asset Property<sup class="error">&nbsp;*</sup></label>
               <div class="col-sm-9">
                  <select class="custom-select custom-select-sm form-select form-select-sm" id="assetKelolaId" name="assetKelolaId" style="width:100%">
                     <?php
                     foreach ($_asset as $row) {
                        echo "<option value='" . $row->AssetDetailId . "' " . ($_data->AssetDetailIdRef == $row->AssetDetailId ? "selected" : "") . ">" . $row->AssetDetailMerk . " - " . $row->AssetDetailType . "</option>";
                     }
                     ?>
                  </select>
               </div>
            </div>
            <div class="row mb-1">
               <label for="AbsenDate" class="col-sm-3 col-form-label">Tanggal</label>
               <div class="col-sm-9">
                  <input type="text" id="AbsenDate" name="AbsenDate" class="form-control form-control-sm" value="">
               </div>
            </div>

            <div class="row mb-1">
               <label for="assetKelolaTypeIdRef" class="col-sm-3 col-form-label">Status<sup class="error">&nbsp;*</sup></label>
               <div class="col-sm-9">
                  <select class="custom-select custom-select-sm form-select form-select-sm" id="assetKelolaTypeIdRef" name="assetKelolaTypeIdRef" style="width:100%">
                     <?php
                     foreach ($_kelola as $row) {
                        echo "<option value='" . $row->assetKelolaTypeId . "'  data-name='" . $row->assetKelolaTypeName . "' " . ($_data->assetKelolaTypeIdRef == $row->assetKelolaTypeId ? "selected" : "") . ">" . $row->assetKelolaTypeName .  "</option>";
                     }
                     ?>
                  </select>
               </div>
            </div>
            <div class="row mb-1">
               <label for="assetKelolaNote" class="col-sm-3 col-form-label">Keterangan</label>
               <div class="col-sm-9">
                  <input type="text" id="assetKelolaNote" name="assetKelolaNote" class="form-control form-control-sm" value="<?= $_data->assetKelolaNote ?>">
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="submit" class="btn btn-success" id="btn-submit">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
         </div>
         </form>
      </div>
   </div>

   <script>
      $("#assetKelolaId").select2({
         dropdownParent: $("#modal-action .modal-content")
      });
      $("#assetKelolaTypeIdRef").select2({
         dropdownParent: $("#modal-action .modal-content")
      });

      var StartDateContent = moment("<?= $_data->assetKelolaDate ?>");
      var EndDateContent = moment();
      $('#AbsenDate').daterangepicker({
         startDate: StartDateContent,
         endDate: EndDateContent,
         singleDatePicker: true,
         locale: {
            "format": 'DD/MM/YYYY',
         }
      }, Date_content);
      Date_content(StartDateContent, EndDateContent);

      function Date_content(start, end) {
         StartDateContent = start;
      }

      $("#btn-submit").click(function() {
         $.ajax({
            method: "POST",
            url: "<?= site_url("function/client_data_tools/assetStatus_edit/") ?>" + <?= $_data->assetKelolaId ?>,
            data: {
               "AssetDetailIdRef": $("#assetKelolaId").val(),
               "assetKelolaTypeIdRef": $("#assetKelolaTypeIdRef").val(),
               "assetKelolaDesc": $("#assetKelolaTypeIdRef").find(':selected').attr('data-name'),
               "assetKelolaDate": StartDateContent.format('YYYY-MM-DD'),
               "assetKelolaNote": $("#assetKelolaNote").val(),
            },
            success: function(data) {
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