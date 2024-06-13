<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <style>
      .timeline ul li {
         list-style-type: none;
         position: relative;
         width: 3px;
         background: #b4b4b4;
      }

      .timeline ul li::after {
         content: '';
         position: absolute;
         left: 50%;
         top: 10%;
         transform: translateX(-50%);
         width: 15px;
         height: 15px;
         border-radius: 50%;
         background: inherit;
      }

      .timeline ul li div {
         position: relative;
         bottom: 0;
         width: 21rem;
         padding: 0.5rem 1rem;
         border-radius: 11px;
         font-size: 0.8rem;
      }

      .timeline time {
         color: gray;
         font-size: 0.75rem;
         display: block;
      }

      .btn-check:active+.btn-check-obi,
      .btn-check:checked+.btn-check-obi {
         color: #6c9bcf;
         border-color: #6c9bcf;
      }

      .btn-check-obi {
         color: #9f9f9f;
         background-color: #f7fdff;
         border-color: #cfcfcf;
         padding: 0.2rem !important;
         font-weight: bold;
         font-size: 0.5rem !important;
      }


      .card-periode {
         font-size: 0.75rem;
         color: gray;
      }

      .card-periode>.periode {
         padding: 0 1rem;
         min-width: 8rem;
         display: inline-block;
         text-align: center;
      }

      .card-periode>i,
      .action-admin-show {
         cursor: pointer;
      }

      .card-periode>i:hover,
      .action-admin-show:hover {
         cursor: pointer;
         color: black;
         background: #e5e5e5;
         border-radius: 0.5rem;
      }

      .card-admin {
         overflow-x: hidden;
      }

      .card-admin>.header:not(.show) {
         left: -100%;
         transition: all 0.5s;
      }

      .card-admin>.header {
         left: 1rem;
         position: absolute;
         width: 90%;
         transition: all 0.5s;
      }


      .card-admin>.detail:not(.show) {
         left: 100%;
         transition: all 0.5s;
      }

      .card-admin>.detail {
         left: 1rem;
         position: absolute;
         width: 90%;
         transition: all 0.5s;
      }

      .loading-dashboard {
         display: block;
         text-align: center;
         height: 8rem;
         color: #6c9bcf;
;
      }

      .card-sales-footer {
         background: #f3e0e045;
         width: 100%;
         position: absolute;
         left: 0;
         bottom: 0;
         border-radius: 0.25rem;
         border-top-left-radius: 0;
         border-top-right-radius: 0;
         text-align: center;
         padding: 0.25rem;
         text-decoration: none;
         color: #f34a4a;
      }

      .card-sales-footer:hover {
         background: #ffecec;
         cursor: pointer;
      }
   </style>
</head>

