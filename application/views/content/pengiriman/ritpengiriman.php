<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <style>
      .number-calender {
         cursor: help;
         background: #e7e7e7;
         width: 1.5rem;
         text-align: center;
         border-bottom-right-radius: 0.25rem;
      }

      .tooltip-inner {
         max-width: 350px;

      }

      .data-item {
         position: relative;
      }

      .data-item>.action {
         position: absolute;
         opacity: 0;
         top: 0;
         right: 0;
         font-size: 0.7rem;
      }

      .data-item:hover>.action {
         opacity: 1;
      }

      .nav-link {
         color: gray;
         background: transparent;
         width: auto !important;
      }

      .nav-link.active {
         color: #f0ad4e !important;
         border-bottom: 3px solid #f0ad4e !important;
      }

      .list-ritase {
         padding-left: 2rem !important;
         position: relative;
      }
      .list-ritase:before {
         content: "";
         position: absolute;
         left: 4px;
         width: 2px;
         height: 100%; 
         border: 2px dashed #c5c5c5;
      }
      .list-ritase:after{ 
         content: "";
         top: 28px;
         position: absolute;
         left: 6px;
         width: 26px;
         height: 2px;
         background-color: #c5c5c5;
      }
      .list-number {
         position: absolute;
         top: 15px;
         left: -7px;
         width: 25px;
         height: 25px;
         border-radius: 50%;
         background: #727272;
         text-align: center;
         color: white;
         font-weight: bold;
         z-index: 1;
      } 
   </style>
</head>

