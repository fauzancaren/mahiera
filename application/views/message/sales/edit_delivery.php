<div class="modal fade" id="modal-action-delivery" tabindex="-1" role="dialog" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-dialog-centered">
      <form class="modal-content shadow-lg" name="form-action-delivery">
         <div class="modal-header">
            <h6 class="modal-title "><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp;Edit Alamat Pengiriman</h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <input id="MsCustomerDeliveryId" name="MsCustomerDeliveryId" type="text" class="form-control form-control-sm" value="<?= $_delivery->MsCustomerDeliveryId ?>" style="display:none">
            <div class="row mb-1 align-items-center">
               <label for="MsCustomerDeliveryReceive" class="col-sm-3 col-form-label">Penerima<sup class="error">&nbsp;*</sup></label>
               <div class="col-sm-9">
                  <input id="MsCustomerDeliveryReceive" name="MsCustomerDeliveryReceive" type="text" class="form-control form-control-sm" value="<?= $_delivery->MsCustomerDeliveryReceive ?>" required>
               </div>
            </div>
            <div class="row mb-1 align-items-center">
               <label for="MsCustomerDeliveryTelp" class="col-sm-3 col-form-label">Telp<sup class="error">&nbsp;*</sup></label>
               <div class="col-sm-9">
                  <input id="MsCustomerDeliveryTelp" name="MsCustomerDeliveryTelp" type="text" class="form-control form-control-sm input-phone" value="<?= $_delivery->MsCustomerDeliveryTelp ?>" required>
               </div>
            </div>
            <div class="row mb-1 align-items-center">
               <label for="MsCustomerDeliveryAddress" class="col-sm-3 col-form-label">Alamat<sup class="error">&nbsp;*</sup></label>
               <div class="col-sm-9">
                  <textarea id="MsCustomerDeliveryAddress" name="MsCustomerDeliveryAddress" class="form-control form-control-sm" required><?= $_delivery->MsCustomerDeliveryAddress ?></textarea>
               </div>
            </div>
            <div class="row mb-1 align-items-center">
               <label for="MsCustomerDeliveryMap" class="col-sm-3 col-form-label">Titik Map<br><span class="text-secondary fw-bold">(Optional)</span></label>
               <div class="col-sm-9">
                  <div class="bg-pinpoint">
                     <i class="fas fa-map-marker-alt fa-2x"></i>
                     <span id="MsCustomerDeliveryName" class="label-small px-1"><?= $_delivery->MsCustomerDeliveryName ?></span>
                     <button type="button" class="btn btn-light py-1 ms-auto btn-sm" id="select-map">Tandai Lokasi</button>
                  </div>
                  <input id="MsCustomerDeliveryLat" name="MsCustomerDeliveryLat" type="text" class="form-control form-control-sm" value="<?= $_delivery->MsCustomerDeliveryLat ?>" style="display:none">
                  <input id="MsCustomerDeliveryLng" name="MsCustomerDeliveryLng" type="text" class="form-control form-control-sm" value="<?= $_delivery->MsCustomerDeliveryLng ?>" style="display:none">
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
   var maplocation = {
      lat: -6.265707593132433,
      lng: 106.77526944082672
   };
   var mapaddress = {
      address: "Pondok Pinang, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta, Indonesia"
   };

   var mode = true;
   var modal_utama = "";
   set_modal_action = function(modalutama) {
      $("#modal-action-delivery").modal("show");
      maplocation = {
         lat: <?= $_delivery->MsCustomerDeliveryLng ?>,
         lng: <?= $_delivery->MsCustomerDeliveryLng ?>,
      };
      mapaddress = {
         address: "<?= $_delivery->MsCustomerDeliveryName ?>",
      };
      mode = true;
      modal_utama = modalutama;
   }

   $("#modal-action-delivery").on("hidden.bs.modal", function() {
      console.log("from modal hide", mode);
      if (mode == true) $(modal_utama).modal("show");

   });
   $("#modal-action-delivery").on("shown.bs.modal", function() {
      console.log("from modal show", mode);
   });
   /*
   |
   |    FUNCTION GOOGLE MAP   
   |
   |
   */

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
   $("<div class=\'centerButton\'>Pilih lokasi ini<div/>").appendTo(api_map.getDiv()).click(function() {
      $("#MsCustomerDeliveryName").text(mapaddress.address);
      $("#MsCustomerDeliveryLat").val(maplocation.lat);
      $("#MsCustomerDeliveryLng").val(maplocation.lng);
      $("#modal-action-map").modal("hide");
   });

   // Create the search box and link it to the UI element.
   api_input = document.getElementById("text-pac-input");
   api_map.controls[google.maps.ControlPosition.TOP_LEFT].push(api_input);
   api_searchBox = new google.maps.places.SearchBox(api_input);

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


   $("#select-map").click(function() {
      mode = false;
      console.log("map select ", mode);
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
   $("#modal-action-map").on("hidden.bs.modal", function() {

      mode = true;
      console.log("map hidden ", mode);
      $("#modal-action-delivery").modal("show");
   });

   /*
   |
   |    FUNCTION ACTION 
   |
   |
   */
   var req_status = 0;
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
            $.ajax({
               method: "POST",
               url: "<?= site_url("function/client_data_master/data_cs_delivery_edit/") ?>",
               data: {
                  "MsCustomerDeliveryReceive": $("#MsCustomerDeliveryReceive").val(),
                  "MsCustomerDeliveryTelp": $("#MsCustomerDeliveryTelp").val(),
                  "MsCustomerDeliveryAddress": $("#MsCustomerDeliveryAddress").val(),
                  "MsCustomerDeliveryName": $("#MsCustomerDeliveryName").text(),
                  "MsCustomerDeliveryLat": $("#MsCustomerDeliveryLat").val(),
                  "MsCustomerDeliveryLng": $("#MsCustomerDeliveryLng").val(),
                  "MsCustomerDeliveryId": $("#MsCustomerDeliveryId").val(),
               },
               before: function() {
                  req_status = 1;
                  $("#btn-submit-delivery").html('<i class="fas fa-circle-notch fa-spin"></i> Loading');
               },
               success: function(data) {
                  req_status = 0;
                  $("#btn-submit-delivery").html("Simpan");
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
                           $("#modal-action-delivery").modal("hide");
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
      }
   });
</script>