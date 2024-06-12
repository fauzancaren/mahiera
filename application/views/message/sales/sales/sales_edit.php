<style>
   .info-box {
      color:#2d7400;;
      cursor: pointer;
   }
   .info-box:hover {
      color: #265e02;
      cursor: pointer;
   }
</style>
<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-xl">
      <div class="modal-content" name="form-action">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp;Edit Penjualan (Sales Order) </h6>
            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="row justify-content-center">
               <div class="col-lg-12 my-lg-0 col-11 my-1">  <!-- Header Select -->
                  <div class="row mb-1 align-items-center">
                     <label for="Salesheader" class="col-sm-2 col-form-label">Header Doc.</label>
                     <div class="col-sm-10">
                        <div class="form-check form-check-inline">
                           <input class="form-check-input" type="radio" name="Salesheader" id="Salesheader1" value="1" checked>
                           <label class="form-check-label" for="Salesheader1">
                              <img src="<?= base_url("asset/image/logo/logo-1-200.png") ?>" class="rounded" width="50">
                           </label>
                        </div>
                        <div class="form-check form-check-inline">
                           <input class="form-check-input" type="radio" name="Salesheader" id="Salesheader3" value="3">
                           <label class="form-check-label" for="Salesheader3"><img src="<?= base_url("asset/image/logo/logo-3-200.png") ?>" class="rounded" width="50"></label>
                        </div>
                        <div class="form-check form-check-inline">
                           <input class="form-check-input" type="radio" name="Salesheader" id="Salesheader4" value="4">
                           <label class="form-check-label" for="Salesheader4"><img src="<?= base_url("asset/image/logo/logo-4-200.png") ?>" class="rounded" width="50"></label>
                        </div>
                        <div class="form-check form-check-inline">
                           <input class="form-check-input" type="radio" name="Salesheader" id="Salesheader5" value="5">
                           <label class="form-check-label" for="Salesheader5"><img src="<?= base_url("asset/image/logo/logo-5-200.png") ?>" class="rounded" width="50"></label>
                        </div>
                        <div class="form-check form-check-inline">
                           <input class="form-check-input" type="radio" name="Salesheader" id="Salesheader6" value="6">
                           <label class="form-check-label" for="Salesheader6"><img src="<?= base_url("asset/image/logo/logo-6-200.png") ?>" class="rounded" width="50"></label>
                        </div>
                        <div class="form-check form-check-inline">
                           <input class="form-check-input" type="radio" name="Salesheader" id="Salesheader7" value="7">
                           <label class="form-check-label" for="Salesheader7"><img src="<?= base_url("asset/image/logo/logo-7-200.png") ?>" class="rounded" width="50"></label>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-6 col-11 my-1"> <!-- Document | pelanggan | Pengiriman -->
                  <!-- document -->
                  <div class="row mb-1 align-items-center">
                     <div class="label-border-right">
                        <span class="label-dialog">Dokument</span>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="SalesRef" class="col-sm-3 col-form-label">No. Ref<sup class="error">&nbsp;(optional)</sup></label>
                     <div class="col-sm-9 group-input">
                        <input id="SalesRef" name="SalesRef" type="text" class="form-control form-control-sm" value="" placeholder="Cari data penawaran" readonly>
                        <button class="btn btn-danger btn-sm close" id="remove-quotation" style="display: none;" type="button"><i class="fas fa-times" aria-hidden="true"></i></button>
                        <button class="btn btn-success btn-sm" id="action-quotation" type="button"><i class="fas fa-search" aria-hidden="true"></i></button>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="SalesCode" class="col-sm-3 col-form-label">No. Doc<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-9">
                        <input id="SalesCode" name="SalesCode" type="text" class="form-control form-control-sm" value="" readonly>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="SalesDate" class="col-sm-3 col-form-label">Tanggal<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-9">
                        <input id="SalesDate" name="SalesDate" type="text" class="form-control form-control-sm" value="">
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="MsEmpId" class="col-sm-3 col-form-label">Admin</label>
                     <div class="col-sm-9">
                        <select class="custom-select custom-select-sm form-control form-control-sm select-modal" id="MsEmpId" name="MsEmpId" style="width:100%">
                           <?php
                           $db = $this->db->where("MsEmpIsActive=1")->get("TblMsEmployee")->result();
                           foreach ($db as $key) {
                              echo '<option value="' . $key->MsEmpId . '" data-kode="' . $key->MsEmpCode . '">' . $key->MsEmpCode . ' - ' . $key->MsEmpName . '</option>';
                           }
                           ?>
                        </select>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="MsWorkplaceId" class="col-sm-3 col-form-label">Toko</label>
                     <div class="col-sm-9">
                        <select class="custom-select custom-select-sm form-control form-control-sm select-modal" id="MsWorkplaceId" name="MsWorkplaceId" style="width:100%">
                           <?php
                           $db = $this->db->where("MsWorkplaceIsActive=1")->get("TblMsWorkplace")->result();
                           foreach ($db as $key) {
                              echo '<option value="' . $key->MsWorkplaceId . '" data-template="' . $key->MsWorkplaceTemplate . '">' . $key->MsWorkplaceCode . '</option>';
                           }
                           ?>
                        </select>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center promo d-none">
                     <input id="PromoCode" name="PromoCode" type="text" class="form-control form-control-sm d-none" value="" readonly>
                     <div class="col-sm-9 offset-sm-3">
                        <div class="alert alert-success" role="alert">
                           <span class="fw-bold"><i class="fas fa-percent pe-2"></i>Promo Tiba Tiba 50 Ribu</span><br>
                           <span style="font-size:0.85rem">Periode 18 November 2022 - 30 November 2022</span><br>
                           <span class="info-box" style="font-size:0.85rem" onclick="showpromo()"><i class="fas fa-info-circle pe-1" ></i>Info Selengkapnya</span><br>
                        </div>
                     </div>
                     <script>
                        showpromo = function(){
                           Swal.fire({ 
                              html: `
                                       <span><b>Syarat & Ketentuan</b></span>
                                       <div style="text-align:start">
                                          <ul class="list-group list-group-flush" style="font-size: 0.85rem;padding-top: 0.5rem">
                                             <li class="list-group-item">Pembelian roster minimal 2 meter diskon 50 ribu, berlaku kelipatan</li>
                                             <li class="list-group-item">Pembelian bata tempel minimal 5 meter diskon 50 ribu, berlaku kelipatan</li>
                                             <li class="list-group-item">Berlaku 18 November - 30 November 2022</li>
                                             <li class="list-group-item">Berlaku untuk all type Roster & Bata Tempel</li>
                                             <li class="list-group-item">Tujuannya untuk meningkatkan penjualan bulan November, memenuhi kebutuhan customer dengan quantity kecil</li>
                                          </ul>  
                                       </div>`,
                              allowOutsideClick: () => {
                                 const popup = Swal.getPopup()
                                 popup.classList.remove('swal2-show')
                                 setTimeout(() => {
                                    popup.classList.add('animate__animated', 'animate__headShake')
                                 })
                                 setTimeout(() => {
                                    popup.classList.remove('animate__animated', 'animate__headShake')
                                 }, 500)
                                 return false
                              }
                           })
                        }
                     </script>
                  </div>


                   <!-- Pelanggan -->
                  <div class="row mb-1 align-items-center">
                     <div class="label-border-right">
                        <span class="label-dialog">Pelanggan</span>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="MsCustomerId" class="col-sm-3 col-form-label">Pelanggan<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-9">
                        <div class="input-group">
                           <select class="custom-select custom-select-sm form-select form-select-sm" id="MsCustomerId" name="MsCustomerId" style="width:90%;"></select>
                           <button class="btn btn-success btn-sm" id="create-new-customer" type="button"><i class="fas fa-plus" aria-hidden="true"></i></button>
                        </div>
                     </div>
                  </div>
                  <div class="row mb-1 ">
                     <label for="Pelanggan" class="col-sm-3 col-form-label">Detail</label>
                     <div class="col-sm-9 p-0">
                        <div class="row m-1">
                           <div class="col-12" id="detail-customer">
                              -
                           </div>
                        </div>
                     </div>
                  </div>

                   <!-- Pengiriman -->
                  <div class="row mb-1 align-items-center">
                     <div class="label-border-right">
                        <span class="label-dialog">Pengiriman / Delivery</span>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="MsDeliveryIsActive" class="col-sm-3 col-form-label">Pengiriman</label>
                     <div class="col-sm-9">
                        <div class="form-check form-switch">
                           <input id="MsDeliveryIsActive" name="MsDeliveryIsActive" class="form-check-input" type="checkbox" checked>
                        </div>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="MsDeliveryId" class="col-sm-3 col-form-label">Armada</label>
                     <div class="col-sm-9">
                        <div class="input-group">
                           <select class="custom-select custom-select-sm form-select form-select-sm" id="MsDeliveryId" name="MsDeliveryId" style="width:90%" disabled>';
                              <?php
                              $db = $this->db->where("MsDeliveryIsActive=1")->get("TblMsDelivery")->result();
                              foreach ($db as $key) {
                                 echo '<option value="' . $key->MsDeliveryId . '" data-kode="' . $key->MsDeliveryName . '">' . $key->MsDeliveryName . '</option>';
                              }
                              ?>
                           </select>
                           <button class="btn btn-success btn-sm" id="create-new-armada" type="button" disabled><i class="fas fa-plus" aria-hidden="true"></i></button>
                        </div>
                     </div>
                  </div>
                  <div class="row mb-1 ">
                     <label for="Pelanggan" class="col-sm-3 col-form-label">Penerima</label>
                     <div class="col-sm-9 p-0">
                        <div class="row m-1">
                           <div class="col-12" id="detail-delivery">
                              -
                           </div>
                        </div>
                     </div>
                  </div>
               </div>  
               <div class="col-lg-6 col-11 my-1">
                  <div class="row justify-content-center">
                     <div class="col-lg-12 col-11 my-1">
                        <div class="row justify-content-center">
                           <div class="col-12">
                              <div class="row mb-1 align-items-center">
                                 <div class="label-border-right mb-3" style="position:relative">
                                    <span class="label-dialog">Detail Item</span>
                                    <button class="btn btn-success btn-sm py-1 me-1 rounded-pill" id="add-item" type="button" style="position:absolute;top: -11px;right: -5px;font-size: 0.6rem;">
                                       <i class="fas fa-plus" aria-hidden="true"></i>
                                       <span class="fw-bold">
                                          &nbsp;Tambah
                                       </span>
                                    </button>
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
                                          </tr>
                                       </thead>
                                    </table>
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
                                    <span class="label-dialog">Optional Item</span>
                                    <button class="btn btn-success btn-sm py-1 me-1 rounded-pill" id="add-optional" type="button" style="position:absolute;top: -11px;right: -5px;font-size: 0.6rem;">
                                       <i class="fas fa-plus" aria-hidden="true"></i>
                                       <span class="fw-bold">
                                          &nbsp;Tambah
                                       </span>
                                    </button>
                                 </div>
                              </div>
                           </div>
                           <div class="col-12">
                              <div class="card " style="min-height:100px;">
                                 <div class="card-body p-2 ">
                                    <table id="tb_data_optional" class="table table-hover align-middle responsive" style='font-family:"Sans-serif", Helvetica; font-size:80%;width:100%'>
                                       <thead class="thead-dark" style="display:none;">
                                          <tr>
                                             <th>html</th>
                                             <th>Deskriksi</th>
                                             <th>total</th>
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
               <div class="col-lg-12">
                  <div class="row mb-1 align-items-center">
                     <div class="label-border-right">
                        <span class="label-dialog">Total Transaksi</span>
                     </div>
                  </div>
                  <div class="row justify-content-center mx-2 mt-2 p-2 shadow-sm card-delivery select rounded " style="position:relative">
                     <div class="col-lg-6">
                        <div class="row mb-1 align-items-center">
                           <label for="SalesSubTotal" class="col-sm-4 col-form-label">Sub Total</label>
                           <div class="col-sm-8">
                              <input id="SalesSubTotal" name="SalesSubTotal" type="text" class="form-control form-control-sm price-modal text-end" value="0" readonly>
                           </div>
                        </div>
                        <div class="row mb-1 align-items-center">
                           <label for="SalesDeliveryTotal" class="col-sm-4 col-form-label">Pengiriman</label>
                           <div class="col-sm-8">
                              <input id="SalesDeliveryTotal" name="SalesDeliveryTotal" type="text" class="form-control form-control-sm price-modal text-end" value="0" readonly>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="row mb-1 align-items-center">
                           <label for="SalesDiscTotal" class="col-sm-4 col-form-label">Diskon Global</label>
                           <div class="col-sm-8">
                              <input id="SalesDiscTotal" name="SalesDiscTotal" type="text" class="form-control form-control-sm price-modal text-end" value="0">
                           </div>
                        </div>
                        <div class="row mb-1 align-items-center">
                           <label for="SalesGrandTotal" class="col-sm-4 col-form-label">Grand Total</label>
                           <div class="col-sm-8">
                              <input id="SalesGrandTotal" name="SalesGrandTotal" type="text" class="form-control form-control-sm price-modal text-end" value="0" readonly>
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
<div id="dialog-item-master">
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
</div>

