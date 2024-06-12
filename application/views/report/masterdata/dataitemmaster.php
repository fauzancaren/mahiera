<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="asset/image/mgs-erp/logo.ico">
    <title>DATA MASTER - DATA ITEM MASTER</title>
    <style>
        .css_table,
        .css_th,
        .css_td {
            border: 0.5px solid black;
            border-collapse: collapse;
        }

        .css_th {
            background-color: #25221d;
            color: white;
        }

        .css_table,
        .css_td {
            padding: 5px;
            font-size: 10px;
            text-align: left;
            word-wrap: break-word;
        }
    </style>
</head>

<body>
    <header>

        <table style="width:100%">
            <tr>
                <td align="center" style="width:20%">
                    <img src="<?= site_url('asset/image/mgs-erp/logo.png'); ?>" alt="" height="100" width="100">
                </td>
                <td align="center">
                    <h1>OBI - Enterprice Resource Planning</h1>
                    <h2>DATA ITEM MASTER</h2>
                </td>
            </tr>
        </table>
    </header>
    <br>
    <br>
    <br>
    <table class="css_table" style="width:100%">
        <tr>
            <th class="css_th">No</th>
            <th class="css_th">Kategori</th>
            <th class="css_th">Kode</th>
            <th class="css_th">Nama</th>
            <th class="css_th">Ukuran</th>
            <th class="css_th">Satuan</th>
            <th class="css_th">Supllier</th>
            <th class="css_th">Harga Jual</th>
            <th class="css_th">Status Jual</th>
            <th class="css_th">Status Item</th>
        </tr>

        <?php
        $no = 1;
        foreach ($datatable as $row) {
            echo '<tr>                                  ';
            echo '  <td class="css_td">' . $no . '</td>  ';
            echo '  <td class="css_td">' . $row->MsItemCatCode . ' - ' . $row->MsItemCatName . '</td>  ';
            echo '  <td class="css_td">' . $row->MsItemCode . '</td>  ';
            echo '  <td class="css_td">' . $row->MsItemName . '</td>  ';
            echo '  <td class="css_td">' . $row->MsItemSize . '</td>  ';
            echo '  <td class="css_td">' . $row->MsItemUoM . '</td>  ';
            echo '  <td class="css_td">' . $row->MsVendorCode . '</td>  ';
            echo '  <td class="css_td">' . number_format($row->MsItemPrice) . '</td>  ';
            echo '  <td class="css_td">' . ($row->MsItemSales == 1 ? "Aktif" : "Tidak Aktif") . '</td>  ';
            echo '  <td class="css_td">' . ($row->MsItemIsActive == 1 ? "Aktif" : "Tidak Aktif") . '</td>  ';
            echo '</tr>                                 ';
            $no++;
        }
        ?>
    </table>
</body>

</html>