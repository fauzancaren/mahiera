<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <style>
      td.details-control:before {
         content: "\f542";
         font-family: "Font Awesome 5 Free";
         font-weight: 600;
         position: relative;
         float: right;
      }

      tr.shown td.details-control:before {
         content: "\f542";
         font-family: "Font Awesome 5 Free";
         font-weight: 600;
         position: relative;
         float: right;
      }
   </style>
</head>

<body>
   <section class="content-header">
      <div class="row mb-2">
         <div class="col-md-auto col-12">
            <h2>Data Purchase Order (PO)</h1>
         </div>
         <div class="col align-self-end">
            <ol class="breadcrumb float-md-end">
               <li class="breadcrumb-item">Pembelian</li>
               <li class="breadcrumb-item active">Data Purchase Order (PO)</li>
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
                     <span class="fw-bold"><i class="fas fa-luggage-cart" aria-hidden="true"></i>&nbsp;Pembelian - Data Purchase Order (PO)</span>
                  </div>
                  <div class="col-auto px-1">
                     <button type="button" class="btn btn-primary btn-sm btn-hide" id="btn-export">
                        <i class="fas fa-file-export"></i>
                        <span class="fw-bold">
                           &nbsp;Export Data
                        </span>
                     </button>
                  </div>
                  <div class="col-auto px-0">
                     <button id="btn-add-kunjungan" class="btn btn-success btn-sm btn-hide">
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
                        <label for="tb_status" class="col-sm-3 col-form-label">Toko</label>
                        <div class="col-sm-9">
                           <select class="custom-select custom-select-sm form-control form-control-sm" id="tb_status" name="tb_status">
                              <option value="" selected>Semua Toko</option>
                              <?php
                              $db = $this->db->where("MsWorkplaceIsActive=1")->get("TblMsWorkplace")->result();
                              foreach ($db as $key) {
                                 echo '<option value="' . $key->MsWorkplaceId . '"  ' . ($this->session->userdata("MsWorkplaceId") == $key->MsWorkplaceId ? "selected" : "") . '>' . $key->MsWorkplaceCode . '</option>';
                              }
                              ?>
                           </select>
                        </div>
                     </div>
                     <div class="row mb-1">
                        <label for="tb_date" class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                           <input type="text" class="form-control form-control-sm" id="tb_date">
                        </div>
                     </div>
                     <div class="row mb-1">
                        <label for="tb_vendor" class="col-sm-3 col-form-label">Vendor</label>
                        <div class="col-sm-9">
                           <select class="custom-select custom-select-sm form-control form-control-sm" id="tb_vendor" name="tb_vendor" style="width:100%">
                              <option value="" selected>Semua Vendor</option>
                              <?php
                              $db = $this->db->where("MsVendorIsActive=1")->get("TblMsVendor")->result();
                              foreach ($db as $key) {
                                 echo '<option value="' . $key->MsVendorId . '"  >' . $key->MsVendorCode . ' - ' . $key->MsVendorName . '</option>';
                              }
                              ?>
                           </select>
                        </div>
                     </div>
                     <div class="row mb-1">
                        <label for="tb_status1" class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-3">
                           <select class="custom-select custom-select-sm form-control form-control-sm" id="tb_status1" name="tb_status1">
                              <option value="" selected>Semua Status</option>
                              <option value="0">Dijadwalkan</option>
                              <option value="1">Diproses</option>
                              <option value="2">Diterima</option>
                           </select>
                        </div>
                        <label for="tb_status2" class="ps-auto col-sm-2 col-form-label">Jenis</label>
                        <div class="col-sm-4">
                           <select class="custom-select custom-select-sm form-control form-control-sm" id="tb_status2" name="tb_status2">
                              <option value="" selected>Semua Jenis</option>
                              <option value="0">PO Sales</option>
                              <option value="1">PO Stock</option>
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
                     <thead class="thead-dark" style="display:none">
                        <tr>
                           <th>No</th>
                           <th>Tanggal</th>
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
         $("#tb_vendor, #tb_status1, #tb_status2,#tb_row").select2();
         $("[data-bs-toggle=\'tooltip\']").tooltip()
         var req_status = 0;
         var modal_action = "";
         var StartDateContent = moment().subtract(60, 'days');
         var EndDateContent = moment();
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
               "url": "<?php echo site_url('function/Client_datatable_pembelian/get_data_po') ?>",
               "type": "POST",
               "data": function(data) {
                  data.search['value'] = $('#tb_search').val();
                  data.search['status'] = $('#tb_status').val();
                  data.search['colstatus'] = "TblPO.MsWorkplaceId";
                  data.search['status1'] = $('#tb_vendor').val();
                  data.search['colstatus1'] = "TblPO.MsVendorId";
                  data.search['status2'] = $('#tb_status1').val();
                  data.search['colstatus2'] = "TblPO.POStatus";
                  data.search['pojenis'] = $('#tb_status2').val();
                  data.search['tanggalstart'] = StartDateContent.format('YYYY-MM-DD');
                  data.search['tanggalend'] = EndDateContent.format('YYYY-MM-DD');
                  data.search['coltanggal'] = "PODate";
               }
            },
            "order": [],
            "columnDefs": [{
               "targets": [1],
               "visible": false,
            }],
            "createdRow": function(row, data, dataIndex) {
               $(row).addClass("tb-sales");
            },
            "language": {
               "emptyTable": '<img src="<?= base_url("asset/image/mgs-erp/iconnotfound.png") ?>" class="rounded mx-auto d-block" width="300px">',
               "zeroRecords": '<img src="<?= base_url("asset/image/mgs-erp/iconnotfound.png") ?>" class="rounded mx-auto d-block" width="300px">'
            },
         });

         $('#tb_data').on('processing.dt', function(e, settings, processing) {
            if (processing) {
               // $('#tb_data_respon').hide();
            } else {
               // $('#tb_data_respon').show();
            }
         });
         $('#tb_search').keyup(function() {
            table.ajax.reload(null, false).responsive.recalc().columns.adjust();
         });
         $('#tb_row').change(function() {
            table.page.len(parseInt($('#tb_row').val())).draw();
         });
         $('#tb_status,#tb_status1,#tb_status2,tb_vendor').change(function() {
            table.ajax.reload(null, false).responsive.recalc().columns.adjust();
         });
         $('#tb_vendor').on('select2:select', function(e) {
            table.ajax.reload(null, false).responsive.recalc().columns.adjust();
         });

         // Add event listener for opening and closing details

         async function get_detail_item(code) {
            var res = $.ajax({
               type: "POST",
               url: "<?php echo site_url('function/Client_datatable_pembelian/get_detail_po') ?>",
               data: {
                  "code": code
               },
               success: function(data) {},
               async: false,
               error: function(err) {
                  console.log(err);
               }
            }).responseText;
            return res;
         }
         $('#tb_data tbody').on('click', 'td.details-control', async function() {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
               // This row is already open - close it
               row.child.hide();
               tr.removeClass('shown');
            } else {
               var data = await get_detail_item(row.data()[8]);
               row.child(data).show();
               tr.addClass('shown');
            }
         });

         load_data_table = function() {
            table.ajax.reload(null, false).responsive.recalc().columns.adjust();
            modal_action.hide();
         };
         $("#btn-add-kunjungan").click(function(e) {
            e.preventDefault();
            if (!req_status) {
               $.ajax({
                  url: "<?php echo site_url('message/message_pembelian/po_add/') ?>",
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
         edit_click = function(id) {
            if (!req_status) {
               $.ajax({
                  url: "<?php echo site_url('message/message_pembelian/po_edit/') ?>" + id,
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
                  html: 'Anda yakin ingin menghapus data PO ini ?',
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
                        url: "<?= site_url("function/client_data_pembelian/data_po_delete/") ?>" + id,
                        before: function() {
                           req_status_add = 1;
                        },
                        success: function(data) {
                           req_status_add = 0;
                           console.log(data);
                           if (data) {
                              Swal.fire({
                                 icon: 'success',
                                 text: 'Batalkan data berhasil',
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
                                 text: 'Batalkan data gagal',
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

         po_print_a5 = function(po_id) {
            window.open('<?php echo site_url('export/datasales/po/a5/') ?>' + po_id, '_blank');
         }
         po_print_a6 = function(po_id) {
            window.open('<?php echo site_url('export/datasales/po/a6/') ?>' + po_id, '_blank');
         }
         $("#btn-export").click(function() {
            //window.open('<?php echo site_url('function/client_export_sales/pengunjung?') ?>' + "datestart=" + StartDateContent.format('YYYY-MM-DD') + "&dateend=" + EndDateContent.format('YYYY-MM-DD') + "&store=" + $('#tb_status').val(), "_blank");
         })

         delivery_add = function(id) {
            if (!req_status) {
               $.ajax({
                  type: "POST",
                  url: "<?= site_url('message/message_pembelian/po_delivery_add/') ?>" + id,
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
         delivery_print = async function(del_id) {

            const result = await $.ajax({
               url: "<?= site_url('function/client_data_sales/valid_data_delivery/') ?>" + del_id,
               type: 'POST',
            });
            if (result == "0") {
               const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                     confirmButton: 'btn btn-success mx-2',
                     cancelButton: 'btn btn-secondary mx-2'
                  },
                  buttonsStyling: false
               })
               const {
                  value: text
               } = await swalWithBootstrapButtons.fire({
                  icon: 'warning',
                  html: 'Anda belum mendapapatkan izin untuk print data ini dikarenakan perlu approval dari finance.<br>masukan catatan untuk izin request print data ini.',
                  input: 'textarea',
                  inputLabel: 'Catatan :',
                  showCancelButton: true,
                  confirmButtonText: 'Request',
                  showLoaderOnConfirm: true,
                  cancelButtonText: 'Batalkan',
                  preConfirm: (request) => {
                     console.log(request);
                     if (request == "") {
                        Swal.showValidationMessage('catatan harus diisi');
                     } else {
                        return $.ajax({
                           url: "<?= site_url("function/client_data_sales/request_delivery/") ?>" + del_id,
                           data: {
                              request: `${request}`,
                           },
                           type: 'POST',
                           success: function(response) {
                              return response
                           },
                           error: function(xhr, status, error) {
                              Swal.showValidationMessage(
                                 `Request failed: ${error}`
                              )
                           }
                        })
                     }

                  },
                  allowOutsideClick: () => !Swal.isLoading()
               });
               if (!text) {
                  return;
               } else {
                  Swal.fire({
                     icon: 'info',
                     title: 'Request sudah dikirim',
                     text: 'Menunggu approval dari Superuser',
                  })
                  return;
               }
            }
            if (result == "1") {
               var url = 'https://web.whatsapp.com/send?text=' + encodeURI("<?= base_url("?menu=redirect&search=ALY/XIII/01/SL-0024/24/I/2022") ?>");
               Swal.fire({
                  icon: 'info',
                  title: 'Request sudah dikirim',
                  text: 'Menunggu approval dari Superuser',
               })
               return;
            };
            window.open('<?php echo site_url('export/datasales/delivery/') ?>' + del_id, '_blank');

         }
         delivery_edit = function(del_id) {
            if (!req_status) {
               $.ajax({
                  type: "POST",
                  url: "<?= site_url('message/message_pembelian/po_delivery_edit/') ?>" + del_id,
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
         delivery_delete = function(del_id) {
            if (!req_status) {
               $.ajax({
                  url: "<?php echo site_url('function/client_data_sales/get_delivery_code/') ?>" + del_id,
                  beforeSend: function() {
                     req_status = 1;
                  },
                  success: function(response) {
                     req_status = 0;
                     const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                           confirmButton: 'btn btn-success mx-1',
                           cancelButton: 'btn btn-secondary mx-1'
                        },
                        buttonsStyling: false
                     });
                     swalWithBootstrapButtons.fire({
                        title: "Batalkan pengiriman",
                        html: 'Anda yakin ingin membatalkan pengiriman <b>' + response + '</b> ?',
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
                              url: "<?= site_url("function/client_data_sales/data_delivery_remove/") ?>" + del_id,
                              before: function() {
                                 req_status_add = 1;
                              },
                              success: function(data) {
                                 req_status_add = 0;

                                 if (data) {
                                    Swal.fire({
                                       icon: 'success',
                                       text: 'Batalkan data berhasil',
                                       showConfirmButton: false,
                                       allowOutsideClick: false,
                                       allowEscapeKey: false,
                                       timer: 1500,
                                    }).then((result) => {
                                       if (result.dismiss === Swal.DismissReason.timer) {

                                          table.ajax.reload(null, false).responsive.recalc().columns.adjust();
                                       }
                                    });
                                 } else {
                                    Swal.fire({
                                       icon: 'error',
                                       text: 'Batalkan data gagal',
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
                  },
                  error: function(xhr, status, error) {
                     console.log(xhr.responseText);
                     req_status = 0;
                  }
               });
            }
         }
         delivery_proses = function(del_id) {
            if (!req_status) {
               $.ajax({
                  type: "POST",
                  url: "<?= site_url('message/message_pembelian/po_delivery_proses/') ?>" + del_id,
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

         /*-------------------- BAGIAN GRPO -------------------------*/
         grpo_add = function(po_id) {
            if (!req_status) {
               $.ajax({
                  type: "POST",
                  url: "<?= site_url('message/message_pembelian/po_grpo_add/') ?>" + po_id,
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
         grpo_print_a5 = function(id) {
            window.open('<?php echo site_url('export/pembelian/grpo/a5/') ?>' + id, '_blank');
         }
         grpo_print_a6 = function(id) {
            window.open('<?php echo site_url('export/pembelian/grpo/a6/') ?>' + id, '_blank');
         }
         grpo_edit = function(id) {
            if (!req_status) {
               $.ajax({
                  type: "POST",
                  url: "<?= site_url('message/message_pembelian/po_grpo_edit/') ?>" + id,
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
         grpo_delete = function(id) {
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
                  html: 'Anda yakin ingin menghapus data GRPO ini ?',
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
                        url: "<?= site_url("function/client_data_sales/data_grpo_remove/") ?>" + id,
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
                                    table.ajax.reload(null, false).responsive.recalc().columns.adjust();
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