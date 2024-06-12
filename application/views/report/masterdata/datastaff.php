<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="asset/image/mgs-erp/logo.ico">
    <title>DATA MASTER - DATA STAFF</title>
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
                    <h2>DATA STAFF</h2>
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
            <th class="css_th">Alamat</th>
            <th class="css_th">Telp</th>
            <th class="css_th">Status</th>
        </tr>

        <?php
        $no = 1;
        foreach ($datatable as $key) {
            echo '<tr>                                  ';
            echo '  <td class="css_td">' . $no . '</td>  ';
            echo '  <td class="css_td">' . $key->StaffCode . '</td>  ';
            echo '  <td class="css_td">' . $key->StaffName . '</td>  ';
            echo '  <td class="css_td">' . $key->StaffAddress . '</td>  ';
            echo '  <td class="css_td">' . $key->StaffTelp . '</td>  ';
            echo '  <td class="css_td">' . ($key->StaffIsActive == 1 ? "Aktif" : "Tidak Aktif") . '</td>  ';
            echo '</tr>                                 ';
            $no++;
        }
        ?>
    </table>
</body>

</html>