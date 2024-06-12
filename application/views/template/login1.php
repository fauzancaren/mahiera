<!DOCTYPE html> 
<html lang="en">
<head>
    <title>&nbsp;Login - OBI ERP</title> 
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('asset/image/mgs-erp/logo.png') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="twitter:site" content="@omahbata" data-rh="true">
    <meta name="twitter:creator" content="@omahbata" data-rh="true">
    <meta name="twitter:title" content="Omahbata Indonesia - Enterprise Resource Planning" data-rh="true">
    <meta name="twitter:description" content="Aplikasi ini dibuat dengan tujuan mempermudah proses transaksi penjualan di omahbata" data-rh="true">
    <meta name="twitter:image" content="<?= base_url('asset/image/mgs-erp/logonew.png') ?>" data-rh="true">

    <!-- CSS --> 
    <link href="<?= base_url('asset/bootstrap-5.2/css/bootstrap.css') ?>" rel="stylesheet" type="text/css">  
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic" rel="stylesheet">  
	<link href="<?= base_url("asset/sweetalert/dist/sweetalert2.min.css") ?>" rel="stylesheet" type="text/css"> 
    <link href="<?= base_url("asset/animate/animate.min.css")?>" rel="stylesheet"  type="text/css">  
    <!-- JS -->
    <script src="<?= base_url('asset/bootstrap-5.2/js/bootstrap.js') ?>"></script>
    <script src="<?= base_url('asset/jquery/jquery-3.6.0.min.js') ?>"></script> 
    <script src="https://kit.fontawesome.com/36f07a24cf.js" crossorigin="anonymous"></script>
	<script src="<?= base_url("asset/sweetalert/dist/sweetalert2.all.min.js") ?>"></script> 
</head>
<style>   

    .curved-background {
        position: absolute;
        top: 0;
        z-index: -1;
        width: 100%;
        height: 26rem;
    }
    .curved-background__curved {
        background-color: #ffa447; 
        border-bottom-left-radius: 25% 50%;
        border-bottom-right-radius: 25% 50%;
        height: 50%;
        width: 100%;
    } 
    section.header{
        margin-top: 2rem;
    } 
    .btn-outline-orange {
        --bs-btn-color: #fda90d;
        --bs-btn-border-color: #fd9d0d;
        --bs-btn-hover-color: #fff;
        --bs-btn-hover-bg: #fd9d0d;
        --bs-btn-hover-border-color: #fda10d;
        --bs-btn-focus-shadow-rgb: 13,110,253;
        --bs-btn-active-color: #fff;
        --bs-btn-active-bg: #fdab0d;
        --bs-btn-active-border-color: #fdbe0d;
        --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
        --bs-btn-disable-color: #fdb70d;
        --bs-btn-disable-bg: transparent;
        --bs-btn-disable-border-color: #fdbe0d;
        --bs-gradient: none;
    }
    .input-box-user{
        background: #ffead2;
    border: 1px solid #ffd79b;
        position: relative;
        border-radius: 0.5rem;
        padding: 0.25rem;
    }
    .input-box-user > ion-icon{ 
        position: absolute;
        color: #a8a8a8;
    } 
    .input-box-user > input{ 
        padding-left:2rem;
        width:95%;
        font-size:0.8rem;
        font-weight:bold;
        background:transparent;
    }
    
    .input-box-password{
        background: #ffead2;
        border: 1px solid #ffd79b;
        position: relative;
        border-radius: 0.5rem;
        padding: 0.25rem;
    }
    .input-box{
        background: #ffead2;
        border: 1px solid #ffd79b; 
        border-radius: 0.5rem;
        padding: 0.25rem;
    }
    .input-box-password > ion-icon{ 
        position: absolute;
        color: #a8a8a8;
    } 
    .input-box-password > input{ 
        padding-left:2rem;
        width:95%;
        font-size:0.8rem;
        font-weight:bold;        
        background:transparent;
    }

    textarea:focus, 
    textarea.form-control:focus, 
    input.form-control:focus, 
    input[type=text]:focus, 
    input[type=password]:focus, 
    input[type=email]:focus, 
    input[type=number]:focus, 
    [type=text].form-control:focus, 
    [type=password].form-control:focus, 
    [type=email].form-control:focus, 
    [type=tel].form-control:focus, 
    [contenteditable].form-control:focus {
        outline: none;
        box-shadow:none !important;
        border:none;
    }
    textarea, 
    textarea.form-control, 
    input.form-control, 
    input[type=text], 
    input[type=password], 
    input[type=email], 
    input[type=number], 
    [type=text].form-control, 
    [type=password].form-control, 
    [type=email].form-control, 
    [type=tel].form-control, 
    [contenteditable].form-control {
        outline: none;
        box-shadow:none !important;
        border:none;
    }
    input:-webkit-autofill,
    input:-webkit-autofill:focus {
        transition: background-color 600000s 0s, color 600000s 0s;
    }
    input[data-autocompleted] {
        background-color: transparent !important;
    }
    .footer {
        left: 0;
        position: fixed;
        bottom: 0;
        width: 100%;
        height:50%;
        z-index: -2;   
        background-image: url(<?= base_url("asset/image/mgs-erp/bg-login.png") ?>);
        background-repeat: tr;
        background-size: 700px 500px;
    }
    .transisi{
        position: absolute;
        height: 100%;
        width: 100%;
        background: rgb(255,255,255);
        background: linear-gradient(180deg, rgba(255,255,255,1) 32%, rgba(255,255,255,0.3533788515406162) 70%, rgba(0,0,0,0) 100%);
    }
    input{
        width: 95%;
        font-size: 0.8rem;
        font-weight: bold;
        background: transparent;
    }
    </style>