<div class="modal fade " id="modal-action-quotation" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-lg ">
      <div class="modal-content" name="form-action-armada">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-search text-primary" aria-hidden="true"></i> &nbsp;List Quotation</h5>
               <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="row mb-1 align-items-center">
               <label for="search-data-quotation" class="col-form-label">Pencarian<sup class="error">&nbsp;*</sup></label>
               <div class="col">
                  <input id="search-data-quotation" name="search-data-quotation" type="text" class="form-control form-control-sm" value="" placeholder="cari nama customer/no quotation/nama item">
               </div>
            </div>

            <table id="tb_data_quotation" class="table table-hover align-middle responsive" style='font-family:"Sans-serif", Helvetica; font-size:80%;width:100%'>
               <thead class="thead-dark" style="display:none;">
                  <tr>
                     <th>html</th>
                     <th>MsItemId</th>
                  </tr>
               </thead>
            </table>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
         </div>
      </div>
   </div>
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
                              $("#QuoDeliveryService").select2("open");
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
<script>
   var data_item = [];
   var tbl_item;
   var data_optional = [];
   var tbl_optional;
   var req_status_add = 0;
   var del_address = [];
   var del_id = -1;
   var datestart = moment(); 
   
   var numberitem=0;
   var number_uniq = 0;

   set_del_id = function(i, j) {
      del_id = i;
   }

   /* -------------------------------------------------------  SET FORM MODAL  ----------------------------------------------- 
   function next_kode() {
      if (typeof window.ajaxRequestSingle !== "undefined") {
         window.ajaxRequestSingle.abort();
      }

      window.ajaxRequestSingle = $.ajax({
         method: "POST",
         url: "<?= site_url("function/client_data_sales/get_next_sales") ?>",
         data: {
            "MsWorkplaceId": $("#MsWorkplaceId").val(),
            "MsEmpId": $("#MsEmpId").val(),
            "SalesDate": moment().format('DD/MM/YYYY')
         },
         success: function(data) {
            $("#SalesCode").val(data)
         }
      });
   } */
   /*  ARRAY SELECT */
   var selectArrays = Array.from(document.getElementsByClassName("select-modal"));
   selectArrays.forEach(function(SelectArray) {
      $(SelectArray).select2({
         dropdownParent: $("#modal-action .modal-content")
      });
   });

   /*  ARRAY DOUBLE */
   var doubleinputs = Array.from(document.getElementsByClassName("double-modal"));
   doubleinputs.forEach(function(doubleinput) {
      new Cleave(doubleinput, {
         numeral: true,
         numeralDecimalMark: ".",
         delimiter: ","
      })
   });

   /*  ARRAY PRICE */
   var priceinputs = Array.from(document.getElementsByClassName("price-modal"));
   priceinputs.forEach(function(priceinput) {
      new Cleave(priceinput, {
         numeral: true,
         delimiter: ",",
         numeralDecimalScale: 0,
         numeralThousandsGroupStyle: "thousand"
      })
   });
   /* -------------------------------------------------------  SET FORM MODAL  ----------------------------------------------- */


   /* -------------------------------------------------------  BAGIAN DOKUMEN  ----------------------------------------------- */
   /*  TANGGAL DOKUMENT */
   $("#SalesDate").daterangepicker({
      singleDatePicker: true,
      startDate: datestart,
      showDropdowns: true,
      locale: {
         "format": "DD/MM/YYYY",
         "customRangeLabel": "Pilih Tanggal Sendiri",
      }
   }, function(start, end) {
      datestart = start;
   });

   /*  SET AUTO CODE ON CHANGE */
   $("#MsEmpId").on("change.select2", function(e) {
      var data = ($(this).select2("data"))[0]["element"];
      //console.log($(data).data("kode"));
     // next_kode();
   });
   $("#MsWorkplaceId").on("change.select2", function(e) {
      var data = ($(this).select2("data"))[0]["element"];
      var id = $(data).data("template");
      $("input[name=Salesheader]").removeAttr("checked");
      $("input[name=Salesheader][value=" + id + "]").attr("checked", "checked");
     // next_kode();
   });
   $("#action-quotation").click(function() {
      $("#modal-action-quotation").modal("show");
      $("#modal-action").modal("hide");
   })

   $("#modal-action-quotation").on("hidden.bs.modal", function() {
      $("#modal-action").modal("show");
   });
   var table_quo = $('#tb_data_quotation').DataTable({
      "responsive": true,
      "searching": false,
      "lengthChange": false,
      "pageLength": parseInt($('#tb_row').data("value")),
      "processing": false,
      "serverSide": true,
      "ajax": {
         "url": "<?php echo site_url('function/client_datatable_sales/get_data_quotation') ?>",
         "type": "POST",
         "beforeSend": function() {
            if (table_quo && table_quo.hasOwnProperty('settings')) {
               table_quo.settings()[0].jqXHR.abort();
            }
         },
         "data": function(data) {
            data.search['value'] = $('#search-data-quotation').val();
            data.search['status'] = "0";
            data.search['colstatus'] = "QuoStatus";
            data.search['mode'] = "select";
         },
      },
      "order": [],
      "columnDefs": [{
         "targets": [1],
         "visible": false,
      }, ],
      "createdRow": function(row, data, dataIndex) {
         $(row).addClass("tb-sales");
      },
      "language": {
         "emptyTable": '<img src="<?= base_url("asset/image/mgs-erp/iconnotfound.png") ?>" class="rounded mx-auto d-block" width="300px">',
         "zeroRecords": '<img src="<?= base_url("asset/image/mgs-erp/iconnotfound.png") ?>" class="rounded mx-auto d-block" width="300px">',
      }

   });

   $('#search-data-quotation').keyup(function() {
      table_quo.ajax.reload(null, false).responsive.recalc().columns.adjust();
   })
   
   quo_select = function(id) {
      $("#modal-action-quotation").modal("hide");
      $("#modal-action").modal("show");

      $.ajax({
         method: "POST",
         dataType: "json",
         url: "<?= site_url("function/client_data_sales/get_data_quotation/") ?>" + id,
         success: function(data) {
            console.log(data);
            $("#SalesRef").val(data["header"]["QuoCode"]);
            $("#remove-quotation").show();
            del_id = data["header"]["MsCustomerDeliveryId"];
            load_data_table(data["header"]["MsCustomerId"]);
            $("#MsDeliveryIsActive").attr("checked", data["header"]["QuoDelStatus"]);
            $("#MsDeliveryId").val(data["header"]["QuoDelService"]).trigger("change");
            $("#MsWorkplaceId").val(data["header"]["MsWorkplaceId"]).trigger("change");
            $("#SalesDeliveryTotal").val(number_format(parseInt(data["header"]["QuoDeliveryTotal"])));
            $("#SalesDiscTotal").val(number_format(parseInt(data["header"]["QuoDiscTotal"])));
            $("#SalesGrandTotal").val(number_format(parseInt(data["header"]["QuoGrandTotal"])));
            $("#SalesSubTotal").val(number_format(parseInt(data["header"]["QuoSubTotal"])));


            $("input[name=Salesheader]").removeAttr("checked");
            $("input[name=Salesheader][value=" + data["header"]["QuoHeader"] + "]").attr("checked", "checked");
            var item_quo = data["detail"];
            data_item = [];
            var numberquo = 0;
            for (var i = 0; i < item_quo.length; i++) {  
               numberquo++;
               var numberindex = numberquo;
               var htmlItem = `<div class="row-table get-item action-table-single">
                  <div class="d-flex item-detail" style=" font-size: 1rem;">
                     <div class="flex-shrink-0">
                        <img width="75" height="75" class="rounded" src="asset/image/mgs-erp/defaultitem.png" style="object-fit: cover;">
                     </div> 
                     <div class="flex-grow-1 ms-3 d-flex flex-column ps-2">
                        <span class="fw-bold">${item_quo[i].MsItemCode}-${item_quo[i].MsItemName}(${item_quo[i].MsVendorCode})</span>
                        <span class="fw-bold" style="font-size:0.85rem"><span name="price">Rp. ${number_format(parseInt(item_quo[i].MsItemPrice))}/<sup style="color:gray;">${item_quo[i].MsItemUoM}</sup></span>&nbsp;|&nbsp;<span class="${(item_quo[i].InvStockBuffer > item_quo[i].InvStockQty ? "text-danger" : "text-success")}" > stock : ${item_quo[i].InvStockQty}</span></span>
                        <span class="fw-bold" style="font-size:0.7rem;display:none" name="displayprice">Rp. 160,000/<sup style="color:gray;">${item_quo[i].MsItemUoM}</sup></span>
                        <span  style="color:gray;font-size:0.6rem">${item_quo[i].MsItemCatName}&nbsp;|&nbsp;${item_quo[i].MsItemSize}&nbsp;|&nbsp;${item_quo[i].MsItemPcsM2}</span>
                        <div class="action pt-2"> 
                           <div class="d-flex justify-content-between" style="font-size:0.85rem"> 
                              <div class="d-flex flex-column">
                                 <span class="text-muted">Tipe Diskon</span>
                                 <div class="">
                                    <div class="form-check form-check-inline pe-2" style="min-height:0px !important;margin-right:0;margin-bottom:0;">
                                       <input class="form-check-input" type="radio" name="SalesDetailDiscType2-${item_quo[i].MsItemId + item_quo[i].MsVendorCode}" id="${item_quo[i].MsItemId + item_quo[i].MsVendorCode + (numberindex +1)}" value="0" checked>
                                       <label class="form-check-label" for="${item_quo[i].MsItemId + item_quo[i].MsVendorCode  + (numberindex +1) }">Tidak Ada</label>
                                    </div>
                                    <div class="form-check form-check-inline pe-2" style="min-height:0px !important;margin-right:0;margin-bottom:0;">
                                       <input class="form-check-input" type="radio" name="SalesDetailDiscType2-${item_quo[i].MsItemId + item_quo[i].MsVendorCode}" id="${item_quo[i].MsItemId + item_quo[i].MsVendorCode + (numberindex +2)}" value="1">
                                       <label class="form-check-label" for="${item_quo[i].MsItemId + item_quo[i].MsVendorCode  + (numberindex +2)}">By Item</label>
                                    </div>
                                    <div class="form-check form-check-inline pe-2" style="min-height:0px !important;margin-right:0;margin-bottom:0;">
                                       <input class="form-check-input" type="radio" name="SalesDetailDiscType2-${item_quo[i].MsItemId + item_quo[i].MsVendorCode}" id="${item_quo[i].MsItemId + item_quo[i].MsVendorCode + (numberindex +3)}" value="2">
                                       <label class="form-check-label" for="${item_quo[i].MsItemId + item_quo[i].MsVendorCode  + (numberindex +3)}">By Total</label>
                                    </div> 
                                 </div> 
                                 <div class="pt-2 align-items-center form-disc-item-${item_quo[i].MsItemId + item_quo[i].MsVendorCode}" style="display:none"> 
                                    <div class="form-check form-check-inline pe-2" style="min-height:0px !important;margin-right:0;margin-bottom:0;">
                                       <input class="form-check-input" type="radio" name="SalesDetailDiscType-${item_quo[i].MsItemId + item_quo[i].MsVendorCode}"  id="${item_quo[i].MsItemId + item_quo[i].MsVendorCode + (numberindex +4)}" value="0" checked>
                                       <label class="form-check-label" for="${item_quo[i].MsItemId + item_quo[i].MsVendorCode+ (numberindex +4)}">Rp.</label>
                                    </div>
                                    <input type="text" class="input-in-table double me-2" name="SalesDetailDisc" style="width:100px" for="${item_quo[i].MsItemId + item_quo[i].MsVendorCode+ (numberindex +4)}" value=""/>
                                    <div class="form-check form-check-inline pe-2" style="min-height:0px !important;margin-right:0;margin-bottom:0;">
                                       <input class="form-check-input" type="radio" name="SalesDetailDiscType-${item_quo[i].MsItemId + item_quo[i].MsVendorCode}"  id="${item_quo[i].MsItemId + item_quo[i].MsVendorCode + (numberindex +5)}" value="1">
                                       <label class="form-check-label" for="${item_quo[i].MsItemId + item_quo[i].MsVendorCode+ (numberindex +5)}" >%</label>
                                    </div> 
                                    <input type="text" class="input-in-table double " name="SalesDetailDiscPercen" style="width:40px" for="${item_quo[i].MsItemId + item_quo[i].MsVendorCode+ (numberindex +5)}" value=""/>
                                 </div>
                                 <div class="pt-2 align-items-center form-disc-total-${item_quo[i].MsItemId + item_quo[i].MsVendorCode}" style="display:none"> 
                                    <div class="form-check form-check-inline pe-2" style="min-height:0px !important;margin-right:0;margin-bottom:0;">
                                       <input class="form-check-input" type="radio" name="SalesDetailDiscType3-${item_quo[i].MsItemId + item_quo[i].MsVendorCode}"  id="${item_quo[i].MsItemId + item_quo[i].MsVendorCode + (numberindex +4)}" value="0" checked>
                                       <label class="form-check-label" for="${item_quo[i].MsItemId + item_quo[i].MsVendorCode+ (numberindex +4)}">Rp.</label>
                                    </div>
                                    <input type="text" class="input-in-table double me-2" name="SalesDetailDisc2" style="width:100px" for="${item_quo[i].MsItemId + item_quo[i].MsVendorCode+ (numberindex +4)}" value=""/>
                                    <div class="form-check form-check-inline pe-2" style="min-height:0px !important;margin-right:0;margin-bottom:0;">
                                       <input class="form-check-input" type="radio" name="SalesDetailDiscType3-${item_quo[i].MsItemId + item_quo[i].MsVendorCode}"  id="${item_quo[i].MsItemId + item_quo[i].MsVendorCode + (numberindex +5)}" value="1">
                                       <label class="form-check-label" for="${item_quo[i].MsItemId + item_quo[i].MsVendorCode+ (numberindex +5)}" >%</label>
                                    </div> 
                                    <input type="text" class="input-in-table double " name="SalesDetailDiscPercen2" style="width:40px" for="${item_quo[i].MsItemId + item_quo[i].MsVendorCode+ (numberindex +5)}" value=""/>
                                 </div>
                              </div>     
                              <div class="d-flex flex-column">
                                 <span  style="color:gray;">Qty&nbsp;(${item_quo[i].MsItemUoM})</span>
                                 <input type="text" class="input-in-table double" name="SalesDetailQty" value=""/>
                              </div>
                           </div>  
                           <div class="d-flex justify-content-end pt-2">
                              <span style="font-size:0.85rem">Total</span>
                              <span class="ps-2" style="font-size:1rem;font-weight:bold">Rp. <span id="SalesDetailTotal-${item_quo[i].MsItemId + item_quo[i].MsVendorCode}"></span></span>
                           </div>
                        </div> 
                     </div>
                  </div>  
                  <a onclick="hapus_item_click(${item_quo[i].MsItemId},\'${item_quo[i].MsVendorCode}\')" class="text-danger pointer" title="Hapus Item"><i class="fas fa-trash-alt fa-lg pe-2"></i>Hapus</a>
               </div>`;
               numberquo = numberquo + 5;
               var arr = [];
               arr["html"] = htmlItem;
               arr["itemid"] = item_quo[i]["MsItemId"];
               arr["vendor"] = item_quo[i]["MsVendorCode"];
               arr["price"] = item_quo[i]["MsItemPrice"];
               arr["qty"] = item_quo[i]["QuoDetailQty"];
               arr["discitemprice"] = item_quo[i]["QuoDetailDisc"];
               arr["uom"] = item_quo[i]["MsItemUoM"];
               arr["pricetotal"] = item_quo[i]["QuoDetailTotal"];
               arr["typepo"] = 1;
               arr["cogs"] = item_quo[i]["MsCogsTotal"];
               arr["discitempersen"] = 0;
               arr["discitemtype"] = 0; //disc type RP % dari item
               arr["disctype"] = 0; //0=none 1=item 2=total
               arr["disctotalprice"] = 0;
               arr["disctotalpersen"] = 0; 
               arr["disctotaltype"] = 0; //disc type RP % dari Total 
               data_item.push(arr); 

               tbl_item.ajax.reload();
            }

            var optional_quo = data["optional"];
            data_optional = [];
            for (var i = 0; i < optional_quo.length; i++) {
               var htmlItem = ' <div class="row row-table get-optional">';
               htmlItem += '    <div class="col-8 pe-0" >';
               htmlItem += '       <div class="d-flex flex-column">';
               htmlItem += '          <span  style="color:gray;">Deskripsi</span>';
               htmlItem += '          <input name="SalesOptionalDesc" type="text" class="form-control form-control-sm input-in-table" value="' + optional_quo[i]["QuoOptionalDesc"] + '" style="width:auto">';
               htmlItem += '       </div>';
               htmlItem += '    </div>';
               htmlItem += '   <div class="col-3 ps-1 pe-0" >';
               htmlItem += '       <div class="d-flex flex-column">';
               htmlItem += '          <span  style="color:gray;">Total</span>';
               htmlItem += '          <input name="SalesOptionalTotal" type="text" class="form-control form-control-sm input-in-table price-option" value="' + optional_quo[i]["QuoOptionalPrice"] + '"  style="width:auto">';
               htmlItem += '       </div>';
               htmlItem += '   </div>';
               htmlItem += '   <div class="col-auto px-0 align-self-end ms-auto action-table-single-optional">';
               htmlItem += '       <a class="text-danger pointer " title="Hapus Item"><i class="fas fa-trash-alt fa-lg"></i></a>';
               htmlItem += '   </div>';
               htmlItem += ' </div>';

               data_optional.push([htmlItem, optional_quo[i]["QuoOptionalDesc"], optional_quo[i]["QuoOptionalPrice"]]);
               tbl_optional.ajax.reload();
            }
            total_sales();
         }
      });
   }
   $("#remove-quotation").click(function() {
      $("#SalesRef").val("");
      $("#remove-quotation").hide();
   })

   /* -------------------------------------------------------   END DOKUMEN    ----------------------------------------------- */


   /* ------------------------------------------------------  BAGIAN PELANGGAN  ---------------------------------------------- */
   $("#MsCustomerId").select2({
      placeholder: "Cari nama pelanggan",
      dropdownParent: $("#modal-action .modal-content"),
      ajax: {
         dataType: "json",
         url: "<?= site_url("function/client_data_sales/get_data_customer") ?>",
         delay: 800,
         data: function(params) {
            return {
               search: params.term,
               page: params.page || 1,
            }
         },
         processResults: function(data, params) {
            params.page = params.page || 1;
            return {
               results: data.results,
               pagination: {
                  more: (params.page * 10) < data.count_filtered
               }
            };
         }
      },
      escapeMarkup: function(m) {
         return m;
      },
      templateResult: function template(data) {
         if ($(data.html).length === 0) {
            return data.text;
         }
         return $(data.html);
      },
      templateSelection: function templateSelect(data) {
         if ($(data.html).length === 0) {
            return data.text;
         }
         return data['text'];
      }
   });
   $("#MsCustomerId").on("select2:select", function(e) {
      var data = e.params.data;
      var htmlCustomer = '<div class="card shadow-sm card-delivery select">';
      htmlCustomer += '   <div class="p-2 ps-4">';
      htmlCustomer += '      <span class="card-title fw-bold">' + data.customer + '</span><br>';
      htmlCustomer += '      <span class="card-text">' + data.telp + '</span><br>';
      htmlCustomer += '      <span class="card-text">' + data.Address + '</span><br>';
      htmlCustomer += '   </div>';
      htmlCustomer += '   <div class="d-flex flex-row ms-4 my-1 ">';
      htmlCustomer += '      <a class="action-label" onclick="customer_edit(' + data.MsCustomerId + ')">Ubah</a>';
      htmlCustomer += '   </div>';
      htmlCustomer += '</div>';
      $("#detail-customer").html(htmlCustomer);
      del_id = -1;

      get_data_delivery(data.MsCustomerId);

   });
   $("#create-new-customer").click(function() {
      if (typeof window.ajaxRequestSingle !== "undefined") {
         window.ajaxRequestSingle.abort();
      }

      window.ajaxRequestSingle = $.ajax({
         method: "POST",
         url: "<?= site_url("message/message_master/data_customer_add") ?>",
         success: function(data) {
            $("#dialog-customer").html(data);
            $("#modal-action").modal("hide");
            $("#modal-action-customer").modal("show");
            $("#modal-action-customer").on("hidden.bs.modal", function() {
               if (get_mode() == "action customer") {
                  $("#modal-action").modal("show");
                  $("#dialog-customer").html("");
               }
            });
         }
      });
   });

   customer_edit = function(id) {
      if (typeof window.ajaxRequestSingle !== "undefined") {
         window.ajaxRequestSingle.abort();
      }

      window.ajaxRequestSingle = $.ajax({
         method: "POST",
         url: "<?= site_url("message/message_master/data_customer_edit/") ?>" + id,
         success: function(data) {
            $("#dialog-customer").html(data);
            $("#modal-action").modal("hide");
            $("#modal-action-customer").modal("show");
            $("#modal-action-customer").on("hidden.bs.modal", function() {
               if (get_mode() == "action customer") {
                  $("#modal-action").modal("show");
               }
            });
         }
      });
   };

   load_data_table = function(id = false) {
      if (!id) {
         $("#modal-action-customer").modal("hide");
         del_id = 0;
         $.ajax({
            method: "POST",
            dataType: "json",
            url: "<?= site_url("function/client_data_sales/get_max_customer") ?>",
            success: function(data) {
               get_data_delivery(data.MsCustomerId);
               var selectcustomer = $("#MsCustomerId");
               var option = new Option(data.customer, data.id, true, true);
               selectcustomer.append(option).trigger("change");
               selectcustomer.trigger({
                  type: "select2:select",
                  params: {
                     data: data
                  }
               });
            }
         });
      } else {
         $("#modal-action-customer").modal("hide");
         $.ajax({
            method: "POST",
            dataType: "json",
            url: "<?= site_url("function/client_data_sales/get_max_customer/") ?>" + id,
            success: function(data) {
               get_data_delivery(data.MsCustomerId);
               var selectcustomer = $("#MsCustomerId");
               var option = new Option(data.customer, data.id, true, true);
               selectcustomer.append(option).trigger("change");
               selectcustomer.trigger({
                  type: "select2:select",
                  params: {
                     data: data
                  }
               });
            }
         });
      }
   }
   /* ------------------------------------------------------    END PELANGGAN    ---------------------------------------------- */


   /* -------------------------------------------------     BAGIAN TOTAL TRANSAKSI     ---------------------------------------- */
   var subtotalitem = 0;
   var subtotaloptional = 0;

   function changenull(thiss) {
      if (isNaN(thiss)) {
         return 0;
      } else {
         return thiss;
      }
   }
   total_sales = function() {
      var subtotal = parseInt(subtotalitem + subtotaloptional);
      var disc = changenull(parseInt($("#SalesDiscTotal").val().replaceAll(",", "")));
      var delivery = changenull(parseInt($("#SalesDeliveryTotal").val().replaceAll(",", "")));
      var grandtotal = subtotal - disc + delivery;
      $("#SalesSubTotal").val(number_format(subtotal));
      $("#SalesGrandTotal").val(number_format(grandtotal));
   }

   $("#SalesDiscTotal, #SalesDeliveryTotal").keyup(function() {
      total_sales();
   });
   $("#SalesDiscTotal, #SalesDeliveryTotal").focusout(function() {
      if ($(this).val() == "") {
         $(this).val(0);
      }
   });
   /* ---------------------------------------------------    END TOTAL TRANSAKSI    -------------------------------------------- */


   /* ------------------------------------------------------     BAGIAN ITEM     ---------------------------------------------- */
   /* data_item (html,itemid,vendorcode,price,qty,disc,uom,total,stock,COGS) */


   var store = <?= JSON_ENCODE($store) ?>;
   tbl_item = $("#tb_data_item").DataTable({
      "searching": false,
      "ajax": function(data, callback, settings) {
         callback({
            data: data_item
         }) //reloads data 
      },
      "columnDefs": [
         { 
            "targets": [0],
            "data": "html",
         } 
      ],
      "lengthChange": false,
      "paging": false,
      "ordering": false,
      "autoWidth": true,
      "info": false
   });
   tbl_item.on("draw", function() { 
      $(".get-item").each(function(index, thisrow) { 

         /* EVENT VARIAN DAN STOCK ITEM */
         $(thisrow).find(".custom-select-item.variansales").each(function() { 
            for(var i = 0; i < data_item[index]["selected"].length ; i++){ 
               if($(this).data("header")==(data_item[index]["selected"][i].split(":"))[0]){
                  $(this).val((data_item[index]["selected"][i].split(":"))[1]);
                  break;
               }
            }
         });
         $(thisrow).find(".custom-select-item.variansales").change(function() {  
            var arr = []; 
            $(thisrow).find(`.custom-select-item.variansales`).each(function(){  
               arr.push($(this).data("header") + ":" + $(this).val());
            }); 
            for (var i = 0; data_item.length > i; i++) {
                  if ( i != index && data_item[i]["MsProdukId"] == data_item[index]["MsProdukId"] && (arr.diff(data_item[i]["selected"])).length == 0) {
                     Swal.fire({
                        icon: 'error',
                        text: 'Data Sudah Ada',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        timer: 1000
                     }); 

                     $(thisrow).find(".custom-select-item.variansales").each(function() { 
                        for(var i = 0; i < data_item[index]["selected"].length ; i++){ 
                           if($(this).data("header")==(data_item[index]["selected"][i].split(":"))[0]){
                              $(this).val((data_item[index]["selected"][i].split(":"))[1]);
                              break;
                           }
                        }
                     });
                     return false;
                  }
               }
            
            for(var i = 0; i < data_item[index]["detail"].length ; i++){ 
               var datavarian = data_item[index]["detail"][i]["MsProdukDetailVarian"].split("|");
               let defarr = arr.diff(datavarian);
               if(defarr.length==0){ 
                  $(thisrow).find(`span[name="uom"]`).each(function(){ 
                     $(this).html("/" +  data_item[index]["detail"][i]["SatuanName"]);
                  })
                  $(thisrow).find(`span[name="price"]`).each(function(){ 
                     $(this).html("Rp. " + number_format(parseInt(data_item[index]["detail"][i]["MsProdukDetailPrice"])));
                  })
                  data_item[index]["price"] = parseInt(data_item[index]["detail"][i]["MsProdukDetailPrice"]);
                  data_item[index]["uom"] = data_item[index]["detail"][i]["SatuanId"];
                  
               }
            }    
            data_item[index]["selected"] = arr;
            $(thisrow).find(".custom-select-item.stocksales").trigger("change");
         }).trigger("change"); 
         $(thisrow).find(".custom-select-item.stocksales").change(function() { 
            var arr = []; 
            var workplace = $(this).val();
            $(thisrow).find(`.custom-select-item.variansales`).each(function(){  
               arr.push($(this).data("header") + ":" + $(this).val());
            });  
            var count = 0;
            for(var i = 0; i < data_item[index]["stock"].length ; i++){ 
               var datavarian = data_item[index]["stock"][i]["MsProdukVarian"].split("|");
               let defarr = arr.diff(datavarian); 
               if(workplace == 0){ 
                     if(defarr.length==0 ){  
                        count += parseInt(data_item[index]["stock"][i]["MsProdukStockQty"]);
                     }
               }else{
                     if(defarr.length==0 && workplace == data_item[index]["stock"][i]["MsWorkplaceId"]){  
                        count += parseInt(data_item[index]["stock"][i]["MsProdukStockQty"]);
                     }
               }
            } 
            $(thisrow).find(`span[name="stock"]`).each(function(){ 
               $(this).html(number_format(count));
            });
         }).trigger("change");


         function total_item() { 
            if( data_item[index]["disctype"] == 0){
               var total = (data_item[index]["price"]) * data_item[index]["qty"];
            }else if( data_item[index]["disctype"] == 1){
               var total = (data_item[index]["price"]- data_item[index]["discitemprice"]) * data_item[index]["qty"];
            }else if( data_item[index]["disctype"] == 2){
               var total = (data_item[index]["price"] * data_item[index]["qty"]) - data_item[index]["disctotalprice"];
            } 

            $(thisrow).find('[name="pricetotal"]').text("Rp. " + number_format(total).toString());
            data_item[index]["pricetotal"] = total;
            if (parseInt(data_item[index]["discitemprice"]) > 0) {
               $(thisrow).find('.disconprice').show();
               $(thisrow).find('[name="displayprice"]').html("Rp. " + number_format(parseInt(data_item[index]["price"] - data_item[index]["discitemprice"])));
               $(thisrow).find('[name="price"]').addClass("strikethrough");
            } else { 
               $(thisrow).find('.disconprice').hide();
               $(thisrow).find('[name="price"]').removeClass("strikethrough");
            }
            total_item_sub();
         }
       

         var textdisc = $(thisrow).find('input[name="SalesDetailDisc"]').val(data_item[index]["discitemprice"]).keyup(function() {
            if (parseInt(this.value.replaceAll(",", "")) > data_item[index]["price"]) {
               data_item[index]["discitemprice"] = 0;
               this.value = 0;
            }
            data_item[index]["discitempersen"] =  this.value.replaceAll(",", "") / (data_item[index]["price"] / 100);
            data_item[index]["discitemprice"] = this.value.replaceAll(",", "");
            $(thisrow).find('input[name="SalesDetailDiscPercen"]').val(number_format(data_item[index]["discitempersen"],2));
            total_item();
         }).focusout(function() {  if (this.value == "" || this.value == "-")   $(this).val(0); });
          
         var textdisc2 = $(thisrow).find('input[name="SalesDetailDisc2"]').val(data_item[index]["disctotalprice"]).keyup(function() {
            if (parseInt(this.value.replaceAll(",", "")) > data_item[index]["pricetotal"]) {
               data_item[index]["disctotalprice"] = 0;
               this.value = 0;
            }
            data_item[index]["disctotalpersen"] =  this.value.replaceAll(",", "") / (data_item[index]["pricetotal"] / 100);
            data_item[index]["disctotalprice"] = this.value.replaceAll(",", "");
            $(thisrow).find('input[name="SalesDetailDiscPercen2"]').val(number_format(data_item[index]["disctotalpersen"],2));
            total_item();
         }).focusout(function() {
            if (this.value == "" || this.value == "-") {
               $(this).val(0);
            }
         });  


         var textdiscPercen = $(thisrow).find('input[name="SalesDetailDiscPercen"]').val(data_item[index]["discitempersen"]).keyup(function() {
            if (parseInt(this.value.replaceAll(",", "")) > 100) {
               data_item[index]["discitempersen"] = 0;
               this.value = 0;
            }
            data_item[index]["discitempersen"] = this.value.replaceAll(",", ""); 
            data_item[index]["discitemprice"] = data_item[index]["price"] / 100 * this.value.replaceAll(",", "");;
            $(thisrow).find('input[name="SalesDetailDisc"]').val(number_format(data_item[index]["discitemprice"]));
            total_item();
         }).focusout(function() { if (this.value == "" || this.value == "-")  $(this).val(0);  });


         var textdiscPercen2 = $(thisrow).find('input[name="SalesDetailDiscPercen2"]').val(data_item[index]["disctotalpersen"]).keyup(function() {
            if (parseInt(this.value.replaceAll(",", "")) > 100) {
               data_item[index]["disctotalpersen"] = 0;
               this.value = 0;
            }
            data_item[index]["disctotalpersen"] = this.value.replaceAll(",", ""); 
            data_item[index]["disctotalprice"] = data_item[index]["pricetotal"] / 100 * this.value.replaceAll(",", "");
            $(thisrow).find('input[name="SalesDetailDisc2"]').val(number_format(data_item[index]["disctotalprice"]));
            total_item();
         }).focusout(function() {
            if (this.value == "" || this.value == "-") {
               $(this).val(0);
            }
         }); 

      $(thisrow).find('input[type=radio][name=SalesDetailDiscType-'+ data_item[index]["MsProdukId"] +data_item[index]["generate"] +']').change(function() { 
         if (this.value == '0') {
            $(textdisc).prop("disabled",false);
            $(textdiscPercen).prop("disabled",true);
         }
         else if (this.value == '1') {
            $(textdisc).prop("disabled",true);
            $(textdiscPercen).prop("disabled",false);
         }
         data_item[index]["discitemtype"] = this.value;
      });

      $(thisrow).find('input[type=radio][name=SalesDetailDiscType3-'+ data_item[index]["MsProdukId"] +data_item[index]["generate"] +']').change(function() { 
         if (this.value == '0') {
            $(textdisc2).prop("disabled",false);
            $(textdiscPercen2).prop("disabled",true);
         }
         else if (this.value == '1') {
            $(textdisc2).prop("disabled",true);
            $(textdiscPercen2).prop("disabled",false);
         }
         data_item[index]["disctotaltype"] = this.value;
      });
      
      $(thisrow).find('input[type=radio][name=SalesDetailDiscType2-'+ data_item[index]["MsProdukId"] +data_item[index]["generate"] +']').change(function() {
         if (this.value == '0') {
            $(textdisc).val("0").trigger("keyup"); 
            $(textdisc2).val("0").trigger("keyup"); 
            $('.form-disc-item-'+ data_item[index]["MsProdukId"] +data_item[index]["generate"]).hide(); 
            $('.form-disc-total-'+ data_item[index]["MsProdukId"] +data_item[index]["generate"]).hide(); 
         }
         else if (this.value == '1') {
            $('.form-disc-item-'+ data_item[index]["MsProdukId"] +data_item[index]["generate"]).show(); 
            $('.form-disc-total-'+ data_item[index]["MsProdukId"] +data_item[index]["generate"]).hide(); 
            $(textdisc2).val("0").trigger("keyup"); 
         }
         else if (this.value == '2') {
            $('.form-disc-item-'+ data_item[index]["MsProdukId"] +data_item[index]["generate"]).hide(); 
            $('.form-disc-total-'+ data_item[index]["MsProdukId"] +data_item[index]["generate"]).show(); 
            $(textdisc).val("0").trigger("keyup"); 
         }
         data_item[index]["disctype"] = this.value;
      });

      $(thisrow).find('input[type=radio][name=SalesDetailDiscType-'+ data_item[index]["MsProdukId"] +data_item[index]["generate"] +'][value='+ data_item[index]["discitemtype"] +']').prop("checked",true).trigger("change");
      $(thisrow).find('input[type=radio][name=SalesDetailDiscType2-'+ data_item[index]["MsProdukId"] +data_item[index]["generate"] +'][value='+ data_item[index]["disctype"] +']').prop("checked",true).trigger("change");
      $(thisrow).find('input[type=radio][name=SalesDetailDiscType3-'+ data_item[index]["MsProdukId"] +data_item[index]["generate"] +'][value='+ data_item[index]["disctotaltype"] +']').prop("checked",true).trigger("change");
         var numberpresed = 1;
         var textqty = $(thisrow).find('input[name="SalesDetailQty"]').val(data_item[index]["qty"]).keyup(function() { 
            data_item[index]["qty"] = this.value.replaceAll(",", ""); 
            // get_discon = 0;  
            // if(data_item[index]["category"] == "RWT" || data_item[index]["category"] == "RED" || data_item[index]["category"] == "RSM"){
            //    get_discon = Math.floor(data_item[index]["qty"] / 50);
            // }
            // if(data_item[index]["category"] == "BTL"){
            //    get_discon = Math.floor(data_item[index]["qty"] / 5);
            // } 
            // if(get_discon > 0){  
            //    $(thisrow).find('input[type=radio][name=SalesDetailDiscType2-'+ data_item[index]["MsProdukId"] +data_item[index]["generate"] +'][value=2]').prop("checked",true).trigger("change");
            //    $(thisrow).find('input[type=radio][name=SalesDetailDiscType3-'+ data_item[index]["MsProdukId"] +data_item[index]["generate"] +'][value=0]').prop("checked",true).trigger("change");
            //    $(textdisc2).val(number_format(Math.floor(get_discon) * 50000).toString()).trigger("keyup");
            // }else{  
            //    $(thisrow).find('input[type=radio][name=SalesDetailDiscType2-'+ data_item[index]["MsProdukId"] +data_item[index]["generate"] +'][value=0]').prop("checked",true).trigger("change"); 
            //    $(textdisc2).val(0).trigger("keyup");
            // }
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
      
      $('.lazy').lazy({
         afterLoad: function(element){
            $(element).removeClass("skeleton");
         }
      });
   });
   $("#add-item").click(function() {
      
      if (typeof window.ajaxRequestSingle !== "undefined") {
         window.ajaxRequestSingle.abort();
      }

      window.ajaxRequestSingle = $.ajax({
         method: "POST",
         url: "<?= site_url("message/message_master/data_item_master_select") ?>",
         success: function(data) {
            $("#dialog-item-master").html(data);
            $("#modal-action").modal("hide");
            $("#modal-action-item").modal("show");
            $("#modal-action-item").on("hidden.bs.modal", function() {
               if (get_mode() == "action item") {
                  $("#modal-action").modal("show");
                  $("#dialog-item-master").html("");
               }
            });
            
            item_data_select = function(data){ 
               //try{
               for (var i = 0; data_item.length > i; i++) {
                  if (data_item[i]["MsProdukId"] == data.MsProdukId && (data_item[i]["selected"].diff(data.selected)).length == 0) {
                     Swal.fire({
                        icon: 'error',
                        text: 'Data Sudah Ada',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        timer: 1000
                     }); 
                     return false;
                  }
               }
               numberitem++;
               var numberindex = numberitem;
               var htmlItem = `<div class="row-table get-item action-table-single">
                     <div class="d-flex item-detail" style=" font-size: 1rem;">
                        <div class="flex-shrink-0">
                           <img class="lazy skeleton" data-src="${data.MsProdukImage}" style="width: 5rem;background: #f1f1f1;padding: 0.25rem;height: 5rem;object-fit: contain;"> 
                        </div> 
                        <div class="flex-grow-1 ms-3 d-flex flex-column ps-2">
                           <span class="fw-bold">${data.MsProdukCode}-${data.MsProdukName}</span> 
                           <span class="fw-bold" style="font-size:0.85rem"><span name="price">Rp. 0</span><span class="fs-8" style="color:gray;" name="uom">/Pcs</span>&nbsp;|&nbsp;<span> stock </span>
                           <select class="custom-select-item stocksales" id="${data.MsProdukId}store" data-index="${data.MsProdukId}" style="width:4rem">
                              <option value='0' selected>Semua</option>`; 
                              for(var j = 0;j < store.length;j++){
                                 htmlItem += `<option value='${store[j]["MsWorkplaceId"]}'>${store[j]["MsWorkplaceCode"]}</option>`;
                              }
                              htmlItem += ` 
                           </select>: <span name="stock">0</span></span>
                           <div class="disconprice" style="display:none;">
                              <span class="fw-bold" style="font-size:0.7rem;" name="displayprice">Rp. 160,000</span>
                              <span class="fs-8 fw-bold" style="color:gray;" name="uom">/Pcs</span>
                           </div>
                           <div class="flex">`;
               var varian = data.MsProdukVarian.split(";");
               for(var j = 0;j < varian.length;j++){
                  var varheader = varian[j].split(":");
                  htmlItem += ` 
                                       <select class="custom-select-item variansales" id="${data.MsProdukId}${varheader[0]}" data-index="${i}" data-header="${varheader[0]}" style="padding-right: 1.5rem;">`;
                  var vardetail = varheader[1].split("|");
                  for(var k = 0;k < vardetail.length;k++){
                     var selected = "";
                     for(var l = 0; l < data.selected.length;l++){
                        if(data.selected[l] == (varheader[0]+ ":" + vardetail[k])){
                           selected = "selected";
                           break; 
                        }
                     }
                     htmlItem += `<option value='${vardetail[k]}' ${selected}>${vardetail[k]}</option>`;  
                     
                  }
                  htmlItem += `</select>`;
                  if(j!=varian.length-1
                  ) htmlItem += `<span>|</span>`;
               }
               htmlItem += `</div> 
                           <div class="action pt-2"> 
                              <div class="d-flex justify-content-between" style="font-size:0.85rem"> 
                                 <div class="d-flex flex-column">
                                    <span class="text-muted">Tipe Diskon</span> 
                                    <div class="">
                                       <div class="form-check form-check-inline pe-2" style="min-height:0px !important;margin-right:0;margin-bottom:0;">
                                          <input class="form-check-input" type="radio" name="SalesDetailDiscType2-${data.MsProdukId + number_uniq}" id="${data.MsProdukId + number_uniq + (numberindex +1)}" value="0" checked>
                                          <label class="form-check-label" for="${data.MsProdukId + number_uniq  + (numberindex +1) }">Tidak Ada</label>
                                       </div>
                                       <div class="form-check form-check-inline pe-2" style="min-height:0px !important;margin-right:0;margin-bottom:0;">
                                          <input class="form-check-input" type="radio" name="SalesDetailDiscType2-${data.MsProdukId + number_uniq}" id="${data.MsProdukId + number_uniq + (numberindex +2)}" value="1">
                                          <label class="form-check-label" for="${data.MsProdukId + number_uniq  + (numberindex +2)}">By Item</label>
                                       </div>
                                       <div class="form-check form-check-inline pe-2" style="min-height:0px !important;margin-right:0;margin-bottom:0;">
                                          <input class="form-check-input" type="radio" name="SalesDetailDiscType2-${data.MsProdukId + number_uniq}" id="${data.MsProdukId + number_uniq + (numberindex +3)}" value="2">
                                          <label class="form-check-label" for="${data.MsProdukId + number_uniq  + (numberindex +3)}">By Total</label>
                                       </div> 
                                    </div> 
                                    <div class="pt-2 align-items-center form-disc-item-${data.MsProdukId + number_uniq}" style="display:none"> 
                                       <div class="form-check form-check-inline pe-2" style="min-height:0px !important;margin-right:0;margin-bottom:0;">
                                          <input class="form-check-input" type="radio" name="SalesDetailDiscType-${data.MsProdukId + number_uniq}"  id="${data.MsProdukId + number_uniq + (numberindex +4)}" value="0" checked>
                                          <label class="form-check-label" for="${data.MsProdukId + number_uniq+ (numberindex +4)}">Rp.</label>
                                       </div>
                                       <input type="text" class="input-in-table double me-2" name="SalesDetailDisc" style="width:100px" for="${data.MsProdukId + number_uniq+ (numberindex +4)}" value=""/>
                                       <div class="form-check form-check-inline pe-2" style="min-height:0px !important;margin-right:0;margin-bottom:0;">
                                          <input class="form-check-input" type="radio" name="SalesDetailDiscType-${data.MsProdukId + number_uniq}"  id="${data.MsProdukId + number_uniq + (numberindex +5)}" value="1">
                                          <label class="form-check-label" for="${data.MsProdukId + number_uniq+ (numberindex +5)}" >%</label>
                                       </div> 
                                       <input type="text" class="input-in-table double " name="SalesDetailDiscPercen" style="width:40px" for="${data.MsProdukId + number_uniq+ (numberindex +5)}" value=""/>
                                    </div>
                                    <div class="pt-2 align-items-center form-disc-total-${data.MsProdukId + number_uniq}" style="display:none"> 
                                       <div class="form-check form-check-inline pe-2" style="min-height:0px !important;margin-right:0;margin-bottom:0;">
                                          <input class="form-check-input" type="radio" name="SalesDetailDiscType3-${data.MsProdukId + number_uniq}"  id="${data.MsProdukId + number_uniq + (numberindex +4)}" value="0" checked>
                                          <label class="form-check-label" for="${data.MsProdukId + number_uniq+ (numberindex + 4)}">Rp.</label>
                                       </div>
                                       <input type="text" class="input-in-table double me-2" name="SalesDetailDisc2" style="width:100px" for="${data.MsProdukId + number_uniq+ (numberindex +4)}" value=""/>
                                       <div class="form-check form-check-inline pe-2" style="min-height:0px !important;margin-right:0;margin-bottom:0;">
                                          <input class="form-check-input" type="radio" name="SalesDetailDiscType3-${data.MsProdukId + number_uniq}"  id="${data.MsProdukId + number_uniq + (numberindex +5)}" value="1">
                                          <label class="form-check-label" for="${data.MsProdukId + number_uniq+ (numberindex + 5)}" >%</label>
                                       </div> 
                                       <input type="text" class="input-in-table double " name="SalesDetailDiscPercen2" style="width:40px" for="${data.MsProdukId + number_uniq+ (numberindex +5)}" value=""/>
                                    </div>
                                 </div>     
                                 <div class="d-flex flex-column">
                                    <span  style="color:gray;">Qty&nbsp;<span class="fs-8 fw-bold" style="color:gray;" name="uom">/Pcs</span></span>
                                    <input type="text" class="input-in-table double" name="SalesDetailQty" value=""/>
                                 </div>
                              </div>  
                              <div class="d-flex justify-content-end pt-2">
                                 <span style="font-size:0.85rem">Total</span>
                                 <span class="ps-2" style="font-size:1rem;font-weight:bold"><span name="pricetotal">Rp. 0</span></span>
                              </div>
                           </div> 
                           </div>
                     </div>  
                     <a onclick="hapus_item_click(${data.MsProdukId},\'${number_uniq}\')" class="text-danger pointer" title="Hapus Item"><i class="fas fa-trash-alt fa-lg pe-2"></i>Hapus</a>
                  </div>`;
               numberitem = numberitem + 5;  

               var arr = [];
               arr["html"] = htmlItem;
               arr["MsProdukId"] = data.MsProdukId;
               arr["selected"] = data.selected;
               arr["detail"] = data.MsProdukDetail;
               arr["stock"] = data.MsProdukStock;
               arr["price"] = 0;
               arr["qty"] = 1;
               arr["discitemprice"] = 0;
               arr["uom"] = "-";
               arr["pricetotal"] = 0;
               arr["typepo"] = 1;
               arr["cogs"] = 0;
               arr["discitempersen"] = 0;
               arr["discitemtype"] = 0; //disc type RP % dari item
               arr["disctype"] = 0; //0=none 1=item 2=total
               arr["disctotalprice"] = 0;
               arr["disctotalpersen"] = 0; 
               arr["disctotaltype"] = 0; //disc type RP % dari Total 
               arr["category"] = 0; //disc type RP % dari Total 
               arr["generate"] = number_uniq; //disc type RP % dari Total 
               data_item.push(arr);
               number_uniq++;
               $("#add-item").prop("disabled", false);
               tbl_item.ajax.reload(); 
               // }catch(err){
               //    console.log(err);
               // }

               $("#modal-action-item").modal("hide");
               $("#modal-action").modal("show");
            }
         }
      });
       
   });

   hapus_item_click = async function(MsProdukId, number_uniq) {
      for (var i = 0; data_item.length > i; i++) {
         if (data_item[i]["MsProdukId"] == MsProdukId && data_item[i]["generate"] == number_uniq) {
            var index = i;
            const swalWithBootstrapButtons = Swal.mixin({
               customClass: {
                  confirmButton: 'btn btn-success mx-1',
                  cancelButton: 'btn btn-secondary mx-1'
               },
               buttonsStyling: false
            });
            var data = await swalWithBootstrapButtons.fire({
               title: "Hapus Item!",
               html: "apakah anda yakin ingin menghapus Item ini!",
               icon: "warning",
               allowOutsideClick: false,
               allowEscapeKey: false,
               showCancelButton: true,
               confirmButtonText: "Lanjutkan",
               cancelButtonText: "Tidak",
               reverseButtons: false
            }).then((result) => {
               if (result.isConfirmed) {
                  data_item.splice(index, 1);
                  tbl_item.ajax.reload();
                  total_item_sub(); 
                  $("#add-item").prop("disabled", false);
                  return true; 
               }
            });
            return data;
         }
      }
   }
   total_item_sub = function() {
      subtotalitem = 0;
      for (var i = 0; data_item.length > i; i++) {
         subtotalitem += data_item[i]["pricetotal"];
      }
      total_sales();
   }

   /* ------------------------------------------------------       END ITEM      ---------------------------------------------- */


   /* ------------------------------------------------------     BAGIAN OPTIONAL     ---------------------------------------------- */
   /* data_optional (html,desc,total) */

   tbl_optional = $("#tb_data_optional").DataTable({
      "searching": false,
      "ajax": function(data, callback, settings) {
         callback({
            data: data_optional
         }) //reloads data 
      },
      "columnDefs": [{
         "targets": [1, 2],
         "visible": false,
      }, ],
      "lengthChange": false,
      "paging": false,
      "ordering": false,
      "autoWidth": true,
      "info": false
   });

   tbl_optional.on("draw", function() {
      function total_optional_sub() {
         subtotaloptional = 0;
         for (var i = 0; data_optional.length > i; i++) {
            subtotaloptional += parseInt(data_optional[i][2]);
         }
         total_sales();
      };


      $(".get-optional").each(function(index, thisrow) {
         $(thisrow).find('input[name="SalesOptionalDesc"]').val(data_optional[index][1]).keyup(function() {
            data_optional[index][1] = this.value;
            if (this.value == "") {
               $("#add-optional").prop("disabled", true);
            } else {
               $("#add-optional").prop("disabled", false);
            }
         })

         $(thisrow).find('input[name="SalesOptionalTotal"]').val(data_optional[index][2]).keyup(function() {
            data_optional[index][2] = this.value.replaceAll(",", "");
            total_optional_sub();
         })


         $(thisrow).find(".pointer").click(function() {
            const swalWithBootstrapButtons = Swal.mixin({
               customClass: {
                  confirmButton: 'btn btn-success mx-1',
                  cancelButton: 'btn btn-secondary mx-1'
               },
               buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
               title: "Hapus Optional!",
               html: "apakah anda yakin ingin menghapus optional ini!",
               icon: "warning",
               allowOutsideClick: false,
               allowEscapeKey: false,
               showCancelButton: true,
               confirmButtonText: "Lanjutkan",
               cancelButtonText: "Tidak",
               reverseButtons: false
            }).then((result) => {
               if (result.isConfirmed) {
                  data_optional.splice(index, 1);
                  tbl_optional.ajax.reload();
                  total_optional_sub();

                  $("#add-optional").prop("disabled", false);
               }
            })
         });


         var priceoptions = Array.from(document.getElementsByClassName("price-option"));
         priceoptions.forEach(function(priceoption) {
            new Cleave(priceoption, {
               numeral: true,
               delimiter: ",",
               numeralDecimalScale: 0,
               numeralThousandsGroupStyle: "thousand"
            })
         });
      });
      total_optional_sub();
   });

   $("#add-optional").click(function() {
      var htmlItem = ' <div class="row row-table get-optional">';
      htmlItem += '    <div class="col-8 pe-0" >';
      htmlItem += '       <div class="d-flex flex-column">';
      htmlItem += '          <span  style="color:gray;">Deskripsi</span>';
      htmlItem += '          <input name="SalesOptionalDesc" type="text" class="form-control form-control-sm input-in-table" value="" style="width:auto">';
      htmlItem += '       </div>';
      htmlItem += '    </div>';
      htmlItem += '   <div class="col-3 ps-1 pe-0" >';
      htmlItem += '       <div class="d-flex flex-column">';
      htmlItem += '          <span  style="color:gray;">Total</span>';
      htmlItem += '          <input name="SalesOptionalTotal" type="text" class="form-control form-control-sm input-in-table price-option" value="0"  style="width:auto">';
      htmlItem += '       </div>';
      htmlItem += '   </div>';
      htmlItem += '   <div class="col-auto px-0 align-self-end ms-auto action-table-single-optional">';
      htmlItem += '       <a class="text-danger pointer " title="Hapus Item"><i class="fas fa-trash-alt fa-lg"></i></a>';
      htmlItem += '   </div>';
      htmlItem += ' </div>';

      data_optional.push([htmlItem, "", 0]);
      $("#add-optional").prop("disabled", true);

      tbl_optional.ajax.reload();
   });


   /* ------------------------------------------------------       END Optional      ---------------------------------------------- */


   /* ------------------------------------------------------   BAGIAN DELIVERY   ---------------------------------------------- */
   $("#MsDeliveryIsActive").change(function() {
      if (this.checked) {
         $("#card-delivery").addClass("select");
         $("#MsDeliveryId").prop("disabled", false);
         $("#SalesDeliveryTotal").prop("readonly", false);
         $("#create-new-armada").prop("disabled", false);
         $(".card-delivery-action").css("display", "flex");
      } else {
         $("#card-delivery").removeClass("select");
         $("#MsDeliveryId").prop("disabled", true);
         $("#SalesDeliveryTotal").prop("readonly", true);
         $("#SalesDeliveryTotal").val("0");
         $("#create-new-armada").prop("disabled", true);
         $(".card-delivery-action").css("display", "none");
         $("#SalesDeliveryTotal").val(0);

      }
   });
   $("#create-new-armada").click(function() {
      $("#modal-action-armada").modal("show");
      $("#modal-action").modal("hide");
   });
   get_data_delivery = function(id) {
      $.ajax({
         method: "POST",
         dataType: "json",
         url: "<?= site_url("function/client_data_sales/get_del_customer/") ?>" + id,
         success: function(data) {
            del_address = data;
            load_data_delivery();
         }
      });
   }
   load_data_delivery = function() {
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
            htmldelivery += '  <div class="flex-row ms-4 card-delivery-action my-1 ">';
            htmldelivery += '      <a class="action-label" onclick="ubah_data_delivery(' + i + ')" >Ubah</a>';
            htmldelivery += '      <div class="action-space"></div>';
            htmldelivery += '      <a class="action-label" onclick="pilih_data_delivery(' + del_address[i]["MsCustomerDeliveryId"] + ')" >Pilih Alamat Lain / Tambah ALamat</a>';
            htmldelivery += '  </div>';
            htmldelivery += '</div>';
            $("#detail-delivery").html(htmldelivery);
            del_id = del_address[i]["MsCustomerDeliveryId"];
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
            htmldelivery += '  <div class="flex-row ms-4 card-delivery-action my-1 ">';
            htmldelivery += '      <a class="action-label" onclick="ubah_data_delivery(' + i + ')" >Ubah</a>';
            htmldelivery += '      <div class="action-space"></div>';
            htmldelivery += '      <a class="action-label" onclick="pilih_data_delivery(' + del_address[i]["MsCustomerDeliveryId"] + ')" >Pilih Alamat Lain / Tambah ALamat</a>';
            htmldelivery += '  </div>';
            htmldelivery += '</div>';
            $("#detail-delivery").html(htmldelivery);
         }
      }
      $("#MsDeliveryIsActive").trigger("change");
   }
   ubah_data_delivery = function(id) {
      if (typeof window.ajaxRequestSingle !== "undefined") {
         window.ajaxRequestSingle.abort();
      }

      window.ajaxRequestSingle = $.ajax({
         method: "POST",
         url: "<?= site_url("message/message_sales/data_delivery_edit/") ?>",
         success: function(data) {
            $("#dialog-customer").html(data);
            $("#modal-action").modal("hide");
            set_modal_action($("#modal-action"), del_address[id], 0);
            $("#modal-action").on("shown.bs.modal", function() {
               get_data_delivery($("#MsCustomerId").val());
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
         url: "<?= site_url("message/message_sales/data_delivery_select/") ?>" + $("#MsCustomerId").val(),
         success: function(data) {
            $("#dialog-customer").html(data);
            $("#modal-action").modal("hide");
            set_modal_select($("#modal-action"));
         }
      });
   }
   $("#modal-action-armada").on("hidden.bs.modal", function() {
      $("#modal-action").modal("show");
   });
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
   /* ------------------------------------------------------      END DELIVERY    ---------------------------------------------- */



   $("#MsEmpId").val("<?= $this->session->userdata("MsEmpId") ?>").trigger("change");
   $("#MsWorkplaceId").val("<?= $this->session->userdata("MsWorkplaceId") ?>").trigger("change");
   var data = <?= JSON_ENCODE($_sales) ?>;
   
   $("#btn-submit").click(async function() {

      if (!req_status_add) {
         $("#btn-submit").html('<i class="fas fa-circle-notch fa-spin"></i> Loading');
         /* -------------------------------------------------     VALID CUSTOMER     ----------------------------------------------*/
         if (!$("#MsCustomerId").val()) {
            Swal.fire({
               icon: 'error',
               text: 'Pilih pelanggan terlebih dahulu!!!',
               showConfirmButton: false,
               allowOutsideClick: false,
               allowEscapeKey: false,
               timer: 1500
            });
            $("#btn-submit").html("Simpan");
            return false;
         }

         /* -------------------------------------------------     CEK ITEM NULL    ----------------------------------------------*/
         if (data_item.length == 0) {
            Swal.fire({
               icon: 'error',
               text: 'Pilih item terlebih dahulu!!!',
               showConfirmButton: false,
               allowOutsideClick: false,
               allowEscapeKey: false,
               timer: 1500
            });
            $("#btn-submit").html("Simpan");
            return false;
         }

         /* -------------------------------------------------     CONFIRM ITEM    ----------------------------------------------*/

         for (var i = 0; data_item.length > i; i++) {
            if (data_item[i][1] == "-" && data_item[i][2] == "-") {
               const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                     confirmButton: 'btn btn-success mx-1',
                     cancelButton: 'btn btn-secondary mx-1'
                  },
                  buttonsStyling: false
               });
               var data = await swalWithBootstrapButtons.fire({
                  title: "Item tidak valid!",
                  html: 'data item ada yang belum lengkap!!!,ingin melengkapi data item tersebut?',
                  icon: "warning",
                  allowOutsideClick: false,
                  allowEscapeKey: false,
                  showCancelButton: true,
                  confirmButtonText: "Lanjutkan",
                  cancelButtonText: "Tidak",
                  reverseButtons: false
               }).then((result) => {
                  if (result.isConfirmed) {
                     return true
                  } else if (result.dismiss === Swal.DismissReason.cancel) {
                     return false;
                  }
               });
               console.log(data);
               if (data) {
                  $("#btn-submit").html("Simpan");
                  return;
               } else {
                  console.log("await hapus");
                  var datas = await hapus_item_click("-", "-", true);
                  console.log(datas);
                  if (!datas) {
                     $("#btn-submit").html("Simpan");
                     return;
                  }
               }
            }
         }

         /* -------------------------------------------------     CONFIRM OPTIONAL    ----------------------------------------------*/
         for (var i = 0; data_optional.length > i; i++) {
            if (data_optional[i][1] == "") {
               Swal.fire({
                  icon: 'error',
                  text: 'Data optional ada yang belum lengkap!!!',
                  showConfirmButton: false,
                  allowOutsideClick: false,
                  allowEscapeKey: false,
                  timer: 1500
               });
               $("#btn-submit").html("Simpan");
               return false;
            }
         }

         var dataheader = {
            "SalesHeader": $("input[name='Salesheader']:checked").val(),
            "SalesRef": $("#SalesRef").val(),
            "SalesCode": $("#SalesCode").val(), 
            "SalesDate": moment(datestart).format('YYYY-MM-DD'), 
            "MsEmpId": $("#MsEmpId").val(),
            "MsWorkplaceId": $("#MsWorkplaceId").val(),
            "MsCustomerId": $("#MsCustomerId").val(),
            "SalesDelStatus": ($("#MsDeliveryIsActive").prop("checked") == false ? "0" : "1"),
            "MsDeliveryId": $("#MsDeliveryId").val(),
            "MsCustomerDeliveryId": $("#MsCustomerDeliveryId").val(),
            "SalesSubTotal": parseInt($("#SalesSubTotal").val().replaceAll(",", "")),
            "SalesDiscTotal": parseInt($("#SalesDiscTotal").val().replaceAll(",", "")),
            "SalesDeliveryTotal": parseInt($("#SalesDeliveryTotal").val().replaceAll(",", "")),
            "SalesGrandTotal": parseInt($("#SalesGrandTotal").val().replaceAll(",", "")),
            "SalesStatusDelivery": ($("#MsDeliveryIsActive").prop("checked") == false ? "4" : "0"),
            "SalesStatusPayment": (parseInt($("#SalesGrandTotal").val().replaceAll(",", "")) == 0 ? "2" : "0"), 
            "SalesPromoCode": $("#PromoCode").val(),
         };

         var detailitem = [];
         for (var i = 0; data_item.length > i; i++) { 
            var data = {
               "MsProdukId": data_item[i]["MsProdukId"],
               "SalesDetailVarian": data_item[i]["selected"].join("|"),
               "SalesDetailPrice": data_item[i]["price"],
               "SalesDetailQty": data_item[i]["qty"],
               "SalesDetailTotal": data_item[i]["pricetotal"],
               "SalesDetailDisc": data_item[i]["discitemprice"],
               "SalesDetailDiscPercen": data_item[i]["discitempersen"],
               "SalesDetailDiscType": data_item[i]["discitemtype"],
               "SalesDetailDiscTypeAll": data_item[i]["disctype"],
               "SalesDetailDiscTotal": data_item[i]["disctotalprice"],
               "SalesDetailDiscTotalPercen": data_item[i]["disctotalpersen"],
               "SalesDetailDiscTotalType": data_item[i]["disctotaltype"],
               "SalesDetailType": 1,
               "SalesDetailRef": $("#SalesCode").val(),
               "SalesDetailCogs": data_item[i]["cogs"],
               "SatuanId":data_item[i]["uom"],
            };
            detailitem.push(data);
         } 

         var detailoptional = [];
         for (var i = 0; data_optional.length > i; i++) {
            /* data_item (html,itemid,vendorcode,price,qty,disc,uom,total) */
            var data = {
               "SalesOptionalDesc": data_optional[i][1],
               "SalesOptionalPrice": data_optional[i][2],
               "SalesOptionalRef": $("#SalesCode").val(),
            };
            detailoptional.push(data);
         }

         /* -------------------------------------------------     SEND DATA SERVER    ---------------------------------------------- */
         $.ajax({
            method: "POST",
            url: "<?= site_url("function/client_data_sales/data_Sales_edit/".$_sales->SalesId) ?>",
            data: {
               "data": dataheader,
               "item": detailitem,
               "optional": detailoptional
            },
            before: function() {
               req_status_add = 1;
            },
            success: function(data) {

               req_status_add = 0;
               $("#btn-submit").html("Simpan");
               console.log(data);
               if (data) {
                  Swal.fire({
                     icon: 'success',
                     text: 'Edit data berhasil',
                     showConfirmButton: false,
                     allowOutsideClick: false,
                     allowEscapeKey: false,
                     timer: 1500,
                  }).then((result) => {
                     if (result.dismiss === Swal.DismissReason.timer) {
                        $.redirect('<?php echo site_url('export/datasales/sales/-') ?>', {
                           'code': $("#SalesCode").val(),
                        }, "POST", "_blank");
                        load_data_table_sales();
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
      }
   }); 

   /* ------------------------------------------------------      LOAD FROM SALES   ---------------------------------------------- */
    

   $("#MsEmpId").val(data["MsEmpId"]).trigger("change");
   $("#MsWorkplaceId").val(data["MsWorkplaceId"]).trigger("change");
   $("#MsEmpId").attr("disabled", true);
   $("#MsWorkplaceId").attr("disabled", true);
   $("#SalesCode").val(data["SalesCode"]);
   $('#SalesDate').data('daterangepicker').setStartDate(moment(data["SalesDate"]));
   $('#SalesDate').data('daterangepicker').setEndDate(moment(data["SalesDate"]));
   datestart = moment(data["SalesDate"]);
   $("input[name=Salesheader]").removeAttr("checked");
   $("input[name=Salesheader][value=" + data["SalesHeader"] + "]").attr("checked", "checked");

   $("#SalesRef").val(data["SalesRef"]);
   $("#remove-quotation").hide();
   $("#action-quotation").hide();
   del_id = data["MsCustomerDeliveryId"];
   load_data_table(data["MsCustomerId"]);
   $("#MsDeliveryIsActive").prop("checked", (data["SalesDelStatus"] == 0 ? false : true));
   $("#MsDeliveryId").val(data["MsDeliveryId"]).trigger("change");
   $("#SalesDeliveryTotal").val(number_format(parseInt(data["SalesDeliveryTotal"])));
   $("#SalesDiscTotal").val(number_format(parseInt(data["SalesDiscTotal"])));
   $("#SalesGrandTotal").val(number_format(parseInt(data["SalesGrandTotal"])));
   $("#SalesSubTotal").val(number_format(parseInt(data["SalesSubTotal"])));

   var item_quo = <?= JSON_ENCODE($_detail) ?>;
   data_item = []; 
   for (var i = 0; i < item_quo.length; i++) {  
      numberitem++;
      var numberindex = numberitem;
      var htmlItem = `<div class="row-table get-item action-table-single">
            <div class="d-flex item-detail" style=" font-size: 1rem;">
               <div class="flex-shrink-0">
                  <img class="lazy skeleton" data-src="${item_quo[i].MsProdukImage}" style="width: 5rem;background: #f1f1f1;padding: 0.25rem;height: 5rem;object-fit: contain;"> 
               </div> 
               <div class="flex-grow-1 ms-3 d-flex flex-column ps-2">
                  <span class="fw-bold">${item_quo[i].MsProdukCode}-${item_quo[i].MsProdukName}</span> 
                  <span class="fw-bold" style="font-size:0.85rem"><span name="price">Rp. 0</span><span class="fs-8" style="color:gray;" name="uom">/Pcs</span>&nbsp;|&nbsp;<span> stock </span>
                  <select class="custom-select-item stocksales" id="${item_quo[i].MsProdukId}store" data-index="${item_quo[i].MsProdukId}" style="width:4rem">
                     <option value='0' selected>Semua</option>`; 
                     for(var j = 0;j < store.length;j++){
                        htmlItem += `<option value='${store[j]["MsWorkplaceId"]}'>${store[j]["MsWorkplaceCode"]}</option>`;
                     }
                     htmlItem += ` 
                  </select>: <span name="stock">0</span></span>
                  <div class="disconprice" style="display:none;">
                     <span class="fw-bold" style="font-size:0.7rem;" name="displayprice">Rp. 160,000</span>
                     <span class="fs-8 fw-bold" style="color:gray;" name="uom">/Pcs</span>
                  </div>
                  <div class="flex">`;
      var varian = item_quo[i].MsProdukVarian.split(";");
      for(var j = 0;j < varian.length;j++){
         var varheader = varian[j].split(":");
         htmlItem += ` 
                              <select class="custom-select-item variansales" id="${item_quo[i].MsProdukId}${varheader[0]}" data-index="${i}" data-header="${varheader[0]}" style="padding-right: 1.5rem;">`;
         var vardetail = varheader[1].split("|");
         for(var k = 0;k < vardetail.length;k++){
            var selected = "";
            for(var l = 0; l < item_quo[i].selected.length;l++){
               if(item_quo[i].selected[l] == (varheader[0]+ ":" + vardetail[k])){
                  selected = "selected";
                  break; 
               }
            }
            htmlItem += `<option value='${vardetail[k]}' ${selected}>${vardetail[k]}</option>`;  
            
         }
         htmlItem += `</select>`;
         if(j!=varian.length-1
         ) htmlItem += `<span>|</span>`;
      }
      htmlItem += `</div> 
                  <div class="action pt-2"> 
                     <div class="d-flex justify-content-between" style="font-size:0.85rem"> 
                        <div class="d-flex flex-column">
                           <span class="text-muted">Tipe Diskon</span> 
                           <div class="">
                              <div class="form-check form-check-inline pe-2" style="min-height:0px !important;margin-right:0;margin-bottom:0;">
                                 <input class="form-check-input" type="radio" name="SalesDetailDiscType2-${item_quo[i].MsProdukId + number_uniq}" id="${item_quo[i].MsProdukId + number_uniq + (numberindex +1)}" value="0" checked>
                                 <label class="form-check-label" for="${item_quo[i].MsProdukId + number_uniq  + (numberindex +1) }">Tidak Ada</label>
                              </div>
                              <div class="form-check form-check-inline pe-2" style="min-height:0px !important;margin-right:0;margin-bottom:0;">
                                 <input class="form-check-input" type="radio" name="SalesDetailDiscType2-${item_quo[i].MsProdukId + number_uniq}" id="${item_quo[i].MsProdukId + number_uniq + (numberindex +2)}" value="1">
                                 <label class="form-check-label" for="${item_quo[i].MsProdukId + number_uniq  + (numberindex +2)}">By Item</label>
                              </div>
                              <div class="form-check form-check-inline pe-2" style="min-height:0px !important;margin-right:0;margin-bottom:0;">
                                 <input class="form-check-input" type="radio" name="SalesDetailDiscType2-${item_quo[i].MsProdukId + number_uniq}" id="${item_quo[i].MsProdukId + number_uniq + (numberindex +3)}" value="2">
                                 <label class="form-check-label" for="${item_quo[i].MsProdukId + number_uniq  + (numberindex +3)}">By Total</label>
                              </div> 
                           </div> 
                           <div class="pt-2 align-items-center form-disc-item-${item_quo[i].MsProdukId + number_uniq}" style="display:none"> 
                              <div class="form-check form-check-inline pe-2" style="min-height:0px !important;margin-right:0;margin-bottom:0;">
                                 <input class="form-check-input" type="radio" name="SalesDetailDiscType-${item_quo[i].MsProdukId + number_uniq}"  id="${item_quo[i].MsProdukId + number_uniq + (numberindex +4)}" value="0" checked>
                                 <label class="form-check-label" for="${item_quo[i].MsProdukId + number_uniq+ (numberindex +4)}">Rp.</label>
                              </div>
                              <input type="text" class="input-in-table double me-2" name="SalesDetailDisc" style="width:100px" for="${item_quo[i].MsProdukId + number_uniq+ (numberindex +4)}" value=""/>
                              <div class="form-check form-check-inline pe-2" style="min-height:0px !important;margin-right:0;margin-bottom:0;">
                                 <input class="form-check-input" type="radio" name="SalesDetailDiscType-${item_quo[i].MsProdukId + number_uniq}"  id="${item_quo[i].MsProdukId + number_uniq + (numberindex +5)}" value="1">
                                 <label class="form-check-label" for="${item_quo[i].MsProdukId + number_uniq+ (numberindex +5)}" >%</label>
                              </div> 
                              <input type="text" class="input-in-table double " name="SalesDetailDiscPercen" style="width:40px" for="${item_quo[i].MsProdukId + number_uniq+ (numberindex +5)}" value=""/>
                           </div>
                           <div class="pt-2 align-items-center form-disc-total-${item_quo[i].MsProdukId + number_uniq}" style="display:none"> 
                              <div class="form-check form-check-inline pe-2" style="min-height:0px !important;margin-right:0;margin-bottom:0;">
                                 <input class="form-check-input" type="radio" name="SalesDetailDiscType3-${item_quo[i].MsProdukId + number_uniq}"  id="${item_quo[i].MsProdukId + number_uniq + (numberindex +4)}" value="0" checked>
                                 <label class="form-check-label" for="${item_quo[i].MsProdukId + number_uniq+ (numberindex + 4)}">Rp.</label>
                              </div>
                              <input type="text" class="input-in-table double me-2" name="SalesDetailDisc2" style="width:100px" for="${item_quo[i].MsProdukId + number_uniq+ (numberindex +4)}" value=""/>
                              <div class="form-check form-check-inline pe-2" style="min-height:0px !important;margin-right:0;margin-bottom:0;">
                                 <input class="form-check-input" type="radio" name="SalesDetailDiscType3-${item_quo[i].MsProdukId + number_uniq}"  id="${item_quo[i].MsProdukId + number_uniq + (numberindex +5)}" value="1">
                                 <label class="form-check-label" for="${item_quo[i].MsProdukId + number_uniq+ (numberindex + 5)}" >%</label>
                              </div> 
                              <input type="text" class="input-in-table double " name="SalesDetailDiscPercen2" style="width:40px" for="${item_quo[i].MsProdukId + number_uniq+ (numberindex +5)}" value=""/>
                           </div>
                        </div>     
                        <div class="d-flex flex-column">
                           <span  style="color:gray;">Qty&nbsp;<span class="fs-8 fw-bold" style="color:gray;" name="uom">/Pcs</span></span>
                           <input type="text" class="input-in-table double" name="SalesDetailQty" value=""/>
                        </div>
                     </div>  
                     <div class="d-flex justify-content-end pt-2">
                        <span style="font-size:0.85rem">Total</span>
                        <span class="ps-2" style="font-size:1rem;font-weight:bold"><span name="pricetotal">Rp. 0</span></span>
                     </div>
                  </div> 
                  </div>
            </div>  
            <a onclick="hapus_item_click(${item_quo[i].MsProdukId},\'${number_uniq}\')" class="text-danger pointer" title="Hapus Item"><i class="fas fa-trash-alt fa-lg pe-2"></i>Hapus</a>
         </div>`;
      numberitem = numberitem + 5;  

      var arr = [];
      arr["html"] = htmlItem;
      arr["MsProdukId"] = item_quo[i].MsProdukId;
      arr["selected"] = item_quo[i].selected;
      arr["detail"] = item_quo[i].MsProdukDetail;
      arr["stock"] = item_quo[i].MsProdukStock;
      arr["price"] = item_quo[i].price;
      arr["qty"] = item_quo[i].qty;
      arr["discitemprice"] =item_quo[i].discitemprice;
      arr["uom"] =item_quo[i].uom;
      arr["pricetotal"] = item_quo[i].pricetotal;
      arr["typepo"] =item_quo[i].typepo;
      arr["cogs"] = item_quo[i].cogs;
      arr["discitempersen"] = item_quo[i].discitempersen;
      arr["discitemtype"] = item_quo[i].discitemtype;
      arr["disctype"] =item_quo[i].disctype;
      arr["disctotalprice"] =item_quo[i].disctotalprice;
      arr["disctotalpersen"] =item_quo[i].disctotalpersen;
      arr["disctotaltype"] = item_quo[i].disctotaltype;
      arr["category"] = "-";
      arr["generate"] = number_uniq; //disc type RP % dari Total 
      data_item.push(arr);
      number_uniq++; 
      tbl_item.ajax.reload(); 
   }

   var optional_quo = <?= JSON_ENCODE($_optional) ?>;
   data_optional = [];
   for (var i = 0; i < optional_quo.length; i++) {
      var htmlItem = ' <div class="row row-table get-optional">';
      htmlItem += '    <div class="col-8 pe-0" >';
      htmlItem += '       <div class="d-flex flex-column">';
      htmlItem += '          <span  style="color:gray;">Deskripsi</span>';
      htmlItem += '          <input name="SalesOptionalDesc" type="text" class="form-control form-control-sm input-in-table" value="' + optional_quo[i]["SalesOptionalDesc"] + '" style="width:auto">';
      htmlItem += '       </div>';
      htmlItem += '    </div>';
      htmlItem += '   <div class="col-3 ps-1 pe-0" >';
      htmlItem += '       <div class="d-flex flex-column">';
      htmlItem += '          <span  style="color:gray;">Total</span>';
      htmlItem += '          <input name="SalesOptionalTotal" type="text" class="form-control form-control-sm input-in-table price-option" value="' + optional_quo[i]["SalesOptionalPrice"] + '"  style="width:auto">';
      htmlItem += '       </div>';
      htmlItem += '   </div>';
      htmlItem += '   <div class="col-auto px-0 align-self-end ms-auto action-table-single-optional">';
      htmlItem += '       <a class="text-danger pointer " title="Hapus Item"><i class="fas fa-trash-alt fa-lg"></i></a>';
      htmlItem += '   </div>';
      htmlItem += ' </div>';
      data_optional.push([htmlItem, optional_quo[i]["SalesOptionalDesc"], optional_quo[i]["SalesOptionalPrice"]]);
      tbl_optional.ajax.reload();
   }
   total_sales();
</script>
