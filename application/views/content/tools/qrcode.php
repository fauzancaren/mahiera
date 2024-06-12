<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <style>
      .icon-sosial-media>span {
         color: transparent;
      }

      .icon-sosial-media {
         color: #797d80;
      }

      .icon-sosial-media:hover {
         color: #47bdef;
         cursor: pointer;
      }

      .icon-sosial-media:hover>span {
         color: #47bdef;
      }

      .btn-orange-test {
         color: #fff;
         background-color: #db6e21;
         border-color: #db6e21;
      }

      .live-preview-outline {
         border: 1px solid #b5b5b5;
         width: 22rem;
         height: calc(100vh - 13rem);
         border-radius: 1.5rem;
         padding: 2.5rem 1rem;
         display: block;
         position: fixed;
      }

      .live-preview {
         border: 1px solid #b5b5b5;
         height: 100%;
      }

      .action-label {
         font-size: 0.85rem;
         color: #0095ff !important;
      }

      .action-label:hover {
         text-shadow: 2px 2px 8px #0095ff;
         -webkit-transition: all 0.5s;
         transition: all 0.5s;
      }

      .action-label:hover>i {
         padding-left: 0.5rem;
         transition: all 0.5s;
      }
   </style>
</head>

<body>
   <section class="content-header">
      <div class="row mb-2">
         <div class="col-md-6">
            <h2>Visit QR Code</h2>
         </div>
         <div class="col-md-6 align-self-end">
            <ol class="breadcrumb float-md-end">
               <li class="breadcrumb-item">Tools</li>
               <li class="breadcrumb-item active">Visit Qr Code</li>
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
                     <span class="fw-bold"><i class="fas fa-database" aria-hidden="true"></i>&nbsp;Tools - Visit Qr Code</span>
                  </div>
                  <div class="col-auto px-1">
                     <ul class="dropdown-menu">
                        <li>
                           <a class="dropdown-item" onclick="window.open('<?php echo site_url('function/client_export_master/data_item_category_export_excel') ?>','_blank')">
                              <small><i class="fas fa-file-excel"></i>&nbsp;Export Excel</small>
                           </a>
                        </li>
                        <li>
                           <hr class="dropdown-divider">
                        </li>
                        <li>
                           <a class="dropdown-item" onclick="window.open('<?php echo site_url('export/datamaster/itemcategory') ?>','_blank')">
                              <small><i class="fas fa-file-pdf"></i>&nbsp;Export PDF</small>
                           </a>
                        </li>
                     </ul>
                  </div>
                  <div class="col-auto px-0">

                     <button id="btn-add-master" class="btn btn-success btn-sm btn-hide">
                        <i class="fas fa-plus" aria-hidden="true"></i>
                        <span class="fw-bold">
                           &nbsp;Tambah Data
                        </span>
                     </button>
                  </div>
               </div>
            </div>
            <div class="card-body">
               <div class="row">
                  <div class="col-lg-6 col-12">
                     <div class="row mb-1">
                        <label for="tb_search" class="col-sm-3 col-form-label">Pencarian</label>
                        <div class="col-sm-9">
                           <input type="text" class="form-control form-control-sm" id="tb_search">
                        </div>
                     </div>
                     <div class="row mb-1 align-items-center">
                        <label for="tb_row" class="col-sm-3 col-form-label">Tampilkan</label>
                        <div class="col-3">
                           <select class="custom-select custom-select-sm form-control form-control-sm" id="tb_row" name="tb_row">
                              <option value="10" selected>10</option>
                              <option value="25">25</option>
                              <option value="50">50</option>
                              <option value="100">100</option>
                           </select>
                        </div>
                        <label class="col-3 col-form-label ps-0">baris</label>
                     </div>
                  </div>
               </div>
               <div class="table-responsive" id="tb_data_respon">
                  <table id="tb_data" class="table table-hover align-middle" style='font-family:"Sans-serif", Helvetica; font-size:80%;width:100%'>
                     <thead class="thead-dark">
                        <tr>
                           <th>List Barcode</th>
                        </tr>
                     </thead>
                     <tbody class="bg-light"> </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div id="dialog-box">
   </div>
   <script>
      $(document).ready(function() {
         var req_status = 0;
         //    var modal_action = "";
         var table = $('#tb_data').DataTable({
            "responsive": true,
            "searching": false,
            "lengthChange": false,
            "pageLength": parseInt($('#tb_row').val()),
            "processing": true,
            "serverSide": true,
            "ajax": {
               "url": "<?php echo site_url('function/client_datatable_tools/get_visit_qr') ?>",
               "type": "POST",
               "data": function(data) {
                  data.search['value'] = $('#tb_search').val();
               }
            },
            "order": [],
            "columnDefs": [{
               "orderable": false,
               targets: 0
            }, ],

         });

         $('#tb_search').keyup(function() {
            table.ajax.reload(null, false).responsive.recalc().columns.adjust();
         });
         $('#tb_row').change(function() {
            table.page.len(parseInt($('#tb_row').val())).draw();
         });

         load_data_table = function() {
            table.ajax.reload(null, false).responsive.recalc().columns.adjust();
            modal_action.hide();
         };


         $('#btn-add-master').click(function(e) {
            e.preventDefault();
            if (!req_status) {
               $.ajax({
                  url: "<?php echo site_url('message/message_tools/data_visit_qr_code_add/') ?>",
                  beforeSend: function() {
                     req_status = 1;
                  },
                  success: function(response) {
                     $("#dialog-box").html(response);
                     modal_action = new bootstrap.Modal(document.getElementById('modal-action'));
                     modal_action.show();
                     req_status = 0;
                  },
                  error: function(xhr, status, error) {
                     console.log(xhr.responseText);
                     req_status = 0;
                  }
               });
            }
         });

         detail_click = function(id) {
            if (!req_status) {
               $.ajax({
                  url: "<?php echo site_url('message/message_tools/data_visit_qr_code_detail/') ?>" + id,
                  beforeSend: function() {
                     req_status = 1;
                  },
                  success: function(response) {
                     $("#dialog-box").html(response);
                     modal_action = new bootstrap.Modal(document.getElementById('modal-action'));
                     modal_action.show();
                     req_status = 0;
                  },
                  error: function(xhr, status, error) {
                     console.log(xhr.responseText);
                     req_status = 0;
                  }
               });
            }
         }

         edit_click = function(id) {
            if (!req_status) {
               $.ajax({
                  url: "<?php echo site_url('message/message_tools/data_visit_qr_code_edit/') ?>" + id,
                  beforeSend: function() {
                     req_status = 1;
                  },
                  success: function(response) {
                     $("#dialog-box").html(response);
                     modal_action = new bootstrap.Modal(document.getElementById('modal-action'));
                     modal_action.show();
                     req_status = 0;
                  },
                  error: function(xhr, status, error) {
                     console.log(xhr.responseText);
                     req_status = 0;
                  }
               });
            }
         }

         delete_click = function(id) {
            if (!req_status) {
               $.ajax({
                  url: "<?php echo site_url('Client_data_tools/qr_delete') ?>" + id,
                  beforeSend: function() {
                     req_status = 1;
                  },
                  success: function(response) {
                     $("#dialog-box").html(response);
                     modal_action = new bootstrap.Modal(document.getElementById('modal-action'));
                     modal_action.show();
                     req_status = 0;
                  },
                  error: function(xhr, status, error) {
                     console.log(xhr.responseText);
                     req_status = 0;
                  }
               });
            }
         }
      });
   </script>
</body>

</html>