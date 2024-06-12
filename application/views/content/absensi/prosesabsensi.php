<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <style>
      .select2-results__group:hover {
         cursor: pointer;
         background: #fff2df;
      }
   </style>
</head>

<body>
   <section class="content-header">
      <div class="row mb-2">
         <div class="col-md-auto col-12">
            <h2 onclick="menuselect('absensi-Proses','menu-absensi')">Proses Absensi</h2>
         </div>
         <div class="col align-self-end">
            <ol class="breadcrumb float-md-end">
               <li class="breadcrumb-item">Absensi</li>
               <li class="breadcrumb-item active" onclick="menuselect('absensi-Proses','menu-absensi')">Proses Absensi</li>
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
                     <span class="fw-bold"><i class="fas fa-users" aria-hidden="true"></i>&nbsp;Absensi - Proses Absensi</span>
                  </div>
               </div>
            </div>
            <div class="card-body">
               <div class="row">
                  <div class="col-lg-6 col-12">
                     <div class="row mb-2">
                        <label for="tb_row" class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                           <input type="text" class="form-control form-control-sm" id="tb_date">
                        </div>
                     </div>
                     <div class="row mb-1">
                        <label for="tb_row" class="col-sm-3 col-form-label">Karyawan</label>
                        <div class="col-sm-9">
                           <select class="custom-select custom-select-sm form-control form-control-sm" id="tb_status" name="tb_status" style="width:100%" multiple="multiple" required>
                              <optgroup class="select2-result-selectable" label="PILIH SEMUA KARYAWAN">
                              </optgroup>
                              <?php
                              $db = $this->db->join("TblMsWorkplace", "TblMsWorkplace.MsWorkplaceId=TblMsEmployee.MsWorkplaceId")->where("MsEmpIsActive=1")->order_by("TblMsEmployee.MsWorkplaceId ASC,MsEmpId ASC")->get("TblMsEmployee")->result();
                              $lastwork = "";
                              $start = 0;
                              foreach ($db as $key) {
                                 if ($lastwork != $key->MsWorkplaceId) {
                                    $lastwork = $key->MsWorkplaceId;
                                    if ($start != 0) echo '</optgroup>';
                                    echo '<optgroup class="select2-result-selectable" label="PILIH DARI TOKO ' . $key->MsWorkplaceCode . '">';
                                    $start++;
                                 }
                                 echo '<option value="' . $key->MsEmpId . '">' . $key->MsEmpCode . '-' . $key->MsEmpName . '</option>';
                              }
                              echo '</optgroup>';
                              ?>
                           </select>
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
         if (moment().format('DD') <= 20) {
            var oldmon = moment(moment().subtract(1, 'month'));

            var StartDateContent = moment(oldmon.format('YYYY-MM-') + '21');
            var EndDateContent = moment(moment().format('YYYY-MM-') + '20');
         } else {
            var nextmon = moment(moment().add(1, 'month'));

            var StartDateContent = moment(moment().format('YYYY-MM-') + '21');
            var EndDateContent = moment(nextmon.format('YYYY-MM-') + '20');
         }
         $('#tb_date').daterangepicker({
               startDate: StartDateContent,
               endDate: EndDateContent,
               ranges: {
                  'Periode ini': [StartDateContent, EndDateContent],
                  '1 Periode yang Lalu': [moment(StartDateContent).subtract(1, 'month'), moment(EndDateContent).subtract(1, 'month')],
                  '2 Periode yang lalu': [moment(StartDateContent).subtract(2, 'month'), moment(EndDateContent).subtract(2, 'month')],
                  '3 Periode yang lalu': [moment(StartDateContent).subtract(3, 'month'), moment(EndDateContent).subtract(3, 'month')],
               },
               locale: {
                  "format": 'DD/MM/YYYY',
                  "customRangeLabel": "Pilih Tanggal Sendiri",
               }
            },
            Date_content);
         Date_content(StartDateContent, EndDateContent);

         function Date_content(start, end) {
            $('#tb_date').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
            StartDateContent = start;
            EndDateContent = end;
         }

         $("#tb_status").select2({
            allowClear: true,
            placeholder: 'Pilih nama karyawan..',
         });
         $(document).on("click", ".select2-results__group", function() {
            $('#tb_status').val(null).trigger('change');
            var groupName = $(this).html();
            var options = $('#tb_status option');
            $.each(options, function(key, value) {
               if (groupName == "PILIH SEMUA KARYAWAN") {
                  $(value).prop("selected", "selected");
               } else {
                  if ($(value)[0].parentElement.label.indexOf(groupName) >= 0) {
                     $(value).prop("selected", "selected");
                  }
               }
            });

            $("#tb_status").trigger("change");
            $("#tb_status").select2('close');

         });
         $("#btn-view").click(function() {
            if ($("#tb_status").select2("val") == "") {
               Swal.fire({
                  icon: 'error',
                  text: 'Silahkan pilih nama karyawan terlebih dahulu...',
                  showConfirmButton: false,
                  allowOutsideClick: false,
                  allowEscapeKey: false,
                  timer: 1500
               });
               return false;
            }
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
                  "MsEmpId": $("#tb_status").select2("val")
               },
               url: "<?= site_url('function/client_export_absen/absensi_proses/') ?>",
               success: function(data) {
                  $("#wait-content").hide();
                  $("#data-content").html(data);
                  $("#data-content").show();
               }
            })
         });
         $("#btn-export").click(function() {
            $.redirect('<?php echo site_url('function/client_export_absen/absensi_proses_export') ?>', {
               'datestart': StartDateContent.format('YYYY-MM-DD'),
               'dateend': EndDateContent.format('YYYY-MM-DD'),
               "MsEmpId": $("#tb_status").select2("val")
            }, "POST", "_blank");
         });
      });
   </script>
</body>

</html>