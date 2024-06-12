<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="Tokopedia">
    <meta name="theme-color" content="#42b549">
    <meta name="page-type" content="productdetailpage-desktop" data-rh="true">
    <meta name="title" content="Detail Transaksi" data-rh="true">
    <meta name="description" content="Penjualan Atas nama  <?php echo $customer; ?>" data-rh="true">

    <meta name="twitter:card" content="product" data-rh="true">
    <meta name="twitter:site" content="@tokopedia" data-rh="true">
    <meta name="twitter:creator" content="@tokopedia" data-rh="true">
    <meta name="twitter:title" content="Detail Transaksi Penjualan | <?php echo $customer; ?>" data-rh="true">
    <meta name="twitter:description" content="Nomer Sales : <?php echo $code; ?> | Tanggal Transaksi pembelian : <?php echo $date_pembelian; ?>" data-rh="true">
    <meta name="twitter:image" content="<?php echo base_url('asset/image/mgs-erp/logo.png') ?>" data-rh="true">


    <link rel="shortcut icon" href="<?php echo base_url('asset/image/mgs-erp/logo.ico') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/bootstrap.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/dataTables.bootstrap4.min.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/responsive.bootstrap4.min.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/datatable.select.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/fontawesome/css/font-awesome.css') ?>" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url('asset/css/daterangepicker.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/fstdropdown.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/fastselect.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/timepicker.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/croppie.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/jquery.contextMenu.css') ?>" />


    <script src="<?php echo base_url('asset/js/jquery-3.3.1.min.js') ?>"></script>
    <script src="<?php echo base_url('asset/js/jquery.dataTables.min.js') ?>"></script>
    <script src="<?php echo base_url('asset/js/popper.min.js') ?>"></script>
    <script src="<?php echo base_url('asset/js/dataTables.bootstrap4.min.js') ?>"></script>
    <script src="<?php echo base_url('asset/js/dataTables.fixedHeader.min.js') ?>"></script>
    <script src="<?php echo base_url('asset/js/dataTables.responsive.min.js') ?>"></script>
    <script src="<?php echo base_url('asset/js/responsive.bootstrap.min.js') ?>"></script>
    <script src="<?php echo base_url('asset/js/bootstrap.js') ?>"></script>
    <script src="<?php echo base_url('asset/js/moment.min.js') ?>"></script>
    <script src="<?php echo base_url('asset/js/daterangepicker.js') ?>"></script>
    <script src="<?php echo base_url('asset/js/timepicker.js') ?>"></script>
    <script src="<?php echo base_url('asset/js/jquery.redirect.js') ?>"></script>
    <script src="<?php echo base_url('asset/js/datatable.select.js') ?>"></script>
    <script src="<?php echo base_url('asset/js/fastselect.js') ?>"></script>
    <script src="<?php echo base_url('asset/js/cleave.js') ?>"></script>
    <script src="<?php echo base_url('asset/js/croppie.js') ?>"></script>
    <script src="<?php echo base_url('asset/js/fstdropdown.js') ?>"></script>
    <script src="<?php echo base_url('asset/js/jquery.validate.js') ?>"></script>
    <script src="<?php echo base_url('asset/js/cleave-phone.id.js') ?>"></script>
    <script src="<?php echo base_url('asset/js/jquery.contextMenu.js') ?>"></script>

</head>
<style>
    .header {
        position: relative;
        color: red;
    }

    .top-right {
        position: absolute;
        border: 1px solid black;
        width: 100px;
        padding: 0.25rem;
        top: 70px;
        right: 0.5rem;
        font-size: 12px;
        font-weight: bold;
        color: black;
    }

    .printdate {
        position: absolute;
        top: 0.75rem;
        right: 0.5rem;
        font-size: 11px;
        color: black
    }

    table th {
        border-top: 1px solid black;
        border-bottom: 1.5px solid black;
        font-size: 12px
    }

    table>tr>td>table>tr.bottom-border {
        border-bottom: 1px solid #222;
    }
</style>

<body style="background-color: #ddd;">
    <div class="container bg-faded">
        <table width="100%" cellspacing="0" cellpadding="0" style="background-color: #fff;border: thin solid #979797; border-bottom: none; border-radius: 4px; color: #343030; margin-top: 20px;">
            <tbody>
                <tr style="background-color: rgba(242, 242, 242, 0.74)">
                    <td style="font-weight: 600; font-size: 16px; padding: 10px;">Ringkasan Transaksi <?php echo $customer; ?></td>
                </tr>
                <tr>
                    <td>
                        <h1 class="text-center mt-4">Sales Order</h1>
                        <hr>
                        <div class="row p-4 m-4">
                            <?php echo $content; ?>
                        </div>
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h1 class="text-center mt-4">Sales Payment</h1>
                        <hr>
                        <div class="row p-4  m-4">
                            <?php echo $content2; ?>
                        </div>
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h1 class="text-center mt-4">Bukti Payment</h1>
                        <hr>
                        <div class="row p-4 m-4">
                            <?php echo $content3; ?>
                        </div>
                        <hr>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
</body>