<body>
   <section class="content-header">
      <div class="row mb-2">
         <div class="col-md-auto col-12">
            <h2>Pengiriman - Rit Pengiriman</h2>
         </div>
         <div class="col align-self-end">
            <ol class="breadcrumb float-md-end">
               <li class="breadcrumb-item">Pengiriman</li>
               <li class="breadcrumb-item active" onclick="menuselect('pengiriman-list','menu-pengiriman')" style="cursor:pointer">List Rit Pengiriman</li>
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
                     <span class="fw-bold"><i class="fas fa-truck" aria-hidden="true"></i>&nbsp;List Rit Pengiriman</span>
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
            <div id="data-content" class="p-2">
               <div class="row border-bottom pb-2">
                  <div class="col-lg-6 col-12">  
                     <div class="row mb-1">
                        <label for="tb_date" class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                           <input type="text" class="form-control form-control-sm" id="tb_date" placeholder="Cari nama customer/kode pengiriman">
                        </div>
                     </div>
                     <div class="row mb-1 align-items-center">
                        <label for="tb_armada" class="col-sm-3 col-form-label">Armada</label>
                        <div class="col-9">
                           <select class="custom-select custom-select-sm form-control form-control-sm" id="tb_armada" name="tb_armada">
                              <option value="-" selected>Semua Armada</option>
                              <option value="engkel">Engkel</option>
                              <option value="pickup">Pickup</option> 
                           </select>
                        </div> 
                     </div>
                     <div class="row mb-1">
                        <label for="tb_search" class="col-sm-3 col-form-label">Pencarian</label>
                        <div class="col-sm-9">
                           <input type="text" class="form-control form-control-sm" id="tb_search" placeholder="Cari nama customer/kode pengiriman">
                        </div>
                     </div>
                  </div>
               </div>
               <nav>
                  <div class="nav nav-tabs" id="nav-tab" role="tablist">
                     <button class="nav-link active" id="nav-new-tab" data-bs-toggle="tab" type="button" role="tab" aria-selected="true">Baru</button>
                     <button class="nav-link" id="nav-set-tab" data-bs-toggle="tab" type="button" role="tab" aria-selected="false">Dijadwalkan</button>
                     <button class="nav-link" id="nav-finish-tab" data-bs-toggle="tab" type="button" role="tab" aria-selected="false">Selesai</button>
                  </div>
               </nav>
               <div class="tab-content" id="nav-tabContent"></div> 
               <div id="wait" class="load-container load4" style="display: block;">
                  <div class="load-progress"></div>
               </div>
               <script>
                  var ajax_req_message;
                  var mode_tab = "home";
                  /* ----------------                     ACTION DATE              ------------------------ */
                  var StartDateContent = moment().subtract(7, 'days');
                  var EndDateContent = moment().add(7,'days');
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
                        tablload_data_ritase();
                     } else {
                        page_load = 1;
                     }
                  }
                  $("#btn-add-master").click(function(){
                     $.ajax({
                           url: "<?= site_url('message/message_pengiriman/add_rit_pengiriman/') ?>",
                           success: function(response) {
                              $("#dialog-box").html(response);
                              modal_action = new bootstrap.Modal(document.getElementById('modal-action'));
                              modal_action.show();
                           },
                           error: function(xhr, status, error) {
                              console.log(xhr.responseText);
                           }
                        }); 
                  });

                  $("#nav-new-tab").click(function(){
                     if(mode_tab!="home"){
                        mode_tab = "home";
                        load_data_ritase();
                     }
                  })
                  $("#nav-set-tab").click(function(){
                     if(mode_tab!="set"){
                        mode_tab = "set";
                        load_data_ritase();
                     } 
                  })
                  $("#nav-finish-tab").click(function(){
                     if(mode_tab!="finish"){
                        mode_tab = "finish";
                        load_data_ritase();
                     }
                  })

                  load_data_ritase = function(){
                     $("#wait").show();  
                     $("#nav-tabContent").hide();
                     switch(mode_tab) {
                        case "home":
                           $.ajax({
                              type:"post",
                              url: "<?= site_url('function/client_datatable_pengiriman/rit_home/') ?>",
                              data: {
                                 "search":$("#tb_search").val(),
                                 "armada":$("#tb_armada").val(),
                                 "start":StartDateContent.format("YYYY-MM-DD"),
                                 "end":EndDateContent.format("YYYY-MM-DD"),
                              },
                              success: function(response) {
                                 $("#wait").hide();  
                                 $("#nav-tabContent").html(response);
                                 $("#nav-tabContent").show("slow");
                              },
                              error: function(xhr, status, error) {
                                 console.log(xhr.responseText);
                              }
                           }); 
                           break;
                        case "set":
                           $.ajax({
                              url: "<?= site_url('function/client_datatable_pengiriman/rit_set/') ?>",
                              data: {
                                 "search":$("#tb_search").val(),
                                 "armada":$("#tb_armada").val(),
                                 "start":StartDateContent.format("YYYY-MM-DD"),
                                 "end":EndDateContent.format("YYYY-MM-DD"),
                              },
                              success: function(response) {
                                 $("#wait").hide();  
                                 $("#nav-tabContent").html(response);
                                 $("#nav-tabContent").show("slow");
                              },
                              error: function(xhr, status, error) {
                                 console.log(xhr.responseText);
                              }
                           }); 
                           break; 
                        case "finish":
                           $.ajax({
                              url: "<?= site_url('function/client_datatable_pengiriman/rit_finish/') ?>",
                              data: {
                                 "search":$("#tb_search").val(),
                                 "armada":$("#tb_armada").val(),
                                 "start":StartDateContent.format("YYYY-MM-DD"),
                                 "end":EndDateContent.format("YYYY-MM-DD"),
                              },
                              success: function(response) {
                                 $("#wait").hide();  
                                 $("#nav-tabContent").html(response);
                                 $("#nav-tabContent").show("slow");
                              },
                              error: function(xhr, status, error) {
                                 console.log(xhr.responseText);
                              }
                           }); 
                           break;
                        default:
                           // code block
                     }
                  }
                  load_data_ritase();
               </script>
            </div>
         </div>
      </div>
   </div>

   <div id="dialog-box">
   </div> 

</body>

</html>