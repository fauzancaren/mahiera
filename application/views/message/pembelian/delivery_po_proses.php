<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-xl">
      <div class="modal-content" name="form-action">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-share-square text-primary"></i> &nbsp;Proses Pengiriman</h6>
            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="row justify-content-center">
               <div class="col-lg-6 col-11 my-1">
                  <div class="row mb-1 align-items-center px-2">
                     <div class="label-border-right">
                        <span class="label-dialog">Dokument</span>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center px-2">
                     <label for="DeliveryCode" class="col-sm-3 col-form-label fw-bold">No. Delivery</label>
                     <div class="col-sm-9">
                        <span class="fw-bold"><?= $_delivery->DeliveryCode ?></span>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center px-2">
                     <label for="DeliveryCode" class="col-sm-3 col-form-label fw-bold">Tanggal Kirim</label>
                     <div class="col-sm-3">
                        <span class="fw-bold"><?= $_delivery->DeliveryDate ?></span>
                     </div>
                     <label for="DeliveryCode" class="col-sm-3 col-form-label fw-bold">Pengiriman Ke</label>
                     <div class="col-sm-3">
                        <span class="fw-bold"><?= $_delivery->DeliveryRit ?></span>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center px-2">
                     <label for="DeliveryCode" class="col-sm-3 col-form-label fw-bold">No. Sales</label>
                     <div class="col-sm-9">
                        <span class="fw-bold"><?= $_delivery->DeliveryRef ?></span>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center px-2">
                     <label for="DeliveryCode" class="col-sm-3 col-form-label fw-bold">No. Ref (PO/TO)</label>
                     <div class="col-sm-9">
                        <span class="fw-bold"><?= $_delivery->DeliveryRef2 ?></span>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center px-2">
                     <label for="DeliveryCode" class="col-sm-3 col-form-label fw-bold">Toko</label>
                     <div class="col-sm-3">
                        <span class="fw-bold"><?= $_delivery->MsWorkplaceCode ?></span>
                     </div>
                     <label for="DeliveryCode" class="col-sm-2 col-form-label fw-bold">Admin</label>
                     <div class="col-sm-4">
                        <span class="fw-bold"><?= $_delivery->MsEmpName ?></span>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center px-2">
                     <label for="DeliveryCode" class="col-sm-3 col-form-label fw-bold">Tipe Pengiriman</label>
                     <div class="col-sm-9">
                        <span class="fw-bold"><?
                                                switch ($_delivery->DeliveryType) {
                                                   case "0":
                                                      echo 'Toko -> Customer';
                                                      break;
                                                   case "1":
                                                      echo 'Toko -> Toko';
                                                      break;
                                                   case "2":
                                                      echo 'Vendor -> Customer';
                                                      break;
                                                   case "3":
                                                      echo 'Vendor -> Toko';
                                                      break;
                                                   case "4":
                                                      echo 'Vendor -> Gudang';
                                                      break;
                                                   default:
                                                      break;
                                                }
                                                ?></span>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center px-2">
                     <label for="DeliveryCode" class="col-sm-3 col-form-label fw-bold">Catatan</label>
                     <div class="col-sm-9">
                        <span class="fw-bold"><?= $_delivery->DeliveryRemarks ?></span>
                     </div>
                  </div>
               </div>
               <div class=" col-xl-6 col-11 my-1">
                  <div class="row mb-1 align-items-center">
                     <div class="label-border-right">
                        <span class="label-dialog">Pengiriman / Delivery</span>
                     </div>
                  </div>

                  <div class="row mb-1 align-items-center ">
                     <label for="DeliveryJenis" class="col-sm-3 col-form-label lbl-omahbata">Via</label>
                     <div class="col-sm-9 lbl-omahbata">
                        <select class="custom-select custom-select-sm form-select form-select-sm" id="DeliveryJenis" name="DeliveryJenis" style="width:100%">
                           <option value="1" <?= ($_delivery->DeliveryJenis == 1 ? "selected" : "") ?>>ENGKEL</option>
                           <option value="2" <?= ($_delivery->DeliveryJenis == 2 ? "selected" : "") ?>>PICK-UP</option>
                           <option value="3" <?= ($_delivery->DeliveryJenis == 3 ? "selected" : "") ?>>PS</option>
                        </select>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center ">
                     <label for="MsVendorId" class="col-sm-3 col-form-label">Driver</label>
                     <div class="col-sm-9">
                        <select class="custom-select custom-select-sm form-control form-control-sm select-modal" id="DeliveryDriver" name="DeliveryDriver" style="width:100%" multiple="multiple" required>
                           <?php
                           $db = $this->db->where("MsEmpPositionId", "11")->where("MsEmpIsActive", 1)->get("TblMsEmployee")->result();
                           foreach ($db as $key) {
                              echo '<option value="' . $key->MsEmpId . '">' . $key->MsEmpCode . ' - ' . $key->MsEmpName . '</option>';
                           }
                           ?>
                        </select>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="DeliveryJenis" class="col-sm-3 col-form-label lbl-omahbata">Pengirim</label>
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
                  <div class="row mb-1 align-items-center">
                     <label for="DeliveryJenis" class="col-sm-3 col-form-label lbl-omahbata">Penerima</label>
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
   $("#DeliveryDriver,#DeliveryJenis,#MsStoreSrc").select2({
      dropdownParent: $("#modal-action .modal-content"),
      placeholder: "pilih driver yang mengantar",
   });


   get_data_delivery = function(id) {
      return new Promise(function(resolve, reject) {
         $.ajax({
            url: "<?= site_url("function/client_data_sales/get_del_customer/") ?>" + id,
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
</script>