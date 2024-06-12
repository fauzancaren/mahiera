<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp;Data Pengunjung</h6>
            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="row mb-1 align-items-center">
               <label for="MsWorkplaceId" class="col-sm-3 col-form-label">Toko</label>
               <div class="col-sm-9">
                  <select class="custom-select custom-select-sm form-control form-control-sm select-modal" id="MsWorkplaceId" name="MsWorkplaceId" style="width:100%" <?= ($this->session->userdata("login_mode") != "Superuser" ? "disabled" : "") ?>>
                     <?php
                     $db = $this->db->where("MsWorkplaceIsActive=1")->get("TblMsWorkplace")->result();
                     foreach ($db as $key) {
                        echo '<option value="' . $key->MsWorkplaceId . '"  ' . ($_visitor->MsWorkplaceId == $key->MsWorkplaceId ? "selected" : "") . '>' . $key->MsWorkplaceCode . '</option>';
                     }
                     ?>
                  </select>
               </div>
            </div>
            <div class="row mb-1 align-items-center">
               <label for="KunjunganDate" class="col-sm-3 col-form-label">Tanggal</label>
               <div class="col-sm-9 ">
                  <input id="KunjunganDate" name="KunjunganDate" type="text" class="form-control form-control-sm" value="" placeholder="Cari data penawaran">
               </div>
            </div>
            <div class="row mb-1 align-items-center">
               <label for="KunjunganCardName" class="col-sm-3 col-form-label">Tipe Pelanggan</label>
               <div class="col-sm-9">
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" type="radio" name="VisitorType" id="VisitorType0" value="0" <?= ($_visitor->VisitorType == 0 ? "checked" : "") ?>>
                     <label class="form-check-label" for="VisitorType0">Baru</label>
                  </div>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" type="radio" name="VisitorType" id="VisitorType1" value="1" <?= ($_visitor->VisitorType == 1 ? "checked" : "") ?>>
                     <label class="form-check-label" for="VisitorType1">Lama</label>
                  </div>
               </div>
            </div>
            <div class="row mb-1 align-items-center">
               <label for="KunjunganDate" class="col-sm-3 col-form-label">Via</label>
               <div class="col-sm-9 ">
                  <select class="custom-select custom-select-sm form-control form-control-sm select-modal" id="VisitorVia" name="VisitorVia" style="width:100%">
                     <option value="Kunjungan" <?= ($_visitor->VisitorVia == "Kunjungan" ? "selected" : "") ?>>Kunjungan</option>
                     <option value="Whatsapp" <?= ($_visitor->VisitorVia == "Whatsapp" ? "selected" : "") ?>>Whatsapp</option>
                     <option value="Telepon" <?= ($_visitor->VisitorVia == "Telepon" ? "selected" : "") ?>>Telepon</option>
                  </select>
               </div>
            </div>
            <div class="row mb-1 align-items-center">
               <label for="KunjunganCardName" class="col-sm-3 col-form-label">Tujuan</label>
               <div class="col-sm-9">
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" type="checkbox" value="" id="VisitorKonsultasi" <?= ($_visitor->VisitorKonsultasi == 1 ? "checked" : "") ?>>
                     <label class="form-check-label" for="VisitorKonsultasi">Konsultasi</label>
                  </div>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" type="checkbox" value="" id="VisitorSampel" <?= ($_visitor->VisitorSampel == 1 ? "checked" : "") ?>>
                     <label class="form-check-label" for="VisitorSampel">Sampel</label>
                  </div>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" type="checkbox" value="" id="VisitorPembelian" <?= ($_visitor->VisitorPembelian == 1 ? "checked" : "") ?>>
                     <label class="form-check-label" for="VisitorPembelian">Pembelian</label>
                  </div>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" type="checkbox" value="" id="VisitorPengambilan" <?= ($_visitor->VisitorPengambilan == 1 ? "checked" : "") ?>>
                     <label class="form-check-label" for="VisitorPengambilan">Pengambilan</label>
                  </div>
               </div>
            </div>
            <div class="row mb-1 align-items-center">
               <label for="VisitorName" class="col-sm-3 col-form-label">Nama</label>
               <div class="col-sm-9 ">
                  <input id="VisitorName" name="VisitorName" type="text" class="form-control form-control-sm" value="<?= $_visitor->VisitorName ?>" placeholder="Isi Nama Pelanggan">
               </div>
            </div>
            <div class="row mb-1 align-items-center">
               <label for="VisitorDescription" class="col-sm-3 col-form-label">Keterangan</label>
               <div class="col-sm-9 ">
                  <textarea id="VisitorDescription" name="VisitorDescription" type="text" class="form-control form-control-sm" placeholder="Isi keterangan"><?= $_visitor->VisitorDescription ?></textarea>
               </div>
            </div>
         </div>
         <div class=" modal-footer">
            <button type="submit" class="btn btn-success" id="btn-submit">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
         </div>
      </div>
   </div>
</div>
<script>
   var datestart = moment("<?= $_visitor->VisitorDate ?>");
   /*  TANGGAL DOKUMENT */
   $("#KunjunganDate").daterangepicker({
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
   /*  ARRAY SELECT */
   var selectArrays = Array.from(document.getElementsByClassName("select-modal"));
   selectArrays.forEach(function(SelectArray) {
      $(SelectArray).select2({
         dropdownParent: $("#modal-action .modal-content")
      });
   });

   var req_status_add = 0;
   $("#btn-submit").click(function() {
      $("#btn-submit").html('<i class="fas fa-circle-notch fa-spin"></i> Loading');
      if (!$("#VisitorName").val()) {
         Swal.fire({
            icon: 'error',
            text: 'isi nama pelanggan terlebih dahulu!!!',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            timer: 1500
         });
         $("#btn-submit").html("Simpan");
         return false;
      }
      if (!$("#VisitorDescription").val()) {
         Swal.fire({
            icon: 'error',
            text: 'isi keterangan pelanggan terlebih dahulu!!!',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            timer: 1500
         });
         $("#btn-submit").html("Simpan");
         return false;
      }

      if (!$("#VisitorKonsultasi").is(":checked") && !$("#VisitorSampel").is(":checked") && !$("#VisitorPembelian").is(":checked") && !$("#VisitorPengambilan").is(":checked")) {
         Swal.fire({
            icon: 'error',
            text: 'Tujuan perlu dichecklis!!!',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            timer: 1500
         });
         $("#btn-submit").html("Simpan");
         return false;
      };

      $.ajax({
         method: "POST",
         url: "<?= site_url("function/client_data_sales/data_kunjungan_edit/") . $_visitor->VisitorId  ?>",
         data: {
            "VisitorDate": moment(datestart).format('YYYY-MM-DD'),
            "VisitorName": $("#VisitorName").val(),
            "VisitorType": $('input[name=VisitorType]:checked').val(),
            "VisitorDescription": $("#VisitorDescription").val(),
            "VisitorVia": $("#VisitorVia").val(),
            "VisitorKonsultasi": ($("#VisitorKonsultasi").prop("checked") == false ? "0" : "1"),
            "VisitorPembelian": ($("#VisitorPembelian").prop("checked") == false ? "0" : "1"),
            "VisitorSampel": ($("#VisitorSampel").prop("checked") == false ? "0" : "1"),
            "VisitorPengambilan": ($("#VisitorPengambilan").prop("checked") == false ? "0" : "1"),
            "MsWorkplaceId": $("#MsWorkplaceId").val()
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