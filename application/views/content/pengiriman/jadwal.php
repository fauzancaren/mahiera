
<div class="row px-md-2 px-0 py-0">  
   <div class="col-md-2 col-6 input-filter end-input mt-md-2 mt-0"> 
      <select class="custom-select custom-select-sm form-control form-control-sm i-search button" id="tb_store" name="tb_store" style="width:100%;">
               <option value="" selected>Semua Toko</option>
               <?php
               $db = $this->db->where("MsWorkplaceIsActive=1")->get("TblMsWorkplace")->result();
               foreach ($db as $key) {
                  echo '<option value="' . $key->MsWorkplaceId . '"  ' . ($this->session->userdata("MsWorkplaceId") == $key->MsWorkplaceId ? "selected" : "") . '>' . $key->MsWorkplaceCode . '</option>';
               }
               ?>
      </select> 
   </div>
</div>

<div class="row border-bottom pb-2">
   <div class="col-lg-6 col-12">
      <div class="row mb-1">
         <label for="tb_store" class="col-sm-3 col-form-label">Toko</label>
         <div class="col-sm-9">
            <select class="custom-select custom-select-sm form-control form-control-sm" id="tb_store" name="tb_store">
               <option value="-" selected>Semua Toko</option>
               <?php
               $this->db->where("MsWorkplaceIsActive", "1");
               $query = $this->db->get('TblMsWorkplace')->result();
               foreach ($query as $key) {
                  echo '<option value="' . $key->MsWorkplaceId . '">' . $key->MsWorkplaceCode . '</option>';
               }
               ?>
            </select>
         </div>
      </div>
      <div class="row mb-1">
         <label for="tb_armada" class="col-sm-3 col-form-label">Pengiriman</label>
         <div class="col-sm-9">
            <select class="custom-select custom-select-sm form-control form-control-sm" id="tb_armada" name="tb_armada">
               <option value="-" selected>Semua Pengiriman</option>
               <?php
               $this->db->where("MsDeliveryIsActive", "1");
               $query = $this->db->get('TblMsDelivery')->result();
               foreach ($query as $key) {
                  echo '<option value="' . $key->MsDeliveryId . '">' . $key->MsDeliveryName . '</option>';
               }
               ?>
            </select>
         </div>
      </div>
      <div class="row mb-1">
         <label for="tb_date" class="col-sm-3 col-form-label">Pencarian</label>
         <div class="col-sm-9">
            <input type="text" class="form-control form-control-sm" id="tb_search" placeholder="Cari nama customer/kode pengiriman">
         </div>
      </div>
   </div>
</div>


<div id="wait" class="load-container load4" style="display: block;">
   <div class="load-progress"></div>
</div>
<div id="data-calendar">
</div>

<div id="dialog-box">
</div>

