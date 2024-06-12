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
            <div class="col-md-6">
                <h2>Data Jabatan</h2>
            </div>
            <div class="col-md-6 align-self-end">
                <ol class="breadcrumb float-md-end">
                    <li class="breadcrumb-item">Master Data</li>
                    <li class="breadcrumb-item active">Data Jabatan</li>
                </ol>
            </div>
        </div>
    </section> 
    <div class="row page-content" >
        <div class="col-12">
            <div class="card border-top-orange">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <span class="fw-bold"><i class="fas fa-database" aria-hidden="true"></i>&nbsp;Master Data - Data Jabatan</span>
                        </div>
                        <div class="col-auto px-1">
                            <button type="button" class="btn btn-primary btn-sm btn-hide" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-file-export"></i>  
                                <span class="fw-bold">
                                    &nbsp;Export Data
                                </span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" 
                                        onclick="window.open('<?php echo site_url('function/client_export_master/data_jabatan_export_excel')?>','_blank')">
                                        <small><i class="fas fa-file-excel"></i>&nbsp;Export Excel</small>
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" onclick="window.open('<?php echo site_url('export/datamaster/jabatan')?>','_blank')"><small><i class="fas fa-file-pdf"></i>&nbsp;Export PDF</small></a></li>
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
                            <div class="row mb-1">
                                <label for="tb_row" class="col-sm-3 col-form-label">Status Jabatan</label>
                                <div class="col-sm-9">
                                    <select class="custom-select custom-select-sm form-control form-control-sm" id="tb_status" name="tb_status">
                                        <option value="">Semua Status</option>
                                        <option value="1" selected>Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
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
                    <div class="table-responsive" id="tb_data_respon" >
                        <table id="tb_data" class="table table-hover align-middle"  style='font-family:"Sans-serif", Helvetica; font-size:80%;width:100%'>
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Status</th>
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
        $(document).ready(function () {
            var req_status = 0;
            var modal_action = "";
            var table = $('#tb_data').DataTable( {
                "responsive": true,
                "searching": false,
                "lengthChange": false,
                "pageLength" : parseInt($('#tb_row').val()),
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo site_url('function/client_datatable/get_master_jabatan')?>",
                    "type": "POST",
                    "data": function(data){
                        data.search['value'] = $('#tb_search').val();
                        data.search['status'] = $('#tb_status').val();
                        data.search['colstatus'] = 'MsEmpPositionIsActive';
                    }
                },
                "order": [],
                "columnDefs": [
                    { 
                        "orderable": false, 
                        targets: 0 
                    },
                    { 
                        "orderable": false, 
                        targets: 3 
                    },
                    { 
                        "orderable": false, 
                        targets: 4 
                    }
                ],
                
            } );
        
            new $.fn.dataTable.FixedHeader(table);
            $('#tb_data').on('processing.dt', function (e, settings, processing) {
                    if (processing) {
                       // $('#tb_data_respon').hide();
                    } else {
                      // $('#tb_data_respon').show();
                    }
                }); 
            $('#tb_search').keyup(function(){
                table.ajax.reload(null, false).responsive.recalc().columns.adjust();
            });
            $('#tb_status').change(function(){
                table.ajax.reload(null, false).responsive.recalc().columns.adjust();
            });
            $('#tb_row').change(function(){
                table.page.len(parseInt($('#tb_row').val())).draw();
            });

            
            $('#btn-add-master').click(function (e) { 
                e.preventDefault();
                if(!req_status){     
                    $.ajax({
                        url:  "<?php echo site_url('message/message_master/data_jabatan_add/')?>",
                        beforeSend: function(){
                            req_status = 1;
                        },
                        success: function (response) {
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
            view_click = function(id){
                if(!req_status){     
                    $.ajax({
                        url:  "<?php echo site_url('message/message_master/data_jabatan_view/')?>" + id,
                        beforeSend: function(){
                            req_status = 1;
                        },
                        success: function (response) {
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
            edit_click = function(id){
                if(!req_status){     
                    $.ajax({
                        url:  "<?php echo site_url('message/message_master/data_jabatan_edit/')?>" + id,
                        beforeSend: function(){
                            req_status = 1;
                        },
                        success: function (response) {
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
            delete_click = function(id){
                if(!req_status){     
                    $.ajax({
                        url:  "<?php echo site_url('message/message_master/data_jabatan_delete/')?>" + id,
                        beforeSend: function(){
                            req_status = 1;
                        },
                        success: function (response) {
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
            enable_click = function(id){
                if(!req_status){     
                    $.ajax({
                        url:  "<?php echo site_url('message/message_master/data_jabatan_enable/')?>" + id,
                        beforeSend: function(){
                            req_status = 1;
                        },
                        success: function (response) {
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
            load_data_table = function(){
                table.ajax.reload(null, false).responsive.recalc().columns.adjust();
                modal_action.hide();
            };
        });
    </script>
</body>
</html>