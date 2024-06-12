<!DOCTYPE html> 
<html lang="en">
<head>
    <title>&nbsp;Login - OBI ERP</title> 
    <link rel="icon" type="image/png" sizes="32x32" href="<?= site_url('asset/image/mgs-erp/logo.png') ?>">
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
	<script src="<?= base_url("asset/jquery/jquery.moment.min.js") ?>"></script>
    <script src="https://kit.fontawesome.com/36f07a24cf.js" crossorigin="anonymous"></script>
	<script src="<?= base_url("asset/sweetalert/dist/sweetalert2.all.min.js") ?>"></script> 
	<script src="<?= base_url("asset/cleave/cleave.min.js") ?>"></script>
	<script src="<?= base_url("asset/cleave/cleave-phone.id.js") ?>"></script>
</head>
<style>   
    :root{
        --bs-link-hover-color: #ff5600;
    	--bs-link-color: #f3830d;
    }
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
    .btn-link{
        text-decoration:none;
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
                <h1 class="text-white mb-0">OBI-ERP</h1>
                <span style="color: #ffebb0;font-size: 0.8rem;">Aplikasi Internal Omahbata Indonesia</span>
            </div> 

        </div>
    </section>
    <section class="container content">
        <div class="d-flex w-100 justify-content-center" style="min-height:50vh">
            <!-- PILIHAN METODE-->
            <div id="form-metode" class="animate__animated justify-content-center mx-2 mx-lg-3" > 
                <div class="card mt-4" style="box-shadow: 0px 0px 12px 0px #b1b1b1;border: none;width:22rem">
                    <div class="card-body " style="font-size:0.85rem">  
                        <h4 class="mb-4 text-center">VERIFIKASI 2 LANGKAH</h4> 
                        <p class="card-text">Pilih metode yang ingin anda gunakan</p> 
                        <div class="d-flex justify-content-between mb-1 align-items-center mx-2 border-bottom">  
                            <a id="btn-method-wa" class="btn btn-link" style="font-size:0.85rem;text-decoration:none"><i class="fab fa-whatsapp pe-2"></i>Whatsapp</a> 
                        </div>     
                        <div class="d-flex mb-3 align-items-center mx-2 border-bottom">   
                            <a id="btn-method-email" class="btn btn-link" style="font-size:0.85rem;text-decoration:none"><i class="fas fa-envelope pe-2"></i>Email</a> 
                        </div>
                        <label id="error-method" class="form-label  text-danger mb-5 "></label>  
                        <div class="d-flex justify-content-between ">
                            <a  href="<?= site_url("login/logout") ?>" class="btn btn-sm btn-link" style="font-size:0.85rem;text-decoration:none">Keluar</a> 
                        </div>
                    </div>
                </div>
            </div>

            <!-- REGISTRASI KODE WHATSAPP-->
            <div id="form-wa-reg" class="animate__animated justify-content-center mx-2 mx-lg-3"> 
                <div class="card mt-4" style="box-shadow: 0px 0px 12px 0px #b1b1b1;border: none;width:22rem">
                    <div class="card-body " style="font-size:0.85rem">  
                        <h4 class="mb-4 text-center">VERIFIKASI 2 LANGKAH</h4> 
                        <p class="card-text">Saat ini anda belum memasukan nomer verifikasi 2 langkah. Silahkan masukan nomer <b>whatsapp</b> yang anda gunakan saat ini untuk mendapatkan <b>kode verifikasi</b>.</p> 
                        <label for="input-verifikasi" class="form-label">Nomer Whatsapp Aktif</label> 
                        <div class="input-box mb-3 d-flex">
                            <div class="icon d-inline ps-2"><i class="fas fa-mobile-alt"></i>&nbsp;+62</div>
                            <div class="flex-fill"> 
                                <input type="text" name="input-wa-reg" id="input-wa-reg" autocomplete="off"  value="" placeholder="812 3456 789">
                            </div>
                        </div>
                        <label id="error-reg-wa" class="form-label  text-danger mb-5 "></label>  
                        <div class="d-flex justify-content-between ">
                            <a  href="<?= site_url("login/logout") ?>" class="btn btn-sm btn-link" style="font-size:0.85rem;text-decoration:none">Keluar</a> 
                            <button class="btn btn-sm btn-outline-orange" id="btn-wa-reg-submit" disabled>Lanjutkan</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- REGISTRASI EMAIL-->
            <div id="form-email-reg" class="animate__animated justify-content-center mx-2 mx-lg-3"> 
                <div class="card mt-4" style="box-shadow: 0px 0px 12px 0px #b1b1b1;border: none;width:22rem">
                    <div class="card-body " style="font-size:0.85rem">  
                        <h4 class="mb-4 text-center">VERIFIKASI 2 LANGKAH</h4> 
                        <p class="card-text">Saat ini anda belum memasukan email verifikasi 2 langkah. Silahkan masukan <b>email</b> yang anda gunakan saat ini untuk mendapatkan <b>kode verifikasi</b>.</p> 
                        <label for="input-verifikasi" class="form-label">Alamat Email</label> 
                        <div class="input-box mb-3 d-flex">
                            <div class="icon d-inline ps-2"><i class="fas fa-envelope"></i>&nbsp;</div>
                            <div class="flex-fill"> 
                                <input type="email" name="input-email-reg" id="input-email-reg" autocomplete="off"  value="" placeholder="admin@obi-system.com">
                            </div>
                        </div>
                        <label id="error-reg-email" class="form-label  text-danger mb-5 "></label>  
                        <div class="d-flex justify-content-between ">
                            <a  href="<?= site_url("login/logout") ?>" class="btn btn-sm btn-link" style="font-size:0.85rem;text-decoration:none">Keluar</a> 
                            <button class="btn btn-sm btn-outline-orange" id="btn-email-reg-submit" disabled>Lanjutkan</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- VERIFIKASI KODE VIA WHATSAPP-->
            <div id="form-wa-send" class="animate__animated justify-content-center mx-2 mx-lg-3"> 
                <div class="card mt-4" style="box-shadow: 0px 0px 12px 0px #b1b1b1;border: none;width:22rem">
                    <div class="card-body " style="font-size:0.85rem">  
                        <h4 class="mb-4 text-center">VERIFIKASI 2 LANGKAH</h4> 
                        <p class="card-text"><b>kode verifikasi</b> 6 digit baru saja dikirimkan ke nomer whatsapp <b>+62 <span id="label-no-wa">895 3529 92663</span></b> </p> 
                        <div class="d-flex justify-content-between mb-3 align-items-center mx-2 border-bottom">  
                            <a id="btn-send-wa-code" class="btn btn-link" style="font-size:0.85rem;text-decoration:none">Kirim Ulang Kode</a>
                            <label id="label-time-wa">00:00</label>
                        </div>
                        <div class="input-box d-flex">
                            <div class="icon d-inline ps-2">  <i class="fas fa-key text-muted"></i>&nbsp;OBI-</div>
                            <div class="flex-fill"> 
                                <input type="text" name="input-wa-code" id="input-wa-code" autocomplete="off"  value="" placeholder="XXX XXX">
                            </div>
                        </div>
                        <label id="error-send-wa" class="form-label  text-danger mb-5 "></label>  
                        <div class="d-flex justify-content-between mb-3 align-items-center">  
                            <p>Saya tidak mendapatkan kode verifikasi, <a class="btn-link select-method" style="cursor:pointer">Gunakan Metode lain</a></p> 
                        </div>

                        <div class="d-flex justify-content-between ">
                            <a  href="<?= site_url("login/logout") ?>" class="btn btn-sm btn-link" style="font-size:0.85rem;text-decoration:none">Keluar</a> 
                            <button class="btn btn-sm btn-outline-orange" id="btn-wa-send-submit" disabled>Lanjutkan</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- VERIFIKASI KODE VIA EMAIL-->
            <div id="form-email-send" class="animate__animated justify-content-center mx-2 mx-lg-3"> 
                <div class="card mt-4" style="box-shadow: 0px 0px 12px 0px #b1b1b1;border: none;width:22rem">
                    <div class="card-body " style="font-size:0.85rem">  
                        <h4 class="mb-4 text-center">VERIFIKASI 2 LANGKAH</h4> 
                        <p class="card-text"><b>kode verifikasi</b> 6 digit baru saja dikirimkan ke email <b><span id="label-email">admin@obi-system.com</span></b> . periksa di kotak spam jika tidak ada di inbox</p> 
                        <div class="d-flex justify-content-between mb-3 align-items-center mx-2 border-bottom">  
                            <a id="btn-send-email-code" class="btn btn-link" style="font-size:0.85rem;text-decoration:none">Kirim Ulang Kode</a>
                            <label id="label-time-email">00:00</label>
                        </div>
                        <div class="input-box d-flex">
                            <div class="icon d-inline ps-2">  <i class="fas fa-key text-muted"></i>&nbsp;OBI-</div>
                            <div class="flex-fill"> 
                                <input type="text" name="input-email-code" id="input-email-code" autocomplete="off"  value="" placeholder="XXX XXX">
                            </div>
                        </div>
                        <label id="error-send-email" class="form-label  text-danger mb-5 "></label>  
                        <div class="d-flex justify-content-between mb-3 align-items-center">  
                            <p>Saya tidak mendapatkan kode verifikasi,<a class="btn-link select-method" style="cursor:pointer">Gunakan Metode lain</a></p> 
                        </div>

                        <div class="d-flex justify-content-between ">
                            <a  href="<?= site_url("login/logout") ?>" class="btn btn-sm btn-link" style="font-size:0.85rem;text-decoration:none">Keluar</a> 
                            <button class="btn btn-sm btn-outline-orange" id="btn-email-send-submit" disabled>Lanjutkan</button>
                        </div>
                    </div>
                </div>
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
        <div class="footer">
            <div class="transisi"></div>  
        </div>
    </section>  
    <script type="text/javascript">
        var codewa = "999999";
        var codeemail = "999999";
        send_wa = function(){
			$("#btn-send-wa-code").addClass("disabled");
			var endtime = new moment().add(3, 'minutes');  
			$.ajax({
				method: "POST",
				dataType: "json",
				url: "<?= site_url("function/client_data_master/send_employee_whatsapp/"). $_sessionuser['MsEmpId'] ?>", 
				data:{
					datetime: endtime.format('YYYY-MM-DD HH:mm:ss')
				},
				success: function(data) { 
					endtime = new moment(data["SysVerifikasiDate"]);
					codewa = data["SysVerifikasiCode"];
					var x = setInterval(function() { 
						var now = new moment();
						var distance = endtime.diff(now, 'seconds') + 1;     
						var seconds = Math.floor((distance % 60));
						var minutes = Math.floor(distance / 60); 

						seconds = (seconds.toString().length == 1 ? "0" + seconds: seconds);
						minutes = (minutes.toString().length == 1 ? "0" + minutes: minutes); 
						$("#label-time-wa").text(minutes + ":" + seconds);
						if (distance < 1) {
							$("#btn-send-wa-code").removeClass("disabled");
							clearInterval(x); 
						}
					}, 1000);
				}
			});
		} 
        send_email = function(){
			$("#btn-send-email-code").addClass("disabled");
			var endtime = new moment().add(15, 'minutes');  
			$.ajax({
				method: "POST",
				dataType: "json",
				url: "<?= site_url("function/client_data_master/send_employee_email/"). $_sessionuser['MsEmpId'] ?>", 
				data:{
					datetime: endtime.format('YYYY-MM-DD HH:mm:ss')
				},
				success: function(data) { 
					endtime = new moment(data["SysVerifikasiDate"]);
					codeemail = data["SysVerifikasiCode"];
					var x = setInterval(function() { 
						var now = new moment();
						var distance = endtime.diff(now, 'seconds') + 1;     
						var seconds = Math.floor((distance % 60));
						var minutes = Math.floor(distance / 60); 

						seconds = (seconds.toString().length == 1 ? "0" + seconds: seconds);
						minutes = (minutes.toString().length == 1 ? "0" + minutes: minutes); 
						$("#label-time-email").text(minutes + ":" + seconds);
						if (distance < 1) {
							$("#btn-send-email-code").removeClass("disabled");
							clearInterval(x); 
						}
					}, 1000);
				}
			});
		} 
        $("#form-email-reg,#form-email-send,#form-wa-reg,#form-wa-send,#form-metode").hide();
        $("#form-metode").show("animate__slideInLeft");
        $(".select-method").click(function(){
            $("#form-wa-send").hide("animate__slideOutLeft");
            $("#form-email-send").hide("animate__slideOutLeft");
            $("#form-metode").show("animate__slideInLeft");
        });

        $("#btn-method-wa").click(function(){ 
            if(StrWa=="-" || StrWa==""){ 
                $("#form-metode").hide("animate__slideOutLeft");
                $("#form-wa-reg").show("animate__slideInRight");
            }else{ 
                $("#form-metode").hide("animate__slideOutLeft");
                $("#form-wa-send").show("animate__slideInRight");
			    $("#label-no-wa").text(StrWa.replace(/\D/g, '').replace(/(\d\d\d?)(\d\d\d\d?)(?=\d\d)/g, '$1-$2-'));
                send_wa();
            }
        });
        $("#btn-method-email").click(function(){
            if(StrEmail=="-" || StrEmail==""){  
                $("#form-metode").hide("animate__slideOutLeft");
                $("#form-email-reg").show("animate__slideInRight");
            }else{ 
                $("#form-metode").hide("animate__slideOutLeft");
                $("#form-email-send").show("animate__slideInRight"); 
			    $("#label-email").text(StrEmail);
                send_email();
            }
        });


        var cleave1 = new Cleave('#input-wa-reg', { 
    		blocks: [3, 4, 5],
    		delimiter: ' ',
		});
		var cleave2 = new Cleave('#input-wa-code', { 
    		blocks: [3, 3],
    		delimiter: ' ',
		});
		var cleave3 = new Cleave('#input-email-code', { 
    		blocks: [3, 3],
    		delimiter: ' ',
		});


		var StrWa = "<?= $_sessionuser['MsEmpWhatsapp'] ?>"; 
		var StrEmail = "<?= $_sessionuser['MsEmpEmail'] ?>";  


        // Form Kode Verifikasi whatsapp
       
		$("#input-wa-code").keyup(function(e){
           $(this).val().length >= 7 ?  $("#btn-wa-send-submit").prop("disabled",false) : $("#btn-wa-send-submit").prop("disabled",true); 
        });
        $("#input-wa-code").keydown(function(e){
			$("#error-send-wa").text("");
			if (e.keyCode == 13) {
				if(!$("#btn-wa-send-submit").prop("disabled")) $('#btn-wa-send-submit').click();
			}
            var key = e.charCode || e.keyCode || 0; 
            return (
                key == 8 || 
                key == 9 ||
                key == 13 ||
                key == 46 ||
                key == 110 ||
                key == 190 ||
                (key >= 35 && key <= 40) ||
                (key >= 48 && key <= 57) ||
                (key >= 96 && key <= 105));
        }); 
        $("#btn-send-wa-code").click(function(){ 
            if(!$(this).hasClass("disabled"))send_wa();
        });
 
        $("#btn-wa-send-submit").click(function(){
            var code_input = $("#input-wa-code").val().replace(/ /g, "");  
			if(code_input.toString()!=codewa.toString()){
				$("#error-send-wa").text("Kode verifikasi tidak sesual");
				return false; 
			}

			$.ajax({
				method: "POST",
				url: "<?= site_url("function/client_data_master/success_employee_verify") ?>", 
				success: function(data) {
					window.location.replace("<?= base_url() ?>");
				}
			});
        })

        // Form add Verifikasi whatsapp
        $("#input-wa-reg").keyup(function(e){
           $(this).val().length >= 13 ?  $("#btn-wa-reg-submit").prop("disabled",false) : $("#btn-wa-reg-submit").prop("disabled",true); 
        });
        $("#input-wa-reg").keydown(function(e) {
			$("#error-wa-reg").text("");
			if (e.keyCode == 13) {
				if(!$("#btn-wa-reg-submit").prop("disabled")) $('#btn-wa-reg-submit').click();
			}
            var key = e.charCode || e.keyCode || 0; 
            return (
                key == 8 || 
                key == 9 ||
                key == 13 ||
                key == 46 ||
                key == 110 ||
                key == 190 ||
                (key >= 35 && key <= 40) ||
                (key >= 48 && key <= 57) ||
                (key >= 96 && key <= 105));
        }); 
        $("#btn-wa-reg-submit").click(function(){  
            $(this).html('<i class="fas fa-circle-notch fa-spin"></i> Loading');
			var str = $("#input-wa-reg").val().trim();
			if(str.charAt(0)==0){ 
				$("#error-verifikasi").text("tidak boleh ada angka 0 didepan, lanjutkan dengan angka berikutnya");
				return false;
			} 
			StrWa = $("#input-wa-reg").val().replace(/ /g, ""); 
			$.ajax({
				method: "POST",
				url: "<?= site_url("function/client_data_master/update_employee_whatsapp") ?>",
				data: {
					"MsEmpId":  "<?= $_sessionuser['MsEmpId'] ?>",
					"MsEmpWhatsapp": StrWa, 
				},
				success: function(data) {
					$("#btn-wa-reg-submit").html('Lanjutkan');   
                    $("#form-wa-reg").hide("animate__slideOutLeft");
                    $("#form-wa-send").show("animate__slideInRight");
                    $("#label-no-wa").text(StrWa.replace(/\D/g, '').replace(/(\d\d\d?)(\d\d\d\d?)(?=\d\d)/g, '$1-$2-'));
                    send_wa();  
				}
			});
        });


        // Form Kode Verifikasi Email  
		$("#input-email-code").keyup(function(e){
           $(this).val().length >= 7 ?  $("#btn-email-send-submit").prop("disabled",false) : $("#btn-email-send-submit").prop("disabled",true); 
        });
        $("#input-email-code").keydown(function(e){
			$("#error-send-email").text("");
			if (e.keyCode == 13) {
				if(!$("#btn-email-send-submit").prop("disabled")) $('#btn-email-send-submit').click();
			}
            var key = e.charCode || e.keyCode || 0; 
            return (
                key == 8 || 
                key == 9 ||
                key == 13 ||
                key == 46 ||
                key == 110 ||
                key == 190 ||
                (key >= 35 && key <= 40) ||
                (key >= 48 && key <= 57) ||
                (key >= 96 && key <= 105));
        }); 
        $("#btn-send-email-code").click(function(){ 
            if(!$(this).hasClass("disabled")) send_email();
        });
        $("#btn-email-send-submit").click(function(){
            var code_input = $("#input-email-code").val().replace(/ /g, "");  
			if(code_input.toString()!=codeemail.toString()){
				$("#error-send-email").text("Kode verifikasi tidak sesual");
				return false; 
			}

			$.ajax({
				method: "POST",
				url: "<?= site_url("function/client_data_master/success_employee_verify") ?>", 
				success: function(data) {
					window.location.replace("<?= base_url() ?>");
				}
			});
        })

        // Form add Verifikasi Email
        $("#input-email-reg").keyup(function(e){ 
            if(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g.test($(this).val())){
                console.log("email valid"); 
                $("#btn-email-reg-submit").prop("disabled",false); 
            }else{
                console.log("email invalid"); 
                $("#btn-email-reg-submit").prop("disabled",true); 
            }
        });
        $("#input-email-reg").keydown(function(e) {
			$("#error-email-reg").text("");
			if (e.keyCode == 13) {
				if(!$("#btn-email-reg-submit").prop("disabled")) $('#btn-email-reg-submit').click();
			} 
        });  
        $("#btn-email-reg-submit").click(function(){ 
           $(this).html('<i class="fas fa-circle-notch fa-spin"></i> Loading'); 
			StrEmail = $("#input-email-reg").val(); 
			$.ajax({
				method: "POST",
				url: "<?= site_url("function/client_data_master/update_employee_email") ?>",
				data: {
					"MsEmpId":  "<?= $_sessionuser['MsEmpId'] ?>",
					"MsEmpEmail": StrEmail, 
				},
				success: function(data) {
					$("#btn-email-reg-submit").html('Lanjutkan');   
                    $("#form-email-reg").hide("animate__slideOutLeft");
                    $("#form-email-send").show("animate__slideInRight");
			        $("#label-email").text(StrEmail);  
                    send_email();
				}
			});
        }) 
    </script>
    
</body>
</html>