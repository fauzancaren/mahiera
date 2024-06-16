<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" name="form-action">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp;Ganti Logo/Header Quotation</h6>
            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="row mb-1 align-items-center">
               <div class="col">
                  <div class="form-check form-check-inline"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="MAHIERA GLOBAL SOLUTION">
                     <input class="form-check-input" type="radio" name="Quoheader" id="Quoheader1" value="1" >
                     <label class="form-check-label" for="Quoheader1">
                        <img src="<?=base_url("asset/image/logo/logo-1-200.png")?>" class="rounded" width="50">
                     </label>
                  </div>
                  <div class="form-check form-check-inline"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="ROSTER REGULER JAKARTA">
                     <input class="form-check-input" type="radio" name="Quoheader" id="Quoheader2" value="2">
                     <label class="form-check-label" for="Quoheader2"><img src="<?=base_url("asset/image/logo/logo-2-200.png")?>" class="rounded" width="50"></label>
                  </div>
                  <div class="form-check form-check-inline"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="BATA REGULER JAKARTA">
                     <input class="form-check-input" type="radio" name="Quoheader" id="Quoheader3" value="3">
                     <label class="form-check-label" for="Quoheader3"><img src="<?=base_url("asset/image/logo/logo-3-200.png")?>" class="rounded" width="50"></label>
                  </div> 
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="submit" class="btn btn-success"   id="btn-submit"        >Pilih</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
         </div>
      </div>
   </div>
</div>
<script>
   $("[data-bs-toggle='tooltip']").tooltip();
   $("input[name='Quoheader'][value='<?=$value?>']").prop('checked', true);
   $("#btn-submit").click(function(){
      if(typeof window.ajaxRequestSingle !== "undefined"){
         window.ajaxRequestSingle.abort();
      }
      window.ajaxRequestSingle = $.ajax({
         method: "POST",
         url: "<?=site_url("function/client_data_sales/data_quotation_header/").$id.'/'?>"+ $("input[name='Quoheader']:checked").val(),
         success: function(data) {
            req_status_add = 0;
            $("#btn-submit").html("Simpan");
            console.log(data);
            if(data){
               Swal.fire({
                  icon: 'success',
                  text: 'Perubahan data header berhasil disimpan',
                  showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                  timer: 1500,
               }).then((result) => {
                  if (result.dismiss === Swal.DismissReason.timer) {
                     load_data_table_quotation();
                  }
               });
            }else{
               Swal.fire({
                  icon: 'error',
                  text: 'Perubahan data header gagal disimpan',
                  showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                  timer: 1500
               });
            }
         }
      });
      
   });
</script>
