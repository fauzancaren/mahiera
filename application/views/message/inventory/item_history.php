
<div class="modal fade " id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
   <div class="modal-dialog modal-lg">
      <div class="modal-content" name="form-action">
         <div class="modal-header bg-dark">
            <h6 class="modal-title text-white"><i class="fas fa-exchange-alt text-primary" aria-hidden="true"></i> &nbsp;History Stock</h6>
            <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">

            <div class="row justify-content-center"> 
               <div class="col-lg-12 col-11 my-1"> 
                  <div class="d-flex justify-content-between p-0 p-md-2 card flex-row m-1">
                     <div class="d-flex col-md-5 col-8">
                        <div class="flex-shrink-0"> 
                           <img class="lazy" style="width: 2.5rem; background: rgb(241, 241, 241); padding: 0.25rem; height: 2.5rem; object-fit: contain;" src="<?= $_item["MsProdukImage"] ?>">
                        </div>
                        <div class="flex-grow-1 ms-1 ps-1 ">
                           <div class="fw-bold fs-7"><?= $_item["MsProdukCode"] ?> - <?= $_item["MsProdukName"] ?></div> 
                           <div><span>Kategori : <?= $_item["MsProdukCategory"] ?></span> </div>  
                           <div><span>Toko : <?= $_item["MsWorkplaceCode"] ?></span> </div> 
                        </div>
                     </div>     
                     <div class="font-size-13 col-md-4 col-2 d-flex flex-column">
                        <?php
                           $var = explode("|", $_item["MsProdukVarian"]);
                           for($i = 0; $i < count($var);$i++){
                              echo '<span>Varian '.explode(":", $var[$i])[0].'  : <b>'.explode(":", $var[$i])[1].'</b></span>'; 
                           }

                        ?>  
                     </div>   
                     <div class="font-size-13 col-md-3 col-3 d-flex flex-column justify-content-center text-center ">
                        <span class="bg-secondary bg-opacity-25">Last Stock</span>
                        <span class="bg-secondary bg-opacity-25" id="date-label">(25/05/2023)</span>
                        <span class="bg-secondary bg-opacity-10 fw-bold fs-3" id="qty-label"><?= $_item["MsProdukStockQty"] ?> <?= strtoupper($_item["detail"]["SatuanName"]) ?></span>
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
                           <label for="stockdate" class="col-sm-2 col-form-label">Tanggal<sup class="error">&nbsp;*</sup></label>
                           <div class="col-sm-3">
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
                                 <th><span class="text-success">Qty (+)</span></th>
                                 <th><span class="text-danger">Qty (-)</span></th>
                                 <th>Stk Akhir</th>
                                 <th>Keterangan</th>
                              </tr>
                           </thead>
                           <tbody> 
                              <tr> 
                                 <th scope="row">2023-05-10</th>
                                 <td>PO</td>
                                 <td>ALY/XIII/01/TO-0001/19/V/2023</td>
                                 <td>200</td>
                                 <td>0</td>
                                 <td>180</td>
                                 <td>20</td>
                                 <td>Auto Create by GRPO</td>
                              </tr>
                              <tr> 
                                 <th scope="row">2023-05-10</th>
                                 <td>BR</td>
                                 <td>ALY/XIII/01/GR-0001/19/V/2023</td>
                                 <td>20</td>
                                 <td>0</td>
                                 <td>5</td>
                                 <td>15</td>
                                 <td>Auto Create by GRPO</td>
                              </tr> 
                              <tr> 
                                 <th scope="row">2023-05-10</th>
                                 <td>PO</td>
                                 <td>ALY/XIII/01/TO-0001/19/V/2023</td>
                                 <td>200</td>
                                 <td>0</td>
                                 <td>180</td>
                                 <td>20</td>
                                 <td>Auto Create by GRPO</td>
                              </tr>
                              <tr> 
                                 <th scope="row">2023-05-10</th>
                                 <td>BR</td>
                                 <td>ALY/XIII/01/GR-0001/19/V/2023</td>
                                 <td>20</td>
                                 <td>0</td>
                                 <td>5</td>
                                 <td>15</td>
                                 <td>Auto Create by GRPO</td>
                              </tr> 
                              <tr> 
                                 <th scope="row">2023-05-10</th>
                                 <td>PO</td>
                                 <td>ALY/XIII/01/TO-0001/19/V/2023</td>
                                 <td>200</td>
                                 <td>0</td>
                                 <td>180</td>
                                 <td>20</td>
                                 <td>Auto Create by GRPO</td>
                              </tr>
                              <tr> 
                                 <th scope="row">2023-05-10</th>
                                 <td>BR</td>
                                 <td>ALY/XIII/01/GR-0001/19/V/2023</td>
                                 <td>20</td>
                                 <td>0</td>
                                 <td>5</td>
                                 <td>15</td>
                                 <td>Auto Create by GRPO</td>
                              </tr> 
                              <tr> 
                                 <th scope="row">2023-05-10</th>
                                 <td>PO</td>
                                 <td>ALY/XIII/01/TO-0001/19/V/2023</td>
                                 <td>200</td>
                                 <td>0</td>
                                 <td>180</td>
                                 <td>20</td>
                                 <td>Auto Create by GRPO</td>
                              </tr>
                              <tr> 
                                 <th scope="row">2023-05-10</th>
                                 <td>BR</td>
                                 <td>ALY/XIII/01/GR-0001/19/V/2023</td>
                                 <td>20</td>
                                 <td>0</td>
                                 <td>5</td>
                                 <td>15</td>
                                 <td>Auto Create by GRPO</td>
                              </tr> 
                              <tr> 
                                 <th scope="row">2023-05-10</th>
                                 <td>PO</td>
                                 <td>ALY/XIII/01/TO-0001/19/V/2023</td>
                                 <td>200</td>
                                 <td>0</td>
                                 <td>180</td>
                                 <td>20</td>
                                 <td>Auto Create by GRPO</td>
                              </tr>
                              <tr> 
                                 <th scope="row">2023-05-10</th>
                                 <td>BR</td>
                                 <td>ALY/XIII/01/GR-0001/19/V/2023</td>
                                 <td>20</td>
                                 <td>0</td>
                                 <td>5</td>
                                 <td>15</td>
                                 <td>Auto Create by GRPO</td>
                              </tr> 
                              <tr> 
                                 <th scope="row">2023-05-10</th>
                                 <td>PO</td>
                                 <td>ALY/XIII/01/TO-0001/19/V/2023</td>
                                 <td>200</td>
                                 <td>0</td>
                                 <td>180</td>
                                 <td>20</td>
                                 <td>Auto Create by GRPO</td>
                              </tr>
                              <tr> 
                                 <th scope="row">2023-05-10</th>
                                 <td>BR</td>
                                 <td>ALY/XIII/01/GR-0001/19/V/2023</td>
                                 <td>20</td>
                                 <td>0</td>
                                 <td>5</td>
                                 <td>15</td>
                                 <td>Auto Create by GRPO</td>
                              </tr> 
                              <tr> 
                                 <th scope="row">2023-05-10</th>
                                 <td>PO</td>
                                 <td>ALY/XIII/01/TO-0001/19/V/2023</td>
                                 <td>200</td>
                                 <td>0</td>
                                 <td>180</td>
                                 <td>20</td>
                                 <td>Auto Create by GRPO</td>
                              </tr>
                              <tr> 
                                 <th scope="row">2023-05-10</th>
                                 <td>BR</td>
                                 <td>ALY/XIII/01/GR-0001/19/V/2023</td>
                                 <td>20</td>
                                 <td>0</td>
                                 <td>5</td>
                                 <td>15</td>
                                 <td>Auto Create by GRPO</td>
                              </tr> 
                              <tr> 
                                 <th scope="row">2023-05-10</th>
                                 <td>PO</td>
                                 <td>ALY/XIII/01/TO-0001/19/V/2023</td>
                                 <td>200</td>
                                 <td>0</td>
                                 <td>180</td>
                                 <td>20</td>
                                 <td>Auto Create by GRPO</td>
                              </tr>
                              <tr> 
                                 <th scope="row">2023-05-10</th>
                                 <td>BR</td>
                                 <td>ALY/XIII/01/GR-0001/19/V/2023</td>
                                 <td>20</td>
                                 <td>0</td>
                                 <td>5</td>
                                 <td>15</td>
                                 <td>Auto Create by GRPO</td>
                              </tr> 
                              <tr> 
                                 <th scope="row">2023-05-10</th>
                                 <td>PO</td>
                                 <td>ALY/XIII/01/TO-0001/19/V/2023</td>
                                 <td>200</td>
                                 <td>0</td>
                                 <td>180</td>
                                 <td>20</td>
                                 <td>Auto Create by GRPO</td>
                              </tr>
                              <tr> 
                                 <th scope="row">2023-05-10</th>
                                 <td>BR</td>
                                 <td>ALY/XIII/01/GR-0001/19/V/2023</td>
                                 <td>20</td>
                                 <td>0</td>
                                 <td>5</td>
                                 <td>15</td>
                                 <td>Auto Create by GRPO</td>
                              </tr> 
                              <tr> 
                                 <th scope="row">2023-05-10</th>
                                 <td>PO</td>
                                 <td>ALY/XIII/01/TO-0001/19/V/2023</td>
                                 <td>200</td>
                                 <td>0</td>
                                 <td>180</td>
                                 <td>20</td>
                                 <td>Auto Create by GRPO</td>
                              </tr>
                              <tr> 
                                 <th scope="row">2023-05-10</th>
                                 <td>BR</td>
                                 <td>ALY/XIII/01/GR-0001/19/V/2023</td>
                                 <td>20</td>
                                 <td>0</td>
                                 <td>5</td>
                                 <td>15</td>
                                 <td>Auto Create by GRPO</td>
                              </tr> 
                              <tr> 
                                 <th scope="row">2023-05-10</th>
                                 <td>PO</td>
                                 <td>ALY/XIII/01/TO-0001/19/V/2023</td>
                                 <td>200</td>
                                 <td>0</td>
                                 <td>180</td>
                                 <td>20</td>
                                 <td>Auto Create by GRPO</td>
                              </tr>
                              <tr> 
                                 <th scope="row">2023-05-10</th>
                                 <td>BR</td>
                                 <td>ALY/XIII/01/GR-0001/19/V/2023</td>
                                 <td>20</td>
                                 <td>0</td>
                                 <td>5</td>
                                 <td>15</td>
                                 <td>Auto Create by GRPO</td>
                              </tr> 
                        </tbody>
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
   var dataitem = <?= json_encode($_item) ?>;
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
 
      $("#date-label").html("(" + end.format("DD/MM/YYYY") + ")");
      $('#stockdate').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
      StartDateContent = start;
      EndDateContent = end;
      if (page_load > 0) table.ajax.reload(null, false).responsive.recalc().columns.adjust();
      page_load = 1;
   } 
   var table = $('#tb_data_item').DataTable({
      "responsive": true,
      "searching": false,
      "lengthChange": false, 
      "ordering": false, 
      "pageLength": 5,
      "processing": true,
      "serverSide": true,
      "ajax": {
         "url": "<?php echo site_url('function/Client_datatable_inventory/get_data_history') ?>",
         "type": "POST",
         "data": function(data) { 
            data.search['tanggalstart'] = StartDateContent.format('YYYY-MM-DD');
            data.search['tanggalend'] = EndDateContent.format('YYYY-MM-DD'); 
            data.search['MsProdukStockId'] = <?= $_item["MsProdukStockId"] ?>; 
         }
      },
      "columns": [
         {
            data: 'date',
         },
         {
            data: 'type',
         },
         {
            data: 'ref',
         },
         {
            data: 'stkawal',
            render: function (data, type) {
               if (type === 'display') { 
                  if (data >= 0) {
                     return '<span class="">' + data + '</span>';
                  } else {
                     return '<span class="text-danger">' + data + '</span>';
                  }

               }

               return data;
            },
         },
         {
            data: 'stkpls',
            render: function (data, type) {
               if (type === 'display') { 
                  if (data >= 0) {
                     return '<span class="">' + data + '</span>';
                  } else {
                     return '<span class="text-danger">' + data + '</span>';
                  }

               }

               return data;
            },
         },
         {
            data: 'stkmns',
            render: function (data, type) {
               if (type === 'display') { 
                  if (data >= 0) {
                     return '<span class="">' + data + '</span>';
                  } else {
                     return '<span class="text-danger">' + data + '</span>';
                  }

               }

               return data;
            },
         },
         {
            data: 'stkend',
            render: function (data, type) {
               if (type === 'display') { 
                  
                  if (data >= 0) {
                     return '<span class="">' + data + '</span>';
                  } else {
                     return '<span class="text-danger">' + data + '</span>';
                  }

               }

               return data;
            },
         },
         {
            data: 'desc',
         },
      ],
      "columnDefs": [
         { className: "bg-success bg-opacity-10", "targets": [ 4 ] },
         { className: "bg-danger bg-opacity-10", "targets": [ 5 ] }
      ]
      
      // "columnDefs": [{
      //       "orderable": false,
      //       targets: 0
      //    },
      //    {
      //       "orderable": false,
      //       "width": "20%",
      //       targets: 3
      //    },
      //    {
      //       "orderable": false,
      //       targets: 5
      //    }
      // ],
      // "order": [
      //    [3, "desc"]
      // ] 
   });


   table.on( 'draw', function () {
      if(table.rows().data().length > 0){

         var last_row = table.rows(':last').data();
         console.log(last_row[0]["date"]);

         $("#date-label").html("(" + EndDateContent.format("DD/MM/YYYY") + ")");
         $("#qty-label").html(last_row[0]["stkend"] + " <?= strtoupper($_item["detail"]["SatuanName"]) ?>"); 
      }else{
         
      }
   });
 
</script>