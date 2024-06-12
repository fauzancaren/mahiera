<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-lg ">
      <div class="modal-content" name="create-toko">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-sync-alt"></i></i> &nbsp;Syncron Log Absensi</h5>
            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="row mb-1">
               <label for="MsEmployeeId" class="col-sm-3 col-form-label">Tanggal<sup class="error">&nbsp;*</sup></label>
               <div class="col-sm-9"> 
                  <input type="text" id="AbsenDateAdd" name="AbsenDateAdd" class="form-control form-control-sm" value="">
               </div>
            </div>
            <div class="row mb-1 mt-2">
               <div class="offset-sm-3 col-sm-9 ">
                  <button id="btn-whpst" type="button" class="btn btn-primary btn-sm ms-2">SYNCRON WHPST</button> 
                  <button id="btn-hopst" type="button" class="btn btn-primary btn-sm ms-2 d-none" >SYNCRON HOPST</button> 
               </div>
            </div>
            <textarea class="form-control" name="" cols="30" rows="10" readonly id="logsyncron"></textarea>
         </div>
         <div class="modal-footer"> 
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
         </div> 
      </div>
   </div>
</div> 
<script>
   
   var StartDateContentAdd = moment(); 
   $('#AbsenDateAdd').daterangepicker({
      startDate: StartDateContentAdd, 
      singleDatePicker: true, 
      locale: {
         "format": 'DD/MM/YYYY',
      }
   }, Date_content_add);
   Date_content_add(StartDateContentAdd); 
   function Date_content_add(start) {
      $('#AbsenDateAdd').val(start.format('DD/MM/YYYY'));
      StartDateContentAdd = start;
   }


   async function get_absen_fingerspot() {
      const result = await $.ajax({
         dataType: "json",
         url: "<?= base_url("function/client_data_absen/get_absen_fingerspot/")?>" + StartDateContentAdd.format('YYYY-MM-DD')
      }); 
      return result;
   };
   
   async function add_absen_fingerspot(args) {
      const result = await $.ajax({
         type: "POST",
         dataType: "json",
         data:args,
         url: "<?= base_url("function/client_data_absen/add_absen_fingerspot/")?>"
      }); 
      return result;
   };
   $("#btn-whpst").click(async function(){  
      $("#btn-whpst").prop("disabled",true);
      $("#btn-hopst").prop("disabled",true);
      var myTextArea = $('#logsyncron');
      myTextArea.val('Memulai syncron data  tanggal '+ StartDateContentAdd.format('YYYY-MM-DD') +'\n===========================\nmenghubungkan ke server...\n'); 
      const data = await get_absen_fingerspot(); 
      if(!data["status"]){ 
         myTextArea.val(myTextArea.val() + data["message"] + "\n"); 
         myTextArea.val(myTextArea.val() + data["error"] + "\n");  
         $("#btn-whpst").prop("disabled",false);
         $("#btn-hopst").prop("disabled",false); 
      }else{ 
         myTextArea.val(myTextArea.val() + data["message"] + "\n"); 
         myTextArea.val(myTextArea.val() + "memproses " + data["data"].length + " data absensi\n");  
         for(var i = 0; i < data["data"].length;i++){   
            add_absen_fingerspot((data["data"][i])).then(function(users){   
               $('#logsyncron').val($('#logsyncron').val()+"\t" + users["date"] + " - " + users["name"]  + "\t" + users["status"] + "\n\t" + users["message"] + "\n");
               var psconsole = $('#logsyncron');
               if(psconsole.length)
               psconsole.scrollTop(psconsole[0].scrollHeight - psconsole.height());
            })
         }
         
         myTextArea.val(myTextArea.val() + "+++++++++++++++++++++++++++++++++++++++++++++++++++++ \n");  
         myTextArea.val(myTextArea.val() + "Proses data selesai \n");  
         $("#btn-whpst").prop("disabled",false);
         $("#btn-hopst").prop("disabled",false); 
      }
      //myTextArea.val(myTextArea.val() + data); 
   })
</script>