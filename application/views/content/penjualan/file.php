<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <style>
      @font-face {
         font-family: Roboto-bold;
         src: url("./asset/fontgoogle/Roboto/Roboto-Medium.ttf");
      }

      @font-face {
         font-family: Roboto;
         src: url("./asset/fontgoogle/Roboto/Roboto-Regular.ttf");
      }

      @font-face {
         font-family: NunitoSans;
         src: url("./asset/fontgoogle/NunitoSans-Bold.ttf");
      }

      body {
         font-family: 'Roboto';
      }

      .card-progress {
         min-height: 500px
      }


      .side-content-job {
         width: 300px;
         border-right: 1px solid #dedede;
         position: relative;
         transition: all 0.5s;
      }

      .side-content-job.hide {
         width: 20px;
         transition: width 0.5s;
      }

      .side-content-body {
         width: 300px;
         position: relative;
         transition: all 1s;
      }

      .side-content-job.hide .side-content-body {
         left: -300px;
         transition: all 1s;
         position: relative;
      }

      .side-content-job>.navigation {
         height: 25px;
         width: 25px;
         position: absolute;
         right: -12px;
         top: 10px;
         background: white;
         border-radius: 12px;
         border: 1px solid #dedede;
         z-index: 10;
      }

      .side-content-job>.navigation:hover {
         cursor: pointer;
         background: #ff6600;
         transition: all 0.2s;
         width: 40px;
         border: 1px solid #ff6600;
         color: white;
      }

      .side-content-job.hide>.navigation:hover {
         transition: all 0.2s;
         width: 25px;
      }

      .side-content-job.hide div.menu-divisi {
         display: none !important;
      }

      .side-content-job>.navigation:before {
         font-family: "Font Awesome 5 Free";
         content: "\f104";
         font-weight: 600;
         font-size: 1rem;
         padding-left: 0.4rem;
         transition: all .3s;
      }

      .side-content-job.hide>.navigation:before {
         display: inline-block;
         transform: rotate(180deg);
         padding-right: 0.5rem;
      }

      .side-content-job .side-header {
         font-family: Roboto-bold;
         padding: 0.5rem 1rem;
         font-size: 0.85rem;
         border-bottom: 1px solid #dedede;
      }

      .side-content-job.hide .side-header {
         display: none;
      }

      .side-content-job .side-search {
         font-family: Roboto;
         padding: 0.5rem;
         font-size: 0.85rem;
         position: relative;
         display: flex;
         align-items: center;
         color: gray;
         border-bottom: 1px solid #dedede;
         letter-spacing: 2px;
      }

      .side-content-job.hide .side-search {
         display: none;
      }

      .side-content-job .side-search>input {
         border: 1px solid white;
         padding: 0.2rem 1.6rem;
         color: inherit;
         font-size: 0.85rem;
      }

      .side-content-job .side-search>input:hover {
         background: #ffb473;
         border: 1px solid #ffb473 !important;
         box-shadow: none !important;
         transition: all 0.3s;
      }

      .side-content-job .side-search>input:focus {
         background: white;
         border: 1px solid #ff6600 !important;
         box-shadow: none !important;
         transition: all 0.3s;
      }

      .side-content-job .side-search::before {
         font-family: "Font Awesome 5 Free";
         content: "\f002";
         font-weight: 600;
         position: absolute;
         left: 1rem;
      }


      .side-content-job ul {
         display: block;
         padding: 0.5rem;
         height: 320px;
         overflow: auto
      }

      .side-content-job.hide ul {
         display: none;
      }

      .side-content-job li {
         font-family: Roboto-bold;
         font-weight: 400;
         position: relative;
         display: block;
         padding: 0.5rem;
         padding-left: 2rem;
         color: #646464;
         letter-spacing: 0.5px;
      }

      .side-content-job li.hide {
         display: none;
      }

      .side-content-job li.active {
         background: #ffcead !important;
         color: #4f4f4f;
         border-radius: 10px;
         border-bottom-left-radius: 0;
         border-top-left-radius: 0;
      }

      .side-content-job li::before {
         font-family: "Font Awesome 5 Free";
         content: "\f007";
         font-weight: 600;
         position: absolute;
         left: 10px;
      }

      .side-content-job .menu-divisi li:hover {
         background: #ececec;
         border-radius: 10px;
         border-bottom-left-radius: 0;
         border-top-left-radius: 0;
         cursor: pointer;
         transition: all 0.2s;
      }

      .side-job {
         min-height: 500px;
         padding: 1rem 2rem;
      }

      .side-job .header {

         font-family: NunitoSans;
         font-weight: 400;
         font-size: 2rem;
         padding: 0.5rem;
         border-radius: 0.25rem;
      }

      .side-job .header:hover {
         background: #e6e9ef;
      }

      .side-job .detail {

         font-family: NunitoSans;
         font-weight: 400;
         font-size: 1rem;
         padding: 0.5rem;
         border-radius: 0.25rem;
      }

      .side-job .detail:hover {
         background: #e6e9ef;
      }

      .side-job .header-end {
         float: right !important;
         font-family: Roboto;
         font-weight: bold;
         font-size: 0.8rem;
      }

      .header-end>button:hover {
         background: #ffcead !important;
      }

      .side-job .nav-pills {
         border-bottom: 1px solid #dedede;
      }

      .side-job .nav-pills a.nav-link {
         color: #646464 !important;
         background: none !important;
         cursor: pointer;
         border-radius: 0;
      }

      .side-job .nav-pills a.nav-link:hover {
         background: #e6e9ef !important;
      }

      .side-job .nav-pills a.nav-link.active {
         border-bottom: 2px solid #ff6600 !important;
      }

      .body.flex {
         display: flex !important;
         flex-wrap: wrap !important;
      }

      .body.column {
         display: flex !important;
         flex-direction: column !important;
      }

      .body.flex>.file-content {
         border: 1px solid #bfbfbf;
         border-radius: 0.5rem;
         margin: 0.25rem;
         width: 10rem;
         height: 12rem;
         position: relative;
      }

      .body.flex>.file-content:hover {
         cursor: pointer;
      }

      .body.flex>.file-content>.file {
         position: absolute;
         width: 70%;
         height: 70%;
         left: 50%;
         top: 10%;
         transform: translateX(-50%);
      }

      .body.flex>.file-content>.file img {
         width: 100%;
         object-fit: cover;
         height: 80%;
         transition: 0.3s;
      }

      .body.flex>.file-content:hover>.file img {
         transform: scale(1.1);
         transition: 0.3s;
      }

      .body.flex>.file-content>.file>.fa {
         font-size: 5rem;
         color: #9a9a9a;
         transition: 0.3s;
      }

      .body.flex>.file-content:hover>.file>.fa {
         transform: scale(1.1);
         transition: 0.3s;
      }

      .body.flex>.file-content>.title {
         color: #636363;
         position: absolute;
         bottom: 10px;
         left: 50%;
         transform: translateX(-50%);
         font-weight: 400;
         font-size: 0.75rem;
      }

      .body.flex>.file-content>.title:hover>span {
         background: white;
      }

      .body.flex>.file-content>.title:hover {
         overflow: revert !important;
         background-size: cover;
         text-shadow: 0px 0px 8px #9b9b9b !important;
         z-index: 1000;
      }

      .body.flex>.file-content>.action {
         position: absolute;
         top: 5px;
         right: -30px;
         opacity: 0;
         transition: all .3s;
      }

      .body.flex>.file-content:hover>.action {
         right: 5px;
         opacity: 1;
         transition: all .3s;
         box-shadow: 3px 2px 5px #6f6f6f;
      }

      .timeline-item {
         background: #fff;
         border: 1px solid;
         border-color: #e5e6e9 #dfe0e4 #d0d1d5;
         border-radius: 3px;
         padding: 12px;

         margin: 0 auto;
         max-width: 472px;
         min-height: 200px;
      }

      @keyframes placeHolderShimmer {
         0% {
            background-position: -468px 0
         }

         100% {
            background-position: 468px 0
         }
      }

      .animated-background {
         animation-duration: 1s;
         animation-fill-mode: forwards;
         animation-iteration-count: infinite;
         animation-name: placeHolderShimmer;
         animation-timing-function: linear;
         background: #f6f7f8;
         background: linear-gradient(to right, #eeeeee 8%, #dddddd 18%, #eeeeee 33%);
         background-size: 800px 104px;
         height: 50px;
         position: relative;
      }

      .background-masker {
         background: #fff;
         position: absolute;
      }

      .background-masker.header {
         top: 15px;
         left: 35px;
         right: 0;
         height: 5px;
      }

      .background-masker.detail {
         top: 34px;
         left: 35px;
         right: 0;
         height: 16px;
      }

      .background-masker.bottom {
         left: 236px;
         right: 0;
         top: 0;
         height: 15px;
      }

      .background-masker.icon {
         top: 0;
         bottom: 0;
      }

      .background-masker.icon-bottom {
         left: 0;
         top: 34px;
         width: 35px;
      }
   </style>
</head>

<body>
   <section class="content-header">
      <div class="row mb-2">
         <div class="col-md-auto col-12">
            <h2 onclick="menuselect('penjualan-file','menu-penjualan')">File Pelanggan</h2>
         </div>
         <div class="col align-self-end">
            <ol class="breadcrumb float-md-end">
               <li class="breadcrumb-item">Penjualan</li>
               <li class="breadcrumb-item active" onclick="menuselect('penjualan-file','menu-penjualan')" style="cursor:pointer">File Pelanggan</li>
            </ol>
         </div>
      </div>
   </section>

   <div class="row page-content">
      <div class="col-12">
         <div class="card border-top-orange card-progress">
            <div class="d-block d-flex flex-row justify-content-between">
               <div class="side-content-job col-auto">
                  <div class="navigation" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Sembunyikan Navigasi"></div>
                  <div class="side-content-body">
                     <div class="side-header">
                        <span>List Pelanggan</span><br>

                        <div class="row mt-2 align-items-center">
                           <label for="MsWorkplaceId" class="col-sm-3 col-form-label">Toko</label>
                           <div class="col-sm-9">
                              <select class="custom-select custom-select-sm form-control form-control-sm select-modal" id="MsWorkplaceId" name="MsWorkplaceId" style="width:100%">
                                 <?php
                                 $db = $this->db->where("MsWorkplaceIsActive=1")->get("TblMsWorkplace")->result();
                                 foreach ($db as $key) {
                                    echo '<option value="' . $key->MsWorkplaceId . '"  ' . ($this->session->userdata("MsWorkplaceId") == $key->MsWorkplaceId ? "selected" : "") . ' data-template="' . $key->MsWorkplaceTemplate . '">' . $key->MsWorkplaceCode . '</option>';
                                 }
                                 ?>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="side-search">
                        <input type="text" class="form-control" id="search-file" placeholder="Pencarian">
                     </div>
                     <ul class="loading">
                        <li class="animated-background">
                           <div class="background-masker header">&nbsp;</div>
                           <div class="background-masker detail">&nbsp;</div>
                           <div class="background-masker bottom">&nbsp;</div>
                           <div class="background-masker icon">&nbsp;</div>
                           <div class="background-masker icon-bottom">&nbsp;</div>
                        </li>
                        <li class="animated-background">
                           <div class="background-masker header">&nbsp;</div>
                           <div class="background-masker detail">&nbsp;</div>
                           <div class="background-masker bottom">&nbsp;</div>
                           <div class="background-masker icon">&nbsp;</div>
                           <div class="background-masker icon-bottom">&nbsp;</div>
                        </li>
                        <li class="animated-background">
                           <div class="background-masker header">&nbsp;</div>
                           <div class="background-masker detail">&nbsp;</div>
                           <div class="background-masker bottom">&nbsp;</div>
                           <div class="background-masker icon">&nbsp;</div>
                           <div class="background-masker icon-bottom">&nbsp;</div>
                        </li>
                        <li class="animated-background">
                           <div class="background-masker header">&nbsp;</div>
                           <div class="background-masker detail">&nbsp;</div>
                           <div class="background-masker bottom">&nbsp;</div>
                           <div class="background-masker icon">&nbsp;</div>
                           <div class="background-masker icon-bottom">&nbsp;</div>
                        </li>
                        <li class="animated-background">
                           <div class="background-masker header">&nbsp;</div>
                           <div class="background-masker detail">&nbsp;</div>
                           <div class="background-masker bottom">&nbsp;</div>
                           <div class="background-masker icon">&nbsp;</div>
                           <div class="background-masker icon-bottom">&nbsp;</div>
                        </li>
                        <li class="animated-background">
                           <div class="background-masker header">&nbsp;</div>
                           <div class="background-masker detail">&nbsp;</div>
                           <div class="background-masker bottom">&nbsp;</div>
                           <div class="background-masker icon">&nbsp;</div>
                           <div class="background-masker icon-bottom">&nbsp;</div>
                        </li>
                     </ul>

                     <ul class="menu-divisi" style="display:none">
                        <li class="animated-background">
                           <div class="background-masker header">&nbsp;</div>
                           <div class="background-masker detail">&nbsp;</div>
                           <div class="background-masker bottom">&nbsp;</div>
                           <div class="background-masker icon">&nbsp;</div>
                           <div class="background-masker icon-bottom">&nbsp;</div>
                        </li>
                        <li class="animated-background">
                           <div class="background-masker header">&nbsp;</div>
                           <div class="background-masker detail">&nbsp;</div>
                           <div class="background-masker bottom">&nbsp;</div>
                           <div class="background-masker icon">&nbsp;</div>
                           <div class="background-masker icon-bottom">&nbsp;</div>
                        </li>
                        <li class="animated-background">
                           <div class="background-masker header">&nbsp;</div>
                           <div class="background-masker detail">&nbsp;</div>
                           <div class="background-masker bottom">&nbsp;</div>
                           <div class="background-masker icon">&nbsp;</div>
                           <div class="background-masker icon-bottom">&nbsp;</div>
                        </li>
                        <li class="animated-background">
                           <div class="background-masker header">&nbsp;</div>
                           <div class="background-masker detail">&nbsp;</div>
                           <div class="background-masker bottom">&nbsp;</div>
                           <div class="background-masker icon">&nbsp;</div>
                           <div class="background-masker icon-bottom">&nbsp;</div>
                        </li>
                        <li class="animated-background">
                           <div class="background-masker header">&nbsp;</div>
                           <div class="background-masker detail">&nbsp;</div>
                           <div class="background-masker bottom">&nbsp;</div>
                           <div class="background-masker icon">&nbsp;</div>
                           <div class="background-masker icon-bottom">&nbsp;</div>
                        </li>
                        <li class="animated-background">
                           <div class="background-masker header">&nbsp;</div>
                           <div class="background-masker detail">&nbsp;</div>
                           <div class="background-masker bottom">&nbsp;</div>
                           <div class="background-masker icon">&nbsp;</div>
                           <div class="background-masker icon-bottom">&nbsp;</div>
                        </li>
                     </ul>
                     <div class="menu-divisi d-flex" style="display:none;background: #e6e9ef;">
                        <div class="p-1 w-100 ps-4">Total Customer</div>
                        <div class="p-1 flex-shrink-1 pe-4 total-row">-</div>
                     </div>
                     <div class="menu-divisi d-flex" style="display:none;background: #e6e9ef;">
                        <div class="p-1 w-100 ps-4">Total File</div>
                        <div class="p-1 flex-shrink-1 pe-4 total-file">-</div>
                     </div>
                     <div class="d-flex justify-content-center m-2">
                        <button id="btn-upload" class="btn btn-primary btn-sm">
                           <i class="fa fa-upload " aria-hidden="true"></i>
                           &nbsp;Upload File
                        </button>
                     </div>
                  </div>
               </div>
               <div class="side-job flex-fill">
                  <div class="d-block">
                     <span class="header">17CS00016 - Bpk Dedi</span><br>
                     <span class="detail">perumahan permata cimanggis cluster onyx blok I 1 no 36</span>

                     <span class="header-end">Total File : 10</span>
                  </div>
                  <div class="body flex">
                     <div class="file-content">
                        <div class="file text-center">
                           <img id="img-0" src="https://obi-system.com/function/client_data_sales/resize_image/8055/VentalisB.jpeg" alt="17CS00016 - Bpk Dedi  | VentalisB.jpeg" data-title="17CS00016 - Bpk Dedi  | VentalisB.jpeg" data-url="https://obi-system.com/uploads/customer/8055/VentalisB.jpeg" data-filename="VentalisB.jpeg" data-folder="8055">
                        </div>
                        <div class="title d-inline-block text-truncate" style="max-width: 150px;">
                           <span>VentalisB.jpeg</span>
                        </div>
                        <div class="btn-group-vertical  btn-group-sm d-flex rounded flex-column action" role="group" aria-label="Button group with nested dropdown">
                           <button type="button" class="btn btn-light "><i class="fas fa-eye" aria-hidden="true" onclick="$('#img-0').click()"></i></button>
                           <button type="button" class="btn btn-light "><i class="fas fa-pencil-alt" aria-hidden="true" onclick="edit_file($('#img-0'))"></i></button>
                           <button type="button" class="btn btn-light "><i class="fas fa-times" aria-hidden="true" onclick="delete_file($('#img-0'))"></i></button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div id="dialog-box">
   </div>
   <div id="modal-pdf" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog full_modal-dialog">
         <div class="modal-content full_modal-content">
            <div class="modal-header">
               <h5 class="modal-title text-truncate">Modal title</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body p-0">
               <embed src="" frameborder="0" width="100%" height="400px">
            </div>
         </div>
      </div>
   </div>

   <script>
      var id_customer = "";
      $(".navigation").click(function() {
         if ($(".side-content-job").hasClass("hide")) {
            $(".side-content-job").removeClass("hide");
            $(".navigation").attr('data-bs-original-title', "Sembunyikan Navigasi");
         } else {
            $(".side-content-job").addClass("hide");
            $(".navigation").attr('data-bs-original-title', "Tampilkan Navigasi");
         }
      });

      function get_list_file() {
         $.ajax({
            method: "POST",
            data: {
               "MsWorkplaceId": $("#MsWorkplaceId").val(),
               "search": $("#search-file").val(),
            },
            url: "<?php echo site_url('function/client_datatable_sales/get_list_file/') ?>" + id_customer,
            success: function(response) {
               $('.side-job').html(response);
            }
         });
      }

      function get_list_customer() {
         $.ajax({
            method: "POST",
            data: {
               "MsWorkplaceId": $("#MsWorkplaceId").val(),
               "search": $("#search-file").val(),
            },
            dataType: "json",
            url: "<?php echo site_url('function/client_datatable_sales/get_list_cs/') ?>",
            before: function() {
               $('ul.loading').show();
               $('ul.menu-divisi').hide();
            },
            success: function(response) {
               $("ul.menu-divisi").html(response["list"]);
               $(".total-row").html(response["total"]);
               $(".total-file").html(response["file"]);

               $('ul.menu-divisi li').unbind().click(function() {
                  $('.menu-divisi li.active').removeClass("active");
                  $(this).addClass("active");
                  id_customer = $(this).children().data("id");
                  get_list_file();
               });
               $('ul.loading').hide();
               $('ul.menu-divisi').show();
               id_customer = response["first"];
               get_list_file();
            },
            error: function(xhr, status, error) {
               console.log(xhr.responseText);
            }
         });
      }
      $("#MsWorkplaceId").change(function() {
         get_list_customer();
      });
      $('#search-file').keyup(function() {
         get_list_customer();
      });
      get_list_customer()



      show_pdf = function(data) {
         $("#modal-pdf").find(".modal-title").text($(data).data("title"));
         $("#modal-pdf").find(".modal-body").html('<embed src="' + $(data).data(" url") + '" frameborder="0" width="100%" height="100%">');
         $("#modal-pdf").modal("show");
      }
      show_file = function(data) {
         $("#modal-pdf").find(".modal-title").text($(data).data("title"));
         var urlfile = "https://view.officeapps.live.com/op/embed.aspx?src=" + encodeURI($(data).data("url"));
         $("#modal-pdf").find(".modal-body").html("<iframe src='" + urlfile + "' width='100%' height='100%'></iframe>");
         $("#modal-pdf").modal("show");
      }

      $("#btn-upload").click(function() {
         $.ajax({
            url: "<?php echo site_url('message/message_sales/file_upload/') ?>",
            success: function(response) {
               $("#dialog-box").html(response);
               $("#modal-action").modal("show");
               $('#modal-action').on('hidden.bs.modal', function(e) {
                  get_list_customer();
               });
            },
            error: function(xhr, status, error) {
               console.log(xhr.responseText);
            }
         });
      })


      edit_file = function(data, id) {
         Swal.fire({
            title: 'ubah nama file',
            input: 'text',
            inputValue: $(data).data("filename"),
            inputAttributes: {
               autocapitalize: 'off'
            },
            inputValidator: (value) => {
               if (!value) {
                  return 'nama file tidak boleh kosong!'
               }
            },
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !Swal.isLoading()
         }).then((result) => {
            if (result.isConfirmed) {
               $.ajax({
                  method: "POST",
                  url: "<?= site_url("function/client_data_sales/customer_rename_file/") ?>" + id,
                  data: {
                     FileCustomerDesc: `${result.value}`,
                  },
                  success: function(datas) {
                     if (datas) {
                        Swal.fire({
                           icon: 'success',
                           text: 'Ubah nama berhasil',
                           showConfirmButton: false,
                           allowOutsideClick: false,
                           allowEscapeKey: false,
                           timer: 1500,
                        }).then((result) => {
                           if (result.dismiss === Swal.DismissReason.timer) {
                              get_list_file();
                           }
                        });
                     } else {
                        Swal.fire({
                           icon: 'error',
                           text: 'Ubah nama gagal',
                           showConfirmButton: false,
                           allowOutsideClick: false,
                           allowEscapeKey: false,
                           timer: 1500
                        });
                        get_list_file();
                     }
                  }
               });
            }
         })
      }

      delete_file = function(data, id) {
         const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
               confirmButton: 'btn btn-success mx-1',
               cancelButton: 'btn btn-secondary mx-1'
            },
            buttonsStyling: false
         });
         swalWithBootstrapButtons.fire({
            title: "Hapus File!",
            html: 'Anda yakin ingin menghapus file <b>' + $(data).data("filename") + '<b>...?',
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
                  url: "<?= site_url("function/client_data_sales/customer_delete_file/") ?>" + $(data).data("folder") + "/" + $(data).data("filename") + "/" + id,
                  before: function() {
                     req_status_add = 1;
                  },
                  success: function(datas) {
                     req_status_add = 0;
                     if (datas) {
                        Swal.fire({
                           icon: 'success',
                           text: 'hapus data berhasil',
                           showConfirmButton: false,
                           allowOutsideClick: false,
                           allowEscapeKey: false,
                           timer: 1500,
                        }).then((result) => {
                           if (result.dismiss === Swal.DismissReason.timer) {
                              get_list_file();
                           }
                        });
                     } else {
                        Swal.fire({
                           icon: 'error',
                           text: 'hapus data gagal',
                           showConfirmButton: false,
                           allowOutsideClick: false,
                           allowEscapeKey: false,
                           timer: 1500
                        });
                        get_list_file();
                     }
                  }
               });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
               return false;
            }
         });
      }

      tambah_file = function(cust, store) {
         $.ajax({
            type: "POST",
            url: "<?php echo site_url('message/message_sales/file_upload_cs/') ?>",
            data: {
               "Customer": cust,
               "Store": store
            },
            success: function(response) {
               $("#dialog-box").html(response);
               $("#modal-action").modal("show");
               $('#modal-action').on('hidden.bs.modal', function(e) {
                  get_list_customer();
               });
            },
            error: function(xhr, status, error) {
               console.log(xhr.responseText);
            }
         });
      }
   </script>

</body>

</html>