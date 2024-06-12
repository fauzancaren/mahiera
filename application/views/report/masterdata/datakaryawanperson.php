<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="<?= site_url('asset/image/mgs-erp/logo.ico') ?>">
    <title>DATA MASTER - DATA KARYAWAN</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <style>
        @page {
            margin: 10px;
        }

        body {
            font-family: 'Noto Sans JP', sans-serif;
        }

        span {
            color: rgba(32, 32, 32, 0.8);
        }

        .header {
            background: #d4582a;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            height: 150px;
        }

        .profile_img {
            position: absolute;
            top: 40px;
            left: 40px;
            width: 150px;
            height: 150px;
            border-radius: 75px;
            border-style: solid;
            border-color: white;
            border-width: medium;

            overflow: hidden;

            background-size: 150px 150px;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
        }

        .title {
            padding-top: 50px;
            padding-left: 30px
        }

        .title-header {
            padding-top: 30px;
            font-family: 'Noto Sans JP', sans-serif;
            font-size: 2rem;
            font-weight: bold;
            color: white
        }

        .title-job {
            font-family: 'Noto Sans JP', sans-serif;
            font-size: 1rem;
            color: white;
        }

        .title-desc {
            padding-top: 30px;
            padding-left: 30px
        }

        .sub-title {
            font-family: 'Noto Sans JP', sans-serif;
            font-size: 1.2rem;
            font-weight: bold;
            color: #d4582a;
            background-color: #f5edea;
            width: 100%;
            padding: 5px;
            padding-left: 15px;
        }

        .menu {
            width: 95%;
            margin-right: 0px;
            margin-left: auto;

        }

        .footer-2 {
            position: fixed;
            bottom: 105px;
            background: #f5edea;
            height: 10px;
        }

        .footer {
            position: fixed;
            bottom: 0px;
            background: #d4582a;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
            height: 100px;
        }
    </style>
</head>

<body>
    <div class="header">
        <table style="width:100%">
            <tr>
                <td align="center" style="width:30%">
                    <img src="<?= site_url('asset/image/employee/' . $datatable['MsEmpCode'] . '.png') ?>" class="profile_img" alt="" height="100" width="100">
                </td>
                <td align="left" class="title">
                    <span class="title-header"><?= $datatable['MsEmpName'] ?></span><br>
                    <span class="title-job"><?= $datatable['MsEmpPositionName'] ?></span>
                </td>
            </tr>
        </table>
    </div>

    <br>

    <table style="width:100%;padding-left: 25%;" cellpadding="7">
        <tr style="background:black">
            <td colspan="3" class="sub-title">
                Personal
            </td>
        </tr>
        <tr>
            <td width="100px">
                <span>NIP/NIK</span>
            </td>
            <td style="width:10px">
                <span>:</span>
            </td>
            <td>
                <span><?= $datatable['MsEmpNip'] ?></span>
            </td>
        </tr>
        <tr>
            <td width="100px">
                <span>Tempat Lahir</span>
            </td>
            <td style="width:10px">
                <span>:</span>
            </td>
            <td>
                <span><?= $datatable['MsEmpBirthPlace'] . ', ' . date_format(date_create($datatable['MsEmpBirthDate']), "d F Y") ?></span>
            </td>
        </tr>
        <tr>
            <td width="100px">
                <span>Jenis Kelamin</span>
            </td>
            <td style="width:10px">
                <span>:</span>
            </td>
            <td>
                <span><?= ($datatable['MsEmpGender'] == "M" ? 'Laki-laki' : 'Perempuan') ?></span>
            </td>
        </tr>
        <tr>
            <td width="100px">
                <span>No. Telp</span>
            </td>
            <td style="width:10px">
                <span>:</span>
            </td>
            <td>
                <span><?= $datatable['MsEmpTlp'] ?></span>
            </td>
        </tr>
        <tr>
            <td width="100px">
                <span>Email</span>
            </td>
            <td style="width:10px">
                <span>:</span>
            </td>
            <td>
                <span><?= $datatable['MsEmpEmail'] ?></span>
            </td>
        </tr>
        <tr>
            <td width="100px">
                <span>Alamat</span>
            </td>
            <td style="width:10px">
                <span>:</span>
            </td>
            <td>
                <span><?= $datatable['MsEmpAddress'] ?></span>
            </td>
        </tr>
    </table>

    <br>

    <table style="width:100%;padding-left: 25%;" cellpadding="7">
        <tr style="background:black">
            <td colspan="3" class="sub-title">
                Perusahaan
            </td>
        </tr>
        <tr>
            <td width="100px">
                <span>Mulai Bekerja</span>
            </td>
            <td style="width:10px">
                <span>:</span>
            </td>
            <td>
                <span><?= date_format(date_create($datatable['MsEmpStartWork']), "d F Y") ?></span>
            </td>
        </tr>
        <tr>
            <td width="100px">
                <span>Jabatan</span>
            </td>
            <td style="width:10px">
                <span>:</span>
            </td>
            <td>
                <span><?= $datatable['MsEmpPositionName'] ?></span>
            </td>
        </tr>
        <tr>
            <td width="100px">
                <span>Toko</span>
            </td>
            <td style="width:10px">
                <span>:</span>
            </td>
            <td>
                <span><?= $datatable['MsWorkplaceName'] ?></span>
            </td>
        </tr>
    </table>

    <br>

    <table style="width:100%;padding-left: 25%;" cellpadding="7">
        <tr style="background:black">
            <td colspan="3" class="sub-title">
                Akun Bank
            </td>
        </tr>
        <tr>
            <td width="100px">
                <span>Bank</span>
            </td>
            <td style="width:10px">
                <span>:</span>
            </td>
            <td>
                <span><?= $datatable['MsEmpBank'] ?></span>
            </td>
        </tr>
        <tr>
            <td width="100px">
                <span>Rekening</span>
            </td>
            <td style="width:10px">
                <span>:</span>
            </td>
            <td>
                <span><?= $datatable['MsEmpRekNo'] ?></span>
            </td>
        </tr>
        <tr>
            <td width="100px">
                <span>A/N</span>
            </td>
            <td style="width:10px">
                <span>:</span>
            </td>
            <td>
                <span><?= $datatable['MsEmpRekName'] ?></span>
            </td>
        </tr>
    </table>

    <div class="footer">
    </div>
    <div class="footer-2">
    </div>
</body>

</html>