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
                <h2>Asset Property</h2>
            </div>
            <div class="col-md-6 align-self-end">
                <ol class="breadcrumb float-md-end">
                    <li class="breadcrumb-item">Tools</li>
                    <li class="breadcrumb-item active">Asset</li>
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
                            <span class="fw-bold"><i class="fas fa-tools" aria-hidden="true"></i>&nbsp;Tools - List Property</span>
                        </div>
                        <div class="col-auto px-0">

                            <button id="btn-add-master" class="btn btn-success btn-sm btn-hide">
                                <i class="fas fa-plus" aria-hidden="true"></i>
                                <span class="fw-bold">
                                    &nbsp;Tambah Property
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
                                    <select class="custom-select custom-select-sm form-control form-control-sm" id="tb_workplace" name="tb_workplace">
                                        <option value="-" selected>Semua Toko</option>
                                        <?php
                                        $query = $this->db->get('TblMsWorkplace')->result();
                                        foreach ($query as $key) {
                                            echo '<option value="' . $key->MsWorkplaceId . '" ' . ($this->session->userdata("MsWorkplaceId") == $key->MsWorkplaceId ? "selected" : "") . '>' . $key->MsWorkplaceCode . '</option>';
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
                                    <th>Asset Divisi</th>
                                    <th>Category</th>
                                    <th>Merk</th>
                                    <th>Type</th>
                                    <th>Lokasi</th>
                                    <th>User</th>
                                    <th>Status</th>
                                    <th>Action</th>
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
            //    var modal_action = "";
            var table = $('#tb_data').DataTable({
                "responsive": true,
                "searching": false,
                "lengthChange": false,
                "pageLength": parseInt($('#tb_row').val()),
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo site_url('function/client_datatable_tools/get_visit_asset') ?>",
                    "type": "POST",
                    "data": function(data) {
                        data.search['value'] = $('#tb_search').val();
                        data.search['name'] = $('#tb_workplace').val();
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

            $('#tb_workplace').change(function() {
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
                        url: "<?php echo site_url('message/message_tools/data_asset_add/') ?>",
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

            view_click = function(id) {
                if (!req_status) {
                    $.ajax({
                        url: "<?php echo site_url('message/message_tools/data_asset_view/') ?>" + id,
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
                        url: "<?php echo site_url('message/message_tools/data_asset_edit/') ?>" + id,
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

            // delete_click = function(id) {
            //     if (!req_status) {
            //         $.ajax({
            //             url: "<?php echo site_url('Client_data_tools/qr_delete') ?>" + id,
            //             beforeSend: function() {
            //                 req_status = 1;
            //             },
            //             success: function(response) {
            //                 $("#dialog-box").html(response);
            //                 modal_action = new bootstrap.Modal(document.getElementById('modal-action'));
            //                 modal_action.show();
            //                 req_status = 0;
            //             },
            //             error: function(xhr, status, error) {
            //                 console.log(xhr.responseText);
            //                 req_status = 0;
            //             }
            //         });
            //     }
            // }
        });
    </script>
</body>

</html>