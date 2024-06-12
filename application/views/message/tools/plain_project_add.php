<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;Tambah Project</h6>
            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">

            <div class="row mb-3">
               <label for="colFormLabelSmTitle" class="col-sm-3 col-form-label col-form-label-sm">Judul Project</label>
               <div class="col-sm-9">
                  <input type="text" class="form-control form-control-sm" id="PlainProjectTitle" placeholder="Masukan nama project">
               </div>
            </div>
            <div class="row mb-3">
               <label for="colFormLabelSmDivisi" class="col-sm-3 col-form-label col-form-label-sm">Divisi</label>

               <div class="col-9">
                  <input type="text" class="form-control form-control-sm" id="MsEmpPositionId" placeholder="Silahkan pilih divisi" autocomplete="off">
               </div>
            </div>

            <div class="row mb-3">
               <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Mulai / Selesai</label>
               <div class="col-sm-9">
                  <input type="text" id="AbsenDate" name="AbsenDate" class="form-control form-control-sm" value="">
               </div>
            </div>
            <div class=" modal-footer">
               <button type="submit" class="btn btn-success" id="btn-submit">Simpan</button>
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
   var StartDateAdd = moment();
   var EndDateAdd = moment();
   $('#AbsenDate').daterangepicker({
      startDate: StartDateAdd,
      endDate: EndDateAdd,
      locale: {
         "format": 'DD MMM YYYY',
      }
   }, Date_content_add);
   Date_content_add(StartDateAdd, EndDateAdd);

   function Date_content_add(start, end) {
      $('#AbsenDate').val(start.format('DD MMM YYYY') + ' - ' + end.format('DD MMM YYYY'));
      StartDateAdd = start;
      EndDateAdd = end;
   }

   var data_divisi = <?= JSON_ENCODE($this->db->get('TblMsDivisi')->result()) ?>;

   function insert_data(ref) {
      var arr_sub = [];
      data_divisi.forEach(element => {
         if (element.MsDivisiRef == ref) {
            var ins = insert_data(element.MsDivisiId);
            if (ins.length > 0) {
               arr_sub.push({
                  id: element.MsDivisiId,
                  title: element.MsDivisiName,
                  subs: ins
               })
            } else {
               arr_sub.push({
                  id: element.MsDivisiId,
                  title: element.MsDivisiName
               })
            };
         }
      });
      return arr_sub;
   }
   var arr = insert_data(0);

   var comboTreeDivisi = $('#MsEmpPositionId').comboTree({
      source: arr,
      cascadeSelect: true,
      collapse: false
   });
   comboTreeDivisi.onChange(function() {
      // console.log(comboTree3._selectedItems);
   });

   $('#btn-submit').click(function() {
      if ($("#PlainProjectTitle").val() == "") {
         Swal.fire(
            'Kesalahan Proses data!',
            'Masukan nama project terlebih dahulu...!',
            'error'
         );
         return false;
      }
      if (comboTreeDivisi._selectedItem["id"] == undefined) {
         Swal.fire(
            'Kesalahan Proses data!',
            'pilih divisi terlebih dahulu...!',
            'error'
         );
         return false;
      }

      var title = $("#PlainProjectTitle").val();
      var divisi = comboTreeDivisi._selectedItem["id"];
      var start = StartDateAdd.format('YYYY-MM-DD 00:00:00');
      var end = EndDateAdd.format('YYYY-MM-DD 23:59:59');
      $.ajax({
         method: "POST",
         url: "<?= site_url("function/client_data_tools/plainProjectAdd") ?>",
         data: {
            title: title,
            divisi: divisi,
            start: start,
            end: end
         },
         success: function(response) {
            Swal.fire({
               icon: 'success',
               text: 'Simpan data berhasil',
               showConfirmButton: false,
               allowOutsideClick: false,
               allowEscapeKey: false,
               timer: 1500,
            }).then((result) => {
               if (result.dismiss === Swal.DismissReason.timer) {
                  load_data_table();
               }
            });
         }
      })

   })
</script>