<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-xl">
      <div class="modal-content" name="form-action">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;Pengiriman</h6>
            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="row justify-content-center">
               <div class="col-lg-6 col-11 my-1">
                  <div class="row mb-1 align-items-center">
                     <div class="label-border-right">
                        <span class="label-dialog">Reference</span>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="DeliveryRef" class="col-sm-3 col-form-label">No. Sales<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-9">
                        <input id="DeliveryRef" name="DeliveryRef" type="text" class="form-control form-control-sm" value="<?= $_dataref->SalesRef ?>" readonly>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <div class="label-border-right">
                        <span class="label-dialog">Dokument</span>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="DeliveryCode" class="col-sm-3 col-form-label">No. Doc<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-9">
                        <input id="DeliveryCode" name="DeliveryCode" type="text" class="form-control form-control-sm" value="" readonly>
                     </div>
                  </div>
                  <div class=" row mb-1 align-items-center">
                     <label for="DeliveryDate" class="col-sm-3 col-form-label">Tanggal<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-3">
                        <input id="DeliveryDate" name="DeliveryDate" type="text" class="form-control form-control-sm" value="">
                     </div>
                     <label for="DeliveryRit" class="col-sm-3 col-form-label">Pengiriman ke<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-3">
                        <input id="DeliveryRit" name="DeliveryRit" type="number" class="form-control form-control-sm" value="">
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="MsWokrplaceCode" class="col-sm-3 col-form-label">Toko<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-3">
                        <div class="input-group">
                           <select class="custom-select custom-select-sm form-select form-select-sm " id="MsWorkplaceId" name="MsWorkplaceId" style="width:100%">';
                              <?php
                              $db = $this->db->get("TblMsWorkplace")->result();
                              foreach ($db as $key) {
                                 echo '<option value="' . $key->MsWorkplaceId . '" ' . ($_session["MsWorkplaceId"] == $key->MsWorkplaceId ? "selected" : "") . '>' . $key->MsWorkplaceCode . '</option>';
                              }
                              ?>
                           </select>
                        </div>
                     </div>
                     <label for="DeliveryAdmin" class="col-sm-2 col-form-label">Admin<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-4">
                        <div class="input-group">
                           <select class="custom-select custom-select-sm form-select form-select-sm " id="MsEmpId" name="MsEmpId" style="width:100%">';
                              <?php
                              $db = $this->db->get("TblMsEmployee")->result();
                              foreach ($db as $key) {
                                 echo '<option value="' . $key->MsEmpId . '" ' . ($_session["MsEmpId"] == $key->MsEmpId ? "selected" : "") . '>' . $key->MsEmpName . '</option>';
                              }
                              ?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="DeliveryRemarks" class="col-sm-3 col-form-label">Catatan<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-9">
                        <textarea id="DeliveryRemarks" name="DeliveryRemarks" type="text" class="form-control form-control-sm"></textarea>
                     </div>
                  </div>
                  <div class="row my-2 align-items-center">
                     <label for="deliverydesc" class="col-sm-3 col-form-label">Pengiriman hari ini</label>
                     <label id="deliverydesc" class="col-sm-9" style="font-weight:bold;font-size:0.75rem">
                        sudah ada 3 pengiriman <a class="text-primary " onclick="show_pengiriman()" style="cursor:pointer">lihat lebih banyak</a>
                     </label>
                  </div>

               </div>
               <div class="col-xl-6 col-11 my-1">
                  <div class="row mb-1 align-items-center">
                     <div class="label-border-right">
                        <span class="label-dialog">Pengiriman / Delivery</span>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="MsDeliveryType" class="col-sm-3 col-form-label">Tipe Pengiriman</label>
                     <div class="col-sm-9">
                        <div class="input-group">
                           <select class="custom-select custom-select-sm form-select form-select-sm" id="MsDeliveryType" name="MsDeliveryType" style="width:100%">
                              <option value="0">Toko -> Customer</option>
                              <option value="1">Toko -> Toko</option>
                              <option value="2">Vendor -> Customer</option>
                              <option value="3">Vendor -> Toko</option>
                              <option value="4">Vendor -> Gudang</option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center d-none" id="display-vendor">
                     <label for="PORef" class="col-sm-3 col-form-label">No. Ref </label>
                     <div class="col-sm-9 group-input">
                        <input id="PORef" name="PORef" type="text" class="form-control form-control-sm" value="<?= $_dataref->POCode ?>" placeholder="Cari data pembelian" readonly>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="MsDeliveryId" class="col-sm-3 col-form-label">Armada</label>
                     <div class="col-sm-5">
                        <div class="input-group">
                           <select class="custom-select custom-select-sm form-select form-select-sm" id="MsDeliveryId" name="MsDeliveryId" style="width:80%">';
                              <?php
                              $db = $this->db->where("MsDeliveryIsActive=1")->get("TblMsDelivery")->result();
                              foreach ($db as $key) {
                                 echo '<option value="' . $key->MsDeliveryId . '">' . $key->MsDeliveryName . '</option>';
                              }
                              ?>
                           </select>
                           <button class="btn btn-success btn-sm" id="create-new-armada" type="button"><i class="fas fa-plus" aria-hidden="true"></i></button>
                        </div>
                     </div>
                     <label for="DeliveryJenis" class="col-sm-1 col-form-label lbl-omahbata">Via</label>
                     <div class="col-sm-3 lbl-omahbata">
                        <select class="custom-select custom-select-sm form-select form-select-sm" id="DeliveryJenis" name="DeliveryJenis" style="width:100%">
                           <option value="1">ENGKEL</option>
                           <option value="2">PICK-UP</option>
                           <option value="3">PS</option>
                        </select>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center lbl-optional" style="display: none;">
                     <label for="DeliveryResi" class="col-sm-3 col-form-label">Resi<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-9">
                        <input id="DeliveryResi" name="DeliveryResi" type="text" class="form-control form-control-sm"></input>
                     </div>
                  </div>
                  <div class="row mb-1 mt-2 align-items-center">
                     <label for="MsStoreSrc" class="col-sm-3 col-form-label">Pengirim</label>
                     <div class="col-sm-9">
                        <div class="input-group">
                           <select class="custom-select custom-select-sm form-select form-select-sm" id="MsStoreSrc" name="MsStoreSrc" style="width:100%">
                              <option value="0">VENDOR</option>
                              <?php
                              $db = $this->db->get("TblMsWorkplace")->result();
                              foreach ($db as $key) {
                                 echo '<option value="' . $key->MsWorkplaceId . '">' . $key->MsWorkplaceCode . '</option>';
                              }
                              ?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="row mb-1 ">
                     <label for="Pelanggan" class="col-sm-3 col-form-label">Penerima</label>
                     <div class="col-sm-9 p-0">
                        <div class="row m-1 ">
                           <div class="input-group d-none" id="display-dst">
                              <select class="custom-select custom-select-sm form-select form-select-sm" id="MsStoreDst" name="MsStoreDst" style="width:100%">';
                                 <?php
                                 $db = $this->db->get("TblMsWorkplace")->result();
                                 foreach ($db as $key) {
                                    echo '<option value="' . $key->MsWorkplaceId . '">' . $key->MsWorkplaceCode . '</option>';
                                 }
                                 ?>
                              </select>
                           </div>
                        </div>
                        <div class="row m-1 ">
                           <div class="col-12" id="detail-delivery">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-12 col-11 my-1">
                  <div class="row justify-content-center">
                     <div class="col-12">
                        <div class="row mb-1 align-items-center">
                           <div class="label-border-right mb-3" style="position:relative">
                              <span class="label-dialog">Detail Item</span>
                           </div>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="card " style="min-height:100px;">
                           <div class="card-body p-2 ">
                              <table id="tb_data_item" class="table table-hover align-middle responsive" style='font-family:"Sans-serif", Helvetica; font-size:80%;width:100%'>
                                 <thead class="thead-dark" style="display:none;">
                                    <tr>
                                       <th>html</th>
                                       <th>MsItemId</th>
                                       <th>MsVendorCode</th>
                                       <th>MsItemUoM</th>
                                       <th>SalesDetailQty</th>
                                       <th>DeliveryDetailQtyTotal</th>
                                       <th>DeliveryDetailQty</th>
                                    </tr>
                                 </thead>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="submit" class="btn btn-success" id="btn-submit">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
         </div>
      </div>
   </div>
