<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-xl">
      <div class="modal-content" name="form-action">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;Tambah Ritase Pengiriman</h6>
            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">   
            <div class="row">
               <div class="col-md-7 col-12">
                  <div class="row mb-1 align-items-center">
                     <label for="DeliveryRitDate" class="col-sm-3 col-form-label">Tanggal Pengiriman<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-9">
                        <input id="DeliveryRitDate" name="DeliveryRitDate" type="text" class="form-control form-control-sm" value="">
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="DeliveryRitArmada" class="col-sm-3 col-form-label">Armada<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-9">
                        <select class="custom-select custom-select-sm form-control form-control-sm" id="DeliveryRitArmada" name="DeliveryRitArmada"> 
                           <option value="engkel">Engkel</option>
                           <option value="pickup">Pickup</option> 
                        </select>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center">
                     <label for="DeliveryRitUser" class="col-sm-3 col-form-label">Karyawan<sup class="error">&nbsp;*</sup></label>
                     <div class="col-sm-9">
                        <select class="custom-select custom-select-sm form-control form-control-sm" id="DeliveryRitUser" name="DeliveryRitUser" style="width:100%" multiple="multiple" required> 
                           <?php
                           $db = $this->db->where("MsEmpIsActive=1")->order_by("MsWorkplaceId ASC,MsEmpId ASC")->get("TblMsEmployee")->result();
                           
                           foreach ($db as $key) { 
                              echo '<option value="' . $key->MsEmpId . '">' . $key->MsEmpName . '</option>'; 
                           } 
                           ?>
                        </select>
                     </div>
                  </div>
                  <div class="row mb-1 align-items-center mt-2"> 
                     <div class="label-border-right mb-3" style="position:relative">
                        <span class="label-dialog">List Delivery</span>
                        <button class="btn btn-success btn-sm py-1 me-1 rounded-pill" id="add-item" type="button" style="position:absolute;top: -11px;right: -5px;font-size: 0.6rem;">
                           <i class="fas fa-plus" aria-hidden="true"></i>
                           <span class="fw-bold">
                              &nbsp;Tambah List Pengiriman
                           </span>
                        </button>
                     </div> 
                  </div>
                  <div id="list-data" style="max-height: 50vh;  min-height: 50vh; overflow: auto; padding: 12px;"></div> 

               </div>
               <div class="col-md-5 col-12"> 
                  <div id="map" style="height: 100%;"></div>
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

<div class="modal fade " id="modal-action-delivery" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-lg ">
      <div class="modal-content" name="form-action-armada">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-search text-primary" aria-hidden="true"></i> &nbsp;Direction Pengiriman</h5>
            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="row mb-1 align-items-center">
               <label for="search-data-delivery" class="col-form-label">Pencarian<sup class="error">&nbsp;*</sup></label>
               <div class="col">
                  <input id="search-data-delivery" name="search-data-delivery" type="text" class="form-control form-control-sm" value="" placeholder="cari nama customer/no delivery/nama item">
               </div>
            </div> 
            <div id="wait" class="load-container load4" style="display: block;">
               <div class="load-progress"></div>
            </div>
            <div id="tb_data_delivery" style="display: none;max-height:400px;overflow-y: auto;">
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
         </div>
      </div>
   </div>
</div>
 
