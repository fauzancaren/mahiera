<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <style>
      @font-face {
         font-family: Roboto-bold;
         src: url("./asset/fontgoogle/Roboto/Roboto-Medium.ttf");
      }

      @font-face {
         font-family: Roboto;
         src: url("./asset/fontgoogle/Roboto/Roboto-Regular.ttf");
      }

      @font-face {
         font-family: NunitoSans;
         src: url("./asset/fontgoogle/NunitoSans-Bold.ttf");
      }

      body {
         font-family: 'Roboto';
      }

      .card-progress {
         min-height: 500px
      }


      .side-content-job {
         width: 500px;
         border-right: 1px solid #dedede;
         position: relative;
         transition: all 0.5s;
      }

      .side-content-job.hide {
         width: 20px;
         transition: width 0.5s;
      }

      .side-content-body {
         width: 490px;
         position: relative;
         transition: all 1s;
      }

      .side-content-job.hide .side-content-body {
         left: -300px;
         transition: all 1s;
         position: relative;
      }

      .side-content-job>.navigation {
         height: 25px;
         width: 25px;
         position: absolute;
         right: -12px;
         top: 10px;
         background: white;
         border-radius: 12px;
         border: 1px solid #dedede;
         z-index: 10;
      }

      .side-content-job>.navigation:hover {
         cursor: pointer;
         background: #ff6600;
         transition: all 0.2s;
         width: 40px;
         border: 1px solid #ff6600;
         color: white;
      }

      .side-content-job.hide>.navigation:hover {
         transition: all 0.2s;
         width: 25px;
      }

      .side-content-job.hide div.menu-divisi {
         display: none !important;
      }

      .side-content-job>.navigation:before {
         font-family: "Font Awesome 5 Free";
         content: "\f104";
         font-weight: 600;
         font-size: 1rem;
         padding-left: 0.4rem;
         transition: all .3s;
      }

      .side-content-job.hide>.navigation:before {
         display: inline-block;
         transform: rotate(180deg);
         padding-right: 0.5rem;
      }

      .side-content-job .side-header {
         font-family: Roboto-bold;
         padding: 0.5rem 1rem;
         font-size: 0.85rem;
         border-bottom: 1px solid #dedede;
      }

      .side-content-job ul {
         display: block;
         padding: 0.25rem;
         height: 320px;
         overflow: auto
      }

      .side-content-job.hide ul {
         display: none;
      }

      .side-content-job li {
         font-family: Roboto-bold;
         font-weight: 400;
         position: relative;
         display: block;
         padding: 0.5rem;
         padding-left: 2rem;
         color: #646464;
         letter-spacing: 0.5px;
      }

      .side-content-job li.hide {
         display: none;
      }

      .side-content-job li.active {
         background: #ffcead !important;
         color: #4f4f4f;
         border-radius: 10px;
         border-bottom-left-radius: 0;
         border-top-left-radius: 0;
      }

      .side-content-job li::before {
         font-family: "Font Awesome 5 Free";
         content: "\f0c9";
         font-weight: 600;
         position: absolute;
         left: 10px;
      }

      .menu-divisi a {
         color: #6d6e6e
      }

      .side-content-job .menu-divisi li:hover {
         background: #ececec;
         border-radius: 10px;
         border-bottom-left-radius: 0;
         border-top-left-radius: 0;
         cursor: pointer;
         transition: all 0.2s;
      }

      .side-job {
         min-height: 500px;
         padding: 1rem 2rem;
         overflow: auto
      }

      .side-job .header {

         font-family: NunitoSans;
         font-weight: 400;
         font-size: 2rem;
         padding: 0.5rem;
         border-radius: 0.25rem;
      }

      .side-job .header:hover {
         background: #e6e9ef;
      }

      .side-job .detail {

         font-family: NunitoSans;
         font-weight: 400;
         font-size: 1rem;
         padding: 0.5rem;
         border-radius: 0.25rem;
      }

      .side-job .detail:hover {
         background: #e6e9ef;
      }

      .side-job .header-end {
         float: right !important;
         font-family: Roboto;
         font-weight: bold;
         font-size: 0.8rem;
      }

      .header-end>button:hover {
         background: #ffcead !important;
      }

      .accordion {
         margin: 0.5rem 0;
      }

      .side-content-job.hide .side-header {
         display: none;
      }

      .side-content-job.hide .accordion {
         display: none;
      }

      .accordion-item {
         border: none
      }

      .accordion-item>a {
         font-family: Roboto-bold;
         font-weight: 400;
         position: relative;
         padding: 0.5rem;
         padding-left: 1rem;
         color: #646464;
         letter-spacing: 0.5px;
         cursor: pointer;
         margin: 0.5rem 0 0;
      }

      .accordion-item>a:hover {
         background: #ececec;
         border-radius: 10px;
         border-bottom-left-radius: 0;
         border-top-left-radius: 0;
         cursor: pointer;
         transition: all 0.2s;
      }

      .accordion a.active {
         background: #ffcead !important;
         color: #4f4f4f;
         border-radius: 10px;
         border-bottom-left-radius: 0;
         border-top-left-radius: 0;
      }

      .accordion-item>a::before {
         font-family: "Font Awesome 5 Free";
         content: "\f0c9";
         font-weight: 600;
         position: absolute;
         left: 10px;
      }

      .accordion-item-sub>a {
         font-family: Roboto-bold;
         font-weight: 400;
         position: relative;
         padding: 0.5rem;
         padding-left: 2rem;
         color: #646464;
         letter-spacing: 0.5px;
         cursor: pointer;
         margin: 0;
      }

      .accordion-item-sub>a:hover {
         background: #ececec;
         border-radius: 10px;
         border-bottom-left-radius: 0;
         border-top-left-radius: 0;
         cursor: pointer;
         transition: all 0.2s;
      }

      .accordion-item-sub>a::before {
         font-family: "Font Awesome 5 Free";
         content: "\f068";
         font-weight: 900;
         position: absolute;
         left: 1.2rem;
      }

      .side-job .side-search {
         font-family: Roboto;
         padding: 0.5rem;
         font-size: 0.85rem;
         position: relative;
         display: flex;
         align-items: center;
         color: gray;
         border-bottom: 1px solid #dedede;
         letter-spacing: 2px;
      }

      .side-job .side-search>input {
         border: 1px solid white;
         padding: 0.2rem 1.6rem;
         color: inherit;
         font-size: 0.85rem;
      }

      .side-job .side-search>input:hover {
         background: #ffb473;
         border: 1px solid #ffb473 !important;
         box-shadow: none !important;
         transition: all 0.3s;
      }

      .side-job .side-search>input:focus {
         background: white;
         border: 1px solid #ff6600 !important;
         box-shadow: none !important;
         transition: all 0.3s;
      }

      .side-job .side-search::before {
         font-family: "Font Awesome 5 Free";
         content: "\f002";
         font-weight: 600;
         position: absolute;
         left: 1rem;
      }
   </style>
