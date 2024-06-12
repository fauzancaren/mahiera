<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <style>
      .btn-check:active+.btn-check-obi,
      .btn-check:checked+.btn-check-obi {
         color: #fff;
         background-color: #e79726;
      }

      .btn-check-obi {
         background-color: #fff9f1;
         border-color: #cfcfcf;
         padding: 0.2 rem !IMPORTANT;
      }
   </style>
</head>

<body>
   <section class="content-header">
      <div class="row mb-2">
         <div class="col-md-auto col-12">
            <h2 onclick="menuselect('absensi-izinsakit','menu-absensi')">Data Keterangan Kehadiran</h2>
         </div>
         <div class="col align-self-end">
            <ol class="breadcrumb float-md-end">
               <li class="breadcrumb-item">Absensi</li>
               <li class="breadcrumb-item active" onclick="menuselect('absensi-izinsakit','menu-absensi')" style="cursor:pointer">Keterangan Kehadiran</li>
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
                     <span class="fw-bold"><i class="fas fa-users" aria-hidden="true"></i>&nbsp;Absensi - Keterangan Kehadiran</span>
                  </div>
                  <div class="col-auto px-1">
                     <button id="btn-export" class="btn btn-primary btn-sm btn-hide">
                        <i class="fas fa-file-export"></i>
                        <span class="fw-bold">
                           &nbsp;Export Data
                        </span>
                     </button>
                  </div>
                  <div class="col-auto px-0">
                     <button id="btn-add" class="btn btn-success btn-sm btn-hide">
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
                        <label for="tb_row" class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                           <input type="text" class="form-control form-control-sm" id="tb_date" name="tb_date">
                        </div>
                     </div>
                     <div class="row mb-1">
                        <label for="tb_row" class="col-sm-3 col-form-label">Type</label>
                        <div class="col-sm-9">
                           <select class="custom-select custom-select-sm form-control form-control-sm" id="tb_type" name="tb_type" style="width:100%">
                              <option value="-" selected>Semua Tipe</option>
                              <?php
                              $query = $this->db->get('TblAbsenKelolaType')->result();
                              foreach ($query as $key) {
                                 echo '<option value="' . $key->AbsenKelolaTypeId . '" >' . $key->AbsenKelolaTypeName . '</option>';
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
                           <th>No</th>
                           <th>Nama Karyawan</th>
                           <th>Keterangan</th>
                           <th>Catatan</th>
                           <th>Tanggal</th>
                           <th><i class="fas fa-cog"></i></th>
                        </tr>
                     </thead>
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
         var modal_action = "";

         var StartDateContent = moment().startOf('month');
         var EndDateContent = moment().endOf('month');
         $('#tb_date').daterangepicker({
            startDate: StartDateContent,
            endDate: EndDateContent,
            ranges: {
               'Hari ini': [moment(), moment()],
               'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
               'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               '7 hari yang lalu': [moment().subtract(6, 'days'), moment()],
               '1 Bulan yang lalu': [moment().subtract(1, 'month'), moment()],
               '3 Bulan yang lalu': [moment().subtract(3, 'month').startOf('month'), moment()]
            },
            locale: {
               "format": 'DD/MM/YYYY',
               "customRangeLabel": "Pilih Tanggal Sendiri",
            }
         }, Date_content);
         var page_load = 0;
         Date_content(StartDateContent, EndDateContent);
         $("#tb_type").select2();

         function Date_content(start, end) {
            $('#tb_date').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
            StartDateContent = start;
            EndDateContent = end;
            if (page_load > 0) table.ajax.reload(null, false).responsive.recalc().columns.adjust();
            page_load = 1;
         }
         var table = $('#tb_data').DataTable({
            "responsive": true,
            "searching": false,
            "lengthChange": false,
            "pageLength": parseInt($('#tb_row').val()),
            "processing": true,
            "serverSide": true,
            "ajax": {
               "url": "<?php echo site_url('function/Client_datatable_absen/get_data_list_izinsakit') ?>",
               "type": "POST",
               "data": function(data) {
                  data.search['value'] = $('#tb_search').val();
                  data.search['tanggalstart'] = StartDateContent.format('YYYY-MM-DD');
                  data.search['tanggalend'] = EndDateContent.format('YYYY-MM-DD');
                  data.search['coltanggal'] = "AbsenKelolaDate";
                  data.search['status'] = $('#tb_type').val();
                  data.search['colstatus'] = "AbsenKelolaType";
               }
            },
            "columnDefs": [{
                  "orderable": false,
                  targets: 0
               },
               {
                  "orderable": false,
                  "width": "20%",
                  targets: 3
               },
               {
                  "orderable": false,
                  targets: 5
               }
            ],
            "order": [
               [3, "desc"]
            ] 
         });

         $('#tb_search').keyup(function() {
            table.ajax.reload(null, false).responsive.recalc().columns.adjust();
         });
         $('#tb_type').change(function() {
            table.ajax.reload(null, false).responsive.recalc().columns.adjust();
         });
         $('#tb_row').change(function() {
            table.page.len(parseInt($('#tb_row').val())).draw();
         });
         load_data_table = function() {
            table.ajax.reload(null, false).responsive.recalc().columns.adjust();
            modal_action.hide();
         };

         $('#btn-export').click(function(e) {
            e.preventDefault();
            $.redirect('<?php echo site_url('function/client_export_absen/data_kehadiran_export_excel') ?>', {
               'datestart': StartDateContent.format('YYYY-MM-DD'),
               'dateend': EndDateContent.format('YYYY-MM-DD'),
               'store': $('#tb_workplace').val(),
               'search': $('#tb_search').val(),
               'type': $('#tb_type').val(),
            }, "POST", "_blank");
         });
         $("#btn-add").click(function(e) {
            e.preventDefault();
            if (!req_status) {
               $.ajax({
                  url: "<?php echo site_url('message/message_absensi/kehadiran_add/') ?>",
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
         })
         edit_click = function(id) {
            if (!req_status) {
               $.ajax({
                  url: "<?php echo site_url('message/message_absensi/kehadiran_edit/') ?>" + id,
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
               const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                     confirmButton: 'btn btn-success mx-1',
                     cancelButton: 'btn btn-secondary mx-1'
                  },
                  buttonsStyling: false
               });
               swalWithBootstrapButtons.fire({
                  title: "Hapus data",
                  html: 'Anda yakin ingin menghapus data kehadiran ini ?',
                  icon: "warning",
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
                        url: "<?= site_url("function/client_data_absen/kehadiran_delete/") ?>" + id,
                        before: function() {
                           req_status_add = 1;
                        },
                        success: function(data) {
                           req_status_add = 0;
                           console.log(data);
                           if (data) {
                              Swal.fire({
                                 icon: 'success',
                                 text: 'Hapus data berhasil',
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
                                 text: 'Hapus data gagal',
                                 showConfirmButton: false,
                                 allowOutsideClick: false,
                                 allowEscapeKey: false,
                                 timer: 1500
                              });
                           }
                        }
                     });
                  }
               });
            }
         }
      });
   </script>

</body>

</html>