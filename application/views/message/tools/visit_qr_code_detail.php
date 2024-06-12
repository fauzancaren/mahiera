<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-dialog-scrollable modal-xl">
      <div class="modal-content">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-chart-bar text-info" aria-hidden="true"></i> &nbsp;Report Scan QR Code - <?= $_qrcode->QrCodeName ?></h6>
            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body" style="min-height: calc(100vh - 11rem);overflow-x:hidden">
            <div class="row pb-2 mb-2 border-bottom border-secondary">
               <div class="col-4">
                  <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                     <i class="fa fa-calendar"></i>&nbsp;
                     <span></span> <i class="fa fa-caret-down float-end"></i>
                  </div>
               </div>
               <div class="col-8">
                  <div class="dropdown float-end">
                     <button class="btn btn-outline-secondary dropdown-toggle btn-sm py-1" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-cog pe-2"></i>Setting
                     </button>
                     <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-file-export pe-2"></i>Export Csv</a></li>
                        <li>
                           <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-trash-alt pe-2"></i>Reset Scan</a></li>
                     </ul>
                  </div>
               </div>
            </div>
            <div class="row mb-2 border-bottom border-light">
               <div class="col-6">
                  <span class="d-block fw-bold">SCAN OVER TIME</span>
                  <div id="chart_div_1"></div>
               </div>
               <div class="col-6">
                  <span class="d-block fw-bold">SCAN BY OPERATION SYSTEM</span>
                  <div id="chart_div_2"></div>
               </div>
            </div>
            <div class="row">
               <div class="col-6">
                  <span class="d-block fw-bold mb-2">SCAN BY COUNTRIES</span>
                  <div id="table-country"></div>
               </div>
               <div class="col-6">
                  <span class="d-block fw-bold mb-2">SCAN BY TOP CITIES</span>
                  <div id="table-city"></div>
               </div>
            </div>
         </div>
         <div class=" modal-footer">
            <button type="submit" class="btn btn-success" id="btn-submit">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
         </div>
      </div>
   </div>
</div>
<script>
   $(document).ready(function() {
      var startdatereport = moment().subtract(7, 'days');
      var enddatereport = moment();

      google.charts.load('current', {
         'packages': ['bar']
      });
      google.charts.load('current', {
         'packages': ['corechart']
      });
      google.charts.setOnLoadCallback(drawChart);
      google.charts.setOnLoadCallback(drawChart1);

      function drawChart() {
         var jsonData = $.ajax({
            url: "<?= site_url("function/client_data_tools/get_scan_qr_code") ?>",
            data: {
               "startdate": startdatereport.format('YYYY-MM-DD'),
               "enddate": enddatereport.format('YYYY-MM-DD'),
               "id": <?= $_qrcode->QrCodeId ?>
            },
            type: "post",
            dataType: "JSON",
            async: false
         }).responseText;
         jsonData = JSON.parse(jsonData);

         var data = new google.visualization.DataTable();
         data.addColumn('string', '');
         data.addColumn('number', '');
         $.each(jsonData, function(i, jsonData) {
            var month = jsonData.day;
            var profit = jsonData.total;
            data.addRows([
               [month, profit]
            ]);
         });
         var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_1'));
         chart.draw(data, {
            hAxis: {
               titlePosition: "none"
            },
            vAxis: {
               minValue: 0,
               titlePosition: "none"
            },
            height: 400,
            legend: {
               position: "none"
            },
         });
      }

      function drawChart1() {
         var jsonData = $.ajax({
            url: "<?= site_url("function/client_data_tools/get_scan_qr_code_os") ?>",
            data: {
               "startdate": startdatereport.format('YYYY-MM-DD'),
               "enddate": enddatereport.format('YYYY-MM-DD'),
               "id": <?= $_qrcode->QrCodeId ?>
            },
            type: "post",
            dataType: "JSON",
            async: false
         }).responseText;
         jsonData = JSON.parse(jsonData);

         var data = new google.visualization.DataTable();
         data.addColumn('string', 'System Operasi');
         data.addColumn('number', 'Total');
         $.each(jsonData, function(i, jsonData) {
            data.addRows([
               [jsonData.os, parseInt(jsonData.total)]
            ]);
         });
         var options = {
            height: 400,
         };

         var chart = new google.visualization.PieChart(document.getElementById('chart_div_2'));
         chart.draw(data, options);
      }

      function getCountry() {
         var jsonData = $.ajax({
            url: "<?= site_url("function/client_data_tools/get_scan_countries") ?>",
            data: {
               "startdate": startdatereport.format('YYYY-MM-DD'),
               "enddate": enddatereport.format('YYYY-MM-DD'),
               "id": <?= $_qrcode->QrCodeId ?>
            },
            type: "post",
            async: false
         }).responseText;
         $("#table-country").html(jsonData);
      }

      function getCity() {
         var jsonData = $.ajax({
            url: "<?= site_url("function/client_data_tools/get_scan_cities") ?>",
            data: {
               "startdate": startdatereport.format('YYYY-MM-DD'),
               "enddate": enddatereport.format('YYYY-MM-DD'),
               "id": <?= $_qrcode->QrCodeId ?>
            },
            type: "post",
            async: false
         }).responseText;
         $("#table-city").html(jsonData);
      }

      function cb(start, end) {
         startdatereport = start;
         enddatereport = end;
         $('#reportrange span').html(startdatereport.format('MMMM D, YYYY') + ' - ' + enddatereport.format('MMMM D, YYYY'));
         drawChart();
         drawChart1();
         getCountry();
         getCity();
      }
      $('#reportrange').daterangepicker({
         startDate: startdatereport,
         endDate: enddatereport,
         ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
         }
      }, cb);
      var myModalEl = document.getElementById('modal-action')
      myModalEl.addEventListener('shown.bs.modal', function(event) {
         cb(startdatereport, enddatereport);
      })
   });
</script>