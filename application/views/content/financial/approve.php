<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
</head>

<body>
   <section class="content-header">
      <div class="row mb-2">
         <div class="col-md-auto col-12">
            <h2>Data Approve Transaksi</h1>
         </div>
         <div class="col align-self-end">
            <ol class="breadcrumb float-md-end">
               <li class="breadcrumb-item">Finance</li>
               <li class="breadcrumb-item active">Data Approve Transaksi</li>
            </ol>
         </div>
      </div>
   </section>
   <div class="row page-content">
      <div class="col-12">
         <div class="card border-top-orange">
            <div class="card-header">
               <div class="row align-items-center">
                  <div class="col">
                     <span class="fw-bold"><i class="fas fa-money-bill-alt" aria-hidden="true"></i>&nbsp;Finance - Data Approve Transaksi</span>
                  </div>
                  <div class="col-auto px-0">
                     <button id="btn-add-master" class="btn btn-primary btn-sm btn-hide">
                        <i class="fas fa-file-export" aria-hidden="true"></i>
                        <span class="fw-bold">
                           &nbsp;Export Data
                        </span>
                     </button>
                  </div>
               </div>
            </div>
            <div class="card-body">
               <div class="row">
                  <div class="col-lg-6 col-12">
                     <div class="row mb-1">
                        <label for="tb_row" class="col-sm-3 col-form-label">Toko</label>
                        <div class="col-sm-9">
                           <select class="custom-select custom-select-sm form-control form-control-sm" id="tb_status" name="tb_status">
                              <option value="-" selected>Semua Toko</option>
                              <?php
                              $this->db->where("MsWorkplaceIsActive", "1");
                              $query = $this->db->get('TblMsWorkplace')->result();
                              foreach ($query as $key) {
                                 echo '<option value="' . $key->MsWorkplaceId . '">' . $key->MsWorkplaceCode . '</option>';
                              }
                              ?>
                           </select>
                        </div>
                     </div>
                     <div class="row mb-1">
                        <label for="tb_search" class="col-sm-3 col-form-label">Pencarian</label>
                        <div class="col-sm-9">
                           <input type="text" class="form-control form-control-sm" id="tb_search">
                        </div>
                     </div>
                  </div>
               </div>

               <div id="wait-content" class="load-container load4" style="display: block;">
                  <div class="load-progress"></div>
               </div>
               <div id="data-content" class="p-2">
            </div>
         </div>
      </div>
   </div>

   <div id="dialog-box">
   </div>
   <div id="modal-view-show">
   </div>

   <script>
      $(document).ready(function() {

         var ajax_req;
         var modal_action;
         show_content = function() {
            $("#data-content").hide();
            $("#wait-content").show();
            if (ajax_req && ajax_req.readyState != 4) {
               ajax_req.abort();
            }
            ajax_req = $.ajax({
               type: "POST",
               data: {
                  "tb_status": $("#tb_status").val(),
                  "tb_search": $("#tb_search").val()
               },
               url: "<?= site_url('function/client_data_financial/get_data_approve/') ?>",
               success: function(data) {
                  $("#wait-content").hide();
                  $("#data-content").html(data);
                  $("#data-content").show();
               }
            })
         }
         show_content();


         $('#tb_search').keyup(function() {
            show_content();
         });
         $('#tb_status').change(function() {
            show_content();
         });

         payment_view = function(id, filename) {
            if (filename) {
               var file_type = filename.split('.').pop().toLowerCase();
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
                     $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('message/message_sales/show_image') ?>",
                        data: {
                           "src": "<?= base_url('asset/image/payment/') ?>" + id + "/" + filename
                        },
                        success: function(response) {
                           $("#modal-view-show").html(response);
                           $("#modal-filename").text(filename);
                           $("#modal-view").modal("show");
                        },
                        error: function(xhr, status, error) {
                           console.log(xhr.responseText);
                        }
                     });
                     break;
                  case "doc":
                  case "docx":
                  case "xlsx":
                  case "xlx":
                     $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('message/message_sales/show_file') ?>",
                        success: function(response) {
                           $("#modal-view-show").html(response);
                           $("#modal-filename").text(filename);
                           var urlfile = "https://view.officeapps.live.com/op/embed.aspx?src=<?= urlencode(base_url("asset/image/payment/")) ?>" + encodeURI(id + "/" + filename);
                           $("#modal-content").html("<iframe src='" + urlfile + "' width='100%' height='100%'></iframe>");
                           $("#modal-view").modal("show");
                        },
                        error: function(xhr, status, error) {
                           console.log(xhr.responseText);
                        }
                     });
                     break;
                  case "pdf":

                     $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('message/message_sales/show_file') ?>",
                        success: function(response) {
                           $("#modal-view-show").html(response);
                           $("#modal-filename").text(filename);
                           //var urlfile = "https://docs.google.com/viewer?url=<?= urlencode(base_url("asset/image/payment/")) ?>" + encodeURI(id + "/" + filename) + "&embedded=true";
                           $("#modal-content").html('<embed type="application/pdf" src="<?= base_url("asset/image/payment/") ?>' + id + "/" + filename + '" width="100%" height="100%"/>');
                           //$("#modal-content").html('<iframe type="application/pdf" id="myIframe" src="<?= base_url("asset/image/payment/") ?>' + id + "/" + filename + '" height="100%" width="100%"></iframe>');

                           //$("#modal-content").html("<iframe src='" + urlfile + "' width='100%' height='100%'></iframe>");
                           $("#modal-view").modal("show");
                           //document.getElementById('myIframe').contentDocument.location.reload()
                        },
                        error: function(xhr, status, error) {
                           console.log(xhr.responseText);
                        }
                     });

                     break;

                  default:
                     // code block
               }
               $("[data-bs-toggle=\'tooltip\']").tooltip();
            } else {
               Swal.fire({
                  icon: 'error',
                  text: 'Tidak ada file',
                  showConfirmButton: false,
                  allowOutsideClick: false,
                  allowEscapeKey: false,
                  timer: 1500
               });
            }
         }
         approve_click = function(id) {
            const swalWithBootstrapButtons = Swal.mixin({
               customClass: {
                  confirmButton: 'btn btn-success mx-1',
                  cancelButton: 'btn btn-secondary mx-1'
               },
               buttonsStyling: false
            });
            swalWithBootstrapButtons.fire({
               title: "Approve Pembayaran!",
               html: 'Anda yakin ingin menyetujui pembayaran ini...?',
               icon: "success",
               allowOutsideClick: false,
               allowEscapeKey: false,
               showCancelButton: true,
               confirmButtonText: "Lanjutkan",
               cancelButtonText: "Tidak",
               reverseButtons: false
            }).then((result) => {
               if (result.isConfirmed) {
                  $.ajax({
                     method: "POST",
                     url: "<?= site_url("function/Client_data_financial/data_financial_approve/") ?>" + id,
                     before: function() {
                        req_status_add = 1;
                     },
                     success: function(datas) {
                        req_status_add = 0;
                        if (datas) {
                           Swal.fire({
                              icon: 'success',
                              text: 'approve data berhasil',
                              showConfirmButton: false,
                              allowOutsideClick: false,
                              allowEscapeKey: false,
                              timer: 1500,
                           }).then((result) => {
                              if (result.dismiss === Swal.DismissReason.timer) {
                                 show_content();
                              }
                           });
                        } else {
                           Swal.fire({
                              icon: 'error',
                              text: 'approve data gagal',
                              showConfirmButton: false,
                              allowOutsideClick: false,
                              allowEscapeKey: false,
                              timer: 1500
                           });
                           show_content();
                        }
                     }
                  });
               } else if (result.dismiss === Swal.DismissReason.cancel) {
                  return false;
               }
            });
         }
      });
   </script>
</body>

</html>