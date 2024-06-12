<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <style>
      td.details-control:before {
         content: "\f542";
         font-family: "Font Awesome 5 Free";
         font-weight: 600;
         position: relative;
         float: right;
      }

      tr.shown td.details-control:before {
         content: "\f14a";
         color: #ff9a00;
         font-family: "Font Awesome 5 Free";
         font-weight: 600;
         position: relative;
         float: right;
      }
      .select2-results__option .wrap:before{
         font-family: "Font Awesome 5 Free";
         color: #ff9a00;
         content:"\f0c8";
         width:25px;
         height:25px;
         padding-right: 10px;
         
      } 
      .select2-results__option--selected .wrap:before{
         font-family: "Font Awesome 5 Free";
         color: #ff9a00;
         content:"\f14a";
         width:25px;
         height:25px;
         padding-right: 10px;
         
      } 
   </style>
</head>

<body>
   <section class="content-header">
      <div class="row mb-2">
         <div class="col-md-auto col-12">
            <h2>Data Stock</h1>
         </div>
         <div class="col align-self-end">
            <ol class="breadcrumb float-md-end">
               <li class="breadcrumb-item">Inventory</li>
               <li class="breadcrumb-item active">Data Stock</li>
            </ol>
         </div>
      </div>
   </section>
   <div class="row page-content">
      <div class="col-12">
         <div class="card border-top-orange">
            <div class="card-header">
               <div class="row align-items-center">
                  <div class="col">
                     <span class="fw-bold"><i class="fas fa-warehouse" aria-hidden="true"></i>&nbsp;Inventory - Data Stock</span>
                  </div>
                  <div class="col-auto px-1">
                     <button type="button" class="btn btn-primary btn-sm btn-hide" id="btn-export">
                        <i class="fas fa-file-export"></i>
                        <span class="fw-bold">
                           &nbsp;Export Data
                        </span>
                     </button>
                  </div>
               </div>
            </div>
            <div class="card-body">
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
                  <div class="col-md-2 col-6 input-filter end-input mt-0 mt-md-2"> 
                     <select class="custom-select custom-select-sm form-control form-control-sm i-search button" id="tb_category" name="tb_category" style="width:100%;">
                        <option value="" selected>Semua Kategori</option>
                        <?php
                        $db = $this->db->where("MsItemCatIsActive=1")->get("TblMsItemCategory")->result();
                        foreach ($db as $key) {
                           echo '<option value="' . $key->MsItemCatId . '" >' . $key->MsItemCatName . '</option>';
                        }
                        ?>
                     </select>
                  </div>
                  <div class="col-md-4 col-12 input-filter end-input mt-2">
                     <select class="custom-select custom-select-sm form-control form-control-sm i-search button dropdown-search" id="tb_varian" name="tb_varian" style="width:100%;" multiple="multiple">  
                        <?php
                           echo '<optgroup label="Vendor">';
                           $db = $this->db->where("MsVendorIsActive=1")->get("TblMsVendor")->result();
                           foreach ($db as $key) {
                              echo '<option value="vendor:' . $key->MsVendorCode . '" >' . $key->MsVendorName . '</option>';
                           }
                           echo '</optgroup>';
                        ?>
                        <?php
                           echo '<optgroup label="Warna">';
                           $db = $this->db->get("TblMsWarna")->result();
                           foreach ($db as $key) {
                              echo '<option value="warna:' . $key->WarnaName . '" >' . $key->WarnaName . '</option>';
                           }
                           echo '</optgroup>';
                        ?>
                        <?php
                           echo '<optgroup label="Ukuran">';
                           $db = $this->db->get("TblMsSize")->result();
                           foreach ($db as $key) {
                              echo '<option value="ukuran:' . $key->SizeName . '" >' . $key->SizeName . '</option>';
                           }
                        echo '</optgroup>';
                        ?> 
                     </select>
                  </div>
                  <div class="col-md-4 col-12 input-filter end-input mt-2">
                     <input type="text" class="form-control form-control-sm i-search button" placeholder="Cari nama/kode item" id="tb_search" />
                     <button class="btn btn-sm btn-right" id="btn-search"><i class="fas fa-search"></i></button>
                  </div>
               </div> 
               <div id="wait-load-item" class="load-container load4" style="display: block;">
                  <div class="load-progress"></div>
               </div>
               <div class="row mt-2"> 
                  <div id="data-load-item"> 
                  </div>
               </div>
               <div class="flex-grow-1 float-md-end float-none" id="produk-pagination">
                    <div class="d-block mb-0">
                        <ul class="pagination">
                           <li class="page-item"><a class="page-link"><i class="fas fa-step-backward"></i></a></li>
                           <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
                           <li class="page-item"><a class="page-link" href="#">1</a></li>
                           <li class="page-item active" aria-current="page"><a class="page-link" href="#">2</a></li>
                           <li class="page-item"><a class="page-link" href="#">3</a></li>
                           <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
                           <li class="page-item"><a class="page-link" href="#"><i class="fas fa-step-forward"></i></a></li> 
                        </ul>
                    </div>
                    <span class="fs-7">Menampilkan 9 dari 2000 data</span>
                </div>
            </div>
         </div>
      </div>
   </div>

   <div id="dialog-box">
   </div>

   <script> 
      $(document).ready(function() {   
         var pagenow = 1;
         var lastTopSelect = 0;
         $("#tb_store").select2();
         $("#tb_category").select2();  

         $.fn.select2.amd.require([
            'select2/selection/single',
            'select2/selection/placeholder',
            'select2/selection/allowClear',
            'select2/dropdown',
            'select2/dropdown/search',
            'select2/dropdown/attachBody',
            'select2/utils'
         ], function (SingleSelection, Placeholder, AllowClear, Dropdown, DropdownSearch, AttachBody, Utils) {

               var SelectionAdapter = Utils.Decorate(
               SingleSelection,
               Placeholder
            );
            
            SelectionAdapter = Utils.Decorate(
               SelectionAdapter,
               AllowClear
            );
                  
            var DropdownAdapter = Utils.Decorate(
               Utils.Decorate(
               Dropdown,
               DropdownSearch
               ),
               AttachBody
            );
            
            var base_element = $('#tb_varian')
            $(base_element).select2({
               placeholder: 'Pilih Varian',
               selectionAdapter: SelectionAdapter,
               dropdownAdapter: DropdownAdapter,
               allowClear: false,
               templateResult: function (data) {

                  if (!data.id) { return data.text; }

                  var $res = $('<div></div>');

                  $res.text(data.text);
                  $res.addClass('wrap');

                  return $res;
               },
               templateSelection: function (data) {
                  load_data_master_select();
                  if (!data.id) return data.text;  
                  var selected = ($(base_element).val() || []).length;
                  var total = $('option', $(base_element)).length; 
                  return  selected + " filter Terpilih dari " + total;
               }
            });

            let optgroupState = {}; 
            $("body").on('click', '.select2-container--open .select2-results__group', function() {
               $(this).siblings().toggle();
               let id = $(this).closest('.select2-results__options').attr('id');
               let index = $('.select2-results__group').index(this);
               try {
                  optgroupState[id][index] = !optgroupState[id][index];
               }
               catch(err) { 
               }
            })

            $('#tb_varian').on('select2:open', function() {
               $('.select2-dropdown--below').css('opacity', 0);
               setTimeout(() => {
                  let groups = $('.select2-container--open .select2-results__group');
                  let id = $('.select2-results__options').attr('id');
                  if (!optgroupState[id]) {
                     optgroupState[id] = {};
                  }
                  $.each(groups, (index, v) => {
                     optgroupState[id][index] = optgroupState[id][index] || false;
                     optgroupState[id][index] ? $(v).siblings().show() : $(v).siblings().hide();
                  })
                  $('.select2-dropdown--below').css('opacity', 1);
               }, 0);
            });
            $('#tb_varian').on('select2:select', function (e) {
               var data = e.params.data;
               console.log(data);
            });
         }); 

         $('#tb_store,#tb_category').on('select2:select', function (e) {
            load_data_master_select();
         });
         $("#btn-search").click(function(){
            load_data_master_select();
         });
         $("#tb_search").change(function() {
            load_data_master_select();
         });

         var ajax_req;
         load_data_master_select = function() {  
            $("#wait-load-item").show();
            $("#data-load-item").hide(); 
            if (ajax_req && ajax_req.readyState != 4) {
               ajax_req.abort();
            }
            ajax_req = $.ajax({
                  dataType: "json",
                  method: "POST",
                  url: "<?= site_url("function/client_datatable_inventory/get_list_stock/") ?>",
                  data: {
                     search: $("#tb_search").val(),  
                     store: $("#tb_store").val(),  
                     kategori:$("#tb_category").val(), 
                     varian:$("#tb_varian").val(), 
                     page: pagenow,
                  },
                  success: function(data) { 
                     var html ="";
                     data_item_select = data["data"];
                     for(var i = 0; i<data["data"].length;i++){ 
                        var datavarian = "";
                        var detailitem = "";
                        var stock = 0;
                        var Satuan = "";
                        for(var j = 0;j < data["data"][i]["MsProdukStock"].length; j++){
                           var dataitem = data["data"][i]["MsProdukStock"];
                           var varian = dataitem[j]["MsProdukDetailVarian"].split('|');
                           datavarian = "";
                           var detaildatavarian = "";
                           for(var h = 0; h < varian.length;h++){
                              datavarian += `<th scope="col">${(varian[h].split(":"))[0]}</th>`;
                              detaildatavarian += `<td>${(varian[h].split(":"))[1]}</td>`;
                           }  
                           stock += parseInt(dataitem[j]["MsProdukStockQty"]);
                           console.log(dataitem[j]["MsProdukStockQty"]);
                           Satuan = dataitem[j]["SatuanName"];
                           if($("#tb_store").val() == "") detaildatavarian += `<td>${dataitem[j]["MsWorkplaceCode"]}</td>`;
                           if($("#tb_store").val() == "") datavarian += `<th scope="col">Store</th>`;
                           detailitem += `<tr> 
                                             ${detaildatavarian}
                                            
                                             <td class="text-end" >${dataitem[j]["MsProdukDetailBerat"]} ${dataitem[j]["BeratCode"]}</td> 
                                             <td class="text-end" >${dataitem[j]["MsProdukStockQty"]} ${dataitem[j]["SatuanName"]}</td>
                                             <td class="text-end" >${dataitem[j]["MsProdukStockBuffer"]} ${dataitem[j]["SatuanName"]}</td>
                                             <td class="text-end" >
                                                <button type="button" class="btn btn-outline-secondary btn-sm me-1" onclick="log_trans(${dataitem[j]["MsProdukStockId"]})" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-book pe-1"></i><span class="fw-bold">History</span>
                                                </button>
                                             </td>
                                          </tr>`;
                          
                        }
                        html += `
                           <div class="d-flex justify-content-between p-0 p-md-2   m-1">
                              <div class="d-flex align-items-center col-md-8 col-10">
                                 <div class="flex-shrink-0"> 
                                    <img class="lazy skeleton" data-src="${data["data"][i]["MsProdukImage"]}" style="width: 2.5rem;background: #f1f1f1;padding: 0.25rem;height: 2.5rem;object-fit: contain;">
                                 </div>
                                 <div class="flex-grow-1 ms-1">
                                    <div class=" pt-1 fw-bold fs-7">${data["data"][i]["MsProdukCode"]} - ${data["data"][i]["MsProdukName"]}</div> 
                                    <span>Kategori : ${data["data"][i]["MsProdukCategory"]}</span> 
                                 </div>
                              </div>     
                              <div class="font-size-13 col-md-4 col-2 d-flex flex-column">
                                 <span>Stock :</span>
                                 <span>${stock} ${Satuan}</span>
                              </div> 
                           </div>
                           
                           <div class="accordion m-2 p-0" >
                              <div class="accordion-item">
                                 <h2 class="accordion-header bg-light" id="panelsStayOpen-${data["data"][i]["MsProdukId"]}-head">
                                    <button class="accordion-button p-2 bg-light fw-bold fs-7 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-${data["data"][i]["MsProdukId"]}"   aria-controls="panelsStayOpen-collapseOne">
                                       Detail Varian
                                    </button>
                                 </h2>
                                 <div id="panelsStayOpen-${data["data"][i]["MsProdukId"]}" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-${data["data"][i]["MsProdukId"]}">
                                    <div class="accordion-body p-1 bg-light"> 
                                       <table class="table table-sm table-hover table-varian">
                                          <thead>
                                             <tr>
                                                ${datavarian} 
                                                <th class="text-end" scope="col">Berat</th> 
                                                <th class="text-end" scope="col">Stock</th>  
                                                <th class="text-end" scope="col">Buffer</th>
                                                <th class="text-end" scope="col">Action</th>
                                             </tr>
                                          </thead> 
                                          <tbody class="table-group-divider">
                                             ${detailitem}
                                          </tbody>
                                       </table> 
                                    </div>
                                 </div>
                              </div>
                           </div>`;                        
                     }
                     if(html == "") {
                        html = '<img src="<?= base_url() ?>asset/image/mgs-erp/iconnotfound.png" class="rounded mx-auto d-block" width="300px">'
                     }
                     $("#data-load-item").html(html);
                     $("#wait-load-item").hide();
                     $("#data-load-item").show();  
                     setTimeout(function() {
                        $('.lazy').lazy({
                           afterLoad: function(element){
                                 $(element).removeClass("skeleton");
                           }
                        }); 
                     }, 1000);

                     $('table.table-varian').DataTable( {
                        "searching": false,
                        "paging": false, 
                        rowsGroup: [0,1,2,3],
                     });
                     var count = data["count"];
                     var page = Math.ceil(count / 10); 
                     var pagelast = page - 2;

                     // Membuat pagination button
                     var pagehtml = `<li class="page-item ${(pagenow==1 ? "disabled" : "")}"><a class="page-link" onclick="pageback()"><i class="fas fa-step-backward"></i></a></li>`;
                     if(pagenow>3)  pagehtml += `<li class="page-item disabled"><a class="page-link" href="#">...</a></li>`;
                     if(pagenow<4) {
                        if(page>=5){ 
                              pagehtml += `<li class="page-item ${(pagenow==1 ? "active" : "")}"><a class="page-link" onclick="pageload(1)">1</a></li>`;
                              pagehtml += `<li class="page-item ${(pagenow==2 ? "active" : "")}"><a class="page-link" onclick="pageload(2)">2</a></li>`;
                              pagehtml += `<li class="page-item ${(pagenow==3 ? "active" : "")}"><a class="page-link" onclick="pageload(3)">3</a></li>`;
                              pagehtml += `<li class="page-item ${(pagenow==4 ? "active" : "")}"><a class="page-link" onclick="pageload(4)">4</a></li>`;
                              pagehtml += `<li class="page-item ${(pagenow==5 ? "active" : "")}"><a class="page-link" onclick="pageload(5)">5</a></li>`;
                        }else{
                              for(var i = 0;i<page;i++){
                                 pagehtml += `<li class="page-item ${(pagenow==(i+1) ? "active" : "")}"><a class="page-link" onclick="pageload(${(i+1)})">${(i+1)}</a></li>`;
                              }
                        }
                     } 
                     if(pagenow>3 && pagenow < pagelast){
                        pagehtml += `<li class="page-item"><a class="page-link" onclick="pageload(${pagenow - 1})">${pagenow - 1}</a></li>`;
                        pagehtml += `<li class="page-item active"><a class="page-link" onclick="pageload(${pagenow})">${pagenow}</a></li>`;
                        pagehtml += `<li class="page-item"><a class="page-link" onclick="pageload(${pagenow + 1})">${pagenow + 1}</a></li>`; 
                        pagehtml += `<li class="page-item disabled"><a class="page-link" href="#">...</a></li>`;    
                     }
                     if(pagenow>3 && pagenow >= pagelast){ 
                        pagehtml += `<li class="page-item ${(pagenow==(page - 3) ? "active" : "")}"><a class="page-link" onclick="pageload(${(page - 3)})">${(page - 3)}</a></li>`;
                        pagehtml += `<li class="page-item ${(pagenow==(page - 2) ? "active" : "")}"><a class="page-link" onclick="pageload(${(page - 2)})">${(page - 2)}</a></li>`;
                        pagehtml += `<li class="page-item ${(pagenow==(page - 1)  ? "active" : "")}"><a class="page-link" onclick="pageload(${(page - 1)})">${(page - 1)}</a></li>`;
                        pagehtml += `<li class="page-item ${(pagenow==(page) ? "active" : "")}"><a class="page-link" onclick="pageload(${(page)})">${(page)}</a></li>`;
                     }
                     pagehtml += `<li class="page-item ${(pagenow==page || page==0? "disabled" : "")}"><a class="page-link" onclick="pagenext()"><i class="fas fa-step-forward"></i></a></li>`;
                     $("#produk-pagination").find("ul").html(pagehtml); 



                     // Membuat pagination deskripsi
                     var pagestart = (pagenow * 10) - 9;
                     var pageend = ((pagenow * 10) > count ? count : (pagenow * 10));
                     $("#produk-pagination").find("span").html(`Menampilkan ${pagestart} sampai ${pageend} dari ${count} data`);

                     
                  }
            });
         };
         load_data_master_select();
         pageback = function(){
            pagenow--;
            load_data_master_select();
         }
         pagenext = function(){
            pagenow++;
            load_data_master_select();
         }
         pageload = function(thispage){
            if(pagenow != thispage){
                  pagenow = thispage;
                  load_data_master_select();
            }
         } 

         var ajax_req;
         log_trans = function(stock_id){
            if (ajax_req && ajax_req.readyState != 4) {
               ajax_req.abort();
            }
            ajax_req = $.ajax({
               url: "<?php echo site_url('message/message_inventory/item_history/') ?>" + stock_id, 
               success: function(response) {
                  $("#dialog-box").html(response);
                  modal_action = new bootstrap.Modal(document.getElementById('modal-action'));
                  modal_action.show(); 
               },
               error: function(xhr, status, error) {
                  console.log(xhr.responseText); 
               }
            });
         } 


      });
   </script>
</body>

</html>