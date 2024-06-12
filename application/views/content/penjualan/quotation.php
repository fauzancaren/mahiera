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
                <h2 onclick="menuselect('penjualan-quotation','menu-penjualan')">Penawaran (Quotation)</h2>
            </div>
            <div class="col align-self-end">
                <ol class="breadcrumb float-md-end">
                    <li class="breadcrumb-item">Penjualan</li>
                    <li class="breadcrumb-item active" onclick="menuselect('penjualan-quotation','menu-penjualan')">Penawaran (Quotation)</li>
                </ol>
            </div>
        </div>
    </section>
    <div class=" row page-content">
        <div class="col-12">
            <div class="card border-top-orange">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <span class="fw-bold"><i class="fas fa-shopping-bag" aria-hidden="true"></i>&nbsp;Penjualan - Penawaran (Quotation)</span>
                        </div>
                        <div class="col-auto px-1">
                            <button type="button" class="btn btn-primary btn-sm btn-hide" id="btn-export">
                                <i class="fas fa-file-excel"></i>
                                <span class="fw-bold">
                                    &nbsp;Export Data
                                </span>
                            </button>

                        </div>
                        <div class="col-auto px-0">
                            <button id="btn-add-quotation" class="btn btn-success btn-sm btn-hide">
                                <i class="fas fa-plus" aria-hidden="true"></i>
                                <span class="fw-bold">
                                    &nbsp;Tambah Data
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-1">
                        <div class="col-md-6 col-12 input-filter  end-input">
                            <i class="fas fa-store text-secondary" style="font-size:0.8rem"></i>
                            <span class="form-control form-control-sm i-search select-row" placeholder="Tampilkan" id="tb_workplace" data-value="<?= $this->session->userdata("MsWorkplaceId") ?>"><?= $this->session->userdata("MsWorkplaceCode") ?></span>
                            <i class="fas fa-list-ul text-secondary"></i>
                            <div class="custom-options">
                                <span class="custom-option" data-value="-">Semua Toko</span>
                                <?php
                                $db = $this->db->where("MsWorkplaceIsActive=1")->get("TblMsWorkplace")->result();
                                foreach ($db as $key) {
                                    echo '<span class="custom-option ' . ($this->session->userdata("MsWorkplaceId") == $key->MsWorkplaceId ? "selected" : "") . '" data-value="' . $key->MsWorkplaceId . '">' . $key->MsWorkplaceCode . '</span>';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="w-100 d-none d-md-block"></div>
                        <div class="col-md-6 col-12 input-filter end-input">
                            <i class="fas fa-calendar-alt text-secondary"></i>
                            <input type="text" class="form-control form-control-sm i-search" placeholder="Pilih Tanggal" id="tb_date" />
                        </div>
                        <div class="w-100 d-none d-md-block"></div>
                        <div class="col-md-3  col-6 input-filter">
                            <i class="fas fa-exclamation-circle text-secondary"></i>
                            <span class="form-control form-control-sm i-search select-row" placeholder="Tampilkan" id="tb_status" data-value="-">Semua Status</span>
                            <i class="fas fa-list-ul text-secondary"></i>
                            <div class="custom-options">
                                <span class="custom-option selected" data-value="-">Semua Status</span>
                                <span class="custom-option" data-value="0">menunggu</span>
                                <span class="custom-option" data-value="1">Selesai</span>
                                <span class="custom-option" data-value="2">Batal</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 input-filter  end-input">
                            <i class="fas fa-list-ul text-secondary"></i>
                            <span class="form-control form-control-sm i-search select-row" placeholder="Tampilkan" id="tb_row" data-value="10">Lihat 10 Baris</span>
                            <i class="fas fa-list-ul text-secondary"></i>
                            <div class="custom-options">
                                <span class="custom-option selected" data-value="10">Lihat 10 Baris</span>
                                <span class="custom-option" data-value="25">Lihat 25 Baris</span>
                                <span class="custom-option" data-value="50">Lihat 50 Baris</span>
                                <span class="custom-option" data-value="100">Lihat 100 Baris</span>
                            </div>
                        </div>
                        <div class="w-100 d-none d-md-block"></div>
                        <div class="col-md-6 col-12 input-filter end-input">
                            <input type="text" class="form-control form-control-sm i-search button" placeholder="Cari No. Dokumen/pelanggan/Alamat/nama Item" id="tb_search" />
                            <button class="btn btn-sm btn-right" id="btn-search"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <div id="wait" class="load-container load4" style="display: block;">
                        <div class="load-progress"></div>
                    </div>
                    <table id="tb_data" class="table align-middle responsive" style='font-family:"Sans-serif", Helvetica; font-size:80%;width:100%'>
                        <thead class="thead-dark" style="display:none">
                            <tr>
                                <th>nama</th>
                                <th>QuoId</th>
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

            var StartDateContent = moment().subtract(60, 'days');
            var EndDateContent = moment();
            var req_status = 0;
            var modal_action = "";
            /* ----------------                     ACTION DATE                 ------------------------ */
            Date_content = function(start, end) {
                $('#tb_date').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
                StartDateContent = start;
                EndDateContent = end;
                if (page_load > 0) table.ajax.reload(null, false).responsive.recalc().columns.adjust();
                page_load = 1;
            }
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


            var status_pembayaran = function() {

            }
            var table = $('#tb_data').DataTable({
                "responsive": true,
                "searching": false,
                "lengthChange": false,
                "pageLength": parseInt($('#tb_row').data("value")),
                "processing": false,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo site_url('function/client_datatable_sales/get_data_quotation') ?>",
                    "type": "POST",
                    "beforeSend": function() {
                        if (table && table.hasOwnProperty('settings')) {
                            table.settings()[0].jqXHR.abort();
                        }
                        $('#btn-search').html('<i class="fas fa-sync fa-spin"></i>');
                        $("#tb_data").hide();
                        $("#wait").show();
                    },
                    "data": function(data) {
                        data.search['store'] = $('#tb_workplace').data("value");
                        data.search['value'] = $('#tb_search').val();
                        data.search['status'] = $('#tb_status').data("value");
                        data.search['colstatus'] = "QuoStatus";
                        data.search['tanggalstart'] = StartDateContent.format('YYYY-MM-DD');
                        data.search['tanggalend'] = EndDateContent.format('YYYY-MM-DD');
                        data.search['coltanggal'] = "QuoDate";
                    },
                    "complete": function(data) {
                        $("#wait").hide();
                        $("#tb_data").show(1000);
                        $('#btn-search').html('<i class="fas fa-search"></i>');
                    }
                },
                "order": [],
                "columnDefs": [{
                    "targets": [1],
                    "visible": false,
                }, ],
                "createdRow": function(row, data, dataIndex) {
                    $(row).addClass("tb-sales");
                },
                "language": {
                    "emptyTable": '<img src="<?= base_url("asset/image/mgs-erp/iconnotfound.png") ?>" class="rounded mx-auto d-block" width="300px">',
                    "zeroRecords": '<img src="<?= base_url("asset/image/mgs-erp/iconnotfound.png") ?>" class="rounded mx-auto d-block" width="300px">',
                }

            });
            new $.fn.dataTable.FixedHeader(table);
            $('#tb_search').keyup(function(e) {
                if (e.keyCode === 13) {
                    table.ajax.reload(null, false).responsive.recalc().columns.adjust();
                }
            });
            $('#tb_row').change(function() {
                table.page.len(parseInt($('#tb_row').data("value"))).draw();
            });
            $('#tb_status').change(function() {
                table.ajax.reload(null, false).responsive.recalc().columns.adjust();
            });
            $('#btn-search').click(function() {
                table.ajax.reload(null, false).responsive.recalc().columns.adjust();
            })
            $('#tb_workplace').change(function() {
                table.ajax.reload(null, false).responsive.recalc().columns.adjust();
            });

            /* ----------------                     ACTION SELECT                 ------------------------ */
            $(".select-row").click(function() {
                if ($(this).parent().hasClass("open")) {
                    $(this).parent().removeClass("open")
                } else {
                    $(this).parent().addClass("open");
                }
            });
            window.addEventListener('click', function(e) {
                for (const select of document.querySelectorAll('.select-row')) {
                    const parentselect = select.closest(".open");
                    if (parentselect != null && !parentselect.contains(e.target)) {
                        parentselect.classList.remove('open');
                    }
                }
            });
            for (const option of document.querySelectorAll(".custom-option")) {
                option.addEventListener('click', function() {
                    if (!$(this).hasClass("selected")) {
                        this.parentNode.querySelector('.custom-option.selected').classList.remove('selected');
                        $(this).addClass('selected');
                        $(this).parent().parent().removeClass("open");
                        $(this).parent().parent().find('.select-row').text(this.textContent);
                        $(this).parent().parent().find('.select-row').data("value", $(this).data("value"));
                        $(this).parent().parent().find('.select-row').trigger('change');
                    }
                })
            }




            load_data_table_quotation = function() {
                table.ajax.reload(null, false).responsive.recalc().columns.adjust();
                modal_action.hide();
            };
            $('#btn-add-quotation').click(function(e) {
                e.preventDefault();
                if (!req_status) {
                    $.ajax({
                        url: "<?php echo site_url('message/message_sales/quotation_add/') ?>",
                        beforeSend: function(jqXHR, settings) {
                            req_status = 1;
                            xhrPool.push(jqXHR);
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
            quo_change_header = function(id, val) {
                if (!req_status) {
                    $.ajax({
                        url: "<?php echo site_url('message/message_sales/quotation_change_header/') ?>" + id + "/" + val,
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

            quo_edit_data = function(id) {
                if (!req_status) {
                    $.ajax({
                        url: "<?php echo site_url('message/message_sales/quotation_edit/') ?>" + id,
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

            quo_delete_data = function(id) {
                if (!req_status) {
                    $.ajax({
                        url: "<?php echo site_url('function/client_data_sales/get_quo_code/') ?>" + id,
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
                                title: "Batalkan data",
                                html: 'Anda yakin ingin membatalkan transaksi <b>' + response + '</b> ?',
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
                                        url: "<?= site_url("function/client_data_sales/data_quotation_disabled/") ?>" + id,
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
                                                        load_data_table_quotation();
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

            quo_print_data = function(id) {
                window.open('<?php echo site_url('export/datasales/quotation/') ?>' + id, '_blank');
            }

            quo_forward_data = function(id) {
                if (!req_status) {
                    $.ajax({
                        dataType: "json",
                        url: "<?php echo site_url('function/client_data_sales/get_data_sales/') ?>" + id,
                        beforeSend: function() {
                            req_status = 1;
                        },
                        success: function(response) {
                            req_status = 0;
                            show_from_notif(0, response["SalesCode"], "SALES", response["MsWorkplaceId"], response["SalesDate"]);
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                            req_status = 0;
                        }
                    });
                }
            }
            $("#btn-export").click(function() {
                window.open('<?php echo site_url('function/client_export_sales/quotation_export_excel?') ?>' + "datestart=" + StartDateContent.format('YYYY-MM-DD') + "&dateend=" + EndDateContent.format('YYYY-MM-DD') + "&store=" + $('#tb_workplace').data("value"), "_blank");
            })
        });
    </script>
</body>

</html>