<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" name="form-action">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp;Ganti Tanggal</h6>
            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="row mb-1 align-items-center">
               <label for="DeliveryOldDate" class="col-sm-5 col-form-label">Tanggal Sebelumnya<sup class="error">&nbsp;*</sup></label>
               <div class="col-sm-7">
                  <input id="DeliveryOldDate" name="DeliveryOldDate" type="text" class="form-control form-control-sm" value="<?= date_format(date_create($_delivery->DeliveryDate), " d/m/Y") ?>" readonly>
               </div>
            </div>
            <div class="row mb-1 align-items-center">
               <label for="DeliveryNewDate" class="col-sm-5 col-form-label">Tanggal sekarang<sup class="error">&nbsp;*</sup></label>
               <div class="col-sm-7">
                  <input id="DeliveryNewDate" name="DeliveryNewDate" type="text" class="form-control form-control-sm" value="">
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
   $("#DeliveryNewDate").daterangepicker({
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
   $("#btn-submit").click(function() {
      if (typeof window.ajaxRequestSingle !== "undefined") {
         window.ajaxRequestSingle.abort();
      }

      window.ajaxRequestSingle = $.ajax({
         method: "POST",
         url: "<?= site_url("function/client_data_sales/data_delivery_date/") . $_delivery->DeliveryId ?>",
         data: {
            "DeliveryDate": moment(datestart).format('YYYY-MM-DD'),
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
                     load_schedule();
                     $("#modal-action").modal("hide");
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