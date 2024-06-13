<div class="modal fade " id="modal-action"  data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered ">
        <div class="modal-content" name="form-action">
            <div class="modal-header bg-dark">
                <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp;Edit Data Item Master</h5>
                <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-1 align-items-center">
                    <div class="label-border-right">
                        <span class="label-dialog">Foto Produk</span>
                    </div>
                </div>  
                <div class="row p-2"> 
                    <input type="file" class="d-none" accept="image/*" id="upload-produk"> 
                    <div class="col-sm-12 d-flex flex-wrap">
                            <div class="d-flex flex-wrap" id="list-produk"></div>
                            <div class="image-default-obi" id="img-produk">
                                <i class="fas fa-image"></i>
                                <span>Tambah Foto</span>
                            </div>
                    </div>
                </div> 
                <div class="row mb-1 align-items-center">
                    <div class="label-border-right">
                        <span class="label-dialog">Deskripsi</span>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-11 my-1">
                        <div class="row mb-1 align-items-center">
                            <label for="MsProdukStock" class="col-sm-4 col-form-label">Status<sup class="error">&nbsp;*</sup></label>
                            <div class="col-sm-8">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="MsProdukStock" value="option1" <?= $produk->MsProdukStock == 1 ? "checked" : "" ?>>
                                    <label class="form-check-label col-form-label" for="MsProdukStock">Stock</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="MsProdukSale" value="option1" <?= $produk->MsProdukSale == 1 ? "checked" : "" ?>>
                                    <label class="form-check-label col-form-label" for="MsProdukSale">Jual</label>
                                </div> 
                            </div>
                        </div> 
                        <div class="row mb-1 align-items-center">
                            <label for="MsProdukCatId" class="col-sm-4 col-form-label">Kategori</label>
                            <div class="col-sm-8">
                                <select class="custom-select custom-select-sm form-control form-control-sm" id="MsProdukCatId" name="MsProdukCatId" style="width:100%" disabled>
                                <?php
                                $db = $this->db->where("MsProdukCatIsActive",1)->get("TblMsProdukCategory")->result();
                                foreach ($db as $key) {
                                    echo '<option value="' . $key->MsProdukCatId . '" data-kode="' . $key->MsProdukCatCode . '" '.($produk->MsProdukCatId == $key->MsProdukCatId ? "selected" : "" ).'>' . $key->MsProdukCatCode . ' - ' . $key->MsProdukCatName . '</option>';
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-1 align-items-center">
                            <label for="MsProdukCode" class="col-sm-4 col-form-label">Kode<sup class="error">&nbsp;*</sup></label>
                            <div class="col-sm-8">
                                <input id="MsProdukCode" name="MsProdukCode" type="text" class="form-control form-control-sm" value="<?= $produk->MsProdukCode ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-1 align-items-center">
                            <label for="MsProdukName" class="col-sm-4 col-form-label">Nama<sup class="error">&nbsp;*</sup></label>
                            <div class="col-sm-8">
                                <input id="MsProdukName" name="MsProdukName" type="text" class="form-control form-control-sm" value="<?= $produk->MsProdukName ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-11 my-1"> 
                        <label for="MsProdukDesc" class="col-sm-4 col-form-label">Detail Produk<sup class="error">&nbsp;*</sup></label> 
                        <textarea id="MsProdukDesc" name="MsProdukDesc" type="text" class="form-control form-control-sm" rows="5"><?= $produk->MsProdukDesc ?></textarea> 
                    </div> 
                </div>
                <div class="row justify-content-center mt-3">
                    <div class="col-lg-12 my-lg-0 col-11 my-1 mt-2"> 
                        <div class="row mb-1 align-items-center">
                            <div class="label-border-right mb-3 " style="position:relative">
                                <span class="label-dialog">Varian</span>
                                <button class="btn btn-success btn-sm py-1 me-1 rounded-pill" id="add-varian" type="button" style="position:absolute;top: -11px;right: -5px;font-size: 0.6rem;">
                                    <i class="fas fa-plus" aria-hidden="true"></i>
                                    <span class="fw-bold">
                                        &nbsp;Tambah Varian
                                    </span>
                                </button> 
                            </div>
                        </div> 
                        <div class="card " style="min-height:50px;">
                            <div class="card-body p-2 ">
                                <div id="tb_varian"></div> 
                            </div>
                        </div> 
                    </div>   
                </div> 
                <div class="row justify-content-center mt-3">
                    <div class="col-lg-12 my-lg-0 col-11 my-1 mt-2"> 
                        <div class="row mb-1 align-items-center">
                            <div class="label-border-right mb-3 " style="position:relative">
                                <span class="label-dialog">Table Varian</span> 
                            </div>
                        </div> 
                        <div class="card " style="min-height:50px;">
                            <div class="card-body p-2 " id="list_varian">  
                            </div>
                        </div> 
                    </div>   
                </div>
            </div>
            <div class="modal-footer">
                <div class="flex-grow-1" style="color: gray;font-size:12px;">
                    <span>Catatan : </span><br>
                    <span>1 . menambahkan Varian akan otomatis membuat stock baru pada varian tersebut</span><br>
                    <span>2 . Menghapus Varian akan menghapus pada stock yang sudah terbuat</span><br>
                    <span>3 . jika disimpan tanpa menghapus list varian maka stock tidak berpengaruh</span><br>
                </div>
                <button type="submit" class="btn btn-success"   id="btn-submit"        >Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- Vertically centered modal -->
<div class="modal fade " id="modal-edit"  data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">  
        <div class="modal-content" name="form-action">
            <div class="modal-header bg-dark">
                <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp;Edit Gambar</h5>
                <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div id="crop-image" style="height:500px;"></div>
                <div class="action" style="position: absolute; bottom: 15px; margin-left: 50%; transform: translateX(-50%); background: #d1d1d1; padding: 0.5rem; border-radius: 0.5rem;  z-index: 2;">
                    <a class="p-2" onclick="rotate_image(90)"><i class="fas fa-undo-alt"></i></a>
                    <a class="p-2" onclick="rotate_image(-90)"><i class="fas fa-redo-alt"></i></a>
                    <a class="p-2" onclick="flip_image(2)"><i class="fas fa-exchange-alt"></i></a>
                    <a class="p-2" onclick="flip_image(4)"><i class="fas fa-exchange-alt fa-rotate-90"></i></a>
                </div>
            </div>
            <div class="modal-footer"> 
                <button type="submit" class="btn btn-success" id="submit-crop" >Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>  
    var req_status_add = 0;
    var checkArrays = Array.from(document.getElementsByClassName("form-check-input"));  
    checkArrays.forEach(function (checkArray) {
        $(checkArray).change(function() {
            var mom = $(this).parents().eq(0); 
            $(mom).children(".label-check-enable").hide();
            $(mom).children(".label-check-disable").hide();
            if(this.checked) {
                $(mom).children(".label-check-enable").show();
            }else{
                $(mom).children(".label-check-disable").show();
            }
        });
    });

    $(".custom-select").select2({
        dropdownParent: $("#modal-action .modal-content")
    }); 

    var doubleinputs = Array.from(document.getElementsByClassName("double"));
    doubleinputs.forEach(function (doubleinput) {
        new Cleave(doubleinput, {
            numeral: true,
            numeralDecimalMark: ".",
            delimiter:          ","
        })
    });

    var priceinputs = Array.from(document.getElementsByClassName("price"));
    priceinputs.forEach(function (priceinput) {
        new Cleave(priceinput, {
            numeral: true,
            delimiter:          ",",
            numeralDecimalScale: 0,
            numeralThousandsGroupStyle: "thousand"
        })
    });

    $("#MsProdukCatId").trigger("change");

    /* function Image */ 
    $("#img-produk").on('click',function(){
        $("#upload-produk").trigger("click");
    })   
    $("#upload-produk").on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function() {
                $("#list-produk").append(`<div class="image-default-obi border">
                                <img src="${reader.result}"> 
                                <div class="action">
                                    <a class="btn btn-sm btn-white p-1" onclick="crop_image(this)"><i class="fas fa-crop-alt"></i></a>
                                    <a class="btn btn-sm btn-white p-1" onclick="delete_image(this)"><i class="fas fa-trash"></i></a>
                                </div>
                        </div>`) 
            }
        }
    });
    var data_image = <?= JSON_ENCODE($produkimage) ?>; 
    for(var i = 0; i < data_image.length;i++){
        $("#list-produk").append(`<div class="image-default-obi border">
                            <img src="${data_image[i]}"> 
                            <div class="action">
                                <a class="btn btn-sm btn-white p-1" onclick="crop_image(this)"><i class="fas fa-crop-alt"></i></a>
                                <a class="btn btn-sm btn-white p-1" onclick="delete_image(this)"><i class="fas fa-trash"></i></a>
                            </div>
                    </div>`)  
    }  
     
        
    var $uploadCrop, tempFilename, rawImg, imageId; 
    $uploadCrop = $('#crop-image').croppie({
        viewport: {
            width: 400,
            height: 400,
        },
        showZoomer: false,
        enforceBoundary: false,
        enableExif: true,
        enableOrientation: true
    });
    crop_image = function(el){ 
        var image_crop = $(el).parent().parent().find('img');
        var flip = 0;
        $('#modal-edit').modal('show');
        
        $('#modal-edit').on('shown.bs.modal', function(){ 
            $uploadCrop.croppie('bind', {
                url: $(image_crop).attr('src')
            }).then(function(){
                console.log('jQuery bind complete');
            });
        });
        rotate_image = function(val){
            $uploadCrop.croppie('rotate',parseInt(val));
        }
        flip_image = function(val){
            flip = flip == 0 ? val : 0;
            $uploadCrop.croppie('bind', { 
                url: $(el).parent().parent().find('img').attr('src'),
                orientation: flip
            });
        } 

        $('#submit-crop').unbind().click(function (ev) {
            $uploadCrop.croppie('result', {
                type: 'base64',
                format: 'png',
                size: {width: 400, height: 400}
            }).then(function (resp) { 
                $(image_crop).attr('src',resp) 
                $('#modal-edit').modal('hide');
            });
        });
    }
    delete_image = function(el){
        $(el).parent().parent().remove();
    }  


    var data_varian = [];  
    // Insert data langsung ke select2 Varian
    console.log('<?= json_encode($varian) ?>');
    var varian = JSON.parse('<?= $produk->MsProdukVarian ?>');
    for (const [key, val] of Object.entries(varian)) {   
        if(key == "Vendor"){ 
            var arr = [];
            arr["html"] = `<div class="row row-table get-item my-2">
                                <div class="col-12 col-md-3">
                                    <select class="custom-select custom-select-sm form-select form-select-sm selectvarian" placeholder="pilih varian" style="width:100%" disabled>
                                        <option value="1" select>Vendor</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-8">
                                    <select class="custom-select custom-select-sm form-control form-control-sm selectvarianvalue" style="width:100%" multiple="multiple" data-type="Vendor" required></select>
                                </div>
        
                                <div class="col-auto px-0">
                                    <span class="badge text-bg-secondary">Default</span>
                                </div>
                            </div>`;
            arr["varian"] = "Vendor";
            arr["value"] = [
                                {
                                    "id": "1",
                                    "text": "TKI",
                                    "html": "<span class=\"fw-bold\">TKI - TERRAKOTA INDONESIA</span>",
                                    "selected": true
                                }
                            ];
            var val_arr = [];
            for(var i = 0;i < val.length;i++){
                val_arr.push({

                })
                console.log(val[i]);
            }
            arr["value"] = [
                                {
                                    "id": "1",
                                    "text": "TKI",
                                    "html": "<span class=\"fw-bold\">TKI - TERRAKOTA INDONESIA</span>",
                                    "selected": true
                                }
                            ];
            data_varian.push(arr) 
        }else{
            var arr = [];
            arr["html"] = `<div class="row row-table get-item my-2">
                                <div class="col-12 col-md-3">
                                    <select class="custom-select custom-select-sm form-select form-select-sm selectvarian" placeholder="pilih varian" style="width:100%" disabled>
                                        <option value="1" select>${key}</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-8">
                                    <select class="custom-select custom-select-sm form-control form-control-sm selectvarianvalue" style="width:100%" multiple="multiple" data-type="${key}" required></select>
                                </div> 
                                <div class="col-auto px-0 align-self-end ms-auto action-table-single-optional">
                                        <a onclick="hapus_varian('${key}',true)" class="text-danger pointer" title="Hapus Item"><i class="fas fa-trash-alt fa-lg"></i></a>
                                    </div> 
                            </div>`;
            arr["varian"] = key;
            for(var i = 0;i < val.length;i++){
                console.log(val[i]);
            }
            arr["value"] = [ ];
            data_varian.push(arr) 
        }
    }
    
    <?php 
        $data = explode(";",$produk->MsProdukVarian);
        foreach($data as $varian){ 
            $datavarian = explode(":",$varian);
            if($datavarian[0] == "Vendor"){
                $datavendor = explode("|",$datavarian[1]);
                $valueselect = array();
                echo 'var arr = [];';
                echo 'arr["html"] = `<div class="row row-table get-item my-2">
                                    <div class="col-12 col-md-3">
                                        <select class="custom-select custom-select-sm form-select form-select-sm selectvarian" placeholder="pilih varian" style="width:100%" disabled>
                                            <option value="1" select>Vendor</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <select class="custom-select custom-select-sm form-control form-control-sm selectvarianvalue" style="width:100%" multiple="multiple" data-type="Vendor" required></select>
                                    </div>
            
                                    <div class="col-auto px-0">
                                        <span class="badge text-bg-secondary">Default</span>
                                    </div>
                                </div>`;';
                echo 'arr["varian"] = "Vendor";'; 
                foreach($datavendor as $vendor){ 
                    $data = $this->db->where("MsVendorCode",$vendor)->get("TblMsVendor")->row();
                    $valueselect[] = array(
                        "id"=>$data->MsVendorId,
                        "text"=>$data->MsVendorCode,
                        "html"=>"<span>".$data->MsVendorCode . " - " .$data->MsVendorName."</span>",
                        "selected"=>true
                    );
                }
                echo "arr['value'] = JSON.parse('".JSON_ENCODE($valueselect)."');";
                echo 'data_varian.push(arr);';
            }else if($datavarian[0] == "Warna"){
                $datavendor = explode("|",$datavarian[1]);
                $valueselect = array();
                echo 'var arr = [];';
                echo 'arr["html"] = `<div class="row row-table get-item my-2">
                                    <div class="col-12 col-md-3">
                                        <select class="custom-select custom-select-sm form-select form-select-sm selectvarian" placeholder="pilih varian" style="width:100%" disabled>
                                            <option value="1" select>'.$datavarian[0].'</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <select class="custom-select custom-select-sm form-control form-control-sm selectvarianvalue" style="width:100%" multiple="multiple" data-type="'.$datavarian[0].'" required></select>
                                    </div> 
                                    <div class="col-auto px-0 align-self-end ms-auto action-table-single-optional">
                                        <a onclick="hapus_varian(\''.$datavarian[0].'\',true)" class="text-danger pointer" title="Hapus Item"><i class="fas fa-trash-alt fa-lg"></i></a>
                                    </div> 
                                </div>`;';
                echo 'arr["varian"] = "'.$datavarian[0].'";'; 
                foreach($datavendor as $vendor){ 
                    $data = $this->db->where("WarnaName",$vendor)->get("TblMsWarna")->row();
                    $valueselect[] = array(
                        "id"=>$data->WarnaId,
                        "text"=>$data->WarnaName,
                        "html"=>"<span>".$data->WarnaName ."</span>",
                        "selected"=>true
                    );
                }
                echo "arr['value'] = JSON.parse('".JSON_ENCODE($valueselect)."');";
                echo 'data_varian.push(arr);';
            } else if($datavarian[0] == "Ukuran"){
                $datavendor = explode("|",$datavarian[1]);
                $valueselect = array();
                echo 'var arr = [];';
                echo 'arr["html"] = `<div class="row row-table get-item my-2">
                                    <div class="col-12 col-md-3">
                                        <select class="custom-select custom-select-sm form-select form-select-sm selectvarian" placeholder="pilih varian" style="width:100%" disabled>
                                            <option value="1" select>'.$datavarian[0].'</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <select class="custom-select custom-select-sm form-control form-control-sm selectvarianvalue" style="width:100%" multiple="multiple" data-type="'.$datavarian[0].'" required></select>
                                    </div> 
                                    <div class="col-auto px-0 align-self-end ms-auto action-table-single-optional">
                                        <a onclick="hapus_varian(\''.$datavarian[0].'\',true)" class="text-danger pointer" title="Hapus Item"><i class="fas fa-trash-alt fa-lg"></i></a>
                                    </div> 
                                </div>`;';
                echo 'arr["varian"] = "'.$datavarian[0].'";'; 
                foreach($datavendor as $vendor){ 
                    $data = $this->db->where("SizeName",$vendor)->get("TblMsSize")->row();
                    $valueselect[] = array(
                        "id"=>$data->SizeId,
                        "text"=>$data->SizeName,
                        "html"=>"<span>".$data->SizeName ."</span>",
                        "selected"=>true
                    );
                }
                echo "arr['value'] = JSON.parse('".JSON_ENCODE($valueselect)."');";
                echo 'data_varian.push(arr);';
            } 
        } 
    ?>  

    $("#add-varian").click(function() {
        try{ 
            var htmlItem = `<div class="row row-table get-item">
                                <div class="col-3" >
                                    <select class="custom-select custom-select-sm form-select form-select-sm selectvarian" placeholder="pilih varian"></select>
                                </div>
                                <div class="col-auto px-0 align-self-end ms-auto action-table-single-optional">
                                    <a onclick="hapus_varian('-',true)" class="text-danger pointer" title="Hapus Item"><i class="fas fa-trash-alt fa-lg"></i></a>
                                </div>
                            </div>`;
            var arr = [];
            arr["html"] = htmlItem;
            arr["varian"] = "-";
            arr["value"] = []; 
            data_varian.push(arr);
            $("#add-varian").prop("disabled", true); 
            load_data_varian();
        }catch(err){
            console.log(err);
        }
    }); 

    load_data_varian = function(){
        $("#tb_varian").html("");
        var select = [];
        var html = "";
        for(var i = 0 ; i < data_varian.length;i++){ 
            $("#tb_varian").append(data_varian[i]["html"]);
            $(".select-modal").select2({
                dropdownParent: $("#modal-action .modal-content")
            }); 
            
            if(data_varian[i]["varian"]!="-") select.push(data_varian[i]["varian"]); 
            $(".selectvarian").select2({
                placeholder: "Pilih Varian",
                dropdownParent: $("#modal-action .modal-content"),
                ajax: {
                    method: "POST",
                    dataType: "json",
                    url: "<?= site_url("function/client_data_master/get_data_item_varian") ?>", 
                    delay: 800,
                    data: function(params) {
                        return {
                            search: params.term,
                            select: select
                        }
                    },
                    processResults: function(data, page) {
                        return {
                            results: data
                        };
                    },
                }, 
                escapeMarkup: function(m) {
                    return m;
                },
                templateResult: function template(data) {
                    if ($(data.html).length === 0) {
                        return data.text;
                    }
                    return $(data.html);
                },
                templateSelection: function templateSelect(data) {
                    if ($(data.html).length === 0) {
                        return data.text;
                    }
                    return data['text'];
                }
            }); 
            
            $(".selectvarian").on("select2:select", function(e) {
                var data = e.params.data; 
                var htmlItem = `<div class="row row-table get-item my-2">
                        <div class="col-12 col-md-3">
                            <select class="custom-select custom-select-sm form-select form-select-sm selectvarian" placeholder="pilih varian" style="width:100%" disabled>
                                <option value="${data.id}" select>${data.text}</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-8">
                            <select class="custom-select custom-select-sm form-control form-control-sm selectvarianvalue" style="width:100%" multiple="multiple" required data-type="${data.text}"></select>
                        </div>
                        <div class="col-auto px-0 align-self-end ms-auto action-table-single-optional">
                            <a onclick="hapus_varian('${data.text}',true)" class="text-danger pointer" title="Hapus Item"><i class="fas fa-trash-alt fa-lg"></i></a>
                        </div>
                    </div>`;
                var arr = [];
                arr["html"] = htmlItem;
                arr["varian"] = data.text;
                arr["value"] = [];
                data_varian[dataindex] = arr; 
                $("#add-varian").prop("disabled", false); 
                load_data_varian(); 
            });

            $(".selectvarianvalue").select2({
                placeholder: "Pilih data varian",
                dropdownParent: $("#modal-action .modal-content"),
                ajax: {
                    method: "POST",
                    dataType: "json",
                    url: "<?= site_url("function/client_data_master/get_data_item_varian_value") ?>", 
                    delay: 800,
                    data: function(params) {
                        return {
                            search: params.term,
                            type: $(this).data("type")
                        }
                    },
                    processResults: function(data, page) {
                        return {
                            results: data
                        };
                    },
                }, 
                escapeMarkup: function(m) {
                    return m;
                },
                templateResult: function template(data) {
                    if ($(data.html).length === 0) {
                        return data.text;
                    }
                    return $(data.html);
                },
                templateSelection: function templateSelect(data) {
                    if ($(data.html).length === 0) {
                        return data.text;
                    }
                    return data['text'];
                }
            }); 

            var datavalue = data_varian[i]["value"]; 
            var dataindex = i;
            for(var j = 0; j < datavalue.length;j++){ 
                var option = new Option(datavalue[j]["text"],datavalue[j]["id"],true,true); 
                $('.selectvarianvalue[data-type="'+data_varian[dataindex]["varian"] +'"]').append(option).trigger('change');
            }  
            
        } 

        $(".selectvarianvalue").on("select2:select", function(e) {    
            var data = e.params.data;  
            for (var j = 0; data_varian.length > j; j++) {
                if (data_varian[j]["varian"] == $(this).data("type") ) {
                    data_varian[j]["value"].push(data);
                    break;
                }
            }  
            load_data_list_varian();
        }).on("select2:unselect", function(e) {   
            var data = e.params.data; 
            for (var j = 0; data_varian.length > j; j++) {
                if (data_varian[j]["varian"] == $(this).data("type") ) {
                    var datavalue = data_varian[j]["value"];
                    for (var k = 0; datavalue.length > k; k++) {
                        if (datavalue[k]["id"] == data.id ) {
                            data_varian[j]["value"].splice(k, 1);   
                        }
                    }  
                }
            }   
            load_data_list_varian();
        });
        load_data_list_varian();
    }

    // berat:0
    // berattype:0
    // harga:0
    // satuan:0
    // varian: Array(2)
    //     0:[Warna: 'GRAY']
    //     1:[Vendor: 'PSL']

    var produk_detail = <?= JSON_ENCODE($produkdetail)?>;
    var data_varian_detail = [];
    for(var i = 0;i < produk_detail.length;i++){
        // "Warna:RED|Vendor:TKI" 
        var varianproduk = [];
        var dataprodukvarian = (produk_detail[i]["MsProdukDetailVarian"].split("|"));
        for(var j = 0; j < dataprodukvarian.length; j++){
            var vari = dataprodukvarian[j].split(":");
            var data = [];
            data[vari[0]] = vari[1];
            varianproduk.push( data);
        }
        data_varian_detail.push({
            "varian": varianproduk,
            "berat": produk_detail[i]["MsProdukDetailBerat"],
            "berattype": produk_detail[i]["BeratId"],
            "satuan": produk_detail[i]["SatuanId"],
            "harga": produk_detail[i]["MsProdukDetailPrice"],
            "id": produk_detail[i]["MsProdukDetailId"],
        })
    }
    var data_varian_list = [];
    var data = []; 
    var data_varians = []; 
    var option_berat = <?= json_encode($berat) ?>;
    var data_option_berat = "";
    for(var i = 0;i < option_berat.length;i++){
        data_option_berat += `<option value="${option_berat[i]["BeratId"]}">(${option_berat[i]["BeratCode"]})</option>`;
    }
    var option_satuan = <?= json_encode($satuan) ?>;
    var data_option_satuan = "";
    for(var i = 0;i < option_satuan.length;i++){
        data_option_satuan += `<option value="${option_satuan[i]["SatuanId"]}">${option_satuan[i]["SatuanName"]}</option>`;
    } 
    get_arr_val_old = function(key,param){
        var value = 0; 
        for(var i = 0; i< data_varian_detail.length;i++){
            var truedata = 0;
            $.each(data_varian_detail[i]["varian"], function(key1, value1) { 
                for (const [key1, val1] of Object.entries(value1)) {    
                    $.each(key, function(key2, value2) { 
                        for (const [key2, val2] of Object.entries(value2)) {   
                            if(key1==key2 && val1 == val2 ){
                                truedata++;
                                break;
                            }
                        }
                    });  
                }
            });   
            if(data_varian_detail[i]["varian"].length == truedata){
                value = data_varian_detail[i][param];
            } 
        }
        return value;
    } 
    var data_varian_new = []; 
    load_data_list_varian = function(){  
        data_varian_list = [];
        var data_array = [];
        for(var j = 0; j < data_varian.length;j++){ 
            var arr = [];
            for(var k = 0; k < data_varian[j]["value"].length;k++){
                data = [];
                data["key"] = data_varian[j]["varian"];
                data["value"] = data_varian[j]["value"][k]["text"];
                arr.push(data);
            } 
            data_array.push(arr);
        }    
        function allPossibleCases(arr) {
            if (arr.length === 0) {
                return [];
            }else if (arr.length ===1){
                return arr[0];
            }else {
                var result = []; 
                var allCasesOfRest = allPossibleCases(arr.slice(1));  // recur with the rest of array  
                for (var i = 0; i < allCasesOfRest.length; i++) {    
                    for (var j = 0; j < arr[0].length; j++) {     
                        if(allCasesOfRest[i].length > 0 ){  
                            data = [];
                            for (var k = 0; k < allCasesOfRest[i].length; k++) {   
                                data.push(allCasesOfRest[i][k]);  
                            } 
                            data.push(arr[0][j]);  
                            result.push(data);
                        }else{ 
                            data = [];
                            data.push(allCasesOfRest[i]);
                            data.push(arr[0][j]);  
                            result.push(data);
                        }
                    } 
                } 
                return result;
            }

        }
        var data_loop = allPossibleCases(data_array);  
        if(data_loop.length > 0) data_varians = data_varian_new; 
        data_varian_new = []; 
        for(var i = 0; i < data_loop.length;i++){  
            var varian = [];  
            if(data_loop[i]["key"] != undefined){
                var arr_sub = []; 
                arr_sub[data_loop[i]["key"]] = data_loop[i]["value"]; 
                varian.push(arr_sub);       
            }else{
                for(var j = 0; j < data_loop[i].length;j++){  
                    var arr_sub = []; 
                    arr_sub[data_loop[i][j]["key"]] = data_loop[i][j]["value"]; 
                    varian.push(arr_sub);  
                }   
            }     
            data_varian_new.push({
                "varian": varian,
                "berat": get_arr_val_old(varian,"berat"),
                "berattype": get_arr_val_old(varian,"berattype"),
                "satuan": get_arr_val_old(varian,"satuan"),
                "harga": get_arr_val_old(varian,"harga"),
                "id": get_arr_val_old(varian,"id"),
            })
        }     
        var headerhtml = `<thead><tr>`;
        var detailhtml = `<tbody>`;
        for(var i = 0; i < data_varian_new.length;i++){ 
            headerhtml = "<thead><tr>";
            detailhtml += `<tr>`;
            $.each(data_varian_new[i]["varian"], function(key, value) { 
                for (const [key, val] of Object.entries(value)) {   
                    headerhtml += `<th scope="col">${key}</th>`;
                    detailhtml += `<td scope="col">${val}</td>`;
                }
            });  
            headerhtml += `<th scope="col" style="width:10rem">Berat</th><th scope="col" style="width:8rem">Satuan</th><th scope="col" style="width:8rem">Harga</th>`;
            detailhtml += `<td scope="col">
                                <div class="input-group"> 
                                    <input type="text" class="form-control form-control-sm weight"  placeholder="" value="${data_varian_new[i]["berat"]}" data-id="${i}">
                                    <select class="custom-select custom-select-sm form-select form-select-sm selectberat" placeholder="" data-id="${i}" style="max-width:4rem;background-color:#ede6e6">
                                        ${data_option_berat}
                                    </select>
                                </div> 
                            </td>`;
            detailhtml += `<td scope="col">
                                <select class="custom-select custom-select-sm form-select form-select-sm selectsatuan" data-id="${i}" placeholder="" style="width:100%">${data_option_satuan}</select>
                            </td>`;
            detailhtml += `<td scope="col">
                                <input type="text" class="form-control form-control-sm price d-inline-block me-2" data-id="${i}" value="${data_varian_new[i]["harga"]}">
                            </td>`;
            detailhtml += `</tr>`;
        }  
        headerhtml += `</tr></thead>`;
        detailhtml += `</tbody>`;
        if(headerhtml == `<thead><tr></tr></thead>`){ 
            $('#list_varian').html(`<div class="text-center"><i class="fas fa-ban pe-2"></i>Lengkapi data varian terlebih dahulu</div>`);
        }else{ 
            $('#list_varian').html(`<table class="table table-hover table-sm">${headerhtml}${detailhtml}</table>`);
            $( ".price" ).each(function() {
                var cleave = new Cleave($(this),{
                    numeral: true,
                    delimeter: ",",
                    numeralDecimalScale:0,
                    numeralThousandGroupStyle:"thousand"
                });
                $(this).change(function(){ 
                    data_varian_new[$(this).data("id")]["harga"] = cleave.getRawValue();
                });
                cleave.getRawValue(data_varian_new[$(this).data("id")]["harga"]);
            });  
            $( ".weight" ).each(function() {
                var cleave = new Cleave($(this),{
                    numeral: true,
                    delimeter: ",",
                    numeralDecimalMark: '.',
                    numeralDecimalScale:2, 
                });
                $(this).change(function(){ 
                    data_varian_new[$(this).data("id")]["berat"] = cleave.getRawValue();
                });
                cleave.getRawValue(data_varian_new[$(this).data("id")]["berat"]);
            });  
            $( ".selectberat" ).each(function() {  
                $(this).select2({
                    placeholder: "Pilih",
                    minimumResultsForSearch: Infinity,
                    dropdownParent: $("#modal-action .modal-content"), 
                }).on("select2:select", function(e) {     
                    var data = e.params.data;  
                    data_varian_new[$(this).data("id")]["berattype"] = data.id; 
                }).val(data_varian_new[$(this).data("id")]["berattype"]).trigger("change.select2"); 
            }); 
            $( ".selectsatuan" ).each(function() {  
                $(this).select2({
                    placeholder: "Pilih", 
                    dropdownParent: $("#modal-action .modal-content"), 
                }).on("select2:select", function(e) {    
                    var data = e.params.data;  
                    data_varian_new[$(this).data("id")]["satuan"] = data.id; 
                }).val(data_varian_new[$(this).data("id")]["satuan"]).trigger("change.select2"); 
            });  
        }

      

    };
    
    hapus_varian = async function(varian, newitem) {
        for (var i = 0; data_varian.length > i; i++) {
            if (data_varian[i]["varian"] == varian  ) {
                var index = i;
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success mx-1',
                        cancelButton: 'btn btn-secondary mx-1'
                    },
                    buttonsStyling: false
                });
                var data = await swalWithBootstrapButtons.fire({
                    title: "Hapus Varian!",
                    html: "apakah anda yakin ingin menghapus varian ini!",
                    icon: "warning",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showCancelButton: true,
                    confirmButtonText: "Lanjutkan",
                    cancelButtonText: "Tidak",
                    reverseButtons: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        data_varian.splice(index, 1);  
                        load_data_varian();
                        load_data_list_varian();
                        if (newitem) {
                            $("#add-varian").prop("disabled", false);
                            return true;
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            return false;
                        }
                    }
                });
                return data;
            }
        }
        load_data_list_varian();
    }
  
    load_data_varian(); 
    var req_status_add = 0;
    $("#btn-submit").click(function(){
        if(req_status_add==1) return;
        if($("#MsProdukName").val()==""){
            Swal.fire({
                icon: 'error',
                text: 'Masukan Nama Produk Terlebih Dahulu...!!!',
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                timer: 1500
            });
            return false;
        }
        if(data_varian_new.length==0){
            Swal.fire({
                icon: 'error',
                text: 'Data Varian Belum Lengkap...!!!',
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                timer: 1500
            });
            return false;
        }
        var datavar = "";
        data_varian.forEach(function(data){
            datavar += data["varian"] + ":";
            data["value"].forEach(function(data2){
                datavar += data2["text"] + "|";
            }) 
            datavar = datavar.slice(0,-1);
            datavar +=  ";";
        })
        console.log(datavar)
        var data_header = {
            "MsProdukCatId": $("#MsProdukCatId").val(),
            "MsProdukStock": ($("#MsProdukStock").is(":checked") ? "1" : "0"),
            "MsProdukSale": ($("#MsProdukSale").is(":checked") ? "1" : "0"),
            "MsProdukCode": $("#MsProdukCode").val(),
            "MsProdukName": $("#MsProdukName").val(),
            "MsProdukDesc": $("#MsProdukDesc").val(),
            "MsProdukVarian": datavar, 
        };

        var data_detail = [];
        data_varian_new.forEach(function(data){
            var datadetailvar = "";
            $.each(data["varian"], function(key, value) { 
                for (const [key, val] of Object.entries(value)) {   
                    datadetailvar += key + ":"  + val + "|"; 
                }
            });  
            datadetailvar = datadetailvar.slice(0,-1); 
            var detail = {
                "MsProdukDetailPrice":data["harga"], 
                "MsProdukDetailVarian":datadetailvar,
                "BeratId":data["berattype"],
                "BeratQty":data["berat"],
                "SatuanId":data["satuan"],
                "MsProdukDetailId": data["id"],
                "MsProdukDetailRef": <?= $produk->MsProdukId ?>,
            }
            data_detail.push(detail);
        }); 

        /* -------------------------------------------------     SEND DATA SERVER    ---------------------------------------------- */
        $.ajax({
            method: "POST", 
            url: "<?= site_url("function/client_data_master/data_item_edit/").$produk->MsProdukId ?>",
            data: {
                "header": data_header,
                "detail": data_detail,  
                "image":data_image,
            },   
            success: function(response) {
                // Tampilkan respon setelah permintaan selesai
                $('#status').html(response.responseText);
                req_status_add = 0;  
                if (data) {
                    Swal.fire({
                        icon: 'success',
                        text: 'Edit data berhasil',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        timer: 1500,
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) { 
                           load_data_table();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        text: 'Edit data gagal',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        timer: 1500
                    });
                }
            } 
        });


         
    })
</script>