<body>
   <section class="content-header">
      <div class="row mb-2">
         <div class="col-md-auto col-12">
            <h2 onclick="menuselect('penjualan-salesorder','menu-penjualan')">Penjualan (Sales Order)</h2>
         </div>
         <div class="col align-self-end">
            <ol class="breadcrumb float-md-end">
               <li class="breadcrumb-item profile">Penjualan</li>
               <li class="breadcrumb-item active" onclick="menuselect('penjualan-salesorder','menu-penjualan')" style="cursor:pointer">Penjualan (Sales Order)</li>
            </ol>
         </div>
      </div>
   </section>
   <div class="row row-cols-3 g-3 mb-2">
      <div class="col-12 col-md-4">
         <div class="card shadow">
            <div class="card-header">
               <div class="fw-bold">Transaksi Belum dibayarkan (sudah DP)</div>
            </div>
            <div class="card-body" style="max-height:10rem;min-height:10rem;height:10rem;">
               <div class="d-flex flex-column fw-bold">
                  <div class="px-2 d-flex">
                     <span class="flex-grow-1 text-secondary">Jumlah Transaksi</span>
                     <span class="fs-4 text-danger card-total" id="card-total-trans">0</span>
                  </div>
                  <div class="px-2 d-flex">
                     <span class="flex-grow-1  text-secondary">Total Pelunasan</span>
                     <span class="fs-4 text-danger card-total" id="card-total-payment">0</span>
                  </div>
                  <span class="text-danger p-2" style="font-size:0.65rem">* Transaksi akan otomatis batal jika tidak dilakukan pembayaran dp selama 2 bulan</span>
               </div>
               <a onclick="get_list_payment()" class="card-sales-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
         </div>
      </div>
      <div class="col-12 col-md-4">
         <div class="card shadow">
            <div class="card-header">
               <div class="d-flex">
                  <div class="fw-bold flex-grow-1">Total Penjualan kategori</div>
                  <div class="card-periode user-select-none">
                     <i class="fas fa-chevron-left pointer" onclick="back_date_category()"></i>
                     <div class="periode" data-periode="<?= date("Y-m-d") ?>" id="date-category"><?= date("F Y") ?></div>
                     <i class="fas fa-chevron-right pointer" onclick="next_date_category()"></i>
                  </div>
               </div>
            </div>
            <div class="card-body overflow-auto" id="data-category" style="max-height:10rem;min-height:10rem;height:10rem;">
               <div id="wait_category" class="loading-dashboard">
                  <i class="fas fa-spinner fa-spin" style="font-size:5rem"></i>
               </div>
               <div id="body_category" class="d-flex flex-column fw-bold" style="display:none !important">
                  <div class="d-flex">
                     <span class="flex-grow-1 text-secondary">ROSTER PUTIH</span>
                     <span>0</span>
                  </div>
                  <div class="d-flex">
                     <span class="flex-grow-1 text-secondary">ROSTER RED</span>
                     <span>0</span>
                  </div>
                  <div class="d-flex">
                     <span class="flex-grow-1 text-secondary">ROSTER SEMEN</span>
                     <span>0</span>
                  </div>
                  <div class="d-flex">
                     <span class="flex-grow-1 text-secondary">ROSTER TANAH LIAT</span>
                     <span>0</span>
                  </div>
                  <div class="d-flex">
                     <span class="flex-grow-1 text-secondary">BATA EXPOSE</span>
                     <span>0</span>
                  </div>
                  <div class="d-flex">
                     <span class="flex-grow-1 text-secondary">BATA TEMPEL</span>
                     <span>0</span>
                  </div>
                  <div class="d-flex">
                     <span class="flex-grow-1 text-secondary">COATING</span>
                     <span>0</span>
                  </div>
                  <div class="d-flex">
                     <span class="flex-grow-1 text-secondary">ROBLOCK</span>
                     <span>0</span>
                  </div>
                  <div class="d-flex">
                     <span class="flex-grow-1 text-secondary">GRASS BLOCK</span>
                     <span>0</span>
                  </div>
                  <div class="d-flex">
                     <span class="flex-grow-1 text-secondary">GLOCANA</span>
                     <span>0</span>
                  </div>
                  <div class="d-flex">
                     <span class="flex-grow-1 text-secondary">PAVING BLOCK</span>
                     <span>0</span>
                  </div>
                  <div class="d-flex">
                     <span class="flex-grow-1 text-secondary">JASA PEMASANGAN</span>
                     <span>0</span>
                  </div>
                  <div class="d-flex">
                     <span class="flex-grow-1 text-secondary">JASA DESIGN</span>
                     <span>0</span>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-12 col-md-4">
         <div class="card  shadow">
            <div class="card-header">
               <div class="d-flex">
                  <div class="fw-bold flex-grow-1">Total Penjualan Admin</div>
                  <div class="card-periode user-select-none">
                     <i class="fas fa-chevron-left pointer" onclick="back_date_admin()"></i>
                     <div class="periode" data-periode="<?= date("Y-m-d") ?>" id="date-admin"><?= date("F Y") ?></div>
                     <i class="fas fa-chevron-right pointer" onclick="next_date_admin()"></i>
                  </div>
               </div>
            </div>
            <div class="card-body card-admin" style="max-height:10rem;min-height:10rem;height:10rem;position:relative;max-width:100%">
               <div id="wait_admin" class="loading-dashboard">
                  <i class="fas fa-spinner fa-spin" style="font-size:5rem"></i>
               </div>
               <div id="body_admin" class="card-admin" style=" display:none !important">

               </div>
            </div>
         </div>
      </div>
   </div>
   <div id="message-alert"></div>

   <div class="row page-content">
      <div class="col-12">
         <div class="card border-top-orange">
            <div class="card-header">
               <div class="row align-items-center">
                  <div class="col">
                     <span class="fw-bold"><i class="fas fa-shopping-bag" aria-hidden="true"></i>&nbsp;Penjualan - Penjualan (Sales Order)</span>
                  </div>
                  <div class="col-auto px-1">
                     <button type="button" class="btn btn-primary btn-sm btn-hide" id="export-sales" aria-expanded="false">
                        <i class="fas fa-file-excel"></i>
                        <span class="fw-bold ps-1 d-sm-inline-block d-none"> Export Data</span>
                     </button>
                  </div>
                  <div class="col-auto px-0">
                     <button id="btn-add-sales" class="btn btn-success btn-sm btn-hide">
                        <i class="fas fa-plus" aria-hidden="true"></i>
                        <span class="fw-bold ps-1 d-sm-inline-block d-none">Tambah Data</span>
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
                  <div class="col-md-6 col-12 input-filter end-input" style="margin-bottom:0.2rem !important">
                     <div class=" row ">
                        <div class=" btn-group btn-group-sm" role="group" aria-label="Basic checkbox toggle button group">
                           <label class="btn btn-check-obi px-0" style="max-width:2rem;min-width:2rem"><i class="fas fa-dollar-sign text-secondary" style="font-size:0.8rem"></i></label>

                           <input type="checkbox" class="btn-check" id="btncheckpay0" autocomplete="off" checked>
                           <label class="btn btn-check-obi px-0" for="btncheckpay0" style="min-width:5rem;max-width:5rem;">Semua Status</label>

                           <input type="checkbox" class="btn-check" id="btncheckpay1" autocomplete="off" checked>
                           <label class="btn btn-check-obi px-0" for="btncheckpay1">Belum Bayar</label>

                           <input type="checkbox" class="btn-check" id="btncheckpay2" autocomplete="off" checked>
                           <label class="btn btn-check-obi px-0" for="btncheckpay2">Sudah DP</label>

                           <input type="checkbox" class="btn-check" id="btncheckpay3" autocomplete="off" checked>
                           <label class="btn btn-check-obi px-0" for="btncheckpay3">Selesai</label>

                           <input type="checkbox" class="btn-check" id="btncheckpay4" autocomplete="off" checked>
                           <label class="btn btn-check-obi px-0" for="btncheckpay4">Dibatalkan</label>
                        </div>
                     </div>
                  </div>
                  <div class="w-100 d-none d-md-block"></div>
                  <div class="col-md-2 col-4 input-filter">
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
                  <div class="col-md-4 col-8 input-filter end-input">
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
   <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas-logsales" aria-labelledby="offcanvas-logsalesLabel">
      <div class="offcanvas-header">
         <h5 class="offcanvas-title" id="offcanvas-logsalesLabel">Log Activity sales</h5>
         <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
         <div id="wait-timeline" class="load-container load4" style="display: block;">
            <div class="load-progress"></div>
         </div>
         <section class="timeline" id="timeline">
            <ul>
               <li>
                  <div>
                     <time>2020-01-12 13:02:00</time>
                     <b>Sales</b> telah dibuat oleh <b>ALAN KURNIAWAN</b>
                  </div>
               </li>
               <li>
                  <div>
                     <time>2020-01-12 14:02:00</time>
                     <b>Performa Invoice</b> telah dibuat oleh <b>ALAN KURNIAWAN</b> sebesar Rp. 700.000 (DP) dengan type <b>TRANSFER</b>
                  </div>
               </li>
               <li>
                  <div>
                     <time>2020-01-12 14:02:00</time>
                     <b>Pembayaran</b> dibuat oleh <b>ALAN KURNIAWAN</b> sebesar Rp. 200.000 (DP) dengan type <b>TRANSFER</b>
                  </div>
               </li>
               <li>
                  <div>
                     <time>2020-01-12 15:02:00</time>
                     <b>PO</b> telah dibuat oleh <b>ALAN KURNIAWAN</b> dengan item Roster L 50pcs(WHO)
                  </div>
               </li>
               <li>
                  <div>
                     <time>2020-01-13 15:02:00</time>
                     <b>Pengiriman</b> <b>Rit 1</b> telah dibuat oleh <b>RYAN FEBRIANSYAH</b> dengan item Roster L 50pcs(WHO) pada tanggal <b>Senin, 17 Sep 2021</b>
                  </div>
               </li>
               <li>
                  <div>
                     <time>2020-01-13 15:02:00</time>
                     <b>Pengiriman</b> <b>Rit 1</b> telah ditugaskan oleh <b>ARIEF BUDIARTO</b> kepada pickup dengan driver <b>AGUNG MULYADI</b> dan <b>SEPTIAN ADE SAPUTRa</b> untuk dikirimkan pada tanggal <b>Selasa, 18 Sep 2021</b>
                  </div>
               </li>
               <li>
                  <div>
                     <time>1934</time>
                     Some content here
                  </div>
               </li>
               <li>
                  <div>
                     <time>1934</time>
                     Some content here
                  </div>
               </li>
            </ul>
         </section>
      </div>
   </div>
   <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas-approve" aria-labelledby="offcanvas-approveLabel">
      <div class="offcanvas-header">
         <h5 class="offcanvas-title" id="offcanvas-approveLabel">Log Approval</h5>
         <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
         <div id="wait-timeline-approve" class="load-container load4" style="display: block;">
            <div class="load-progress"></div>
         </div>
         <section class="timeline" id="timeline-approve">
            <ul>
               <li>
                  <div>
                     <time>2020-01-12 13:02:00</time>
                     <b>Sales</b> telah dibuat oleh <b>ALAN KURNIAWAN</b>
                  </div>
               </li>
               <li>
                  <div>
                     <time>2020-01-12 14:02:00</time>
                     <b>Performa Invoice</b> telah dibuat oleh <b>ALAN KURNIAWAN</b> sebesar Rp. 700.000 (DP) dengan type <b>TRANSFER</b>
                  </div>
               </li>
               <li>
                  <div>
                     <time>2020-01-12 14:02:00</time>
                     <b>Pembayaran</b> dibuat oleh <b>ALAN KURNIAWAN</b> sebesar Rp. 200.000 (DP) dengan type <b>TRANSFER</b>
                  </div>
               </li>
               <li>
                  <div>
                     <time>2020-01-12 15:02:00</time>
                     <b>PO</b> telah dibuat oleh <b>ALAN KURNIAWAN</b> dengan item Roster L 50pcs(WHO)
                  </div>
               </li>
               <li>
                  <div>
                     <time>2020-01-13 15:02:00</time>
                     <b>Pengiriman</b> <b>Rit 1</b> telah dibuat oleh <b>RYAN FEBRIANSYAH</b> dengan item Roster L 50pcs(WHO) pada tanggal <b>Senin, 17 Sep 2021</b>
                  </div>
               </li>
               <li>
                  <div>
                     <time>2020-01-13 15:02:00</time>
                     <b>Pengiriman</b> <b>Rit 1</b> telah ditugaskan oleh <b>ARIEF BUDIARTO</b> kepada pickup dengan driver <b>AGUNG MULYADI</b> dan <b>SEPTIAN ADE SAPUTRa</b> untuk dikirimkan pada tanggal <b>Selasa, 18 Sep 2021</b>
                  </div>
               </li>
               <li>
                  <div>
                     <time>1934</time>
                     Some content here
                  </div>
               </li>
               <li>
                  <div>
                     <time>1934</time>
                     Some content here
                  </div>
               </li>
            </ul>
         </section>
      </div>
   </div>
   <div id="dialog-box">
   </div>
   <div id="modal-view-show">
   </div>
   <script>
      $(document).ready(function() {
         var min_date_payment = moment();
         var min_date_delivery = moment();
         var min_date_PO = moment();
         var min_date_payment_remove = moment();


         back_date_category = function() {
            var date = moment($("#date-category").data("periode"));
            date.subtract(1, 'months');
            $("#date-category").data("periode", date.format("YYYY-MM-DD"));
            $("#date-category").html(date.format("MMMM YYYY"));
            load_sales_category();
         }
         next_date_category = function() {
            var date = moment($("#date-category").data("periode"));
            date.add(1, 'months');
            $("#date-category").data("periode", date.format("YYYY-MM-DD"));
            $("#date-category").html(date.format("MMMM YYYY"));
            load_sales_category();
         }
         var ajax_sales_category;
         load_sales_category = function() {
            $("#wait_category").show();
            $("#body_category").addClass("d-none");
            var datestart = moment($("#date-category").data("periode"), "YYYY-MM-DD").startOf('month');
            var dateend = moment($("#date-category").data("periode"), "YYYY-MM-DD").endOf('month');
            var store = $('#tb_workplace').data("value");
            if (ajax_sales_category && ajax_sales_category.readyState != 4) {
               ajax_sales_category.abort();
            }
            ajax_sales_category =
               $.ajax({
                  method: "POST",
                  url: "<?= site_url("function/client_data_sales/get_card_category/") ?>",
                  data: {
                     datestart: datestart.format("YYYY-MM-DD"),
                     dateend: dateend.format("YYYY-MM-DD"),
                     store: store,
                  },
                  success: function(data) {
                     $("#body_category").html(data);
                     $("#wait_category").hide();
                     $("#body_category").show();
                     $("#body_category").removeClass("d-none");
                  }
               });
         }

         show_list = function(d) {
            $(d).parent().parent().removeClass("show");
            $(d).parent().parent().parent().find(".header").addClass("show");
         }
         show_detail = function(d, id) {
            var datestart = moment($("#date-admin").data("periode"), "YYYY-MM-DD").startOf('month');
            var dateend = moment($("#date-admin").data("periode"), "YYYY-MM-DD").endOf('month');
            var store = $('#tb_workplace').data("value");
            if (ajax_sales_admin && ajax_sales_admin.readyState != 4) {
               ajax_sales_admin.abort();
            }
            ajax_sales_admin =
               $.ajax({
                  method: "POST",
                  url: "<?= site_url("function/client_data_sales/get_card_admin_category/") ?>" + id,
                  data: {
                     datestart: datestart.format("YYYY-MM-DD"),
                     dateend: dateend.format("YYYY-MM-DD"),
                     store: store,
                  },
                  success: function(data) {
                     $(d).parent().parent().parent().find(".detail").html(data);
                     $(d).parent().parent().removeClass("show");
                     $(d).parent().parent().parent().find(".detail").addClass("show");
                  }
               });

         }
         back_date_admin = function() {
            var date = moment($("#date-admin").data("periode"));
            date.subtract(1, 'months');
            $("#date-admin").data("periode", date.format("YYYY-MM-DD"));
            $("#date-admin").html(date.format("MMMM YYYY"));
            load_sales_admin();
         }
         next_date_admin = function() {
            var date = moment($("#date-admin").data("periode"));
            date.add(1, 'months');
            $("#date-admin").data("periode", date.format("YYYY-MM-DD"));
            $("#date-admin").html(date.format("MMMM YYYY"));
            load_sales_admin();
         }
         var ajax_sales_admin;
         load_sales_admin = function() {
            $("#wait_admin").show();
            $("#body_admin").addClass("d-none");
            var datestart = moment($("#date-admin").data("periode"), "YYYY-MM-DD").startOf('month');
            var dateend = moment($("#date-admin").data("periode"), "YYYY-MM-DD").endOf('month');
            var store = $('#tb_workplace').data("value");
            if (ajax_sales_admin && ajax_sales_admin.readyState != 4) {
               ajax_sales_admin.abort();
            }
            ajax_sales_admin =
               $.ajax({
                  method: "POST",
                  url: "<?= site_url("function/client_data_sales/get_card_admin/") ?>",
                  data: {
                     datestart: datestart.format("YYYY-MM-DD"),
                     dateend: dateend.format("YYYY-MM-DD"),
                     store: store,
                  },
                  success: function(data) {
                     $("#body_admin").html(data);
                     $("#wait_admin").hide();
                     $("#body_admin").show();
                     $("#body_admin").removeClass("d-none");
                  }
               });
         }

         load_sales_dashboard = function() {
            var aDashboard = $.ajax({
               method: "POST",
               dataType: "json",
               url: "<?= site_url("function/client_data_sales/get_total_card/") ?>" + $('#tb_workplace').data("value"),
               success: function(data) {

                  $("#card-total-payment").html(data["payment"]);
                  $("#card-total-trans").html(data["trans"]);

                  min_date_payment = moment(data["datepayment"]);

                  $(".card-total").each(function() {
                     var val = this.innerHTML;
                     animateValue(this, 0, val, 2000);
                  });
               }
            });

            function animateValue(obj, start, end, duration) {
               let startTimestamp = null;
               const step = (timestamp) => {
                  if (!startTimestamp) startTimestamp = timestamp;
                  const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                  obj.innerHTML = (Math.floor(progress * (end - start) + start)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                  if (progress < 1) {
                     window.requestAnimationFrame(step);
                  }
               };
               window.requestAnimationFrame(step);
            }
         }


         $("#btncheckpay0").change(function() {
            if ($(this).prop('checked')) {
               $("#btncheckpay0").prop('checked', true);
               $("#btncheckpay1").prop('checked', true);
               $("#btncheckpay2").prop('checked', true);
               $("#btncheckpay3").prop('checked', true);
               $("#btncheckpay4").prop('checked', true);
            } else {
               $("#btncheckpay0").prop('checked', false);
               $("#btncheckpay1").prop('checked', false);
               $("#btncheckpay2").prop('checked', false);
               $("#btncheckpay3").prop('checked', false);
               $("#btncheckpay4").prop('checked', false);
            }
         });
         $("#btncheckpay1,#btncheckpay2,#btncheckpay3,#btncheckpay4").change(function() {
            if ($("#btncheckpay1").prop('checked') && $("#btncheckpay2").prop('checked') && $("#btncheckpay3").prop('checked') && $("#btncheckpay4").prop('checked')) {
               $("#btncheckpay0").prop('checked', true);
            } else {
               $("#btncheckpay0").prop('checked', false);
            }
         })




         $("[data-bs-toggle='tooltip']").tooltip();
         /* ----------------                     ACTION SELECT            ------------------------ */
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
               load_sales_category();
               load_sales_dashboard();
               load_sales_admin();
            })
         }
         for (const option of document.querySelectorAll(".custom-option-multiple")) {
            option.addEventListener('click', function() {
               if (!$(this).hasClass("selected")) {
                  if ($(this).data("value") == "-") {
                     $(this).parent().find(".custom-option-multiple").addClass('selected');
                  } else {
                     $(this).addClass('selected');
                     var bool = false;
                     $(this).parent().find(".custom-option-multiple").each(function(index) {
                        if (!$(this).hasClass("selected") && $(this).data("value") != "-") bool = true;
                     });
                     if (bool == false) {
                        $(this).parent().find(".custom-option-multiple[data-value='-']").addClass('selected');
                     }
                  }
               } else {
                  if ($(this).data("value") != "-") {
                     $(this).removeClass('selected');
                     $(this).parent().find(".custom-option-multiple[data-value='-']").removeClass('selected');
                     if (!$(this).parent().find(".custom-option-multiple").hasClass("selected")) $(this).parent().find(".custom-option-multiple").addClass('selected');
                  }
               }

               var textcontent = "";
               var textdata = "";
               $(this).parent().find(".custom-option-multiple").each(function(index) {
                  if ($(this).data("value") == "-" && $(this).hasClass("selected")) {
                     $(this).parent().parent().find('.select-row').text("Semua Status");
                     $(this).parent().parent().find('.select-row').data("value", "-");
                     return false;
                  } else if ($(this).data("value") != "-" && $(this).hasClass("selected")) {
                     textcontent += this.textContent + ";";
                     textdata += $(this).data("value") + ";";
                     $(this).parent().parent().find('.select-row').text(textcontent);
                     $(this).parent().parent().find('.select-row').data(textdata);
                  }
               });

               $(this).parent().parent().find('.select-row').trigger('change');
            })
         }
         /* ----------------                     END SELECT               ------------------------ */

         load_sales_category();
         load_sales_dashboard();
         load_sales_admin();

         /* ----------------                     ACTION DATE              ------------------------ */
         // var StartDateContent = moment().subtract(2, 'month');
         // var EndDateContent = moment();

         var StartDateContent = moment().startOf("month");
         var EndDateContent = moment().endOf("month");

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

         $('#tb_date').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
         });
         /* ----------------                     END DATE                 ------------------------ */

         /* ----------------                     Load Datatable           ------------------------ */
         var status_pembayaran = function() {
            var arr = []; 
            if ($("#btncheckpay0").prop("checked")) {
               arr.push("0");
               arr.push("1");
               arr.push("2");
               arr.push("3");
            } else {
               if ($("#btncheckpay1").prop("checked")) {
                  arr.push("0");
               }
               if ($("#btncheckpay2").prop("checked")) {
                  arr.push("1");
               }
               if ($("#btncheckpay3").prop("checked")) {
                  arr.push("2");
               }
               if ($("#btncheckpay4").prop("checked")) {
                  arr.push("3");
               }
            }
            return arr;
         };
         showalert = function() {
            var datemin = moment().subtract(2, 'month');
            datemin = datemin.add(7, 'days');
            $.ajax({
               method: "POST",
               dataType: "json",
               data: {
                  "datemin": datemin.format("YYYY-MM-DD"),
               },
               url: "<?= site_url("function/client_data_sales/get_alert_sales/") ?>" + $('#tb_workplace').data("value"),
               success: function(data) {
                  $("#message-alert").html(data["html"]);
                  min_date_payment_remove = moment(data["datemin"]);
               }
            });
         }
         var table = $('#tb_data').DataTable({
            "responsive": true,
            "searching": false,
            "lengthChange": false,
            "pageLength": parseInt($('#tb_row').data("value")),
            "processing": false,
            "serverSide": true,
            "ajax": {
               "url": "<?php echo site_url('function/client_datatable_sales/get_data_sales') ?>",
               "type": "POST",
               "beforeSend": function(jqXHR, settings) {
                  if (table && table.hasOwnProperty('settings')) {
                     table.settings()[0].jqXHR.abort();
                  }
                  xhrPool.push(jqXHR);
                  $('#btn-search').html('<i class="fas fa-sync fa-spin"></i>');
                  $("#tb_data").hide();
                  $("#wait").show();
               },
               "data": function(data) {
                  data.search['store'] = $('#tb_workplace').data("value");
                  data.search['value'] = $('#tb_search').val();
                  data.search['status'] = status_pembayaran();
                  data.search['colstatus'] = "SalesStatusPayment";
                  data.search['tanggalstart'] = StartDateContent.format('YYYY-MM-DD');
                  data.search['tanggalend'] = EndDateContent.format('YYYY-MM-DD');
                  data.search['coltanggal'] = "SalesDate";
               },
               "complete": function(data) {
                  $("#wait").hide();
                  $("#tb_data").show(500);
                  $('#btn-search').html('<i class="fas fa-search"></i>');
                  document.getElementById("tb_data").scrollIntoView({
                     behavior: 'smooth'
                  });
                  $(".time-banned").each(function(e) {
                     var dateremove = moment($(this).data("date"), "YYYY-MM-DD").add(2, "month");
                     var duration = dateremove.diff(moment(), 'days');
                     $(this).text(duration + " hari akan batal otomatis");
                  });
                  showalert();
               }
            },
            "ordering": false,
            "columnDefs": [{
               "targets": [1],
               "visible": false,
            }, ],
            "createdRow": function(row, data, dataIndex) {
               $(row).addClass("tb-sales");
            },
            "language": {
               "emptyTable": '<img src="<?= base_url("asset/image/mgs-erp/iconnotfound.png") ?>" class="rounded mx-auto d-block" width="300px">',
               "zeroRecords": '<img src="<?= base_url("asset/image/mgs-erp/iconnotfound.png") ?>" class="rounded mx-auto d-block" width="300px">'
            },
         });
         table.ajax.reload(null, false).responsive.recalc().columns.adjust();

         get_list_payment = function() {

            $("#btncheckpay0").prop("checked", false);
            $("#btncheckpay1").prop("checked", false);
            $("#btncheckpay2").prop("checked", true);
            $("#btncheckpay3").prop("checked", false);
            $("#btncheckpay4").prop("checked", false);

            $("#btncheckdel0").prop("checked", false);
            $("#btncheckdel1").prop("checked", false);
            $("#btncheckdel2").prop("checked", false);
            $("#btncheckdel3").prop("checked", false);
            $("#btncheckdel4").prop("checked", false);
            $("#btncheckdel5").prop("checked", false);

            $("#btncheckitem0").prop("checked", false);
            $("#btncheckitem1").prop("checked", false);
            $("#btncheckitem2").prop("checked", false);
            $("#btncheckitem3").prop("checked", false);
            $("#btncheckitem4").prop("checked", false);
            StartDateContent = min_date_payment;
            EndDateContent = moment();
            Date_content(StartDateContent, EndDateContent);
         };
         get_list_payment_remove = function() {

            $("#btncheckpay0").prop("checked", false);
            $("#btncheckpay1").prop("checked", true);
            $("#btncheckpay2").prop("checked", false);
            $("#btncheckpay3").prop("checked", false);
            $("#btncheckpay4").prop("checked", false);

            $("#btncheckdel0").prop("checked", false);
            $("#btncheckdel1").prop("checked", false);
            $("#btncheckdel2").prop("checked", false);
            $("#btncheckdel3").prop("checked", false);
            $("#btncheckdel4").prop("checked", false);
            $("#btncheckdel5").prop("checked", false);

            $("#btncheckitem0").prop("checked", false);
            $("#btncheckitem1").prop("checked", false);
            $("#btncheckitem2").prop("checked", false);
            $("#btncheckitem3").prop("checked", false);
            $("#btncheckitem4").prop("checked", false);

            var datemin = moment().subtract(2, 'month');
            datemin = datemin.add(7, 'days');
            StartDateContent = min_date_payment_remove;
            EndDateContent = datemin;
            Date_content(StartDateContent, EndDateContent);
         };
         get_list_delivery = function() {

            $("#btncheckpay0").prop("checked", false);
            $("#btncheckpay1").prop("checked", false);
            $("#btncheckpay2").prop("checked", true);
            $("#btncheckpay3").prop("checked", true);
            $("#btncheckpay4").prop("checked", false);

            $("#btncheckdel0").prop("checked", false);
            $("#btncheckdel1").prop("checked", true);
            $("#btncheckdel2").prop("checked", false);
            $("#btncheckdel3").prop("checked", false);
            $("#btncheckdel4").prop("checked", false);
            $("#btncheckdel5").prop("checked", false);

            $("#btncheckitem0").prop("checked", false);
            $("#btncheckitem1").prop("checked", false);
            $("#btncheckitem2").prop("checked", false);
            $("#btncheckitem3").prop("checked", false);
            $("#btncheckitem4").prop("checked", false);
            StartDateContent = min_date_payment;
            Date_content(StartDateContent, EndDateContent);
         };
         get_list_po = function() {

            $("#btncheckpay0").prop("checked", false);
            $("#btncheckpay1").prop("checked", false);
            $("#btncheckpay2").prop("checked", true);
            $("#btncheckpay3").prop("checked", true);
            $("#btncheckpay4").prop("checked", false);

            $("#btncheckdel0").prop("checked", false);
            $("#btncheckdel1").prop("checked", false);
            $("#btncheckdel2").prop("checked", false);
            $("#btncheckdel3").prop("checked", false);
            $("#btncheckdel4").prop("checked", false);
            $("#btncheckdel5").prop("checked", false);

            $("#btncheckitem0").prop("checked", false);
            $("#btncheckitem1").prop("checked", true);
            $("#btncheckitem2").prop("checked", false);
            $("#btncheckitem3").prop("checked", false);
            $("#btncheckitem4").prop("checked", false);
            StartDateContent = min_date_payment;
            Date_content(StartDateContent, EndDateContent);
         };

         $('#btn-search').click(function() {
            table.ajax.reload(null, false).responsive.recalc().columns.adjust();
         })
         $('#tb_search').keyup(function(e) {
            if (e.keyCode === 13) {
               table.ajax.reload(null, false).responsive.recalc().columns.adjust();
            }
         });
         $('#tb_row').change(function() {
            table.page.len(parseInt($('#tb_row').data("value"))).draw();
         });
         $('#tb_status_pembayaran,#tb_status_pengiriman,#tb_status_barang').change(function() {
            table.ajax.reload(null, false).responsive.recalc().columns.adjust();
         });
         $('#tb_workplace').change(function() {
            load_sales_dashboard();
            table.ajax.reload(null, false).responsive.recalc().columns.adjust();
         });
         /* ----------------                     End Datatable           ------------------------ */
         var req_status = 0;
         load_data_table_sales = function() {
            table.ajax.reload(null, false).responsive.recalc().columns.adjust();
            modal_action.hide();
         };
         $("#btn-add-sales").click(function(e) {
            e.preventDefault();
            if (!req_status) {
               $.ajax({
                  url: "<?php echo site_url('message/message_sales/sales_add/') ?>",
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


         /*-------------------- BAGIAN SALES -------------------------*/

         sales_change_header = function(id, val) {
            if (!req_status) {
               $.ajax({
                  url: "<?php echo site_url('message/message_sales/sales_change_header/') ?>" + id + "/" + val,
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
         sales_edit_data = async function(id, data) {
            function call_edit() {
               if (!req_status) {
                  $.ajax({
                     url: "<?php echo site_url('message/message_sales/sales_edit/') ?>" + id,
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
            if ($(data).data("superuser") != 1) {
               if ($(data).data("request") == 0) {
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
                     html: 'Anda belum mendapapatkan izin untuk edit data.<br>masukan catatan untuk izin request edit data.',
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
                              url: "<?= site_url("function/client_data_sales/request_edit/") ?>" + id,
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
                     $(data).data("request", 1);
                  }
               }
               if ($(data).data("request") == 1) {
                  var url = 'https://web.whatsapp.com/send?text=' + encodeURI("<?= base_url("?menu=redirect&search=ALY/XIII/01/SL-0024/24/I/2022") ?>");
                  Swal.fire({
                     icon: 'info',
                     title: 'Request sudah dikirim',
                     text: 'Menunggu approval dari Superuser',
                  })
                  return;
               };
               call_edit();
            } else {
               call_edit();
            }

         }
         sales_delete_data = async function(id, data) {
            console.log(data);

            function call_remove() {
               if (!req_status) {
                  $.ajax({
                     url: "<?php echo site_url('function/client_data_sales/get_sales_code/') ?>" + id,
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
                                 url: "<?= site_url("function/client_data_sales/data_sales_disabled/") ?>" + id,
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

            if ($(data).data("superuser") != 1) {
               if ($(data).data("request") == 0) {
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
                     html: 'Anda perlu request untuk membatalkan transaksi ini.<br>masukan catatan untuk request pembatalan data sales ini.',
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
                              url: "<?= site_url("function/client_data_sales/request_remove/") ?>" + id,
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
                     $(data).data("request", 1);
                  }
               }
               if ($(data).data("request") == 1) {
                  Swal.fire({
                     icon: 'info',
                     title: 'Request sudah dikirim',
                     text: 'Menunggu approval dari Superuser',
                  });
                  return;
               };
               call_remove();
            } else {
               call_remove();
            }
         }
         sales_print_data = function(id) {
            window.open('<?php echo site_url('export/datasales/sales/') ?>' + id, '_blank');
         }

         /*-------------------- BAGIAN PAYMENT -------------------------*/
         payment_add = function(id,ref) {
            if (!req_status) {
               $.ajax({
                  url: "<?= site_url('message/message_sales/sales_payment_add/') ?>" + id + "/" + ref,
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
                           $("#modal-content").html('<embed type="application/pdf" src="<?= base_url("asset/image/payment/") ?>' + id + "/" + filename + '" width="100%" height="100%"></embed>');
                           //$("#modal-content").html("<iframe src='" + urlfile + "' width='100%' height='100%'></iframe>");
                           $("#modal-view").modal("show");
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
         payment_edit = function(id) {
            if (!req_status) {
               $.ajax({
                  url: "<?php echo site_url('message/message_sales/sales_payment_edit/') ?>" + id,
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
         payment_cancel = function(id) {
            const swalWithBootstrapButtons = Swal.mixin({
               customClass: {
                  confirmButton: 'btn btn-success mx-1',
                  cancelButton: 'btn btn-secondary mx-1'
               },
               buttonsStyling: false
            });
            swalWithBootstrapButtons.fire({
               title: "Batalkan Pembayaran!",
               html: 'Anda yakin ingin menghapus pembayaran ini?',
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
                     url: "<?= site_url("function/client_data_sales/data_payment_disabled/") ?>" + id,
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
               } else if (result.dismiss === Swal.DismissReason.cancel) {
                  return false;
               }
            });
         }
         payment_print = function(id) {
            window.open('<?php echo site_url('export/datasales/payment/') ?>' + id, '_blank');
         }

         /*-------------------- BAGIAN PERFORMA -------------------------*/
         performa_add = function(id,ref) {
            if (!req_status) {
               $.ajax({
                  type: "POST",
                  url: "<?= site_url('message/message_sales/sales_performa_add/') ?>" + id + "/" + ref,
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
         performa_edit = function(performa_id) {
            if (!req_status) {
               $.ajax({
                  type: "POST",
                  url: "<?= site_url('message/message_sales/sales_performa_edit/') ?>" + performa_id,
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
         performa_cancel = function(performa_id) {
            const swalWithBootstrapButtons = Swal.mixin({
               customClass: {
                  confirmButton: 'btn btn-success mx-1',
                  cancelButton: 'btn btn-secondary mx-1'
               },
               buttonsStyling: false
            });
            swalWithBootstrapButtons.fire({
               title: "Batalkan Performa",
               html: 'Anda yakin ingin membatalkan Performa ini?',
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
                     url: "<?= site_url("function/client_data_sales/data_sale_performa_remove/") ?>" + performa_id,
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

         }
         performa_success = function(performa_id) {
            const swalWithBootstrapButtons = Swal.mixin({
               customClass: {
                  confirmButton: 'btn btn-success mx-1',
                  cancelButton: 'btn btn-secondary mx-1'
               },
               buttonsStyling: false
            });
            swalWithBootstrapButtons.fire({
               title: "Selesaikan Performa",
               html: 'Anda yakin ingin menyelesaikan Performa ini?',
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
                     url: "<?= site_url("function/client_data_sales/data_sale_performa_success/") ?>" + performa_id,
                     before: function() {
                        req_status_add = 1;
                     },
                     success: function(data) {
                        req_status_add = 0;

                        if (data) {
                           swalWithBootstrapButtons.fire({
                              title: "Performa Berhasil diselesaikan",
                              html: 'Anda ingin meneruskan ke pembayaran?',
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
                                    url: "<?php echo site_url('message/message_sales/sales_performa_success/') ?>" + performa_id,
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
                              } else {

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

               };

            });
         }
         performa_print = function(performa_id) {
            window.open('<?php echo site_url('export/datasales/performa/') ?>' + performa_id, '_blank');
         }

         /*-------------------- BAGIAN DELIVERY -------------------------*/
         delivery_add = function(id, tipe = null, po_id = null) {
            if (!req_status) {
               $.ajax({
                  type: "POST",
                  url: "<?= site_url('message/message_sales/sales_delivery_add/') ?>" + id,
                  data: {
                     "id": po_id,
                     "tipe": tipe
                  },
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
         delivery_edit = function(del_id) {
            if (!req_status) {
               $.ajax({
                  type: "POST",
                  url: "<?= site_url('message/message_sales/sales_delivery_edit/') ?>" + del_id,
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
         var ajax_req_message;
         delivery_proses = function(id) {
            if (ajax_req_message && ajax_req_message.readyState != 4) {
               ajax_req_message.abort();
            }
            ajax_req_message = $.ajax({
               url: "<?php echo site_url('message/message_sales/sales_delivery_proses/') ?>" + id,
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
         delivery_proses_view = function(id) { 
            $.ajax({
               type: "POST",
               url: "<?php echo site_url('message/message_sales/show_image') ?>",
               data: {
                  "src": "<?= base_url('asset/image/pengiriman/') ?>" + id + "/bukti_pengiriman.png"
               },
               success: function(response) {
                  $("#modal-view-show").html(response);
                  $("#modal-filename").text("bukti_pengiriman.png");
                  $("#modal-view").modal("show");
               },
               error: function(xhr, status, error) {
                  console.log(xhr.responseText);
               }
            });
            
         }
         delivery_selesai = function(id) {
            if (ajax_req_message && ajax_req_message.readyState != 4) {
               ajax_req_message.abort();
            }
            ajax_req_message = $.ajax({
               url: "<?php echo site_url('message/message_sales/sales_delivery_selesai/') ?>" + id,
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
         delivery_selesai_view = function(id) { 
            $.ajax({
               type: "POST",
               url: "<?php echo site_url('message/message_sales/show_image') ?>",
               data: {
                  "src": "<?= base_url('asset/image/pengiriman/') ?>" + id + "/bukti_penerima.png"
               },
               success: function(response) {
                  $("#modal-view-show").html(response);
                  $("#modal-filename").text("bukti_penerima.png");
                  $("#modal-view").modal("show");
               },
               error: function(xhr, status, error) {
                  console.log(xhr.responseText);
               }
            });
            
         }
         delivery_transfer = function(id, type) {
            if (ajax_req_message && ajax_req_message.readyState != 4) {
               ajax_req_message.abort();
            }
            ajax_req_message = $.ajax({
               url: "<?php echo site_url('message/message_sales/sales_delivery_transfer/') ?>" + id + "/" + type,
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
         /*-------------------- BAGIAN PO -------------------------*/
         po_add = function(id) {
            if (!req_status) {
               $.ajax({
                  type: "POST",
                  url: "<?= site_url('message/message_sales/sales_po_add/') ?>" + id,
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
         po_print_a5 = function(po_id) {
            window.open('<?php echo site_url('export/datasales/po/a5/') ?>' + po_id, '_blank');
         }
         po_print_a6 = function(po_id) {
            window.open('<?php echo site_url('export/datasales/po/a6/') ?>' + po_id, '_blank');
         }
         po_delete = function(po_id) {
            if (!req_status) {
               $.ajax({
                  url: "<?php echo site_url('function/client_data_sales/get_po_code/') ?>" + po_id,
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
                        title: "Batalkan PO",
                        html: 'Anda yakin ingin membatalkan PO <b>' + response + '</b> ?',
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
                              url: "<?= site_url("function/client_data_sales/data_po_remove/") ?>" + po_id,
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
         po_edit = function(po_id) {
            if (!req_status) {
               $.ajax({
                  type: "POST",
                  url: "<?= site_url('message/message_sales/sales_po_edit/') ?>" + po_id,
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
                  url: "<?= site_url('message/message_sales/sales_grpo_add/') ?>" + po_id,
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
         grpo_edit = function(id) {
            if (!req_status) {
               $.ajax({
                  type: "POST",
                  url: "<?= site_url('message/message_sales/sales_grpo_edit/') ?>" + id,
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
         grpo_print_a5 = function(id) {
            window.open('<?php echo site_url('export/pembelian/grpo/a5/') ?>' + id, '_blank');
         }
         grpo_print_a6 = function(id) {
            window.open('<?php echo site_url('export/pembelian/grpo/a6/') ?>' + id, '_blank');
         }

         /*-------------------- BAGIAN TRANSFER -------------------------*/
         transfer_add = function(id) {
            if (!req_status) {
               $.ajax({
                  url: "<?= site_url('message/message_sales/sales_transfer_out/') ?>" + id,
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
         transfer_out_edit = function(id) {
            if (!req_status) {
               $.ajax({
                  url: "<?= site_url('message/message_sales/sales_transfer_out_edit/') ?>" + id,
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
         transfer_out_delete = function(id) {
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
                  html: 'Anda yakin ingin menghapus data Kirim Barang ini ?',
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
                        url: "<?= site_url("function/client_data_sales/data_to_remove/") ?>" + id,
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
         transfer_out_print = function(id) {
            window.open('<?php echo site_url('export/datasales/to/') ?>' + id, '_blank');
         }
         transfer_out_selesai = function(id) {
            if (!req_status) {
               $.ajax({
                  url: "<?= site_url('message/message_sales/sales_transfer_in/') ?>" + id,
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

         transfer_in_edit = function(id) {
            if (!req_status) {
               $.ajax({
                  url: "<?= site_url('message/message_sales/sales_transfer_in_edit/') ?>" + id,
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
         transfer_in_delete = function(id) {
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
                  html: 'Anda yakin ingin menghapus data Terima Barang ini ?',
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
                        url: "<?= site_url("function/client_data_sales/data_ti_remove/") ?>" + id,
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
         transfer_in_print = function(id) {
            window.open('<?php echo site_url('export/datasales/ti/') ?>' + id, '_blank');
         }

         


         log_sales = function(sales_id) {
            var myOffcanvas = document.getElementById('offcanvas-logsales');
            var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);
            bsOffcanvas.show();
            $("#wait-timeline").show();
            $("#timeline").hide();
            if (!req_status) {
               $.ajax({
                  url: "<?= site_url('function/client_data_sales/get_sales_log/') ?>" + sales_id,
                  beforeSend: function() {
                     req_status = 1;
                  },
                  success: function(response) {
                     $("#timeline").html(response);
                     $("#wait-timeline").hide();
                     $("#timeline").show();
                     req_status = 0;
                     var span = $("#offcanvas-logsales").find(".offcanvas-body");
                     span.html(span.html().replace(/Sales/g, '<span style="color: blue">$&</span>'));
                     span.html(span.html().replace(/Pembayaran/g, '<span style="color: green">$&</span>'));
                     span.html(span.html().replace(/PO/g, '<span style="color: #ffc107!important">$&</span>'));
                     span.html(span.html().replace(/Pengiriman/g, '<span style="color: #0dcaf0!important">$&</span>'));
                     span.html(span.html().replace(/Performa Invoice/g, '<span style="color: blue">$&</span>'));
                  },
                  error: function(xhr, status, error) {
                     console.log(xhr.responseText);
                     req_status = 0;
                  }
               });
            }
         }

         log_approve = function(sales_id) {
            var myOffcanvas = document.getElementById('offcanvas-approve');
            var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);
            bsOffcanvas.show();
            $("#wait-timeline-approve").show();
            $("#timeline-approve").hide();
            if (!req_status) {
               $.ajax({
                  url: "<?= site_url('function/client_data_sales/get_sales_request/') ?>" + sales_id,
                  beforeSend: function() {
                     req_status = 1;
                  },
                  success: function(response) {
                     $("#timeline-approve").html(response);
                     $("#wait-timeline-approve").hide();
                     $("#timeline-approve").show();
                     req_status = 0;
                     var span = $("#offcanvas-approve").find(".offcanvas-body");
                     span.html(span.html().replace(/Request/g, '<span style="color: blue">$&</span>'));
                     span.html(span.html().replace(/diapprove/g, '<span style="color: green">$&</span>'));
                     span.html(span.html().replace(/menunggu/g, '<span style="color: #ffc107!important">$&</span>'));
                  },
                  error: function(xhr, status, error) {
                     console.log(xhr.responseText);
                     req_status = 0;
                  }
               });
            }
         }

         log_edit = function(id) {
            if (!req_status) {
               $.ajax({
                  url: "<?php echo site_url('message/message_sales/sales_history/') ?>" + id,
                  beforeSend: function() {
                     req_status = 1;
                  },
                  success: function(response) {
                     req_status = 0;
                     if (response == "false") {
                        Swal.fire({
                           icon: 'info',
                           text: 'TIdak Ada Data',
                           html: 'belum ada history perubahan data sales',
                           showConfirmButton: false,
                           allowOutsideClick: false,
                           allowEscapeKey: false,
                           timer: 1500
                        });
                     } else {
                        $("#dialog-box").html(response);
                        modal_action = new bootstrap.Modal(document.getElementById('modal-action'));
                        modal_action.show();
                     }
                  },
                  error: function(xhr, status, error) {
                     console.log(xhr.responseText);
                     req_status = 0;
                  }
               });
            }
         }

         $("#export-sales").click(function() {
            window.open('<?php echo site_url('function/client_export_sales/sales_item?') ?>' + "datestart=" + StartDateContent.format('YYYY-MM-DD') + "&dateend=" + EndDateContent.format('YYYY-MM-DD') + "&store=" + $('#tb_workplace').data("value"), "_blank");
         });

      });
   </script>
</body>

</html>

</html>