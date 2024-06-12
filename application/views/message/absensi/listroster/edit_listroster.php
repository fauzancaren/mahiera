<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-dialog-centered ">
      <form class="modal-content" name="create-toko">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp;Edit List Roster</h5>
               <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body align-middle">
            <div class=" row mb-1">
               <label for="RosterListCode" class="col-sm-3 col-form-label">Kode<sup class="error">&nbsp;*</sup></label>
               <div class="col-sm-9">
                  <input type="text" id="RosterListCode" name="RosterListCode" class="form-control form-control-sm" value="<?= $_data->RosterListCode ?>">
               </div>
            </div>
            <div class="row mb-1">
               <label for="RosterListDesc" class="col-sm-3 col-form-label">Nama</label>
               <div class="col-sm-9">
                  <input type="text" id="RosterListDesc" name="RosterListDesc" class="form-control form-control-sm" value="<?= $_data->RosterListDesc ?>">
               </div>
            </div>
            <div class="row mb-1">
               <label for="RosterListTimeIn" class="col-sm-3 col-form-label">Jam Masuk</label>
               <div class="col-sm-3">
                  <input type="text" id="RosterListTimeIn" name="RosterListTimeIn" class="form-control form-control-sm" value="">
               </div>
               <label for="RosterListTimeOut" class="col-sm-3 col-form-label">Jam Keluar</label>
               <div class="col-sm-3">
                  <input type="text" id="RosterListTimeOut" name="RosterListTimeOut" class="form-control form-control-sm" value="">
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
   var StartDateContent = moment("<?= $_data->RosterListTimeIn ?>", "hh:mm:ss");
   var EndDateContent = moment("<?= $_data->RosterListTimeOut ?>", "hh:mm:ss");
   $('#RosterListTimeIn').daterangepicker({
      startDate: StartDateContent,
      timePicker: true,
      singleDatePicker: true,
      timePicker24Hour: true,
      timePickerIncrement: 1,
      timePickerSeconds: true,
      locale: {
         format: 'HH:mm:ss'
      }
   }, Date_content_start).on('show.daterangepicker', function(ev, picker) {
      picker.container.find(".calendar-table").hide();
   });

   function Date_content_start(start, end) {
      StartDateContent = start;
   }

   $('#RosterListTimeOut').daterangepicker({
      startDate: EndDateContent,
      timePicker: true,
      singleDatePicker: true,
      timePicker24Hour: true,
      timePickerIncrement: 1,
      timePickerSeconds: true,
      locale: {
         format: 'HH:mm:ss'
      }
   }, Date_content_end).on('show.daterangepicker', function(ev, picker) {
      picker.container.find(".calendar-table").hide();
   });

   function Date_content_end(start, end) {
      EndDateContent = start;
   }


   $(function() {
      $("form[name='create-toko']").validate({
         rules: {
            RosterListCode: {
               "required": true,
               "remote": "<?= site_url("function/client_data_absen/validate_kode_list_roster/") . $_data->RosterListId ?>",
            },
            RosterListDesc: "required",
            RosterListTimeIn: "required",
            RosterListTimeOut: "required",
         },
         messages: {
            RosterListCode: {
               required: "Masukan kode Roster",
               remote: "Kode Roster sudah ada"
            },
            RosterListDesc: "Masukan Nama Roster",
            RosterListTimeIn: "Masukan Jam Masuk",
            RosterListTimeOut: "Masukan Jam Keluar",
         },
         submitHandler: function(form) {
            $("#btn-submit").html('<i class="fas fa-circle-notch fa-spin"></i> Loading');
            $.ajax({
               method: "POST",
               url: "<?= site_url("function/client_data_absen/data_list_roster_edit/") . $_data->RosterListId ?>",
               data: $("form[name='create-toko']").serialize(),
               success: function(data) {
                  req_status_add = 0;
                  $("#btn-submit").html("Simpan");

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
            return false;
         }
      });
   });
</script>