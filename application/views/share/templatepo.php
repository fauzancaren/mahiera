<!DOCTYPE html>
<html>

<head>
   <meta charset="UTF-8">
   <meta name="mobile-web-app-capable" content="yes">

   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="apple-mobile-web-app-title" content="Omahbata">
   <meta name="theme-color" content="#42b549">
   <meta name="page-type" content="productdetailpage-desktop" data-rh="true">
   <meta name="title" content="Detail Transaksi" data-rh="true">
   <meta name="twitter:card" content="transaksi" data-rh="true">
   <meta name="twitter:site" content="@omahbata" data-rh="true">
   <meta name="twitter:creator" content="@omahbata" data-rh="true">
   <meta name="twitter:image" content="<?php echo base_url('asset/image/mgs-erp/logo.png') ?>" data-rh="true">
   <link rel="shortcut icon" href="<?php echo base_url('asset/image/mgs-erp/logo.ico') ?>">


   <link href="<?= base_url("asset/bootstrap-5.0/css/bootstrap.min.css") ?>" rel="stylesheet" type="text/css">
   <link href="<?= base_url("asset/fontawesome5/fontawesome.min.css") ?>" rel="stylesheet" type="text/css">
   <link href="<?= base_url("asset/fontawesome5/all.min.css") ?>" rel="stylesheet" type="text/css">
   <link href="<?= base_url("asset/sweetalert/dist/sweetalert2.min.css") ?>" rel="stylesheet" type="text/css">

   <script src="<?= base_url("asset/bootstrap-5.0/js/bootstrap.bundle.min.js") ?>"></script>
   <script src="<?= base_url("asset/jquery/jquery-3.6.0.min.js") ?>"></script>
   <script src="<?= base_url("asset/sweetalert/dist/sweetalert2.min.js") ?>"></script>
   <script src="<?= base_url("asset/zoom/panzoom.min.js") ?>"></script>
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;1,100;1,200;1,300;1,400;1,500&display=swap" rel="stylesheet">
   <style>
      body {
         background: #efefef;
         font-size: 0.8rem;
      }

      .text-header {
         color: #ff6600;
         font-size: 20px;
      }

      .text-header-card {
         color: #ff6600;
         font-size: 20px;

      }

      .text-judul {
         font-family: 'Poppins', sans-serif;
         font-weight: 400;
         color: gray;
         font-size: 0.75rem;
      }

      .border-top-orange {
         border-top: 2px solid #f0ad4e;
      }

      .border-top-orange::before {
         content: "";
         position: absolute;
         top: 35px;
         left: -12px;
         width: 25px;
         height: 8px;
         background-color: #ff8d00;
      }

      .line-orange {
         color: #f0ad4e;
      }

      .label-border-right {
         text-align: left;
         width: 96%;
         border-bottom: 1px solid #dee2e6;
         line-height: 0.1em;
         margin: 10px 10px 5px 15px;
      }

      .label-border-right .label-dialog {
         background: #fff;
         left: -3px;
         top: -10px;
         font-family: 'Mukta', sans-serif;
         font-weight: bold;
         position: absolute;
         color: #ff8d00;
      }

      .btn-transparent {
         color: #6754ff;
         border: 1px solid;
         transition: all 0.3s;
      }

      .btn-transparent:hover {
         background: #fff0de;
         border-radius: 0.5rem;
         color: #6754ff;
      }

      .action-zoom {
         position: absolute;
         bottom: 50px;
         width: 100%;
         display: flex;
         padding: 0.2rem 1rem;
         text-align: center;
         display: flex;
         justify-content: center;
      }

      .action-zoom a {
         background: #000000de;
         padding: 0.5rem 0.7rem;
         font-size: 1rem;
         color: white !important;
      }

      .action-zoom a:hover {
         background: #000000b5;
         cursor: pointer;
      }

      .label-span {
         min-width: 5rem !important;
         max-width: 5rem !important;
         display: inline-block;
      }

      .bg-pinpoint {
         display: flex;
         -webkit-box-align: center;
         align-items: center;
         -webkit-box-pack: justify;
         justify-content: space-between;
         padding: 8px 16px;
         border: 1px solid var(--N75, #E5E7E9);
         border-radius: 8px;
         background: url('<?= base_url('asset/image/mgs-erp/bg-map.png') ?>') center center / cover no-repeat rgb(242, 242, 242);
      }

      .list-progress {
         position: relative;
         padding: 0.5rem 0;
         margin-top: 0.5rem;
      }

      .list-progress>span:nth-child(1) {
         position: absolute;
         top: 50%;
         transform: translateY(-50%);
         font-size: 1rem;
         left: 25%;
      }

      .list-progress>span>i.fa-stack-2x {
         color: #e9ecef;
      }

      .list-progress>span.success>i.fa-stack-2x {
         color: #198754;
      }

      .list-progress>span>i.fa-stack-1x {
         color: #8e7efb;
      }

      .list-progress>span.success>i.fa-stack-1x {
         color: #f9fafb;
      }

      .list-progress>span:nth-child(2) {
         position: absolute;
         top: 50%;
         transform: translateY(-50%);
         font-size: 1rem;
         left: 58%;
      }

      .list-progress>span:nth-child(3) {
         position: absolute;
         top: 50%;
         transform: translateY(-50%);
         font-size: 1rem;
         left: 90%;
      }
   </style>
</head>

<body>
   <div class="container">
      <div class="card m-2 shadow border-top-orange">
         <div class="card-body p-4">
            <h5 class="card-title">
               <a class="navbar-brand fw-bold">
                  <span class="fw-bold text-header-card user-select-none">Detail Pembelian Barang</span>
               </a>
            </h5>
            <?php
            $delivery = "";
            foreach ($_delivery as $row) {
               $query1 = $this->db->query("select * from TblPODetail left join TblMsItem on TblPODetail.MsItemId=TblMsItem.MsItemId LEFT JOIN TblMsItemCategory on TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId  where PODetailRef='" . $row->POCode . "'")->result();
               $detailpo = "";
               foreach ($query1 as $row1) {
                  $detailpo .= '    <div class="row align-items-center border-light border-bottom border-top me-2 py-1">
                                                      <div class="col-8">
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemCode . '-' . $row1->MsItemName . '</span><br>
                                                            <span class="text-secondary">Ukuran : <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemSize . '</span></span>
                                                      </div>
                                                      <div class="col-4 text-right">
                                                            <span class="text-secondary">Qty</span><br>
                                                            <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->PODetailQty . ' ' . $row1->MsItemUoM . '</span>
                                                      </div>
                                                </div>';
               }
               if ($row->POStatus == 0) {
                  $valueprogress = 30;
                  $button = ' <div class="col-md-12 d-flex pt-2">
                                                <button type="button" onclick="po_edit(\'' . $row->POId . '\')" class="btn btn-transparent btn-sm mx-1" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-pencil-alt"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Edit
                                                      </span>
                                                </button>
                                                <button type="button" class="btn btn-transparent btn-sm mx-1 dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-print"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Print
                                                      </span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-sm w-16rem">
                                                      <li><a class="dropdown-item" onclick="po_print_a5(\'' . $row->POId . '\')"><i class="fas fa-file"  style="min-width:20px"></i>&nbsp;Print ukuran A5</a></li>
                                                      <li><a class="dropdown-item" onclick="po_print_a6(\'' . $row->POId . '\')"><i class="fas fa-file"  style="min-width:20px"></i>&nbsp;Print ukuran A6</a></li>
                                                </ul>
                                                <button type="button" onclick="po_delete(\'' . $row->POId . '\')" class="btn btn-transparent btn-sm mx-1" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-times"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Hapus
                                                      </span>
                                                </button>
                                                <button type="button" class="btn btn-transparent btn-sm mx-1 ms-auto" onclick="po_selesai(' . $row->POId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-share-square"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Selesaikan
                                                      </span>
                                                </button>
                                          </div>';
               } else if ($row->POStatus == 1) {
                  $valueprogress = 65;
                  $button = ' <div class="col-md-12 d-flex pt-2">
                                                <button type="button" onclick="po_edit(\'' . $row->POId . '\')" class="btn btn-transparent btn-sm mx-1" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-pencil-alt"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Edit
                                                      </span>
                                                </button>
                                                <button type="button" class="btn btn-transparent btn-sm mx-1 dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-print"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Print
                                                      </span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-sm w-16rem">
                                                      <li><a class="dropdown-item" onclick="po_print_a5(\'' . $row->POId . '\')"><i class="fas fa-file"  style="min-width:20px"></i>&nbsp;Print ukuran A5</a></li>
                                                      <li><a class="dropdown-item" onclick="po_print_a6(\'' . $row->POId . '\')"><i class="fas fa-file"  style="min-width:20px"></i>&nbsp;Print ukuran A6</a></li>
                                                </ul>
                                                <button type="button" onclick="po_delete(\'' . $row->POId . '\')" class="btn btn-transparent btn-sm mx-1" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-times"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Hapus
                                                      </span>
                                                </button>
                                                <button type="button" class="btn btn-transparent btn-sm mx-1 ms-auto" onclick="po_selesai(' . $row->POId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-share-square"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Selesaikan
                                                      </span>
                                                </button>
                                          </div>';
               } else if ($row->POStatus == 2) {
                  $valueprogress = 100;
                  $button = ' <div class="col-md-12 d-flex pt-2">        
                                                <button type="button" class="btn btn-transparent btn-sm mx-1 dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                      <i class="fas fa-print"></i>  
                                                      <span class="fw-bold">
                                                      &nbsp;Print
                                                      </span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-sm w-16rem">
                                                      <li><a class="dropdown-item" onclick="po_print_a5(\'' . $row->POId . '\')"><i class="fas fa-file"  style="min-width:20px"></i>&nbsp;Print ukuran A5</a></li>
                                                      <li><a class="dropdown-item" onclick="po_print_a6(\'' . $row->POId . '\')"><i class="fas fa-file"  style="min-width:20px"></i>&nbsp;Print ukuran A6</a></li>
                                                </ul>
                                          </div>';
               }
               $delivery .= '<div class="mx-2 p-2" style="border-bottom: 1px dashed #ff7900;">
                                          <div class="row py-1 g-1">
                                                <div class="col-lg-4 col-md-6 col-12">
                                                      <span class="text-secondary label-span">No. PO</span><span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->POCode . '</span><br> 
                                                      <span class="text-secondary label-span">Tgl.</span><span class="text-dark fw-bold" style="font-size:0.7rem;">' . date_format(date_create($row->PODate), "d F Y") . '</span><br>
                                                      <span class="text-secondary label-span">Vendor</span><span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->MsVendorName . '</span><br>
                                                </div> 
                                                <div class="col-lg-4 col-md-6 col-12">
                                                   <span class="text-secondary label-span">admin</span><span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->MsEmpName . '</span><br>
                                                   <span class="text-secondary label-span">Keterangan</span><span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->PORemarks . '</span>
                                                </div>
                                                <div class="col-lg-4 col-md-12 col-12">
                                                      <div class="list-progress" style="">
                                                                  <span class="fa-stack text-secondary ' . ($row->POStatus >= 0 ? "success" : "") . '" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="dijadwalkan">
                                                                        <i class="fas fa-circle fa-stack-2x" ></i>
                                                                        <i class="fas fa-calendar-alt fa-stack-1x"></i>
                                                                  </span>
                                                                  <span class="fa-stack text-secondary ' . ($row->POStatus >= 1 ? "success" : "") . '" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="diproses">
                                                                        <i class="fas fa-circle fa-stack-2x" ></i>
                                                                        <i class="fas fa-project-diagram fa-stack-1x" ></i>
                                                                  </span>
                                                                  <span class="fa-stack text-secondary ' . ($row->POStatus >= 2 ? "success" : "") . '" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="diterima">
                                                                        <i class="fas fa-circle fa-stack-2x"></i>
                                                                        <i class="fas fa-people-carry fa-stack-1x"></i>
                                                                  </span>
                                                                  <div class="progress">
                                                                        <div class="progress-bar bg-success" role="progressbar" style="width: ' . $valueprogress . '%" aria-valuenow="' . $valueprogress . '" aria-valuemin="0" aria-valuemax="100"></div>
                                                                  </div>
                                                            </div>
                                                </div>
                                                <div class="col-md-12 d-flex flex-column " style="border: 1px solid #d2cac0;border-radius: 0.25rem;">
                                                      ' . $detailpo . '
                                                </div> 
                                          </div>
                                       </div>  ';
            }

            if (strlen($delivery) == 0) $delivery = '<div class="text-center">Belum Ada pengiriman yang dibuat</div><br>';

            echo $delivery
            ?>
         </div>
      </div>
   </div>
</body>

</html>