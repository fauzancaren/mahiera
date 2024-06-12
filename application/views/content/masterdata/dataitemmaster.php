<section class="content-header">
    <div class="row mb-2">
        <div class="col-md-6">
            <h2>Data Produk Master</h2>
        </div>
        <div class="col align-self-end">
            <ol class="breadcrumb float-md-end">
                <li class="breadcrumb-item">Master Data</li>
                <li class="breadcrumb-item active">Produk Master</li>
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
                        <span class="fw-bold"><i class="fas fa-database" aria-hidden="true"></i>&nbsp;Master Data - Produk Master</span>
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
                                <a class="dropdown-item" onclick="window.open('<?php echo site_url('function/client_export_master/data_item_master_export_excel') ?>','_blank')">
                                    <small><i class="fas fa-file-excel"></i>&nbsp;Export Excel</small>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" onclick="window.open('<?php echo site_url('export/datamaster/item') ?>','_blank')">
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
                        <div class="row mb-1">
                            <label for="tb_row" class="col-sm-3 col-form-label">Kategori</label>
                            <div class="col-sm-9">
                                <select class="custom-select custom-select-sm form-control form-control-sm" id="tb_status_2" name="tb_status_2" style="width:100%">
                                    <option value="" selected>Semua Kategori</option>
                                    <?php
                                    $db = $this->db->get("TblMsItemCategory")->result();
                                    foreach ($db as $key) {
                                        echo '<option value="' . $key->MsItemCatId . '">' . $key->MsItemCatCode . ' - ' . $key->MsItemCatName . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <script>
                            $('#tb_status_2').select2();
                        </script>
                        <div class="row mb-1">
                            <label for="tb_row" class="col-sm-3 col-form-label">Status Jual</label>
                            <div class="col-sm-9">
                                <select class="custom-select custom-select-sm form-control form-control-sm" id="tb_status_1" name="tb_status_1">
                                    <option value="" selected>Semua Status</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label for="tb_row" class="col-sm-3 col-form-label">Status Item</label>
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
                <table id="tb_data" class="table table-hover align-middle" style='font-family:"Sans-serif", Helvetica; font-size:80%;width:100%'>
                    <thead class="thead-dark">
                        <tr>
                            <th> </th>
                            <th>Gambar</th>
                            <th>Kategori</th>
                            <th>Kode</th>
                            <th>Nama</th>  
                            <th>Status Jual</th>
                            <th>Status Item</th>
                            <th><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                </table>
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

        /* Formatting function for row details - modify as you need */
        function format(d) {
            // `d` is the original data object for the row 
            var tbody = ""; 
            var col_head = "";
            var col_cell= "";
            for(var i = 0;i < d.detail.length;i++){
                var dt_varian = d.detail[i].MsProdukDetailVarian.split("|");
                col_cell = "";
                col_head = "";
                for(var j = 0;j < dt_varian.length;j++){
                    var data = dt_varian[j].split(":");  
                    col_cell += `<td>${data[1]}</td>`;
                    col_head += `<th>Varian ${data[0]}</th>`;
                }
                tbody += `
                        <tr>
                            ${col_cell}
                            <td>${d.detail[i].MsProdukDetailBerat} ${d.detail[i].BeratCode}</td>
                            <td>${d.detail[i].MsProdukDetailPrice}</td>
                            <td>${d.detail[i].SatuanName}</td>
                            <td><a onclick="edit_detail_click(${d.detail[i].MsProdukDetailId})" class="me-2 text-warning pointer" title="Edit Data"><i class="fas fa-pencil-alt"></i></a></td>
                        </tr>`;
            } 
            var html = `
            <table class="table table-hover float-end" cellpadding="5" cellspacing="0" border="0" style="margin-left:60px; width: 90%">
                <thead>
                    <tr>
                        ${col_head}
                        <th>Berat</th>
                        <th>Harga</th>
                        <th>Satuan</th>
                        <th><i class="fas fa-cog"></i></th>
                    </tr>
                </thead>
                <tbody>${tbody}</tbody>
            </table>`;
            return html;
        }
        var table = $('#tb_data').DataTable({
            "responsive": false,
            "searching": false,
            "lengthChange": false,
            "pageLength": parseInt($('#tb_row').val()),
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo site_url('function/client_datatable/get_item') ?>",
                "type": "POST",
                "data": function(data) {
                    data.search['value'] = $('#tb_search').val();
                    data.search['status'] = $('#tb_status').val();
                    data.search['colstatus'] = "MsItemIsActive";
                    data.search['status1'] = $('#tb_status_1').val();
                    data.search['colstatus1'] = "MsItemSales";
                    data.search['status2'] = $('#tb_status_2').val();
                    data.search['colstatus2'] = "TblMsItem.MsItemCatId";
                }
            },
            columns: [
                {
                    className: 'dt-control',
                    orderable: false,
                    data: null,
                    defaultContent: '<i class="fas fa-chevron-down"></i>',
                },
                { 
                    data: "image", 
                },
                { data: 'Category' },
                { data: 'Code' },
                { data: 'Name' },
                { data: 'Sale' },
                { data: 'Stock' },
                { data: 'action' },
            ],
            columnDefs: [
                { 
                    targets: 1,
                    render: function(data) {
                        return '<img src="'+data+'" width="60" height="60">'
                    }
                }   
            ],
            "order": [],  
        });
            // Add event listener for opening and closing details
        $('#tb_data tbody').on('click', 'td.dt-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
    
            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();  
                $(this).html('<i class="fas fa-chevron-down"></i>');
            } else {
                // Open this row
                row.child(format(row.data())).show();  
                $(this).html('<i class="fas fa-chevron-up"></i>');
            }
        });
        //new $.fn.dataTable.FixedHeader(table);
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
        $('#tb_status,#tb_status_1,#tb_status_2').change(function() {
            table.ajax.reload(null, false).responsive.recalc().columns.adjust();
        });

        load_data_table = function() {
            table.ajax.reload(null, false).responsive.recalc().columns.adjust();
            modal_action.hide();
        };

        $('#btn-add-master').click(function(e) {
            e.preventDefault();
            if (!req_status) {
                $.ajax({
                    url: "<?php echo site_url('message/message_master/data_item_master_add/') ?>",
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
                    url: "<?php echo site_url('message/message_master/data_item_master_view/') ?>" + id,
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
                    url: "<?php echo site_url('message/message_master/data_item_master_edit/') ?>" + id,
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

        disable_sales_click = function(id) {
            if (!req_status) {
                $.ajax({
                    url: "<?php echo site_url('message/message_master/data_item_master_disable_jual/') ?>" + id,
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

        enable_sales_click = function(id) {
            if (!req_status) {
                $.ajax({
                    url: "<?php echo site_url('message/message_master/data_item_master_enable_jual/') ?>" + id,
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

        enable_active_click = function(id) {
            if (!req_status) {
                $.ajax({
                    url: "<?php echo site_url('message/message_master/data_item_master_enable/') ?>" + id,
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

        disable_active_click = function(id) {
            if (!req_status) {
                $.ajax({
                    url: "<?php echo site_url('message/message_master/data_item_master_disable/') ?>" + id,
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