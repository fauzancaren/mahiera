<!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8"> 
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('asset/image/mgs-erp/logo.png') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="twitter:site" content="@mahieraglobalsolution" data-rh="true">
    <meta name="twitter:creator" content="@mahieraglobalsolution" data-rh="true">
    <meta name="twitter:title" content="mahiera global solution - Enterprise Resource Planning" data-rh="true">
    <meta name="twitter:description" content="Aplikasi ini dibuat dengan tujuan mempermudah proses transaksi penjualan di Mahiera Global Solution" data-rh="true">
    <meta name="twitter:image" content="<?= base_url('asset/image/mgs-erp/logo.png') ?>" data-rh="true">
    <title>MGS-ERP | LOGIN FORM</title>
    <link href="<?= base_url('asset/bootstrap-5.2/css/bootstrap.css') ?>" rel="stylesheet" type="text/css">   

	
	<link href="<?= base_url("asset/sweetalert/dist/sweetalert2.min.css") ?>" rel="stylesheet" type="text/css"> 
    <link href="<?= base_url("asset/animate/animate.min.css")?>" rel="stylesheet"  type="text/css">  
	<script src="<?= base_url("asset/sweetalert/dist/sweetalert2.all.min.js") ?>"></script> 

	
    <script src="<?= base_url('asset/bootstrap-5.2/js/bootstrap.js') ?>"></script>
    <script src="<?= base_url('asset/jquery/jquery-3.6.0.min.js') ?>"></script> 
    <script src="https://kit.fontawesome.com/36f07a24cf.js" crossorigin="anonymous"></script>
    <style>
        body{
            font-family: "Roboto", sans-serif;
        }
		.btn-primary{
			background:#6c9bcf;
			border-color:#6c9bcf;
		}
    </style>
 </head>
 <body>
    <section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="text-center my-4">
						<img src="<?= base_url('asset/image/mgs-erp/logo-blue.png') ?>" alt="logo" width="200">
					</div>
					<div class="card shadow-lg border-0">
						<div class="card-body p-5 ">
							<h1 class="fs-4 card-title fw-bold mb-4">Login App</h1>   
							<div class="mb-3">
								<label class="mb-2 text-muted" for="username">username</label>
								<input id="username" type="text" class="form-control" name="username" value="" required autofocus>
								<div class="invalid-feedback">
									Username Tidak Valid
								</div>
							</div>

							<div class="mb-3">
								<div class="mb-2 w-100">
									<label class="text-muted" for="password">Password</label>
									
								</div>
								<input id="password" type="password" class="form-control" name="password" required>
								<div class="invalid-feedback">
									Password Tidak Valid
								</div>
							</div>

							<div class="d-flex  "> 
								<button type="submit"  id="submit" class="btn btn-primary">
									Login
								</button>
								<a href="#" class="ms-auto">
									Lupa Password?
								</a>
							</div> 
						</div> 
					</div>
					<div class="text-center mt-5 text-muted fs-7">
						Copyright&copy;2024 &mdash; MAHIERA GLOBAL SOLUTION 
					</div>
				</div>
			</div>
		</div>
	</section>

	<script>
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
                                window.location.replace('<?= base_url("client"); ?>');
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