</div>

<div id="dialog-customer">
</div>

<div class="modal fade " id="modal-action-armada" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-dialog-centered ">
      <form class="modal-content" name="form-action-armada">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;Tambah Armada Pengiriman</h5>
               <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="row justify-content-center">
               <div class="col-10">
                  <div class="row mb-1 align-items-center">
                     <label for="MsDeliveryName" class="col-sm-3 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-9">
                        <input id="MsDeliveryName" name="MsDeliveryName" type="text" class="form-control form-control-sm" value="">
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="submit" class="btn btn-success" id="btn-submit-armada">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
         </div>
      </form>
   </div>
   <script>
      var req_status_armada = 0;

      $(function() {
         $("form[name='form-action-armada']").validate({
            rules: {
               MsDeliveryName: {
                  "required": true,
                  "remote": "<?= site_url("function/client_data_master/validate_kode_delivery") ?>",
               },
            },
            messages: {
               MsDeliveryName: {
                  required: "Masukan Nama Tipe Pengiriman",
                  remote: "Nama Tipe Pengiriman sudah ada"
               },
            },
            submitHandler: function(form) {
               if (!req_status_armada) {
                  $("#btn-submit-armada").html('<i class="fas fa-circle-notch fa-spin"></i> Loading');
                  $.ajax({
                     method: "POST",
                     url: "<?= site_url("function/client_data_master/data_delivery_add") ?>",
                     data: {
                        "MsDeliveryName": $("#MsDeliveryName").val(),
                        "MsDeliveryIsActive": "on"
                     },
                     before: function() {
                        req_status_armada = 1;
                     },
                     success: function(data) {
                        req_status_add = 0;
                        $("#btn-submit-armada").html("Simpan");

                        if (data) {
                           Swal.fire({
                              icon: 'success',
                              text: 'Tambah data berhasil',
                              showConfirmButton: false,
                              allowOutsideClick: false,
                              allowEscapeKey: false,
                              timer: 1500,
                           }).then((result) => {
                              if (result.dismiss === Swal.DismissReason.timer) {
                                 $("#modal-action-armada").modal("hide");
                                 $("#SalesDeliveryService").select2("open");
                              }
                           });
                        } else {
                           Swal.fire({
                              icon: 'error',
                              text: 'Tambah data gagal',
                              showConfirmButton: false,
                              allowOutsideClick: false,
                              allowEscapeKey: false,
                              timer: 1500
                           });
                        }
                     }
                  });
                  return false;
               }
            }
         });
      });
   </script>
