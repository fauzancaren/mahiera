<div class="modal fade" id="modal-select-delivery" tabindex="-1" role="dialog" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content shadow-lg" name="form-select-delivery">
         <div class="modal-header">
            <h6 class="modal-title "><i class="far fa-check-square text-success"></i>&nbsp;Pilih Alamat Pengiriman</h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="row justify-content-center">
               <div class="col-12">
                  <button class="btn btn-success btn-sm py-1" id="create-delivery" type="button">
                     <i class="fas fa-plus" aria-hidden="true"></i>
                     <span class="fw-bold">
                        &nbsp;Tambah Alamat Baru
                     </span>
                  </button>
                  <div id="data-pengiriman" class="d-flex flex-column mt-1">
                     <div class="card shadow-sm card-delivery select delivery-select">
                        <div class="p-2 ps-4">
                           <span class="card-title fw-bold">Ibu Salsa&nbsp;<span class="badge bg-secondary">Utama</span></span><br>
                           <span class="card-text">0813 1015 4883</span><br>
                           <span class="card-text">Jl. Banding V, Kec. Tangerang, Kota Tangerang, Banten, 15118
                              [Tokopedia Note: aura laundry jalan banding 5 blok d8 no 5]</span><br>
                           <div class="py-2 d-flex align-items-center text-secondary">
                              <i class="fas fa-map-marker-alt fa-2x"></i>
                              <span class="label-small">&nbsp;Map Sudah diset</span>
                           </div>
                        </div>
                        <div class="d-flex flex-row ms-4 card-delivery-action my-1 ">
                           <a class="action-label" href="#">Ubah</a>
                        </div>
                     </div>
                     <div class="card shadow-sm card-delivery delivery-select">
                        <div class="p-2 ps-4">
                           <span class="card-title fw-bold">Ibu Salsa</span><br>
                           <span class="card-text">0813 1015 4883</span><br>
                           <span class="card-text">Jl. Banding V, Kec. Tangerang, Kota Tangerang, Banten, 15118
                              [Tokopedia Note: aura laundry jalan banding 5 blok d8 no 5]</span><br>
                           <div class="py-2 d-flex align-items-center text-secondary">
                              <i class="fas fa-map-marker-alt fa-2x"></i>
                              <span class="label-small">&nbsp;Map Sudah diset</span>
                           </div>
                        </div>
                        <div class="d-flex flex-row ms-4 card-delivery-action my-1 ">
                           <a class="action-label" href="#">Ubah</a>
                           <div class="action-space"></div>
                           <a class="action-label" href="#">Jadikan Alamat Utama</a>
                           <div class="action-space"></div>
                           <a class="action-label" href="#">Hapus</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="submit" class="btn btn-success py-1" id="btn-submit-select">pilih</button>
            <button type="button" class="btn btn-secondary py-1" data-bs-dismiss="modal">batalkan</button>
         </div>
      </div>
   </div>