<body>
    <div class="curved-background">
        <div class="curved-background__curved"></div>
    </div> 
    <section class="container text-center header">
        <div class="d-flex justify-content-center">
            <div class="logo">
                <img src="<?= base_url("asset/image/mgs-erp/logowhite.png") ?>" width="50" height="50" class="d-inline-block align-top me-2" alt=""> 
            </div>
            <div class="title"> 
                <h1 class="text-white mb-0">MGS-ERP</h1>
                <span style="color: #ffebb0;font-size: 0.8rem;">Aplikasi Internal MGS</span>
            </div> 

        </div>
    </section>
    <section class="container content">
        <div class="row justify-content-center mx-2 mx-lg-3"> 
            <div class="card mt-4" style="box-shadow: 0px 0px 12px 0px #b1b1b1;border: none;width:20rem">
                <div class="card-body text-center">  
                    <h1 class="mb-4">Login</h1> 
                    <div class="input-box mb-3 d-flex">
                        <div class="icon d-inline px-2">  <i class="fas fa-user text-muted"></i>  </div>
                        <div class="flex-fill"> 
                            <input type="text" name="username" id="username" autocomplete="off"  value="" placeholder="username">
                        </div>
                    </div>
                    <div class="input-box mb-3 d-flex">
                        <div class="icon d-inline px-2">  <i class="fas fa-key text-muted"></i>  </div>
                        <div class="flex-fill"> 
                            <input type="password" name="password" id="password" autocomplete="off"  value="" placeholder="password">
                        </div>
                    </div> 
                    <button type="submit" name="submit"  id="submit" class="btn btn-outline-orange btn-sm w-100 mb-2">Submit</button> 
                </div>
            </div>
            <div class="text-center mt-4"> 
                <div class="d-flex brand justify-content-center">
                    <img src="<?= base_url("asset/image/logo/logo-1-200.png") ?>" alt="" height="50"> 
                    <img src="<?= base_url("asset/image/logo/logo-2-200.png") ?>" alt="" height="50"> 
                    <img src="<?= base_url("asset/image/logo/logo-3-200.png") ?>" alt="" height="50"> 
                    <img src="<?= base_url("asset/image/logo/logo-4-200.png") ?>" alt="" height="50"> 
                    <img src="<?= base_url("asset/image/logo/logo-5-200.png") ?>" alt="" height="50"> 
                    <img src="<?= base_url("asset/image/logo/logo-7-200.png") ?>" alt="" height="50"> 
                </div>
                <span style="font-size: 0.85rem;color: #999999;">—— © Support By : IT Center and Program ——</span>
            </div>
        </div>
        <div class="footer">
            <div class="transisi"></div>  
        </div>
    </section>  
    <script type="text/javascript">
        $("#username").keyup(function(event) {
            if (event.keyCode === 13) {
                $("#password").focus();
            }
        });
        $("#password").keyup(function(event) {
            if (event.keyCode === 13) {
                $("#submit").click();
            }
        });
        $('#submit').on('click', function() {  
            $(this).html('<i class="fas fa-circle-notch fa-spin"></i> Loading');
            $.ajax({
                method: "POST",
                url: "<?php echo base_url('login/check') ?>",
                data: {
                    'MsEmpCode': $("#username").val(),
                    'MsEmpPass': $("#password").val()
                },
                success: function(data) {
                    $("#message-username").html(data.username);
                    $("#message-password").html(data.password);
                    $("#submit").html('Submit');
                    if (data.status == 'Success') {
                        Swal.fire({
                            showClass: {
                                popup: 'animate__animated animate__zoomInUp', 
                            }, 
                            hideClass: {
                                popup: 'animate__animated fadeOutUp animate__zoomOutDown',
                            },
                            icon: 'success',
                            title: 'Login Success',
                            showConfirmButton: false,
                            timer: 1500,
                        }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.timer) {
                                window.location.replace('<?= base_url(); ?>');
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
    
</body>
</html>