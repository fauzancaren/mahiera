<div class="modal fade " id="modal-action-customer" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-xl modal-dialog-centered ">
      <form class="modal-content" name="form-action-customer">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp;Edit Data Pelanggan</h5>
               <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="row justify-content-center">
               <div class="col-lg-12 col-11 my-1"> 
                  <div class="row mb-1 align-items-center">
                     <div class="label-border-right">
                        <span class="label-dialog">Pelanggan</span>
                     </div>
                  </div>
               </div> 
               <div class="col-lg-6 col-11 my-1">
                  <div class="row mb-1 align-items-center">
                     <label for="MsCustomerTypeId" class="col-sm-2 col-form-label">Kategori<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-5 col-5  pe-0">
                        <div class="input-group">
                           <select class="custom-select custom-select-sm form-select form-select-sm" id="MsCustomerTypeId" name="MsCustomerTypeId">
                              <option value="<?= $_customer->MsCustomerTypeId ?>" selected="selected"><?= $_customer->MsCustomerTypeName ?></option>
                           </select>
                           <button class="btn btn-success btn-sm" id="create-kategori" type="button"><i class="fas fa-plus" aria-hidden="true"></i></button>
                        </div>
                     </div>
                     <div class="col-sm-5 col-7">
                        <input id="MsCustomerCompany" name="MsCustomerCompany" type="text" class="form-control form-control-sm" value="<?= $_customer->MsCustomerCompany ?>" readonly placeholder="isi nama perusahaan">
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="MsCustomerRemarks" class="col-sm-2 col-form-label">Note</label>
                     <div class="col-sm-10">
                        <input id="MsCustomerRemarks" name="MsCustomerRemarks" type="text" class="form-control form-control-sm" value="<?= $_customer->MsCustomerRemarks ?>">
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center mt-2">
                     <label for="MsCustomerCode" class="col-sm-2 col-form-label">Kode<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-10">
                        <input id="MsCustomerCode" name="MsCustomerCode" type="text" class="form-control form-control-sm" value="<?= $_customer->MsCustomerCode ?>" readonly>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="MsCustomerName" class="col-sm-2 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-10">
                        <input id="MsCustomerName" name="MsCustomerName" type="text" class="form-control form-control-sm" value="<?= $_customer->MsCustomerName ?>">
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="MsCustomerTelp1" class="col-sm-2 col-form-label">Telp.</label>
                     <div class="col-sm-10 d-flex justify-content-between align-items-center">
                        <input id="MsCustomerTelp1" name="MsCustomerTelp1" type="text" class="form-control form-control-sm input-phone" value="<?= $_customer->MsCustomerTelp1 ?>">
                        <span class="fw-bold px-2">/</span>
                        <input id="MsCustomerTelp2" name="MsCustomerTelp2" type="text" class="form-control form-control-sm input-phone" value="<?= $_customer->MsCustomerTelp2 ?>">
                     </div>
                  </div>
               </div> 
               <div class="col-lg-6 col-11 my-1"> 
                  <div class="row mb-1 align-items-center">
                     <label for="MsCustomerEmail" class="col-sm-2 col-form-label">Email</label>
                     <div class="col-sm-10">
                        <input id="MsCustomerEmail" name="MsCustomerEmail" type="text" class="form-control form-control-sm" value="<?= $_customer->MsCustomerEmail ?>">
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="MsCustomerInstagram" class="col-sm-2 col-form-label">Instagram</label>
                     <div class="col-sm-10">
                        <input id="MsCustomerInstagram" name="MsCustomerInstagram" type="text" class="form-control form-control-sm" value="<?= $_customer->MsCustomerInstagram ?>">
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="MsCustomerCity" class="col-sm-2 col-form-label">Kota & Kec.</label>
                     <div class="col-sm-10 position-relative">
                        <input id="MsCustomerCity" name="MsCustomerCity" type="text" class="form-control form-control-sm" value="" placeholder="Provinsi, Kota, Kecamatan, Kodepos" autocomplete="new-password">
                        <div class="custom-search" style="display:none;"> 
                           <div class="search-group" style="display:block">
                              <ul class="nav nav-tabs" id="tab-city" role="tablist">
                                 <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="prov-tab" data-bs-toggle="tab" data-type="prov" data-bs-target="#prov-tab-pane" type="button" role="tab" aria-controls="prov-tab-pane" aria-selected="true">PROV.</button>
                                 </li>
                                 <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="kota-tab" data-bs-toggle="tab"  data-type="kota" data-bs-target="#kota-tab-pane" type="button" role="tab" aria-controls="kota-tab-pane" aria-selected="false" disabled>KOTA</button>
                                 </li>
                                 <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="kec-tab" data-bs-toggle="tab" data-type="kec"  data-bs-target="#kec-tab-pane" type="button" role="tab" aria-controls="kec-tab-pane" aria-selected="false" disabled>KEC.</button>
                                 </li>
                                 <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="poscode-tab" data-bs-toggle="tab"  data-type="poscode" data-bs-target="#poscode-tab-pane" type="button" role="tab" aria-controls="poscode-tab-pane" aria-selected="false" disabled>KODEPOS</button>
                                 </li>
                              </ul>
                              <div class="tab-content" id="nav-tabContent" style="max-height: 15rem;overflow-y:auto;">
                                 <div class="tab-pane fade show active list-group " id="tab-pane" role="tabpanel" aria-labelledby="tab-pane" tabindex="0"> 
                                    
                                 </div> 
                              </div>
                           </div>
                           <div class="search-text" style="display:none">
                              <div class="tab-content" style="max-height: 15rem;overflow-y:auto;">
                                 <div class="tab-pane fade show active list-group " id="list-search" role="tabpanel" aria-labelledby="tab-pane" tabindex="0">  
                                 </div> 
                              </div>
                           </div>
                        </div>
                     </div> 
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="MsCustomerAddress" class="col-sm-2 col-form-label">Alamat</label>
                     <div class="col-sm-10">
                        <textarea id="MsCustomerAddress" name="MsCustomerAddress" class="form-control form-control-sm"><?= $_customer->MsCustomerAddress ?></textarea>
                     </div>
                  </div> 
               </div>

               <div class="col-lg-12 col-11 my-1"> 
                  <div class="row mb-1 align-items-center">
                     <div class="label-border-right">
                        <span class="label-dialog">Alamat Pengiriman</span>
                     </div>
                  </div> 
                  <div class="card ">
                     <div class="card-body p-2 ">
                        <button class="btn btn-success btn-sm py-1" id="create-delivery" type="button">
                           <i class="fas fa-plus" aria-hidden="true"></i>
                           <span class="fw-bold">
                              &nbsp;Tambah Alamat Baru
                           </span>
                        </button>
                        <div id="data-pengiriman" class="d-flex flex-column mt-1">
                        </div>
                     </div>
                  </div> 
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="submit" class="btn btn-success" id="btn-submit-customer">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
         </div>
      </form>
   </div>