</div>
<div id="data-modal-select-delivery">
</div>
<script>
   var modeselect = true;
   var id_delivery = 0;
   var id_index = 0;
   var data_delivery = [];
   set_modal_select = function(modalutama) {
      $("#modal-select-delivery").modal("show");

      $("#modal-select-delivery").on("hidden.bs.modal", function() {
         if (modeselect) $(modalutama).modal("show")
      });
      $("#modal-select-delivery").on("show.bs.modal", function() {
         modeselect = true;
      });
   }

   function load_data_select_delivery() {
      $.ajax({
         method: "POST",
         dataType: "json",
         url: "<?= site_url("function/client_data_sales/get_del_customer/") . $id ?>",
         success: function(data) {
            datadelivery = data;
            var htmldelivery = "";
            var htmlAction = "";
            var orderflex = 2;
            for (var i = 0; datadelivery.length > i; i++) {
               if (datadelivery[i]["MsCustomerDeliveryUtama"] == 1) {
                  htmldelivery += '<div class="card shadow-sm card-delivery order-1 delivery-select" data-value="' + datadelivery[i]["MsCustomerDeliveryId"] + '" data-index="' + i + '" >';
                  htmlAction = '      <a class="action-label" onclick="change_delivery_select(' + i + ')" >Ubah</a>';
               } else {
                  htmldelivery += '<div class="card shadow-sm card-delivery order-' + orderflex + ' delivery-select" data-value="' + datadelivery[i]["MsCustomerDeliveryId"] + '">';
                  orderflex++;
                  htmlAction = '      <a class="action-label" onclick="change_delivery_select(' + i + ')" >Ubah</a>';
                  htmlAction += '      <div class="action-space"></div>';
                  htmlAction += '      <a class="action-label" onclick="set_delivery_select(' + i + ')" >Jadikan Alamat Utama</a>';
               }
               htmldelivery += '  <div class="p-2 ps-4">';
               htmldelivery += '      <span class="card-title fw-bold">' + datadelivery[i]["MsCustomerDeliveryReceive"] + (datadelivery[i]["MsCustomerDeliveryUtama"] == 1 ? '&nbsp;<span class="badge bg-secondary">Utama</span>' : "") + '</span><br>';
               htmldelivery += '      <span class="card-text">' + datadelivery[i]["MsCustomerDeliveryTelp"] + '</span><br>';
               htmldelivery += '      <span class="card-text">' + datadelivery[i]["MsCustomerDeliveryAddress"] + '</span><br>';
               htmldelivery += '      <div class="py-2 d-flex align-items-center text-secondary">';
               htmldelivery += '          <i class="fas fa-map-marker-alt fa-2x pe-2"></i>';
               htmldelivery += '          <span class="label-small">' + datadelivery[i]["MsCustomerDeliveryName"] + '</span>';
               htmldelivery += '      </div>';
               htmldelivery += '  </div>';
               htmldelivery += '  <div class="d-flex flex-row ms-4 card-delivery-action my-1 ">';
               htmldelivery += htmlAction;
               htmldelivery += '  </div>';
               htmldelivery += '</div>';
            }
            $("#data-pengiriman").html(htmldelivery);


            $("#btn-submit-select").prop("disabled", true);

            function closeall() {
               $(".delivery-select").each(function(index, element) {
                  $(this).removeClass("select");
               });
               $("#btn-submit-select").prop("disabled", true);
            }
            $(".delivery-select").each(function(index, element) {
               $(this).click(function() {
                  closeall();
                  $(this).addClass("select");
                  $("#btn-submit-select").prop("disabled", false);
                  id_delivery = $(this).data("value");
                  id_index = $(this).data("index");
               });
            });
         }
      });
   }
   load_data_select_delivery();
   $("#modal-select-delivery").on("show.bs.modal", function() {
      mode = true;
      load_data_select_delivery();
   });
   $("#create-delivery").click(function() {
      if (typeof window.ajaxRequestSingle !== "undefined") {
         window.ajaxRequestSingle.abort();
      }

      window.ajaxRequestSingle = $.ajax({
         method: "POST",
         url: "<?= site_url("message/message_sales/data_delivery_edit/") ?>",
         success: function(data) {
            $("#data-modal-select-delivery").html(data);
            modeselect = false;
            $("#modal-select-delivery").modal("hide");
            set_modal_action($("#modal-select-delivery"), [], <?= $id ?>);

         }
      });
   });

   function change_delivery_select(i) {
      if (typeof window.ajaxRequestSingle !== "undefined") {
         window.ajaxRequestSingle.abort();
      }

      window.ajaxRequestSingle = $.ajax({
         method: "POST",
         url: "<?= site_url("message/message_sales/data_delivery_edit/") ?>",
         success: function(data) {
            $("#data-modal-select-delivery").html(data);
            modeselect = false;
            $("#modal-select-delivery").modal("hide");
            set_modal_action($("#modal-select-delivery"), datadelivery[i], 0);

         }
      });
   }

   function set_delivery_select(i) {
      if (typeof window.ajaxRequestSingle !== "undefined") {
         window.ajaxRequestSingle.abort();
      }

      window.ajaxRequestSingle = $.ajax({
         method: "POST",
         url: "<?= site_url("function/client_data_master/data_cs_delivery_utama/") ?>",
         data: {
            "MsCustomerId": <?= $id ?>,
            "MsCustomerDeliveryId": datadelivery[i]["MsCustomerDeliveryId"],
         },
         success: function(data) {
            if (data) {
               Swal.fire({
                  icon: 'success',
                  text: 'Simpan data berhasil',
                  showConfirmButton: false,
                  allowOutsideClick: false,
                  allowEscapeKey: false,
                  timer: 1500,
               }).then((result) => {
                  if (result.dismiss === Swal.DismissReason.timer) {
                     load_data_select_delivery();
                  }
               });
            } else {
               Swal.fire({
                  icon: 'error',
                  text: 'Simpan data gagal',
                  showConfirmButton: false,
                  allowOutsideClick: false,
                  allowEscapeKey: false,
                  timer: 1500
               });
            }
         }
      });
   }
   $("#btn-submit-select").click(function() {
      set_del_id(id_delivery, id_index);
      get_data_delivery(<?= $id ?>);

      $("#modal-select-delivery").modal("hide");
      $("#modal-action").modal("show");
   });
</script>