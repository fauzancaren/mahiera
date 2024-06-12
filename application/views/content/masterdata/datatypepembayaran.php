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
                <h2>Data Tipe Pembayaran</h2>
            </div>
            <div class="col-md-6 align-self-end">
                <ol class="breadcrumb float-md-end">
                    <li class="breadcrumb-item">Master Data</li>
                    <li class="breadcrumb-item active">Data Tipe Pembayaran</li>
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
                            <span class="fw-bold"><i class="fas fa-database" aria-hidden="true"></i>&nbsp;Master Data - Tipe Pembayaran</span>
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
                                <label for="tb_row" class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9">
                                    <select class="custom-select custom-select-sm form-control form-control-sm" id="tb_status" name="tb_status">
                                        <option value="" selected>Semua Status</option>
                                        <option value="1">Aktif</option>
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
                                    <th>Code</th>
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
                    "url": "<?php echo site_url('function/client_datatable/get_master_pembayaran_type')?>",
                    "type": "POST",
                    "data": function(data){
                        data.search['value'] = $('#tb_search').val();
                        data.search['status'] =$('#tb_status').val();
                        data.search['colstatus'] = "MsMethodIsActive";
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
            $('#tb_row').change(function(){
                table.page.len(parseInt($('#tb_row').val())).draw();
            });
            $('#tb_status').change(function(){
                table.ajax.reload(null, false).responsive.recalc().columns.adjust();
            });
            
            load_data_table = function(){
                table.ajax.reload(null, false).responsive.recalc().columns.adjust();
                modal_action.hide();
            };
            $('#btn-add-master').click(function (e) { 
                e.preventDefault();
                if(!req_status){     
                    $.ajax({
                        url:  "<?php echo site_url('message/message_master/data_method_add/')?>",
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
                        url:  "<?php echo site_url('message/message_master/data_method_view/')?>" + id,
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
                        url:  "<?php echo site_url('message/message_master/data_method_edit/')?>" + id,
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
                        url:  "<?php echo site_url('message/message_master/data_method_delete/')?>" + id,
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
                        url:  "<?php echo site_url('message/message_master/data_method_enable/')?>" + id,
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
        });
    </script>
</body>
</html>