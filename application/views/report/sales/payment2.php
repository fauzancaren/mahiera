<!DOCTYPE html>
<html>

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- Required meta tags -->
   <meta charset="UTF-8">
   <meta name="mobile-web-app-capable" content="yes">
   <meta name="apple-mobile-web-app-title" content="omahbata">
   <meta name="theme-color" content="#42b549">
   <meta name="page-type" content="productdetailpage-desktop" data-rh="true">
   <meta name="title" content="Omahbata Indonesia - Enterprise Resource Planning"" data-rh=" true">
   <meta name="description" content="Transaksi Atas nama <?= ($_data->MsCustomerTypeId == 1 ? $_data->MsCustomerName : $_data->MsCustomerName . ' (' . $_data->MsCustomerCompany . ')') ?>" data-rh="true">

   <meta name="twitter:card" content="product" data-rh="true">
   <meta name="twitter:site" content="@omahbata" data-rh="true">
   <meta name="twitter:creator" content="@omahbata" data-rh="true">
   <meta name="twitter:title" content="Omahbata Indonesia - Enterprise Resource Planning" data-rh="true">
   <meta name="twitter:description" content="Transaksi atas nama <?= ($_data->MsCustomerTypeId == 1 ? $_data->MsCustomerName : $_data->MsCustomerName . ' (' . $_data->MsCustomerCompany . ')') ?>" data-rh="true">
   <meta name="twitter:image" content="https://obi-system.com/asset/image/mgs-erp/logo.png" data-rh="true">
   <title>Payment - <?= ($_data->MsCustomerTypeId == 1 ? $_data->MsCustomerName : $_data->MsCustomerName . ' (' . $_data->MsCustomerCompany . ')') ?></title>
   <style>
      @font-face {
         font-family: 'Poppins-bold';
         src: url('<?= base_url("asset/fontgoogle/poppins/Poppins-SemiBold.ttf") ?>');
      }

      @font-face {
         font-family: 'Poppins';
         src: url('<?= base_url("asset/fontgoogle/poppins/Poppins-Regular.ttf") ?>');
      }

      @font-face {
         font-family: 'Montserrat';
         src: url('<?= base_url("asset/fontgoogle/Montserrat/Montserrat-Bold.ttf") ?>');
      }

      @font-face {
         font-family: 'Montserrat-reg';
         src: url('<?= base_url("asset/fontgoogle/Montserrat/Montserrat-Medium.ttf") ?>');
      }

      @page {
         margin: 0.75em
      }


      header {
         position: relative;
         display: block;
         margin-top: 10px;
      }

      header .logo-lama {
         position: absolute;
         top: -10px;
      }

      header .judul-lama {
         position: absolute;
         font-size: 0.85rem;
         font-weight: bold;
         top: 40px;
         right: 0px;
         border: 1.2px solid black;
         padding: 0.25rem;
      }

      header .cetak-lama {
         position: absolute;
         top: 5px;
         right: 0px;
         font-size: 0.75rem;
      }

      header .logo {
         position: absolute;
         width: 120px;
         left: 5px
      }

      header .store {
         position: absolute;
         font-family: 'Montserrat';
         width: 120px;
         top: 52px;
         width: 120px;
         left: 5px;
         text-align: center;
         font-size: 0.65rem;
         color: #d5582a;
      }

      header .store-info {
         top: 5px;
         letter-spacing: 1px;
         position: relative;
         font-family: 'Montserrat';
         font-size: 0.6rem;
         position: absolute;
         left: 135px;
         right: 200px;
         justify-content: space-around;
         line-height: 0.85;
         color: #222222;
      }

      .address {
         position: absolute;
         top: 0px;
         left: 0px;
         line-height: 1;
      }

      .email {
         position: absolute;
         top: 30px;
         left: 20px;
      }

      .icon-email {
         position: absolute;
         background: #d5582a;
         height: 13px;
         width: 13px;
         top: 30px;
         border-radius: 6px;
      }

      .icon-email img {
         margin: 3px;
         width: 7px;
         height: 7px;
      }

      .telp {
         position: absolute;
         top: 45px;
         left: 20px;
      }

      .icon-telp {
         position: absolute;
         background: #d5582a;
         height: 13px;
         width: 13px;
         top: 45px;
         border-radius: 6px;
      }

      .icon-telp img {
         margin: 3px;
         width: 7px;
         height: 7px;
      }

      .instagram {
         position: absolute;
         top: 30px;
         left: 280px;
      }

      .icon-instagram {
         position: absolute;
         background: #d5582a;
         height: 13px;
         width: 13px;
         top: 30px;
         left: 260px;
         border-radius: 6px;
      }

      .icon-instagram img {
         margin: 3px;
         width: 7px;
         height: 7px;
      }

      .website {
         position: absolute;
         top: 45px;
         left: 280px;
      }

      .icon-website {
         position: absolute;
         background: #d5582a;
         height: 13px;
         width: 13px;
         top: 45px;
         left: 260px;
         border-radius: 6px;
      }

      .icon-website img {
         margin: 3px;
         width: 7px;
         height: 7px;
      }

      .icon-telp {
         position: absolute;
         background: #d5582a;
         height: 13px;
         width: 13px;
         top: 45px;
         border-radius: 6px;
      }

      header .judul {
         position: absolute;
         font-size: 0.85rem;
         font-weight: bold;
         top: 50px;
         right: 85px;
         border: 1.2px solid black;
         padding: 0.25rem;
      }

      header .cetak {
         position: absolute;
         top: 5px;
         right: 85px;
         font-size: 0.75rem;
      }

      header .barcode {
         position: absolute;
         top: 0px;
         right: 0px;
         width: 80px
      }

      header .grid-1 {
         top: 80.5px;
         left: 5px;
         position: absolute;
         height: 6px;
         width: 120px;
         background: #d5582a;
         z-index: 1;
      }

      header .grid-2 {
         top: 82px;
         left: 5px;
         position: absolute;
         height: 3px;
         width: 100%;
         background: #67432b;
      }


      .center {
         margin-left: auto;
         margin-right: auto;
      }

      table th {
         border-top: 1px solid black;
         border-bottom: 1.5px solid black;
         margin: 0px;
         font-size: 12px
      }


      .content {
         display: block;
         padding-top: 100px;
         padding-bottom: 5px;
      }

      .content>.customer {
         display: inline-block;
         width: 60%;
         background: green;
         padding: 0.5rem 0.25rem;
      }

      .content>.dokument {
         align-content: flex-start;
         width: 38%;
         display: inline-block;
         margin-top: 0;
         background: green;
      }

      .row {
         display: block;
      }

      .col {
         display: inline-block;
         font-size: 13px
      }

      .col.header-col {
         width: 4rem;
      }

      .item {
         width: 100%;
         padding: 0 10px
      }

      .footer {
         width: 100%;
         padding: 0 10px
      }

      ol {
         padding-left: 1.8em;
         margin-top: 0;
      }

      ol li {

         text-align: justify;
      }
   </style>
