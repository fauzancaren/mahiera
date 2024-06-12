<div class="modal fade " id="modal-action-item" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered ">
        <form class="modal-content" name="form-action-customer">
            <div class="modal-header bg-dark">
                <h6 class="modal-title text-white"><i class="fas fa-check-square text-primary" aria-hidden="true"></i> &nbsp;Pilih Item</h5>
                <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"> 
                <div class="row mb-2">
                    <div class="col-md-4 col-sm-12"> 
                        <label class="fs-7" for="floatingInputValue">Kategori</label>
                        <select class="form-select form-select-sm" id="category-data-item" aria-label="Floating label select example">
                            <option selected value="0">Pilih Semua Kategori</option>
                            <?php
                                $data_category = $this->db->where("MsItemCatIsSales",1)->get("TblMsItemCategory")->result();
                                foreach($data_category as $row){
                                    echo "<option value='".$row->MsItemCatId."'>".$row->MsItemCatCode." - ".$row->MsItemCatName."</option>";
                                }
                            ?> 
                        </select>  
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <label class="fs-7" for="floatingInputValue">Pencarian</label>
                        <input class="form-control form-control-sm" type="text" placeholder="cari kode,nama atau varian" id="search-data-item"> 
                    </div>  
                </div>
                
               <div id="wait-load-item" class="load-container load4" style="display: block;">
                  <div class="load-progress"></div>
               </div>
                <div class="row">
                    <div class="d-flex flex-wrap justify-content-center" id="data-load-item"> 
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex">  
                <div class="flex-grow-1 text-start" id="produk-pagination">
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
                <button type="button" class="btn btn-success me-2" id="btn-submit-item" disabled>pilih</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button> 
            </div>
        </form>
    </div>
