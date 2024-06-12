<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-dialog-centered">
      <form class="modal-content" name="form-action">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;Pembayaran</h6>
            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="row mb-1 align-items-center">
               <label for="PaymentDate" class="col-sm-3 col-form-label">Tanggal</label>
               <div class="col-sm-9 ">
                  <input id="PaymentDate" name="PaymentDate" type="text" class="form-control form-control-sm" value="" placeholder="Cari data penawaran">
               </div>
            </div>
            <div class="row mb-1 align-items-center">
               <label for="MsMethodId" class="col-sm-3 col-form-label">Metode</label>
               <div class="col-sm-9">
                  <select class="custom-select custom-select-sm form-control form-control-sm select-modal" id="MsMethodId" name="MsMethodId" style="width:100%">
                     <?php
                     $db = $this->db->where("MsMethodIsActive=1")->get("TblMsMethod")->result();
                     foreach ($db as $key) {
                        echo '<option value="' . $key->MsMethodId . '">' . $key->MsMethodCode . ' - ' . $key->MsMethodName . '</option>';
                     }
                     ?>
                  </select>
               </div>
            </div>
            <div class="row mb-1 align-items-center">
               <label for="PaymentCardName" class="col-sm-3 col-form-label">Nama</label>
               <div class="col-sm-9">
                  <input id="PaymentCardName" name="PaymentCardName" type="text" class="form-control form-control-sm" value="<?= $customer ?>" placeholder="Masukan Nama ">
               </div>
            </div>  
            <div class="row mb-1 align-items-center">
               <label for="PaymentTotal" class="col-sm-3 col-form-label">Total</label>
               <div class="col-sm-9">
                  <input id="PaymentTotal" name="PaymentTotal" type="text" class="form-control form-control-sm price-modal" value="<?= $sisa ?>" placeholder="Masukan Total">
               </div>
            </div>
            <div class="row mb-1 align-items-center">
               <label for="PaymentType" class="col-sm-3 col-form-label">(DP)</label>
               <div class="col-sm-9">
                  <input class="form-check-input" type="checkbox" value="" id="PaymentType" name="PaymentType" checked>
               </div>
            </div>
            <div class="row mb-1">
               <label for="drop_zone" class="col-sm-3 col-form-label">Bukti Transaksi</label>
               <div class="col-sm-9" id="Paymentfile">
               </div>
               <div class="col-sm-9" id="paymentupload">
                  <input type="file" id="myfile" name="myfile" hidden>
                  <div class="file-input">
                     <div id="drop_zone" class="d-flex justify-content-center flex-column text-center" onclick="$('#myfile').click();" ondrop="dropHandler(event);" ondragover="dragOverHandler(event);" ondragleave="dragLeaveHandler(event);">
                        <span style="font-size:0.85rem">geser dan tarik file disini atau klik untuk upload</span>
                        <span style="font-size:0.6rem">format file bisa dokumen(word,excel,pdf) atau gambar(png,jpeg,jpg)</span>
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
<script>
   var salesref = "";
   var performaid = 0;
   var refsales = <?= JSON_ENCODE($ref) ?>;
   set_ref = function(name) {
      salesref = name;
   }

   if(refsales){ 
      $("#MsMethodId").val(refsales["MsMethodId"]);
      $("#PaymentTotal").val(refsales["PerformaTotal"]); 
      (refsales["PerformaType"] == 1 ?  $("#PaymentType").prop("checked",true) :  $("#PaymentType").prop("checked",false));
      performaid = refsales["PerformaId"];
   }
   var unix_time = Math.round(+new Date() / 1000);
   $("#Paymentfile").hide();
   $("#paymentupload").show();
   var datestart = moment();
   /*  TANGGAL DOKUMENT */
   $("#PaymentDate").daterangepicker({
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
   /*  ARRAY PRICE */
   var priceinputs = Array.from(document.getElementsByClassName("price-modal"));
   priceinputs.forEach(function(priceinput) {
      new Cleave(priceinput, {
         numeral: true,
         delimiter: ",",
         numeralDecimalScale: 0,
         numeralThousandsGroupStyle: "thousand"
      })
   });

   async function createFile(url) {
      try {
         let response = await fetch(url);
         let data = await response.blob();
         const myArr = data.type.split("/");
         let file = new File([data], "file." + myArr[1], {
            type: data.type
         });
         return file;
      } catch (err) {
         alert(err.message);
      }
   }
   var file = null;
   var file_name = null;
   var src = null;

   function view_image(img_title) {
      $.ajax({
         type: "POST",
         url: "<?php echo site_url('message/message_sales/show_image') ?>",
         data: {
            "src": src
         },
         success: function(response) {
            $("#modal-view-show").html(response);
            $("#modal-filename").text(img_title);
            $("#modal-view").modal("show");
         },
         error: function(xhr, status, error) {
            console.log(xhr.responseText);
         }
      });
   }


   function remove_image(img_title) {
      console.log(img_title);
      if (img_title) {
         $.ajax({
            method: "POST",
            url: "<?= site_url('function/client_data_sales/remove_file/') ?>",
            data: {
               "fname": img_title,
            },
         }).done(function(data) {
            //console.log(data);
         });
      }
      file = null;
      $("[data-bs-toggle=\'tooltip\']").tooltip("hide");
      $("#Paymentfile").html("");
      $("#Paymentfile").hide();
      $("#paymentupload").show();
   }

   function view_pdf(filename) {
      $.ajax({
         type: "POST",
         url: "<?php echo site_url('message/message_sales/show_file') ?>",
         data: {
            "src": src
         },
         success: function(response) {
            $("#modal-view-show").html(response);
            $("#modal-filename").text(filename);
            //var urlfile = "https://view.officeapps.live.com/op/embed.aspx?src=<?= base_url("temp/") ?>" + encodeURI(filename);
            //var urlfile = "https://docs.google.com/viewer?url=<?= urlencode(base_url("temp/")) ?>" + encodeURI(filename) + "&embedded=true";
            //$("#modal-content").html("<iframe src='" + urlfile + "' width='100%' height='100%'></iframe>");
            $("#modal-content").html('<embed type="application/pdf" src="<?= base_url("temp/") ?>' + filename + '" width="100%" height="100%"></embed>');
            $("#modal-view").modal("show");
         },
         error: function(xhr, status, error) {
            console.log(xhr.responseText);
         }
      });

   }

   function view_file(filename) {
      $.ajax({
         type: "POST",
         url: "<?php echo site_url('message/message_sales/show_file') ?>",
         data: {
            "src": src
         },
         success: function(response) {
            $("#modal-view-show").html(response);
            $("#modal-filename").text(filename);
            var urlfile = "https://view.officeapps.live.com/op/embed.aspx?src=<?= urlencode(base_url("temp/")) ?>" + encodeURI(filename);
            $("#modal-content").html("<iframe src='" + urlfile + "' width='100%' height='100%'></iframe>");
            $("#modal-view").modal("show");
         },
         error: function(xhr, status, error) {
            console.log(xhr.responseText);
         }
      });

   }

   function proses_file(selectedFile) {
      var file_type = selectedFile.name.split('.').pop().toLowerCase();
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
      var img_title = unix_time + "." + file_type;
      selectedFile.name = img_title;


      console.log(selectedFile);
      switch (file_type) {
         case "jpg":
         case "jpeg":
         case "png":
            var reader = new FileReader();
            reader.onload = function(event) {
               var fd = new FormData();
               fd.append('fname', img_title);
               fd.append('data', event.target.result);
               $.ajax({
                  type: 'POST',
                  url: "<?= site_url('function/client_data_sales/upload_file/') ?>",
                  data: fd,
                  processData: false,
                  contentType: false
               }).done(function(data) {
                  //console.log(data);
               });

               src = event.target.result;
               file = selectedFile;
               file_name = img_title;
               var htmlline = '  <div class="img-thumbnail img-cover">';
               htmlline += '        <img height = "150" width = "150" src = "' + src + '" style="object-fit: contain;"/>';
               htmlline += '        <div class="detail">' + img_title + '</div>';
               htmlline += '        <div class="action">';
               htmlline += '           <a class="btn btn-transparent p-1" data-bs-toggle="tooltip" data-bs-title="Tampilkan" onclick="view_image(\'' + img_title + '\')"><i class="fas fa-eye text-primary"></i></a>';
               htmlline += '           <a class="btn btn-transparent p-1" data-bs-toggle="tooltip" data-bs-title="Hapus" onclick="remove_image(\'' + img_title + '\')"><i class="fas fa-times text-danger"></i></a>';
               htmlline += '        </div>';
               htmlline += '      </div>';

               $("#Paymentfile").html(htmlline);
               $("#Paymentfile").show();
               $("#paymentupload").hide();
            };
            reader.readAsDataURL(selectedFile);
            break;
         case "doc":
         case "docx":
            var htmlline = '  <div class="img-thumbnail img-cover">';
            htmlline += '        <i class="far fa-file-word fa-6x text-secondary"></i>';
            htmlline += '        <div class="detail">' + img_title + '</div>';
            htmlline += '        <div class="action">';
            htmlline += '           <a class="btn btn-transparent p-1" data-bs-toggle="tooltip" data-bs-title="Tampilkan" onclick="view_file(\'' + img_title + '\')"><i class="fas fa-eye text-primary"></i></a>';
            htmlline += '           <a class="btn btn-transparent p-1" data-bs-toggle="tooltip" data-bs-title="Hapus" onclick="remove_image(\'' + img_title + '\')"><i class="fas fa-times text-danger"></i></a>';
            htmlline += '        </div>';
            htmlline += '      </div>';
            $("#Paymentfile").html(htmlline);
            $("#Paymentfile").show();
            $("#paymentupload").hide();

            var reader = new FileReader();
            reader.onload = function(event) {
               var fd = new FormData();
               fd.append('fname', img_title);
               fd.append('data', event.target.result);
               $.ajax({
                  type: 'POST',
                  url: "<?= site_url('function/client_data_sales/upload_file/') ?>",
                  data: fd,
                  processData: false,
                  contentType: false
               }).done(function(data) {
                  //console.log(data);
               });
            }
            file = selectedFile;
            file_name = img_title;
            reader.readAsDataURL(selectedFile);
            break;
         case "pdf":
            var htmlline = '  <div class="img-thumbnail img-cover">';
            htmlline += '        <i class="far fa-file-pdf fa-6x text-secondary"></i>';
            htmlline += '        <div class="detail">' + img_title + '</div>';
            htmlline += '        <div class="action">';
            htmlline += '           <a class="btn btn-transparent p-1" data-bs-toggle="tooltip" data-bs-title="Tampilkan" onclick="view_pdf(\'' + img_title + '\')"><i class="fas fa-eye text-primary"></i></a>';
            htmlline += '           <a class="btn btn-transparent p-1" data-bs-toggle="tooltip" data-bs-title="Hapus" onclick="remove_image(\'' + img_title + '\')"><i class="fas fa-times text-danger"></i></a>';
            htmlline += '        </div>';
            htmlline += '      </div>';
            $("#Paymentfile").html(htmlline);
            $("#Paymentfile").show();
            $("#paymentupload").hide();

            var reader = new FileReader();
            reader.onload = function(event) {
               var fd = new FormData();
               fd.append('fname', img_title);
               fd.append('data', event.target.result);
               $.ajax({
                  type: 'POST',
                  url: "<?= site_url('function/client_data_sales/upload_file/') ?>",
                  data: fd,
                  processData: false,
                  contentType: false
               }).done(function(data) {
                  //console.log(data);
               });
            }
            file = selectedFile;
            file_name = img_title;
            reader.readAsDataURL(selectedFile);
            break;

         case "xlsx":
         case "xlx":
            var htmlline = '  <div class="img-thumbnail img-cover">';
            htmlline += '        <i class="far fa-file-excel fa-6x text-secondary"></i>';
            htmlline += '        <div class="detail">' + img_title + '</div>';
            htmlline += '        <div class="action">';
            htmlline += '           <a class="btn btn-transparent p-1" data-bs-toggle="tooltip" data-bs-title="Tampilkan" onclick="view_file(\'' + img_title + '\')"><i class="fas fa-eye text-primary"></i></a>';
            htmlline += '           <a class="btn btn-transparent p-1" data-bs-toggle="tooltip" data-bs-title="Hapus" onclick="remove_image(\'' + img_title + '\')"><i class="fas fa-times text-danger"></i></a>';
            htmlline += '        </div>';
            htmlline += '      </div>';
            $("#Paymentfile").html(htmlline);
            $("#Paymentfile").show();
            $("#paymentupload").hide();

            var reader = new FileReader();
            reader.onload = function(event) {
               var fd = new FormData();
               fd.append('fname', img_title);
               fd.append('data', event.target.result);
               $.ajax({
                  type: 'POST',
                  url: "<?= site_url('function/client_data_sales/upload_file/') ?>",
                  data: fd,
                  processData: false,
                  contentType: false
               }).done(function(data) {
                  //console.log(data);
               });
            }
            file = selectedFile;
            file_name = img_title;
            reader.readAsDataURL(selectedFile);
            break;

         default:
            // code block
      }
      $("[data-bs-toggle=\'tooltip\']").tooltip();

   }
   /* by Click */
   $("#myfile").on("change", function(event) {
      const fileList = event.target.files;
      proses_file(fileList[0]);
   });
   /* by paste */
   $(document).on({
      'custom/paste/images': function(event, blobs) {
         proses_file(blobs[0]);
      }
   });

   /* by drop */
   async function dropHandler(ev) {
      $(".file-input").css("padding", "0.2rem");
      ev.preventDefault();
      var imageUrl = ev.dataTransfer.getData('text/html');
      if (imageUrl != "") {
         var parser = new DOMParser();
         var doc = parser.parseFromString(imageUrl, 'text/html');
         var body = doc.body;
         var img = $(body).children();
         if ($(img).attr("src") == "undefined") {
            return;
         }
         try {
            var data = await createFile($(img).attr("src"));
            proses_file(data);
         } catch (err) {
            alert(err.message);
         }
      } else {
         if (ev.dataTransfer.items) {
            var file = ev.dataTransfer.items[0].getAsFile();
            proses_file(file);
         }
      }
   }

   function dragOverHandler(ev) {
      $(".file-input").css("padding", "0.5rem");
      ev.preventDefault();
   }

   function dragLeaveHandler(ev) {
      $(".file-input").css("padding", "0.2rem");
      ev.preventDefault();
   }

   var req_status_add = 0;
   $(function() {
      $("form[name='form-action']").validate({
         rules: {
            PaymentDate: "required",
            MsMethodId: "required",
            PaymentCardName: "required",
            PaymentTotal: "required",

         },
         messages: {
            PaymentDate: "Pilih tanggal terlebih dahulu",
            MsMethodId: "pilih methode pembayaran",
            PaymentCardName: "masukan nama customer",
            PaymentTotal: "masukan total pembayaran",
         },
         submitHandler: function(form) {
            if (!req_status_add) {
               $("#btn-submit").html('<i class="fas fa-circle-notch fa-spin"></i> Loading');
               $.ajax({
                  method: "POST",
                  url: "<?= site_url("function/client_data_sales/data_sales_payment_add") ?>",
                  data: {
                     "PaymentDate": moment(datestart).format('YYYY-MM-DD'),
                     "MsMethodId": $("#MsMethodId").val(),
                     "PaymentCardName": $("#PaymentCardName").val(),
                     "PaymentTotal": parseInt($("#PaymentTotal").val().replaceAll(",", "")),
                     "PaymentRef": "<?= $code ?>",
                     "PaymentRef2": performaid,
                     "PaymentType": ($("#PaymentType").prop("checked") ? "D" : "P"),
                     "PaymentImage": (file == null ? "" : file_name)
                  },
                  before: function() {
                     req_status_add = 1;
                  },
                  success: function(data) {
                     req_status_add = 0;
                     $("#btn-submit").html("Simpan");

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
                              $.redirect('<?php echo site_url('export/datasales/payment/-') ?>', {
                                 'code': "<?= $code ?>",
                              }, "POST", "_blank");
                              load_data_table_sales();
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
               return false;
            }
         }
      });
   });
</script>