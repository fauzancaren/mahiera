<div class="modal fade" id="modal-action" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h6 class="modal-title text-white"><i class="fas fa-pencil-alt text-warning" aria-hidden="true"></i> &nbsp;Edit Menu Listing</h5>
                <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-1 align-items-center justify-content-center">
                    <label for="MenuListingName" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-8">
                        <input id="MenuListingName" name="MenuListingName" type="text" class="form-control form-control-sm" value="<?= $_listing->MenuListingName ?>">
                    </div>
                </div> 
                <div class="row mb-1 align-items-center justify-content-center"> 
                    <div class="col-sm-10" id="data-table">
                        <table class="table" id="data-listing">
                            <thead>
                                <tr>
                                    <th scope="col" style="width:3%">#</th>
                                    <th scope="col">Menu</th>
                                    <th scope="col" style="width:8%">
                                        <div class="form-check ">
                                            <input class="form-check-input check pointer" type="checkbox" value="" id="checkall">
                                            <label class="form-check-label pointer" for="checkall">All</label>
                                        </div>
                                    </th>
                                    <th scope="col" style="width:8%">
                                        <div class="form-check">
                                            <input class="form-check-input check pointer" type="checkbox" value="" id="checkvisible">
                                            <label class="form-check-label pointer" for="checkvisible">Visible</label>
                                        </div>
                                    </th>
                                    <th scope="col" style="width:8%">
                                        <div class="form-check">
                                            <input class="form-check-input check pointer" type="checkbox" value="" id="checkview">
                                            <label class="form-check-label pointer" for="checkview">View</label>
                                        </div>
                                    </th>
                                    <th scope="col" style="width:8%">
                                        <div class="form-check">
                                            <input class="form-check-input check pointer" type="checkbox" value="" id="checkedit">
                                            <label class="form-check-label pointer" for="checkedit">Edit</label>
                                        </div>
                                    </th> 
                                    <th scope="col" style="width:8%">
                                        <div class="form-check">
                                            <input class="form-check-input check pointer" type="checkbox" value="" id="checkdelete">
                                            <label class="form-check-label pointer" for="checkdelete">Delete</label>
                                        </div>
                                    </th> 
                                    <th scope="col" style="width:8%">
                                        <div class="form-check">
                                            <input class="form-check-input check pointer" type="checkbox" value="" id="checkexport">
                                            <label class="form-check-label pointer" for="checkexport">Export</label>
                                        </div>
                                    </th>  
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                    foreach($_menu as $row){
                                        if($row->MenuParent==0){ 
                                            echo '<tr data-id="'.$row->MenuId.'">
                                                    <th onclick="subaction(\'menu-'.$row->MenuId.'\',this)" scope="row" class="pointer"><i class="fas fa-caret-right close"></i></th>
                                                    <td>'.$row->MenuText.'</td>
                                                    <td><input class="form-check-input m-0 checkall" data-menuid="'.$row->MenuId.'" type="checkbox"></td>
                                                    <td><input class="form-check-input m-0 checkvisible" data-menuid="'.$row->MenuId.'" type="checkbox"></td>
                                                    <td><input class="form-check-input m-0 checkview" data-menuid="'.$row->MenuId.'" type="checkbox"></td>
                                                    <td><input class="form-check-input m-0 checkedit" data-menuid="'.$row->MenuId.'" type="checkbox"></td>
                                                    <td><input class="form-check-input m-0 checkdelete" data-menuid="'.$row->MenuId.'" type="checkbox"></td>
                                                    <td><input class="form-check-input m-0 checkexport" data-menuid="'.$row->MenuId.'" type="checkbox"></td>
                                                </tr>';
                                            $no++;

                                            $recent = "";
                                            foreach($_menu as $row_item){
                                                if($row_item->MenuParent==$row->MenuId){
                                                    if($recent!= $row_item->MenuHeader){
                                                        echo '<tr class="menu-'.$row->MenuId.' sub-menu header d-none " style="font-size:0.65rem;font-weight:bold;color: #7a7a7a;">
                                                                <th scope="row"></th> 
                                                                <td class="ps-2">'.$row_item->MenuHeader.'</td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>';
                                                        $recent=$row_item->MenuHeader;
                                                    }
                                                    echo '<tr class="menu-'.$row->MenuId.' sub-menu  d-none" data-id="'.$row_item->MenuId.'" >
                                                            <th scope="row"></th>
                                                            <td class="ps-2"><i class="px-2 fas fa-circle"  data-menuid="'.$row_item->MenuId.'" style="font-size:0.65rem;font-weight:bold;color: #7a7a7a;"></i>'.$row_item->MenuText.'</td>
                                                            <td><input class="form-check-input m-0 checkall"  data-menuid="'.$row_item->MenuId.'" type="checkbox"></td>
                                                            <td><input class="form-check-input m-0 checkvisible"  data-menuid="'.$row_item->MenuId.'" type="checkbox"></td>
                                                            <td><input class="form-check-input m-0 checkview"  data-menuid="'.$row_item->MenuId.'"  type="checkbox"></td>
                                                            <td><input class="form-check-input m-0 checkedit"  data-menuid="'.$row_item->MenuId.'" type="checkbox"></td>
                                                            <td><input class="form-check-input m-0 checkdelete"  data-menuid="'.$row_item->MenuId.'" type="checkbox"></td>
                                                            <td><input class="form-check-input m-0 checkexport"  data-menuid="'.$row_item->MenuId.'" type="checkbox"></td>
                                                        </tr>';
                                                }
                                            }
                                        }
                                    }
                                ?> 
                            </tbody>
                        </table> 
                    </div> 
                </div> 
            </div> 
            <div class="modal-footer"> 
                <button type="submit" class="btn btn-success" id="btn-submit">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
            </div>
        </div>
    </div>
