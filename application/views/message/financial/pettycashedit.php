<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-lg">
      <form class="modal-content" name="form-action">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp;Petty Cash</h6>
            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="row mb-1 align-items-center">
               <label for="MsWorkplaceId" class="col-sm-3 col-form-label">Toko</label>
               <div class="col-sm-9">
                  <select class="custom-select custom-select-sm form-control form-control-sm select-modal" id="MsWorkplaceId" name="MsWorkplaceId" style="width:100%">
                     <?php
                     $db = $this->db->where("MsWorkplaceIsActive=1")->get("TblMsWorkplace")->result();
                     foreach ($db as $key) {
                        echo '<option value="' . $key->MsWorkplaceId . '" data-template="' . $key->MsWorkplaceTemplate . '" ' . ($_finance->MsWorkplaceId == $key->MsWorkplaceId ? "selected" : "") . '>' . $key->MsWorkplaceCode . '</option>';
                     }
                     ?>
                  </select>
               </div>
            </div>
            <script>
               console.log(<?= JSON_ENCODE($_kategori) ?>)
            </script>
            <div class="row mb-1 align-items-center">
               <label for="FinancialCategory" class="col-sm-3 col-form-label">Kategory</label>
               <div class="col-sm-9">
                  <select class="custom-select custom-select-sm form-control form-control-sm select-modal" id="FinancialCategory" name="FinancialCategory" style="width:100%">
                     <?php
                     echo '<option value="' . $_finance->FinanceCatId . '" selected>' . $_finance->FinanceCatName . ' - ' . $_kategori->FinanceCatName . '</option>';
                     ?>
                  </select>
               </div>
            </div>
            <div class="row mb-1 align-items-center">
               <label for="FinancialDate" class="col-sm-3 col-form-label">Tanggal</label>
               <div class="col-sm-9 ">
                  <input id="FinancialDate" name="FinancialDate" type="text" class="form-control form-control-sm" value="" placeholder="masukan tanggal">
               </div>
            </div>
            <div class="row mb-1 align-items-center">
               <label for="FinancialDesc" class="col-sm-3 col-form-label">Keterangan</label>
               <div class="col-sm-9">
                  <textarea id="FinancialDesc" name="FinancialDesc" type="text" class="form-control form-control-sm" value="" placeholder="Masukan keterangan"><?= $_finance->FinancialDescription ?></textarea>
               </div>
            </div>
            <div class="row mb-1 align-items-center">
               <label for="FinancialTotal" class="col-sm-3 col-form-label">Total</label>
               <div class="col-sm-9">
                  <input id="FinancialTotal" name="FinancialTotal" type="text" class="form-control form-control-sm price-modal" value="<?= $_finance->FinancialTotal ?>" placeholder="Masukan Total">
               </div>
            </div>
            <div class="row mb-1 align-items-center">
            </div>
            <div class="row mb-1">
               <label for="drop_zone" class="col-sm-3 col-form-label">Bukti Transaksi</label>
               <div class="col-sm-9">
                  <div class="border">
                     <div class="dropzone" id="file-upload">
                        <div class="dz-message">
                           <span style="font-size:0.85rem">geser dan tarik file disini atau klik untuk upload</span><br>
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
      </form>
   </div>
</div>
<div class="modal fade" id="modal-view-image">
   <div class="modal-dialog modal-fullscreen">
      <div class="modal-content" name="form-action" style="background: transparent;">
         <div class="modal-header" style="border-bottom: none;">
            <h6 class="modal-title text-white" id="modal-filename"></h6>
            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body d-flex justify-content-center align-items-center" id="modal-content" style="background: transparent;">
            <div class="panzoom" id="panzoom-element"><img id="image-view" src="" style="object-fit: contain;max-width: 100%;height: 100%;" /></div>
         </div>
         <div class="modal-footer">
            <div class=" action-zoom">
               <a id="zoom-in"><i class="fas fa-search-plus"></i></a>
               <a id="zoom-out"><i class="fas fa-search-minus"></i></a>
               <a id="reset"><i class="fas fa-undo-alt"></i></a>
            </div>
         </div>
      </div>
   </div>
