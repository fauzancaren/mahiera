<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-md modal-dialog-centered ">
      <div class="modal-content" name="form-action">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp;Ganti Logo/Header Sales Order</h6>
            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="row mb-1 align-items-center">
               <div class="col">
                  <div class="form-check form-check-inline" data-bs-toggle="tooltip" data-bs-placement="bottom" title="OMAHBATA">
                     <input class="form-check-input" type="radio" name="Salesheader" id="Salesheader1" value="1">
                     <label class="form-check-label" for="Salesheader1">
                        <img src="<?= base_url("asset/image/logo/logo-1-200.png") ?>" class="rounded" width="50">
                     </label>
                  </div>
                  <div class="form-check form-check-inline" data-bs-toggle="tooltip" data-bs-placement="bottom" title="TOKO ROSTER BSD">
                     <input class="form-check-input" type="radio" name="Salesheader" id="Salesheader3" value="3">
                     <label class="form-check-label" for="Salesheader3"><img src="<?= base_url("asset/image/logo/logo-3-200.png") ?>" class="rounded" width="50"></label>
                  </div>
                  <div class="form-check form-check-inline" data-bs-toggle="tooltip" data-bs-placement="bottom" title="PABRIK ROSTER">
                     <input class="form-check-input" type="radio" name="Salesheader" id="Salesheader4" value="4">
                     <label class="form-check-label" for="Salesheader4"><img src="<?= base_url("asset/image/logo/logo-4-200.png") ?>" class="rounded" width="50"></label>
                  </div>
                  <div class="form-check form-check-inline" data-bs-toggle="tooltip" data-bs-placement="bottom" title="GLOCANA">
                     <input class="form-check-input" type="radio" name="Salesheader" id="Salesheader5" value="5">
                     <label class="form-check-label" for="Salesheader5"><img src="<?= base_url("asset/image/logo/logo-5-200.png") ?>" class="rounded" width="50"></label>
                  </div>
                  <div class="form-check form-check-inline" data-bs-toggle="tooltip" data-bs-placement="bottom" title="OMAHBATA STUDIO">
                     <input class="form-check-input" type="radio" name="Salesheader" id="Salesheader6" value="6">
                     <label class="form-check-label" for="Salesheader6"><img src="<?= base_url("asset/image/logo/logo-6-200.png") ?>" class="rounded" width="50"></label>
                  </div>
                  <div class="form-check form-check-inline" data-bs-toggle="tooltip" data-bs-placement="bottom" title="CONBLOCINDO">
                     <input class="form-check-input" type="radio" name="Salesheader" id="Salesheader7" value="7">
                     <label class="form-check-label" for="Salesheader7"><img src="<?= base_url("asset/image/logo/logo-7-200.png") ?>" class="rounded" width="50"></label>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="submit" class="btn btn-success" id="btn-submit">Pilih</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
         </div>
      </div>
   </div>
</div>
<script>
   $("[data-bs-toggle='tooltip']").tooltip();
   $("input[name='Salesheader'][value='<?= $value ?>']").prop('checked', true);
   $("#btn-submit").click(function() {
      if (typeof window.ajaxRequestSingle !== "undefined") {
         window.ajaxRequestSingle.abort();
      }
      window.ajaxRequestSingle = $.ajax({
         method: "POST",
         url: "<?= site_url("function/client_data_sales/data_sales_header/") . $id . '/' ?>" + $("input[name='Salesheader']:checked").val(),
         success: function(data) {
            req_status_add = 0;
            $("#btn-submit").html("Simpan");
            console.log(data);
            if (data) {
               Swal.fire({
                  icon: 'success',
                  text: 'ubah data berhasil',
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
                  text: 'ubah data gagal',
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