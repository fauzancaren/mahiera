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
            <h2>Report Penjualan Vendor</h2>
         </div>
         <div class="col align-self-end">
            <ol class="breadcrumb float-md-end">
               <li class="breadcrumb-item">Penjualan</li>
               <li class="breadcrumb-item active">Report Penjualan Vendor</li>
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
                     <span class="fw-bold"><i class="fas fa-shopping-bag" aria-hidden="true"></i>&nbsp;Report - Penjualan Vendor</span>
                  </div>
               </div>
            </div>
            <div class="card-body">
               <div class="row">
                  <div class="col-lg-6 col-12">
                     <div class="row mb-1">
                        <label for="tb_row" class="col-sm-3 col-form-label">Toko</label>
                        <div class="col-sm-9">
                           <select class="custom-select custom-select-sm form-control form-control-sm" id="tb_status" name="tb_status" <?= (($this->session->userdata("login_mode") == "Superuser" || $this->session->userdata("login_mode") == "Finance") ? "" : "disabled") ?>>
                              <option value="-" selected>Semua Toko</option>
                              <?php
                              $db = $this->db->where("MsWorkplaceIsActive=1")->get("TblMsWorkplace")->result();
                              foreach ($db as $key) {
                                 echo '<option value="' . $key->MsWorkplaceId . '"  ' . ($this->session->userdata("MsWorkplaceId") == $key->MsWorkplaceId ? "selected" : "") . '>' . $key->MsWorkplaceCode . '</option>';
                              }
                              ?>
                           </select>
                        </div>
                     </div>
                     <div class="row mb-2">
                        <label for="tb_row" class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                           <input type="text" class="form-control form-control-sm" id="tb_date">
                        </div>
                     </div>
                     <div class="row mb-1">
                        <div class="col-sm-9 offset-3">
                           <button type="button" class="btn btn-success btn-sm btn-hide py-1" id="btn-view">
                              <i class="fas fa-file-export"></i>
                              <span class="fw-bold">
                                 &nbsp;View Data
                              </span>
                           </button>
                           <button type="button" class="btn btn-primary btn-sm btn-hide py-1" id="btn-export">
                              <i class="fas fa-file-export"></i>
                              <span class="fw-bold">
                                 &nbsp;Export Data
                              </span>
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
               <hr>
               <div id="wait-content" class="load-container load4" style="display: none;">
                  <div class="load-progress"></div>
               </div>
               <div id="data-content" class="p-2">

               </div>
            </div>
         </div>
      </div>
   </div>

   <div id="dialog-box">
   </div>

   <script>
      $(document).ready(function() {
         $("[data-bs-toggle=\'tooltip\']").tooltip();
         var ajax_req;
         var req_status = 0;
         var modal_action = "";
         var StartDateContent = moment().startOf('month');
         var EndDateContent = moment().endOf('month');
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
         Date_content(StartDateContent, EndDateContent);

         function Date_content(start, end) {
            $('#tb_date').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
            StartDateContent = start;
            EndDateContent = end;
         }
         $("#btn-view").click(function() {
            $("#data-content").hide();
            $("#wait-content").show();
            if (ajax_req && ajax_req.readyState != 4) {
               ajax_req.abort();
            }
            ajax_req = $.ajax({
               type: "POST",
               data: {
                  "datestart": StartDateContent.format('YYYY-MM-DD'),
                  "dateend": EndDateContent.format('YYYY-MM-DD'),
                  "store": $('#tb_status').val()
               },
               url: "<?= site_url('function/client_export_sales/sales_vendor_load/') ?>",
               success: function(data) {
                  $("#wait-content").hide();
                  $("#data-content").html(data);
                  $("#data-content").show();
               }
            })
         })
         $("#btn-export").click(function() {

            $.redirect('<?php echo site_url('function/client_export_sales/sales_vendor_export') ?>', {
               'datestart': StartDateContent.format('YYYY-MM-DD'),
               'dateend': EndDateContent.format('YYYY-MM-DD'),
               'store': $('#tb_status').val(),
            }, "POST", "_blank");
         })
      });
   </script>
</body>

</html>