</div>
<script>
   var elem = document.getElementById('panzoom-element');
   var zoomInButton = document.getElementById('zoom-in');
   var zoomOutButton = document.getElementById('zoom-out');
   var resetButton = document.getElementById('reset');
   var panzoom = Panzoom(elem, {
      maxZoom: 1,
      minZoom: 0.1,
      bounds: true,
      boundsPadding: 0.1,
      startTransform: "scale(0.1)" // +10%
   });
   var parent = elem.parentElement;
   // No function bind needed
   //parent.addEventListener('wheel', panzoom.zoomWithWheel);
   zoomInButton.addEventListener('click', panzoom.zoomIn);
   zoomOutButton.addEventListener('click', panzoom.zoomOut);
   resetButton.addEventListener('click', function() {
      panzoom.pan(0, 0);
      panzoom.zoom(0.8, {
         animate: true
      });
   });
   $("#modal-content").click(function(e) {
      if ($(e.target).parents(".panzoom").length === 0) {
         $("#modal-view").modal("hide");
      }
   });
   panzoom.zoom(0.8, {
      animate: true
   })
</script>
<div class="modal fade" id="modal-view-file">
   <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
      <div class="modal-content" name="form-action" style="background: transparent;">
         <div class="modal-header" style="border-bottom: none;">
            <h6 class="modal-title text-white" id="modal-filename"></h6>
            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body d-flex justify-content-center align-items-center" id="modal-content-file" style="background: transparent;">
         </div>
      </div>
   </div>
