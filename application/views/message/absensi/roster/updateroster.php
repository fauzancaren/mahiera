<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-dialog-centered ">
      <div class="modal-content" name="create-toko">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp;Update Schedule</h5>
               <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class=" row mb-1">
               <label for="MsEmployeeId" class="col-sm-3 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
               <div class="col-sm-9">
                  <select class="custom-select custom-select-sm form-select form-select-sm" id="MsEmployeeId" name="MsEmployeeId" multiple="multiple" style="width:100%">
                     <optgroup class="select2-result-selectable" label="PILIH SEMUA KARYAWAN">
                     </optgroup>
                     <?php
                     $db = $this->db->join("TblMsWorkplace", "TblMsWorkplace.MsWorkplaceId=TblMsEmployee.MsWorkplaceId")->where("MsEmpIsActive=1")->order_by("TblMsEmployee.MsWorkplaceId ASC,MsEmpId ASC")->get("TblMsEmployee")->result();
                     $lastwork = "";
                     $start = 0;
                     foreach ($db as $key) {
                        if ($lastwork != $key->MsWorkplaceId) {
                           $lastwork = $key->MsWorkplaceId;
                           if ($start != 0) echo '</optgroup>';
                           echo '<optgroup class="select2-result-selectable" label="PILIH DARI TOKO ' . $key->MsWorkplaceCode . '">';
                           $start++;
                        }
                        echo '<option value="' . $key->MsEmpId . '" ' . ($_roster->MsEmpId == $key->MsEmpId ? "selected" : "") . '>' . $key->MsEmpCode . '-' . $key->MsEmpName . '</option>';
                     }
                     echo '</optgroup>';
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
               <label for="RosterList" class="col-sm-3 col-form-label">Roster<sup class="error">&nbsp;*</sup></label>
               <div class="col-sm-9">
                  <select class="custom-select custom-select-sm form-select form-select-sm" id="RosterList" name="RosterList" style="width:100%">
                     <?php
                     foreach ($_rosterlist as $row) {
                        echo "<option value='" . $row->RosterListCode . "' " . ($_roster->RosterTipe == $row->RosterListCode ? "selected" : "") . ">" . $row->RosterListCode . "-" . $row->RosterListDesc . " (" . $row->RosterListTimeIn . "-" . $row->RosterListTimeOut . ")</option>";
                     }
                     ?>
                  </select>
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
      $("#MsEmployeeId").select2({
         allowClear: true,
         placeholder: 'Pilih nama karyawan..',
      });
      $(document).on("click", ".select2-results__group", function() {
         $('#MsEmployeeId').val(null).trigger('change');
         var groupName = $(this).html();
         var options = $('#MsEmployeeId option');
         $.each(options, function(key, value) {
            if (groupName == "PILIH SEMUA KARYAWAN") {
               $(value).prop("selected", "selected");
            } else {
               if ($(value)[0].parentElement.label.indexOf(groupName) >= 0) {
                  $(value).prop("selected", "selected");
               }
            }
         });

         $("#MsEmployeeId").trigger("change");
         $("#MsEmployeeId").select2('close');

      });
      $("#MsEmployeeId").select2({
         dropdownParent: $("#modal-action .modal-content")
      });
      $("#MsWorkplaceId").select2({
         dropdownParent: $("#modal-action .modal-content")
      });
      var StartDateContent = moment('<?= $_roster->RosterDate ?>');
      var EndDateContent = moment('<?= $_roster->RosterDate ?>');
      $('#AbsenDate').daterangepicker({
         startDate: StartDateContent,
         endDate: EndDateContent,
         locale: {
            "format": 'DD/MM/YYYY',
         }
      }, Date_content);
      Date_content(StartDateContent, EndDateContent);

      function Date_content(start, end) {
         StartDateContent = start;
         EndDateContent = end;
      }
      var getDaysBetweenDates = function(startDate, endDate) {
         var now = startDate.clone(),
            dates = [];

         while (now.isSameOrBefore(endDate)) {
            dates.push(now.format('YYYY-MM-DD'));
            now.add(1, 'days');
         }
         return dates;
      };
      $("#btn-submit").click(function() {
         var dataroster = [];
         var dateList = getDaysBetweenDates(StartDateContent, EndDateContent);
         dateList.forEach(adate => {
            dataroster.push({
               "MsEmpId": $("#MsEmployeeId").select2("val"),
               "RosterTipe": $("#RosterList").val(),
               "RosterDate": adate,
            });
         });
         console.log(dataroster);
         $.ajax({
            method: "POST",
            url: "<?= site_url("function/client_data_absen/schedule_update") ?>",
            data: {
               "data": dataroster
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
                        $("#modal-action").modal("hide");
                        load_data();
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