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
   <meta name="description" content="Penjualan Atas nama  <?= ($_data->MsCustomerTypeId == 1 ? $_data->MsCustomerName : $_data->MsCustomerName . ' (' . $_data->MsCustomerCompany . ')') ?>" data-rh="true">

   <meta name="twitter:card" content="transaksi" data-rh="true">
   <meta name="twitter:site" content="@omahbata" data-rh="true">
   <meta name="twitter:creator" content="@omahbata" data-rh="true">
   <meta name="twitter:title" content="Detail Transaksi Penjualan | <?= ($_data->MsCustomerTypeId == 1 ? $_data->MsCustomerName : $_data->MsCustomerName . ' (' . $_data->MsCustomerCompany . ')') ?>" data-rh="true">
   <meta name="twitter:description" content="Nomer Sales : <?= $_data->SalesCode ?> | Tanggal Transaksi pembelian : <?= $_data->SalesCreate ?>" data-rh="true">
   <meta name="twitter:image" content="<?php echo base_url('asset/image/mgs-erp/logo.png') ?>" data-rh="true">
   <link rel="shortcut icon" href="<?php echo base_url('asset/image/mgs-erp/logo.ico') ?>">


   <link href="<?= base_url("asset/bootstrap-5.2/css/bootstrap.min.css") ?>" rel="stylesheet" type="text/css">
   <link href="<?= base_url("asset/fontawesome5/css/fontawesome.min.css") ?>" rel="stylesheet" type="text/css">
   <link href="<?= base_url("asset/fontawesome5/css/all.min.css") ?>" rel="stylesheet" type="text/css">
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
   </style>
</head>

