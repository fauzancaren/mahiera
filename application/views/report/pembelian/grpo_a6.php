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
   <title>GRPO - <?= ($_data->GRPOCode) ?> </title>
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
         margin: 0em;
      }


      body {
         padding: 0.2em;
         border: 5px solid #ff6347
      }

      header {
         position: relative;
      }

      header .logo {
         position: absolute;
         width: 120px;
         left: 10px;
         top: 10px;
      }

      header .title {
         position: absolute;
         font-size: 0.6rem;
         font-weight: bold;
         top: 25px;
         left: 140px;
         padding: 0.1em 1em;
      }

      header .judul {
         position: absolute;
         font-size: 0.85rem;
         font-weight: bold;
         top: 0px;
         right: 0px;
         border: 1.5px solid black;
         padding: 0.1em 1em;
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

      .footer {
         position: fixed;
         bottom: -40px;
         left: 10px;
         right: 10px;
         height: 120px;

         /** Extra personal styles **/
      }
   </style>
</head>

<body>
   <?= $_header ?>
   <div class="content">
      <table style="width: 100%;margin-top:0px;border-collapse: collapse;">
         <tr>
            <td align="left" valign="top" style="width:25%;font-size:14px;padding-left:20px">Tanggal </td>
            <td align="left" valign="top" style="width:2%;font-size:14px;">:</td>
            <td align="left" valign="top" style="width:73%;font-size:14px;"><?= date("d F Y", strtotime($_data->PODate)) ?></td>
         </tr>
         <tr>
            <td align="left" valign="top" style="width:25%;font-size:14px;padding-left:20px">No. Doc </td>
            <td align="left" valign="top" style="width:2%;font-size:14px;">:</td>
            <td align="left" valign="top" style="width:73%;font-size:14px;"><?= $_data->POCode ?></td>
         </tr>
         <tr>
            <td align="left" valign="top" style="width:25%;font-size:14px;padding-left:20px">Admin </td>
            <td align="left" valign="top" style="width:2%;font-size:14px;">:</td>
            <td align="left" valign="top" style="width:73%;font-size:14px;"><?= $_data->MsEmpName ?></td>
         </tr>
         <tr>
            <td align="left" valign="top" style="width:25%;font-size:14px;padding-left:20px">Customer </td>
            <td align="left" valign="top" style="width:2%;font-size:14px;">:</td>
            <td align="left" valign="top" style="width:73%;font-size:14px;"><?= ($_data->MsCustomerTypeId == 1 ? $_data->MsCustomerName : $_data->MsCustomerName . ' (' . $_data->MsCustomerCompany . ')') ?></td>
         </tr>
         <tr>
            <td align="left" valign="top" style="width:25%;font-size:14px;padding-left:20px">Supplier </td>
            <td align="left" valign="top" style="width:2%;font-size:14px;">:</td>
            <td align="left" valign="top" style="width:73%;font-size:14px;"><?= $_data->PORemarks ?></td>
         </tr>
      </table>
      <table class="center border" style="width: 100%;margin:5px;border-collapse: collapse;border: 1px solid black;">
         <tr>
            <th style="text-align:center;">No.</th>
            <th style="text-align:left;">Nama Item</th>
            <th style="text-align: right;">Qty</th>
            <th style="text-align:left;">Satuan</th>
         </tr>
         <?php
         $no = 0;
         foreach ($_item as $rowsitem) {
            $no++;
            echo      '
            <tr style="font-size:13px;vertical-align: center;" >
               <td style=text-align:center>' . $no . '</td>
               <td>
                  <span style="font-size:13px;">' . $rowsitem->MsItemCode . '-' . $rowsitem->MsItemName . '<span><br>
                  <span style="font-size:12px;">' . $rowsitem->MsItemSize . '<span>
               </td>
               <td style="font-size:13px;text-align: right;">' . number_format($rowsitem->PODetailQty, 2) . '</td>
               <td>' . $rowsitem->MsItemUoM . '</td>
            </tr>';
         }
         ?>
      </table>
      <table style="width: 100%;margin:5px;margin-top:0px">
         <tr>
            <td align="left" valign="top">
               <span style="font-size:14px;">Keterangan :<span>
            </td>
         </tr>
         <tr>
            <td align="left" valign="top">
               <span style="font-size:14px;"><?= $_data->PORemarks ?><span>
            </td>
         </tr>
      </table>
   </div>

   <div class="footer center">
      <img src="<?= base_url("asset/image/kop/pofooter1.jpg") ?>" style="width: 100%;">
   </div>
</body>

</html>