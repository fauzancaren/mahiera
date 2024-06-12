<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="asset/image/mgs-erp/logo.ico">
    <title>DATA MASTER - DATA CUSTOMER</title>
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
                    <img src="<?= base_url("asset/image/mgs-erp/logo.png") ?>" alt="" height="100" width="100">
                </td>
                <td align="center">
                    <h1>OBI - Enterprice Resource Planning</h1>
                    <h2>DATA CUSTOMER</h2>
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
            <th class="css_th">Perusahaan</th>
            <th class="css_th">Deskripsi</th>
            <th class="css_th">Kode</th>
            <th class="css_th">Nama</th>
            <th class="css_th">Telp 1</th>
            <th class="css_th">Telp 2</th>
            <th class="css_th">Fax</th>
            <th class="css_th">Email</th>
            <th class="css_th">Alamat</th>
            <th class="css_th">Status</th>
        </tr>

        <?php

        $no = 1;
        foreach ($datatable as $row) {
            echo '<tr>                                  ';
            echo '  <td class="css_td">' . $no . '</td>  ';
            echo '  <td class="css_td">' . $row->MsCustomerTypeName . '</td>  ';
            echo '  <td class="css_td">' . $row->MsCustomerCompany . '</td>  ';
            echo '  <td class="css_td">' . $row->MsCustomerRemarks . '</td>  ';
            echo '  <td class="css_td">' . $row->MsCustomerCode . '</td>  ';
            echo '  <td class="css_td">' . $row->MsCustomerName . '</td>  ';
            echo '  <td class="css_td">' . $row->MsCustomerTelp1 . '</td>  ';
            echo '  <td class="css_td">' . $row->MsCustomerTelp2 . '</td>  ';
            echo '  <td class="css_td">' . $row->MsCustomerFax . '</td>  ';
            echo '  <td class="css_td">' . $row->MsCustomerEmail . '</td>  ';
            echo '  <td class="css_td">' . $row->MsCustomerAddress . '</td>  ';
            echo '  <td class="css_td">' . ($row->MsCustomerIsActive == 1 ? "Aktif" : "Tidak Aktif") . '</td>  ';
            echo '</tr>                                 ';
            $no++;
            if ($no > 1000) break;
        }

        ?>
    </table>
</body>

</html>