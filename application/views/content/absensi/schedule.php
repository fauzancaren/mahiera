<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <style>
      .datepicker table {
         width: 100%;
      }

      .col-head {
         min-width: 2rem !important;
      }

      .col-fix {
         min-width: 10rem !important;
         position: sticky;
         position: -webkit-sticky;
         background-color: #f2f2f2 !important;
      }

      .select2-selection.select2-selection--multiple {
         overflow-y: auto;
         max-height: 7rem;
      }
   </style>
</head>

<body>
   <section class="content-header">
      <div class="row mb-2">
         <div class="col-md-auto col-12">
            <h2 onclick="menuselect('absensi-roster','menu-absensi')">Data Schedule/Roster</h2>
         </div>
         <div class="col align-self-end">
            <ol class="breadcrumb float-md-end">
               <li class="breadcrumb-item">Absensi</li>
               <li class="breadcrumb-item active" onclick="menuselect('absensi-roster','menu-absensi')">Schedule/Roster</li>
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
                     <span class="fw-bold"><i class="fas fa-users" aria-hidden="true"></i>&nbsp;Absensi - Schedule/Roster</span>
                  </div>
                  <div class="col-auto px-1">
                     <button id="btn-export-absen" class="btn btn-primary btn-sm btn-hide">
                        <i class="fas fa-file-export"></i>
                        <span class="fw-bold">
                           &nbsp;Export Data
                        </span>
                     </button>
                  </div>
               </div>
            </div>
            <div class="card-body">
               <div class="row">
                  <div class="col-lg-6 col-12">
                     <div class="row mb-1">
                        <label for="tb_row" class="col-sm-3 col-form-label">Periode</label>
                        <div class="col-sm-9">
                           <div class="d-flex">
                              <button type="button" class="btn btn-secondary btn-sm" id="btnprev"><i class="fas fa-arrow-left"></i></button>
                              <input type="text" class="form-control form-control-sm flex-fill mx-1 text-center" id="tb_date" readonly style="width: 100%;">
                              <button type="button" class="btn btn-secondary btn-sm" id="btnnext"><i class="fas fa-arrow-right"></i></button>
                           </div>
                        </div>
                     </div>
                     <div class="row mb-1">
                        <label for="tb_row" class="col-sm-3 col-form-label">Toko</label>
                        <div class="col-sm-9">
                           <select class="custom-select custom-select-sm form-control form-control-sm" id="tb_workplace" name="tb_workplace">
                              <option value="-" selected>Semua Toko</option>
                              <?php
                              $query = $this->db->get('TblMsWorkplace')->result();
                              foreach ($query as $key) {
                                 echo '<option value="' . $key->MsWorkplaceId . '" ' . ($this->session->userdata("MsWorkplaceId") == $key->MsWorkplaceId ? "selected" : "") . '>' . $key->MsWorkplaceCode . '</option>';
                              }
                              ?>
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
         var datefilter = moment();
         var ajax_req;
         var dp = $("#tb_date").datepicker({
            viewMode: 1,
            minViewMode: 1,
            format: "MM yyyy"
         });
         $("#tb_date").datepicker('setDate', datefilter.toDate());
         $("#tb_date").datepicker('refresh');

         dp.on('changeDate', function(e) {
            datefilter = moment($('#tb_date').datepicker('getFormattedDate', 'yyyy-mm-dd'));
            load_data();
         });
         $("#btnnext").click(function() {
            datefilter = datefilter.add(1, 'month');
            $("#tb_date").datepicker('setDate', datefilter.toDate());
            $("#tb_date").datepicker('refresh');
         })
         $("#btnprev").click(function() {
            datefilter = datefilter.subtract(1, 'months');
            $("#tb_date").datepicker('setDate', datefilter.toDate());
            $("#tb_date").datepicker('refresh');
         })
         $("#tb_workplace").change(function() {
            load_data();
         });
         $("#tb_search").keyup(function(e) {
            if (e.keyCode === 13) {
               load_data();
            }
         });
         load_data = function() {
            $("#data-content").hide();
            $("#wait-content").show();
            if (ajax_req && ajax_req.readyState != 4) {
               ajax_req.abort();
            }
            ajax_req = $.ajax({
               type: "POST",
               data: {
                  "month": datefilter.format('MM'),
                  "year": datefilter.format('YYYY'),
                  "store": $('#tb_workplace').val(),
                  "search": $('#tb_search').val(),
               },
               url: "<?= site_url('function/client_export_absen/schedule_load/') ?>",
               success: function(data) {
                  $("#wait-content").hide();
                  $("#data-content").html(data);
                  $("#data-content").show();
               }
            })
         }
         load_data();

         tdclick = function(e, EmpId, RosterDate, id) {
            if (!e) var e = window.event; // Get the window event
            e.cancelBubble = true; // IE Stop propagation
            if (e.stopPropagation) e.stopPropagation(); // Other Broswers 

            if (ajax_req && ajax_req.readyState != 4) {
               ajax_req.abort();
            }
            ajax_req = $.ajax({
               url: "<?php echo site_url('message/message_absensi/roster_update/') ?>" + EmpId + "/" + RosterDate + "/" + id,
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
         };
      });
   </script>
</body>