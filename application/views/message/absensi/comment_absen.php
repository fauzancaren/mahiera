<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-dialog-centered ">
      <div class="modal-content" name="create-toko">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp;Edit Keterangan Absensi</h5>
               <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class=" row mb-1">
               <label for="AbsenDesc" class="col-sm-3 col-form-label">Keterangan<sup class="error">&nbsp;*</sup></label>
               <div class="col-sm-9">
                  <textarea id="AbsenDesc" name="AbsenDesc" class="form-control form-control-sm"><?= $_absen->AbsenDesc ?></textarea>
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
      $("#btn-submit").click(function() {
         $.ajax({
            method: "POST",
            url: "<?= site_url("function/client_data_absen/absen_edit/") . $_absen->AbsenId ?>",
            data: {
               "AbsenDesc": $("#AbsenDesc").val(),
            },
            success: function(data) {
               $("#btn-submit").html("Simpan");
               console.log(data);
               if (data) {
                  Swal.fire({
                     icon: 'success',
                     text: 'Keterangan Berhasil Dibuat',
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
                     text: 'Simpan data gagal',
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