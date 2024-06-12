<div class="modal fade " id="modal-action" data-keyboard="false" data-backdrop="static">
   <div class="modal-dialog modal-lg">
      <div class="modal-content" name="form-action">
         <div class="modal-header bg-dark">
            <h5 class="modal-title text-white"><i class="fa fa-upload text-success" aria-hidden="true"></i> &nbsp;upload File</h5>
            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="row mb-1">
               <label for="MsCustomerId" class="col-sm-3 col-form-label">Toko</label>
               <div class="col-sm-9">
                  <select class="custom-select custom-select-sm form-control form-control-sm select-modal" id="MsWorkplaceId" name="MsWorkplaceId" style="width:100%">
                     <?php
                     $db = $this->db->where("MsWorkplaceIsActive=1")->get("TblMsWorkplace")->result();
                     foreach ($db as $key) {
                        echo '<option value="' . $key->MsWorkplaceId . '" data-template="' . $key->MsWorkplaceTemplate . '">' . $key->MsWorkplaceCode . '</option>';
                     }
                     ?>
                  </select>
               </div>
            </div>
            <div class="row mb-1">
               <label for="MsCustomerId" class="col-sm-3 col-form-label">Pelanggan</label>
               <div class="col-sm-9">
                  <select class="custom-select custom-select-sm form-select form-select-sm" id="MsCustomerId" name="MsCustomerId" style="width:100%"></select>
               </div>
            </div>
            <div class="row">
               <label for="drop_zone" class="col-sm-3 col-form-label">File</label>
               <div class="col-sm-9">
                  <div class="border">
                     <div class="dropzone" id="file-upload">
                        <div class="dz-message">
                           <span style="font-size:0.85rem">geser dan tarik file disini atau klik untuk upload</span>
                           <span style="font-size:0.6rem">format file bisa dokumen(word,excel,pdf) atau gambar(png,jpeg,jpg)</span>
                        </div>
                     </div>
                  </div>
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
   $("#MsCustomerId").select2({
      placeholder: "Cari nama pelanggan",
      dropdownParent: $("#modal-action .modal-content"),
      ajax: {
         dataType: "json",
         url: "<?= site_url("function/client_data_sales/get_data_customer") ?>",
         delay: 800,
         data: function(params) {
            return {
               search: params.term,
               page: params.page || 1,
            }
         },
         processResults: function(data, params) {
            params.page = params.page || 1;
            return {
               results: data.results,
               pagination: {
                  more: (params.page * 10) < data.count_filtered
               }
            };
         }
      },
      escapeMarkup: function(m) {
         return m;
      },
      templateResult: function template(data) {
         if ($(data.html).length === 0) {
            return data.text;
         }
         return $(data.html);
      },
      templateSelection: function templateSelect(data) {
         if ($(data.html).length === 0) {
            return data.text;
         }
         return data['text'];
      }
   });
   Dropzone.autoDiscover = false;
   var myDropzone = new Dropzone(".dropzone", {
      addRemoveLinks: true,
      dictRemoveFile: '<i class="fas fa-times-circle text-danger"></i>',
      autoProcessQueue: false,
      maxFilesize: 10,
      parallelUploads: 20,
      maxFiles: 20,
      acceptedFiles: "image/*,.xlsx,.xls,.pdf,.doc,.docx",
      url: "<?= site_url("function/client_data_sales/customer_upload_file/") ?>" + $("#MsWorkplaceId").val() + "/" + $("#MsCustomerId").val(),
   });
   document.onpaste = function(event) {
      var items = (event.clipboardData || event.originalEvent.clipboardData).items;
      for (index in items) {
         var item = items[index];
         if (item.kind === 'file') {
            // adds the file to your dropzone instance
            myDropzone.addFile(item.getAsFile())
         }
      }
   }
   $('#btn-submit').click(function() {
      if ($("#MsCustomerId").val() == null) {
         alert("silahkan pilih pelanggan sebelum menyimpan file ini...!!!");
         return
      }
      myDropzone.options.url = "<?= site_url("function/client_data_sales/customer_upload_file/") ?>" + $("#MsWorkplaceId").val() + "/" + $("#MsCustomerId").val();
      myDropzone.processQueue();
   });
   myDropzone.on("queuecomplete", function(file) {
      $("#modal-action").modal("hide");
   });
</script>