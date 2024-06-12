<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-dialog-centered">
      <form class="modal-content" name="form-action">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-plus text-success" aria-hidden="true"></i> &nbsp;Performa Invoice</h6>
            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="row mb-1 align-items-center">
               <label for="PerformaDate" class="col-sm-3 col-form-label">Tanggal</label>
               <div class="col-sm-9 ">
                  <input id="PerformaDate" name="PerformaDate" type="text" class="form-control form-control-sm" value="" placeholder="Cari data penawaran">
               </div>
            </div>
            <div class="row mb-1 align-items-center">
               <label for="MsMethodId" class="col-sm-3 col-form-label">Metode</label>
               <div class="col-sm-9">
                  <select class="custom-select custom-select-sm form-control form-control-sm select-modal" id="MsMethodId" name="MsMethodId" style="width:100%">
                     <?php
                     $db = $this->db->where("MsMethodIsActive=1")->get("TblMsMethod")->result();
                     foreach ($db as $key) {
                        echo '<option value="' . $key->MsMethodId . '">' . $key->MsMethodCode . ' - ' . $key->MsMethodName . '</option>';
                     }
                     ?>
                  </select>
               </div>
            </div>
            <div class="row mb-1 align-items-center">
               <label for="PerformaCardName" class="col-sm-3 col-form-label">Nama</label>
               <div class="col-sm-9">
                  <input id="PerformaCardName" name="PerformaCardName" type="text" class="form-control form-control-sm" value="<?= $customer ?>" placeholder="Masukan Nama ">
               </div>
            </div>
            <div class="row mb-1 align-items-center">
               <label for="PerformaType" class="col-sm-3 col-form-label">(DP)</label>
               <div class="col-sm-9">
                  <input class="form-check-input" type="checkbox" value="" id="PerformaType" name="PerformaType" checked>
               </div>
            </div>
            <div class="row mb-1 align-items-center">
               <label for="PerformaTotal" class="col-sm-3 col-form-label">Total</label>
               <div class="col-sm-9">
                  <input id="PerformaTotal" name="PerformaTotal" type="text" class="form-control form-control-sm price-modal" value="<?= $sisa ?>" placeholder="Masukan Total">
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="submit" class="btn btn-success" id="btn-submit">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
         </div>
      </form>
   </div>
</div>
<script>
   var salesref = "";
   set_ref = function(name) {
      salesref = name;
   }

   var salesref = "";
   var PaymentId = 0;
   var refsales = <?= JSON_ENCODE($ref) ?>; 

   if(refsales){ 
      $("#MsMethodId").val(refsales["MsMethodId"]);
      $("#PerformaTotal").val(refsales["PaymentTotal"]); 
      (refsales["PaymentType"] == "D" ?  $("#PerformaType").prop("checked",true) :  $("#PerformaType").prop("checked",false));
      PaymentId = refsales["PaymentId"];
   }
   $("#Performafile").hide();
   $("#Performaupload").show();
   var datestart = moment();
   /*  TANGGAL DOKUMENT */
   $("#PerformaDate").daterangepicker({
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
   /*  ARRAY SELECT */
   var selectArrays = Array.from(document.getElementsByClassName("select-modal"));
   selectArrays.forEach(function(SelectArray) {
      $(SelectArray).select2({
         dropdownParent: $("#modal-action .modal-content")
      });
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

   var req_status_add = 0;
   $(function() {
      $("form[name='form-action']").validate({
         rules: {
            PerformaDate: "required",
            MsMethodId: "required",
            PerformaCardName: "required",
            PerformaTotal: "required",

         },
         messages: {
            PerformaDate: "Pilih tanggal terlebih dahulu",
            MsMethodId: "pilih methode pembayaran",
            PerformaCardName: "masukan nama customer",
            PerformaTotal: "masukan total pembayaran",
         },
         submitHandler: function(form) {
            if (!req_status_add) {
               $("#btn-submit").html('<i class="fas fa-circle-notch fa-spin"></i> Loading');
               $.ajax({
                  method: "POST",
                  url: "<?= site_url("function/client_data_sales/data_sales_performa_add") ?>",
                  data: {
                     "PerformaDate": moment(datestart).format('YYYY-MM-DD'),
                     "MsMethodId": $("#MsMethodId").val(),
                     "PerformaCardName": $("#PerformaCardName").val(),
                     "PerformaType": ($('#PerformaType').is(":checked") ? "1" : "0"),
                     "PerformaTotal": parseInt($("#PerformaTotal").val().replaceAll(",", "")),
                     "PerformaRef": "<?= $code ?>",
                     "PaymentId": PaymentId,
                  },
                  before: function() {
                     req_status_add = 1;
                  },
                  success: function(data) {
                     req_status_add = 0;
                     $("#btn-submit").html("Simpan");

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

                              $.redirect('<?php echo site_url('export/datasales/performa/-') ?>', {
                                 'code': "<?= $code ?>",
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
               return false;
            }
         }
      });
   });
</script>