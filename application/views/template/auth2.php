<!DOCTYPE html>
<html lang="en">

<head>
	<title>&nbsp;OBI-SYSTEM Authentication</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="shortcut icon" href="<?= base_url("asset/image/mgs-erp/logo.ico") ?>">
	<meta name="author" content="Syahrul Fauzan">
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">


	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-title" content="OBI-ERP">
	<meta name="theme-color" content="#42b549">
	<meta name="page-type" content="productdetailpage-desktop" data-rh="true">
	<meta name="title" content="Detail Transaksi" data-rh="true">
	<meta name="description" content="Menu Aplikasi OBI - ERP" data-rh="true">

	<meta name="twitter:card" content="product" data-rh="true">
	<meta name="twitter:site" content="@omahbata" data-rh="true">
	<meta name="twitter:creator" content="@omahbata" data-rh="true">
	<meta name="twitter:title" content="Aplikasi OBI-ERP" data-rh="true">
	<meta name="twitter:description" content="Menu Aplikasi OBI - ERP" data-rh="true">
	<meta name="twitter:image" href="<?= base_url("asset/image/mgs-erp/logo.png") ?>" data-rh="true">

	<link href="<?= base_url("asset/bootstrap-5.2/css/bootstrap.min.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url("asset/datepicker/daterangepicker.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url("asset/sweetalert/dist/sweetalert2.min.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url("asset/fontawesome5/css/all.min.css") ?>" rel="stylesheet" type="text/css"> 
	<link href="<?= base_url("asset/croppie/croppie.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url("asset/select2/css/select2.min.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url("asset/datatable/datatables.min.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url("asset/mainmenu.css?version=1.5") ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url("asset/sidebar.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url("asset/sales.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url("asset/dropzone/dropzone.min.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url("asset/contextmenu/jquery.contextMenu.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url("asset/signature/css/jquery.signature.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url("asset/signature/css/jquery-ui.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url("asset/date-bootstrap/css/bootstrap-datepicker.min.css") ?>" rel="stylesheet" type="text/css"> 
	<link href="<?= base_url("asset/fontgoogle/poppins.css") ?>" rel="stylesheet" type="text/css"> 
	<link href="<?= base_url("asset/fontgoogle/roboto.css") ?>" rel="stylesheet" type="text/css"> 
	<link href="<?= base_url("asset/combotree/comboTreePlugin.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url("asset/emoji/emojionearea.min.css") ?>" rel="stylesheet" type="text/css">
	 
	<script src="<?= base_url("asset/bootstrap-5.2/js/bootstrap.bundle.min.js") ?>"></script>
	<script src="<?= base_url("asset/jquery/jquery-3.6.0.min.js") ?>"></script>
	<script src="<?= base_url("asset/cleave/cleave.min.js") ?>"></script>
	<script src="<?= base_url("asset/cleave/cleave-phone.id.js") ?>"></script>
	<script src="<?= base_url("asset/jquery/jquery.validate.min.js") ?>"></script>
	<script src="<?= base_url("asset/jquery/jquery.moment.min.js") ?>"></script>
	<script src="<?= base_url("asset/sweetalert/dist/sweetalert2.all.min.js") ?>"></script>
	<script src="<?= base_url("asset/croppie/croppie.min.js") ?>"></script>
	<script src="<?= base_url("asset/datepicker/daterangepicker.js") ?>"></script>
	<script src="<?= base_url("asset/select2/js/select2.min.js") ?>"></script>
	<script src="<?= base_url("asset/datatable/datatables.min.js") ?>"></script>
	<script src="<?= base_url("asset/dropzone/dropzone.min.js") ?>"></script>
	<script src="<?= base_url("asset/copyreader.js") ?>"></script>
	<script src="<?= base_url("asset/zoom/panzoom.min.js") ?>"></script>
	<script src="<?= base_url("asset/contextmenu/jquery.contextMenu.js") ?>"></script>
	<script src="<?= base_url("asset/signature/js/jquery-ui.min.js") ?>"></script>
	<script src="<?= base_url("asset/signature/js/jquery.signature.js") ?>"></script>
	<script src="<?= base_url("asset/signature/js/jquery.ui.touch-punch.min.js") ?>"></script>
	<script src="<?= base_url("asset/jquery/jquery.redirect.js") ?>"></script>
	<script src="<?= base_url("asset/date-bootstrap/js/bootstrap-datepicker.min.js") ?>"></script>
	<script src="<?= base_url("asset/combotree/comboTreePlugin.js") ?>" type="text/javascript"></script>
	<script src="<?= base_url("asset/freezeTable.js") ?>" type="text/javascript"></script>
	<script src="<?= base_url("asset/emoji/emojionearea.min.js") ?>" type="text/javascript"></script> 
	<!-- GOOGLE JS MAPS, CHART  -->
	<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
	<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
	<script src="https://www.gstatic.com/charts/loader.js" type="text/javascript"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAW3xZvltquY2OtGjDOqwTq_KaYSo2S77w&libraries=places&language=id&region=ID" async defer></script>

	<link href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.1/viewer.min.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.1/viewer.min.js"></script>
	<!-- JS SOCKET IO -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.min.js"></script>
	<style>
		.input-group .input-group-text {
			width: auto !important;
		}
	</style>
</head>

<body class="loaded"> 
	<script type="text/javascript" src="<?= base_url("asset/jquery/detect-width.js") ?>"></script>
	<!-- HEADER -->
	<nav class="navbar navbar-expand-md navbar-light ">
		<div class="container-fluid">
			<a class="navbar-brand fw-bold">
				<img src="<?= base_url("asset/image/mgs-erp/logo.png") ?>" width="30" height="30" class="d-inline-block align-top" alt="">
				<span class="fw-bold d-none d-sm-none d-md-inline-block text-header user-select-none">OBI - Enterprice Resource Planning</span>
			</a>
			<span class="fw-bold align-middle d-sm-block d-md-none text-header user-select-none">OBI - ERP</span>
			<div class="d-flex"> 
				<div class="btn-group  hover-gray">
					<a class="btn bg-white dropdown-toggle profile" id="profile-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
						<img class="rounded-circle" src="<?= $_sessionuser['MsEmpImage'] ?>" width="40" height="40"><span class="fw-bold d-none d-sm-none d-md-inline-block">&nbsp;&nbsp;<?= $_sessionuser['MsEmpName'] ?></span>
					</a>
					<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink" data-bs-popper="none"> 
						<li><a href="<?= site_url("login/logout") ?>" class="dropdown-item">Keluar</a></li>
					</ul>
				</div>

			</div>
		</div>
	</nav>
	
	<div class="wrapper"> 
		<div id="content" class="content">
			<div class="d-flex flex-column page-load m-2 align-items-center justify-content-center" style="height:calc(100vh - 92px)"> 
				<div id="card-wa" class="card shadow" style="width: 30rem;">
					<div class="card-body p-4">
						<h5 class="card-title text-center mb-4">VERIFIKASI 2 LANGKAH</h5> 
						<p class="card-text">Saat ini anda belum memasukan nomer verikasi 2 langkah.<br>Silahkan masukan nomer <b>whatsapp</b> yang anda gunakan saat ini untuk mendapatkan <b>kode verifikasi</b>.</p> 
						<label for="input-verifikasi" class="form-label px-4">Nomer Whatsapp Aktif</label>
						<div class="input-group px-4">
							<span class="input-group-text" id="basic-addon1">+62</span>
							<input id="input-verifikasi" type="text" class="form-control" placeholder="812 3456 789" aria-label="812 3456 789" aria-describedby="basic-addon1">
						</div>
						<label id="error-verifikasi" class="form-label px-4 text-danger mb-5 "></label> 
						<div class="d-flex justify-content-between"> 
							<a href="<?= site_url("login/logout") ?>" class="btn py-1 text-danger">Keluar</a> 
							<button type="submit" class="btn btn-success py-1" id="btn-submit-auth" disabled>Simpan & Teruskan</button>
						</div>
					</div>
				</div>
				<div id="card-kode" class="card shadow" style="width: 30rem;">
					<div class="card-body p-4">
						<h5 class="card-title text-center mb-4">VERIFIKASI 2 LANGKAH</h5> 
						<p class="card-text"><b>kode verifikasi</b> 6 digit baru saja dikirimkan ke nomer whatsapp <b>+62 <span id="label-no-wa">895 3529 92663</span></b> </p> 
						<div class="d-flex justify-content-between mb-3 px-4">  
							<button id="btn-send-code" class="btn btn-link">Kirim Ulang Kode</button>
							<label id="label-time">00:00</label>
						</div>
						<label for="input-kode" class="form-label px-4">Masukan Kode Verifikasi</label> 
						<div class="input-group px-4">
							<span class="input-group-text" id="basic-addon2">OBI-</span>
							<input id="input-kode" type="text" class="form-control" placeholder="XXX XXX" aria-label="XXX XXX" aria-describedby="basic-addon2">
						</div> 
						<label id="error-kode" class="form-label px-4 text-danger mb-5 "></label> 
						<div class="d-flex justify-content-between"> 
							<a href="<?= site_url("login/logout") ?>" class="btn py-1 text-danger">Keluar</a> 
							<button type="submit" class="btn btn-success py-1" id="btn-submit-kode" disabled>Lanjutkan</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>  
	<script>
		var cleave = new Cleave('#input-verifikasi', { 
    		blocks: [3, 4, 5],
    		delimiter: ' ',
		});
		$("#input-verifikasi").keydown(function(e)
        {
			$("#error-verifikasi").text("");
			if (e.keyCode == 13) {
				if(!$("#btn-submit-auth").prop("disabled")) $('#btn-submit-auth').click();
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
		
		var cleave = new Cleave('#input-kode', { 
    		blocks: [3, 3],
    		delimiter: ' ',
		});
		$("#input-kode").keydown(function(e)
        {
			$("#error-kode").text("");
			if (e.keyCode == 13) {
				if(!$("#btn-submit-kode").prop("disabled")) $('#btn-submit-kode').click();
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
		var code = "290912";
		send_wa = function(){
			$("#btn-send-code").prop("disabled",true);
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
					code = data["SysVerifikasiCode"];
					var x = setInterval(function() { 
						var now = new moment();
						var distance = endtime.diff(now, 'seconds') + 1;     
						var seconds = Math.floor((distance % 60));
						var minutes = Math.floor(distance / 60); 

						seconds = (seconds.toString().length == 1 ? "0" + seconds: seconds);
						minutes = (minutes.toString().length == 1 ? "0" + minutes: minutes); 
						$("#label-time").text(minutes + ":" + seconds);
						if (distance < 1) {
							$("#btn-send-code").prop("disabled",false);
							clearInterval(x); 
						}
					}, 1000);
				}
			});
		} 
		
		var no_wa = "<?= $_sessionuser['MsEmpWhatsapp'] ?>";
		if(no_wa === ""){ 
			$("#card-kode").addClass("d-none");
			$("#card-wa").removeClass("d-none");
		}else{ 
			$("#card-wa").addClass("d-none"); 
			$("#card-kode").removeClass("d-none");
			$("#label-no-wa").text(no_wa.replace(/\D/g, '').replace(/(\d\d\d?)(\d\d\d\d?)(?=\d\d)/g, '$1-$2-'));
			send_wa();
		}

		/** mode simpan nomer whatsapp */ 
		window.onload = () => {
			const myInput = document.getElementById('input-verifikasi');
			myInput.onpaste = e => e.preventDefault();
		}
		$("#input-verifikasi").keyup(function(e)
        {
           $(this).val().length >= 12 ?  $("#btn-submit-auth").prop("disabled",false) : $("#btn-submit-auth").prop("disabled",true);
		   
        });
		$("#btn-submit-auth").click(function(){ 
			$(this).html('<i class="fas fa-circle-notch fa-spin"></i> Loading');
			var str = $("#input-verifikasi").val().trim();
			if(str.charAt(0)==0){ 
				$("#error-verifikasi").text("tidak boleh ada angka 0 didepan, lanjutkan dengan angka berikutnya");
				return false;
			} 
			no_wa = $("#input-verifikasi").val().replace(/ /g, ""); 
			$.ajax({
				method: "POST",
				url: "<?= site_url("function/client_data_master/update_employee_whatsapp") ?>",
				data: {
					"MsEmpId":  "<?= $_sessionuser['MsEmpId'] ?>",
					"MsEmpWhatsapp": no_wa, 
				},
				success: function(data) {
					$("#btn-submit-auth").html('Simpan & Teruskan');  
					if(data){
						$("#card-wa").addClass("d-none"); 
						$("#card-kode").removeClass("d-none");
						$("#label-no-wa").text(no_wa.replace(/\D/g, '').replace(/(\d\d\d?)(\d\d\d\d?)(?=\d\d)/g, '$1-$2-'));
						send_wa();
					}else{
						$("#error-verifikasi").text("update ke database gagal");
					}
				}
			});
		});
		 
		/** mode kirim kode verifikasi */ 
		$("#btn-send-code").click(function(){
			send_wa();
		})
		$("#input-kode").keyup(function(e)
        {
           $(this).val().length >= 7 ?  $("#btn-submit-kode").prop("disabled",false) : $("#btn-submit-kode").prop("disabled",true); 
        });
		$("#btn-submit-kode").click(function(){
			var code_input = $("#input-kode").val().replace(/ /g, ""); 
			console.log(code_input);
			console.log(code);
			if(code_input.toString()!=code.toString()){
				$("#error-kode").text("Kode verifikasi tidak sesual");
				return false; 
			}

			$.ajax({
				method: "POST",
				url: "<?= site_url("function/client_data_master/success_employee_whatsapp") ?>", 
				success: function(data) {
					window.location.replace("<?= base_url() ?>");
				}
			});
		});
	</script>
</body>

</html>
