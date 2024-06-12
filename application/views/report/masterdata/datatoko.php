<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="asset/image/mgs-erp/logo.ico">
    <title>DATA MASTER - DATA TOKO</title>
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
                    <h2>DATA TOKO</h2>
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
            <th class="css_th">Kode</th>
            <th class="css_th">Nama</th>
            <th class="css_th">Tipe</th>
            <th class="css_th">Alamat</th>
            <th class="css_th">Telp 1</th>
            <th class="css_th">Telp 2</th>
            <th class="css_th">Fax</th>
            <th class="css_th">Status</th>
        </tr>

        <?php
        $no = 1;
        foreach ($datatable as $key) {
            echo '<tr>                                  ';
            echo '  <td class="css_td">' . $no . '</td>  ';
            echo '  <td class="css_td">' . $key->MsWorkplaceCode . '</td>  ';
            echo '  <td class="css_td">' . $key->MsWorkplaceName . '</td>  ';
            echo '  <td class="css_td">' . ($key->MsWorkplaceType == 0 ? "TOKO" : "GUDANG") . '</td>  ';
            echo '  <td class="css_td">' . $key->MsWorkplaceAddress . '</td>  ';
            echo '  <td class="css_td">' . $key->MsWorkplaceTelp1 . '</td>  ';
            echo '  <td class="css_td">' . $key->MsWorkplaceTelp2 . '</td>  ';
            echo '  <td class="css_td">' . $key->MsWorkplaceFax . '</td>  ';
            echo '  <td class="css_td">' . ($key->MsWorkplaceIsActive == 1 ? "Aktif" : "Tidak Aktif") . '</td>  ';
            echo '</tr>                                 ';
            $no++;
        }
        ?>
    </table>
</body>

</html>