<script> 
 
   var markersArray = [];
   var maplocation = {
      lat: -6.353237,
      lng: 106.766167
   }; 
   api_map = new google.maps.Map(document.getElementById("map"), {
      center: maplocation,
      zoom: 10,
      zoomControl: true,
      keyboardShortcuts: false,
      disableDefaultUI: true,
      clickableIcons: false, 
      mapTypeId: google.maps.MapTypeId.ROADMAP
   });   
   
   $("#map").append(`<div id="info-map" style="padding:1rem;position: absolute; width: 18rem;  background: #ffffff9e; border-radius: 1rem; height: auto; top: 5px; left: 5px;"></div>`);

   var array_list = [];


   $("#DeliveryRitUser").select2({ dropdownParent: $("#modal-action .modal-content")});
   var datestartrit = moment();
   $("#DeliveryRitDate").daterangepicker({
      singleDatePicker: true,
      startDate: datestartrit,
      showDropdowns: true,
      locale: {
         "format": "DD/MM/YYYY",
         "customRangeLabel": "Pilih Tanggal Sendiri",
      }
   }, function(start, end) {
      datestartrit = start;
   });
   load_data_list();
   function load_data_list(){ 
      var no = 0;
      var html = "";
      for(var i = 0; i < array_list.length;i++){
         var item = "";
         for(var j = 0;j < array_list[i]["detail"].length;j++){
            item += `<div class="row align-items-center border-light border-bottom border-top me-1 py-1">
                        <div class="col-6">
                           <span class="text-dark fw-bold" style="font-size:0.7rem;">${array_list[i]["detail"][j]["MsItemCode"]}-${array_list[i]["detail"][j]["MsItemName"]}</span><br>
                           <span class="text-secondary">Ukuran : <span class="text-dark fw-bold" style="font-size:0.7rem;">${array_list[i]["detail"][j]["MsItemSize"]}</span></span>
                        </div>
                        <div class="col-3">
                           <span class="text-secondary">Vendor</span><br>
                           <span class="text-dark fw-bold" style="font-size:0.7rem;">${array_list[i]["detail"][j]["MsVendorCode"]}</span>
                        </div>
                        <div class="col-3 text-right">
                           <span class="text-secondary">Qty</span><br>
                           <span class="text-dark fw-bold" style="font-size:0.7rem;">${array_list[i]["detail"][j]["DeliveryDetailQty"]} ${array_list[i]["detail"][j]["MsItemUoM"]}</span>
                        </div>
                     </div>`;
         }
         no++;
         html +=  `
               <div class="list-ritase pb-2">
                  <div class="list-number">${no}</div>
                  <div class="card shadow-sm card-delivery mt-0">
                     <div class="row">
                        <div class="col-sm-5">
                           <input id="DeliveryId" value="${array_list[i]["header"]["DeliveryId"]}" style="display:none">  
                           <div class="p-2 ps-3">      
                              <span class="text-secondary label-span">No. Sales</span><span class="card-title ">${array_list[i]["header"]["DeliveryRef"]}</span><br>  
                              <span class="text-secondary label-span">No. Delivery</span><span class="card-title ">${array_list[i]["header"]["DeliveryCode"]}</span><br>    
                              <span class="text-secondary label-span">Penerima</span><span class="card-title ">${array_list[i]["header"]["MsCustomerDeliveryReceive"]}</span><br>     
                              <span class="text-secondary label-span">Telp.</span><span class="card-title ">${array_list[i]["header"]["MsCustomerDeliveryTelp"]}</span><br>    
                           </div>  
                        </div>
                        <div class="col-sm-7 p-2 pe-4">
                           <span class="text-secondary">Alamat :</span><br>      
                           <span class="card-text">${array_list[i]["header"]["MsCustomerDeliveryAddress"]}</span><br>      
                           <div class="bg-pinpoint">
                              <i class="fas fa-map-marker-alt fa-2x"></i>
                              <span class="label-small px-1">${array_list[i]["header"]["MsCustomerDeliveryName"]}</span></span>
                              <a class="btn btn-light py-1 ms-auto btn-sm" href="https://maps.google.com/?q=${array_list[i]["header"]["MsCustomerDeliveryLat"]},${array_list[i]["header"]["MsCustomerDeliveryLng"]}" target="_blank" style="min-width: 5rem;">Lihat Map</a>
                           </div>
                        </div>
                     </div>
                     <div class="row px-4 pb-2">
                        <div class="col-md-12 d-flex flex-column " style="border: 1px solid #d2cac0;border-radius: 0.25rem;">
                           ${item}
                        </div>
                     </div> 
                     <div class="flex-row ms-4 card-delivery-action my-1 p-2" style="display: flex;">      
                        <a class="action-label text-success" onclick="bottom_data_delivery(${i})"><i class="fas fa-arrow-down pe-2"></i>Pindahkan kebawah</a>      
                        <div class="action-space"></div>      
                        <a class="action-label text-primary" onclick="top_data_delivery(${i})"><i class="fas fa-arrow-up pe-2"></i>Pindahkan keatas</a>     
                        <div class="action-space"></div>      
                        <a class="action-label text-danger" onclick="delete_data_delivery(${i})"><i class="fas fa-trash pe-2"></i>Hapus dari list pengiriman</a>     
                     </div>
                  </div> 
               </div> `;
      }
      if(html.length == 0){
         $("#list-data").html(`<div class="d-flex justify-content-center"> <h6 class="text-secondary">Tidak ada data</h6></div>`);
      }else{

         $("#list-data").html(html);
      }
      load_marker();
   }
   $("#btn-submit").click(function() {
      if (typeof window.ajaxRequestSingle !== "undefined") {
         window.ajaxRequestSingle.abort();
      }

      window.ajaxRequestSingle = $.ajax({
         method: "POST",
         url: "<?= site_url("function/client_data_sales/data_delivery_date/") ?>",
         data: {
            "DeliveryDate": moment(datestartrit).format('YYYY-MM-DD'),
         },
         success: function(data) {
            $("#btn-submit").html("Simpan");
            console.log(data);
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
                     load_schedule();
                     $("#modal-action").modal("hide");
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
   });
   $("#add-item").click(function(){ 
      $("#modal-action-delivery").modal("show");
      $("#modal-action").modal("hide");
   }) 
   $("#modal-action-delivery").on("hidden.bs.modal", function() {
      $("#modal-action").modal("show");
   });    
   $("#modal-action-delivery").on("shown.bs.modal", function() {
      load_data_delivery();
   }); 

   /* load data */
   $("#search-data-delivery").keyup(function(){
      load_data_delivery();
   })     
   load_data_delivery = function() {
      var list_code = [];
      for(var i = 0; i < array_list.length;i++){
         list_code.push(array_list[i]["header"]["DeliveryCode"]);
      }
      $("#wait").show();
      $("#tb_data_delivery").hide(); 
      $.ajax({
         type: "POST",
         url: "<?php echo site_url('function/client_datatable_pengiriman/get_data_pengiriman_ref/') ?>",
         data: {
            "search": $("#search-data-delivery").val(),
            "tanggal": datestartrit.format("YYYY-MM-DD"),
            "exception": list_code,
         },
         success: function(response) {
            $("#tb_data_delivery").html(response);
            $("#wait").hide();
            $("#tb_data_delivery").show();
         },
         error: function(xhr, status, error) {
            console.log(xhr.responseText); 
         }
      });
   }
   delivery_select = function(id){ 
      $("#modal-action-delivery").modal("hide");
      $.ajax({
         dataType: "json",
         type: "POST",
         url: "<?php echo site_url('function/client_datatable_pengiriman/get_data_delivery/') ?>" +id, 
         success: function(response) {  
            array_list.push(response); 
            load_data_list();
         },
         error: function(xhr, status, error) {
            console.log(xhr.responseText); 
         }
      });
   }
   function move(array, oldIndex, newIndex) {
      if (newIndex >= array.length) {
         newIndex = array.length - 1;
      }
      array.splice(newIndex, 0, array.splice(oldIndex, 1)[0]);
      return array;
   }
   bottom_data_delivery = function(id){
      if(id!=array_list.length - 1){
         var nextid = id++;
         const element = array_list.splice(id, 1)[0]; 
         array_list.splice(nextid, 0, element);  
         load_data_list(); 
      }
   }
   top_data_delivery = function(id){
      if(id!=0) {
         var nextid = id--;
         const element = array_list.splice(id, 1)[0]; 
         array_list.splice(nextid, 0, element);  
         load_data_list(); 
      }
   }
   delete_data_delivery = function(id){
      array_list.splice(id, 1)
      load_data_list(); 
   }

   //Initialize the Direction Service 
   var service = new google.maps.DirectionsService();  

   var directionsRenderer = new google.maps.DirectionsRenderer({
      map: api_map,
      suppressMarkers : true,
      preserveViewport: true
   }); 
   function load_marker(){  
      $("#info-map").html("");
      if (markersArray) {
         for (i in markersArray) {
            markersArray[i].setMap(null);
         }
      }  
      markersArray.length = 0; 
      var marker_home = new google.maps.Marker({
         position: maplocation,
         map: api_map, 
         label: {
            text: "\ue88a", // codepoint from https://fonts.google.com/icons
            fontFamily: "Material Icons",
            color: "#ffffff",
            fontSize: "20px",
         },
         title: "Start"
      }); 
      markersArray.push(marker_home);

      if(array_list.length == 0) return; 

      var infoWindow = new google.maps.InfoWindow();
      var lat_lng = new Array();
      var latlngbounds = new google.maps.LatLngBounds();


      for(var i = 0; i < array_list.length;i++){
         var number = i + 1;
         var data = array_list[i]["header"]; 
         var myLatlng = new google.maps.LatLng(data.MsCustomerDeliveryLat, data.MsCustomerDeliveryLng);
         lat_lng.push(myLatlng);
         var marker = new google.maps.Marker({
            position: myLatlng,
            map: api_map,
            label: {
               text: number.toString(), 
               color: "#ffffff",
               fontFamily: "Roboto",
               fontSize: "18px", 
            },
            title: data.MsCustomerDeliveryReceive
         });  
         markersArray.push(marker);
         latlngbounds.extend(marker.position);
         (function(marker, data) {
            google.maps.event.addListener(marker, "click", function(e) {
               infoWindow.setContent(data.MsCustomerDeliveryReceive);
               infoWindow.open(api_map, marker);
            });
         })(marker, data);
      }

 
      var  waypts = [];
      for (var i = 1; i < markersArray.length - 1; i++) { 
         waypts.push({
            location: markersArray[i].position,
            stopover: true,
         }); 
      }
      service.route({
         origin: markersArray[0].position,
         destination: markersArray[markersArray.length-1].position,
         waypoints: waypts,  
         travelMode: google.maps.TravelMode.DRIVING,
      })
      .then((response) => {
         directionsRenderer.setDirections(response);
         for (i in response.routes[0].legs) { 
            if(i==0){
               var icon = `<i class="fas fa-home px-2"></i><i class="fas fa-long-arrow-alt-right px-2"></i><span class="fw-bold px-2 pe-4">${1}</span>`;
            }else{
               var next = i;
               next++;
               var icon = `<span class="fw-bold px-2">${i}</span><i class="fas fa-long-arrow-alt-right px-2"></i><span class="fw-bold px-2 pe-4">${next}</span>`;
            }
            console.log(response.routes[0].legs[i]);
            $("#info-map").append(icon + response.routes[0].legs[i].distance.text + "(" + response.routes[0].legs[i].duration.text + ")<br>");
         } 
         setTimeout(function() {  
            api_map.setCenter(latlngbounds.getCenter());
            api_map.fitBounds(latlngbounds); 
            api_map.setZoom(10); 
         }, 200);
      })
      .catch((e) => window.alert("Directions request failed due to " + e)); 

   }
  
</script>