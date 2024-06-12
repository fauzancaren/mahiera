<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-dialog-centered ">
      <div class="modal-content" name="create-toko">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;Tambah Keterangan Asset</h5>
               <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class=" row mb-1">
               <label for="AssetDetailId" class="col-sm-3 col-form-label">Asset Property<sup class="error">&nbsp;*</sup></label>
               <div class="col-sm-9">
                  <select class="custom-select custom-select-sm form-select form-select-sm" id="AssetDetailId" name="AssetDetailId" style="width:100%">
                     <?php
                     foreach ($_asset as $row) {
                        echo "<option value='$row->AssetDetailId'>" . $row->AssetDetailMerk . " - " . $row->AssetDetailType . "</option>";
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
                        echo "<option value='" . $row->assetKelolaTypeId . "'  data-name='" . $row->assetKelolaTypeName . "' >" . $row->assetKelolaTypeName .  "</option>";
                     }
                     ?>
                  </select>
               </div>
            </div>
            <div class="row mb-1">
               <label for="assetKelolaNote" class="col-sm-3 col-form-label">Keterangan</label>
               <div class="col-sm-9">
                  <input type="text" id="assetKelolaNote" name="assetKelolaNote" class="form-control form-control-sm" value="">
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
      $("#AssetDetailId").select2({
         dropdownParent: $("#modal-action .modal-content")
      });
      $("#assetKelolaTypeIdRef").select2({
         dropdownParent: $("#modal-action .modal-content")
      });

      var StartDateContent = moment();
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
            url: "<?= site_url("function/client_data_tools/assetStatus_add") ?>",
            data: {
               "AssetDetailIdRef": $("#AssetDetailId").val(),
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