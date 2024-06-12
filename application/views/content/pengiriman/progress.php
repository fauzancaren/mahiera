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

      .col-form-label {
         width: 8rem;
      }

      .col-form-label-2 {
         width: 4rem;
      }

      @media (max-width: 422px) {

         .col-form-label {
            width: 100%;
         }

         .col-form-label-2 {
            width: 100%;
         }
      }

      .kbw-signature {
         width: 330px;
         height: 240px;
      }

      #sig canvas {

         width: 100% !important;

         height: auto;

      }
   </style>
</head>

<body>
   <section class="content-header">
      <div class="row mb-2">
         <div class="col-md-auto col-12">
            <h2>Pengiriman - Progress</h2>
         </div>
         <div class="col align-self-end">
            <ol class="breadcrumb float-md-end">
               <li class="breadcrumb-item">Pengiriman</li>
               <li class="breadcrumb-item active" onclick="menuselect('pengiriman-progress','menu-pengiriman')" style="cursor:pointer">List Pengiriman</li>
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
                     <span class="fw-bold"><i class="fas fa-truck" aria-hidden="true"></i>&nbsp;List Pengiriman</span>
                  </div>
               </div>
            </div>
            <div class="card-body">
               <div class="row border-bottom pb-2">
                  <div class="col-lg-6 col-12">
                     <div class="row mb-1">
                        <label for="tb_driver" class="col-sm-3 col-form-label">Driver</label>
                        <div class="col-sm-9">
                           <select class="custom-select custom-select-sm form-control form-control-sm" id="tb_driver" name="tb_driver">
                              <option value="" selected>Semua Driver</option>
                              <?php
                              $this->db->where("MsEmpIsActive", "1");
                              $this->db->where("MsEmpPositionId", "11");
                              $query = $this->db->get('TblMsEmployee')->result();
                              foreach ($query as $key) {
                                 echo '<option value="' . $key->MsEmpId . '">' . $key->MsEmpCode . ' - ' . $key->MsEmpName . '</option>';
                              }
                              ?>
                           </select>
                        </div>
                     </div>
                     <div class="row mb-1">
                        <label for="tb_armada" class="col-sm-3 col-form-label">Jenis</label>
                        <div class="col-sm-9">
                           <select class="custom-select custom-select-sm form-control form-control-sm" id="tb_armada" name="tb_armada">
                              <option value="" selected>Semua Jenis</option>
                              <option value="1">PICK-UP</option>
                              <option value="2">ENGKEL</option>
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

               <div id="wait-content" class="load-container load4" style="display: block;">
                  <div class="load-progress"></div>
               </div>
               <div id="data-content" class="p-2" />
            </div>
         </div>
      </div>
   </div>

   <div id="dialog-box">
   </div>

   <script>
      var ajax_req;
      var modal_action;
      show_content = function() {
         $("#data-content").hide();
         $("#wait-content").show();
         if (ajax_req && ajax_req.readyState != 4) {
            ajax_req.abort();
         }
         ajax_req = $.ajax({
            type: "POST",
            data: {
               "driver": $("#tb_driver").val(),
               "jenis": $("#tb_armada").val()
            },
            url: "<?= site_url('function/client_data_pengiriman/get_data_progress/') ?>",
            success: function(data) {
               $("#wait-content").hide();
               $("#data-content").html(data);
               $("#data-content").show();
            }
         })
      }
      show_content();

      delivery_selesai = function(id) {
         if (ajax_req && ajax_req.readyState != 4) {
            ajax_req.abort();
         }
         ajax_req = $.ajax({
            url: "<?php echo site_url('message/message_pengiriman/selesai_pengiriman/') ?>" + id,
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
      load_data_table = function() {
         modal_action.hide();
         show_content();
      }
   </script>

</body>

</html>