</div>
<script>
   var priceinputs = Array.from(document.getElementsByClassName("price-modal"));
   priceinputs.forEach(function(priceinput) {
      new Cleave(priceinput, {
         numeral: true,
         delimiter: ",",
         numeralDecimalScale: 0,
         numeralThousandsGroupStyle: "thousand"
      })
   });
   datestart = moment("<?= $_finance->FinancialDate ?>");
   $("#FinancialDate").daterangepicker({
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
   $('#FinancialCategory').select2({
      placeholder: "Cari Kategory",
      dropdownParent: $("#modal-action .modal-content"),
      ajax: {
         dataType: "json",
         url: "<?= site_url("function/client_data_financial/get_data_category") ?>",
         delay: 800,
         processResults: function(data) {
            return {
               results: data
            };
         }
      }
   });

   var files = [];
   Dropzone.autoDiscover = false;
   var myDropzone = new Dropzone(".dropzone", {
      addRemoveLinks: true,
      dictRemoveFile: '<i class="fas fa-times-circle text-danger"></i>',
      autoProcessQueue: false,
      maxFilesize: 10,
      parallelUploads: 20,
      maxFiles: 20,
      acceptedFiles: "image/*,.xlsx,.xls,.pdf,.doc,.docx",
      url: "<?= site_url("function/client_data_financial/petty_cash_upload_file/") ?>",
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
   myDropzone.on("queuecomplete", function(file) {});
   myDropzone.on("addedfile", function(file) {
      files.push(file);
      $(file.previewElement).append("<div class='dz-action text-center mt-1'><a class='btn btn-sm btn-primary py-1' style='cursor:pointer' onclick='show(" + (files.length - 1) + ")'><i class='fas fa-eye pe-1'></i>preview</a></div>");
      $(file.previewElement).find(".dz-progress").hide();
   });
   async function getFileFromUrl(url, name, defaultType = 'image/jpeg') {
      const response = await fetch(url);
      const data = await response.blob();
      return new File([data], name, {
         type: response.headers.get('content-type') || defaultType,
      });
   }
   $.ajax({
      dataType: "json",
      url: "<?= site_url("function/client_data_financial/data_image_url/") . $_finance->FinancialPath ?>",
      success: async function(data) {
         for (var i = 0; i < data.length; i++) {
            let blob = await getFileFromUrl(data[i]["dataURL"], data[i]["filename"], data[i]["filetype"]);
            myDropzone.addFile(blob);
         }

      },
      error: function(xhr, status, error) {
         console.log(xhr.responseText);
      }
   });
   show = function(index) {

      var file_type = files[index].name.split('.').pop().toLowerCase();
      var fileExtension = ["jpg", "jpeg", "png", "doc", "docx", "pdf", "xlsx", "xlx"];
      if ($.inArray(file_type, fileExtension) == -1) {
         Swal.fire({
            icon: 'error',
            text: 'format file tidak didukung',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            timer: 1500
         });
         return;
      }
      switch (file_type) {
         case "jpg":
         case "jpeg":
         case "png":
            var reader = new FileReader();
            reader.onload = function(event) {
               // event.target.result contains base64 encoded image
               var base64String = event.target.result;
               var fileName = files[index].name
               //handlePictureDropUpload(base64String, fileName);
               $("#image-view").attr("src", base64String)
               $("#modal-view-image").modal("show");
            };
            reader.readAsDataURL(files[index]);
            console.log("view image");
            break;
         case "doc":
         case "docx":
         case "xlsx":
         case "xlx":
            console.log("view doc");
            break;
         case "pdf":
            var reader = new FileReader();
            reader.onload = function(event) {
               const FILE_NAME = 'files[index].name';
               const file_header = ';headers=filename%3D';

               var base64String = event.target.result;
               base64String = base64String.replace(';', file_header + encodeURIComponent(FILE_NAME) + ';');
               $("#modal-content-file").html('<embed type="application/pdf" src="' + base64String + '" width="100%" height="100%"></embed>');
               //$("#modal-content").html("<iframe src='" + urlfile + "' width='100%' height='100%'></iframe>");
               $("#modal-view-file").modal("show");
            };
            reader.readAsDataURL(files[index]);
            console.log("view image");
            break;

         default:
      }
   }
   var req_status_add = 0;
   $(function() {
      $("form[name='form-action']").validate({
         rules: {
            FinancialDate: "required",
            FinancialDesc: "required",
            FinancialCategory: "required",
            FinancialTotal: "required",

         },
         messages: {
            FinancialDate: "Pilih tanggal terlebih dahulu",
            FinancialCategory: "pilih kategori terlebih dahulu",
            FinancialDesc: "masukan keterangan",
            FinancialTotal: "masukan total biaya",
         },
         submitHandler: function(form) {
            if (!req_status_add) {
               $("#btn-submit").html('<i class="fas fa-circle-notch fa-spin"></i> Loading');
               $.ajax({
                  method: "POST",
                  url: "<?= site_url("function/client_data_financial/data_petty_cash_edit/") ?>" + <?= $_finance->FinancialId ?>,
                  data: {
                     "FinancialDate": moment(datestart).format('YYYY-MM-DD'),
                     "FinancialCategory": $("#FinancialCategory").val(),
                     "FinancialDesc": $("#FinancialDesc").val(),
                     "FinancialTotal": parseInt($("#FinancialTotal").val().replaceAll(",", "")),
                     "MsWorkplaceId": $("#MsWorkplaceId").val(),
                     "FinancialPath": <?= $_finance->FinancialPath ?>
                  },
                  before: function() {
                     req_status_add = 1;
                  },
                  success: function(data) {
                     req_status_add = 0;
                     $("#btn-submit").html("Simpan");

                     myDropzone.options.url = "<?= site_url("function/client_data_financial/upload_file/") ?>" + <?= $_finance->FinancialPath ?>;
                     myDropzone.processQueue();

                     $("#modal-action").modal("hide");
                     get_data_side();
                  }
               });
               return false;
            }
         }
      });
   });
</script>