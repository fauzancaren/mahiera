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

      @page {
         margin: 0.75em
      }


      header {
         position: relative;
      }

      header img {
         position: absolute;
         margin-top: 2px;
      }

      header .judul {
         position: absolute;
         font-size: 0.85rem;
         font-weight: bold;
         top: 75px;
         right: 0px;
         border: 1.5px solid black;
         padding: 0.1em 1em;
      }

      header .cetak {
         position: absolute;
         top: 5px;
         right: 0px;
         font-size: 0.85rem;
      }

      .content {
         padding-top: 100px;
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
   </style>
</head>

<body>
   <?= $_header ?>
   <div class="content">
      <table style="width: 100%;margin-left:10px;margin-top:0px;border-collapse: collapse;">
         <tr>
            <td align="left" valign="top" colspan="3" style="width:60%;font-size:13px">Kepada Yth:</td>
            <td align="left" valign="top" style="width:10%;font-size:13px">Tanggal</td>
            <td align="left" valign="top" style="width:2%;font-size:13px">:</td>
            <td align="left" valign="top" style="width:28%;font-size:13px"><?= date_format(date_create($_data->SalesDate), "j F Y") ?></td>
         </tr>
      </table>
      <table style="width: 100%;margin-left:10px;margin-top:0px;border-collapse: collapse;">
         <tr>
            <td align="left" valign="top" style="width:10%;font-size:13px">Nama</td>
            <td align="left" valign="top" style="width:2%;font-size:13px">:</td>
            <td align="left" valign="top" style="width:48%;font-size:13px;font-weight:bold"><?= ($_data->MsCustomerTypeId == 1 ? $_data->MsCustomerName : $_data->MsCustomerName . ' (' . $_data->MsCustomerCompany . ')') ?></td>
            <td align="left" valign="top" style="width:10%;font-size:13px">No. Invoice</td>
            <td align="left" valign="top" style="width:2%;font-size:13px">:</td>
            <td align="left" valign="top" style="width:28%;font-size:13px"><?= $_data->SalesCode ?></td>
         </tr>
      </table>
      <table style="width: 100%;margin-left:10px;margin-top:0px;border-collapse: collapse;">
         <tr>
            <td align="left" valign="top" style="width:10%;font-size:13px">No. Telp</td>
            <td align="left" valign="top" style="width:2%;font-size:13px">:</td>
            <td align="left" valign="top" style="width:48%;font-size:13px;font-weight:bold"><?= (($_data->MsCustomerTelp2 == "" || $_data->MsCustomerTelp2 == "-") ? $_data->MsCustomerTelp1 : $_data->MsCustomerTelp1 . " / " . $_data->MsCustomerTelp2) ?></td>
            <td align="left" valign="top" style="width:10%;font-size:13px">Admin</td>
            <td align="left" valign="top" style="width:2%;font-size:13px">:</td>
            <td align="left" valign="top" style="width:28%;font-size:13px"><?= $_data->MsEmpName ?></td>
         </tr>
      </table>
      <table style="width: 100%;margin-left:10px;margin-top:0px;margin-bottom:5px;border-collapse: collapse;">
         <tr>
            <td align="left" valign="top" style="width:10%;font-size:13px">Alamat</td>
            <td align="left" valign="top" style="width:2%;font-size:13px">:</td>
            <td align="left" valign="top" style="width:48%;font-size:13px"><?= $_data->MsCustomerAddress ?></td>
            <td align="left" valign="top" style="width:10%;font-size:13px">Ref.</td>
            <td align="left" valign="top" style="width:2%;font-size:13px">:</td>
            <td align="left" valign="top" style="width:28%;font-size:13px"><?= ($_data->SalesRef == "" ? "-" : $_data->SalesRef) ?></td>
         </tr>
      </table>
      <table class="center" style="width: 95%;border-collapse: collapse;border-bottom: 1px solid black;">
         <tr>
            <th style="text-align:center;">No.</th>
            <th style="text-align:left;">Kategori</th>
            <th style="text-align:left;">Nama Item</th>
            <th style="text-align:left;">Ukuran</th>
            <th style="text-align: right;">Qty</th>
            <th style="text-align:left;">Satuan</th>
            <th style="text-align: right;">Harga</th>
            <th style="text-align: right;">Disc</th>
            <th style="text-align: right;">Harga Total</th>
         </tr>
         <?php
         $no = 0;
         foreach ($_item as $rowsitem) {
            $no++;
            echo      '
            <tr style="font-size:13px;vertical-align: top;" >
               <td style=text-align:center>' . $no . '</td>
               <td>' . $rowsitem->MsItemCatName . '</td>
               <td><span style="font-size:13px;">' . $rowsitem->MsItemCode . '-' . $rowsitem->MsItemName . '<span></td>
               <td><span style="font-size:13px;">' . $rowsitem->MsItemSize . '</span></td>
               <td style="font-size:13px;text-align: right;">' . number_format($rowsitem->SalesDetailQty, 2) . '</td>
               <td>' . $rowsitem->MsItemUoM . '</td>
               <td style="font-size:13px;text-align: right;">' . number_format($rowsitem->SalesDetailPrice) . '</td>
               <td style="font-size:13px;text-align: right;">' . number_format($rowsitem->SalesDetailDisc) . '</td>
               <td style="font-size:13px;text-align: right;">' . number_format($rowsitem->SalesDetailTotal) . '</td>
            </tr>';
         }
         if ($_optional) {
            echo '<tr> 
                  <td colspan="2">
                     <span style="margin-left:40px;padding:5px;font-size:13px;font-weight: bold;">Biaya Lain Lain</span>
                  </td>
               </tr>';
            $no = 0;
            foreach ($_optional as $rowsitems) {
               $no++;
               echo '<tr style="font-size:13px;vertical-align: top;" >
                     <td style="text-align:center">' . $no . '</td>
                     <td colspan="7">' . $rowsitems->SalesOptionalDesc . '</td>
                     <td style="font-size:13px;text-align: right;">' . number_format($rowsitems->SalesOptionalPrice) . '</td>
                  </tr>';
            }
         }
         ?>
      </table>
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
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>BCA 498 0375 990 a/n <br>
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
                  <tr>
                     <td align="right" valign="top" style="width:47%;font-size:13px;">Disc</td>
                     <td align="right" valign="top" style="width:50%;font-size:13px;font-weight:bold"><?= number_format($_data->SalesDiscTotal) ?></td>
                  </tr>
                  <tr>
                     <td align="right" valign="top" style="width:47%;font-size:13px;">Delivery</td>
                     <td align="right" valign="top" style="width:50%;font-size:13px;font-weight:bold"><?= number_format($_data->SalesDeliveryTotal) ?></td>
                  </tr>
                  <tr>
                     <td align="right" valign="top" style="width:47%;font-size:13px;">Grand Total</td>
                     <td align="right" valign="top" style="width:50%;font-size:13px;font-weight:bold"><?= number_format($_data->SalesGrandTotal) ?></td>
                  </tr>
                  <?php  
                  $totalbayar = 0;
                  foreach ($_payment as $row) {
                     if($row->PerformaStatus==1){
                        $totalbayar += $row->PerformaTotal;
                     }
                  }
                  if($totalbayar>0){
                     echo '
                        <tr>
                           <td align="right" valign="top" style="width:47%;font-size:13px;">Sudah dibayarkan</td>
                           <td align="right" valign="top" style="width:50%;font-size:13px;font-weight:bold">' . number_format($totalbayar) . '</td>
                        </tr>';
                  }
                  ?>
               </table>
               <hr style="margin:1px" />
               <table style="width: 100%;margin-right:13px;margin-top:0px;border-collapse: collapse;">';
                  <?php 
                  $payment = $_data->SalesGrandTotal;  
                  foreach ($_payment as $row) {
                     if($row->PerformaStatus==0){ 
                        echo '
                        <tr>
                           <td align="right" valign="top" style="width:70%;font-size:13px;">' . $row->MsMethodName . ' (' . $row->PerformaDate . ')</td>
                           <td align="right" valign="top" style="width:30%;font-size:13px;font-weight:bold">' . number_format($row->PerformaTotal) . '</td>
                        </tr>';
                     }
                    
                     $payment = $payment - $row->PerformaTotal;
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
   </div>
</body>

</html>