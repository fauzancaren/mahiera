<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" name="form-action">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp;Buffer Stock</h6>
            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="row mb-1 align-items-center">
               <label for="InvStockBuffer" class="col-sm-5 col-form-label">Buffer Stock<sup class="error">&nbsp;*</sup></label>
               <div class="col-sm-7">
                  <input id="InvStockBuffer" name="InvStockBuffer" type="text" class="form-control form-control-sm double" value="<?= $_data->InvStockBuffer ?>">
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
   var doubleinputs = Array.from(document.getElementsByClassName("double"));
   doubleinputs.forEach(function(doubleinput) {
      new Cleave(doubleinput, {
         numeral: true,
         numeralDecimalMark: ".",
         delimiter: ","
      })
   });
   $("#btn-submit").click(function() {
      if (typeof window.ajaxRequestSingle !== "undefined") {
         window.ajaxRequestSingle.abort();
      }
      window.ajaxRequestSingle = $.ajax({
         method: "POST",
         url: "<?= site_url("function/client_data_inventory/buffer_stock/") . $_data->InvStockId ?>",
         data: {
            "InvStockBuffer": $("#InvStockBuffer").val(),
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
   });
</script>