</head>

<body>
   <section class="content-header">
      <div class="row mb-2">
         <div class="col-md-auto col-12">
            <h2>Data Kas Kecil (Petty Cash)</h2>
         </div>
         <div class="col align-self-end">
            <ol class="breadcrumb float-md-end">
               <li class="breadcrumb-item">Finance</li>
               <li class="breadcrumb-item active" onclick="menuselect('finance-pettycash','menu-finance')" style="cursor:pointer">Petty Cash</li>
            </ol>
         </div>
      </div>
   </section>

   <div class="row page-content">
      <div class="col-12">
         <div class="card border-top-orange card-progress">
            <div class="card-header">
               <div class="row align-items-center">
                  <div class="col">
                     <span class="fw-bold"><i class="fas fa-money-bill-alt" aria-hidden="true"></i>&nbsp;Finance - Data Kas Kecil</span>
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
               <div class="row border-bottom pb-2">
                  <div class="col-lg-6 col-12">
                     <div class="row mb-1">
                        <label for="tb_store" class="col-sm-3 col-form-label">Toko</label>
                        <div class="col-sm-9">
                           <select class="custom-select custom-select-sm form-control form-control-sm" id="tb_store" name="tb_store" <?= ($this->session->userdata("login_mode") == "Superuser" || $this->session->userdata("login_mode") == "Finance" ? "" : "disabled") ?>>
                              <option value="">Semua Toko</option>
                              <?php
                              $this->db->where("MsWorkplaceIsActive", "1");
                              $query = $this->db->get('TblMsWorkplace')->result();
                              foreach ($query as $key) {
                                 echo '<option value="' . $key->MsWorkplaceId . '" ' . ($this->session->userdata("MsWorkplaceId") == $key->MsWorkplaceId ? "selected" : "") . '>' . $key->MsWorkplaceCode . '</option>';
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
                  </div>
               </div>
               <div class="d-block d-flex flex-row justify-content-between">
                  <div class="side-content-job col-auto">
                     <div class="navigation" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Sembunyikan Navigasi"></div>
                     <div class="side-content-body" id="side-content">
                        <div class="row align-items-center side-header me-2">
                           <div class="col">
                              <span class="fw-bold">Kategori</span>
                           </div>
                           <div class="col-auto px-1 text-end" style="width:7rem">
                              <span class="fw-bold"><i class="fas fa-arrow-down text-success"></i></i>&nbsp;Diterima</span>
                           </div>
                           <div class="col-auto px-0 text-end" style="width:7rem">
                              <span class="fw-bold"><i class="fas fa-arrow-up text-danger"></i>&nbsp;Dikeluarkan</span>
                           </div>
                        </div>
                        <div class="accordion accordion-flush" id="menu-side">
                           <div class="accordion-item">
                              <a class="row align-items-center text-decoration-none me-2 collapsed" data-bs-toggle="collapse" data-bs-target="#non-reguler" aria-expanded="false" aria-controls="non-reguler">
                                 <div class="col">
                                    <span>Non Reguler</span>
                                 </div>
                                 <div class="col-auto px-1 text-end" style="width:6rem">
                                    <span class="fw-bold">0</span>
                                 </div>
                                 <div class="col-auto px-0 text-end" style="width:6rem">
                                    <span class="fw-bold">0</span>
                                 </div>
                              </a>
                              <div id="non-reguler" class="accordion-item-sub accordion-collapse collapse" aria-labelledby="non-reguler" data-bs-parent="#menu-side">
                                 <a class="row align-items-center text-decoration-none me-2">
                                    <div class="col">
                                       <span>Divisi Molding</span>
                                    </div>
                                    <div class="col-auto px-1 text-end" style="width:6rem">
                                       <span class="fw-bold">0</span>
                                    </div>
                                    <div class="col-auto px-0 text-end" style="width:6rem">
                                       <span class="fw-bold">0</span>
                                    </div>
                                 </a>
                                 <a class="row align-items-center text-decoration-none me-2">
                                    <div class="col">
                                       <span>Divisi Logisitik</span>
                                    </div>
                                    <div class="col-auto px-1 text-end" style="width:6rem">
                                       <span class="fw-bold">0</span>
                                    </div>
                                    <div class="col-auto px-0 text-end" style="width:6rem">
                                       <span class="fw-bold">0</span>
                                    </div>
                                 </a>
                                 <a class="row align-items-center text-decoration-none me-2">
                                    <div class="col">
                                       <span>Divisi Civil</span>
                                    </div>
                                    <div class="col-auto px-1 text-end" style="width:6rem">
                                       <span class="fw-bold">0</span>
                                    </div>
                                    <div class="col-auto px-0 text-end" style="width:6rem">
                                       <span class="fw-bold">0</span>
                                    </div>
                                 </a>
                                 <a class="row align-items-center text-decoration-none me-2">
                                    <div class="col">
                                       <span>Dana Keluar</span>
                                    </div>
                                    <div class="col-auto px-1 text-end" style="width:6rem">
                                       <span class="fw-bold">0</span>
                                    </div>
                                    <div class="col-auto px-0 text-end" style="width:6rem">
                                       <span class="fw-bold">0</span>
                                    </div>
                                 </a>
                                 <a class="row align-items-center text-decoration-none me-2">
                                    <div class="col">
                                       <span>Dana Masuk</span>
                                    </div>
                                    <div class="col-auto px-1 text-end" style="width:6rem">
                                       <span class="fw-bold">0</span>
                                    </div>
                                    <div class="col-auto px-0 text-end" style="width:6rem">
                                       <span class="fw-bold">0</span>
                                    </div>
                                 </a>
                              </div>
                           </div>
                        </div>
                        <div class="my-2 menu-divisi row align-items-center border-top me-2 pe-2 ps-1">
                           <div class="col">
                              <span class="fw-bold">Total</span>
                           </div>
                           <div class="col-auto px-1 text-end" style="width:7rem">
                              <span class="fw-bold" id="total-masuk">0</span>
                           </div>
                           <div class="col-auto px-0 text-end" style="width:7rem">
                              <span class="fw-bold" id="total-keluar">0</span>
                           </div>
                        </div>
                        <div class="my-2 menu-divisi row align-items-center me-2 pe-2 ps-1">
                           <div class="col">
                              <span class="fw-bold">SALDO AWAL DARI <a id="label-date"></a></span>
                           </div>
                           <div class="col-auto px-0 text-end" style="width:7rem">
                              <span class="fw-bold" id="total-saldo">0</span>
                           </div>
                        </div>
                        <div class="my-2 menu-divisi row align-items-center me-2 pe-2 ps-1">
                           <div class="col">
                              <span class="fw-bold">PERUBAHAN SALDO KAS</span>
                           </div>
                           <div class="col-auto px-0 text-end" style="width:7rem">
                              <span class="fw-bold" id="total-perubahan">0</span>
                           </div>
                        </div>
                        <div class="my-2 menu-divisi row align-items-center me-2 pe-2 ps-1">
                           <div class="col">
                              <span class="fw-bold">SALDO AKHIR <a id="label-date-end"></a></span>
                           </div>
                           <div class="col-auto px-0 text-end" style="width:7rem">
                              <span class="fw-bold" id="total-sisa">0</span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="side-job flex-fill">
                     <div class="side-search">
                        <input type="text" class="form-control bg-light" id="search-file" placeholder="Pencarian">
                     </div>
                     <div id="data-content">
                        <div class="d-block">
                           <span class="detail">Data toko : Semua Toko</span>
                           <span class="header-end">Periode 29/08/2021 - 04/09/2021</span>
                        </div>
                        <div class="d-block">
                           <span class="header">Non Reguler</span>
                        </div>
                        <div class="d-block detail ms-2 bg-light">Divisi Molding</div>
                        <table class="table ms-2">
                           <thead>
                              <tr>
                                 <th scope="col">#</th>
                                 <th scope="col">Keterangan</th>
                                 <th scope="col">Tanggal</th>
                                 <th scope="col">Total</th>
                                 <th scope="col"><i class="fas fa-cog"></i></th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <th scope="row">1</th>
                                 <td>Mark</td>
                                 <td>Otto</td>
                                 <td>@mdo</td>
                                 <td>@mdo</td>
                              </tr>
                              <tr>
                                 <th scope="row">2</th>
                                 <td>Jacob</td>
                                 <td>Thornton</td>
                                 <td>@fat</td>
                                 <td>@mdo</td>
                              </tr>
                              <tr>
                                 <th scope="row">3</th>
                                 <td colspan="2">Larry the Bird</td>
                                 <td>@twitter</td>
                                 <td>@mdo</td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div id="dialog-box">
   </div>
   <div id="modal-pdf" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog full_modal-dialog">
         <div class="modal-content full_modal-content">
            <div class="modal-header">
               <h5 class="modal-title text-truncate">Modal title</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body p-0">
               <embed src="" frameborder="0" width="100%" height="400px">
            </div>
         </div>
      </div>
   </div>

   <script>
      var req;
      var id_active = "";
      $(".navigation").click(function() {
         if ($(".side-content-job").hasClass("hide")) {
            $(".side-content-job").removeClass("hide");
            $(".navigation").attr('data-bs-original-title', "Sembunyikan Navigasi");
         } else {
            $(".side-content-job").addClass("hide");
            $(".navigation").attr('data-bs-original-title', "Tampilkan Navigasi");
         }
      });

      /* ----------------                     ACTION DATE              ------------------------ */
      var StartDateContent = moment();
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
         if (page_load != 0) {
            get_data_side();
         } else {
            page_load = 1;
         }
      }
      $("#tb_store").change(function() {
         get_data_side();
      })

      set_fixed_header();

      get_data_side = function() {
         if (req && req.readyState != 4) {
            req.abort();
         }
         req = $.ajax({
            method: "POST",
            dataType: "json",
            data: {
               "store": $("#tb_store").val(),
               "datestart": StartDateContent.format('YYYY-MM-DD'),
               "dateend": EndDateContent.format('YYYY-MM-DD'),
            },
            url: "<?= site_url('function/Client_data_financial/data_petty_cash_kategory/') ?>",
            success: function(response) {
               $('#menu-side').html(response["list"]);
               $('#total-masuk').html(response["totalin"]);
               $('#total-keluar').html(response["totalout"]);
               $('#total-saldo').html(response["saldoawal"]);
               $('#total-perubahan').html(response["perubahan"]);
               $('#total-sisa').html(response["sisa"]);
               $('#label-date').html(StartDateContent.format('DD/MM/YYYY'));
               $('#label-date-end').html(EndDateContent.format('DD/MM/YYYY'));

               $('.accordion a').unbind().click(function() {
                  $('.accordion a.active').removeClass("active");
                  $(this).addClass("active");
                  get_data_content($(this).data("id"));
                  id_active = $(this).data("id");
               });
               id_active = 1;
               get_data_content(1);
            }
         });
      }
      get_data_side();

      get_data_content = function(id) {
         if (req && req.readyState != 4) {
            req.abort();
         }
         req = $.ajax({
            method: "POST",
            dataType: "json",
            data: {
               "store": $("#tb_store").val(),
               "datestart": StartDateContent.format('YYYY-MM-DD'),
               "dateend": EndDateContent.format('YYYY-MM-DD'),
               "id": id,
               "search": $("#search-file").val(),
            },
            url: "<?= site_url('function/Client_data_financial/data_petty_cash_table/') ?>",
            success: function(response) {
               $("#data-content").html(response["header"] + response["datacategory"]);
            }
         });
      }
      $("#search-file").keyup(function() {
         get_data_content(id_active);
      })

      $("#btn-add").click(function() {
         if (req && req.readyState != 4) {
            req.abort();
         }
         req = $.ajax({
            url: "<?php echo site_url('message/message_financial/petty_cash_add/') ?>",
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
      });
      view_click = function(id) {
         if (req && req.readyState != 4) {
            req.abort();
         }
         req = $.ajax({
            url: "<?php echo site_url('message/message_financial/petty_cash_view/') ?>" + id,
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
      edit_click = function(id) {
         if (req && req.readyState != 4) {
            req.abort();
         }
         req = $.ajax({
            url: "<?php echo site_url('message/message_financial/petty_cash_edit/') ?>" + id,
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
      delete_click = function(id) {
         const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
               confirmButton: 'btn btn-success mx-1',
               cancelButton: 'btn btn-secondary mx-1'
            },
            buttonsStyling: false
         });
         swalWithBootstrapButtons.fire({
            title: "Batalkan Pettycash!",
            html: 'Anda yakin ingin menghapus data ini?',
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
                  url: "<?= site_url("function/client_data_financial/data_petty_cash_delete/") ?>" + id,
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
                              get_data_side();
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
                        get_data_side();
                     }
                  }
               });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
               return false;
            }
         });
      }

      $("#btn-export").click(function() {
         window.open('<?php echo site_url('function/client_export_financial/pettycash?') ?>' + "datestart=" + StartDateContent.format('YYYY-MM-DD') + "&dateend=" + EndDateContent.format('YYYY-MM-DD') + "&store=" + $('#tb_store').val(), "_blank");
      })
   </script>

</body>

</html>