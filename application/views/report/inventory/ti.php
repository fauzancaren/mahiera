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

   <meta name="twitter:card" content="product" data-rh="true">
   <meta name="twitter:site" content="@omahbata" data-rh="true">
   <meta name="twitter:creator" content="@omahbata" data-rh="true">
   <meta name="twitter:title" content="Omahbata Indonesia - Enterprise Resource Planning" data-rh="true">
   <meta name="twitter:image" content="https://obi-system.com/asset/image/mgs-erp/logo.png" data-rh="true">
   <title>Transfer IN</title>
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
         padding-top: 105px;
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
      <table style="width: 100%;margin-top:0px">
         <tr>
            <td align="left" valign="top" style="width:60%;font-size:13px;">
               <div style="width:90%;border-bottom:1px solid black;">dikirim dari</div>
               <table style="width: 100%;margin-top:0px;border-collapse: collapse;">
                  <tr>
                     <td align="left" valign="top" style="width:20%;font-size:13px;">Ref </td>
                     <td align="left" valign="top" style="width:2%;font-size:13px;">:</td>
                     <td align="left" valign="top" style="width:78%;font-size:13px;"><?= $_data->InvTIRef ?></td>
                  </tr>
                  <tr>
                     <td align="left" valign="top" style="width:20%;font-size:13px;">Toko </td>
                     <td align="left" valign="top" style="width:2%;font-size:13px;">:</td>
                     <td align="left" valign="top" style="width:78%;font-size:13px;"><?= $_data->src ?></td>
                  </tr>
                  <tr>
                     <td align="left" valign="top" style="width:20%;font-size:13px;">Keterangan </td>
                     <td align="left" valign="top" style="width:2%;font-size:13px;">:</td>
                     <td align="left" valign="top" style="width:78%;font-size:13px;"><?= $_data->InvTIRemarks ?></td>
                  </tr>
               </table>
            </td>
            <td align="left" valign="top" style="width:40%;font-size:13px">
               <div style="width:90%;border-bottom:1px solid black">Dokument</div>
               <table style="width: 100%;margin-top:0px;border-collapse: collapse;">
                  <tr>
                     <td align="left" valign="top" style="width:20%;font-size:13px;">No. Doc. </td>
                     <td align="left" valign="top" style="width:2%;font-size:13px;">:</td>
                     <td align="left" valign="top" style="width:78%;font-size:13px;"><?= $_data->InvTICode ?></td>
                  </tr>
                  <tr>
                     <td align="left" valign="top" style="width:20%;font-size:13px;">Toko</td>
                     <td align="left" valign="top" style="width:2%;font-size:13px;">:</td>
                     <td align="left" valign="top" style="width:78%;font-size:13px;"><?= $_data->dst ?></td>
                  </tr>
                  <tr>
                     <td align="left" valign="top" style="width:20%;font-size:13px;">Tgl. </td>
                     <td align="left" valign="top" style="width:2%;font-size:13px;">:</td>
                     <td align="left" valign="top" style="width:78%;font-size:13px;"><?= date("d F Y", strtotime($_data->InvTIDate)) ?></td>
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
      <table class="center border" style="width: 100%;margin:5px;border-collapse: collapse;border: 1px solid black;">
         <tr>
            <th style="text-align:center;">No.</th>
            <th style="text-align:left;">Kategori</th>
            <th style="text-align:left;">Nama Item</th>
            <th style="text-align:left;">Vendor</th>
            <th style="text-align:left;">Ukuran</th>
            <th style="text-align: right;">Qty</th>
            <th style="text-align:left;">Satuan</th>
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
               <td><span style="font-size:13px;">' . $rowsitem->MsVendorCode . '</span></td>
               <td><span style="font-size:13px;">' . $rowsitem->MsItemSize . '</span></td>
               <td style="font-size:13px;text-align: right;">' . number_format($rowsitem->InvTIDetailQty, 2) . '</td>
               <td>' . $rowsitem->MsItemUoM . '</td>
            </tr>';
         }
         ?>
      </table>
      <table style="width: 100%;margin:5px;margin-top:0px">
         <tr>
            <td align="left" valign="top" style="width:70%;font-size:12px">
            </td>
            <td align="left" valign="top" style="width:30%;font-size:13px">
               <table style="width: 100%;margin-left:10px;margin-top:0px">
                  <tr>
                     <td align="center" valign="top" style="width:50%;border:0.5px solid black;text-decoration: underline;height:80px">Admin</td>
                     <td align="center" valign="top" style="width:50%;border:0.5px solid black;text-decoration: underline;height:80px">Penerima</td>
                  </tr>
               </table>
            </td>
         </tr>
      </table>
   </div>
</body>

</html>