</div>
<script>
    $("#data-table").freezeTable({ 
        'container': '#modal-action.modal', 
    });
    var req_status_add = false;
    $("#checkall").change(function(){ 
        $("#checkvisible").prop('checked', this.checked).trigger("change");
        $("#checkview").prop('checked', this.checked).trigger("change");
        $("#checkedit").prop('checked', this.checked).trigger("change");
        $("#checkdelete").prop('checked', this.checked).trigger("change");
        $("#checkexport").prop('checked', this.checked).trigger("change");  
        $(".checkall").prop('checked', this.checked);
    });
    $("#checkvisible").change(function(){  
        $(".checkvisible").prop('checked', this.checked);
    });
    $("#checkview").change(function(){  
        $(".checkview").prop('checked', this.checked);
    });
    $("#checkedit").change(function(){  
        $(".checkedit").prop('checked', this.checked);
    });
    $("#checkdelete").change(function(){  
        $(".checkdelete").prop('checked', this.checked);
    });
    $("#checkexport").change(function(){  
        $(".checkexport").prop('checked', this.checked);
    }); 

    subaction = function(name,t){
        var content = $(t).find("i");
        if($(content).hasClass("close")){
            $(content).removeClass("close");
            $(content).addClass("open fa-rotate-90");
            $("."+name).removeClass("d-none"); 
        }else{  
            $(content).removeClass("open");
            $(content).removeClass("fa-rotate-90");
            $(content).addClass("close");
            $("."+name).addClass("d-none"); 
        }
    }
    $(".checkall").each(function(){
        $(this).change(function(){   
            $(this).parents("tr").find(".checkvisible").prop('checked', this.checked);
            $(this).parents("tr").find(".checkview").prop('checked', this.checked);
            $(this).parents("tr").find(".checkedit").prop('checked', this.checked);
            $(this).parents("tr").find(".checkdelete").prop('checked', this.checked);
            $(this).parents("tr").find(".checkexport").prop('checked', this.checked);
        }); 
    });

    $("#btn-submit").click(function(){
        if($("#MenuListingName").val()==""){ 
            Swal.fire({
                icon: 'error',
                text: 'Nama belum diisi',
                showConfirmButton: true,
                allowOutsideClick: false,
                allowEscapeKey: false, 
            });
        }else{ 
            var data_listing = [];
            $('#data-listing tr').each(function(){
                if($(this).data("id")!=undefined){
                    data_listing.push({
                        "MenuId":$(this).data("id"),
                        "MenuListingId": <?= $_listing->MenuListingId ?>,
                        "menuListingDetailStatus":($(this).find('.checkvisible').prop("checked") ? 1 : 0),
                        "menuListingDetailView":($(this).find('.checkview').prop("checked") ? 1 : 0),
                        "menuListingDetailEdit":($(this).find('.checkedit').prop("checked") ? 1 : 0),
                        "menuListingDetailDelete":($(this).find('.checkdelete').prop("checked") ? 1 : 0),
                        "menuListingDetailExport":($(this).find('.checkexport').prop("checked") ? 1 : 0),
                    });
                } 
            }) 
            if (!req_status_add) {
               $("#btn-submit").html('<i class="fas fa-circle-notch fa-spin"></i> Loading');
               $.ajax({
                    method: "POST",
                    url: "<?= site_url("function/client_data_master/data_system_listing_edit/").$_listing->MenuListingId ?>",
                    data: { 
                        "MenuListingName":$("#MenuListingName").val(),
                        "MenuListingDetail": data_listing, 
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
               return false;
            }
        }
    });
 
    /* load data yang dari database */
    var data_listing = <?= JSON_ENCODE($_listingdetail)?>;
    $.each(data_listing, function( index, value ) { 
        $('.checkvisible[data-menuid="'+ value["MenuId"] + '"]').prop('checked', (value["MenuListingDetailStatus"]== 0 ? false : true)); 
        $('.checkview[data-menuid="'+ value["MenuId"] + '"]').prop('checked', (value["MenuListingDetailView"]== 0 ? false : true)); 
        $('.checkedit[data-menuid="'+ value["MenuId"] + '"]').prop('checked', (value["MenuListingDetailEdit"]== 0 ? false : true)); 
        $('.checkdelete[data-menuid="'+ value["MenuId"] + '"]').prop('checked', (value["MenuListingDetailDelete"]== 0 ? false : true)); 
        $('.checkexport[data-menuid="'+ value["MenuId"] + '"]').prop('checked', (value["MenuListingDetailExport"]== 0 ? false : true)); 
    });  
</script>