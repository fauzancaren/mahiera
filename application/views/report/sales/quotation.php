<!DOCTYPE html>
<html>

<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>Quotation - <?= ($_data->MsCustomerTypeId == 1 ? $_data->MsCustomerName : $_data->MsCustomerName . ' (' . $_data->MsCustomerCompany . ')') ?></title>
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
         margin: 0.5em
      }

      .line-title {
         border: 0;
         border-style: inset;
         border-top: 0.25px solid #000;
      }

      .line-footer {
         margin-left: 50px;
         margin-right: 50px;
         border: 0;
         border-style: inset;
         border-top: 0.25px solid #000;
      }

      header {
         position: relative;
      }

      header .logo {
         position: absolute;
         top: 15px;
         left: 0px;
      }

      header .title {
         position: absolute;
         top: 15px;
         left: 150px;
         height: 50px;
         width: 350px;
      }

      header .title-head {
         font-family: 'Poppins-bold', sans-serif;
         font-size: 1.5rem;
         color: #ec3e01;
         line-height: 0.7em;
      }

      header .title-desc {
         font-family: 'Poppins', sans-serif;
         font-size: 0.8rem;
         color: #a62b00;
         line-height: 0.8em;
      }

      footer {
         position: fixed;
         bottom: 40px;
         left: 0px;
         right: 0px;
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
   <footer>
      <img src="<?= base_url("asset/image/mgs-erp/footer.png") ?>" style="width: 100%;">
   </footer>
   <main style="top:200px;padding:0.5rem">
      <table style="width: 100%;margin-top:10px;">
         <tr>
            <td>
               <span style="font-size:18px;font-weight: bold;color:#ff6c0a">
                  Penawaran (Quotation)
               </span>
            </td>
         </tr>
      </table>
      <table style="width: 100%;margin-top:10px;margin-left:20px">
         <tr>
            <td width="50%">
               <span style="font-size:14px;padding:10px;padding-left:0">
                  Kepada Yth:
               </span><br>
               <span style="font-size:14px;font-weight: bold;padding:10px;padding-left:0">
                  <?= ($_data->MsCustomerTypeId == 1 ? $_data->MsCustomerName : $_data->MsCustomerName . ' (' . $_data->MsCustomerCompany . ')') ?>
               </span><br>
               <span style="font-size:14px;padding:10px;padding-left:0">
                  <?= (($_data->MsCustomerTelp2 == "" || $_data->MsCustomerTelp2 == "-") ? $_data->MsCustomerTelp1 : $_data->MsCustomerTelp1 . " / " . $_data->MsCustomerTelp2) ?>
               </span>
            </td>
            <td width="17%">
               <span style="font-size:14px;">
                  Tanggal
               </span><br>
               <span style="font-size:14px;">
                  No. Document
               </span><br>
            </td>
            <td width="3%">
               <span style="font-size:14px;">
                  :
               </span><br>
               <span style="font-size:14px;">
                  :
               </span><br>
            </td>
            <td width="30%">
               <span style="font-size:14px;">
                  <?= date_format(date_create($_data->QuoDate), "d F Y") ?>
               </span><br>
               <span style="font-size:14px;">
                  <?= $_data->QuoCode ?>
               </span><br>
            </td>
         </tr>
      </table>
      <table style="width: 100%;margin-top:10px;margin-left:20px">
         <tr>
            <td>
               <span style="font-size:14px;">Dengan Hormat,<br>Bersama ini kami sampaikan penawaran barang dengan keterangan sebagai berikut :</span>
            </td>
         </tr>
      </table>
      <table class="center" style="border-collapse: collapse;border-bottom: 1px solid black;width:95%">
         <?php

         $disc = 0;
         foreach ($_item as $rowsitem) {
            if ($rowsitem->QuoDetailDiscTypeAll == 1) $disc += $rowsitem->QuoDetailDisc * $rowsitem->QuoDetailQty;
            if ($rowsitem->QuoDetailDiscTypeAll == 2) $disc += $rowsitem->QuoDetailDiscTotal; 
         }
         $header = ' 
         <tr>
            <th style="text-align:center;">No.</th>
            <th style="text-align:left;">Nama Item</th>
            <th style="text-align:left;">Harga</th>
            <th style="text-align: right;">Qty</th> 
            <th style="text-align: right;">Total</th>
         </tr>';
         echo $header;
         /* ------------------------------------------------------   DATA ITEM   ------------------------------------------------------*/
         $no = 1;
         $item = "";
         foreach ($_item as $row) {
            $data_split_var =  explode("|",$row->QuoDetailVarian);
            $varian = "";
            foreach($data_split_var as $row1){
               $data_split_var_row =  explode(":",$row1);
               if($data_split_var_row[0] != "Vendor") $varian .= $data_split_var_row[0]. " : ".$data_split_var_row[1]." | ";
            }
            $item .= "<tr style='font-size:12px;vertical-align: top;'>";
            $item .= "   <td style='text-align:center'>{$no}</td>";
            $item .= "   <td>" . $row->MsProdukCode . " - " . $row->MsProdukName . "<br>" . rtrim($varian," | ") . "</td>";
            if ($rowsitem->QuoDetailDiscTypeAll == 1){ 
               $item .= "   <td><strike>Rp.".number_format($rowsitem->QuoDetailPrice)."</strike><br>Rp.".number_format($rowsitem->QuoDetailPrice - $rowsitem->QuoDetailDisc)."</td>"; 
            }else{
               $item .= "   <td>Rp.".number_format($rowsitem->QuoDetailPrice)."</td>"; 
            }
            $item .= "   <td style='text-align: right;'>" . number_format($row->QuoDetailQty, 2) . " " . $row->SatuanName . "</td>";  
            if ($rowsitem->QuoDetailDiscTypeAll == 2){  
               $item .= "   <td style='text-align: right;'><strike>Rp. " . number_format($row->QuoDetailPrice * $row->QuoDetailQty) . "</strike><br>Rp. " . number_format($row->QuoDetailTotal) . "</td>"; 
            }else{
               $item .= "   <td style='text-align: right;'>Rp. " . number_format($row->QuoDetailTotal) . "</td>";
            }
            $item .= "</tr>";
            $no++;
         }
         if (strlen($item) == 0) {
            $item = "<tr style='font-size:12px;vertical-align: top;'><td colspan='6'>Tidak Ada Data</td></tr>";
         }
         echo $item;

         /* ------------------------------------------------------   DATA OPTIONAL   ------------------------------------------------------*/
         $no = 1;
         $optional = "";
         foreach ($_optional as $row) {
            $optional .= "<tr style='font-size:12px;vertical-align: top;'>";
            $optional .= "   <td style='text-align:center'>{$no}</td>";
            $optional .= "   <td colspan='3'>" . $row->QuoOptionalDesc . "</td>";
            $optional .= "   <td style='text-align: right;'>Rp. " . number_format($row->QuoOptionalPrice) . "</td>";
            $optional .= "</tr>";
            $no++;
         }
         if (strlen($optional) > 0) {
            echo '
               <tr> 
                  <td colspan="2">
                     <span style="margin-left:20px;padding:5px;font-size:12px;font-weight: bold;">Biaya Lain Lain</span>
                  </td>
               </tr>';
            echo $optional;
         }
         ?>
      </table>
      <table class="center" style="border-collapse: collapse;width: 95%;">
         <tr>
            <td width="70%" rowspan="4">
               <span style="font-size:12px;">
                  Note : <i>1. Penawaran ini <b>bukan</b> suatu bukti transaksi pembelian melainkan penawaran</i>
               </span><br>
               <span style="font-size:12px;padding:10px;margin-left:23px">
                  <i>2. Mohon periksa kembali apakah sesuai kebutuhan dan jumlah yang tertera sudah benar.</i>
               </span><br>
            </td>

            <td width="15%">
               <span style="font-size:12px;">
                  Sub Total
               </span>
            </td>
            <td style="font-size:12px;font-weight: bold;" width="15%" align="right">
               <?= ($_data->QuoSubTotal == 0 ? "-" :  "Rp. " . number_format($_data->QuoSubTotal)) ?>
            </td>
         </tr>
         <tr>
            <td width="15%">
               <span style="font-size:12px;">
                  Delivery
               </span>
            </td>
            <td style="font-size:12px;font-weight: bold;" width="15%" align="right">
               <?= ($_data->QuoDeliveryTotal == 0 ? "-" :  "Rp. " . number_format($_data->QuoDeliveryTotal)) ?>
            </td>
         </tr>
         <tr>
            <td width="15%">
               <span style="font-size:12px;">
                  Disc
               </span>
            </td>
            <td style="font-size:12px;font-weight: bold;" width="15%" align="right">
               <?= ($_data->QuoDiscTotal == 0 ? "-" :  "Rp. " . number_format($_data->QuoDiscTotal)) ?>
            </td>
         </tr>
         <tr>
            <td width="15%">
               <span style="font-size:12px;">
                  Grand Total
               </span>
            </td>
            <td style="font-size:12px;font-weight: bold;" width="15%" align="right">
               <?= ($_data->QuoGrandTotal == 0 ? "-" :  "Rp. " . number_format($_data->QuoGrandTotal)) ?>
            </td>
         </tr>
      </table>
      <table class="center" style="width: 60%;border-collapse: collapse;border: 1px solid black;margin-top:1rem">
         <tr>
            <th width="50%" align="center" style="border: 1px solid black;">
               <span style="font-size:12px;">
                  Alamat Pengiriman
               </span>
            </th>
            <th width="50%" align="center" style="border: 1px solid black;">
               <span style="font-size:12px;">
                  Nama Penerima
               </span>
            </th>
         </tr>
         <?php
         if ($_data->QuoDelStatus == 0) {
            echo '<tr>
                        <td width="50%" align="center" style="height:100px"><span style="font-size:12px;">-</span></td>			
                        <td width="50%" align="center" style="border: 1px solid black;"><span style="font-size:12px;">-</span></td>
                     </tr>';
         } else {
            echo '<tr>
                        <td width="50%" align="center" style="height:100px"><span style="font-size:12px;">' . $_delivery->MsCustomerDeliveryAddress . '</span></td>			
                        <td width="50%" align="center" style="border: 1px solid black;"><span style="font-size:12px;">' . $_delivery->MsCustomerDeliveryReceive . '</span></td>
                     </tr>';
         }
         ?>

      </table>
      <div style="margin-left:50px;font-size:14px;margin-top:25px">
         <span>Disiapkan Oleh : <b><?= $_data->QuoAsign ?></b></span><br>
         <span>Direct Contact : <b><?= $_direct ?></b></span><br>
         <span><b>CV. OMAH BATA INDONESIA</b></span>
      </div>
      <hr class="line-footer">
      <div style="margin-left:50px;font-size:14px;margin-top:25px">
         <span>Term and Condition :</span><br><br>
         <span>1. Masa Berlaku Form Penawaran 14 Hari terhitung dari tanggal dokumen</span><br>
         <span>2. Pembayaran DP 50% ketika sudah ada kesepakatan material</span><br>
         <span>3. Detail pembayaran dengan transfer dan pelunasan sebelum pengiriman</span><br>
         <span>4. Harga material diluar biaya packing</span><br>
         <!--<span>4. Harga material diluar biaya packing dan ongkos pengiriman(transport /ekspedisi) luar jakarta</span><br>-->
      </div>

   </main>
</body>

</html>