</div>
<div class="modal fade" id="create-new-kategori" tabindex="-1" role="dialog" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-dialog-centered">
      <form class="modal-content" name="form-action-category">
         <div class="modal-header">
            <h6 class="modal-title "><i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;Tambah Tipe Pelanggan</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="row mb-1 align-items-center">
               <label for="MsCustomerTypeName" class="col-sm-3 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
               <div class="col-sm-9">
                  <input id="MsCustomerTypeName" name="MsCustomerTypeName" type="text" class="form-control form-control-sm" value="" required>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="submit" class="btn btn-success" id="btn-submit-category">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">batalkan</button>
         </div>
      </form>
   </div>
</div>
<div class="modal fade" id="modal-action-delivery" tabindex="-1" role="dialog" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-dialog-centered">
      <form class="modal-content shadow-lg" name="form-action-delivery">
         <div class="modal-header">
            <h6 class="modal-title "><i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;Tambah Alamat Pengiriman</h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="row mb-1 align-items-center">
               <div class="col-sm-9 offset-sm-3">
                  <a onclick="paste_data_delivery()" class="text-primary text-decoration-none pointer"><i class="fas fa-paste"></i>&nbsp;Copy paste dari personal data</a>
               </div>
            </div>
            <div class="row mb-1 align-items-center">
               <label for="MsCustomerDeliveryReceive" class="col-sm-3 col-form-label">Penerima<sup class="error">&nbsp;*</sup></label>
               <div class="col-sm-9">
                  <input id="MsCustomerDeliveryReceive" name="MsCustomerDeliveryReceive" type="text" class="form-control form-control-sm" value="" required>
               </div>
            </div>
            <div class="row mb-1 align-items-center">
               <label for="MsCustomerDeliveryTelp" class="col-sm-3 col-form-label">Telp<sup class="error">&nbsp;*</sup></label>
               <div class="col-sm-9">
                  <input id="MsCustomerDeliveryTelp" name="MsCustomerDeliveryTelp" type="text" class="form-control form-control-sm input-phone" value="" required>
               </div>
            </div>
            <div class="row mb-1 align-items-center">
               <label for="MsCustomerDeliveryAddress" class="col-sm-3 col-form-label">Alamat<sup class="error">&nbsp;*</sup></label>
               <div class="col-sm-9">
                  <textarea id="MsCustomerDeliveryAddress" name="MsCustomerDeliveryAddress" class="form-control form-control-sm" value="" required></textarea>
               </div>
            </div>
            <div class="row mb-1 align-items-center">
               <label for="MsCustomerDeliveryMap" class="col-sm-3 col-form-label">Titik Map<br><span class="text-secondary fw-bold">(Optional)</span></label>
               <div class="col-sm-9">
                  <div class="bg-pinpoint">
                     <i class="fas fa-map-marker-alt fa-2x"></i>
                     <span id="MsCustomerDeliveryName" class="label-small px-1">Tandai lokasi dalam peta untuk memudahkan pengiriman</span>
                     <button type="button" class="btn btn-light py-1 ms-auto btn-sm" id="select-map">Tandai Lokasi</button>
                  </div>
                  <input id="MsCustomerDeliveryLat" name="MsCustomerDeliveryLat" type="text" class="form-control form-control-sm" value="" style="display:none">
                  <input id="MsCustomerDeliveryLng" name="MsCustomerDeliveryLng" type="text" class="form-control form-control-sm" value="" style="display:none">
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="submit" class="btn btn-success py-1" id="btn-submit-delivery">Simpan</button>
            <button type="button" class="btn btn-secondary py-1" data-bs-dismiss="modal">batalkan</button>
         </div>
      </form>
   </div>
