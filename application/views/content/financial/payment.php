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
            <h2 onclick="menuselect('finance-salespayment','menu-finance')">List Piutang Penjualan</h2>
         </div>
         <div class="col align-self-end">
            <ol class="breadcrumb float-md-end">
               <li class="breadcrumb-item">Finance</li>
               <li class="breadcrumb-item active" onclick="menuselect('finance-salespayment','menu-finance')" style="cursor:pointer">Piutang Penjualan</li>
            </ol>
         </div>
      </div>
   </section>
   <div class="row row-cols-3 g-3 mb-2 "> 
      <div class="col-12 col-md-4 ">
         <div class="card shadow text-bg-orange border-top-orange">
            <div class="card-header">
               <div class="fw-bold"><i class="fas fa-list-alt"></i> Semua transaksi piutang</div>
            </div>
            <div class="card-body bg-white">
               <div class="d-flex flex-column fw-bold">
                  <div class="px-2 d-flex">
                     <span class="flex-grow-1">Jumlah Transaksi</span>
                     <span class="fs-4 card-total" id="card-total-trans">0</span>
                  </div>
                  <div class="px-2 d-flex">
                     <span class="flex-grow-1">Total Pelunasan</span>
                     <span class="fs-4 card-total" id="card-total-payment">0</span>
                  </div> 
               </div> 
            </div>
         </div> 
      </div> 
      <div class="col-12 col-md-4">
         <div class="card shadow text-bg-orange border-top-orange">
            <div class="card-header">
               <div class="fw-bold"><i class="fas fa-list-alt"></i> Transaksi piutang Wajib (sudah selesai)</div>
            </div>
            <div class="card-body bg-white">
               <div class="d-flex flex-column fw-bold">
                  <div class="px-2 d-flex">
                     <span class="flex-grow-1  ">Jumlah Transaksi</span>
                     <span class="fs-4 card-total" id="card-hutang-trans">0</span>
                  </div>
                  <div class="px-2 d-flex">
                     <span class="flex-grow-1   ">Total Pelunasan</span>
                     <span class="fs-4 card-total" id="card-hutang-payment">0</span>
                  </div> 
               </div> 
            </div>
         </div> 
      </div> 
      <div class="col-12 col-md-4">
         <div class="card shadow text-bg-orange text-white  border-top-orange">
            <div class="card-header">
               <div class="fw-bold"><i class="fas fa-list-alt"></i> Transaksi piutang progress (sedang berjalan)</div>
            </div>
            <div class="card-body bg-white">
               <div class="d-flex flex-column fw-bold">
                  <div class="px-2 d-flex">
                     <span class="flex-grow-1  ">Jumlah Transaksi</span>
                     <span class="fs-4 card-total" id="card-progress-trans">0</span>
                  </div>
                  <div class="px-2 d-flex">
                     <span class="flex-grow-1   ">Total Pelunasan</span>
                     <span class="fs-4 card-total" id="card-progress-payment">0</span>
                  </div> 
               </div> 
            </div>
         </div> 
      </div>
   </div>
   <div class="row page-content">
      <div class="col-12">
         <div class="card border-top-orange">
            <div class="card-header">
               <div class="row align-items-center">
                  <div class="col">
                     <span class="fw-bold"><i class="fas fa-money-bill-alt" aria-hidden="true"></i>&nbsp;Finance - Piutang Penjualan</span>
                  </div>
                  <div class="col-auto px-1 d-none">
                     <button id="btn-export" class="btn btn-primary btn-sm btn-hide">
                        <i class="fas fa-file-export"></i>
                        <span class="fw-bold">
                           &nbsp;Export Data
                        </span>
                     </button>
                  </div>
                  <div class="col-auto px-0 d-none">
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
                        <label for="tb_store" class="col-sm-3 col-form-label">Toko</label>
                        <div class="col-sm-9">
                           <select class="custom-select custom-select-sm form-control form-control-sm" id="tb_store" name="tb_store" <?= ($this->session->userdata("login_mode") == "Superuser" || "Finance" ? "" : "disabled") ?>>
                              <option value="0">Semua Toko</option>
                              <?php
                                 $this->db->where("MsWorkplaceIsActive", "1")->where("MsWorkplaceType", "0");
                                 $query = $this->db->get('TblMsWorkplace')->result();
                                 foreach ($query as $key) {
                                    echo '<option value="' . $key->MsWorkplaceId . '" ' . ($this->session->userdata("MsWorkplaceId") == $key->MsWorkplaceId ? "selected" : "") . '>' . $key->MsWorkplaceCode . '</option>';
                                 }
                              ?>
                           </select>
                        </div>
                     </div>

                     <div class="row mb-1">
                        <label for="tb_search" class="col-sm-3 col-form-label">
                           <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="" id="tb_date_check">
                              <label class="form-check-label" for="tb_date_check">
                                 Tanggal
                              </label>
                           </div>
                        </label>
                        <div class="col-sm-9">
                           <input type="text" class="form-control form-control-sm" id="tb_date" disabled>
                        </div>
                     </div> 
                     <div class="row mb-1">
                        <label for="tb_row" class="col-sm-3 col-form-label">Status Transaksi</label>
                        <div class="col-sm-9">
                           <select class="custom-select custom-select-sm form-control form-control-sm" id="tb_type" name="tb_type" style="width:100%">
                              <option value="0" selected>Semua Status</option>
                              <option value="1" >Masih Progress</option> 
                              <option value="2" >Sudah Selesai</option> 
                           </select>
                        </div>
                     </div> 
                     <div class="row mb-1">
                        <label for="tb_search" class="col-sm-3 col-form-label">Pencarian</label>
                        <div class="col-sm-9">
                           <input type="text" class="form-control form-control-sm" id="tb_search">
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
      $(document).ready(function() { 
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
               show_card(); 
               show_detail();
            } else {
               page_load = 1;
            }
         }
         $('#tb_date_check').change(function() {
            if(this.checked) {
               $('#tb_date').removeAttr('disabled'); 
            }else{
               $('#tb_date').attr('disabled','disabled');
               show_card(); 
               show_detail();
            } 
            console.log($('#tb_date_check').is(":checked"));
         });
            
         var ajax_card = new $.ajax();
         var ajax_search = new $.ajax();
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
         show_card = function() {  
            if (ajax_card && ajax_card.readyState != 4) {
               ajax_card.abort();
            }
            ajax_card =  $.ajax({
                                    method: "POST",
                                    url: "<?= site_url("function/Client_data_financial/get_card_pihutang/") ?>" + $("#tb_store").val(),  
                                    data: {
                                       "tanggalstart": StartDateContent.format('YYYY-MM-DD'),
                                       "tanggalend": EndDateContent.format('YYYY-MM-DD'),
                                       "tanggalchecked":$('#tb_date_check').is(":checked"),
                                    },  
                                    success: function(data) { 
                                       $("#card-total-trans").html(data["totaltrans"]);
                                       $("#card-total-payment").html(data["totalpayment"]);
                                       $("#card-hutang-trans").html(data["hutangtrans"]);
                                       $("#card-hutang-payment").html(data["hutangpayment"]);
                                       $("#card-progress-trans").html(data["progresstrans"]);
                                       $("#card-progress-payment").html(data["progresspayment"]);
                                       $(".card-total").each(function() {
                                          var val = this.innerHTML;
                                          animateValue(this, 0, val, 2000);
                                       });
                                    }
                                 });

         }
         show_detail = function(){
            $("#wait-content").show();
            $("#data-content").hide();
            if (ajax_search && ajax_search.readyState != 4) {
               ajax_search.abort();
            }
            ajax_search =  $.ajax({
                  method: "POST",
                  url: "<?= site_url("function/Client_data_financial/get_list_pihutang/") ?>",
                  data: {
                     "store": $("#tb_store").val(),
                     "status": $("#tb_type").val(),
                     "search": $("#tb_search").val(),
                     "tanggalstart": StartDateContent.format('YYYY-MM-DD'),
                     "tanggalend": EndDateContent.format('YYYY-MM-DD'),
                     "tanggalchecked":$('#tb_date_check').is(":checked"),
                  }, 
                  success: function(data) {  
                     $("#wait-content").hide();
                     $("#data-content").html(data);
                     $("#data-content").show();
                  }
               });

         }
         $("#tb_store").change(function(){ 
            show_card(); 
            show_detail();
         });
         $("#tb_store").trigger("change");

         $("#tb_type").change( function(){  
             show_detail();
         });
         $("#tb_search").keyup( function(){ 
             show_detail();
         })
      });
   </script>

</body>

</html>