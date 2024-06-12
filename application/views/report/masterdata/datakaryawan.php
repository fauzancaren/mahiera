<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="asset/image/mgs-erp/logo.ico">
    <title>DATA MASTER - DATA KARYAWAN</title>
    <style>
        .css_table,
        .css_th,
        .css_td {
            border: 0.2px solid black;
            border-collapse: collapse;
        }

        .css_th {
            background-color: #25221d;
            color: white;
            font-size: 0.5rem;
        }

        .css_table,
        .css_td {
            padding: 5px;
            text-align: left;
            word-wrap: break-word;
            font-size: 0.5rem;
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
                    <h2>DATA KARYAWAN</h2>
                </td>
            </tr>
        </table>
    </header>
    <br>
    <table class="css_table" style="width:100%">
        <tr>
            <th class="css_th" colspan="5">Detail</th>
            <th class="css_th" colspan="6">Personal</th>
            <th class="css_th" colspan="3">perusahaan</th>
            <th class="css_th" colspan="3">Akun Bank</th>
        </tr>
        <tr>
            <th class="css_th">No</th>
            <th class="css_th">Kode</th>
            <th class="css_th">Nama</th>
            <th class="css_th">No.Kartu</th>
            <th class="css_th">Status</th>
            <th class="css_th">NIK</th>
            <th class="css_th">Tempat Lahir</th>
            <th class="css_th">Jenis Kelamin</th>
            <th class="css_th">No. Telp</th>
            <th class="css_th">Email</th>
            <th class="css_th">Alamat</th>
            <th class="css_th">Mulai Bekerja</th>
            <th class="css_th">Jabatan</th>
            <th class="css_th">Toko</th>
            <th class="css_th">Bank</th>
            <th class="css_th">Rekening</th>
            <th class="css_th">A/N</th>
        </tr>

        <?php
        $no = 1;
        foreach ($datatable as $key) {
            echo '<tr>                                  ';
            echo '  <td class="css_td">' . $no . '</td>  ';
            echo '  <td class="css_td">' . $key->MsEmpCode . '</td>  ';
            echo '  <td class="css_td">' . $key->MsEmpName . '</td>  ';
            echo '  <td class="css_td">' . $key->MsEmpCard . '</td>  ';
            echo '  <td class="css_td">' . ($key->MsEmpIsActive == 1 ? "Aktif" : "Tidak Aktif") . '</td>  ';
            echo '  <td class="css_td">' . $key->MsEmpNip . '</td>  ';
            echo '  <td class="css_td">' . $key->MsEmpBirthPlace . ', ' . date_format(date_create($key->MsEmpBirthDate), "d F Y") . '</td>  ';
            echo '  <td class="css_td">' . ($key->MsEmpGender == "M" ? 'Laki-laki' : 'Perempuan') . '</td>  ';
            echo '  <td class="css_td">' . $key->MsEmpTlp . '</td>  ';
            echo '  <td class="css_td">' . $key->MsEmpEmail . '</td>  ';
            echo '  <td class="css_td">' . $key->MsEmpAddress . '</td>  ';
            echo '  <td class="css_td">' . date_format(date_create($key->MsEmpStartWork), "d F Y") . '</td>  ';
            echo '  <td class="css_td">' . $key->MsEmpPositionName . '</td>  ';
            echo '  <td class="css_td">' . $key->MsWorkplaceName . '</td>  ';
            echo '  <td class="css_td">' . $key->MsEmpBank . '</td>  ';
            echo '  <td class="css_td">' . $key->MsEmpRekNo . '</td>  ';
            echo '  <td class="css_td">' . $key->MsEmpRekName . '</td>  ';
            echo '</tr>                                 ';
            $no++;
        }
        ?>
    </table>
</body>

</html>