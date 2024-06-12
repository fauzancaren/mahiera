<div class="modal fade " id="modal-action" data-keyboard="false" data-backdrop="static">
   <div class="modal-dialog modal-lg">
      <div class="modal-content" name="form-action">
         <div class="modal-header bg-dark">
            <h5 class="modal-title text-white"><i class="fa fa-upload text-success" aria-hidden="true"></i> &nbsp;upload File</h5>
            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
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
   Dropzone.autoDiscover = false;
   var myDropzone = new Dropzone(".dropzone", {
      addRemoveLinks: true,
      dictRemoveFile: '<i class="fas fa-times-circle text-danger"></i>',
      autoProcessQueue: false,
      maxFilesize: 10,
      parallelUploads: 20,
      maxFiles: 20,
      acceptedFiles: "image/*,.xlsx,.xls,.pdf,.doc,.docx",
      url: "<?= site_url("function/client_data_sales/customer_upload_file/") . $_store . "/" . $_cust ?>",
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
      myDropzone.options.url = "<?= site_url("function/client_data_sales/customer_upload_file/") . $_store . "/" . $_cust ?>";
      myDropzone.processQueue();
   });
   myDropzone.on("queuecomplete", function(file) {
      $("#modal-action").modal("hide");
   });
</script>