</head>

<body>
   <?= $_header ?>
   <div class="content">
      <table style="width: 100%;margin-top:0px">
         <tr>
            <td align="left" valign="top" style="width:65%;font-size:13px;">
               <div>Kepada Yth:</div>
               <table style="width: 100%;margin-top:0px;border-collapse: collapse;">
                  <tr>
                     <td align="left" valign="top" style="width:10%;font-size:13px;">Nama</td>
                     <td align="left" valign="top" style="width:2%;font-size:13px;">:</td>
                     <td align="left" valign="top" style="width:88%;font-size:13px;font-weight:bold;"><?= ($_data->MsCustomerTypeId == 1 ? $_data->MsCustomerName : $_data->MsCustomerName . ' (' . $_data->MsCustomerCompany . ')') ?></td>
                  </tr>
               </table>
               <table style="width: 100%;margin-top:0px;border-collapse: collapse;">
                  <tr>
                     <td align="left" valign="top" style="width:10%;font-size:13px;">Telp</td>
                     <td align="left" valign="top" style="width:2%;font-size:13px;">:</td>
                     <td align="left" valign="top" style="width:88%;font-size:13px;font-weight:bold;"><?= (($_data->MsCustomerTelp2 == "" || $_data->MsCustomerTelp2 == "-") ? $_data->MsCustomerTelp1 : $_data->MsCustomerTelp1 . " / " . $_data->MsCustomerTelp2)  ?></td>

                  </tr>
               </table>
               <table style="width: 100%;margin-top:0px;border-collapse: collapse;">
                  <tr>
                     <td align="left" valign="top" style="width:10%;font-size:13px;">Email</td>
                     <td align="left" valign="top" style="width:2%;font-size:13px;">:</td>
                     <td align="left" valign="top" style="width:38%;font-size:13px;font-weight:bold;"> <?= $_data->MsCustomerEmail ?></td>
                     <td align="left" valign="top" style="width:10%;font-size:13px;">Instagram</td>
                     <td align="left" valign="top" style="width:2%;font-size:13px;">:</td>
                     <td align="left" valign="top" style="width:38%;font-size:13px;font-weight:bold;"><?= $_data->MsCustomerInstagram ?></td>
                  </tr>
               </table>
               <table style="width: 100%;margin-top:0px;border-collapse: collapse;">
                  <tr>
                     <td align="left" valign="top" style="width:10%;font-size:13px;">Alamat </td>
                     <td align="left" valign="top" style="width:2%;font-size:13px;">:</td>
                     <td align="left" valign="top" style="width:88%;font-size:13px;"><?= $_data->MsCustomerAddress ?></td>
                  </tr>
               </table>
            </td>
            <td align="left" valign="top" style="width:35%;font-size:13px">
               <table style="width: 100%;margin-top:0px;border-collapse: collapse;">
                  <tr>
                     <td align="left" valign="top" style="width:20%;font-size:13px;">Tanggal</td>
                     <td align="left" valign="top" style="width:2%;font-size:13px;">:</td>
                     <td align="left" valign="top" style="width:78%;font-size:13px;"><?= date_format(date_create($_data->SalesDate), "j F Y") ?></td>
                  </tr>
                  <tr>
                     <td align="left" valign="top" style="width:20%;font-size:13px;">No. Ref.</td>
                     <td align="left" valign="top" style="width:2%;font-size:13px;">:</td>
                     <td align="left" valign="top" style="width:78%;font-size:13px;"><?= ($_data->SalesRef == "" ? "-" : $_data->SalesRef) ?></td>
                  </tr>
                  <tr>
                     <td align="left" valign="top" style="width:20%;font-size:13px;">No. Inv.</td>
                     <td align="left" valign="top" style="width:2%;font-size:13px;">:</td>
                     <td align="left" valign="top" style="width:78%;font-size:13px;"><?= $_data->SalesCode ?></td>
                  </tr>
                  <tr>
                     <td align="left" valign="top" style="width:20%;font-size:13px;">Admin</td>
                     <td align="left" valign="top" style="width:2%;font-size:13px;">:</td>
                     <td align="left" valign="top" style="width:78%;font-size:13px;"><?= $_data->MsEmpName ?></td>
                  </tr>
               </table>
            </td>
         </tr>
      </table>

   </div>
   <div class="item">
      <table class="center" style="width: 100%;border-collapse: collapse;border-bottom: 1px solid black;">

         <?php

         $disc = 0;
         $subtotal = 0;
         foreach ($_item as $rowsitem) {
            $disc += $rowsitem->SalesDetailDisc * $rowsitem->SalesDetailQty;
            $subtotal += $rowsitem->SalesDetailQty * $rowsitem->SalesDetailPrice;
         }
         if ($_optional) {
            foreach ($_optional as $rowsitems) {
               $subtotal += $rowsitems->SalesOptionalPrice;
            }
         }


         $no = 0;
         $data = "";
         foreach ($_item as $rowsitem) {
            $no++;
            $data .=      '
               <tr style="font-size:13px;vertical-align: top;" >
                  <td style="text-align:center;width:20px">' . $no . '</td>
                  <td style="width:120px">' . $rowsitem->MsItemCatName . '</td>
                  <td ><span style="font-size:13px">' . $rowsitem->MsItemCode . '-' . $rowsitem->MsItemName . '<span></td>
                  <td style="width:100px"><span style="font-size:13px;">' . $rowsitem->MsItemSize . '</span></td>
                  <td style="width:50px;padding-right:5px;font-size:13px;text-align: right;">' . number_format($rowsitem->SalesDetailQty, 2) . '</td>
                  <td style="width:40px;"><span style="font-size:13px;">' . $rowsitem->MsItemUoM . '</span></td>
                  <td style="width:70px;font-size:13px;text-align: right;">' . number_format($rowsitem->SalesDetailPrice) . '</td>';
            if ($disc > 0) {
               $data .=      '<td style="width:70px;font-size:13px;text-align: right;">' . number_format($rowsitem->SalesDetailDisc) . '</td>';
            }
            $data .=      ' 
               <td style="width:70px;font-size:13px;text-align: right;">' . number_format($rowsitem->SalesDetailTotal) . '</td>
            </tr>';
         }
         if ($_optional) {
            $data .= '<tr> 
                  <td colspan="3">
                     <span style="margin-left:1rem;padding:5px;font-size:13px;font-weight: bold;">Biaya Lain Lain</span>
                  </td>
               </tr>';
            $no = 0;
            foreach ($_optional as $rowsitems) {
               $no++;
               $data .= '<tr style="font-size:13px;vertical-align: top;" >
                     <td style="text-align:center">' . $no . '</td>
                     <td colspan="' . ($disc > 0 ? '7' : '6') . '">' . $rowsitems->SalesOptionalDesc . '</td>
                     <td style="font-size:13px;text-align: right;">' . number_format($rowsitems->SalesOptionalPrice) . '</td>
                  </tr>';
            }
         }
         echo ' <tr>
            <th style="text-align:center;">No.</th>
            <th style="text-align:left;">Kategori</th>
            <th style="text-align:left;">Nama Item</th>
            <th style="text-align:left;">Ukuran</th>
            <th style="text-align:right;">Qty</th>
            <th style="text-align:left;">Satuan</th>
            <th style="text-align:right;">Harga</th>';
         if ($disc > 0) {
            echo '<th style="text-align:right;">Disc/item</th>';
         }
         echo '<th style="text-align:right;">Harga Total</th>
         </tr>' . $data;
         ?>
      </table>
   </div>
   <table style="width: 100%;margin-left:10px;margin-top:0px">
      <tr>
         <td align="left" valign="top" style="width:30%;font-size:13px">
            <table style="width: 100%;margin-left:10px;margin-top:0px">
               <tr>
                  <td align="center" valign="top" style="width:50%;border:1px solid black;text-decoration: underline;height:100px">Penerima/Pembeli</td>
                  <td align="center" valign="top" style="width:50%;border:1px solid black;text-decoration: underline;height:100px">Admin</td>
               </tr>
            </table>
         </td>
         <td align="left" valign="top" style="width:40%;font-size:11px">Note :<br>
            1. pembayaran melalui transfer pada No. Rekening<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>BCA 498 0375 990<br>
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OMAHBATA INDONESIA CV.<br></b>
            2. DP atau Pelunasan yang sudah masuk tidak bisa <br>
            &nbsp;&nbsp;&nbsp;&nbsp;<b>dikembalikan(Refund)</b><br>
            3. Barang yang sudah dibeli tidak dapat <br>
            &nbsp;&nbsp;&nbsp;&nbsp;<b>dikembalikam/ditukar</b><br>
         </td>
         <td align="left" valign="top" style="width:30%;font-size:13px">
            <table style="width: 100%;margin-right:13px;margin-top:0px;border-collapse: collapse;">
               <tr>
                  <td align="right" valign="top" style="width:47%;font-size:13px;">Sub Total</td>
                  <td align="right" valign="top" style="width:50%;font-size:13px;font-weight:bold"><?= number_format($_data->SalesSubTotal) ?></td>
               </tr>
               <?php
               $disc += $_data->SalesDiscTotal;
               if ($disc > 0) {
                  echo '
                           <tr>
                              <td align="right" valign="top" style="width:47%;font-size:13px;">Disc</td>
                              <td align="right" valign="top" style="width:50%;font-size:13px;font-weight:bold">' . number_format($disc) . '</td>
                           </tr>';
               }
               if ($_data->SalesDeliveryTotal > 0) {
                  echo '
                           <tr>
                              <td align="right" valign="top" style="width:47%;font-size:13px;">Delivery</td>
                              <td align="right" valign="top" style="width:50%;font-size:13px;font-weight:bold">' . number_format($_data->SalesDeliveryTotal) . '</td>
                           </tr>';
               }
               ?>

               <tr>
                  <td align="right" valign="top" style="width:47%;font-size:13px;">Grand Total</td>
                  <td align="right" valign="top" style="width:50%;font-size:13px;font-weight:bold"><?= number_format($_data->SalesGrandTotal) ?></td>
               </tr>
            </table>
            <hr style="margin:1px" />
            <table style="width: 100%;margin-right:13px;margin-top:0px;border-collapse: collapse;">';
               <?php

               $payment = $_data->SalesGrandTotal;
               foreach ($_payment as $row) {
                  echo '
               <tr>
                  <td align="left" valign="top" style="width:70%;font-size:13px;">' . $row->MsMethodName . ' (' . $row->PaymentDate . ')</td>
                  <td align="right" valign="top" style="width:30%;font-size:13px;font-weight:bold">' . number_format($row->PaymentTotal) . '</td>
               </tr>';
                  $payment = $payment - $row->PaymentTotal;
                  break;
               }
               ?>
            </table>
            <hr style="margin:1px">
            </hr>
            <table style="width: 100%;margin-right:13px;margin-top:0px;border-collapse: collapse; ">
               <tr>
                  <td align="right" valign="top" style="width:70%;font-size:13px;font-weight:bold">Sisa Pembayaran</td>
                  <td align="right" valign="top" style="width:30%;font-size:13px;font-weight:bold"><?= number_format($payment) ?></td>
               </tr>
            </table>
         </td>
      </tr>
   </table>
</body>

</html>