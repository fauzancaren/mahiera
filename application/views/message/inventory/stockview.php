<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-lg">
      <div class="modal-content" name="form-action">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-exchange-alt text-primary" aria-hidden="true"></i> &nbsp;Log Transaksi</h6>
            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="row justify-content-center">
               <div class="col-12">
                  <div class="card card-delivery select">
                     <div class="card-body">
                        <div class="row">
                           <div class="col-lg-6">
                              <div class="row mb-1 align-items-center">
                                 <label for="MsItemCatId" class="col-3 col-form-label">Kategori</label>
                                 <label for="MsItemCatId" class="col-1 col-form-label">:</label>
                                 <label for="MsItemCatId" class="col-8 fw-bold"><?= $_dataitem->MsItemCatCode . " - " . $_dataitem->MsItemCatName ?></label>
                              </div>
                              <div class="row mb-1 align-items-center">
                                 <label for="MsItemCatId" class="col-3 col-form-label">Nama Item</label>
                                 <label for="MsItemCatId" class="col-1 col-form-label">:</label>
                                 <label for="MsItemCatId" class="col-8 fw-bold"><?= $_dataitem->MsItemCode . " - " . $_dataitem->MsItemName ?></label>
                              </div>
                              <div class="row mb-1 align-items-center">
                                 <label for="MsItemCatId" class="col-3 col-form-label">Vendor</label>
                                 <label for="MsItemCatId" class="col-1 col-form-label">:</label>
                                 <label for="MsItemCatId" class="col-8 fw-bold"><?= $_dataitem->MsVendorCode . " - " . $_dataitem->MsVendorName ?></label>
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class="row mb-1 align-items-center">
                                 <label for="MsItemCatId" class="col-3 col-form-label">Ukuran</label>
                                 <label for="MsItemCatId" class="col-1 col-form-label">:</label>
                                 <label for="MsItemCatId" class="col-8 fw-bold"><?= $_dataitem->MsItemSize ?></label>
                              </div>
                              <div class="row mb-1 align-items-center">
                                 <label for="MsItemCatId" class="col-3 col-form-label">Toko</label>
                                 <label for="MsItemCatId" class="col-1 col-form-label">:</label>
                                 <label for="MsItemCatId" class="col-8 fw-bold"><?= $_dataitem->MsWorkplaceCode ?></label>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

               </div>
               <div class="col-lg-12 col-11 my-1">
                  <div class="row justify-content-center">
                     <div class="col-12 p-2">
                        <div class="row mb-1 align-items-center">
                           <div class="label-border-right mb-3" style="position:relative">
                              <span class="label-dialog">Filter</span>
                           </div>
                        </div>
                        <div class="row mb-1 align-items-center">
                           <label for="stockdate" class="col-sm-3 col-form-label">Tanggal<sup class="error">&nbsp;*</sup></label>
                           <div class="col-sm-9">
                              <input id="stockdate" name="stockdate" type="text" class="form-control form-control-sm" value="">
                           </div>
                        </div>
                     </div>
                     <div class="col-12">
                        <table id="tb_data_item" class="table table-hover align-middle responsive" style='font-family:"Sans-serif", Helvetica; font-size:80%;width:100%'>
                           <thead class="thead-dark">
                              <tr>
                                 <th>Tanggal</th>
                                 <th>Tipe</th>
                                 <th>Ref Code</th>
                                 <th>Stk Awal</th>
                                 <th>Qty</th>
                                 <th>Stk Akhir</th>
                                 <th>Keterangan</th>
                              </tr>
                           </thead>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
         </div>
      </div>
   </div>
</div>
<script>
   var StartDateContent = moment().subtract(60, 'days');
   var EndDateContent = moment();
   $('#stockdate').daterangepicker({
      startDate: StartDateContent,
      endDate: EndDateContent,
      ranges: {
         'Hari ini': [moment(), moment()],
         'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
         'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
         '7 hari yang lalu': [moment().subtract(6, 'days'), moment()],
         '1 Bulan yang lalu': [moment().subtract(1, 'month'), moment()],
         '3 Bulan yang lalu': [moment().subtract(3, 'month').startOf('month'), moment()]
      },
      locale: {
         "format": 'DD/MM/YYYY',
         "customRangeLabel": "Pilih Tanggal Sendiri",
      }
   }, Date_content);
   var page_load = 0;
   Date_content(StartDateContent, EndDateContent);

   function Date_content(start, end) {
      $('#stockdate').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
      StartDateContent = start;
      EndDateContent = end;
      if (page_load > 0) tableajax.ajax.reload(null, false).responsive.recalc().columns.adjust();
      page_load = 1;
   }

   var tableajax = $('#tb_data_item').DataTable({
      "responsive": true,
      "searching": false,
      "lengthChange": false,
      "processing": true,
      "serverSide": true,
      "ajax": {
         "url": "<?php echo site_url('function/client_datatable_inventory/get_data_trans') ?>",
         "type": "POST",
         "data": function(data) {
            data.search['status'] = "<?= $_dataitem->MsWorkplaceId ?>";
            data.search['colstatus'] = "TblInvTrans.MsWorkplaceId";
            data.search['status1'] = "<?= $_dataitem->MsItemId ?>";
            data.search['colstatus1'] = "TblInvTrans.MsItemId";
            data.search['status2'] = "<?= $_dataitem->MsVendorCode ?>";
            data.search['colstatus2'] = "TblInvTrans.MsVendorCode";
            data.search['tanggalstart'] = StartDateContent.format('YYYY-MM-DD');
            data.search['tanggalend'] = EndDateContent.format('YYYY-MM-DD');
            data.search['coltanggal'] = "InvTransDate";
         }
      },
      "ordering": false,
   });

   $('#tb_data').on('processing.dt', function(e, settings, processing) {
      if (processing) {
         // $('#tb_data_respon').hide();
      } else {
         // $('#tb_data_respon').show();
      }
   });
</script>