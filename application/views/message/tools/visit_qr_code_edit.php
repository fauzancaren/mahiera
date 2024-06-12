<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-dialog-scrollable modal-xl">
      <div class="modal-content">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;Edit QR Code</h6>
            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body" style="min-height: calc(100vh - 11rem);">
            <div class=" row">
               <div class="col-8">
                  <label for="basic-url" class="form-label">Url Barcode <span class="text-danger">*</span></label>
                  <div class="input-group mb-3">
                     <span class="input-group-text" style="width:auto"><?= site_url("share/qrcode/") ?></span>
                     <input type="text" class="form-control" value="<?= $_data->QrCodeNickName ?>" id="basic-url" aria-describedby="basic-addon3">
                  </div>

                  <label for="basic-url" class="form-label">Barcode Name <span class="text-danger">*</span></label>
                  <div class="input-group mb-3">
                     <input type="text" class="form-control" id="basic-url" value="<?= $_data->QrCodeName ?>" aria-describedby="basic-addon3">
                  </div>
                  <div class="accordion">
                     <div class="accordion-item mt-2">
                        <h2 class="accordion-header" id="panelstay-design-customizations">
                           <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panel-design-customizations" aria-expanded="true" aria-controls="panelstay-design-customizations">
                              <i class="fas fa-icons pe-2"></i> Design & Customizations
                           </button>
                        </h2>
                        <div id="panel-design-customizations" class="accordion-collapse collapse show" aria-labelledby="panelstay-design-customizations">
                           <div class="accordion-body">
                              <div class="mb-1">
                                 <label for="formFileSm" class="form-label">Upload image to change the heading</label>
                                 <input class="form-control form-control-sm" id="qrCodeHeaderImage"  type="file" accept="image/*" onchange="loadFile(event)">
                              </div>

                              <div class="mb-1">
                                 <label for="exampleColorInput" class="form-label">Set Color heading</label>
                                 <input type="color" class="form-control form-control-color" id="colorInput" value="<?= $_data->QrCodeHeadColor ?>" title="Choose your color">
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="accordion-item mt-2">
                        <h2 class="accordion-header" id="panelstay-basic-information">
                           <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panel-basic-information" aria-expanded="true" aria-controls="panelstay-basic-information">
                              <i class="fas fa-info-circle pe-2"></i> Basic Information
                           </button>
                        </h2>
                        <div id="panel-basic-information" class="accordion-collapse collapse show" aria-labelledby="panelstay-basic-information">
                           <div class="accordion-body">
                              <div class="row mb-4">
                                 <div class="col-4">
                                    <label for="formFileHeadline" class="form-label">Headline</label>
                                 </div>
                                 <div class="col-8">
                                    <input class="form-control form-control-sm" id="qrCodeHeadline" value="<?= $_data->QrCodeHeadLine ?>" type="text">
                                 </div>
                              </div>
                              <div class="row mb-3">
                                 <div class="col-4">
                                    <label for="formFileAbout" class="form-label">About Us</label>

                                 </div>

                                 <div class="col-8">
                                    <textarea class="form-control" placeholder="Leave a comment here" id="qrCodeAboutUs"><?= $_data->QrCodeAboutUs ?></textarea>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="accordion-item mt-2">
                        <h2 class="accordion-header" id="panelstay-social-media">
                           <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panel-social-media" aria-expanded="true" aria-controls="panelstay-social-media">
                              <i class="fas fa-bullhorn pe-2"></i></i> Social Media
                           </button>
                        </h2>
                        <div id="panel-social-media" class="accordion-collapse collapse show" aria-labelledby="panelstay-social-media">
                           <div class="accordion-body">
                              <div id="list-sosial-media">
                              </div>
                              <div class="row">
                                 <div class="col-3">
                                    <span>Add more :</span>
                                 </div>
                                 <div class="col-9" style="font-size: 1.5rem;">
                                    <span class="col-form-label">Click on the icon to add a social media profile.</span>
                                    <div class=" d-flex flex-wrap">
                                       <?php
                                       foreach ($this->db->get("TblMsSosialMedia")->result() as $row) {
                                          echo '<div class="d-flex flex-column align-items-center p-1 icon-sosial-media" ';
                                          echo 'data-id="' . $row->MsSosialMediaId . '" ';
                                          echo 'data-name="' . $row->MsSosialMediaName . '" ';
                                          echo 'data-icon=\'' . $row->MsSosialMediaIcon . '\' ';
                                          echo 'data-default-url="' . $row->MsSosialMediaUrlDefault . '" ';
                                          echo 'data-default-text="' . $row->MsSosialMediaTextDefault . '" ';
                                          echo 'data-type="' . $row->MsSosialMediaType . '" ';
                                          echo 'style="min-width: 3rem;max-width: 3rem;">';
                                          echo $row->MsSosialMediaIcon;
                                          echo '<span style="font-size:0.75rem">' . $row->MsSosialMediaName . '</span> </div>';
                                       }
                                       ?>

                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-4 position-relative">
                  <div class="position-absolute">
                     <div class="live-preview-outline">
                        <div class="live-preview" style="overflow: auto; overflow-x: hidden;">
                           <div class="row">
                              <img id="image-preview" src="<?= base_url("asset/image/qrcode/$_data->QrCodeImage") ?>.png" style=" border: none; padding: 0; height: 150px;">
                              </img>

                              <div id="color" style="height: 100px; padding: 10px;">
                                 <div class="row px-3">
                                    <small style="white-space: nowrap; color:white; font-size: medium; font-weight: bold;" id="head"></small>
                                 </div>
                                 <div class="row px-3">
                                    <small style="color:white;" id="aboutUs"></small>

                                 </div>
                              </div>

                              <div class="d-flex flex-column">
                                 <ul class="list-group list-group-flush" id="live-social-media">
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class=" modal-footer">
            <button type="submit" class="btn btn-success" id="btn-submit">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
         </div>
      </div>
   </div>