<body>
   <div class="container">
      <!-- Content here -->
      <?php
      $customername = $_data->MsCustomerTypeId == 1 ? $_data->MsCustomerName : $_data->MsCustomerCompany . ' (' . $_data->MsCustomerName . ')';
      $customerTelp = $_data->MsCustomerTelp2 == "" ? $_data->MsCustomerTelp1 : $_data->MsCustomerTelp1 . '/' . $_data->MsCustomerTelp2;

      $sebelum_disc = 0;
      $total_disc = 0;
      $subtotal = 0;
      $table_item = "";
      $table_payment = "";
      $no = 0;
      foreach ($_detail as $row) {
         $no++;
         $table_item .= '   <tr>
                     <th scope="row" class="text-nowrap">' . $no . '</th>
                     <td class="text-nowrap">' . $row->MsItemCatName . '</td>
                     <td class="text-nowrap">' . $row->MsItemCode . '-' . $row->MsItemName . '</td>
                     <td class="text-nowrap">' . $row->MsItemSize . '</td>
                     <td class="text-nowrap">' . number_format($row->SalesDetailQty, 2) . ' ' . $row->MsItemUoM . '</td>
                     <td class="text-nowrap text-end">' . number_format($row->SalesDetailPrice) . '</td>
                     <td class="text-nowrap text-end">' . number_format($row->SalesDetailDisc) . '</td>
                     <td class="text-nowrap text-end">' . number_format($row->SalesDetailQty * $row->SalesDetailPrice) . '</td>
                  </tr>';
         $sebelum_disc += $row->SalesDetailQty * $row->SalesDetailPrice;
         $total_disc += $row->SalesDetailQty * $row->SalesDetailDisc;
         $subtotal += $row->SalesDetailTotal;
      }
      if (sizeof($_optional) > 0) {
         $no = 0;
         $table_item .=  '   <tr>
                     <th scope="row" class="text-nowrap"></th>
                     <th scope="row" class="text-nowrap" colspan="7">Biaya Lain Lain</th>
                  </tr>';
         foreach ($_optional as $row) {
            $no++;
            $table_item .= '   <tr>
                        <th scope="row" class="text-nowrap">1</th>
                        <td colspan="6" class="text-nowrap">' . $row->SalesOptionalDesc . '</td>
                        <td class="text-nowrap text-end">' . $row->SalesOptionalPrice . '</td>
                     </tr>';

            $sebelum_disc += $row->SalesOptionalPrice;
            $subtotal += $row->SalesOptionalPrice;
         }
      }

      $no = 0;
      $total_payment = 0;
      foreach ($_payment as $row) {
         $no++;
         $total_payment += $row->PaymentTotal;
         $table_payment .= '
               <tr>
                  <th scope="row" class="text-nowrap">' . $no . '</th>
                  <td class="text-nowrap">' . $row->MsMethodCode . ' - ' . $row->MsMethodName . '</td>
                  <td class="text-nowrap">' . $row->PaymentCardName . '</td>
                  <td class="text-nowrap">' . date_format(date_create($row->PaymentDate), "j F Y") . '</td>
                  <td class="text-nowrap">' . number_format($row->PaymentTotal) . '</td>
                  <td class="text-nowrap"><button type="button" class="btn btn-transparent btn-sm" aria-expanded="false" onclick="payment_view(' . $_data->SalesId . ',\'' . $row->PaymentImage . '\')" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                        <i class="fas fa-eye"></i>
                        <span class="fw-bold">
                           &nbsp;Lihat
                        </span>
                     </button></td>
               </tr>';
      }
      ?>
      <div class="row">
         <div class="col-md-4 col-12">
            <div class="card m-2 shadow border-top-orange">
               <div class="card-body p-4">
                  <h5 class="card-title">
                     <a class="navbar-brand fw-bold">
                        <img src="<?= base_url() ?>asset/image/mgs-erp/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
                        <span class="fw-bold d-none d-sm-none d-md-inline-block  text-header user-select-none">OBI - Enterprice Resource Planning</span>
                     </a>
                     <span class="fw-bold align-middle d-sm-block d-md-none text-header user-select-none">OBI - ERP</span>
                  </h5>
                  <hr class="line-orange">
                  <div class="row mt-2">
                     <div class="col">
                        <span class="text-judul"><i class="fas fa-archive me-2"></i>NO. SALES</span><br>
                        <img src="<?= base_url() ?>asset/image/logo/logo-<?= $_data->SalesHeader ?>-200.png" class="rounded" width="40">
                        <span class="fw-bold text-secondary"><?= $_data->SalesCode ?></span>
                     </div>
                  </div>
                  <div class="row mt-2">
                     <div class="col">
                        <span class="text-judul"><i class="fas fa-calendar-alt me-2"></i>Tgl. Pembelian</span><br>
                        <span class="fw-bold text-secondary"><?= date_format(date_create($_data->SalesDate), "j F Y") ?></span>
                     </div>
                  </div>
                  <div class="row mt-2">
                     <div class="col">
                        <span class="text-judul"><i class="fas fa-user-alt me-2"></i>Admin</span><br>
                        <span class="fw-bold text-secondary"><?= $_data->MsEmpName ?></span>
                     </div>
                  </div>
                  <div class="row mt-4 align-items-center">
                     <div class="label-border-right" style="position:relative">
                        <span class="label-dialog">Deskripsi Pelanggan</span>
                     </div>
                  </div>
                  <div class="row mt-2">
                     <div class="col">
                        <span class="text-judul"><i class="fas fa-id-card me-2"></i>Customer</span><br>
                        <span class="fw-bold text-secondary"><?= $customername ?></span>
                     </div>
                  </div>
                  <div class="row mt-2">
                     <div class="col">
                        <span class="text-judul"><i class="fas fa-phone-square-alt me-2"></i>Telp</span><br>
                        <span class="fw-bold text-secondary"><?= $customerTelp ?></span>
                     </div>
                  </div>
                  <div class="row mt-2">
                     <div class="col">
                        <span class="text-judul"><i class="fas fa-house-user me-2"></i>Alamat</span><br>
                        <span class="fw-bold text-secondary"><?= $_data->MsCustomerAddress ?></span>
                     </div>
                  </div>
                  <div class="row mt-4 align-items-center">
                     <div class="label-border-right" style="position:relative">
                        <span class="label-dialog">Total Transaksi</span>
                     </div>
                  </div>
                  <div class="row border-bottom border-dark mx-1 mt-2">
                     <div class="col-auto pe-0 ps-0" style="min-width:80px;">
                        <span class="fw-bold text-secondary" style="font-size:0.8rem;">Disc Item&nbsp;<i class="far fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Disc item sudah terhitung dalam sub total" aria-label="Disc item sudah terhitung dalam sub total"></i></span>
                     </div>
                     <div class="col-auto px-0" style="min-width:30px;">
                        <span class="fw-bold text-secondary" style="font-size:0.8rem;">: Rp.</span>
                     </div>
                     <div class="col text-end pe-0">
                        <span class="fw-bold text-dark" style="font-size:1rem;"><?= $total_disc ?></span>
                     </div>
                  </div>
                  <div class="row mx-1">
                     <div class="col-auto pe-0 ps-0" style="min-width:80px;">
                        <span class="fw-bold text-secondary" style="font-size:0.8rem;">Sub Total</span>
                     </div>
                     <div class="col-auto px-0" style="min-width:30px;">
                        <span class="fw-bold text-secondary" style="font-size:0.8rem;">: Rp.</span>
                     </div>
                     <div class="col text-end pe-0">
                        <span class="fw-bold text-dark" style="font-size:1rem;"><?= number_format($subtotal) ?></span>
                     </div>
                  </div>
                  <div class="row mx-1">
                     <div class="col-auto pe-0 ps-0" style="min-width:80px;">
                        <span class="fw-bold text-secondary" style="font-size:0.8rem;">Pengiriman</span>
                     </div>
                     <div class="col-auto px-0" style="min-width:30px;">
                        <span class="fw-bold text-secondary" style="font-size:0.8rem;">: Rp.</span>
                     </div>
                     <div class="col text-end pe-0">
                        <span class="fw-bold text-dark" style="font-size:1rem;"><?= number_format($_data->SalesDeliveryTotal) ?></span>
                     </div>
                  </div>
                  <div class="row mx-1">
                     <div class="col-auto pe-0 ps-0" style="min-width:80px;">
                        <span class="fw-bold text-secondary" style="font-size:0.8rem;">Diskon</span>
                     </div>
                     <div class="col-auto px-0" style="min-width:30px;">
                        <span class="fw-bold text-secondary" style="font-size:0.8rem;">: Rp.</span>
                     </div>
                     <div class="col text-end pe-0">
                        <span class="fw-bold text-dark" style="font-size:1rem;"><?= number_format($_data->SalesDiscTotal) ?></span>
                     </div>
                  </div>
                  <div class="row border-bottom border-dark mx-1">
                     <div class="col-auto pe-0 ps-0" style="min-width:80px;">
                        <span class="fw-bold text-secondary" style="font-size:0.8rem;">Grand Total</span>
                     </div>
                     <div class="col-auto px-0" style="min-width:30px;">
                        <span class="fw-bold text-secondary" style="font-size:0.8rem;">: Rp.</span>
                     </div>
                     <div class="col text-end pe-0">
                        <span class="fw-bold text-dark" style="font-size:1rem;"><?= number_format($_data->SalesGrandTotal) ?></span>
                     </div>
                  </div>
                  <div class="row border-bottom border-dark mx-1">
                     <div class="col-auto pe-0 ps-0" style="min-width:80px;">
                        <span class="fw-bold text-secondary" style="font-size:0.8rem;">Bayar</span>
                     </div>
                     <div class="col-auto px-0" style="min-width:30px;">
                        <span class="fw-bold text-secondary" style="font-size:0.8rem;">: Rp.</span>
                     </div>
                     <div class="col text-end pe-0">
                        <span class="fw-bold text-dark" style="font-size:1rem;"><?= number_format($total_payment) ?></span>
                     </div>
                  </div>
                  <div class="row mx-1">
                     <div class="col-auto pe-0 ps-0" style="min-width:80px;">
                        <span class="fw-bold text-secondary" style="font-size:0.8rem;">Sisa</span>
                     </div>
                     <div class="col-auto px-0" style="min-width:30px;">
                        <span class="fw-bold text-secondary" style="font-size:0.8rem;">: Rp.</span>
                     </div>
                     <div class="col text-end pe-0">
                        <span class="fw-bold text-dark" style="font-size:1rem;"> <?= number_format($_data->SalesGrandTotal - $total_payment) ?></span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-8 col-12">
            <div class="d-flex flex-column">
               <div class="card m-2 shadow border-top-orange">
                  <div class="card-body p-4">
                     <h5 class="card-title">
                        <a class="navbar-brand fw-bold">
                           <span class="fw-bold text-header-card user-select-none">Detail Barang</span>
                        </a>
                     </h5>
                     <div class="table-responsive" style="font-size:0.85rem">
                        <table class="table table-sm text-secondary">
                           <thead class="table-secondary">
                              <tr>
                                 <th scope="col" class="text-nowrap">#</th>
                                 <th scope="col" class="text-nowrap">Kategori</th>
                                 <th scope="col" class="text-nowrap">Nama Item</th>
                                 <th scope="col" class="text-nowrap">Ukuran</th>
                                 <th scope="col" class="text-nowrap">Qty</th>
                                 <th scope="col" class="text-nowrap">Harga</th>
                                 <th scope="col" class="text-nowrap">Disc/Item</th>
                                 <th scope="col" class="text-nowrap">Harga Total</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?= $table_item ?>
                           </tbody>
                           <tfoot>
                              <tr>
                                 <th scope="row" class="text-nowrap text-end" colspan="6">Sebelum Disc</th>
                                 <th scope="row" class="text-nowrap text-end" colspan="2"><?= number_format($sebelum_disc) ?></th>
                              </tr>
                              <tr>
                                 <th scope="row" class="text-nowrap text-end" colspan="6">Disc Item</th>
                                 <th scope="row" class="text-nowrap text-end" colspan="2"><?= number_format($total_disc) ?></th>
                              </tr>
                              <tr>
                                 <th scope="row" class="text-nowrap text-end" colspan="6">Sub Total</th>
                                 <th scope="row" class="text-nowrap text-end" colspan="2"><?= number_format($subtotal) ?></th>
                              </tr>
                           </tfoot>
                        </table>
                     </div>
                  </div>
               </div>
               <div class="card m-2 shadow border-top-orange">
                  <div class="card-body p-4">
                     <h5 class="card-title">
                        <a class="navbar-brand fw-bold">
                           <span class="fw-bold text-header-card user-select-none">Detail Pembayaran</span>
                        </a>
                     </h5>
                     <div class="table-responsive" style="font-size:0.85rem">
                        <table class="table table-sm text-secondary">
                           <thead class="table-secondary">
                              <tr>
                                 <th scope="col" class="text-nowrap">#</th>
                                 <th scope="col" class="text-nowrap">Metode Pembayaran</th>
                                 <th scope="col" class="text-nowrap">Atas Nama</th>
                                 <th scope="col" class="text-nowrap">Tanggal</th>
                                 <th scope="col" class="text-nowrap">Total</th>
                                 <th scope="col" class="text-nowrap">Bukti</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?= $table_payment ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               <div class="card m-2 shadow border-top-orange">
                  <div class="card-body p-4">
                     <h5 class="card-title">
                        <a class="navbar-brand fw-bold">
                           <span class="fw-bold text-header-card user-select-none">Detail Pengiriman</span>
                        </a>
                     </h5>
                     <?php
                     $delivery = "";
                     if ($_data->SalesDelStatus == 0) {
                        $delivery = "<div class='text-center'>Tidak Ada Pengiriman</div><br>";
                     } else {
                        foreach ($_delivery as $row) {
                           $query1 = $this->db->query("select * from TblDeliveryDetail left join TblMsItem on TblDeliveryDetail.MsItemId=TblMsItem.MsItemId LEFT JOIN TblMsItemCategory on TblMsItem.MsItemCatId=TblMsItemCategory.MsItemCatId  where DeliveryDetailRef='" . $row->DeliveryCode . "'")->result();
                           $detaildelivery = "";
                           foreach ($query1 as $row1) {
                              $detaildelivery .= '    <div class="row align-items-center border-light border-bottom border-top me-1 py-1">
                                                                  <div class="col-6">
                                                                        <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemCode . '-' . $row1->MsItemName . '</span><br>
                                                                        <span class="text-secondary">Ukuran : <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsItemSize . '</span></span>
                                                                  </div>
                                                                  <div class="col-3">
                                                                        <span class="text-secondary">Vendor</span><br>
                                                                        <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->MsVendorCode . '</span>
                                                                  </div>
                                                                  <div class="col-3 text-right">
                                                                        <span class="text-secondary">Qty</span><br>
                                                                        <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row1->DeliveryDetailQty . ' ' . $row1->MsItemUoM . '</span>
                                                                  </div>
                                                            </div>';
                           }
                           if ($row->DeliveryStatus == 0) {
                              $valueprogress = 30;
                              $button = ' <div class="col-md-12 d-flex">
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_edit(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-pencil-alt"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Edit
                                                            </span>
                                                      </button>
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_print(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-print"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Print
                                                            </span>
                                                      </button>
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_delete(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-times"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Hapus
                                                            </span>
                                                      </button>
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1 ms-auto" onclick="delivery_proses(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem"> 
                                                            <i class="fas fa-share-square"></i>
                                                            <span class="fw-bold">
                                                            &nbsp;Proses
                                                            </span>
                                                      </button>
                                                </div>';
                           } else if ($row->DeliveryStatus == 1) {
                              $valueprogress = 65;
                              $button = ' <div class="col-md-12 d-flex">
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_edit(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-pencil-alt"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Edit
                                                            </span>
                                                      </button>
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_print(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-print"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Print
                                                            </span>
                                                      </button>
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_delete(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-times"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Hapus
                                                            </span>
                                                      </button>
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1 ms-auto" onclick="delivery_selesai(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-share-square"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Selesaikan
                                                            </span>
                                                      </button>
                                                </div>';
                           } else if ($row->DeliveryStatus == 2) {
                              $valueprogress = 100;
                              $button = ' <div class="col-md-12 d-flex"> 
                                                      <button type="button" class="btn btn-transparent btn-sm mx-1" onclick="delivery_print(' . $row->DeliveryId . ')" aria-expanded="false" style="font-size:0.6rem;padding:0.2rem 0.5rem">
                                                            <i class="fas fa-print"></i>  
                                                            <span class="fw-bold">
                                                            &nbsp;Print
                                                            </span>
                                                      </button>  
                                                </div>';
                           }
                           $delivery .= '<div class="mx-2 p-2" style="border-bottom: 1px dashed #ff7900;">
                                          <div class="row py-1 g-1">
                                                <div class="col-lg-6 col-md-6 col-12">
                                                      <span class="text-secondary label-span">No. Delivery</span><span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->DeliveryCode . '</span><br>
                                                      <span class="text-secondary label-span">Rit</span><span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->DeliveryRit . '</span><br>
                                                      <span class="text-secondary label-span">Tgl. kirim</span><span class="text-dark fw-bold" style="font-size:0.7rem;">' . date_format(date_create($row->DeliveryDate), "d F Y") . '</span><br>
                                                      <span class="text-secondary label-span">Armada</span><span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->MsDeliveryName . '</span><br>
                                                </div> 
                                                <div class="col-lg-6 ps-lg-2 col-12">
                                                   <div class="row">
                                                      <div class="col label-span">
                                                         <span class="text-secondary">Penerima</span>
                                                      </div>
                                                      <div class="col">
                                                         <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->MsCustomerDeliveryReceive . ' </span><span class="text-dark fw-bold" style="font-size:0.7rem;">(' . $row->MsCustomerDeliveryTelp . ')</span>
                                                      </div>
                                                   </div> 
                                                   <div class="row">
                                                      <div class="col label-span">
                                                         <span class="text-secondary">Alamat</span>
                                                      </div>
                                                      <div class="col">
                                                         <span class="text-dark fw-bold" style="font-size:0.7rem;">' . $row->MsCustomerDeliveryAddress . '</span>
                                                      </div>
                                                   </div> 
                                                     
                                                   <span class="text-secondary">Titik Map</span><br>
                                                   <div class="bg-pinpoint">
                                                      <i class="fas fa-map-marker-alt fa-2x"></i>
                                                      <span class="label-small px-1">' . $row->MsCustomerDeliveryName . '</span>
                                                      <a class="btn btn-light py-1 ms-auto btn-sm" href="https://maps.google.com/?q=' . $row->MsCustomerDeliveryLat . ',' . $row->MsCustomerDeliveryLng . '" target="_blank" style="min-width: 5rem;">Lihat Map</a>
                                                   </div>
                                                </div>
                                                <div class="col-md-12 d-flex flex-column " style="border: 1px solid #d2cac0;border-radius: 0.25rem;">
                                                      ' . $detaildelivery . '
                                                </div> 
                                          </div>
                                       </div>  ';
                        }

                        if (strlen($delivery) == 0) $delivery = '<div class="text-center">Belum Ada pengiriman yang dibuat</div><br>';
                     }
                     echo $delivery
                     ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div id="modal-view-show">
   </div>
   <script>
      payment_view = function(id, filename) {
         if (filename) {
            var file_type = filename.split('.').pop().toLowerCase();
            var fileExtension = ["jpg", "jpeg", "png", "doc", "docx", "pdf", "xlsx", "xlx"];
            if ($.inArray(file_type, fileExtension) == -1) {
               Swal.fire({
                  icon: 'error',
                  text: 'format file tidak didukung',
                  showConfirmButton: false,
                  allowOutsideClick: false,
                  allowEscapeKey: false,
                  timer: 1500
               });
               return;
            }
            switch (file_type) {
               case "jpg":
               case "jpeg":
               case "png":
                  $.ajax({
                     type: "POST",
                     url: "<?php echo site_url('message/message_sales/show_image') ?>",
                     data: {
                        "src": "<?= base_url('asset/image/payment/') ?>" + id + "/" + filename
                     },
                     success: function(response) {
                        $("#modal-view-show").html(response);
                        $("#modal-filename").text(filename);
                        $("#modal-view").modal("show");
                     },
                     error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                     }
                  });
                  break;
               case "doc":
               case "docx":
               case "xlsx":
               case "xlx":
                  $.ajax({
                     type: "POST",
                     url: "<?php echo site_url('message/message_sales/show_file') ?>",
                     success: function(response) {
                        $("#modal-view-show").html(response);
                        $("#modal-filename").text(filename);
                        var urlfile = "https://view.officeapps.live.com/op/embed.aspx?src=<?= urlencode(base_url("asset/image/payment/")) ?>" + encodeURI(id + "/" + filename);
                        $("#modal-content").html("<iframe src='" + urlfile + "' width='100%' height='100%'></iframe>");
                        $("#modal-view").modal("show");
                     },
                     error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                     }
                  });
                  break;
               case "pdf":

                  $.ajax({
                     type: "POST",
                     url: "<?php echo site_url('message/message_sales/show_file') ?>",
                     success: function(response) {
                        $("#modal-view-show").html(response);
                        $("#modal-filename").text(filename);
                        //var urlfile = "https://docs.google.com/viewer?url=<?= urlencode(base_url("asset/image/payment/")) ?>" + encodeURI(id + "/" + filename) + "&embedded=true";
                        $("#modal-content").html('<embed type="application/pdf" src="<?= base_url("asset/image/payment/") ?>' + id + "/" + filename + '" width="100%" height="100%"></embed>');
                        //$("#modal-content").html("<iframe src='" + urlfile + "' width='100%' height='100%'></iframe>");
                        $("#modal-view").modal("show");
                     },
                     error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                     }
                  });

                  break;

               default:
                  // code block
            }
            $("[data-bs-toggle=\'tooltip\']").tooltip();
         } else {
            Swal.fire({
               icon: 'error',
               text: 'Tidak ada file',
               showConfirmButton: false,
               allowOutsideClick: false,
               allowEscapeKey: false,
               timer: 1500
            });
         }
      }
   </script>
</body>

</html>