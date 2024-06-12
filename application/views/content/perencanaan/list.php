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
         content: "\f0db";
         font-weight: 600;
         position: absolute;
         left: 10px;
      }

      .side-content-job li:hover {
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

      .side-job .header-end {
         float: right !important;
         font-family: Roboto;
         font-weight: bold;
         font-size: 1rem;
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
   </style>
</head>

<body>
   <section class="content-header">
      <div class="row mb-2">
         <div class="col-md-auto col-12">
            <h2>List Perencanaan</h2>
         </div>
         <div class="col align-self-end">
            <ol class="breadcrumb float-md-end">
               <li class="breadcrumb-item">Perencanaan Pekerjaan</li>
               <li class="breadcrumb-item active" onclick="menuselect('perencanaan-list','menu-perencanaan')" style="cursor:pointer">List Perencanaan</li>
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
                        <span>LIST DIVISI</span>
                     </div>
                     <div class="side-search">
                        <input type="text" class="form-control" id="search-divisi" placeholder="Pencarian">
                     </div>
                     <ul class="menu-divisi">
                        <?php
                        $data = $this->db->where(array("MsEmpPositionIsActive" => 1))->order_by("MsEmpPositionName ASC")->get("TblMsEmployeePosition")->result();
                        foreach ($data as $row) {
                           echo "<li><a data-id='" . $row->MsEmpPositionId . "' >" . $row->MsEmpPositionName . "</a></li>";
                        }
                        ?>
                     </ul>
                  </div>
               </div>
               <div class="side-job flex-fill">
                  <div class="d-block">
                     <span class="header">IT Program and Support</span>
                     <div class="dropdown header-end user-select-none">
                        <button class="btn btn-none" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                           <i class="fas fa-users"></i>&nbsp;Anggota
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                           <li><a class="dropdown-item"><img class="rounded-circle" src="" width="40" height="40">&nbsp;Syahrul Fauzan</a></li>
                        </ul>
                     </div>
                  </div>
                  <div class="d-block mt-4">
                     <nav>
                        <div class="nav nav-pills" id="tab-content-job" role="tablist">
                           <a class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fas fa-table"></i>&nbsp;Table</a>
                           <a class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fas fa-stream"></i>&nbsp;Timeline</a>
                           <a class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false"><i class="fas fa-chart-pie"></i>&nbsp;Chart</a>
                        </div>
                     </nav>
                     <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                           ...
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                           ...
                        </div>
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                           ...
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script>
         function keylistin(evt) {
            if (evt.which === 40) {
               console.log(" plus");
            } else if (evt.which === 38) {
               console.log("min");
            }
         }
         $(".menu-divisi li").bind('keydown', function(e) {
            if (evt.which === 40) {
               console.log("plus");
            } else if (evt.which === 38) {
               console.log("min");
            }
         });
         $("[data-bs-toggle=\'tooltip\']").tooltip();
         $('.menu-divisi li').click(function() {
            $('.menu-divisi li.active').removeClass("active");
            $(this).addClass("active");
            $.each(xhrPool, function(idx, jqXHR) {
               jqXHR.abort();
            });
            $.ajax({
               type: "POST",
               url: "<?php echo site_url('message/Message_perencanaan/load_page/') ?>",
               beforeSend: function(jqXHR, settings) {
                  xhrPool.push(jqXHR);
               },
               data: {
                  "id": $(this).data("id")
               },
               success: function(response) {
                  $(".side-job").html(response);
               },
               error: function(xhr, status, error) {
                  console.log(xhr.responseText);
               }
            });
         });
         $("#search-divisi").keydown(function(evt) {
            if (evt.key === "Tab") {
               evt.preventDefault();
               $('.menu-divisi li.active').removeClass("active");
               $('.menu-divisi').find("li:not(.hide):first").focus().addClass("active");
               $(this).blur();
            }
         });
         $('#search-divisi').bind('keyup', function(e) {
            var searchString = $(this).val();
            $("ul.menu-divisi li").each(function(index, value) {
               currentName = $(value).text();
               if (currentName.toUpperCase().indexOf(searchString.toUpperCase()) > -1) {
                  $(value).removeClass("hide");
               } else {
                  $(value).addClass("hide");
               }
            });
         });

         $(".navigation").click(function() {
            if ($(".side-content-job").hasClass("hide")) {
               $(".side-content-job").removeClass("hide");
               $(".navigation").attr('data-bs-original-title', "Sembunyikan Navigasi");
            } else {
               $(".side-content-job").addClass("hide");
               $(".navigation").attr('data-bs-original-title', "Tampilkan Navigasi");
            }
         });
      </script>

</body>

</html>