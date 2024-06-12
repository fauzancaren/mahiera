<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <title>&nbsp;Login - OBI ERP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="twitter:site" content="@omahbata" data-rh="true">
    <meta name="twitter:creator" content="@omahbata" data-rh="true">
    <meta name="twitter:title" content="Omahbata Indonesia - Enterprise Resource Planning" data-rh="true">
    <meta name="twitter:description" content="Aplikasi ini dibuat dengan tujuan mempermudah proses transaksi penjualan di omahbata" data-rh="true">
    <meta name="twitter:image" content="https://obi-system.com/asset/image/mgs-erp/logo.png" data-rh="true">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/bootstrap-5.2/css/bootstrap.css') ?>" />
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <script src="<?php echo base_url('asset/bootstrap-5.2/js/bootstrap.js') ?>"></script>
    <script src="<?php echo base_url('asset/jquery/jquery-3.6.0.min.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js" crossorigin="anonymous"></script>

    <script src="https://kit.fontawesome.com/36f07a24cf.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700&amp;display=swap" rel="stylesheet">
    <title>OBI-ERP</title>
    <link rel="icon" type="image/png" sizes="32x32" href="<?= site_url('asset/image/mgs-erp/logo.png') ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">  
	<link href="<?= base_url("asset/sweetalert/dist/sweetalert2.min.css") ?>" rel="stylesheet" type="text/css">
	<script src="<?= base_url("asset/sweetalert/dist/sweetalert2.all.min.js") ?>"></script>
    <style>
        body {
            font-family: "Karla", sans-serif;
            background-color: #d0d0ce;
            min-height: 100vh;
        }

        .brand-wrapper {
            margin-bottom: 19px;
        }

        .brand-wrapper .logo {
            height: 60px;
        }

        .container {
            max-width: 900px;
        }

        @media (min-width: 768px) {

            .container,
            .container-md,
            .container-sm {
                max-width: 720px;
            }
        }

        .login-card {
            border: 0;
            border-radius: 20px;
            box-shadow: 0 10px 30px 0 rgba(172, 168, 168, 0.43);
            overflow: hidden;
        }

        .login-card-img {
            border-radius: 0;
            width: 100%;
            height: 100%;
            -o-object-fit: cover;
            object-fit: cover;
        }

        .login-card .card-body {
            padding: 1rem 2rem 2rem;
        }

        @media (max-width: 422px) {
            .login-card .card-body {
                padding: 35px 24px;
            }
        }

        .login-card-description {
            font-size: 25px;
            color: #000;
            font-weight: normal;
            margin-bottom: 23px;
        }

        .footer-link {
            top: 90% !important;
        }

        .login-btn {
            padding: 13px 20px 12px;
            background-color: #222d32;
            border-radius: 4px;
            font-size: 17px;
            font-weight: bold;
            line-height: 20px;
            color: #b8c7ce;
            margin-bottom: 24px;
        }

        .login-btn:hover {
            background: #1e282c;
            color: white;
        }
    </style>
</head>

<body>
    <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">
        <div class="container">
            <div class="card login-card">
                <div class="row no-gutters">
                    <div class="col-md-5 d-none d-sm-none d-md-block p-0 m-0 position-relative " style="background: #222d32;">
                        <img src="asset/image/mgs-erp/logo-login.jpg" alt="login" class="login-card-img">
                        <span class="text-white fw-bolder text-center font-monospace position-absolute footer-link start-50 translate-middle">
                            <a href="https://www.omahbata.com/" target="_blank" class="text-white">www.omahbata.com</a>
                        </span>
                    </div>
                    <div class="col-md-7 position-relative">
                        <div class="card-body">
                            <div class="brand-wrapper  mb-4 ">
                                <div class="d-flex flex-row align-items-center bd-highlight">
                                    <img src="asset/image/mgs-erp/logo.png" alt="logo" class="logo">
                                    <span class="fw-bold align-middle ms-2 font-monospace" style="color: #ff6600;font-size: 2rem">OBI-ERP</span>
                                </div>
                            </div>
                            <div class="form" id="formlogin">
                                <div class="form-floating mb-4">
                                    <input type="text" class="form-control" id="username" name="username" placeholder="ID000xx" required>
                                    <label for="username">Username</label>
                                    <div class="invalid text-danger" id="message-username">

                                    </div>
                                </div>
                                <div class="form-floating mb-4">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                    <label for="password">Password</label>
                                    <div class="invalid text-danger" id="message-password">

                                    </div>
                                </div>
                                <div class="d-grid gap-2">
                                    <button name="login" id="login" class="btn btn-block login-btn mb-4" type="submit">Login</button>
                                </div>
                            </div>
                            <script type="text/javascript">
                                $("#username").keyup(function(event) {
                                    if (event.keyCode === 13) {
                                        $("#password").focus();
                                    }
                                });
                                $("#password").keyup(function(event) {
                                    if (event.keyCode === 13) {
                                        $("#login").click();
                                    }
                                });
                                $('#login').on('click', function() {
                                    $(this).html('<i class="fas fa-circle-notch fa-spin"></i> Loading');
                                    $.ajax({
                                        method: "POST",
                                        url: "<?php echo site_url('login/check') ?>",
                                        data: {
                                            'MsEmpCode': $("#username").val(),
                                            'MsEmpPass': $("#password").val()
                                        },
                                        success: function(data) {
                                            $("#message-username").html(data.username);
                                            $("#message-password").html(data.password);
                                            $("#login").html('Login');
                                            if (data.status == 'Success') {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Login Success',
                                                    showConfirmButton: false,
                                                    timer: 1500,
                                                }).then((result) => {
                                                    if (result.dismiss === Swal.DismissReason.timer) {
                                                        window.location.replace('<?= site_url(); ?>');
                                                    }
                                                })

                                            } else {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Login failed',
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                });
                                            }
                                        }
                                    });
                                })
                            </script>
                            <p class="text-center">—— © Support By : IT Center and Program ——</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>