</div>
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
   <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
   </symbol>
   <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
      <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
   </symbol>
   <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
      <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
   </symbol>
</svg>
<div class="modal fade" id="modal-action-map" tabindex="-1" role="dialog" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content shadow-lg" name="form-action-delivery">
         <div class="modal-header">
            <h6 class="modal-title"><i class="fas fa-map-marker-alt text-secondary" aria-hidden="true"></i> &nbsp;Pilih lokasi map</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="alert alert-orange d-flex align-items-center m-2" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:">
               <use xlink:href="#exclamation-triangle-fill" />
            </svg>
            <div>
               Pastikan titik map sesuai dengan alamat yang tercantum sebelumnya
            </div>
         </div>
         <div class="modal-body">
            <div style="height:450px;display:block">
               <input id="text-pac-input" type="text" class="form-control" placeholder="Tulis jalan / perumahan / gedung" aria-describedby="label-pac-input">
               <div id="map" style="height: 100%;"></div>
            </div>
         </div>
         <div class="modal-footer m-0 p-2" style="border-radius:0.3rem;border-top-right-radius:0px;border-top-left-radius:0px;">
            <div id="location-text"></div>
         </div>
      </div>
   </div>
</div>
<script>
   var req_status = 0;
   var delivery_action_id = -1;
   var datadelivery = <?= JSON_ENCODE($_deliverycustomer) ?>;

   function load_datadelivery() {
      var htmldelivery = "";
      var orderflex = 2;
      for (var i = 0; datadelivery.length > i; i++) {
         if (datadelivery[i]["MsCustomerDeliveryUtama"] == 1) {
            htmldelivery += '<div class="card shadow-sm card-delivery select order-1">';
            var htmlAction = '      <a class="action-label" onclick="change_delivery(' + i + ')" >Ubah</a>';
         } else {
            htmldelivery += '<div class="card shadow-sm card-delivery order-' + orderflex + '">';
            orderflex++;
            htmlAction = '      <a class="action-label" onclick="change_delivery(' + i + ')" >Ubah</a>';
            htmlAction += '      <div class="action-space"></div>';
            htmlAction += '      <a class="action-label" onclick="set_delivery(' + i + ')" >Jadikan Alamat Utama</a>';
            htmlAction += '      <div class="action-space"></div>';
            htmlAction += '      <a class="action-label" onclick="delete_delivery(' + i + ')" >Hapus</a>';
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
   }
   load_datadelivery();
   $("#MsCustomerTypeId").select2({
      theme: "bootstrap",
      dropdownParent: $("#modal-action-customer .modal-content"),
      ajax: {
         dataType: "json",
         url: "<?= site_url("function/client_data_master/get_data_customer_type") ?>",
         delay: 800,
         data: function(params) {
            return {
               search: params.term
            }
         },
         processResults: function(data, page) {
            return {
               results: data
            };
         },
      }
   }).change(function() {
      if ($("#MsCustomerTypeId").val() == 1) {
         $("#MsCustomerCompany").val("-");
         $("#MsCustomerCompany").prop("readonly", true);
      } else {
         $("#MsCustomerCompany").val("");
         $("#MsCustomerCompany").prop("readonly", false);
      };
   });
   $("#MsCustomerTypeId").trigger("change");
   $("#MsCustomerCompany").val("<?= $_customer->MsCustomerCompany ?>");
   var datesCollection = document.getElementsByClassName("input-phone");
   var phones = Array.from(datesCollection);
   phones.forEach(function(phone) {
      new Cleave(phone, {
         phone: true,
         phoneRegionCode: "ID"
      })
   });
  
   var timeoutopen;
   var opencustomsearch = false;
   var typenav = "prov";
   var selectcity = {prov : {}, kota : {},kec : {},poscode :{}};  
   selectcity["prov"]["id"] =  '<?= $_customer->MsProvinceId ?>';
   selectcity["prov"]["value"] =  '<?= $_customer->MsProvinceName ?>';
   selectcity["kota"]["id"] =  '<?= $_customer->MsRegencyId ?>';
   selectcity["kota"]["value"] =  '<?= $_customer->MsRegencyName ?>';
   selectcity["kec"]["id"] =  '<?= $_customer->MsDistrictId ?>';
   selectcity["kec"]["value"] =  '<?= $_customer->MsDistrictName ?>';
   selectcity["poscode"]["id"] =  '<?= $_customer->MsVillageId ?>';
   selectcity["poscode"]["value"] =  '<?= $_customer->MsVillageName ?>';
   selectcity["poscode"]["kode"] =  '<?= $_customer->MsVillageKodePos ?>';
   if( selectcity["prov"]["value"] !== undefined && selectcity["prov"]["value"].length > 0) $("#MsCustomerCity").val(selectcity["prov"]["value"] );
   if( selectcity["kota"]["value"] !== undefined && selectcity["kota"]["value"].length > 0) $("#MsCustomerCity").val(selectcity["prov"]["value"] + ", " + selectcity["kota"]["value"]  );
   if( selectcity["kec"]["value"] !== undefined && selectcity["kec"]["value"].length > 0) $("#MsCustomerCity").val(selectcity["prov"]["value"] + ", " + selectcity["kota"]["value"]   + ", " + selectcity["kec"]["value"]);
   if(selectcity["poscode"]["value"] !== undefined && selectcity["poscode"]["value"].length > 0) $("#MsCustomerCity").val(selectcity["prov"]["value"] + ", " + selectcity["kota"]["value"] + ", " + selectcity["kec"]["value"]+ ", " + selectcity["poscode"]["value"]+ ", " + selectcity["poscode"]["kode"]);  

   $("#MsCustomerCity").focus(function() { 
      $("#MsCustomerCity").val("");
      load_custom_search(typenav);
      opencustomsearch = true;
      closecustomselect(0);
   }).focusout(function(){
      opencustomsearch = false;
      closecustomselect(300);  

      if( selectcity["prov"]["value"] !== undefined && selectcity["prov"]["value"].length > 0) $("#MsCustomerCity").val(selectcity["prov"]["value"] );
      if( selectcity["kota"]["value"] !== undefined && selectcity["kota"]["value"].length > 0) $("#MsCustomerCity").val(selectcity["prov"]["value"] + ", " + selectcity["kota"]["value"]  );
      if( selectcity["kec"]["value"] !== undefined && selectcity["kec"]["value"].length > 0) $("#MsCustomerCity").val(selectcity["prov"]["value"] + ", " + selectcity["kota"]["value"]   + ", " + selectcity["kec"]["value"]);
      if(selectcity["poscode"]["value"] !== undefined && selectcity["poscode"]["value"].length > 0) $("#MsCustomerCity").val(selectcity["prov"]["value"] + ", " + selectcity["kota"]["value"] + ", " + selectcity["kec"]["value"]+ ", " + selectcity["poscode"]["value"]+ ", " + selectcity["poscode"]["kode"]);  

   });
   closecustomselect = function(delay){ 
      clearTimeout(timeoutopen);
      timeoutopen = setTimeout( function() 
      {
         if(!opencustomsearch){ 
            $(".custom-search").hide(); 
         }else{ 
            console.log("open search"); 
            $(".custom-search").show();
         }
      }, delay);
   }
   $(".custom-search").hover(
      function() { 
            opencustomsearch = true;
            closecustomselect(0); 
      }, function() {
         if(!$("#MsCustomerCity").is(":focus")){  
            opencustomsearch = false; 
            closecustomselect(500);
         }
      }
   );

   $('.nav-tabs button').on('shown.bs.tab', function (e) { 
        var current_tab = e.target;
        var previous_tab = e.relatedTarget;
        console.log($(current_tab).data("type"));
        $("#MsCustomerCity").focus();
        load_custom_search($(current_tab).data("type"));
    });

   load_custom_search = function(type){
      $.ajax({
         dataType: "json",
         method: "POST",
         url: "<?= site_url("function/client_data_master/get_data_city") ?>",
         data: {
            "type": type,
            "select": selectcity,
         }, 
         success: function(data) {
            $("#tab-pane").html("");
            for(var i = 0;i < data.length;i++){  
               var status = ""; 
               if(type == "prov"){  
                  if(selectcity["prov"]["id"] == data[i]["id"]) status = "active";
               }
               if(type == "kota"){   
                  if(selectcity["kota"]["id"] == data[i]["id"])  status = "active";
               }
               if(type == "kec"){   
                  if(selectcity["kec"]["id"] == data[i]["id"])  status = "active";
               }
               if(type == "poscode"){   
                  if(selectcity["poscode"]["id"] == data[i]["id"])  status = "active";
               } 
               
               $("#tab-pane").append(`<a onclick="custom_click('${type}',this)" class="list-group-item list-group-item-action ${status}" data-id="${data[i]["id"]}" data-value="${data[i]["value"]}"  data-kode="${data[i]["kode"]}">${data[i]["text"]}</a>`)
            }
         }
      });
   }

   custom_click = function(type,el){
      $("#MsCustomerCity").val("");
      if(type == "prov"){  
         selectcity["prov"] = $(el).data();
         selectcity["kota"] = {};
         selectcity["kec"] = {};
         selectcity["poscode"] = {};
         $("#kota-tab").prop("disabled",false);
         $("#kec-tab").prop("disabled",true);
         $("#poscode-tab").prop("disabled",true);
         $("#kota-tab").trigger("click");

         $("#MsCustomerCity").attr("placeholder", selectcity["prov"]["value"]); 
         typenav = "kota";
      }
      if(type == "kota"){  
         selectcity["kota"] = $(el).data();
         selectcity["kec"] = {};
         selectcity["poscode"] = {};
         $("#kec-tab").prop("disabled",false);
         $("#poscode-tab").prop("disabled",true);
         $("#kec-tab").trigger("click");

         $("#MsCustomerCity").attr("placeholder", selectcity["prov"]["value"] + ", " + selectcity["kota"]["value"]);
         typenav = "kec";
      }
      if(type == "kec"){  
         selectcity["kec"] = $(el).data(); 
         selectcity["poscode"] = {};
         $("#poscode-tab").prop("disabled",false);
         $("#poscode-tab").trigger("click");

         $("#MsCustomerCity").attr("placeholder", selectcity["prov"]["value"] + ", " + selectcity["kota"]["value"] + ", " + selectcity["kec"]["value"]);
         typenav = "poscode";
      } 
      if(type == "poscode"){   
         selectcity["poscode"] =$(el).data();   
         $("#MsCustomerCity").attr("placeholder", selectcity["prov"]["value"] + ", " + selectcity["kota"]["value"] + ", " + selectcity["kec"]["value"] + ", " + selectcity["poscode"]["value"]+ ", " + selectcity["poscode"]["kode"]);
         $("#MsCustomerCity").val(selectcity["prov"]["value"] + ", " + selectcity["kota"]["value"] + ", " + selectcity["kec"]["value"] + ", " + selectcity["poscode"]["value"]+ ", " + selectcity["poscode"]["kode"]);
      } 
   }
   var datatable_search = [];
   $("#MsCustomerCity").keyup(function(){ 
      if($("#MsCustomerCity").val().length > 0){
         $(".search-text").show();
         $(".search-group").hide();
         $.ajax({
            dataType: "json",
            method: "POST",
            url: "<?= site_url("function/client_data_master/get_data_city_search") ?>",
            data: {
               "search": $("#MsCustomerCity").val(), 
            }, 
            success: function(data) {
               datatable_search = data;
               $("#list-search").html("");
               for(var i = 0;i < data.length;i++){    
                  $("#list-search").append(`<a onclick="search_click(${i})" class="list-group-item list-group-item-action" >${data[i]["text"]}</a>`)
               }
            }
         });
      }else{ 
         $(".search-text").hide();
         $(".search-group").show(); 
      }
   });
  
   search_click = function(index){ 
      selectcity["prov"]["id"] = datatable_search[index]["prov"]["id"];
      selectcity["prov"]["value"] = datatable_search[index]["prov"]["value"];
      selectcity["kota"]["id"] = datatable_search[index]["kota"]["id"];
      selectcity["kota"]["value"] = datatable_search[index]["kota"]["value"];
      selectcity["kec"]["id"] = datatable_search[index]["kec"]["id"];
      selectcity["kec"]["value"] = datatable_search[index]["kec"]["value"];
      selectcity["poscode"]["id"] = datatable_search[index]["poscode"]["id"];
      selectcity["poscode"]["value"] = datatable_search[index]["poscode"]["value"];
      selectcity["poscode"]["kode"] = datatable_search[index]["poscode"]["kode"];


      $("#MsCustomerCity").attr("placeholder", selectcity["prov"]["value"] + ", " + selectcity["kota"]["value"] + ", " + selectcity["kec"]["value"] + ", " + selectcity["poscode"]["value"]+ ", " + selectcity["poscode"]["kode"]);
      $("#MsCustomerCity").val(selectcity["prov"]["value"] + ", " + selectcity["kota"]["value"] + ", " + selectcity["kec"]["value"] + ", " + selectcity["poscode"]["value"]+ ", " + selectcity["poscode"]["kode"]);
   }
   




   /*
   |
   |    FUNCTION GOOGLE MAP   
   |
   |
   */

   var maplocation = {
      lat: -6.265707593132433,
      lng: 106.77526944082672
   };
   var mapaddress = {
      address: "Pondok Pinang, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta, Indonesia"
   };

   function set_text_address() {
      $("#location-text").html("<span>" + mapaddress.address + "</span>")
   }
   api_geocoder = new google.maps.Geocoder();
   api_map = new google.maps.Map(document.getElementById("map"), {
      center: maplocation,
      zoom: 20,
      zoomControl: false,
      keyboardShortcuts: false,
      disableDefaultUI: true,
      clickableIcons: false,
      mapTypeId: google.maps.MapTypeId.ROADMAP
   });
   api_map.setZoom(19);
   api_map.setCenter(maplocation);
   $("<div/>").addClass("centerMarker").appendTo(api_map.getDiv());
   $("<div class='centerButton'>Pilih lokasi ini<div/>").appendTo(api_map.getDiv()).click(function() {
      $("#MsCustomerDeliveryName").text(mapaddress.address);
      $("#MsCustomerDeliveryLat").val(maplocation.lat);
      $("#MsCustomerDeliveryLng").val(maplocation.lng);
      $("#modal-action-map").modal("hide");
   });

   // Create the search box and link it to the UI element.
   api_input = document.getElementById("text-pac-input");
   api_map.controls[google.maps.ControlPosition.TOP_LEFT].push(api_input);
   api_searchBox = new google.maps.places.SearchBox(api_input);

   // Bias the SearchBox results towards current maps viewport.
   api_map.addListener("bounds_changed", () => {
      maplocation = api_map.getCenter();
      api_searchBox.setBounds(api_map.getBounds());
      set_text_address();
   });
   api_map.addListener("mouseup", () => {

      $(".centerMarker").removeClass("mousedown");
      maplocation = api_map.getCenter();
      api_geocoder
         .geocode({
            location: maplocation
         })
         .then((response) => {
            if (response.results[0]) {
               try {
                  mapaddress.address = response.results[0].plus_code.compound_code.slice(8);
               } catch (err) {
                  mapaddress.address = response.results[0].formatted_address;
               }
               set_text_address();
            } else {
               console.log("api_map.addListener geocode => No results found");
            }
         })
         .catch((e) => console.log("api_map.addListener geocode => No results found" + e));
   });
   api_map.addListener("mousedown", () => {
      $(".centerMarker").addClass("mousedown");
   });
   api_markers = [];

   // Listen for the event fired when the user selects a prediction and retrieve
   // more details for that place.
   api_searchBox.addListener("places_changed", () => {
      const places = api_searchBox.getPlaces();

      if (places.length == 0) {
         return;
      }
      // Clear out the old api_markers.
      api_markers.forEach((marker) => {
         marker.setMap(null);
      });
      api_markers = [];

      // For each place, get the icon, name and location.
      const bounds = new google.maps.LatLngBounds();
      places.forEach((place) => {
         if (!place.geometry || !place.geometry.location) {
            console.log("Returned place contains no geometry");
            return;
         }
         const icon = {
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(25, 25),
         };
         // Create a marker for each place.
         api_markers.push(
            new google.maps.Marker({
               api_map,
               icon,
               title: place.name,
               position: place.geometry.location,
            })
         );
         maplocation = place.geometry.location;
         try {
            mapaddress.address = place.plus_code.compound_code.slice(8);
         } catch (err) {
            mapaddress.address = place.formatted_address;
         }
         set_text_address();
         if (place.geometry.viewport) {
            bounds.union(place.geometry.viewport);
         } else {
            bounds.extend(place.geometry.location);
         }
      });
      api_map.fitBounds(bounds);
      api_map.setZoom(19);
      api_map.setCenter(maplocation);
   });

   /*
   |
   |    FUNCTION FORM ACTION   
   |
   |
   */
   $(function() {
      $("form[name='form-action-category']").validate({
         rules: {
            MsCustomerTypeName: {
               "required": true,
               "remote": "<?= site_url("function/client_data_master/validate_kode_customer_type") ?>",
            },
         },
         messages: {
            MsCustomerTypeName: {
               required: "Masukan Nama Tipe Pelanggan",
               remote: "Nama Tipe Pelanggan sudah ada"
            },
         },
         submitHandler: function(form) {
            if (!req_status) {
               $("#btn-submit-category").html('<i class="fas fa-circle-notch fa-spin"></i> Loading');
               $.ajax({
                  method: "POST",
                  url: "<?= site_url("function/client_data_master/data_customer_type_add") ?>",
                  data: {
                     "MsCustomerTypeName": $("#MsCustomerTypeName").val(),
                     "MsCustomerTypeIsActive": "on",
                  },
                  before: function() {
                     req_status = 1;
                  },
                  success: function(data) {
                     req_status = 0;
                     $("#btn-submit-category").html("Simpan");
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
                              $("#create-new-kategori").modal("hide");
                              $("#MsCustomerTypeName").val("");
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

      $("form[name='form-action-delivery']").validate({
         rules: {
            MsCustomerDeliveryReceive: "required",
            MsCustomerDeliveryTelp: "required",
            MsCustomerDeliveryAddress: "required",
         },
         messages: {
            MsCustomerDeliveryReceive: "Masukan Nama Penerima",
            MsCustomerDeliveryTelp: "Masukan Nomer Penerima",
            MsCustomerDeliveryAddress: "Masukan Alamat Penerima",
         },
         submitHandler: function(form) {
            if (!req_status) {
               $("#btn-submit-delivery").html('<i class="fas fa-circle-notch fa-spin"></i> Loading');
               if (delivery_action_id == -1) {
                  datadelivery.push({
                     "MsCustomerDeliveryReceive": $("#MsCustomerDeliveryReceive").val(),
                     "MsCustomerDeliveryTelp": $("#MsCustomerDeliveryTelp").val(),
                     "MsCustomerDeliveryAddress": $("#MsCustomerDeliveryAddress").val(),
                     "MsCustomerDeliveryName": $("#MsCustomerDeliveryName").text(),
                     "MsCustomerDeliveryLat": $("#MsCustomerDeliveryLat").val(),
                     "MsCustomerDeliveryLng": $("#MsCustomerDeliveryLng").val(),
                     "MsCustomerDeliveryUtama": (datadelivery.length == 0 ? 1 : 0),
                     "MsCustomerDeliveryId": null,
                     "MsCustomerId": null,
                  });
                  load_datadelivery();
                  $("#modal-action-delivery").modal("hide");
                  $("#btn-submit-delivery").html('Simpan');
               } else {
                  datadelivery[delivery_action_id]["MsCustomerDeliveryReceive"] = $("#MsCustomerDeliveryReceive").val();
                  datadelivery[delivery_action_id]["MsCustomerDeliveryTelp"] = $("#MsCustomerDeliveryTelp").val();
                  datadelivery[delivery_action_id]["MsCustomerDeliveryAddress"] = $("#MsCustomerDeliveryAddress").val();
                  datadelivery[delivery_action_id]["MsCustomerDeliveryName"] = $("#MsCustomerDeliveryName").text();
                  datadelivery[delivery_action_id]["MsCustomerDeliveryLat"] = $("#MsCustomerDeliveryLat").val();
                  datadelivery[delivery_action_id]["MsCustomerDeliveryLng"] = $("#MsCustomerDeliveryLng").val();
                  load_datadelivery();
                  $("#modal-action-delivery").modal("hide");
                  $("#btn-submit-delivery").html("Simpan");
               }
               return false;
            }
         }
      });

      function uploaddata() {

         if(selectcity["poscode"]["id"] == undefined || selectcity["poscode"]["id"].length == 0) { 
            Swal.fire({
                  icon: 'error',
                  text: 'Data Kota dan kecamatan belum lengkap',
                  showConfirmButton: false,
                  allowOutsideClick: false,
                  allowEscapeKey: false,
                  timer: 1500
               });
               return false;
         }
         $.ajax({
            method: "POST",
            url: "<?= site_url("function/client_data_master/data_customer_edit/") . $_customer->MsCustomerId ?>",
            data: {
               "MsCustomerIsActive": ($("#MsCustomerIsActive").prop("checked") == false ? null : "on"),
               "MsCustomerTypeId": $("#MsCustomerTypeId").val(),
               "MsCustomerCode": $("#MsCustomerCode").val(),
               "MsCustomerCompany": $("#MsCustomerCompany").val(),
               "MsCustomerName": $("#MsCustomerName").val(),
               "MsCustomerAddress": $("#MsCustomerAddress").val(),
               "MsVillageId": selectcity["poscode"]["id"],
               "MsCustomerTelp1": $("#MsCustomerTelp1").val(),
               "MsCustomerTelp2": $("#MsCustomerTelp2").val(),
               "MsCustomerFax": "",
               "MsCustomerRemarks": $("#MsCustomerRemarks").val(),
               "MsCustomerEmail": $("#MsCustomerEmail").val(),
               "MsCustomerInstagram": $("#MsCustomerInstagram").val(),
               "data_delivery": datadelivery
            },
            before: function() {
               req_status = 1;
               $("#btn-submit-customer").html('<i class="fas fa-circle-notch fa-spin"></i> Loading');
            },
            success: function(data) {
               req_status = 0;
               $("#btn-submit-customer").html("Simpan");
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
                        load_data_table(<?= $_customer->MsCustomerId ?>);
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
      $("form[name='form-action-customer']").validate({
         rules: {
            MsCustomerCompany: "required",
            MsCustomerName: "required",
            MsCustomerTelp1: "required",
            MsCustomerAddress: "required",
            MsCustomerCity: "required",
         },
         messages: {
            MsCustomerCompany: "Masukan Nama Perusahaan",
            MsCustomerName: "Masukan Nama Pelanggan",
            MsCustomerTelp1: "Masukan Nomer Pelanggan",
            MsCustomerAddress: "Masukan Alamat Pelanggan", 
            MsCustomerCity: "Masukan Nama Kota Pelanggan",
         },
         submitHandler: function(form) {
            if (!req_status) {
               if (datadelivery.length == 0) {
                  const swalWithBootstrapButtons = Swal.mixin({
                     customClass: {
                        confirmButton: 'btn btn-success mx-1',
                        cancelButton: 'btn btn-secondary mx-1'
                     },
                     buttonsStyling: false
                  })
                  swalWithBootstrapButtons.fire({
                     title: "Alamat Pengiriman Kosong!",
                     text: "apakah ingin dibuat otomatis dari nama personal?",
                     icon: "warning",
                     allowOutsideClick: false,
                     allowEscapeKey: false,
                     showCancelButton: true,
                     confirmButtonText: "Lanjutkan",
                     cancelButtonText: "Tidak",
                     reverseButtons: true
                  }).then((result) => {
                     if (result.isConfirmed) {
                        datadelivery.push({
                           "MsCustomerDeliveryReceive": $("#MsCustomerName").val(),
                           "MsCustomerDeliveryTelp": $("#MsCustomerTelp1").val() + ($("#MsCustomerTelp2").val() != "" ? "/" + $("#MsCustomerTelp2").val() : ""),
                           "MsCustomerDeliveryAddress": $("#MsCustomerAddress").val(),
                           "MsCustomerDeliveryName": "Tandai lokasi dalam peta untuk memudahkan pengiriman",
                           "MsCustomerDeliveryLat": -6.265707593132433,
                           "MsCustomerDeliveryLng": 106.77526944082672,
                           "MsCustomerDeliveryUtama": 1,
                           "MsCustomerDeliveryId": 0,
                           "MsCustomerId": 0,
                        });
                        load_datadelivery();
                        uploaddata();
                     } else if (
                        result.dismiss === Swal.DismissReason.cancel
                     ) {
                        $("#modal-action-delivery").modal("show");
                     }
                  })
               } else {
                  uploaddata();
               }
               return false;
            }
         }
      });
   });
   /* ----------- modal -------- */

   var mode = "action customer";
   get_mode = function() {
      return mode;
   };
   $("#create-delivery").click(function() {
      delivery_action_id = -1;
      $("#modal-action-delivery h6").html('<i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;Tambah Alamat Pengiriman');
      $("form[name='form-action-delivery']")[0].reset();
      $("#MsCustomerDeliveryName").text("Tandai lokasi dalam peta untuk memudahkan pengiriman");
      maplocation = {
         lat: -6.265707593132433,
         lng: 106.77526944082672
      };
      mapaddress = {
         address: "Pondok Pinang, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta, Indonesia"
      };

      $("#modal-action-delivery").modal("show");
      $("#modal-action-customer").modal("hide");
   });
   $("#create-category").click(function() {
      mode = "action category";
      $("#create-new-kategori").modal("show");
   });
   $("#select-map").click(function() {
      mode = "action map";
      $("#modal-action-map").modal("show");
      $("#modal-action-delivery").modal("hide");
      if ($("#MsCustomerDeliveryName").text() == "Tandai lokasi dalam peta untuk memudahkan pengiriman") {
         maplocation = {
            lat: -6.265707593132433,
            lng: 106.77526944082672
         };
         mapaddress = {
            address: "Pondok Pinang, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta, Indonesia"
         };
      } else {
         maplocation = {
            lat: parseFloat($("#MsCustomerDeliveryLat").val()),
            lng: parseFloat($("#MsCustomerDeliveryLng").val())
         };
         mapaddress = {
            address: $("#MsCustomerDeliveryName").text()
         };
      }
      api_map.setCenter(maplocation);
   });

   $("#modal-action-customer").on("show.bs.modal", function() {
      mode = "action customer";
   });
   $("#modal-action-delivery").on("show.bs.modal", function() {
      mode = "action delivery";
      $("#modal-action-customer").modal("hide");
   });
   $("#modal-action-delivery").on("hidden.bs.modal", function() {
      if (mode != "action map") {
         mode = "action delivery";
         $("#modal-action-customer").modal("show");
      }
   });

   $("#modal-action-map").on("hidden.bs.modal", function() {
      $("#modal-action-delivery").modal("show");
      mode = "action delivery";
   });

   $("#create-new-kategori").on("show.bs.modal", function() {
      $("#modal-action-customer").modal("hide");
   });
   $("#create-new-kategori").on("hidden.bs.modal", function() {
      $("#modal-action-customer").modal("show");
   });

   /* --------- function -------*/

   function paste_data_delivery() {
      $("#MsCustomerDeliveryReceive").val($("#MsCustomerName").val());
      $("#MsCustomerDeliveryTelp").val($("#MsCustomerTelp1").val() + ($("#MsCustomerTelp2").val() != "" ? "/" + $("#MsCustomerTelp2").val() : ""));
      $("#MsCustomerDeliveryAddress").val($("#MsCustomerAddress").val());
   }

   function change_delivery(i) {
      $("#MsCustomerDeliveryReceive").val(datadelivery[i]["MsCustomerDeliveryReceive"]);
      $("#MsCustomerDeliveryTelp").val(datadelivery[i]["MsCustomerDeliveryTelp"]);
      $("#MsCustomerDeliveryAddress").val(datadelivery[i]["MsCustomerDeliveryAddress"]);
      $("#MsCustomerDeliveryName").text(datadelivery[i]["MsCustomerDeliveryName"]);
      $("#MsCustomerDeliveryLat").val(datadelivery[i]["MsCustomerDeliveryLat"]);
      $("#MsCustomerDeliveryLng").val(datadelivery[i]["MsCustomerDeliveryLng"]);
      maplocation = {
         lat: datadelivery[i]["MsCustomerDeliveryLat"],
         lng: datadelivery[i]["MsCustomerDeliveryLng"]
      };
      $("#modal-action-delivery h6").html('<i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp;Edit Alamat Pengiriman');
      $("#modal-action-delivery").modal("show");
      delivery_action_id = i;
   }

   function set_delivery(i) {
      for (var j = 0; datadelivery.length > j; j++) {
         datadelivery[j]["MsCustomerDeliveryUtama"] = 0;
      }
      datadelivery[i]["MsCustomerDeliveryUtama"] = 1;
      Swal.fire({
         icon: 'success',
         text: 'mengubah alamat utama berhasil',
         showConfirmButton: false,
         allowOutsideClick: false,
         allowEscapeKey: false,
         timer: 1500,
      }).then((result) => {
         if (result.dismiss === Swal.DismissReason.timer) {
            load_datadelivery();
         }
      });
      load_datadelivery();
   }

   function delete_delivery(i) {
      const swalWithBootstrapButtons = Swal.mixin({
         customClass: {
            confirmButton: 'btn btn-success mx-1',
            cancelButton: 'btn btn-secondary mx-1'
         },
         buttonsStyling: false
      })
      swalWithBootstrapButtons.fire({
         title: "Hapus Alamat Pengiriman!",
         html: "apakah anda yakin ingin menghapus alamat pengiriman <strong>" + datadelivery[i]["MsCustomerDeliveryReceive"] + "</strong> !",
         icon: "warning",
         allowOutsideClick: false,
         allowEscapeKey: false,
         showCancelButton: true,
         confirmButtonText: "Lanjutkan",
         cancelButtonText: "Tidak",
         reverseButtons: true
      }).then((result) => {
         if (result.isConfirmed) {
            Swal.fire({
               icon: 'success',
               text: 'hapus data berhasil',
               showConfirmButton: false,
               allowOutsideClick: false,
               allowEscapeKey: false,
               timer: 1500,
            }).then((result) => {
               if (result.dismiss === Swal.DismissReason.timer) {
                  datadelivery.splice(i, 1);
                  load_datadelivery();
               }
            });
         }
      })
   }
</script>';