<script>
   $(document).ready(function() {
      var req;
      var _date = moment();
      load_schedule = function() {
         $("#data-calendar").hide();
         $("#wait").show();
         if (req && req.readyState != 4) {
            req.abort();
         }
         req = $.ajax({
            type: "POST",
            url: "<?php echo site_url('function/client_data_pengiriman/build_calendar/') ?>",
            data: {
               "month": _date.format('M'),
               "year": _date.format('YYYY'),
               "store": $("#tb_store").val(),
               "armada": $("#tb_armada").val(),
               "search": $("#tb_search").val(),
            },
            success: function(data) {
               $("#wait").hide();
               $("#data-calendar").html(data);
               $("#data-calendar").show();
               // $.contextMenu({
               //    selector: '.more-option', 
               //    callback: function(key, options) {
               //       var m = "clicked: " + key;
               //       window.console && console.log(m) || alert(m); 
               //    },
               //    items: {
               //       "edit": {name: "Edit", icon: "edit"},
               //       "cut": {name: "Cut", icon: "cut"},
               //       copy: {name: "Copy", icon: "copy"},
               //       "paste": {name: "Paste", icon: "paste"},
               //       "delete": {name: "Delete", icon: "delete"},
               //       "sep1": "---------",
               //       "quit": {name: "Quit", icon: function(){
               //          return 'context-menu-icon context-menu-icon-quit';
               //       }}
               //    }
               // });

               // $('.more-option').on('click', function(e){
               //       console.log('clicked', this);
               // })    
               
               console.log("loop context menu");
               $(function() {
                  $(".del-list").each(function() {
                     console.log("loop context menu");
                     $(this).contextMenu({
                        selector: '.more-option',
                        trigger: 'left',
                        callback: function(key, options) {
                           if (key == "view") {
                              view_detail($(this).parent().parent().data("id"));
                           } else if (key == "print") {
                              print_detail($(this).parent().parent().data("id"));
                           } else if (key == "date") {
                              change_date_detail($(this).parent().parent().data("id"));
                           } else if (key == "delete") {
                              delete_detail($(this).parent().parent().data("id"));
                           }
                        },
                        items: {
                           "view": {
                              name: "Detail Pengiriman",
                              icon: "view"
                           },
                           "sep1": "---------",
                           "date": {
                              name: "Ganti Tanggal",
                              icon: "date"
                           },
                           "sep2": "---------",
                           "delete": {
                              name: "Hapus Pengiriman",
                              icon: "delete"
                           },
                        }
                     });
                  });
               });
            }
         });
      };
      load_schedule();
      prev = function() {
         _date = moment(_date.format('YYYY-MM-DD')).subtract(1, 'months');
         //alert(_date);
         load_schedule();
      }
      next = function() {
         _date = moment(_date.format('YYYY-MM-DD')).add(1, 'months');
         //alert(_date);
         load_schedule();
      }
      $("#tb_store, #tb_armada").change(function() {
         load_schedule();
      });
      $("#tb_search").keyup(function() {
         load_schedule();
      });

      print_detail = function(id) {
         window.open('<?php echo site_url('export/datasales/delivery/') ?>' + id, '_blank');
      }
      view_detail = function(id) {
         $.ajax({
            url: "<?= site_url('message/message_pengiriman/view_pengiriman/') ?>" + id,
            success: function(response) {
               $("#dialog-box").html(response);
               modal_action = new bootstrap.Modal(document.getElementById('modal-action'));
               modal_action.show();
            },
            error: function(xhr, status, error) {
               console.log(xhr.responseText);
            }
         });
      };
      change_date_detail = function(id) {
         $.ajax({
            url: "<?= site_url('message/message_pengiriman/ganti_pengiriman/') ?>" + id,
            success: function(response) {
               $("#dialog-box").html(response);
               modal_action = new bootstrap.Modal(document.getElementById('modal-action'));
               modal_action.show();
            },
            error: function(xhr, status, error) {
               console.log(xhr.responseText);
            }
         });
         // $.ajax({
         //    method: "POST",
         //    dataType: "json",
         //    url: "<?= site_url("function/client_data_sales/get_data_delivery/") ?>" + id,
         //    success: function(data) {
         //       const swalWithBootstrapButtons = Swal.mixin({
         //          customClass: {
         //             confirmButton: 'btn btn-success mx-1',
         //             cancelButton: 'btn btn-secondary mx-1'
         //          },
         //          buttonsStyling: false
         //       });
         //       swalWithBootstrapButtons.fire({
         //          html: data,
         //          confirmButtonText: "Simpan",
         //          cancelButtonText: "Batal",
         //          showCancelButton: true,
         //          reverseButtons: false
         //       }).then((result) => {
         //          if (result.isConfirmed) {
         //             $.ajax({
         //                method: "POST",
         //                data: {
         //                   "date": $("#DeliveryDate").val()
         //                },
         //                url: "<?= site_url("function/client_data_sales/data_delivery_change_date/") ?>" + id,
         //                success: function(data) {
         //                   if (data) {
         //                      Swal.fire({
         //                         icon: 'success',
         //                         text: 'Batalkan data berhasil',
         //                         showConfirmButton: false,
         //                         allowOutsideClick: false,
         //                         allowEscapeKey: false,
         //                         timer: 1500,
         //                      }).then((result) => {
         //                         if (result.dismiss === Swal.DismissReason.timer) {

         //                            table.ajax.reload(null, false).responsive.recalc().columns.adjust();
         //                         }
         //                      });
         //                   } else {
         //                      Swal.fire({
         //                         icon: 'error',
         //                         text: 'Batalkan data gagal',
         //                         showConfirmButton: false,
         //                         allowOutsideClick: false,
         //                         allowEscapeKey: false,
         //                         timer: 1500
         //                      });
         //                   }
         //                }
         //             });
         //          }
         //       });
         //    }
         // });

      }
      delete_detail = function(id) {
         $.ajax({
            url: "<?php echo site_url('function/client_data_sales/get_delivery_code/') ?>" + id,
            success: function(response) {
               const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                     confirmButton: 'btn btn-success mx-1',
                     cancelButton: 'btn btn-secondary mx-1'
                  },
                  buttonsStyling: false
               });
               swalWithBootstrapButtons.fire({
                  title: "Batalkan pengiriman",
                  html: 'Anda yakin ingin membatalkan pengiriman <b>' + response + '</b> ?',
                  icon: "warning",
                  allowOutsideClick: false,
                  allowEscapeKey: false,
                  showCancelButton: true,
                  confirmButtonText: "Lanjutkan",
                  cancelButtonText: "Tidak",
                  reverseButtons: false
               }).then((result) => {
                  if (result.isConfirmed) {
                     $.ajax({
                        method: "POST",
                        url: "<?= site_url("function/client_data_sales/data_delivery_remove/") ?>" + id,
                        success: function(data) {
                           if (data) {
                              Swal.fire({
                                 icon: 'success',
                                 text: 'Batalkan data berhasil',
                                 showConfirmButton: false,
                                 allowOutsideClick: false,
                                 allowEscapeKey: false,
                                 timer: 1500,
                              }).then((result) => {
                                 if (result.dismiss === Swal.DismissReason.timer) {

                                    table.ajax.reload(null, false).responsive.recalc().columns.adjust();
                                 }
                              });
                           } else {
                              Swal.fire({
                                 icon: 'error',
                                 text: 'Batalkan data gagal',
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
            },
            error: function(xhr, status, error) {
               console.log(xhr.responseText);
            }
         });
      }
   });
</script>