</div>
<script>
    var mode = "action item";
    var pagenow = 1;
    var data_item_select = []; 
    var item_select = []; 
    get_mode = function() {
        return mode;
    };
    var store = <?= JSON_ENCODE($this->db->get("TblMsWorkplace")->result()) ?>;
    load_data_master_select = function() { 
        $("#btn-submit-item").prop("disabled",true);
        $("#wait-load-item").show();
        $("#data-load-item").hide(); 
        $.ajax({
            dataType: "json",
            method: "POST",
            url: "<?= site_url("function/client_datatable/get_list_produk/") ?>",
            data: {
                search: $("#search-data-item").val(), 
                kategori: $("#category-data-item").val(), 
                page: pagenow,
            },
            success: function(data) { 
                var html = "";
                data_item_select = data["data"];
                for(var i = 0; i<data["data"].length;i++){
                    var htmlvarian = "";
                    var varian = data["data"][i]["MsProdukVarian"].split(";");
                    for(var j = 0;j < varian.length;j++){
                        var varheader = varian[j].split(":");
                        htmlvarian += ` <div class="d-flex justify-content-between py-1">
                                            <span class="fs-8">${varheader[0]}</span>
                                            <select class="custom-select-item varian" id="${data["data"][i]["MsProdukId"]}${varheader[0]}" data-index="${i}" data-header="${varheader[0]}" style="width: 70%">`;
                        var vardetail = varheader[1].split("|");
                        for(var k = 0;k < vardetail.length;k++){ 
                            htmlvarian += `<option value='${vardetail[k]}' ${((varheader[0] == "Warna" && vardetail[k]=="GREY") ? "selected" : "")}>${vardetail[k]}</option>`;
                        }
                        htmlvarian += ` 
                                            </select>  
                                        </div> `;
                    }
                    html += `
                        <div class="">
                            <div class="card-item" data-index="${i}" data-id="${data["data"][i]["MsProdukId"]}">
                                <div class="d-flex">
                                    <div class="flex-shrink-0"> 
                                        <img class="lazy skeleton" data-src="${data["data"][i]["MsProdukImage"]}" style="width: 5rem;background: #f1f1f1;padding: 0.25rem;height: 5rem;object-fit: contain;">
                                    </div>
                                    <div class="flex-grow-1 ms-1">
                                        <div class=" pt-1 fw-bold fs-7">${data["data"][i]["MsProdukName"]}</div>  
                                        ${htmlvarian}
                                    </div>
                                </div>  
                                <div class="row">
                                    <div class="col-5 pe-0">
                                        <span class="fs-8">Stock</span>
                                        <select class="custom-select-item stock" id="${data["data"][i]["MsProdukId"]}" data-index="${i}" style="width:4rem">
                                            <option value='0' selected>Semua</option>`; 
                        for(var j = 0;j < store.length;j++){
                            html += `<option value='${store[j]["MsWorkplaceId"]}'>${store[j]["MsWorkplaceCode"]}</option>`;
                        }
                        html += ` 
                                        </select>
                                        <div class="d-block">
                                            <span class="fw-bold fs-4 stockitem" data-index="${i}">2.000</span>
                                            <span class="fs-8 uomitem" data-index="${i}">/PCS</span>
                                        </div>
                                    </div>
                                    <div class="col-7 ps-1 text-end"> 
                                        <span class="fs-8">Harga Satuan</span>
                                        <div class="d-block">
                                            <span class="fw-bold fs-4 priceitem" data-index="${i}">19.000</span>
                                            <span class="fs-8 uomitem" data-index="${i}">/PCS</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                }
                $("#data-load-item").html(html);
                $("#wait-load-item").hide();
                $("#data-load-item").show(); 


                $(".custom-select-item.varian").change(function() {
                    var arr = [];
                    var id = $(this).data("index");
                    $(`.custom-select-item.varian[data-index=${id}]`).each(function(){  
                        arr.push($(this).data("header") + ":" + $(this).val());
                    }); 
                    for(var i = 0; i < data_item_select[id]["MsProdukDetail"].length ; i++){ 
                        var datavarian = data_item_select[id]["MsProdukDetail"][i]["MsProdukDetailVarian"].split("|");
                        let defarr = arr.diff(datavarian);
                        if(defarr.length==0){ 
                            $(`.uomitem[data-index=${id}]`).each(function(){ 
                                $(this).html("/" +  data_item_select[id]["MsProdukDetail"][i]["SatuanName"]);
                            })
                            $(`.priceitem[data-index=${id}]`).each(function(){ 
                                $(this).html(number_format(parseInt(data_item_select[id]["MsProdukDetail"][i]["MsProdukDetailPrice"])));
                            })
                        }
                    }    
                    data_item_select[id]["selected"] = arr;
                    $(`.custom-select-item.stock[data-index=${id}]`).trigger("change");
                });
                $(".custom-select-item.stock").change(function() { 
                    var arr = [];
                    var id = $(this).data("index");
                    var worplace = $(this).val();
                    $(`.custom-select-item.varian[data-index=${id}]`).each(function(){  
                        arr.push($(this).data("header") + ":" + $(this).val());
                    }); 

                    var count = 0;
                    for(var i = 0; i < data_item_select[id]["MsProdukStock"].length ; i++){ 
                        var datavarian = data_item_select[id]["MsProdukStock"][i]["MsProdukVarian"].split("|");
                        let defarr = arr.diff(datavarian); 
                        if(worplace == 0){ 
                            if(defarr.length==0 ){  
                                count += parseInt(data_item_select[id]["MsProdukStock"][i]["MsProdukStockQty"]);
                            }
                        }else{
                            if(defarr.length==0 && worplace == data_item_select[id]["MsProdukStock"][i]["MsWorkplaceId"]){  
                                count += parseInt(data_item_select[id]["MsProdukStock"][i]["MsProdukStockQty"]);
                            }
                        }
                    } 

                    $(`.stockitem[data-index=${id}]`).each(function(){ 
                        $(this).html(number_format(count));
                    }) 
                })
                //syncron all data
                $( ".custom-select-item[data-header='Vendor']" ).each(function(){
                    $(this).trigger("change");
                })
                $(".custom-select-item.stock").each(function(){
                    $(this).trigger("change");
                })

                $( ".card-item" ).each(function( index ) {
                    $(this).click(function(){
                        $( ".card-item" ).removeClass("selected");
                        $(this).addClass("selected");
                        $("#btn-submit-item").prop("disabled",false);

                        item_select = data_item_select[$(this).data("index")]
                    })
                });
                $('.lazy').lazy({
                    afterLoad: function(element){
                        $(element).removeClass("skeleton");
                    }
                });
                var count = data["count"];
                var page = Math.ceil(count / 9); 
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
                var pagestart = (pagenow * 9) - 8;
                var pageend = ((pagenow * 9) > count ? count : (pagenow * 9));
                $("#produk-pagination").find("span").html(`Menampilkan ${pagestart} sampai ${pageend} dari ${count} data`);

                
            }
        });
    };
    load_data_master_select();

    $("#search-data-item").keyup(function(){ 
        pagenow = 1;
        load_data_master_select(); 
    });
     
    $("#category-data-item").change(function(){ 
        pagenow = 1;
        load_data_master_select(); 
    });

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

    $("#btn-submit-item").click(function(){
        item_data_select(item_select);
    });
</script>