</div>
<script>
   var arr_sosial_media = [];

   function load_data_sosial() {
      var html = "";
      for (let i = 0; i < arr_sosial_media.length; i++) {
         if (i == 0) {
            var custom_action = '<a onclick="move_down(' + i + ')" class="text-secondary pointer flex-fill" title="View Data"><i class="fas fa-arrow-up"></i></a>'
         }
         html += '   <div class="row sosial-media border-light border-bottom py-3">';
         html += '      <div class="col-2">';
         html += '         <span class="col-form-label">' + arr_sosial_media[i]["QrSosialMediaName"] + '</span>';
         html += '      </div>';
         html += '      <div class="col-1 text-center" style="font-size: 3rem;">';
         html += arr_sosial_media[i]["QrSosialMediaIcon"];
         html += '      </div>';
         html += '      <div class="col-8">';
         html += '           <div class="input-group mb-3">';
         html += '               <span class="input-group-text" id="basic-addon1">' + arr_sosial_media[i]["QrSosialMediaDefaultUrlName"] + ' *</span>';
         html += '               <input type="text" name="QrSocialMediaUrl" class="form-control" placeholder="' + arr_sosial_media[i]["QrSosialMediaDefaultUrl"] + '" aria-label="Username" aria-describedby="basic-addon1" value="' + arr_sosial_media[i]["QrSosialMediaUrl"] + '">';
         html += '           </div>';
         html += '           <div class="input-group mb-3">';
         html += '               <span class="input-group-text" id="basic-addon1">text</span>';
         html += '               <input type ="text" name="QrSocialMediaText" class="form-control" value="' + arr_sosial_media[i]["QrSosialMediaText"] + '" aria-label="Username" aria-describedby="basic-addon1">';
         html += '           </div>';
         html += '      </div>';
         html += '      <div class="col-1 action-sosial-media" style="display:none">';
         html += '         <div class="d-flex flex-column h-100 text-center" >';
         html += '            <a onclick="sm_move_up(' + i + ')" class="text-secondary pointer flex-fill " title="View Data"><i class="fas fa-arrow-up"></i></a>';
         html += '            <a onclick="sm_move_down(' + i + ')" class="text-secondary pointer flex-fill" title="View Data"><i class="fas fa-arrow-down"></i></a>';
         html += '            <a onclick="sm_delete(' + i + ')" class="text-secondary pointer flex-fill" title="View Data"><i class="fas fa-trash-alt"></i></a>';
         html += '         </div>';
         html += '      </div>';
         html += '   </div>';
      };

      $("#list-sosial-media").html(html);

      $(".sosial-media").each(function() {
         $(this).hover(
            function() {
               $(this).find(".action-sosial-media").show("300");
            },
            function() {
               $(this).find(".action-sosial-media").hide();
            }
         );
      });

      $('input[name=QrSocialMediaUrl]').each(function(i, elem) {
         $(this).on('input', function(event) {
            arr_sosial_media[i]["QrSosialMediaUrl"] = this.value;
            load_view_data_sosial();
         });
      });
      $('input[name=QrSocialMediaText]').each(function(i, elem) {
         $(this).on('input', function(event) {
            arr_sosial_media[i]["QrSosialMediaText"] = this.value;
            load_view_data_sosial();
         });
      });
      load_view_data_sosial();

   }

   function load_view_data_sosial() {
      var html = "";
      for (let i = 0; i < arr_sosial_media.length; i++) {
         html += '<li class="list-group-item">';
         html += '      <div class="fa-2x d-inline-block">';
         html += arr_sosial_media[i]["QrSosialMediaIcon"];
         html += '      </div>';
         html += '      <div class="ms-2 d-inline-block">';
         html += '         <div class="fw-bold">' + arr_sosial_media[i]["QrSosialMediaText"] + '</div>';
         html += arr_sosial_media[i]["QrSosialMediaUrl"];
         html += '      </div>';
         html += '   </li>';
      }
      $("#live-social-media").html(html);
   }
   
   sm_move_up = function(id) {
      if (id == 0) return;
      var d = arr_sosial_media[id];
      arr_sosial_media[id] = arr_sosial_media[id - 1];
      arr_sosial_media[id - 1] = d;
      load_data_sosial();
   }

   sm_move_down = function(id) {
      if (id >= arr_sosial_media.length - 1) return;
      var d = arr_sosial_media[id + 1];
      arr_sosial_media[id + 1] = arr_sosial_media[id];
      arr_sosial_media[id] = d;
      load_data_sosial();
   }

   load_data_sosial();

   $(".icon-sosial-media").click(function() {
      var arr = {
         QrSosialMediaType: $(this).data("id"),
         QrSosialMediaUrl: "",
         QrSosialMediaText: $(this).data("default-text"),
         QrSosialMediaDefaultUrl: $(this).data("default-url"),
         QrSosialMediaDefaultUrlName: $(this).data("type"),
         QrSosialMediaDefaultText: $(this).data("default-text"),
         QrSosialMediaIcon: $(this).data("icon"),
         QrSosialMediaName: $(this).data("name"),
      };
      arr_sosial_media.push(arr);
      load_data_sosial();
   });
   // var html = '<div class="row">';
   // html += '<div class="col-2">';
   // html += '   <span class="col-form-label">' + $(this).data("name") + '</span>';
   // html += '</div>';
   // html += '<div class="col-2" style="font-size: 3rem;">';
   // html += $(this).data("icon");
   // html += '</div>';
   // html += '<div class="col-8">';
   // html += '   <div class="input-group mb-3">';
   // html += '      <span class="input-group-text" id="basic-addon1">' + $(this).data("type") + ' *</span>';
   // html += '      <input type ="text" id="textSocialMedia" name="QrSocialMediaUrl" class="form-control" placeholder="' + $(this).data("default-url") + '" aria-label="Username" aria-describedby="basic-addon1">';
   // html += '   </div>';
   // html += '   <div class="input-group mb-3">';
   // html += '      <span class="input-group-text" id="basic-addon1">text</span>';
   // html += '      <input type ="text" name="QrSocialMediaText" class="form-control" value="' + $(this).data("default-text") + '" aria-label="Username" aria-describedby="basic-addon1">';
   // html += '   </div>';
   // html += '</div></div>';
   // $("#list-sosial-media").append(html);

   // // List Sosial Media
   // var listSocialMedia = `
   //    <div class="row container align-items-center" style="overflow-wrap: anywhere;">
   //       <div class="col-2" id="iconSC" style="font-size: 2rem;">
   //          ${$(this).data("icon")}
   //       </div>
   //       <div class="col d-flex flex-column align-items-start justify-content-start">
   //          <div id="urlSC-${$(this).data("name").replaceAll(' ', '-')}"></div>
   //          <div id="textSC-${$(this).data("name").replaceAll(' ', '-')}"></div>
   //       </div>
   //    </div>`;

   // $("#live-social-media").append(listSocialMedia);
   // // END List Social Media

   // $('input[name=QrSocialMediaUrl]').each(function(i, elem) {
   //    let urlName = $("#list-sosial-media").find('span.col-form-label')[i].innerHTML
   //    urlName = urlName.replace(' ', '-');
   //    $(this).on('input', function(event) {
   //       $(`#urlSC-${urlName}`).html(`<strong>${this.value}</strong>`);
   //    });
   // });

   // $('input[name=QrSocialMediaText]').each(function(i, elem) {
   //    let textName = $("#list-sosial-media").find('span.col-form-label')[i].innerHTML
   //    textName = textName.replace(' ', '-');
   //    $(this).on('click', () => {
   //       $(`#textSC-${textName}`).html(this.value);
   //    })

   //    $(this).on('input', function(event) {
   //       $(`#textSC-${textName}`).html(this.value);
   //    });
   // });


   $("#colorInput").change(function(event) {
      $("#color").css("background-color", this.value);
   });

   $("#qrCodeHeadline").on('input', function(event) {
      $("#head").html(this.value);
   });

   $("#qrCodeAboutUs").on('input', function(event) {
      $("#aboutUs").html(this.value);
   });

   var loadFile = function(event) {
      var reader = new FileReader();
      reader.onload = function() {
         var output = document.getElementById('image-preview');
         output.src = reader.result;
      };
      reader.readAsDataURL(event.target.files[0]);
   };

   $("#colorInput").trigger("change");
   $("#qrCodeHeadline").trigger("input");
   $("#qrCodeAboutUs").trigger("input");
</script>