</div>

<script>
   /*  ARRAY SELECT */
   var datestart = moment();
   var req_status_add = 0;
   var del_address_store = [];
   var del_id = <?= ($_dataref->MsCustomerDeliveryId != null ? $_dataref->MsCustomerDeliveryId : 0) ?>;
   var cust_id = <?= ($_dataref->MsCustomerId != null ? $_dataref->MsCustomerId : 0) ?>;
   var del_index = 0;

   function next_kode() {
      if (typeof window.ajaxRequestSingle !== "undefined") {
         window.ajaxRequestSingle.abort();
      }

      window.ajaxRequestSingle = $.ajax({
         method: "POST",
         url: "<?= site_url("function/client_data_pembelian/get_next_delivery") ?>",
         data: {
            "MsWorkplaceId": $("#MsWorkplaceId").val(),
            "MsEmpId": $("#MsEmpId").val(),
            "Month": datestart.format('MM'),
            "Year": datestart.format('YYYY')
         },
         success: function(data) {
            $("#DeliveryCode").val(data)
         }
      });
   }
   next_kode();
   var data_item = [];
   $("#DeliveryDate").daterangepicker({
      singleDatePicker: true,
      startDate: datestart,
      showDropdowns: true,
      locale: {
         "format": "DD/MM/YYYY",
         "customRangeLabel": "Pilih Tanggal Sendiri",
      }
   }, function(start, end) {
      datestart = start;
      get_list_delivery();
      next_kode();
   });


   data_pengiriman = [];
   data_pengiriman_html = [];
   get_list_delivery = function() {
      $.ajax({
         method: "POST",
         dataType: "json",
         url: "<?= site_url("function/client_data_sales/get_list_delivery/") ?>" + moment(datestart).format('YYYY-MM-DD'),
         success: function(data) {
            data_pengiriman = data["data"];
            data_pengiriman_html = data["html"];
            if (data_pengiriman.length > 0) {
               $("#deliverydesc").html('sudah ada ' + data_pengiriman.length + ' pengiriman omahbata <a class="text-primary" onclick="show_pengiriman()" style="cursor:pointer">lihat detail</a>');
            } else {
               $("#deliverydesc").html('tidak ada pengiriman');
            }
         }
      });
   }
   show_pengiriman = function() {
      Swal.fire({
         width: 1200,
         height: 600,
         html: data_pengiriman_html,
      })
   }

   $('#MsDeliveryId').select2({
      placeholder: "Cari Armada",
      dropdownParent: $("#modal-action .modal-content"),
      ajax: {
         dataType: "json",
         url: "<?= site_url("function/client_data_sales/get_data_armada") ?>",
         delay: 800,
         processResults: function(data) {
            return {
               results: data
            };
         }
      }
   });
   $("#MsDeliveryId").on("select2:select", function(e) {
      if (this.value == 1) {
         $.each($(".lbl-omahbata"), function(e) {
            $(this).show();
         });
         $.each($(".lbl-optional"), function(e) {
            $(this).hide();
         });
      } else {
         $.each($(".lbl-omahbata"), function(e) {
            $(this).hide();
         });
         $.each($(".lbl-optional"), function(e) {
            $(this).show();
         });
      }
   });
   $('#MsDeliveryType').select2({
      placeholder: "Cari Armada",
      dropdownParent: $("#modal-action .modal-content")
   });
   $("#MsDeliveryType").on("select2:select", function(e) {
      if (this.value > 0) {
         $("#display-vendor").removeClass("d-none");
      } else {
         $("#display-vendor").removeClass("d-none");
         $("#display-vendor").addClass("d-none");
      };

      if (this.value == 1) {
         $("#display-dst").removeClass("d-none");
         $("#MsStoreDst").val("<?= $this->session->userdata("MsWorkplaceId") ?>").trigger("change");
         get_data_delivery_store($("#MsStoreDst").val());
      } else if (this.value == 3) {
         $("#display-dst").removeClass("d-none");
         $("#MsStoreDst").val("<?= $this->session->userdata("MsWorkplaceId") ?>").trigger("change");
         get_data_delivery_store($("#MsStoreDst").val());
      } else if (this.value == 4) {
         $("#display-dst").removeClass("d-none");
         $("#MsStoreDst").val(2).trigger("change");
         get_data_delivery_store($("#MsStoreDst").val());
      } else {
         $("#display-dst").removeClass("d-none");
         $("#display-dst").addClass("d-none");
         load_data_delivery();
      };
   });

   $('#MsStoreDst,#MsStoreSrc,#DeliveryJenis,#MsWorkplaceId,#MsEmpId').select2({
      dropdownParent: $("#modal-action .modal-content")
   });
   $("#MsStoreDst").on("select2:select", function(e) {
      get_data_delivery_store(this.value);
   });
   $("#MsWorkplaceId,#MsEmpId").on("select2:select", function(e) {
      next_kode();
   });
   $("#create-new-armada").click(function() {
      $("#modal-action-armada").modal("show");
      $("#modal-action").modal("hide");
   });
   $("#modal-action-armada").on("hidden.bs.modal", function() {
      $("#modal-action").modal("show");
   });

   get_data_delivery = function() {
      return new Promise(function(resolve, reject) {
         $.ajax({
            url: "<?= site_url("function/client_data_sales/get_del_customer/") ?>" + cust_id,
            type: "GET",
            dataType: "json",
            beforeSend: function() {},
            success: function(data) {
               resolve(data) // Resolve promise and when success
            },
            error: function(err) {
               reject(err) // Reject the promise and go to catch()
            }
         });
      });
   }
   load_data_delivery = async function() {
      const del_address = await get_data_delivery();
      var htmldelivery = "";
      for (var i = 0; del_address.length > i; i++) {
         if (del_id < 0 && del_address[i]["MsCustomerDeliveryUtama"] == 1) {
            htmldelivery = '<div id="card-delivery" class="card shadow-sm card-delivery select" >';
            htmldelivery += '  <input id="MsCustomerDeliveryId" value="' + del_address[i]["MsCustomerDeliveryId"] + '" style="display:none"/>';
            htmldelivery += '  <div class="p-2 ps-4">';
            htmldelivery += '      <span class="card-title fw-bold">' + del_address[i]["MsCustomerDeliveryReceive"] + '</span><br>';
            htmldelivery += '      <span class="card-text">' + del_address[i]["MsCustomerDeliveryTelp"] + '</span><br>';
            htmldelivery += '      <span class="card-text">' + del_address[i]["MsCustomerDeliveryAddress"] + '</span><br>';
            htmldelivery += '      <div class="py-2 d-flex align-items-center text-secondary">';
            htmldelivery += '          <i class="fas fa-map-marker-alt fa-2x pe-2"></i>';
            htmldelivery += '          <span class="label-small">' + del_address[i]["MsCustomerDeliveryName"] + '</span>';
            htmldelivery += '      </div>';
            htmldelivery += '  </div>';
            htmldelivery += '  <div class="d-flex ms-4 card-delivery-action my-1 ">';
            htmldelivery += '      <a class="action-label" onclick="ubah_data_delivery()" >Ubah</a>';
            htmldelivery += '      <div class="action-space"></div>';
            htmldelivery += '      <a class="action-label" onclick="pilih_data_delivery()" >Pilih Alamat Lain</a>';
            htmldelivery += '  </div>';
            htmldelivery += '</div>';
            $("#detail-delivery").html(htmldelivery);
            del_id = del_address[i]["MsCustomerDeliveryId"];
            del_index = i;
            break;
         } else if (del_address[i]["MsCustomerDeliveryId"] == del_id) {
            htmldelivery = '<div id="card-delivery" class="card shadow-sm card-delivery select">';
            htmldelivery += '  <input id="MsCustomerDeliveryId" value="' + del_address[i]["MsCustomerDeliveryId"] + '" style="display:none"/>';
            htmldelivery += '  <div class="p-2 ps-4">';
            htmldelivery += '      <span class="card-title fw-bold">' + del_address[i]["MsCustomerDeliveryReceive"] + '</span><br>';
            htmldelivery += '      <span class="card-text">' + del_address[i]["MsCustomerDeliveryTelp"] + '</span><br>';
            htmldelivery += '      <span class="card-text">' + del_address[i]["MsCustomerDeliveryAddress"] + '</span><br>';
            htmldelivery += '      <div class="py-2 d-flex align-items-center text-secondary">';
            htmldelivery += '          <i class="fas fa-map-marker-alt fa-2x pe-2"></i>';
            htmldelivery += '          <span class="label-small">' + del_address[i]["MsCustomerDeliveryName"] + '</span>';
            htmldelivery += '      </div>';
            htmldelivery += '  </div>';
            htmldelivery += '  <div class="d-flex  ms-4 card-delivery-action my-1 ">';
            htmldelivery += '      <a class="action-label" onclick="ubah_data_delivery()" >Ubah</a>';
            htmldelivery += '      <div class="action-space"></div>';
            htmldelivery += '      <a class="action-label" onclick="pilih_data_delivery()" >Pilih Alamat Lain</a>';
            htmldelivery += '  </div>';
            htmldelivery += '</div>';
            del_index = i;
            $("#detail-delivery").html(htmldelivery);
            break;
         }
      }
   }

   get_data_store = function(id) {
      return new Promise(function(resolve, reject) {
         $.ajax({
            url: "<?= site_url("function/client_data_sales/get_del_store/") ?>" + id,
            type: "GET",
            dataType: "json",
            beforeSend: function() {},
            success: function(data) {
               resolve(data) // Resolve promise and when success
            },
            error: function(err) {
               reject(err) // Reject the promise and go to catch()
            }
         });
      });
   }

   get_data_delivery_store = async function(id) {
      try {
         const del_address = await get_data_store(id);
         var htmldelivery = "";
         htmldelivery = '<div id="card-delivery" class="card shadow-sm card-delivery select" >';
         htmldelivery += '  <input id="MsCustomerDeliveryId" value="' + del_address["MsWorkplaceId"] + '" style="display:none"/>';
         htmldelivery += '  <div class="p-2 ps-4">';
         htmldelivery += '      <span class="card-title fw-bold">' + del_address["MsWorkplaceName"] + '</span><br>';
         htmldelivery += '      <span class="card-text">' + del_address["MsWorkplaceTelp1"] + '</span><br>';
         htmldelivery += '      <span class="card-text">' + del_address["MsWorkplaceAddress"] + '</span><br>';
         htmldelivery += '      <div class="py-2 d-flex align-items-center text-secondary">';
         htmldelivery += '          <i class="fas fa-map-marker-alt fa-2x pe-2"></i>';
         htmldelivery += '          <span class="label-small">' + del_address["MsWorkplaceMap"] + '</span>';
         htmldelivery += '      </div>';
         htmldelivery += '  </div>';
         htmldelivery += '</div>';
         $("#detail-delivery").html(htmldelivery);
      } catch (e) {
         console.log(e);
      }
   }


   ubah_data_delivery = function() {
      if (typeof window.ajaxRequestSingle !== "undefined") {
         window.ajaxRequestSingle.abort();
      }

      window.ajaxRequestSingle = $.ajax({
         method: "POST",
         url: "<?= site_url("message/message_sales/data_delivery_edit/") ?>" + $("#MsCustomerDeliveryId").val(),
         success: function(data) {
            $("#dialog-customer").html(data);
            $("#modal-action").modal("hide"); 
            set_modal_action($("#modal-action"));
            $("#modal-action").on("shown.bs.modal", function() {
               load_data_delivery();
            });
         }
      });
   }
   pilih_data_delivery = function() {
      if (typeof window.ajaxRequestSingle !== "undefined") {
         window.ajaxRequestSingle.abort();
      }

      window.ajaxRequestSingle = $.ajax({
         method: "POST",
         url: "<?= site_url("message/message_sales/data_delivery_select/") ?>" + cust_id,
         success: function(data) {
            $("#dialog-customer").html(data);
            $("#modal-action").modal("hide");
            set_modal_select($("#modal-action"));
         }
      });
   }
   set_del_id = function(i, j) {
      del_id = i;
      del_index = j;
   }


   load_data_delivery();

   /* data_item (html,itemid,vendorcode,uom,SalesDetailQty,DeliveryDetailQtyTotal,DeliveryDetailQty) */
   get_list_delivery();





   function get_sum_delivery(itemid, vendor) {
      var total = 0;
      for (var i = 0; data_delivery.length > i; i++) {
         if (itemid == data_delivery[i]['MsItemId'] && vendor == data_delivery[i]['MsVendorCode']) {
            total += parseFloat(data_delivery[i]['DeliveryDetailQty']);
         }
      }
      return total;
   }
   var po = <?= JSON_ENCODE($_dataref) ?>;
   $("#MsDeliveryType>option[value='0']").attr('disabled', 'disabled');
   $("#MsDeliveryType>option[value='1']").attr('disabled', 'disabled');
   if (po["SalesRef"] == "") {
      $("#MsDeliveryType>option[value='2']").attr('disabled', 'disabled');
   } else {}

   if (po["PODst"] == "0") {
      $("#MsDeliveryType").val(2).trigger("change").trigger("select2:select");
   } else if (po["PODst"] == "2") {
      $("#MsDeliveryType").val(4).trigger("change").trigger("select2:select");
   } else {
      $("#MsDeliveryType").val(3).trigger("change").trigger("select2:select");
   }
   $("#MsStoreDst").val(po["PODst"]).trigger("change").trigger("select2:select");
   $("#DeliveryRef").val(po["SalesRef"]);
   $("#PORef").val(po["POCode"]);
   $("#action-pembelian").hide();

   var item_po = <?= JSON_ENCODE($_item) ?>;
   var item_po_delivery = <?= JSON_ENCODE($_itemdelivery) ?>;

   function get_sum_delivery_po(itemid, vendor) {
      var total = 0;
      for (var i = 0; item_po_delivery.length > i; i++) {
         if (itemid == item_po_delivery[i]['MsItemId'] && vendor == item_po_delivery[i]['MsVendorCode']) {
            total += parseFloat(item_po_delivery[i]['DeliveryDetailQty']);
         }
      }
      return total;
   }
   data_item = [];
   for (var i = 0; i < item_po.length; i++) {
      var total_delivery = get_sum_delivery_po(item_po[i]['MsItemId'], item_po[i]['MsVendorCode']);
      var htmlItem = '<div class="row row-table get-item">';
      htmlItem += '     <div class="col-lg-5 col-12 mb-lg-0 mb-2" >';
      htmlItem += '       <span class="fw-bold">' + item_po[i]['MsItemCode'] + '-' + item_po[i]['MsItemName'] + ' (' + item_po[i]['MsVendorCode'] + ')</span><br>';
      htmlItem += '       <span  style="color:gray;font-size:0.6rem">' + item_po[i]['MsItemSize'] + '&nbsp;|&nbsp;' + item_po[i]['MsItemPcsM2'] + '</span>';
      htmlItem += '     </div>';
      htmlItem += '     <div class="col-lg-7 col-12 g-1">';
      htmlItem += '       <div class="row" >';
      htmlItem += '          <div class="col-3">';
      htmlItem += '             <div class="d-flex flex-column">';
      htmlItem += '                <span  style="color:gray;">Yang Sudah dikirim :</span>';
      htmlItem += '                <span class="fw-bold style="color:gray;" name="DeliveryDetailQtyTotal">' + total_delivery + " " + item_po[i]['MsItemUoM'] + '</span>';
      htmlItem += '             </div>';
      htmlItem += '          </div>';
      htmlItem += '          <div class="col-3">';
      htmlItem += '             <div class="d-flex flex-column">';
      htmlItem += '                <span  style="color:gray;">Total dari PO :</span>';
      htmlItem += '                <span class="fw-bold style="color:gray;" name="SalesDetailQty">' + item_po[i]['PODetailQty'] + ' ' + item_po[i]['MsItemUoM'] + '</span>';
      htmlItem += '             </div>';
      htmlItem += '          </div>';
      htmlItem += '          <div class="col-3">';
      htmlItem += '             <div class="d-flex flex-column">';
      htmlItem += '                <span  style="color:gray;">Qty&nbsp;(' + item_po[i]['MsItemUoM'] + ')</span>';
      htmlItem += '                <input type="text" class="input-in-table double" name="DeliveryDetailQty" style="min-width:90px" value=""/>';
      htmlItem += '             </div>';
      htmlItem += '          </div>';
      htmlItem += '          <div class="col-3">';
      htmlItem += '             <div class="d-flex flex-column">';
      htmlItem += '                <span  style="color:gray;">Spare&nbsp;(' + item_po[i]['MsItemUoM'] + ')</span>';
      htmlItem += '                <input type="text" class="input-in-table double" name="DeliveryDetailQtySpare" style="min-width:90px" value=""/>';
      htmlItem += '             </div>';
      htmlItem += '          </div>';
      htmlItem += '        </div>';
      htmlItem += '     </div>';
      data_item.push([htmlItem,
         item_po[i]['MsItemId'],
         item_po[i]['MsVendorCode'],
         item_po[i]['MsItemUoM'],
         item_po[i]['PODetailQty'],
         total_delivery,
         item_po[i]['PODetailQty'],
         0,
      ]);
   }
   var tbl_item = $("#tb_data_item").DataTable({
      "searching": false,
      "ajax": function(data, callback, settings) {
         callback({
            data: data_item
         }) //reloads data 
      },
      "columnDefs": [{
         "targets": [1, 2, 3, 4, 5, 6],
         "visible": false,
      }, ],
      "lengthChange": false,
      "paging": false,
      "ordering": false,
      "autoWidth": true,
      "info": false
   });

   tbl_item.on("draw", function() {
      $(".get-item").each(function(index, thisrow) {
         function total_item() {
            var sisa = (data_item[index][4] - data_item[index][5]);
            if (data_item[index][6] > sisa) {
               // data_item[index][6] = sisa;
               //$(thisrow).find('input[name="DeliveryDetailQty"]').val(sisa);
            };
         }
         console.log(data_item[index][6]);
         var textqty = $(thisrow).find('input[name="DeliveryDetailQty"]').val(data_item[index][6]).keyup(function() {
            data_item[index][6] = this.value.replaceAll(",", "");
            total_item();
         }).focusout(function() {
            if (this.value == "" || this.value == "-") {
               $(this).val(0);
            }
         }).focus();
         var textspare = $(thisrow).find('input[name="DeliveryDetailQtySpare"]').val(data_item[index][7]).keyup(function() {
            data_item[index][7] = this.value.replaceAll(",", "");
            total_item();
         }).focusout(function() {
            if (this.value == "" || this.value == "-") {
               $(this).val(0);
            }
         }).focus();
         total_item();
      });

      var doubleinputs = Array.from(document.getElementsByClassName("double"));
      doubleinputs.forEach(function(doubleinput) {
         new Cleave(doubleinput, {
            numeral: true,
            numeralDecimalMark: ".",
            delimiter: ","
         })
      });
   });
   tbl_item.ajax.reload();

   $("#btn-submit").click(async function() {
      if (($("#MsDeliveryType").val() > 1) && ($("#PORef").val() == "")) {
         Swal.fire({
            icon: 'error',
            text: 'Pilih dokument PO terlebih dahulu!!!',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            timer: 1500
         });
         return;
      }
      if (!req_status_add) {
         $("#btn-submit").html('<i class="fas fa-circle-notch fa-spin"></i> Loading');
         var dataheader = {
            "DeliveryRef": $("#DeliveryRef").val(),
            "DeliveryRef2": $("#PORef").val(),
            "DeliveryFrom": $("#MsStoreSrc").val(),
            "DeliveryCode": $("#DeliveryCode").val(),
            "DeliveryDate": moment(datestart).format('YYYY-MM-DD'),
            "DeliveryDate2": moment().format('YYYY-MM-DD'),
            "DeliveryRit": $("#DeliveryRit").val(),
            "MsDeliveryId": $("#MsDeliveryId").val(),
            "MsCustomerDeliveryId": $("#MsCustomerDeliveryId").val(),
            "MsCustomerId": cust_id,
            "DeliveryType": $("#MsDeliveryType").val(),
            "DeliveryJenis": $("#DeliveryJenis").val(),
            "DeliveryRemarks": $("#DeliveryRemarks").val(),
            "MsEmpId": <?= $_dataref->MsEmpId ?>,
            "DeliveryStatus": ($("#MsDeliveryId").val() == 1 ? 0 : 1),
            "MsWorkplaceId": <?= $_dataref->MsWorkplaceId ?>,
         };

         var detailitem = [];
         for (var i = 0; data_item.length > i; i++) {
            /* data_item (html,itemid,vendorcode,price,qty,disc,uom,total) */
            if (data_item[i][6] > 0) {
               var data = {
                  "MsItemId": data_item[i][1],
                  "MsVendorCode": data_item[i][2],
                  "DeliveryDetailQty": data_item[i][6],
                  "DeliveryDetailSpareQty": data_item[i][7],
                  "DeliveryDetailRef": $("#DeliveryCode").val(),
               };
               detailitem.push(data);
            }
         }

         /* -------------------------------------------------     SEND DATA SERVER    ---------------------------------------------- */
         $.ajax({
            method: "POST",
            url: "<?= site_url("function/client_data_sales/data_delivery_add") ?>",
            data: {
               "data": dataheader,
               "item": detailitem,
            },
            before: function() {
               req_status_add = 1;
            },
            success: function(data) {
               req_status_add = 0;
               $("#btn-submit").html("Simpan");
               Swal.fire({
                  icon: 'success',
                  text: 'Tambah data berhasil',
                  showConfirmButton: false,
                  allowOutsideClick: false,
                  allowEscapeKey: false,
                  timer: 1500,
               }).then((result) => {
                  if (result.dismiss === Swal.DismissReason.timer) {
                     $.redirect('<?php echo site_url('export/datasales/delivery/-') ?>', {
                        'code': $("#DeliveryCode").val(),
                     }, "POST", "_blank");
                     load_data_table();
                  }
               });
            }
         });
      }
   });
</script>