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
      .box{
        padding: 0.25rem;
        margin: 0.25rem;
        margin-bottom: 1rem;
        border: 1px solid #e7d8c9;
        background: #fff2e5;
        border-radius: 0.5rem;
        box-shadow: 0px 2px 9px 0px #833c002e;
      }
   </style>
</head>

<body>
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-md-auto col-12">
                <h2>Data Produksi</h1>
            </div>
            <div class="col align-self-end">
                <ol class="breadcrumb float-md-end">
                <li class="breadcrumb-item">Inventory</li>
                <li class="breadcrumb-item active">Data Produksi</li>
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
                            <span class="fw-bold"><i class="fas fa-warehouse" aria-hidden="true"></i>&nbsp;Inventory - Data Produksi</span>
                        </div> 
                    </div>
                </div> 

                <div class="card-body">  
                    <div class="box">
                        <h6 class="text-center pt-4">DATA LIST SEDANG CETAK<button class="ms-2 btn btn-sm btn-primary p-1" onclick="load_chart()"><i class="fas fa-sync-alt pe-2"></i>Refresh</button></h6> 
                        <div class="chart-container" style="position: relative; height:300px; width:90vw">
                            <canvas id="myChart"></canvas> 
                        </div> 
                    </div> 
  
                    <ul class="nav nav-tabs" id="tab-produksi" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="po-baru" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">PO Baru</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="po-cetak" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Proses Cetak</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="po-proses" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Proses Pengeringan</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="po-selesai" data-bs-toggle="tab" data-bs-target="#disabled-tab-pane" type="button" role="tab" aria-controls="disabled-tab-pane" aria-selected="false">Selesai</button>
                        </li>
                    </ul> 
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                            <div class="row p-2">
                                <div class="col-md-6 col-12"> 
                                    <div class="row mb-2">
                                        <span class="fw-bold">Filter</span>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="form-check col-md-3 col-form-label ps-2">
                                            <input class="form-check-input ms-0" type="checkbox" value="" id="POBaruDateCheck">
                                            <label class="form-check-label" for="POBaruDateCheck">Tanggal PO</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input id="POBaruDate" name="POBaruDate" type="text" class="form-control form-control-sm" value="" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="POBaruSearch" class="col-md-3 col-form-label">Pencarian<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-md-9">
                                            <input id="POBaruSearch" name="POBaruSearch" type="text" class="form-control form-control-sm" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                            <div class="row p-2">
                                <div class="col-md-6 col-12"> 
                                    <div class="row mb-2">
                                        <span class="fw-bold">Filter</span>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="CetakStaffId" class="col-md-3 col-form-label">Staff Cetak<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-md-9">
                                            <select class="custom-select custom-select-sm form-control form-control-sm" multiple="multiple"  id="CetakStaffId" name="CetakStaffId" style="width:100%">
                                                <?php
                                                $query = $this->db->get('TblMsStaff')->result();
                                                foreach ($query as $key) {
                                                    echo '<option value="' . $key->StaffId . '" >' . $key->StaffName . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="CetakSearch" class="col-md-3 col-form-label">Pencarian<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-md-9">
                                            <input id="CetakSearch" name="CetakSearch" type="text" class="form-control form-control-sm" value="">
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                            <div class="row p-2">
                                <div class="col-md-6 col-12"> 
                                    <div class="row mb-2">
                                        <span class="fw-bold">Filter</span>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="KeringStaffId" class="col-md-3 col-form-label">Staff Cetak<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-md-9">
                                            <select class="custom-select custom-select-sm form-control form-control-sm" multiple="multiple"  id="KeringStaffId" name="KeringStaffId" style="width:100%">
                                                <?php
                                                $query = $this->db->get('TblMsStaff')->result();
                                                foreach ($query as $key) {
                                                    echo '<option value="' . $key->StaffId . '" >' . $key->StaffName . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="KeringSearch" class="col-md-3 col-form-label">Pencarian<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-md-9">
                                            <input id="KeringSearch" name="KeringSearch" type="text" class="form-control form-control-sm" value="">
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">
                            <div class="row p-2">
                                <div class="col-md-6 col-12"> 
                                    <div class="row mb-2">
                                        <span class="fw-bold">Filter</span>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="SelesaiDate" class="col-md-3 col-form-label">Tanggal Selesai<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-md-9">
                                            <input id="SelesaiDate" name="SelesaiDate" type="text" class="form-control form-control-sm" value="">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="SelesaiStaffId" class="col-md-3 col-form-label">Staff Cetak<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-md-9">
                                            <select class="custom-select custom-select-sm form-control form-control-sm" multiple="multiple"  id="SelesaiStaffId" name="SelesaiStaffId" style="width:100%">
                                                <?php
                                                $query = $this->db->get('TblMsStaff')->result();
                                                foreach ($query as $key) {
                                                    echo '<option value="' . $key->StaffId . '" >' . $key->StaffName . '</option>';
                                                }
                                                ?>
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label for="SelesaiSearch" class="col-md-3 col-form-label">Pencarian<sup class="error">&nbsp;*</sup></label>
                                        <div class="col-md-9">
                                            <input id="SelesaiSearch" name="SelesaiSearch" type="text" class="form-control form-control-sm" value="">
                                        </div>
                                    </div>
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
    <script>

        var ctx = document.getElementById("myChart");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    <?php
                        $_datastaff = $this->db->query("SELECT *,(SELECT IFNULL(SUM(ProduksiQty),0) FROM TblProduksi WHERE ProduksiStatus=0 AND MsStaffId=Staffid) AS count FROM TblMsStaff ORDER BY COUNT desc")->result();
                        foreach($_datastaff as $row){
                            echo '"'.$row->StaffName.'",'; 
                        }
                    ?>],
                datasets: [{  
                    backgroundColor: '#f0ad4e',   
                    barPercentage:0.9,  
                    data: [
                        <?php 
                            foreach($_datastaff as $row){
                                echo '"'.$row->count.'",';
                            }
                        ?>], 
                    borderWidth: 1
                }]
            },
            options: { 
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false, 
                    },
                    beforeDraw: (chart) => {
                        const {ctx} = chart;
                        ctx.save();
                        ctx.globalCompositeOperation = 'destination-over';
                        ctx.fillStyle = 'lightGreen';
                        ctx.fillRect(0, 0, chart.width, chart.height);
                        ctx.restore();
                    }
                },
                indexAxis: 'y', 
                yAxes: [{
                    categorySpacing: 0
                }],
                layout: {
                    width: "80%"
                }, 
            },
        });

        var dateStartPONew = moment().subtract(1, 'month');
        var dateEndPONew = moment();
        var dateStartSelesai = moment().subtract(1, 'month');
        var dateEndSelesai = moment();
        var page_load_baru = 0; 
        var page_load_selesai = 0; 
        $('#POBaruDate').daterangepicker({
            startDate: dateStartPONew,
            endDate: dateEndPONew,
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
        }, Date_content_new);
        function Date_content_new(start, end) {
            $('#POBaruDate').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
            dateStartPONew = start;
            dateEndPONew = end;
            if (page_load_baru != 0) {
                show_content_baru();
            } else {
                page_load_baru = 1;
            }
        }
        $('#SelesaiDate').daterangepicker({
            startDate: dateStartSelesai,
            endDate: dateEndSelesai,
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
        }, Date_content_new);
        function Date_content_new(start, end) {
            $('#SelesaiDate').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
            dateStartSelesai = start;
            dateEndSelesai = end;
            if (page_load_selesai != 0) {
                show_content_selesai();
            } else {
                page_load_selesai = 1;
            }
        }
        $("#POBaruDateCheck").change(function(){
            this.checked ? $('#POBaruDate').removeAttr('disabled') :$ ('#POBaruDate').attr('disabled','disabled'); 
        }) 
        $("#CetakStaffId").select2({
            allowClear: true,
            placeholder: 'Semua Staff',
         });
        $("#KeringStaffId").select2({
            allowClear: true,
            placeholder: 'Semua Staff',
         });
        $("#SelesaiStaffId").select2({
            allowClear: true,
            placeholder: 'Semua Staff',
         });



        var menu_select = "po-baru";
        var modal_action = "";
        $("#tab-produksi button").click(function(){
            var menu = $(this).prop("id"); 
            switch(menu){
                case "po-baru": 
                    menu_select = "po-baru";
                    show_content_baru();
                    break;
                case "po-cetak":
                    menu_select = "po-cetak";
                    show_content_cetak();
                    break;
                case "po-proses":
                    menu_select = "po-proses";
                    show_content_proses();
                    break;
                case "po-selesai":
                    menu_select = "po-selesai";
                    show_content_selesai();
                    break;
                default:
                    //
            } 
        });
        var ajax_req;
        var modal_action;
        show_content_baru = function() {
            $("#data-content").hide();
            $("#wait-content").show();
            if (ajax_req && ajax_req.readyState != 4) {
                ajax_req.abort();
            }
            ajax_req = $.ajax({
                type: "POST",
                url: "<?= site_url('function/client_datatable_inventory/get_menu_produksi_baru/') ?>",
                success: function(data) {
                    $("#wait-content").hide();
                    $("#data-content").html(data);
                    $("#data-content").show();
                    load_chart();
                }
            })
        }
        show_content_cetak = function() {
            $("#data-content").hide();
            $("#wait-content").show();
            if (ajax_req && ajax_req.readyState != 4) {
                ajax_req.abort();
            }
            ajax_req = $.ajax({
                type: "POST",
                url: "<?= site_url('function/client_datatable_inventory/get_menu_produksi_cetak/') ?>",
                success: function(data) {
                    $("#wait-content").hide();
                    $("#data-content").html(data);
                    $("#data-content").show();
                    load_chart();
                }
            })
        }
        show_content_proses = function() {
            $("#data-content").hide();
            $("#wait-content").show();
            if (ajax_req && ajax_req.readyState != 4) {
                ajax_req.abort();
            }
            ajax_req = $.ajax({
                type: "POST",
                url: "<?= site_url('function/client_datatable_inventory/get_menu_produksi_proses/') ?>",
                success: function(data) {
                    $("#wait-content").hide();
                    $("#data-content").html(data);
                    $("#data-content").show();
                    load_chart();
                }
            })
        }
        show_content_selesai = function() {
            if (ajax_req && ajax_req.readyState != 4) {
                ajax_req.abort();
            }
            ajax_req = $.ajax({
                type: "POST",
                url: "<?= site_url('function/client_datatable_inventory/get_menu_produksi_selesai/') ?>",
                success: function(data) {
                    $("#wait-content").hide();
                    $("#data-content").html(data);
                    $("#data-content").show();
                    load_chart();
                }
            })
        }
        show_content_baru();


        ready_stock = function(item,vendor,code){
            if (ajax_req && ajax_req.readyState != 4) {
                ajax_req.abort();
            }
            ajax_req = $.ajax({
                type: "POST",
                data:{
                    item : item,
                    vendor : vendor,
                    code : code
                },
                url: "<?= site_url('message/message_inventory/ready_stock/') ?>",
                success: function(data) {
                    $("#dialog-box").html(data);
                    modal_action = new bootstrap.Modal(document.getElementById('modal-action'));
                    modal_action.show(); 
                } 
            })
        }
        proses_cetak = function(item,vendor,code){
            if (ajax_req && ajax_req.readyState != 4) {
                ajax_req.abort();
            }
            ajax_req = $.ajax({
                type: "POST",
                data:{
                    item : item,
                    vendor : vendor,
                    code : code
                },
                url: "<?= site_url('message/message_inventory/cek_item_bom/') ?>",
                success: function(data) {
                    if(data=="true"){ 
                        if (ajax_req && ajax_req.readyState != 4) {
                            ajax_req.abort();
                        }
                        ajax_req = $.ajax({
                            type: "POST",
                            data:{
                                item : item,
                                vendor : vendor,
                                code : code
                            },
                            url: "<?= site_url('message/message_inventory/proses_cetak/') ?>",
                            success: function(data) {
                                $("#dialog-box").html(data);
                                modal_action = new bootstrap.Modal(document.getElementById('modal-action'));
                                modal_action.show(); 
                            } 
                        })
                    }else{ 
                        const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-success mx-1',
                                cancelButton: 'btn btn-secondary mx-1'
                            },
                            buttonsStyling: false
                        })
                        swalWithBootstrapButtons.fire({
                            title: "Data Bahan Baku Tidak Ada!",
                            html: "anda harus memasukan bahan baku terlebih dahulu di data master",
                            icon: "warning",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showCancelButton: true,
                            confirmButtonText: "Buat",
                            cancelButtonText: "Keluar",
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {  
                                $.ajax({
                                    url:  "<?=  site_url('message/message_master/data_bom_action/')?>" + item + "/undefined" ,
                                    success: function (response) {
                                        $("#dialog-box").html(response);
                                        modal_action = new bootstrap.Modal(document.getElementById('modal-action'));
                                        modal_action.show(); 
                                    },
                                    error: function(xhr, status, error) {
                                        console.log(xhr.responseText);
                                    }
                                });
                            }
                        })
                    }
                } 
            })
        }
        edit_proses_cetak = function(id){ 
            if (ajax_req && ajax_req.readyState != 4) {
                ajax_req.abort();
            }
            ajax_req = $.ajax({
                type: "POST", 
                url: "<?= site_url('message/message_inventory/proses_cetak_edit/') ?>" + id,
                success: function(data) {
                    $("#dialog-box").html(data);
                    modal_action = new bootstrap.Modal(document.getElementById('modal-action'));
                    modal_action.show(); 
                } 
            })  
        }

        proses_kering = function(id){
            if (ajax_req && ajax_req.readyState != 4) {
                ajax_req.abort();
            }
            ajax_req = $.ajax({
                type: "POST", 
                url: "<?= site_url('message/message_inventory/proses_kering/') ?>" + id,
                success: function(data) {
                    $("#dialog-box").html(data);
                    modal_action = new bootstrap.Modal(document.getElementById('modal-action'));
                    modal_action.show(); 
                } 
            })  
        }
        edit_proses_kering = function(id){ 
            if (ajax_req && ajax_req.readyState != 4) {
                ajax_req.abort();
            }
            ajax_req = $.ajax({
                type: "POST", 
                url: "<?= site_url('message/message_inventory/proses_kering_edit/') ?>" + id,
                success: function(data) {
                    $("#dialog-box").html(data);
                    modal_action = new bootstrap.Modal(document.getElementById('modal-action'));
                    modal_action.show(); 
                } 
            })  
        }
        proses_ready = function(id){ 
            if (ajax_req && ajax_req.readyState != 4) {
                ajax_req.abort();
            }
            ajax_req = $.ajax({
                type: "POST", 
                url: "<?= site_url('message/message_inventory/proses_ready/') ?>" + id,
                success: function(data) {
                    $("#dialog-box").html(data);
                    modal_action = new bootstrap.Modal(document.getElementById('modal-action'));
                    modal_action.show(); 
                } 
            })  
        }
        load_data_table = function() {

              
            switch(menu_select){
                case "po-baru": 
                    show_content_baru();
                    break;
                case "po-cetak":
                    show_content_cetak();
                    break;
                case "po-proses":
                    show_content_proses();
                    break;
                case "po-selesai":
                    show_content_selesai();
                    break;
                default:
                    //
            } 
            try {
               modal_action.hide();
            } catch (error) {

            }
        };
        function arrayColumn(matrix, col){
            var column = [];
            for(var i=0; i<matrix.length; i++){
                console.log(matrix[i]["StaffName"]);
                column.push(matrix[i][col]);
            }
            return column;
        } 
        load_chart = function(){
            if (ajax_req && ajax_req.readyState != 4) {
                ajax_req.abort();
            }
            ajax_req = $.ajax({
                type: "POST",
                dataType:"json",
                url: "<?= site_url('function/client_datatable_inventory/get_data_cetak_dash/') ?>",
                success: function(data) {  
                    myChart.data =  {
                        labels: arrayColumn(data, "StaffName"),
                        datasets: [{  
                            backgroundColor: '#f0ad4e',   
                            barPercentage:0.9,  
                            data: arrayColumn(data, "count"),
                            borderWidth: 1
                        }]
                    };
                    myChart.update();
                }
            })
        }
    </script>
</body> 